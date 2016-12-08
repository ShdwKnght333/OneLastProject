<?
include "conf/config.php";
checkLogin();
$rs=getSqlRow("select * from users where id=".$_SESSION['memberid']."");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>My Addresses</title>
<? include "inc/styles.php"; ?>
<script>
function setAddress(id) {
	$("#span_address_loading").show();
	$("#result").load("conf/post.php?cmd=set_address&id="+id);
}
</script>
</head>
<body>

<div class="mainbody">

<? include "inc/header.php"; ?>
                

<div id="content" class="container_12">
<div class="grid_12">
<h1><?=$GLOBALS['delivery_addresses']?></h1>
<div>


<form id="myform" name="myform" method="post" action="javascript:void(null);">
  <input type="hidden" name="cmd" id="cmd" value="save_address" />
<table class="fonrm_table">

<tr>
<td style="width:150px;"><?=$GLOBALS['addresses']?></td>
<td style="height:30px;"><select name="address_id" id="address_id" style="width:203px;" onchange="setAddress(this.value);" class="input-text">
<option value=""><?=$GLOBALS['new_address']?></option>
<?
$getRss= mysql_query("SELECT * FROM delivery_addresses where userid=".$_SESSION['memberid']." order by nick asc");
while ($rss = mysql_fetch_array($getRss)) {
?>
<option value="<?=$rss['id']?>"><?=$rss['nick']?></option>
<? } ?>
</select> <span id="span_address_loading" style="display:none;"><img src="img/loading.gif"  /></span></td>
</tr>


<tr>
<td>Nickname</td>
<td><input type="text" name="nick" id="nick" value="" style="width:185px;" maxlength="50" class="input-text" /></td>
</tr>

<tr>
<td>Name</td>
<td><input type="text" name="name" id="name" value="" style="width:185px;" maxlength="100" class="input-text" /></td>
</tr>


<tr>
<td>Mobile</td>
<td><input type="text" name="mobilphone" id="mobilphone" value="" style="width:185px;" maxlength="50" class="input-text" /></td>
</tr>

<tr>
<td style="vertical-align:top;"><?=$GLOBALS['address']?></td>
<td><textarea name="address" id="address" style="width:185px;height:70px;" class="input-text"></textarea></td>
</tr>

<tr>
<td style="padding-top:8px;"><?=$GLOBALS['city']?></td>
<td style="padding-top:8px;"><select name="city" id="city" style="width:203px;" class="input-text">
	<option value="">---</option>
	<? $getRss = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'");
	while ($rss = mysql_fetch_array($getRss)) { ?>
	<option value="<?=$rss['region'];?>"><?=$rss['region'];?></option>
	<? } 
	?>
	</select></td>
</tr>

<tr>
<td><?=$GLOBALS['postcode']?></td>
<td><input type="text" name="postcode" id="postcode" value="" style="width:185px;" maxlength="10" onkeyup='this.value=this.value.replace(/[^\d]*/gi,"");' class="input-text" /></td>
</tr>

  <tr>
 <td ></td>
 <td style="height:30px;"><input name="sbt" id="sbt" class="b22" type="submit" value="<?=$GLOBALS['save']?>" onclick='this.disabled=true;loading("span_loading",1); post("myform"); return false;' /> <span id="span_loading"></span></td>
 </tr>
 
 </table>
 
</form>
<br/><br/>

</div>
</div>
</div>
            

<? include "inc/footer.php"; ?>
            
<div class="clearfix"></div>
</div>

</body>
</html>