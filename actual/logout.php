<?php
session_start();

if ( $_SESSION['mycity'] && $_SESSION['myarea'] )
{
$mycity = $_SESSION['mycity'];
$myarea = $_SESSION['myarea'];
$service = $_SESSION['service'];
}

session_destroy();
echo "<script>window.location='./';</script>";

session_start();

$_SESSION['mycity'] = $mycity;
$_SESSION['myarea'] = $myarea;
$_SESSION['service'] = $service;



?>