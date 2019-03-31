
<?php 
	
	$loginUserRelationToOthers = loginUserRelationToOther($userId);

	// fal($loginUserRelationToOthers);

	$userOrganization = array();

	foreach ($loginUserRelationToOthers->userOrganization as $key => $value) {
		
			$userOrganization[$key] = key($value);
	}

	$url = URL."ShiftUsers/getAllShiftHistoryOfEmp/".$user_id.".json";
	$data = \Httpful\Request::get($url)->send()->body;

	// fal($data);

 ?>
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>Shift History  <small>Fiscal year</small></h1>
			</div>
			<!-- END PAGE TITLE -->
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="#">Home</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="">Shift Histories</a>
				</li>
			</ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list-ul font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Shift History</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<select class="form-control input-sm" id="yearSelect">
											<?php $cm = date('m'); ?>
											<?php if ($m != 7) {
												$y = date('Y') -1;
											}else
											{
												$y = date('Y');
											} ?>
											<?php $daterange = range(2010, $y, 1);?>
											<?php foreach ($daterange as $year): ?>
												<option value="<?php echo $year; ?>" <?php echo ($year==$y)?"selected":"";?>><?php echo $year; ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<select class="form-control input-sm" id="cycleType">
											<option value="1" selected>Week</option>
											<option value="2">Fortnight</option>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<select class="form-control input-sm" id="wfSelect">
										</select>
									</div>
								</div>
				                <div class="col-md-3">
				                    <p class="help-block" id="yearInfo"></p>
				                </div>
							</div>
								<small>Fiscal Year starts from July 1st to June 30th.</small>
								<div id="shiftHistoryLoading" style="text-align:center;">
									<img src="<?php echo URL_VIEW; ?>admin/layout/img/loading.gif" alt="loading"/>
								</div>
							<div class="tabbable-line" id="shiftHistoryDiv">
								<!-- <ul class="nav nav-tabs shnav-tabs">
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
														                                             <?php echo $value->totalShifts; ?><span class="font-lg font-grey-mint">$</span>
														                                        </div>
														                                    </div>
														                                    <div class="col-md-4 col-sm-12 col-xs-12">
														                                        <div class="font-grey-mint font-sm">
														                                             Total Attendance
														                                        </div>
														                                        <div class="uppercase font-hg theme-font">
														                                             <?php echo $value->totalAttendance; ?> <span class="font-lg font-grey-mint">$</span>
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
														                                             <?php echo $value->totalAbsent; ?> <span class="font-lg font-grey-mint">$</span>
														                                        </div>
														                                    </div>
														                                    <div class="col-md-4 col-sm-12 col-xs-12">
														                                        <div class="font-grey-mint font-sm">
														                                             Total Working Hours
														                                        </div>
														                                        <div class="uppercase font-hg font-purple">
														                                             <?php echo round($value->workedhours, 2); ?> <span class="font-lg font-grey-mint">$</span>
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
													                                             0 <span class="font-lg font-grey-mint">$</span>
													                                        </div>
													                                    </div>
													                                    <div class="col-md-4 col-sm-12 col-xs-12">
													                                        <div class="font-grey-mint font-sm">
													                                             Total Attendance
													                                        </div>
													                                        <div class="uppercase font-hg theme-font">
													                                             0.00 <span class="font-lg font-grey-mint">$</span>
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
													                                             0 <span class="font-lg font-grey-mint">$</span>
													                                        </div>
													                                    </div>
													                                    <div class="col-md-4 col-sm-12 col-xs-12">
													                                        <div class="font-grey-mint font-sm">
													                                             Total Working Hours
													                                        </div>
													                                        <div class="uppercase font-hg font-purple">
													                                             0 <span class="font-lg font-grey-mint">$</span>
													                                        </div>
													                                    </div>
													                                </div>
												</div>
											</div>
										</div>
									<?php endif;?>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTAINER-->
		</div>
		<!-- BEGIN PAGE CONTENT -->
	</div>
	<!-- END PAGE CONTENT -->
</div>
<script src="<?php echo URL_VIEW; ?>js/date-format/date.format.js" type="text/javascript"></script>
<script type="text/javascript">

	$(function()
		{
			function loadShiftHistory(range)
			{
				var str = range.split("/");
                var sD = new Date(str[0]);
                var sD = sD.format("dS mmm, yyyy");

                var eD = new Date(str[1]);
                var eD = eD.format("dS mmm, yyyy");

                $("#yearInfo").html("").append('<i style="color:#BFBFBF;">from</i> '+'<span class="font-green">'+sD+'</span>'+' <i style="color:#BFBFBF;">to</i> '+'<span class="font-green">'+eD+'</span>');

				$("#shiftHistoryLoading").show();
				$("#shiftHistoryDiv").html("").load("../loadShiftHistory.php?range="+range, function(event)
					{
						$("#shiftHistoryLoading").hide();
					});
			}

			function populateWf(year, cycle)
			{
				if(cycle == 1)
				{
					var url = "../getWeekOfFiscalYear.php?year=";
				}else
				{
					var url = "../getFortnightOfFiscalYear.php?year=";
				}
				$.ajax(
					{
						url:url+year,
						type:'post',
						async:false,
						success:function(res)
						{
							var data = JSON.parse(res);
							var opts = "";

							var c = "Week";

							var d = new Date().getTime();
							if(cycle == 2)
							{
								c = "Fortnight";
							}
							$.each(data, function (i,v)
							{
								var str = v.split("/");

								var sD = new Date(str[0]).getTime();
								var eD = new Date(str[1]).getTime();

								var select = "";
								if( d >= sD && d<=eD )
								{
									select = "selected";
								}
							  opts += "<option value="+v+" "+select+">"+c+" "+i+"</option>";
							});

							$("#wfSelect").html("").append(opts);

						}

					});
			}

			populateWf($("#yearSelect").val(), $("#cycleType").val());

			$("#yearSelect").on('change', function(event)
				{
					var year = $(this).val();
					var c = $("#cycleType").val();

					populateWf(year, c);

					var range = $("#wfSelect").val();

					loadShiftHistory(range);

				});

			$("#cycleType").on('change', function(event)
				{
					var year = $("#yearSelect").val();
					var c = $(this).val();

					populateWf(year, c);

					var range = $("#wfSelect").val();

					loadShiftHistory(range);

				});

			$("#wfSelect").on('change', function(event)
				{
					var range = $(this).val();
					loadShiftHistory(range);
				});

			loadShiftHistory($("#wfSelect").val());

		});
</script>