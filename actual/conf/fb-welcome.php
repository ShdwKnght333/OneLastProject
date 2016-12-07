<?php 

	$sender = SITE_EMAIL;
	$to = $me['email'];
	$subject = "Welcome to Foodzoned";
	$msg = "<img src='".SITEURL."/img/email/mail-header-logo.png'><br/><br/><b>Hi " . $me['name'] . ",</b><br/><b>Thank you for joining to Foodzoned.com</b>";
	$msg .= "<br /><br /><b>How To Order:</b><br/>+ Login to Foodzoned.com<br/>+ Select your City & Area<br/>+ Choose Restaurant & Food<br/>+ Proceed to Checkout<br/>+ Fill Delivery Details<br/>+ Select Payment Method<br/>+ Customer gets confirmation via Email<br/>+ Notification sent to Restaurant<br/>+ Order is Processed & Delivered<br/>";
	$msg .= "<br /><br /><b>TEAM FOODZONED</b>";
	$mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
	$mailheaders .= "Return-path: {$sender} <{$sender}>\n";
	$mailheaders .= "From: ".SITENAME." <{$sender}>\n";
	$mailheaders .= "Reply-To: ".$sender."\n";
	$mailheaders .= "X-Mailer: php/".phpversion( )."\n";
	$mailheaders .= "X-Return-Path: {$sender}\n";
	send_email( $to, $subject, $msg, $mailheaders );


?>