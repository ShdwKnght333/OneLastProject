<?
include "conf/config.php";
checkLogin();

$rs=getSqlRow("select * from users where id=".$_SESSION['memberid']."");

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>My Account</title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<? include "inc/styles.php"; ?>
</head>
<body>
<div class="mainbody">
<? include "inc/header.php"; ?>
<div id="content">
<!-- Page Content Start -->

<br/><h1>My Account</h1>

 

<h3>
<a href="orders.php" class="link"><i class="fa fa-clock-o fa-2x"></i> &nbsp; My Orders</a><br/><br/>
<a href="delivery_addresses.php"><i class="fa fa-check-circle fa-2x"></i> &nbsp; Delivery Addresses</a><br/><br/>
<a href="member_details.php"><i class="fa fa-cog fa-2x"></i> &nbsp; Personal Information</a><br/><br/>
<a href="change_password.php"><i class="fa fa-refresh fa-2x"></i> &nbsp; Change Password</a>
</h3>



<!-- Page Content End -->
</div>
<? include "inc/footer.php"; ?>
<div class="clearfix"></div>
</div>
</body>
</html>