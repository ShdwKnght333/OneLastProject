<? 
include "../conf/config.php";
include "check_login.php"; 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Most Ordered Products</title>
<? include "styles.php";  ?>
</head>

<body>


<? include "header.php";
include "sub_reports.php"; ?>

<div id="content">
<div id="container">
<h1 class="h1">Most Ordered Products</h1>

<table width="100%">
  <tr>
    <td width="45%" class="tdheader">Product Name</td>
    <td width="15%" class="tdheader" style="text-align:right;">Order Count</td>
    <td width="20%" class="tdheader" style="text-align:right;padding-right:10px;">Product Price</td>
    <td width="20%" class="tdheader" style="text-align:right;padding-right:10px;">Total Price</td>
  </tr>
  <?
  
if ($_GET['s'] == "") $start = 0;
else $start = $_GET['s'];
$limit = 100;


$totalResults = getSqlNumber("SELECT id FROM order_details where resid=".$_SESSION['restaid']." group by prodid");
$getRs = mysql_query("SELECT *,sum(qty) as total_qty,sum(subtotal) as total from order_details where resid=".$_SESSION['restaid']." group by prodid order by total_qty desc LIMIT ".$start.",".$limit." ");
while ($rs = mysql_fetch_array($getRs)) {
$class=(($count++)%2==0)?"tda":"tdb";
?>
  <tr>
    <td class="<?=$class?>">
	<?=getVal("products","name",$rs['prodid']);?>
	</td>
    <td class="<?=$class?>" style="text-align:right;">
	<?=$rs['total_qty'];?>
	</td>
    <td class="<?=$class?>" style="text-align:right;padding-right:10px;">
	<b><?=setPrice($rs['price']);?></b>
	</td>
	<td class="<?=$class?>" style="text-align:right;padding-right:10px;">
	<b><?=setPrice($rs['total']);?></b>
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

</div>
</div>



<? include "footer.php"; ?>


</body>
</html>