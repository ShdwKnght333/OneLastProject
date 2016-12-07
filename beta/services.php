<?php
include "conf/config.php";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Services</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    
	<?php include "inc/styles.php"; ?>
	<link rel="stylesheet" href="css/servicestyle.css">
	<link rel="stylesheet" href="css/site-grid-main.css">

</head>
<body>
<?php include "inc/header-abs.php"; ?>
<?php include "inc/login.php"; ?>
<?php $query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'"); ?>
<?php
if(isset($_SESSION['mycity'])&& isset($_SESSION['myarea']))
{	
	// Fetch the Restaurants from rest_id using Session City and Session Area
$RDa_id = getSqlRow("SELECT id FROM delivery_areas WHERE region='".$_SESSION['mycity']."' AND city='".$_SESSION['myarea']."'");
$R_id = mysql_query("SELECT * FROM rest_delivery_area WHERE da_id='".$RDa_id ['id']."' ");
if(isset($list))
  unset($list);
else
	$list="";
while ($Rest_id = mysql_fetch_array($R_id)) { $list .= (string) $Rest_id['rest_id'] . ","; }
$list = substr($list, 0, -1); // Remove the last comma
if(is_resource($Rest_id))
{
	mysql_data_seek ($Rest_id,0); // reset it back 0th row after fetching once
}
if(isset($_REQUEST['service']))
{
$_SESSION['myservice']=intval($_REQUEST['service']);
$service=$_SESSION['myservice'];
}	
$sort_key=" order by `rpriority` DESC";
$R_ID = mysql_query("SELECT * FROM rest_delivery_area WHERE da_id='".$RDa_id ['id']."' ".$sort_key." ");
if(isset($_REQUEST['SortBy'])&& $_REQUEST['SortBy']=='ByPopularity')
{
	$sort_key=" order by `ratings` DESC";
	$R_ID = mysql_query("SELECT * FROM rest_delivery_area WHERE da_id='".$RDa_id ['id']."' ".$sort_key." ");
}	
else if(isset($_REQUEST['SortBy'])&& $_REQUEST['SortBy']=='ByMinOrderValue')
{
	$sort_key="order by `min` ASC";
	$R_ID = mysql_query("SELECT * FROM rest_delivery_area WHERE da_id='".$RDa_id ['id']."' ".$sort_key." ");
}	
else if(isset($_REQUEST['SortBy'])&& $_REQUEST['SortBy']=='ByDeliveryFee')
{
	$sort_key="order by `dfees` ASC";
	$R_ID = mysql_query("SELECT * FROM rest_delivery_area WHERE da_id='".$RDa_id ['id']."' ".$sort_key." ");
}
else if(isset($_REQUEST['viewOffer'])&& $_REQUEST['viewOffer']=='true')
{
	$R_ID = mysql_query("SELECT * FROM `offers`,`rest_delivery_area` where offers.resid=rest_delivery_area.rest_id and offers.status='1' and da_id='".$RDa_id ['id']."' order by offers.priority DESC");
}
$Darea=getSqlRow("select id from delivery_areas where region='".$_SESSION['mycity']."' and city='".$_SESSION['myarea']."'");
$Service_Count = getSqlNumber("SELECT id FROM rests WHERE status=1 AND site_service='".$service."' AND id IN (" . $list . ")");
if($service == 1){ // Service Type -- 1 for Restaurants
	if($Service_Count =="")
	{
		$Service_text="<div class='service-container' style='display:block'><span class='service-text'> No Restaurants are Available in this Area ! </span> </div>";
	}
	else {
		$Service_text="<div class='service-container' style='display:block'><span class='service-text'>Order from ".$Service_Count." Restaurants </span> </div>";
	}
}
else if($service == 3){  // Service Type -- 3 for Liquors
	if($Service_Count =="")
	{
		$Service_text="<div class='service-container' style='display:block'><span class='service-text'> No Liquor Stores are Available in this Area ! </span> </div>";
	}
	else {
		$Service_text="<div class='service-container' style='display:block'><span class='service-text'>Order from ".$Service_Count." Liquor Store </span> </div>";
   }
}
}
else
{
	$Service_text=""; 
}	
?>	
<!----------------------------------------------------header ends----------------------------->
	<div class="first-widget parallax-services" id="services">
		<div class="parallax-overlay-services">
			<div class="container pageTitle-services">
				<div class="row">
					<div class="home-component">
                            <div class="container">
							   <?php echo $Service_text; ?>
                          <div class="glassy-box" <?php if(isset($_SESSION['mycity'])&& isset($_SESSION['myarea'])) echo "style='display:none;'";   ?>  >
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
                                            <!--<hr>
                                            <span>Select Services</span>
                                            <hr>-->
                                        </div>
										<div>
                                         <ul class="address-shortcuts-list"  id="hidden_add" style="display:none;" ></ul>
											</div>
                            </div>                                       
                           </div>
                          </div>
                        </div>
						
				</div> <!-- /.row -->
			</div> <!-- /.container -->	
	<div class="location-head">
				<div class="location-contain">
				<?php if(isset($_SESSION['myarea'])&& isset($_SESSION['mycity'] )) echo "<span class='present_location'>".$_SESSION['myarea'].", ".$_SESSION['mycity']." </span>"; else echo "<span class='present_location'>Location Not Set </span>";?><button type="submit" id="change_location" class="buttonwallet buttonloc fa fa-location-arrow"> Location Settings </button>
				</div>

	</div>			
		</div> <!-- /.parallax-overlay -->
	</div><br> <!-- /.pageTitle -->
	
	<div>
	</div>
