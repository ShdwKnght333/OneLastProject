<h2>&nbsp;MENU 
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
<? if ($Rp2['proprice']>0) { echo setPrice($Rp2['proprice']); } else { echo setPrice($Rp2['price']); } ?>
</option>
<? } } ?>
</select>
</form>
</h2>

<ul class="responsive-accordion responsive-accordion-default bm-larger">

<?
$getRsm = mysql_query("SELECT * FROM menus where resid=".$rs['id']." and status=1 order by priority desc");
while ($rsm = @mysql_fetch_array($getRsm)) {
?>

<li>
<div class="responsive-accordion-head" id="menu_<?=$rsm['id']?>">
<?=$rsm['menu']?> &nbsp;<? if ($rsm['flash']=="1") echo '<img src="/img/new.gif">'; ?> <a name="<?=$rsm['id']?>"></a>
<i class="fa fa-chevron-down responsive-accordion-plus fa-fw"></i>
<i class="fa fa-chevron-up responsive-accordion-minus fa-fw"></i>
</div>

<div class="responsive-accordion-panel">

<?
$getRsp= mysql_query("SELECT * FROM products where menuid=".$rsm['id']." and status=1 order by type,price asc");
while ($rsp = @mysql_fetch_array($getRsp)) {
?>

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
<? 	if ($rsp['picture']) { ?>		
<a href="upload/images/<?=$rsp['picture']?>" rel="product_img" title="<?=$rsp['name']?>"><?=$rsp['name']?></a>
<? } else { ?>
<?=$rsp['name']?>
<? } ?> 
<br /><small><?=$rsp['details']?></small></td>

<td style="width:80px;text-align:right;padding-right:5px;"><?
	if ($rsp['proprice']>0) {
		echo "<font color='red'><strike>".setPrice($rsp['price'])."</strike></font><br/>".setPrice($rsp['proprice']);
	} else {
		echo setPrice($rsp['price']);
	}
	?></td>
<td id="td_addcart_<?=$rsp['id']?>" style="width:22px;"><img src="<?=SITEURL?>img/addcart.gif" height="15px" alt="<?=$GLOBALS['add_cart']?> - <?=$rsp['name']?>" /></td>
</tr>
</table>
</div>
</a>

<? } ?>
<div class="clearfix"></div>
</div>
</li>

<? } ?>

</ul>