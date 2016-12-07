<?php 
require "conf/facebook.php";
//Shdw started
/*
if (FACEBOOK_APP_ID && FACEBOOK_APP_SECRET) {

	$facebook = new Facebook(array(
      'appId'  => FACEBOOK_APP_ID,
      'secret' => FACEBOOK_APP_SECRET,
      'cookie' => true,
    ));

$loginUrl = $facebook->getLoginUrl(array("scope" => "email,user_likes,user_hometown,user_location"));
    if (isset($_REQUEST['state'])&& $_REQUEST['state']) {
    	$session = $facebook->getUser();
        
        $me = null;
        // Session based API call.
        if ($session) {
          try {
            $uid = $facebook->getUser();
            /* $me = $facebook->api('/me'); //Shdw removed '*./'
            $me = $facebook->api('/'.$uid);
          } catch (FacebookApiException $e) {
            error_log($e);
          }
        }
    }
	if (isset($session) && $session) {
		//$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$session['access_token']));
		$fb_id=$me['id'];
		$profile_photo = "//graph.facebook.com/".$fb_id."/picture";
		$_SESSION['profile_pic']=$profile_photo;
		$rss=getSqlRow("select * from users where fb_id='".$fb_id."' OR email='".$me['email']."'");
		if ($rss['id']) {

			if (!$rss['verify'] == "") { mysql_query("update users set verify='' where id=".$rss['id'].""); }
			if ( $rss['fb_id'] !== $fb_id ) { mysql_query("update users set fb_id=".$fb_id." where id=".$rss['id'].""); }

		$_SESSION['memberid']=$rss['id'];

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

// if ( $_REQUEST['approve'] ) { echo "<script>window.location='./approve.php';</script>"; } else { echo "<script>window.location='./member_details.php';</script>"; }
		}
		echo "<script>var path=document.referrer; window.location=path;</script>";
		exit;
	}
} */
?>
<!---------------------------------login---------------------------------------------------------->
<div id="id01" class="modalogin">  
  <div class="modal-contentlogin animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>
	
<div class="login_container" style="border-bottom:1px solid #ececec; color:#666;">
      <h4 id="header_titles" style="margin:0; font-weight:bold; font-size:1.8rem;">Login to Foodzoned</h4>
    </div>
	
    <div class="login_container">
		<div class="social_login" id="id02">
			<?php if (FACEBOOK_APP_ID && FACEBOOK_APP_SECRET) { ?>			
			<div class="">
					<a href='<?php echo $loginUrl;?>' class="social_box fb">
						<span class="icon"><i class="fa fa-facebook-square fa-2x" style="color:#3b589e"></i></span>
						<span class="icon_title">SignIn with Facebook</span>
					</a>
					 <div id="fb-root"></div>
				</div>
				 <?php  } ?>
				<div class="centeredText">
					<span>Or use your Email address</span>
				</div>
				<div class="action_btns">
					<div class="one_half"><a class="btn" onclick="logindisplay()">Login</a></div>
					<div class="one_half last"><a class="btn" onclick="registerdisplay()">Register</a></div>
				</div>
			</div>

			<div class="user_login" id="id03">
				<form id="mylogin" name="mylogin" class="form-group" method="post" action="javascript:void(null);">
                <input type="hidden" name="cmd" id="cmd" value="login" />
					<label><b>Email</b></label>
					<input id="username" class="input-fields" name="email" value="" placeholder="Username" autofocus="" required="" type="text">
			
					<label><b>Password</b></label>
					<input id="password" class="input-fields" name="password" value="" placeholder="Password" required="" autofocus="" type="password">

					
					<div class="checkbox">
						<input id="remember" type="checkbox" />
						<label for="remember">Remember me on this computer</label>
					</div>

					<div class="action_btns">
						<div class="one_halflog"><a class="btn back_btn" onclick="yoback()"><i class="fa fa-angle-double-left"></i> Back</a></div>
						<div class="one_halflog last"><input class="btn btn_red" type="submit" value="Login" onclick='this.disabled=true; post("mylogin"); return false;' /></div>
					</div>
					<a href="#" class="forgot_password" onclick="forgetdisplay()">Forgot password?</a>
				</form>
				<div id="result"></div>
    <?php
        if ($dbh[0] != 0) {
            mysql_close($dbh);
        }
    ?>
	<?php 
