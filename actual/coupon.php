<?
function validVoucher($voucherCode,$cost,$orderId,$discount,$city,$userId,&$output){
	if($voucherCode!=''){
		$cts=date('Y-m-d H:i:s');
		$voucherCode=strtoupper($voucherCode);
		$voucherSQL="SELECT * FROM coupon where voucherCode='".$voucherCode."'";
		$SQLresult=mysql_query($voucherSQL);
		if(mysql_num_rows($SQLresult)==0){
			$output= 'Sorry, the code doesn\'t exist!';
			if($discount>0.0)
				return $discount;
		}
		else{
			$result=mysql_fetch_array($SQLresult);
			$query="SELECT * FROM orders WHERE userid='$userId'AND coupon='$voucherCode'AND payment_status=1";
			$SQLquery=mysql_query($query);
			if(mysql_num_rows($SQLquery)>=$result['maxUses'])
				$output= 'Coupon use limit exceeded!';
			else if($discount>0.0){
				$output= 'Already used a coupon!';
				return $discount;
			}
			else if($result['location']=='ALL' || $city==$result['location']){
				$opCode="SELECT * FROM orders WHERE id=".$orderId;
				$opSQL=mysql_query($opCode);
				$opResult=mysql_fetch_array($opSQL);
				if($result['restID']==0 || $result['restID']==$opResult['resid']){
					if($result['active']==1 && $cts<$result['expiry'] && $result['totalVouchers']>0){
						if($cost>=$result['minBasketCost']){
							if($result['discountType']=='%'){
								$discount=($cost/100)*$result['discountAmount'];
								if($discount>$result['maxDiscount']){
									$discount=$result['maxDiscount'];
								}
							}
							elseif($result['discountType']=='-'){
								$discount=$result['discountAmount'];
								
							}
							$sql = "UPDATE orders SET fzDiscount = '$discount' WHERE id= '$orderId'";
							$updateCoupon="UPDATE orders SET coupon='$voucherCode' WHERE id= '$orderId'";
							mysql_query($sql);
							mysql_query($updateCoupon);
							$output= 'Rs ' . $discount . ' have been disounted!';
							return $discount;
						
						}
						else{
							$output= 'Sorry, the order total is less than minimum required amount!';
						}
					}
					else{
						$output= 'Sorry, the coupon has expired!';
					}
				}
				else
					$output='Sorry, not valid for this restraunt!';
			}
			else
				$output= 'Sorry, not valid in this region!';
		}
	}
	return $discount;
}
?>