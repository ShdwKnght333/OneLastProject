<?
include "../conf/config.php";
include "check_login.php"; 

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Optionals</title>
<? include "styles.php"; ?>
<script language="JavaScript" type="text/javascript">
function Del(id) {
     if(!confirm('Are you sure?')) return false;
    $("#result").load("../conf/post_admin.php?cmd=del_optional&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
}

</script>
</head>
<body>

<? include "header.php";
include "sub_products.php";
if ($_REQUEST['id']) {
	$id=safe($_REQUEST['id']);
	$rs=getSqlRow("SELECT * FROM optionals where resid=".$_SESSION['restaid']." and id=".$id."");
}
 ?>

<div id="content">
<div id="container">
<h1 class="h1">Optionals</h1>

<?
if (!$rs['price']) $rs['price']=0;
?>
<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="id" id="id" value="<?=$rs['id']?>" />
<input type="hidden" name="cmd" id="cmd" value="save_optional" />
<table width="600" style="line-height:30px;">
  <tr>
    <td width="30%">Opt. Name</td>
    <td width="70%"><input type="text" name="optional" id="optional" value="<?=$rs['optional']?>" style="width:300px;" maxlength="100" class="input-text"></td>
  </tr>
  <tr>
    <td>Price</td>
    <td><input type="text" name="price" id="price" value="<?=$rs['price']?>"  style="width:60px;text-align:right;" maxlength="6" class="input-text"> <?=CURRENCY?>
	</td>
  </tr>

  <tr>
    <td></td>
    <td><input type="submit" name="sbt" id="sbt" value="Save" style="font-size:16px;" onclick='this.disabled=true; post_admin("myform"); return false;'></td>
  </tr>
</table>
</form>

<br />
<table width="500">
  <tr>
    <td width="55%" class="tdheader">Optional</td>
    <td width="30%" class="tdheader" style="text-align:right;">Price</td>
    <td width="15%" class="tdheader" style="text-align:center;">Del</td>
  </tr>
<?
$getRs = mysql_query("SELECT * FROM optionals where resid=".$_SESSION['restaid']." order by optional asc");
while ($rs = @mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
    <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>"><?=$rs['optional'];?></td>
    <td class="<?=$class?>" style="text-align:right;"><?=$rs['price'];?> <?=CURRENCY?></td>
	<td class="<?=$class?>" style="text-align:center;"><a href="<?=$_SERVER['PHP_SELF']?>?id=<?=$rs['id'];?>">Edit</a> | <a href="#" onclick='Del(<?=$rs['id'];?>);'>Del</a></td>
  </tr>
<? } ?>
</table>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>