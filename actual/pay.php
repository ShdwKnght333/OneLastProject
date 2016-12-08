<?
include "conf/config.php";
checkLogin();
?>

<html>
<head>
<title>Payment Processing</title>
</head>
<body>
<center>

<?

$order_id = $_REQUEST['order_id'];
$token = $_REQUEST['token'];

$op = getsqlrow("SELECT * FROM orders WHERE id='".$order_id."' AND userid='".$_SESSION['memberid']."' AND payment_status='0'");
$ouser = getsqlrow( "select email from users where id='".$_SESSION['memberid']."'");
$rest_name = getsqlrow("SELECT name FROM rests WHERE id='".$op['resid']."'");

if ( $token == md5($order_id) && $order_id == $op['id'] && $_REQUEST['make_payment']=="1" && $_REQUEST['paygate'] !== "" )
{
$optotal = $op['order_total']-$op['fzDiscount'];
$op_tax = ( $op['order_total'] / 100 ) * $fz_con_fee;
$optotal = $optotal + $op_tax;

//***********************************
// PayUMoney PAYMENT GATEWAY SETTINGS

$key="JQrc5I";
$salt="U9jUAkfm";

$redirect_url_1 = SITEURL . "payment-paid-payu.php";
$redirect_url_2 = SITEURL . "payment-paid.php";
$cancel_url = SITEURL . "orders.php";

$productinfo = "Foodzoned.com";
$hashSeq = $key.'|'.$op['id'].'|'.$optotal.'|'.$productinfo.'|'.$op['name'].'|'.$ouser['email'].'|||||||||||'.$salt;
$hash = hash("sha512",$hashSeq);

?>

<!-- Start gateway code -->

<h3>Transaction Processing...</h3>

<? if ( $_REQUEST['paygate'] == "payu" ) { ?>

<form method="post" name="redirect" action="https://secure.payu.in/_payment">
<input type="hidden" name="surl" value="<?php echo $redirect_url_1; ?>">
<input type="hidden" name="furl" value="<?php echo $cancel_url; ?>">
<input type="hidden" name="hash" value="<?php echo $hash; ?>">
<input type="hidden" name="email" value="<?php echo $ouser['email']; ?>">
<input type="hidden" name="phone" value="<?php echo $op['mobilphone']; ?>">
<input type="hidden" name="firstname" value="<?php echo $op['name']; ?>">
<input type="hidden" name="productinfo" value="<?php echo $productinfo; ?>">
<input type="hidden" name="amount" value="<?php echo $optotal; ?>">
<input type="hidden" name="txnid" value="<?php echo $op['id']; ?>">
<input type="hidden" name="key" value="<?php echo $key; ?>">
<input type="hidden" name="service_provider" value="payu_paisa">
</form>

<script language='javascript'>document.redirect.submit();</script>

<? } else { ?>

<?php 

include "conf/payment-crypto.php";
error_reporting(0);
	
$merchant_data = "";
$merchant_data.= 'merchant_id'.'='.$merchant_id.'&';
$merchant_data.= 'redirect_url'.'='.$redirect_url_2.'&';
$merchant_data.= 'cancel_url'.'='.$cancel_url.'&';
$merchant_data.= 'order_id'.'='.$op['id'].'&';
$merchant_data.= 'amount'.'='.$optotal.'&';
$merchant_data.= 'currency'.'='.'INR'.'&';
$merchant_data.= 'language'.'='.'EN'.'&';
$merchant_data.= 'billing_email'.'='.$ouser['email'].'&';
$merchant_data.= 'billing_name'.'='.$op['name'].'&';
$merchant_data.= 'billing_tel'.'='.$op['mobilphone'].'&';
$merchant_data.= 'billing_address'.'='.$op['address'].'&';
$merchant_data.= 'billing_city'.'='.$op['city'].'&';
$merchant_data.= 'billing_zip'.'='.$op['postcode'].'&';
$merchant_data.= 'billing_state'.'='.'KARNATAKA'.'&';
$merchant_data.= 'billing_country'.'='.'India'.'&';

	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.

?>

<form method="post" name="redirect2" action="http://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>

<script language='javascript'>document.redirect2.submit();</script>


<? } ?>

<!-- End gateway code -->

<?
}
else
{
echo "<h3>Invalid Transaction.</h3>";
}
?>

</body>
</html>