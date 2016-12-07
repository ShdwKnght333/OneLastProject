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
$key="JQrc5I"; // 
$salt="U9jUAkfm"; 
$hash="1";
$Rhash="0";
if(isset($_POST["mode"])&& isset($_POST["status"]) && isset($_POST["key"])&& isset($_POST["txnid"])&& isset($_POST["amount"])&& isset($_POST["productinfo"])&& isset($_POST["hash"])&& isset($_POST["PG_TYPE"])&& isset($_POST["mihpayid"])&& isset($_POST["bank_ref_num"]))
{
$mode= "PayU - " . $_POST["mode"]; // 			 Payment_mode
$payment_status=$_POST["status"]; // 			 Payment status -- success/failure/pending
$key=$_POST["key"]; //   			 							 Merchant key provided by PayUMoney
$orderID = $_POST["txnid"];//      						     Merchant Transaction ID
$orderid=$_SESSION['orderid']; // 						 Need to be changed or removed later
$amount=$_POST["amount"]; //     						 Original amount send by merchant
$productinfo=$_POST["productinfo"]; //      		 Product Info
$retrieved_hash=$_POST["hash"];//      	     	 For Re-Verification 
$email=$_POST["email"];  //       	     					 Email
$card_name=$_POST["PG_TYPE"]; //             Card_name
$discount=$_POST["discount"];  		// 					Discount for the order 			
$tracking_id=$_POST["payuMoneyId"];      //  	tracking id 
$bank_ref_num=$_POST["bank_ref_num"]; // Bank-ref-Number 


$user = msql_query("select * from users where id='".$_SESSION['memberid']."' ");
$user_info = mysql_fetch_array($user);
$firstname = $user_info['name'];
  
 $hashSeq=$salt.'|'.$payment_status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$orderID.'|'.$key;
$hash = hash("sha512",$hashSeq); // Recalculate the hash for verification

$amount = $_SESSION['amountPayable'];
if( $discount == "" )
{ $paid_amount = $amount; }
else
{ $paid_amount = $amount - $discount; }

if( $payment_status == 'success' && $hash == $retrieved_hash ) {
$current_timestamp = date('Y-m-d H:i:s'); // current time-stamp
$update1 = mysql_query( "UPDATE `orders` SET status='2',payment_status='1', tracking_id='".$tracking_id."', bank_ref_no='".$bank_ref_num."', payment_mode='".$mode."', card_name='".$card_name."', orderdate='".$current_timestamp."',paid_amount='".$paid_amount."' WHERE id='".$orderid."' ");
$update2 = mysql_query( "UPDATE `wallet` SET payment_status='1' WHERE id='".$orderid."' ");
	echo "<center><img src='https://static.payu.in/images/ajax-loader-new.gif'></center>";
	echo "<center><h1>Your Transaction was Successful ! </h1></center>";
@include( DIR_PATH."conf/notifications.php" ); 
?>
<form name='frpaid' action='finishorder.php' method='POST'>
<input type='hidden' name='paid' value='true'>
<input type='hidden' name='amount' value='<?php echo $amount; ?>'>
<input type='hidden' name='order_id' value='<?php echo $orderid; ?>'>
</form>
<script language='javascript'> document.frpaid.submit(); </script> 
<?php }
else if($payment_status == 'success' && $hash != $retrieved_hash)	{
	echo "<center><img src='https://static.payu.in/images/ajax-loader-new.gif'></center>";
	echo "<center><h1>Payment Error : Invalid Transaction ! </h1></center>"; ?>
	<form name='frpaid' action='orders.php' method='POST'>
<input type='hidden' name='paid' value='false'>
<input type='hidden' name='amount' value='<?php echo $amount; ?>'>
<input type='hidden' name='order_id' value='<?php echo $orderid; ?>'>
</form>
<script language='javascript'> document.frpaid.submit(); </script>
	
<?php }
else if( $payment_status == "pending" &&  $hash == $retrieved_hash ){
$current_timestamp = date('Y-m-d H:i:s'); // current time-stamp
$update1 = mysql_query( "UPDATE `orders` SET status='1',payment_status='0', tracking_id='".$tracking_id."', bank_ref_no='".$bank_ref_num."', payment_mode='".$mode."', card_name='".$card_name."', orderdate='".$current_timestamp."',paid_amount='".$paid_amount."' WHERE id='".$orderid."' ");
$update2 = mysql_query( "UPDATE `wallet` SET payment_status='0' WHERE id='".$orderid."' ");

	echo "<center><img src='https://static.payu.in/images/ajax-loader-new.gif'></center>";
	echo "<center><h1>Your Transaction is Pending for Approval ! </h1></center>";  ?>
<form name='frpaid' action='orders.php' method='POST'>
<input type='hidden' name='paid' value='false'>
<input type='hidden' name='amount' value='<?php echo $amount; ?>'>
<input type='hidden' name='order_id' value='<?php echo $orderid; ?>'>
</form>
<script language='javascript'> document.frpaid.submit(); </script>
<?php }
else if($payment_status == "pending" &&  $hash != $retrieved_hash)	{
	echo "<center><h1>Payment Error : Invalid Transaction ! </h1></center>";  ?>
	<form name='frpaid' action='orders.php' method='POST'>
<input type='hidden' name='paid' value='false'>
<input type='hidden' name='amount' value='<?php echo $amount; ?>'>
<input type='hidden' name='order_id' value='<?php echo $orderid; ?>'>
</form>
<script language='javascript'> document.frpaid.submit(); </script>	
<?php }
	 else if( $payment_status == "failure"){
			echo "<center><img src='https://static.payu.in/images/ajax-loader-new.gif'></center>";
			echo "<center><h1>Payment Error : Transaction Failed to Complete , Please Try Again !</h1></center>";   ?>
 <form name='frpaid' action='orders.php' method='POST'>
<input type='hidden' name='paid' value='false'>
<input type='hidden' name='amount' value='<?php echo $amount; ?>'>
<input type='hidden' name='order_id' value='<?php echo $orderid; ?>'>
</form>
<script language='javascript'> document.frpaid.submit(); </script>
<?php }
}	
else{
		echo  "<center><h1> Security Error: Illegal Access Detected. </h1></center>";
	echo "<script language='javascript'> window.location= ".SITEURL."index.php'; </script>";
		exit();
}
	echo "<br><br>";
	
?>
<br/>
<div class="clearfix"></div>
</body>
</html>