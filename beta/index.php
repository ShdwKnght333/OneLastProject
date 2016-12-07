<?php
include "conf/config.php";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Delivery & Takeaway | Restaurants, Grocery & More...</title>
<meta name="description" content="Foodzoned.com is an online food ordering portal which consists of the varied menus of all the food joints enlisted on it. The website acts as a one-step go platform for the users who wish to order food online. The website releases the users from the humdrum of carrying printed menu cards and searching for restaurant phone numbers." />
<meta name="keywords" content="Foodzoned, Team Foodzoned, Manipal, Mangalore, Order Food Online, Food Delivery, Online Food Ordering Portal, Online Menus, Restaurant Menus, Order Online, Takeaway Delivery, Online Food Delivery, Foodzoned.com, Restaurants in Mangalore, Restaurants in Manipal, Manipala" />

<meta property="og:title" content="Foodzoned.com | Delivery & Takeaway | Restaurants, Grocery & More"/>
<meta property="og:image" content="http://www.foodzoned.com/img/website-logo.png"/>
<meta property="og:site_name" content="Foodzoned.com"/>
<meta property="og:description" content="Foodzoned.com is an online food ordering portal which consists of the varied menus of all the food joints enlisted on it. The website acts as a one-step go platform for the users who wish to order food online. The website releases the users from the humdrum of carrying printed menu cards and searching for restaurant phone numbers."/>

<?php include "inc/index-styles.php"; ?>
</head>
<body>
<?php include "inc/index-header.php"; ?> 
<?php include "inc/login.php"; ?>
<?php $query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'"); ?>
 <!---------------------------------Parallax-and-Search------------------------------------->   

<section id="homeIntro" class="parallax first-widget">
    <div class="parallax-overlay">
        <div class="container home-intro-content">
            <div class="row">
                <div class="col-md-12">
                    <section class="cd-intro visible-md visible-lg">
                        <!--<h2 class="cd-headline letters type">-->
                            <img src="images/circlefz1.png" height="136px" width="480px" alt="fzlogof">
							<!--<span>Enter your</span> 
                            <span class="cd-words-wrapper waiting">
                                <b class="is-visible">address</b>
                                <b>locality</b>
                            </span>
                            <span>to get started.</span>-->
                        <!--</h2>-->
                    </section>
					<section class="cd-intro visible-sm visible-xs">
					<img src="images/foodlogo.png" height="120px" width="120px" alt="fzlogof">
					</section>
					<div class="home-component">
                            <div class="container">
                                <div class="glassy-box">
                                    <div class="location-container">
                                        <select class="btnse btnse-default choosen-location col-md-3 col-xs-12" name="city" value="0" id="main_city" onchange="mycity(this.value)">
                              <?php if(isset($_SESSION['mycity']) && $_SESSION['mycity']){ ?>
									<?php while($row = mysql_fetch_array($query_parent)){ ?>
									<option value="<?php echo $row['region'];?>"<?php if (isset($_SESSION['mycity'])){ if ($_SESSION['mycity'] == $row['region'] ) { echo "selected"; } } ?>><?php echo $row['region']; ?></option>
									<?php  }?>
									<?php }else { ?>
									<option value="" >Select City</option>
									<?php while($row = mysql_fetch_array($query_parent)){ ?>
									<option id="my_city" value="<?php echo $row['region']; ?>"<?php if (isset($_SESSION['mycity'])){ if ($_SESSION['mycity'] == $row['region'] ) { echo "selected"; } } ?>><?php echo $row['region']; ?></option>
									<?php }// End of While?>
									<?php	 }//End of Else ?>
                                        </select>
                                                                                                                       
                                             <div class="location-input-container col-md-9 col-xs-12">
                                                <i class="search-icon"></i>
                                             <input type="text"  class="form-control location-hint"  id="myarea" value=""  placeholder="Type your delivery location"  onkeyup="myarea(this.value)"  >
													   <div ><ul id="sub_cat2" ></ul></div>
                                                <span class="locate-me">
                                                    <span class="locate-me-text">
                                                        <input type="submit" value=""  id="locateme" class="detect-location-icon" onclick="locateme()" title="Locate Me" /></span>
                                                </span>
                                           </div>                                                                                            
                                      </div>
                                        
                                   <div class="saved-addresses" id="myservice"  id="myservice" style="display:none;">
											<div class="or-divider">
                                            <hr>
                                            <span>Select Services</span>
                                            <hr>
                                        </div>
										<div>
                                         <ul class="address-shortcuts-list"  id="hidden_add" style="display:none;" ></ul>
											</div>
                            </div>                                       
                           </div>
                          </div>
                        </div>
                        <section class="cta1 clearfix visible-md visible-lg">
                            <div class="container">
                                <div class="row">
                                	<div class="col-md-4 col-lg-4">
                                            <h3>Fz Wallet</h3>
											<a class="fab fab-bottom-center down-bg" href="#fzwallet">
    												<div class="fa fa-chevron-down"></div>			
                                                
											</a>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                            <h3>Find my food</h3>
                                            <a class="fab fab-bottom-center down-bg" href="#findfzfood">
    												<div class="fa fa-chevron-down"></div>			
                                            </a>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                            <h3>Our App</h3>
                                            <a class="fab fab-bottom-center down-bg" href="#apps">
    												<div class="fa fa-chevron-down"></div>			
                                            </a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div> <!-- /.row -->
                            </div> <!-- /.container -->
                        </section> <!-- /.cta -->                         
		        	</div> <!-- /.col-md-12 -->
		        </div> <!-- /.row -->
		    </div> <!-- /.container -->            
	    </div> <!-- /.parallax-overlay -->
	</section> <!-- /#homeIntro -->
   <!---------------------------------end of parallax and search------------------------->

	<section class="cta clearfix visible-md visible-lg">
		<div class="container">
			    <div class="section-header1">
                  <h2 class="section-title">How Does It Work?</h2>
				</div>
          <div class="row">
            	<div class="service-icon-wrap2">
						<img src="images/includes/res.png" alt="restraunt" height="80px" width="80px"><br>
                        <p><strong>1. Choose A Restaurant</strong></p>
				</div>
                <div class="service-icon-wrap2">
                        <i class="fa fa-angle-right fa-3x"style="margin-top:20px;"></i>
				</div>
                <div class="service-icon-wrap2">
						<img src="images/includes/work2.png" alt="food" height="80px" width="170px"><br>
                        <p><strong>2. Place Your Order</strong></p>
				</div>
                <div class="service-icon-wrap2">
                        <i class="fa fa-angle-right fa-3x"style="margin-top:20px;"></i>
				</div>
                <div class="service-icon-wrap2">
						<img src="images/includes/scooter.png" alt="delivery" height="80px" width="90px"><br>
                        <p><strong>3. Food At Your Doorsteps</strong></p>
				</div>
                <div class="clearfix"  id="apps""></div>
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</section> <!-- /.cta -->
    
