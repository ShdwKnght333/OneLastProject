<?php 
include "conf/config.php";

if ($_SESSION['memberid']) { } else {
	header("Location: ".SITEURL."login.php?approve=1");
	exit;
}

if ($_REQUEST['cmd']=="set_ordertype") {
	
	$need=getWhere("order_types","need_address","order_type='".safe($_REQUEST['val'])."'");
	if ($need==1) {
		echo "<script>$('.tr_delivery').show();</script>";
	} else {
		echo "<script>$('.tr_delivery').hide();</script>";
	}
	
	exit;
}

$rest_id=getWhere("cart","rest_id","session_id='".session_id()."'");
if (!$rest_id) {
	header("Location: ".SITEURL."");
	exit;
}

$rsr=getSqlRow("SELECT * FROM rests WHERE id=".$rest_id."");

$rest_tax=$rsr['rest_tax'];
$service_fee=$rsr['servicefee'];

$getRss= mysql_query("SELECT * FROM cart where session_id='".session_id()."' and rest_id=".$rest_id." order by added_date asc");
$frs=getSqlRow("SELECT * FROM rests WHERE id=".$rest_id."");

while ($rss = mysql_fetch_array($getRss)) {
	$rsp=getSqlRow("select * from products where id=".$rss['prod_id']."");
	$extras_array=explode(",",$rss['extras']);
	$price=($rsp['proprice']>0)?$rsp['proprice']:$rsp['price'];
	$price=($price*$rss['qty']);
	$price=number_format($price,2,".","");
	$sub_total=$sub_total+$price;	
	$getRsss = mysql_query("SELECT optionals.* FROM optionals,optional_product where optional_product.prodid=".$rsp['id']." and optional_product.optid=optionals.id order by optional asc");
	while ($rsss = @mysql_fetch_array($getRsss)) {
		if (in_array($rsss['id'],$extras_array)) $extra_total=$extra_total+($rsss['price']*$rss['qty']);
	}
	
	
	
}

if ($rest_tax>0) { 
	$tax_total=number_format(($sub_total+$extra_total)*$rest_tax/100,2,".","");	
}
$order_total=$tax_total+$sub_total+$service_fee+$extra_total;


$session_id=session_id();
$getRss= mysql_query("SELECT * FROM cart where session_id='".$session_id."' and rest_id=".$rsr['id']." order by added_date asc");
while ($rss = mysql_fetch_array($getRss)) {

$rsp=getSqlRow("select * from products where id=".$rss['prod_id']."");
if ( $rsp['stock'] == "2" && $rss['qty'] > $rsp['stock_qty'] )
{
header("Location: ".setRestUrl($rsr['id'],$rsr['name']).""); exit; }
}


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?=$GLOBALS['order_approve']?></title>
<? include "inc/styles.php"; ?>
<link rel="stylesheet" href="js/jqueryui/themes/base/jquery.ui.all.css" /> 
<script src="js/jqueryui/ui/jquery.ui.core.js"></script> 
<script src="js/jqueryui/ui/jquery.ui.widget.js"></script> 
<script src="js/jqueryui/ui/jquery.ui.datepicker.js"></script> 
<script>
$(function() {
	$( "#deliverydate" ).datepicker();
});

function setAddress(id) {
	$("#span_address_loading").show();
	$("#result").load("conf/post.php?cmd=set_address&id="+id);
}

function setOrderType(val) {
	
	$.post("<?=$_SERVER['PHP_SELF']?>", { cmd: "set_ordertype", val: val }, 
            function(data) {
			$("#result").html(data);
	});
	return false;
	
}

function showcc(val) {
	if (val=="Online Credit Card" || val=="Authorize.net") {
		$(".cc_details").show();
	} else {
		$(".cc_details").hide();
	}
}
</script>
</head>
<body>

<div class="mainbody">

<? include "inc/header.php"; ?>
                