<!--------------------------------------------------------------------------------------------->
    <main class="cd-main-content">

		<div class="cd-tab-filter-wrapper visible-sm visible-md visible-lg">
			<div class="cd-tab-filter">
				<ul class="cd-filters cf">
					<li class="placeholder"> 
						<a data-type="all" href="#0">Select</a>
					</li> 
					<li class="filter" id="all" ><i class=" fa fa-cutlery"style="color:#fff;"></i><a href="services.php?service=<?php if(isset($_SESSION['myservice'])){ echo $_SESSION['myservice']; }?>"  data-type="all"> All</a></li>
					<li class="filter" data-filter=".online"><i class=" fa fa-clock-o"style="color:#fff;"></i><a href="#0" data-type="color-1">Now Open</a></li>
					<li class="filter" id="offers" data-filter="" ><i class=" fa fa-gift"style="color:#fff;"></i><a href="#0" data-type="color-2" onclick="sortSet('Offers');">Offers</a></li>
				</ul> 
			</div> 
		</div>
		<div class="cd-tab-filter-wrapper visible-xs">
			<div class="cd-tab-filter">
				<ul class="cd-filters cf">
					<li class="placeholder"> 
						<a data-type="all" href="#0">Select</a>
					</li> 
					<li class="filter" id="all" ><a href="services.php?service=<?php if(isset($_SESSION['myservice'])){ echo $_SESSION['myservice']; }?>"  data-type="all"> All</a></li>
					<li class="filter" data-filter=".online"><a href="#0" data-type="color-1">Now Open</a></li>
					<li class="filter" id="offers" data-filter="" ><a href="#0" data-type="color-2" onclick="sortSet('Offers');">Offers</a></li>
				</ul> 
			</div> 
		</div>
