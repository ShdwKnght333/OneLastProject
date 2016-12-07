<?php

include( "config.php" );
$cmd = safe( $_REQUEST['cmd'] );
if ( $cmd == "res_login" )
{
    if ( !$_REQUEST['username'] )
    {
        echo "<script>alert('You did not write username!'); enable('sbt'); focus('username');</script>";
    }
    else if ( !$_REQUEST['password'] )
    {
        echo "<script>alert('You did not write password!'); enable('sbt'); focus('password');</script>";
    }
    else
    {
        $userDetails = getsqlrow( "SELECT * FROM rests WHERE username='".safe( $_REQUEST['username'] )."' AND  password='".safe( $_REQUEST['password'] )."'" );
        if ( !$userDetails['id'] )
        {
            echo "<script>alert('Username or Password error!'); enable('sbt'); focus('username');</script>";
        }
        else
        {
            $_SESSION['restarea'] = "Active";
            $_SESSION['restaid'] = $userDetails['id'];
            $_SESSION['restusern'] = $userDetails['username'];
            $_SESSION['restname'] = $userDetails['name'];
            echo "<script> go('./')</script>";
        }
    }
}
if ( $cmd == "sys_login" )
{
    if ( !$_REQUEST['username'] )
    {
        echo "<script>alert('You did not write username!'); enable('sbt'); focus('username');</script>";
    }
    else if ( !$_REQUEST['password'] )
    {
        echo "<script>alert('You did not write password!'); enable('sbt'); focus('password');</script>";
    }
    else if ( safe( $_REQUEST['username'] ) != $sys_username || safe( $_REQUEST['password'] ) != $sys_password )
    {
        echo "<script>alert('Username or Password error!'); enable('sbt'); focus('username');</script>";
    }
    else
    {
        $_SESSION['sysarea'] = "Active";
        echo "<script> go('./')</script>";
    }
}
if ( $cmd == "set_rest_status" )
{
    $val = safe( $_REQUEST['val'] );
    $update = mysql_query( "UPDATE rests SET status=".$val." WHERE id=".$_SESSION['restaid']."" );
    $status = $val == 0 ? "Closed" : "Opened";
    echo "<script>alert('Service Provider ".$status."');</script>";
}
if ( $cmd == "save_opening_hours" )
{
    @mysql_query( @"delete from site_timing where resid=".@$_SESSION['restaid']."" );
    $i = 0;
    while ( $i < 7 )
    {
        unset( $data );
        $data['resid'] = $_SESSION['restaid'];
        $data['dateday'] = $i;
        $data['open1'] = $_REQUEST['open1_'][$i];
        $data['close1'] = $_REQUEST['close1_'][$i];
        $data['open2'] = $_REQUEST['open2_'][$i];
        $data['close2'] = $_REQUEST['close2_'][$i];
        $data['open3'] = $_REQUEST['open3_'][$i];
        $data['close3'] = $_REQUEST['close3_'][$i];
        $data['custom_time'] = $_REQUEST['custom_time_'][$i];

        $sql = insert_sql( "site_timing", $data, "dateday=".$i." and resid=".$_SESSION['restaid']."" );
        ++$i;
    }
    echo "<script> alert('Timing updated');enable('sbt');</script>";
}

