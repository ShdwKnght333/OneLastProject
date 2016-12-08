<?
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Service Provider Logo</title>
<? include "styles.php"; ?>
</head>
<body>

<? include "header.php";
include "sub_settings.php"; ?>

<div id="content">
<div id="container">
<h1 class="h1">Service Provider Logo</h1>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="pictureold" id="pictureold" value="<?=$rs['picture']?>" />
<table width="700" style="line-height:30px;">
 <tr>
    <td style="vertical-align:top;">Logo (if exist)</td>
    <td>
	 <input type="hidden" name="picture" id="picture" value="">
	<iframe name="photoframe" id="photoframe" src="../upload/rest_logo.php?id=<?=$_SESSION['restaid'];?>" frameborder="0" height="80" scrolling="no" width="500px">?</iframe>	
	<? if ($rs['picture']) { ?>
	<img src="../upload/images/<?=$rs['picture']?>" name="prd_img" id="prd_img" />
	<? } ?> 
	</td>
  </tr>
</form>
</table>

Current Logo:<br /><br />
<? 
$logoname=$_SESSION['restaid'].".jpg";
if (file_exists("../logos/".$logoname)) {
	echo "<img name='rest_logo'  id='rest_logo' src='../logos/".$_SESSION['restaid'].".jpg' />";
} else {
	echo "<img name='rest_logo'  id='rest_logo' src='../img/default_logo.jpg' />";	
}
?>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>