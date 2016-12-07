<?php
include "conf/config.php";
$_REQUEST['r']=intval(safe($_REQUEST['r']));
$id=$_REQUEST['r'];
if (!$id) {
	include("404.php");
	exit;
}
$rs=getSqlRow("select * from rests where id=".$id."");
if (!$rs['id']) {
	include("404.php");
	exit;
}
$Service_text = ""; 
if(isset($_SESSION['mycity'])&& isset($_SESSION['myarea'])){
$s_a1=getSqlRow("SELECT id FROM delivery_areas WHERE region='".$_SESSION['mycity']."' AND city='".$_SESSION['myarea']."'");
$s_area=getSqlNumber("select rest_id from rest_delivery_area where da_id='".$s_a1['id']."' and rest_id=".$rs['id']."");
if(!$s_area){
 $rest_service = $rs['site_service'];
 $Service_text="<div class='service-container' style='display:block'><div><span class='service-text' style='@media (max-width:400px){font-size:25px;}'>This service is not available in your area</span></div><div style='padding:10px'><a href='services.php?service=".$rest_service."'><button type='submit' class='buttonwallet buttonloc fa fa-location-arrow' style='font-size:20px;'> Show Services in My Area</button></a></div></div>";
}	
$ec12=getSqlRow("select id from delivery_areas where region='".$_SESSION['mycity']."' and city='".$_SESSION['myarea']."'");
$ec123=getSqlRow("select dfees from rest_delivery_area where rest_id='".$rs['id']."' and da_id='".$ec12['id']."'");
$min123=getSqlRow("select min from rest_delivery_area where rest_id='".$rs['id']."' and da_id='".$ec12['id']."'");
}
$rstimes=getSqlRow("select * from site_timing where resid=".$rs['id']." AND dateday='".date("w")."' ");

////////////////////////////////////////////////// SERVICE PROVIDER 01 PHP-MYSQL QUERY ///////////////////////////////////////////////////////////////////////////////
$getRp1 = mysql_query("SELECT * FROM menus where resid=".$rs['id']." and status=1 order by priority desc");
$getRsm = mysql_query("SELECT * FROM menus where resid=".$rs['id']." and status=1 order by priority desc");

/////////////////////////////////////////////// RATINGS AND REVIEWS PHP-MYSQL QUERY /////////////////////////////////////////////////////////
$getRatings = mysql_query("SELECT * FROM ratings where resid=".$rs['id']." and publish_status=1 order by date asc limit 5");

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Menu</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    
	<?php include "inc/styles.php"; ?>
   	<link rel="stylesheet" href="css/menustyle.css">
