<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shiftmate</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-toastr/toastr.min.css"/>
<script src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
<!-- toastr notification js-->
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/ui-toastr.js"></script>
<!-- End of toastr notification js -->



<script>
jQuery(document).ready(function() {    
 
UIToastr.init(); //init Toastr Notification.
});
</script>

</head>

<body>

<?php
if(isset($_SESSION['success']))
{
  
  echo("<script>
      toastr.success('Thank You For Registration.Please Check Your email For Activate');

            </script>");
  
  unset($_SESSION['success']);
}
// For remember me cookie
function encrypt_decrypt($action, $string) {
    $remembermeData = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'breakit';
    $secret_iv = 'doit';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $remembermeData = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $remembermeData = base64_encode($remembermeData);
    }
    else if( $action == 'decrypt' ){
        $remembermeData = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $remembermeData;
}
// end of remember me cookie

if(isset($_COOKIE['remember_me_cookie1'])&&isset($_COOKIE['remember_me_cookie2']))
{
  // echo "<pre>";print_r($_COOKIE['remember_me_cookie']);

  $rememberEmail = encrypt_decrypt('decrypt',$_COOKIE['remember_me_cookie1']);
  $rememberPassword = encrypt_decrypt('decrypt',$_COOKIE['remember_me_cookie2']);
}

//session_start();
//include('config.php');

// require_once('facebook-php-sdk/Facebook/autoload.php');

if(isset($_POST['fb_login_submit']))
{
  $email = $_POST['email'];
  $fbid = $_POST['fb_id'];
  $fname = $_POST['fb_first_name'];
  $lname = $_POST['fb_last_name'];

  $url = URL."Users/login.json";
  $response = \Httpful\Request::put($url)                  // Build a PUT request...
    ->sendsJson()  
  //->addHeader('X-MyApiTokenHeader', '123456')                            // tell it we're sending (Content-Type) JSON...
    //->authenticateWith($username, $password)  // authenticate with basic auth...
    ->body(array('User'=>array('email'=>$email, 'fbid'=>$fbid, 'fname'=>$fname, 'lname'=>$lname)))             // attach a body/payload...
    ->send();
 // echo "<pre>";
 // print_r($response->body->message);
 // die();
  $response_status =  $response->body->message->status;
  
  if($response_status == 0){
    
      $_SESSION['user_type'] = '';
      $_SESSION['token'] = '';
      $_SESSION['user_id'] = '';
      $login_type['status'] = 0;
      $login_type['name'] = 'Fail';
      $error_message = 'username / password incorrect';
      
  }else{
    $login_detail = $response->body->message;
    $login_status = getLoginUserDetail($login_detail);
    echo '<script>window.location = "'.URL_VIEW.'";</script>';
	die();
  }
}

if(isset($_POST['gmail_login_submit']))
{
  // echo "<pre>";print_r($_POST);die();
  $email = $_POST['email'];
  $gmailid = $_POST['gmail_id'];
  $fname = $_POST['gmail_first_name'];
  $lname = $_POST['gmail_last_name'];

  $url = URL."Users/gmaillogin.json";
  $response = \Httpful\Request::put($url)                  // Build a PUT request...
    ->sendsJson()  
  //->addHeader('X-MyApiTokenHeader', '123456')                            // tell it we're sending (Content-Type) JSON...
    //->authenticateWith($username, $password)  // authenticate with basic auth...
    ->body(array('User'=>array('email'=>$email, 'gmailid'=>$gmailid, 'fname'=>$fname, 'lname'=>$lname)))             // attach a body/payload...
    ->send();
 // echo "<pre>";
 // print_r($response->body->message);
 // die();
  $response_status =  $response->body->message->status;
  
  if($response_status == 0){
    
      $_SESSION['user_type'] = '';
      $_SESSION['token'] = '';
      $_SESSION['user_id'] = '';
      $login_type['status'] = 0;
      $login_type['name'] = 'Fail';
      $error_message = 'username / password incorrect';
      
  }else{
    $login_detail = $response->body->message;
    $login_status = getLoginUserDetail($login_detail);
    echo '<script>window.location = "'.URL_VIEW.'";</script>';
	die();
  }
}

if(isset($_POST['submit']) && $_POST['submit']=="Log In")
{
	
	// echo "<pre>";
 //  print_r($_POST);die();
	$email = $_POST['email'];
	$password = $_POST['password'];

  if(isset($_POST['remember_me']) && $_POST['remember_me'] == "on")
  {

    $cookie_name1 = 'remember_me_cookie1';
    $cookie_value1 = encrypt_decrypt('encrypt',$email);

    $cookie_name2 = 'remember_me_cookie2';
    $cookie_value2 = encrypt_decrypt('encrypt',$password);

    setcookie($cookie_name1, $cookie_value1, time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie($cookie_name2, $cookie_value2, time() + (86400 * 30), "/"); // 86400 = 1 day
  }

	$url = URL."Users/login.json";
	$response = \Httpful\Request::put($url)                  // Build a PUT request...
    ->sendsJson()  
	//->addHeader('X-MyApiTokenHeader', '123456')                            // tell it we're sending (Content-Type) JSON...
    //->authenticateWith($username, $password)  // authenticate with basic auth...
    ->body(array('User'=>array('email'=>$email, 'password'=>$password)))             // attach a body/payload...
    ->send();

	$response_status =  $response->body->message->status;
	/*echo "<pre>";
	print_r($response_status);
	print_r($response);
	die();*/
	if($response_status == 0){
		
			$_SESSION['user_type'] = '';
			$_SESSION['token'] = '';
			$_SESSION['user_id'] = '';
			$login_type['status'] = 0;
			// $login_type['name'] = 'Fail';
			$error_message = 'username / password incorrect';
			
	}else{
		$login_detail = $response->body->message;
		$login_status = getLoginUserDetail($login_detail);
		echo '<script>window.location = "'.URL_VIEW.'";</script>';
		die();
	}
	
}
?>
<style>
  .full-width {
    width: 100% !important;
  }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>styles/login.css"/>
<div class="registration-formDiv">
    <div class="logo">
    	Shiftmate
    </div>
    <div class="content login">
		<div class="clear"></div>
		<form action="" method="post">
		    <h3 class="form-title">Sign In</h3>		            
	            <ul class="registration-form">
                	<?php
					if(isset($error_message) && !empty($error_message)){
					?>
                    <li><?php echo $error_message;?></li>
                    <?php } ?>
	                <li>
	                	<label>Email Address</label></li>
	                <li>
                    <?php if(isset($_COOKIE['remember_me_cookie1'])&&isset($_COOKIE['remember_me_cookie2'])):?>
	                	<input type="text" name="email" id="email" value="<?php echo $rememberEmail;?>" class="full-width"></li>
                  <?php else:?>
                  <input type="text" name="email" id="email" class="full-width"></li>
                <?php endif;?>
	                <li>
	                	<label>Password</label></li>
	                <li>
                    <?php if(isset($_COOKIE['remember_me_cookie1'])&&isset($_COOKIE['remember_me_cookie2'])):?>
	                	<input type="password" name="password" id="password" value="<?php echo $rememberPassword;?>" class="full-width">
                  <?php else:?>
                    <input type="password" name="password" id="password"  class="full-width">
                <?php endif;?>
	                </li>
	                <li>
	                <div class="clear"></div>
	                	<input type="checkbox" name="remember_me"><span class="check">Remember me</span>
	                </li>
	            </ul>
              Login With:

              <a href="#" id="fb_login"> <img src="<?php echo URL; ?>webroot/files/facebookicon.png" height="30" width="30"/></a>
              <a id="render" style="cursor:pointer" onclick="login()"><img src="<?php echo URL; ?>webroot/files/googleplus.png" height="30" width="30"/></a>



		            <div class="clear"></div>
                
		            <a href="#">Forget password?</a>
		            <input type="submit" name="submit" value="Log In">
		            <div class="clear"></div>
		            <div class="registerLineLogin"><a href="<?php echo URL_VIEW;?>organizations/orgRegister">Register Organization</a> | <a href="<?php echo URL_VIEW;?>employees/employeeRegistration">Register User</a></div>
		        
		</form>
	</div>
</div>

<form id="fb_form" method="POST" action="">
  <input type="hidden" name="fb_first_name" id="fb_first_name" value="">
  <input type="hidden" name="fb_last_name" id="fb_last_name" value="">
  <input type="hidden" name="fb_id" id="fb_id" value="">
  <input type="hidden" name="email" id="fb_email" value=""/>
  <input type="submit" name="fb_login_submit" id="fb_login_submit" hidden/>
</form>

<form id="gmail_form" method="POST" action="">
  <input type="hidden" name="gmail_first_name" id="gmail_first_name" value="">
  <input type="hidden" name="gmail_last_name" id="gmail_last_name" value="">
  <input type="hidden" name="gmail_id" id="gmail_id" value="">
  <input type="hidden" name="email" id="gmail_email" value=""/>
  <input type="submit" name="gmail_login_submit" id="gmail_login_submit" hidden/>
</form>
</body>
</html>

<script type="text/javascript">

	$(function()
		{
        // Facebook login functions
        window.fbAsyncInit = function() {
        FB.init({
          appId      : '856218954432326',
          cookie     : true,  // enable cookies to allow the server to access 
                              // the session
          status     : true,
          oauth      : true,
          xfbml      : true,  // parse social plugins on this page
          version    : 'v2.4' // use version 2.2
        });

        };

        // Load the SDK asynchronously
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        $("#fb_login").on('click', fb_login);
        function fb_login()
        {
          FB.login(function(response) {
                          if (response.status === 'connected') {

                            loginAPI();
                            // Logged into your app and Facebook.
                          } else if (response.status === 'not_authorized') {
                            // The person is logged into Facebook, but not your app.
                          } else {
                            // The person is not logged into Facebook, so we're not sure if
                            // they are logged into this app or not.
                          }
                        },{scope: 'public_profile'});
        }

        function loginAPI()
        {
          FB.api('/me?fields=email,first_name,last_name,birthday,picture', function(response) {

            // console.log(response);

                  $("#fb_first_name").val(response.first_name);
                  $("#fb_last_name").val(response.last_name);
                  $("#fb_id").val(response.id);
                  $("#fb_email").val(response.email);
                  $("#fb_login_submit").click();
              });
        }
        // End of Facebook login functions.
      });
</script>

<script type="text/javascript">

      // Google plus login function

      function onLoadCallback()
                {
                    gapi.client.setApiKey('AIzaSyAQ2Cvaed2aoCo5HVEZ6-hRdChYxzavMuc'); //set your API KEY
                    gapi.client.load('plus', 'v1',function(){});//Load Google + API
                }
              
      function login() 
                  {
                    var myParams = {
                      'clientid' : '620920868667-rc2a63oa13b43bk86ut57k84fflue674.apps.googleusercontent.com',
                      'cookiepolicy' : 'single_host_origin',
                      'callback' : 'loginCallback', //callback function
                      'approvalprompt':'force',
                      'scope' : 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
                    };
                    gapi.auth.signIn(myParams);
                   

                  }

      function loginCallback(authResult)
        {
            if (authResult['status']['signed_in'])
            {

             var request = gapi.client.plus.people.get(
                                          {
                                              'userId': 'me'
                                          });
                request.execute(function (response)
                {
                  // console.log(response);

                  var email = response.emails['0']['value'];
                  var gmailid = response.id;
                  var fname = response.name.givenName;
                  var lname = response.name.familyName;

                  $("#gmail_first_name").val(fname);
                  $("#gmail_last_name").val(lname);
                  $("#gmail_id").val(gmailid);
                  $("#gmail_email").val(email);
                  $("#gmail_login_submit").click();
                });

            } else {
              // Update the app to reflect a signed out user
              // Possible error values:
              //   "user_signed_out" - User is signed-out
              //   "access_denied" - User denied access to your app
              //   "immediate_failed" - Could not automatically log in the user
              console.log('Sign-in state: ' + authResult['error']);
            }
          }
      // End of Google plus login

</script>

<script type="text/javascript">

  // Google api loading script
      (function() {
       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
       po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
     })();
     // end of google api loading script.
</script>
