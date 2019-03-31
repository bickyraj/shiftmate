<?php


$orgId = $_GET['org_id'];
$homeEmployee = URL_VIEW.'organizationUsers/listOrganizationEmployees?org_id='.$orgId;
//print_r($orgId);
//Get list of countries
$url = URL . "Countries/getCountryList.json";
$countryList = \Httpful\Request::get($url)->send();
$countries = $countryList->body->countries;

//Get List of Cities
$url = URL . "Cities/cityList.json";
$cityList = \Httpful\Request::get($url)->send();
$cities = $cityList->body->cities;

$url = URL . "Organizationroles/orgRoleList/".$orgId.".json";
$orgRole = \Httpful\Request::get($url)->send();
$orgRoleList = $orgRole->body->orgRoleList;

// fal($orgRoleList);

$url = URL . "Branches/BranchesList/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;
// echo "<pre

$url = URL . "Groups/listGroup/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$groups = $data->body;
// echo "<pre>";
// print_r($groups);
// die();








// print_r($branches);
// die();

if (isset($_POST["submit"])) {
    
    // if($_POST['data1']['review1']['period'] == "Days"){
    //     $_POST['data']['OrganizationUser'][0]['reviewperiod']= $_POST['data1']['review1']['value']."D";
    // }elseif($_POST['data1']['review1']['period'] == "Weeks"){
    //     $_POST['data']['OrganizationUser'][0]['reviewperiod']= ($_POST['data1']['review1']['value']*7)."D";
    // }elseif($_POST['data1']['review1']['period'] == "Months"){
    //     $_POST['data']['OrganizationUser'][0]['reviewperiod']= $_POST['data1']['review1']['value']."M";
    // }elseif($_POST['data1']['review1']['period'] == "Years"){
    //     $_POST['data']['OrganizationUser'][0]['reviewperiod']= $_POST['data1']['review1']['value']."Y";
    // }

// $date = new DateTime();
// $date->add(new DateInterval('P'.$_POST['data']['OrganizationUser'][0]['reviewperiod']));
// $_POST['data']['OrganizationUser'][0]['reviewdate'] = $date->format('Y-m-d');

    $url = URL . "Users/employeeRegistrationByOrg/".$orgId.".json";
    $response = \Httpful\Request::post($url)
    ->sendsJson()
    ->body($_POST['data'])
    ->send();

    // echo "<pre>";
    // print_r($response);
    // die();



   if(isset($response->body->output->status) && $response->body->output->status == '1')
    {
        
        $_SESSION['success']="success";
        echo("<script>location.href = '".URL_VIEW."organizationUsers/listOrganizationEmployees;</script>");
    }

    else
    {
        $_SESSION['fail']= 'fail';


    }
}
?>


