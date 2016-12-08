<?
include "../conf/config.php";
include "check_login.php"; 


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Offline Billing</title>
<? include "styles.php"; ?>

<script language="JavaScript" type="text/javascript">

function search_item() {
	$("#searchData").focus().select();
}

</script>

    <style type="text/css" title="currentStyle">
                @import "system/cart/grid_sytles.css";
                @import "system/cart/jquery-ui-1.8.4.custom.css";

    </style>

    <!-- jQuery libs -->
    <script  type="text/javascript" src="system/cart/jquery-ui-1.7.custom.min.js"></script>
    <script  type="text/javascript" src="system/cart/jquery-search.js"></script>

    <script type="text/javascript">
    var TableBackgroundNormalColor = "#ffffff";
    var TableBackgroundMouseoverColor = "#E0ECF8";
    function ChangeBackgroundColor(row) { row.style.backgroundColor = TableBackgroundMouseoverColor; }
    function RestoreBackgroundColor(row) { row.style.backgroundColor = TableBackgroundNormalColor; }
    </script>

<!-- POPUP FOR STOCKUPDATE -->

    <style type="text/css">

.prop { text-decoration: line-through; color:red; }
.my-total { text-align:right; color:#000000; }

        .web_dialog_overlay
        {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            background: #000000;
            opacity: .15;
            filter: alpha(opacity=15);
            -moz-opacity: .15;
            z-index: 101;
            display: none;
        }
        .web_dialog
        {
            display: none;
            position: fixed;
            width: 500px;
            height: 200px;
            top: 50%;
            left: 50%;
            margin-left: -190px;
            margin-top: -100px;
            background-color: #ffffff;
            border: 2px solid #336699;
            padding: 0px;
            z-index: 102;
            font-family: Verdana;
            font-size: 10pt;
        }
        .web_dialog_title
        {
            border-bottom: solid 2px #336699;
            background-color: #336699;
            padding: 4px;
            color: White;
            font-weight:bold;
        }
        .web_dialog_title a
        {
            color: White;
            text-decoration: none;
        }
        .align_right
        {
            text-align: right;
        }


.shopping-cart{
	width: 90%;
	background: #F0F0F0;
	padding: 10px;	
	border: 1px solid #DDD;
	border-radius: 5px;

}
.shopping-cart h2 {
	background: #E2E2E2;
	padding: 4px;
	font-size: 14px;
	margin: -10px -10px 5px;
	color: #707070;
}

.shopping-cart h3,.view-cart h3 {
	font-size: 12px;
	margin: 0px;
	padding: 0px;
}
.shopping-cart ol{
	padding: 1px 0px 0px 15px;
}
.shopping-cart .cart-itm, .view-cart .cart-itm{
	border-bottom: 1px solid #DDD;
	font-size: 11px;
	font-family: arial;
	margin-bottom: 5px;
	padding-bottom: 5px;
}
.shopping-cart .remove-itm, .view-cart .remove-itm{
	font-size: 14px;
	float: right;
	background: #D5D5D5;
	padding: 4px;
	line-height: 8px;
	border-radius: 3px;
}
.shopping-cart .remove-itm:hover, .view-cart .remove-itm:hover{
	background: #C4C4C4;
}
.shopping-cart .remove-itm a, .view-cart .remove-itm a{
	color: #888;
	text-shadow: 1px 1px 1px #ECECEC;
	text-decoration:none;
}

.check-out-txt{
	float:right;
}

    </style>
    <script type="text/javascript">

        $(document).ready(function ()
        {
            $("#btnShowSimple").click(function (e)
            {
                ShowDialog(false);
                e.preventDefault();
            });

            $("#btnClose").click(function (e)
            {
                HideDialog();
                e.preventDefault();
            });

        });

        function ShowDialog(modal)
        {
            $("#overlay").show();
            $("#dialog").fadeIn(300);

            if (modal)
            {
                $("#overlay").unbind("click");
            }
            else
            {
                $("#overlay").click(function (e)
                {
                    HideDialog();
                });
            }
        }

        function HideDialog()
        {
            $("#overlay").hide();
            $("#dialog").fadeOut(300);
        } 
        
    </script>


</head>

<body>


<? include "header.php";
 ?>

<div id="content">
<div id="container">
<br/>
<h1 class="h1">Offline Billing</h1>



    <div id="dataTable">

        <div class="ui-grid ui-widget ui-widget-content ui-corner-all">


<?php 
$query_par2 = mysql_query("SELECT * FROM menus where resid=".$_SESSION['restaid']." order by menu asc");
?>
<form onsubmit="search_item();return false;">
<select style="width:218px;" id="searchCat" class="input-text">
        <option value="0" selected>All Categories</option>
        <?php while($row = mysql_fetch_array($query_par2)): ?>
        <option value="<?=$row['id'];?>"><?=$row['menu'];?></option>
        <?php endwhile; ?>
</select> 

&nbsp; &nbsp; 
<input style="width:300px;" id="searchData" placeholder="Product Name / Barcode" type="text" autocomplete="off" onClick="this.value='';" class="input-text" autofocus>
</form>


<table width="100%">
<td width="70%">


            <table class="ui-grid-content ui-widget-content cStoreDataTable" id="cStoreDataTable">
                <thead>
                    <tr>
                        <th width="36%" class="ui-state-default">Product</th>
                        <th width="10%" class="ui-state-default">Price</th>
                        <th width="10%" class="ui-state-default">Stock</th>
                        <th width="18%" class="ui-state-default">ADD</th>
                    </tr>
                </thead>
                <tbody id="results"></tbody>
            </table>

</td>
<td>


<div class="shopping-cart">
<h2> &nbsp;Shopping Cart</h2>
<?php

	$_SESSION["$current_url"] = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    
if(isset($_SESSION["products"]))
{
    $total = 0;
    echo '<ol>';
    foreach ($_SESSION["products"] as $cart_itm)
    {
        echo '<li class="cart-itm">';
        echo '<span class="remove-itm"><a href="/partner/system/cart-update.php?removep='.$cart_itm["code"].'&return_url='.$_SESSION["$current_url"].'">&times;</a></span>';

        echo '<h3>'.$cart_itm["name"].'</h3>';

$rsp=getSqlRow("select * from products where id=".$cart_itm["code"]."");
if ( $rsp['stock'] == "2" && $cart_itm["qty"] > $rsp['stock_qty'] )
{ echo "<div class='p-code'><font color='red'>(No Stock)</font></div>"; }

        echo '<div class="p-qty">Qty : '.$cart_itm["qty"].'</div>';
        echo '<div class="p-price">Price :'.$currency.$cart_itm["price"].'</div>';
        echo '</li>';
        $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
        $total = ($total + $subtotal);
    }
    echo '</ol>';
    echo '<span class="check-out-txt"></span><br/><h2 class="my-total">Total : '.setPrice($currency.$total).' &nbsp; </h2>';
	echo '(<a href="/partner/system/cart-update.php?emptycart=1&return_url='.$_SESSION["$current_url"].'">Empty Cart</a>)<br/><form id="checkout_now" action="/partner/system/cart-update.php" class="my-total"><input type="hidden" name="checkout" value="1" /><input type="hidden" name="return_url" value="'.$_SESSION["$current_url"].'" /><button id="checkout_button" class="input-text">CHECKOUT NOW</button></form>';

}else{
    echo 'Your Cart is empty';
}
?>
</div>

</td>
</table>



        </div>
    </div>



<br/><br/>

</div>
</div>


<? include "footer.php"; ?>


</body>
</html>