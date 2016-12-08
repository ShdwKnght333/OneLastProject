<?
include "conf/config.php";
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

//***********************************
// PayUMoney PAYMENT GATEWAY SETTINGS

$key = "JQrc5I";
$salt = "U9jUAkfm";

$order_status=$_POST["status"];
$amount=$_POST["amount"];
$orderId=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$mihpayid=$_POST["mihpayid"];
$discount=$_POST["discount"];
$PG_TYPE=$_POST["PG_TYPE"];
$mode= "PayU - " . $_POST["mode"];
$bank_ref_num=$_POST["bank_ref_num"];
$discount=$_POST["discount"];
$payuMoneyId=$_POST["payuMoneyId"];


if( $discount == "" )
{ $paid_amount = $amount; }
else
{ $paid_amount = $amount - $discount; }


$op = getsqlrow("SELECT * FROM orders WHERE id='".$order_id."'");
$ouser = getsqlrow( "select email from users where id='".$op['userid']."'");
$rest_name = getsqlrow("SELECT name FROM rests WHERE id='".$op['resid']."'");
$left=$op['totalVouchers']-1;
$code=$op['coupon'];
mysql_query("UPDATE coupon SET totalVouchers=totalVouchers-1 WHERE voucherCode='".$code."'");
$productinfo = "Foodzoned.com";
$hashSeq = $key.'|'.$op['id'].'|'.$optotal.'|'.$productinfo.'|'.$op['name'].'|'.$ouser['email'].'|||||||||||'.$salt;
$hash = hash("sha512",$hashSeq);


if( $order_status == "success" && $hash = $posted_hash )
{

$odate = date( "Y-m-d H:i:s" );

mysql_query( "UPDATE orders SET status='2',orderdate='".$odate."',payment_status='1',tracking_id='".$payuMoneyId."',bank_ref_no='".$bank_ref_num."',payment_mode='".$mode."',card_name='".$PG_TYPE."',paid_amount='".$paid_amount."' WHERE id='".$orderId."'");

@include( DIR_PATH."conf/notifications.php" );

?>

<form name='frpaid' action='/orders.php' method='POST'>
<input type='hidden' name='paid' value='2'>
<input type='hidden' name='for' value='<?=$orderId?>'>
</form>
<script language='javascript'> document.frpaid.submit(); </script>

<?php

	}
	else if( $order_status == "pending" &&  $hash = $posted_hash )
	{

	mysql_query( "UPDATE orders SET tracking_id='".$payuMoneyId."',bank_ref_no='".$bank_ref_num."',payment_mode='".$mode."',card_name='".$PG_TYPE."',paid_amount='".$paid_amount."' WHERE id='".$orderId."'");

	echo "Thanks for ordering on Foodzoned! <br/>Your transaction is pending for payment approval. Contact our customer care for more details.";
	
	}
	 else if( $order_status == "failure" )
	{
?>


<form name='frpaid' action='/orders.php' method='POST'>
<input type='hidden' name='paid' value='1'>
<input type='hidden' name='for' value='<?=$orderId?>'>
</form>
<script language='javascript'> document.frpaid.submit(); </script>


<?php
	}
	else
	{
		echo "Security Error. Illegal access detected.";
	
	}

	echo "<br><br>";

?>

<br/>



<!-- Page Content End -->
</div>
<? include "inc/footer.php"; ?>
<div class="clearfix"></div>
</div>
</body>
</html>