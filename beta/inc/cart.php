<?php
if (isset($_REQUEST['pid']) || isset($_REQUEST['cid'])) {
include "../conf/config.php";
}
$discount_total=0;
$sub_total=0;
$extra_total=0;
$cart_id="";
if(isset($_REQUEST['r']))
$rest_id=$_REQUEST['r'];
if(isset($_REQUEST['pid']))
$prod_id=safe($_REQUEST['pid']);
if(isset($_REQUEST['cid']))
$cart_id=safe($_REQUEST['cid']);
if(isset($_REQUEST['id']))
$rest_id=safe($_REQUEST['id']);
$session_id=session_id();
$derror="";
$cart_empty_msg = "<p class='desktop-cart_order__message'>Start adding your favourite Dishes !</p>";
$cart_empty_msg = $cart_empty_msg."<div style='border:2px dashed;min-height:450px;padding:130px 30px'><span style='font-weight:bold'><center><i class='fa fa-shopping-cart fa-5x'></i><br><br>Your Cart is Empty</center></span></div>";

if(isset($_SESSION['mycity'])&& isset($_SESSION['myarea'])) {
		
		$rest_tax=getVal("rests","rest_tax",$rest_id);
		$s_a12=getSqlRow("SELECT id FROM delivery_areas WHERE region='".$_SESSION['mycity']."' AND city='".$_SESSION['myarea']."'");
		$ec43=getSqlRow("select dfees from rest_delivery_area where rest_id='".$rest_id."' and da_id='".$s_a12['id']."'");
		$ec44=getSqlRow("select packagingfees from rests where id='".$rest_id."'");
		$service_fee = $ec43['dfees'];
		$pfees = $ec44['packagingfees'];

		$cr=getSqlRow("select min from rest_delivery_area where rest_id='".$rest_id."' and da_id='".$s_a12['id']."'");	
		$discount=getVal("rests","discount",$rest_id);
		$dis_min=getVal("rests","dis_min",$rest_id);

if ( isset($prod_id) && $prod_id && isset( $_REQUEST['cmd']) && $_REQUEST['cmd']=="add") {
	$isExist=getSqlNumber("select prod_id from cart where session_id='".$session_id."' and prod_id=".$prod_id." and extras=''");

/* CHECK STOCK AVAILABILITY */
$addp=getSqlRow("SELECT * FROM products WHERE id='".$prod_id."'");
if ( $addp['stock'] == "2" && $addp['stock_qty'] > "0" || $addp['stock'] < "2" ) { 

	if ($isExist) {

$mqty=getSqlRow("select qty from cart where session_id='".$session_id."' and prod_id=".$prod_id."");

if ( $addp['stock'] == "2" && $mqty['qty'] < $addp['stock_qty'] || $addp['stock'] < "2" )
{
	if($mqty['qty'] < "10")
	{ 
			@mysql_query("update cart set qty=qty+1 where session_id='".$session_id."' and prod_id=".$prod_id." "); 		
	}
	else
	{ echo ""; }

} else { echo "<script> alert('Limited Stock! ,No more stock available.'); </script>"; }


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

if ($cart_id && isset( $_REQUEST['cmd'])&& $_REQUEST['cmd']=="update_qty") {

	/* CHECK STOCK AVAILABILITY */
	$cpid=getVal("cart","prod_id",$cart_id);
	$cpqty=getVal("cart","qty",$cart_id);
	$caddp=getSqlRow("SELECT * FROM products WHERE id='".$cpid."'");

if ( $caddp['stock'] == "2" && $cpqty < $caddp['stock_qty'] || $caddp['stock'] == "2" && $_REQUEST['qty'] < $cpqty || $caddp['stock'] < "2" )
	{
	@mysql_query("update cart set qty=".safe($_REQUEST['qty'])." where id=".$cart_id."");
	} else { echo "<script> sweetAlert('Limited Stock!','Sorry, No more stock available.','warning'); </script>"; }

}

if ($cart_id && isset( $_REQUEST['cmd'])&&  $_REQUEST['cmd']=="update_extra") {

			$extra_amount=mysql_query("SELECT extra_total FROM cart where id=".$cart_id." ");
			$extra_amt  = mysql_fetch_array($extra_amount);
			$price = safe($_REQUEST['price']);
			$qty = safe($_REQUEST['qty']);	
			$extra_sum  = $extra_amt['extra_total'] +($price*$qty); 
		@mysql_query("update cart set extras='".safe($_REQUEST['extras'])."',extra_total=".$extra_sum." where id=".$cart_id."");
		
}

if ($cart_id=="all" && isset( $_REQUEST['cmd']) && $_REQUEST['cmd']=="remove") {
	@mysql_query("delete from cart where session_id='".$session_id."'");
}

if ($cart_id && $cart_id!="all"  && isset( $_REQUEST['cmd'])&& $_REQUEST['cmd']=="remove") {
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
echo $cart_empty_msg ;
} else {
	    echo "<div class='desktop-cart__order'>";
     echo  "<div class='checkout__summary' style='max-height:62.0313px;'>";
  echo "<table class='summary__items desktop-cart__products' style='width:100%;'>";
echo "<tbody class='cart__item'>";
?>
<!-- ITEM HEADER -->
<tr style="border-bottom:1px solid #ddd;cursor:text"><td><b>Item</b></td><td><center><b>Qty &nbsp;</b></center></td><td style="text-align:right;"><b>Price</b></td><td></td></tr>
<?php
$getRss= mysql_query("SELECT * FROM cart where session_id='".$session_id."' and rest_id=".$rest_id." order by added_date asc");
while ($rss = mysql_fetch_array($getRss)) {
	$rsp=getSqlRow("select * from products where id=".$rss['prod_id']."");
	$extras_array=explode(",",$rss['extras']);
?>
<tr>
<!-- ITEM NAME -->
<td style="font-size:11.6px;padding:0px;padding-top:8px;width: 130px;cursor:text"><?php if (strlen($rsp['name']) >= 20) { echo substr($rsp['name'], 0, 20). ".."; } else { echo $rsp['name']; }?> 

<?php 
if ( $rsp['stock'] == "2" && $rss['qty'] > $rsp['stock_qty'] )
{ echo "<font color='red'>(No Stock)</font>"; }
?>
</td>
<!-- ITEM QUANTITY -->
<td style="width:75px;font-size:14px;padding-top:8px;cursor:text"><center>
<a href="javascript:void(0);" title="Add" <?php if( $rss['qty'] < 10 ) { ?> onclick="updateQty2(<?php echo $rss['id']?>,<?php echo($rss['qty']+1);?>);" <?php  } ?>><i class="fa fa-plus-circle fa-1x"></i></a>
<?php if($rss['qty'] < 10 ) { echo $rss['qty'].""; } else { echo $rss['qty']; } ?>&nbsp;
<a href="javascript:void(0);" title="Remove" <?php  if( $rss['qty'] > 1 ) { ?> onclick="updateQty2(<?php echo $rss['id']; ?>,<?php echo ($rss['qty']-1);?>);" <? } ?>><i class="fa fa-minus-circle fa-1x"></i></a> 
</center>
</td>
<!-- ITEM PRICE -->
<td style="text-align:right;width:55px;font-size:12px;padding-top:8px;cursor:text">
<?php
	if($rsp['proprice']>0)
		$price=$rsp['proprice'];
	else
		$price=$rsp['price']; 	
	
	
	$rupee= $price*$rss['qty'];
	echo "<span class='fa fa-inr' >&nbsp;</span>".$rupee;
	$price=($price*$rss['qty']);
	$price=number_format($price,2,".","");
	$sub_total=$sub_total+$price;
	

	?>
</td>
<?php // Extras will be added later to slider iteself
//  echo "<tr><td colspan='4' style='font-size:12px;padding-top:8px;'><font style='font-size:13px;color:#DB1921;'><b>" . $roc2['name'] . "</b></font><br/>";
/* $getRoc3 = mysql_query("SELECT * FROM optionals where id IN (" . $roc2['items'] . ") order by id asc");
while ($roc3 = @mysql_fetch_array($getRoc3)) { /* Start of While  (1)
<!--<input type="checkbox" style="padding-top:2px;" name="extra_<?php echo $roc3['id']; ?>" id="extra_<?php echo $roc3['id']; ?>" value="<?php echo $roc3['id']; ?>" class="extras_cb cb_<?php echo $rss['id']; ?>" onclick="updateExtras(<?php echo $rss['id']; ?>);" <?php  if (in_array($roc3['id'],$extras_array)) echo "checked='true'"; ?>  ><?php echo $roc3['optional']; ?> [<?php echo setPrice($roc3['price']);?>]</td></tr> -->
	*/ ?>

<!-- ITEM REMOVE ICON-->
<td style="width:15px;text-align:center;font-size:12px;padding-top:6px;">
<a href="javascript:void(0);" onclick="remove_cart(<?php echo $rss['id']; ?>)" title="<?php echo $GLOBALS['remove']; ?> - <?php echo $rsp['name']; ?>"><img src="images/delete.gif" alt="<?php echo $GLOBALS['remove']; ?> - <?php echo $rsp['name']; ?>" /></a></td>
</tr>
<?php
$Extras = mysql_query("SELECT * FROM optional_group where proid=".$rsp['id']." order by id asc");
$extras_id= @mysql_fetch_array($Extras); 
$extras_info = mysql_query("SELECT * FROM extra_group where id=".$extras_id['egid']." order by id asc");
$extras_items = @mysql_fetch_array($extras_info);
// If there is any extras show Customise button .
if ($extras_items['items']) { 
?>
<!-- EXTRAS WILL BE ADDED DIRECTLY TO POP UP  STARTS -->
<tr style="border-bottom: 1px solid #eee;">
	<td style="width: 140px;" >
	<a data-toggle="modal" id="<?php echo $rss['id']; ?>" data-target="#edit-modal">Customise <span class="fa fa-arrow-right"></span></a>
	</td>
	 <td ></td><td></td><td></td><!-- Bottom line adder -->
</tr>
<!-- EXTRAS WILL BE ADDED DIRECTLY TO POP UP ENDS -->

<?php  
			}// END of IF CONDITION 
      echo "</td></tr>";
}
?>
</tbody>
</table>
 </div>
</div><!-- Actual Cart Ends -->
<div class="desktop-cart__footer"><!-- OUTER CONTAINER -->
<div class="desktop-cart__order__subtotal-container"> <!-- INNER CONTAINER -->
		<!-- SUB TOTAL -->
		<div class="desktop-cart__order__subtotal">
				<span><?php echo $GLOBALS['subtotal']; ?></span><span class="desktop-cart__order__subtotal-price"><?php echo setPrice($sub_total);?> <a href="javascript:void(0);" onclick="remove_cart2('all')" title="<?php echo $GLOBALS['empty_cart']; ?>"><img src="images/delete.gif" /></a></span>
       </div>
    <!-- EXTRAS IF ANY-->	
<?php 	$extra_1=mysql_query("SELECT sum(extra_total)as final FROM cart where session_id='".$session_id."' ");
		$extra_2  = mysql_fetch_array($extra_1);
		$extra_total=$extra_2['final'];
			?>	
		<?php if ($extra_total >0) { ?>
		<div class="desktop-cart__order__extra">
			<span><?php echo $GLOBALS['extras']; ?> &nbsp; <span class="desktop-cart__order__extras"><?php echo setPrice($extra_total);?></span></span>
		</div>
	  <?php  } ?>

	 <!-- TAXES IF ANY -->	  
			<?php /* if ($rest_tax>0) { */
			$tax_total=number_format(($sub_total+$extra_total)*$rest_tax/100,2,".","");
			$tax_total = ceil($tax_total);	
			?>
			<div class="desktop-cart__order__vat">
				<span>Taxes &nbsp; <span class="desktop-cart__order__vat-price desktop-cart__order__vat-total"><?php echo setPrice($tax_total);?></span></span>
			</div>
			<?php  /* }*/  ?>
			
		 <!-- Delivery FEE IF ANY  -->	
		  <div class="desktop-cart__order__delivery">
        <span><?php echo $GLOBALS['service_fee_text']; ?> &nbsp; <span class="desktop-cart__order__delivery-price"><?php echo setPrice($service_fee);?></span></span>
        </div>

        <!-- Packaging FEE IF ANY  -->	
		  <div class="desktop-cart__order__packaging">
        <span><?php echo "Packaging Fees"; ?> &nbsp; <span class="desktop-cart__order__delivery-price"><?php echo setPrice($pfees);?></span></span>
        </div>

		 <!-- DISCOUNT IF ANY  -->
		<?php if ($discount>0) { 
			if ( ($sub_total+$extra_total) >= $dis_min )
					{ $discount_total=number_format(($sub_total+$extra_total)*$discount/100,2,".","");

			?>
			<div class="">
					<span>Discount &nbsp; <span class="desktop-cart__order__min-order-value"><?php echo $discount; ?></span>%</span></br>
					<span>Discount Total: <span class="desktop-cart__order__min-order-value"><?php echo setPrice($discount_total);?></span></span>
		</div>
			<?php  }?>
			<?php  } ?>
			
			 <!-- FINAL CART TOTAL  -->
			 <?php
					$ctotal = $tax_total+$sub_total+$service_fee+$pfees+$extra_total-$discount_total;
					$ctotal = round($ctotal);
				?>
			<div class="desktop-cart__order-total-container">
			<div class="desktop-cart__order__total">
            <span><?php echo $GLOBALS['total_amount']; ?><em class="desktop-cart__order__total-note"> </em>
            <span class="desktop-cart__order__total-price"><?php echo setPrice($ctotal); ?></span></span>
			</div>
		  </div>
		
			
			<!-- PROCEED TO CHECK OUT -->
		<div class="desktop-cart__order__checkout_button_container">
			<?php
				$rest_isopen = getSqlNumber("SELECT id FROM rests where id=".$rest_id." and status=1");
				$rsoc=getSqlRow("select * from site_timing where resid=".$rest_id." and dateday=".date('w')."");
			if ($rest_isopen && checkRestHour($rsoc['open1'],$rsoc['close1'],$rsoc['open2'],$rsoc['close2'],$rsoc['open3'],$rsoc['close3'])) {
			?>
			<?php if ($ctotal >= $cr['min']) { ?>
			<form id="proceedToLogin"  action="your-details.php" method="POST">
			<input type="hidden" name="r" value="<?php echo $rest_id; ?>" />
			<input type="hidden" name="s" value="<?php echo $sub_total; ?>" />
			<input type="hidden" name="c" value="<?php echo $ctotal; ?>" />
			</form>
		<a href="javascript:void(0);" onclick="document.getElementById('proceedToLogin').submit();" class="ordernow" title="<?php echo $GLOBALS['order_now']; ?>">
		 <button class="buttonc btn-checkout button--full-width">
        <span class="button__text">PROCEED TO CHECKOUT</span>
          </button></a>
			<?php $_SESSION['cart_approve'] = "2"; ?>
			<?php } else { ?>
			<button class="button--disabled button--full-width">
			<span>Minimum Order is <?php echo setPrice($cr['min']);?></span></button>
			<?php $_SESSION['cart_approve'] = "1"; ?>
			<?php  } ?>
		<?php  } else { ?>
		<button class="button--disabled button--full-width">
		<span><?php echo $GLOBALS['rest_closed_msg']; ?></span></button>
		<?php  } ?>
		</div>
     </div><!-- INNER CONTAINER END-->
	 </div><!-- OUTER CONTAINER END-->
<?php  }/* End of Else */?>

<?php if ((isset($prod_id )&& $prod_id) || (isset($cart_id)&& $cart_id)) { ?>
<script>
// $("#span_cart_loading").html('');
$("#span_addcart_<?php if(isset($prod_id)){echo $prod_id; }?>").html('<a href="javascript:void(0);" onclick="addCart(<?php echo $prod_id; ?>);" title="<?php echo $GLOBALS['add_cart'];?>"><img src="img/cd-icon-cart.svg" height="25px" width="25px" style="padding:0px 4px;" alt="<?php echo $GLOBALS['add_cart']; ?>" /></a>');
</script>
<?php  }else { echo $cart_empty_msg; }} ?>
<!--
<div id="fz-footer">
<div class="wrap">
<a href="#div_cart"><i class="fa fa-shopping-cart fa-1x"></i>&nbsp; <?=setPrice($ctotal);?></a> &nbsp; | &nbsp; 
<a href="#"><i class="fa fa-arrow-up fa-1x"></i> TOP</a>
</div>
</div>

-->
