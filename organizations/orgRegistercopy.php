<!DOCTYPE html>

<html lang="en">

<head>
<meta charset="utf-8"/>
<title></title>
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
<script src="https://www.google.com/recaptcha/api.js?onload=loadCaptcha&render=explicit" async defer></script>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
<?php


//Get list of countries
$url = URL."Countries/getCountryList.json";
$countryList = \Httpful\Request::get($url)->send();
$countries = $countryList->body->countries;

//Get list of Days
$url = URL."Days/dayList.json";
$dayList = \Httpful\Request::get($url)->send();
$days = $dayList->body->days;

//Get List of Cities
$url = URL."Cities/cityList.json";
$cityList = \Httpful\Request::get($url)->send();
$cities = $cityList->body->cities;
// echo "<pre>";
// print_r($cities);

if(isset($_POST["submit"]))
{
   
    $test['Organization']['title'] = $_POST['organizationname'];
    $test['Organization']['address'] = $_POST['address'];
    $test['Organization']['phone'] = $_POST['organizationPhone'];
    $test['Organization']['fax'] = $_POST['organizationFax'];
    $test['Organization']['website'] = $_POST['organizationWebsite'];
    $test['Organization']['country_id'] = $_POST['organizationCountry'];
    $test['Organization']['city_id'] = $_POST['OrganizationCity'];
    $test['Organization']['lat'] = $_POST['organizationLat'];
    $test['Organization']['long'] = $_POST['organizationLong'];
    $test['Organization']['day_id'] = $_POST['organizationDay'];

     $test['Organization']['logo'] = array( 'name'=> $_FILES['logo']['name'],
    'type'=> $_FILES['logo']['type'],
    'tmp_name'=> $_FILES['logo']['tmp_name'],
    'error'=> $_FILES['logo']['error'],
    'size'=> $_FILES['logo']['size']
    );
     $test['User']['username'] = $_POST['username'];
    $test['User']['email'] = $_POST['email'];
    $test['User']['password'] = $_POST['password'];
    $test['User']['confirm_password'] = $_POST['rpassword'];


       //  echo "<pre>";
       // print_r($test);
       // die();
        $url = URL."Users/orgRegistration.json";

    $response = \Httpful\Request::post($url)    
        ->sendsJson()
        ->body($test) 
        ->send(); 
       //  echo "<pre>";
       // print_r($response);
       // die();
    //echo "Please wait for confirmation";
        if($response->body->output->status == '1')
           {
                $_SESSION['success']= "Thank you for registration";
               echo '<script>window.location.assign("login.php")</script>';
           }
           else{
            echo("<script>
                location.href ='".URL_VIEW."organizations/orgRegister"."';</script>");
           }
      

//print_r($response);
   
}
?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="index.html">
    <img src="<?php echo URL_VIEW; ?>admin/layout/img/logo.png" alt=""/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN REGISTRATION FORM -->
    <form class="orgReg" action="" id="OrganizationAddForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <h3>Organization Registration</h3>
        <p>
             Enter Organization details below:
        </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Name</label>
            <div class="input-icon">
                <i class="fa fa-font"></i><!-- 
                <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="fullname"/> -->
                <input name="organizationname" class="form-control placeholder-no-fix" maxlength="200" type="text" id="OrganizationTitle" placeholder="Organization Name" required="required"/>
            </div>
        </div>
        
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="email" maxlength="255" placeholder="Email" name="email" id="orgEmail"/>
            </div>
            <span id="error" class="help-block"></span>

        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Address</label>
            <div class="input-icon">
                <i class="fa fa-check"></i>
                <input name="address" maxlength="255" type="text" id="OrganizationAddress" required="required" class="form-control placeholder-no-fix" placeholder="Address" />
            </div>
        </div>
         <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Logo</label>
            <div class="input-icon">
                <input name="logo" maxlength="255" type="file" id="OrganizationLogo" required="required"  />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Phone</label>
            <div class="input-icon">
                <i class="fa fa-location-arrow"></i>
                <input class="form-control placeholder-no-fix" type="number" type="number" id="OrganizationPhone" placeholder="Contact Number" name="organizationPhone"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Fax</label>
            <div class="input-icon">
                <i class="fa fa-location-arrow"></i>
                <input class="form-control placeholder-no-fix" type="number" type="number" id="OrganizationFax" placeholder="Fax Number" name="organizationFax"/>
            </div>
        </div>
         <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Website</label>
            <div class="input-icon">
                <i class="fa fa-location-arrow"></i>
                <input class="form-control placeholder-no-fix" type="text" type="number" id="OrganizationWebsite" placeholder="Website" name="organizationWebsite"/>
            </div>
        </div>
       
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Country</label>
            <div class="input-icon">
                <i class="fa fa-location-arrow"></i>
                <select name="organizationCountry" id="OrganizationCountryId" required="required" class="form-control placeholder-no-fix">
                    <option value="default">Choose Country</option>
                    <?php foreach($countries as $key=>$country):?>
                    
                    <option value="<?php echo $key;?>"><?php echo $country;?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">City</label>
            <div class="input-icon">
                <i class="fa fa-location-arrow"></i>
                 <select name="OrganizationCity" id="cities" required="required" class="form-control placeholder-no-fix">
                    <option value="default">Select Cities</option>
                    
                </select>
            </div>
        </div>
         <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Lat</label>
            <div class="input-icon">
                <i class="fa fa-location-arrow"></i>
                <input class="form-control placeholder-no-fix" type="number" type="number" id="OrganizationLat" placeholder="lat" name="organizationLat"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Long</label>
            <div class="input-icon">
                <i class="fa fa-location-arrow"></i>
                <input class="form-control placeholder-no-fix" type="number" type="number" id="OrganizationLong" placeholder="Long" name="organizationLong"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Day</label>
            <div class="input-icon">
                <select name="organizationDay" id="OrganizationDayId" required="required" class="form-control placeholder-no-fix">
                    <?php foreach($days as $key=>$day):?>
                    
                    <option value="<?php echo $key;?>"><?php echo $day;?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <p>
             Enter Organization account details below:
        </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/>
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
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" id="rpassword" name="rpassword"/>
                </div>
            </div>
            <div id="cpassError" style="float:right; display:none; color:red;">The password did not match the original.</div>
        </div>
        <div class="form-group">
            <!-- <label>
            <input type="checkbox" name="tnc"/> I agree to the <a href="javascript:;">
            Terms of Service </a>
            and <a href="javascript:;">
            Privacy Policy </a>
            </label>
            <div id="register_tnc_error">
            </div> -->
               <div id="captcha_container"></div>
                <span id="capchaError" class="help-block"></span>
        </div>
        <div class="form-actions">
            <button id="register-back-btn" type="button" class="btn">
            <i class="m-icon-swapleft"></i> Back </button>
            <button type="submit" id="register-submit-btn" name ="submit"class="btn blue pull-right">
            Sign Up <i class="m-icon-swapright m-icon-white"></i>
            </button><!-- 
            <input  type="submit" name="submit" value="Submit" class="btn blue pull-right"/> -->
        </div>
    </form>
    <!-- END REGISTRATION FORM -->

</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
     2014 &copy; Metronic - Admin Dashboard Template.
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
 <script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : '6Lc1xwsTAAAAAC3eiLOPB7qfCprUeK2cNkAU8VHv'
        });
      };
    </script>