</head>
<body>
<?php include "inc/header-abs.php"; ?>
<?php include "inc/login.php"; ?>
<?php include "inc/modal.php"; ?>
<?php $query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'"); ?>
<!----------------------------------------------------header ends----------------------------->
	<div class="first-widget parallax-services" id="restaurant-menu">
		<div class="parallax-overlay-services">
			<div class="container pageTitle-services" >
				<div class="row">
		<div class="home-component">
                     <div class="container">
					 <?php echo $Service_text; ?>
                          <div class="glassy-box"  style="display:none;" >
                           <div class="location-container">
                              <select class="btnse btnse-default choosen-location col-md-3 col-xs-12" name="city" value="0" id="main_city" onchange="mycity(this.value);">
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
										<div>
                                         <ul class="address-shortcuts-list"  id="hidden_add" style="display:none;" ></ul>
											</div>
                            </div>                                       
                           </div>
                          </div>
                        </div>
						<!------if no search bar then display this restaurant info------------------->
							<div class="restaurant_info_wrapper cf" <?php if($Service_text !="")echo "style='display:none;'";  ?> >
								<div class="col-md-12">
								<!-- CSS margin-top added to col-md-3 -->
									<div class="col-md-3 visible-md visible-lg" style="z-index:4;">
										<div class="restaurant_image cf">
										<?php
											$logo="logos/".$rs['id'].".jpg";
											if (file_exists($logo)) { 	
										?>
										<!-- CSS opacity changed for image -->
										<img src="<?php echo $logo;?>"  alt="<?php echo $rs['name']; ?>" />
										<?php  } else { ?>
										<img src="logos/default_logo.jpg" alt="<?php echo $rs['name']; ?>" />
										<?php  } ?>
										</div>
									</div>
									<div class="col-md-9" style="line-height:initial;">
										<div class="restaurant_detail">
									<!-- CSS text tranform added  -->
										<h1 style="text-transform:uppercase;"><?php echo $rs['name']; ?></h1>
										<!-- CSS margin top for p tags are added -->
										<p style="margin: 5px;"><i class="fa fa-clock-o fa-1x"></i> <?php echo $rstimes['custom_time'];?></p>
										<p style="margin: 5px;"><?php if ( $rs['servicetime'] !== "0" ) { ?>
												<?php echo $GLOBALS['est_delivery_time']; ?>: <?php echo $rs['servicetime']; ?> <?php echo $GLOBALS['minute'];?>
												<?php  } ?>
										</p>
										<p style="margin: 5px;"><?php if(isset($_SESSION['mycity']) && isset($_SESSION['myarea'])) { echo $GLOBALS['delivery_cost']; ?>: <?php  if ( $ec123['dfees'] <= '0' ) { echo "FREE"; } else { echo setPrice($ec123['dfees']); } }?></p>
										<?php  if(isset($_SESSION['mycity']) && isset($_SESSION['myarea'])) { ?><p style="margin: 5px;">Min Order : <?php echo setPrice($min123['min']); ?></p><?php } ?>
										</div>
									</div>
								</div><!---column12-->
							</div>		
		
						<!------------end of restaurant info----------------------------------------->
				</div> <!-- /.row -->
			</div> <!-- /.container -->	
	<div class="location-head">
				<div class="location-contain">
				<?php if(isset($_SESSION['myarea'])&& isset($_SESSION['mycity'] )) echo "<span class='present_location'>".$_SESSION['myarea'].", ".$_SESSION['mycity']." </span>"; else echo "<span class='present_location'>Location Not Set </span>";?><button type="submit" id="change_location" class="buttonwallet buttonloc fa fa-location-arrow"> Location Settings </button>
				</div>

	</div>			
		</div> <!-- /.parallax-overlay -->
	</div><br> <!-- /.pageTitle -->
<!--------------------------------------------------------------------------------------------->
<div class="container cf">
	<div class="row">
	<div class="col-md-9" style="padding-bottom:10px;">
	<div class="tabs">
    <ul class="tab-links" style="background:#fff; padding-left:15px;border-radius:4px 4px 0 0;">
        <li class="active"><a href="#tab1">Menu</a></li>
        <li><a href="#tab2">Reviews</a></li>
        <li><a href="#tab3">Info</a></li>
		<li>
		<!-- SEARCH RESTAURANT MENU -->
		<form id="rest-items" name="rest-items" style="margin:8px; height:30px;">
<select class="special-flexselect" style="width:100%;height:28px;margin-top:1px" id="rest-items" name="rest-items" tabindex="1" data-placeholder="Start typing a Product Name..." onchange="addCart(this.value);updateInput(this.value='');">
<option value=""></option>
<?php
$getRp1 = mysql_query("SELECT * FROM menus where resid=".$rs['id']." and status=1 order by priority desc");
while ($Rp1 = @mysql_fetch_array($getRp1)) {
$getRp2 = mysql_query("SELECT * FROM products where menuid=".$Rp1['id']." AND ( stock='2' AND stock_qty > '0' OR stock < '2') AND status=1 order by type,price asc");
while ($Rp2 = @mysql_fetch_array($getRp2)) {
?>
<option value="<?php echo $Rp2['id'];?>">
<?php echo $Rp2['name'];?> - <?php if ($Rp2['proprice']>0) { echo setPrice($Rp2['proprice']); } else { echo setPrice($Rp2['price']); } ?>
</option>
<?php  } } ?>
</select>
</form>
		</li>
    </ul>
	
	<div class="tab-content">
	<div id="tab1" class="tab active">
