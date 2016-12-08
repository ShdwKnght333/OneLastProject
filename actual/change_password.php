<?
include "conf/config.php";

//forgot pass login start
if ($_REQUEST['fp']) {
	$rs=getSqlRow("select id from users where forgot_pass='".safe($_REQUEST['fp'])."'");
	if ($rs['id']) {
		$_SESSION['memberid']=$rs['id'];
		mysql_query("update users set forgot_pass='' where id=".$rs['id']."");
	}
}
//forgot pass login end

checkLogin();

$rs=getSqlRow("select * from users where id=".$_SESSION['memberid']."");

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>My Details</title>
<? include "inc/styles.php"; ?>
</head>
<body>

<div class="mainbody">

<? include "inc/header.php"; ?>
                

<div id="content" class="container_12">
<div class="grid_12">
<h1>Change Password</h1>
<div>


<form id="myform" name="myform" method="post" action="javascript:void(null);">
  <input type="hidden" name="cmd" id="cmd" value="change_pass" />
<table class="fonrm_table">
  <tr>
 <td colspan="2" class="t22"><?=$rs['email']?><input type="hidden" name="email" id="email" value="<?=$rs['email']?>" readonly="true" maxlength="100" style="width:300px;" class="input-text" /></td>
 </tr>
 <tr>
 <td style="width:150px;" class="t22"><br/><?=$GLOBALS['password']?></td>
 <td><br/><input type="password" name="password" id="password" maxlength="20" style="width:185px;" class="input-text" /></td>
 </tr>
<tr>
 <td class="t22"><?=$GLOBALS['password_confirm']?></td>
 <td><input type="password" name="password_confirm" id="password_confirm" maxlength="20" style="width:185px;" class="input-text" /></td>
 </tr>

  <tr>
 <td ></td>
 <td style="height:30px;"><input name="sbt" id="sbt" class="b22" type="submit" value="Change my password"  onclick='this.disabled=true;loading("span_loading",1); post("myform"); return false;' /> <span id="span_loading"></span></td>
 </tr>
 
 </table>
 
 
 </form>

</div>
</div>
</div>
            

<? include "inc/footer.php"; ?>
            
<div class="clearfix"></div>
</div>

</body>
</html>