<section class="cta clearfix visible-sm visible-xs"><!--responsive howitworks-->
		<div class="container">
			<div class="row">
			<div class="center">
				<span style="font-weight:bold;">How it works</span>
			</div>
				<div class="service-icon-wrap2"style="width:30%;">
                        <img src="images/includes/shop (1).png"><br>
							<p style="font-size:smaller;font-weight:bold;margin:0;line-height:initial;">Choose a restaurant</p>
				</div>
                <div class="service-icon-wrap2" style="width:5%;">
                        <i class="fa fa-angle-right fa-3x"style="margin-top:13px;"></i>
				</div>
                <div class="service-icon-wrap2"style="width:30%;">
                        <img src="images/includes/sandwich.png"><br>
						<p style="font-size:smaller;font-weight:bold;margin:0;line-height:initial;">Place your order</p>
				</div>
                <div class="service-icon-wrap2"style="width:5%;">
                        <i class="fa fa-angle-right fa-3x"style="margin-top:13px;"></i>
				</div>
                <div class="service-icon-wrap2"style="width:30%;">
                        <img src="images/includes/delivery.png"><br>
						<p style="font-size:smaller;font-weight:bold;margin:0;line-height:initial;">On your way</p>
				</div>
                <div class="clearfix"></div>
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</section> <!-- /.cta -->

<section class="app">
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
           			<form class="telwrap">
                        <h2>Get our App link to your phone</h2>
                        <div class="cell">
                        	<input class="telno" type="tel" placeholder="Mobile Number">
                    	</div>
                    	<div class="cell">
                        	<button type="submit" class="cta button primary">Send Link</button>
                        </div>
               		</form>
           </div>
       </div>
    </div>
</section>

	<section class="light-content services visible-md visible-lg"  name="fzwallet" id="fzwallet">
		<div class="container">
			<div class="row">
            	<div class="col-md-12 col-sm-12">
					<div class="service-cnt-wrap-r">
							<a href="find-my-food.php"><h3 class="service-title">Find My Food</h3></a>
							<p style="text-align:justify">Save Time | Compare prices | Get the best deals in just One click. 
