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
		$service_fee = $ec43['dfees'];

		$cr=getSqlRow("select min from rest_delivery_area where rest_id='".$rest_id."' and da_id='".$s_a12['id']."'");	
		$discount=getVal("rests","discount",$rest_id);
		$dis_min=getVal("rests","dis_min",$rest_id);


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
<tr style="border-bottom:1px solid #ddd;"><td><b>Item</b></td><td><center><b>Qty &nbsp;</b></center></td><td style="text-align:right;"><b>Price</b></td><td></td></tr>
<?php
$getRss= mysql_query("SELECT * FROM cart where session_id='".$session_id."' and rest_id=".$rest_id." order by added_date asc");
while ($rss = mysql_fetch_array($getRss)) {
	$rsp=getSqlRow("select * from products where id=".$rss['prod_id']."");
	$extras_array=explode(",",$rss['extras']);
?>
<tr>
<!-- ITEM NAME -->
<td style="font-size:12px;padding:0px;padding-top:8px;width: 60%;"><?php if (strlen($rsp['name']) >= 20) { echo substr($rsp['name'], 0, 20). ".."; } else { echo $rsp['name']; }?> 

<?php 
if ( $rsp['stock'] == "2" && $rss['qty'] > $rsp['stock_qty'] )
{ echo "<font color='red'>(No Stock)</font>"; }
?>
<?php /* ?><br/> - <? $price1=($rsp['proprice']>0)?$rsp['proprice']:$rsp['price']; 	echo setPrice($price1); ?><? */ ?>
</td>
<!-- ITEM QUANTITY -->
<td style="width:20%;font-size:14px;padding-top:8px;"><center>
<?php if($rss['qty'] < 10 ) { echo $rss['qty'].""; } else { echo $rss['qty']; } ?>&nbsp;
</center>
</td>
<!-- ITEM PRICE -->
<td style="text-align:right;width:20%;font-size:12px;padding-top:8px;">
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
</tr>
<?php
$Extras = mysql_query("SELECT * FROM optional_group where proid=".$rsp['id']." order by id asc");
$extras_id= @mysql_fetch_array($Extras); 
$extras_info = mysql_query("SELECT * FROM extra_group where id=".$extras_id['egid']." order by id asc");
$extras_items = @mysql_fetch_array($extras_info);
?>
<?php  
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
				<span><?php echo $GLOBALS['subtotal']; ?></span><span class="desktop-cart__order__subtotal-price"><?php echo setPrice($sub_total);?></span>
       </div>
    <!-- EXTRAS To be Added later in CSS-->	
<?php 	$extra_1=mysql_query("SELECT sum(extra_total)as final FROM cart where session_id='".$session_id."' ");
		$extra_2  = mysql_fetch_array($extra_1);
		$extra_total=$extra_2['final'];
			?>	
		<?php if ($extra_total >0) { ?>
		<div class="desktop-cart__order__extra">
			<span><?php echo $GLOBALS['extras']; ?> &nbsp;  <span class="desktop-cart__order__extras" style="float:right;"><?php echo setPrice($extra_total);?></span></span>
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
					$ctotal = $tax_total+$sub_total+$service_fee+$extra_total-$discount_total;
					$ctotal = round($ctotal);
				?>
			<div class="desktop-cart__order-total-container">
			<div class="desktop-cart__order__total">
            <span><b><em class="desktop-cart__order__total-note">Total &nbsp; 
            <span class="desktop-cart__order__total-price"><?php echo setPrice($ctotal);?></span></em></b></span>
			</div>
		  </div>
     </div><!-- INNER CONTAINER END-->
	 </div><!-- OUTER CONTAINER END-->
<?php  }/* End of Else */?>

<?php if ((isset($prod_id )&& $prod_id) || (isset($cart_id)&& $cart_id)) { ?>
<script>
// $("#span_cart_loading").html('');
$("#span_addcart_<?php if(isset($prod_id)){echo $prod_id; }?>").html('<a href="javascript:void(0);" onclick="addCart(<?php echo $prod_id; ?>);" title="<?php echo $GLOBALS['add_cart'];?>"><img src="img/cd-icon-cart.svg" height="25px" width="25px" style="padding:0px 4px;" alt="<?php echo $GLOBALS['add_cart']; ?>" /></a>');
</script>
<?php  }}else { echo $cart_empty_msg; } ?>