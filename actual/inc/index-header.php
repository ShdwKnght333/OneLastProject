
<?php if ($_SESSION['memberid']) { ?>
<div class="welcome"><div class="wrap">
<?php $hwm = getsqlrow( "select name from users where id='".$_SESSION['memberid']."'"); ?>
<table width="100%">
<td><a href="member.php" class="top-2"><i class="fa fa-user fa-1x"></i> <?=$hwm['name'];?></a></td><td align="right"><a href="<?=SITEURL?>logout.php" class="top-2"><i class="fa fa-power-off fa-1x"></i> Log Out</a></td>
</table>
</div></div>
<?php } ?>
			<div class="header">
				<div class="wrap">
				<div class="logo"> <?php /* src="/img/page/offers/diwali-logo.png" */ ?>
<a href="/"><img src="/img/foodzonedlogo2.png" title="Foodzoned.com" width="260" height="62" alt="Foodzoned.com" /></a>
				</div>
				<div class="top-nav">
						<ul class="flexy-menu thick orange">

							<?php if (!$_SESSION['memberid']) { ?>
							<li><a href="<?=SITEURL?>login.php">LOGIN</a></li>
							<li><a href="<?=SITEURL?>register.php">REGISTER</a></li>
							<?php } ?>
							<?php if ($_SESSION['memberid']) { ?>
							<li><a href="<?=SITEURL?>orders.php">MY ORDERS</a></li>
							<li><a href="<?=SITEURL?>member.php">ACCOUNT</a></li>
							<?php } ?>
							<li><a href="<?=SITEURL?>find-my-food.php">FIND MY FOOD</a></li>
							<li><a href="<?=SITEURL?>offers.php">OFFERS</a></li>
							<li><a href="<?=SITEURL?>faq.php">FAQ</a></li>
							<li><a href="<?=SITEURL?>contact.php">CONTACT US</a></li>

						</ul>
						
				</div>
				<div class="clear"> </div>
				</div>
			</div>

<?php 
$query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'");
?>

			<div class="find-place dfind-place">
				<div class="wrap">

					<div class="p-ww">

<form id="find-restaurants" name="find-restaurants" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="find_restaurants" />
					
<select class="dest" type="text" name="city" id="parent_cat"> 
        <option value="">Select City</option>
        <?php while($row = mysql_fetch_array($query_parent)): ?>
        <option value="<?=$row['region'];?>" <?php if ( $_SESSION['mycity'] && $_SESSION['myarea'] ) { if ( $_SESSION['mycity'] == $row['region'] ) { echo "selected"; } } ?>><?=$row['region'];?></option>
        <?php endwhile; ?>
</select>

<span>&nbsp;</span>

<select class="dest" type="text" name="area" id="sub_cat">
<?php if ( $_SESSION['mycity'] && $_SESSION['myarea'] ) { 
$query3 = mysql_query("SELECT city FROM delivery_areas WHERE region='" . $_SESSION['mycity'] ."'");
?>
        <option value="">Select Area</option>
        <?php while($row3 = mysql_fetch_array($query3)): ?>
        <option value="<?=$row3['city'];?>" <?php if ( $_SESSION['myarea'] == $row3['city'] ) { echo "selected"; } ?>><?=$row3['city'];?></option>
        <?php endwhile; ?>
<?php } else { ?>
<option value="" selected>Select Area</option>
<?php } ?>
</select>

<span>&nbsp;</span>

<?php if (isset($_REQUEST['service'])) { $_SESSION['service'] = $_REQUEST['service']; } ?>
<select class="dest" type="text" name="service" id="sub_cat_service">
<?php if ( $_SESSION['mycity'] && $_SESSION['myarea'] ) {
$R111= getSqlRow("SELECT id FROM delivery_areas WHERE region='".$_SESSION['mycity']."' AND city='".$_SESSION['myarea']."'");
$getR22 = mysql_query("SELECT * FROM rest_delivery_area WHERE da_id='".$R111['id']."'");
unset($list2);
while ($R22 = mysql_fetch_array($getR22)) { $list2 .= (string) $R22['rest_id'] . ","; }
$list2 = substr($list2, 0, -1);
$getRss33 = mysql_query("SELECT DISTINCT site_service FROM rests WHERE status=1 AND id IN (" . $list2 . ") order by site_service asc");
$totalResults4 = getSqlNumber("SELECT DISTINCT site_service FROM rests WHERE status=1 AND id IN (" . $list2 . ")");
?>

<option value="">Select Service</option>
<?php while ($rss33 = mysql_fetch_array($getRss33)) { ?>

<?php if( getval( "site_services", "status", $rss33['site_service'] ) == 1 ) { ?>
<option value="<?=$rss33['site_service'];?>" <?php if ( isset($_SESSION['service']) == $rss33['site_service'] || $totalResults4 == "1" ) { echo "selected"; } ?>><?=strtoupper(getval( "site_services", "name", $rss33['site_service'] ));?></option>
<?php } ?>

<?php } /* While End */ ?>
<?php } else { ?>
<option value="" selected>Select Service</option>
<?php } ?>
</select>

<input name="find" id="find" type="submit" value="SEARCH" onclick='this.disabled=true; post("find-restaurants"); return false;'/>

</form>

					</div>
					<div class="clear"> </div>
				</div>
			</div>
			
		<div class="wrap">
		<div class="main-content">