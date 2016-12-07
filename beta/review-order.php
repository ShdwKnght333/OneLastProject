<?php
include "conf/config.php";
// Login Required to Proceed
if (!(isset($_SESSION['memberid'])&& $_SESSION['memberid']) ) {
header("Location: ".SITEURL."your-details.php");
exit;
}
if (isset($_REQUEST['cmd']) && $_REQUEST['cmd']=="set_DeliveryType") {
	if(isset($_REQUEST['val'])){	
	$_SESSION['deliveryType']=safe($_REQUEST['val']);
	}	
	exit;
}
if (isset($_REQUEST['cmd']) && $_REQUEST['cmd']=="set_OrderNote") {
	if(isset($_REQUEST['val'])){
    if($_REQUEST['val'] !="")		
	$_SESSION['orderNote']=safe($_REQUEST['val']);
	}	
	exit;
}
// Prevent Malicious XSS Attack on Form 
generateFormToken('FZform');

$rest_id=getWhere("cart","rest_id","session_id='".session_id()."'"); 
// change this to SITEURL later
 if (!$rest_id) {
	header("Location: ".SITEURL."index.php");
	exit;
}	
$rsr=getSqlRow("SELECT * FROM rests WHERE id=".$rest_id."");
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Review Order</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    
	<?php include "inc/styles.php"; ?>
	<link rel="stylesheet" href="css/checkout.css">
</head>
<body>
<?php include "inc/header-abs.php"; ?>

<!----------------------------------------------------header ends----------------------------->
		<section>
			<nav>
				<ol class="cd-multi-steps text-bottom count">
					<li class="visited"><a>Login</a></li>
					<li class="current"><a>Review</a></li>
					<li><em>Payment</em></li>
				</ol>
			</nav>
		</section><br> <!-- /.pageTitle -->
	<div class="review_contain">
	<div class="container">
		<div class="col-md-7 cf" style="padding:0 8px 10px;">
			<div class="review_header">
			<h3>How would you like your food</h3>
			</div>
			<div class="review_wrapper">
			<form name="placeOrder" id="placeOrder" action="javascript:void(0);" method="POST">
			 <input type="hidden" name="cmd" id="cmd" value="place_order_<?php echo $_SESSION['FZform_token'];?>" />
				<div class="user_choice cf">
					  <ul>
						  <li>
							<div class="first_child">
							<input type="radio" id="f-option" name="deliveryType" value="Delivery" onchange="setDeliveryType(this.value);">							
							<div class="del_user_info">
								<label for="f-option">Delivery <br><span>Food will be delivered to your address by <?php $est_time = $rsr['servicetime'] + 5; $est_time = "+" . $est_time . " minutes"; echo date("g:i A", strtotime($est_time)); ?></span></label>
							</div>
							<div class="check"></div>
							</div>							
						  </li>
						  
						  <li>
							<div class="first_child">
							<input type="radio" id="s-option" name="deliveryType" value="Dine-In" onchange="setDeliveryType(this.value);">							
							<div class="del_user_info">
								<label for="s-option">Dine In<br><span>Eat your food in the restaurant itself </span></label>
							</div>
							<div class="check"></div>
							</div>							
						  </li>
						  
						  <li>
							<div class="first_child">
							<input type="radio" id="t-option" name="deliveryType" value="Take-Away" onchange="setDeliveryType(this.value);">							
							<div class="del_user_info">
								<label for="t-option">Take Away<br><span>Take away your food from the restaurant</span></label>
							</div>
							<div class="check"></div>
							</div>							
						  </li>
						</ul>					
				</div><br>
				
				<div class="review_note">
				<h3>Order Note</h3>
				<textarea id="orderNote" placeholder="your order note(if any)" rows="4" cols="50" maxlength="200" style="width:100%" ></textarea>
			</div>
			</form><!--Place_order_Form-->
			</div><!--review_wrapper-->
            </div>
        
		<div class="col-md-5 cf" style="padding:0 8px;">
		<div class="review_wrapperR">
		<div class="desktop-cart-container" style="background:#fff";>
            <div class="desktop-cart__header">
            <h3 class="desktop-cart__title">Your order</h3>
			<a href="restaurants-menu.php?r=<?php echo $rest_id; ?>"><h4 class="desktop-cart__tiltle_update">Edit</h4></a>
             </div>
        <!-- Virtual Cart Before Placing the Order -->
              <?php include "conf/virtualCart1.php"; ?>
			  	<!-- PROCEED TO CHECK OUT -->
		<div class="desktop-cart__order__checkout_button_container">
			<?php
				$rest_isopen = getSqlNumber("SELECT id FROM rests where id=".$rest_id." and status=1");
				$rsoc=getSqlRow("select * from site_timing where resid=".$rest_id." and dateday=".date('w')."");
			if ($rest_isopen && checkRestHour($rsoc['open1'],$rsoc['close1'],$rsoc['open2'],$rsoc['close2'],$rsoc['open3'],$rsoc['close3'])) {
			?>
			<?php if ($ctotal >= $cr['min']) { ?>
		  <div class="desktop-cart__order__checkout_button_container">
			<?php 
			$rest_isopen = getSqlNumber("SELECT id FROM rests where id=".$rest_id." and status=1");
			$rsoc=getSqlRow("select * from site_timing where resid=".$rest_id." and dateday=".date('w')."");
			if ($rest_isopen && checkRestHour($rsoc['open1'],$rsoc['close1'],$rsoc['open2'],$rsoc['close2'],$rsoc['open3'],$rsoc['close3'])) {
            ?>
			<input name="sbt" id="sbt" class="vmenu" style="width:100%;background-color: #ff554e;color: #fff;" type="submit"  value="PLACE YOUR ORDER " onclick='this.disabled=true; post("placeOrder"); return false;'  /></span>
			<?php  } else { ?>
			<font color="red" style="padding-top:10px;"><b>SERVICE PROVIDER CLOSED NOW</b><br/>We are unable to process your order.</font>
			<?php  } ?>
  <span class="desktop-cart__error__below-minimum-amount form__error-message hide">You need to add more items to be able to checkout</span></div>
		  
			<?php $_SESSION['cart_approve'] = "2"; ?>
			<?php } else { ?>
			<button class="button--disabled button--full-width">
			<span>Minimum Order is <?php echo setPrice($cr['min']);?></span></button>
			<?php $_SESSION['cart_approve'] = "1"; ?>
			<?php  } ?>
		<?php  } else { ?>
		<button class="button--disabled button--full-width">
		<span><?php echo $GLOBALS['rest_closed_msg']; ?></span></button>
		<?php  } ?>
		</div>
            </div>
        </div>
   
  
