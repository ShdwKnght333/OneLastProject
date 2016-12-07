<?php
include "conf/config.php";
include "coupon.php";
// Login Required to Proceed
if (!(isset($_SESSION['memberid'])&& $_SESSION['memberid']) ) {
header("Location: ".SITEURL."your-details.php");
exit;
}
if(isset($_REQUEST['oid']) && isset($_REQUEST['token'])&& $_REQUEST['oid'] && $_REQUEST['token']){
	
	$order_id=$_REQUEST['oid'];
	$token = $_REQUEST['token'];

	generateFormToken('FZform');
	generateFzWalletToken();
	generatePayUmoneyToken();
	generateCODToken();
	
	$order = getsqlrow("SELECT * FROM orders WHERE id='".$order_id."' AND userid='".$_SESSION['memberid']."'");

if ( !$_REQUEST['oid'] == "0" && $order_id == $order['id'] && $token == md5($order['id']) && $order['payment_status'] == "0" )
{
		$_SESSION['order_id']=$order_id;
		$rsr=getSqlRow("SELECT * FROM rests WHERE id=".$order['resid']."");	
		$ouser = getsqlrow( "select email from users where id='".$_SESSION['memberid']."'");

if($order['order_type'] != 'Delivery')
{	
		$rest_info = getsqlrow("SELECT name,address,rcity,zip FROM rests WHERE id='".$order['resid']."'");
	
}
$discount=$order['fzDiscount'];
$cost=$order['sub_total'];
$output='';
if(isset($_POST['submitcoupon'])){
	$coupon=strtoupper($_POST['coupon']);
	$discount=validVoucher($_POST['coupon'],$cost,$order_id,$order['fzDiscount'],$order['city'],$order['userid'],$output);   
//	echo $output;
	$result = mysql_query("select totalVouchers from coupon where voucherCode='".$coupon."' ");
	while ($r = mysql_fetch_array($result)) {
		$totalVouchers = $r['totalVouchers'];
	}
	if($totalVouchers == 0)
		$output="This coupon has been already completed its LIMITS";
	else
	{
		$totalVouchers=($totalVouchers-1);
		$_SESSION["totalVouchers"] = intval($totalVouchers);
		$_SESSION["couponCode"] = $coupon;
		$output='Coupon has been Applied !';
	}	
}
//Get Subtotal and Total
if($discount >= $order['sub_total'])
	{	
		$order['sub_total']=0; 
		$discount=0;
	    $optotal=$order['sub_total'] +  $order['tax_total'];
		$op_tax = ( $optotal / 100 ) * $fz_con_fee;
		$optotal = $optotal + $op_tax;
      }
	  else
	  {
		$optotal=$order['order_total']-$discount;
		$op_tax = ( $optotal / 100 ) * $fz_con_fee;
		$optotal = $optotal + $op_tax;
	  }
}
// change this to SITEURL later
/* if (!$rest_id) {
	header("Location:".SITEURL."index.php");
	exit;
}	
*/
}

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Payment </title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    
	<?php include "inc/styles.php"; ?>
	<link rel="stylesheet" href="css/checkout.css">
		<style>
 .input-text{
	background-color: #f9f9f9;
	 width:300px !important;
    width: 80%;
    padding: 5px;
    font-size: 16px;
    line-height: 1;
    border: 1px solid #cecece;
    border-radius: 3px;
    height: 34px;
    -webkit-appearance: none;
    margin-bottom: 10px;
}
@media(max-width:360px){
	h3 {
		font-size:initial;
	}
	.balance {
		font-size:small;
	}
}
@media(max-width:420px){
	.input-text {
		width:80% !important;
	}
}

</style>
</head>
<body>
<?php include "inc/header-abs.php"; ?>
<?php include "inc/totalbreakup.php"; ?>

<!----------------------------------------------------header ends----------------------------->
		<section>
			<nav>
				<ol class="cd-multi-steps text-bottom count">
					<li class="visited"><a>Login</a></li>
					<li class="visited"><a>Review</a></li>
					<li class="visited"><a>Payment</a></li>
				</ol>
			</nav>
		</section><br> <!-- /.pageTitle -->
