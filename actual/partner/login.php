<? 
include "../conf/config.php"; 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Service Provider Login | Foodzoned.com</title>

<link rel="stylesheet" type="text/css" media="all" href="<?=SITEURL?>css/reset.css" />
<link href="../css/login.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?=SITEURL?>js/jquery.js"></script>
<script type="text/javascript" src="<?=SITEURL?>js/jquery.color.js"></script>
<script type="text/javascript" src="<?=SITEURL?>js/site-main-fun.js"></script>

</head>
<body>

<?
$scr=explode("partner/",$_SERVER['SCRIPT_NAME']); 
$scr=$scr[1]; 
$arr_home=array("index.php", "bolgeler.php", "semtler.php", "payment_types.php");
$arr_prods=array("products.php", "product.php", "optionals.php");
?>

<div id="content">
<div id="container">

    <br/><br/><br/><br/><br/>
    <div class='form'>
      <h1 class="h1-login">Service Provider Login</h1>
      <div class='line'></div>
      <!-- Span class ie-placeholder is there for IE browser. IE doesn't support placeholder attribute -->
<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="res_login" />
        <span class='ie-placeholders'>Login:</span><input type='text' placeholder='Username' name="username" id="username" />
        <span class='ie-placeholders'>Password:</span><input type="password" name="password" id="password" placeholder='Password' />
        <input type='submit' class='btn-sign-in btn-orange' name="sbt" id="sbt" value='Login' onclick='this.disabled=true; post_admin("myform"); return false;' />
      </form>
    </div>

<center>
<font size="1px" color="#9D9D9D">DESIGNED BY HAMGELE TECHNOLOGIES</font>
</center>


</div></div>
<div id="result"></div>
<?
if ($dbh[0] != 0) {
mysql_close($dbh);
}
?>

</body>
</html>