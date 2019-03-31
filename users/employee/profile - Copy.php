<link href="<?php echo URL_VIEW;?>admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>


<!-- BEGIN GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->

<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

<script>
jQuery(document).ready(function() {       

 $('#dashboard-report-range').daterangepicker({ format: 'YYYY-MM-DD'});
 ComponentsPickers.init();
 });
</script>

<?php
// print_r($user_id);
// die();
$url = URL ."Users/myProfile/".$user_id.".json";
$org = \Httpful\Request::get($url)->send();

$userDetail = $org->body->userDetail;
// echo "<pre>";
// print_r($org_id);
// die();
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

?>


<!-- <a href="<?php echo URL_VIEW."employees/editEmployeeDetail?user_id=".$user_id;?>">Edit Profile</a>
 -->
 <!-- BEGIN PAGE HEADER-->
<!--  <h3 class="page-title">
    Profile <small>User information</small>
</h3> -->
 <div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>My Profile</h1>
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
				<a href="javascript:;">My Profile</a>
			</li>
        </ul>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
	<div class="row margin-top-20">
		
		<div class="col-md-12">
			<!-- BEGIN PROFILE SIDEBAR -->
			<div class="profile-sidebar">
				<!-- PORTLET MAIN -->
				<div class="portlet light profile-sidebar-portlet">
					<!-- SIDEBAR USERPIC -->
					<div class="profile-userpic">
						
						
						<img src="<?php echo $userimage;?>" alt="no image found" class="img-responsive">
						
					</div>
					<!-- END SIDEBAR USERPIC -->
					<!-- SIDEBAR USER TITLE -->
					<div class="profile-usertitle">
						<div class="profile-usertitle-name">
							 <?php echo $userDetail->User->fname.' '.$userDetail->User->lname; ?>
						</div>
						<div class="profile-usertitle-job">
							<?php
							 // foreach ($userDetail->OrganizationUser as $organizationUserdetail) {
							 // 	echo $organizationUserdetail->Organization->title.'<br>';
								// echo $organizationUserdetail->designation.'<br>';
							
								// }
							 ?>
							
						</div>
					</div>
					<!-- END SIDEBAR USER TITLE -->
					<!-- SIDEBAR BUTTONS -->
					<div class="profile-userbuttons">
					</div>
					<!-- END SIDEBAR BUTTONS -->
					<!-- SIDEBAR MENU -->
					<div class="profile-usermenu">
						<ul class="nav">
							<li class="active">
								<a href="">
								<i class="icon-home"></i>
								Overview </a>
							</li>
							<li>
								<a href="<?php echo URL_VIEW. 'users/userEdit?user_id='.$userId; ?>">
								<i class="icon-settings"></i>
								Account Settings </a>
							</li>
							<li>

								<a href="<?php echo URL_VIEW; ?>tasks/listTask">

								<i class="icon-check"></i>
								Tasks </a>
							</li>
							
						</ul>
					</div>
					<!-- END MENU -->
				</div>
				<!-- END PORTLET MAIN -->
				<!-- PORTLET MAIN -->
				<!-- <div class="portlet light"> -->
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
						<h4 class="profile-desc-title">About Marcus Doe</h4>
						<span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
						<div class="margin-top-20 profile-desc-link">
							<i class="fa fa-globe"></i>
							<a href="#">Weblink</a>
						</div>
						<div class="margin-top-20 profile-desc-link">
							<i class="fa fa-twitter"></i>
							<a href="#">@TwitterLink</a>
						</div>
						<div class="margin-top-20 profile-desc-link">
							<i class="fa fa-facebook"></i>
							<a href="#">FacebookLink</a>
						</div>
					</div> -->
				<!-- </div> -->
				<!-- END PORTLET MAIN -->
			</div>
			<!-- END BEGIN PROFILE SIDEBAR -->
			<!-- BEGIN PROFILE CONTENT -->
			<div class="profile-content">
				<div class="row">
					<div class="col-md-6">
						<!-- BEGIN PORTLET -->
						<div class="portlet light ">
							<div class="portlet-title">
								<div class="caption caption-md">
									<i class="icon-bar-chart theme-font hide"></i>
									<span class="caption-subject font-blue-madison bold uppercase">User Information</span>
									<!-- <span class="caption-helper hide">weekly stats...</span> -->
								</div>
								<!-- <div class="actions">
									<div class="btn-group btn-group-devided" data-toggle="buttons">
										<label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
										<input type="radio" name="options" class="toggle" id="option1">Today</label>
										<label class="btn btn-transparent grey-salsa btn-circle btn-sm">
										<input type="radio" name="options" class="toggle" id="option2">Week</label>
										<label class="btn btn-transparent grey-salsa btn-circle btn-sm">
										<input type="radio" name="options" class="toggle" id="option2">Month</label>
									</div>
								</div> -->
							</div>
							<div class="portlet-body" style="padding-top:0px;">
								<!-- <div class="row number-stats margin-bottom-30">
									 <div class="col-md-6 col-sm-6 col-xs-6">
										<div class="stat-left">
											<div class="stat-chart">
												<div id="sparkline_bar"></div>
											</div>
											<div class="stat-number">
												<div class="title">
													 Total
												</div>
												<div class="number">
													 2460
												</div>
											</div>
										</div>
									</div> 
									 <div class="col-md-6 col-sm-6 col-xs-6">
										<div class="stat-right">
											<div class="stat-chart">
											
												<div id="sparkline_bar2"></div>
											</div>
											<div class="stat-number">
												<div class="title">
													 New
												</div>
												<div class="number">
													 719
												</div>
											</div>
										</div>
									</div>
								</div> -->
								<div class="table-scrollable table-scrollable-borderless">

									<table class="table table-hover table-light">
									<!-- <thead>
									<tr class="uppercase">
										<th colspan="2">
											 MEMBER
										</th>
										<th>
											 Earnings
										</th>
										<th>
											 CASES
										</th>
										<th>
											 CLOSED
										</th>
										<th>
											 RATE
										</th>
									</tr>
									</thead> -->

									<tbody>
									<tr>
										<td>
											<span>First Name<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $userDetail->User->fname; ?></span>
										</td>
									</tr>
									<tr>
										<td>
											<span>Last Name</span><span style="float:right;"><?php echo $userDetail->User->lname; ?></span>
										</td>
									</tr>
									<tr>
										<td>
											<span>Username</span><span style="float:right;"><?php echo $userDetail->User->username; ?></span>
										</td>
									</tr>
									<tr>
										<td>
											<span>Email</span><span style="float:right;"><?php echo $userDetail->User->email; ?></span>
										</td>
									</tr>
									<tr>
										<td>
											<span>Address</span><span style="float:right;"><?php echo $userDetail->User->address; ?></span>
										</td>
									</tr>
									<tr>
										<td>
											<span>Phone Number</span><span style="float:right;"><?php echo $userDetail->User->phone; ?></span>
											
										</td>
									</tr>
									<tr>
										<td>
											 <span> Date Of Birth</span><span style="float:right;"><?php echo $userDetail->User->dob; ?></span>
										</td>
									</tr>
									<tr>
										<td>
											<span>City</span><span style="float:right;"><?php echo $userDetail->City->title; ?></span>
										</td>
									</tr>
									<tr>
										<td>
											<span>Country</span><span style="float:right;"><?php echo $userDetail->Country->title; ?></span>
										</td>
									</tr>
									</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- END PORTLET -->
					</div>
					<div class="col-md-6">
						<!-- BEGIN PORTLET -->
						<div class="portlet light">
						
							
							<!-- 	<form id="dateRangeFrm" action=" " method="post">
				                        <input id="dateRangeStartDate" type="hidden" name="startDate">
				                        <input id="dateRangeEndDate" type="hidden" name="endDate">
				                        <input id="dateRangeFrmSubmit" type="submit" name="dateRangeFrmSubmit" hidden>     

				               	</form> -->
				               <!--  <div class="page-toolbar">
				                    <form action="" method="post">
				                        <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm btn-default" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range" data-date-format="yyyy-mm-dd">
				                            <i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block"></span>&nbsp; <i class="fa fa-angle-down"></i>
				                        </div>
				                    </form>
				                </div> -->
						
							<div class="portlet-title tabbable-line">
								<div class="caption caption-md" >
									<i class="icon-globe theme-font hide"></i>
									<span class="caption-subject font-blue-madison bold uppercase" style="float:right;" >Shifts History</span>
								</div>
							</div>

							<?php if(!empty($loginUserRelationToOther->userOrganization)):?>

							<div class="collapse navbar-collapse navbar-ex1-collapse">  
                                <form role="form" method="post" action="">
                                    <div class="form-group" stlye="float:right;">
                                             <label>Date Range</label>
                                             <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"  data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control" name="data[start_date]" required />
                                                <span class="input-group-addon">
                                                to </span>
                                                <input type="text" class="form-control" name="data[end_date]" required />
                                             </div> 
                                    </div><span>
                                        
                                    <div class="form-actions" > 
                                        <input type="submit" class="btn blue applyBtn"  value="Submit" name="submit_date">
                                        
                                    </div></span> 
                                </form> 
                            </div>


							<div class="portlet-title tabbable-line">
												
								<ul class="nav nav-tabs">
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
											    }else{

											        $url = URL."ShiftUsers/getOverTime/".$user_id."/".$orgid.".json";
											        $response = \Httpful\Request::get($url)->send();
											        $url1 = URL."ShiftUsers/orgEmployeeDetails/".$user_id."/".$orgid.".json";
											        $response1 = \Httpful\Request::get($url1)->send();
											    }
											        $total = $response->body;
											        $allDetails = $response1->body;
												

						            	 		

						            	 	?> 
						            	 	<div class="tab-pane <?php if($count==1){echo 'active';}?>" id="tab_1_<?php echo $orgid;?>">
                        						<div class="table-scrollable table-scrollable-borderless">

													<table class="table table-hover table-light">
													
														<tbody>
														<tr>
															<td>
																<div class="col-md-4 col-sm-4 col-xs-6">
																	<div class="uppercase profile-stat-title" style="font-size:15px;">
																		 <?php echo $allDetails->number->totalShifts; ?>
																	</div>
																	<div class="uppercase profile-stat-text">
																		 Total no of Shift
																	</div>
																</div>
																<div class="col-md-4 col-sm-4 col-xs-6">
																	<div class="uppercase profile-stat-title" style="font-size:15px;">
																		 <?php echo $allDetails->number->totalWorkingHours; ?>
																	</div>
																	<div class="uppercase profile-stat-text">
																		 Working Hours
																	</div>
																</div>
																<div class="col-md-4 col-sm-4 col-xs-6">
																	<div class="uppercase profile-stat-title" style="font-size:15px;">
																		 <?php echo gmdate("H:i:s",$total->output->totalOverTimeWorking);?>
																	</div>
																	<div class="uppercase profile-stat-text">
																		 Overtime hour
																	</div>
																</div>
															</td>
														</tr>
														<!-- <tr>
															<td>
																<span>Total no of Shift<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $number->totalShifts;?>  </span>
															</td>
														</tr> -->
														<tr>
															<td>
																<span>Total Attendance<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->totalShifts; ?>    </span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Absent Shifts<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->absent; ?> </span>
															</td>
														</tr>
														<!-- <tr>
															<td>
																<span>Working Hours<i class="fa fa-img-up"></i></span>
																<span style="float:right;">
																<?php

																		$init = $totalWorkinHour;
																		$hours = floor($init / 3600);
																		$minutes = floor(($init / 60) % 60);
																		$seconds = $init % 60;

																		echo $hours."Hrs ".$minutes."mins ".$seconds."sec ";

																		?>
																</span>
															</td>
														</tr> -->
														<!-- <tr>
															<td>
																<span>Overtime hour<i class="fa fa-img-up"></i></span>
																<span style="float:right;">
																	<?php
																				$init = $totalOverTimes->totalOverTimeWorking;
																				$hours = floor($init / 3600);
																				$minutes = floor(($init / 60) % 60);
																				$seconds = $init % 60;

																				echo $hours."hrs ".$minutes."mins ".$seconds."sec ";
																			?>
																</span>
															</td>
														</tr> -->
														<tr>
															<td>
																<span>Late Checkin<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->totalNoOfLateCheckIn;?> </span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Early Checkout<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->earlyCheckOut; ?> </span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Late Checkout<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->lateCheck; ?> </span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Total Late Checkin Hours<i class="fa fa-img-up"></i></span>
																<span style="float:right;"> 
																	<?php echo gmdate("H:i:s",$total->output->totalLateCheckInTime); ?> 
																</span>
															</td>
															

														</tr>
														<tr>
															<td>
																<span>Total Less To full Work Hours <i class="fa fa-img-up"></i></span>
																<span style="float:right;"> 
																	<?php echo gmdate("H:i:s",$total->output->totalLessToFullWorkTime); ?>
																</span>
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
												    }else{

												        $url = URL."ShiftUsers/getOverTime/".$userId."/0.json";
												        $response = \Httpful\Request::get($url)->send();
												        $url1 = URL."ShiftUsers/orgEmployeeDetails/".$userId."/0.json";
												        $response1 = \Httpful\Request::get($url1)->send();
												    }
												        $total = $response->body;
												        $allDetails = $response1->body;
												
												?>
                    							<div class="table-scrollable table-scrollable-borderless">

													<table class="table table-hover table-light">
													
														<tbody>
														<tr>
															<td>
																<div class="col-md-4 col-sm-4 col-xs-6">
																	<div class="uppercase profile-stat-title" style="font-size:15px;">
																		 <?php echo $allDetails->number->totalShifts; ?>
																	</div>
																	<div class="uppercase profile-stat-text" >
																		 Total no of Shift
																	</div>
																</div>
																<div class="col-md-4 col-sm-4 col-xs-6">
																	<div class="uppercase profile-stat-title" style="font-size:15px;">
																		 <?php echo $allDetails->number->totalWorkingHours; ?>
																	</div>
																	<div class="uppercase profile-stat-text">
																		 Working Hours
																	</div>
																</div>
																<div class="col-md-4 col-sm-4 col-xs-6">
																	<div class="uppercase profile-stat-title" style="font-size:15px;">
																		<?php echo gmdate("H:i:s",$total->output->totalOverTimeWorking); ?>
																	</div>
																	<div class="uppercase profile-stat-text">
																		 Overtime hour
																	</div>
																</div>
															</td>
														</tr>
														<!-- <tr>
															<td>
																<span>Total no of Shift<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $number->totalShifts;?> </span>
															</td>
														</tr> -->
														<tr>
															<td>
																<span>Total Attendance<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->totalShifts; ?>   </span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Absent Shifts<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->absent; ?>  </span>
															</td>
														</tr>
														<!-- <tr>
															<td>
																<span>Working Hours<i class="fa fa-img-up"></i></span>
																<span style="float:right;">
																<?php

																		$init = $totalWorkinHour;
																		$hours = floor($init / 3600);
																		$minutes = floor(($init / 60) % 60);
																		$seconds = $init % 60;

																		echo $hours."Hrs ".$minutes."mins ".$seconds."sec ";

																		?>
																</span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Overtime hour<i class="fa fa-img-up"></i></span>
																<span style="float:right;">
																	<?php
																		$init = $totalOverTimes->totalOverTimeWorking;
																		$hours = floor($init / 3600);
																		$minutes = floor(($init / 60) % 60);
																		$seconds = $init % 60;

																		echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																		?>
																</span>
															</td>
														</tr> -->
														<tr>
															<td>
																<span>Late Checkin<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->totalNoOfLateCheckIn; ?> </span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Early Checkout<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->earlyCheckOut; ?> </span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Late Checkout<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $allDetails->number->lateCheck; ?> </span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Total Late Checkin Hours<i class="fa fa-img-up"></i></span>
																<span style="float:right;"> 
																	<?php echo gmdate("H:i:s",$total->output->totalLateCheckInTime); ?>
																</span>
															</td>
															

														</tr>
														<tr>
															<td>
																<span>Total Less To full Work Hours <i class="fa fa-img-up"></i></span>
																<span style="float:right;"> 
																	<?php echo gmdate("H:i:s",$total->output->totalLessToFullWorkTime); ?> 
																</span>
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
						<!-- END PORTLET -->
					</div>
					<!-- ************************************************************************************************************ -->


					<!-- ************************************************************************************************************ -->						





				</div>
				
				<div class="row">
					<!-- <div class="col-md-6">
						<!-- BEGIN PORTLET -->
						<!--<div class="portlet light">
							<div class="portlet-title">
								<div class="caption caption-md">
									<i class="icon-bar-chart theme-font hide"></i>
									<span class="caption-subject font-blue-madison bold uppercase">Customer Support</span>
									<span class="caption-helper">45 pending</span>
								</div>
								<div class="inputs">
									<div class="portlet-input input-inline input-small ">
										<div class="input-icon right">
											<i class="icon-magnifier"></i>
											<input type="text" class="form-control form-control-solid" placeholder="search...">
										</div>
									</div>
								</div>
							</div>
							<div class="portlet-body">
								<div class="scroller" style="height: 305px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
									<div class="general-item-list">
										<div class="item">
											<div class="item-head">
												<div class="item-details">
													<img class="item-pic" src="<?php echo URL_VIEW;?>admin/layout/img/avatar4.jpg">
													<a href="" class="item-name primary-link">Nick Larson</a>
													<span class="item-label">3 hrs ago</span>
												</div>
												<span class="item-status"><span class="badge badge-empty badge-success"></span> Open</span>
											</div>
											<div class="item-body">
												 Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
											</div>
										</div>
										<div class="item">
											<div class="item-head">
												<div class="item-details">
													<img class="item-pic" src="<?php echo URL_VIEW;?>admin/layout/img/avatar3.jpg">
													<a href="" class="item-name primary-link">Mark</a>
													<span class="item-label">5 hrs ago</span>
												</div>
												<span class="item-status"><span class="badge badge-empty badge-warning"></span> Pending</span>
											</div>
											<div class="item-body">
												 Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat tincidunt ut laoreet.
											</div>
										</div>
										<div class="item">
											<div class="item-head">
												<div class="item-details">
													<img class="item-pic" src="<?php echo URL_VIEW;?>admin/layout/img/avatar6.jpg">
													<a href="" class="item-name primary-link">Nick Larson</a>
													<span class="item-label">8 hrs ago</span>
												</div>
												<span class="item-status"><span class="badge badge-empty badge-primary"></span> Closed</span>
											</div>
											<div class="item-body">
												 Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh.
											</div>
										</div>
										<div class="item">
											<div class="item-head">
												<div class="item-details">
													<img class="item-pic" src="<?php echo URL_VIEW;?>admin/layout/img/avatar7.jpg">
													<a href="" class="item-name primary-link">Nick Larson</a>
													<span class="item-label">12 hrs ago</span>
												</div>
												<span class="item-status"><span class="badge badge-empty badge-danger"></span> Pending</span>
											</div>
											<div class="item-body">
												 Consectetuer adipiscing elit Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
											</div>
										</div>
										<div class="item">
											<div class="item-head">
												<div class="item-details">
													<img class="item-pic" src="<?php echo URL_VIEW;?>admin/layout/img/avatar9.jpg">
													<a href="" class="item-name primary-link">Richard Stone</a>
													<span class="item-label">2 days ago</span>
												</div>
												<span class="item-status"><span class="badge badge-empty badge-danger"></span> Open</span>
											</div>
											<div class="item-body">
												 Lorem ipsum dolor sit amet, consectetuer adipiscing elit, ut laoreet dolore magna aliquam erat volutpat.
											</div>
										</div>
										<div class="item">
											<div class="item-head">
												<div class="item-details">
													<img class="item-pic" src="<?php echo URL_VIEW;?>admin/layout/img/avatar8.jpg">
													<a href="" class="item-name primary-link">Dan</a>
													<span class="item-label">3 days ago</span>
												</div>
												<span class="item-status"><span class="badge badge-empty badge-warning"></span> Pending</span>
											</div>
											<div class="item-body">
												 Lorem ipsum dolor sit amet, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
											</div>
										</div>
										<div class="item">
											<div class="item-head">
												<div class="item-details">
													<img class="item-pic" src="<?php echo URL_VIEW;?>admin/layout/img/avatar2.jpg">
													<a href="" class="item-name primary-link">Larry</a>
													<span class="item-label">4 hrs ago</span>
												</div>
												<span class="item-status"><span class="badge badge-empty badge-success"></span> Open</span>
											</div>
											<div class="item-body">
												 Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- END PORTLET -->
					<!--</div> -->
					<!-- <div class="col-md-6"> -->
						<!-- BEGIN PORTLET -->
						<!-- <div class="portlet light tasks-widget">
							<div class="portlet-title">
								<div class="caption caption-md">
									<i class="icon-bar-chart theme-font hide"></i>
									<span class="caption-subject font-blue-madison bold uppercase">Tasks</span>
									<span class="caption-helper">16 pending</span>
								</div>
								<div class="inputs">
									<div class="portlet-input input-small input-inline">
										<div class="input-icon right">
											<i class="icon-magnifier"></i>
											<input type="text" class="form-control form-control-solid" placeholder="search...">
										</div>
									</div>
								</div>
							</div>
							<div class="portlet-body">
								<div class="task-content">
									<div class="scroller" style="height: 282px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
										<!-- START TASK LIST -->
										<!--<ul class="task-list">
											<li>
												<div class="task-checkbox">
													<input type="hidden" value="1" name="test"/>
													<input type="checkbox" class="liChild" value="2" name="test"/>
												</div>
												<div class="task-title">
													<span class="task-title-sp">
													Present 2013 Year IPO Statistics at Board Meeting </span>
													<span class="label label-sm label-success">Company</span>
													<span class="task-bell">
													<i class="fa fa-bell-o"></i>
													</span>
												</div>
												<div class="task-config">
													<div class="task-config-btn btn-group">
														<a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
														<i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
														</a>
														<ul class="dropdown-menu pull-right">
															<li>
																<a href="javascript:;">
																<i class="fa fa-check"></i> Complete </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-pencil"></i> Edit </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-trash-o"></i> Cancel </a>
															</li>
														</ul>
													</div>
												</div>
											</li>
											<li>
												<div class="task-checkbox">
													<input type="checkbox" class="liChild" value=""/>
												</div>
												<div class="task-title">
													<span class="task-title-sp">
													Hold An Interview for Marketing Manager Position </span>
													<span class="label label-sm label-danger">Marketing</span>
												</div>
												<div class="task-config">
													<div class="task-config-btn btn-group">
														<a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
														<i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
														</a>
														<ul class="dropdown-menu pull-right">
															<li>
																<a href="javascript:;">
																<i class="fa fa-check"></i> Complete </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-pencil"></i> Edit </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-trash-o"></i> Cancel </a>
															</li>
														</ul>
													</div>
												</div>
											</li>
											<li>
												<div class="task-checkbox">
													<input type="checkbox" class="liChild" value=""/>
												</div>
												<div class="task-title">
													<span class="task-title-sp">
													AirAsia Intranet System Project Internal Meeting </span>
													<span class="label label-sm label-success">AirAsia</span>
													<span class="task-bell">
													<i class="fa fa-bell-o"></i>
													</span>
												</div>
												<div class="task-config">
													<div class="task-config-btn btn-group">
														<a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
														<i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
														</a>
														<ul class="dropdown-menu pull-right">
															<li>
																<a href="javascript:;">
																<i class="fa fa-check"></i> Complete </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-pencil"></i> Edit </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-trash-o"></i> Cancel </a>
															</li>
														</ul>
													</div>
												</div>
											</li>
											<li>
												<div class="task-checkbox">
													<input type="checkbox" class="liChild" value=""/>
												</div>
												<div class="task-title">
													<span class="task-title-sp">
													Technical Management Meeting </span>
													<span class="label label-sm label-warning">Company</span>
												</div>
												<div class="task-config">
													<div class="task-config-btn btn-group">
														<a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
														<i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
														</a>
														<ul class="dropdown-menu pull-right">
															<li>
																<a href="javascript:;">
																<i class="fa fa-check"></i> Complete </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-pencil"></i> Edit </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-trash-o"></i> Cancel </a>
															</li>
														</ul>
													</div>
												</div>
											</li>
											<li>
												<div class="task-checkbox">
													<input type="checkbox" class="liChild" value=""/>
												</div>
												<div class="task-title">
													<span class="task-title-sp">
													Kick-off Company CRM Mobile App Development </span>
													<span class="label label-sm label-info">Internal Products</span>
												</div>
												<div class="task-config">
													<div class="task-config-btn btn-group">
														<a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
														<i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
														</a>
														<ul class="dropdown-menu pull-right">
															<li>
																<a href="javascript:;">
																<i class="fa fa-check"></i> Complete </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-pencil"></i> Edit </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-trash-o"></i> Cancel </a>
															</li>
														</ul>
													</div>
												</div>
											</li>
											<li>
												<div class="task-checkbox">
													<input type="checkbox" class="liChild" value=""/>
												</div>
												<div class="task-title">
													<span class="task-title-sp">
													Prepare Commercial Offer For SmartVision Website Rewamp </span>
													<span class="label label-sm label-danger">SmartVision</span>
												</div>
												<div class="task-config">
													<div class="task-config-btn btn-group">
														<a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
														<i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
														</a>
														<ul class="dropdown-menu pull-right">
															<li>
																<a href="javascript:;">
																<i class="fa fa-check"></i> Complete </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-pencil"></i> Edit </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-trash-o"></i> Cancel </a>
															</li>
														</ul>
													</div>
												</div>
											</li>
											<li>
												<div class="task-checkbox">
													<input type="checkbox" class="liChild" value=""/>
												</div>
												<div class="task-title">
													<span class="task-title-sp">
													Sign-Off The Comercial Agreement With AutoSmart </span>
													<span class="label label-sm label-default">AutoSmart</span>
													<span class="task-bell">
													<i class="fa fa-bell-o"></i>
													</span>
												</div>
												<div class="task-config">
													<div class="task-config-btn btn-group">
														<a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
														<i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
														</a>
														<ul class="dropdown-menu pull-right">
															<li>
																<a href="javascript:;">
																<i class="fa fa-check"></i> Complete </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-pencil"></i> Edit </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-trash-o"></i> Cancel </a>
															</li>
														</ul>
													</div>
												</div>
											</li>
											<li>
												<div class="task-checkbox">
													<input type="checkbox" class="liChild" value=""/>
												</div>
												<div class="task-title">
													<span class="task-title-sp">
													Company Staff Meeting </span>
													<span class="label label-sm label-success">Cruise</span>
													<span class="task-bell">
													<i class="fa fa-bell-o"></i>
													</span>
												</div>
												<div class="task-config">
													<div class="task-config-btn btn-group">
														<a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
														<i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
														</a>
														<ul class="dropdown-menu pull-right">
															<li>
																<a href="javascript:;">
																<i class="fa fa-check"></i> Complete </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-pencil"></i> Edit </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-trash-o"></i> Cancel </a>
															</li>
														</ul>
													</div>
												</div>
											</li>
											<li class="last-line">
												<div class="task-checkbox">
													<input type="checkbox" class="liChild" value=""/>
												</div>
												<div class="task-title">
													<span class="task-title-sp">
													KeenThemes Investment Discussion </span>
													<span class="label label-sm label-warning">KeenThemes </span>
												</div>
												<div class="task-config">
													<div class="task-config-btn btn-group">
														<a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
														<i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
														</a>
														<ul class="dropdown-menu pull-right">
															<li>
																<a href="javascript:;">
																<i class="fa fa-check"></i> Complete </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-pencil"></i> Edit </a>
															</li>
															<li>
																<a href="javascript:;">
																<i class="fa fa-trash-o"></i> Cancel </a>
															</li>
														</ul>
													</div>
												</div>
											</li>
										</ul>-->
										<!-- END START TASK LIST -->
									<!--</div>
								</div>
								<div class="task-footer">
									<div class="btn-arrow-link pull-right">
										<a href="javascript:;">See All Tasks</a>
									</div>
								</div>
							</div>
						</div> -->
						<!-- END PORTLET -->
					<!-- </div> -->
				</div>
			</div>
			<!-- END PROFILE CONTENT -->
		</div>
	</div>

<!-- END PAGE CONTENT-->

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


