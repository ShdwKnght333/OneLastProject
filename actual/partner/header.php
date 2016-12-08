<?
$scr=explode("partner/",$_SERVER['SCRIPT_NAME']); 
$scr=$scr[1]; 
$arr_home=array("index.php", "bolgeler.php", "semtler.php");
$arr_prods=array("products.php", "product.php", "optionals.php", "categories.php", "extra-item.php");
$arr_settings=array("edit.php", "logo.php", "hours.php", "payment_types.php", "delivery_areas.php");
$arr_reports=array("reports.php", "report_most_ordered.php");
?>

<div id="header">
<div id="container">

<h1><? if ($_SESSION['restusern']) echo "<span style='color:#000;'>".$_SESSION['restname']."</span>";?></h1>

<? if ($_SESSION['restarea']=="Active") { ?>
<div id="headermenu" class="tabmenu">  
<ul>
<li <? if (in_array($scr, $arr_home)) echo"class='active'";?>><a href="./">Home</a></li>
<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"cart.php")>0) echo"class='active'";?>><a href="cart.php">Offline Billing</a></li>
<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"orders.php")>0) echo"class='active'";?>><a href="orders.php">Online Orders</a></li>
<li  <? if (in_array($scr, $arr_prods)) echo"class='active'";?>><a href="products.php">Products</a></li>
<li  <? if (in_array($scr, $arr_reports)) echo"class='active'";?>><a href="reports.php">Reports</a></li>
<li <? if (in_array($scr, $arr_settings)) echo"class='active'";?>><a href="edit.php">Settings</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</div><p style="clear: both;"></p>
<? } ?>
</div>
</div>
