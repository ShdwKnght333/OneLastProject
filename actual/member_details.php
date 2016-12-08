<?
include "conf/config.php";

// Email Verification Starts
if ($_REQUEST['fz']) {
	$rs=getSqlRow("select id from users where verify='".safe($_REQUEST['fz'])."'");
	if ($rs['id']) {
		$_SESSION['memberid']=$rs['id'];
		mysql_query("update users set verify='' where id=".$rs['id']."");
	}
}
// Email Verification end

checkLogin();
$rs=getSqlRow("select * from users where id=".$_SESSION['memberid']."");

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Personal Information</title>
<? include "inc/styles.php"; ?>
</head>
<body>

<div class="mainbody">

<? include "inc/header.php"; ?>
                

<div id="content" class="container_12">
<div class="grid_12">
<h1>Personal Information</h1>
<div>


<?php 
$query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'");
?>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
  <input type="hidden" name="cmd" id="cmd" value="save_member" />
<input type="hidden" name="back" id="back" value="<?=$_REQUEST['back']?>" />
<table class="fonrm_table">
  <tr>

<? if (!$rs['email'] == "" ) { ?>
<tr><td colspan="2"><?=$rs['email']?><input type="hidden" name="email" id="email" value="<?=$rs['email']?>" readonly="true" maxlength="100" style="width:185px;" class="input-text" /><br/><br/></td></tr>
<? } else { ?>
<tr><td style="width:150px;" class="t22">Email Address</td><td>
<input type="text" name="email" id="email" maxlength="100" style="width:185px;" class="input-text" /></td></tr>
<? } ?>


<? if ( $rs['dob'] == "" || $rs['dob'] == "00/00/0000" ) { ?>
<tr><td style="width:150px;" class="t22">Date of Birth</td><td>
<select class="input-text" type="text" name="dd" id="dd" style="width:58px;"> 
<option value='0' selected>dd</option>
<? for($j=1;$j<=31;$j++) { echo "<option value='"; if($j < 10){ echo '0' . $j; } else { echo $j; } echo "'>";
if($j < 10){ echo '0' . $j; } else { echo $j; } echo "</option>"; } ?>
</select>
<select class="input-text" type="text" name="mm" id="mm" style="width:64px;"> 
<option value='0' selected>mm</option>
<? for($j=1;$j<=12;$j++) { echo "<option value='"; if($j < 10){ echo '0' . $j; } else { echo $j; } echo "'>";
if($j < 10){ echo '0' . $j; } else { echo $j; } echo "</option>"; } ?>
</select>
<select class="input-text" type="text" name="yy" id="yy" style="width:74px;"> 
<option value='0' selected>yyyy</option>
<? for($j=$date('Y');$j>=($date('Y')-100);$j--) { echo "<option value='" . $j . "'>" . $j . "</option>"; } ?>
</select>
</td></tr>
<? } else { ?>
<tr><td style="width:150px;" class="t22">Date of Birth</td><td>
<? echo date("d-m-Y", strtotime($rs['dob'])); ?> <input type="hidden" name="dob" id="dob" value="<?=$rs['dob']?>" readonly="true" maxlength="100" class="input-text" /><br/><br/></td></tr>
<? } ?>

  <tr>
 <td class="t22">Name </td>
 <td><input type="text" name="name" id="name" value="<?=$rs['name']?>" maxlength="100" style="width:185px;" class="input-text" /></td>
 </tr>
  <tr>
 <td class="t22">Mobile </td>
 <td><input type="text" name="mobilphone" id="mobilphone" value="<?=$rs['mobilphone']?>"  placeholder="Enter 10 Digit Mobile Number" maxlength="100" style="width:185px;" class="input-text" /></td>
 </tr>


<tr><td>Gender </td>
<td><select name="gender" id="gender" class="input-text" style="width:203px;">
<option value="0" selected> --- </option>
<option value="1" <? if($rs['gender'] == "1") {echo "selected";} ?>>Male</option>
<option value="2" <? if($rs['gender'] == "2") {echo "selected";} ?>>Female</option>
</select></td>
</tr>


  <tr>
 <td style="width:150px;" class="t22">City </td><td>
        <select class="input-text" type="text" name="city" id="city" style="width:203px;"> 
        <option value="0" selected>Select City</option>
        <?php while($row = mysql_fetch_array($query_parent)): ?>
        <option value="<?=$row['region'];?>" <? if($row['region'] == $rs['city']) {echo "selected";} ?>><?=$row['region'];?></option>
        <?php endwhile; ?>
        </select>
</td>
 </tr>

 <tr>
 <td class="t22">Company</td>
 <td><input type="text" name="company" id="company" value="<?=$rs['company']?>" placeholder="optional" maxlength="100" style="width:185px;" class="input-text" /></td>
 </tr>

  <tr>
 <td class="t22">Telephone</td>
 <td><input type="text" name="phone" id="phone" value="<?=$rs['phone']?>" placeholder="optional" maxlength="100" style="width:185px;" class="input-text" /></td>
 </tr>

  <tr>
 <td ></td>
 <td style="height:30px;"><input name="sbt" class="b22" id="sbt" type="submit" value="<?=$GLOBALS['save']?>"  onclick='this.disabled=true;loading("span_loading",1); post("myform"); return false;' /> <span id="span_loading"></span></td>
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