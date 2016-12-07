<?php 
include "conf/config.php";
$latitude = $_GET['latitude'];
$longitude = $_GET['longitude'];
$geolocation = $latitude.','.$longitude;
$request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&sensor=false'; 
$file_contents = file_get_contents($request);
$json_decode = json_decode($file_contents);
if(isset($json_decode->results[0])) {
    $response = array();
    foreach($json_decode->results[0]->address_components as $addressComponet) {
        if(in_array('political', $addressComponet->types)) {
                $response[] = $addressComponet->long_name; 
        }
    }
    if(isset($response[0])){ $place  =  $response[0];  } else { $place  = 'null'; }
    if(isset($response[1])){ $city =  $response[1];  } else { $city = 'null'; }
	if(isset($response[2])){ $third  =  $response[2];  } else { $third  = 'null'; }
    if(isset($response[3])){ $fourth =  $response[3];  } else { $fourth = 'null'; }
    if(isset($response[4])){ $fifth  =  $response[4];  } else { $fifth  = 'null'; }
 
    if( $place != 'null' && $city != 'null' && $third != 'null' && $fourth != 'null' && $fifth != 'null' ) {
		if(isset($_SESSION['mycity'])&& isset($_SESSION['myarea']))
		{ 	unset($_SESSION['mycity']);
				unset($_SESSION['myarea']);
				$_SESSION['mycity']=$city;
				$_SESSION['myarea']=$place;
		 }		
		echo $place."-".$city."-".$fourth."-".$fifth;
    }
    else if ( $place != 'null' && $city != 'null' && $third != 'null' && $fourth != 'null' && $fifth == 'null'  ) {
       if(isset($_SESSION['mycity'])&& isset($_SESSION['myarea']))
		{ 	unset($_SESSION['mycity']);
				unset($_SESSION['myarea']);
				$_SESSION['mycity']=$city;
				$_SESSION['myarea']=$place;
		 }		
		echo $place."-".$city."-".$third."-".$fourth;
    }
  else
  {
	  echo "Location "."-"."Unable "."-"."to "."-"."Detect ! ";
  }	  
}
?>