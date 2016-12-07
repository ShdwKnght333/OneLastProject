<?php
include "conf/config.php";
if (isset($_SESSION['memberid'])&& $_SESSION['memberid']) {
header("Location: ".SITEURL."review-order.php");
} 
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Your Details</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    
	<?php include "inc/styles.php"; ?>
	<link rel="stylesheet" href="css/checkout.css">
	<link rel="stylesheet" href="css/loginstyle.css">	
</head>
<body>
<?php include "inc/login.php"; ?>
<?php include "inc/header-abs.php"; ?>


<!----------------------------------------------------header ends----------------------------->
		<section>
			<nav>
				<ol class="cd-multi-steps text-bottom count">
					<li class="current"><a>Login</a></li>
					<li><em>Review</em></li>
					<li><em>Payment</em></li>
				</ol>
			</nav>
		</section> <!-- /.pageTitle -->
	
<div class="login_contain">
	<div class="container">
		<div class="row" style="box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;">
		<div class="login_header">
					<h3 class="center">Provide your details to Proceed</h3>
				</div>
				</div>
		<div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;padding:20px 10px;">
        	<div class="col-md-12 col-sm-12 col-xs-12 center">
			<div class="col-md-6">
			<?php 
			$logo="";
			if(isset($_POST['r']) && $_POST['r']){
			$session_id = session_id();
			$rest_id=getWhere("cart","rest_id","session_id='".session_id()."'");
			$rss=getSqlRow("SELECT * FROM rests WHERE id=".$rest_id."");
			$logo="logos/".$rss['id'].".jpg";
			}
			?>
			<?php
			if (file_exists($logo)) { ?>
				<img src="<?php echo $logo?>" alt="<?php echo $rss['name']; ?>"><br><br>	
			<?php }else {	?>
			<img src="logos/default_logo.jpg" alt="Restaurant"><br><br>
			<?php }?>
			</div>
			<div id="extra_info" class="col-md-6">
			<H2><a href="<?php echo setRestUrl($rss['id'],$rss['name']); ?>" title="<?php echo $rss['name']; ?>" style="color:#222;"><?php if (strlen($rss['name']) >= 21) { echo substr($rss['name'], 0, 21). "..."; } else { echo $rss['name']; } ?></a></H2>

				<?php if(isset($_POST['c']) && $_POST['c']){ ?>
				<span><?php echo $GLOBALS['total_amount']; ?>
            <span><?php echo setPrice($_POST['c']);?></span></span>
				<?php }?>
			</div>
            </div>
				<div class="col-md-12 col-sm-12 col-xs-12 center">
			<a  style="text-decoration:none; cursor:pointer;" role="button" class="buttonwallet buttoncoupon" onclick="document.getElementById('id01').style.display='block'">Login to Continue</a>		
        </div>
		
		</div>       
    </div>
</div><br> <!-- /.container -->

<!--Footer-------------------------------------------------------------------------------------->
	<?php include "inc/footer-checkout.php"; ?>


	<!-- Scripts -->
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
	<script src="js/jslog/lpginpop.js"></script>  <!--login-->
   	<script src="js/b2tmain.js"></script><!--back-to-top-->
<!-- Auth script -->
	<script>
$(document).keyup(function(n){"27"==n.which&&$("#id01").hide()}),window.onclick=function(n){n.target==modal&&(modal.style.display="none")};
	</script>
	<script>
function post(form) {
	var form=$('#'+form).serialize();
	$.ajax({
		type: 'POST',
		url: 'conf/post.php',
		data: form,
		success: function(result) {
			$('#result').html(result);
			$('.btn').prop('disabled', false);
			
		}
	});
	return false;
}
	</script>
	 <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>
      FB.init({appId: '<?php echo FACEBOOK_APP_ID ?>', status: true, cookie: true, xfbml: true});
      FB.Event.subscribe('auth.login', function(response) {
        window.location.reload();
      });
    </script>
<!-- Auth Script Ends -->
</body>
</html>