<?
include "conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Registration</title>
<? include "inc/styles.php"; ?>

</head>
<body>

<div class="mainbody">

<? include "inc/header.php"; ?>

<div id="content" class="container_12">
<div class="grid_12">
<h1>Create a new account</h1>

<div class="page3">

<?php 
$query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'");
?>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
  <input type="hidden" name="cmd" id="cmd" value="register" />
 <table class="fonrm_table">

  <tr>
 <td class="t22">Email</td>
 <td><input type="text" name="email_reg" id="email_reg" maxlength="100" style="width:185px;" class="input-text" /></td>
 </tr>
  <tr>
 <td style="width:140px;" class="t22">Name</td>
 <td><input type="text" name="name" id="name" maxlength="100" style="width:185px;" class="input-text" /></td>
 </tr>
  <tr>
 <td class="t22">Mobile</td>
 <td><input type="text" name="mobilphone" id="mobilphone" placeholder="Enter 10 Digit Mobile Number" maxlength="100" style="width:185px;" class="input-text" /></td>
 </tr>
  <tr>
 <td style="width:130px;" class="t22">Date of Birth</td><td>
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

<tr><td>Gender</td>
<td><select name="gender" id="gender" class="input-text" style="width:203px;">
<option value=""> --- </option>
<option value="1">Male</option>
<option value="2">Female</option>
</select></td>
</tr>

  <tr>
 <td class="t22">Your City</td><td>
        <select class="input-text" type="text" name="city" id="city" style="width:203px;"> 
        <option value="0" selected>Select City</option>
        <?php while($row = mysql_fetch_array($query_parent)): ?>
        <option value="<?=$row['region'];?>"><?=$row['region'];?></option>
        <?php endwhile; ?>
        </select>
</td>
 </tr>

 <tr>
 <td class="t22">Password</td>
 <td><input type="password" name="password_reg" id="password_reg" maxlength="20" style="width:185px;" class="input-text" /></td>
 </tr>
<tr>
 <td class="t22">Confirm</td>
 <td><input type="password" name="password_confirm" id="password_confirm" maxlength="20" style="width:185px;" class="input-text" /></td>
 </tr>
  <tr>
    <td class="t22">Verification</td>
    <td> <input type="text" name="captcha" id="captcha" class="input-text" placeholder="Enter below code" style="width:185px;" autocomplete="off" /></td>
   </tr>
  <tr>
 <td ><img src="captcha.php" alt="captcha" /></td>
 <td style="height:30px;vertical-align: middle;"><input name="sbt_reg" id="sbt_reg" type="submit" class="b22" value="Create My Account"  onclick='this.disabled=true;loading("span_loading_reg",1); post("myform"); return false;' /> <span id="span_loading_reg"></span></td>
 </tr>
 
 </table>
 </form>

<br/>
By clicking 'Create My Account' you agree to <br/>Foodzoned's <a href="/privacy.php" target="_blank">Privacy Policy</a> and <a href="/terms.php" target="_blank">Terms of Use</a>.

</div>
<div class="page4">

<div style="text-align:left;border-left:2px solid #DDD;padding-top:30px;background:#fff;">
<a href="/login.php" title="Login to your Foodzoned account"><img src="/img/page/register-page.jpg"></a>
</div>
</div>

<br/></div>

<? include "inc/footer.php"; ?>
            
<div class="clearfix"></div>
</div>

</body>
</html>