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

<script src='https://www.google.com/recaptcha/api.js'></script>

<link rel="stylesheet" href="<?php echo URL_VIEW;?>crop-avatar/css/cropper.min.css">
<link rel="stylesheet" href="<?php echo URL_VIEW;?>crop-avatar/css/main.css">

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
    $test['Organization']['country_id'] = 2;
    $test['Organization']['city_id'] = 0;
    $test['Organization']['lat'] = $_POST['organizationLat'];
    $test['Organization']['long'] = $_POST['organizationLong'];
    $test['Organization']['day_id'] = $_POST['organizationDay'];

    $avatar_data = json_decode($_POST['avatar_data']);
     $test['Organization']['logo'] = array( 'name'=> $_FILES['logo']['name'],
            'type'=> $_FILES['logo']['type'],
            'tmp_name'=> $_FILES['logo']['tmp_name'],
            'error'=> $_FILES['logo']['error'],
            'size'=> $_FILES['logo']['size'],
            'x' => $avatar_data->x,
            'y' => $avatar_data->y,
            'srcW' => $avatar_data->width,
            'srcH' => $avatar_data->height
            );
     $test['User']['username'] = $_POST['username'];
    $test['User']['email'] = $_POST['email'];
    $test['User']['password'] = $_POST['password'];
    $test['User']['confirm_password'] = $_POST['rpassword'];


    // fal($test);
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
                $_SESSION['success']= "Thank you for registration,Please check your email for activation.";
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
    <img src="<?php echo URL_VIEW; ?>admin/layout3/img/logo.png" alt=""/>
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
<div id="crop-avatar">
    <!-- BEGIN REGISTRATION FORM -->
    <form class="orgReg" action="" id="OrganizationAddForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <h3>Organisation Registration</h3>
        <p>
             Enter Organisation details below:
        </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Organisation Titile</label>
            <div class="input-icon">
                <i class="fa fa-font"></i><!-- 
                <input class="form-control placeholder-no-fix" type="text" placeholder="Full Name" name="fullname"/> -->
                <input name="organizationname" class="form-control placeholder-no-fix" maxlength="200" type="text" id="OrganizationTitle" placeholder="Organisation Title" required/>
            </div>
        </div>
        
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input class="form-control placeholder-no-fix" type="email" maxlength="255" placeholder="Email" name="email" id="orgEmail" required="required"/>
            </div>
            <span id="error" class="help-block"></span>

        </div>
         <div class="form-group avatar-view input-icon" title="Upload Logo">
                    <label for="image">Logo</label>
                      <a class="btn btn-success">Choose Image</a>
                    <input type="hidden" id="namePicInput" name="avatar"/>
                </div>

        <div class="avatar-modal" id="chooseImage" style="display:none;">
        <div class="avatar-preview preview-lg"></div>
    </div><br>
                
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Phone</label>
            <div class="input-icon">
                <i class="fa fa-phone"></i>
                <input class="form-control placeholder-no-fix" type="number" type="text" id="OrganizationPhone" placeholder="Contact Number" name="organizationPhone"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Fax</label>
            <div class="input-icon">
                <i class="fa fa-fax"></i>
                <input class="form-control placeholder-no-fix" type="number" min="0" id="OrganizationFax" placeholder="Fax Number" name="organizationFax"/>
            </div>
        </div>
         <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Website</label>
            <div class="input-icon">
                <i class="fa fa-external-link"></i>
                <input class="form-control placeholder-no-fix" type="text" id="OrganizationWebsite" placeholder="Website" name="organizationWebsite"/>
            </div>
        </div>
            <p><small>Example: https://website.com</small></p>
            <br/>

        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Sub Urb</label>
            <div class="input-icon">
                <i class="fa fa-bars"></i>
                <input name="address" maxlength="255" type="text" id="autocomplete" required class="form-control placeholder-no-fix" placeholder="Enter your Suburb" />
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon">
                <label class="control-label visible-ie8 visible-ie9">State</label>
                <!-- <i class="fa fa-map-marker"></i> -->
                    <input class="form-control placeholder-no-fix" type="hidden" id="administrative_area_level_1" name="employeeAddress" placeholder="Enter your state" />
            </div>
        </div>
        <!--  -->
         <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Lat</label>
            <div class="input-icon">
                <!-- <i class="fa fa-location-arrow"></i> -->
                <input class="form-control placeholder-no-fix" type="hidden" type="number" id="OrganizationLat" placeholder="lat" name="organizationLat"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Long</label>
            <div class="input-icon">
                <!-- <i class="fa fa-location-arrow"></i> -->
                <input class="form-control placeholder-no-fix" type="hidden" type="number" id="OrganizationLong" placeholder="Long" name="organizationLong"/>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Day</label>
            <div class="input-icon">
                <i class="fa fa-calendar"></i>
                <select name="organizationDay" id="OrganizationDayId" required="required" class="form-control placeholder-no-fix">
                    <option value="default" selected disabled>Week Start Day</option>
                    <?php foreach($days as $key=>$day):?>
                    <option value="<?php echo $key;?>"><?php echo $day;?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <p>
             Enter Organisation account details below:
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
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" minlength="6" placeholder="Password" name="password"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
            <div class="controls">
                <div class="input-icon">
                    <i class="fa fa-check"></i>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" minlength="6" placeholder="Re-type Your Password" id="rpassword" name="rpassword"/>
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
               <!-- <div id="captcha_container"></div>
                <span id="capchaError" class="help-block"></span> -->
                <div class="g-recaptcha" data-sitekey="6LdFtgsTAAAAAHvYyC_SxXyr0jYmbxOrb9LTlTuo"></div>
                <i id="capError" style="display:none; float:right;"></i>
                <span id="capchaError" class="help-block"></span>
        </div>
        <div class="form-actions">
            <a href="<?php echo URL_VIEW;?>"><button id="register-back-btn" type="button" class="btn">
            <i class="m-icon-swapleft"></i> Back</button></a>
            <button type="submit" id="register-submit-btn" name ="submit" class="btn blue pull-right">
            Sign Up <i class="m-icon-swapright m-icon-white"></i>
            </button><!-- 
            <input  type="submit" name="submit" value="Submit" class="btn blue pull-right"/> -->
        </div>


         <div class="modal fade avatar-modal" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!-- <form class="avatar-form" action="<?php echo URL_VIEW; ?>employees/crop.php" enctype="multipart/form-data" method="post"> -->
            <div class="avatar-form">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
            </div>
            <div class="modal-body">
              <div class="avatar-body">

                <!-- Upload image and data -->
                <div class="avatar-upload">
                  <input type="hidden" class="avatar-src" name="avatar_src">
                  <input type="hidden" class="avatar-data" name="avatar_data">
                  <label for="avatarInput">Local upload</label>
                  <input type="file" class="avatar-input" id="avatarInput" name="logo">
                </div>

                <!-- Crop and preview -->
                <div class="row">
                  <div class="col-md-9">
                    <div class="avatar-wrapper"></div>
                  </div>
                  <div class="col-md-3 imageBlock">
                    <div class="avatar-preview preview-lg"></div>
                    <div class="avatar-preview preview-md"></div>
                    <div class="avatar-preview preview-sm"></div>
                  </div>
                </div>

                <div class="row avatar-btns">
            <!--       <div class="col-md-9">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Rotate Left</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45deg</button>
                    </div>
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate Right</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45deg</button>
                    </div>
                  </div> -->
                  <div class="col-md-3">
                    <button data-dismiss="modal" id="done" name="done" class="btn btn-primary btn-block avatar-save">Done</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
          <!-- </form> -->
        </div>
        </div>
      </div>
    </div><!-- /.modal -->
    </form>
    <!-- END REGISTRATION FORM -->

