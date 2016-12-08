<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Service Provider Dashboard</title>
<? include "styles.php";?>
<script>
function set_RestStatus(id,val) {
	$("#result").load("../conf/post_admin.php?cmd=set_rest_status&back=<?=$_SERVER['PHP_SELF']?>&id="+id+"&val="+val);
}
</script>
</head>
<body>

<? 
include "header.php"; 
include "sub_home.php"; 
?>

<div id="content">
<div id="container">
<h1 class="h1">Service Provider Dashboard</h1>
<br />
<? $durum = getSqlField("SELECT status FROM rests WHERE id=".$_SESSION['restaid']."","status"); ?>
<form>
Service Status : 	<input type="radio" name="stataus" id="stataus" value="1" onclick='set_RestStatus(<?=$_SESSION['restaid'];?>,this.value);' <? if ($durum==1) echo "checked"; ?>> <span class="green bold">Open</span>
	<input type="radio" name="stataus" id="stataus" value="0" onclick='set_RestStatus(<?=$_SESSION['restaid'];?>,this.value);' <? if ($durum==0) echo "checked"; ?>> <span class="red bold">Closed</span>
</form>
<br /><br />

<?
$newOrder= getSqlNumber("SELECT id FROM orders where status=0 and resid=".$_SESSION['restaid']."");
if ($newOrder>0) {
?>
<h2 style="color:red;font-size:25px;">You have <?=$newOrder?> new order<? if ($newOrder>1) echo "s"; ?></h2>
<a href="orders.php">Click here for order details</a>
<br /><br /><br />
<? } ?>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>