if ( $cmd == "add_payment_type" )
{
    if ( !$_REQUEST['paymenttype'] )
    {
        echo "<script>alert('You did not write payment type!'); enable('sbt'); focus('paymenttype');</script>";
        exit( );
    }
    $sql['paymenttype'] = $_REQUEST['paymenttype'];
    $newId = insert_sql( "paymenttypes", $sql );
    echo "<script>alert('Record saved!'); go('".$_REQUEST['back']."')</script>";
}
if ( $cmd == "del_payment_type" )
{
    $id = safe( $_REQUEST['id'] );
    $sql = mysql_query( "delete from paymenttypes WHERE  id=".$id."" );
    echo "<script>hide('tr_".$id."');alert('Record deleted!');</script>";
}
if ( $cmd == "add_order_type" )
{
    if ( !$_REQUEST['order_type'] )
    {
        echo "<script>alert('You did not write order type!'); enable('sbt'); focus('order_type');</script>";
        exit( );
    }
    $sql['order_type'] = $_REQUEST['order_type'];
    $sql['need_address'] = $_REQUEST['need_address'];
    $newId = insert_sql( "order_types", $sql );
    echo "<script>alert('Record saved!'); go('".$_REQUEST['back']."')</script>";
}
if ( $cmd == "del_order_type" )
{
    $id = safe( $_REQUEST['id'] );
    $sql = mysql_query( "delete from order_types WHERE  id=".$id."" );
    echo "<script>hide('tr_".$id."');alert('Record deleted!');</script>";
}
if ( $cmd == "add_order_status" )
{
    if ( !$_REQUEST['status'] )
    {
        echo "<script>alert('You did not write order status!'); enable('sbt'); focus('status');</script>";
        exit( );
    }
    $sql['status'] = $_REQUEST['status'];
    if ( !$_REQUEST['id'] )
    {
        $newId = insert_sql( "order_statuses", $sql );
    }
    else
    {
        update_sql( "order_statuses", $sql, "id=".safe( $_REQUEST['id'] )."" );
    }
    echo "<script>alert('Record saved!'); go('order_statuses.php')</script>";
}
if ( $cmd == "del_order_status" )
{
    $id = safe( $_REQUEST['id'] );
    $sql = mysql_query( "delete from order_statuses WHERE  id=".$id."" );
    echo "<script>hide('tr_".$id."');alert('Record deleted!');</script>";
}
if ( $cmd == "save_area" )
{
    if ( !$_REQUEST['region'] )
    {
        echo "<script>alert('Select delivery city!'); enable('sbt'); focus('region');</script>";
        exit( );
    }
    else if ( !$_REQUEST['city'] )
    {
        echo "<script>alert('You did not write city!'); enable('sbt'); focus('city');</script>";
        exit( );
    }
    else if ( !$_REQUEST['zip'] || !is_numeric($_REQUEST['zip']) )
    {
        echo "<script>alert('Incorrect Pincode!'); enable('sbt'); focus('zip');</script>";
        exit( );
    }
    $sql['region'] = $_REQUEST['region'];
    $sql['city'] = strtoupper($_REQUEST['city']);
    $sql['zip'] = $_REQUEST['zip'];
    if ( !$_REQUEST['id'] )
    {
        $newId = insert_sql( "delivery_areas", $sql );
    }
    else
    {
        update_sql( "delivery_areas", $sql, "id=".safe( $_REQUEST['id'] )."" );
    }
    echo "<script>alert('Record saved!'); go('delivery_areas.php')</script>";
}
if ( $cmd == "del_area" )
{
    $id = safe( $_REQUEST['id'] );
    $sql = mysql_query( "delete from delivery_areas WHERE  id=".$id."" );
    echo "<script>hide('tr_".$id."');alert('Record deleted!');</script>";
}
if ( $cmd == "update_select_city" )
{
    $select_options = "";
    $select_options .= "<option value=''>--- Select ---</option>";
    if ( $_REQUEST['region'] )
    {
        $getRss = mysql_query( "SELECT id,city FROM delivery_areas where region='".safe( $_REQUEST['region'] )."' group by city" );
        while ( $rss = mysql_fetch_array( $getRss ) )
        {
            $select_options .= "<option value='".$rss['city']."'>".$rss['city']."</option>";
        }
        echo "<script>$('#city').html('".jsescape( $select_options )."'); enable('city');</script>";
    }
}
if ( $cmd == "update_select_zip" )
{
    $select_options = "";
    $select_options .= "<option value=''>--- Select ---</option>";
    if ( $_REQUEST['city'] )
    {
        $getRss = mysql_query( "SELECT id,zip FROM delivery_areas where region='".safe( $_REQUEST['region'] )."' and city='".safe( $_REQUEST['city'] )."' group by zip" );
        while ( $rss = mysql_fetch_array( $getRss ) )
        {
            $select_options .= "<option value='".$rss['zip']."'>".$rss['zip']."</option>";
        }
        echo "<script>$('#zip').html('".jsescape( $select_options )."'); enable('zip');</script>";
    }
}
if ( $cmd == "set_rest_area" )
{
    $id = safe( $_REQUEST['id'] );
    $sql['rest_id'] = $_SESSION['restaid'];
    $sql['da_id'] = $_REQUEST['id'];

    if ( safe( $_REQUEST['val'] ) )
    {
        insert_sql( "rest_delivery_area", $sql );
    }
    else
    {
        $sql = mysql_query( "delete from rest_delivery_area WHERE  rest_id=".$_SESSION['restaid']." and da_id=".safe( $sql['da_id'] )."" );
    }
    updatekeywords( $_SESSION['restaid'] );
}