Find you favourite dishes from the best service providers near you.<br>Find My Food lets you compare similar products from different service providers 
so that you can compare the prices and choose the best deals for yourself.
</p>
						</div> <!-- /.service-cnt-wrap -->
                    <div class="service-box-wrap">
						<div class="service-icon-wrap-r">
							<div class="tooltipf">
							<a href="find-my-food.php"><img src="images/includes/hamburger.png" alt="Find Your Food" width="200" height="200"></a>
							<span class="tooltiptext">Find My Food</span></div>
						</div> <!-- /.service-icon-wrap -->						
					</div> <!-- /.service-box-wrap -->
				</div> <!-- /.col-md-4 -->
			</div> 
		</div> <!-- /.container -->
	</section><!-- /.services -->
	<hr style="width:90%">
	<section class="light-content services visible-md visible-lg"  name="fzwallet" id="fzwallet">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="service-box-wrap">
						<div class="service-icon-wrap-l">
						<div class="tooltipf">
							<a href="wallet.php"><img src="images/includes/wallet.png" alt="wallet" width="200" height="200"></a>
							<span class="tooltiptext">Fz Wallet</span></div>
						</div> <!-- /.service-icon-wrap -->
                        <div class="service-cnt-wrap-l">
							<a href="wallet.php"><h3 class="service-title">Fz Wallet</h3></a>
							<p style="text-align:justify"><strong>Simple | Fast | Hassle Free Payments | Zero Convinience Fees |</strong><br>Want a safe and hassle free payment facility? Add amount to Foodzoned Wallet. Pay for your food securely in no time. Also receive many more offers and cashbacks !!!</p><a href="wallet.php"><button type="button" class="buttonwallet buttoncoupon"">Add Cash</button></a>
						</div> <!-- /.service-cnt-wrap -->						
					</div> <!-- /.service-box-wrap -->
				</div> <!-- /.col-md-4 -->
			</div>
		</div> <!-- /.container -->
	</section> <!-- /.services -->
<!-----------------------------------------------------displayed in phones------------------------>
<section class="light-content services visible-sm visible-xs">
		<div class="container">
			<div class="row">
            	<div class="col-md-12 col-sm-12">
					<div class="service-box-wrapmobile">
						<div class="service-icon-wrap">
							<a href="find-my-food.php"><img src="images/includes/hamburger.png" alt="Find Your Food" width="150" height="150"></a>
						</div> <!-- /.service-icon-wrap -->
						<div class="service-cnt-wrap">
							<h3 class="service-titlem">Find My Food</h3>
							<p>Save Time | Compare prices | Get the best deals in just One click. 
Find you favourite dishes from the best service providers near you.<br>Find My Food lets you compare similar products from different service providers 
so that you can compare the prices and choose the best deals for yourself.</p>
						</div> <!-- /.service-cnt-wrap -->
					</div> <!-- /.service-box-wrap -->
				</div> <!-- /.col-md-4 -->

				<div class="col-md-12 col-sm-12">
					<div class="service-box-wrap">
						<div class="service-icon-wrap">
							<a href="wallet.php"><img src="images/includes/wallet.png" alt="wallet" width="150" height="150"></a>
						</div> <!-- /.service-icon-wrap -->
						<div class="service-cnt-wrap">
							<h3 class="service-titlem">Wallet</h3>
							<p>Simple | Fast | Hassle Free Payments | Zero Convinience Fees |</strong><br>Want a safe and hassle free payment facility? Add amount to Foodzoned Wallet. Pay for your food securely in no time. Also receive many more offers and cashbacks !!!</p>
						</div> <!-- /.service-cnt-wrap -->
					</div> <!-- /.service-box-wrap -->
				</div> <!-- /.col-md-4 -->
			</div>
		</div> <!-- /.container -->
	</section> <!-- /.services -->
<!-------------------------------------------------------------------------------------------------------->
    
    <section class="testimonials-widget">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="bxslider">
						<div class="testimonial">
						  <div class="testimonial-content">
                           	<div class="testimg thumb-post1">
		        					<img src="images/includes/blogthumb1.jpg" alt="" class="img-circle">
	        				  </div>
								<span class="testimonial-author">Poorvi Gautam,WGSHA Manipal</span>
								<p class="testimonial-description">The website releases the users from the humdrum of carrying printed menu cards and searching for restaurant phone numbers.</p>
							</div>
						</div>
						<div class="testimonial">
							<div class="testimonial-content">
                            	<div class="testimg thumb-post1">
		        					<img src="images/includes/blogthumb2.jpg" alt="" class="img-circle">
	        				    </div>
								<span class="testimonial-author">Dr. Monisha K, MCODS Manipal</span>
								<p class="testimonial-description">The website releases the users from the humdrum of carrying printed menu cards and searching for restaurant phone numbers.</p>
							</div>
						</div>
						<div class="testimonial">
							<div class="testimonial-content">
                            	<div class="testimg thumb-post1">
		        					<img src="images/includes/blogthumb3.jpg" alt="" class="img-circle">
	        				  	</div>
								<span class="testimonial-author">Nakul Shetty, Assistant Prof. MIT</span>
								<p class="testimonial-description">The website releases the users from the humdrum of carrying printed menu cards and searching for restaurant phone numbers.</p>
							</div>
						</div>
					</div> <!-- /.bxslider -->
				</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</section> <!-- /.testimonials-widget -->
    
	<section id="blogPosts" class="parallaxb">
	    <div class="parallax-overlayb">
		    <div class="container">
		        <div class="row">
		        	<div class="col-md-12">
		        		<div class="section-header">
							<h2 class="section-title">Want to Partner Us?</h2>
							<p class="section-desc">Join Our Food Web</p>
						</div> <!-- /.section-header -->
		        	</div> <!-- /.col-md-12 -->
		        </div> <!-- /.row -->
		        <div class="row latest-posts">
		        	<a href="joinus.php" role="button" class="buttonpartner buttonus">BECOME A PARTNER</a>
		        </div> <!-- /.row -->
		    </div> <!-- /.container -->
	    </div> <!-- /.parallax-overlay -->
	</section> <!-- /#blogPosts -->

