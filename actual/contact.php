<?
include "conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Contact Us | <?=SITENAME?></title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<? include "inc/styles.php"; ?>

<!-- JavaScript -->
 <link href="/theme/assets/css/responsive-accordion.css" rel="stylesheet" type="text/css" media="all" />
 <script src="/theme/assets/js/smoothscroll.min.js" type="text/javascript"></script>
 <script src="/theme/assets/js/backbone.js" type="text/javascript"></script>
 <script src="/theme/assets/js/responsive-accordion.min.js" type="text/javascript"></script>

</head>
<body>
<div class="mainbody">
<? include "inc/header.php"; ?>
<div id="content">
<!-- Page Content Start -->

<h1>Contact Us</h1>

<div class="page3">

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="send_contact" />
<table>

<tr><td class="t22">Email</td><td>
<input type="text" name="email" id="email" style="width:185px;" class="input-text" <? if ($_SESSION['memberid']) { echo " value='".getval( "users", "email", $_SESSION['memberid'] )."'"; } ?>/>
</td></tr>

<tr><td class="t22" style="width:130px;">Name</td><td>
<input type="text" name="name" id="name" style="width:185px;" class="input-text" <? if ($_SESSION['memberid']) { echo " value='".getval( "users", "name", $_SESSION['memberid'] )."'"; } ?>/>
</td></tr>

<tr><td class="t22">Mobile</td><td>
<input type="text" name="mobile" id"mobile" style="width:185px;" class="input-text" <? if ($_SESSION['memberid']) { echo " value='".getval( "users", "mobilphone", $_SESSION['memberid'] )."'"; } ?>/>
</td></tr>

<?php $query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'"); ?>

<tr><td class="t22">City</td><td>
        <select class="input-text" type="text" name="city" id="city" style="width:203px;"> 
        <option value="0">Select City</option>
        <?php while($row = mysql_fetch_array($query_parent)): ?>
        <option value="<?=$row['region'];?>"<? if ( $_SESSION['mycity'] == $row['region'] ) { echo " selected"; } ?>><?=$row['region'];?></option>
        <?php endwhile; ?>
        </select>
</td></tr>

<tr><td class="t22">Order ID</td><td><input type="text" name="orderid" id="orderid" placeholder="optional" style="width:185px;" class="input-text"/></td></tr>

<tr><td class="t22">Subject</td><td><input type="text" name="subject" id="subject" style="width:185px;" class="input-text"/></td></tr>

<tr><td class="t22" style="vertical-align:top">Message</td><td><textarea name="message" id="message" rows="5" cols="40" style="width:185px;" class="input-text"></textarea></td></tr>

  <tr>
    <td class="t22">Verification</td>
    <td> <input type="text" name="captcha" id="captcha" class="input-text" placeholder="Enter below code" style="width:185px;" autocomplete="off" /></td>
   </tr>
  <tr>
 <td><img src="captcha.php" alt="captcha" /></td>
<td style="height:30px;vertical-align: middle;"><input name="sbt" id="sbt" type="submit" class="b22" value="SEND MESSAGE"  onclick='this.disabled=true; loading("span_loading",1); post("myform"); return false;' /> <span id="span_loading"></span></td></tr>

</table>
</form>

</div>
<div class="page4">
<br/>
<div style="text-align:left;border-left:2px solid #DDD; padding-left:100px;">

<b>CUSTOMER CARE</b><br/>
<a href="mailto:care@foodzoned.com">care@foodzoned.com</a> (10AM-11PM)<br/><br/>

<b>HELPLINE</b><br/>
+91-9035-515-321 (10AM-11PM)<br/><br/>

<b>SELLER SUPPORT</b><br/>
<a href="mailto:support@foodzoned.com">support@foodzoned.com</a> (10AM-10PM)<br/><br/>

<b>OFFICE ADDRESS</b><br/>
Team Foodzoned<br/>
Kamla house, 8-77E3,<br/>
House No - 3, Eshwar Nagar,<br/>
Manipal, Karnataka – 576104<br/><br/>

<a href="/faq.php">Foodzoned FAQ's</a><br/><br/>

</div>
</div>



<!-- Page Content End -->
</div>
<? include "inc/footer.php"; ?>
<div class="clearfix"></div>
</div>
</body>
</html>