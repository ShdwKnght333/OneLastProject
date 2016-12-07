<?php 
session_start();
if(isset($_SESSION['mycity'])&& isset($_SESSION['myarea']) && $_SESSION['mycity'] && $_SESSION['myarea'] )
{	
	echo "1";
}
else 
{
	echo "0";
}
?>