<?php
include "conf/config.php";
?>
<!DOCTYPE html>
<html>	
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<title><?=SITENAME?> | Delivery & Takeaway | Restaurants, Grocery & More...</title>

<meta name="description" content="Foodzoned.com is an online food ordering portal which consists of the varied menus of all the food joints enlisted on it. The website acts as a one-step go platform for the users who wish to order food online. The website releases the users from the humdrum of carrying printed menu cards and searching for restaurant phone numbers." />
<meta name="keywords" content="Foodzoned, Team Foodzoned, Manipal, Mangalore, Order Food Online, Food Delivery, Online Food Ordering Portal, Online Menus, Restaurant Menus, Order Online, Takeaway Delivery, Online Food Delivery, Foodzoned.com, Restaurants in Mangalore, Restaurants in Manipal, Manipala" />

<meta property="og:title" content="Foodzoned.com | Delivery & Takeaway | Restaurants, Grocery & More"/>
<meta property="og:image" content="http://www.foodzoned.com/img/website-logo.png"/>
<meta property="og:site_name" content="Foodzoned.com"/>
<meta property="og:description" content="Foodzoned.com is an online food ordering portal which consists of the varied menus of all the food joints enlisted on it. The website acts as a one-step go platform for the users who wish to order food online. The website releases the users from the humdrum of carrying printed menu cards and searching for restaurant phone numbers."/>

<?php include "inc/styles.php"; ?>
</head>
<body>
<div class="mainbody">

<?php include "inc/index-header.php"; ?>
<div id="content">

<center><br/>
<?php /* ?><img src="/img/page/homepage/appbanner.png"><?php */ ?>

<a href="app.php"><img src="/img/page/homepage/appbanner.png">

<?/*?><a href="offer-info.php?offer=diwalidhamaka" title="DIWALI DHAMKA 2016"><img src="/img/page/homepage/diwali-banner-final2.gif"><?php*/?>
</a>
</center>

<div class="homepage-c3"><br/>
<div class="home-points">
<h3><small><i class="fa fa-smile-o fa-5x"></i></small></h3>
<h2><span class="counter"><?=getSqlNumber("SELECT id FROM orders WHERE status = 7");?></span>+
<br/>Orders Delivered</h2>
</div>
<div class="home-points">
<h3><small><i class="fa fa-newspaper-o fa-5x"></i></small></h3><h2><span class="counter">62</span>+<br/>Categories</h2>
</div>
<div class="home-points">
<h3><small><i class="fa fa-user fa-5x"></i></small></h3>
<h2><span class="counter">75</span>+<br/>Service Providers</h2>
</div>
<div class="home-points">
<h3><small><i class="fa fa-motorcycle fa-5x"></i></small></h3><h2><span class="counter">150</span>+<br/>Delivery Areas</h2>
</div>
<div class="home-points">
<h3><small><i class="fa fa-shopping-cart fa-5x"></i></small></h3><h2><span class="counter">16000</span>+<br/>Products Listed</h2>
</div>
<div class="clearfix"></div>
</div>


<!-- Homepage-2 Start -->

<br/>
<div id="homepage-c2">
<div class="home-1" style="padding-top:5px;">

<?php if ( $_SESSION['mycity'] == "MANIPAL") { ?>
<a href="/hiren-wines-60.html"><img src="/img/page/homepage/manipal-liquors.jpg"></a>
<?php } else { ?>
<a href="/find-my-food.php"><img src="/img/page/homepage/homepage-134.png"></a>
<?php } ?>


