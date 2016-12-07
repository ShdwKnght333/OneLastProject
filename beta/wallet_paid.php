<?php
include "conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Payment | <?php echo SITENAME?></title>
</head>
<body>
<!-- Page Content Start -->
<center> <h1>Redirecting .... </h1> </center>
<?php

//**********************************************************
// PayUMoney PAYMENT GATEWAY SETTINGS
//***********************************************************

$key = "JQrc5I";
$salt = "U9jUAkfm";

$hash="1";
$Rhash="0";
if(isset($_POST["mode"])&& isset($_POST["status"]) && isset($_POST["key"])&& isset($_POST["txnid"])&& isset($_POST["amount"])&& isset($_POST["productinfo"])&& isset($_POST["hash"])&& isset($_POST["PG_TYPE"])&& isset($_POST["mihpayid"])&& isset($_POST["bank_ref_num"])&&  isset($_POST["bank_ref_num"]))
{
////////////////////////////////////// Fetch Wallet Info from PayUmoney ////////////////////////////////////////////////////////////	

$mode= "PayU - " . $_POST["mode"]; 				// 	PAYMENT MODE
$payment_status=$_POST["status"];				   //   PAYMENT STATUS  -- success/failure/pending
$key=$_POST["key"]; 										   //   MERCHANT KEY provided by PayUMoney
$wallet_id=$_POST["txnid"];								//  MERCHANT Transaction ID
$credit=$_POST["amount"]; 								//  CREDIT AMOUNT send by merchant
$productinfo=$_POST["productinfo"]; 					//   PRODUCT INFO
$retrieved_hash=$_POST["hash"];						// RE-VERIFICATION HASH
$email=$_POST["email"];  									// EMAIL 
$card_name=$_POST["PG_TYPE"]; 				// CARD NAME 				,
$mihpayid=$_POST["mihpayid"];
$tracking_id=$_POST["payuMoneyId"];				// TRACKING ID 
$bank_ref_num=$_POST["bank_ref_num"];   //BANK REFERENCE NUMBER


///////////////////////////////////////  FETCH USER INFO /////////////////////////////
if(isset($_SESSION['memberid']))
{	
$user_id=$_SESSION['memberid'];   
$user = mysql_query("SELECT * FROM users where id='".$user_id."' ");	
$user_info  = mysql_fetch_array($user);
$email =$user_info['email'];
$phone=$user_info['mobilphone'];
$firstname=$user_info['name'];
$query = mysql_query("SELECT w_id FROM wallet WHERE userid='".$user_id."' order by w_id DESC LIMIT 1");
$row=mysql_fetch_array($query);
$wallet_id=$row['w_id']; 
}
///////////////////////////////////////  FETCH USER INFO /////////////////////////////

////////////////////////////////////// PAYUMONEY - FOODZONE VALIDATION ///////////////////////////////////////////////
 $hashSeq=$salt.'|'.$payment_status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$credit.'|'.$wallet_id.'|'.$key;
$hash = hash("sha512",$hashSeq); // Recalculate the hash for verification


if( $payment_status == 'success' && $hash == $retrieved_hash ) {
$current_timestamp = date('Y-m-d H:i:s');     // Transaction End Time
$result = mysql_query( "UPDATE wallet SET payment_status='1', tracking_id='".$tracking_id."', bank_ref_no='".$bank_ref_num."', payment_mode='".$mode."', card_name='".$card_name."', date='".$current_timestamp."' WHERE userid='".$user_id."' AND w_id='".$wallet_id."' ");
	echo "<center><img src='https://static.payu.in/images/ajax-loader-new.gif'></center>";
	echo "<center><h1>Your Transaction was Successful ! </h1></center>";
?>
<form name='frpaid' action='wallet.php' method='POST'>
<input type='hidden' name='paid' value='true'>
<input type='hidden' name='amount' value='<?php echo $credit; ?>'>
<input type='hidden' name='w_id' value='<?php echo $wallet_id; ?>'>
</form>
<script language='javascript'> document.frpaid.submit(); </script> 
<?php }// Successful Transaction 
else if( $payment_status == 'success' && $hash != $retrieved_hash ) {
$current_timestamp = date('Y-m-d H:i:s');     // Transaction End Time
$result = mysql_query( "UPDATE wallet SET payment_status='1', tracking_id='".$tracking_id."', bank_ref_no='".$bank_ref_num."', payment_mode='".$mode."', card_name='".$card_name."', date='".$current_timestamp."' WHERE userid='".$user_id."' AND w_id='".$wallet_id."' ");
	echo "<center><img src='https://static.payu.in/images/ajax-loader-new.gif'></center>";
	echo "<center><h1>Your Transaction was Successful ! </h1></center>";
?>
<form name='frpaid' action='wallet.php' method='POST'>
<input type='hidden' name='paid' value='true'>
<input type='hidden' name='amount' value='<?php echo $credit; ?>'>
<input type='hidden' name='w_id' value='<?php echo $wallet_id; ?>'>
</form>
<script language='javascript'> document.frpaid.submit(); </script> 
<?php } // Successful Transaction for different email address used in PayUmoney 
else if( $payment_status == "pending" &&  $hash == $retrieved_hash ){
$current_timestamp = date('Y-m-d H:i:s');  // Transaction End Time
$result = mysql_query( "UPDATE wallet SET payment_status='0', tracking_id='".$tracking_id."', bank_ref_no='".$bank_ref_num."', payment_mode='".$mode."', card_name='".$card_name."', date='".$current_timestamp."' WHERE userid='".$user_id."' AND w_id='".$wallet_id."' ");
	echo "<center><img src='https://static.payu.in/images/ajax-loader-new.gif'></center>";
	echo "<center><h1>Your Transaction is Pending for Approval ! </h1></center>";
	echo "<script language='javascript'> window.location= '".SITEURL."wallet.php';  </script>";  exit();
}// Non Successful Transaction
else if($payment_status == "pending" &&  $hash != $retrieved_hash)	{
	echo "<center><h1>Payment Error : Invalid Transaction ! </h1></center>";
echo "<script language='javascript'> window.location= '".SITEURL."wallet.php';  </script>";  exit();
}// FakeTransaction
	 else if( $payment_status == "failure"){
			echo "<center><img src='https://static.payu.in/images/ajax-loader-new.gif'></center>";
			echo "<center><h1>Payment Error : Transaction Failed to Complete , Please Try Again !</h1></center>";  
			echo "<script language='javascript'> window.location= '".SITEURL."wallet.php';  </script>";  exit();
	 } // FailedTransaction
}	
else{
		echo  "<center><h1> Security Error: Illegal Access Detected. </h1></center>";
		echo "<script language='javascript'> window.location= '".SITEURL."wallet.php';  </script>";  exit();
		exit();
}
	echo "<br><br>";
	
?>
<br/>
<div class="clearfix"></div>
</body>
</html>