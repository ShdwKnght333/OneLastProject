<?
include "../conf/config.php";
include "check_login.php"; 


if ($_REQUEST['id']) {
	$id=safe($_REQUEST['id']);
	$varmi = getSqlNumber("SELECT id FROM products WHERE id=".$id."");
	if ($varmi==0) {
		echo "<script>document.location.href='products.php'</script>";
		exit;
	}
	$rs=getSqlRow("SELECT * FROM products WHERE id=".$id."");
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Product Information</title>
<? include "styles.php";  ?>
<style>
.frame {
	clear:both; 
	font-size:12px;
	height: 150px; 
	width: 100%; 
	overflow: auto; background:#F5F5F5;
}
</style>

</head>
<body>


<? include "header.php";
include "sub_products.php"; ?>

<div id="content">
<div id="container">
<br/>
<h1 class="h1">Product Information</h1>

<?
//PLEASE DONT REMOVE THIS CODE
$productcount = getSqlNumber("SELECT id FROM products");
?>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="id" id="id" value="<?=$rs['id']?>" />
<input type="hidden" name="pictureold" id="pictureold" value="<?=$rs['picture']?>" />
<input type="hidden" name="cmd" id="cmd" value="save_product" />
<table width="700" style="line-height:30px;">

   <tr>
    <td>Status</td>
    <td>
    <input type="radio" name="status" id="status" value="1" <? if ( $rs['status'] =="1" || !$rs['status'] ) echo "checked"; ?>> Active 
    <input type="radio" name="status" id="status" value="0" <? if ( $rs['status']=="0" ) echo "checked"; ?>> Suspend <br/><br/>
    </td>
  </tr>

  <tr>
    <td width="30%">Product Name</td>
    <td width="70%"><input type="text" name="name" id="name" value="<?=$rs['name']?>" style="width:300px;" maxlength="100" class="input-text"></td>
  </tr>

  <tr>
    <td width="30%">Barcode / Identity No.</td>
    <td width="70%"><input type="text" name="barcode" id="barcode" value="<?=$rs['barcode']?>" style="width:300px;" maxlength="100" class="input-text"></td>
  </tr>

   <tr>
    <td width="30%" style="vertical-align:top;">Details (if exist)</td>
    <td width="70%"><textarea name="details" id="details" style="width:300px;height:60px;" class="input-text"><?=$rs['details']?></textarea></td>
  </tr>

<tr>
<td>Product Type</td><td>

<select name="type" id="type" style="width:318px;" class="input-text">
<option selected>--- Select ---</option>
<option value="1" style="color:green;" <? if ($rs['type']==1) echo "selected"; ?>>Vegetarian</option>
<option value="2" style="color:red;" <? if ($rs['type']==2) echo "selected"; ?>>Non-Vegetarian</option>
<option value="3" style="color:purple;" <? if ($rs['type']==3) echo "selected"; ?>>Alcohol</option>
<option value="4" <? if ($rs['type']==4) echo "selected"; ?>>Other</option>
</select>

</td>
</tr>

<tr>
    <td width="30%">Category</td>
    <td width="70%"><select name="menuid" id="menuid" style="width:318px;" class="input-text">
<option value="">--- Select ---</option>
<? 
$getRs = mysql_query("SELECT * FROM menus where status=1 and resid=".$_SESSION['restaid']." order by menu asc");
while ($rsi = mysql_fetch_array($getRs)) { ?>
<option value="<?=$rsi['id'];?>" <? if ($rs['menuid']==$rsi['id']) echo "selected"; ?>><?=$rsi['menu'];?></option>
<? } ?>
</select></td>
  </tr>

   <tr>
    <td>Price</td>
    <td><input type="text" name="price" id="price" value="<?=$rs['price']?>"  style="width:120px;text-align:right;" maxlength="6" class="input-text"> <?=CURRENCY?></td>
  </tr>
	<tr>
    <td>Promotion Price (if exist)</td>
    <td><input type="text" name="proprice" id="proprice" value="<?=$rs['proprice']?>"  style="width:120px;text-align:right;" maxlength="6" class="input-text"> <?=CURRENCY?></td>
  </tr>

<tr>
<td>Stock Management</td><td>
<select name="stock" id="stock" style="width:138px;" class="input-text">
<option>--- Select ---</option>
<option value="1" style="color:red;" <? if ($rs['stock']==1) echo "selected"; ?>>Not Required</option>
<option value="2" style="color:green;" <? if ($rs['stock']==2) echo "selected"; ?>>Required</option>
</select>
</td>
</tr>


<tr>
<td>Stock Availability</td>
<td>

<?php if ( !$_REQUEST['id'] ) { ?>
<input type="text" name="stock_qty" id="stock_qty" value="<?=$rs['stock_qty']?>"  style="width:120px;text-align:right;" maxlength="6" class="input-text"> Qty.
<?php } else {  ?>
<?=$rs['stock_qty']?> Qty.<br/><br/>
<?php } ?>
</td>
</tr>
  
  <tr>
    <td  style="vertical-align:top">Optionals</td>
    <td>
	<div class="frame">
<?
$getRss = mysql_query("SELECT * FROM extra_group where resid=".$_SESSION['restaid']." order by id asc");
while ($rss = @mysql_fetch_array($getRss)) {
	$checked=getSqlNumber("SELECT id FROM optional_group WHERE egid=".$rss['id']." and proid=".$rs['id']."");
?>
	<input type="checkbox" name="opt[]" id="opt[]" value="<?=$rss['id']?>" <? if ($checked) echo "checked"; ?> /><?=$rss['name']?><br/>
<? } ?>
	</div>
	
	</td>
  </tr>
  
  <tr>
    <td></td>
    <td><br/><input type="submit" name="sbt" id="sbt" value="Save" style="font-size:16px;" onclick='this.disabled=true; post_admin("myform"); return false;'  class="b22"></td>
  </tr>
</table>
</form>

<br/><br/>

</div>
</div>


<? include "footer.php"; ?>


</body>
</html>