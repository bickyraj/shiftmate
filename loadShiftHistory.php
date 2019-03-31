<?php
	session_start();
	include('config.php');
	include('function.php');
	//include('loginCheck.php');
	include('url_get_value.php');

	$range = explode("/", $_GET['range']);
	$sDate = $range[0];
	$eDate = $range[1];

	$loginUserRelationToOthers = loginUserRelationToOther($userId);

	// fal($loginUserRelationToOthers);

	$userOrganization = array();

	foreach ($loginUserRelationToOthers->userOrganization as $key => $value) {
		
			$userOrganization[$key] = key($value);
	}

	$url = URL."ShiftUsers/getAllShiftHistoryOfEmp/".$user_id."/".$sDate."/".$eDate.".json";
	$data = \Httpful\Request::get($url)->send()->body;

	// fal($data);


?>

<ul class="nav nav-tabs shnav-tabs">
	<li class="active">
		<a href="#tab_15_0" data-toggle="tab">
		All </a>
	</li>
	<?php foreach ($userOrganization as $key => $value): ?>
		<li>
			<a href="#tab_15_<?php echo $key; ?>" data-toggle="tab">
			<?php echo $value; ?></a>
		</li>
	<?php endforeach ?>
</ul>
<div class="tab-content">
	<?php if ($data->status == 1): ?>
		<?php foreach ($data->total as $key=>$value): ?>
			<div class="tab-pane <?php echo ($key==0)?"active":"" ?>" id="tab_15_<?php echo $key;?>">
				<div class="row">
					<div class="col-md-7">
						<div class="table-scrollable table-scrollable-borderless">
							<table class="table table-hover table-light">
								<tr>
									<td>
										<a href="javascript:;" class="primary-link">Overtime hour</a>
									</td>
									<td>
										<span class="bold theme-font"><?php echo round($value->morehours, 2); ?></span>
									</td>
								</tr>
								<tr>
									<td>
										<a href="javascript:;" class="primary-link">Late Checkin</a>
									</td>
									<td>
										<span class="bold theme-font"><?php echo $value->totalLateCheckin; ?></span>
									</td>
								</tr>
								<tr>
									<td>
										<a href="javascript:;" class="primary-link">Early Checkout</a>
									</td>
									<td>
										<span class="bold theme-font"><?php echo $value->totalEarlyCheckout; ?></span>
									</td>
								</tr>
								<tr>
									<td>
										<a href="javascript:;" class="primary-link">Late Checkout</a>
									</td>
									<td>
										<span class="bold theme-font"><?php echo $value->totalLateCheckout; ?></span>
									</td>
								</tr>
								<tr>
									<td>
										<a href="javascript:;" class="primary-link">Total Late Checkin Hours</a>
									</td>
									<td>
										<span class="bold theme-font"><?php echo round($value->totalLateCheckinHours, 2); ?></span>
									</td>
								</tr>
								<tr>
									<td>
										<a href="javascript:;" class="primary-link">Total Less To full Work Hours </a>
									</td>
									<td>
										<span class="bold theme-font"><?php echo round($value->lesshours, 2); ?></span>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="col-md-5">
						<div class="row list-separated">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="font-grey-mint font-sm">
                                     Total Shifts
                                </div>
                                <div class="uppercase font-hg font-red-flamingo">
                                     <?php echo $value->totalShifts; ?><!-- <span class="font-lg font-grey-mint">$</span> -->
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="font-grey-mint font-sm">
                                     Total Attendance
                                </div>
                                <div class="uppercase font-hg theme-font">
                                     <?php echo $value->totalAttendance; ?> <!-- <span class="font-lg font-grey-mint">$</span> -->
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row list-separated">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="font-grey-mint font-sm">
                                     Absent
                                </div>
                                <div class="uppercase font-hg font-purple">
                                     <?php echo $value->totalAbsent; ?> <!-- <span class="font-lg font-grey-mint">$</span> -->
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="font-grey-mint font-sm">
                                     Total Working Hours
                                </div>
                                <div class="uppercase font-hg font-purple">
                                     <?php echo round($value->workedhours, 2); ?> <!-- <span class="font-lg font-grey-mint">$</span> -->
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	<?php else: ?>
		<div class="tab-pane" id="tab_15_<?php echo $key; ?>">
			<div class="row">
				<div class="col-md-7">
					<div class="table-scrollable table-scrollable-borderless">
						<table class="table table-hover table-light">
							<tr>
								<td>
									<a href="javascript:;" class="primary-link">Overtime hour</a>
								</td>
								<td>
									<span class="bold theme-font">0</span>
								</td>
							</tr>
							<tr>
								<td>
									<a href="javascript:;" class="primary-link">Late Checkin</a>
								</td>
								<td>
									<span class="bold theme-font">0</span>
								</td>
							</tr>
							<tr>
								<td>
									<a href="javascript:;" class="primary-link">Early Checkout</a>
								</td>
								<td>
									<span class="bold theme-font">0</span>
								</td>
							</tr>
							<tr>
								<td>
									<a href="javascript:;" class="primary-link">Late Checkout</a>
								</td>
								<td>
									<span class="bold theme-font">0</span>
								</td>
							</tr>
							<tr>
								<td>
									<a href="javascript:;" class="primary-link">Total Late Checkin Hours</a>
								</td>
								<td>
									<span class="bold theme-font">0</span>
								</td>
							</tr>
							<tr>
								<td>
									<a href="javascript:;" class="primary-link">Total Less To full Work Hours </a>
								</td>
								<td>
									<span class="bold theme-font">0</span>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="col-md-5">
					<div class="row list-separated">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="font-grey-mint font-sm">
                                 Total Shifts
                            </div>
                            <div class="uppercase font-hg font-red-flamingo">
                                 0 <!-- <span class="font-lg font-grey-mint">$</span> -->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="font-grey-mint font-sm">
                                 Total Attendance
                            </div>
                            <div class="uppercase font-hg theme-font">
                                 0.00 <!-- <span class="font-lg font-grey-mint">$</span> -->
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row list-separated">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="font-grey-mint font-sm">
                                 Absent
                            </div>
                            <div class="uppercase font-hg font-purple">
                                 0 <!-- <span class="font-lg font-grey-mint">$</span> -->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="font-grey-mint font-sm">
                                 Total Working Hours
                            </div>
                            <div class="uppercase font-hg font-purple">
                                 0 <!-- <span class="font-lg font-grey-mint">$</span> -->
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	<?php endif;?>
</div>