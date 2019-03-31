<!DOCTYPE html>
<?php 

$query_string = $_GET['A1'];
$decodeQuery = base64_decode($query_string);

$arr = explode('&', $decodeQuery);

$userId = explode('userId=', $arr['0']);

$userId = base64_decode($userId['1']);

if(isset($_POST['submitf']))
{

 // $email = $_POST['email'];
      
      $_POST['data']['User']['password'] = $_POST['password'];
      //echo "<Pre>";print_r($_POST['data']);die();
      $url = URL . "Users/resetPassword/".$userId.".json";
      $response = \Httpful\Request::post($url)
              ->sendsJson()
              ->body($_POST['data'])
              ->send();
      
     if($response->body->output == '1')
         {
              $_SESSION['pwd_success']= "Successfully!! Password Reset";
             echo '<script>window.location.assign("login.php")</script>';
         }
         else{
          echo("<script>
              location.href ='".URL_VIEW."employees/enterNewPassword"."';</script>");
         }

      //echo "<pre>";print_r($response);die();
  }
?>

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
<!-- BEGIN LOGO -->
<div class="logo">
  <img src="<?php echo URL_VIEW; ?>admin/layout/img/logo.png" alt=""/>
  
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->

  <!-- BEGIN LOGIN FORM -->
 
  <!-- END LOGIN FORM -->
  <!-- BEGIN FORGOT PASSWORD FORM -->
  <div class="content">
    <!-- BEGIN REGISTRATION FORM -->
    <form class="" action="" id="PasswordResetForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    
    
        <h3>Reset your Password</h3>
        <p>
             Enter your new password:
        </p>
  
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
            <div class="controls">
                <div class="input-icon">
                    <i class="fa fa-check"></i>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" id="rpassword" name="rpassword"/>

                </div>
            </div>
            <div id="cpassError" style="float:right; display:none; color:red;">The password did not match the original.</div>
        </div>
        <div class="form-group">
                <div id="googleCaptcha" style="float:right;"></div>
                <i id="capError" style="display:none; float:right;"></i>
                <span id="capchaError" class="help-block"></span>
        </div>
        <div class="form-actions">
            <button id="register-back-btn" type="button" class="btn">
            <i class="m-icon-swapleft"></i> Back </button>
           <!--  <button type="submit" id="register-submit-btn" class="btn blue pull-right">
            Sign Up <i class="m-icon-swapright m-icon-white"></i>
            </button> -->
            <input  type="submit" name="submitf" value="Submit" class="btn blue pull-right"/>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
    Designed &amp; Developed By: <a href="#" target="_blank">OnePlatinum Technolog
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>

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
var captchaSubmit = false;
var verifyCallback = function(response) {
        var capError = $("#capchaError");
        capError.css("display", "none");
        captchaSubmit = true;
      };
var onloadCallback = function() {
        grecaptcha.render('googleCaptcha', {
          'sitekey' : '6LdFtgsTAAAAAHvYyC_SxXyr0jYmbxOrb9LTlTuo',
          'callback' : verifyCallback,
          'theme': 'light'
        });
      };

            var valid = false;
            var email = $("#orgEmail").val();
            $("#orgEmail").on('blur', function(event)
                {
                    var org_email = $("#orgEmail").val();

                    var validEmail = validateEmail(org_email);

                    // alert(validEmail);

                    if(validEmail===true)
                    {
                        checkEmail(org_email);
                    }
                    else
                    {
                        emailValid = false
                    }
                });

            function validateEmail(email) {
                        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                        return re.test(email);
                    }

 
$validator =  $("#PasswordResetForm").validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    
                    
                    password: {
                        required: true
                    },
                    rpassword: {
                        equalTo: "#register_password"
                    },

                    tnc: {
                        required: true
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
                    tnc: {
                        required: "Please accept TNC first."
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   

                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                        label.closest('.form-group').addClass('has-success');
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },

                errorPlacement: function (error, element) {
                    if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
                        error.insertAfter($('#register_tnc_error'));
                    } else if (element.closest('.input-icon').size() === 1) {
                        error.insertAfter(element.closest('.input-icon'));
                    } else {
                        error.insertAfter(element);
                    }
                },

             


            });
</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>