<?php

include( "config.php" );
$cmd = safe( $_REQUEST['cmd'] );
 
if ( $cmd == "find_restaurants" )
{
    if ( !$_REQUEST['city'] )
    {
        echo "<script> swal('Select your City!'); </script>";
    }
    else if ( !$_REQUEST['area'] )
    {
        echo "<script> swal('Select your Area!'); </script>";
    }
    else if ( !$_REQUEST['service'] )
    {
        echo "<script> swal('Select Service Type!'); </script>";
    }
    else
    {
        echo "<script> window.location = './services.php?service=".$_REQUEST['service']."&city=".$_REQUEST['city']."&area=".$_REQUEST['area']."' ; </script>";
    }
}
// This might be required later 
if ( $cmd == "age_verification" )
{
    if ( !$_REQUEST['city'] )
    {
        echo "<script> enable('sbt_loc'); swal('Select your Area!'); </script>";
    }
    else
    {
        $_SESSION['myage'] = "1";
        echo "<script> location.reload(); </script>";
    }
}

if ( $cmd == "send_contact" )
{
    if (!$_REQUEST['email'] )
    {
        echo "<script> swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script> swal('Invalid email address.'); </script>";
    }
    else if (!$_REQUEST['name'] )
    {
        echo "<script> swal('Enter your name.'); </script>";
    }
    else if (!$_REQUEST['mobile'] )
    {
        echo "<script>swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobile']) || strlen($_REQUEST['mobile']) < "10" || strlen($_REQUEST['mobile']) > "10" || $_REQUEST['mobile'] == "0000000000" )
    {
        echo "<script>swal('Invalid mobile number.'); </script>";
    }
    else if (!$_REQUEST['city'] )
    {
        echo "<script> swal('Select your city.'); </script>";
    }
    else if (!$_REQUEST['subject'] )
    {
        echo "<script> swal('Enter subject.'); </script>";
    }
    else if (!$_REQUEST['message'] )
    {
        echo "<script> swal('Message is empty.'); </script>";
    }
    else if ( $_SESSION['security_code'] != $_REQUEST['captcha'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid verification code.'); </script>";
    }
    else
    {
        $sender =SITE_EMAIL;
        $to = SITE_SUPPORT;
        $reply = $_REQUEST['email'];
        $subject = $_REQUEST['name']." | Contact Form ".SITENAME;
        $msg = "<b>From :</b> ".$_REQUEST['name']."<br/><br/><b>Email :</b> ".$_REQUEST['email']."<br/><br/><b>Mobile :</b> ".$_REQUEST['mobile']."<br/><br/>";
	if($_REQUEST['orderid']) { $msg .= "<b>Order ID :</b> ".$_REQUEST['orderid']."<br/><br/>"; }
	$msg .= "<b>City :</b> ".$_REQUEST['city']."<br/><br/><b>Subject :</b> ".$_REQUEST['subject']."<br/><br/><b>Message :</b> <br/>".nl2br( $_REQUEST['message'] )."<br/><br/>";

        $mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
        $mailheaders .= "Return-path: {$sender} <{$sender}>\n";
        $mailheaders .= "From: ".SITENAME." <{$sender}>\n";
        $mailheaders .= "Reply-To: ".$_REQUEST['email']."\n";
        $mailheaders .= "X-Mailer: php/".phpversion( )."\n";
        $mailheaders .= "X-Return-Path: {$sender}\n";
        @mail( @$to, @$subject, @$msg, @$mailheaders );
	    echo "<script>swal({ title: 'Good job!', text: 'Your message was Sent Successfully !', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ window.location.reload(1); }); </script>";
   }
}


if ( $cmd == "register" )
{
    if ( $_REQUEST['email_reg'] )
    {
        $check_email = getsqlnumber( "select id from users where email='".safe( $_REQUEST['email_reg'] )."'" );
    }
    if ( !$_REQUEST['email_reg'] )
    {
        echo "<script> swal('Enter your email.'); </script>";
    }
    else if ( $check_email )
    {
        echo "<script> swal('".$GLOBALS['alert_email_exist']."'); </script>";
    }

    else if (!filter_var($_REQUEST['email_reg'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script> swal('Invalid email address.'); </script>";
    }
    else if ( !$_REQUEST['name'] )
    {
        echo "<script>swal('Enter your name.'); </script>";
    }
    else if ( strlen($_REQUEST['name']) < "5" )
    {
        echo "<script> swal('Your name is too short!'); </script>";
    }
    else if ( !$_REQUEST['mobilphone'] )
    {
        echo "<script>swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobilphone']) || strlen($_REQUEST['mobilphone']) < "10" || strlen($_REQUEST['mobilphone']) > "10" || $_REQUEST['mobilphone'] == "0000000000" )
    {
        echo "<script>swal('Invalid mobile number.');</script>";
    }
    else if ( strlen($_REQUEST['password_reg']) < "5" )
    {
        echo "<script>swal('Your password is too short!'); </script>";
    }
    else if ( !$_REQUEST['password_reg'] )
    {
        echo "<script>swal('Enter your password.'); </script>";
    }
    else if ( !$_REQUEST['password_confirm'] )
    {
        echo "<script> swal('Confirm your password.'); </script>";
    }
    else if ( $_REQUEST['password_reg'] != $_REQUEST['password_confirm'] )
    {
        echo "<script> sweetAlert('Oops!','The password and confirmation password are different.','error'); </script>";
    }
    else if ( !$_REQUEST['approve'] && $_SESSION['security_code'] != $_REQUEST['captcha'] )
    {
        echo "<script>  swal('Invalid verification code.'); </script>";
    }
    else
    {
        $sql['name'] = $_REQUEST['name'];
        $sql['email'] = $_REQUEST['email_reg'];
        $sql['mobilphone'] = $_REQUEST['mobilphone'];
        $sql['password'] = md5( $_REQUEST['password_reg'] );
        $sql['regdate'] = date( "Y-m-d H:i:s" );

        $code = rand( 1000, 9999 );
	$code = md5( $code );
        $sql['verify'] = $code;
	$sender = SITE_EMAIL;
	$to = $_REQUEST['email_reg'];
	$subject = "Membership Verification";
	$msg = "<img src='".SITEURL."/img/email/mail-header-logo.png'><br/><br/><b>Hi " . $_REQUEST['name'] . ",</b><br/><b>Thank you for joining to Foodzoned.com</b><br/>To complete your registration and email verification please use the following address:";
	$msg .= "<br /><br /><a href='".SITEURL."member-details.php?fz=".$code."'>".SITEURL."member-details.php?fz=".$code."</a>";
	$msg .= "<br /><br /><b>TEAM FOODZONED</b>";
	$mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
	$mailheaders .= "Return-path: {$sender} <{$sender}>\n";
	$mailheaders .= "From: ".SITENAME." <{$sender}>\n";
	$mailheaders .= "Reply-To: ".$sender."\n";
	$mailheaders .= "X-Mailer: php/".phpversion( )."\n";
	$mailheaders .= "X-Return-Path: {$sender}\n";
	send_email( $to, $subject, $msg, $mailheaders );

   $newId = insert_sql( "users", $sql );

	echo "<script>swal({ title: 'Verification email sent!', text: 'We sent a verification link to your Email. Please check Inbox & Spam.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ window.location.reload(1);  }); </script>";

    }
}
// Used this feature or done using this new Foodzoned
if ( $cmd == "save_member" )
{

    if (isset($_REQUEST['email'] )&& $_REQUEST['email'] )
    {
        $check_email = getsqlnumber( "select id from users where email='".$_REQUEST['email']."' AND id <> '".$_SESSION['memberid']."'" );
    }

    if ( !$_REQUEST['email'] )
    {
        echo "<script> swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script>swal('Invalid email address.'); </script>";
    }
    else if ( $check_email )
    {
        echo "<script> swal('Email id already used!'); </script>";
    }
    else if ( !$_REQUEST['name'] )
    {
        echo "<script> swal('Enter your name.'); </script>";
    }
    else if ( isset($_REQUEST['mobilphone']) && !$_REQUEST['mobilphone'] )
    {
        echo "<script>swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobilphone']) || strlen($_REQUEST['mobilphone']) < "10" || strlen($_REQUEST['mobilphone']) > "10" || $_REQUEST['mobilphone'] == "0000000000" )
    {
        echo "<script>swal('Invalid mobile number.'); </script>";
    }
    else if ( isset($_REQUEST['gender'] ) && !$_REQUEST['gender'] )
    {
        echo "<script>swal('Select gender.'); </script>";
    }
    else if (isset($_REQUEST['city']) &&  !$_REQUEST['city'] )
    {
        echo "<script> swal('Select your city.'); </script>";
    }
    else
    {
        $sql['email'] = $_REQUEST['email'];
        if ( !$_REQUEST['dob'] ) { $sql['dob'] = $_REQUEST['mm'] . "/" . $_REQUEST['dd'] . "/" . $_REQUEST['yy']; }

        $sql['name'] = $_REQUEST['name'];
        $sql['mobilphone'] = $_REQUEST['mobilphone'];
        $sql['gender'] = $_REQUEST['gender'];
        $sql['city'] = $_REQUEST['city'];
        $sql['company'] = $_REQUEST['company'];
        $sql['phone'] = $_REQUEST['phone'];
        update_sql( "users", $sql, "id=".$_SESSION['memberid']."" );
     echo "<script>swal({ title: 'Good job!', text: 'Your address has been Successfully updated !', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ window.location.reload(1); }); </script>";
	}

    }

if ( $cmd == "change_pass" )
{
    if ( isset($_REQUEST['email']) && !$_REQUEST['email'] )
    {
        echo "<script>swal('Enter your email.'); </script>";
    }
    else if (isset($_REQUEST['password']) &&  !$_REQUEST['password'] )
    {
        echo "<script> swal('Enter your password.'); </script>";
    }
    else if ( isset($_REQUEST['password_confirm'])&&  !$_REQUEST['password_confirm'] )
    {
        echo "<script>swal('Confirm your password.'); </script>";
    }
    else if ( $_REQUEST['password'] != $_REQUEST['password_confirm'] )
    {
        echo "<script> sweetAlert('Oops!','The password and confirmation password are different.','error'); </script>";
    }
    else
    {
        $sql['password'] = md5( $_REQUEST['password'] );
        update_sql( "users", $sql, "id=".$_SESSION['memberid']."" );
		echo "<script>swal({ title: 'Good job!', text: 'Your Password has been Successfully updated ! ', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ window.location.reload(1); }); </script>";      
    }
}


if ( $cmd == "login" )
{
    if ( !$_REQUEST['email'] )
    {
        echo "<script> swal({ title: 'Enter your email'});  </script>";
    }
    else if ( !$_REQUEST['password'] )
    {
        echo "<script> swal('Enter your password.'); </script>";
    }
    else
    {
        $rs = getsqlrow( "select id,verify from users where email='".safe( $_REQUEST['email'] )."' and password='".md5( safe( $_REQUEST['password'] ) )."'" );
        if ( !$rs['verify'] == "" )
        {
       echo "<script> swal('Your email not verified!'); window.location.reload(1);</script>";
        }
        else if ( !$rs['id'] )
        {
            echo "<script> swal('Incorrect email or password.'); </script>";
        }
        else
        {
            $_SESSION['memberid'] = $rs['id'];
				if(isset( $_SESSION['memberid'] ))
				echo "<script>window.location.reload(1);</script>";
        }
    }
}
if ( $cmd == "send_pass" )
{
    if ( !$_REQUEST['email'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your email.'); </script>";
    }
    else if ( !$_REQUEST['captcha'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter verification code.'); </script>";
    }
    else if ( $_SESSION['security_code'] != $_REQUEST['captcha'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid verification code.'); </script>";
    }
    else
    {
        $rs = getsqlrow( "select id,name,email from users where email='".safe( $_REQUEST['email'] )."'" );
        if ( !$rs['id'] )
        {
            echo "<script> enable('sbt'); loading('span_loading',0); swal('No account found!'); </script>";
        }
        else
        {
            $code = rand( 10000, 99999 );
            $code = md5( $code );
            mysql_query( "update users set forgot_pass='".$code."' where id=".$rs['id']."" );
            $sender = SITE_EMAIL;
            $to = $rs['email'];
            $subject = "Forgot Password";
            $msg = "<img src='".SITEURL."/img/email/mail-header-logo.png'><br/><br/><b>Hi " . $rs['name'] . ",</b><br /> To reset your password, please go to the following link:";
            $msg .= "<br /><br /><a href='".SITEURL."member-details.php?fp=".$code."'>".SITEURL."member-details.php?fp=".$code."</a><br/><br/><b>TEAM FOODZONED</b>";
            $mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
            $mailheaders .= "Return-path: {$sender} <{$sender}>\n";
            $mailheaders .= "From: ".SITENAME." <{$sender}>\n";
            $mailheaders .= "Reply-To: ".$sender."\n";
            $mailheaders .= "X-Mailer: php/".phpversion( )."\n";
            $mailheaders .= "X-Return-Path: {$sender}\n";
            send_email( $to, $subject, $msg, $mailheaders );
  echo "<script> swal({ title: 'Reset link sent!', text: 'Please check your email Inbox & Spam folder.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ window.location.reload(1);  }); </script>";
        }
    }
}
// Used this feature or done using this new Foodzoned
if(isset($_SESSION['FZform_token'])&& $cmd == "place_order_".$_SESSION['FZform_token'])
{
		$cart_error = 0; // No Error
		$rest_id = getwhere("cart", "rest_id", "session_id='".session_id( )."'" );
		$session_id=session_id();
		
		$CartInfo= mysql_query("SELECT * FROM cart where session_id='".$session_id."' and rest_id=".$rest_id." order by added_date asc");	
		
	while ($rss = mysql_fetch_array($CartInfo)) {
	
		$rsp=getSqlRow("select * from products where id=".$rss['prod_id']." ");
		
		if ( $rsp['stock'] == "2" && $rss['qty'] > $rsp['stock_qty'] )
			{ $cart_error = 1; }// Out-of Stock Error
	}
	
	if ( $cart_error == 1 ){
        echo "<script> sweetAlert('Check your Cart!','Some Products are Limited in Stock','warning'); </script>";
    }
	else if(!(isset($_REQUEST['deliveryType']))){
		echo "<script> sweetAlert('Delivery Type Not Set','Set your order Delivery Type','warning'); </script>";
	}
	else if ( isset($_SESSION['orderNote']) && strlen($_SESSION['orderNote']) > 120 ){
            echo "<script>swal('Order note maximum 120 characters allowed.'); </script>";
        }
	else {
		
			// Fetch all the Information from the Restaurant 
			$rest_tax = getval( "rests", "rest_tax", $rest_id ); 
            $discount = getval( "rests", "discount", $rest_id );  
            $dis_min = getval( "rests", "dis_min", $rest_id ); 
            $fz_comm = getval( "rests", "fz_comm", $rest_id );
            $fz_delivery_type = getval( "rests", "delivery_type", $rest_id );
			$zip=getval( "rests", "zip", $rest_id );

			// Basic information about the orders 
            $sql['userid'] = $_SESSION['memberid'];
            $sql['resid'] = $rest_id;
            $sql['orderdate'] = date( "Y-m-d H:i:s" );
            $sql['order_type'] =$_REQUEST['deliveryType'];
			$sql['postcode'] = $zip;
			if(isset($_SESSION['orderNote']) ){
			 $sql['order_note'] =$_SESSION['orderNote'];   
			 unset($_SESSION['orderNote']); 
			 }
            $sql['site_service'] = getval( "rests", "site_service", $rest_id );
			$sql['payment_status'] = 0;
			$sql['mobilphone'] = getval( "users", "mobilphone", $_SESSION['memberid'] );
			$sql['name'] = getval( "users", "name", $_SESSION['memberid'] );
			if(isset($_SESSION['mycity'])){ 
					$sql['city'] = $_SESSION['mycity'];
			  }		
			  else {
				  $sql['city'] = getval( "users", "city", $_SESSION['memberid'] );
			  }	    
			$orderId = insert_sql( "orders", $sql );
			
			
			// THIS CODE BELOW FILLS ALL THE BASIC AND EXTRA INFORMATION AVAILABLE TO THE ORDERS & ORDER_DETAILS TABLE IN DB 
			$tax_total=0;
			$order_total = 0;
			$discount_total=0;
			$extras_subtotal=0;
			
            $order_details = "";
            $smsorder_details = "";

            $getRss = mysql_query( "SELECT * FROM cart where session_id='".session_id( )."' order by added_date asc" );
            while ( $rss = mysql_fetch_array( $getRss ) )
            {
                unset( $sql );
                $rs = getsqlrow( "SELECT * FROM products WHERE id='".$rss['prod_id']."' " );
                $price = $rs['proprice'] == 0?$rs['price'] : $rs['proprice'];
                $price = $price * $rss['qty'];
                $optionals = "";
                $smsoptionals = "";
                $extras_total = 0;
                if ( $rss['extras'] )
                {
                    $opts = explode( ",", $rss['extras'] );
                    foreach ( $opts as $opt )
                    {
                        $rsss = getsqlrow( "SELECT price,optional FROM optionals WHERE id=".$opt."" );
                        $extras_total = $extras_total + $rsss['price'] * $rss['qty'];
                        $optionals .= "- ".$rss['qty']." x ".$rsss['optional']." [".setprice( $rsss['price'] * $rss['qty'] )."]<br />";
                        $smsoptionals .= "- ".$rsss['optional']." ";
                    }
                }
				// Add everything to the Order_details table 
                $sql['orderid'] = $orderId;
                $sql['userid'] = $_SESSION['memberid'];
                $sql['resid'] = $rest_id;
                $sql['prodid'] = $rss['prod_id'];
                $sql['qty'] = $rss['qty'];
                $sql['price'] = $price;
                $sql['extas_total'] = $extras_total;
                $sql['subtotal'] = $sql['price'] + $sql['extas_total'];
                $sql['extras'] = $rss['extras'];
                $sql['optionals'] = $optionals;
                $sql['stock_mgt'] = $rs['stock'];
			
				
				// Update the Stock 
                if ( $rs['stock'] == "2" ){
                $sqty_total = $rs['stock_qty'] - $rss['qty'];
				$update = mysql_query( "UPDATE products SET stock_qty=".$sqty_total." WHERE id=".$rss['prod_id']." and resid=".$rest_id."" );
                }

                $newId = insert_sql( "order_details", $sql );

				// Calculate Restaurant Tax
                if ( $rest_tax > 0 )
                {
                    $tax_total = $tax_total + number_format( $sql['subtotal'] * $rest_tax / 100, 2, ".", "" );
                    $tax_total = ceil($tax_total);
                }
			   // Order Details in the FZ-Admin Back-end Panel 
                $order_total = $order_total + $sql['subtotal'];
                $extras_subtotal = $extras_subtotal + $sql['extas_total'];
                $order_details .= "- ".$rss['qty']." x ".$rs['name']."<br/>";
                $order_details .= $optionals;
                $smsorder_details .= " - ".$rss['qty']."x".$rs['name']." ".$smsoptionals." ";
            }

			 // Calculate the Discount 
            if ( $discount > 0 ){ 
						if ( $order_total >= $dis_min ){ 
								$discount_total = number_format( $order_total * $discount / 100, 2, ".", "" ); 
					}
		   }
			// Calculate the final Order Invoice to be Paid  
            $total_amount = $order_total + $tax_total;
            $total_amount = $total_amount - $discount_total;
            $total_amount = round($total_amount);
            $fz_comm_total = number_format( ( $total_amount * $fz_comm ) / 100, 2, ".", "" );

			 
			
			// Update everything to Orders Table in the Database
            $update = mysql_query( "UPDATE orders SET tax_total='".$tax_total."',extras_total='".$extras_subtotal."',sub_total='".$order_total."', order_total='".$total_amount."',discount='".$discount_total."',orderdetails='".$order_details."',fz_fee='".$fz_comm_total."',delivery_type='".$fz_delivery_type."',smsorderdetails='".$smsorder_details."' WHERE id=".$orderId."" );
			
			// Placed order will be Unconfirmed Orders in the Review Order Page  
			mysql_query("UPDATE orders SET status = '3' WHERE id='".$orderId."'");
			
			// If Placed Order is of type Delivery then Delivery Fee will be added 
			 if($_REQUEST['deliveryType'] == 'Delivery')
			{
				$order = getSqlRow("select order_total,city from orders where id='".$orderId."' ");
				$daID=getSqlRow("SELECT id FROM delivery_areas WHERE region='".$order['city']."' AND city='".$_SESSION['myarea']."' ");
				$dfees=getSqlRow("select dfees from rest_delivery_area where rest_id='".$rest_id."' and da_id='".$daID['id']."' ");
				$order_total=$order['order_total']+$dfees['dfees']; 
				@mysql_query("UPDATE orders SET service_fee='".$dfees['dfees']."', order_total='".$order_total."' WHERE id='".$orderId."' ");
			}

// Start Creating Virtual Cart2 			
ob_start(); // turn on output buffering
include('virtualCart1.php');
$res = ob_get_contents(); // get the contents of the output buffer
ob_end_clean(); //  clean (erase) the output buffer and turn off output buffering	
$destination = "virtualCart2.php";
$file = fopen($destination, "w+");
fputs($file, $res);
fclose($file);	


			// Delete Everything from the cart since we have added everything to DB
			@mysql_query( @"delete from cart WHERE session_id='".@session_id( )."'" );
			// Redirect the User to check payment page .
			echo "<script>window.location ='check-payment.php?oid=".$orderId."&token=".md5($orderId)." ';</script>";
			
			// Delivery Address , Payment Type ,Coupon , Fz Con_fee , SMS DETAILS will be added later in the next page -->  check-payment.php  		
	}	
	
}
// Used this feature or done using this new Foodzoned
if(isset($_SESSION['FZform_token']) && $cmd ==  "confirm_order_".$_SESSION['FZform_token']){
	

	if(isset($_SESSION['order_id'])){
		$order = getSqlRow("select * from orders where id='".$_SESSION['order_id']."' ");
	}
	else {
		echo "<script>swal('Internal Error occurred, We couldn't process your order !'); </script>";
	}
	/* if($_SESSION['memberid'] == $order['userid'] )
	{
		echo "<script>swal('Unauthorized Accesss , We couldn't process your order !'); </script>";
	}*/	
	$balance=getWalletBalance();
	 if (isset($_REQUEST['PaymentType'])&&  !$_REQUEST['PaymentType'] )
    {
        echo "<script>swal('".$GLOBALS['alert_paymenttype']."'); </script>";
    }
	  else if ( isset($_REQUEST['PaymentType']) && ( !$_REQUEST['PaymentType'] ) )
    {
        echo "<script> swal('".$GLOBALS['alert_cc_name']."'); </script>";
    }
	  else if ( $order['order_type'] == 'Delivery' && isset($_REQUEST['nick'])&& isset($_REQUEST['address_id'])&&  !$_REQUEST['nick'] && !$_REQUEST['address_id'] )
	  {
        echo "<script> swal('Enter nickname for the address.'); </script>";
    }
	 else if ( $order['order_type'] == 'Delivery'  && isset($_REQUEST['name']) &&  !$_REQUEST['name'] )
	 {
        echo "<script> swal('Enter your name.'); </script>";
    }
	    else if ( $order['order_type'] == 'Delivery'  && isset($_REQUEST['mobilphone'])&&  !$_REQUEST['mobilphone'] )
	{
        echo "<script>  swal('Enter mobile number.'); </script>";
    }
    else if (  $order['order_type'] == 'Delivery'  && ( !is_numeric($_REQUEST['mobilphone']) || strlen($_REQUEST['mobilphone']) < "10" || strlen($_REQUEST['mobilphone']) > "10" || $_REQUEST['mobilphone'] == "0000000000" ) )
    {
        echo "<script> swal('Invalid mobile number.'); </script>";
    }
	  else if (  $order['order_type'] == 'Delivery' && isset($_REQUEST['address']) && !$_REQUEST['address'] )
    {
        echo "<script>  swal('Enter your Address.'); </script>";
    }
	else if ( $order['order_type'] == 'Delivery' && isset($_REQUEST['area'] )&& !$_REQUEST['area'] )	
    {
        echo "<script> swal('Select your Area.'); </script>";
    }
	else if ( $order['paymenttype']=='ONLINE PAYMENT' && $_REQUEST['PaymentType']==$_SESSION['FzWallet_token'] && $balance == 0 )	
    {
        echo "<script> sweetAlert('Zero Balance in Wallet','Add some money to your FzWallet ','warning'); </script>";
    }
    else
    {	
           if($order['order_type'] == 'Delivery'){		
			// Things to be added if there is Delivery 
			 $sql['userid'] = $_SESSION['memberid'];
			 $sql['nick'] = $_REQUEST['nick'];
			$sql['name'] = $_REQUEST['name'];
			$sql['mobilphone'] = $_REQUEST['mobilphone'];
			$sql['address'] = $_REQUEST['address'];
			$sql['postcode'] = $order['postcode'];
			$sql['city'] = $order['city'];
			update_sql( "delivery_addresses", $sql, "id=".safe( $_REQUEST['address_id'] )."" ); unset($sql);
		   }
			
			// Things need to be updated 
			  $order_date = date( "Y-m-d H:i:s" ); // Latest Date &Time when confirm Order is clicked
			 $name = $_REQUEST['name'];
             $mobile = $_REQUEST['mobilphone'];
             $address = $_REQUEST['address'] . ", " . getval( "delivery_areas", "city", $_REQUEST['area'] );
			 $update = mysql_query( "UPDATE orders SET name='".$name."' , mobilphone='".$mobile."' , address='".$address."' , orderdate='".$order_date."'  WHERE id='".$order['id']."' " );
			 
			 if($order['paymenttype'] == 'COD' && $order['fzwallet_Paid']==0 && $order['payment_status']==0 ) // COD
			 {
				 $result = mysql_query( "UPDATE orders SET status='2'  WHERE id='".$order['id']."' " );
				 echo "<form name='frpaid' action='finishorder.php' method='POST'><input type='hidden' name='paid' value='true'><input type='hidden' name='order_id' value='".$order['id']."'></form><script language='javascript'> document.frpaid.submit(); </script>";
			}
			else if($order['paymenttype'] == 'ONLINE PAYMENT' && $order['fzwallet_Paid']==0 && $order['payment_status']==0 )// PayUmoney 
			{
				 $result = mysql_query( "UPDATE orders SET status='1'  WHERE id='".$order['id']."' " );
				$token=md5($order['id']);
				
				// Submit And Go to Online-Payment 
				echo "<form id='payUmoney' name='payUmoney' method='post' action='pay.php'>
				<input type='hidden' name='order_id' id='order_id' value='".$order['id']."' readonly='true' />
				<input type='hidden' name='token' id='token' value='".$token."' readonly='true' />
				<input type='hidden' name='make_payment' id='order_id' value='1' readonly='true' />
				<input type='hidden' id='payu' name='paygate' value='payu'  />
				</form><script language='javascript'> document.payUmoney.submit(); </script>";
		     }
			else if($order['paymenttype'] == 'ONLINE PAYMENT' && $order['fzwallet_Paid']!=0 && $order['payment_status']==0 )// Fz Wallet
			{
				 $result = mysql_query( "UPDATE orders SET status='1'  WHERE id='".$order['id']."' " ); 
				if($balance>=0){
					$remaining = ($order['order_total']  + $order['con_fee'] )- $balance;
					$paid = $order['order_total']  + $order['con_fee'];
					if($remaining <= 0){
							$user_id=$_SESSION['memberid'];
							$transactionDescription="Paid to Order - ID  ".$order['id'];
							$current_timestamp = date('Y-m-d H:i:s'); 
							$payment_status=1;
							$update = mysql_query( "UPDATE orders SET status='2',payment_status='".$payment_status."',paid_amount='".$paid."'  WHERE id='".$order['id']."' " ); 
							$result = mysql_query("INSERT INTO `wallet`(`w_id`, `userid`, `credit`, `debit`, `id`,`transactionDescription`,`date`, `promocode`, `tracking_id`, `bank_ref_no`, `payment_mode`, `card_name`, `payment_status`) VALUES (0,'".$user_id."',0,'".$order['fzwallet_Paid']."', '".$order['id']."', '".$transactionDescription."', '".$current_timestamp."', ' ', ' ', ' ', ' ', ' ', '".$payment_status."' )");
							echo "<form name='frpaid' action='finishorder.php' method='POST'><input type='hidden' name='paid' value='true' readonly='true'><input type='hidden' name='order_id' value='".$order['id']."' readonly='true'></form><script language='javascript'> document.frpaid.submit(); </script>";
					}
					else if($remaining > 0 )
					{	
							$token=md5($order['id']);
							$user_id=$_SESSION['memberid'];
							$transactionDescription="Paid to Order - ID ".$order['id'];
							$current_timestamp = date('Y-m-d H:i:s'); 
							$payment_status=0;
							$result = mysql_query("INSERT INTO `wallet`(`w_id`, `userid`, `credit`, `debit`, `id`,`transactionDescription`,`date`, `promocode`, `tracking_id`, `bank_ref_no`, `payment_mode`, `card_name`, `payment_status`) VALUES (0,'".$user_id."',0,'".$order['fzwallet_Paid']."', '".$order['id']."', '".$transactionDescription."', '".$current_timestamp."', ' ', ' ', ' ', ' ', ' ', '".$payment_status."' )");
						
								// Pay remaining amount through Online
						echo "<form id='payUmoney' name='payUmoney' method='post' action='pay.php'>
									<input type='hidden' name='order_id' id='order_id' value='".$order['id']."' readonly='true' />
									<input type='hidden' name='remaining' id='fzwallet' value='true' readonly='true' />
									<input type='hidden' name='token' id='token' value='".$token."' readonly='true' />
									<input type='hidden' name='make_payment' id='order_id' value='1' readonly='true' />
									<input type='hidden' id='payu' name='paygate' value='payu'  />
									</form><script language='javascript'> document.payUmoney.submit(); </script>";
					}
			   }	
			}
			else 
			{
				echo "<script> swal('There is some Internal Error, We couldn't process your Payment !'); </script>";
			}	
			
	}// End of Else
}
// Used this feature or done using this new Foodzoned
if ( $cmd == "set_address" )
{
    if ( 0 < $_REQUEST['id'] )
    {
        $rss = getsqlrow( "SELECT * FROM delivery_addresses WHERE id=".safe( $_REQUEST['id'] )." and userid=".$_SESSION['memberid']."" );
    }
    echo "<script>";
    echo "$('#nick').val('".jsescape( $rss['nick'] )."');";
    echo "$('#name').val('".jsescape( $rss['name'] )."');";
    echo "$('#address').val('".jsescape( $rss['address'] )."');";
    echo "$('#postcode').val('".jsescape( $rss['postcode'] )."');";
    echo "$('#city').val('".jsescape( $rss['city'] )."');";
    echo "$('#mobilphone').val('".jsescape( $rss['mobilphone'] )."');";
    echo "$('#span_address_loading').hide();";
    echo "</script>";
    exit( );
}
if ( $cmd == "rate" )
{
    mysql_query( "update orders set speed=".safe( $_REQUEST['speed'] ).",service=".safe( $_REQUEST['service'] ).",taste=".safe( $_REQUEST['taste'] )." where id=".safe( $_REQUEST['id'] )."" );
    $resid = getval( "orders", "resid", safe( $_REQUEST['id'] ) );
    $rsh = getsqlrow( "SELECT avg(speed) as ort FROM orders WHERE resid=".$resid." and speed>0" );
    $rss = getsqlrow( "SELECT avg(service) as ort FROM orders WHERE resid=".$resid." and speed>0" );
    $rsl = getsqlrow( "SELECT avg(taste) as ort FROM orders WHERE resid=".$resid." and speed>0" );
    $data['speed'] = $rsh['ort'];
    $data['service'] = $rss['ort'];
    $data['taste'] = $rsl['ort'];
    $sql = update_sql( "rests", $data, "id=".$resid."" );
}
// Used this feature or done using this new Foodzoned
if ( $cmd == "save_address" )
{
    if (isset($_REQUEST['nick'])&&  !$_REQUEST['nick'] )
    {
        echo "<script> swal('Enter nickname for address.'); </script>";
        exit( );
    }
    if ( isset($_REQUEST['name']) && !$_REQUEST['name'] )
    {
        echo "<script>swal('Enter your name.'); </script>";
        exit( );
    }
    if (isset($_REQUEST['mobilphone']) &&  !$_REQUEST['mobilphone'] )
    {
        echo "<script> swal('Enter mobile number.'); </script>";
        exit( );
    }
    else if ( !is_numeric($_REQUEST['mobilphone']) || strlen($_REQUEST['mobilphone']) < "10" || strlen($_REQUEST['mobilphone']) > "10" || $_REQUEST['mobilphone'] == "0000000000" )
    {
        echo "<script>  swal('Invalid mobile number.'); </script>";
        exit( );
    }
    if ( isset($_REQUEST['address'])&& !$_REQUEST['address'] )
    {
        echo "<script>swal('Enter your address.'); </script>";
        exit( );
    }
    if ( isset($_REQUEST['city']) && !$_REQUEST['city'] )
    {
        echo "<script>swal('Select your city.'); </script>";
        exit( );
    }

    unset( $sql );
    $sql['userid'] = $_SESSION['memberid'];
    $sql['nick'] = $_REQUEST['nick'];
    $sql['name'] = $_REQUEST['name'];
    $sql['mobilphone'] = $_REQUEST['mobilphone'];
    $sql['address'] = $_REQUEST['address'];
    $sql['postcode'] = $_REQUEST['postcode'];
    $sql['city'] = $_REQUEST['city'];
    if ( !$_REQUEST['address_id'] )
    {
        $addressId = insert_sql( "delivery_addresses", $sql );
    }
    else
    {
        update_sql( "delivery_addresses", $sql, "id=".safe( $_REQUEST['address_id'] )."" );
    }
    	echo "<script>swal({ title: 'Good job!', text: 'Your address has been Successfully updated !  ', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ window.location.reload(1); }); </script>";      

}

if ( $cmd == "contact_ad" )
{

    if ( !$_REQUEST['name'] )
    {
        echo "<script>swal('Enter contact person name.'); </script>";
    }
    else if ( !$_REQUEST['company'] )
    {
        echo "<script> swal('Enter company name.'); </script>";
    }
    else if ( !$_REQUEST['mobile'] )
    {
        echo "<script>swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobile']) || strlen($_REQUEST['mobile']) < "10"  || strlen($_REQUEST['mobile']) > "10" || $_REQUEST['mobile'] == "0000000000" )
    {
        echo "<script> swal('Invalid mobile number.'); </script>";
    }
    else if ( !$_REQUEST['email'] )
    {
        echo "<script>swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script> swal('Invalid email address.'); </script>";
    }
    else if ( !$_REQUEST['city'] )
    {
        echo "<script>swal('Enter your city.'); </script>";
    }
    else if ( !$_REQUEST['message'] )
    {
        echo "<script> swal('Message is Empty!'); </script>";
    }
    else if ( !$_REQUEST['captcha'] )
    {
        echo "<script> swal('Enter verification code.'); </script>";
    }
    else if ( $_SESSION['security_code'] != $_REQUEST['captcha'] )
    {
        echo "<script> swal('Invalid verification code.'); </script>";
    }
    else
    {
        $sender = SITE_EMAIL;
        $to = SITE_EMAIL;
        $reply = $_REQUEST['email'];
        $subject = "Advertisement Form ".SITENAME." | ".$_REQUEST['company'];
        $msg = "<b>Contact Person :</b> ".$_REQUEST['name']."<br/><br/><b>Company :</b> ".$_REQUEST['company']."<br/><br/><b>Email :</b> ".$_REQUEST['email']."<br/><br/><b>Mobile :</b> ".$_REQUEST['mobile']."<br/><br/>";
	$msg .= "<b>City :</b> ".$_REQUEST['city']."<br/><br/><b>Message :</b> <br/>".nl2br( $_REQUEST['message'] )."<br/><br/>";

        $mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
        $mailheaders .= "Return-path: {$sender} <{$sender}>\n";
        $mailheaders .= "From: ".SITENAME." <{$sender}>\n";
        $mailheaders .= "Reply-To: ".$form['email']."\n";
        $mailheaders .= "X-Mailer: php/".phpversion( )."\n";
        $mailheaders .= "X-Return-Path: {$sender}\n";
        @mail( @$to, @$subject, @$msg, @$mailheaders );
        echo "<script>loading('span_loading',0); swal({ title: 'Thank You!', text: 'Your message was sent successfully.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ window.location.reload(1);  }); </script>";
    }
}

if ( $cmd == "suggest_rest" )
{

    if ( !$_REQUEST['rname'] )
    {
        echo "<script> swal('Enter service provider name.'); </script>";
    }
    else if ( !$_REQUEST['address'] )
    {
        echo "<script> swal('Enter service provider address.'); </script>";
    }
    else if ( !$_REQUEST['city'] )
    {
        echo "<script> swal('Enter Service provider City.'); </script>";
    }
    else if ( !$_REQUEST['name'] )
    {
        echo "<script> swal('Enter your name.'); </script>";
    }
    else if ( !$_REQUEST['email'] )
    {
        echo "<script>swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script>swal('Invalid email address.'); </script>";
    }
    else if ( !$_REQUEST['mobile'] )
    {
        echo "<script> swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobile']) || strlen($_REQUEST['mobile']) < "10" || strlen($_REQUEST['mobile']) > "10" || $_REQUEST['mobile'] == "0000000000" )
    {
        echo "<script>swal('Invalid mobile number.'); </script>";
    }
    else if ( !$_REQUEST['message'] )
    {
        echo "<script> swal('Comment box is Empty!'); </script>";
    }
    else if ( !$_REQUEST['captcha'] )
    {
        echo "<script> swal('Enter verification code.'); </script>";
    }
    else if ( $_SESSION['security_code'] != $_REQUEST['captcha'] )
    {
        echo "<script> swal('Invalid verification code.'); </script>";
    }
    else
    {
        $sender = SITE_EMAIL;
        $to = SITE_EMAIL;
        $reply = $_REQUEST['email'];
        $subject = "Service Provider Suggestion | ".$_REQUEST['rname'];
        $msg = "<b>Suggestion By :</b> ".$_REQUEST['name']."<br/><br/><b>Email :</b> ".$_REQUEST['email']."<br/><br/><b>Mobile :</b> ".$_REQUEST['mobile']."<br/><br/>";
	if($_REQUEST['city']) { $msg .= "<b>City :</b> ".$_REQUEST['city']."<br/><br/>"; }
	$msg .= "<b>Service :</b> ".$_REQUEST['rname']."<br/><br/><b>Address :</b> ".$_REQUEST['address']."<br/><br/><b>Message :</b> <br/>".nl2br( $_REQUEST['message'] )."<br/><br/>";

        $mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
        $mailheaders .= "Return-path: {$sender} <{$sender}>\n";
        $mailheaders .= "From: ".SITENAME." <{$sender}>\n";
        $mailheaders .= "Reply-To: ".$form['email']."\n";
        $mailheaders .= "X-Mailer: php/".phpversion( )."\n";
        $mailheaders .= "X-Return-Path: {$sender}\n";
        @mail( @$to, @$subject, @$msg, @$mailheaders );
        echo "<script>loading('span_loading',0); swal({ title: 'Thank You!', text: 'Your suggestion has been submitted successfully.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ window.location.reload(1);  }); </script>";
    }
}


if ( $cmd == "join_network" )
{

    if ( !$_REQUEST['name'] )
    {
        echo "<script>swal('Enter your name.'); </script>";
    }
    else if ( !$_REQUEST['phone'] )
    {
        echo "<script>swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['phone']) || strlen($_REQUEST['phone']) < "10" || strlen($_REQUEST['phone']) > "10" || $_REQUEST['phone'] == "0000000000" )
    {
        echo "<script>swal('Invalid mobile number.'); </script>";
    }
    else if ( !$_REQUEST['email'] )
    {
        echo "<script>swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script>swal('Invalid email address.'); </script>";
    }
    else if ( !$_REQUEST['rname'] )
    {
        echo "<script>swal('Enter service name.'); </script>";
    }
    else if ( !$_REQUEST['address'] )
    {
        echo "<script> swal('Enter service address.'); </script>";
    }
    else if ( !$_REQUEST['city'] )
    {
        echo "<script> swal('Enter your city.'); </script>";
    }
    else if ( !$_REQUEST['pincode'] )
    {
        echo "<script> swal('Enter your pincode.'); </script>";
    }
    else if ( !$_REQUEST['captcha'] )
    {
        echo "<script> swal('Enter verification code.'); </script>";
    }
    else if ( $_SESSION['security_code'] != $_REQUEST['captcha'] )
    {
        echo "<script> swal('Invalid verification code.'); </script>";
    }
    else
    {
        $sender = SITE_EMAIL;
        $to = SITE_EMAIL;
        $reply = $_REQUEST['email'];
        $subject = "Service Joining Form | ".$_REQUEST['rname'];
        $msg = "<b>Contact Person :</b> ".$_REQUEST['name']."<br/><br/><b>Email :</b> ".$_REQUEST['email']."<br/><br/><b>Mobile :</b> ".$_REQUEST['phone']."<br/><br/>";
		$msg .= "<b>Service :</b> ".$_REQUEST['rname']."<br/><br/><b>Address :</b><br/> ".$_REQUEST['address']."<br/><br/><b>City :</b> ".$_REQUEST['city']."<br/><br/><b>Pincode :</b> ".$_REQUEST['pincode']."<br/><br/>";

        $mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
        $mailheaders .= "Return-path: {$sender} <{$sender}>\n";
        $mailheaders .= "From: ".SITENAME." <{$sender}>\n";
        $mailheaders .= "Reply-To: ".$form['email']."\n";
        $mailheaders .= "X-Mailer: php/".phpversion( )."\n";
        $mailheaders .= "X-Return-Path: {$sender}\n";
        @mail( @$to, @$subject, @$msg, @$mailheaders );
        echo "<script> swal({ title: 'Thank You!', text: 'Your request has been submitted successfully.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ window.location.reload(1);  }); </script>";
    }
}

if ( $cmd == "feedback" )
{

    if ( !$_REQUEST['city'] )
    {
        echo "<script> swal('Select your city.'); </script>";
    }
    else if ( !$_REQUEST['name'] )
    {
        echo "<script> swal('Enter your name.'); </script>";
    }
    else if ( !$_REQUEST['email'] )
    {
        echo "<script> swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script>swal('Invalid email address.'); </script>";
    }
    else if ( !$_REQUEST['mobile'] )
    {
        echo "<script>  swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobile']) || strlen($_REQUEST['mobile']) < "10" || strlen($_REQUEST['mobile']) > "10" || $_REQUEST['mobile'] == "0000000000" )
    {
        echo "<script>  swal('Invalid mobile number.'); </script>";
    }
    else if ( $_REQUEST['type'] == "0" )
    {
        echo "<script>swal('Select feedback category.'); </script>";
    }
    else if ( !$_REQUEST['message'] )
    {
        echo "<script>swal('Your feedback is empty.'); </script>";
    }
    else if ( $_SESSION['security_code'] != $_REQUEST['captcha'] )
    {
        echo "<script> swal('Invalid verification code.'); </script>";
    }
    else
    {
        $sql['type'] = $_REQUEST['type'];
        $sql['name'] = $_REQUEST['name'];
        $sql['email'] = $_REQUEST['email'];
        $sql['mobile'] = $_REQUEST['mobile'];
        $sql['city'] = $_REQUEST['city'];
        $sql['message'] = $_REQUEST['message'];
        $sql['fdate'] = date( "Y-m-d H:i:s" );
        $sql['status'] = "0";
        $newId = insert_sql( "feedback", $sql );
	echo "<script>loading('span_loading',0); swal({ title: 'Thank You!', text: 'Your feedback has been submitted successfully.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){window.location.reload(1); });  </script>";
    }
}
exit( );

?>