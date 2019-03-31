<link href="<?php echo URL_VIEW;?>admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?php echo URL_VIEW;?>crop-avatar/css/cropper.min.css">
<link rel="stylesheet" href="<?php echo URL_VIEW;?>crop-avatar/css/main.css">
<?php
$userId = $_GET['user_id'];
if (isset($_POST["submitPersonalInfo"])) {
  $url_geo = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($_POST['data']['User']['address'])."&key=AIzaSyCIuoU0w1H1peZGucqAzVwBFrfwbYaUPD8";
           $response_geo = \Httpful\Request::get(($url_geo))->send();
        if($response_geo->body->status=="OK"){
             $location = $response_geo->body->results[0]->geometry->location;
             $_POST['data']['User']['lat']=$location->lat;
             $_POST['data']['User']['long']=$location->lng;
        }else{
            $_POST['data']['User']['lat']="-";
            $_POST['data']['User']['long']="-";
        }

    $url = URL . "Users/editUser/".$userId.".json";
    $response = \Httpful\Request::post($url)
    ->sendsJson()
    ->body($_POST['data'])
    ->send();
    }
if (isset($_POST["saveimage"])) {
    if(isset($_POST['avatar_data'])){
        $avatar_data = json_decode($_POST['avatar_data']);
    }
     $_POST['data']['User']['image'] = array( 'name'=> $_FILES['image']['name'],
            'type'=> $_FILES['image']['type'],
            'tmp_name'=> $_FILES['image']['tmp_name'],
            'error'=> $_FILES['image']['error'],
            'size'=> $_FILES['image']['size'],
            'x' => $avatar_data->x,
            'y' => $avatar_data->y,
            'srcW' => $avatar_data->width,
            'srcH' => $avatar_data->height,
            );
    $url1 = URL . "Users/editEmployeeDetail/".$userId.".json";
    $response1 = \Httpful\Request::post($url1)
                    ->sendsJson()
                    ->body($_POST['data'])
 
                    ->send();

     if(isset($response1->body->status)){       
    if($response1->body->status == 1){
        $imagesaveSuccess = 1;
        ?>

        <script type="text/javascript">toastr.info("Logo changed","Edit");</script>
        <?php
    }
  }

                    


}



if (isset($_POST['data']['User']['old_password'])) {
    $url = URL . "Users/changePassword/".$userId.".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
     if($response->body->output == 1){ ?>
        <script>
            toastr.success("Password Changed Successfully");
        </script>               
   <?php   }elseif($response->body->output == 2){ ?>
        <script>
            toastr.error("Old password mismatch");
        </script>             
   <?php }else{ ?>
        <script>
            toastr.error("Something went wrong");
        </script>                  
 <?php    }}

$url = URL."Users/editUser/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$userdetail = $data->body->users;

$orgimage = URL.'webroot/files/user/image/'.$userdetail->User->image_dir.'/thumb2_'.$userdetail->User->image;
$image = $userdetail->User->image;
$gender = $userdetail->User->gender;

$userimage = imageGenerate($orgimage,$image,$gender);