</div>
        </div>
    </div>
</div>
	</div>
	</div>
	<div id="result"> </div>
	</div><br> <!-- /.container -->

<!--Footer-------------------------------------------------------------------------------------->
	<?php include "inc/footer-checkout.php"; ?>

	<!-- Scripts -->
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
   	<script src="js/b2tmain.js"></script><!--back-to-top-->
	<script>
function setDeliveryType(val) {
		if(val !='Delivery' )
	{
		$(".desktop-cart__order__delivery").hide();
	}	
	else
	{
		$(".desktop-cart__order__delivery").show();
	}
	$.post("<?php echo $_SERVER['PHP_SELF'];?>", { cmd: "set_DeliveryType", val: val }, 
            function(data) {
			$("#result").html(data);
	});
	return false;
}
var oldNote = "";
$("#orderNote").on("change keyup paste", function() {
    var currentVal = $(this).val();
    if(currentVal == oldNote) {
        return; //check to prevent multiple simultaneous triggers
    }   
	oldNote= currentVal;
	$.post("<?php echo $_SERVER['PHP_SELF'];?>", { cmd: "set_OrderNote", val: oldNote}, 
            function(data) {
			$("#result").html(data);
	});
});
	</script>
	<!-- Auth script -->
<script>
function post(form) {
	var form=$('#'+form).serialize();
	$.ajax({
		type: 'POST',
		url: 'conf/post.php',
		data: form,
		success: function(result) {
			$('#result').html(result);
			$('#sbt').prop('disabled', false);
		}
	});
	return false;
}
	</script>
<!-- Auth Script Ends -->	
</body>
</html>