<link href="<?php echo URL_VIEW;?>admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>

<link href="<?php echo URL_VIEW; ?>global/plugins/icheck/skins/all.css" rel="stylesheet"/>


<!-- BEGIN GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->

<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->

<link rel="stylesheet" href="<?php echo URL_VIEW;?>crop-avatar/css/cropper.min.css">
<link rel="stylesheet" href="<?php echo URL_VIEW;?>crop-avatar/css/main.css">

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<style>
.other label{
	color:#9A9A9A !important;
	margin-bottom:12px !important;
}	
</style>
<script>
jQuery(document).ready(function() {       

 $('#dashboard-report-range').daterangepicker({ format: 'YYYY-MM-DD'});
 ComponentsPickers.init();
 });
</script>

<?php

if (isset($_POST['changePassSubmit'])) {

	$_POST['data']['User']['password']=$_POST['password'];
	$_POST['data']['User']['confirm_password']=$_POST['rpassword'];
	
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

if(isset($_POST["myProfSubmit"])){

	//fal($_POST);
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


$url = URL ."Users/myProfile/".$user_id.".json";
$org = \Httpful\Request::get($url)->send();

$userDetail = $org->body->userDetail;

$loginUserRelationToOther = loginUserRelationToOther($user_id);
//  echo "<pre>";
// print_r($loginUserRelationToOther);
// die();



if(empty($userDetail))
{
	echo "<br/>";
	echo "An error occured in Server. Please contact the server administrator.";
	die();
}

$orgimage = URL.'webroot/files/user/image/'.$userDetail->User->image_dir.'/thumb2_'.$userDetail->User->image;
$image = $userDetail->User->image;
$gender = $userDetail->User->gender;

$userimage = imageGenerate($orgimage,$image,$gender);

if(isset($_POST["liscenseFormSubmit"])){
// fal($_POST);
	$url = URL . "Liscenses/saveLiscense/".$userId.".json";
    $response = \Httpful\Request::post($url)
    ->sendsJson()
    ->body($_POST['data'])
    ->send();
}

$url = URL ."Liscenses/view/".$user_id.".json";
$data = \Httpful\Request::get($url)->send();

if(isset($data->body->Liscense)){
$liscenses = $data->body->Liscense;	
}
//fal($liscenses);

if(isset($liscenses) && !empty($liscenses)){
	$lType = $liscenses->type;
	$lIssueDate = $liscenses->issuedate;
	$lExpiryDate = $liscenses->expirydate;
}

$url = URL ."Vaccinations/view/".$user_id.".json";
$data = \Httpful\Request::get($url)->send();
$vaccination = $data->body;

?>


<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>My Profile <small>general ui components</small></h1>
			</div>
			<!-- END PAGE TITLE -->
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb">
	            <li>
					<i class="fa fa-home"></i>
					<a href="<?=URL_VIEW;?>">Home</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="javascript:;">My Profile</a>
				</li>
	        </ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN ALERTS PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<!-- <i class="fa fa-cogs font-green-sharp"></i> -->
								<span class="caption-subject font-green-sharp bold uppercase">Hi <?php echo $userDetail->User->fname; ?>!</span>
								<span class="caption-helper"></span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row myProfFRow">
								<div class="col-md-4">
									<div class="portlet">
										<div class="portlet-title" style="border:none; margin-bottom:0px;">
											<div class="caption">
												<i class="fa fa-info-circle"></i>Verify Your Infromation
											</div>
										</div>
										<p>
											Verify your information below. Make sure your email and mobile number are correct. This is how your manager will contact you with schedule updates.
										</p>

									</div>
								</div>
								<div class="col-md-4">
									<div class="portlet">
										<div class="portlet-title" style="border:none; margin-bottom:0px;">
											<div class="caption">
												<i class="fa fa-clock-o"></i>INPUT YOUR AVAILABILITY
											</div>
										</div>
										<p>
											Your availability lets the manager know when you are unavailable and when you prefer to be scheduled.
										</p>

										<a href="<?php echo URL_VIEW;?>useravailabilities/myAvailability" class="btn btn-sm btn-default" style="width:100%; text-align:left;">Setup Availability    <i class="fa fa-angle-right pull-right" style="margin-top: 3px;"></i></a>
									</div>
								</div>
								<div class="col-md-4">
									<div class="portlet">
										<div class="portlet-title" style="border:none; margin-bottom:0px;">
											<div class="caption">
												<i class="fa fa-gear"></i>REVIEW ALERT PREFERENCES
											</div>
										</div>
										<p>
											Review your alert preferences below. These preferences determine how you are notified about schedule updates, shift trades/drops and other activity about your work schedule.
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END ALERTS PORTLET-->
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<!-- BEGIN ALERTS PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<!-- <i class="fa fa-cogs font-green-sharp"></i> -->
								<span class="caption-subject font-green-sharp bold uppercase">My Profile</span>
								<span class="caption-helper"></span>
							</div>
							<div class="tools">
								<button href="#changePassModal" data-toggle="modal" class="btn btn-md default">Change Password</button>
								<button type="button" class="btn btn-md green" id="updateProfile">Update</button>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-3" id="crop-avatar">
									<form action="" method="POST" role="form" enctype="multipart/form-data">
										<input type="hidden" name="data[User][id]" value="<?php echo $userId;?>"/>
										<div class="avatar-view fileinput-new thumbnail" title="Change Avatar">
                                           <img src="<?php echo $userimage; ?>" alt="no image found" class="img-responsive">
                                            <input type="hidden" id="namePicInput" name="avatar"/>
                                        </div>
										<div class="avatar-view profile-usertitle">
											<button type="button" class="btn default" style="width:100%">Upload Picture</button>
										</div>

										    <!-- Current avatar -->
                                        <div class="modal fade avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                                              
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
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
                                                                      <input type="file" class="avatar-input" id="avatarInput" name="image">
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
                                                                        </div -->
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
									</form>
								</div>

								<div class="col-md-9 editProfileDiv">
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="" id="myProfForm" method="POST" class="horizontal-form">
											<input type="hidden" name="data[User][id]" value="<?php echo $userId;?>"/>
											<div class="form-body">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">First Name</label>
															<input name="data[User][fname]" type="text" id="firstName" value="<?php echo $userDetail->User->fname; ?>" class="form-control" placeholder="Chee Kin">
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Last Name</label>
															<input name="data[User][lname]" type="text" id="lastName" value="<?php echo $userDetail->User->lname;?>" class="form-control" placeholder="Lim">
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Phone</label>
															<input name="data[User][phone]" type="text" value="<?php echo $userDetail->User->phone;?>" class="form-control">
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Date of Birth</label>
															<input name="data[User][dob]" data-date-format="yyyy-mm-dd" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="<?php echo $userDetail->User->dob;?>"/>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Email</label>
															<input disabled type="text" name="data[User][email]" value="<?php echo $userDetail->User->email;?>" class="form-control" placeholder="Lim">
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Address</label>
															<input type="text" class="form-control" id="UserAddress" name="data[User][address]" value="<?php echo $userDetail->User->address;?>"/>
														</div>
													</div>
												</div>
											</div>
											<input type="submit" name="myProfSubmit" style="display:none;" id="myProfFormSubmit">
										</form>
										<!-- END FORM-->
									</div>
								</div>
							</div>
						</div>
					</div>

										<!--Other Details starts-->		
					<div class="portlet light">
					
						<div class="portlet-title">
							<div class="caption">
								<!-- <i class="fa fa-cogs font-green-sharp"></i> -->
								<span class="caption-subject font-green-sharp bold uppercase">other details</span>
								<span class="caption-helper">Liscense</span>
							</div>
							<div class="tools">
								<button type="button" id="updateLiscense" class="btn btn-md green">Update</button>
							</div>
						</div>
						<div class="portlet-body">
						<form action="" method="POST">
							<div class="form-body other">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Liscense Type</label>
											<select name="data[Liscense][type]" type="text" id="liscenseType" value="" class="form-control">
											<option value="0" disabled <?php if(!isset($lType)){ echo "selected"; } ?> >Select Liscense Type</option>
											
											<option value="Heavy Weight" <?php if(isset($lType)){ if($lType == "Heavy Weight"){ echo "selected"; } } ?> >Heavy Weight</option>
											<option value="Light Weight" <?php if(isset($lType)){ if($lType == "Light Weight"){ echo "selected"; } } ?> >Light Weight</option>

											</select>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Issue Date</label>
											<input name="data[Liscense][issuedate]" type="text"  size="16" class="form-control date-picker" data-date-format="yyyy-mm-dd" placeholder="Issue Date.." value="<?php if(isset($lIssueDate)){ echo $lIssueDate; } ?>" required>
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Expiry Date</label>
											<input name="data[Liscense][expirydate]" type="text" size="16" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?php if(isset($lExpiryDate)){ echo $lExpiryDate; } ?>" placeholder="Expiry Date.." required>
										</div>
									</div>
									
								</div>
								<hr>

								<div class="vaccination">
									<?php if(isset($vaccination) && !empty($vaccination)){ ?>
									<?php $count = 0; foreach($vaccination as $v) { ?>
									<div class="row child" data-count="<?php echo $count;?>">
										<div class="col-md-4">
											<div class="form-group">
												<?php if($count < 1) { ?>
												<label class="control-label">Vaccination Type</label>
												<?php } ?>
				
												<select name="data[Vaccination][<?php echo $count; ?>][type]" type="text" id="liscenseType" value="" class="form-control">
												<option value="0" disabled selected>Select Vaccinations Type</option>
												<option value="Vaccination A" <?php if($v->Vaccination->type=="Vaccination A"){ echo "selected"; } ?> >Vaccination A</option>
												<option value="Vaccination B" <?php if($v->Vaccination->type=="Vaccination B"){ echo "selected"; } ?> >Vaccination B</option>
												<option value="Vaccination C" <?php if($v->Vaccination->type=="Vaccination C"){ echo "selected"; } ?>>Vaccination C</option>

												</select>
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<?php if($count < 1) { ?>
												<label class="control-label">Date</label>
												<?php } ?>
												<input name="data[Vaccination][<?php echo $count; ?>][date]" type="text"  size="16" class="form-control date-picker" data-date-format="yyyy-mm-dd" placeholder="Date.." value="<?php echo $v->Vaccination->date; ?>">
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<?php if($count < 1) { ?>
												<label class="control-label">Status</label>
												<?php } ?>
												<input name="data[Vaccination][<?php echo $count; ?>][status]" type="text" size="16" class="form-control" data-date-format="yyyy-mm-dd" value="<?php echo $v->Vaccination->status; ?>" placeholder="Status">
											</div>
										</div>
										<div class="col-md-1"><a href="javascript://" class="remove_field"><i class="fa fa-minus-circle" style="margin-top:<?php if($count == 0){ echo '43px'; } else{ echo '10px';} ?>;"></i> </a></div>
										<input type="hidden" name="data[Vaccination][<?php echo $count; ?>][user_id]" value="<?php echo $userId; ?>">
										
									</div>

								<?php $count++; } } else { ?>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label">Vaccination Type</label>
												<select name="data[Vaccination][0][type]" type="text" id="liscenseType" value="" class="form-control">
												<option value="0" disabled selected>Select Vaccinations Type</option>
												<option value="Vaccination A">Vaccination A</option>
												<option value="Vaccination B">Vaccination B</option>
												<option value="Vaccination C">Vaccination C</option>

												</select>
											</div>
										</div>
										
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label">Date</label>
												<input name="data[Vaccination][0][date]" type="text"  size="16" class="form-control date-picker" data-date-format="yyyy-mm-dd" placeholder="Date.." >
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<label class="control-label">Status</label>
												<input name="data[Vaccination][0][status]" type="text" size="16" class="form-control" data-date-format="yyyy-mm-dd" placeholder="Status">
											</div>
										</div>
										<input type="hidden" name="data[Vaccination][0][user_id]" value="<?php echo $userId; ?>">
										
									</div>
								<?php } ?>	

									<div class="add-more-here">

									</div>
								</div>

								<div class="form-group">
									<button type="button"  class="add_more btn btn-success btn-sm"> <i class="fa fa-plus"></i> Add More</button>
								</div>
							</div>
							<input type="submit" style="display:none;" name="liscenseFormSubmit" id="liscenseFormSubmit">
							</form>

						</div>

					</div>
					<!--other details ends-->

					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<!-- <i class="fa fa-cogs font-green-sharp"></i> -->
								<span class="caption-subject font-green-sharp bold uppercase">SAVE Alert Preferences</span>
								<span class="caption-helper"></span>
							</div>
							<div class="tools">
								<button type="button" class="btn btn-md green">Save</button>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-hover table-light">
											<tbody>
											<tr>
												<td class="col-md-9">
													TIME-OFF REQUESTS
												</td>
												<td class="col-md-3">
													<div class="input-group">
														<div class="icheck-inline">
															<label>
															<input type="checkbox" class="icheck" data-checkbox="icheckbox_flat-green"> Email </label>
															<label>
															<input type="checkbox" checked class="icheck" data-checkbox="icheckbox_flat-green"> Mobile </label>
															<label>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="col-md-9">
													SWAP / DROP REQUESTS
												</td>
												<td>
													<div class="input-group">
														<div class="icheck-inline">
															<label>
															<input type="checkbox" class="icheck" data-checkbox="icheckbox_flat-green"> Email </label>
															<label>
															<input type="checkbox" checked class="icheck" data-checkbox="icheckbox_flat-green"> Mobile </label>
															<label>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="col-md-9">
													SCHEDULE UPDATES
												</td>
												<td>
													<div class="input-group">
														<div class="icheck-inline">
															<label>
															<input type="checkbox" class="icheck" data-checkbox="icheckbox_flat-green"> Email </label>
															<label>
															<input type="checkbox" checked class="icheck" data-checkbox="icheckbox_flat-green"> Mobile </label>
															<label>
														</div>
													</div>
												</td>
											</tr>

											<tr>
												<td class="col-md-9">
													ATTENDANCE ALERTS
												</td>
												<td>
													<div class="input-group">
														<div class="icheck-inline">
															<label>
															<input type="checkbox" class="icheck" data-checkbox="icheckbox_flat-green"> Email </label>
															<label>
															<input type="checkbox" checked class="icheck" data-checkbox="icheckbox_flat-green"> Mobile </label>
															<label>
														</div>
													</div>
												</td>
											</tr>
											</tbody>
											</table>
						</div>
					</div>
					<!-- END ALERTS PORTLET-->


				</div>
				<div class="col-md-4">
					<!-- BEGIN ALERTS PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<!-- <i class="fa fa-cogs font-green-sharp"></i> -->
								<span class="caption-subject font-green-sharp bold uppercase">Shift History</span>
								<span class="caption-helper"></span>
							</div>
						</div>
						<div class="portlet-body">
							<?php if(!empty($loginUserRelationToOther->userOrganization)):?>

                                <form role="form" method="post" action="">
                                    <div class="form-group">
	                                     <label>Date Range</label>

	                                     <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"  data-date-format="yyyy-mm-dd">
	                                        <input type="text" class="form-control" name="data[start_date]" required />
	                                        <span class="input-group-addon">
	                                        to </span>
	                                        <input type="text" class="form-control" name="data[end_date]" required />
	                                     </div> 

                                    </div>
                                        
                                    <div class="form-actions" > 
                                        <input type="submit" class="btn btn-sm green applyBtn"  value="Submit" name="submit_date">
                                        
                                    </div>
                                </form>
                                <hr> 


							<div class="portlet-title tabbable-line">
												
								<ul class="nav nav-tabs pull-right">
									<?php if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)):?>
	                            <?php
	                            		$count=0;
	                            		foreach($loginUserRelationToOther->userOrganization as $orgid=>$org_detail){
		                            		$url=URL."Organizations/organizationProfile/".$orgid.".json";
		                            		$orgs=\Httpful\Request::get($url)->send();
	                            	?>

	                            		<li class="<?php if($count==0){echo 'active';}?>">
		                                    <a href="#tab_1_<?php echo $orgid;?>" data-toggle="tab" style="color:black;">
		                                    <?php echo $orgs->body->output->Organization->title;?></a>
		                                </li>
		                          	<?php
		                          	$count++;
	                           			 }
	                           			?>


	                           		<li>
		                                <a  href="#tab_9_def" data-toggle="tab" style="color:black;">
		                                All</a>
		                            </li>
			                        <?php else:?>
			                    <?php endif;?>
	                        	</ul>
							</div>
							<?php endif;?>
							<div class="portlet-body">
								<!--BEGIN TABS-->
								<div class="tab-content">
									<?php if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)):?>
									    <?php
											$count=0;
						            		 foreach ($loginUserRelationToOther->userOrganization as $orgid=>$org_detail):
											$count++;


												if(isset($_POST['submit_date'])){

											        $url = URL."ShiftUsers/getOverTime/".$user_id."/".$orgid."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
											        $response = \Httpful\Request::get($url)->send();
											        $url1 = URL."ShiftUsers/orgEmployeeDetails/".$user_id."/".$orgid."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
											        $response1 = \Httpful\Request::get($url1)->send();

											        $url = URL."Accounts/getEmpRelatedOrgHistory/".$orgid."/".$user_id."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
											        $response2 = \Httpful\Request::get($url)->send();

											    }else{

											        $url = URL."ShiftUsers/getOverTime/".$user_id."/".$orgid.".json";
											        $response = \Httpful\Request::get($url)->send();
											        $url1 = URL."ShiftUsers/orgEmployeeDetails/".$user_id."/".$orgid.".json";
											        $response1 = \Httpful\Request::get($url1)->send();

											        $url = URL."Accounts/getEmpRelatedOrgHistory/".$orgid."/".$user_id.".json";
											        $response2 = \Httpful\Request::get($url)->send();
											    }
											        $total = $response->body;
											        $allDetails = $response1->body;

											        // fal($response2);
											        $empShiftHist = $response2->body->total->Account;

											        $url = URL."Accounts/getPayCycle/".$userId."/".$orgId.".json";
											        $response = \Httpful\Request::get($url)->send();

											        $payCycle = $response->body;

						            	 	?> 
						            	 	<div class="tab-pane <?php if($count==1){echo 'active';}?>" id="tab_1_<?php echo $orgid;?>">
                        						<div class="table-scrollable table-scrollable-borderless">

													<table class="table table-hover table-light">
													
														<tbody>
														<tr>
															<td>
																<span>Total no of Shift<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->totalShifts; ?></span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Working Hours<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo round($empShiftHist->workedhours, 2); ?> </span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Overtime hour<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo round($empShiftHist->morehours, 2); ?></span>
															</td>
														</tr>														
														</tbody>
													</table>
												</div>
												<hr>
                        						<h4>Pay Cycle</h4>
                        						<div class="table-scrollable table-scrollable-borderless">

													<table class="table table-hover table-light">
													
														<tbody>
														<tr>
															<td>
																<span>This week<i class="fa fa-img-up"></i></span>
															<?php if ($payCycle->status == 1): ?>
																<span style="float:right;"><?php echo "$ ".round($payCycle->PayCycle->Account->total, 3); ?></span>
															<?php else: ?>
																<span style="float:right;"> $ 0.00</span>
															<?php endif ?>
															</td>
														</tr>														
														</tbody>
													</table>
												</div>
                    						</div>
                    						<?php
						            	 		endforeach;

						            	 	?> 
                    						<div class="tab-pane" id="tab_9_def">
                    							<?php            	       								
												if(isset($_POST['submit_date'])){

												        $url = URL."ShiftUsers/getOverTime/".$userId."/0/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
												        $response = \Httpful\Request::get($url)->send();
												        $url1 = URL."ShiftUsers/orgEmployeeDetails/".$userId."/0/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
												        $response1 = \Httpful\Request::get($url1)->send();

												        $url = URL."Accounts/getAllEmpRelOrgHistory/".$user_id."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
												        $response2 = \Httpful\Request::get($url)->send();

												    }else{

												        $url = URL."ShiftUsers/getOverTime/".$userId."/0.json";
												        $response = \Httpful\Request::get($url)->send();
												        $url1 = URL."ShiftUsers/orgEmployeeDetails/".$userId."/0.json";
												        $response1 = \Httpful\Request::get($url1)->send();

												        $url = URL."Accounts/getAllEmpRelOrgHistory/".$user_id.".json";
												        $response2 = \Httpful\Request::get($url)->send();
												    }
												        $total = $response->body;
												        $allDetails = $response1->body;

												        $empAllShiftHist = $response2->body->total->Account;

												        $url = URL."Accounts/getPayCycle/".$userId.".json";
												        $response = \Httpful\Request::get($url)->send();

												        $payCycle = $response->body;
												
												?>
                    							<div class="table-scrollable table-scrollable-borderless">

													<table class="table table-hover table-light">
													
														<tbody>
														<tr>
															<td>
																<span>Total no of Shift<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->totalShifts; ?></span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Working Hours<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo round($empAllShiftHist->workedhours, 2); ?>  </span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Overtime hour<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo round($empAllShiftHist->morehours, 2); ?></span>
															</td>
														</tr>														
														</tbody>
													</table>
												</div>
												<hr>
                        						<h4>Pay Cycle</h4>
                        						<div class="table-scrollable table-scrollable-borderless">

													<table class="table table-hover table-light">
													
														<tbody>
														<tr>
															<td>
																<span>This week<i class="fa fa-img-up"></i></span>
																<?php if ($payCycle->status == 1): ?>
																	<span style="float:right;"><?php echo "$ ".round($payCycle->PayCycle->Account->total, 3); ?></span>
																<?php else: ?>
																	<span style="float:right;"> $ 0.00</span>
																<?php endif ?>
															</td>
														</tr>														
														</tbody>
													</table>
												</div>
											</div>
						            	 	 
						            	 	                    
									<?php else:?>
										<div>No Data.</div>
									<?php endif;?>
								</div>
								<!--END TABS-->
							</div>
						</div>
					</div>
					<!-- END ALERTS PORTLET-->

					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<!-- <i class="fa fa-cogs font-green-sharp"></i> -->
								<span class="caption-subject font-green-sharp bold uppercase">Social</span>
								<span class="caption-helper"></span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row socialDiv">
								<div class="col-md-12">
									<div class="portlet">
										<div class="portlet-title" style="border:none; margin-bottom:0px;">
											<div class="caption">
												<i class="fa fa-facebook-square"></i>Facebook
											</div>
										</div>
										<p>
											Connect to Facebook so you can view your schedule on Facebook without logging in to When I Work. You can even setup "Schedule Sharing" so your Facebook friends can see when you get off work.
										</p>

										<?php if(isset($userDetail->User->fbid) && !empty($userDetail->User->fbid)):?>
											<button type="button" class="btn" style="background-color:#3a5795;color:#ffffff;"> YOU'RE CONNECTED</button>
										<?php else:?>
											<button id="fb_login" type="button" class="btn" style="background-color:#3a5795;color:#ffffff;">CONNECT</button>
										<?php endif;?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT INNER -->
	</div>
	<!-- END PAGE CONTENT -->
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePassModal" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="changePasswordForm" action="" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Change Password</h4>
				</div>
				<div class="modal-body">
					<div class="form-body">
						<div class="form-group">
							<label class="control-label">Current Password</label>
							<input type="password" name="data[User][old_password]" class="form-control" placeholder="Enter text" required>
							<span class="help-block"></span>
						</div>

						<div class="form-group">
							<label class="control-label">New Password</label>
							<input type="password" class="form-control" name="password" id="submit_form_password" placeholder="Enter text">
							<span class="help-block"></span>
						</div>

						<div class="form-group">
							<label class="control-label">Re-type New Password</label>
							<input type="password" class="form-control" name="rpassword" placeholder="Enter text">
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
					<input type="submit" name="changePassSubmit" class="btn blue" value="Save changes">
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- End of change password modal -->

