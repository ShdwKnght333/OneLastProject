<?php
include "../../../conf/config.php";

//empty cart by distroying current session
if(isset($_GET["emptycart"]) && $_GET["emptycart"]==1)
{
	$return_url = base64_decode($_GET["return_url"]); //return url
	unset($_SESSION["products"]);
	header('Location:'.$return_url);
}

//add item in shopping cart
if(isset($_POST["type"]) && $_POST["type"]=='add')
{
	$product_code 	= filter_var($_POST["product_code"], FILTER_SANITIZE_STRING); //product code
	$product_qty 	= filter_var($_POST["product_qty"], FILTER_SANITIZE_NUMBER_INT); //product code
	$return_url 	= base64_decode($_POST["return_url"]); //return url
	
echo " " . $product_code . " " . $product_qty . " " . $return_url;

	//MySqli query - get details of item from db using product code
	$results = getSqlRow("SELECT * FROM products WHERE id='".$product_code."'");


if ($results) { //we have the product info 
	

	
if ( $results['proprice'] > 0 )
{
		//prepare array for the session variable
		$new_product = array(array('name'=>$results['name'], 'code'=>$results['id'], 'qty'=>$product_qty, 'price'=>$results['proprice']));
}
else
{
		//prepare array for the session variable
		$new_product = array(array('name'=>$results['name'], 'code'=>$results['id'], 'qty'=>$product_qty, 'price'=>$results['price']));
}

		
		if(isset($_SESSION["products"])) //if we have the session
		{
			$found = false; //set found item to false
			
			foreach ($_SESSION["products"] as $cart_itm) //loop through session array
			{
				if($cart_itm["code"] == $product_code){ //the item exist in array

$product[] = array('name'=>$cart_itm["name"], 'code'=>$cart_itm["code"], 'qty'=>$product_qty, 'price'=>$cart_itm["price"]);
					$found = true;
				}else{
//item doesn't exist in the list, just retrive old info and prepare array for session var

$product[] = array('name'=>$cart_itm["name"], 'code'=>$cart_itm["code"], 'qty'=>$cart_itm["qty"], 'price'=>$cart_itm["price"]);
				}
			}
			
			if($found == false) //we didn't find item in array
			{
				//add new user item in array
				$_SESSION["products"] = array_merge($product, $new_product);
			}else{
				//found user item in array list, and increased the quantity
				$_SESSION["products"] = $product;
			}
			
		}else{
			//create a new session var if does not exist
			$_SESSION["products"] = $new_product;
		}
		
	}
	
	//redirect back to original page
	header('Location:'.$return_url);
}

//remove item from shopping cart
if(isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["products"]))
{
	$product_code 	= $_GET["removep"]; //get the product code to remove
	$return_url 	= base64_decode($_GET["return_url"]); //get return url

	
	foreach ($_SESSION["products"] as $cart_itm) //loop through session array var
	{
		if($cart_itm["code"]!=$product_code){ //item does,t exist in the list
			$product[] = array('name'=>$cart_itm["name"], 'code'=>$cart_itm["code"], 'qty'=>$cart_itm["qty"], 'price'=>$cart_itm["price"]);
		}
		
		//create a new product list for cart
		$_SESSION["products"] = $product;
	}
	
	//redirect back to original page
	header('Location:'.$return_url);
}


//remove item from shopping cart
if(isset($_GET["checkout"]) && isset($_GET["return_url"]) && isset($_SESSION["products"]))
{

	$return_url 	= base64_decode($_GET["return_url"]); //get return url

	
	foreach ($_SESSION["products"] as $cart_itm) //loop through session array var
	{

	$rsp=getSqlRow("select * from products where id=".$cart_itm["code"]."");
	if ( $rsp['stock'] == "2" && $cart_itm["qty"] > $rsp['stock_qty'] )
	{ $cart_error = 1; header('Location:'.$return_url); die('Limited Stock Availability!');}

	}

	foreach ($_SESSION["products"] as $cart_itm) //loop through session array var
	{
	$rsp2=getSqlRow("select * from products where id=".$cart_itm["code"]."");
	if ( $rsp2['stock'] == "2" )
	{
	$sqty_total = "0";
	$sqty_total = $rsp2['stock_qty'] - $cart_itm["qty"];
	$update = mysql_query( "UPDATE products SET stock_qty=".$sqty_total." WHERE id=".$cart_itm["code"]." and resid=".$_SESSION['restaid']."" );
	}
	}
?>

<html>
<head>
<title></title>

<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

<style>

body { font-family: 'Roboto', sans-serif; }
a { text-decoration:none; }

.shopping-cart{
width: 90%;
background: #F0F0F0;
padding: 10px;	
border: 1px solid #DDD;
border-radius: 5px;
text-align:left;
}
.shopping-cart h2 {
	background: #E2E2E2;
	padding: 4px;
	font-size: 16px;
	margin: -10px -10px 5px;
	color: #707070;
}

.shopping-cart h3,.view-cart h3 {
	font-size: 14px;
	margin: 0px;
	padding: 0px;
}
.shopping-cart ol{
	padding: 1px 0px 0px 15px;
}
.shopping-cart .cart-itm, .view-cart .cart-itm{
	border-bottom: 1px solid #DDD;
	font-size: 13px;
	font-family: arial;
	margin-bottom: 5px;
	padding-bottom: 5px;
}
.shopping-cart .remove-itm, .view-cart .remove-itm{
	font-size: 16px;
	float: right;
	background: #D5D5D5;
	padding: 4px;
	line-height: 8px;
	border-radius: 3px;
}
.shopping-cart .remove-itm:hover, .view-cart .remove-itm:hover{
	background: #C4C4C4;
}
.shopping-cart .remove-itm a, .view-cart .remove-itm a{
	color: #888;
	text-shadow: 1px 1px 1px #ECECEC;
	text-decoration:none;
}

.check-out-txt{
	float:right;
}

</style>
</head>
<body>

<center>
<div class="shopping-cart">
<h1 align="center"> &nbsp;<?=getVal("rests","name",$_SESSION['restaid']); ?> <br/><small>(<?=date("d/m/Y h:i:s A");?>)</small></h1>
<?php


if(isset($_SESSION["products"]))
{
    $total = 0;
    echo '<ol>';
    foreach ($_SESSION["products"] as $cart_itm)
    {
        echo '<li class="cart-itm">';
        echo '<span></span>';
        echo '<h3>'.$cart_itm["name"].'</h3>';
        echo '<div class="p-qty">Qty : '.$cart_itm["qty"].'</div>';
        echo '<div class="p-price">Price :'.$currency.$cart_itm["price"].'</div>';
        echo '</li>';
        $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
        $total = ($total + $subtotal);
    }
    echo '</ol>';
    echo '<span class="check-out-txt"></span><br/><h1 class="my-total"> &nbsp;Total : '.setPrice($currency.$total).' &nbsp; </h1>';

}else{
    echo 'Your Cart is empty';
}
?>
</div>
<div style="text-align:center;font-size:11px;">
<br>
POWERED BY <a href="http://www.foodzoned.com" target="_blank">FOODZONED.COM</a> | DESIGNED BY <a href="http://www.hamgele.com" target="_blank">HAMGELE</a>
<br><br>
</div>
</center>

</body>
</html>

<?
unset($_SESSION["products"]);

}

?>