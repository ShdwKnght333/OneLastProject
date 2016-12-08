<div id="subheader">
<div id="container">
<div id="headermenu" class="tabmenu_sub">  
<ul>
<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"edit.php")>0) echo"class='active'";?>><a href="edit.php">Service Information</a></li>
<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"logo.php")>0) echo"class='active'";?>><a href="logo.php">Seller Logo</a></li>
<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"hours.php")>0) echo"class='active'";?>><a href="hours.php">Service Timing</a></li>
<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"payment_types.php")>0) echo"class='active'";?>><a href="payment_types.php">Payment Types</a></li>
<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"delivery_areas.php")>0) echo"class='active'";?>><a href="delivery_areas.php">Delivery Areas</a></li>
</ul>
</div>
</div>
</div>