<?php
$url = URL ."Users/myProfile/".$user_id.".json";
$org = \Httpful\Request::get($url)->send();

$userDetail = $org->body->userDetail;
if(empty($userDetail))
{
	echo "<br/>";
	echo "An error occured in Server. Please contact the server administrator.";
	die();
}

?>

<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/jquery-validation/js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/form-wizard.js"></script>

<script src="<?php echo URL_VIEW;?>crop-avatar/js/cropper.min.js"></script>
<script src="<?php echo URL_VIEW;?>crop-avatar/js/main.js"></script>

<script src="<?php echo URL_VIEW; ?>global/plugins/icheck/icheck.min.js"></script>
<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/form-icheck.js"></script>
<script>
jQuery(document).ready(function() { 
    FormiCheck.init();
    FormWizard.init();
});
</script>
<script>
$(document).ready(function(){
		
	$("#updateLiscense").click(function(event){
		$("#liscenseFormSubmit").click();
		});

	var c = 5;
	$(".add_more").live("click",function(){
		 var html = "";
		 html += '	<div class="row"><div class="col-md-4"><div class="form-group"><select name="data[Vaccination]['+c+'][type]" type="text" id="liscenseType" value="" class="form-control"><option value="0" disabled selected>Select Vaccinations Type</option><option value="Vaccination A">Vaccination A</option><option value="Vaccination B">Vaccination B</option><option value="Vaccination C">Vaccination C</option></select></div></div><div class="col-md-4"><div class="form-group"><input name="data[Vaccination]['+c+'][date]" type="text"  size="16" class="form-control date-picker" data-date-format="yyyy-mm-dd" placeholder="Date.." ></div></div><div class="col-md-3"><div class="form-group"><input name="data[Vaccination]['+c+'][status]" type="text" size="16" class="form-control" data-date-format="yyyy-mm-dd" placeholder="Status"></div></div><div class="col-md-1"><a href="javascript://" class="remove_field"><i class="fa fa-minus-circle" style="margin-top:12px;"></i> </a></div><input type="hidden" name="data[Vaccination]['+c+'][user_id]" value="<?php echo $userId; ?>"></div>';
		c++; 

		//if(c <= 3){
		 $(".add-more-here").append(html);
		//}
		$('.date-picker').datepicker();
			
	});
	
	$(".remove_field").live("click",function(){
		$(this).closest(".row").remove();
	});
});
</script>

