<!DOCTYPE html>

<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 3.9.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>  
<meta charset="utf-8"/>
<title>Shiftmate</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW; ?>global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW; ?>global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW; ?>global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW; ?>global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo URL_VIEW; ?>global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW; ?>admin/pages/css/login-soft.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo URL_VIEW; ?>global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW; ?>global/css/plugins.css" rel="stylesheet" type="text/css"/>

<link id="style_color" href="<?php echo URL_VIEW; ?>admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW; ?>admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->

<!--
aDDED JS AND CSS
-->
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
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<?php
if(isset($_SESSION['success']))
{
  
  echo("<script>
      toastr.success('Thank You For Registration.');

            </script>");
  
  unset($_SESSION['success']);
}


else if(isset($_SESSION['pwd_success'])){
  echo("<script>
      toastr.success('Sucessfully password reset!!Please Log in with new password!!');

            </script>");
  
  unset($_SESSION['pwd_success']);
}

else if(isset($_SESSION['error'])){
  echo("<script>
      toastr.success('Something Went Wrong');

            </script>");

  unset($_SESSION['error']);

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

  // echo "<pre>";print_r($_POST);die();

  $url = URL."Users/fblogin.json";
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

if(isset($_POST['btnSubmit']) && $_POST['btnSubmit']=="Log In")
{
  
  // echo "<pre>";
  // print_r($_POST);die();
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(isset($_POST['remember_me']) && $_POST['remember_me'] == "1")
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
  // echo "<pre>";
  // print_r($response_status);
  // print_r($response);
  // die();
  if($response_status == 0){
    
      $_SESSION['user_type'] = '';
      $_SESSION['token'] = '';
      $_SESSION['user_id'] = '';
      $login_type['status'] = 0;
      // $login_type['name'] = 'Fail';
      $error_message = 'username / password incorrect';
      
  }
  else if($response_status == 5 || $response_status == 4)
  {
      //$_SESSION['user_type'] = '';
      //$_SESSION['token'] = '';
      //$_SESSION['user_id'] = '';
      //$login_type['status'] = 0;
      // $login_type['name'] = 'Fail';
      $error_message = 'Inactive User,Activate before login'; 
  }

  else{
    $login_detail = $response->body->message;
    $login_status = getLoginUserDetail($login_detail);
    echo '<script>window.location = "'.URL_VIEW.'";</script>';
    die();
  }
  
}
?>
<!-- BEGIN LOGO -->
<div class="logo">
  <img src="<?php echo URL_VIEW; ?>admin/layout3/img/logo.png" alt=""/>
  
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
  <!-- BEGIN LOGIN FORM -->
  <form  class="login-form" action="" method="post">
    <h3 class="form-title">Login to your account</h3>
    <?php
      if(isset($error_message) && !empty($error_message)){
    ?>
      <div class="alert alert-danger display-show">
          <button class="close" data-close="alert"></button>
              <span>
             <?php echo $error_message;?> </span>
       </div>
   <?php } else {?>
      <div class="alert alert-danger display-hide">
          <button class="close" data-close="alert"></button>
              <span></span>
       </div>
   <?php } ?>
    <div class="form-group">
      <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
      <label class="control-label visible-ie8 visible-ie9">Email</label>
      <div class="input-icon">
        <i class="fa fa-user"></i>
        <?php if(isset($_COOKIE['remember_me_cookie1'])&&isset($_COOKIE['remember_me_cookie2'])):?>
              
              <input type="text" name="email" id="email" value="<?php echo $rememberEmail;?>" class="form-control placeholder-no-fix">
         <?php else:?>
              <input type="text" name="email" id="email" placeholder="Email" class="form-control placeholder-no-fix">
          <?php endif;?>

      </div>
    </div>
    <div class="form-group">
      <label class="control-label visible-ie8 visible-ie9">Password</label>
      <div class="input-icon">
        <i class="fa fa-lock"></i>
        <?php if(isset($_COOKIE['remember_me_cookie1'])&&isset($_COOKIE['remember_me_cookie2'])):?>
            
            <input type="password" name="password" id="password" value="<?php echo $rememberPassword;?>" class="form-control placeholder-no-fix">
        <?php else:?>
            <input type="password" name="password" id="password" placeholder="Password"  class="form-control placeholder-no-fix">
        <?php endif;?>
      </div>
    </div>
    <div class="form-actions">
      <input type="submit" name="btnSubmit" id="btnSubmit" value="Log In" class="btn blue pull-right">
      <label class="checkbox">
      <input type="checkbox" name="remember_me" value="1"/> Remember me </label>
      <!-- <button type="submit" class="btn blue pull-right">
      Login <i class="m-icon-swapright m-icon-white"></i>
      </button> -->
    </div>
  </form>
    <div class="login-options">
      <h4>Or login with</h4>
      <ul class="social-icons">
        <li>
          <a class="facebook" id="fb_login" data-original-title="facebook" href="javascript:;">
          </a>
        </li>
       <!--  <li>
          <a class="twitter" data-original-title="Twitter" href="javascript:;">
          </a>
        </li> -->
        <li>
          <a class="googleplus" id="render" style="cursor:pointer" onclick="login()" data-original-title="Goole Plus" href="javascript:;">
          </a>
        </li>
       <!--  <li>
          <a class="linkedin" data-original-title="Linkedin" href="javascript:;">
          </a>
        </li> -->
      </ul>
    </div>
    <form id="fb_form2" method="POST" action="fb-callback.php">
      <input id="hidFbData" type="hidden" name="fb_data">
    </form>
    <form id="gmail_form2" method="POST" action="gmailcallback.php">
      <input id="hidgmailData" type="hidden" name="gmail_data">
    </form>

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
    <div class="forget-password">
      <h4>Forgot your password ?</h4>
      <p>
         no worries, click <a href="<?php echo URL_VIEW;?>employees/resetPassword" id="forget-password">
        here </a>
        to reset your password.
      </p>
    </div>
    <div class="create-account">
      <p>
         Don't have an account yet ?&nbsp;<br>
         <div class="registerLineLogin"><a href="<?php echo URL_VIEW;?>organizations/orgRegister">Register Organisation</a> | <a href="<?php echo URL_VIEW;?>employees/employeeRegistration">Register User</a></div>
      </p>
    </div>

  <!-- END LOGIN FORM -->

</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
    Designed &amp; Developed By: <a href="#" target="_blank">OnePlatinum Technology
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo URL_VIEW; ?>global/plugins/respond.min.js"></script>
<script src="<?php echo URL_VIEW; ?>global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo URL_VIEW; ?>global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW; ?>global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW; ?>global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW; ?>global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW; ?>global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW; ?>global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo URL_VIEW; ?>global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW; ?>global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_VIEW; ?>global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW; ?>admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW; ?>admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/login-soft.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script type="text/javascript">

$(function() {
    $('.login-form').each(function() {
        $(this).find('input').keypress(function(e) {
            if(e.which == 10 || e.which == 13) {
              //alert(this);
                $("#btnSubmit").click();
            }
        });

    });
});
</script>

<script>
jQuery(document).ready(function() {     
  Metronic.init(); // init metronic core components
Layout.init(); // init current layout
  Login.init();
  Demo.init();
       // init background slide images
       $.backstretch([
        "<?php echo URL_VIEW; ?>admin/pages/media/bg/1.jpg",
        "<?php echo URL_VIEW; ?>admin/pages/media/bg/2.jpg",
        "<?php echo URL_VIEW; ?>admin/pages/media/bg/3.jpg",
        "<?php echo URL_VIEW; ?>admin/pages/media/bg/4.jpg"
        ], {
          fade: 1000,
          duration: 8000
    }
    );
});
</script>
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

                            // console.log(response);

                            loginAPI();
                            // Logged into your app and Facebook.
                          } else if (response.status === 'not_authorized') {
                            // The person is logged into Facebook, but not your app.
                          } else {
                            // The person is not logged into Facebook, so we're not sure if
                            // they are logged into this app or not.
                          }
                        },{scope:'email',return_scopes: true});
        }

        function loginAPI()
        {
          FB.api('/me?fields=email,first_name,last_name,birthday,picture', function(response) {

            console.log(response);
            var fbjson = JSON.stringify(response);
            // console.log(fbjson);            

              var email = response.email;
              var fname = response.first_name;
              var lname = response.last_name;
              var fbid = response.id;
              var urli = '<?php echo URL."Users/checkFbEmail/"."'+email+'"."/"."'+fbid+'".".json";?>';
              $.ajax(
                {
                  url:urli,
                  type:'post',
                  datatype:'jsonp',
                  success:function(response)
                  {
                    // console.log(response);

                    if(response.output == 1)
                    {
                      if(response.status == 4)
                      {
                        toastr.success('An email has been sent to you. Please check your email for activation.');
                      }
                      else
                      {

                        $("#fb_first_name").val(fname);
                        $("#fb_last_name").val(lname);
                        $("#fb_id").val(fbid);
                        $("#fb_email").val(email);
                        $("#fb_login_submit").click();
                        // alert('hello');
                      }
                      
                    }
                    else
                    {
                      $("#hidFbData").val(fbjson);
                      $("#fb_form2").submit();
                    }
                  }
                });
              


            // $("#hidFbData").val(fbjson);
            // $("#fb_form2").submit();
                  
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
                  var gmailjson = JSON.stringify(response);
                  console.log(gmailjson);

                  var email = response.emails['0']['value'];
                  var gmailid = response.id;
                  var fname = response.name.givenName;
                  var lname = response.name.familyName;

                  var urli = '<?php echo URL."Users/checkGmailEmail/"."'+email+'"."/"."'+gmailid+'".".json";?>';
                  $.ajax(
                    {
                      url:urli,
                      type:'post',
                      datatype:'jsonp',
                      success:function(response)
                      {
                        // console.log(response);
                        
                        if(response.output == 1)
                        {
                          if(response.status == 4)
                          {
                            toastr.success('An email has been sent to you. Please check your email for activation.');
                          }
                          else
                          {

                            $("#gmail_first_name").val(fname);
                            $("#gmail_last_name").val(lname);
                            $("#gmail_id").val(gmailid);
                            $("#gmail_email").val(email);
                            $("#gmail_login_submit").click();
                            // alert('hello');
                          }
                          
                        }
                        else
                        {
                          $("#hidgmailData").val(gmailjson);
                          $("#gmail_form2").submit();
                        }
                      }
                    });

                  // $("#gmail_first_name").val(fname);
                  // $("#gmail_last_name").val(lname);
                  // $("#gmail_id").val(gmailid);
                  // $("#gmail_email").val(email);
                  // $("#gmail_login_submit").click();
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

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>