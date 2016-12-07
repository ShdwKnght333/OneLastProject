<?php
if ($_REQUEST['pid'] || $_REQUEST['cid']) {
include "../conf/config.php";
}
$prod_id=safe($_REQUEST['pid']);
$cart_id=safe($_REQUEST['cid']);
$rest_id=safe($_REQUEST['id']);
$session_id=session_id();

$rest_tax=getVal("rests","rest_tax",$rest_id);

$s_a12=getSqlRow("SELECT id FROM delivery_areas WHERE region='".$_SESSION['mycity']."' AND city='".$_SESSION['myarea']."'");
$ec43=getSqlRow("select dfees from rest_delivery_area where rest_id='".$rest_id."' and da_id='".$s_a12['id']."'");
$ec33=getSqlRow("select packagingfees from rests where id='".$rest_id);
$service_fee = $ec43['dfees'];
$pfees = $ec33['packagingfees'];

$cr=getSqlRow("select min from rest_delivery_area where rest_id='".$rest_id."' and da_id='".$s_a12['id']."'");

$discount=getVal("rests","discount",$rest_id);
$dis_min=getVal("rests","dis_min",$rest_id);


if ($prod_id && $_REQUEST['cmd']=="add") {
	$isExist=getSqlNumber("select prod_id from cart where session_id='".$session_id."' and prod_id=".$prod_id." and extras=''");

/* CHECK STOCK AVAILABILITY */
$addp=getSqlRow("SELECT * FROM products WHERE id='".$prod_id."'");
if ( $addp['stock'] == "2" && $addp['stock_qty'] > "0" || $addp['stock'] < "2" ) { 

	if ($isExist) {

$mqty=getSqlRow("select qty from cart where session_id='".$session_id."' and prod_id=".$prod_id."");

if ( $addp['stock'] == "2" && $mqty['qty'] < $addp['stock_qty'] || $addp['stock'] < "2" )
{
	if($mqty['qty'] < "20")
	{ @mysql_query("update cart set qty=qty+1 where session_id='".$session_id."' and prod_id=".$prod_id.""); }
	else
	{ echo ""; }

} else { echo "<script> sweetAlert('Limited Stock!','Sorry, No more stock available.','warning'); </script>"; }


	} else {
		@mysql_query("delete from cart where session_id='".$session_id."' and rest_id!=".$rest_id."");
		$sql['session_id']	= $session_id;
		$sql['rest_id']		= $_REQUEST['id'];
		$sql['prod_id']		= $prod_id;
		$sql['added_date']	= Date("Y-m-d H:i:s");
		$newId=insert_sql("cart",$sql);
	}

/* CLOSE OF CHECK STOCK AVAILABILITY */
} else { echo "<script> sweetAlert('Out of Stock!','Sorry, this product is currently not available.','warning'); </script>"; }

}

if ($cart_id && $_REQUEST['cmd']=="update_qty") {

	/* CHECK STOCK AVAILABILITY */
	$cpid=getVal("cart","prod_id",$cart_id);
	$cpqty=getVal("cart","qty",$cart_id);
	$caddp=getSqlRow("SELECT * FROM products WHERE id='".$cpid."'");

if ( $caddp['stock'] == "2" && $cpqty < $caddp['stock_qty'] || $caddp['stock'] == "2" && $_REQUEST['qty'] < $cpqty || $caddp['stock'] < "2" )
	{
	@mysql_query("update cart set qty=".safe($_REQUEST['qty'])." where id=".$cart_id."");
	} else { echo "<script> sweetAlert('Limited Stock!','Sorry, No more stock available.','warning'); </script>"; }

}

if ($cart_id && $_REQUEST['cmd']=="update_extra") {
	@mysql_query("update cart set extras='".safe($_REQUEST['extras'])."' where id=".$cart_id."");
}

if ($cart_id=="all" && $_REQUEST['cmd']=="remove") {
	@mysql_query("delete from cart where session_id='".$session_id."'");
}

if ($cart_id && $cart_id!="all"  && $_REQUEST['cmd']=="remove") {
	@mysql_query("delete from cart where id=".$cart_id."");
}

/* Cart Main Code */

$cart_count=getSqlNumber("select prod_id from cart where session_id='".$session_id."' and rest_id=".$rest_id."");

