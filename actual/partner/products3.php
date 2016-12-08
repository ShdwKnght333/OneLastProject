<?
include "../conf/config.php";
include "check_login.php"; 


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Products</title>
<? include "styles.php"; ?>

<script language="JavaScript" type="text/javascript">
function Del(id) {
     if(!confirm('Are you going to delete this product!\nIs it ok?')) return false;
    $("#result").load("../conf/post_admin.php?cmd=del_product&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
}


function set_product_status(id,val) {
	$("#result").load("../conf/post_admin.php?cmd=set_product_status&back=<?=$_SERVER['PHP_SELF']?>&id="+id+"&val="+val);
}

</script>

</head>

<body>


<? include "header.php";
include "sub_products.php";
 ?>

<div id="content">
<div id="container">
<br/>
<h1 class="h1">Products</h1>

<table width="100%">
  <tr>
    <td width="25%" class="tdheader">Menu</td>
    <td width="40%" class="tdheader">Product</td>
    <td width="15%" class="tdheader" style="text-align:right;">Price</td>
    <td width="20%" class="tdheader" style="text-align:center;">Status</td>
  </tr>
  <?
/*
$getRs = mysql_query("SELECT products.id,products.name,products.price,menus.menu,products.status,products.details FROM products,menus where products.resid=".$_SESSION['restaid']." and products.menuid=menus.id order by menus.menu asc"); 
*/
$getRs = mysql_query("SELECT * FROM products where resid='".$_SESSION['restaid']."' order by id asc"); 

while ($rs = @mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
$cnt++
?>
  <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>"><?=getval( "menus", "menu", $rs['menuid'] ); ?></td>
    <td class="<?=$class?>"><?=$cnt?>. <a href="product.php?id=<?=$rs['id'];?>"><?=$rs['name'];?></a><br />
	<?=$rs['details'];?></td>
    <td class="<?=$class?>" style="text-align:right;"><?=setPrice($rs['price']);?></td>
    <td class="<?=$class?>" style="text-align:center;">


<input type="radio" name="status_<?=$rs['id'];?>" id="status_<?=$rs['id'];?>" value="1" onclick='set_product_status(<?=$rs['id'];?>,this.value);' <? if ($rs['status']==1) echo "checked"; ?>> On &nbsp; 
	<input type="radio" name="status_<?=$rs['id'];?>" id="status_<?=$rs['id'];?>" value="0" onclick='set_product_status(<?=$rs['id'];?>,this.value);' <? if ($rs['status']==0) echo "checked"; ?>> Off &nbsp;  &nbsp; 
	[<a href="javascript:void(0)" title="Delete" onclick='Del(<?=$rs['id'];?>);'>X</a>]
	</td>
  </tr>
<? } ?>
</table>

<br/><br/>

</div>
</div>


<? include "footer.php"; ?>


</body>
</html>