if ( $cmd == "save_rest" )
{
    if ( !$_REQUEST['id'] )
    {
        $is_username = getsqlnumber( "SELECT id FROM rests WHERE username='".safe( $_REQUEST['username'] )."'" );
    }
    else if ( $_REQUEST['olduser'] && $_REQUEST['olduser'] != $_REQUEST['username'] )
    {
        $is_username = getsqlnumber( "SELECT id FROM rests WHERE username='".safe( $_REQUEST['username'] )."'" );
    }
    else
    {
        $is_username = 0;
    }
    if ( !$_REQUEST['zip'] )
    {
        echo "<script>alert('Please select Region, Area and Zip!'); enable('sbt'); focus('zip');</script>";
    }
    else if ( !$_REQUEST['username'] )
    {
        echo "<script>alert('You did not write a username!'); enable('sbt'); focus('username');</script>";
    }
    else if ( 0 < $is_username )
    {
        echo "<script>alert('This username exist!'); enable('sbt'); focus('username');</script>";
    }
    else if ( !$_REQUEST['password'] )
    {
        echo "<script>alert('You did not write a password!'); enable('sbt'); focus('password');</script>";
    }
    else if ( !$_REQUEST['name'] )
    {
        echo "<script>alert('You did not write a name!'); enable('sbt'); focus('name');</script>";
    }
    else if ( !$_REQUEST['site_service'] )
    {
        echo "<script>alert('Select service type!'); enable('sbt'); focus('site_service');</script>";
    }
    else if ( !$_REQUEST['delivery_type'] )
    {
        echo "<script>alert('Select Delivery Provider!'); enable('sbt'); focus('delivery_type');</script>";
    }
    else
    {
        $rs_da = getsqlrow( "select * from delivery_areas where region='".safe( $_REQUEST['region'] )."' and city='".safe( $_REQUEST['city'] )."' and zip='".safe( $_REQUEST['zip'] )."'" );
        $_REQUEST['rest_tax'] = str_replace( ",", ".", $_REQUEST['rest_tax'] );
        $data['da_id'] = $rs_da['id'];
        $data['username'] = $_REQUEST['username'];
        $data['password'] = $_REQUEST['password'];
        $data['name'] = $_REQUEST['name'];
        $data['phone'] = $_REQUEST['phone'];
        $data['fax'] = $_REQUEST['fax'];
        $data['gsm'] = $_REQUEST['gsm'];
        $data['gsm2'] = $_REQUEST['gsm2'];
        $data['email'] = $_REQUEST['email'];
        $data['servicetime'] = $_REQUEST['servicetime'];
        $data['servicefee'] = $_REQUEST['servicefee'];
        $data['discount'] = $_REQUEST['discount'];
        $data['dis_min'] = $_REQUEST['dis_min'];
        $data['fz_comm'] = $_REQUEST['fz_comm'];
        $data['priority'] = $_REQUEST['priority'];
        $data['minorder'] = $_REQUEST['minorder'];
        $data['type'] = $_REQUEST['type'];
        $data['site_service'] = $_REQUEST['site_service'];
        $data['delivery_type'] = $_REQUEST['delivery_type'];
        $data['monthly_fee'] = $_REQUEST['monthly_fee'];
        $data['rest_tax'] = $_REQUEST['rest_tax'];
        $data['address'] = $_REQUEST['address'];
        $data['zip'] = $rs_da['zip'];
        $data['description'] = strip_tags( $_REQUEST['description'] );
        $data['updated'] = date( "Y-m-d H:i:s" );
        $data['flash'] = $_REQUEST['flash'];

        $data['note'] = $_REQUEST['note'];
        /* $data['note'] = strip_tags( $_REQUEST['note'] ); */

        $data['rcity'] = $rs_da['region'];
        $data['keywords'] = $data['name'].",".$rs_da['zip'].",".$rs_da['city'].",".$rs_da['region'];
        $data['keywords'] = strtolower( $data['keywords'] );
        $data['order_types'] = serialize( $_REQUEST['order_types'] );
        $data['status'] = $_REQUEST['status'];
        if ( strtolower( ENABLE_PAYPAL_FOR_REST ) == "yes" )
        {
            $data['paypal_email'] = $_REQUEST['paypal_email'];
        }
        if ( strtolower( ENABLE_AUTHORIZE_FOR_REST ) == "yes" )
        {
            $data['authorize_login_id'] = $_REQUEST['authorize_login_id'];
            $data['authorize_key'] = $_REQUEST['authorize_key'];
        }
        if ( strtolower( ENABLE_GOOGLE_CHECKOUT_FOR_REST ) == "yes" )
        {
            $data['google_merchant'] = $_REQUEST['google_merchant'];
            $data['google_key'] = $_REQUEST['google_key'];
        }
        if ( !$_REQUEST['id'] )
        {
            $newId = insert_sql( "rests", $data );
            $_REQUEST['id'] = $newId;
            $i = 0;
            for ($i=0; $i<7; $i++)
            {
                unset( $data );
                $data['resid'] = $newId;
                $data['dateday'] = $i;
                $data['time_open'] = "10:00";
                $data['time_close'] = "21:00";
                $data['break1'] = "00:00";
                $data['break2'] = "00:00";
                $newId = insert_sql( "times", $data );
            }
            echo "<script>alert('Record added!'); go('service-providers.php')</script>";
        }
        else
        {
            $sql = update_sql( "rests", $data, "id=".$_REQUEST['id']."" );
            if ( $_REQUEST['from'] == "partner" )
            {
                echo "<script>alert('Your details updated!');enable('sbt');</script>";
            }
            else
            {
                echo "<script>alert('Record updated!'); go('service-providers.php');</script>";
            }
        }
        updatekeywords( $_REQUEST['id'] );
    }
}
if ( $cmd == "del_rest" )
{
    $id = safe( $_REQUEST['id'] );
    $sql = mysql_query( "update rests set status=2 WHERE  id=".$id."" );
    echo "<script>hide('tr_".$id."');alert('Record deleted!');go('".$_REQUEST['back']."')</script>";
}
if ( $cmd == "set_order_status" )
{
    $id = safe( $_REQUEST['id'] );
    $val = safe( $_REQUEST['val'] );
    if ( $val == 9 )
    {
        @mysql_query( @"delete from orders WHERE id=".@$id."" );
        @mysql_query( @"delete from order_details WHERE orderid=".@$id."" );
    }
    else
    {
        $update = mysql_query( "UPDATE orders SET status=".$val." WHERE id=".$id."" );
    }
    echo "<script>go('".$_SESSION["actual_link"]."')</script>";
}
if ( $cmd == "save_payment_types" )
{
    $checks = $_REQUEST['ptype'];
    $data['paymenttypes'] = implode( "|", $checks );
    $sql = update_sql( "rests", $data, "id=".$_SESSION['restaid']."" );
    echo "<script>alert('Payment types updated!');  enable('sbt');</script>";
}

