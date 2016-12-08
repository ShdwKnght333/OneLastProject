<?
include "conf/config.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Offer Terms & Conditions | <?=SITENAME?></title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<? include "inc/styles.php"; ?>
</head>
<body>
<div class="mainbody">
<? include "inc/header.php"; ?>
<div id="content">
<!-- Page Content Start -->
<br/><br/>


<?php if( $_REQUEST['offer']=="diwalidhamaka" ) { ?>

<h2>DIWALI DHAMKA 2016</h2>
<h2>OFFER TERMS AND CONDITIONS</h2>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; Upto 30% instant discount on orders above Rs.500, Maximum discount of Rs.150. Use Coupon Code : DIWALI30</h4>
 
<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; Offer valid for MAX 2 USE per user only on ONLINE PAYMENTS.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; Offer valid till 29th October 2016 midnight.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; Offers cannot be clubbed with any other offer.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; Foodzoned.com reserves the right to end any offers at it discretion.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; All disputes subject to UDUPI Jurisdictions.</h4>


<?php } else if( $_REQUEST['offer']=="payumoney2016" ) { ?>

<h2>PAYUMONEY 2015</h2>
<h2>OFFER TERMS AND CONDITIONS</h2>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; OFFER: On the first four transactions with a particular merchant under the OFFER, the Customer will receive a cashback @ 10% of the value of the transaction amount subject to a maximum of Rs.50/- ('Cashback Amount') in its PayUmoney Wallet issued by RBL ('PayUmoney Wallet') upon making a payment on all websites where the PayUmoney Wallet is available as a payment option through their PayUmoney Account. On all subsequent transactions with the merchant (5th transaction onwards) under the OFFER, the Customers will be eligible for 1% discount.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; In order to avail the OFFER, the Customer must make the payments through PayUmoney payment option and must be a registered as a PayUmoney Walletholder.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; The Cashback Amount can be availed only on the first four transactions by one Walletholder. The Cashback Amount will be received in the Walletholder's PayUmoney Wallet, minimum after 24 hours of the Transaction.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; The Offer will be valid from 9th November, 2015 (00:00:00 hours) to 30th November, 2015 (23:59:59 hours).</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; The Cashback Amount received in the PayUmoney Wallet can be used by the customers on all websites where the PayUmoney Wallet is available as a payment option.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; In the event of a full or partial refund, the proportionate cashback or discount shall be deducted from the customers PayUmoney Wallet account or refund amount. In case the customers PayUmoney Wallet has zero balance then the account shall be in negative and will be adjusted as soon as the cashback or refund is deposited in the customers PayUmoney Wallet.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; This Offer cannot be clubbed with any other offer/promotion being run by PayUmoney. </h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; PayUmoney does not warrant or guarantee availability, merchantability, quality, fitness etc., of any product or service offered on websites where the PayUmoney Wallet is available as a payment option. </h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; PayUmoney reserves the right to, at any stage and at its discretion, modify/change or alter the Offer. PayUmoney also reserves the right to modify/change all or any of the terms applicable to the Offer and to discontinue the Offer without assigning any reasons or without any prior intimation whatsoever. </h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; PayUmoney reserves the right to restrict and disqualify any customer from the benefits of the Offer, in case of any fraudulent activity/suspicious transactions or misuse of the Offer in any way. </h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; Any disputes will be subject to the exclusive jurisdiction of the competent courts of New Delhi.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; In all matters relating to the Offer, PayUmoney's decision will be final.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; In addition to the above, the Offer is also subject to PayUmoney Terms and Conditions including PayUmoney Wallet Issued by RBL Terms and Conditions available on payumoney.com.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; All capitalized terms used but not defined herein shall have the respective meanings ascribed to them in the PayUmoney Terms and Conditions.</h4>

<h4 class="g1"><i class="fa fa-dot-circle-o fa-2x g2"></i> &nbsp; The respective Terms & Conditions on all websites where the PayUmoney Wallet is available as a payment option shall also apply.</h4>

<?php } else { echo "<script> go('./offers.php'); </script>"; } ?>

<br/><br/>

<!-- Page Content End -->
</div>
<? include "inc/footer.php"; ?>
<div class="clearfix"></div>
</div>
</body>
</html>