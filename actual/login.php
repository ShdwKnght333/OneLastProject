<?
include "conf/config.php";
require "conf/facebook.php";

if (FACEBOOK_APP_ID && FACEBOOK_APP_SECRET) {

	$facebook = new Facebook(array(
      'appId'  => FACEBOOK_APP_ID,
      'secret' => FACEBOOK_APP_SECRET,
      'cookie' => true,
    ));

$loginUrl = $facebook->getLoginUrl(array("scope" => "email,user_likes,user_hometown,user_location"));

    if ($_REQUEST['state']) {
    	$session = $facebook->getUser();
        
        $me = null;
        // Session based API call.
        if ($session) {
          try {
            $uid = $facebook->getUser();
            /* $me = $facebook->api('/me'); */
            $me = $facebook->api('/'.$uid);
          } catch (FacebookApiException $e) {
            error_log($e);
          }
        }
    }

	if ($session) {
		//$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$session['access_token']));
		$fb_id=$me['id'];
		$rss=getSqlRow("select * from users where fb_id='".$fb_id."' OR email='".$me['email']."'");
		if ($rss['id']) {

if (!$rss['verify'] == "") { mysql_query("update users set verify='' where id=".$rss['id'].""); }
if ( $rss['fb_id'] !== $fb_id ) { mysql_query("update users set fb_id=".$fb_id." where id=".$rss['id'].""); }

		$_SESSION['memberid']=$rss['id'];

if ( $_REQUEST['back'] ) { echo "<script>window.location='.".$_REQUEST['back']."';</script>"; } 
if ( $_REQUEST['approve'] ) { echo "<script>window.location='./approve.php';</script>"; } else { echo "<script>window.location='./member.php';</script>"; }

		} else {
			$sql['fb_id']		= $fb_id;
			$sql['email']		= $me['email'];
			$sql['name']		= $me['name'];
			$sql['verify']		= "";

			$rpcode = rand(1000,9999);
			$sql['password']	= md5($rpcode);

			$sql['regdate']		= Date("Y-m-d H:i:s");
			$newId=insert_sql("users",$sql);
			$_SESSION['memberid']=$newId;

			if ( $me['email'] !== "" )
			{ @include( DIR_PATH."conf/fb-welcome.php" ); }

if ( $_REQUEST['approve'] ) { echo "<script>window.location='./approve.php';</script>"; } else { echo "<script>window.location='./member_details.php';</script>"; }

		}
		exit;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><? if ($_REQUEST['pass']) { ?>Forgot Password<? } else { ?>Login<? } ?> | <?=SITENAME?></title>
<? include "inc/styles.php"; ?>

    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>
      FB.init({appId: '<?= FACEBOOK_APP_ID ?>', status: true, cookie: true, xfbml: true});
      FB.Event.subscribe('auth.login', function(response) {
        window.location.reload();
      });
      
    </script>

</head>
<body>

<div class="mainbody">

<? include "inc/header.php"; ?>
                

<div id="content" class="container_12">
<div class="grid_12">
<? if ($_REQUEST['pass']) { ?><br/><h1>Forgot Your Password?</h1><? } ?>
<div>

<? if (!$_REQUEST['pass']) { ?>
<br/>
<div class="page3">
<h1><?=(!$_REQUEST['pass'])?$GLOBALS['login']:$GLOBALS['send_my_password']?></h1>
<form id="myform" name="myform" method="post" action="javascript:void(null);">
<input type="hidden" name="cmd" id="cmd" value="login" />
<input type="hidden" name="approve" id="approve" value="<?=$_REQUEST['approve']?>" />
<input type="hidden" name="back" id="back" value="<?=$_REQUEST['back']?>" />
 <table class="fonrm_table">
  <tr>
 <td style="width:130px;" class="t22"><?=$GLOBALS['email']?></td>
 <td><input type="text" name="email" id="email" maxlength="100" style="width:185px;" class="input-text" /></td>
 </tr>
 <tr>
 <td class="t22"><?=$GLOBALS['password']?></td>
 <td><input type="password" name="password" id="password" maxlength="20" style="width:185px;" class="input-text" /></td>
 </tr>
 <tr>
 <td ></td>
 <td style="height:30px;"><input name="sbt" id="sbt" type="submit" class="b22" value="<?=$GLOBALS['login']?>"  onclick='this.disabled=true; loading("span_loading",1); post("myform"); return false;' /> <span id="span_loading"></span></td>
 </tr>
  <tr>
 <td></td>
 <td  style="padding-top:10px;"> <a href="<?=$_SERVER['PHP_SELF']?>?pass=1">Forgot Password?</a></td>
 </tr>
 
 <? if (FACEBOOK_APP_ID && FACEBOOK_APP_SECRET) { ?>
 <tr>
 <td> &nbsp; </td>
 <td  style="padding-top:10px;">
 <a href="<?=$loginUrl?>"><img src="img/fb-login.png" alt="Facebook login" width="205px;"/></a>
    <div id="fb-root"></div>
</td>
 </tr>
 <? } ?>

 <tr>
 <td></td>
 <td  style="padding-top:10px;"><a href="/register.php">Don't have an account?</a><br/><br/><br/></td>
 </tr>
</table>
</form>
</div>

<div class="page4">
<br/>
<div style="text-align:left;border-left:2px solid #DDD;padding-top:30px;background:#fff;">
<a href="/register.php" title="Create a new Foodzoned account"><img src="/img/page/login-page.jpg"></a>
</div>
</div>

 <? } else { ?>

Enter your E-Mail address and we will send you a link to reset your password.<br/><br/>

 <form id="myform" name="myform" method="post" action="javascript:void(null);" >
<input type="hidden" name="cmd" id="cmd" value="send_pass" />
 <table class="fonrm_table">
  <tr>
 <td style="width:140px;" class="t22"><?=$GLOBALS['email']?></td>
 <td><input type="text" name="email" id="email" maxlength="100" style="width:185px;" class="input-text" /></td>
 </tr>
  <tr>
    <td class="t22">Verification</td>
    <td> <input type="text" name="captcha" id="captcha" class="input-text" placeholder="Enter below code" style="width:185px;" autocomplete="off" /></td>
   </tr>
  <tr>
 <td ><img src="captcha.php" alt="captcha" /></td>
 <td style="height:30px;vertical-align: middle;"><input name="sbt" id="sbt" class="b22" type="submit" value="SEND LINK"  onclick='this.disabled=true;loading("span_loading",1); post("myform"); return false;' /> <span id="span_loading"></span></td>
 </tr>
 
 </table>
 </form>
 
 <? } ?>
 

</div>
</div>
</div>
            

<? include "inc/footer.php"; ?>
            
<div class="clearfix"></div>
</div>

</body>
</html>