if ( $cmd == "save_extra_group" )
{
    if ( !$_REQUEST['name'] )
    {
        echo "<script>alert('You did not write category name!'); enable('sbt'); focus('name');</script>";
    }
    else
    {

        $data['resid'] = $_SESSION['restaid'];
        $data['name'] = $_REQUEST['name'];
        $data['max'] = $_REQUEST['max'];
        $checks = $_REQUEST['egroup'];
        $data['items'] = implode( ",", $checks );

        if ( !$_REQUEST['id'] )
        {
            $newId = insert_sql( "extra_group", $data );
            echo "<script>alert('New category added!'); go('categories.php');</script>";
        }
        else
        {
            $sql = update_sql( "extra_group", $data, "id=".safe( $_REQUEST['id'] )."" );
            echo "<script>alert('Category updated!'); go('categories.php');</script>";
        }
    }
}

if ( $cmd == "set_menu_status" )
{
    $id = safe( $_REQUEST['id'] );
    $val = safe( $_REQUEST['val'] );
    $update = mysql_query( "UPDATE menus SET status=".$val." WHERE resid=".$_SESSION['restaid']." and id=".$id."" );
    echo "<script>alert('Menu status updated!');</script>";
}

if ( $cmd == "set_menu_group_status" )
{
    $id = safe( $_REQUEST['id'] );
    $val = safe( $_REQUEST['val'] );
    $update = mysql_query( "UPDATE menus_group SET status=".$val." WHERE resid=".$_SESSION['restaid']." and id=".$id."" );
    echo "<script>alert('Group status updated!');</script>";
}