</div>
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
     <div class="page-footer">
    <div class="page-footer-inner">
         Designed &amp; Developed By: <a href="#" target="_blank">OnePlatinum Technology</a>
    </div>
    <div class="scroll-to-top" style="display: block;">
        <i class="icon-arrow-up"></i>
    </div>
</div>
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


<script src="<?php echo URL_VIEW;?>crop-avatar/js/cropper.min.js"></script>
<script src="<?php echo URL_VIEW;?>crop-avatar/js/main.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIuoU0w1H1peZGucqAzVwBFrfwbYaUPD8&signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>

<script>
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;
var componentForm = {
  // street_number: 'short_name',
  // route: 'long_name',
  // locality: 'long_name',
  administrative_area_level_1: 'long_name',
  // country: 'long_name',
  // postal_code: 'short_name'
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
      {types: ['geocode'],
       componentRestrictions: {country: "AU"},
  });

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

// [START region_fillform]
function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

  console.log(place);

  var lat = place.geometry.location.lat();
  var lng = place.geometry.location.lng();
  $("#OrganizationLat").val(lat);
  $("#OrganizationLong").val(lng);

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];

    // console.log(addressType);
    if(addressType == "route")
    {
        $("#autocomplete").val(place.address_components[i].long_name);
    }

    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}
