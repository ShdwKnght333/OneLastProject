<? 
include "../conf/config.php"; 
include "check_login.php"; 


$_REQUEST['id']=$_SESSION['restaid'];

if ($_REQUEST['id']) {
	$id=safe($_REQUEST['id']);
	$varmi = getSqlNumber("SELECT id FROM rests WHERE id=".$id."");
	if ($varmi==0) {
		echo "<script>document.location.href='rests.php'</script>";
		exit;
	}
	$rs=getSqlRow("SELECT * FROM rests WHERE id=".$id."");
	$rsd=getSqlRow("select * from delivery_areas where id=".$rs['da_id']."");
}
if (!$id) {
	$rs['servicetime']="30";
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Service Information</title>
<? include "styles.php"; ?>

<script type="text/javascript" charset="utf-8">
$(function(){
  $("select#region").change(function(){
		$("select#city").html('<option value="">---</option>');
		$("select#zip").html('<option value="">---</option>');
		$("#result").load("../conf/post_admin.php",{cmd: "update_select_city", region: $(this).val(), ajax: 'true'});
		
	});

	$("select#city").change(function(){
		$("select#zip").html('<option value="">---</option>');
		$("#result").load("../conf/post_admin.php",{cmd: "update_select_zip",  region: $("select#region").val(), city: $(this).val(), ajax: 'true'});
	});
})
</script>

</head>
<body>

<? include "header.php"; 
include "sub_settings.php"; ?>

<div id="content">
<div id="container">

<br/>
<h1 class="h1">Access Denied!</h1>
<p>This section is temporarily disabled by Administrator.</p>
<?php if($_REQUEST['admin']=="1") { ?>


<h1 class="h1">
<? if (!$_REQUEST['id']) {
	echo "New Restaurant";
} else {
	echo $rs['name'];
}
?>
</h1>

<?
//PLEASE DONT REMOVE THIS CODE
$productrests = getSqlNumber("SELECT id FROM rests");
?>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="id" id="id" value="<?=$rs['id']?>">
<input type="hidden" name="site_service" id="site_service" value="<?=$rs['site_service']?>">
<input type="hidden" name="fz_comm" id="fz_comm" value="<?=$rs['fz_comm']?>">
<input type="hidden" name="priority" id="priority" value="<?=$rs['priority']?>">
<input type="hidden" name="olduser" id="olduser" value="<?=$rs['username']?>">
<input type="hidden" name="cmd" id="cmd" value="save_rest" />
<input type="hidden" name="from" id="from" value="resadmin" />
<table width="600" style="line-height:30px;">

   <tr>
    <td>Status</td>
    <td><input type="radio" name="status" id="status" value="1" <? if ($rs['status']==1) echo "checked"; ?>> Active &nbsp; &nbsp; 
	<input type="radio" name="status" id="status" value="0" <? if ($rs['status']==0) echo "checked"; ?>> Closed<br/><br/></td>
  </tr>

<tr>
    <td width="30%">Region</td>
    <td width="70%">
<select name="region"  id="region" style="width:318px;background:#FFFF80;" class="input-text">
<option value="">--- Select ---</option>
<? 
$getRss = mysql_query("SELECT id,region FROM delivery_areas group by region");
while ($rss = mysql_fetch_array($getRss)) { ?>
<option value="<?=$rss['region'];?>" <? if ($rsd['region']==$rss['region']) echo "selected"; ?>><?=$rss['region'];?></option>
<? } ?>
</select> *</td>
  </tr>
  
  <tr>
    <td width="30%">Area</td>
    <td width="70%"><select name="city" id="city" class="input-text" style="width:318px;background: #FFFF80;" <? if (!$rs['id']) { echo 'disabled="true"'; } ?> =>
	<option value="">---</option>
	<? 
	if ($rs['id']) {
	$getRss = mysql_query("SELECT id,city FROM delivery_areas where region='".$rsd['region']."' group by city");
	while ($rss = mysql_fetch_array($getRss)) { ?>
	<option value="<?=$rss['city'];?>" <? if ($rsd['city']==$rss['city']) echo "selected"; ?>><?=$rss['city'];?></option>
	<? } 
	}
	?>
	</select> *
</td>
  </tr>


   <tr>
    <td width="30%">Pincode</td>
    <td width="70%"><select name="zip" id="zip" class="input-text" style="width:318px;background:#FFFF80;" <? if (!$rs['id']) { echo 'disabled="true"'; } ?> >
	<option value="">---</option>
	<? 
	if ($rs['id']) {
	$getRss = mysql_query("SELECT id,zip FROM delivery_areas where region='".$rsd['region']."' and city='".$rsd['city']."' group by zip");
	while ($rss = mysql_fetch_array($getRss)) { ?>
	<option value="<?=$rss['zip'];?>" <? if ($rsd['zip']==$rss['zip']) echo "selected"; ?>><?=$rss['zip'];?></option>
	<? } 
	}
	?>
	</select> *
</td>
  </tr>
   
  <tr>
    <td width="30%">Username</td>
    <td width="70%"><input type="text" name="username" id="username" class="input-text" value="<?=$rs['username']?>" style="width:300px;background: #FFFF80;" maxlength="20"> *</td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type="text" name="password" id="password" class="input-text" value="<?=$rs['password']?>" style="width:300px;background: #FFFF80;" maxlength="20"> *</td>
  </tr>
  <tr>
    <td>Service Name</td>
    <td><input type="text" name="name" id="name" class="input-text" value="<?=$rs['name']?>" style="width:300px;background: #FFFF80;" maxlength="250"> *</td>
  </tr>

<tr>
<td>Products Type</td><td>
<select name="type" id="type" class="input-text" style="width:318px;">
<option value="0" <? if ($rs['type']==0) echo "selected"; ?>>Select Type</option>
<option value="1" style="color:green;" <? if ($rs['type']==1) echo "selected"; ?>>Vegetarian</option>
<option value="2" style="color:red;" <? if ($rs['type']==2) echo "selected"; ?>>Non-Vegetarian</option>
<option value="3" style="color:blue;" <? if ($rs['type']==3) echo "selected"; ?>>Veg & Non-Veg</option>
<option value="4" style="color:purple;" <? if ($rs['type']==4) echo "selected"; ?>>Alcohol</option>
<option value="5" <? if ($rs['type']==5) echo "selected"; ?>>Others</option>
</select>

</td>
</tr>

  <tr>
    <td>Email</td>
    <td><input type="text" name="email" id="email" value="<?=$rs['email']?>" class="input-text" style="width:300px" maxlength="250"></td>
  </tr>
  <tr>
    <td>Landline</td>
    <td><input type="text" name="phone" id="phone" value="<?=$rs['phone']?>" class="input-text" style="width:200px" maxlength="20"></td>
  </tr>
  <tr>
    <td>Mobile</td>
    <td><input type="text" name="gsm" id="gsm" value="<?=$rs['gsm']?>" class="input-text" style="width:200px" maxlength="20" placeholder="10 Digit Mobile Number"></td>
  </tr>
  <tr>
    <td>Mobile 2</td>
    <td><input type="text" name="gsm2" id="gsm2" value="<?=$rs['gsm2']?>" class="input-text" style="width:200px" maxlength="20" placeholder="10 Digit Mobile Number"></td>
  </tr>
  <tr>
    <td>Fax</td>
    <td><input type="text" name="fax" id="fax" value="<?=$rs['fax']?>" class="input-text" style="width:200px" maxlength="20"></td>
  </tr>
   <tr>
    <td>Minimum Order</td>
    <td><input type="text" name="minorder" id="minorder" class="input-text" value="<?=intval($rs['minorder'])?>"  style="width:80px;text-align:right;" maxlength="4" onkeyup='this.value=this.value.replace(/[^\d]*/gi,"");' /> </td>
  </tr>
   <tr>
    <td>Service Fee</td>
    <td><input type="text" name="servicefee" id="servicefee" class="input-text" value="<?=intval($rs['servicefee'])?>"  style="width:80px;text-align:right;" maxlength="3"  onkeyup='this.value=this.value.replace(/[^\d]*/gi,"");' /> </td>
  </tr>
   <tr>
    <td>Service Time</td>
    <td><input type="text" name="servicetime" id="servicetime" class="input-text" value="<?=$rs['servicetime']?>" style="width:80px;text-align:right;" maxlength="3"  onkeyup='this.value=this.value.replace(/[^\d]*/gi,"");' /> Minutes </td>
  </tr>
  <tr>
    <td>Tax for orders (%)</td>
    <td><input type="text" name="rest_tax" id="rest_tax" class="input-text" value="<?=$rs['rest_tax']?>"  style="width:80px;text-align:right;" maxlength="6"  /> 8.245 format.</td>
  </tr>

  <tr>
    <td>Discount (%)</td>
    <td><input type="text" name="discount" id="discount" class="input-text" value="<?=$rs['discount']?>"  style="width:80px;text-align:right;" maxlength="6"  /></td>
  </tr>
  <tr>
    <td>Discount on Minimum</td>
    <td><input type="text" name="dis_min" id="dis_min" class="input-text" value="<?=$rs['dis_min']?>"  style="width:80px;text-align:right;" maxlength="6"  /> Ex: 199</td>
  </tr>

  <tr>
    <td>Address</td>
    <td><input type="text" name="address" id="address" class="input-text" value="<?=$rs['address']?>" style="width:400px" maxlength="250"></td>
  </tr>

  <tr>
    <td style="vertical-align:top;">About your service</td>
    <td>
	<textarea name="description" id="description" class="input-text" style="width:400px;height:100px;"><?=$rs['description']?></textarea>
	</td>
  </tr>
  <tr>
    <td style="vertical-align:top;">Info. for Customers</td>
    <td>
	<textarea name="note" id="note" class="input-text" style="width:400px;height:100px;"><?=$rs['note']?></textarea>
	</td>
  </tr>
  <? if (strtolower(ENABLE_PAYPAL_FOR_REST)=="yes") { ?>
  <tr>
    <td>PayPal Email</td>
    <td><input type="text" name="paypal_email" id="paypal_email" value="<?=$rs['paypal_email']?>" style="width:400px" maxlength="100"></td>
  </tr>
  <?  } ?>
  
  <? if (strtolower(ENABLE_AUTHORIZE_FOR_REST)=="yes") { ?>
  <tr>
    <td>Authorize Login Id</td>
    <td><input type="text" name="authorize_login_id" id="authorize_login_id" value="<?=$rs['authorize_login_id']?>" style="width:400px" maxlength="100"></td>
  </tr>
  <tr>
    <td>Authorize Key</td>
    <td><input type="text" name="authorize_key" id="authorize_key" value="<?=$rs['authorize_key']?>" style="width:400px" maxlength="100"></td>
  </tr>
  <?  } ?>
  <? if (strtolower(ENABLE_GOOGLE_CHECKOUT_FOR_REST)=="yes") { ?>
  <tr>
    <td>Authorize Login Id</td>
    <td><input type="text" name="google_merchant" id="google_merchant" value="<?=$rs['google_merchant']?>" style="width:400px" maxlength="100"></td>
  </tr>
  <tr>
    <td>Authorize Key</td>
    <td><input type="text" name="google_key" id="google_key" value="<?=$rs['google_key']?>" style="width:400px" maxlength="100"></td>
  </tr>
  <?  } ?>
  
  <tr>
    <td>Accept Order Types</td>
    <td>
    <? 
    $order_types=unserialize($rs['order_types']);
$getRss = mysql_query("SELECT * FROM order_types order by order_type");
while ($rss = mysql_fetch_array($getRss)) { ?>
    <input type="checkbox" name="order_types[]" id="order_types[]" value="<?=$rss['id']?>" <? if (@in_array($rss['id'],$order_types)) echo "checked='true'"; ?> /> <?=$rss['order_type']?>
    <? } ?>
    </td>
  </tr>
  
  <tr>
    <td></td>
    <td><input type="submit" name="sbt" id="sbt" class="b22" value="Save" style="font-size:16px;margin-top:15px;" onclick='this.disabled=true; post_admin("myform"); return false;'></td>
  </tr>
</table>
</form>


<?php } ?>

<br/><br/>
</div>
</div>

<? include "footer.php"; ?>

</body>
</html>