<section class="cd-faq">
	<!--  RESTAURANT MENU CAT -->
	<ul class="cd-faq-categories cf"  style="overflow-y:scroll;" >
		<?php while ($rsm = @mysql_fetch_array($getRsm)) { ?>
		<li><a  href="#<?php $menu_cat = str_replace(array(' ', '\'', '/', '[',']','&','=','\'\'','.','(',')',':','!','+','|',',','{','}','#','%','*','-',';'),"-",$rsm['menu']); echo  $menu_cat ;?>"><?php echo $rsm['menu']; ?></a></li>
		<?php }?>
	</ul> <!-- cd-faq-categories -->
	<?php mysql_data_seek ($getRsm,0); ?>
	<!--  RESTAURANT MENU ITEMS -->
	<div class="cd-faq-items cf">
	<?php while ($rsm = @mysql_fetch_array($getRsm)) { ?>
	<ul id="<?php $menu_cat = str_replace(array(' ', '\'', '/', '[',']','&','=','\'\'','.','(',')',':','!','+','|',','),"-",$rsm['menu']);   echo  $menu_cat ; ?>" class="cd-faq-group cf">
			<li class="cd-faq-title cf" style="border-bottom:1px solid #ececec;"><h2><?php echo $rsm['menu']; ?> &nbsp; <?php if ($rsm['flash']=="1") echo '<img src="images/new.gif">'; ?> <a name="<?php echo $rsm['id']; ?>"></a></h2></li>		
		<?php
		$getRsp= mysql_query("SELECT * FROM products where menuid=".$rsm['id']." and status=1 order by type,price asc");
		while ($rsp = mysql_fetch_array($getRsp)) {
		?>
		<li class="cf">
		<div class="cd-faq-content">
		<a href="javascript:void(0);" onclick="addCart(<?php echo $rsp['id']?>);" title="<?php echo $GLOBALS['add_cart']; ?> - <?php echo $rsp['name']; ?>">
					<div class="products">
		
		<!------------------DISPLAYING PICTURES IN MENU---------------------------->				
					
		<!---------------------PICTURES IN PHOTO FOLDER-------------------------->		
						
						<div class="products_wrapper">
							<div class="product_type">
								<?php if($rsp['type']=="1") { ?>
								<img src="images/veg.png" width="13" height="13" title="Vegetarian">
								<?php } else if($rsp['type']=="2") { ?>
								<img src="images/nonveg.png" width="13" height="13" title="Non-Vegetarian"> 
								<?php } else if($rsp['type']=="3") { ?>
								<img src="images/alcohol.png" width="13" height="13" title="Alcoholic">
								<?php  } ?>
							</div>
							<div class="product_name">
								<span><?php echo $rsp['name']; ?></span>
							</div>
							<div class="product_description">
								<span><?php echo $rsp['details'];?></span>
							</div>
						</div>
						<div class="product_price">
							<span><?php echo setPrice($rsp['price'])?></span>
								<!-- SITEURL needs to be changed below later -->
                           <span id="span_addcart_<?php echo $rsp['id'];?>"><img src="img/cd-icon-cart.svg" height="25px" width="25px" style="padding:0px 4px;" alt="<?php echo $GLOBALS['add_cart']; ?> - <?php echo $rsp['name']; ?>"></span>
                            <!--<div class="icon icon-shopping-cart" style="color:#ff554e; padding: 0px 4px;"></div>-->
						</div>
					</div>
			</div> <!-- cd-faq-content -->
			</a>
			</li> <!-- cd-faq-group  LI List-->
			<?php } ?>
	</ul> <!-- cd-faq-group  UL List-->	
		<?php } ?>
	</div> <!-- cd-faq-items -->
	<a href="#0" class="cd-close-panel">Close</a>
</section> <!-- cd-faq -->

