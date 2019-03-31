<link href="<?php echo URL_VIEW;?>admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?php echo URL_VIEW;?>crop-avatar/css/cropper.min.css">
<link rel="stylesheet" href="<?php echo URL_VIEW;?>crop-avatar/css/main.css">
<?php
$orgId = $_GET['org_id'];
$orgProfile = URL_VIEW.'organizations/organizationProfile?org_id='.$orgId;
if(isset($_POST["submit"]))
{

  if(isset($_POST['avatar_data'])){
    $avatar_data = json_decode($_POST['avatar_data']);
  }

  $_POST['data']['Organization']['logo'] = array( 'name'=> $_FILES['logo']['name'],
            'type'=> $_FILES['logo']['type'],
            'tmp_name'=> $_FILES['logo']['tmp_name'],
            'error'=> $_FILES['logo']['error'],
            'size'=> $_FILES['logo']['size'],
            'x' => $avatar_data->x,
            'y' => $avatar_data->y,
            'srcW' => $avatar_data->width,
            'srcH' => $avatar_data->height
            );
        $url = URL."Organizations/orgEdit/".$orgId.".json";
        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();

  if(isset($response->body->output->status)){       
    if($response->body->output->status == 1){
      $imagesaveSuccess = 1;
        ?>
        <script type="text/javascript">toastr.success("Organisation logo changed Successfully.");</script>
        <?php
    }
  }  
}
if (isset($_POST["submitOrganizationInfo"])) {
        $url = URL . "Organizations/orgEdit/".$orgId.".json";
        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();
         if($response->body->output->status == 1)
                {
                     echo '<script>
                            toastr.success("Information Changed Successfully");
                    </script>';
                   
                }
                 else
                {

                     echo '<script>
                            toastr.info("Something Went Wrong");
                    </script>';
                   
                }
    }

if (isset($_POST["changePassword"])) {
   
    $url = URL . "Organizations/changePassword/".$orgId.".json";
    $response = \Httpful\Request::post($url)
    ->sendsJson()
    ->body($_POST['data'])
    ->send();
    if($response->body->output->status == 1)
                {
                     echo '<script>
                            toastr.success("Password Changed Successfully");
                    </script>';
                   
                }
                 else
                {

                     echo '<script>
                            toastr.info("Old password mismatch.");
                    </script>';
                   
                }
                
    }

$url = URL."Organizations/orgEdit/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$organization = $data->body->organizations;


$url_head = URL."Tasks/taskCount/".$organization->Organization->user_id.".json";
$taskCount = \Httpful\Request::get($url_head)->send();
$taskCounts = $taskCount->body->taskCount;

$url_head = URL."Messages/messageCount/".$organization->Organization->user_id."/".'received'.".json";
$messageCount = \Httpful\Request::get($url_head)->send();
$receivedMessage = $messageCount->body->receivedMessage;

//get userId using org Id.
$url = URL . "Organizations/getOrgIdFromUserId/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$orgId = $data->body->orgId;


//Get list of countries
$url = URL."Countries/getCountryList.json";
$countryList = \Httpful\Request::get($url)->send();
$countries = $countryList->body->countries;

// echo "<pre>";
// print_r($countries);
// die();

//Get list of Days
$url = URL."Days/dayList.json";
$dayList = \Httpful\Request::get($url)->send();
$days = $dayList->body->days;

//Get List of Cities
$url = URL."Cities/cityList/".$organization->Country->id.".json";
$cityList = \Httpful\Request::get($url)->send();
$cities = $cityList->body->cities;

      
$orgimage = URL.'webroot/files/organization/logo/'.$organization->Organization->logo_dir.'/thumb_'.$organization->Organization->logo;
$image = $organization->Organization->logo;
$gender = $organization->User->gender;

$organizationImage = imageGenerate($orgimage,$image,$gender);

// fal($image);


?>
<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Organisation <small>Edit</small></h1>
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
                    <a href="<?php echo $orgProfile; ?>">Organisation Profile</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">Edit Profile</a>
                </li>
            </ul>
