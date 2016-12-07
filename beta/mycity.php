<?php 
include "conf/config.php";
// get the q parameter from URL
$q = $_GET["mycity"];
unset($_SESSION['mycity']);
$_SESSION['mycity']=$q;
?>