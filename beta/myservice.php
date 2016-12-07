<?php 
include "conf/config.php";
if(isset($_POST['Area'])&& isset($_POST['City'])){ 
	$_SESSION['mycity']=$_POST['City'];
	$_SESSION['myarea']=$_POST['Area'];	
}
else if (isset($_POST['Area'])){
	$_SESSION['myarea']=$_POST['Area'];	
}	
$area=$_SESSION['myarea'];
$city=$_SESSION['mycity'];
 if(isset($_SESSION['mycity'])&& isset($_SESSION['myarea'])&& $_SESSION['mycity'] && $_SESSION['myarea'] )
{ 
$R1= getSqlRow("SELECT id FROM delivery_areas WHERE region='".$_SESSION['mycity']."' AND city='".strtoupper($_SESSION['myarea'])."' ");
$R2 = mysql_query("SELECT * FROM rest_delivery_area WHERE da_id='".$R1['id']."' ");
if(isset($list2))
	unset($list2);
else
	$list2="";
while ($R3 = mysql_fetch_array($R2)) {  $list2.=(string) $R3['rest_id'].",";  } // comma seperated resturant ids
$list2 = substr($list2, 0, -1); // remove the last comma
$R4 = mysql_query("SELECT DISTINCT site_service FROM rests WHERE status=1 AND id IN (". $list2.") order by site_service asc");
$R5 = getSqlNumber("SELECT DISTINCT site_service FROM rests WHERE status=1 AND id IN (". $list2.")");
if(is_resource($R4))
{
while ($rss33 = mysql_fetch_array($R4)) 
{ 
		if(getval( "site_services", "status",$rss33['site_service'] )== 1 ) 
		{ 
					switch(strtoupper(getval("site_services", "name", $rss33['site_service'] )))
					{
							case 'RESTAURANTS' :  echo  "<li class='other-addresses' id='restaurant'><a href='services.php?service=1'><i class='other-addresses-icon icon fa fa-cutlery'></i><span class='other-addresses-text'>Restaurant</span></a></li>"; break;
						
						    case 'LIQUORS' : 	echo   "<li class='other-addresses' id='liquor'><a href='services.php?service=3' ><i class='other-addresses-icon icon fa fa-glass'></i><span class='other-addresses-text'>Liquor</span></a></li>"; break;
				
							case 'GROCERIES' : echo "<li class='other-addresses' id='groceries'><a><i class='other-addresses-icon icon  fa fa-shopping-cart'></i><span class='other-addresses-text'>Groceries</span></a></li>"; break;
                                
							case 'LAUNDRY' : echo "<li class='other-addresses' id='laundry'><a><i class='other-addresses-icon icon fa fa-instagram'></i><span class='other-addresses-text'>Laundry</span></a> </li>";break;

							default: echo "No Services Available right Now ! "; goto exit_loop;
					 }		
		 }	
}
}
else
	echo "<li> No Services Available in your Place </li>";
	exit_loop: echo " ";
}
else  echo    "<li class='other-addresses' id='restaurant'><a><i class='other-addresses-icon icon fa fa-cutlery'></i><span class='other-addresses-text'>Restaurant</span></a></li>";
 ?>
