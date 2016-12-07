<?php

if( $nop['paymenttype'] == "COD" ) { $ptype = "COD"; } else { $ptype = "OP"; }

$my_sub = $nop['order_total'] - $nop['service_fee'];

$smstext = "Order ID: ".$orderId."\n";
$smstext .= $nop['name']." ".$nop['mobilphone']."\n";
$smstext .= "Type: ".$nop['order_type']."\n";
$smstext .= "Order:".$nop['smsorderdetails']."\n";
$smstext .= "Address: ".$nop['address']."\n";
$smstext .= "Payment: ".$ptype."\n";
$smstext .= "Subtotal: ".setprice($my_sub)."\n";
$smstext .= "Delivery: ".setprice( $nop['service_fee'] )."\n";
$smstext .= "Total: ".setprice( $nop['order_total'] );

if ($nop['order_note'])
{
$smstext .= "\nNote: ".$nop['order_note'];
}

$PhNo = "";

if ( $mobilphone2 == "" )
{ $PhNo = $mobilphone; }
else
{ $PhNo = $mobilphone . "," . $mobilphone2; }

$ID = "somilkhicha";
$Pwd = "foodzoned5050";
$sender_id = "FZONED";


/* Restaurant SMS */

$Text = urlencode($smstext);
$srvc_name = urlencode("TEMPLATE_BASED");

$url = "http://sms.hspsms.com:/sendSMS?username=somilkhicha&message=".$Text."&sendername=FZONED&smstype=TRANS&numbers=".$PhNo."&apikey=7a487929-63af-4ed1-b387-c07a30aa068e";

/*
$url = "http://bhashsms.com/api/sendmsg.php?user=".$ID."&pass=".$Pwd."&sender=".$sender_id."&phone=".$PhNo."&priority=ndnd&stype=normal&text=".$Text;
*/

echo $url ."<br/><br/>";

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
$result = curl_exec($ch);
curl_close($ch);

/* Client SMS */


$smstext2 = "Hi " . ucwords(strtolower($nop['name'])) . ",\n";
$smstext2 .= "We have received your order #" . $nop['id'] . " amounting to " . setprice($nop['order_total']) . " and it will be delivered soon. Queries! Reach us at 09035515321.\n\n";
$smstext2 .= "FOODZONED.COM";

$Text2 = urlencode($smstext2);
$PhNo = "";
$PhNo = $nop['mobilphone'];


$url = "http://sms.hspsms.com:/sendSMS?username=somilkhicha&message=".$Text2."&sendername=FZONED&smstype=TRANS&numbers=".$PhNo."&apikey=7a487929-63af-4ed1-b387-c07a30aa068e";

/*
$url = "http://bhashsms.com/api/sendmsg.php?user=".$ID."&pass=".$Pwd."&sender=".$sender_id."&phone=".$PhNo."&priority=ndnd&stype=normal&text=".$Text2;
*/

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
$result = curl_exec($ch);
curl_close($ch);

?>