<div id="content" class="container_12">
<div class="grid_12">
<h1><?=$GLOBALS['order_approve']?></h1>
<div id="div_order">
<?=$GLOBALS['order_approve_notice']?>

<?php

if ($rsr['outside_city'] == 1)
{ $rsr['rcity'] = $_SESSION['mycity']; }

?>

<form name="myform" id="myform" action="javascript:void(0);">
<input type="hidden" name="cmd" id="cmd" value="approve_order" />
<input type="hidden" name="order_total" id="order_total" value="<?=$order_total?>" />
<input type="hidden" name="city2" id="city2" value="<?=$rsr['rcity'];?>" />
<input type="hidden" name="zip2" id="zip2" value="<?=$rsr['zip'];?>" />


<table style="margin-top:10px;line-height:28px;">

<tr>
<td class="t22">Service Provider</td>
<td class="t22"><?=$rsr['name'];?></td>
</tr>

<tr>
<td class="t22">*Est. Delivery Time</td>
<td class="t22"><? $ed = $rsr['servicetime'] + 5; $ed = "+" . $ed . " minutes"; echo date("g:i A", strtotime($ed)); ?></td>
</tr>

<tr>
<td style="width:150px;" class="t22"><?=$GLOBALS['order_type']?></td>
<td style="padding-top:10px;"><select name="order_type" id="order_type" class="input-text" style="width:203px;">
<? 
/* onchange="setOrderType(this.value)" */

$ot=0;
$last_ot="";
$order_types=unserialize($rsr['order_types']);
$getRss= mysql_query("SELECT * FROM order_types order by need_address desc,order_type asc");
while ($rss = mysql_fetch_array($getRss)) {
    if (in_array($rss['id'],$order_types)) {
        $ot++;
        $last_ot=$rss['order_type'];
        
?>
<option value="<?=$rss['order_type']?>"><?=$rss['order_type']?></option>
<? } 
}?>
</select></td>
</tr>
<tr>
<td class="t22"><?=$GLOBALS['payment_type']?></td>
<td><select name="paymenttype" id="paymenttype" style="width:203px;" class="input-text" onchange="showcc(this.value);">
<option value=""><?=$GLOBALS['please_select']?></option>
<? 
$payment_types=explode("|",$rsr['paymenttypes']);
foreach ($payment_types as $key=>$val) {
?>
<option value="<?=$val;?>"><?=$val;?></option>
<? } ?>
</select></td>
</tr>

<tr class="tr_delivery">
<td colspan="2" style="font-weight:bold;" class="t22"><?=$GLOBALS['delivery_address']?></td>
</tr>

<tr class="tr_delivery">
<td style="width:150px;" class="t22"><?=$GLOBALS['addresses']?></td>
<td style="height:30px;"><select name="address_id" id="address_id" class="input-text" style="width:203px;" onchange="setAddress(this.value);">
<option value=""><?=$GLOBALS['new_address']?></option>
<?
$getRss= mysql_query("SELECT * FROM delivery_addresses where userid=".$_SESSION['memberid']." order by nick asc");
while ($rss = mysql_fetch_array($getRss)) {
?>
<option value="<?=$rss['id']?>"><?=$rss['nick']?></option>
<? } ?>
</select> <span id="span_address_loading" style="display:none;"><img src="img/loading.gif"  /></span></td>
</tr>


<tr>
<td>Nickname</td>
<td><input type="text" name="nick" id="nick" value="" placeholder="Used to Save Address" style="width:185px;" maxlength="50" class="input-text" /></td>
</tr>

<tr>
<td>Name</td>
<td><input type="text" name="name" id="name" value="" style="width:185px;" maxlength="100" class="input-text" /></td>
</tr>


<tr>
<td>Mobile</td>
<td><input type="text" name="mobilphone" id="mobilphone" placeholder="10 Digit Mobile Number" value="" style="width:185px;" maxlength="50" class="input-text" /></td>
</tr>

