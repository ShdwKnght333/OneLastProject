<?php
include "conf/config.php";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Contact Us</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	
	<?php include "inc/styles.php"; ?>
</head>
<body>
<?php include "inc/header.php"; ?>
<?php $query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'"); ?>
<!------------------------------------content------------------------->
	<div class="first-widget parallax" id="contact">
		<div class="parallax-overlay">
			<div class="container pageTitle">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2 class="page-title">Contact Us</h2>
					</div> <!-- /.col-md-6 -->
					<!--<div class="col-md-6 col-sm-6 text-right">
						<span class="page-location">Home / Contact</span>
					</div>-->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.parallax-overlay -->
	</div> <!-- /.pageTitle -->

	<div class="container">	
		<div class="row">

			<div class="col-md-12 blog-posts">
				<div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:4px;">
					<div class="col-md-12">
						<div class="contact-wrapper">
							<h3>Get In Touch With Us</h3>
							<p>Team Foodzoned is more than happy to help! If you have any concerns or feedback, feel free to contact us. Happy Ordering!</p>
							<hr>
                        </div> <!-- /.contact-wrapper -->
						<div class="contact_row col-md-4 col-sm-4">
                            <h2>FAQ</h2>
                            <p>Check our Commonly Asked Questions</p>
                            <a href="faq.php"><p>Read our FAQ's</p></a>
                         </div>
                         
                         <div class="contact_row col-md-4 col-sm-4">
                            <h2>Social Media</h2>
                            <p>Follow us on Social media to stay updated about great offers.</p>
							<div class="social">
            		<a href="http://facebook.com/Foodzoned"><i class="fa fa-facebook-square fa-2x" style="color:#3b589e"></i></a>
                    <a href="http://twitter.com/foodzoned"><i class="fa fa-twitter-square fa-2x"  style="color:#79c3f6"></i></a>
                    <a href="http://plus.google.com/102345729917238565603"><i class="fa fa-google-plus-square fa-2x" style="color:#e04b3f"></i></a>
                    <a href=""><i class="fa fa-instagram fa-2x" style="color:#9b6954"></i></a>
                    <a href="http://youtube.com/foodzoned"><i class="fa fa-youtube-square fa-2x" style="color:#bb0000"></i></a><br><br>
                    
						</div>
                         </div>
                         
                         <div class="contact_row col-md-4 col-sm-4">
                            <h2>E-mail us</h2>
                            <p>Didn't find your answer? E-mail us we will look upon the matter and contact you as soon as possible. </p>
                         	<a href="mailto:care@foodzoned.com"><p>care@foodzoned.com</p></a>
                        </div>
                    </div> <!-- /.col-md-12 -->
                   	<h4 style="text-align:center; color:#0D0D0D">Are you a Restaurant Owner?&nbsp;<a href="joinus.php">Register here</a></h4>
				</div> <!-- /.row -->
                
                		<br><div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:4px;">
                        <div class="col-md-12">
                            <div class="contact_row col-md-3 col-sm-6">
                            <h3>CUSTOMER CARE</h3>
                            <p><a href="mailto:care@foodzoned.com">care@foodzoned.com</a><br>(10AM-11PM)</p>
                            </div>
                            
                            <div class="contact_row col-md-3 col-sm-6">
                            <h3>HELPLINE</h3>
                            <p>+91-9035-515-321<br>(10AM-11PM)</p>
                            </div>
                            
                            <div class="contact_row col-md-3 col-sm-6">
                            <h3>SELLER SUPPORT</h3>
                            <p><a href="mailto:support@foodzoned.com">support@foodzoned.com</a><br>(10AM-11PM)</p>
                            </div>
                            
                            <div class="contact_row col-md-3 col-sm-6">
                            <h3>OFFICE ADDRESS</h3>
                            <p>Team Foodzoned<br>Tamana House, 1st cross,<br>House No - 2, Eshwar Nagar,<br>Manipal, Karnataka – 576104</p>
                            </div>
                        </div> <!-- /.col-md-12 -->
                                </div><br> <!-- /.row -->
                
				<div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:4px;">
                    <div class="col-md-12">
                        <div class="contact-form">
                            <h3>Send a Direct Message</h3>
	                        <div class="widget-inner">
                            <form id="sendcontact" name="sendcontact" method="post" action="javascript:void(null);">
									<input type="hidden" name="cmd" id="cmd" value="send_contact" />
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>
                                            <label for="name">Your Name:</label>
                                            <input type="text" name="name" id="name" placeholder="Enter your name" maxlength="50" <? if (isset($_SESSION['memberid'])&& $_SESSION['memberid']) { echo " value='".getval( "users", "name", $_SESSION['memberid'] )."'"; } ?> required>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>
                                            <label for="email">Email Address:</label>
                                             <input type="text" name="email" id="email" placeholder="Enter your E-mail" <? if (isset($_SESSION['memberid'])&& $_SESSION['memberid']) { echo " value='".getval( "users", "email", $_SESSION['memberid'] )."'"; } ?> required>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>
                                            <label for="mobile">Mobile</label><br>
                                             <input type="number" name="mobile" id="mobile" placeholder="Enter 10 digit Mobile Number " maxlength="50" <? if (isset($_SESSION['memberid']) && $_SESSION['memberid']) { echo " value='".getval( "users", "mobilphone", $_SESSION['memberid'] )."'"; } ?> required>
                                        </p>
                                    </div>
                                </div>
								          <div class="row">
                                     <div class="col-md-4">
                                        <p>
                                            <label for="subject">Subject:</label>
                                             <input type="text" name="subject" id="subject" placeholder="Subject of your querry" maxlength="50" required>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>
                                          <label for="city">City :</label>
													<select type="text" name="city" id="city" > 
													<option value="0">Select your City</option>
													<?php while($row = mysql_fetch_array($query_parent)): ?>
													<option value="<?php echo $row['region'];?>"<? if ( $_SESSION['mycity'] == $row['region'] ) { echo " selected"; } ?>><?php echo $row['region'];?></option>
													<?php endwhile; ?>
													</select>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>
                                            <label for="orderid">Order ID :</label>
                                             <input type="text" name="orderid" id="orderid" placeholder="Optional " maxlength="50" >
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            <label for="message">Your message:</label>
                                            <textarea name="message" id="message" placeholder="Your messsage to us."></textarea>
                                        </p>
                                    </div>
                                </div>
								<div class="row">
								  <div class="col-md-12">
                                      <div class="col-md-4">
                                        <p>
                                       <input type="text" name="captcha" id="captcha" placeholder="Enter Verification Code" autocomplete="off" required>
											  <label for="captcha"><img src="captcha.php" alt="captcha" /></label>
                                        </p>
                                    </div>
                             </div>
								</div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="mainBtn" id="submit" onclick='this.disabled=true;post("sendcontact"); return false;'>Send Message</button>
                                    </div>
                                </div>
                             </form>
                          </div> <!-- /.widget-inner -->
						  <div id="result"> </div>
                        </div> <!-- /.contact-form -->
                    </div> <!-- /.col-md-12 -->
                </div> <!-- /.row -->
			</div> <!-- /.col-md-8 -->
		
		</div> <!-- /.row -->
	</div> <!-- /.container -->	<br>
		
<!--Footer-------------------------------------------------------------------------------------->
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
			$('#submit').prop('disabled', false);
		}
	});
	return false;
}
</script>
</body>
</html>