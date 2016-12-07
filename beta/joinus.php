<?php
include "conf/config.php";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Join us</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    
	<?php include "inc/styles.php"; ?>
	
	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/joinustyle.css">
</head>
<body>
<?php include "inc/header.php"; ?>
    
    <!-----------------------------------------------------------header ends------------------------>

	<div class="first-widget parallax" id="joinus">
		<div class="parallax-overlay">
			<div class="container pageTitle">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2 class="page-title">Join Our Food Network</h2>
					</div> <!-- /.col-md-6 -->
					<!--<div class="col-md-6 col-sm-6 text-right">
						<span class="page-location">Home / Become a Partner</span>
					</div>-->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.parallax-overlay -->
	</div> <!-- /.pageTitle -->
<!-----------------------------------------parallax ends------------------------------------------>
<div class="app1 visible-md visible-lg">
	<div class="col-md-12">
	<div class="content--partner">
	<div class="content__row__wrapper">
		<div class="col-md-5">
    	<div class="content__row__col__intro">
        	<div class="content__intro">
            	<h2 class="content__intro__title">Become a Partner with Foodzoned</h2>
                <p class="content__intro__txt">By joining Foodzoned you will get your restaurant in front of hungry customers ready to order.</p>
                <p class="content__intro__txt">If your restaurant already makes a quality product, provides a great customer experience, your only barrier to more sales is your exposure to more customers. That's where Foodzoned comes in, as a leading online dilivery/takeaway ordering platform. We have a strong user base of customers ordering regularly across desktop, mobile and app.</p>
            </div>
		</div>
        </div>
		 <form id="join" name="join" method="post" action="javascript:void(null);">
        <div class="content__row__col">
			<div class="col-md-7">
        	<div class="content__row__col__formfield">
						<input type="hidden" name="cmd" id="cmd" value="join_network" />
						<label class="form--label">Resturant name</label>
						<input type="text" name="rname" id="rname" maxlength="70" required />
						<span class="form--error">Please add a restaurant name</span>
                    <label class="form--label">Contact Name</label>
						 <input type="text" name="name" id="name"  required/>
                    <span class="form--error">Your contact name</span>
                    <label class="form--label">E-mail</label>
						<input type="text" name="email" id="email" maxlength="50" required />
                    <span class="form--error">Please add your email</span>
                    <label class="form--label">Contact Number</label>
						<input type="text" name="phone" id="phone"  required />
                    <span class="form--error">Enter your contact number</span>
                    <label class="form--label">Address</label>
                    <input type="text" name="address" id="address" required>
                    <span class="form--error">Please fill the address</span>
                    <label class="form--label">City</label>
						 <input type="text" name="city" id="city" required/>
                    <span class="form--error">Please Enter valid city</span>
                    <label class="form--label">PINCODE</label>
						<input type="text" name="pincode" id="pincode" maxlength="6" required/>
                    <span class="form--error">Please Enter Valid Pincode</span>
						<label class="form--label" style="padding-top:10px"><img src="captcha.php" alt="captcha" /></label>
						<input type="text" name="captcha" id="captcha" placeholder="Enter below verification code"  autocomplete="off" />
					   
					   
                   <input class="form--button buttonp" name="submit" type="submit" value="I'M INTERESTED" onclick='this.disabled=true; post("join"); return false;'>	
				   
           </div>
		   </div>
        </div>
		</form>
    </div>
    </div>
	</div><!--col-12-->
</div><br>
		<!---------------------------mobile display-------------------------->
	<div class="container visible-xs visible-sm">
		<div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:4px;">
                    <div class="col-md-12">
                        <div class="join-form">
                            <h3>Become Our Partner</h3>
	                        <div class="widget-inner">
                            <form action="#" method="post" id="join-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            <label for="restaurant">Your Restaurant Name</label>
                                            <input type="text" name="restaurant" id="restaurant" maxlength="70" required>
                                        </p>
                                    </div>
									<div class="col-md-12">
                                        <p>
                                            <label for="name">Your Name</label>
                                            <input type="text" name="name" id="name" maxlength="50" required>
                                        </p>
                                    </div>
									<div class="col-md-12">
                                        <p>
                                            <label for="contact">Your Contact Number</label>
                                            <input type="text" name="contact" id="name" maxlength="50" required>
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            <label for="email">Email</label>
                                             <input type="text" name="email" id="email" required>
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            <label for="address">Your Address</label>
                                             <input type="text" name="address" id="address" required>
                                        </p>
                                    </div>
                                <div class="col-md-12">
                                        <p>
                                            <label for="city">City</label>
                                            <input type="text" name="city" id="city" required>
                                        </p>
                                    </div>
								<div class="col-md-12">
                                        <p>
                                            <label for="pincode">Pincode</label>
                                            <input type="text" name="pincode" id="pincode" maxlength="6" required>
                                        </p>
                                    </div>
                                </div>
                                <div class="row" style="text-align:center">
                                    <div class="col-md-12">
                                        <button class="mainBtn" id="submit">I'm Interested</button>
                                    </div>
                                </div>
                             </form>
                          </div> <!-- /.widget-inner -->
                        </div> <!-- /.contact-form -->
                    </div> <!-- /.col-md-12 -->
                </div> <!-- /.row -->
	</div><br>
		<!-------------------------------------------------------------------->		
		<div class="container">
        	<div class="row" style="text-align:center;background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;">
            	<div class="col-md-12">
                	<h2 style="text-align:center">Why Join Foodzned?</h2><br>
                                  
                 <div class="col-md-4">
                 	<img src="images/includes/snippet-partner-forks.png" alt="Your Restaurant">
                    <p>Have your restaurant listed where many people are looking to order</p>
                  </div>
                  
                  <div class="col-md-4">
                 	<img src="images/includes/snippet-partner-hands.png" alt="partner">
                    <p>Stop wasting time processing order on phone</p>
                  </div>
                  
                  <div class="col-md-4">
                 	<img src="images/includes/snippet-partner-screen.png" alt="Our Services">
                    <p>Simple Sign-up process</p>
                  </div>
                  
                  </div>
             </div>
         </div><br>
                  <div id="result"> </div>

<!--Footer------------------------------------------------------------------------------------->
	<?php include "inc/footer.php"; ?>

	<!-- Scripts -->
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
    <script src="js/b2tmain.js"></script><!--back-to-top-->
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
</body>
</html>