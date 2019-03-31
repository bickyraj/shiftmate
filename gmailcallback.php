<?php
	session_start();
	include('config.php');
	// include('Httpful');
	include('function.php');
	include('url_get_value.php');

	if(isset($_POST['gmail_data']) && !empty($_POST['gmail_data']))
	{

		$gmail_data = json_decode($_POST['gmail_data']);
		// fal($gmail_data);
	}
	// echo "<Pre>";print_r(json_decode($_POST['gmail_data']));
	if(isset($_POST['gmailSubmit']))
	{
		$gmailImage = $_POST['image'];
	  $emailValidation = $_POST['emailValidation'];
	  $email = $_POST['email'];
	  $gmailid = $_POST['gmail_id'];
	  $fname = $_POST['fname'];
	  $lname = $_POST['lname'];
	  $dob = $_POST['dob'];
	  $gender = $_POST['gender'];
	  $password = $_POST['password'];

		// echo "<pre>";print_r($_POST);die();

	  $url = URL."Users/gmailregistration.json";
	  $response = \Httpful\Request::put($url)                  // Build a PUT request...
	    ->sendsJson()  
	  //->addHeader('X-MyApiTokenHeader', '123456')                            // tell it we're sending (Content-Type) JSON...
	    //->authenticateWith($username, $password)  // authenticate with basic auth...
	    ->body(array('User'=>array('email'=>$email, 'gmailid'=>$gmailid, 'fname'=>$fname, 'lname'=>$lname, 'gender'=>$gender, 'dob'=>$dob, 'password'=>$password),'emailValidation'=>$emailValidation))             // attach a body/payload...
	    ->send();
	 // echo "<pre>";
	 // print_r($response->body);
	 // die();
	    if(isset($response->body->message->status) && !empty($response->body->message->status))
	    {

	  		$response_status =  $response->body->message->status;
	  		$user_id = $response->body->message->user_id;
	  		$dirPath = mkdir('/home/shiftmatecom/public_html/shiftmate_api/webroot/files/user/image/'.$user_id);
	  		$url = $gmailImage;
            
            file_put_contents('/home/shiftmatecom/public_html/shiftmate_api/webroot/files/user/image/'.$user_id.'/thumb2_gmailimage.jpg', file_get_contents($url));
	    }
	  

	  if($response->body->output->emailValidation ==1)
	  {
	  	$message = $response->body->output->message;
	  	 echo "<script>alert('Please log in to your email for activation.');</script>";
	  }
	  else
	  {

		  if($response_status == 0){
		      
		  }else{
		    $login_detail = $response->body->message;
		    $login_status = getLoginUserDetail($login_detail);

		   // echo "<pre>";print_r($login_detail);print_r($login_status);die();
		    echo '<script>window.location = "'.URL_VIEW.'";</script>';
		  die();
		  }
	  }
	}
?>

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
<link href="<?php echo URL_VIEW;?>global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>admin/pages/css/login-soft.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo URL_VIEW;?>global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link id="style_color" href="<?php echo URL_VIEW;?>admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-toastr/toastr.min.css"/>