<!-- Edit -->    
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>Add New Employee <small> Add New Employee</small></h1>
		</div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo URL_VIEW; ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo $homeEmployee; ?>">Employee</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:;">Add New Employee</a>
            </li>
        </ul>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <!-- BEGIN VALIDATION STATES-->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Employee Details</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-fit-height green dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                                Actions <i class="fa fa-angle-down"></i>
                            </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                   <!--  <li>
                                        <a class="active" href="<?php echo URL_VIEW;?>employees/employeeRegistrationByOrg?org_id=<?php echo $orgId;?>">Add new employee</a>
                                    </li> -->
                                    <li>
                                        <a href="<?php echo URL_VIEW;?>organizationUsers/assignEmployeeToOrganization?org_id=<?php echo $orgId;?>"><i class="fa fa-plus"></i> Add existing employee</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo URL_VIEW;?>users/requestEmployeeToOrganization?org_id=<?php echo $orgId;?>"><i class="fa fa-send (alias)"></i> Send Request</a>
                                    </li>
                                </ul>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="" id="OrganizationUserAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                            <div style="display:none;">
                                <input type="hidden" name="_method" value="POST"/>
                            </div>
                            <div class="form-body">
                                <div class="row">
                                    
                                    <div class="col-md-6" style="border-right: 1px solid #EEEEEE;">
                                        <h3 class="form-section">User Details</h3>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">First Name <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" name="data[User][fname]" maxlength="200" id="UserFname" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Last Name <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" name="data[User][lname]" maxlength="200" id="UserLname" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Username <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control" name="data[User][username]" maxlength="200" type="text" id="UserUsername" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Password <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input name="data[User][password]" class="form-control" minlength="6" maxlength="200" type="password" id="UserPassword" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Confirm Password <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input name="data[User][confirm_password]" maxlength="200" type="password" id="confirmPassword" class="form-control" required/>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <div id="cpassError" style="float:right; display:none; color:red;">The password did not match the original.</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Email <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input name="data[User][email]" class="form-control" maxlength="200" type="email" id="UserEmail" required/>
                                            </div>
                                        </div>
                                         <div>
                                            <div class="loader" style="display:none;"><img src="<?php echo URL_IMAGE.'ajax-loader.gif';?>" /></div>
                                                <i id="error" style="display:none; float:right;"></i>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Date Of Birth <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-append date" id="dp3" data-date="12-02-2015" data-date-format="yyyy-mm-dd">

                                                    <input id="UserDob" class="form-control form-control-inline date-picker" name="data[User][dob]" size="16" type="text" value="" data-date-format="yyyy-mm-dd" required/>
                                                  <div class="add-on" style="cursor:pointer;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Phone <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input name="data[User][phone]" min="1" maxlength="200" type="number" id="UserPhone" class="form-control" required/>
                                            </div>
                                        </div>

                                        <input type="hidden" name="data[User][country_id]" value="2">
                                        <input type="hidden" name="data[User][city_id]" value="0">

                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Sub urb <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input name="data[User][address]" onFocus="geolocate()" id="autocomplete" maxlength="200" type="text" class="form-control" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Postal Code <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control"  name="data[User][zipcode]" id="postal_code" min="1" maxlength="200" type="number" required/>
                                            </div>
                                        </div>

                                        

                                        <div class="form-group">
                                            <label class="control-label col-md-4">State <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control" name="data[User][state]" maxlength="200" type="text" id="administrative_area_level_1" required/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        
                                        <h3 class="form-section">Organisation User Detail</h3>

                                        <div class="form-group">
                                                <label class="control-label col-md-4">Branch <span class="required">
                                                * </span>
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control" name="data[OrganizationUser][0][branch_id]" id="OrganizationUserBranchId" required>
                                                        <?php foreach ($branches as $key => $branch): ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $branch; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="control-label col-md-4">Groups <span class="required">
                                                * </span>
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control" name="data[OrganizationUser][0][group_id]" id="OrganizationUserBranchId" required>
                                                        <?php foreach ($groups as  $group): ?>
                                                        <option value="<?php echo $group->Group->id; ?>"><?php echo $group->Group->title; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="control-label col-md-4">Organisation Role <span class="required">
                                                * </span>
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control" name="data[OrganizationUser][0][organizationrole_id]" id="OrganizationUserOrganizationroleId" required>
                                                            <?php foreach ($orgRoleList as $key => $role): ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $role; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Designation <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <select class="form-control" name="data[OrganizationUser][0][designation]" maxlength="200"  id="OrganizationUserDesignation" required>
                                                    <option selected disabled>--Select One--</option>
                                                    <option value="Owner/General Manager">Owner/General Manager</option>
                                                    <option value="Manager">Manager</option>
                                                    <option value="Supervisor">Supervisor</option>
                                                    <option value="Leading Hand">Leading Hand</option>
                                                    <option value="Employee">Employee</option>
                                                    <option value="Junior Employee">Junior Employee</option>
                                                    <option value="Tradesman">Tradesman</option>
                                                    <option value="Apprentice">Apprentice</option>
                                                 </select>   
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Hire Date <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
                                                <input id="OrganizationUserHireDate" class="form-control form-control-inline date-picker" name="data[OrganizationUser][0][hire_date]" size="16" type="text" value="" data-date-format="yyyy-mm-dd"/>

                                                  <!-- <input class="form-control" name="data[OrganizationUser][0][hire_date]" id="OrganizationUserHireDate" class="span2" size="16" type="text" value=""/> -->
                                                  <div class="add-on" style="cursor:pointer;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Wage Per Hour <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control" min="1" name="data[OrganizationUser][0][wage]" type="number" id="OrganizationUserWage" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Max Weekly Hour <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control" name="data[OrganizationUser][0][max_weekly_hour]" type="number" id="OrganizationUserMaxWeeklyHour" min="1" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Skills<span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control" name="data[OrganizationUser][0][skills]" type="text" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="control-label col-md-4">Employee Type <span class="required">
                                                * </span>
                                                </label>
                                                <div class="col-md-7">
                                                    <select class="form-control" name="data[OrganizationUser][0][employee_status]" id="OrganizationUserStatus" required>
                                                        <option value="1">Permanent</option>
                                                        <option value="0">Temporary</option>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="control-label col-md-4">Review  Period <span class="required">
                                                * </span>
                                                </label>
                                                <div class="col-md-7 form-inline">
                                                    <input class="form-control col-md-6" type="number" min="1" name="data[OrganizationUser][0][reviewperiod]" required=""/>
                                                    <select class="form-control col-md-6" name="data[OrganizationUser][0][reviewtype]">
                                                    
                                                        <option value="Weeks">Weeks</option>
                                                        <option value="Months">Months</option>
                                                        <option value="Years">Years</option>
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                    <input id="addEmployeSubmit"  type="submit" name="submit" value="Submit" class="btn green pull-right"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
                <!-- END VALIDATION STATES-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#UserCountryId').on('change',function(){
        var countryId = $(this).val();
        var data;
        //console.log(countryId);
        //alert(countryId);
        $.ajax({
             url: "<?php echo URL_VIEW."process.php";?>",
                data: "action=getCountryCity&countryID="+countryId,
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
$(function()
{

    $("#confirmPassword").blur(function(e)
        {

            var cpassError = $("#cpassError");

            if($("#UserPassword").val() != $("#confirmPassword").val())
            {
                cpassError.css("display", "block");
            }else
            {
                cpassError.css("display", "none");
            }

        });

    function checkEmail(email)
    {

                var valid;
                 var urli = '<?php echo URL."Users/checkUniqueEmail.json";?>';
                 var loader = $(".loader");
                 var error = $("#error");
                 error.css("display", "none");

                 

                 if(email === "" || valid === true)
                 {

                 }

                else
                {

                    loader.css("display", "block");

                     $.ajax({
                              url:urli,
                              async:"false",
                              type:'post',
                              data:'email='+email,
                              success:function(response)
                                                   {
                                                        var status = response.output.status;
                                                        loader.css("display","none");

                                                        if(status === 1){
                                                            error.css("display", "block");
                                                            error.html("The email is already in use.").css("color", "red");

                                                            valid = false;

                                                            return false;
                                                        }else{
                                                            error.css("display", "block");
                                                            error.html("valid email.").css("color", "green");
                                                            $('#OrganizationUserAddForm').unbind('submit');
                                                            // $('#OrganizationUserAddForm').submit();
                                                            $("#addEmployeSubmit").click();


                                                        }
                                                   }
                         });
                }


    }


    $("#OrganizationUserAddForm").on('submit', function(e)
        {
            $(this).find('input[type="submit"]').click();
            var conPass;
            var cpassError = $("#cpassError");

            if($("#UserPassword").val() != $("#confirmPassword").val())
            {
                cpassError.css("display", "block");
                conPass = false;
            }else
            {
                cpassError.css("display", "none");
                conPass = true;
            }

            var email = $("#UserEmail").val();

            if(conPass === false)
            {
                console.log('false');
                return false;
            }
            else
            {
                e.preventDefault();
                console.log("true");
                checkEmail(email);
                
            }

        });
    function validateEmail(email) {
                                var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                                return re.test(email);
                            }

    $("#UserEmail").blur(function()
        {

            var email = $(this).val();
            var validEmail = validateEmail(email);

            var urli = '<?php echo URL."Users/checkUniqueEmail.json";?>';
             var loader = $(".loader");
             var error = $("#error");

             error.css("display", "none");

             if(email === "" || validEmail==false)
             {
                error.css("display", "block");
                error.html("Invalid email.").css("color", "red");
             }

             else
             {
                loader.css("display", "block");

                 $.ajax({
                          url:urli,
                          type:'post',
                          data:'email='+email,
                          success:function(response)
                                               {
                                                    var status = response.output.status;
                                                    

                                                    loader.css("display","none");

                                                    if(status === 1){
                                                        error.css("display", "block");
                                                        error.html("The email is already in use.").css("color", "red");
                                                    }else{

                                                        error.css("display", "block");
                                                        error.html("valid email.").css("color", "green");
                                                    }
                                               }
                     });
             }

        });



});
$(function()
    {
        $(".date-picker").datepicker();
    });
</script>

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
  postal_code: 'long_name'
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

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];

    console.log(addressType);
    if(addressType == "locality" || addressType == "route")
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