?>

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>User <small> Edit</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
            <i class="fa fa-home"></i>
                <a href="<?=URL_VIEW;?>">Home</a>
            <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?=URL_VIEW;?>users/employee/profile">My Profile</a>
            <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:;">Edit Profile</a>
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
                    <img src="<?php echo $userimage; ?>" alt="no image found" class="img-responsive">
                </div>
            <!-- END SIDEBAR USERPIC -->

            <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                       <?php echo $userdetail->User->fname.' '.$userdetail->User->lname; ?>
                    </div>
                   <!--  <div class="profile-usertitle-job">
                        Developer
                    </div> -->
                </div>
            <!-- END SIDEBAR USER TITLE -->

            <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons">
                </div>
            <!-- END SIDEBAR BUTTONS -->

            <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li>
                            <a href="<?php echo URL_VIEW;?>users/employee/profile">
                            <i class="icon-home"></i>
                            Overview </a>
                        </li>
                       <!--  <li class="active">
                            <a href="extra_profile_account.html">
                            <i class="icon-settings"></i>
                            Account Settings </a>
                        </li> -->
                        <li>
                            <a href="<?php echo URL_VIEW;?>tasks/listTask">
                            <i class="icon-check"></i>
                            Tasks </a>
                        </li>
                       <!--  <li>
                            <a href="extra_profile_help.html">
                            <i class="icon-info"></i>
                            Help </a>
                        </li> -->
                    </ul>
                </div>
            <!-- END MENU -->
        </div>
        <!-- END PORTLET MAIN -->

        <!-- PORTLET MAIN -->
       <!--  <div class="portlet light"> -->
            <!-- STAT -->
            <!-- <div class="row list-separated profile-stat">
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="uppercase profile-stat-title">
                         37
                    </div>
                    <div class="uppercase profile-stat-text">
                         Projects
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="uppercase profile-stat-title">
                         51
                    </div>
                    <div class="uppercase profile-stat-text">
                         Tasks
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="uppercase profile-stat-title">
                         61
                    </div>
                    <div class="uppercase profile-stat-text">
                         Uploads
                    </div>
                </div>
            </div> -->
            <!-- END STAT -->
            <!-- <div>
                <h4 class="profile-desc-title">About Ajay Maharjan</h4>
                <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-globe"></i>
                    <a href="http:#">Web Link</a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-twitter"></i>
                    <a href="#">@Twitter Link</a>
                </div>
                <div class="margin-top-20 profile-desc-link">
                    <i class="fa fa-facebook"></i>
                    <a href="#">facebook Link</a>
                </div>
            </div>
        </div> -->
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
                                <a href="#tab_1_2" id="changeAvatarTab" data-toggle="tab">Change Avatar</a>
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
                                <form action="" id="OrganizationAddForm"  method="post" accept-charset="utf-8">
                                <div style="display:none;">
                                    <input type="hidden" name="_method" value="POST"/>
                                    <input type="hidden" name="data[User][id]" value="<?php echo $userId;?>"/>
                                    <input type="hidden" name="data[Organization][id]" value="<?php echo $organization->id;?>"/>
                                </div>
                                    <div class="form-group">
                                        <label class="control-label">First Name</label>
                                        <input type="text" class="form-control" name="data[User][fname]" value="<?php echo $userdetail->User->fname;?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Last Name</label>
                                        <input type="text" class="form-control" name="data[User][lname]" value="<?php echo $userdetail->User->lname;?>"/>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label">Username</label>
                                        <input type="text" class="form-control" name="data[User][username]" value="<?php echo $userdetail->User->username;?>"/>
                                    </div> -->
                                    <div class="form-group">
                                        <label class="control-label">Date Of Birth</label>
                                        <input type="text"  class="form-control input-medium date-picker date-picker-modal" data-date-format="yyyy-mm-dd"  name="data[User][dob]" value="<?php echo $userdetail->User->dob;?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Address</label>
                                        <input type="text" class="form-control" id="UserAddress" name="data[User][address]" value="<?php echo $userdetail->User->address;?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Phone</label>
                                        <input type="text"class="form-control" name="data[User][phone]" value="<?php echo $userdetail->User->phone;?>"/>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label">Fax</label>
                                        <input type="text"class="form-control" name="data[User][fax]" value="<?php echo $organization->fax;?>"/>
                                    </div> -->
                                   <!--  <div class="form-group">
                                        <label class="control-label">Website</label>
                                        <input type="text" class="form-control"  name="data[Organization][website]" value="<?php echo $organization->website;?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Country</label>
                                        <select name="data[Organization][country_id]" class="form-control">
                                        <?php foreach($countries as $key=>$country):?>

                                        <option value="<?php echo $key;?>" <?php echo ($organization->country_id == $key)? 'selected="selected"':'';?>><?php echo $country;?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div> -->
                                   <!--  <div class="form-group">
                                        <label class="control-label">City</label>
                                        <select name="data[Organization][city_id]" class="form-control">
                                        <?php foreach($cities as $key=>$city):?>
                
                                        <option value="<?php echo $key;?>" <?php echo ($organization->city_id == $key)? 'selected="selected"':'';?>><?php echo $city;?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div> -->
                                    <!-- <div class="form-group">
                                        <label class="control-label">Lat</label>
                                        <input type="text" class="form-control"  name="data[Organization][lat]" value="<?php echo $organization->lat;?>"/>
                                    </div> -->
                                   <!--  <div class="form-group">
                                        <label class="control-label">Long</label>
                                        <input type="text" class="form-control" name="data[Organization][long]" value="<?php echo $organization->long;?>"/>
                                    </div> -->
                                   <!--  <div class="form-group">
                                        <label class="control-label">Day</label>
                                        <select name="data[Organization][day_id]" class="form-control">
                                        <?php foreach($days as $key=>$day):?>
                
                                        <option value="<?php echo $key;?>" <?php echo ($organization->day_id == $key)? 'selected="selected"':'';?>><?php echo $day;?></option>
                                        <?php endforeach;?>
                                        </select>
                                    </div> -->
                                    <div class="margiv-top-10">
                                        <input type="submit" name="submitPersonalInfo" value="Save Changes" class="btn green-haze" />
                                        
                                        <a href="javascript:;" class="btn default">
                                        Cancel </a>
                                    </div>
                                </form>
                            </div>
                                <!-- END PERSONAL INFO TAB -->
                                <!-- CHANGE AVATAR TAB -->
                                <?php
                                    // function image_change($image,$image_url,$gender,$defaultimg,$defaultfimg){
                                    //     if ($image &&  @GetImageSize($image_url)) {
                                    //         return $image_url;
                                    //     }
                                    //     else{
                                    //         if($gender == '0')
                                    //         {
                                    //             return $defaultimg;
                                    //         }
                                    //         else{
                                    //             return $defaultfimg;
                                    //         }
                                    //     }
                                    // }
                                ?>
                                <?php
                                   //  $user_image = URL.'webroot/files/user/image/'.$userdetail->User->image_dir.'/thumb2_'.$userdetail->User->image;
                                   //  $image= $userdetail->User->image;
                                   //  $gender = $userdetail->User->gender;
                                   //  $fimage = URL.'webroot/img/user_image/defaultuser.png';
                                   //  $limage = URL.'webroot/img/user_image/femaleadmin.png';
                                   // image_change($image,$user_image,$gender,$limage,$fimage);
                                ?>
                            <div class="tab-pane <?php echo (isset($imagesaveSuccess))?'active':'';?>" id="tab_1_2">
                               <!--  <p>
                                     Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                                </p> -->
                            <form action="" method="POST" role="form" enctype="multipart/form-data">
                                    <div class="container" id="crop-avatar">
                                        <!--    <div class="form-group"> -->
                                        <input type="hidden" name="data[User][id]" value="<?php echo $userId;?>"/>
                                        <!--     <input type="hidden" name="data[User1][image_dir]" value="<?php echo $userdetail->User->image_dir ?>" /> -->
                     
                                        <div class="avatar-view fileinput-new thumbnail" title="Change Avatar" style="width: 200px; height: 200px;">
                                           <img src="<?php echo $userimage; ?>" alt="no image found" class="img-responsive">
                                            <input type="hidden" id="namePicInput" name="avatar"/>
                                        </div>

                                        <div class="avatar-view">
                                          <a class="btn btn-success">Upload</a>
                                        </div>
                                            <!-- Current avatar -->
                                        <div class="modal fade avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                                              
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
                                                                      <input type="file" class="avatar-input" id="avatarInput" name="image">
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
                                                                            <button type="submit" id="done" name="saveimage" class="btn btn-primary btn-block avatar-save">Done</button>
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
                                    </div>
                            </form>
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
                                    <input type="password" class="form-control" name="data[User][password]" id="npassword" />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Re-type New Password</label>
                                    <input type="password" class="form-control" name="data[User][confirm_password]" id="cpassword" />
                                </div>
                                <div class="margin-top-10">
                                    <input type="submit" name="changePassword" value="Change Password" class="btn green-haze" id="changePassword">
                                    
                                    <a href="javascript:;" class="btn default">
                                    Cancel </a>
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
<script type="text/javascript">
$(function(){
        $('#frmchangepassword').on('submit',function(ev){
                ev.preventDefault();
                var newPassword = $('#npassword').val();

                var confirmPassword = $('#cpassword').val();
                if (!(newPassword).match(confirmPassword)) {
                                toastr.options = {
                                      "closeButton": true,
                                      "debug": false,
                                      "positionClass": "toast-top-center",
                                      "onclick": null,
                                      "showDuration": "1000",
                                      "hideDuration": "1000",
                                      "timeOut": "10000",
                                      "extendedTimeOut": "1000",
                                      "showEasing": "swing",
                                      "hideEasing": "linear",
                                      "showMethod": "fadeIn",
                                      "hideMethod": "fadeOut"
                                    };
                            toastr.error("new password missmatch");
                   
                }
                else{
                    
                     $('#frmchangepassword').unbind('submit').submit();
                }
            });
  });
</script>
<script src="<?php echo URL_VIEW; ?>global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/profile.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script src="<?php echo URL_VIEW;?>crop-avatar/js/cropper.min.js"></script>
<script src="<?php echo URL_VIEW;?>crop-avatar/js/main.js"></script>

<script>
jQuery(document).ready(function() {       
   ComponentsPickers.init();
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
         var searchbox = new google.maps.places.SearchBox(document.getElementById("UserAddress"));
     }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>