<?php
session_start();

if ((isset($_SESSION['mycity']) && $_SESSION['mycity']) && (isset($_SESSION['myarea'])&& $_SESSION['myarea']) && (isset($_SESSION['myservice'])&& $_SESSION['myservice']) )
{
$mycity = $_SESSION['mycity'];
$myarea = $_SESSION['myarea'];
$service = $_SESSION['myservice'];
}

session_destroy();
echo "<script>var path=document.referrer; window.location=path;</script>";

session_start();

$_SESSION['mycity'] = $mycity;
$_SESSION['myarea'] = $myarea;
$_SESSION['myservice'] = $service;



?>