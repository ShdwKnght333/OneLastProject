<?
include "conf/config.php";
$_REQUEST['id']=intval(safe($_REQUEST['id']));
$id=$_REQUEST['id'];
if (!$id) {
	include("404.php");
	exit;
}
$rs=getSqlRow("select * from rests where id=".$id."");
if (!$rs['id']) {
	include("404.php");
	exit;
}

$s_a1=getSqlRow("SELECT id FROM delivery_areas WHERE region='".$_SESSION['mycity']."' AND city='".$_SESSION['myarea']."'");
$s_area=getSqlNumber("select rest_id from rest_delivery_area where da_id='".$s_a1['id']."' and rest_id=".$rs['id']."");

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?=$rs['name']?> - <?=ucwords(strtolower($rs['rcity']))?></title>
<meta name="description" content="<?=$rs['description']?>" />
<meta name="keywords" content="<?=$rs['keywords']?>" />

<? include "inc/styles.php"; ?>

<meta property="og:title" content="<?=$rs['name']?> @ <?=SITENAME?>"/>
<meta property="og:image" content="<?=SITEURL?>img/website-logo.png"/>
<meta property="og:site_name" content="<?=SITENAME?>"/>
<meta property="og:url" content="<?=setRestUrl($rs['id'],$rs['name'])?>"/>
<meta property="og:description" content="Foodzoned.com is an online food ordering portal which consists of the varied menus of all the food joints enlisted on it. The website acts as a one-step go platform for the users who wish to order food online. The website releases the users from the humdrum of carrying printed menu cards and searching for restaurant phone numbers."/>

<link type="text/css" media="screen" rel="stylesheet" href="js/colorbox/colorbox.css" />
<script type="text/javascript" src="js/colorbox/jquery.colorbox-min.js"></script>

<script>

function addCart(pid) {
	//$("#span_cart_loading").html('<img src="img/loading.gif" style="margin:0;padding:0;" />');
	$("#td_addcart_"+pid).html('<img src="img/loading.gif" height="15px" />');
	$(".div_cart_content").load("inc/cart.php?cmd=add&id=<?=$rs['id']?>&pid="+pid);
	return false;
}

function remove_cart(cid) { 
	$("#span_cart_loading").html('<img src="img/loading.gif" style="margin:0;padding:0;" />');
	$(".div_cart_content").load("inc/cart.php?cmd=remove&id=<?=$rs['id']?>&cid="+cid);
	return false;
}

function remove_cart2(cid) { 

swal({
  title: "Are you sure?",
  text: "Your cart will be cleared!",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes, clear it!",
  closeOnConfirm: false
},
function(){

	$("#span_cart_loading").html('<img src="img/loading.gif" style="margin:0;padding:0;" />');
	$(".div_cart_content").load("inc/cart.php?cmd=remove&id=<?=$rs['id']?>&cid="+cid);
	swal("Cart cleared!", "Your shopping cart is empty", "success");
	return false;
});
 }

function updateQty(cid) {
	$("#span_cart_loading").html('<img src="img/loading.gif" style="margin:0;padding:0;" />');
	$(".div_cart_content").load("inc/cart.php?cmd=update_qty&id=<?=$rs['id']?>&cid="+cid+"&qty="+$('#qty_'+cid).val());
	return false;
}

function updateQty2(cid, urp) {
	$("#span_cart_loading").html('<img src="img/loading.gif" style="margin:0;padding:0;" />');
	$(".div_cart_content").load("inc/cart.php?cmd=update_qty&id=<?=$rs['id']?>&cid="+cid+"&qty="+urp+"");
	return false;
}

function updateExtras(cid) {
	var selected=new Array();
	$('.cb_'+cid+':checked').each(
	  function() {
	  	selected.push(this.value);
	  }
	);
	
	$("#span_cart_loading").html('<img src="img/loading.gif" style="margin:0;padding:0;" />');
	$(".div_cart_content").load("inc/cart.php?cmd=update_extra&id=<?=$rs['id']?>&cid="+cid+"&extras="+selected.join(','));
	return false;
}
</script>