// [END region_fillform]

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
// [END region_geolocation]
</script>

<script type="text/javascript">
    //  function initialize() {
    //      var searchbox = new google.maps.places.SearchBox(document.getElementById("OrganizationAddress"));
    //      google.maps.event.addListener(searchbox, 'places_changed', function () {
    //          var placeDetail = searchbox.getPlaces();
    //          var location = placeDetail[0]['geometry']['location'];
    //         console.log(location);
    //          /*by ashok*/
    //          //document.getElementById("OrganizationLat").value=location['G'];
    //          //document.getElementById("OrganizationLong").value=location['K'];
    //          /*by rabi*/
    //          document.getElementById("OrganizationLat").value=location['H'];
    //          document.getElementById("OrganizationLong").value=location['L'];
    //      });
    //  }
    // google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script type="text/javascript">
    
    $(document).ready(function(){
         $("#OrganizationTitle").blur(function(){
            var orgTitle = $(this).val();
           
            document.getElementById('OrganizationTitle').value =  toTitleCase(orgTitle);
        });
        function toTitleCase(str)
        {
            return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
        }
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
//ar captchaSubmit = false;

// var loadCaptcha = function() {
//       captchaContainer = grecaptcha.render('captcha_container', {
//         'sitekey' : '6LdFtgsTAAAAAHvYyC_SxXyr0jYmbxOrb9LTlTuo',
//         'callback' : function(response) {
//             if(response == null){
//                 alert('false');
//             }
//             else{
//                 var capError = $("#capchaError");
//                 capError.css("display", "none");
//                 captchaSubmit = true;
//             }
//           console.log(response);
//         }
//       });
//     };

            var valid = false;
            var email = $("#orgEmail").val();
            var emailValid = false;
            $("#orgEmail").on('blur', function(event)
                {
                    var org_email = $("#orgEmail").val();

                    var validEmail = validateEmail(org_email);

                    // alert(validEmail);

                    if(validEmail===true)
                    {
                        checkEmail(org_email);
                        emailValid = true;
                    }
                    else
                    {
                        emailValid = false;
                        var errors = { email: "Please enter a valid email address." };
                        $validator.showErrors(errors);
                    }
                });

            function validateEmail(email) {
                        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                        return re.test(email);
                    }


 function checkEmail(email)
{
            //var valid;
            // var data = new Array();
            var urli = '<?php echo URL;?>Users/checkUniqueEmail/'+email+'.json';
                $.ajax({
                          url:urli,
                          dataType:'jsonp',
                            crossDomain:true,
                            async:false,
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
                    organizationWebsite:{
                        url:true
                    },
                    
                    username:{
                        required:true
                    },
                    password: {
                        required: true
                    },
                    rpassword: {
                        equalTo: "#register_password",
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
                        // console.log(valid);
                        //console.log(captchaSubmit);
                       // form.submit();
                       if(emailValid === true && valid === true && grecaptcha.getResponse() != "")
                    {  
                         form.submit();
                    } else if(emailValid === false ){
                        var errors = { email: "Please enter a valid email address." };
                        $validator.showErrors(errors);
                    }
                    else
                    {
                        if(grecaptcha.getResponse() == ""){
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
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>