if ( $cmd == "save_menu" )
{
    if ( !$_REQUEST['menu'] )
    {
        echo "<script>alert('You did not write menu/category name!'); enable('sbt'); focus('menu');</script>";
    }
    else
    {
        $data['resid'] = $_SESSION['restaid'];
        $data['menu'] = $_REQUEST['menu'];
        $data['gpid'] = $_REQUEST['gpid'];
        $data['priority'] = $_REQUEST['priority'];
        $data['flash'] = $_REQUEST['flash'];
        $data['description'] = strip_tags( $_REQUEST['description'] );
        if ( !$_REQUEST['id'] )
        {
            $newId = insert_sql( "menus", $data );
            echo "<script>alert('Record added!');go('menus.php');</script>";
        }
        else
        {
            $sql = update_sql( "menus", $data, "id=".safe( $_REQUEST['id'] )."" );
            echo "<script>alert('Record updated!');go('menus.php');</script>";
        }
    }
}


if ( $cmd == "save_menu_group" )
{
    if ( !$_REQUEST['gp_name'] )
    {
        echo "<script>alert('You did not write Group Name!'); enable('sbt'); focus('gp_name');</script>";
    }
    else
    {
        $data['resid'] = $_SESSION['restaid'];
        $data['gp_name'] = $_REQUEST['gp_name'];
        $data['priority'] = $_REQUEST['priority'];
        $data['flash'] = $_REQUEST['flash'];
        $data['description'] = strip_tags( $_REQUEST['description'] );
        if ( !$_REQUEST['id'] )
        {
            $newId = insert_sql( "menus_group", $data );
            echo "<script>alert('Record added!');go('menus-group.php');</script>";
        }
        else
        {
            $sql = update_sql( "menus_group", $data, "id=".safe( $_REQUEST['id'] )."" );
            echo "<script>alert('Record updated!');go('menus-group.php');</script>";
        }
    }
}

if ( $cmd == "del_menu" )
{
    $id = safe( $_REQUEST['id'] );
    $sql = mysql_query( "delete from menus WHERE  resid=".$_SESSION['restaid']." and id=".$id."" );
    echo "<script>hide('tr_".$id."');alert('Record deleted!');</script>";
}

if ( $cmd == "del_menu_group" )
{
    $id = safe( $_REQUEST['id'] );
    $sql = mysql_query( "delete from menus_group WHERE resid=".$_SESSION['restaid']." and id=".$id."" );
    echo "<script>hide('tr_".$id."');alert('Record deleted!');</script>";
}


