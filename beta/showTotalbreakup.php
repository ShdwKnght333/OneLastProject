<?php 
include "conf/config.php";
if(isset($_REQUEST['egid']) && $_REQUEST['egid']) {
	
	$order_info= mysql_query("SELECT * FROM orders where id='".$_REQUEST['egid']."' ");
	$order = mysql_fetch_array($order_info);

	echo "Sub Total : ₹ ".$order['sub_total']."<br>";
	echo "Extras Total : ₹ ".$order['extras_total']."<br>";
	echo "Tax Total : ₹ ".$order['tax_total']."<br>";
	if($order['order_type'] == 'Delivery')
	{	
	echo "Delivery Fee : ₹ ".$order['service_fee']."<br>";
	}	
	if($order['paymenttype'] == "" )
	{
		echo "Convenience Fee : ₹  0 <br>";
		echo "Amount Payable ₹ ".$order['order_total']."<br>";
	}
else {	
	if($order['paymenttype'] == 'COD')
	{
		echo "Convenience Fee : ₹  0 <br>";
		echo "Amount Payable ₹ ".$order['order_total']."<br>";
	}
	else if($order['paymenttype'] == 'ONLINE PAYMENT' && $order['fzwallet_Paid'] == 0 ) // PayUMoney
	{
			$con_percent=5; // you can change the con fee here
			$con_fee  = number_format(($order['order_total'])*$con_percent/100,2,".","");
			$amount_payable = $order['order_total']  + $con_fee ;
			echo "Convenience Fee : ₹ ".$con_fee."<br>";
			echo "Amount Payable : ₹ ".$amount_payable."<br>";
	}
	else if($order['paymenttype'] == 'ONLINE PAYMENT' && $order['fzwallet_Paid'] != 0 ) // FzWallet
	{
			$con_percent=4; // you can change the con fee here
			$con_fee  = number_format(($order['order_total'])*$con_percent/100,2,".","");
			$amount_payable = $order['order_total']  + $con_fee ;
			$balance=getWalletBalance();
			if($balance>0){
					$remaining = ($order['order_total']  + $con_fee)- $balance;
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
			echo "Convenience Fee : ₹  ".$con_fee."<br>";
			echo "Wallet Paid : ₹  ".$fzpaid."<br>";
			echo "Amount Payable : ".$amount_payable;
	}
}	
}

?>