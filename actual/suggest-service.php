<?
include "conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Suggest a Service Provider | <?=SITENAME?></title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<? include "inc/styles.php"; ?>
</head>
<body>
<div class="mainbody">
<? include "inc/header.php"; ?>
<div id="content">
<!-- Page Content Start -->

<h1>Suggest a Service Provider</h1>

<div class="page3">

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="suggest_rest" />
<h3>Service Provider Information</h3><br/>
<table>
<tr><td class="t22" style="width:130px;">Service Name</td><td><input type="text" name="rname" id="rname" style="width:185px;" class="input-text"/></td></tr>

<tr><td class="t22">Address</td><td><input type="text" name="address" id="address" style="width:185px;" class="input-text"/></td></tr>

<tr><td class="t22">City</td><td><input type="text" name="city" id="city" style="width:185px;" class="input-text"/></td></tr>

<tr><td class="t22">Phone</td><td><input type="text" name="mobile" id"mobile" style="width:185px;" class="input-text"/></td></tr>

</table>
<br/><h3>Your Information</h3><br/>
<table>

<tr><td class="t22" style="width:130px;">Name</td><td>
<input type="text" name="name" id="name" style="width:185px;" class="input-text" <? if ($_SESSION['memberid']) { echo " value='".getval( "users", "name", $_SESSION['memberid'] )."'"; } ?>/>
</td></tr>

<tr><td class="t22">Email</td><td>
<input type="text" name="email" id="email" style="width:185px;" class="input-text" <? if ($_SESSION['memberid']) { echo " value='".getval( "users", "email", $_SESSION['memberid'] )."'"; } ?>/>
</td></tr>

<tr><td class="t22">Mobile</td><td>
<input type="text" name="mobile" id="mobile" style="width:185px;" class="input-text" <? if ($_SESSION['memberid']) { echo " value='".getval( "users", "mobilphone", $_SESSION['memberid'] )."'"; } ?>/>
</td></tr>

<tr><td class="t22" style="vertical-align:top">Comments</td><td><textarea name="message" id="message" rows="5" cols="40" style="width:185px;" class="input-text"></textarea></td></tr>

  <tr>
    <td class="t22">Verification</td>
    <td> <input type="text" name="captcha" id="captcha" class="input-text" placeholder="Enter below code" style="width:185px;" autocomplete="off" /></td>
   </tr>
  <tr>
 <td><img src="captcha.php" alt="captcha" /></td>
<td style="height:30px;vertical-align: middle;"><input name="sbt" id="sbt" type="submit" class="b22" value="SUBMIT"  onclick='this.disabled=true; loading("span_loading",1); post("myform"); return false;' /> <span id="span_loading"></span></td></tr>

</table>
</form>

</div>
<div class="page4">
<p align="justify">
Can't find a Service? Simply fill out the enquiry form to suggest a service provider. Then we'll contact them to get them online quickly.</p><br/>
<center>
<img src="/img/page/suggest-restaurant.jpg">
</center>

</div>



<!-- Page Content End -->
</div>
<? include "inc/footer.php"; ?>
<div class="clearfix"></div>
</div>
</body>
</html>