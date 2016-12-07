<?php
include "../../conf/config.php";

    /* The search input from user ** passed from jQuery .get() method */
    $param = $_GET["searchData"];
    $scity = $_GET["scity"];


if ( $scity == "0" )
{ echo "<br/><font color='red'>Please Select your City to search product.</font>"; }

  /* If connection to database, run sql statement. */
 /* Fetch the users input from the database and put it into a valuable $fetch for output to our table. */
$getR2 = mysql_query("SELECT * FROM rests WHERE rcity='".$scity."'");

/* $getR2 = mysql_query("SELECT * FROM rest_delivery_area WHERE da_id='".$R1['id']."'"); */
if(isset($list)) 
	unset($list);
else
	$list="";
$sResults="";
while ($R2 = mysql_fetch_array($getR2)) { $list .=(string) $R2['id'] . ","; }
$list = substr($list, 0, -1);
$fetch = mysql_query("SELECT * FROM products WHERE name LIKE '%{$param}%' AND status=1 AND resid IN (" . $list . ") ORDER BY price ASC LIMIT 0, 100");

        /*
           Retrieve results of the query to and build the table.
           We are looping through the $fetch array and populating
           the table rows based on the users input.
         */

$veg = '<img src="images/veg.png" width="13" height="13" title="Vegetarian">';
$nonveg = '<img src="images/nonveg.png" width="13" height="13" title="Non-Vegetarian">';
$alco = '<img src="images/alcohol.png" width="13" height="13" title="Alcoholic">';

echo "<tr><td colspan='4' style='padding:15px 0px 15px 0px;'>Search Query : " . $param . "</td></tr>";
if(is_resource($fetch))
{
while ( $row = mysql_fetch_object( $fetch ) ) {

$sres2 = getsqlrow("SELECT * FROM rests WHERE id='". $row->resid ."'");
if ( $sres2['status'] == 1 )
{
	$sResults .= '<tr id="'. $row->id . '">';
if(  $row->type == "1" )  // Name
{ $sResults .= '<td>' . $veg . ' ' . $row->name . '</td>'; }
else if(  $row->type == "2" ) 
{ $sResults .= '<td>' . $nonveg . ' ' . $row->name . '</td>'; }
else if(  $row->type == "3" ) 
{ $sResults .= '<td>' . $alco . ' ' . $row->name . '</td>'; }
else
{ $sResults .= '<td> &nbsp; </td>'; }
$sResults.= '<td style="text-align:left">' . setPrice($row->price) . '</td>'; // Price
$sres3 = getsqlrow("SELECT * FROM menus WHERE id='". $row->menuid ."'"); 
$sResults .= '<td style="text-align:left">' . $sres3['menu'] . '</td>';  // Category
/* $sResults .= '<td style="text-align:right"><a href="/restaurant.php?id='.$sres2['id'].'" target="_blank">' .$sres2['name']. '</a></td></tr>'; */
$sResults .= '<td style="text-align:left"><a href="'.setRestUrl($sres2['id'],$sres2['name']).'" target="_blank">' .$sres2['name']. '</a></td></tr>'; // Service provider
}
    }
}	
	if(isset($conn))
	{	
    /* Free connection resources. */
    mysql_close($conn);
	}

    /* Toss back the results to populate the table. */
    echo $sResults;

?>