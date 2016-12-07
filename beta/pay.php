<?php
include "conf/config.php";
checkLogin();
?>
<html>
<head>
<title>Payment Processing</title>
</head>
<body>
<center>
<?php

$order_id = $_REQUEST['order_id'];
$token = $_REQUEST['token'];
$_SESSION['orderid']=$order_id; // needs to be removed later 

$op = getsqlrow("SELECT * FROM orders WHERE id='".$order_id."' AND userid='".$_SESSION['memberid']."' AND payment_status='0' ");

// Reverify that , order is there or not 
if ( $token == md5($order_id) && $order_id == $op['id'] && $_REQUEST['make_payment']=="1" && $_REQUEST['paygate'] !== "" && $op['paymenttype'] == 'ONLINE PAYMENT'  )
{
			$oid =$order_id; // change this later
			$ouser = getsqlrow( "select email from users where id='".$_SESSION['memberid']."' ");
		   $rest_name = getsqlrow("SELECT name FROM rests WHERE id='".$op['resid']."' ");

if($op['fzwallet_Paid'] == 0)// Check if it is OnlinePayment 
{	
		$optotal = $op['order_total']-$op['fzDiscount'];
		$op_tax = ( $optotal / 100 ) * $fz_con_fee;
		$amount_payable = $optotal + $op_tax;
		
		$_SESSION['amountPayable']=$amount_payable;
}
else  if(isset($_REQUEST['remaining'])&& $_REQUEST['remaining'] == 'true' && $op['fzwallet_Paid'] != 0)// Check if it is FzWallet Remaining Payout
{
	$balance= getWalletBalance();
	if($balance>0){
					// Since even if it is FzWallet remaining is paid through on-line ,  Paid amount = $op['order_total']  + $op['con_fee'] for final calculations 
					$_SESSION['amountPayable']=$op['order_total']  + $op['con_fee'];
					$remaining = ($op['order_total']  + $op['con_fee'] )- $balance;
					$remaining = ceil($remaining); 
					if($remaining > 0 )
					{
						$amount_payable = $remaining;
					}
	}	
}
else 
{
	echo "Internal Error occurred , We could not process your order !";
}	

//*********************************************************************************
//  PAYUMONEY PROCESSING  [ STARTS HERE]
//*********************************************************************************

$key="JQrc5I"; 
$salt="U9jUAkfm";  


$redirect_url_success=SITEURL."paid.php"; 
$cancel_url = SITEURL."orders.php";


$_SESSION['firstname']=$op['name'];
$productinfo = "Foodzoned.com";
$hashSeq = $key.'|'.$oid.'|'.$amount_payable.'|'.$productinfo.'|'.$op['name'].'|'.$ouser['email'].'|||||||||||'.$salt;
$hash = hash("sha512",$hashSeq);

?>

<!-- Start gateway code -->

<h3>Transaction Processing...</h3>

<?php if ( $_REQUEST['paygate'] == "payu" ) { ?>

<form method="post" name="redirect" action="https://secure.payu.in/_payment"> 
<input type="hidden" name="surl" value="<?php echo $redirect_url_success; ?>">
<input type="hidden" name="furl" value="<?php echo $cancel_url; ?>">
<input type="hidden" name="hash" value="<?php echo $hash; ?>">
<input type="hidden" name="email" value="<?php echo $ouser['email']; ?>">
<input type="hidden" name="phone" value="<?php echo $op['mobilphone']; ?>">
<input type="hidden" name="firstname" value="<?php echo $op['name']; ?>">
<input type="hidden" name="productinfo" value="<?php echo $productinfo; ?>">
<input type="hidden" name="amount" value="<?php echo $amount_payable; ?>">
<input type="hidden" name="txnid" value="<?php echo $oid; ?>">
<input type="hidden" name="key" value="<?php echo $key; ?>">
<input type="hidden" name="service_provider" value="payu_paisa">
</form>

<script language='javascript'>document.redirect.submit();</script>

<?php  } else  {
echo "<h3>Invalid Transaction.</h3>";
}
//*********************************************************************************
//  PAYUMONEY PROCESSING  [ ENDS HERE]
//*********************************************************************************
}
?>

</body>
</html>