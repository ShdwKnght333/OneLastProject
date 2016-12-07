<?php  include "conf/config.php"; ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Find your food</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	  <!-- jQuery libs -->
	 <script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script  type="text/javascript" src="js/find-food/jquery-ui-1.7.custom.min.js"></script>
    <script  type="text/javascript" src="js/find-food/jquery-search.js"></script>
	<style type="text/css" title="currentStyle">
                @import "js/find-food/grid_sytles.css";
                @import "js/find-food/jquery-ui-1.8.4.custom.css";
    </style>
	<?php include "inc/styles.php"; ?>
</head>
<body>
<?php include "inc/login.php"; ?>
<?php include "inc/header.php"; ?>
<?php $query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'"); ?>
 <!---------------------------------------------header ends------------------------------------>   
	<div class="first-widget parallax" id="findmyfood">
		<div class="parallax-overlay">
			<div class="container pageTitle">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2 class="page-title">Find Your Food</h2>
					</div> <!-- /.col-md-6 -->
					
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.parallax-overlay -->
	</div><br> <!-- /.pageTitle -->
<!-----------------------------------------parallax ends------------------------------------------>
	<div class="container">	
		<div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;">
        	<div class="col-md-12">
                    <div class="findfood">
					<select style="width:218px;" id="searchCity" class="input-text" onchange="mycity(this.value)">	
						<?php if(isset($_SESSION['mycity']) && $_SESSION['mycity']){ ?>
						<?php while($row = mysql_fetch_array($query_parent)){ ?>
						<option value="<?php echo $row['region'];?>"<?php if (isset($_SESSION['mycity'])){ if ($_SESSION['mycity'] == $row['region'] ) { echo "selected"; } } ?>><?php echo $row['region']; ?></option>
						<?php  }?>
						<?php }else { ?>
						<option value="0" >Select City</option>
						<?php while($row = mysql_fetch_array($query_parent)){ ?>
						<option  value="<?php echo $row['region']; ?>"<?php if (isset($_SESSION['mycity'])){ if ($_SESSION['mycity'] == $row['region'] ) { echo "selected"; } } ?>><?php echo $row['region']; ?></option>
						<?php }// End of While?>
					   <?php	 }//End of Else ?>
					</select>     
					 <md-input-container>
                                    <input id="searchData" class="md-input" maxlength="70"  type="text" placeholder="Search Your Food" autofocus>
                  </md-input-container>
                   <div>
                           
                        </div>
                 	</div>
                 </div>
             </div><br>
             <div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;">
        	  <div class="col-md-12">
              	<div class="findfoodtb">
                <table>
                <thead>
                    <tr>
                        <th width="30%">Name</th>
                        <th width="15%" style="text-align:right;">Price</th>
                        <th width="30%" style="text-align:right;">Category</th>
                        <th width="25%" style="text-align:right;">Service Provider</th>
                    </tr>
                </thead>
                <tbody id="results"></tbody>
            </table>
            </div>
            </div>                                                   
		</div> <!-- /.row -->
	</div><br> <!-- /.container -->

<!--Footer-------------------------------------------------------------------------------------->
	<?php include "inc/footer.php"; ?>
<!-------------------------------------------------------------------------------------------->

	<!-- Scripts -->
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
   <script src="js/b2tmain.js"></script><!--back-to-top-->
	<script type="text/javascript"> <!---------- Store the City in the Session--------->
function mycity(str) {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("myarea").value="";
					document.getElementById("myservice").style ="display:none";
            }
        };
        xmlhttp.open("GET","mycity.php?mycity="+str,true);
        xmlhttp.send();
}
</script>	
</body>
</html>
