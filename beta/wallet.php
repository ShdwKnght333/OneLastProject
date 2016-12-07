<?php
include "conf/config.php";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Wallet</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    
	<?php include "inc/styles.php"; ?>
    <link type="text/css" rel="stylesheet" href="css/anireset.css" />
	<style>
	#walletfaq a{
		color:#d61f26;
	}
	</style>
</head>
<body>
<?php include "inc/login.php"; ?>
<?php include "inc/header.php"; ?>

<!----------------------------------------------------header ends----------------------------->
	<div class="first-widget parallax" id="walletbg">
		<div class="parallax-overlay">
			<div class="container pageTitle">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2 class="page-title">Fz Wallet</h2>
					</div> <!-- /.col-md-6 -->
					</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.parallax-overlay -->
	</div><br> <!-- /.pageTitle -->

	<div class="container">	
		<div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;">
        	<div class="col-md-12">
            	<div class="fzwallet">
                	<div class="wallethead">
                    	<h4 style="color:#fff;margin:5px;font-weight:600;">Fz Wallet</h4>
                    </div>
                    <div class="yourwallet cf">
                    	<ul>
                        	<li>
                            	<img src="images/wallet24.png" style="margin-bottom: 10px;">
									<?php 
									if (isset($_SESSION['memberid'])&& $_SESSION['memberid']) {
											$balance=getWalletBalance();
									?><span class="value">Rs <?php echo $balance; ?></span>
									<?php  }else  { ?>
										<span class="value">Rs 0</span>
									<?php }?>
                                <span class="text">Your wallet balance</span>
                            </li>
						<form id="addmoney" name="addmoney" method="post" action="wallet_pay.php">							
								 <li class="colo"> 
                            <md-input-container >
								<span class="amount-box" >
                               <input type="number" min="1" style="width:190px;margin-left:-50px" class="md-input"  name="amount" value="" maxlength="7" autocomplete="off"  max="1000000" placeholder="Enter Your Amount">
								</span>
							</md-input-container>
                            </li>
							<!-- promo code needs to be Changed --> 
                           <!-- <li class="add-promo-code">
                            	<md-input-container >
								<span class="promo-box" >
                                  <input class="md-input" name="promocode" value="" maxlength="6" autocomplete="off" placeholder="Enter Promocode(if any)">
                            </span>
							</md-input-container>
                            </li> -->
								<li class="colo1">			
									<input type="hidden" name="make_payment" id="order_id" value="1" readonly />
									<button name="payU" id="payU" type="submit" class="buttonwallet buttonus" form="addmoney" style="margin-left:-40px">Add Money</button></td></tr>						
								</li>	
						</form>								
                        </ul>                        
                    </div>
                  </div>
            </div>
        </div>
        </div><br>
		<div class="container">	
		<div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;">
        	<div class="col-md-12">
				<div class="wallethead">
            	<h4 style="color:#fff;margin:5px;font-weight:600;">Fz Passbook</h4>
				</div>
				<!-- <p style="padding-top:40px">Please <a href="#modal" id="mmodal_trigger">Login</a> to see all your FZ wallet transactions.</p> -->
				<?php 
				if (isset($_SESSION['memberid'])&& $_SESSION['memberid']) {
						?>
				<p style="padding-top:40px;border-bottom:2px solid #ff554e;width:150px;">Transaction History </p>
				<div class="wallettb">
			<table>
				 <?php  
					 $user_id=$_SESSION['memberid'];
					 $query = mysql_query("SELECT * FROM wallet WHERE userid='".$user_id."' order by w_id DESC");
					 if(mysql_num_rows($query) > 0 ){
					 echo "<thead><tr>";
				     echo "<td width='45%' style='text-align:left;padding-left: 10px;'>Wallet Description</td><td width='12.5%'>Deposit</td><td width='12.5%'>Withdrawal</td><td width='30%'>Status</td>";
					 echo "</tr></thead><tbody>";
					 while($row=mysql_fetch_array($query))
					 { 
								echo "<tr>";	
								if($row['id'] != 0 ){	
								    echo	"<td style='text-align:left'>";
									echo "<div style='display:table-cell'>";
									echo "<img src='images/fz.png' width='50px' height='50px' style='display:table-cell;float:left; margin-top:10px;margin-right:10px;border: 1px solid #ececec;border-radius: 6px' >";
									echo "<ul>";
									echo "<li>Paid to Order</li>";
									if($row['payment_status'] == 1 ){
									echo "<li>Order Id: #".$row['id']."</li>";
										}
									else if($row['payment_status'] == 0){
										echo "<li>Ref No : #".$row['w_id']."</li>";
									}
									echo "<li>".$row['date']."</li>";
									echo "</ul></div></td>";
									if($row['credit']==0){ 
									echo "<td> </td>";
									}
									if($row['debit'] !=0) {
									echo 	"<td>".$row['debit']."</td>";
									}
									if($row['payment_status']==1) {
										echo "<td>Success </td>";
									}
									else 
									{
										 echo "<td>Pending <span class='tooltip'>Help<span class='tooltiptext'>FzWallet - <a href='walletfaq.php'>FAQ</a> </span></span></td>";
									}
								}
								else {
									echo	"<td style='text-align:left'>";
									echo "<div style='display:table-cell'>";
									echo "<img src='images/cash1.png' width='50px' height='50px' style='display:table-cell;float:left; margin-top:10px;margin-right:10px;border: 1px solid #ececec;border-radius: 6px' >";
									echo "<ul>";
									echo "<li>Cash Added</li>";
									if($row['payment_status'] == 1 ){
									echo "<li>Tracking Id: #".$row['tracking_id']."</li>";
									}
									else if($row['payment_status'] == 0){
										echo "<li>Ref No : # ".$row['w_id']."</li>";
									}
									echo "<li>".$row['date']."</li>";
									echo "</ul></div></td>";
									if($row['credit']!=0){ 
									echo 	"<td>".$row['credit']."</td>";
									}
									if($row['debit'] ==0) {
									echo 	"<td> </td>";
									}
									if($row['payment_status']==1) {
										echo "<td>Success </td>";
									}
									else 
									{
										 echo "<td>Pending <span class='tooltip'>?<span class='tooltiptext'>FzWallet - <a href='walletfaq.php'>FAQ</a> </span></span></td>";
									}
								}	
						   
						echo "</tr>";
					 }
					 echo "</tbody>";
				}
				else 
				{
					echo "<p class='transaction-box' style='margin-top:0px;'> You haven't done any Transactions yet ! </p>";	
				}	
					 ?>	
				</table>	
				<?php 
				} else {
					echo "<p class='transaction-box'> Please"; ?>
						<strong><a style="text-decoration:none;cursor:pointer" role="button"  onclick="document.getElementById('id01').style.display='block'">Login/Signup</a></strong>
					<?php echo " to see all your FzWallet transactions.</p>";	
				}
				?>
				<div style="text-align:right;font-size:13px;padding-bottom: 10px;padding-top:10px" id="walletfaq">
				<span><a href="walletfaq.php">FAQ's</a> and <a href="walletterms.php">Terms And Conditions</a></span>
				</div>
				</div>
			</div>
        </div>
        </div><br>
		<div class="container">	
		<div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;">
            	<div class="col-md-12 col-sm-12 col-xs-12 ctaoffer cf">
									<div class="contact_row col-md-3 col-sm-6 col-xs-6">
									<img src="images/walletwoneclick.png" style="margin-top:16px;">
									<p><strong>One Click Payment</strong></p>
									</div>
									
									<div class="contact_row col-md-3 col-sm-6 col-xs-6">
									<img src="images/walletwrefund.png" style="margin-top:16px;">
									<p><strong>Instant Refund</strong></p>
									</div>
									
									<div class="contact_row col-md-3 col-sm-6 col-xs-6">
									<img src="images/walletwsec.png" style="margin-top:16px;">
									<p><strong>Secure Payment</strong></p>
									</div>
									
									<div class="contact_row col-md-3 col-sm-6 col-xs-6">
									<img src="images/walletwquick.png" style="margin-top:16px;">
									<p><strong>Quicker than other Wallets</strong></p>
									</div>
				</div>
        </div>
        </div><br>
        <!--<div class="container">	
		<div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;">
        	<div class="col-md-12">
            	<p style="margin:10px 0;">Cashback is 'Foodzoned wallet loyalty cashback' given by 'Pay with Fzwallet' payment platform. It can be used to pay for your food at checkout.</p>
            </div>
        </div>
        </div><br>-->
              
<!--Footer-------------------------------------------------------------------------------------->
	<?php include "inc/footer.php"; ?>


	<!-- Scripts -->
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
    <script src="js/jslog/lpginpop.js"></script>  <!--login-->
   	<script src="js/b2tmain.js"></script><!--back-to-top-->
<!-- Auth script -->
	<script>
function post(form) {
	var form=$('#'+form).serialize();
	$.ajax({
		type: 'POST',
		url: 'conf/post.php',
		data: form,
		success: function(result) {
			$('.btn').prop('disabled', false);
			$('#result').html(result);
		}
	});
	return false;
}
	</script>
	 <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>
      FB.init({appId: '<?php echo FACEBOOK_APP_ID ?>', status: true, cookie: true, xfbml: true});
      FB.Event.subscribe('auth.login', function(response) {
        window.location.reload();
      });
    </script>
<!-- Auth Script Ends -->	
</body>
</html>