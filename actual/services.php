<?
include "conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Services</title>
<? include "inc/styles.php"; ?>

<script>
function sortFz(val) {

if ( val=="2" )
{ $(".offline").hide(); }
else
{ $(".offline").show(); }
	
}
</script>

</head>
<body>

<div class="mainbody">

<? include "inc/header.php"; ?>  

<div id="content" class="container_12">

<? 
if(isset($_GET['s']))
	if($_GET['s'] =="") $start = 0;
	else $start = $_GET['s'];
else
	$start=0;
$limit = 60;


if ($_REQUEST['city']) {
	$city=strtoupper(safe($_REQUEST['city']));
	$city=str_replace(" "," ",$city);
}

if ($_REQUEST['area']) {
	$area=strtoupper(safe($_REQUEST['area']));
	$area=str_replace(" "," ",$area);
}

if ($_REQUEST['service']) {
	$service=strtoupper(safe($_REQUEST['service']));
	$service=str_replace(" "," ",$service);
}

$R1= getSqlRow("SELECT id FROM delivery_areas WHERE region='".$city."' AND city='".$area."'");
$getR2 = mysql_query("SELECT * FROM rest_delivery_area WHERE da_id='".$R1['id']."'");

unset($list);
$list="";
while ($R2 = mysql_fetch_array($getR2)) { $list = $list.(string) $R2['rest_id'] . ","; }
$list = substr($list, 0, -1);