</div>
<div class="home-2">
<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2FFoodzoned&amp;height=358&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=false&amp;appId=756619687729565" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:280px;" allowTransparency="true"></iframe>
</div>
<div class="home-3">
<h2>Your Benefits @ FOODZONED</h2>
<h3 class="g1"><i class="fa fa-check-square-o fa-1x g2"></i> &nbsp; Delivery within *45 Minutes</h3>
<h3 class="g1"><i class="fa fa-check-square-o fa-1x g2"></i> &nbsp; Online Deals & Promotions</h3>
<h3 class="g1"><i class="fa fa-check-square-o fa-1x g2"></i> &nbsp; Best Local Service Providers</h3>
<h3 class="g1"><i class="fa fa-check-square-o fa-1x g2"></i> &nbsp; Reach More Categories</h3>
<h3 class="g1"><i class="fa fa-check-square-o fa-1x g2"></i> &nbsp; Multiple Service Ordering</h3>
<h3 class="g1"><i class="fa fa-check-square-o fa-1x g2"></i> &nbsp; Service Delivered to Doorstep</h3>
<h3 class="g1"><i class="fa fa-check-square-o fa-1x g2"></i> &nbsp; Dedicated Customer Support</h3>
<h3 class="g1"><i class="fa fa-check-square-o fa-1x g2"></i> &nbsp; Secure Payment Options</h3>
</div>
<div class="clearfix"></div>
</div>
<br/>

<!-- FOODZONED OFFERS -->

<div id="content" class="container_12">
<div class="grid_12">
<h1>OFFERS <font size="2">( <a href="/offers.php">VIEW ALL</a> )</font></h1>
</div>
<?php
if ( $_SESSION['mycity'] && $_SESSION['myarea'] )
{
$ec12=getSqlRow("select id from delivery_areas where region='".$_SESSION['mycity']."' and city='".$_SESSION['myarea']."'");
$getR2 = mysql_query("SELECT rest_id FROM rest_delivery_area WHERE da_id='".$ec12['id']."'");

unset($list);
while ($R2 = mysql_fetch_array($getR2)) { $list .= (string) $R2['rest_id'] . ","; }
$list = substr($list, 0, -1);

$getRss = mysql_query("SELECT * FROM offers WHERE status=1  AND resid IN (" . $list . ") order by priority desc LIMIT 0,4");
}
else
{
$getRss = mysql_query("SELECT * FROM offers WHERE status=1 order by priority desc LIMIT 0,4");
}

$count=mysql_num_rows($getRss);
if(!$count>=1) { echo "Sorry, No offers found."; }


while ($rss = mysql_fetch_array($getRss)) {

$logo="logos/".$rss['resid'].".jpg";
$rname=getval( "rests", "name", $rss['resid'] );
$raddress=getval( "rests", "address", $rss['resid'] );
$rtype=getval( "rests", "type", $rss['resid'] );

?>

<div class="grid_4" style="margin-bottom:20px;margin-right:30px;">
<div class="sitems">

<center>
<?php if (file_exists($logo)) { ?>
<div class="rest_logo">
<a href="<?=setRestUrl($rss['resid'],$rname)?>" title="<?=$rname?>"><img src="<?=$logo?>" class="rest_logo"/></a>
</div>
<?php } else { ?>
<div class="rest_logo">
<a href="<?=setRestUrl($rss['resid'],$rname)?>" title="<?=$rname?>"><img src="img/default_logo.jpg" class="rest_logo"/></a>
</div>
<?php } ?>
</center>

<div style="min-height:85px;padding:0px 5px 0px 8px;">
<h3 style="color:#ff6600"><?=getval( "rests", "name", $rss['resid'] )?></h3>
<b><?=$rss['name']?></b><br/>
<?=$rss['details']?>

</div>
<h3 align="center"><a href="<?=setRestUrl($rss['resid'],$rname)?>" title="VIEW OFFER" class="vmenu">VIEW OFFER</a></h3>

</div>
</div>
<?php } ?>
</div>
<!-- FOODZONED OFFERS -->

<!-- Homepage End -->

</div></div>
<?php include "inc/footer.php"; ?>
            
<div class="clearfix"></div>
</div>


<!-- Animated Counter Start -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script> 
<script src="/js/counter/jquery.counterup.min.js"></script> 
<script>
    jQuery(document).ready(function( $ ) {
        $('.counter').counterUp({
            delay: 10,
            time: 2000
        });
    });
</script>
<!-- Animated Counter End -->

</body>
</html>