<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
    
    $(document).ready(function(){
        $("#OrganizationCountryId").on('change',function(){
            //alert('hello');
            var data;
            var country=$(this).val();
          // alert(country);


            $.ajax({
                 url: "<?php echo URL_VIEW."process.php";?>",
                data: "action=getCountryCity&countryID="+country,
                type: "post",
                success:function(response){
                    //console.log(response);
                    var cities = JSON.parse(response);
                     $.each(cities, function(key,obj){
                               data+= "<option value=" + key + ">" + obj + "</option>";
                           });
                           $("#cities").html(data);
                            if(jQuery.isEmptyObject(cities))
                            {
                                
                                data = "<option value=''>Select city</option>";
                                $("#cities").html(data);
                            }
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
var captchaSubmit = false;

var loadCaptcha = function() {
      captchaContainer = grecaptcha.render('captcha_container', {
        'sitekey' : '6LdFtgsTAAAAAHvYyC_SxXyr0jYmbxOrb9LTlTuo',
        'callback' : function(response) {
            if(response == null){
                alert('false');
            }
            else{
                var capError = $("#capchaError");
                capError.css("display", "none");
                captchaSubmit = true;
            }
          console.log(response);
        }
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


 function checkEmail(email)
{

            //var valid;
             var urli = '<?php echo URL."Users/checkUniqueEmail.json";?>';
            

                 $.ajax({
                          url:urli,
                          type:'post',
                          data:'email='+email,
                          success:function(response)
                                               {
                                                    var status = response.output.status;
                                                    var error = $("#error");
                                                    var capchaerror = $("#capchaError");
                                                   // loader.css("display","none");

                                                    if(status === 1){
                                                       // error.css("display", "block");
                                                      // error.html("The email is already in use.").css("color", "red");
                                                       //$(email).closest('.form-group').removeClass('has-success');
                                                        //$(email).closest('.form-group').addClass('has-error');
                                                        var errors = { email: "The email is already in use." };
                                                        $validator.showErrors(errors);
                                                        valid = false;

                                                        return false;
                                                    }else{

                                                        
                                                        valid = true;

                                                       


                                                    }
                                               }
                     });
             


}


$validator =  $(".orgReg").validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    
                    organizationname: {
                        required: true
                    },
                    orgEmail: {
                        required: true
                    },
                    OrganizationAddress: {
                        required: true
                    },
                    organizationPhone:{
                        required: true
                    },
                    organizationFax:{
                        required:true
                    },
                    
                    organizationCountry:{
                        required:true
                    },
                    OrganizationCity:{
                        required:true
                    },
                    
                    username:{
                        required:true
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
                        console.log(valid);
                        console.log(captchaSubmit);
                       // form.submit();
                       if(valid === true && captchaSubmit === true)
                    {
                       
                         form.submit();
                    }
                    else
                    {
                        if(captchaSubmit === false){
                        var capchaerror = $("#capchaError");
                        capchaerror.css("display", "block");
                        capchaerror.html("Capcha is required.").css("color", "red");
                        }
                        else if(valid === false){
                        var errors = { email: "The email is already in use." };
                        $validator.showErrors(errors);
                        }
                        else{
                            var capchaerror = $("#capchaError");
                            capchaerror.css("display", "block");
                            capchaerror.html("Capcha is required.").css("color", "red");
                            var errors = { email: "The email is already in use." };
                            $validator.showErrors(errors);
                        }

                    }
                    
                }


            });
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIuoU0w1H1peZGucqAzVwBFrfwbYaUPD8&libraries=places"> </script>
<script type="text/javascript">
     function initialize() {
         var searchbox = new google.maps.places.SearchBox(document.getElementById("OrganizationAddress"));
         google.maps.event.addListener(searchbox, 'places_changed', function () {
             var placeDetail = searchbox.getPlaces();
             var location = placeDetail[0]['geometry']['location'];
             document.getElementById("OrganizationLat").value=location['G'];
             document.getElementById("OrganizationLong").value=location['K'];
         });
     }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
