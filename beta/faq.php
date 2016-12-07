<?php
include "conf/config.php";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>FAQ</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    
	<?php include "inc/styles.php"; ?>
	
	<!-- Stylesheets -->
   	<link rel="stylesheet" href="css/faqstyle.css"> <!-- Resource style -->
</head>
<body>
<?php include "inc/header.php"; ?>

	<div class="first-widget parallax" id="faq">
		<div class="parallax-overlay">
			<div class="container pageTitle">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2 class="page-title">FAQ</h2>
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.parallax-overlay -->
	</div> <!-- /.pageTitle -->
<!------------------------------------end of header-------------------------------------->
<section class="cd-faq">
	<ul class="cd-faq-categories">
		<li><a class="selected" href="#basics">Basics</a></li>
		<li><a href="#mobile">Mobile</a></li>
		<li><a href="#account">Account</a></li>
		<li><a href="#payments">Payments</a></li>
		<li><a href="#privacy">Privacy</a></li>
		<li><a href="#delivery">Delivery</a></li>
	</ul> <!-- cd-faq-categories -->

	<div class="cd-faq-items">
		<ul id="basics" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Basics</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">What is Foodzoned?</a>
				<div class="cd-faq-content">
					<p>Foodzoned is an online food ordering portal which consists of the varied menus of all the food joints enlisted on it. The website acts as a one-step go platform for the users who wish to order food online. The website releases the users from the humdrum of carrying printed menu cards and searching for restaurant phone numbers.<br/><br/>
                    The easy and appealing UI of the website allows the users to order the food of their choice with a few clicks. The users can experiment with different cuisines available with the restaurant even when ordering from home and thus they can bring in the fine dining experience.<br/><br/>
                    Foodzoned aims at bridging the gap that exists between the user and the restaurant and thus providing the ultimate food experience to the masses.</p>
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">Can I place Takeaway orders on Foodzoned?</a>
				<div class="cd-faq-content">
					<p>Yes you can place a takeaway order from Foodzoned.</p>
				</div> <!-- cd-faq-content -->
			</li>
            
            <li>
				<a class="cd-faq-trigger" href="#0">Can I call and place my order? </a>
				<div class="cd-faq-content">
					<p>Definitely! You can. We look forward to hear from you. Call us at +91-7204555321.</p>
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">Can I suggest a Service Provider? How?</a>
				<div class="cd-faq-content">
					<p>Yes. Please send us your request on <a href="mailto:care@foodzoned.com">support@foodzoned.com</a></p>
				</div> <!-- cd-faq-content -->
			</li>
		</ul> <!-- cd-faq-group -->

		<ul id="mobile" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Mobile</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">Do you have mobile app?</a>
				<div class="cd-faq-content">
					<p>No, we are currently working - for Android and iOS. It will be out soon!</p>
				</div> <!-- cd-faq-content -->
			</li>
			
		</ul> <!-- cd-faq-group -->

		<ul id="account" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Account</h2></li>
			
            <li>
				<a class="cd-faq-trigger" href="#0">How do I sign up?</a>
				<div class="cd-faq-content">
					<p>Click on the login/signup button on the homepage to register yourself to Foodzoned.</p>
				</div> <!-- cd-faq-content -->
			</li>
            
            <li>
				<a class="cd-faq-trigger" href="#0">I don’t remember my password. I Need Help!</a>
				<div class="cd-faq-content">
					<p>&#8226; Don't worry. Here's what you need to do:<br/><br/>
                        &#8226; Click LOGIN on the top right of the site page to access the login page.<br/><br/>
                        &#8226; Click <a href="/login.php?pass=1">FORGOT PASSWORD?</a> Link available at the bottom of the login page.<br/><br/>
                        &#8226; Enter your e-mail ID in the displayed field.<br/><br/>
                        &#8226; We will send you a link in your e-mail.<br/><br/>
                        &#8226; You can reset your password instantly by clicking the link.</p>
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">Are there any perks of signing up on Foodzoned?</a>
				<div class="cd-faq-content">
					<p>&#8226; You will have quicker and smoother transactions.<br/><br/>
                        &#8226; Your past delivery addresses will be saved so that you don't have to enter them all over again in your next order.<br/><br/>
                        &#8226; You can track the history of every order with their details in your account.</p>
				</div> <!-- cd-faq-content -->
			</li>

		</ul> <!-- cd-faq-group -->

		<ul id="payments" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Payments</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">Is it safe to use my credit card / debit card on this site?</a>
				<div class="cd-faq-content">
					<p>Absolutely!! All transactions on Foodzoned are 100% safe and secure. We work with world-class payment gateways to process your payment and ensure secure ordering for all our customers. No financial data is gathered without a secure layer transaction. All the information is processed using SSL data encryption (secure encrypted connection), which protects the information from being viewed by anyone. The iframe that gathers financial data is completely secure and is posted through a HTTPS.</p>
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">How do I know my purchase is complete?</a>
				<div class="cd-faq-content">
					<p>You will see a confirmation message on the screen along with your order number. You will also receive order details via email.</p>
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">My transaction failed but the money was deducted from my account. What do I do?</a>
				<div class="cd-faq-content">
					<p>Your money is safe and will be refunded. Do not worry. Please send order details to <a href="mailto:care@foodzond.com">care@foodzond.com</a></p>
				</div> <!-- cd-faq-content -->
			</li>
            
            <li>
				<a class="cd-faq-trigger" href="#0">Are there any hidden costs when I make a purchase on Foodzoned?</a>
				<div class="cd-faq-content">
					<p>None. We will never hide any cost from you. The price and charges mentioned on the site are final.</p>
				</div> <!-- cd-faq-content -->
			</li>
		</ul> <!-- cd-faq-group -->

		<ul id="privacy" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Privacy</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">I am concerned about the privacy of my personal information I have shared with Foodzoned.</a>
				<div class="cd-faq-content">
					<p>We understand that you value your privacy, and we respect it. Foodzoned is committed to maintaining complete confidentiality and privacy of the data that you share with us. You may go through our <a href="privacy.php">Privacy Policy</a>.</p>
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">How can I access my account data?</a>
				<div class="cd-faq-content">
					<p>All of your account data can be seen on the member dashboard after you login.</p>
				</div> <!-- cd-faq-content -->
			</li>
			
		</ul> <!-- cd-faq-group -->

		<ul id="delivery" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Delivery</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">What should I do if my order hasn't been delivered yet?</a>
				<div class="cd-faq-content">
					<p>Feel free to call us to our customer support.</p>
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">When will I get my refund?</a>
				<div class="cd-faq-content">
					<p>Your refund will happen as per the below mentioned timelines. Please note that the refunds are dependent on external agencies such as banks, payment gateways etc.<br/><br/>
                        &#8226; Debit card 7-10 working days from the refund initiation date<br/>
                        &#8226; NEFT transfer 7-10 working days from the refund initiation date<br/><br/>
                        For any queries mail us at <a href="mailto:care@foodzond.com">care@foodzond.com</a></p>
				</div> <!-- cd-faq-content -->
			</li>
			
            <li>
				<a class="cd-faq-trigger" href="#0">What is the service guarantee and when do I get a refund?</a>
				<div class="cd-faq-content">
					<p>We guarantee to deliver within 45 minutes.<br/><br/>
                        If there is any difference in the price of the item billed to you by Foodzoned and the actual bill delivered by the restaurant then the difference paid by you will be refunded to you.<br/><br/>
                        If there is an item missing then we will try to replace it within an acceptable time or refund the amount whichever is suitable to you.<br/><br/>
                        If, after placing your order, the restaurant decides to not deliver your complete or part order for any reason then we will contact you with the option of shifting the order to another restaurant or you can choose to get refund and we will simply reverse the transaction amount to the medium (Debit Card) used by you while making the payment to us.</p>
				</div> <!-- cd-faq-content -->
			</li>
            
			<li>
				<a class="cd-faq-trigger" href="#0">Are the any limitations to the service guarantee?</a>
				<div class="cd-faq-content">
					<p>Food and Cake Pics are for representation purposes only and FZ won't guarantee that the ordered item would look/taste exactly the same as shown on the FZ and its partner restaurant websites.<br/><br/>
                        Foodzoned Guarantee won't be applicable on peak festival days like Christmas, New Year's Eve, Ganesh Chaturthi/Visarjan, LaxmiPujan or any other such festival/s during which most of the restaurants are either closed or are restricted for delivery.<br/><br/>
                        Foodzoned Guarantee won't be applicable on days when any procession/rally/march/road construction etc is taking place which affects the normal process of delivery.<br/><br/>
                        FZ Management reserves the right to revoke all types of guarantees at any point in time without prior intimation. Final decision on the same rests with the management which is non-contestable and fully binding.<br/><br/>
                        Time Guarantee is valid till the first barrier of entry. If your number is not reachable, then the guarantee ceases to exist.</p>
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">Can I cancel an order, once placed?</a>
				<div class="cd-faq-content">
					<p>No. We apologise for the inconvenience.<br/>
						Once an order placed it cannot be cancelled or updated as we at Foodzoned have a live order transmission system in place at most of the restaurants. This ensures that the order reaches you in the committed time frame and in warm condition.</p>
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">When will my order arrive?</a>
				<div class="cd-faq-content">
					<p>As promised we will try to deliver your order within 45 minutes.</p>
				</div> <!-- cd-faq-content -->
			</li>
			
		</ul> <!-- cd-faq-group -->
	</div> <!-- cd-faq-items -->
	<a href="#0" class="cd-close-panel">Close</a>
</section> <!-- cd-faq -->
		
<!--Footer---------------------------------------------------------------------------------------->
	<?php include "inc/footer.php"; ?>

	<!-- Scripts -->
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
    <script src="js/faqmain.js"></script> <!-- Resource jQuery -->
    <script src="js/b2tmain.js"></script><!--back-to-top-->
</body>
</html>