<!-- Item Search -->
    <link rel="stylesheet" href="/js/restaurant-items/flexselect.css" type="text/css" media="screen" />

    <script src="/js/restaurant-items/liquidmetal.js" type="text/javascript"></script>
    <script src="/js/restaurant-items/jquery.flexselect.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("select.special-flexselect").flexselect({ hideDropdownOnEmptyInput: true });
        $("select.flexselect").flexselect();
      });
    </script>
<!-- Item Search -->

<!-- JavaScript -->
 <link href="/theme/assets/css/responsive-accordion.css" rel="stylesheet" type="text/css" media="all" />
 <script src="/theme/assets/js/smoothscroll.min.js" type="text/javascript"></script>
 <script src="/theme/assets/js/backbone.js" type="text/javascript"></script>
 <script src="/theme/assets/js/responsive-accordion.min.js" type="text/javascript"></script>

<style>
.responsive-accordion-default.responsive-accordion li .responsive-accordion-panel {
padding:10px; padding-bottom:20px;
}
</style>

</head>
<body>

<div class="mainbody">

<? include "inc/header.php"; ?>
<br/>
<?
$derror = "<h2>Delivery Not Available</h2> Please select a nearby area or <a href='/contact.php'>contact us</a> to arrange a delivery in your area.";

if ( $_SESSION['mycity'] && $_SESSION['myarea'] ) {
if (!$s_area) {
?>
<div class="d_error"><?=$derror;?><br/><br/></div>
<? } } ?>

<div id="content" class="container_12">


<div id="div_items" class="grid_7">


<div style="font-size:13px;background:#ffffff;">
<h2 style="text-transform:uppercase;">&nbsp;<a href="<?=setRestUrl($rs['id'],$rs['name'])?>" title="<?=$rs['name']?>"><?=$rs['name']?> - <?=$rs['rcity']?></a></h2>

<? 
$logo="logos/".$rs['id'].".jpg";
if (file_exists($logo)) { 	
?>
<img src="<?=$logo?>" style="float:left;margin-left:8px;" alt="<?=$rs['name']?>" width="30%"/>
<? } else { ?>
<img src="img/default_logo.jpg" style="float:left;margin-left:8px;" alt="<?=$rs['name']?>" width="30%"/>
<? } ?>

<table style="float:left;margin-left:10px;">
<tr>
<td colspan="3" style="text-align:left;">
</td></tr>

<tr>
<td colspan="3"><i class="fa fa-map-marker fa-1x"></i> <?=$rs['address']?></td>
</tr>

<tr>
<td colspan="3" style="padding:5px 0px 0px 0px;">

<? if($rs['type']=="1") { ?>
<img src='/theme/images/veg.png' width='13' height='13' title='Vegetarian Products'>
<? } else if($rs['type']=="2") { ?>
<img src='/theme/images/nonveg.png' width='13' height='13' title='Non-Vegetarian Products'>
<? } else if($rs['type']=="3") { ?>
<img src='/theme/images/veg.png' width='13' height='13' title='Vegetarian Products'> &nbsp; 
<img src='/theme/images/nonveg.png' width='13' height='13' title='Non-Vegetarian Products'>
<? } else if($rs['type']=="4") { ?>
<img src='/theme/images/alcohol.png' width='13' height='13' title='Alcoholic Products'> 
<? } ?>

</td>
</tr>

<?
$rstimes=getSqlRow("select * from site_timing where resid=".$rs['id']." and dateday='".date("w")."'");
?>
<tr>
<td colspan="3" style="padding:5px 0px 5px 0px;color:#DB1921;">
<i class="fa fa-clock-o fa-1x"></i> <?=$rstimes['custom_time'];?>
</td>
</tr>