</div>
<div id="tab2" class="tab">
            <div class="row">
					<div class="col-md-12">
                        <div id="blog-comments" class="blog-post-comments">
                            <div class="blog-comments-content">
							<?php $number = mysql_num_rows($getRatings) ?>
                          <?php if($number >0){ ?>
								<?php  while($getinfo =mysql_fetch_array($getRatings )) {  ?>
								<?php $rating_usrname = getval( "users", "name", $getinfo['userid']);  ?>
									  <div class="media">
                              <div class="pull-left">
									<span class="rating">
									<?php $count = $getinfo['ratings'];   ?>
									<?php $i=5-$count; ?>
									<?php while ($i !=0 ){ ?>
									 <span class="star"></span>
									<?php $i--; ?>
									<?php } ?>
									<?php while($count !=0 ){ ?>
									<span class="star filled"></span>
									<?php $count=$count-1;?>
									<?php } ?>
									</span>
                                    </div><br>
                                    <div class="media-body">
                                        <div class="media-heading">
                                        	<h4><?php echo $rating_usrname; ?></h4> 
                                        	<span><?php echo $getinfo['date']; ?></span>
                                        </div>
                                        <p><?php echo $getinfo['review_info']; ?> </p>
                                    </div>
                                </div>
								<?php } // End While ?>
						  <?php } else { ?>
						  <div class="media" style="border-bottom:none !important">
						  <div class="pull-left">
						  <span class="rating">
<?php $rate =mysql_query("SELECT ratings FROM rest_delivery_area WHERE rest_id='".$rs['id']."' "); ?>
<?php $getstar = mysql_fetch_array($rate); $count = $getstar['ratings'];   ?>
<?php $i=5-$count; ?>
<?php while ($i !=0 ){ ?>
<span class="star"></span>
<?php $i--; ?>
<?php } ?>
<?php while($count !=0 ){ ?>
<span class="star filled"></span>
<?php $count=$count-1;?>
<?php } ?>
</span>
						  </div><br>
						  <div class="media-body">
                       <div class="media-heading">
                         <p><strong> No Reviews available for this restaurant yet .</strong></p>
                      </div>
					  </div>
					  </div>
						  <?php } ?>
                            </div> <!-- /.blog-comments-content -->
                        </div> <!-- /.blog-post-comments -->
                    </div> <!-- /.col-md-12 -->
				</div> <!-- /.row -->
</div><!--tab2--->

<div id="tab3" class="tab"><!-----------------restaurant info------------------->
            <div class="row">
					<div class="col-md-12">
					<h2 style="text-transform:uppercase;"><?php echo $rs['name']; ?></h2>
					<div style="border-bottom:1px solid #ececec;">
					<h4 style="margin:0;"><i class="fa fa-cutlery"></i> Cuisines</h4>
					<span style="padding-left:20px;"><?php echo $rs['cuisines']; ?></span>
					</div>
					<div class="col-md-12" style="border-bottom:1px solid #ececec; margin-top: 20px;">
					<div class="col-md-8">
						<h4 style="margin:0;"><strong><i class="fa fa-hourglass-half"></i> Delivery Hours</strong></h4>
						<ul>
							<li><div>Monday <span style="float:right;"><i class="fa fa-clock-o fa-1x"></i><?php echo $rstimes['custom_time'];?></span></div></li>
							<li>Tuesday <span style="float:right;"><i class="fa fa-clock-o fa-1x"></i><?php echo $rstimes['custom_time'];?></span></li>
							<li>Wednesday <span style="float:right;"><i class="fa fa-clock-o fa-1x"></i><?php echo $rstimes['custom_time'];?></span></li>
							<li>Thursday <span style="float:right;"><i class="fa fa-clock-o fa-1x"></i><?php echo $rstimes['custom_time'];?></span></li>
							<li>Friday <span style="float:right;"><i class="fa fa-clock-o fa-1x"></i><?php echo $rstimes['custom_time'];?></span></li>
							<li>Saturday <span style="float:right;"><i class="fa fa-clock-o fa-1x"></i><?php echo $rstimes['custom_time'];?></span></li>
							<li>Sunday <span style="float:right;"><i class="fa fa-clock-o fa-1x"></i><?php echo $rstimes['custom_time'];?></span></li>
							
						</ul>
					</div>
					<div class="col-md-4" style="margin-top:45px;">
						<h5><strong>Delivery Fee</strong></h5>
						<span><i class="fa fa-money fa-1x"></i> <?php  if ( $ec123['dfees'] <= '0' ) { echo "FREE"; } else { echo setPrice($ec123['dfees']); } ?></span>
						<h5><strong>Delivery Time</strong></h5>
						<span><i class="fa fa-clock-o fa-1x"></i> <?php echo $rs['servicetime']; ?> <?php echo $GLOBALS['minute'];?></span>
					</div>
					</div>
					<div class="col-md-12" style="margin-top: 20px;">
						<div class="col-md-8">
						<h4 style="margin:0;"><strong><i class="fa fa-map-marker fa-1x"></i> Address</strong></h4>
						<span><?php echo $rs['address']; ?></span>
						</div>
						<div class="col-md-4">
						<h5><strong>Payment Type</strong></h5>
						<span><?php echo str_replace("|"," | ",$rs['paymenttypes'])?></span>
						</div>
					</div>
                    </div> <!-- /.col-md-12 -->
				</div> <!-- /.row -->
