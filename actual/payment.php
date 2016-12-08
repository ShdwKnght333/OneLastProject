<?
	include "conf/config.php";
	checkLogin();
?>

<?php 
	include "conf/payment-crypto.php";
	include "coupon.php";
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Payment | <?=SITENAME?></title>

<? include "inc/styles.php"; ?>
</head>
<body>
<div class="mainbody">
<? include "inc/header.php"; ?>
<div id="content">
<!-- Page Content Start -->

<h1>Payment</h1>

<?php

$oid=$_REQUEST['oid'];
$op = getsqlrow("SELECT * FROM orders WHERE id='".$oid."' AND userid='".$_SESSION['memberid']."'");

$redirect_url = SITEURL . "payment-paid.php";
$cancel_url = SITEURL . "orders.php";

if ( !$_REQUEST['oid'] == "0" && $oid == $op['id'] && $_REQUEST['token'] == md5($op['id']) && $op['payment_status'] == "0" )
{
$ouser = getsqlrow( "select email from users where id='".$_SESSION['memberid']."'");
$rest_name = getSqlField("SELECT name FROM rests WHERE id='".$op['resid']."'");
//Get Subtotal and Total
$discount=$op['fzDiscount'];
$cost=$op['sub_total'];
$output='';
if(isset($_POST['submitcoupon']))
	$discount=validVoucher($_POST['coupon'],$cost,$oid,$op['fzDiscount'],$op['city'],$op['userid'],$output);
$optotal=$op['order_total']-$discount;
$op_tax = ( $op['order_total'] / 100 ) * $fz_con_fee;
$optotal = $optotal + $op_tax;

?>
<table class="fonrm_table">

<tr><td style="width:130px;" class="t22">Order ID</td><td>#<?=$op['id']?><br/><br/></td></tr>

<tr><td class="t22">Name</td><td><?=$op['name']?><br/></td></tr>
<tr><td class="t22">Mobile</td><td><?=$op['mobilphone']?><br/><br/></td></tr>

<tr><td class="t22">Service Provider</td><td><?=$rest_name?><br/><br/></td></tr>

<tr><td class="t22">Order Details</td><td>
<? $order_details="";
$getRsd = mysql_query("SELECT * FROM order_details where orderid=".$op['id']." order by id asc");
	while ($rsd = mysql_fetch_array($getRsd)) {
		$prod = getSqlField("SELECT name FROM products WHERE id=".$rsd['prodid']."","name");
		$order_details.="- ".$rsd['qty']." x ".$prod." [".setPrice($rsd['price'])."]<br />";
		if ($rsd['optionals']) $order_details.="".$rsd['optionals']." ";
	}
	echo $order_details;
	?>
<br/></td></tr>


<tr><td class="t22">Subtotal</td><td><?=setprice($op['order_total']-$discount)?><br/></td></tr>
<tr><td class="t22">Taxes</td><td><?=setprice($op['tax_total'])?><br/></td></tr>
<tr><td class="t22">Delivery charge</td><td><?=setprice($op['service_fee'])?><br/></td></tr>
<tr><td class="t22">Convenience Fee</td><td><?=setprice($op_tax)?><br/></td></tr>
<tr><td class="t22"><b>Total Amount</b></td><td><b><?=setprice($optotal)?></b><br/><br/></td></tr>
<form name="couponform" method="post" action="payment.php">
<input type="hidden" name="oid" id="order_id" value="<?=$_REQUEST['oid']?>" readonly="true" />
<input type="hidden" name="token" id="token" value="<?=$_REQUEST['token']?>" readonly="true" />

<tr><td class="t22">Coupon</td><td><input name="coupon" class="input-text" placeholder="Enter Coupon Code Here" style="width:185px;" type="text" /></td>
<td><input name="submitcoupon" type="submit" class="vmenu" style="width:100px;" value="APPLY" /></td></tr>
<tr><td></td><td><center><? echo $output ?></center>
</td></tr>
</form>

<form id="myform" name="myform" method="post" action="pay.php">
<input type="hidden" name="order_id" id="order_id" value="<?=$op['id']?>" readonly="true" />
<input type="hidden" name="token" id="token" value="<?=$_REQUEST['token']?>" readonly="true" />
<input type="hidden" name="make_payment" id="order_id" value="1" readonly="true" />
<tr><td class="t22"><b>Payment via</b></td><td>
<table style="width:200px;border-collapse: separate;border-spacing: 0px 10px;">
<tr style="background:#fff;">
	<td style="vertical-align:top;padding:8px;"><input type="radio" id="payu" name="paygate" value="payu" checked="checked"></td>
	<td><img src="/img/payumoney.jpg" for="payu"><br><small>Visa/Mastercard/Netbanking</small></td>
</tr>
</table>
<br>
</td></tr>
<tr><td ></td>
<td style="height:30px;">
<input name="sbt" id="sbt" class="vmenu" style="width:200px;" type="submit" value="MAKE PAYMENT" /></td></tr>
</form>
</table>
<?php
}
else if ( $op['payment_status'] == "1" && $_REQUEST['token'] == md5($op['id']) )
{
echo "You already paid for your order #".$op['id']."<br/>Go to <a href='/orders.php'>My Orders</a>.";
}
else
{
echo "No order selected, Go to <a href='/orders.php'>My Orders</a>.";
}
?>

<br/>

<!-- Page Content End -->
</div>
<? include "inc/footer.php"; ?>
<div class="clearfix"></div>
</div>
</body>
</html>