<div class="payment_contain">
	<div class="container">
		<div class="col-md-8 cf" style="padding:0 8px 20px;">
			<div class="add_header">
			<?php if($order['order_type'] == 'Delivery'){ ?>
								<h3>Delivery Address</h3>
			<?php }else { ?>
							<h3>Restaurant Address</h3>
			<?php } ?>				
						</div>
			<div class="payment_wrapper">	
					<form name="confirmOrder" id="confirmOrder" action="javascript:void(0);" method="POST">
						<input type="hidden" name="cmd" id="cmd" value="confirm_order_<?php echo $_SESSION['FZform_token']?>" />
				        <div class="payment-form cf">
							<div class="widget-inner">
						<?php if($order['order_type'] == 'Delivery'){ ?>	
                                <div class="col-md-8">
								<div class="row">
								<select name="address_id" id="address_id" class="input-text" style="margin:0px 0px 10px 20px;" onchange="setAddress(this.value);">
								<option value=""><?php echo $GLOBALS['new_address']; ?></option>								
								<?php
								$getRss= mysql_query("SELECT * FROM delivery_addresses where userid=".$_SESSION['memberid']." order by nick asc");
								while ($rss = mysql_fetch_array($getRss)) {
									?>
									<option value="<?php echo $rss['id']?>"><?php echo $rss['nick'];?></option>
								<? } ?>
							  </select>
                                   <!-- <div class="col-md-12">
                                        <p>
                                            <label for="name">Address</label>
                                            <input type="text" name="name" id="name" maxlength="50" required>
                                        </p>
                                    </div> -->
                                    <div class="col-md-12">
                                        <p>
                                            <label for="nick">Nickname</label><br/>
														<input type="text" name="nick" id="nick" value="" placeholder="Used to Save Address"  class="input-text"  maxlength="100"  />
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            <label for="name">Name</label><br/>
                                             <input type="text" name="name" id="name" placeholder="Enter your Name" value=""  maxlength="100" class="input-text" />
												</p>	 
                                    </div>
									<div class="col-md-12">
                                        <p>
                                            <label for="mobilphone">Mobile</label><br/>
                                             <input type="number" name="mobilphone" id="mobilphone" placeholder="10 Digit Mobile Number" value=""  class="input-text" maxlength="50" />
										</p>
									</div>
									<div class="col-md-12">
                                        <p>
                                            <label for="address">Address</label><br/>
														<input type="text" name="address" id="address" value="" placeholder="Door no. / Building / Street / Landmark"  class="input-text" maxlength="100" />
										</p>	
									</div>
									<div class="col-md-12">
									<?php $query_p = mysql_query("SELECT * FROM delivery_areas WHERE region='".$order['city']."' order by city asc"); ?>
                                        <p>
                                            <label for="area">Area</label><br/>
                                              <select class="input-text" type="text" name="area" id="area" > 
														<option value="0">--- Select Area ---</option>
														<?php  while($row = mysql_fetch_array($query_p)){ ?>
														<?php $totalResults = getSqlNumber("SELECT da_id FROM rest_delivery_area where da_id='".$row['id']."' and rest_id='".$order['resid']." '");
															if ($totalResults) {  ?>
																<?php if ( $_SESSION['myarea'] == $row['city'] ) { ?>
																<option value="<?php echo $row['id'];?>"<?php if ( $_SESSION['myarea'] == $row['city'] ) { echo " selected";   } ?>><?php echo $row['city'];?></option>
																<?php  } ?>
														<? } ?>
														<?php }?>
														</select>
										</p>
                                    </div>
				
								</div>
								
                                <!--<div class="row">
                                    <div class="col-md-12">
                                        <button class="mainBtn" id="submit">Send Message</button>
                                    </div>
                                </div>-->
								</div>
							<?php }else {?> 
							  <div class="col-md-8">
								<div class="row">
								<label><h3><b>Pick up your Favourite Food from<b></h3></label>
								</div>
								<div class="row">
								<label><b><?php echo $rest_info['name']; ?></b></label></br>
								<label><b><?php echo $rest_info['address'];  ?></b></label></br>
								<label><b><?php echo $rest_info['rcity']; ?> &nbsp; <?php echo $rest_info['zip']; ?></b></label></br>
								</div>
								</div>
							 <?php }?>
							 </div> <!-- /.widget-inner -->
							
                         </div> <!-- /.payment cf form -->
						<div class="payment_header">
								<h3>Payment Method</h3>
						</div>
						
						<div class="last_radio">
							<div class="cd-filter-block">
								<ul class="cd-filter-content cd-filters list">
								<li>
											<input id="payU" name="PaymentType" class="filter" type="radio" value="<?php echo $_SESSION['PayUmoney_token'];?>"  onchange="setPaymentType(this.id,this.name,this.value)">
											<label class="radio-label" for="payU">PayUmoney <img src="images/online.png"></label>
										</li>
								
								<div id="line"></div>
								<li>
									<input id="COD" name="PaymentType" class="filter" type="radio"  value="<?php echo $_SESSION['COD_token'];?>" onchange="setPaymentType(this.id,this.name,this.value);">
									<label class="radio-label" for="COD">Cash On Delivery <img src="images/cod.png"></label>
								</li>
								<div id="line"></div>
								<li>
									<input id="FzWallet" name="PaymentType" class="filter" type="radio"  value="<?php echo $_SESSION['FzWallet_token'];?>" id="radio3" onchange="setPaymentType(this.id,this.name,this.value);">
									<label class="radio-label" for="FzWallet">Fz Wallet <img src="images/wallet.png"> <span class="balance" style='float:right'>Balance ₹<?php echo getWalletBalance(); ?></span></label>
								</li>
								<div id="linet"></div>
							</ul> <!-- cd-filter-content -->
						</div> <!-- cd-filter-block -->
					</div>
					</form><!-- PAYMENT FORM -->
						<div class="coupon_check">
							<div class="coupon_header">
								<p> Coupon Code(if any) <span class="servicedrop fa fa-chevron-right" style="font-size:13px;"></span></p>
							</div>
							<div id="coupon_body">
							<form name="couponform" method="post" action="<?php echo "check-payment.php?oid=".$order_id."&token=".$token." "; ?>" >
							<input type="hidden" name="oid" id="order_id" value="<? echo $order_id; ?>" readonly="true" />
							<input type="hidden" name="token" id="token" value="<? echo $token ; ?>" readonly="true" />
							<input type="text" name="coupon" placeholder="Enter Coupon Code" value="" ><input type="submit" name="submitcoupon"   value="APPLY"  form="couponform" class="buttoncoupon buttoncoupon">
							</form>
							<div><br><?php echo $output; ?> </div>
							</div>
						</div> 
			
						<div class="payment_header_total">
								<h3>Amount Payable <span style="float:right;"><span id="amountPayable"><?php echo  " ₹ ".$order['order_total']; ?></span></span></h3>
								<div class="dropdown_fee" style="float:right;">
									  <span data-toggle="modal" id="<?php echo $order_id; ?>" data-target="#edit-modal">Total Breakup </span>	
									</div> 
						</div>
						<div class="final_order">
						<div class="cd-filter-block">
							<ul class="list">
									<li>
										<input type="checkbox" id="checkbox_final" required>
										<label class="checkbox-label" for="checkbox_final">I agree to the <a href="terms.php">Terms of Use</a> and <a href="privacy.php">Privacy Policy</a>.</label>
									</li>
								</ul>
						</div>		
							<div class="final_button">
								<button type="submit" class="buttonwallet buttoncheckout" id="final_checkout_btn" onclick='this.disabled=true;post("confirmOrder"); return false;' >Order Now</button>
							</div>
						</div>
            </div> <!-- /.payment-form -->
													
            </div>
      		<div class="col-md-4 cf" style="padding:0 8px;">
			<div class="payment_wrapperR">
				<div class="desktop-cart-container " style="background:#fff;">
            <div class="desktop-cart__header">
            <h4 class="desktop-cart__title">Your order</h4>
                    </div>
      <!-- Virtual Cart After Placing the Order -->
              <?php include "conf/virtualCart2.php"; ?>
    </div>