<!-- Edit Profile-->
<div class="row margin-top-20">
    <div class="col-md-12">
    <!-- BEGIN PROFILE SIDEBAR -->
    <div class="profile-sidebar">
        <!-- PORTLET MAIN -->
        <div class="portlet light profile-sidebar-portlet">
            <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                 
                     <img src="<?php echo $organizationImage; ?>" alt="image not found" class="img-responsive" />
                 
                </div>
            <!-- END SIDEBAR USERPIC -->

            <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        <?php echo $organization->Organization->title; ?>
                    </div>
                    <!-- <div class="profile-usertitle-job">
                        Developer
                    </div> -->
                </div>
            <!-- END SIDEBAR USER TITLE -->

            <!-- SIDEBAR BUTTONS -->
                <!-- <div class="profile-userbuttons">
                    <button type="button" class="btn btn-circle green-haze btn-sm">Follow</button>
                    <button type="button" class="btn btn-circle btn-danger btn-sm">Message</button>
                </div> -->
            <!-- END SIDEBAR BUTTONS -->

            <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li>
                            <a href="<?php echo URL_VIEW.'organizations/organizationProfile?org_id='.$organization->Organization->id;?>">
                            <i class="icon-home"></i>
                            Overview </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo URL_VIEW; ?>tasks/listTask">
                              <?php if ($taskCounts) { ?>
                                <i class="icon-check"></i>
                              Tasks <?php echo $taskCounts; ?>
                              <?php } else { ?>
                              <i class="icon-check"></i>
                              Tasks
                              <?php  }?>
                              
                            </a>
                        </li>
                       
                    </ul>
                </div>
            <!-- END MENU -->
        </div>
        <!-- END PORTLET MAIN -->

        <!-- PORTLET MAIN -->
        
        <!-- END PORTLET MAIN -->
    </div>
    <!-- END BEGIN PROFILE SIDEBAR -->

    <!-- BEGIN PROFILE CONTENT -->
    <div class="profile-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe theme-font hide"></i>
                            <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                        </div>

                        <ul class="nav nav-tabs">
                            <li class="<?php echo (isset($imagesaveSuccess))?'':'active';?>">
                                <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                            </li>
                            <li class="<?php echo (isset($imagesaveSuccess))?'active':'';?>">
                                <a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
                            </li>
                            <li>
                                <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                            </li>
                            <!-- <li>
                                <a href="#tab_1_4" data-toggle="tab">Privacy Settings</a>
                            </li> -->
                        </ul>
                    </div>

                    <div class="portlet-body">
                        <div class="tab-content">
                        <!-- PERSONAL INFO TAB -->
                            <div class="tab-pane <?php echo (isset($imagesaveSuccess))?'':'active';?>" id="tab_1_1">
                                <form action="" id="OrganizationAddForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                <div style="display:none;">
                                    <input type="hidden" name="_method" value="POST"/>
                                   
                                    <input type="hidden" name="data[Organization][id]" value="<?php echo $organization->Organization->id;?>"/>
                                </div>
                                    <div class="form-group">
                                        <label class="control-label">Organisation Name</label>
                                        <input type="text" class="form-control" name="data[Organization][title]" value="<?php echo $organization->Organization->title;?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Address</label>
                                        <input type="text" class="form-control" id="OrganizationAddress" name="data[Organization][address]" value="<?php echo $organization->Organization->address;?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Phone</label>
                                        <input type="text"class="form-control" name="data[Organization][phone]" value="<?php echo $organization->Organization->phone;?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="text"class="form-control" name="data[Organization][email]" value="<?php echo $organization->Organization->email;?>" disabled/>
                                    </div>
                                     <div class="form-group">
                                        <label class="control-label">Website</label>
                                        <input type="text"class="form-control" name="data[Organization][website]" value="<?php echo $organization->Organization->website;?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Fax</label>
                                        <input type="text"class="form-control" name="data[Organization][fax]" value="<?php echo $organization->Organization->fax;?>"/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label">Country</label>
                                        <select name="data[Organization][country_id]" class="form-control">
                                        <?php foreach($countries as $key=>$country):?>

                                        <option value="<?php echo $key;?>" <?php echo ($organization->Organization->country_id == $key)? 'selected="selected"':'';?>><?php echo $country;?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <select name="data[Organization][city_id]" class="form-control">
                                        <?php foreach($cities as $key=>$city):?>
                
                                        <option value="<?php echo $key;?>" <?php echo ($organization->Organization->city_id == $key)? 'selected="selected"':'';?>><?php echo $city;?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                       <!-- <label class="control-label">Lat</label> -->
                                        <input type="hidden" class="form-control" id="OrganizationLat" name="data[Organization][lat]" value="<?php echo $organization->Organization->lat;?>"/>
                                    </div>
                                    <div class="form-group">