if ( $cmd == "save_product" )
{
    if ( !$_REQUEST['name'] )
    {
        echo "<script>alert('You did not write product name!'); enable('sbt'); focus('name');</script>";
    }
    else if ( !$_REQUEST['menuid'] )
    {
        echo "<script>alert('You did not select menu!'); enable('sbt'); focus('menuid');</script>";
    }
    else if ( !$_REQUEST['price'] )
    {
        echo "<script>alert('You did not write product price!'); enable('sbt'); focus('price');</script>";
    }
    else if ( $_REQUEST['stock'] < 1 )
    {
        echo "<script>alert('Select Stock Management Required or Not!'); enable('sbt'); focus('stock');</script>";
    }
    else
    {
        $_REQUEST['price'] = str_replace( ",", ".", $_REQUEST['price'] );
        if ( $_REQUEST['proprice'] != "" && 0 < $_REQUEST['proprice'] )
        {
            $_REQUEST['proprice'] = str_replace( ",", ".", $_REQUEST['proprice'] );
        }
        $data['resid'] = $_SESSION['restaid'];
        $data['type'] = $_REQUEST['type'];
        $data['menuid'] = $_REQUEST['menuid'];
        $data['name'] = $_REQUEST['name'];
        $data['barcode'] = $_REQUEST['barcode'];
        $data['details'] = $_REQUEST['details'];
        $data['price'] = $_REQUEST['price'];
        $data['proprice'] = $_REQUEST['proprice'];
        $data['stock'] = $_REQUEST['stock'];

        $data['status'] = $_REQUEST['status'];
        $data['updated'] = date( "Y-m-d H:i:s" );

        if ( !$_REQUEST['id'] ) { $data['stock_qty'] = $_REQUEST['stock_qty']; }

        if ( !$_REQUEST['pictureold'] && $_REQUEST['picture'] )
        {
            $data['picture'] = $_REQUEST['picture'];
        }
        if ( $_REQUEST['pictureold'] && $_REQUEST['picture'] )
        {
            if ( file_exists( "../upload/images/".$_REQUEST['pictureold'] ) )
            {
                unlink( "../upload/images/".$_REQUEST['pictureold'] );
            }
            $data['picture'] = $_REQUEST['picture'];
        }
        if ( $data['picture'] && file_exists( "../upload/tmp/".$data['picture'] ) )
        {
            rename( "../upload/tmp/".$data['picture'], "../upload/images/".$data['picture'] );
        }
        if ( !$_REQUEST['id'] )
        {
            $Id = insert_sql( "products", $data );
            echo "<script>alert('New product added!');go('products.php');</script>";
        }
        else
        {
            $sql = update_sql( "products", $data, "id=".$_REQUEST['id']."" );
            $Id = $_REQUEST['id'];
            echo "<script>alert('Product record updated!');go('products.php');</script>";
        }
        @mysql_query( @"delete from optional_group where proid=".@$Id."" );
        $optionals = $_REQUEST['opt'];
        if ( $optionals )
        {
            foreach ( $optionals as $opt )
            {
                @mysql_query( @"INSERT INTO optional_group (proid,egid) VALUES (".@$Id.", ".@$opt.")" );
            }
        }
    }
}

if ( $cmd == "update_product_stock" )
{

    $id = safe( $_REQUEST['id'] );
    $rsto=getSqlRow("SELECT stock_qty FROM products WHERE id=".$id."");

if ( !is_numeric($_REQUEST['st_data']) && is_float($_REQUEST['st_data']) )
{ 
echo "<script>alert('Invalid Input!');</script>";
}
else if ( $_REQUEST['uptype'] == 1 )
{

$st_total = $rsto['stock_qty'] + $_REQUEST['st_data'];

    if( $st_total >= "0" )
    {
    $update = mysql_query( "UPDATE products SET stock_qty=".$st_total." WHERE resid=".$_SESSION['restaid']." and id=".$id."" );
    echo "<script>alert('Stock updated!'); go('products.php');</script>";
    }
    else { echo "<script> alert('Entry Rejected, Please try again!'); go('products.php');</script>"; }
}
else if ( $_REQUEST['uptype'] == 2 )
{

$st_total = $rsto['stock_qty'] - $_REQUEST['st_data'];

    if( $st_total >= "0" )
    {
    $update = mysql_query( "UPDATE products SET stock_qty=".$st_total." WHERE resid=".$_SESSION['restaid']." and id=".$id."" );
    echo "<script>alert('Stock updated!'); go('products.php');</script>";
    }
    else { echo "<script> alert('Entry Rejected, Please try again!'); go('products.php');</script>"; }
}

}

