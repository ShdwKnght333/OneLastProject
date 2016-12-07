<?php 
include "conf/config.php";
// get the q parameter from URL
$q = $_REQUEST["myarea"];
if(isset($_SESSION['mycity'])&& $_SESSION['mycity'])
{
$area = $_SESSION['mycity'];
$query = mysql_query("SELECT city FROM delivery_areas WHERE region='".$area."' order by city asc");
$i=0;
while($row = mysql_fetch_array($query)) {
    $a[$i++]=$row['city'];
}
$hint = "";
// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = "<a class='selectOption' href='javascript:void(0);' ><li class='left-text' data-value='".$name."' >".$name."</li></a>";
            } else {
                $hint .= "<a class='selectOption' href='javascript:void(0);'  ><li class='left-text' data-value='".$name."' >".$name."</li></a>";
            }
        }
    }
}
// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "<li></li>" : $hint;
}
?>