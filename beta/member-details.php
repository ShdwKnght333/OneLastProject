<?php 
include "conf/config.php";

// Registration Email Verification STARTS
if (isset($_REQUEST['fz'])&& $_REQUEST['fz']) {
	$rs=getSqlRow("select id from users where verify='".safe($_REQUEST['fz'])."'");
	if (isset($rs['id'])&& $rs['id']) {
		$_SESSION['memberid']=$rs['id'];
		mysql_query("update users set verify='' where id=".$rs['id']."");
	}
}
// Registration Email Verification ENDS

// Forgot or Change Password STARTS 
if (isset($_REQUEST['fp']) && $_REQUEST['fp']) {
	$rs=getSqlRow("select id from users where forgot_pass='".safe($_REQUEST['fp'])."' ");
	if (isset($rs['id'])&& $rs['id']) {
		$_SESSION['memberid']=$rs['id'];
		mysql_query("update users set forgot_pass='' where id=".$rs['id']."");
	}
}
// Forgot or Change Password ENDS  

checkLogin();
$rs=getSqlRow("select * from users where id='".$_SESSION['memberid']."' ");
$name = $rs['name'];
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Members Area</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
 <?php include "inc/styles.php"; ?>
</head>
<body>
<?php include "inc/header.php"; ?>
<?php 
$query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'");
?>
<!----------------------------------------------------header ends----------------------------->
	<div class="first-widget parallax" id="myaccount">
		<div class="parallax-overlay">
			<div class="container pageTitle">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2 class="page-title"><?php  if(isset($_SESSION['profile_pic'])&& $_SESSION['profile_pic'] ){ ?><img src="<?php echo $_SESSION['profile_pic']; ?>" height="64" width="64" style="border-radius: 50%;"><?php } else if($rs['gender'] ==1){?><img src="images/male.png" height="64" width="64" style="border-radius: 50%;"><?php }  else if($rs['gender'] ==2){ ?><img src="images/female.png" height="64" width="64" style="border-radius: 50%;"><?php }else { ?><img src="images/default-user.png" height="64" width="64" style="border-radius: 50%;"><?php  }?> Hello! <?php echo $name; ?></h2>
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.parallax-overlay -->
	</div><br> <!-- /.pageTitle -->

	<div class="container">	
		<div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;">
        	<div class="col-md-12">
            	<div class="cd-tabs">
					<nav>
						<ul class="cd-tabs-navigation">
							<li><a data-content="deliveryadd" class="selected" href="#0"><span class="fa fa-map-marker fa-2x"></span> Delivery Addresses</a></li>
							<li><a data-content="myinfo" href="#0"><span class="fa fa-info fa-2x"></span> Profile Information</a></li>
							<li><a data-content="fpass" href="#0"><span class="fa fa-unlock-alt fa-2x"></span> Change Password</a></li>
						</ul> <!-- cd-tabs-navigation -->
					</nav>

					<ul class="cd-tabs-content">
						<li data-content="deliveryadd" class="selected">
							<div id="content" class="container_12">
							<div class="grid_12">
							<br>
							<div>

							<!-- Delivery Address Save Button --> 
							<form id="saveaddress" name="saveaddress" method="post" action="javascript:void(null);">
							  <input type="hidden" name="cmd" id="cmd" value="save_address" />
							<table class="fonrm_table">
							<tr>
							<td style="width:150px;"><?php echo $GLOBALS['addresses']?></td>
							<td style="height:30px;"><select name="address_id" id="address_id"  style="width:200px;margin-bottom:10px;" onchange="setAddress(this.value);"  class="input-text">
							<option value=""><?php echo $GLOBALS['new_address']?></option>
							<?php
							$getRss= mysql_query("SELECT * FROM delivery_addresses where userid=".$_SESSION['memberid']." order by nick asc");
							while ($rss = mysql_fetch_array($getRss)) {
							?>
							<option value="<?php echo $rss['id']; ?>"><?php echo $rss['nick']?></option>
							<?php } ?>
							</select></span></td>
							</tr>
							<tr>
							<td>Nickname</td>
							<td><input type="text" name="nick" id="nick" value="" style="width:200px;margin-bottom:10px;" maxlength="50" class="input-text" /></td>
							</tr>
							<tr>
							<td>Name</td>
							<td><input type="text" name="name" id="name" value="" style="width:200px;margin-bottom:10px;" maxlength="100" class="input-text" /></td>
							</tr>
							<tr>
							<td>Mobile</td>
							<td><input type="text" name="mobilphone" id="mobilphone" value="" style="width:200px;margin-bottom:10px;" maxlength="50" class="input-text" /></td>
							</tr>
							<tr>
							<td style="vertical-align:top;"><?php echo $GLOBALS['address']?></td>
							<td><textarea name="address" id="address" style="width:200px;height:70px;margin-bottom:10px;" class="input-text"></textarea></td>
							</tr>
							<tr>
							<td style="padding-top:8px;"><?php echo $GLOBALS['city']?></td>
							<td style="padding-top:8px;"><select name="city" id="city" style="width:200px;margin-bottom:10px;" class="input-text">
								<option value="">-- SELECT CITY --</option>
								<?php $getRss = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'");
								while ($rss = mysql_fetch_array($getRss)) { ?>
								<option value="<?php echo $rss['region'];?>"><?php echo $rss['region'];?></option>
								<?php } 
								?>
								</select></td>
							</tr>
							<tr>
							<td><?php echo $GLOBALS['postcode']?></td>
							<td><input type="text" name="postcode" id="postcode" value="" style="width:200px;margin-bottom:10px;" maxlength="10" onkeyup='this.value=this.value.replace(/[^\d]*/gi,"");' class="input-text" /></td>
							</tr>
							  <tr>
							 <td ></td>
							 <td style="height:30px;"><input name="sbt" class="buttonwallet buttoncheckout" type="submit" value="<?php echo $GLOBALS['save']?>" onclick='this.disabled=true;post("saveaddress"); return false;' /></td>
							 </tr>
							 </table>		 
							</form>
							<br/><br/>

							</div>
							</div>
							</div>
						</li>

						<li data-content="myinfo">
							<div id="content" class="container_12">
								<div class="grid_12">
								<br>
								<div>

								<!-- Save Personal Information Save Button -->
								<form id="savemember" name="savemember" method="post" action="javascript:void(null);">
								  <input type="hidden" name="cmd" id="cmd" value="save_member" />
								<table class="fonrm_table">
								  <tr>
								<?php if (isset($rs['email'])&& !$rs['email'] == "" ) { ?>
								<tr><td colspan="2"><?php echo $rs['email']?><input type="hidden" name="email" id="email" value="<?php echo $rs['email']?>" readonly="true" maxlength="100" style="width:200px;margin-bottom:10px;" class="input-text" /><br/><br/></td></tr>
								<?php } else { ?>
								<tr><td style="width:150px;" class="t22">Email Address</td><td>
								<input type="text" name="email" id="email" maxlength="100" style="width:200px;margin-bottom:10px;" class="input-text" /></td></tr>
								<?php } ?>

								<!-- if DOB is not provided then ask for DOB to set --> 
								<?php if ( $rs['dob'] == "" || $rs['dob'] == "00/00/0000" ) { ?>
								<tr><td style="width:150px;" class="t22">Date of Birth</td><td>
								<select class="input-text" type="text" name="dd" id="dd" style="width:58px;margin-bottom:10px;"> 
								<option value='0' selected>dd</option>
								<?php for($j=1;$j<=31;$j++) { echo "<option value='"; if($j < 10){ echo '0' . $j; } else { echo $j; } echo "'>";
								if($j < 10){ echo '0' . $j; } else { echo $j; } echo "</option>"; } ?>
								</select>
								<select class="input-text" type="text" name="mm" id="mm" style="width:64px;"> 
								<option value='0' selected>mm</option>
								<?php for($j=1;$j<=12;$j++) { echo "<option value='"; if($j < 10){ echo '0' . $j; } else { echo $j; } echo "'>";
								if($j < 10){ echo '0' . $j; } else { echo $j; } echo "</option>"; } ?>
								</select>
								<select class="input-text" type="text" name="yy" id="yy" style="width:74px;"> 
								<option value='0' selected>yyyy</option>
								<?php for($j=$date('Y');$j>=($date('Y')-100);$j--) { echo "<option value='" . $j . "'>" . $j . "</option>"; } ?>
								</select>
								</td></tr>
								<?php } else { ?>
								<tr><td style="width:150px;" class="t22">Date of Birth</td><td>
								<?php echo date("d-m-Y", strtotime($rs['dob'])); ?> <input type="hidden" name="dob" id="dob" value="<?php echo $rs['dob']?>" readonly="true" maxlength="100" class="input-text" /><br/><br/></td></tr>
								<?php } ?>

								  <tr>
								 <td class="t22">Name </td>
								 <td><input type="text" name="name" id="name" value="<?php echo $rs['name']?>" maxlength="100" style="width:200px;margin-bottom:10px;" class="input-text" /></td>
								 </tr>
								  <tr>
								 <td class="t22">Mobile </td>
								 <td><input type="text" name="mobilphone" id="mobilphone" value="<?php echo $rs['mobilphone']?>"  placeholder="Enter 10 Digit Mobile Number" maxlength="100" style="width:200px;margin-bottom:10px;" class="input-text" /></td>
								 </tr>


								<tr><td>Gender </td>
								<td><select name="gender" id="gender" class="input-text" style="width:200px;margin-bottom:10px;">
								<option value="0" selected> --- </option>
								<option value="1" <?php if($rs['gender'] == "1") {echo "selected";} ?>>Male</option>
								<option value="2" <?php if($rs['gender'] == "2") {echo "selected";} ?>>Female</option>
								</select></td>
								</tr>


								  <tr>
								 <td style="width:150px;" class="t22">City </td><td>
										<select class="input-text" type="text" name="city" id="city" style="width:200px;margin-bottom:10px;"> 
										<option value="0" selected>Select City</option>
										<?php while($row = mysql_fetch_array($query_parent)): ?>
										<option value="<?php echo $row['region'];?>" <?php if($row['region'] == $rs['city']) {echo "selected";} ?>><?php echo $row['region'];?></option>
										<?php endwhile; ?>
										</select>
								</td>
								 </tr>
								  <tr>
								 <td ></td>
								 <td style="height:30px;"><input name="sbt" class="buttonwallet buttoncheckout" id="sbt" type="submit" value="<?php echo $GLOBALS['save']?>"  onclick='this.disabled=true;post("savemember"); return false;' /></td>
								 </tr>					 
								 </table>
								 </form>
								<br/><br/>

								</div>
								</div>
								</div>
						</li>

						<li data-content="fpass">
							<div id="content" class="container_12">
								<div class="grid_12">
								<br>
								<div>

								<!-- Change my Password Button -->
								<form id="changepassword" name="changepassword" method="post" action="javascript:void(null);">
								  <input type="hidden" name="cmd" id="cmd" value="change_pass" />
								<table class="fonrm_table">
								  <tr>
								 <td colspan="2" class="t22"><?php echo $rs['email']?><input type="hidden" name="email" id="email" value="<?php echo $rs['email']?>" readonly="true" maxlength="100" style="width:300px;margin-bottom:10px;" class="input-text" /></td>
								 </tr>
								 <tr>
								 <td style="width:150px;" class="t22"><br/><?php echo $GLOBALS['password']?></td>
								 <td><br/><input type="password" name="password" id="password" maxlength="20" style="width:200px;margin-bottom:10px;" class="input-text" /></td>
								 </tr>
								<tr>
								 <td class="t22"><?php echo $GLOBALS['password_confirm']?></td>
								 <td><input type="password" name="password_confirm" id="password_confirm" maxlength="20" style="width:200px;margin-bottom:10px;" class="input-text" /></td>
								 </tr>
								  <tr>
								 <td ></td>
								 <td style="height:30px;"><input name="sbt" class="buttonwallet buttoncheckout" type="submit"  value="Change Password"  onclick='this.disabled=true; post("changepassword"); return false;' /> </td>
								 </tr>							 
								 </table>	 
								 </form>
								</div>
								</div>
								</div>
						</li>
					</ul> <!-- cd-tabs-content -->
				</div> <!-- cd-tabs -->
            </div>
        </div><br>
    </div><br> <!-- /.container -->
<div id="result"></div>
<!--Footer----------------------tnahsushant-------------------------------->
	<?php include "inc/footer.php"; ?>


	<!-- Scripts -->
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
	<script src="js/tabs.js"></script>
   	<script src="js/b2tmain.js"></script><!--back-to-top-->
<script>
	function setAddress(id) {
	$("#result").load("conf/post.php?cmd=set_address&id="+id);
}
</script>
<script>
function post(form) {
	var form=$('#'+form).serialize();
	$.ajax({
		type: 'POST',
		url: 'conf/post.php',
		data: form,
		success: function(result) {
			$('#result').html(result);
			$('.buttonwallet').prop('disabled', false);
		}
	});
	return false;
}
</script>
</body>
</html>