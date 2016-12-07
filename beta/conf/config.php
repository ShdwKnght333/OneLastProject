<?php

$session_expiration = time() + 3600 * 24 * 6; // 6 days
session_set_cookie_params($session_expiration);
session_start();

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'glo11449_fzdata';

$dbh = mysql_connect($dbhost,$dbuser,$dbpass) or die (mysql_error());
mysql_select_db($dbname);
mysql_query("SET NAMES 'utf8'");

define('SITEURL', 'http://www.beta.foodzoned.com/');

//***********************************
//System admin username and password

$sys_username="fzadmin";
$sys_password="fz574211";

//***********************************
// FOODZONED CONVENIENCE FEE

$fz_con_fee = "5";

//***********************************
// PAYMENT GATEWAY SETTINGS

$merchant_id = "37044";
$merchant_data='';
$working_key='69F859C715E60E711635B0F02C877072'; //Shared by CCAVENUES
$access_code='AVRQ01BG85AF20QRFA'; //Shared by CCAVENUES

//***********************************

include_once ("funcs.php");

?>