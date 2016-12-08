<?
include "../conf/config.php";
include "check_login.php"; 

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Promotions</title>
<? include "styles.php"; ?>
<script LANGUAGE="JavaScript" TYPE="text/javascript">
function Sil(id) {
     if(!confirm('Dou you want to delete the promotion!\nIs it ok?')) return false;
    $("#result").load("../conf/post_admin.php?cmd=del_promotion&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
}

</script>
</head>

<body>


<? include "header.php"; 

if ($_REQUEST['id']) {
	$id=safe($_REQUEST['id']);
	$rs=getSqlRow("SELECT * FROM promotions where resid=".$_SESSION['restaid']." and id=".$id."");
}
?>

<div id="content">
<div id="container">
<h1 class="h1">Promotions</h1>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="id" id="id" value="<?=$rs['id']?>" />
<input type="hidden" name="cmd" id="cmd" value="save_promotion" />
Promotion Note : <input type="text" name="promotion" id="promotion" value="<?=$rs['promotion']?>" style="width:700px" maxlength="250" /><input type="submit" name="sbt" id="sbt" value="Save" style="font-size:14px;" onclick='this.disabled=true; post_admin("myform"); return false;' />
</form>
<br />
<table width="100%">
  <tr>
    <td width="85%" class="tdheader">Promotion</td>
    <td width="15%" class="tdheader" style="text-align:center;">Edit | Del</td>
  </tr>
<?
$getRs = mysql_query("SELECT * FROM promotions where resid=".$_SESSION['restaid']." order by id desc");
while ($rs = @mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
    <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>"><?=$rs['promotion'];?></td>
	<td class="<?=$class?>" style="text-align:center;"><a href="<?=$_SERVER['PHP_SELF']?>?id=<?=$rs['id'];?>">Edit</a> | <a href="#" onclick='Sil(<?=$rs['id'];?>);'>Del</a></td>
  </tr>
<? } ?>
</table>


</div>
</div>


<? include "footer.php"; ?>


</body>
</html>