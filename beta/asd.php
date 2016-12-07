<?php
include "conf/config.php";
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>FAQ</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    
	<?php include "inc/styles.php"; ?>


<script src="js/bootstrap.min.js"></script>
	<!-- Stylesheets -->
   	<link rel="stylesheet" href="css/faqstyle.css"> <!-- Resource style -->
</head>
<body>
<?php include "inc/header.php"; ?>

	<div class="first-widget parallax" id="faq">
		<div class="parallax-overlay">
			<div class="container pageTitle">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2 class="page-title">FAQ</h2>
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.parallax-overlay -->
	</div> <!-- /.pageTitle -->
<!------------------------------------end of header-------------------------------------->
<div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

<?php include "inc/modal.php"; ?>
		
<!--Footer---------------------------------------------------------------------------------------->
	<?php include "inc/footer.php"; ?>

	<!-- Scripts -->
	<script>
	$(window).load(function()
{
    $('#myModal').modal('show');
});
</script>
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
    <script src="js/faqmain.js"></script> <!-- Resource jQuery -->
    <script src="js/b2tmain.js"></script><!--back-to-top-->
</body>
</html>