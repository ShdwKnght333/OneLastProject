<?php

include "../conf/config.php";

$scity = $_GET['parent_city'];
$sarea = $_GET['parent_area'];

$R111= getSqlRow("SELECT id FROM delivery_areas WHERE region='".$scity."' AND city='".$sarea."'");
$getR22 = mysql_query("SELECT * FROM rest_delivery_area WHERE da_id='".$R111['id']."'");
unset($list2);
while ($R22 = mysql_fetch_array($getR22)) { $list2 .= (string) $R22['rest_id'] . ","; }
$list2 = substr($list2, 0, -1);
$getRss33 = mysql_query("SELECT DISTINCT site_service FROM rests WHERE status=1 AND id IN (" . $list2 . ") order by site_service asc");
$totalResults3 = getSqlNumber("SELECT DISTINCT site_service FROM rests WHERE status=1 AND id IN (" . $list2 . ")");
?>

<option value="">Select Service</option>
<?php while ($rss33 = mysql_fetch_array($getRss33)) { ?>

<? if ( getval( "site_services", "status", $rss33['site_service']) == 1 ) { ?>

<option value="<?=$rss33['site_service'];?>" <?php if( $totalResults3 == "1" ) { echo "selected"; } ?>>
<?=strtoupper(getval( "site_services", "name", $rss33['site_service'] ));?>
</option>

<? } /* IF CONDITION */ ?>

<?php } /* While End */ ?>