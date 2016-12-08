<?
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Payment Types</title>
<? include "styles.php";  ?>
</head>

<body>

<? include "header.php";
include "sub_settings.php";  ?>

<div id="content">
<div id="container">
<h1 class="h1">Payment Types</h1>
<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="save_payment_types" />
<table width="400">
  <tr>
    <td width="90%" class="tdheader">Type</td>
    <td width="10%" class="tdheader"></td>
  </tr>
<?
$payment_types = getSqlField("SELECT paymenttypes FROM rests WHERE id=".$_SESSION['restaid']."","paymenttypes");
$getRs = mysql_query("SELECT * FROM paymenttypes order by paymenttype asc");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
   <tr>
    <td class="<?=$class?>"><?=$rs['paymenttype'];?></td>
    <td class="<?=$class?>"><input type="checkbox" name="ptype[]" id="ptype[]" value="<?=$rs['paymenttype'];?>"  <? if (substr_count($payment_types,$rs['paymenttype'])>0) echo "checked"; ?>></td>
  </tr>
<? } ?>
<tr>
    <td><br/><input type="submit" name="sbt" id="sbt" value="Save" style="font-size:16px;" onclick='this.disabled=true; post_admin("myform"); return false;'></td>
    <td></td>
  </tr>
</table>

</form>
</div>
</div>

<? include "footer.php"; ?>

</body>
</html>