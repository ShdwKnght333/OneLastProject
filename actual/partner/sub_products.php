<div id="subheader">
<div id="container">
<div id="headermenu" class="tabmenu_sub">  
<ul>
<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"products.php")>0) echo"class='active'";?>><a href="products.php">Products</a></li>
<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"product.php")>0) echo"class='active'";?>><a href="product.php">New Product</a></li></li>

<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"menus-group.php")>0) echo"class='active'";?>><a href="menus-group.php">Cat. Group</a></li></li>

<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"menus.php")>0) echo"class='active'";?>><a href="menus.php">Categories</a></li></li>

<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"categories.php")>0) echo"class='active'";?>><a href="categories.php">Optional Groups</a></li>
<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"extra-item.php")>0) echo"class='active'";?>><a href="extra-item.php">New Group</a></li>
<li <? if(substr_count($_SERVER['SCRIPT_NAME'],"optionals.php")>0) echo"class='active'";?>><a href="optionals.php">Optionals</a></li>
</ul>
</div>
</div>
</div>