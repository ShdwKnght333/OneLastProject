<?php

include "../conf/config.php";

$area = $_GET['parent_cat'];
$query = mysql_query("SELECT city FROM delivery_areas WHERE region='" . $area ."' order by city asc");
?>
<option value="" selected>Select Area</option>
<?php 
while($row = mysql_fetch_array($query)) {
echo "<option value='$row[city]'>$row[city]</option>";
}
?>