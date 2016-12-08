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
     if(!confirm('If you delete the menu, products will be delete under this menu!\nIs it ok?')) return false;
    $("#result").load("../conf/post_admin.php?cmd=del_menu&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
}


function set_menu_status(id,val) {
	$("#result").load("../conf/post_admin.php?cmd=set_menu_status&back=<?=$_SERVER['PHP_SELF']?>&id="+id+"&val="+val);
}


</script>
</head>
<body>

<? include "header.php";
include "sub_products.php";

if ($_REQUEST['id']) {
	$id=safe($_REQUEST['id']);
	$rs=getSqlRow("SELECT * FROM menus where resid=".$_SESSION['restaid']." and id=".$id."");
}
?>

<div id="content">
<div id="container">
<br/>
<h1 class="h1">Categories</h1>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="save_menu" />
<input type="hidden" name="id" id="id" value="<?=$rs['id']?>" />
Name:<br />
<input type="text" name="menu" id="menu" value="<?=$rs['menu']?>" style="width:450px" class="input-text" maxlength="100"><br />
Description:<br />
<textarea name="description" id="description" class="input-text" style="width:450px;height:50px;"><?=$rs['description']?></textarea><br />

<?php 
$query_group = mysql_query("SELECT * FROM menus_group WHERE resid=".$_SESSION['restaid']."");
?>
Group: <br />
        <select class="input-text" type="text" name="gpid" id="gpid" style="width:470px"> 
        <option value="0">None</option>
        <?php while($row = mysql_fetch_array($query_group)): ?>
        <option value="<?=$row['id'];?>" <?php if( $row['id'] == $rs['gpid'] ) { echo "selected"; } ?>><?=$row['gp_name'];?></option>
        <?php endwhile; ?>
        </select><br />

Priority:<br />
<input type="text" name="priority" id="priority" placeholder="(Optional)" class="input-text" value="<?=$rs['priority']?>" style="width:100px" maxlength="100"> 

&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; 
Flash as NEW : <input type="checkbox" name="flash" id="flash" value="1" <? if ($rs['flash']=="1") echo 'checked="true"'; ?>><br /><br />

<input type="submit" name="sbt" id="sbt" value="Save" style="font-size:14px;" onclick='this.disabled=true; post_admin("myform"); return false;'>
</form>

<br />
<table width="100%">
  <tr>
    <td width="40%" class="tdheader">Menu</td>
    <td width="20%" class="tdheader">Priority</td>
    <td width="20%" class="tdheader">Status</td>
    <td width="20%" class="tdheader" style="text-align:center;">Del</td>
  </tr>
<?
$getRs = mysql_query("SELECT * FROM menus where resid=".$_SESSION['restaid']." order by id asc");
while ($rs = @mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
    <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>"><b><?=$rs['menu'];?></b> <? if ($rs['flash']=="1") echo '<img src="/img/new.gif">'; ?><br/><?=$rs['description'];?></td>
    <td class="<?=$class?>"><?=$rs['priority'];?></td>
    <td class="<?=$class?>">
	<input type="radio" name="status_<?=$rs['id'];?>" id="status_<?=$rs['id'];?>" value="1" onclick='set_menu_status(<?=$rs['id'];?>,this.value);' <? if ($rs['status']==1) echo "checked"; ?>> ON
	<input type="radio" name="status_<?=$rs['id'];?>" id="status_<?=$rs['id'];?>" value="0" onclick='set_menu_status(<?=$rs['id'];?>,this.value);' <? if ($rs['status']==0) echo "checked"; ?>> OFF 
	</td>
	<td class="<?=$class?>" style="text-align:center;"><a href="<?=$_SERVER['PHP_SELF']?>?id=<?=$rs['id'];?>">Edit</a> | <a href="#" onclick='Del(<?=$rs['id'];?>);'>Del</a></td>
  </tr>
<? } ?>
</table>

<br/><br/>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>