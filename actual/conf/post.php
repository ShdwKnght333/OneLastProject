<?php

include( "config.php" );
$cmd = safe( $_REQUEST['cmd'] );

if ( $cmd == "find_restaurants" )
{
    if ( !$_REQUEST['city'] )
    {
        echo "<script> enable('find'); swal('Select your City!'); </script>";
    }
    else if ( !$_REQUEST['area'] )
    {
        echo "<script> enable('find'); swal('Select your Area!'); </script>";
    }
    else if ( !$_REQUEST['service'] )
    {
        echo "<script> enable('find'); swal('Select Service Type!'); </script>";
    }
    else
    {
        echo "<script> go('./services.php?service=".$_REQUEST['service']."&city=".$_REQUEST['city']."&area=".$_REQUEST['area']."'); </script>";
    }
}


if ( $cmd == "set_my_loc" )
{
    if ( !$_REQUEST['city'] )
    {
        echo "<script> document.getElementById('sbt_loc').style.display='block'; loading_bar('loc_loading',0); enable('sbt_loc'); swal('Select your City!'); </script>";
    }
    else if ( !$_REQUEST['area'] )
    {
        echo "<script> document.getElementById('sbt_loc').style.display='block'; loading_bar('loc_loading',0); enable('sbt_loc'); swal('Select your Area!'); </script>";
    }
    else
    {
        $_SESSION['mycity'] = $_REQUEST['city'];
        $_SESSION['myarea'] = $_REQUEST['area'];
        echo "<script> location.reload(); </script>";
    }
}

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
    if ( !$_REQUEST['email'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid email address.'); </script>";
    }
    else if ( !$_REQUEST['name'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your name.'); </script>";
    }
    else if ( !$_REQUEST['mobile'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobile']) || strlen($_REQUEST['mobile']) < "10" || strlen($_REQUEST['mobile']) > "10" || $_REQUEST['mobile'] == "0000000000" )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid mobile number.'); </script>";
    }
    else if ( !$_REQUEST['city'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Select your city.'); </script>";
    }
    else if ( !$_REQUEST['subject'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter subject.'); </script>";
    }
    else if ( !$_REQUEST['message'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Message is empty.'); </script>";
    }
    else if ( $_SESSION['security_code'] != $_REQUEST['captcha'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid verification code.'); </script>";
    }
    else
    {
        $sender = SITE_EMAIL;
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
        echo "<script>loading('span_loading',0); swal({ title: 'Good job!', text: 'Your message was sent successfully.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ go('./'); }); </script>";
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
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Enter your email.'); </script>";
    }
    else if ( $check_email )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('".$GLOBALS['alert_email_exist']."'); </script>";
    }

    else if (!filter_var($_REQUEST['email_reg'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Invalid email address.'); </script>";
    }
    else if ( !$_REQUEST['name'] )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Enter your name.'); </script>";
    }
    else if ( strlen($_REQUEST['name']) < "5" )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Your name is too short!'); </script>";
    }
    else if ( !$_REQUEST['mobilphone'] )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobilphone']) || strlen($_REQUEST['mobilphone']) < "10" || strlen($_REQUEST['mobilphone']) > "10" || $_REQUEST['mobilphone'] == "0000000000" )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Invalid mobile number.');</script>";
    }
    else if ( !$_REQUEST['dd'] || !$_REQUEST['mm'] || !$_REQUEST['yy'] )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Enter your date of birth.');</script>";
    }
    else if ( !$_REQUEST['gender'] == "1" || !$_REQUEST['gender'] == "2" )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Select your gender.'); </script>";
    }
    else if ( $_REQUEST['city'] == "0" )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Select your city.'); </script>";
    }
    else if ( strlen($_REQUEST['password_reg']) < "5" )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Your password is too short!'); </script>";
    }
    else if ( !$_REQUEST['password_reg'] )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Enter your password.'); </script>";
    }
    else if ( !$_REQUEST['password_confirm'] )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Confirm your password.'); </script>";
    }
    else if ( $_REQUEST['password_reg'] != $_REQUEST['password_confirm'] )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); sweetAlert('Oops!','The password and confirmation password are different.','error'); </script>";
    }
    else if ( !$_REQUEST['approve'] && $_SESSION['security_code'] != $_REQUEST['captcha'] )
    {
        echo "<script> enable('sbt_reg'); loading('span_loading_reg',0); swal('Invalid verification code.'); </script>";
    }
    else
    {
        $sql['name'] = $_REQUEST['name'];
        $sql['email'] = $_REQUEST['email_reg'];
        $sql['mobilphone'] = $_REQUEST['mobilphone'];
        $sql['city'] = $_REQUEST['city'];
        $sql['gender'] = $_REQUEST['gender'];
        $sql['password'] = md5( $_REQUEST['password_reg'] );
        $sql['regdate'] = date( "Y-m-d H:i:s" );
        $sql['dob'] = $_REQUEST['mm'] . "/" . $_REQUEST['dd'] . "/" . $_REQUEST['yy'];

        $code = rand( 1000, 9999 );
	$code = md5( $code );
        $sql['verify'] = $code;
	$sender = SITE_EMAIL;
	$to = $_REQUEST['email_reg'];
	$subject = "Membership Verification";
	$msg = "<img src='".SITEURL."/img/email/mail-header-logo.png'><br/><br/><b>Hi " . $_REQUEST['name'] . ",</b><br/><b>Thank you for joining to Foodzoned.com</b><br/>To complete your registration and email verification please use the following address:";
	$msg .= "<br /><br /><a href='".SITEURL."member_details.php?fz=".$code."'>".SITEURL."member_details.php?fz=".$code."</a>";
	$msg .= "<br /><br /><b>TEAM FOODZONED</b>";
	$mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
	$mailheaders .= "Return-path: {$sender} <{$sender}>\n";
	$mailheaders .= "From: ".SITENAME." <{$sender}>\n";
	$mailheaders .= "Reply-To: ".$sender."\n";
	$mailheaders .= "X-Mailer: php/".phpversion( )."\n";
	$mailheaders .= "X-Return-Path: {$sender}\n";
	send_email( $to, $subject, $msg, $mailheaders );

        $newId = insert_sql( "users", $sql );

	echo "<script>loading('span_loading',0); swal({ title: 'Verification email sent!', text: 'We sent a verification link to your Email. Please check Inbox & Spam.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ go('./'); }); </script>";

    }
}