<div class="container">
		<section class="cd-gallery">
			<ul class="cf">
			<?php 
			if(isset($R_ID)&& is_resource($R_ID))   {
			while($Drss = mysql_fetch_array($R_ID) ){
			// Fetch all info from rest using rest ID
			$Rest_info = mysql_query("SELECT * FROM rests WHERE status=1 AND site_service=".$service." AND id='".$Drss['rest_id']."' " );
			while ($rss = mysql_fetch_array($Rest_info)) {
			$logo="logos/".$rss['id'].".jpg";
			$rstimes=getSqlRow("select * from site_timing where resid=".$rss['id']." and dateday='".date("w")."'");
			?>
			<?php $payment_type = substr($rss['paymenttypes'],4); ?>
				<li class="mix <?php echo $rss['name']; ?> <?php if (checkRestHour($rstimes['open1'],$rstimes['close1'],$rstimes['open2'],$rstimes['close2'],$rstimes['open3'],$rstimes['close3'])) { echo "online"; }?> <?php if ( $rss['delivery_type'] == '2' ){echo "FzDelivery"; }?> <?php if($rss['flash']==1)echo "New"; ?> <?php if($rss['type']=="1") echo "Veg"; ?> <?php if($payment_type=="ONLINE PAYMENT") echo "OnlinePayment"; ?> <?php if($rss['fzrecommend']=="1") echo "Fzrecommend"; ?>">
						<div class="grid_4 <?php  if (checkRestHour($rstimes['open1'],$rstimes['close1'],$rstimes['open2'],$rstimes['close2'],$rstimes['open3'],$rstimes['close3'])) { echo "online"; } else { echo "offline"; } ?>" style="margin-bottom:20px;margin-right:7px;">
						<div class="sitems">
					<!-- Card Service Logo --->
					<center>
				<?php if (file_exists($logo)) { ?>
				<div class="rest_logo">
				<a href="<?php echo setRestUrl($rss['id'],$rss['name']);?>" title="<?php echo $rss['name']; ?>"><img style="border:1px solid #eee;" src="<?php echo $logo; ?>" class="rest_logo"/></a>
				</div>
			<?php  } else { ?>
			<div class="rest_logo">
				<a href="<?php echo setRestUrl($rss['id'],$rss['name']); ?>" title="<?php echo $rss['name']; ?>"><img src="logos/default_logo.jpg" class="rest_logo"/></a>
			</div>
			<?php  } ?>
				</center>
				<!---- Card Service Information ---> 
						<table style="width:90%; margin:0px 10px; line-height:initial; font-size:small;text-align:left;">
						<tbody><tr><td colspan="3" style="padding-top:5px;font-weight:bold;">
						<b><a href="<?php echo setRestUrl($rss['id'],$rss['name']); ?>" title="<?php echo $rss['name']; ?>" style="color:#222;"><?php if (strlen($rss['name']) >= 21) { echo substr($rss['name'], 0, 21). "..."; } else { echo $rss['name']; } ?></a></b> <?php if($rss['flash']==1) { echo '<img src="images/new.gif" width="26" height="12" style="margin-top: -10px;">'; }?><br/>
						
						<!-- Sponsered Card Remaining --->
						<!-- FZ Delivery Display Remaining --- >
			
						<!--<small><i class="fa fa-map-marker fa-1x"></i>
						Manipal-Udupi Road</small>-->
						</td>
						</tr>
						<tr><td>
<span class="rating">
<?php $rate =mysql_query("SELECT ratings FROM rest_delivery_area WHERE rest_id='".$rss['id']."' "); ?>
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
</span></td></tr>
						<tr><td colspan="3" style="padding-top:4px;">

						<?php if($rss['type']=="1") { ?>
						<img src='images/veg.png' width='13' height='13' title='Vegetarian Products'>
						<?php } else if($rss['type']=="2") { ?>
						<img src='images/nonveg.png' width='13' height='13' title='Non-Vegetarian Products'>
						<?php } else if($rss['type']=="3") { ?>
						<img src='images/veg.png' width='13' height='13' title='Vegetarian Products'>  
						<img src='images/nonveg.png' width='13' height='13' title='Non-Vegetarian Products'>
						<?php } else if($rss['type']=="4") { ?>
						<img src='images/alcohol.png' width='13' height='13' title='Alcoholic Products'> 
						<?php  } ?>
						<?php if($rss['sponsered']==1) { echo '<span class="label label-primary">SPONSORED</span>';   } 
									else if($rss['fzrecommend']==1) { echo '<span class="label label-primary">RECOMMENDED</span>';   }//'<span class="label label-tra" style="color:#ff554e">OFFERS</span>'; ?>
						</td></tr>
						<?php
						$Dfees=getSqlRow("select dfees from rest_delivery_area where rest_id='".$rss['id']."' and da_id='".$Darea['id']."'");
						$minOrder=getSqlRow("select min from rest_delivery_area where rest_id='".$rss['id']."' and da_id='".$Darea['id']."'"); 
						?>

						<tr><td colspan="3">Delivery Fee : <?php if ( $Dfees['dfees'] <= '0' ) { echo "FREE"; } else { echo setPrice($Dfees['dfees']); } ?> <?php if ( $rss['delivery_type'] == '2' ){echo '<span class="label label-danger"><i class="fa fa-bolt" style="color:#fff;"></i></span>'; }?> </td></tr>
						<tr><td colspan="3">Min. Order : <?php echo setPrice($minOrder['min']);?> </td></tr>
						
						<!--<tr><td colspan="3"><i class="fa fa-credit-card fa-1x"></i> COD | ONLINE PAYMENT</td></tr>-->

						<!--<tr>
						<td colspan="3"><i class="fa fa-clock-o fa-1x"></i> <small>11.30AM-10PM</small></td>
						</tr>-->

						<tr>
						<td colspan="3">
						<?php  if (checkRestHour($rstimes['open1'],$rstimes['close1'],$rstimes['open2'],$rstimes['close2'],$rstimes['open3'],$rstimes['close3'])) {  ?>
						<h3 align="center"><a href="<?php echo setRestUrl($rss['id'],$rss['name']);?>" title="View <?php echo $rss['name']; ?> Products" class="vmenu">NOW OPEN</a></h3>
						<?php  } else { ?>
						<h3 align="center"><a href="<?php echo setRestUrl($rss['id'],$rss['name']); ?>" title="Timings: <?php echo $rstimes['custom_time'];?>"  class="vclosed">NOW CLOSED</a></h3>
						<?php  } ?>
						</td>
						</tr>
						</tbody></table>

						</div></div>
                </li>
			<?php
						} // End of While Loop
				}
			} // End of $Rest_info If Statement
			?>               
			</ul>
			<?php 
				if(isset($R_ID)&& is_resource($R_ID)) {
				if(isset($Rest_info)&& $Rest_info !="" ){	
				$count=mysql_num_rows($Rest_info);
			    if(!$count>=1){  if (isset($_SESSION['mycity'])) { echo "<div class='cd-fail-message'><span class='notice-msg' >No Result found in <b>".$_SESSION['myarea']."</b> right now, Check back later...</span></div>";  }}
			    }
				}else  if(!isset($_SESSION['myservice']))
				{ echo "<div class='cd-fail-message'><span class='notice-msg' >No Service Available !</span></div><br>"; }
				if(!(isset($_SESSION['mycity']) && isset($_SESSION['myarea']))){
				?>
				<div class="cd-fail-message"><span class="notice-msg" >Location Not Set : Select your City and Location to get your Online Service ! </span><div>
				<?php } // End Location if
				?> 
			
		</section> <!-- cd-gallery -->