<?php include "inc/footer.php"; ?>
	
	<!-- Scripts -->
	<script src="js/plugins.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
    <script src="js/jslog/lpginpop.js"></script>  <!--login-->
    <script src="js/b2tmain.js"></script><!--back-to-top-->
	<script>
	$(document).keyup(function(n){"27"==n.which&&$("#id01").hide()}),window.onclick=function(n){n.target==modal&&(modal.style.display="none")};
</script>
    <script>
	$(function() {
	  $('a[href*="#"]:not([href="#"])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
		  var target = $(this.hash);
		  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
		  if (target.length) {
			$('html, body').animate({
			  scrollTop: target.offset().top
			}, 1000);
			return false;
		  }
		}
	  });
	});
	</script>
	<script type="text/javascript">
$(document).ready(function() {
	var Area="";
	 function myservice(Area){
         $.ajax({
                    type: "POST",
                    url: "myservice.php",
					data: { 'Area': Area },
					cache: true,
                    success: function(data){
						     document.getElementById("myservice").style ="display:block";
							 document.getElementById("hidden_add").style ="display:block";
							document.getElementById("hidden_add").innerHTML =data;
                        }
                    });
    }
$("#sub_cat2").on("click", "a", function(e){
    e.preventDefault();
    var $this = $(this).children();
    $("#myarea").val($this.data("value"));
	$("#sub_cat2").hide();
	var dataString = $this.data("value");
	myservice(dataString);
});
$('#myarea').focus(function () {
		  $(".parallax-overlay").addClass("highlight ");
});
$('#myarea').focusout(function () {
		$(".parallax-overlay").removeClass("highlight ");
});
});
function mycity(str) {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("myarea").value="";
					document.getElementById("myservice").style ="display:none";
            }
        };
        xmlhttp.open("GET","mycity.php?mycity="+str,true);
        xmlhttp.send();
}
function myarea(str) {
	str = str.trim();
	if(str=="")
	{
		document.getElementById("sub_cat2").style="display:none"; 
		document.getElementById("myservice").style ="display:none";
		document.getElementById("hidden_add").style ="display:none";
		
		return;
	}	
	else 
	{
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("sub_cat2").style="display:block;margin-top: 50px;background: #fff;color: #000; border-radius:4px;";
				document.getElementById("sub_cat2").innerHTML = xmlhttp.responseText; 
            }
        };
        xmlhttp.open("GET","myarea.php?myarea="+str,true);
        xmlhttp.send();
	}		
}
function callback(position) {
   var  latitude = position.coords.latitude;
   var longitude = position.coords.longitude;
       if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState < 4 && xmlhttp.status != 200)
		  {
				 $("#locateme").removeProp("background");
				 $("#locateme").css("background","url('images/AjaxLoader.gif') no-repeat");
				
		  }
			else  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var my_location = xmlhttp.responseText; 
				var values = my_location.split('-');
				var Location = values[0]+", "+values[1]+", "+values[2]+", "+values[3];
				document.getElementById("myarea").value=Location; 
				var area="";
				var city="";
				Area=values[0]; // Save the Area 
				City=values[1]; // Save the City
				 $.ajax({
                    type: "POST",
                    url: "myservice.php",
					data: { 'Area':Area , 'City':City  },
					cache: true,
                    success: function(data){
						     document.getElementById("myservice").style ="display:block";
							 document.getElementById("hidden_add").style ="display:block";
							document.getElementById("hidden_add").innerHTML =data;
                        }
                    });
				 $("#locateme").removeProp("background");
				 $("#locateme").css("background","url('images/locatemearrow.png')");
			}
        };
        xmlhttp.open("GET","locateme.php?latitude="+latitude+"&longitude="+longitude,true);
        xmlhttp.send();
}
function locateme() {
   // One-shot position request.
   navigator.geolocation.getCurrentPosition(callback);
}
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
			$('.btn').prop('disabled', false);
			
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