<?
include "../conf/config.php";
include "check_login.php"; 

$varmi = getSqlNumber("SELECT id FROM site_timing WHERE resid=".$_SESSION['restaid']."");
if ($varmi==0) {
	for ($i=0; $i<7; $i++) {
		unset($data);
		$data['resid']		= $_SESSION['restaid'];
		$data['dateday']	= $i;
		$data['open1']	= "10:00";
		$data['close1']	= "21:00";
		$data['open2']	= "00:00";
		$data['close2']	= "00:00";
		$data['open3']	= "00:00";
		$data['close3']	= "00:00";
		$data['custom_time'] = "10AM-9PM";
		$newId=insert_sql("site_timing",$data);
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Service Timing</title>
<? include "styles.php"; ?>
</head>
<body>

<? include "header.php";
include "sub_settings.php"; 
 ?>

<div id="content">
<div id="container">
<h1 class="h1">Timing</h1>
<small>Ex: If Sunday night service available till 2AM, then Monday value should be open1 = "00:00" & close1 = "02:00".<br/>
And fill others with normal timing.</small><br/><br/>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="save_opening_hours" />
<table border="0" width="100%" style="line-height:30px;">
  <tr>
    <td class="tdheader">Day</td>
    <td class="tdheader" style="text-align:center;">Open 1</td>
    <td class="tdheader" style="text-align:center;">Close 1</td>
    <td class="tdheader" style="text-align:center;">Open 2</td>
    <td class="tdheader" style="text-align:center;">Close 2</td>
    <td class="tdheader" style="text-align:center;">Open 3</td>
    <td class="tdheader" style="text-align:center;">Close 3</td>
    <td class="tdheader" style="text-align:center;">Custom Display</td>
  </tr>

  <? for ($i=1; $i<8; $i++) {
  	$class=(($count++)%2==0)?"tda":"tdb";
  	if ($i==7) $i=0;
  	$rss=getSqlRow("select * from site_timing WHERE resid=".$_SESSION['restaid']." and  dateday=".$i."");
 ?>

<tr>
<td class="<?=$class?>"><?=getDateName($i)?></td>

<td class="<?=$class?>" style="text-align:center;">
<input type="text" name="open1_[<?=$i?>]" id="open1_[<?=$i?>]" value="<?=substr($rss['open1'],0,5)?>" style="width:50px;text-align:center;" maxlength="5" class="input-text"></td>

<td class="<?=$class?>" style="text-align:center;">
<input type="text" name="close1_[<?=$i?>]" id="close1_[<?=$i?>]" value="<?=substr($rss['close1'],0,5)?>" style="width:50px;text-align:center;" maxlength="5" class="input-text"></td>

<td class="<?=$class?>" style="text-align:center;">
<input type="text" name="open2_[<?=$i?>]" id="open2_[<?=$i?>]" value="<?=substr($rss['open2'],0,5)?>" style="width:50px;text-align:center;" maxlength="5" class="input-text"></td>

<td class="<?=$class?>" style="text-align:center;">
<input type="text" name="close2_[<?=$i?>]" id="close2_[<?=$i?>]" value="<?=substr($rss['close2'],0,5)?>" style="width:50px;text-align:center;" maxlength="5" class="input-text"></td>

<td class="<?=$class?>" style="text-align:center;">
<input type="text" name="open3_[<?=$i?>]" id="open3_[<?=$i?>]" value="<?=substr($rss['open3'],0,5)?>" style="width:50px;text-align:center;" maxlength="5" class="input-text"></td>

<td class="<?=$class?>" style="text-align:center;">
<input type="text" name="close3_[<?=$i?>]" id="close3_[<?=$i?>]" value="<?=substr($rss['close3'],0,5)?>" style="width:50px;text-align:center;" maxlength="5" class="input-text"></td>

<td class="<?=$class?>" style="text-align:center;">
<input type="text" name="custom_time_[<?=$i?>]" id="custom_time_[<?=$i?>]" value="<?=$rss['custom_time']?>" style="width:220px;text-align:center;" placeholder="Ex:10AM-4PM 7PM-2AM" class="input-text">
</td>

</tr>
  <? 
  if ($i==0) break;
  } ?>
  <tr>
    <td style="text-align:left;"><br/><input type="submit" name="sbt" id="sbt" value="UPDATE" style="font-size:16px;" onclick='this.disabled=true; post_admin("myform");  return false;' class="input-text"></td>
    <td colspan="4"></td>  
  </tr>
</table>
</form>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>