</div>
		<div class="cd-filter">
			<form>
				<div class="cd-filter-block">
					<h4>Sort By</h4>
					
					<div class="cd-filter-content">
						<div class="cd-select cd-filters">
						<select class="filter" name="selectThis" id="selectThis" onchange="sortSet(this.value);">
								<option value="">Choose an Option</option>
								<option value="ByPopularity">Popularity</option>
								<option value="ByMinOrderValue">MinOrderValue</option>
								<option value="ByDeliveryFee">DeliveryFee</option>
							</select>
						</div> <!-- cd-select -->
					</div> <!-- cd-filter-content -->
				</div> <!-- cd-filter-block -->

				<div class="cd-filter-block">
					<h4>Filter</h4>

					<ul class="cd-filter-content cd-filters list">
					<li>
							<input class="filter" data-filter="" type="radio" name="radioButton" id="radio1" checked>
			    			<label class="radio-label" for="radio1">None</label>
						</li>
						<li>
							<input class="filter" data-filter=".FzDelivery" type="radio" name="radioButton" id="radio2">
			    			<label class="radio-label" for="radio2">FzDelivery</label>
						</li>

						<li>
							<input class="filter" data-filter=".New" type="radio" name="radioButton" id="radio3">
							<label  class="radio-label" for="radio3">New Restaurants</label>
						</li>

						<li>
							<input class="filter" data-filter=".Veg" type="radio" name="radioButton" id="radio4">
							<label class="radio-label" for="radio4">Vegetarian Only</label>
						</li>
						
						<li>
							<input class="filter" data-filter=".Fzrecommend" type="radio" name="radioButton" id="radio5">
							<label class="radio-label" for="radio5">Recommended</label>
						</li>
						
						<li>
							<input class="filter" data-filter=".OnlinePayment" type="radio" name="radioButton" id="radio6">
							<label class="radio-label" for="radio6">Online Payment</label>
						</li>
						
					</ul> <!-- cd-filter-content -->
				</div> <!-- cd-filter-block -->

				<!--<div class="cd-filter-block">
					<h4>Radio buttons</h4>

					<ul class="cd-filter-content cd-filters list">
						<li>
							<input class="filter" data-filter="" type="radio" name="radioButton" id="radio1" checked>
							<label class="radio-label" for="radio1">All</label>
						</li>

						<li>
							<input class="filter" data-filter=".radio2" type="radio" name="radioButton" id="radio2">
							<label class="radio-label" for="radio2">Choice 2</label>
						</li>

						<li>
							<input class="filter" data-filter=".radio3" type="radio" name="radioButton" id="radio3">
							<label class="radio-label" for="radio3">Choice 3</label>
						</li>
					</ul> 
				</div>-->
			</form>

			<a href="#0" class="cd-close fa fa-chevron-left"> Close</a>
		</div> <!-- cd-filter -->
		<div class="cd-filter-trigger_search">
			<div class="dispsearch" style="position: absolute;right: 2%; color: #fff; margin-top:5px;cursor:pointer;"><i class="fa fa-search fa-2x" style="font-size:1.5em"></i></div>
				<div class="cd-filter-block" id="research" style="margin-bottom:0">
					<div class="cd-filter-content" style="margin-right: 30px;">
						<input type="search" placeholder="Search" autofocus>
					</div> <!-- cd-filter-content -->
				</div> <!-- cd-filter-block -->
					
		</div>
		<a href="#0" class="cd-filter-trigger">MORE Filters</a>
	</main> <!-- cd-main-content --> 
