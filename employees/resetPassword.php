<!DOCTYPE html>

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

<?php 

if(isset($_POST['submitf']))
{

 // $email = $_POST['email'];
     //echo "<Pre>";print_r($_POST['data']);die();
      $_POST['data']['User']['email'] = $_POST['email'];
      $url = URL . "Users/resetPasswordManually.json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

                // echo "<pre>";print_r($response);die();

                if($response->body->output ==1)
                {
                  echo("<script>
                            toastr.success('Email has been sent to your email address.');

                                  </script>");
                }
                else
                {
                  echo("<script>
                      toastr.error('Invalid Email address.');

                            </script>");
                }
}

 ?>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
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

  <!-- BEGIN LOGIN FORM -->
 
  <!-- END LOGIN FORM -->
  <!-- BEGIN FORGOT PASSWORD FORM -->
  <div class="content">
  <!-- BEGIN LOGIN FORM -->
  
  <!-- END LOGIN FORM -->
  <!-- BEGIN FORGOT PASSWORD FORM -->
  <form class="forget-form" action="" method="post" novalidate="novalidate" style="display: block;">
    <h3>Forget Password ?</h3>
    <p>
       Enter your e-mail address below to reset your password.
    </p>
    <div class="form-group">
      <div class="input-icon">
        <i class="fa fa-envelope"></i>
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email">
      </div>
    </div>
    <div class="form-actions">
      <a href="<?php echo URL_VIEW;?>">
      <button type="button" id="back-btn" class="btn">
      <i class="m-icon-swapleft"></i> Back </button></a>
      <button type="submit" name="submitf" class="btn blue pull-right">
      Submit <i class="m-icon-swapright m-icon-white"></i>
      </button>
    </div>
  </form>
  <!-- END FORGOT PASSWORD FORM -->
  <!-- BEGIN REGISTRATION FORM -->
  
  <!-- END REGISTRATION FORM -->

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
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>