if ( $cmd == "set_product_status" )
{
    $id = safe( $_REQUEST['id'] );
    $val = safe( $_REQUEST['val'] );
    @mysql_query( @"UPDATE products SET status=".@$val." WHERE resid=".@$_SESSION['restaid']." and id=".@$id."" );
    echo "<script>alert('Product status updated!');</script>";
}
if ( $cmd == "del_product" )
{
    $id = safe( $_REQUEST['id'] );
    @mysql_query( @"delete from products WHERE  resid=".@$_SESSION['restaid']." and id=".@$id."" );
    echo "<script>hide('tr_".$id."');alert('Product deleted!');</script>";
}
if ( $cmd == "del_category" )
{
    $id = safe( $_REQUEST['id'] );
    @mysql_query( @"delete from extra_group WHERE  resid=".@$_SESSION['restaid']." and id=".@$id."" );
    echo "<script>hide('tr_".$id."');alert('Categoty deleted!');</script>";
}
if ( $_REQUEST['cmd'] == "save_optional" )
{
    if ( !$_REQUEST['optional'] )
    {
        echo "<script>alert('You did not write optional name!'); enable('sbt'); focus('optional');</script>";
    }
    else
    {
        $data['resid'] = $_SESSION['restaid'];
        $data['optional'] = $_REQUEST['optional'];
        $data['price'] = $_REQUEST['price'];
        if ( !$_REQUEST['id'] )
        {
            $newId = insert_sql( "optionals", $data );
        }
        else
        {
            $sql = update_sql( "optionals", $data, "id=".$_REQUEST['id']."" );
        }
        echo "<script>alert('Item saved!');go('optionals.php');</script>";
    }
}
if ( $cmd == "del_optional" )
{
    $id = safe( $_REQUEST['id'] );
    @mysql_query( @"delete from optionals WHERE resid=".@$_SESSION['restaid']." and id=".@$id."" );
    @mysql_query( @"delete from optional_product WHERE optid=".@$id."" );
    echo "<script>hide('tr_".$id."');alert('Item deleted!');</script>";
}
if ( $_REQUEST['cmd'] == "save_promotion" )
{
    if ( !$_REQUEST['promotion'] )
    {
        echo "<script>alert('You did not write promotion!'); enable('sbt'); focus('promotion');</script>";
    }
    else
    {
        $data['resid'] = $_SESSION['restaid'];
        $data['promotion'] = $_REQUEST['promotion'];
        if ( !$_REQUEST['id'] )
        {
            $newId = insert_sql( "promotions", $data );
        }
        else
        {
            $sql = update_sql( "promotions", $data, "id=".$_REQUEST['id']."" );
        }
        echo "<script>alert('Item saved!');go('promotions.php');</script>";
    }
}
if ( $cmd == "del_promotion" )
{
    $id = safe( $_REQUEST['id'] );
    @mysql_query( @"delete from promotions WHERE resid=".@$_SESSION['restaid']." and id=".@$id."" );
    echo "<script>hide('tr_".$id."');alert('Item deleted!');</script>";
}
if ( $cmd == "save_options" )
{
    $getRs = mysql_query( "SELECT * FROM options order by id asc" );
    while ( $rs = mysql_fetch_array( $getRs ) )
    {
        @mysql_query( @"update options set option_value='".@trim( @safe( @$_REQUEST["opt_".@$rs['id']] ) )."' where id=".@$rs['id']."" );
    }
    echo "<script>enable('sbt'); alert('Options saved!');</script>";
}
if ( $cmd == "save_langs" )
{
    $langs_arr = array( );
    $getRs = mysql_query( "SHOW COLUMNS FROM langs" );
    while ( $rs = mysql_fetch_array( $getRs ) )
    {
        if ( $rs['Field'] != "id" && $rs['Field'] != "name" )
        {
            array_push( $langs_arr, $rs['Field'] );
        }
    }
    $getRs = mysql_query( "SELECT * FROM langs order by id asc" );
    while ( $rs = mysql_fetch_array( $getRs ) )
    {
        foreach ( $langs_arr as $lang_name )
        {
            @mysql_query( @"update langs set {$lang_name}='".@trim( @safe( @$_REQUEST["opt_".@$lang_name."_".@$rs['id']] ) )."' where id=".@$rs['id']."" );
        }
    }
    echo "<script>enable('sbt'); alert('Language texts saved!');</script>";
}

