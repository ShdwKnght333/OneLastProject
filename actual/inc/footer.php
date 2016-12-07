<div class="clear"></div>
<br/><br/>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- FZ Responsive 01 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-4183537949812518"
     data-ad-slot="2752620784"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br/>

</div>
<div class="clear"></div>	
		</div>
		</div>
		<div id="result"></div>

		<div class="footer" id="footer">
		<div class="wrap">
			<div class="footer-grids">

			<div class="footer-grid address">
			<h3>FOODZONED</h3>
			<ul>
			<li><a href="/aboutus.php">About Us</a></li>
			<li><a href="/blog.php">Fz Blog</a></li>
			<li><a href="/team.php">Meet The Team</a></li>
			<li><a href="/feedback.php">Send Feedback</a></li>
			<li><a href="/privacy.php">Privacy Policy</a></li>
			<li><a href="/terms.php">Terms & Conditions</a></li>
			</ul>
			<div class="clear"></div>
			</div>
			
			<div class="footer-grid Newsletter">
			<h3>MORE STUFF</h3>
			<ul>
			<li><a href="/member.php">My Account</a></li>
			<li><a href="/how-it-works.php">How it Works</a></li>
			<li><a href="/bulk-orders.php">Bulk Orders</a></li>
			<li><a href="/refer-a-friend.php">Refer a Friend</a></li>
			<li><a href="/careers.php">Careers</a></li>
			<li><a href="/faq.php">Cancellation & Returns</a></li>
			</ul>
			<div class="clear"></div>
			</div>
			
			<div class="footer-grid Newsletter">
			<h3>SERVICES</h3>
			<ul>
			<li><a href="/suggest-service.php">Suggest a Service</a></li>
			<li><a href="/join-network.php">Join our Network</a></li>
			<li><a href="/partner/" target="_blank">Service Provider Login</a></li>
			<li><a href="/press-releases.php">Press Releases</a></li>
			<li><a href="/contact.php">Business Enquiries</a></li>
			<li><a href="/advertise.php">Advertise on Foodzoned</a></li>
			</ul>
			<div class="clear"></div>
			</div>

			<div class="footer-grid f1 Newsletter">
			<h3>CONNECT WITH US</h3>

<ul class="social-icons icon-circle list-unstyled list-inline">
<li><a href="http://facebook.com/Foodzoned" target="_blank"><i class="fa fa-facebook"></i></a></li> 
<li><a href="http://twitter.com/foodzoned" target="_blank"><i class="fa fa-twitter"></i></a></li>   
<li><a href="http://plus.google.com/102345729917238565603/" target="_blank"><i class="fa fa-google-plus"></i></a></li>
<li><a href="http://youtube.com/foodzoned" target="_blank"><i class="fa fa-youtube"></i></a></li>
</ul>

			<ul>
			<li><a href="/contact.php">Need Help? Contacts Us</a></li>
			<li>Whatsapp 9035515321 <small>(10AM-11PM)</small></li>
			</ul>

<div style="margin-top:10px;width:300px;height:34px;background:url('/theme/images/payment.png');"></div>

			<div class="clear"></div>
			</div>

			</div>
		</div><div class="clear"> </div>
        </div>
		
<div class="subfooter"><p id="copy-right">

<?=$copyright?>
</p><br/><br/></div>


<div id="feedback">
  <a href="/feedback.php">Feedback</a>
</div>


<!--Start of Set Location -->

<?
if ( !($_SESSION['mycity'] || $_SESSION['myarea']) )
{
?>

<script>
$(document).ready(function() {
$(".overlay").fadeToggle("fast");
});
</script>

<script type="text/javascript">
$(document).ready(function() {
	$("#sub_cat2").prop("disabled", true);

	$("#parent_cat2").change(function() {
	$("#sub_cat2").prop("disabled", true);
		$.get('/inc/subcat.php?parent_cat=' + $(this).val(), function(data) {
			$("#sub_cat2").html(data);
			$('#loader').slideUp(200, function() {
				$(this).remove();
			}); $("#sub_cat2").prop("disabled", false); }); }); });
</script>

<div class="overlay" style="display: none;">
	<div class="login-wrapper">
		<div class="login-content" style="height:185px;">
			<h4>Set your Location</h4>
<?php 
$query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'");
?>

<form id="myloc" name="myloc" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="set_my_loc" />
						
<select type="text" name="city" id="parent_cat2" style="width:250px;" class="input-text popup_select"> 
        <option value="" selected>Select City</option>
        <?php while($row = mysql_fetch_array($query_parent)): ?>
        <option value="<?=$row['region'];?>"><?=$row['region'];?></option>
        <?php endwhile; ?>
</select><br/>

<select type="text" name="area" id="sub_cat2" style="width:250px;" class="input-text popup_select"> 
<option value="" selected> &nbsp; </option>
</select><br/>

<center>
<input type="submit" value="SAVE LOCATION" class="vmenu" style="width:250px;margin-bottom:10px;" name="sbt_loc" id="sbt_loc" onclick='this.disabled=true; this.style.display="none"; loading_bar("loc_loading",1); post("myloc"); return false;'/><span id="loc_loading"></span>
</form>
</center>

		</div>
	</div>
</div>

<!-- End Location -->

<? } ?>

<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?2KSjKrnCeu1StpsFYvnqZQS80Ts0kpIB';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-53449409-1', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');
</script>


