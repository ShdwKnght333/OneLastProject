<?
include "conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Special Offers</title>
<? include "inc/styles.php"; ?>
</head>
<body>

<div class="mainbody">

<? include "inc/header.php"; ?>  

<div id="content" class="container_12">
<div class="grid_12">
<h1>Special offers</h1>
</div>

<? 
if ($_GET['s'] == "") $start = 0;
else $start = $_GET['s'];
$limit = 16;


if ( $_SESSION['mycity'] && $_SESSION['myarea'] )
{
$ec12=getSqlRow("select id from delivery_areas where region='".$_SESSION['mycity']."' and city='".$_SESSION['myarea']."'");
$getR2 = mysql_query("SELECT rest_id FROM rest_delivery_area WHERE da_id='".$ec12['id']."'");

unset($list);
while ($R2 = mysql_fetch_array($getR2)) { $list .= (string) $R2['rest_id'] . ","; }
$list = substr($list, 0, -1);

$totalResults = getSqlNumber("SELECT id FROM offers WHERE status=1 AND resid IN (" . $list . ")");
$getRss = mysql_query("SELECT * FROM offers WHERE status=1  AND resid IN (" . $list . ") order by priority desc LIMIT ".$start.",".$limit."");
}
else
{
	$totalResults = getSqlNumber("SELECT id FROM offers WHERE status=1");
	$getRss = mysql_query("SELECT * FROM offers WHERE status=1 order by priority desc LIMIT ".$start.",".$limit."");
}

$count=mysql_num_rows($getRss);
if(!$count>=1) { echo "Sorry, No offers found."; }


while ($rss = mysql_fetch_array($getRss)) {

$logo="logos/".$rss['resid'].".jpg";
$rname=getval( "rests", "name", $rss['resid'] );
$raddress=getval( "rests", "address", $rss['resid'] );
$rtype=getval( "rests", "type", $rss['resid'] );

?>

<div class="grid_4" style="margin-bottom:20px;margin-right:30px;">
<div class="sitems">

<center>
<? if (file_exists($logo)) { ?>
<div class="rest_logo">
<a href="<?=setRestUrl($rss['resid'],$rname)?>" title="<?=$rname?>"><img src="<?=$logo?>" class="rest_logo"/></a>
</div>
<? } else { ?>
<div class="rest_logo">
<a href="<?=setRestUrl($rss['resid'],$rname)?>" title="<?=$rname?>"><img src="img/default_logo.jpg" class="rest_logo"/></a>
</div>
<? } ?>
</center>

<div style="min-height:120px;padding:0px 5px 0px 8px;">
<h3 style="color:#ff6600"><?=getval( "rests", "name", $rss['resid'] )?></h3>
<b><?=$rss['name']?></b><br/>
<?=$rss['details']?>

</div>
<h3 align="center"><a href="<?=setRestUrl($rss['resid'],$rname)?>" title="VIEW OFFER" class="vmenu">VIEW OFFER</a></h3>

</div>
</div>
<? } ?>

<? if ($totalResults>$limit) { ?>
<br style="clear: both;" />
<div class="pagination" style="margin-left:10px;">
<ul>
<?
pages($start,$limit,$totalResults,$_SERVER['PHP_SELF'], $additionalVars, $city, $area);
?>
</ul>
</div>
<? } ?>

</div>
<div class="clearfix"></div>

<? include "inc/footer.php"; ?>

<div class="clearfix"></div>
</div>

</body>
</html>