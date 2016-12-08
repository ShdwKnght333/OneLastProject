<?
include "conf/config.php";
checkLogin();
$rs=getSqlRow("select * from users where id=".$_SESSION['memberid']."");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>My Orders</title>
<? include "inc/styles.php"; ?>
<script>
function rate(id) {
	$.post("conf/post.php", { cmd: "rate", id: id, speed:$("#rate_speed_"+id).val(), service:$("#rate_service_"+id).val(), taste:$("#rate_taste_"+id).val() }, 
        function(data) {
		$("#result").html(data);
		$("#td_speed_"+id).html($("#rate_speed_"+id).val());
		$("#td_service_"+id).html($("#rate_service_"+id).val());
		$("#td_taste_"+id).html($("#rate_taste_"+id).val());
});
}
</script>
</head>
<body>

<div class="mainbody">

<? include "inc/header.php"; ?>
                

<div id="content" class="container_12">
<div class="grid_12">
<h1>Order History</h1>
<div>

<? if( $_REQUEST['for'] && $_REQUEST['paid'] == 1 )  { ?>
<div style="padding:10px;background:#ffcccc;color:#cc0000;">
Order ID : #<?=$_REQUEST['for']?> - Your transaction could not be completed!
</div><br/>
<? } ?>

<? if( $_REQUEST['for'] && $_REQUEST['paid'] == 2 )  { ?>
<div style="padding:10px;background:#ccff99;color:#669900;">
Order ID : #<?=$_REQUEST['for']?> - Your transaction was successfully processed!
</div><br/>
<? } ?>

<form id="myform" name="myform" method="post" action="javascript:void(null);">
<div style="background:#fff;margin:0px;padding:2%;">
<table border="0" width="100%" style="padding:2px;">
  <tr style="background:#dedede;padding:5px;">
    <th width="25%" class="tdheader">Status</th>
    <th width="30%" class="tdheader"><?=$GLOBALS['delivery_address']?></th>
    <th width="45%" class="tdheader"><?=$GLOBALS['order_details']?></th>
  </tr>
  
<?
if ($_GET['s'] == "") $start = 0;
else $start = $_GET['s'];
$limit = 5;

$totalResults = getSqlNumber("SELECT id FROM orders where userid=".$_SESSION['memberid']."");
$getRs = mysql_query("SELECT * from orders where userid=".$_SESSION['memberid']." order by id desc  LIMIT ".$start.",".$limit." ");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
$rest_name = getSqlField("SELECT name FROM rests WHERE id=".$rs['resid']."","name");

?>
<tr id="tr_<?=$rs['id'];?>" style="border-bottom:1px solid #dedede; padding-bottom:20px;">

<td class="<?=$class?>" style="padding-bottom:20px;">

<? 
if($rs['status'] < 2 ) { 
$to_time = strtotime(date( "Y-m-d H:i:s" ));
$from_time = strtotime($rs['orderdate']);
$od_time = round(abs($to_time - $from_time) / 60,0);

if ( $od_time < "20" ) {
?>

<br /><b><a href="/payment.php?oid=<?=$rs['id']?>&token=<?=md5($rs['id']);?>">MAKE PAYMENT</a></b><br />
<? } } ?><br/>


Status : <?=getVal("order_statuses","status",$rs['status']);?><br /><br />
ID #<?=$rs['id']?><br />
Payment : <?=$rs['paymenttype']?><br />
Order Type : <?=$rs['order_type']?><br />
Date : <? echo date('d-m-Y (g:iA)', strtotime($rs['orderdate']));?><br />

<? if ( $rs['discount'] > 0 ) { ?> Rest. Discount: <?=setPrice($rs['discount']);?><br /> <? } ?>

</td>

<td class="<?=$class?>" style="padding-bottom:20px;">
<br/><?=$rs['name'];?><br /><?=$rs['address'];?><br /><?=$rs['city'];?><br />Ph.: <?=$rs['mobilphone'];?>
<br/>
<? if ($rs['order_note']) { ?><br/>Order Note : <?=$rs['order_note'];?> <? } ?>
</td>

<td class="<?=$class?>" style="padding-bottom:20px;"><br/>
Service Provider : <a href="<?=setRestUrl($rs['resid'],$rest_name)?>" title="<?=$rest_name?>"><?=$rest_name?></a><br /><br /> 

<? $order_details="";
$getRss = mysql_query("SELECT * FROM order_details where orderid=".$rs['id']." order by id asc");
	while ($rss = mysql_fetch_array($getRss)) {
		$prod = getSqlField("SELECT name FROM products WHERE id=".$rss['prodid']."","name");
		$order_details.="- ".$rss['qty']." x ".$prod." [".setPrice($rss['price'])."]<br />";
		if ($rss['optionals']) $order_details.=" ".$rss['optionals']." ";
	}
	echo $order_details;
	?>

<br/>
Subtotal : <?=setPrice($rs['sub_total']);?><br/>
Taxes : <?=setPrice($rs['tax_total']);?><br/>
Delivery charge :  <?=setPrice($rs['service_fee']);?><br/><br/>

Order Total : <?=setPrice($rs['order_total']);?><br />
<? if ( $rs['payment_status'] == "1" ) { ?>
Convenience Fee : <?=setPrice($rs['con_fee']);?><br />
Amount Paid : <?=setPrice($rs['paid_amount']);?><br /><br /> 
<? } ?>

	</td>
  </tr>
  
  <? } ?>
  
</table>
</div>

<br />
<div class="pagination">
<ul>
<?
pages($start,$limit,$totalResults,$_SERVER['PHP_SELF'],$additionalVars);
?>
</ul>
</div>

</form>

<br /><br />

</div>
</div>
</div>
            

<? include "inc/footer.php"; ?>
            
<div class="clearfix"></div>
</div>

</body>
</html>