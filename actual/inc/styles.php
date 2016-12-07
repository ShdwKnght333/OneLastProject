<!-- DESIGNED BY HAMGELE TECHNOLOGIES & MADHUKAR BANTWAL -->

 <link rel="shortcut icon" href="/favicon.ico" />
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

 <link href="/theme/font-awesome-new/css/font-awesome.min.css" rel="stylesheet">
 <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
 <link href="<?=SITEURL?>css/site-grid-main.css" type="text/css" rel="stylesheet" media="screen"/>
 <link href="<?=SITEURL?>css/main-site.css" type="text/css" rel="stylesheet" media="screen"/> 
 <link href="/theme/css/site-style-theme.css" rel='stylesheet' type='text/css' />

 <script type="text/javascript" src="<?=SITEURL?>js/jquery.js"></script>
 <script type="text/javascript" src="<?=SITEURL?>js/jquery.color.js"></script>
 <script type="text/javascript" src="<?=SITEURL?>js/site-main-fun.js"></script>

 <!-- start of sweetAlert -->
 <script src="js/sweetalert/lib/sweet-alert.min.js"></script>
 <link rel="stylesheet" type="text/css" href="js/sweetalert/lib/sweet-alert.css">
 <!-- End of sweetAlert -->

 <!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
 <![endif]-->

		<!-- start top nav script -->
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		</script>
		<script type="text/javascript" src="/theme/js/flexy-menu.js"></script>
		<script type="text/javascript">$(document).ready(function(){$(".flexy-menu").flexymenu({speed: 400,type: "horizontal",align: "right"});});</script>
		<!-- End-top-nav-script -->

<script type="text/javascript">
$(document).ready(function() {
	$("#parent_cat").change(function() {
		$.get('/inc/subcat.php?parent_cat=' + $(this).val(), function(data) {
			$("#sub_cat").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			}); }); }); });


$(document).ready(function() {
	$("#sub_cat").change(function() {
	$.get('/inc/sub-service.php?parent_city=' + $("#parent_cat").val() + '&parent_area=' + $("#sub_cat").val(), function(data) {
			$("#sub_cat_service").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			}); }); }); });
</script>


<?
if ( isset($_REQUEST['city']) && isset($_REQUEST['area']) )
{
$_SESSION['mycity'] = $_REQUEST['city'];
$_SESSION['myarea'] = $_REQUEST['area'];
}
?>