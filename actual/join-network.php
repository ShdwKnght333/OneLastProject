<?
include "conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Join our Network | <?=SITENAME?></title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<? include "inc/styles.php"; ?>
</head>
<body>
<div class="mainbody">
<? include "inc/header.php"; ?>
<div id="content">
<!-- Page Content Start -->

<h1>Join Foodzoned Network</h1>

<div class="page3">

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="join_network" />
<table>

<tr><td class="t22" style="width:130px;">Contact Person</td><td><input type="text" name="name" id="name" style="width:185px;" class="input-text"/></td></tr>

<tr><td class="t22">Mobile</td><td><input type="text" name="mobile" id"mobile" style="width:185px;" class="input-text"/></td></tr>

<tr><td class="t22">Email</td><td><input type="text" name="email" id="email" style="width:185px;" class="input-text"/></td></tr>

<tr><td class="t22">Service</td><td><input type="text" name="rname" id="rname" style="width:185px;" class="input-text"/></td></tr>

<tr><td class="t22">Telephone</td><td><input type="text" name="phone" id"phone" style="width:185px;" class="input-text"/></td></tr>

<tr><td class="t22" style="vertical-align:top">Adress</td><td><textarea name="adress" id="adress" rows="5" cols="40" style="width:185px;" class="input-text"></textarea></td></tr>

<tr><td class="t22">City</td><td><input type="text" name="city" id="city" style="width:185px;" class="input-text"/></td></tr>

<tr><td class="t22">Pincode</td><td><input type="text" name="pincode" id="pincode" style="width:185px;" class="input-text"/></td></tr>

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

<center>
<img src="/img/page/fz-join-01.png">
</center>

<p align="left" style="margin-left:17px;">
<br/><b>SELLER SUPPORT : </b> <a href="mailto:support@foodzoned.com">support@foodzoned.com</a> (10AM-11PM)<br/>
</p>

</div>

<!-- Page Content End -->
</div>
<? include "inc/footer.php"; ?>
<div class="clearfix"></div>
</div>
</body>
</html>