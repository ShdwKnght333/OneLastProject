<?
include "../conf/config.php"; 

if ($_REQUEST['cmd']=="check_order") {
	$totalResults = getSqlNumber("SELECT id FROM orders where resid=".$_SESSION['restaid']."");
	//echo $_REQUEST['count']."-".$totalResults;
	if ($totalResults>$_REQUEST['count']) {
		include "alert.html";
		echo "<script>alert('New order recieved!');window.location='".$_SERVER['PHP_SELF']."'</script>";
	}
	exit;
}


if ($_REQUEST['cmd']=="paid") {
    @mysql_query("update orders set payment_status=1 where id=".safe($_REQUEST['id'])." and resid=".$_SESSION['restaid']."");
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Orders</title>
<? include "styles.php";  ?>
<script type="text/javascript" src="<?=SITEURL?>js/jquery.timer.js"></script>
<script type="text/JavaScript">
function set_OrderStatus(id,val) {
	$("#result").load("../conf/post_admin.php?cmd=set_order_status&back=<?=$_SERVER['PHP_SELF']?>&id="+id+"&val="+val);
}



jQuery(function($) {	
	var i=0;
 	$.timer(10000, function (timer) {
  		//timer.stop();
  		i++;
 		var order_count=$("#timer_count").val();
 		$("#result").load("<?=$_SERVER['PHP_SELF']?>?cmd=check_order&count="+order_count);
	});
	
 });


</script>
</head>

<body>


<? include "header.php"; 
if ($_GET['s'] == "") $start = 0;
else $start = $_GET['s'];
$limit = 10;


if ($_REQUEST['q']) {
	$q=safe($_REQUEST['q']);
	$addsql=" and id=".intval($q)."";
	$additionalVars.="&q=".$q;
}

if ($_REQUEST['status']) {
	$status=safe($_REQUEST['status']);
	if ($addsql) {
		$addsql=" and status=".intval($status)."";
	} else {
		$addsql=" and status=".intval($status)."";	
	}
	
	$additionalVars.="&status=".$status;
}

$totalResults = getSqlNumber("SELECT id FROM orders where resid=".$_SESSION['restaid']." $addsql");
$totalResults_fortimer = getSqlNumber("SELECT id FROM orders where resid=".$_SESSION['restaid']."");
?>

<div id="content">
<div id="container">
<h1 class="h1">Orders</h1>
<input type="hidden" name="timer_count" id="timer_count" value="<?=$totalResults_fortimer?>" />
 <form id="sss" action="<?=$_SERVER['PHP_SELF']?>" method="GET"> 
Order Id: # <input type="text" name="q" id="q" value="<?=$_REQUEST['q']?>" style="width:100px;" class="input-text"/> <input type="submit" class="input-text"value="Search" />
</form>
<br />

<table width="100%">
  <tr>
    <td width="20%" class="tdheader">Date/Total</td>
    <td width="28%" class="tdheader">Shipping Address</td>
    <td width="28%" class="tdheader">Order Details</td>
    <td width="24%" class="tdheader" style="text-align:center;">Status</td>
  </tr>
  <?
  

$getRs = mysql_query("SELECT * from orders where resid=".$_SESSION['restaid']." and status > 1 $addsql order by orderdate desc LIMIT ".$start.",".$limit." ");
while ($rs = @mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
if (!$rs['deliverydate']) $rs['deliverydate']="Right Now";
$need_address=getWhere("order_types","need_address","order_type='".$rs['order_type']."'");
?>
  <tr>
    <td class="<?=$class?>">
	<br />OID : #<?=$rs['id']?><br />
	<?=date('g:iA (d-m-y)', strtotime($rs['orderdate']));?><br />
<? if ( $rs['discount'] > 0 ) { ?> Rest. Discount: <?=setPrice($rs['discount']);?><br /> <? } ?>
	<b><?=setPrice($rs['order_total']);?></b><br />
	</td>

    <td class="<?=$class?>">
<br />
	Name : <?=$rs['name']?><br />

	<? /* ?> <b>Delivery Date:</b>	<?=$rs['deliverydate']?><br /> <? */ ?>
	Address: <?=nl2br($rs['address'])?><br /><?=$rs['postcode']?><br /><?=$rs['city']?><br />

	Mobile : <?=$rs['mobilphone']?>
	<? if ($rs['order_note']) { ?>
	<br /><br />Order Note : <?=nl2br($rs['order_note'])?>
	<? } ?>
	<br /><br />
	</td>

    <td class="<?=$class?>">
	<br />
	
	<?
	$order_details="";
$getRss = mysql_query("SELECT * FROM order_details where orderid=".$rs['id']." order by id asc");
	while ($rss = mysql_fetch_array($getRss)) {
		$prod = getSqlField("SELECT name FROM products WHERE id=".$rss['prodid']."","name");
		$order_details.="- ".$rss['qty']." x ".$prod."<br />";
		if ($rss['optionals']) $order_details.="<span style='font-size:10px;line-height:14px;'>".$rss['optionals']."</span>";
	}
	echo $order_details;
	?>
	
	<br /><br />
	</td>

    <td class="<?=$class?>"><br />
Order Status: <?=getVal("order_statuses","status",$rs['status'])?><br />

Order type: <?=$rs['order_type']?><br />
Payment: <?=$rs['paymenttype'];?><br />



	<? if ( strtolower($rs['paymenttype']) !== "cod" ) { ?><br />
	Payment Status: <?php if($rs['payment_status']=="1") { echo "<b><font color='green'>PAID</font></b>"; } else { echo "PENDING"; } ?><br />
	OP ID: <?=$rs['tracking_id'];?><br />
	Mode: <?=$rs['payment_mode'];?><br />
	Via: <?=$rs['card_name'];?><br />
	<? } ?>

	<br /><br />
	</td>

  </tr>
<? } ?>
</table>
<br />
<div class="pagination">
<ul>
<?
pages($start,$limit,$totalResults,$_SERVER['PHP_SELF'],$additionalVars);
?>
</ul>
</div>

<br/><br/><br/>

</div>
</div>

<? include "footer.php"; ?>

</body>
</html>