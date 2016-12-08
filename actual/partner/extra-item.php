<?
include "../conf/config.php";
include "check_login.php"; 


if ($_REQUEST['id']) {
	$id=safe($_REQUEST['id']);
	$varmi = getSqlNumber("SELECT id FROM extra_group WHERE id=".$id."");
	if ($varmi==0) {
		echo "<script>document.location.href='extra-groups.php'</script>";
		exit;
	}

	$rg=getSqlRow("SELECT * FROM extra_group WHERE id=".$id."");
}

if (!$_REQUEST['id']) { $rg['max'] = "0"; }

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Category Information</title>
<? include "styles.php";  ?>
<style>
.frame {
	clear:both; 
	font-size:12px;
	height: 100px; 
	width: 100%; 
	overflow: auto; 
}
</style>

</head>
<body>


<? include "header.php";
include "sub_products.php"; ?>

<div id="content">
<div id="container">
<h1 class="h1">Category Form</h1>

<?
//PLEASE DONT REMOVE THIS CODE
$productcount = getSqlNumber("SELECT id FROM extra_group");


if ($_REQUEST['id']) { $items = getSqlField("SELECT items FROM extra_group WHERE id=".$id."","items"); }
$getRs = mysql_query("SELECT * FROM optionals WHERE resid=".$_SESSION['restaid']." order by id asc");

?>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="id" id="id" value="<?=$rg['id']?>" />
<input type="hidden" name="cmd" id="cmd" value="save_extra_group" />

<table width="460" style="line-height:30px;">
  <tr>
    <td width="30%">Category Name</td>

<td width="70%"><input type="text" name="name" id="name" value="<?=$rg['name']?>" style="width:280px;" class="input-text" maxlength="100" placeholder="Ex: Select Fillings! (Choose any 3)"></td>
  </tr>
  <tr>
    <td width="30%">Max. Selection</td>
    <td width="70%"><input type="text" name="max" id="max" value="<?=$rg['max']?>" class="input-text" style="width:50px;" maxlength="100"> ( 0 = All Optionals can be used )</td>
  </tr>
</table>
<br/>

<table width="400">
  <tr>
    <td width="90%" class="tdheader">Optionals</td>
    <td width="10%" class="tdheader"></td>
  </tr>

<?
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
   <tr>
    <td class="<?=$class?>"><?=$rs['optional'];?> - <?=setPrice($rs['price']);?></td>
    <td class="<?=$class?>"><input type="checkbox" name="egroup[]" id="egroup[]" value="<?=$rs['id'];?>"  <? if (substr_count($items,$rs['id'])>0) echo "checked"; ?>></td>
  </tr>
<? } ?>
</table>

<br/>
<input type="submit" name="sbt" id="sbt" value="Save" style="font-size:16px;" onclick='this.disabled=true; post_admin("myform"); return false;'>

</form>

</div>
</div>


<? include "footer.php"; ?>


</body>
</html>