<!--                                        <label class="control-label">Long</label> -->
                                        <input type="hidden" class="form-control" id="OrganizationLong" name="data[Organization][long]" value="<?php echo $organization->Organization->long;?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Day</label>
                                        <select name="data[Organization][day_id]" class="form-control">
                                        <?php foreach($days as $key=>$day):?>
                
                                        <option value="<?php echo $key;?>" <?php echo ($organization->Organization->day_id == $key)? 'selected="selected"':'';?>><?php echo $day;?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="margiv-top-10">
                                        <input type="submit" name="submitOrganizationInfo" value="Change Information" class="btn default"  >
                                       <input type="reset" name="cancel" value="Cancel" class="btn default"  >
                                    </div>
                                </form>
                            </div>
                        <!-- END PERSONAL INFO TAB -->
                        <!-- CHANGE AVATAR TAB -->
                        <div class="tab-pane <?php echo (isset($imagesaveSuccess))?'active':'';?>" id="tab_1_2">
                           <!--  <p>
                                 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                            </p> -->
                            <div class="container" id="crop-avatar">
                             <form action="" method="POST" role="form" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="hidden" name="data[Organization][id]" value="<?php echo $organization->Organization->id;?>"/>
                                    <input type="hidden" name="data[Organization][logo_dir]" value="<?php echo $organization->Organization->logo_dir; ?>" />
                             
                                </div>

                                <div class="avatar-view fileinput-new thumbnail" title="Change Avatar" style="width: 200px; height: 200px;">
                                           <img src="<?php echo $orgimage; ?>" alt="no image found" class="img-responsive">
                                            <input type="hidden" id="namePicInput" name="avatar"/>
                                        </div>

                                        <div class="avatar-view">
                                          <a class="btn btn-success">Upload</a>
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
                  <label for="avatarInput">Upload Image :</label>
                  <input type="file" class="avatar-input" id="avatarInput" name="logo">
                </div>

                <!-- Crop and preview -->
                <div class="row">
                  <div class="col-md-9">
                    <div class="avatar-wrapper"></div>
                  </div>
                  <div class="col-md-3">
                    <div class="avatar-preview preview-lg"></div>
                    <div class="avatar-preview preview-md"></div>
                    <div class="avatar-preview preview-sm"></div>
                  </div>
                </div>

                <div class="row avatar-btns">
                  <!-- <div class="col-md-9">
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
                    <button type="submit" id="done" name="submit" class="btn btn-primary btn-block avatar-save">Done</button>
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
                        </div>
                        </div>
                        <!-- END CHANGE AVATAR TAB -->
                        <!-- CHANGE PASSWORD TAB -->
                        <div class="tab-pane" id="tab_1_3">
                            <form action="" method="POST" role="form" id="frmchangepassword">
                                <div class="form-group">
                                    <label class="control-label">Current Password</label>
                                    <input type="password" class="form-control" name="data[User][old_password]"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">New Password</label>
                                    <input type="password" class="form-control" name="data[User][password]"/>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Re-type New Password</label>
                                    <input type="password" class="form-control" name="data[User][confirm_password]"/>
                                </div>
                                <div class="margin-top-10">
                                    <input type="submit" name="changePassword" value="Change password" class="btn default">
                                    <input type="reset" value="Cancel" class="btn default">
                                    
                                </div>
                            </form>
                        </div>
                        <!-- END CHANGE PASSWORD TAB -->
                        <!-- PRIVACY SETTINGS TAB -->
                        <div class="tab-pane" id="tab_1_4">
                            <form action="#">
                                <table class="table table-light table-hover">
                                <tr>
                                    <td>
                                         Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus..
                                    </td>
                                    <td>
                                        <label class="uniform-inline">
                                        <input type="radio" name="optionsRadios1" value="option1"/>
                                        Yes </label>
                                        <label class="uniform-inline">
                                        <input type="radio" name="optionsRadios1" value="option2" checked/>
                                        No </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                         Enim eiusmod high life accusamus terry richardson ad squid wolf moon
                                    </td>
                                    <td>
                                        <label class="uniform-inline">
                                        <input type="checkbox" value=""/> Yes </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                         Enim eiusmod high life accusamus terry richardson ad squid wolf moon
                                    </td>
                                    <td>
                                        <label class="uniform-inline">
                                        <input type="checkbox" value=""/> Yes </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                         Enim eiusmod high life accusamus terry richardson ad squid wolf moon
                                    </td>
                                    <td>
                                        <label class="uniform-inline">
                                        <input type="checkbox" value=""/> Yes </label>
                                    </td>
                                </tr>
                                </table>
                                <!--end profile-settings-->
                                <div class="margin-top-10">
                                    <a href="javascript:;" class="btn green-haze">
                                    Save Changes </a>
                                    <a href="javascript:;" class="btn default">
                                    Cancel </a>
                                </div>
                            </form>
                        </div>
                        <!-- END PRIVACY SETTINGS TAB -->
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PROFILE CONTENT -->
    </div>
</div>
<!-- End Edit Profile-->

</div>
</div>
<script>
    $.getJSON( "<?php echo URL_VIEW;?>Countries/getCountryList.json", { countryId: "1" } )
.done(function( json ) {
console.log( json );

})

});
</script>

<script src="<?php echo URL_VIEW;?>crop-avatar/js/cropper.min.js"></script>
<script src="<?php echo URL_VIEW;?>crop-avatar/js/main.js"></script>

<script src="<?php echo URL_VIEW; ?>global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/profile.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {       
   
Profile.init(); // init page demo
});
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-37564768-1', 'keenthemes.com');
  ga('send', 'pageview');
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIuoU0w1H1peZGucqAzVwBFrfwbYaUPD8&libraries=places"> </script>
<script type="text/javascript">
     function initialize() {
         var searchbox = new google.maps.places.SearchBox(document.getElementById("OrganizationAddress"));
         google.maps.event.addListener(searchbox, 'places_changed', function () {
             var placeDetail = searchbox.getPlaces();
             var location = placeDetail[0]['geometry']['location'];
             document.getElementById("OrganizationLat").value=location.lat();
             document.getElementById("OrganizationLong").value=location.lng();
         });
     }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>