</div><!--tab3--->
</div>
</div>
</div>

<div class="col-md-3 nopadding">
	<div class="desktop-cart-container visible-lg visible-md" style="background:#fff;min-width:260px;min-height:570px;" >
            <div class="desktop-cart__header">
						<h3 class="desktop-cart__title">Your order</h3>
						<!--       <p class="desktop-cart_order__message">
													You haven’t added anything to your cart yet! Start adding your favourite dishes
														</p> -->
            </div>
		
<div class="div_cart_content">
<?php include "inc/cart.php"; ?>
</div><!-- OUTSIDE CONTAINER -->
</div>
			<div class="desktop-cart-container1 visible-sm visible-xs" style="background:#fff;min-height:490px;" >
            <div class="desktop-cart__header">
						<h3 class="desktop-cart__title">Your order</h3>
						<!--       <p class="desktop-cart_order__message">
													You haven’t added anything to your cart yet! Start adding your favourite dishes
														</p> -->
            </div>
		
<div class="div_cart_content">
<?php include "inc/cart.php"; ?>
</div><!-- OUTSIDE CONTAINER -->
</div>
</div>
</div>
<br><br>
</div>
              
<!--Footer-------------------------------------------------------------------------------------->
	<?php include "inc/footer.php"; ?>


	<!-- Scripts -->
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
    <script src="js/jslog/lpginpop.js"></script>  <!--login-->
   	<script src="js/b2tmain.js"></script><!--back-to-top-->
	<script src="js/menumain.js"></script>
	<script src="js/plugins/jquery.sticky.js"></script>

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
	    e.preventDefault();
    var $this = $(this).children();
    $("#myarea").val($this.data("value"));
	$("#sub_cat2").hide();
	var dataString = $this.data("value");
	myservice(dataString);
  window.location.reload(1);
	
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
                    success: function(data){
						     document.getElementById("myservice").style ="display:block";
							 document.getElementById("hidden_add").style ="display:block";
							document.getElementById("hidden_add").innerHTML =data;
                        }
                    });
				 $("#locateme").removeProp("background");
				 $("#locateme").css("background","url('images/locatemearrow.png')");
				 window.location.reload(1);
			}
        };
        xmlhttp.open("GET","locateme.php?latitude="+latitude+"&longitude="+longitude,true);
        xmlhttp.send();
}
function locateme() {
   // One-shot position request.
   navigator.geolocation.getCurrentPosition(callback);
}
$("#change_location").on("click", function(e){
    e.preventDefault();
	$(".service-container").hide();
	$(".restaurant_info_wrapper").hide();
	$(".glassy-box").show();
});
</script>
<script>
jQuery(document).ready(function() {
    jQuery('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).slideDown(400).siblings().slideUp(400);
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
        e.preventDefault();
    });
});
</script>
<script>
$(document).ready(function() {
	if ($(window).width() >= 768) {
		$('.desktop-cart-container').sticky ({bottomSpacing:385,topSpacing:20,className:"cartstick"});
	}
});
</script>
<!-- Item Search -->
    <link rel="stylesheet" href="js/restaurant-items/flexselect.css" type="text/css" media="screen" />
    <script src="js/restaurant-items/liquidmetal.js" type="text/javascript"></script>
    <script src="js/restaurant-items/jquery.flexselect.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("select.special-flexselect").flexselect({ hideDropdownOnEmptyInput: true });
        $("select.flexselect").flexselect();
      });
    </script>