if ( $cmd == "add_lang_name" )
{
    if ( !$_REQUEST['lang'] )
    {
        echo "<script>alert('You did not write language name!'); enable('sbt'); focus('lang');</script>";
        exit( );
    }
    else
    {
        mysql_query( "ALTER TABLE langs ADD ".safe( $_REQUEST['lang'] )." TEXT NOT NULL" );
        mysql_query( "update langs set ".safe( $_REQUEST['lang'] )."=en" );
    }
    echo "<script>alert('Record saved!'); go('langs.php')</script>";
}
if ( $cmd == "del_lang" )
{
    mysql_query( "ALTER TABLE langs DROP  ".safe( $_REQUEST['lang'] )."" );
    echo "<script> go('langs.php')</script>";
}
if ( $cmd == "send_notification" )
{
    $rs = getsqlrow( "select id from orders where id='".$_REQUEST['orderid']."'" );
    if ( $_REQUEST['orderid'] == $rs['id'] )
    {
    $orderId = $_REQUEST['orderid'];
    @include( DIR_PATH."conf/notifications.php" );
    echo "<script> alert('Notification Sent!'); go('./'); </script>";
    }
    else
    {
        echo "<script> alert('Wrong order ID!'); enable('sbt'); </script>";
    }
}


if ( $cmd == "save_offer" )
{

    if ( !$_REQUEST['resid'] )
    {
        echo "<script>alert('Enter Restaurant ID!'); enable('sbt'); focus('resid');</script>";
    }
	else if ( !$_REQUEST['name'] )
    {
        echo "<script>alert('Enter offer title!'); enable('sbt'); focus('name');</script>";
    }
		else if ( !$_REQUEST['details'] )
    {
        echo "<script>alert('Enter offer details!'); enable('sbt'); focus('details');</script>";
    }
    else
    {

        $data['resid'] = $_REQUEST['resid'];
        $data['priority'] = $_REQUEST['priority'];
        $data['name'] = $_REQUEST['name'];
        $data['details'] = $_REQUEST['details'];
        $data['status'] = $_REQUEST['status'];
		
        if ( !$_REQUEST['id'] )
        {
            $newId = insert_sql( "offers", $data );
            $_REQUEST['id'] = $newId;

            echo "<script>alert('Record added!'); go('fzoffers.php')</script>";
        }
        else
        {
            $sql = update_sql( "offers", $data, "id=".$_REQUEST['id']."" );

            echo "<script>alert('Record added!'); go('fzoffers.php')</script>";

        }
    }
}
if ( $cmd == "del_offer" )
{
    $id = safe( $_REQUEST['id'] );
    $sql = mysql_query( "DELETE FROM offers WHERE id=".$id."" );
    echo "<script>hide('tr_".$id."');alert('Record deleted!');go('".$_REQUEST['back']."')</script>";
}

if ( $cmd == "set_dfees" )
{
    $id = safe( $_REQUEST['id'] );
    $sql['rest_id'] = $_SESSION['restaid'];
    $sql['da_id'] = $_REQUEST['id'];
    $sql['dfees'] = $_REQUEST['amt'];

    $update = mysql_query( "UPDATE rest_delivery_area SET dfees='".$_REQUEST['amt']."' WHERE rest_id='".$_SESSION['restaid']."' and da_id='".$_REQUEST['id']."'" );

}

if ( $cmd == "set_min" )
{
    $id = safe( $_REQUEST['id'] );
    $sql['rest_id'] = $_SESSION['restaid'];
    $sql['da_id'] = $_REQUEST['id'];
    $sql['min'] = $_REQUEST['amt2'];

    $update = mysql_query( "UPDATE rest_delivery_area SET min='".$_REQUEST['amt2']."' WHERE rest_id='".$_SESSION['restaid']."' and da_id='".$_REQUEST['id']."'" );

}


exit( );

?>