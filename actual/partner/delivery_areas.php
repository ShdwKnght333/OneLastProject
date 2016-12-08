<? 
include "../conf/config.php";
include "check_login.php"; 

$_REQUEST['id']=$_SESSION['restaid'];

if ($_REQUEST['id']) {
	$id=safe($_REQUEST['id']);
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Delivery Areas</title>
<? include "styles.php"; ?>

<script LANGUAGE="JavaScript" TYPE="text/javascript">
function add_area(id) {
	var checked=0;
	if ($('#area_'+id).is(':checked')) {
		checked=1;
	}
	$("#result").load("../conf/post_admin.php?cmd=set_rest_area&id="+id+"&val="+checked);
}
function add_dfees(id,dfees) {
	$("#result").load("../conf/post_admin.php?cmd=set_dfees&id="+id+"&amt="+dfees);
}
function add_min(id,min) {
	$("#result").load("../conf/post_admin.php?cmd=set_min&id="+id+"&amt2="+min);
}

</script>

</head>
<body>

<? 
include "header.php"; 
include "sub_settings.php"; 
?>

<div id="content">
<div id="container">
<h1 class="h1">Delivery Areas</h1>

Select the areas that you will deliver foods:<br /><br />

<form name="myform" id="myform" action="javascript:void(0);">
<table width="100%">
  <tr>
    <td width="10%" class="tdheader">Region</td>
    <td width="30%" class="tdheader">Area</td>
    <td width="10%" class="tdheader">Pincode</td>
    <td width="15%" class="tdheader">Delivery Charge</td>
    <td width="15%" class="tdheader">Minimum Order</td>
    <td width="20%" class="tdheader" style="text-align:center;">Select</td>
  </tr>

<?

$fz2 = getsqlrow("SELECT zip FROM rests WHERE id='".$id."'");
$fz3 = getsqlrow("SELECT region FROM delivery_areas WHERE zip='".$fz2['zip']."'");

$getRs = mysql_query("SELECT * FROM delivery_areas WHERE region='".$fz3['region']."' order by region,city,zip asc");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
$checked =getsqlrow("select * from rest_delivery_area where rest_id=".$_SESSION['restaid']." and da_id=".$rs['id']."");

?>

   <tr id="tr_<?=$rs['id'];?>">
    <td class="<?=$class?>"><?=$rs['region'];?></td>
    <td class="<?=$class?>"><?=$rs['city'];?></td>
    <td class="<?=$class?>"><?=$rs['zip'];?></td>
    <td class="<?=$class?>">
<? if ($checked['da_id']) { ?>
<input class="input-field input-text" type="text" name="area_<?=$checked['da_id'];?>" id="area_<?=$checked['da_id'];?>" value="<?=$checked['dfees'];?>" onchange="add_dfees(<?=$checked['da_id'];?>,this.value);" size="5"/>
<? } ?>
</td>

    <td class="<?=$class?>">
<? if ($checked['da_id']) { ?>
<input class="input-field input-text" type="text" name="min_<?=$checked['da_id'];?>" id="min_<?=$checked['da_id'];?>" value="<?=$checked['min'];?>" onchange="add_min(<?=$checked['da_id'];?>,this.value);" size="5" />
<? } ?>
</td>

    <td class="<?=$class?>" style="text-align:center;"><input class="chkbox" type="checkbox" name="area_<?=$rs['id'];?>" id="area_<?=$rs['id'];?>" value="<?=$rs['id'];?>" <? if ($checked['rest_id']) echo "checked='true'"; ?> onchange="add_area(<?=$rs['id'];?>);" /></td>
  </tr>
<? } ?>
</table>
</form>
<br/><br/>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>