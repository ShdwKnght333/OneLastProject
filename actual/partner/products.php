<?
include "../conf/config.php";
include "check_login.php"; 


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Products</title>
<? include "styles.php"; ?>

<script language="JavaScript" type="text/javascript">

function Del(id) {
     if(!confirm('Are you going to delete this product!\nIs it ok?')) return false;
    $("#result").load("../conf/post_admin.php?cmd=del_product&back=<?=$_SERVER['PHP_SELF']?>&id="+id);
 location.reload(); 
}


function set_product_status(id,val) {
	$("#result").load("../conf/post_admin.php?cmd=set_product_status&back=<?=$_SERVER['PHP_SELF']?>&id="+id+"&val="+val);
}

function search_item() {
	$("#searchData").focus().select();
}

function updateStock(id) {
    $("#result").load("system/update_stock.php?id="+id);
}

</script>

    <style type="text/css" title="currentStyle">
                @import "system/products/grid_sytles.css";
                @import "system/products/jquery-ui-1.8.4.custom.css";

    </style>

    <!-- jQuery libs -->
    <script  type="text/javascript" src="system/products/jquery-ui-1.7.custom.min.js"></script>
    <script  type="text/javascript" src="system/products/jquery-search.js"></script>

    <script type="text/javascript">
    var TableBackgroundNormalColor = "#ffffff";
    var TableBackgroundMouseoverColor = "#E0ECF8";
    function ChangeBackgroundColor(row) { row.style.backgroundColor = TableBackgroundMouseoverColor; }
    function RestoreBackgroundColor(row) { row.style.backgroundColor = TableBackgroundNormalColor; }
    </script>

<!-- POPUP FOR STOCKUPDATE -->

    <style type="text/css">
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
include "sub_products.php";
 ?>

<div id="content">
<div id="container">
<br/>
<h1 class="h1">Products</h1>



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

<br/><br/>

            <table class="ui-grid-content ui-widget-content cStoreDataTable" id="cStoreDataTable">
                <thead>
                    <tr>
                        <th width="36%" class="ui-state-default">Product</th>
                        <th width="26%" class="ui-state-default">Category</th>
                        <th width="10%" class="ui-state-default">Price</th>
                        <th width="10%" class="ui-state-default">Stock</th>
                        <th width="18%" class="ui-state-default">Status & Del</th>
                    </tr>
                </thead>
                <tbody id="results"></tbody>
            </table>

        </div>
    </div>



<br/><br/>

</div>
</div>


<? include "footer.php"; ?>


</body>
</html>