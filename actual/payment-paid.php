<?
include "conf/config.php";
?>

<?php include "conf/payment-crypto.php"; ?>

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


$rs_length = 15;
$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $rs_length);

	error_reporting(0);
	
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$working_key);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);

for($i = 0; $i < $dataSize; $i++) 
{
	$information=explode('=',$decryptValues[$i]);
	if($i==0) $orderId=$information[1];
	if($i==1) $tracking_id=$information[1];
	if($i==2) $bank_ref_no=$information[1];
	if($i==3) $order_status=$information[1];
	if($i==5) $payment_mode=$information[1];
	if($i==6) $card_name=$information[1];
	if($i==10) $paid_amount=$information[1];
}


	if($order_status==="Success")
	{

$odate = date( "Y-m-d H:i:s" );

mysql_query( "UPDATE orders SET status='2',orderdate='".$odate."',payment_status='1',tracking_id='".$tracking_id."',bank_ref_no='".$bank_ref_no."',payment_mode='".$payment_mode."',card_name='".$card_name."',paid_amount='".$paid_amount."' WHERE id='".$orderId."'");

@include( DIR_PATH."conf/notifications.php" );

?>

<form name='frpaid' action='/orders.php' method='POST'>
<input type='hidden' name='paid' value='2'>
<input type='hidden' name='for' value='<?=$orderId?>'>
</form>
<script language='javascript'> document.frpaid.submit(); </script>

<?php

	}
	else if($order_status==="Aborted")
	{

	mysql_query( "UPDATE orders SET tracking_id='".$tracking_id."',bank_ref_no='".$bank_ref_no."',payment_mode='".$payment_mode."',card_name='".$card_name."',paid_amount='".$paid_amount."' WHERE id='".$orderId."'");

	echo "Thanks for ordering on Foodzoned! <br/>Your transaction is pending for payment approval. Contact our customer care for more details.";
	
	}
	 else if($order_status==="Failure")
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
		echo "Security Error. Illegal access detected";
	
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