</div>
<br>
              
<!--Footer-------------------------------------------------------------------------------------->
	<?php include "inc/footer.php"; ?>


	<!-- Scripts -->
	
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
    <script src="js/jslog/lpginpop.js"></script>  <!--login-->
   	<script src="js/b2tmain.js"></script><!--back-to-top-->
	<script src="js/servicesmain.js"></script>
	<script src="js/jslog/lpginpop.js"></script>  <!--login-->
	<script src="js/jquery.mixitup.min.js"></script>


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
$("#change_location").on("click", function(e){
    e.preventDefault();
	$(".service-container").hide();
	$(".glassy-box").show();
});
</script>
<script type="text/javascript">
function  sortSet(value)
{
	if(value=="ByPopularity")
	{
		var location = window.location.pathname+"?service="+<?php if(isset($_SESSION['myservice'])){echo $_SESSION['myservice']; } ?>+"&SortBy=ByPopularity";
		window.location.href=location;
	}
	else if(value == "ByMinOrderValue")
	{
		var location = window.location.pathname+"?service="+<?php  if(isset($_SESSION['myservice'])){echo $_SESSION['myservice']; }?>+"&SortBy=ByMinOrderValue";
		window.location.href=location;
	}
	else if(value =="ByDeliveryFee")
	{
		var location = window.location.pathname+"?service="+<?php if(isset($_SESSION['myservice'])){ echo $_SESSION['myservice']; } ?>+"&SortBy=ByDeliveryFee";
		window.location.href=location;
	}	
	else if(value == "Offers")
	{
		var location = window.location.pathname+"?service="+<?php if(isset($_SESSION['myservice'])){ echo $_SESSION['myservice']; } ?>+"&viewOffer=true";
		window.location.href=location;
	}
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
	$(document).keyup(function(n){"27"==n.which&&$("#id01").hide()}),window.onclick=function(n){n.target==modal&&(modal.style.display="none")};$(document).ready(function(){$(".dispsearch").click(function(){$("#research").toggle("slow,swing");});});
</script>
</body>
</html>