<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
	<img src="<?php echo URL_VIEW;?>admin/layout/img/logo.png" alt="">
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN REGISTRATION FORM -->
	<form class="fb_registerForm" action="" method="post">
		<h3>Gmail login detail</h3>
		<input type="hidden" name="image" value="<?php echo $gmail_data->image->url;?>" />
		<input type="hidden" name="gmail_id" value="<?php echo $gmail_data->id;?>">
		<p>
			 Enter your personal details below:
		</p>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">First Name</label>
			<div class="input-icon">
				<i class="fa fa-font"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" value="<?php echo (!empty($gmail_data->name->givenName)?$gmail_data->name->givenName:'');?>" name="fname"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Last Name</label>
			<div class="input-icon">
				<i class="fa fa-font"></i>
				<input class="form-control placeholder-no-fix" type="text" placeholder="Last Name" 
				value="<?php echo (!empty($gmail_data->name->familyName)?$gmail_data->name->familyName:'');?>" name="lname"/>
			</div>
		</div>

		<?php if(!isset($gmail_data->emails['0']->value) && empty($gmail_data->emails['0']->value)):?>
			<input type="hidden" name="emailValidation" value="1">
			<div class="form-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9">Email</label>
				<div class="input-icon">
					<i class="fa fa-envelope"></i>
					<input id="gmail_email" class="form-control placeholder-no-fix" type="text" placeholder="Email" value="" name="email"/>
				</div>
			</div>
		<?php else:?>
			<input type="hidden" name="emailValidation" value="0">
			<input type="hidden" name="email" value="<?php echo $gmail_data->emails['0']->value;?>">
	    <?php endif;?>

		<div class="form-group">
			<label>Gender</label>
			<div class="radio-list">
				<label class="radio-inline">
				<input type="radio" name="gender" id="optionsRadios4" value="0" checked>Male</label>
				<label class="radio-inline">
				<input type="radio" name="gender" id="optionsRadios5" value="1">Female</label>
			</div>
		</div>

		<div class="form-group">
			<div class="input-icon">
				<div class="input-group date date-picker" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
					<input type="text" class="form-control placeholder-no-fix" placeholder="Date of Birth" name="dob" readonly>
					<span class="input-group-btn">
					<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
					</span>
				</div>
			</div>
		</div>
		
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
					<input class="form-control placeholder-no-fix" name="rpassword" type="password" autocomplete="off" placeholder="Re-type Your Password"/>
				</div>
			</div>
		</div>
		<div class="form-actions">
			<button id="register-back-btn" type="button" class="btn">
			<i class="m-icon-swapleft"></i> <a href="<?php echo URL_VIEW;?>">Back</a></button>
			<button type="submit" name="gmailSubmit" id="register-submit-btn" class="btn blue pull-right">Log in <i class="m-icon-swapright m-icon-white"></i>
			</button>
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
<script src="<?php echo URL_VIEW;?>global/plugins/respond.min.js"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_VIEW;?>global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/login-soft.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/ui-toastr.js"></script>

<script>
jQuery(document).ready(function() {     
  Metronic.init(); // init metronic core components
Layout.init(); // init current layout
  Login.init();
  Demo.init();
  UIToastr.init();
  ComponentsPickers.init();
       // init background slide images
       $.backstretch([
        "<?php echo URL_VIEW;?>admin/pages/media/bg/1.jpg",
        "<?php echo URL_VIEW;?>admin/pages/media/bg/2.jpg",
        "<?php echo URL_VIEW;?>admin/pages/media/bg/3.jpg",
        "<?php echo URL_VIEW;?>admin/pages/media/bg/4.jpg"
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
			var inputGmailEmail = $("#gmail_email");
			var emailValid = false;

			checkEmail(inputGmailEmail.val());

			$("#gmail_email").on('blur', function(event)
				{
					var gmail_email = inputGmailEmail.val();

					var validEmail = validateEmail(gmail_email);

					// alert(validEmail);

					if(validEmail===true)
					{
						checkEmail(gmail_email);
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

			function checkEmail(email)
				{
	         		var urli = '<?php echo URL."Users/checkUniqueEmail.json";?>';

	            	 $.ajax({
		                      url:urli,
		                      type:'post',
		                      data:'email='+email,
		                      success:function(response)
	                                           {
	                                                var status = response.output.status;

	                                                if(status === 1){

	                                                	// alert('used');
	                                                	$(inputGmailEmail).closest('.form-group').removeClass('has-success');
	                                                	$(inputGmailEmail).closest('.form-group').addClass('has-error');
	                                                	toastr.warning("The email is already in use. Please log in as a normal log in or unhide your email address in your facebook account.");
	                                                	var errors = { email: "The email is already in use." };
	                                                	$validator.showErrors(errors);

	                                                	emailValid = false;

	                                                }else{
	                                                	emailValid = true;
	                                                	$(inputGmailEmail).closest('.form-group').removeClass('has-error');

	                                                }
	                                           }
	                 });


				}

			   $validator =  $('.fb_registerForm').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                
	                fname: {
	                    required: true
	                },
	                dob: {
	                    required: true
	                },
	                gender: {
	                    required: true
	                },
	                email: {
	                    required: true,
	                    email: true
	                },
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

	            submitHandler: function (form) {
	            	if(emailValid ===true)
	            	{
	                	form.submit();
	            	}
	            	else
	            	{
	            		toastr.warning("The email is already in use. Please log in as a normal log in or unhide your email address in your facebook account.");
	            		$(inputGmailEmail).closest('.form-group').removeClass('has-success');
                    	$(inputGmailEmail).closest('.form-group').addClass('has-error');

                    	var errors = { email: "The email is already in use." };
                    	$validator.showErrors(errors);
	            	}
	            }
	        });

			$('.register-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.register-form').validate().form()) {
	                    $('.register-form').submit();
	                }
	                return false;
	            }
	        });
		});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

