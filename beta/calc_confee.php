<?php 
include "conf/config.php";
// FZconvenience Fee Calculation 
$con_fee=0;
$con_percent=0;

if (isset($_REQUEST['cmd']) && $_REQUEST['cmd']=="set_PaymentType" && isset($_SESSION['order_id'])) {
		
		$id = safe($_REQUEST['id']);
		$name = safe($_REQUEST['name']);
		$value = safe($_REQUEST['val']);
		
		$order_id = $_SESSION['order_id'];
		$order_total = getsqlrow("SELECT order_total FROM orders WHERE id='".$order_id."' AND userid='".$_SESSION['memberid']."'");
	
		if($id=='payU' && $value == $_SESSION['PayUmoney_token'] && $name =='PaymentType' ){
			$con_percent=5; // you can change the con fee here
			$con_fee  = number_format(($order_total['order_total'])*$con_percent/100,2,".","");
			$amount_payable = $order_total['order_total']  + $con_fee ;
			$amount_payable = number_format($amount_payable,2,".","");
			$fzpaid=0;
			echo " ₹ ".$amount_payable;
			 @mysql_query("UPDATE orders SET con_fee='".$con_fee."', paymenttype='ONLINE PAYMENT' , fzwallet_Paid='".$fzpaid."' WHERE id='".$order_id."' ");
		}
		else if($id=='COD' && $value == $_SESSION['COD_token'] && $name =='PaymentType'){
			$con_fee  = 0;
			$amount_payable = $order_total['order_total']  + $con_fee ;
			$amount_payable = number_format($amount_payable,2,".","");
			$fzpaid=0;
			echo " ₹ ".$amount_payable;
			 @mysql_query("UPDATE orders SET con_fee='".$con_fee."' , paymenttype='COD' , fzwallet_Paid='".$fzpaid."' WHERE id='".$order_id."' ");
		}
		else if($id=='FzWallet' && $value == $_SESSION['FzWallet_token'] && $name =='PaymentType' ){
			$con_percent=4; // you can change the con fee here 
			$con_fee  = number_format(($order_total['order_total'])*$con_percent/100,2,".","");
			
			$balance=getWalletBalance();
			if($balance>0){
					$remaining = ($order_total['order_total']  + $con_fee)- $balance;
					if($remaining >=0){
						$fzpaid=$balance;
						$remaining = number_format($remaining,2,".","");
					$amount_payable =  " ₹ ".$remaining;
					}
				   else {
					   $fzpaid=$order_total['order_total']  + $con_fee;
					   $amount_payable=" ₹ "."0";
				   }
			}
			else {
				$fzpaid=0;
				$amount_payable = $order_total['order_total']  + $con_fee;
				$amount_payable = number_format($amount_payable,2,".","");
				$amount_payable = " ₹ ".$amount_payable;
			}	
			echo $amount_payable;
			 @mysql_query("UPDATE orders SET con_fee='".$con_fee."', paymenttype='ONLINE PAYMENT' , fzwallet_Paid='".$fzpaid."' WHERE id='".$order_id."' ");
			}
			else 
				echo "Internal error, reload the page";		
}
?>