$query_parent = mysql_query("SELECT DISTINCT region FROM search WHERE status='1'");
?>
			</div>

			<!-- Register Form -->
			<div class="user_register" id="id04">
				<form  id="myregister" name="myregister" method="post" action="javascript:void(null);">
				<input type="hidden" name="cmd" id="cmd" value="register" />
				<table class="fonrm_table">
				<tr>
				<td ><label><b>Full Name</b></label></td>
				<td><input type="text" name="name" id="name" maxlength="100" placeholder="Enter Full Name" class="input-text" required/></td>
				</tr>
				<tr>
				<td><label><b>Email </b></label></td>
				<td><input type="text" name="email_reg" id="email_reg" maxlength="100" placeholder="Enter Email Address"class="input-text" required/></td>
				</tr>
				<tr>
				<td><label><b>Password</b></label></td>
				<td><input type="password" name="password_reg" id="password_reg" maxlength="20" minlength="5" placeholder="Enter password" class="input-text" required/></td>
				</tr>
				<tr>
				<td><label><b>Confirm</b></label></td>
				<td><input type="password" name="password_confirm" id="password_confirm" maxlength="20" minlength="5" placeholder="Confirm password" class="input-text" /></td>
				</tr>
				<tr>
                <td><label><b>Phone </b></label></td>
					<td><input type="text" name="mobilphone" id="mobilphone" placeholder="Enter Mobile Number" minlength="10"  class="input-text" required/></td>
				</tr>
				<tr>	
					<td><label><img src="captcha.php" alt="captcha" style="margin-top: -10px;" /></label></td>
					<td><input type="text" name="captcha" id="captcha" class="input-text" placeholder="Enter 4 Digit Code" autocomplete="off" /></td>
				</tr>
			<div class="action_btns">				
				<tr>   
					<td><div class="one_halflog"><a class="btn back_btn" onclick="yoback()"><i class="fa fa-angle-double-left"></i> Back</a></div></td>
					<td><div class="one_halflog last"><input type="submit" class="btn btn_red" name="sbt_reg" value="Register" onclick='this.disabled=true; post("myregister"); return false;' /></div></td>
				</tr>
		   </div>
				</table>
				</form>
				<div id="result"></div>
    <?php
        if ($dbh[0] != 0) {
            mysql_close($dbh);
        }
    ?>
			</div>
            
            <!--forget password-->
            <div class="user_forget" id="id05">
			<form id="user_forget" name="user_forget" method="post" action="javascript:void(null);" >
				<input type="hidden" name="cmd" id="cmd" value="send_pass" />
					<table>
					<tr>
					<label style="color:#666;">Lost your password ? </label>
					</tr>
					<tr> 
					<td><label><b>Email Address</b></label></td>
					<td><input type="text" name="email" id="email" placeholder="Enter Email Address" maxlength="100" class="input-text" /></td>
					</tr>
						<tr>	
					<td><label><img src="captcha.php" alt="captcha" style="margin-top: -10px;" /></label></td>
					<td><input type="text" name="captcha" id="captcha" class="input-text" placeholder="Enter 4 Digit Code" autocomplete="off" /></td>
				</tr>
				<div class="action_btns">
					<tr>
					 <td><div class="one_halfp"><a class="btn back_btn" onclick="yoback()"><i class="fa fa-angle-double-left"></i> Back</a></div></td>
					 <td><div class="one_halfp last"><input type="submit" class="btn btn_red"name="sbt" value="Send Reset Link" onclick='this.disabled=true;post("user_forget"); return false;' /></div></td>
				</tr></div>
				</table>
				</form>
				<div id="result"></div>
			</div>	
			<div id="result"></div>
			 <?php
        if ($dbh[0] != 0) {
            mysql_close($dbh);
        }
    ?>
    </div>

    <div class="login_container center">
      <p style="margin:0;line-height:16px;font-size:12px;">By logging in, you agree to Foodzoned's <br><a href="terms.php">Terms of Service</a> and <a href="privacy.php">Privacy Policy</a>.</p>
    </div>
  </div>
</div>