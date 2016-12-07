<div class="responsive_menu">
        <ul class="main_menu">
            <li><a href="contact.php">Contact</a></li>
			<?php if (isset($_SESSION['memberid'])&& $_SESSION['memberid']) { ?>
			<?php $user=getSqlRow("select name from users where id='".$_SESSION['memberid']."' "); ?>
		<li><a href="orders.php">My Orders</a></li>
	<li><a href="member-details.php">My Account</a></li>
	<li><a href="wallet.php">FzWallet ₹ <?php echo getWalletBalance(); ?></a></li>
		<li><a href="logout.php">Log Out</a></li>
		<?php } ?>
        </ul> <!-- /.main_menu -->
    </div> <!-- /.responsive_menu -->

	<header class="site-header clearfix">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="pull-left logo">
						<a href="index.php">
							<img src="images/circlefz1.png" width="200" height="56" alt="FoodZoned">
						</a>
					</div>	<!-- /.logo -->
					<div class="main-navigation pull-right">
						<nav class="main-nav visible-md visible-lg">
							<ul class="sf-menu">
								<!--<li><a href="orders.php">MY ORDERS</a></li>
								<li><a href="member.php">ACCOUNT</a></li>-->
					            <li><a href="contact.php">Contact</a></li>
								<?php if (isset($_SESSION['memberid'])&& $_SESSION['memberid']) { ?>
								<li class="dropdown_mem">
										<a href="javascript:void(0)" class="dropmem" onclick="member_func()"><?php if(isset($_SESSION['profile_pic'])&& $_SESSION['profile_pic'] ){ ?><img src="<?php echo $_SESSION['profile_pic']; ?>" width="30" height="30" style="border-radius:50%;"> <?php }else { ?><img src="images/default-user.png" width="30" height="30" style="border-radius:50%;"> <?php } ?> <?php echo $user['name']; ?> <span class="fa fa fa-chevron-down"></span></a>
									<div class="dropdown-content_mem" id="myDropdown_mem">
									  <a href="orders.php" style="border-bottom: 1px solid #868686;"><i class="fa fa-history"></i> My orders</a>
									  <a href="member-details.php" style="border-bottom: 1px solid #868686;"><i class="fa fa-user"></i> My account</a>
									  <a href="wallet.php" style="border-bottom: 1px solid #868686;"><img src="images/wallet24.png"width="22px"height="22px"> ₹ <?php echo getWalletBalance(); ?> </a>
									  <a href="logout.php"><i class="fa fa-sign-out"></i> Log out</a> 
									</div>
								  </li>
								<?php } ?>
							</ul> <!-- /.sf-menu -->
						</nav> <!-- /.main-nav -->
						<!-- This one in here is responsive menu for tablet and mobiles -->
					    <div class="responsive-navigation visible-sm visible-xs">
					        <a href="#nogo" class="menu-toggle-btn">
					            <i class="fa fa-bars"></i>
					        </a>
					    </div> <!-- /responsive_navigation -->
					</div> <!-- /.main-navigation -->
				</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
		</div> <!-- /.container -->
	</header> <!-- /.site-header -->