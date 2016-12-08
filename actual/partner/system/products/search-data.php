<?php

include "../../../conf/config.php";

    /* The search input from user ** passed from jQuery .get() method */
    $param = $_GET["searchData"];
    $scat = $_GET["scat"];
    $myid = $_SESSION['restaid'];

if ( $scat == "0" )
{ $adddata =""; }
else
{ $adddata = "AND menuid=".$scat; }



    /* If connection to database, run sql statement. */


        /* Fetch the users input from the database and put it into a
         valuable $fetch for output to our table. */

$LLimit = "250";

$fetch = mysql_query("SELECT * FROM products WHERE (name LIKE '%{$param}%' OR barcode LIKE '%{$param}%') AND resid='$myid' $adddata ORDER BY updated desc LIMIT 0,".$LLimit."");

$data_total = getSqlNumber("SELECT * FROM products WHERE (name LIKE '%{$param}%' OR barcode LIKE '%{$param}%') AND resid='$myid' $adddata ORDER BY updated desc");

        /*
           Retrieve results of the query to and build the table.
           We are looping through the $fetch array and populating
           the table rows based on the users input.
         */

echo "<tr><td colspan='3' style='padding:15px 0px 15px 0px;'>Search Results: " . $param . "</td>";
echo "<td colspan='2' style='padding:15px 0px 15px 0px;text-align:right;'>Total Products: " . $data_total . " &nbsp; &nbsp;";

if ( $data_total > $LLimit ) { echo "<br/>(Products display limit: " . $LLimit . ") &nbsp; &nbsp;"; }

echo "</td></tr>";

while ( $row = mysql_fetch_object( $fetch ) ) {
$sResults .= '<tr id="fp_'. $row->id . '" onmouseover="ChangeBackgroundColor(this)" onmouseout="RestoreBackgroundColor(this)">';

$sResults .= '<td><b><a href="/partner/product.php?id=' . $row->id . '" title="' . $row->details . '">' . $row->name . '</a></b>';

if ( $row->barcode ) { $sResults .= '<br/>'.$row->barcode; }

$sResults .= '</td><td>' . getval( "menus", "menu", $row->menuid ) . '</td>';
$sResults .= '<td style="text-align:right">' . setPrice($row->price) . '</td>';

if ( $row->stock == "2" ) 
{ $sResults .= '<td style="text-align:center"><b><a href="javascript:void(0)" title="Update Stock" onclick="updateStock(' . $row->id . ');">[ ' . $row->stock_qty . ' ]</a></b></td>'; }
else
{ $sResults .= '<td style="text-align:center"> - </td>'; }

$sResults .= '<td style="text-align:center">';

$sResults .= '<input type="radio" name="status_' . $row->id . '" id="status_' . $row->id . '" value="1" onclick="set_product_status(' . $row->id . ',this.value);"' .(( $row->status == "1" )?"checked":"").'> ON ';

$sResults .= '<input type="radio" name="status_' . $row->id . '" id="status_' . $row->id . '" value="0" onclick="set_product_status(' . $row->id . ',this.value);"' .(( $row->status == "0" )?"checked":"").'> OFF ';

$sResults .= '&nbsp; &nbsp; [<a href="javascript:void(0)" title="Delete" onclick="Del(' . $row->id . ');">X</a>]</td></tr>';

}


    /* Free connection resources. */
    mysql_close($conn);

    /* Toss back the results to populate the table. */
    echo $sResults;

?>