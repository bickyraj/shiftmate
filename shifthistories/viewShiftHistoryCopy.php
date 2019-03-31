<?php 

if(isset($_POST['submit']))
{
		$url8= URL."ShiftUsers/getByDate.json";
        $response8 = \Httpful\Request::post($url8)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

$response8=$response8->body->output;
// fal($response8);
}

if(isset($_POST['submit1']))
{
		$url9= URL."ShiftUsers/getByDate.json";
        $response9 = \Httpful\Request::post($url9)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
$response9=$response9->body->output;
		// echo "<pre>";
		// print_r($response9);
		// die();


}

 ?>


<link href="<?php echo URL_VIEW;?>admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Shift History</h1>
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
                <a href="<?=URL_VIEW."shifthistories/viewShiftHistory";?>">Shift History</a>
            </li>
        </ul>


<div class="row">
             <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">

                        <div class="portlet-title tabbable-line">

							<div class="caption caption-md">
								<i class="icon-bar-chart theme-font hide"></i>
								<span class="caption-subject theme-font bold uppercase">My Shift History</span>
								<!-- <span class="caption-helper hide">weekly stats...</span> -->
							</div>

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



    <div class="portlet-body">
                            <!--BEGIN TABS-->
            <div class="tab-content">
            	<?php if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)):?>
            	<?php
					$count=0;
            		 foreach ($loginUserRelationToOther->userOrganization as $orgid=>$org_detail):
					$count++;

					
						$url = URL."ShiftUsers/myShifts/".$user_id."/".$orgid.".json";
						$response = \Httpful\Request::get($url)->send();
						// fal($response);

						$url1 = URL."ShiftUsers/getCount/".$user_id."/".$orgid.".json";
						$response1 = \Httpful\Request::get($url1)->send();

						// fal($response1);


						$url2= URL."ShiftUsers/getTotal/".$user_id."/".$orgid.".json";
						$response2 = \Httpful\Request::get($url2)->send();
						// fal($response2);

						$url3= URL."ShiftUsers/getOverTime/".$user_id."/".$orgid.".json";
						$response3 = \Httpful\Request::get($url3)->send();
						// fal($response3);


						// $myShifts = $response->body->myShifts;
						// fal($myShifts);

						$number = $response1->body->number;

						$totalWorkinHour = $response2->body->output;

						$totalOverTimes = $response3->body->output;
					
						$totalOverTimeWorking = $totalOverTimes->totalOverTimeWorking;
            	 	
            	 	?>


                    <div class="tab-pane <?php if($count==1){echo 'active';}?>" id="tab_1_<?php echo $orgid;?>">
                        <div class="portlet"  data-always-visible="1" data-rail-visible="0">


								  <form role="form" method="post" action="">
											<div class="form-group" stlye="float:right;">
											<input type="hidden" value="<?php echo $user_id;?>" name="data[ShiftUser][user_id]">
											<input type="hidden" value="<?php echo $orgid;?>" name="data[ShiftUser][organization_id]">
											         <label>Date Range</label>
											         <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"  data-date-format="yyyy-mm-dd">
											            <input type="text" class="form-control" name="data[ShiftUser][start_date]" value="<?php if(isset($response8)){if($response8->OrgId == $orgid){ echo $response8->start_date; }} ?>" required />
											            <span class="input-group-addon">
											            to </span>
											            <input type="text" class="form-control" name="data[ShiftUser][end_date]" value="<?php if(isset($response8)){if($response8->OrgId == $orgid){ echo $response8->end_date; }} ?>" required>
											         </div> <span ></span>
											</div><span>
												
											<div class="form-actions">
												<input type="submit" class="btn blue"  value="Submit" name="submit">
												
											</div></span>
									</form>             
								      	
                            
							<?php 
							if(isset($response8)){
									if($response8->OrgId == $orgid){ ?>
										

								
								<ul class="feeds accordion task-list scrollable" id="accordion2">


									<!-- PORTLET MAIN -->
											<div class="portlet light">
	
												<!-- STAT -->
												<div class="row list-separated profile-stat" >
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															<?php echo $response8->number->totalShifts; ?>
														</div>
														<div class="uppercase profile-stat-text">
															 Total no of Shift
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $response8->number->present; ?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Total Attendance
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $response8->number->absent;?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Absent Shifts
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="profile-stat-title" style="font-size:18px;">
															
															<?php
																$init = $response8->totalWorkinHour;
																$hours = floor($init / 3600);
																$minutes = floor(($init / 60) % 60);
																$seconds = $init % 60;

																echo $hours."Hrs ".$minutes."mins ".$seconds."sec ";

																?>
														</div>
														<div class="uppercase profile-stat-text">
															 Working Hours
														</div>
													</div>
												</div>
												<!-- END STAT -->
											</div>


								
									<!-- END TAB PORTLET-->
										<div class="table table-striped table-hover">
															
													<div class="portlet-body"  style="font-size:16px;">
														<ul class="list-unstyled">
															<li>
																<span class="sale-info">
																Overtime hour:<i class="fa fa-img-up"></i>
																</span>
																<span class="sale-num">
																<?php
																	$init = $response8->totalOverTimeWorking;
																	$hours = floor($init / 3600);
																	$minutes = floor(($init / 60) % 60);
																	$seconds = $init % 60;

																	echo $hours."hrs ".$minutes."mins ".$seconds."sec ";
																?>

															</li>
															<li>
																<span class="sale-info">
																Late Checkin :<i class="fa fa-img-down"></i>
																</span>
																<span class="sale-num">
																<?php echo $response8->number->totalNoOfLateCheckIn;?></span>
															</li>
															<li>
																<span class="sale-info">
																Early Checkout :</span>
																<span class="sale-num">
																<?php echo $response8->number->earlyCheckOut;?> </span>
															</li>
															<li>
																<span class="sale-info">
																Late Checkout : </span>
																<span class="sale-num">
																<?php echo $response8->number->lateCheck;?></span>
															</li>

															<li>
																	<span class="sale-info">
																	Total Late Checkin Hours : </span>
																	<span class="sale-num">
																	
																	<?php
																			$init =$response8->totalLateCheckInTime;
																			$hours = floor($init / 3600);
																			$minutes = floor(($init / 60) % 60);
																			$seconds = $init % 60;

																			echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																			?>

																	</span>
																</li>	
																<li>
																	<span class="sale-info">
																	Total Less To full Work Hours : </span>
																	<span class="sale-num">
																	
																	<?php
																			$init = $response8->totalLessToFullWorkTime;
																			$hours = floor($init / 3600);
																			$minutes = floor(($init / 60) % 60);
																			$seconds = $init % 60;

																			echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																			?>

																	</span>
																</li>


														</ul>

													</div>
											</div>
			                             			
									</ul>


				



									<?php }else{ ?>
									 <ul class="feeds accordion task-list scrollable" id="accordion2">

						    

									<!-- PORTLET MAIN -->
											<div class="portlet light">
	
												<!-- STAT -->
												<div class="row list-separated profile-stat" >
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $number->totalShifts;?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Total no of Shift
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $number->present;?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Total Attendance
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $number->absent;?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Absent Shifts
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="profile-stat-title" style="font-size:18px;">
															
															<?php
																$init = $totalWorkinHour;
																$hours = floor($init / 3600);
																$minutes = floor(($init / 60) % 60);
																$seconds = $init % 60;

																echo $hours."Hrs ".$minutes."mins ".$seconds."sec ";

																?>
														</div>
														<div class="uppercase profile-stat-text">
															 Working Hours
														</div>
													</div>
												</div>
												<!-- END STAT -->
											</div>


								
							<!-- END TAB PORTLET-->
								<div class="table table-striped table-hover">
													
											<div class="portlet-body"  style="font-size:16px;">
												<ul class="list-unstyled">
													<li>
														<span class="sale-info">
														Overtime hour:<i class="fa fa-img-up"></i>
														</span>
														<span class="sale-num">
														<?php
															$init = $totalOverTimes->totalOverTimeWorking;
															$hours = floor($init / 3600);
															$minutes = floor(($init / 60) % 60);
															$seconds = $init % 60;

															echo $hours."hrs ".$minutes."mins ".$seconds."sec ";
															?>

													</li>
													<li>
														<span class="sale-info">
														Late Checkin :<i class="fa fa-img-down"></i>
														</span>
														<span class="sale-num">
														<?php echo $number->totalNoOfLateCheckIn;?></span>
													</li>
													<li>
														<span class="sale-info">
														Early Checkout :</span>
														<span class="sale-num">
														<?php echo $number->earlyCheckOut;?> </span>
													</li>
													<li>
														<span class="sale-info">
														Late Checkout : </span>
														<span class="sale-num">
														<?php echo $number->lateCheck;?></span>
													</li>

													<li>
															<span class="sale-info">
															Total Late Checkin Hours : </span>
															<span class="sale-num">
															
															<?php
																	$init =$totalOverTimes->totalLateCheckInTime;
																	$hours = floor($init / 3600);
																	$minutes = floor(($init / 60) % 60);
																	$seconds = $init % 60;

																	echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																	?>

															</span>
														</li>	
														<li>
															<span class="sale-info">
															Total Less To full Work Hours : </span>
															<span class="sale-num">
															
															<?php
																	$init = $totalOverTimes->totalLessToFullWorkTime;
																	$hours = floor($init / 3600);
																	$minutes = floor(($init / 60) % 60);
																	$seconds = $init % 60;

																	echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																	?>

															</span>
														</li>


												</ul>

											</div>
									</div>
	                             			
							</ul>
					<?php }}else{ ?>


 							<ul class="feeds accordion task-list scrollable" id="accordion2">

						    

									<!-- PORTLET MAIN -->
											<div class="portlet light">
	
												<!-- STAT -->
												<div class="row list-separated profile-stat" >
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $number->totalShifts;?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Total no of Shift
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $number->present;?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Total Attendance
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $number->absent;?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Absent Shifts
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="profile-stat-title" style="font-size:18px;">
															
															<?php
																$init = $totalWorkinHour;
																$hours = floor($init / 3600);
																$minutes = floor(($init / 60) % 60);
																$seconds = $init % 60;

																echo $hours."Hrs ".$minutes."mins ".$seconds."sec ";

																?>
														</div>
														<div class="uppercase profile-stat-text">
															 Working Hours
														</div>
													</div>
												</div>
												<!-- END STAT -->
											</div>


								
							<!-- END TAB PORTLET-->
								<div class="table table-striped table-hover">
													
											<div class="portlet-body"  style="font-size:16px;">
												<ul class="list-unstyled">
													<li>
														<span class="sale-info">
														Overtime hour:<i class="fa fa-img-up"></i>
														</span>
														<span class="sale-num">
														<?php
															$init = $totalOverTimes->totalOverTimeWorking;
															$hours = floor($init / 3600);
															$minutes = floor(($init / 60) % 60);
															$seconds = $init % 60;

															echo $hours."hrs ".$minutes."mins ".$seconds."sec ";
															?>

													</li>
													<li>
														<span class="sale-info">
														Late Checkin :<i class="fa fa-img-down"></i>
														</span>
														<span class="sale-num">
														<?php echo $number->totalNoOfLateCheckIn;?></span>
													</li>
													<li>
														<span class="sale-info">
														Early Checkout :</span>
														<span class="sale-num">
														<?php echo $number->earlyCheckOut;?> </span>
													</li>
													<li>
														<span class="sale-info">
														Late Checkout : </span>
														<span class="sale-num">
														<?php echo $number->lateCheck;?></span>
													</li>

													<li>
															<span class="sale-info">
															Total Late Checkin Hours : </span>
															<span class="sale-num">
															
															<?php
																	$init =$totalOverTimes->totalLateCheckInTime;
																	$hours = floor($init / 3600);
																	$minutes = floor(($init / 60) % 60);
																	$seconds = $init % 60;

																	echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																	?>

															</span>
														</li>	
														<li>
															<span class="sale-info">
															Total Less To full Work Hours : </span>
															<span class="sale-num">
															
															<?php
																	$init = $totalOverTimes->totalLessToFullWorkTime;
																	$hours = floor($init / 3600);
																	$minutes = floor(($init / 60) % 60);
																	$seconds = $init % 60;

																	echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																	?>

															</span>
														</li>


												</ul>

											</div>
									</div>
	                             			
							</ul>


							<?php	} ?>
                        </div>
                    </div>

            	<?php endforeach;?>
            	
      



            	<!-- default tab -->

			<?php            	       								
			$url4 = URL."ShiftUsers/myShifts/".$user_id.".json";
			$response4 = \Httpful\Request::get($url4)->send();

			$url5 = URL."ShiftUsers/getCount/".$user_id.".json";
			$response5 = \Httpful\Request::get($url5)->send();


			/*$url03 = URL."ShiftUsers/getTotal/".$user_id.".json";
			$response03 = \Httpful\Request::get($url03)->send();*/


			$url6= URL."ShiftUsers/getTotal/".$user_id.".json";
			$response6 = \Httpful\Request::get($url6)->send();

			$url7= URL."ShiftUsers/getOverTime/".$user_id.".json";
			$response7 = \Httpful\Request::get($url7)->send();



			$myShifts = $response4->body->myShifts;
			$number = $response5->body->number;
			$totalWorkinHour = $response6->body->output;
			$totalOverTimes = $response7->body->output;
			

					/*	echo "<pre>";
						print_r($totalOverTimes);
						die();
            	 	*/
			
			?>
            	<div class="tab-pane" id="tab_9_def">

                        	<div class="portlet"  data-always-visible="1" data-rail-visible="0">
	                             <ul class="feeds accordion task-list scrollable" id="accordion2">
										<!-- PORTLET MAIN -->
												<div class="portlet light">

									<!-- Date Input Form Start -->					

									    <form role="form" method="post" action="">
												<div class="form-group" stlye="float:right;">
												<input type="hidden" value="<?php echo $user_id;?>" name="data[ShiftUser][user_id]" />
												         <label>Date Range</label>
												         <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"  data-date-format="yyyy-mm-dd">
												            <input type="text" class="form-control" name="data[ShiftUser][start_date]" value= "<?php if(isset($response9)){ echo $response9->start_date; } ?>" required />
												            <span class="input-group-addon">
												            to </span>
												            <input type="text" class="form-control" name="data[ShiftUser][end_date]" value= "<?php if(isset($response9)){ echo $response9->end_date; } ?>" required />
												         </div>
												</div><span>	
												<div class="form-actions">
													<input type="submit" class="btn blue"  value="Submit" name="submit1">
													
												</div></span>
										</form>

								<!-- Date Input Form end -->		

									<?php 
									if(isset($response9)){
											 ?>




								<ul class="feeds accordion task-list scrollable" id="accordion2">


									<!-- PORTLET MAIN -->
											<div class="portlet light">
	
												<!-- STAT -->
												<div class="row list-separated profile-stat" >
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															<?php echo $response9->number->totalShifts; ?>
														</div>
														<div class="uppercase profile-stat-text">
															 Total no of Shift
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $response9->number->present; ?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Total Attendance
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $response9->number->absent;?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Absent Shifts
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="profile-stat-title" style="font-size:18px;">
															
															<?php
																$init = $response9->totalWorkinHour;
																$hours = floor($init / 3600);
																$minutes = floor(($init / 60) % 60);
																$seconds = $init % 60;

																echo $hours."Hrs ".$minutes."mins ".$seconds."sec ";

																?>
														</div>
														<div class="uppercase profile-stat-text">
															 Working Hours
														</div>
													</div>
												</div>
												<!-- END STAT -->
											</div>


								
									<!-- END TAB PORTLET-->
									<div class="table table-striped table-hover">
														
												<div class="portlet-body"  style="font-size:16px;">
													<ul class="list-unstyled">
														<li>
															<span class="sale-info">
															Overtime hour:<i class="fa fa-img-up"></i>
															</span>
															<span class="sale-num">
															<?php
																$init = $response9->totalOverTimeWorking;
																$hours = floor($init / 3600);
																$minutes = floor(($init / 60) % 60);
																$seconds = $init % 60;

																echo $hours."hrs ".$minutes."mins ".$seconds."sec ";
															?>

														</li>
														<li>
															<span class="sale-info">
															Late Checkin :<i class="fa fa-img-down"></i>
															</span>
															<span class="sale-num">
															<?php echo $response9->number->totalNoOfLateCheckIn;?></span>
														</li>
														<li>
															<span class="sale-info">
															Early Checkout :</span>
															<span class="sale-num">
															<?php echo $response9->number->earlyCheckOut;?> </span>
														</li>
														<li>
															<span class="sale-info">
															Late Checkout : </span>
															<span class="sale-num">
															<?php echo $response9->number->lateCheck;?></span>
														</li>

														<li>
																<span class="sale-info">
																Total Late Checkin Hours : </span>
																<span class="sale-num">
																
																<?php
																		$init =$response9->totalLateCheckInTime;
																		$hours = floor($init / 3600);
																		$minutes = floor(($init / 60) % 60);
																		$seconds = $init % 60;

																		echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																		?>

																</span>
															</li>	
															<li>
																<span class="sale-info">
																Total Less To full Work Hours : </span>
																<span class="sale-num">
																
																<?php
																		$init = $response9->totalLessToFullWorkTime;
																		$hours = floor($init / 3600);
																		$minutes = floor(($init / 60) % 60);
																		$seconds = $init % 60;

																		echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																		?>

																</span>
															</li>


													</ul>

												</div>
										</div>
		                             			
								</ul>


				



											<?php }else{ ?>







												<!-- STAT -->
												<div class="row list-separated profile-stat" >
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $number->totalShifts;?> 

														</div>
														<div class="uppercase profile-stat-text">
															 Total no of Shift
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $number->present;?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Total Attendance
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="uppercase profile-stat-title">
															 <?php echo $number->absent;?> 
														</div>
														<div class="uppercase profile-stat-text">
															 Absent Shifts
														</div>
													</div>
													<div class="col-md-3 ">
														<div class="profile-stat-title" style="font-size:18px;">
															
															<?php

																		$init = $totalWorkinHour;
																		$hours = floor($init / 3600);
																		$minutes = floor(($init / 60) % 60);
																		$seconds = $init % 60;

																		echo $hours."Hrs ".$minutes."mins ".$seconds."sec ";

																		?>
														</div>
														<div class="uppercase profile-stat-text">
															 Working Hours
														</div>
													</div>
												</div>
												<!-- END STAT -->
												
									</div>
								
									<!-- END TAB PORTLET-->
										<div class="portlet sale-summary">
															
															<div class="portlet-body"  style="font-size:16px;">
																<ul class="list-unstyled">
																	<li>
																		<span class="sale-info">
																		Overtime hour:<i class="fa fa-img-up"></i>
																		</span>
																		<span class="sale-num">
																		<?php
																				$init = $totalOverTimes->totalOverTimeWorking;
																				$hours = floor($init / 3600);
																				$minutes = floor(($init / 60) % 60);
																				$seconds = $init % 60;

																				echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																				?>
																	</li>
																	<li>
																		<span class="sale-info">
																		Late Checkin :<i class="fa fa-img-down"></i>
																		</span>
																		<span class="sale-num">
																		<?php echo $number->totalNoOfLateCheckIn;?></span>
																	</li>
																	<li>
																		<span class="sale-info">
																		Early Checkout :</span>
																		<span class="sale-num">
																		<?php echo $number->earlyCheckOut;?> </span>
																	</li>
																	<li>
																		<span class="sale-info">
																		Late Checkout : </span>
																		<span class="sale-num">
																		<?php echo $number->lateCheck;?></span>
																	</li>
																	<li>
																		<span class="sale-info">
																		Total Late Checkin Hours : </span>
																		<span class="sale-num">
																		
																		<?php
																				$init = $totalOverTimes->totalLateCheckInTime;
																				$hours = floor($init / 3600);
																				$minutes = floor(($init / 60) % 60);
																				$seconds = $init % 60;

																				echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																				?>

																		</span>
																	</li>
																	<li>
																	<span class="sale-info">
																	Total Less To full Work Hours : </span>
																	<span class="sale-num">
																	
																	<?php
																			$init = $totalOverTimes->totalLessToFullWorkTime;
																			$hours = floor($init / 3600);
																			$minutes = floor(($init / 60) % 60);
																			$seconds = $init % 60;

																			echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

																			?>

																	</span>
																</li>

																</ul>
															</div>
														</div>
				                             	</ul>
		                    </div>
		                </div>



				<?php } ?>


            </div>
            <!--END TABS-->
    </div>

<?php else:?>
	<div>No Data.</div>
<?php endif;?>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script>

$(".date-picker").datepicker();

jQuery(document).ready(function() {       
 TableManaged.init();
 ComponentsPickers.init();
});
</script>