<?php
include "conf/config.php";
?>
<html>
<head>
<title>Transaction Processing</title>
</head>
<body>
<?php
//*********************************************************************************
// USER TRANSACTION CREDIT DETAILS 
//*********************************************************************************

// CHECK LOGIN 
if(isset($_SESSION['memberid'])&& $_SESSION['memberid']){
$user_id=$_SESSION['memberid'];                // USER INFO 
}
else 
{
	header("Location:".SITEURL."wallet.php"); /* Redirect browser */ exit(); 
}	
$credit=$_POST['amount']; 								// AMOUNT 
$debit=0; 															// DEBIT
$promo=$_POST['promocode']; 						// OPTIONAL

////////////////////////////////////// Fetch User Info ////////////////////////////////////////////////////////////
$user = mysql_query("SELECT * FROM users where id='".$user_id."' ");	
$user_info  = mysql_fetch_array($user);
$email =$user_info['email'];
$phone=$user_info['mobilphone'];
$firstname=$user_info['name'];
////////////////////////////////////// Fetch User Info ////////////////////////////////////////////////////////////	

$current_timestamp = date('Y-m-d H:i:s'); 		// TRANSACTION START TIME
$payment_status=0; 												// PAYMENT STATUS =0

////////////////////////////////////// Validation  ////////////////////////////////////////////////////////////
if(trim($credit)== ""){ header("Location:".SITEURL."wallet.php"); /* Redirect browser */ exit(); }
if(trim($credit)<= 0 ){ header("Location:".SITEURL."wallet.php"); /* Redirect browser */ exit(); }
////////////////////////////////////// Validation  ////////////////////////////////////////////////////////////

 //******************************************************************************
// USER TRANSACTION CREDIT DETAILS ----  [ ENDS HERE ]
//********************************************************************************
// -----------------------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------------------
//*********************************************************************************
//  PAYUMONEY PROCESSING 
//*********************************************************************************
if (isset($user_id)&& isset($credit)&& isset($email)&& isset($phone)&& isset($firstname))// some more conditions need to be added later 
{	
$transactionDescription="Amount has been received";
$result = mysql_query("INSERT INTO `wallet`(`w_id`, `userid`, `credit`, `debit`, `id`,`transactionDescription`,`date`, `promocode`, `tracking_id`, `bank_ref_no`, `payment_mode`, `card_name`, `payment_status`) VALUES (0,'".$user_id."',".$credit.",".$debit.",0,'".$transactionDescription."','".$current_timestamp."', '".$promo."',' ',' ',' ',' ',".$payment_status." )");
if($result )
{   
		 // get the last transaction id and send the last transaction id +1 to the payU money page
		$query = mysql_query("SELECT w_id FROM wallet WHERE userid='".$user_id."' order by w_id DESC LIMIT 1");
		$row=mysql_fetch_array($query);
		$wallet_id=$row['w_id']; 
 }
//*********************************************************
// PayUMoney PAYMENT GATEWAY SETTINGS
// *********************************************************
$key="JQrc5I";
$salt="U9jUAkfm";

$redirect_url_success= SITEURL."wallet_paid.php";  
$cancel_url = SITEURL."wallet.php";  

$productinfo = "Foodzoned.com";
$hashSeq = $key.'|'.$wallet_id.'|'.$credit.'|'.$productinfo.'|'.$firstname.'|'.$email.'|||||||||||'.$salt;
$hash = hash("sha512",$hashSeq);

?>
<!-- Start gateway code -->
<center><h3>Transaction Processing ...</h3></center>
<?php if ($hash ) { ?>

<form method="post" name="redirect" action="https://secure.payu.in/_payment">
<input type="hidden" name="key" value="<?php echo $key; ?>">
<input type="hidden" name="txnid" value="<?php echo $wallet_id; ?>">
<input type="hidden" name="amount" value="<?php echo $credit; ?>">
<input type="hidden" name="productinfo" value="<?php echo $productinfo; ?>">
<input type="hidden" name="firstname" value="<?php echo $firstname; ?>">
<input type="hidden" name="email" value="<?php echo $email; ?>">
<input type="hidden" name="phone" value="<?php echo $phone; ?>">
<input type="hidden" name="surl" value="<?php echo $redirect_url_success; ?>">
<input type="hidden" name="furl" value="<?php echo $cancel_url; ?>">
<input type="hidden" name="hash" value="<?php echo $hash; ?>">
<input type="hidden" name="service_provider" value="payu_paisa">
</form>
<script language='javascript'>document.redirect.submit();</script>  
<!-- End gateway code -->
<?php  } 
}
else{
echo "<h3>Invalid Transaction.</h3>";
}
//*********************************************************************************
//  PAYUMONEY PROCESSING  [ ENDS HERE]
//*********************************************************************************
?>
</body>
</html>