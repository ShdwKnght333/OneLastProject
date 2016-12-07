<?php
include "conf/config.php";
checkLogin();

if(isset($_SESSION['memberid'])&& $_SESSION['memberid']  ){
$rs=getSqlRow("select * from users where id=".$_SESSION['memberid']."");
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>My Orders</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
    
	<?php include "inc/styles.php"; ?>
</head>
<body>
<?php include "inc/header.php"; ?>

<!----------------------------------------------------header ends----------------------------->
	<div class="first-widget parallax" id="myorders">
		<div class="parallax-overlay">
			<div class="container pageTitle">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<h2 class="page-title"><?php  if(isset($_SESSION['profile_pic'])&& $_SESSION['profile_pic'] ){ ?><img src="<?php echo $_SESSION['profile_pic']; ?>" height="64" width="64" style="border-radius: 50%;"><?php } else if($rs['gender'] ==1){?><img src="images/male.png" height="64" width="64" style="border-radius: 50%;"><?php }  else if($rs['gender'] ==0){ ?><img src="images/female.png" height="64" width="64" style="border-radius: 50%;"><?php }else { ?><img src="default-user.png" height="64" width="64" style="border-radius: 50%;"><?php  }?> Hello! <?php echo $rs['name'];  ?></h2>
					</div> <!-- /.col-md-6 -->
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div> <!-- /.parallax-overlay -->
	</div><br> <!-- /.pageTitle -->

	<div class="container">	
		<div class="row" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;">
        	<div class="col-md-12">
            	<div class="cd-tabs">
					<nav>
						<ul class="cd-tabs-navigation">
							<li><a data-content="myorders" class="selected" href="#0"><span class="fa fa-history fa-2x"></span> Order History </a></li>
							<li><a data-content="review" href="#0"><span class="fa fa-repeat fa-2x"></span> Reviews</a></li>
						</ul> <!-- cd-tabs-navigation -->
					</nav>

					<ul class="cd-tabs-content">
						<li data-content="myorders" class="selected">
							<div id="content" class="container_12">
								<div class="grid_12">
								<br>
								<div>

								<?php if( isset($_REQUEST['paid'] ) && $_REQUEST['paid']=='false' )  { ?>
								<div style="padding:10px;background:#ffcccc;color:#cc0000;">
								Order ID : #<?php echo $_REQUEST['order_id']; ?> - Your transaction could not be completed!
								</div><br/>
								<?php } ?>

									<?php if( isset($_REQUEST['paid'] ) && $_REQUEST['paid']=='true' )  { ?>
								<div style="padding:10px;background:#ccff99;color:#669900;">
								Order ID : #<?php echo $_REQUEST['order_id']; ?> - Your transaction was successfully processed!
								</div><br/>
								<?php } ?>

								<!--<form id="myform" name="myform" method="post" action="javascript:void(null);">-->
								<div style="background:#fff;margin:0px;padding:2%;">
								<table border="0" width="100%" style="padding:2px;">
								  <tr style="background:#ff554e;padding:5px; color:#fff;">
									<th width="30%"  style="padding-left:10px;" class="tdheader">Status</th>
									<th width="30%" class="tdheader"><?php echo $GLOBALS['delivery_address']; ?></th>
									<th width="40%" class="tdheader"><?php echo $GLOBALS['order_details']; ?></th>
								  </tr>
								<?php
								$count=0;
								$totalResults = getSqlNumber("SELECT id FROM orders where userid=".$_SESSION['memberid']."");
								$getRs = mysql_query("SELECT * from orders where userid=".$_SESSION['memberid']." order by id desc ");
								if(is_resource($getRs)){
								while ($rs = mysql_fetch_array($getRs)) {
								$class=(($count++)%2==0)?"tda":"tdb";
								$rest_name = getSqlField("SELECT name FROM rests WHERE id=".$rs['resid']."","name");
								?>
								<tr id="tr_<?php echo $rs['id'];?>" style="border-bottom:1px solid #dedede; padding-bottom:20px;">

								<td class="<?php echo $class; ?>" style="padding-bottom:20px;">
								<?php 
								if($rs['status'] < 2 ) { 
								$to_time = strtotime(date( "Y-m-d H:i:s" ));
								$from_time = strtotime($rs['orderdate']);
								$od_time = round(abs($to_time - $from_time) / 60,0);

								if ( $od_time < "20" ) {
								?>
								<br /><strong><a href="check-payment.php?oid=<?php echo $rs['id']?>&token=<?php echo md5($rs['id']);?>">MAKE PAYMENT</a></strong><br />
								<?php } } ?>

								Status :  <?php echo getVal("order_statuses","status",$rs['status']);?></br>
								ID #<?php echo $rs['id']?><br />
								Payment : <?php echo $rs['paymenttype']?><br />
								Order Type : <?php echo $rs['order_type']?><br />
								Date : <?php echo date('d-m-Y (g:iA)', strtotime($rs['orderdate']));?><br />

								<?php if ( $rs['discount'] > 0 ) { ?> Rest. Discount: <?php echo setPrice($rs['discount']);?><br /> <?php } ?>

								</td>

								<td class="<?php echo $class ?>" style="padding-bottom:40px;padding-right:40px">
								<br/><?php echo $rs['name'];?><br /><?php echo $rs['address'];?><br /><?php echo $rs['city'];?><br />Ph.: <?php echo $rs['mobilphone'];?>
								<br/>
								<?php if ($rs['order_note']) { ?><br/>Order Note : <?php echo $rs['order_note'];?> <?php } ?>
								</td>

								<td class="<?php echo $class?>" style="padding-bottom:20px;"><br/>
								<strong><a href="<?php echo setRestUrl($rs['resid'],$rest_name)?>" title="<?php echo $rest_name?>"><?php echo $rest_name?></a></strong><br />
								<?php $order_details="";
								$getRss = mysql_query("SELECT * FROM order_details where orderid=".$rs['id']." order by id asc");
									while ($rss = mysql_fetch_array($getRss)) {
										$prod = getSqlField("SELECT name FROM products WHERE id=".$rss['prodid']."","name");
										$order_details.="- ".$rss['qty']." x ".$prod." [".setPrice($rss['price'])."]<br />";
										if ($rss['optionals']) $order_details.=" ".$rss['optionals']." ";
									}
									echo $order_details;
									?>
								<!-- Subtotal : <?php echo setPrice($rs['sub_total']);?><br/>
								Taxes : <?php echo setPrice($rs['tax_total']);?><br/>
								Delivery charge :  <?php echo setPrice($rs['service_fee']);?><br/> -->
								Order Total : <?php echo setPrice($rs['order_total']);?><br />
								<?php if ( $rs['payment_status'] == "1" ) { ?>
								Convenience Fee : <?php echo setPrice($rs['con_fee']);?><br />
								Amount Paid : <?php echo setPrice($rs['paid_amount']);?><br /><br /> 
								<?php } ?>

									</td>
								  </tr>
								  
								<?php }} ?>
								  
								</table>
								</div>

								<br />
								<!--</form>-->

								<br /><br />

								</div>
								</div>
								</div>
						</li>					
								
						<li data-content="review">
							<div class="review_container" style="background:#fff;box-shadow: 0 1px 2px 0 rgba(0,0,0,.2); border-radius:2px;">
								<div class="col-md-12">
									<h2>Privacy Policy</h2>
									<p align="justify">
										Foodozoned has created this statement in order to demonstrate our commitment to your privacy, while you visit our web site. This statement discloses the information practices for the Foodozoned web site, including what type of information is gathered and tracked, how the information is used and with whom the information is shared. To make this notice easy to find, we make it available on our homepage and at every point where personal identification information may be requested.
									</p>
								</div>
							</div><br>
						</li>
					</ul> <!-- cd-tabs-content -->
				</div> <!-- cd-tabs -->
            </div>
        </div><br>
    </div><br> <!-- /.container -->

<!--Footer----------------------tnahsushant-------------------------------->
	<?php include "inc/footer.php"; ?>


	<!-- Scripts -->
	<script src="js/min/plugins.min.js"></script>
	<script src="js/min/medigo-custom.min.js"></script>
	<script src="js/tabs.js"></script>
   	<script src="js/b2tmain.js"></script><!--back-to-top-->
</body>
</html>