<script type="text/javascript">
	$(function()
		{
			var form = $("#changePasswordForm");
			form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    password: {
                        // minlength: 5,
                        required: true
                    },
                    rpassword: {
                        // minlength: 5,
                        required: true,
                        equalTo: "#submit_form_password"
                    },
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                        label
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label
                            .addClass('valid') // mark the current input as valid and display OK icon
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },

                submitHandler: function (form) {
                    // success.show();
                    // error.hide();
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax

                    form.submit();
                }

            });
			$("#updateProfile").on('click', function(event)
				{
					$("#myProfFormSubmit").click();
				});
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
        	var e = $(this);
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
          FB.api('/me?fields=email', function(response) {

            // console.log(response);
            var fbjson = JSON.stringify(response);           

            var userId = '<?php echo $userId;?>';
              var fbemail = response.email;
              var fbid = response.id;
              var data = {'User':{'id':userId, 'fbid':fbid}};

              // console.log(data);
              var urli = '<?php echo URL;?>Users/saveFbId.json';

              var userEmail = '<?php echo $userDetail->User->email;?>';

              if(userEmail === fbemail)
              {
              	$.ajax(
                {
                  url:urli,
                  data:data,
                  type:'post',
                  datatype:'jsonp',
                  success:function(response)
                  {

                    if(response.output == 1)
                    {
                    	toastr.success('You are now connected with facebook.');
                    	$("#fb_login").html("YOU'RE CONNECTED");
		                $("#fb_login").removeAttr('id').off("click");
                    }
                    else
                    {
                    	toastr.warning('Something went wrong. Please try again.');
                    }
                  }
                });
              }else
              {
              	toastr.warning("Your facebook email did not matched with your account email.");
              }

              
              


            // $("#hidFbData").val(fbjson);
            // $("#fb_form2").submit();
                  
              });
        }
        // End of Facebook login functions.
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


