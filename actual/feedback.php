<?
include "conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Feedback | <?=SITENAME?></title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<? include "inc/styles.php"; ?>
</head>
<body>
<div class="mainbody">
<? include "inc/header.php"; ?>
<div id="content">
<!-- Page Content Start -->

<h1>Tell us what you think</h1>

<div class="page3">

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="feedback" />
<table>

<?php $query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'"); ?>
<tr><td class="t22">City</td><td>
        <select class="input-text" type="text" name="city" id="city" style="width:203px;"> 
        <option value="0">Select City</option>
        <?php while($row = mysql_fetch_array($query_parent)): ?>
        <option value="<?=$row['region'];?>"<? if ( $_SESSION['mycity'] == $row['region'] ) { echo " selected"; } ?>><?=$row['region'];?></option>
        <?php endwhile; ?>
        </select>
</td></tr>

<tr><td class="t22">Name</td><td>
<input type="text" name="name" id="name" style="width:185px;" class="input-text" <? if ($_SESSION['memberid']) { echo " value='".getval( "users", "name", $_SESSION['memberid'] )."'"; } ?>/>
</td></tr>

<tr><td class="t22">Email</td><td>
<input type="text" name="email" id="email" style="width:185px;" class="input-text" <? if ($_SESSION['memberid']) { echo " value='".getval( "users", "email", $_SESSION['memberid'] )."'"; } ?>/>
</td></tr>

<tr><td class="t22">Mobile</td><td>
<input type="text" name="mobile" id="mobile" style="width:185px;" class="input-text" <? if ($_SESSION['memberid']) { echo " value='".getval( "users", "mobilphone", $_SESSION['memberid'] )."'"; } ?>/>
</td></tr>

<tr><td class="t22" style="width:130px;">Category</td><td>
<select name="type" id="type" style="width:203px;" class="input-text">
<option value="0">-- Select --</option>
<option value="1">General</option>
<option value="2">Suggestion</option>
<option value="3">Problem</option>
</select>
</td></tr>

<tr><td class="t22" style="vertical-align:top">Feedback</td><td><textarea name="message" id="message" rows="5" cols="40" style="width:185px;" class="input-text"></textarea></td></tr>

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
<img src="/img/page/feedback.jpg">
</center>

</div>





<!-- Page Content End -->
</div>
<? include "inc/footer.php"; ?>
<div class="clearfix"></div>
</div>
</body>
</html>