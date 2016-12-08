<?
include "../conf/config.php";
include "check_login.php"; 


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Categories</title>
<? include "styles.php"; ?>

<script language="JavaScript" type="text/javascript">
function Del(id) {
     if(!confirm('Are you going to delete this category!\nIs it ok?')) return false;
    $("#result").load("../conf/post_admin.php?cmd=del_category&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
}

</script>

</head>

<body>


<? include "header.php";
include "sub_products.php";
 ?>

<div id="content">
<div id="container">
<h1 class="h1">Optional Categories</h1>

<table width="500">
  <tr>
    <td width="50%" class="tdheader">Name</td>
    <td width="20%" class="tdheader">Max.</td>
    <td width="15%" class="tdheader">Details</td>
    <td width="15%" class="tdheader">Delete</td>
  </tr>
  <?

$getRs = mysql_query("SELECT * FROM extra_group where resid='".$_SESSION['restaid']."' order by id asc"); 

while ($rs = @mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
$cnt++
?>
  <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>"><?=$cnt?>. <?=$rs['name']?></td>
    <td class="<?=$class?>"><?=$rs['max']?></td>

    <td class="<?=$class?>"><a href="extra-item.php?id=<?=$rs['id'];?>">Edit</a></td>

    <td class="<?=$class?>">[<a href="javascript:void(0)" title="Delete" onclick='Del(<?=$rs['id'];?>);'>X</a>]
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