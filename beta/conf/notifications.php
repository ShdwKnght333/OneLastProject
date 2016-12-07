<?php

$nop = getsqlrow("SELECT * FROM orders WHERE id='".$orderId."'");

$restmail = getval( "rests", "email", $nop['resid'] );
$sender = "orders@foodzoned.com";
$tofz = "orders@foodzoned.com";

$custemer_email = getval( "users", "email", $nop['userid'] );
$crd = getsqlrow("SELECT * FROM rests WHERE id=".$nop['resid']."");


                $reply = SITE_EMAIL;
                $subject = "New Order";
                $msg = "<img src='".SITEURL."/img/email/mail-header-logo.png'><br/><br/>\r\n\t\t\t<table width='500'>\r\n\t\t\t<tr>\r\n\t\t\t<td>Order ID : #".$orderId."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>Service Provider :</b><br />\r\n\t\t\t".$crd['name']."<br />\r\n\t\t\t".$crd['address']."<br />\r\n\t\t\tPh: ".$crd['gsm']."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>Order Type :</b><br />\r\n\t\t\t".$nop['order_type']."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>Order Details :</b><br />\r\n\t\t\t".$nop['orderdetails']."\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>Customer Name :</b><br />\r\n\t\t\t".$nop['name']."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>Mobile :</b><br />\r\n\t\t\t".$nop['mobilphone']."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t";

$msg .= "<b>Address :</b><br />\r\n\t\t\t".$nop['address']."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />";

                $msg .= "<b>Payment Type :</b><br />\r\n\t\t\t".$nop['paymenttype']."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>Subtotal : ".setprice( $nop['order_total'] - $nop['service_fee'] )."</b><br />\r\n\t\t\t<b>Delivery Charge : ".setprice( $nop['service_fee'] )."</b><br />\r\n\t\t\t<b>Order Total : ".setprice( $nop['order_total'] )."</b><br /><br />";

if ($nop['order_note']) { $msg .= "\r\n\t\t\t<b>Order Note :</b> <br />\r\n\t\t\t" . $nop['order_note'] . "<br /><br />"; }

$msg .= "\r\n\t\t\t<br />\r\n\t\t\t\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t";

                $mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
                $mailheaders .= "Return-path: {$sender} <{$sender}>\n";
                $mailheaders .= "From: ".SITENAME." <{$sender}>\n";
                $mailheaders .= "Reply-To: ".$reply."\n";
                $mailheaders .= "Bcc: ".$restmail."\n";
                $mailheaders .= "X-Mailer: php/".phpversion( )."\n";
                $mailheaders .= "X-Return-Path: {$sender}\n";
                send_email( $tofz, $subject." #{$orderId}", $msg, $mailheaders );




            if ( 5 < strlen( $custemer_email ) )
            {

                $msg_custemer = "<img src='".SITEURL."/img/email/mail-header-logo.png'><br/><br/>\r\n\t\t\t<table width='550'>\r\n\t\t\t<tr>\r\n\t\t\t<td>\r\n\t\t\t".$GLOBALS['email_order_id']." : #".$orderId."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>Service Provider : </b><br/>".$crd['name']."<br/>\r\n\t\t\t".$crd['address']." <br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>Order Type : </b>".$nop['order_type']."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>".$GLOBALS['email_order_details']." :</b><br />\r\n\t\t\t".$nop['orderdetails']."\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>Name :</b><br />\r\n\t\t\t".$nop['name']."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>Mobile :</b><br />\r\n\t\t\t".$nop['mobilphone']."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t";
$msg_custemer .= "<b>Address :</b><br />\r\n\t\t\t".$nop['address']."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t";

                $msg_custemer .= "<b>".$GLOBALS['email_payment_type']." :</b><br />\r\n\t\t\t".$nop['paymenttype']."<br />\r\n\t\t\t--------------------------------------------------------------------------<br />\r\n\t\t\t<b>".$GLOBALS['email_order_total']." : ".setprice( $nop['order_total'] )."</b><br /><br />";


if ( strtolower($nop['paymenttype']) !== "cod" )
{ $msg_custemer .= "<b>Amount Paid : " . setPrice($nop['paid_amount']) . "</b><br /><br />"; }


if ($nop['order_note']) { $msg_custemer .= "<b>Order Note :</b> " . $nop['order_note'] . "<br /><br />"; }

$msg_custemer .= "Thanks for Ordering! <br />For any queries contact <a href='mailto:care@foodzoned.com'>care@foodzoned.com</a><br /><br /><b>TEAM FOODZONED</b><br /><br />";
                $mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
                $mailheaders .= "Return-path: {$sender} <{$sender}>\n";
                $mailheaders .= "From: ".SITENAME." <{$sender}>\n";
                $mailheaders .= "Reply-To: ".$reply."\n";
                $mailheaders .= "X-Mailer: php/".phpversion( )."\n";
                $mailheaders .= "X-Return-Path: {$sender}\n";
                send_email( $custemer_email, $GLOBALS['email_order']." #{$orderId}", $msg_custemer, $mailheaders );
            }
			
            if ( FAX_ENABLE == "yes" )
            {
                $fax_no = getval( "rests", "fax", $nop['resid'] );
                $fax_msg = $msg;
                ob_start( );
                @include( DIR_PATH."conf/fax.php" );
                $page = ob_get_clean( );
            }
            if ( SMS_ENABLE == "yes" )
            {
                $mobilphone = getval( "rests", "gsm", $nop['resid'] );
                $mobilphone2 = getval( "rests", "gsm2", $nop['resid'] );
                ob_start( );
                @include( DIR_PATH."conf/sms.php" );
                $page = ob_get_clean( );
            }
		
mysql_query("UPDATE orders SET orderdetails = '',smsorderdetails = '' WHERE id='".$orderId."'");	

?>