$s_a2=getSqlRow("SELECT id FROM delivery_areas WHERE region='".$_SESSION['mycity']."' AND city='".$_SESSION['myarea']."'");
$s_area2=getSqlNumber("select rest_id from rest_delivery_area where da_id='".$s_a2['id']."' and rest_id=".$rest_id."");

if (!$s_area2) {
echo $derror;
} 
else if (!$cart_count) {
echo $GLOBALS['no_items'];
} else {

echo "<table style='width:100%;'>";
?>
<tr><td><b>Item</b></td><td><center><b>Qty &nbsp;</b></center></td><td style="text-align:right;"><b>Price</b></td><td></td></tr>
<?
$getRss= mysql_query("SELECT * FROM cart where session_id='".$session_id."' and rest_id=".$rest_id." order by added_date asc");
while ($rss = mysql_fetch_array($getRss)) {
	$rsp=getSqlRow("select * from products where id=".$rss['prod_id']."");
	$extras_array=explode(",",$rss['extras']);
?>

<tr>
<td style="font-size:12px;padding-top:10px;padding-right:5px;"><?=$rsp['name']?> 

<? 
if ( $rsp['stock'] == "2" && $rss['qty'] > $rsp['stock_qty'] )
{ echo "<font color='red'>(No Stock)</font>"; }
?>

<? /* ?><br/> - <? $price1=($rsp['proprice']>0)?$rsp['proprice']:$rsp['price']; 	echo setPrice($price1); ?><? */ ?>
</td>

<td style="width:55px;font-size:14px;padding-top:10px;">
<a href="javascript:void(0);" title="Add" <? if( $rss['qty'] < 20 ) { ?> onclick="updateQty2(<?=$rss['id']?>,<?=$rss['qty']+1;?>);" <? } ?>><i class="fa fa-plus-circle fa-1x"></i></a>
 &nbsp;<? if($rss['qty'] < 10 ) { echo "0".$rss['qty']; } else { echo $rss['qty']; } ?>&nbsp; 
<a href="javascript:void(0);" title="Remove" <? if( $rss['qty'] > 1 ) { ?> onclick="updateQty2(<?=$rss['id']?>,<?=$rss['qty']-1;?>);" <? } ?>><i class="fa fa-minus-circle fa-1x"></i></a> 
</td>

<td style="text-align:right;width:85px;font-size:12px;padding-top:10px;">
<?
	$price=($rsp['proprice']>0)?$rsp['proprice']:$rsp['price']; 	echo setPrice($price*$rss['qty']);
	$price=($price*$rss['qty']);
	$price=number_format($price,2,".","");
	$sub_total=$sub_total+$price;

	?></td>

<td style="width:15px;text-align:center;font-size:12px;padding-top:10px;">
<a href="javascript:void(0);" onclick="remove_cart(<?=$rss['id']?>)" title="<?=$GLOBALS['remove']?> - <?=$rsp['name']?>"><img src="img/delete.gif" alt="<?=$GLOBALS['remove']?> - <?=$rsp['name']?>" /></a></td>
</tr>

<?
$getRoc = mysql_query("SELECT * FROM optional_group where proid=".$rsp['id']." order by id asc");
while ($roc = @mysql_fetch_array($getRoc)) { 

$getRoc2 = mysql_query("SELECT * FROM extra_group where id=".$roc['egid']." order by id asc");
while ($roc2 = @mysql_fetch_array($getRoc2)) { 

if ($roc2['items']) { echo "<tr><td colspan='4' style='font-size:12px;padding-top:8px;'>
<font style='font-size:13px;color:#DB1921;'><b>" . $roc2['name'] . "</b></font><br/>";

$getRoc3 = mysql_query("SELECT * FROM optionals where id IN (" . $roc2['items'] . ") order by id asc");
while ($roc3 = @mysql_fetch_array($getRoc3)) { 

if (in_array($roc3['id'],$extras_array)) $extra_total=$extra_total+($roc3['price']*$rss['qty']);
?>

<input type="checkbox" style="padding-top:2px;" name="extra_<?=$roc3['id']?>" id="extra_<?=$roc3['id']?>" value="<?=$roc3['id']?>" class="extras_cb cb_<?=$rss['id']?>" onclick="updateExtras(<?=$rss['id']?>);" <? if (in_array($roc3['id'],$extras_array)) echo "checked='true'"; ?>  /> <?=$roc3['optional']?> [<?=setPrice($roc3['price']);?>]<br/>

<? } ?>

<? } /* Of IF condition */ } echo "</td></tr>"; } ?>
<? } ?>

<tr>
<td style=""><br/><?=$GLOBALS['subtotal']?></td>
<td></td>
<td style="text-align:right;"><br/><?=setPrice($sub_total);?></td>
<td style="width:15px;text-align:center;"><br/>
<a href="javascript:void(0);" onclick="remove_cart2('all')" title="<?=$GLOBALS['empty_cart']?>"><img src="img/delete.gif" /></a>
</td></tr>
<? if ($extra_total>0) { 

?>
<tr>
<td style=""><?=$GLOBALS['extras']?></td>
<td></td>
<td style="text-align:right;"><?=setPrice($extra_total);?></td>
<td style="width:10px;"></td>
</tr>
<? } ?>

<? // if ($rest_tax>0) { 
$tax_total=number_format(($sub_total+$extra_total)*$rest_tax/100,2,".","");
$tax_total = ceil($tax_total);	
?>
<tr>
<td style="">Taxes</td>
<td></td>
<td style="text-align:right;"><?=setPrice($tax_total);?></td>
<td style="width:10px;"></td>
</tr>
<? // } ?>


<tr>
<td style=""><?=$GLOBALS['service_fee_text']?></td>
<td></td>
<td style="text-align:right;"><?=setPrice($service_fee);?></td>
<td style="width:10px;"></td>
</tr>

<tr>
<td style="">Packaging Fees</td>
<td></td>
<td style="text-align:right;"><?=setPrice($pfees);?></td>
<td style="width:10px;"></td>
</tr>

<? if ($discount>0) { 

if ( ($sub_total+$extra_total) >= $dis_min )
{ $discount_total=number_format(($sub_total+$extra_total)*$discount/100,2,".","");

?>
<tr>
<td style="">Discount <?=$discount?>%</td>
<td></td>
<td style="text-align:right;"><?=setPrice($discount_total);?></td>
<td style="width:10px;"></td>
</tr>
<?  } } ?>

<?php
$ctotal = $tax_total+$sub_total+$service_fee+$pfees+$extra_total-$discount_total;
$ctotal = round($ctotal);
?>

<tr>
<td style="padding-bottom:10px;padding-top:8px;"><?=$GLOBALS['total_amount']?></td>
<td></td>
<td style="text-align:right;padding-top:8px;"><?=setPrice($ctotal);?></td>
<td style="width:10px;"></td>
</tr>
<?
$rest_isopen = getSqlNumber("SELECT id FROM rests where id=".$rest_id." and status=1");
$rsoc=getSqlRow("select * from site_timing where resid=".$rest_id." and dateday=".date('w')."");
if ($rest_isopen && checkRestHour($rsoc['open1'],$rsoc['close1'],$rsoc['open2'],$rsoc['close2'],$rsoc['open3'],$rsoc['close3'])) {
?>
<tr>

<td colspan="4" class="order_now">
<? if ($ctotal >= $cr['min']) { ?>

<a href="<?=SITEURL?>approve.php" class="ordernow" title="<?=$GLOBALS['order_now']?>">PROCEED TO CHECKOUT</a>
<? $_SESSION['cart_approve'] = "2"; ?>

<? } else { ?>

<font color="#666">MIN ORDER <?=setPrice($cr['min']);?></font>
<? $_SESSION['cart_approve'] = "1"; ?>

<? } ?>
</td>

</tr>
<? } else { ?>
<tr>
<td colspan="4" class="order_now" style="color:#db1921;"><?=$GLOBALS['rest_closed_msg']?></td>
</tr>
<? } ?>
</table>


<?
}

if ($prod_id || $cart_id) { ?>
<script>
$("#span_cart_loading").html('');
$("#td_addcart_<?=$prod_id?>").html('<a href="javascript:void(0);" onclick="addCart(<?=$prod_id?>);" title="<?=$GLOBALS['add_cart']?>"><img src="<?=SITEURL?>img/addcart.gif" height="15px" alt="<?=$GLOBALS['add_cart']?>" /></a>');
</script>
<? } ?>

<div id="fz-footer">
<div class="wrap">
<a href="#div_cart"><i class="fa fa-shopping-cart fa-1x"></i>&nbsp; <?=setPrice($ctotal);?></a> &nbsp; | &nbsp; 
<a href="#"><i class="fa fa-arrow-up fa-1x"></i> TOP</a>
</div>
</div>
