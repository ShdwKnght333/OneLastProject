<?
include "conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Find My Food</title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<? include "inc/styles.php"; ?>

    <style type="text/css" title="currentStyle">
                @import "/js/find-food/grid_sytles.css";
                @import "/js/find-food/jquery-ui-1.8.4.custom.css";
    </style>

    <!-- jQuery libs -->
    <script  type="text/javascript" src="/js/find-food/jquery-ui-1.7.custom.min.js"></script>
    <script  type="text/javascript" src="/js/find-food/jquery-search.js"></script>

</head>
<body>
<div class="mainbody">
<? include "inc/header.php"; ?>
<div id="content">
<!-- Page Content Start -->


    <div id="dataTable">

        <div class="ui-grid ui-widget ui-widget-content ui-corner-all">

            <div class="ui-grid-header ui-widget-header ui-corner-top clearfix">

<div class="header-left">

<?php 
$query_par2 = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'");
?>
<h1 style="text-align:left;">Find My Food</h1>

<select style="width:218px;" id="searchCity" class="input-text">
        <option value="0" selected>Select City</option>
        <?php while($row = mysql_fetch_array($query_par2)): ?>
        <option value="<?=$row['region'];?>"<? if ( $_SESSION['mycity'] == $row['region'] ) { echo " selected"; } ?>><?=$row['region'];?></option>
        <?php endwhile; ?>
</select><br/>

<input style="width:200px;" id="searchData" placeholder="Search for a product" type="text" class="input-text" autofocus>
</div>

                <div class="header-right">
<img src="/img/page/FMF-logo.png">
                </div>

                </div>

<br/>
            <table class="ui-grid-content ui-widget-content cStoreDataTable" id="cStoreDataTable">
                <thead>
                    <tr>
                        <th class="ui-state-default" width="30%">Name</th>
                        <th class="ui-state-default" width="15%">Price</th>
                        <th class="ui-state-default" width="30%">Category</th>
                        <th class="ui-state-default" width="25%">Service Provider</th>
                    </tr>
                </thead>
                <tbody id="results"></tbody>
            </table>

        </div>
    </div>


<!-- Page Content End -->
</div>
<? include "inc/footer.php"; ?>
<div class="clearfix"></div>
</div>
</body>
</html>