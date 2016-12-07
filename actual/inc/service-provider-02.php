<?php

/* Select category group or menu */

$rscat = $_REQUEST['category'];
$rsg=getSqlRow("SELECT * FROM menus_group WHERE id='".$rscat."' and resid='".$rs['id']."'");

?>

<h2>
&nbsp;<? if ( $rscat == $rsg['id'] && $_REQUEST['category'] ) { ?>
<a href="<?=setRestUrl($rs['id'],$rs['name'])?>"><i class="fa fa-chevron-circle-left"></i> Go Back</a>
<? } else { ?>Categories<? } ?>

<form id="rest-items" name="rest-items" style="float:right;">
<select class="special-flexselect" style="width:240px;" id="rest-items" name="rest-items" tabindex="1" data-placeholder="Start typing a Product Name..." onchange="addCart(this.value);updateInput(this.value='');">
<option value=""></option>
<?
$getRp1 = mysql_query("SELECT * FROM menus where resid=".$rs['id']." and status=1 order by priority desc");
while ($Rp1 = @mysql_fetch_array($getRp1)) {
$getRp2 = mysql_query("SELECT * FROM products where menuid=".$Rp1['id']." AND ( stock='2' AND stock_qty > '0' OR stock < '2') AND status=1 order by type,price asc");

while ($Rp2 = @mysql_fetch_array($getRp2)) {

?>

<option value="<?=$Rp2['id']?>">
<?=$Rp2['name']?> - 
<? if ( $Rp2['proprice'] > "0" ) { echo setPrice($Rp2['proprice']); } else { echo setPrice($Rp2['price']); } ?>
</option>

<? } } ?>
</select>
</form>
</h2>


<? if ( $rscat == $rsg['id'] && $_REQUEST['category'] ) { ?>


<ul class="responsive-accordion responsive-accordion-default bm-larger">

<?
$getRsm = mysql_query("SELECT * FROM menus where resid=".$rs['id']." and gpid=".$rsg['id']." and status=1 order by priority desc");
while ($rsm = @mysql_fetch_array($getRsm)) {

$totalR = "0";
$totalR = getSqlNumber("SELECT id FROM products WHERE resid='".$rs['id']."' AND menuid='".$rsm['id']."' AND ( stock='2' AND stock_qty > '0' OR stock < '2') AND status=1");

?>

<li>
<div class="responsive-accordion-head" id="menu_<?=$rsm['id']?>">
<?=$rsm['menu']?> &nbsp;(<?=$totalR?>) &nbsp;<? if ($rsm['flash']=="1") echo '<img src="/img/new.gif">'; ?> <a name="<?=$rsm['id']?>"></a>
<i class="fa fa-chevron-down responsive-accordion-plus fa-fw"></i>
<i class="fa fa-chevron-up responsive-accordion-minus fa-fw"></i>
</div>

<div class="responsive-accordion-panel">

<?
$getRsp= mysql_query("SELECT * FROM products where menuid=".$rsm['id']." and status=1 order by type,price asc");
while ($rsp = @mysql_fetch_array($getRsp)) {
?>


<?php if ( $rsp['stock'] == "2" && $rsp['stock_qty'] > "0" || $rsp['stock'] < "2" ) { ?>
	
<a href="javascript:void(0);" onclick="addCart(<?=$rsp['id']?>);" title="<?=$GLOBALS['add_cart']?> - <?=$rsp['name']?>">
<div class="product-row-2">
<table style="width:100%;">
<tr>
<td align="center" style="width:30px;">

<? if($rsp['type']=="1") { ?>
<img src="/theme/images/veg.png" width="13" height="13" title="Vegetarian">
<? } else if($rsp['type']=="2") { ?>
<img src="/theme/images/nonveg.png" width="13" height="13" title="Non-Vegetarian"> 
<? } else if($rsp['type']=="3") { ?>
<img src="/theme/images/alcohol.png" width="13" height="13" title="Alcoholic">
<? } ?>

</td>

<td>
<? if ($rsp['picture']) { ?>		
<a href="upload/images/<?=$rsp['picture']?>" rel="product_img" title="<?=$rsp['name']?>"><?=$rsp['name']?></a>
<? } else { ?>
<?=$rsp['name']?>
<? } ?> 
<br /><small><?=$rsp['details']?></small></td>

<td style="width:80px;text-align:right;padding-right:5px;">
<?
	if ($rsp['proprice']>0) {
		echo "<font color='red'><strike>".setPrice($rsp['price'])."</strike></font><br/>".setPrice($rsp['proprice']);
	} else {
		echo setPrice($rsp['price']);
	}	
?>
</td>
<td id="td_addcart_<?=$rsp['id']?>" style="width:22px;"><img src="<?=SITEURL?>img/addcart.gif" height="15px" alt="<?=$GLOBALS['add_cart']?> - <?=$rsp['name']?>" /></td>
</tr>
</table>
</div>
</a>

<? } /* Stock Availability Check */ ?>

<? /* Products Loop */ } ?>
<div class="clearfix"></div>
</div>
</li>

<? } ?>

</ul>

<? }  else { ?>


<ul class="responsive-accordion responsive-accordion-default bm-larger">
<?
/* DISPLAYING SERVICE PROVIDER MENU GROUP */
$getRsm = mysql_query("SELECT * FROM menus_group where resid=".$rs['id']." and status=1 order by priority desc");
while ($rsm = @mysql_fetch_array($getRsm)) {


$getRC2 = mysql_query("SELECT * FROM menus where resid=".$rs['id']." and gpid=".$rsm['id']." and status=1");
unset($list);
while ($RC2 = mysql_fetch_array($getRC2)) { $list .= (string) $RC2['id'] . ","; }
$list = substr($list, 0, -1);
$totalR2 = "0";
$totalR2 = getSqlNumber("SELECT id FROM products WHERE resid='".$rs['id']."' AND ( stock='2' AND stock_qty > '0' OR stock < '2') AND status=1 AND menuid IN (" . $list . ")");
?>

<li><a href="?category=<?=$rsm['id']?>">
<div class="responsive-accordion-head"><?=$rsm['gp_name']?> &nbsp;(<?=$totalR2?>) &nbsp;<? if ($rsm['flash']=="1") echo '<img src="/img/new.gif">'; ?> 
<i class="fa fa-chevron-right"></i>
</div></a></li>

<? } ?>
</ul>

<? } ?>