</div>
           </div>
    </div>
				
			</div>
		</div>
    </div> <!-- /.container -->
	</div>
<div id="result"></div>
<!--Footer-------------------------------------------------------------------------------------->
	<?php include "inc/footer-checkout.php"; ?>


	<!-- Scripts -->
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
   	<script src="js/b2tmain.js"></script><!--back-to-top-->
	<script>
    $(".coupon_header").click(function(){
        $("#coupon_body").slideToggle("slow");
		$(this).find('.servicedrop').toggleClass('fa-chevron-down fa-chevron-right');	
	});
function setAddress(id) {
	$("#span_address_loading").show();
	$("#result").load("conf/post.php?cmd=set_address&id="+id);
}
function setPaymentType(id,name,val){
		$.post("calc_confee.php", { cmd: "set_PaymentType", id: id , name:name,val:val }, 
            function(data) {
			$("#amountPayable").html(data);
	});
	return false;
}
</script>
<script>
function post(form) {
	var form=$('#'+form).serialize();
	$.ajax({
		type: 'POST',
		url: 'conf/post.php',
		data: form,
		success: function(result) {
			$('#result').html(result);
			$('#final_checkout_btn').prop('disabled', false);
		}
	});
	return false;
}
</script>
<script>
	$(document).keyup(function(n){"27"==n.which&&$("#id01").hide()}),window.onclick=function(n){n.target==modal&&(modal.style.display="none")};
</script>
<script>
        $('#edit-modal').on('show.bs.modal', function(e) {    
            var $modal = $(this),
                extraId = e.relatedTarget.id;    
				$.ajax({
				cache: false,
				type: 'POST',
				url: 'showTotalbreakup.php',
					data: 'egid='+extraId,
					success: function(data) 
					{
                    $modal.find('.edit-content').html(data);
						}
				});
            
        })
    </script>
</body>
</html>