<!-- Item Search -->
<script type="text/javascript">
function showLocationError(){
	swal({ title: 'Location Not Set', text: 'Please Select your location to start ordering !', type: 'error', showCancelButton: false,  showConfirmButton:true },function() { $("html, body").animate({ scrollTop: 0 }, "slow"); 	}); 
}
function checkLocation()
{
  var condtion="";
    $.ajax({
      url:"checkLocation.php",
      async: false,  
      success:function(data) {
         condtion= data; 
      }
   });
   return condtion;
}
function addCart(pid) {
	//$("#span_cart_loading").html('<img src="img/loading.gif" style="margin:0;padding:0;" />');
	var condition = parseInt(checkLocation(), 2);
	if(condition) {
	$("#span_addcart_"+pid).html('<img src="images/AjaxLoader.gif" height="15px" />');
	$(".div_cart_content").load("inc/cart.php?cmd=add&id=<?php echo $rs['id']; ?>&pid="+pid);
	}
	else 	{
		showLocationError();
	}	
	return false;
}

function remove_cart(cid) { 
	var condition = parseInt(checkLocation(), 2);
	if(condition) {
	$("#span_cart_loading").html('<img src="images/AjaxLoader.gif" style="margin:0;padding:0;" />');
	$(".div_cart_content").load("inc/cart.php?cmd=remove&id=<?php echo $rs['id'];?>&cid="+cid);
}
else{
	showLocationError();
}
return false;
}
function updateQty(cid) {
	var condition = parseInt(checkLocation(), 2);
	if(condition) {
	$("#span_cart_loading").html('<img src="img/loading.gif" style="margin:0;padding:0;" />');
	$(".div_cart_content").load("inc/cart.php?cmd=update_qty&id=<?php echo $rs['id']; ?>&cid="+cid+"&qty="+$('#qty_'+cid).val());
	}
	else {
	showLocationError();
	}
	return false;
}

function updateQty2(cid, urp) {
	var condition = parseInt(checkLocation(), 2);
	if(condition) {
	$("#span_cart_loading").html('<img src="img/loading.gif" style="margin:0;padding:0;" />');
	$(".div_cart_content").load("inc/cart.php?cmd=update_qty&id=<?php echo $rs['id']; ?>&cid="+cid+"&qty="+urp+"");
	}
	else {
		showLocationError();
	}
	return false;
}
function remove_cart2(cid) { 
		setTimeout( function(){
				if (confirm("Are you sure to remove all items ? ")) {
					$(".div_cart_content").load("inc/cart.php?cmd=remove&id=<?php echo $rs['id']; ?>&cid="+cid);
							}
				}, 200); 
}
function updateExtras(id,cid,price,qty) {
	
		var condition = parseInt(checkLocation(), 2);
	if(condition) {
	if($('#'+id).is(':checked')) {
	var selected=new Array();
	$('.cb_'+cid+':checked').each(
	  function() {
	  	selected.push(this.value);
	  }
	);
	$(".div_cart_content").load("inc/cart.php?cmd=update_extra&id=<?php echo $rs['id'];?>&cid="+cid+"&price="+price+"&qty="+qty+"&extras="+selected.join(','));
        } else {
						price=-price;
						var selected=new Array();
						$('.cb_'+cid+':checked').each(
						function() {
										selected.push(this.value);
						}
					);
					var condition = parseInt(checkLocation(), 2);
					$(".div_cart_content").load("inc/cart.php?cmd=update_extra&id=<?php echo $rs['id'];?>&cid="+cid+"&price="+price+"&qty="+qty+"&extras="+selected.join(','));
        }
	}
else {
	showLocationError();
	}
	return false;
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
				url: 'showExtras.php',
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