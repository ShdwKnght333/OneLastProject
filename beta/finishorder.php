<?php
include "conf/config.php";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Your Order</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    
	<?php include "inc/styles.php"; ?>
	<link rel="stylesheet" href="css/checkout.css">
</head>
<body>
<?php include "inc/header.php"; ?>
<!----------------------------------------------------header ends----------------------------->
	<div class="container" id="topfinish">
		<div class="col-md-9 cf" style="padding:20px 0px;">
			<div class="finishorder center cf"style="box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px; background:#fff;padding-bottom:20px;padding-top:20px;">
				<div class="order_recieved"style="border-bottom:1px solid #ececec;padding:0 15px;">
						<?php  if( isset($_REQUEST['paid'])&&  $_REQUEST['paid']=='true' && isset($_REQUEST['order_id'])&&  $_REQUEST['order_id']!="" ) { ?>
						<span class="fa fa-check-square-o fa-3x" style="color:#d61f26;"></span>
						<h2 style="font-weight:bold">Your Order has been received</h2>
						<p>Your order id is <strong><?php echo $_REQUEST['order_id']; ?></strong></p>	
						<p>Go to <strong><a href="orders.php">My Orders Page</a></strong></p>	
						<?php } else { ?>
						<span class="fa fa-uncheck-square-o fa-3x" style="color:#d61f26;"></span>
						<h2 style="font-weight:bold">We couldn't process your Order</h2>
						<p>Please <strong>contact us</strong> using the reference below</p>	
						<?php }?>
				</div>
					<div class="col-md-12 cf">
									<div class="contact_row col-md-4 col-sm-6">
									<h3>CUSTOMER CARE</h3>
									<p><a href="mailto:care@foodzoned.com">care@foodzoned.com</a><br>(10AM-11PM)</p>
									</div>
									
									<div class="contact_row col-md-4 col-sm-6">
									<h3>HELPLINE</h3>
									<p>+91-9035-515-321<br>(10AM-11PM)</p>
									</div>
									
									<div class="contact_row col-md-4 col-sm-6">
									<h3>SELLER SUPPORT</h3>
									<p><a href="mailto:support@foodzoned.com">support@foodzoned.com</a><br>(10AM-11PM)</p>
									</div>
								</div> <!-- /.col-md-12 -->
								
								<div class="col-md-12 cf">
								<div class="row" id="color_height">
								<div class="app">
								<div class="appbanner">
									<div class="appbannerphone">
										<img src="images/includes/android1.png" alt="fzapp">
									</div>
									<div class="appwrapinfo">
										<div class="appbannerdownload">
											<header class="appbannerdownloadhead">
												<p class="headst">Foodzoned App</p>
												<p class="titlest">Order Online and On The Go</p>
											</header>
											<span class="appbannerinfo">Download the app for free, and order takeaway online, anytime.</span>
											<div id="findfzfood">
												<a href="https://play.google.com/store/apps/details?id=www.foodzoned.com.foodzoned&hl=en"><img src="images/includes/GooglePlay-Button.png" alt="fzappgoogle" width="150" height="56"></a>
											</div>												
									   </div>
								   </div>
								</div>
							</div>
							</div>
							</div>
								
			</div><!-- /.pageTitle -->
			</div>
	
      		<div class="col-md-3 cf" style="padding:20px 8px 15px;">
			<div class="payment_wrapperR">
				<div class="desktop-cart-container " style="background:#fff;">
            <div class="desktop-cart__header">
            <h3 class="desktop-cart__title"><center>Your order</center></h3>
             </div>
        <!-- Virtual Cart after placing the order -->
               <?php include "conf/virtualCart2.php"; ?>
		</div>
     </div>
    </div>
				
			</div>
		</div>
    </div> <!-- /.container -->

<!--Footer-------------------------------------------------------------------------------------->
	<?php include "inc/footer-checkout.php"; ?>


	<!-- Scripts -->
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
   	<script src="js/b2tmain.js"></script><!--back-to-top-->
</body>
</html>