<tr>
<td style="vertical-align:top;"><?=$GLOBALS['address']?></td>
<td><input type="text" name="address" id="address" value="" placeholder="Door no. / Building / Street" style="width:185px;" maxlength="50" class="input-text" /></td>

<?php 
$query_p = mysql_query("SELECT * FROM delivery_areas WHERE region='".$rsr['rcity']."' order by city asc"); ?>
<tr>
<td>Area</td><td>
        <select class="input-text" type="text" name="area" id="area" style="width:203px;"> 
        <option value="0">--- Select Area ---</option>
        <?php while($row = mysql_fetch_array($query_p)): ?>
<? $totalResults = getSqlNumber("SELECT da_id FROM rest_delivery_area where da_id='".$row['id']."' and rest_id='".$rest_id."'");
if ($totalResults) {
?>

<? if ( $_SESSION['myarea'] == $row['city'] ) { ?>
<option value="<?=$row['id'];?>"<? if ( $_SESSION['myarea'] == $row['city'] ) { echo " selected"; } ?>><?=$row['city'];?></option>
<? } ?>

<? } ?>
        <?php endwhile; ?>
        </select>
</td></tr>


<tr>
<td style="vertical-align:top;" class="t22"><?=$GLOBALS['order_note']?></td>
<td><textarea maxlength="120" placeholder="Max.Characters: 120" name="order_note" id="order_note" style="width:185px;height:70px;" class="input-text"></textarea></td>
</tr>


<tr>
<td></td><td style="height:30px;" class="t22">

<?
$ec=getSqlRow("select email from users where id='".$_SESSION['memberid']."'");
if ( $ec['email'] == "" )
{ echo "<br/>Update your <a href='/member_details.php?back=/approve.php'>Personal Information</a> to process order."; }
else
{
?>

<?
$s_a12=getSqlRow("SELECT id FROM delivery_areas WHERE region='".$_SESSION['mycity']."' AND city='".$_SESSION['myarea']."'");
$cr=getSqlRow("select min from rest_delivery_area where rest_id='".$rest_id."' and da_id='".$s_a12['id']."'");

$rest_isopen = getSqlNumber("SELECT id FROM rests where id=".$rest_id." and status=1");
$rsoc=getSqlRow("select * from site_timing where resid=".$rest_id." and dateday=".date('w')."");
if ($rest_isopen && checkRestHour($rsoc['open1'],$rsoc['close1'],$rsoc['open2'],$rsoc['close2'],$rsoc['open3'],$rsoc['close3'])) {
?>

<? if($_SESSION['cart_approve']==2) { ?>

<input name="sbt" id="sbt" class="vmenu" type="submit" style="width:175px;" value="CONFIRM ORDER" onclick='this.disabled=true;loading_order("span_loading",1); post("myform"); return false;'  /> &nbsp; <span id="span_loading"></span><br/><br/>
<a class="vclosed" style="width:146px;" href="<?=setRestUrl($rsr['id'],$rsr['name'])?>">UPDATE YOUR CART</a>

<? } else { ?>

<b><font color="red" style="padding-top:10px;"><a href="<?=setRestUrl($rsr['id'],$rsr['name'])?>" title="<?=$rsr['name']?>">
Minimum order <?=setPrice($cr['min']);?> <br/>Click here & add more products to your cart.</a>></font></b>
<? } ?>

<? } else { ?>

<font color="red" style="padding-top:10px;"><b>SERVICE PROVIDER CLOSED</b><br/>So, We can't process your order.</font>

<? } ?>

<? } ?>

</td>
</tr>


</table>

</form>
<br/><br/>

</div>
</div>
</div>
           
 
<? include "inc/footer.php"; 
if ($ot==1) {
?>
<script>
setOrderType('<?=$last_ot?>');
</script>
      <? }?>     
<div class="clearfix"></div>
</div>

</body>
</html>