<? if ( $rs['servicetime'] !== "0" ) { ?>
<tr>
<td><?=$GLOBALS['est_delivery_time']?> </td><td> : </td>
<td>&nbsp; <?=$rs['servicetime']?> <?=$GLOBALS['minute']?></td>
</tr>
<? } ?>

<?
$ec12=getSqlRow("select id from delivery_areas where region='".$_SESSION['mycity']."' and city='".$_SESSION['myarea']."'");
$ec123=getSqlRow("select dfees from rest_delivery_area where rest_id='".$rs['id']."' and da_id='".$ec12['id']."'");
$min123=getSqlRow("select min from rest_delivery_area where rest_id='".$rs['id']."' and da_id='".$ec12['id']."'"); 
?>

<tr>
<td><?=$GLOBALS['delivery_cost']?> </td><td> : </td>
<td>&nbsp; <? if ( $ec123['dfees'] <= '0' ) { echo "FREE"; } else { echo setPrice($ec123['dfees']); } ?></td>
</tr>

<tr>
<td>Minimum Order </td><td> : </td>
<td>&nbsp; <?=setPrice($min123['min']);?></td>
</tr>

<tr><td colspan="3"><i class="fa fa-credit-card fa-1x"></i> <?=str_replace("|"," | ",$rs['paymenttypes'])?></td></tr>

<tr>
<td colspan="3">
<!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_default_style" style="padding-top:8px">
<a class="a2a_button_facebook" title="Share on Facebook"></a>
<a class="a2a_button_twitter" title="Share on Twitter"></a>
<a class="a2a_button_google_plus" title="Share on Google+"></a>
</div>
<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->
</td>
</tr>
</table>

<div style="clear:both;"></div><br/>
</div>

<div style="clear:both;"></div>
<? if ($rs['note']) { ?><br/><p align="justify">NOTE : <?=$rs['note']?></p><? } ?>
<br/>


<?php 
if( $rs['site_service']=="2" ) 
{ include "inc/service-provider-02.php"; }
else
{ include "inc/service-provider-01.php"; }
?>

</div>

<div id="div_cart" class="grid_3">
<div class="border">
<h3>YOUR ORDER <span id="span_cart_loading"></span></h3>
<div class="div_cart_content">
<? include "inc/cart.php"; ?>
</div>
</div>
</div>


</div>
<div class="clearfix"></div>

<? include "inc/footer.php"; ?>
            
<div class="clearfix"></div>
</div>

<!--Start of AGE VERIFICATION -->

<?

if ($_REQUEST['verify']) { $_SESSION['myage'] = $_REQUEST['verify']; }

if ( $_SESSION['mycity'] && $_SESSION['myarea'] && $rs['site_service']=="3" && $_SESSION['myage'] != "1" )
{
?>

<script>
$(document).ready(function() {
$(".overlay").fadeToggle("fast");
});
</script>

<div class="overlay" style="display: none;">
	<div class="login-wrapper">
		<div class="login-content">
<br/>
<h4>AGE VERIFICATION</h3>
<h3 style="color:red;">You must be 21+ years old to do transaction in liquor section.</h4>
<small>By clicking 'YES, I AM 21+' you agree to Foodzoned's <a href="/privacy.php" target="_blank">Privacy Policy</a> and <a href="/terms.php" target="_blank">Terms of Use</a>.</small>
<br/>
<center>
<table>
<td style="padding:10px;">
<form method="get" action="/" name="my-age2">
<input type="submit" value="NO" style="padding:10px;">
</form>
</td>
<td style="padding:10px;">
<form method="post" action="<? echo $_SERVER["REQUEST_URI"]; ?>" name="my-age1">
<input type="hidden" name="verify" id="verify" value="1" />
<input type="submit" value="YES, I AM 21+" style="padding:10px;">
</form>
</td>
</table>
</center>
<br/>

		</div>
	</div>
</div>

<? } ?>
<!-- End of AGE VERIFICATION -->

</body>
</html>