if ( $cmd == "save_member" )
{

    if ( $_REQUEST['email'] )
    {
        $check_email = getsqlnumber( "select id from users where email='".$_REQUEST['email']."' AND id <> '".$_SESSION['memberid']."'" );
    }

    if ( !$_REQUEST['email'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid email address.'); </script>";
    }
    else if ( $check_email )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Email id already used!'); </script>";
    }
    else if ( !$_REQUEST['name'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your name.'); </script>";
    }
    else if ( !$_REQUEST['mobilphone'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobilphone']) || strlen($_REQUEST['mobilphone']) < "10" || strlen($_REQUEST['mobilphone']) > "10" || $_REQUEST['mobilphone'] == "0000000000" )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid mobile number.'); </script>";
    }
    else if ( !$_REQUEST['gender'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Select gender.'); </script>";
    }
    else if ( !$_REQUEST['city'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Select your city.'); </script>";
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

        echo "<script>enable('sbt'); loading('span_loading',0); swal('".$GLOBALS['alert_record_updated']."');";
            if ( $_REQUEST['back'] )
            { echo "go('".$_REQUEST['back']."');</script>"; }
            else
            { echo "go('./member.php');</script>"; }

    }
}

if ( $cmd == "change_pass" )
{
    if ( !$_REQUEST['email'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your email.'); </script>";
    }
    else if ( !$_REQUEST['password'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your password.'); </script>";
    }
    else if ( !$_REQUEST['password_confirm'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Confirm your password.'); </script>";
    }
    else if ( $_REQUEST['password'] != $_REQUEST['password_confirm'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); sweetAlert('Oops!','The password and confirmation password are different.','error'); </script>";
    }
    else
    {
        $sql['password'] = md5( $_REQUEST['password'] );
        update_sql( "users", $sql, "id=".$_SESSION['memberid']."" );
        update_sql( "users", $sql2, "id=".$_SESSION['memberid']."" );
        echo "<script>enable('sbt'); loading('span_loading',0); swal({ title: 'Password Changed!', text: 'Your password has been reset successfully.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ go('./member.php'); }); </script>";
    }
}


if ( $cmd == "login" )
{
    if ( !$_REQUEST['email'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your email.'); </script>";
    }
    else if ( !$_REQUEST['password'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your password.'); </script>";
    }
    else
    {
        $rs = getsqlrow( "select id,verify from users where email='".safe( $_REQUEST['email'] )."' and password='".md5( safe( $_REQUEST['password'] ) )."'" );
        if ( !$rs['verify'] == "" )
        {
       echo "<script> enable('sbt'); loading('span_loading',0); sweetAlert('Your email not verified!','','warning'); </script>";
        }
        else if ( !$rs['id'] )
        {
            echo "<script> enable('sbt'); loading('span_loading',0); sweetAlert('Login Failed!','Incorrect email or password.','error'); </script>";
        }
        else
        {
            $_SESSION['memberid'] = $rs['id'];
            if ( $_REQUEST['approve'] )
            {
                echo "<script>loading('span_loading',0); go('./approve.php');</script>";
            }
            else if ( $_REQUEST['back'] )
            {
                echo "<script>loading('span_loading',0); go('".$_REQUEST['back']."');</script>";
            }
            else
            {
                echo "<script>loading('span_loading',0); go('./');</script>";
            }
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
            $msg .= "<br /><br /><a href='".SITEURL."change_password.php?fp=".$code."'>".SITEURL."change_password.php?fp=".$code."</a><br/><br/><b>TEAM FOODZONED</b>";
            $mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
            $mailheaders .= "Return-path: {$sender} <{$sender}>\n";
            $mailheaders .= "From: ".SITENAME." <{$sender}>\n";
            $mailheaders .= "Reply-To: ".$sender."\n";
            $mailheaders .= "X-Mailer: php/".phpversion( )."\n";
            $mailheaders .= "X-Return-Path: {$sender}\n";
            send_email( $to, $subject, $msg, $mailheaders );
  echo "<script>loading('span_loading',0); swal({ title: 'Reset link sent!', text: 'Please check your email Inbox & Spam folder.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ go('./'); }); </script>";
        }
    }
}
if ( $cmd == "approve_order" )
{

$rest_id = getwhere( "cart", "rest_id", "session_id='".session_id( )."'" );

$session_id=session_id();
$cart_error = 0;

$getRss= mysql_query("SELECT * FROM cart where session_id='".$session_id."' and rest_id=".$rest_id." order by added_date asc");
while ($rss = mysql_fetch_array($getRss)) 
{
    $rsp=getSqlRow("select * from products where id=".$rss['prod_id']."");
    if ( $rsp['stock'] == "2" && $rss['qty'] > $rsp['stock_qty'] )
    { $cart_error = 1; }
}


    $need_address = getwhere( "order_types", "need_address", "order_type='".safe( $_REQUEST['order_type'] )."'" );

    if ( $cart_error == 1 )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); sweetAlert('Check your Cart!','Products having limited stock.','warning'); </script>";
    }
    else if ( !$_REQUEST['paymenttype'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('".$GLOBALS['alert_paymenttype']."'); </script>";
    }
    else if ( ( $_REQUEST['paymenttype'] == "Online Credit Card" || $_REQUEST['paymenttype'] == "Authorize.net" ) && !$_REQUEST['cc_name'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('".$GLOBALS['alert_cc_name']."'); </script>";
    }
    else if ( ( $_REQUEST['paymenttype'] == "Online Credit Card" || $_REQUEST['paymenttype'] == "Authorize.net" ) && !$_REQUEST['cc_lastname'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('".$GLOBALS['alert_cclastname']."'); </script>";
    }
    else if ( ( $_REQUEST['paymenttype'] == "Online Credit Card" || $_REQUEST['paymenttype'] == "Authorize.net" ) && !$_REQUEST['cc_no'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('".$GLOBALS['alert_ccno']."'); </script>";
    }
    else if ( ( $_REQUEST['paymenttype'] == "Online Credit Card" || $_REQUEST['paymenttype'] == "Authorize.net" ) && !$_REQUEST['cc_cvv2'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('".$GLOBALS['alert_cc_cvv2']."'); </script>";
    }
    else if ( $need_address == 1 && !$_REQUEST['nick'] && !$_REQUEST['address_id'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter nickname for address.'); </script>";
    }
    else if ( !$_REQUEST['name'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your name.'); </script>";
    }
    else if ( !$_REQUEST['mobilphone'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter mobile number.'); </script>";
    }
    else if ( $need_address == 1 && ( !is_numeric($_REQUEST['mobilphone']) || strlen($_REQUEST['mobilphone']) < "10" || strlen($_REQUEST['mobilphone']) > "10" || $_REQUEST['mobilphone'] == "0000000000" ) )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid mobile number.'); </script>";
    }
    else if ( $need_address == 1 && !$_REQUEST['address'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your Address.'); </script>";
    }
    else if ( $need_address == 1 && !$_REQUEST['city2'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Select your City.'); </script>";
    }
    else
    {
        if ( !$_REQUEST['mobilphone'] )
        {
            echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter mobile number.'); </script>";
        }
        else if ( !$_REQUEST['address'] )
        {
            echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your Address.'); </script>";
        }
        else if ( !$_REQUEST['area'] )
        {
            echo "<script> enable('sbt'); loading('span_loading',0); swal('Select your Area.'); </script>";
        }
        else if ( !$_REQUEST['city2'] )
        {
            echo "<script> enable('sbt'); loading('span_loading',0); swal('Select your City.'); </script>";
        }
        else if ( strlen($_REQUEST['order_note']) > 120 )
        {
            echo "<script> enable('sbt'); loading('span_loading',0); swal('Order note maximum 120 characters allowed.'); </script>";
        }
        else
        {

            $rest_tax = getval( "rests", "rest_tax", $rest_id );
            $discount = getval( "rests", "discount", $rest_id );
            $dis_min = getval( "rests", "dis_min", $rest_id );
            $fz_comm = getval( "rests", "fz_comm", $rest_id );
            $fz_delivery_type = getval( "rests", "delivery_type", $rest_id );

            $ec123=getSqlRow("select dfees from rest_delivery_area where rest_id='".$rest_id."' and da_id='".$_REQUEST['area']."'");
            $service_fee = $ec123['dfees'];


            $sql['userid'] = $_SESSION['memberid'];
            $sql['resid'] = $rest_id;
            $sql['orderdate'] = date( "Y-m-d H:i:s" );
            $sql['deliverydate'] = $_REQUEST['deliverydate']." ".$_REQUEST['deliverytime'];
            $sql['order_type'] = $_REQUEST['order_type'];
            $sql['paymenttype'] = $_REQUEST['paymenttype'];
            $sql['name'] = $_REQUEST['name'];
            $sql['phone'] = $_REQUEST['phone'];
            $sql['mobilphone'] = $_REQUEST['mobilphone'];
            $sql['address'] = $_REQUEST['address'] . ", " . getval( "delivery_areas", "city", $_REQUEST['area'] );
            $sql['postcode'] = $_REQUEST['postcode'];
            $sql['city'] = $_REQUEST['city2'];
            $sql['postcode'] = $_REQUEST['zip2'];
            $sql['company'] = $_REQUEST['company'];
            $sql['order_note'] = $_REQUEST['order_note'];
            $sql['site_service'] = getval( "rests", "site_service", $rest_id );
            if ( $payment_result == "ok" )
            {
                $sql['payment_status'] = 1;
            }
            $orderId = insert_sql( "orders", $sql );
            if ( $need_address == 1 )
            {
                unset( $sql );
                $sql['userid'] = $_SESSION['memberid'];
                $sql['nick'] = $_REQUEST['nick'];
                $sql['name'] = $_REQUEST['name'];
                $sql['phone'] = $_REQUEST['phone'];
                $sql['mobilphone'] = $_REQUEST['mobilphone'];
                $sql['address'] = $_REQUEST['address'];
                $sql['city'] = $_REQUEST['city2'];
                $sql['postcode'] = $_REQUEST['zip2'];
                $sql['company'] = $_REQUEST['company'];
                if ( !$_REQUEST['address_id'] )
                {
                    $addressId = insert_sql( "delivery_addresses", $sql );
                }
                else
                {
                    update_sql( "delivery_addresses", $sql, "id=".safe( $_REQUEST['address_id'] )."" );
                }
            }

            $order_total = 0;
            $order_details = "";
            $smsorder_details = "";

            $getRss = mysql_query( "SELECT * FROM cart where session_id='".session_id( )."' order by added_date asc" );
            while ( $rss = mysql_fetch_array( $getRss ) )
            {
                unset( $sql );
                $rs = getsqlrow( "SELECT * FROM products WHERE id=".$rss['prod_id']."" );
                $price = $rs['proprice'] == 0 ? $rs['price'] : $rs['proprice'];
                $price = $price * $rss['qty'];
                $optionals = "";
                $smsoptionals = "";
                $extras_total = 0;
                $restid = $getRss['rest_id'];
                $srs = getsqlrow( "SELECT packagingfees FROM rests WHERE id=".$restid."" );
                $pfees = $srs['packagingfees'];
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
                $sql['orderid'] = $orderId;
                $sql['userid'] = $_SESSION['memberid'];
                $sql['resid'] = $rest_id;
                $sql['prodid'] = $rss['prod_id'];
                $sql['qty'] = $rss['qty'];
                $sql['price'] = $price;
                $sql['extas_total'] = $extras_total + $pfees;
                $sql['subtotal'] = $sql['price'] + $sql['extas_total'];
                $sql['extras'] = $rss['extras'];
                $sql['optionals'] = $optionals;
                $sql['stock_mgt'] = $rs['stock'];

                if ( $rs['stock'] == "2" )
                {
                $sqty_total = $rs['stock_qty'] - $rss['qty'];
$update = mysql_query( "UPDATE products SET stock_qty=".$sqty_total." WHERE id=".$rss['prod_id']." and resid=".$rest_id."" );
                }

                $newId = insert_sql( "order_details", $sql );

                if ( $rest_tax > 0 )
                {
                    $tax_total = $tax_total + number_format( $sql['subtotal'] * $rest_tax / 100, 2, ".", "" );
                    $tax_total = ceil($tax_total);
                }

                $order_total = $order_total + $sql['subtotal'];
                $extras_subtotal = $extras_subtotal + $sql['extas_total'];
                $order_details .= "- ".$rss['qty']." x ".$rs['name']."<br />";
                $order_details .= $optionals;
                $smsorder_details .= "- ".$rss['qty']."x".$rs['name']." ".$smsoptionals." ";
            }

            if ( $discount > 0 )
            { 

            if ( $order_total >= $dis_min )
            { $discount_total = number_format( $order_total * $discount / 100, 2, ".", "" ); }

            }

            $total_amount = $order_total + $tax_total + $service_fee;
            $total_amount = $total_amount - $discount_total;
            $total_amount = round($total_amount);
            $fz_comm_total = number_format( ( $total_amount * $fz_comm ) / 100, 2, ".", "" );


            $update = mysql_query( "UPDATE orders SET tax_total='".$tax_total."',extras_total='".$extras_subtotal."',sub_total='".$order_total."',service_fee='".$service_fee."',order_total='".$total_amount."',discount='".$discount_total."',orderdetails='".$order_details."',fz_fee='".$fz_comm_total."',delivery_type='".$fz_delivery_type."',smsorderdetails='".$smsorder_details."' WHERE id=".$orderId."" );

            /* USER MOBILE ADDING */
            $mcheck = getval( "users", "mobilphone", $_SESSION['memberid'] );
            if (!$mcheck)
            {
            unset( $sql );
            $sql['mobilphone'] = $_REQUEST['mobilphone'];
            update_sql( "users", $sql, "id=".$_SESSION['memberid']."" );
            }

            /* USER CITY ADDING */
            $mcheck2 = getval( "users", "city", $_SESSION['memberid'] );
            if (!$mcheck2)
            {
            unset( $sql );
            $sql['city'] = $_REQUEST['city2'];
            update_sql( "users", $sql, "id=".$_SESSION['memberid']."" );
            }


            if ( strtolower( $_REQUEST['paymenttype'] ) == "cod" )
            {

               mysql_query("UPDATE orders SET status = '2' WHERE id='".$orderId."'");
               @include( DIR_PATH."conf/notifications.php" );      
               /* $result = $GLOBALS['msg_order_approve']; */

               $result = "<form name='frpaid' action='/orders.php' method='POST'><input type='hidden' name='paid' value='2'><input type='hidden' name='for' value='".$orderId."'></form><script language='javascript'> document.frpaid.submit(); </script>";

            }
            else
            {
                $convenience_fee = number_format( ( $total_amount * $fz_con_fee ) / 100, 2, ".", "" );
                mysql_query("UPDATE orders SET con_fee='".$convenience_fee."' WHERE id='".$orderId."'");
                echo "<script>go('./payment.php?oid=".$orderId."&token=".md5($orderId)."');</script>";
            }


            @mysql_query( @"delete from cart WHERE session_id='".@session_id( )."'" );
            echo "<script> enable('sbt'); loading('span_loading',0); $('#div_order').html('".jsescape( $result )."')</script>";
        }
    }
}
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
if ( $cmd == "save_address" )
{
    if ( !$_REQUEST['nick'] )
    {
        echo "<script>enable('sbt'); loading('span_loading',0); swal('Enter nickname for address.'); </script>";
        exit( );
    }
    if ( !$_REQUEST['name'] )
    {
        echo "<script>enable('sbt'); loading('span_loading',0); swal('Enter your name.'); </script>";
        exit( );
    }
    if ( !$_REQUEST['mobilphone'] )
    {
        echo "<script>enable('sbt'); loading('span_loading',0); swal('Enter mobile number.'); </script>";
        exit( );
    }
    else if ( !is_numeric($_REQUEST['mobilphone']) || strlen($_REQUEST['mobilphone']) < "10" || strlen($_REQUEST['mobilphone']) > "10" || $_REQUEST['mobilphone'] == "0000000000" )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid mobile number.'); </script>";
        exit( );
    }
    if ( !$_REQUEST['address'] )
    {
        echo "<script>enable('sbt'); loading('span_loading',0); swal('Enter your address.'); </script>";
        exit( );
    }
    if ( !$_REQUEST['city'] )
    {
        echo "<script>enable('sbt'); loading('span_loading',0); swal('Select your city.'); </script>";
        exit( );
    }

    unset( $sql );
    $sql['userid'] = $_SESSION['memberid'];
    $sql['nick'] = $_REQUEST['nick'];
    $sql['name'] = $_REQUEST['name'];
    $sql['phone'] = $_REQUEST['phone'];
    $sql['mobilphone'] = $_REQUEST['mobilphone'];
    $sql['address'] = $_REQUEST['address'];
    $sql['postcode'] = $_REQUEST['postcode'];
    $sql['city'] = $_REQUEST['city'];
    $sql['company'] = $_REQUEST['company'];
    if ( !$_REQUEST['address_id'] )
    {
        $addressId = insert_sql( "delivery_addresses", $sql );
    }
    else
    {
        update_sql( "delivery_addresses", $sql, "id=".safe( $_REQUEST['address_id'] )."" );
    }
    echo "<script>enable('sbt'); loading('span_loading',0); swal('Your address updated!'); location.reload();</script>";
}

if ( $cmd == "contact_ad" )
{

    if ( !$_REQUEST['name'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter contact person name.'); </script>";
    }
    else if ( !$_REQUEST['company'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter company name.'); </script>";
    }
    else if ( !$_REQUEST['mobile'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobile']) || strlen($_REQUEST['mobile']) < "10"  || strlen($_REQUEST['mobile']) > "10" || $_REQUEST['mobile'] == "0000000000" )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid mobile number.'); </script>";
    }
    else if ( !$_REQUEST['email'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid email address.'); </script>";
    }
    else if ( !$_REQUEST['city'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your city.'); </script>";
    }
    else if ( !$_REQUEST['message'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Message is Empty!'); </script>";
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
        echo "<script>loading('span_loading',0); swal({ title: 'Thank You!', text: 'Your message was sent successfully.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ go('./'); }); </script>";
    }
}

if ( $cmd == "suggest_rest" )
{

    if ( !$_REQUEST['rname'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter service provider name.'); </script>";
    }
    else if ( !$_REQUEST['address'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter service provider address.'); </script>";
    }
    else if ( !$_REQUEST['city'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter Service provider City.'); </script>";
    }
    else if ( !$_REQUEST['name'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your name.'); </script>";
    }
    else if ( !$_REQUEST['email'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid email address.'); </script>";
    }
    else if ( !$_REQUEST['mobile'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobile']) || strlen($_REQUEST['mobile']) < "10" || strlen($_REQUEST['mobile']) > "10" || $_REQUEST['mobile'] == "0000000000" )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid mobile number.'); </script>";
    }
    else if ( !$_REQUEST['message'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Comment box is Empty!'); </script>";
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
        echo "<script>loading('span_loading',0); swal({ title: 'Thank You!', text: 'Your suggestion has been submitted successfully.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ go('./'); }); </script>";
    }
}


if ( $cmd == "join_network" )
{

    if ( !$_REQUEST['name'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your name.'); </script>";
    }
    else if ( !$_REQUEST['mobile'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobile']) || strlen($_REQUEST['mobile']) < "10" || strlen($_REQUEST['mobile']) > "10" || $_REQUEST['mobile'] == "0000000000" )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid mobile number.'); </script>";
    }
    else if ( !$_REQUEST['email'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid email address.'); </script>";
    }
    else if ( !$_REQUEST['rname'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter service name.'); </script>";
    }
    else if ( !$_REQUEST['phone'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter service telephone.'); </script>";
    }
    else if ( !$_REQUEST['address'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter service address.'); </script>";
    }
    else if ( !$_REQUEST['city'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your city.'); </script>";
    }
    else if ( !$_REQUEST['pincode'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your pincode.'); </script>";
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
        $sender = SITE_EMAIL;
        $to = SITE_EMAIL;
        $reply = $_REQUEST['email'];
        $subject = "Service Joining Form | ".$_REQUEST['rname'];
        $msg = "<b>Contact Person :</b> ".$_REQUEST['name']."<br/><br/><b>Email :</b> ".$_REQUEST['email']."<br/><br/><b>Mobile :</b> ".$_REQUEST['mobile']."<br/><br/>";
	$msg .= "<b>Service :</b> ".$_REQUEST['rname']."<br/><br/><b>Phone :</b> ".$_REQUEST['phone']."<br/><br/><b>Address :</b><br/> ".$_REQUEST['address']."<br/><br/><b>City :</b> ".$_REQUEST['city']."<br/><br/><b>Pincode :</b> ".$_REQUEST['pincode']."<br/><br/>";

        $mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
        $mailheaders .= "Return-path: {$sender} <{$sender}>\n";
        $mailheaders .= "From: ".SITENAME." <{$sender}>\n";
        $mailheaders .= "Reply-To: ".$form['email']."\n";
        $mailheaders .= "X-Mailer: php/".phpversion( )."\n";
        $mailheaders .= "X-Return-Path: {$sender}\n";
        @mail( @$to, @$subject, @$msg, @$mailheaders );
        echo "<script>loading('span_loading',0); swal({ title: 'Thank You!', text: 'Your request has been submitted successfully.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ go('./'); }); </script>";
    }
}



if ( $cmd == "feedback" )
{

    if ( !$_REQUEST['city'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Select your city.'); </script>";
    }
    else if ( !$_REQUEST['name'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your name.'); </script>";
    }
    else if ( !$_REQUEST['email'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter your email.'); </script>";
    }
    else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL))
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid email address.'); </script>";
    }
    else if ( !$_REQUEST['mobile'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Enter mobile number.'); </script>";
    }
    else if ( !is_numeric($_REQUEST['mobile']) || strlen($_REQUEST['mobile']) < "10" || strlen($_REQUEST['mobile']) > "10" || $_REQUEST['mobile'] == "0000000000" )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid mobile number.'); </script>";
    }
    else if ( $_REQUEST['type'] == "0" )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Select feedback category.'); </script>";
    }
    else if ( !$_REQUEST['message'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Your feedback is empty.'); </script>";
    }
    else if ( $_SESSION['security_code'] != $_REQUEST['captcha'] )
    {
        echo "<script> enable('sbt'); loading('span_loading',0); swal('Invalid verification code.'); </script>";
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
	echo "<script>loading('span_loading',0); swal({ title: 'Thank You!', text: 'Your feedback has been submitted successfully.', type: 'success', showCancelButton: false, confirmButtonColor: '', confirmButtonText: 'OK', closeOnConfirm: false }, function(){ go('./'); });  </script>";
    }
}



exit( );

?>