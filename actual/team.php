<?
include "conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Team Foodzoned</title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<? include "inc/styles.php"; ?>

<style>
.team_member { -webkit-filter: grayscale(100%); filter: grayscale(100%); }
.team_member:hover { -webkit-filter: grayscale(0%); filter: grayscale(0%); }
</style>

</head>
<body>
<div class="mainbody">
<? include "inc/header.php"; ?>
<div id="content">
<!-- Page Content Start -->

<h1>Team Foodzoned</h1><br/>

<div>

<div class="member">
<img src="/img/page/team-01.png" class="team_member"><br/>
<h3>SOMIL KHICHA</h3>
FOUNDER & CEO
</div>

<div class="member">
<img src="/img/page/team-02.png" class="team_member"><br/>
<h3>GOPAL KRISHNA</h3>
CO-FOUNDER
</div>

<div class="member">
<img src="/img/page/team-03.png" class="team_member"><br/>
<h3>MADHUKAR</h3>
(SHIVANANDA) - CTO
</div>

<div class="clearfix"></div>
</div>
<br/><br/>

<!-- Page Content End -->
</div>
<? include "inc/footer.php"; ?>
<div class="clearfix"></div>
</div>
</body>
</html>