if (!$_REQUEST['area']) {

echo "<div class='grid_12'><h1>Service providers</h1>Select your City, Area & Service to search service providers.</div>";

} else {

$totalResults = getSqlNumber("SELECT id FROM rests WHERE status=1 AND site_service='".$service."' AND id IN (" . $list . ")");
$getRss = mysql_query("SELECT * FROM rests WHERE status=1 AND site_service='".$service."' AND id IN (" . $list . ") order by priority desc LIMIT ".$start.",".$limit."");

$_SESSION['area'] = $_SESSION['myarea'];
$ec12=getSqlRow("select id from delivery_areas where region='".$_SESSION['mycity']."' and city='".$_SESSION['myarea']."'");

$count=mysql_num_rows($getRss);
if(!$count>=1){ if ($_REQUEST['city']) { echo "<h1><small>Sorry, No service provider available @ ".ucwords(strtolower($area))."</small></h1>"; } else { echo "Select City, Area & Service to search service providers. "; }

}

?>

<div class="grid_12">
<h1><? if ($totalResults) { ?><small>Order from <?=$totalResults?> Service Provider<? if($totalResults > 1 ){echo "s";} ?></small><? } ?></h1>

<div class="page3">
SORT BY &nbsp; <select onchange="sortFz(this.value)">
<option value="1">ALL</option>
<option value="2">NOW OPEN</option>
</select><br/><br/>
</div>
<div class="page4">
<? if ($totalResults>$limit) { ?>
<div class="pagination">
<ul style="text-align:right;padding-right:30px;">
<?
restaurantspages($start,$limit,$totalResults,$_SERVER['PHP_SELF'], $additionalVars, $city, $area, $service);
?>
</ul>
</div><br/><br/>
<? } ?>
</div>
<p style="clear:both;"></p>
</div>

<?
while ($rss = mysql_fetch_array($getRss)) {
	$logo="logos/".$rss['id'].".jpg";
?>

<?
$rstimes=getSqlRow("select * from site_timing where resid=".$rss['id']." and dateday='".date("w")."'");
?>

<div class="grid_4 <? if (checkRestHour($rstimes['open1'],$rstimes['close1'],$rstimes['open2'],$rstimes['close2'],$rstimes['open3'],$rstimes['close3'])) { echo "online"; } else { echo "offline"; } ?>" style="margin-bottom:20px;margin-right:30px;">
<div class="sitems">

<center>
<? if (file_exists($logo)) { ?>
<div class="rest_logo">
<a href="<?=setRestUrl($rss['id'],$rss['name'])?>" title="<?=$rss['name']?>"><img src="<?=$logo?>" class="rest_logo"/></a>
</div>
<? } else { ?>
<div class="rest_logo">
<a href="<?=setRestUrl($rss['id'],$rss['name'])?>" title="<?=$rss['name']?>"><img src="img/default_logo.jpg" class="rest_logo"/></a>
</div>
<? } ?>
</center>

<table style="width:90%; margin:0px 10px;">
<td colspan="3" style="padding-top:5px;">
<b><a href="<?=setRestUrl($rss['id'],$rss['name'])?>" title="<?=$rss['name']?>" style="color:#222;"><? if (strlen($rss['name']) >= 21) { echo substr($rss['name'], 0, 21). "..."; } else { echo $rss['name']; } ?></a></b> <? if($rss['flash']==1) { echo '<img src="/img/new.gif" width="26" height="12">'; }?><br/>
<small>
<? if (strlen($rss['address']) >= 30) { echo substr($rss['address'], 0, 30). " ... "; } else { echo $rss['address']; } ?>
</small>
</td>
</tr>

<tr><td colspan="3" style="padding-top:4px;">

<? if($rss['type']=="1") { ?>
<img src='/theme/images/veg.png' width='13' height='13' title='Vegetarian Products'>
<? } else if($rss['type']=="2") { ?>
<img src='/theme/images/nonveg.png' width='13' height='13' title='Non-Vegetarian Products'>
<? } else if($rss['type']=="3") { ?>
<img src='/theme/images/veg.png' width='13' height='13' title='Vegetarian Products'>  
<img src='/theme/images/nonveg.png' width='13' height='13' title='Non-Vegetarian Products'>
<? } else if($rss['type']=="4") { ?>
<img src='/theme/images/alcohol.png' width='13' height='13' title='Alcoholic Products'> 
<? } ?>

</td></tr>

<?
$ec123=getSqlRow("select dfees from rest_delivery_area where rest_id='".$rss['id']."' and da_id='".$ec12['id']."'");
$min123=getSqlRow("select min from rest_delivery_area where rest_id='".$rss['id']."' and da_id='".$ec12['id']."'"); 
?>

<tr><td colspan="3"><i class="fa fa-map-marker fa-1x"></i> Delivery : <? if ( $ec123['dfees'] <= '0' ) { echo "FREE"; } else { echo setPrice($ec123['dfees']); } ?></td></tr>
<tr><td colspan="3"><i class="fa fa-money fa-1x"></i> Min. Order : <?=setPrice($min123['min']);?></td></tr>
<tr><td colspan="3"><i class="fa fa-credit-card fa-1x"></i> <?=str_replace("|"," | ",$rss['paymenttypes'])?></td></tr>

<tr>
<td colspan="3"><i class="fa fa-clock-o fa-1x"></i> <small><?=$rstimes['custom_time'];?></small></td>
</tr>

<tr>
<td colspan="3">
<?
if (checkRestHour($rstimes['open1'],$rstimes['close1'],$rstimes['open2'],$rstimes['close2'],$rstimes['open3'],$rstimes['close3'])) {
?>
<h3 align="center"><a href="<?=setRestUrl($rss['id'],$rss['name'])?>" title="View <?=$rss['name']?> Products" class="vmenu">NOW OPEN</a></h3>
<? } else { ?>
<h3 align="center"><a href="<?=setRestUrl($rss['id'],$rss['name'])?>" title="Timing: <?=$rstimes['custom_time'];?>"  class="vclosed">NOW CLOSED</a></h3>
<? } ?>
</td>
</tr>
</table>

</div>
</div>
<? } ?>

<? if ($totalResults>$limit) { ?>
<br style="clear: both;" />
<div class="pagination" style="margin-left:10px;">
<br/>
<ul>
<?
restaurantspages($start,$limit,$totalResults,$_SERVER['PHP_SELF'], $additionalVars, $city, $area, $service);
?>
</ul>
</div>
<? } } ?>

</div>
<div class="clearfix"></div>

<? include "inc/footer.php"; ?>

<div class="clearfix"></div>
</div>

</body>
</html>