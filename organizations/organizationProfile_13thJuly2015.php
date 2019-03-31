<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>
<?php
	
	$url = URL . "Organizations/OrganizationProfile/" . $orgId . ".json";
	$data = \Httpful\Request::get($url)->send();
	$org_profile = $data->body->output;

	// echo "<pre>";
	// print_r($org_profile);
	// die();

?>

<h3 class="page-title">
	Organization Profile <small>Company subtitle goes here.</small>
</h3>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="index.html">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<a href="#">Organization Profile</a>
		</li>
	</ul>
	
</div>

<!-- <h1><?php echo $org_profile->Organization->title;?></h1>

<img src='<?php echo URL."webroot/files/organization/logo/".$org_profile->Organization->logo_dir."/thumb_".$org_profile->Organization->logo;?>'/>

<ul>
	<li><?php echo $org_profile->Organization->address;?></li>
	<li><?php echo $org_profile->Organization->phone;?></li>
	<li><?php echo $org_profile->Organization->fax;?></li>
	<li><?php echo $org_profile->Organization->website;?></li>

	<li><?php echo $org_profile->City->title;?></li>
	<li><?php echo $org_profile->Country->title;?></li>
</ul>

<?php $number_of_branches = count($org_profile->Branch);?>
<h2>Branches (<?php echo $number_of_branches;?>)</h2>

<ul>
<?php foreach( $org_profile->Branch as $branch):?>


	<li><a href="<?php echo URL_VIEW.'Branches/viewBranch?branch_id='.$branch->id;?>"><?php echo $branch->title;?></a></li>
<?php endforeach;?>
</ul>



<?php $number_of_boards = count($org_profile->Board);?>
<h2>Boards (<?php echo $number_of_boards;?>)</h2>

<ul>
<?php foreach( $org_profile->Board as $board):?>

	<li><?php echo $board->title;?></li>
<?php endforeach;?>
</ul>


<?php $number_of_groups = count($org_profile->Group);?>
<h2>Groups (<?php echo $number_of_groups;?>)</h2>

<ul>
<?php foreach( $org_profile->Group as $group):?>

	<li><?php echo $group->title;?></li>
<?php endforeach;?>
</ul> -->

<div class="row profile">
				<div class="col-md-12">
					<!--BEGIN TABS-->
					<div class="tabbable-line tabbable-full-width">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_1_1" data-toggle="tab">
								Overview </a>
							</li>
							<li>
								<a href="#tab_1_3" data-toggle="tab">
								Branch </a>
							</li>
							<li>
								<a href="#tab_1_4" data-toggle="tab">
								Board </a>
							</li>
							<li>
								<a href="#tab_1_6" data-toggle="tab">
								Group </a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1_1">
								<div class="tab-pane active" id="tab_1_1">
								<div class="row">
									<div class="col-md-3">
										<ul class="list-unstyled profile-nav">
											<li>
												<img src='<?php echo URL."webroot/files/organization/logo/".$org_profile->Organization->logo_dir."/thumb_".$org_profile->Organization->logo;?>' alt="Orgtanization Image"/>
												<!-- <a href="javascript:;" class="profile-edit">
												edit </a> -->
											</li>
											<li>
												<a href="javascript:;">
												Projects </a>
											</li>
											<li>
												<a href="javascript:;">
												Messages <span>
												3 </span>
												</a>
											</li>
											<li>
												<a href="javascript:;">
												Friends </a>
											</li>
											<li>
												<a href="<?php echo URL_VIEW . 'organizations/orgEdit?org_id='.$orgId ?>">
												Settings </a>
											</li>
										</ul>
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="col-md-8 profile-info">
												<h1><?php echo $org_profile->Organization->title;?></h1>
												<!-- <p>
													Description Goes Here.......
												</p> -->
												<p>
													<a href="javascript:;" target="blank">
													<?php echo $org_profile->Organization->website;?></a>
												</p>
												<ul class="list-unstyled">
															<li>
																<span class="sale-info">
																<?php echo $org_profile->Organization->address;?><i class="fa fa-img-up"></i>
																</span>
															</li>
															<li>
																<span class="sale-info">
																<?php echo $org_profile->Organization->phone;?><i class="fa fa-img-down"></i>
																</span>
															</li>
															<li>
																<span class="sale-info">
																<?php echo $org_profile->Organization->fax;?></span>
															</li>
															<!-- <li>
																<span class="sale-info">
																<?php echo $org_profile->Organization->website;?></span>
															</li> -->
															<li>
																<span class="sale-info">
																<?php echo $org_profile->City->title;?></span>
															</li>
															<li>
																<span class="sale-info">
																<?php echo $org_profile->Country->title;?></span>
															</li>
														</ul>
											</div> 
											<!--end col-md-8-->
											<div class="col-md-4">
												<div class="portlet sale-summary">
													
													<div class="portlet-body">
														<div class="portlet sale-summary">
													<div class="portlet-title">
														<div class="caption">
															 Sales Summary
														</div>
														<div class="tools">
															<a class="reload" href="javascript:;">
															</a>
														</div>
													</div>
													<div class="portlet-body">
														<ul class="list-unstyled">
															<li>
																<span class="sale-info">
																TODAY SOLD <i class="fa fa-img-up"></i>
																</span>
																<span class="sale-num">
																23 </span>
															</li>
															<li>
																<span class="sale-info">
																WEEKLY SALES <i class="fa fa-img-down"></i>
																</span>
																<span class="sale-num">
																87 </span>
															</li>
															<li>
																<span class="sale-info">
																TOTAL SOLD </span>
																<span class="sale-num">
																2377 </span>
															</li>
															<li>
																<span class="sale-info">
																EARNS </span>
																<span class="sale-num">
																$37.990 </span>
															</li>
														</ul>
													</div>
												</div>
													</div>
												</div>
											</div>
											<!--end col-md-4-->
										</div>
										<!--end row-->
										<div class="tabbable-line tabbable-custom-profile">
											<ul class="nav nav-tabs">
												<li class="active">
													<a href="#tab_1_11" data-toggle="tab">
													Latest Customers </a>
												</li>
												<li>
													<a href="#tab_1_22" data-toggle="tab">
													Feeds </a>
												</li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="tab_1_11">
													<div class="portlet-body">
														<table class="table table-striped table-bordered table-advance table-hover">
														<thead>
														<tr>
															<th>
																<i class="fa fa-briefcase"></i> Company
															</th>
															<th class="hidden-xs">
																<i class="fa fa-question"></i> Descrition
															</th>
															<th>
																<i class="fa fa-bookmark"></i> Amount
															</th>
															<th>
															</th>
														</tr>
														</thead>
														<tbody>
														<tr>
															<td>
																<a href="javascript:;">
																Pixel Ltd </a>
															</td>
															<td class="hidden-xs">
																 Server hardware purchase
															</td>
															<td>
																 52560.10$ <span class="label label-success label-sm">
																Paid </span>
															</td>
															<td>
																<a class="btn default btn-xs green-stripe" href="javascript:;">
																View </a>
															</td>
														</tr>
														<tr>
															<td>
																<a href="javascript:;">
																Smart House </a>
															</td>
															<td class="hidden-xs">
																 Office furniture purchase
															</td>
															<td>
																 5760.00$ <span class="label label-warning label-sm">
																Pending </span>
															</td>
															<td>
																<a class="btn default btn-xs blue-stripe" href="javascript:;">
																View </a>
															</td>
														</tr>
														<tr>
															<td>
																<a href="javascript:;">
																FoodMaster Ltd </a>
															</td>
															<td class="hidden-xs">
																 Company Anual Dinner Catering
															</td>
															<td>
																 12400.00$ <span class="label label-success label-sm">
																Paid </span>
															</td>
															<td>
																<a class="btn default btn-xs blue-stripe" href="javascript:;">
																View </a>
															</td>
														</tr>
														<tr>
															<td>
																<a href="javascript:;">
																WaterPure Ltd </a>
															</td>
															<td class="hidden-xs">
																 Payment for Jan 2013
															</td>
															<td>
																 610.50$ <span class="label label-danger label-sm">
																Overdue </span>
															</td>
															<td>
																<a class="btn default btn-xs red-stripe" href="javascript:;">
																View </a>
															</td>
														</tr>
														<tr>
															<td>
																<a href="javascript:;">
																Pixel Ltd </a>
															</td>
															<td class="hidden-xs">
																 Server hardware purchase
															</td>
															<td>
																 52560.10$ <span class="label label-success label-sm">
																Paid </span>
															</td>
															<td>
																<a class="btn default btn-xs green-stripe" href="javascript:;">
																View </a>
															</td>
														</tr>
														<tr>
															<td>
																<a href="javascript:;">
																Smart House </a>
															</td>
															<td class="hidden-xs">
																 Office furniture purchase
															</td>
															<td>
																 5760.00$ <span class="label label-warning label-sm">
																Pending </span>
															</td>
															<td>
																<a class="btn default btn-xs blue-stripe" href="javascript:;">
																View </a>
															</td>
														</tr>
														<tr>
															<td>
																<a href="javascript:;">
																FoodMaster Ltd </a>
															</td>
															<td class="hidden-xs">
																 Company Anual Dinner Catering
															</td>
															<td>
																 12400.00$ <span class="label label-success label-sm">
																Paid </span>
															</td>
															<td>
																<a class="btn default btn-xs blue-stripe" href="javascript:;">
																View </a>
															</td>
														</tr>
														</tbody>
														</table>
													</div>
												</div>
												<!--tab-pane-->
												<div class="tab-pane" id="tab_1_22">
													<div class="tab-pane active" id="tab_1_1_1">
														<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
															<ul class="feeds">
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-success">
																					<i class="fa fa-bell-o"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 You have 4 pending tasks. <span class="label label-danger label-sm">
																					Take action <i class="fa fa-share"></i>
																					</span>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 Just now
																		</div>
																	</div>
																</li>
																<li>
																	<a href="javascript:;">
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-success">
																					<i class="fa fa-bell-o"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New version v1.4 just lunched!
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 20 mins
																		</div>
																	</div>
																	</a>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-danger">
																					<i class="fa fa-bolt"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 Database server #12 overloaded. Please fix the issue.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 24 mins
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-info">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 30 mins
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-success">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 40 mins
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-warning">
																					<i class="fa fa-plus"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New user registered.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 1.5 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-success">
																					<i class="fa fa-bell-o"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 Web server hardware needs to be upgraded. <span class="label label-inverse label-sm">
																					Overdue </span>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 2 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-default">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 3 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-warning">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 5 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-info">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 18 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-default">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 21 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-info">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 22 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-default">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 21 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-info">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 22 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-default">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 21 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-info">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 22 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-default">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 21 hours
																		</div>
																	</div>
																</li>
																<li>
																	<div class="col1">
																		<div class="cont">
																			<div class="cont-col1">
																				<div class="label label-info">
																					<i class="fa fa-bullhorn"></i>
																				</div>
																			</div>
																			<div class="cont-col2">
																				<div class="desc">
																					 New order received. Please take care of it.
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col2">
																		<div class="date">
																			 22 hours
																		</div>
																	</div>
																</li>
															</ul>
														</div>
													</div>
												</div>
												<!--tab-pane-->
											</div>
										</div>
									</div>
								</div>
							</div>
							</div>
							<!--tab_1_2-->
							<div class="tab-pane" id="tab_1_3">
								
								<div class="row">
									<div class="col-md-12">
										<div class="add-portfolio">
											<?php $number_of_branches = count($org_profile->Branch);?>
											<span>
												Number Of Branches (<?php echo $number_of_branches;?>)
											</span>
										</div>
									</div>
								</div>
								<?php foreach( $org_profile->Branch as $branch):?>
									<div class="row portfolio-block">
										<div class="col-md-5">
											<div class="portfolio-text">
												<div class="portfolio-text-info">
													<!-- <h4>Metronic - Responsive Template</h4> -->
													<h4>
														<a href="<?php echo URL_VIEW.'Branches/viewBranch?branch_id='.$branch->id;?>"><?php echo $branch->title;?></a>
													</h4>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach;?>
							</div>
							<!--end tab-pane-->
							<div class="tab-pane" id="tab_1_4">
								<div class="row">
									<div class="col-md-12">
										<div class="add-portfolio">
											<?php $number_of_boards = count($org_profile->Board);?>
											<span>
												Number Of Boards (<?php echo $number_of_boards;?>)
											</span>
										</div>
									</div>
								</div>
								<?php foreach( $org_profile->Board as $board):?>
									<div class="row portfolio-block">
										<div class="col-md-5">
											<div class="portfolio-text">
												<div class="portfolio-text-info">
													<!-- <h4>Metronic - Responsive Template</h4> -->
													<h4>
														<?php echo $board->title;?>
													</h4>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach;?>
							</div>
							<!--end tab-pane-->
							<div class="tab-pane" id="tab_1_6">
								
								<div class="row">
									<div class="col-md-12">
										<div class="add-portfolio">
											<?php $number_of_groups = count($org_profile->Group);?>
											<span>
												Number Of Groups (<?php echo $number_of_groups;?>)
											</span>
										</div>
									</div>
								</div>
								<?php foreach( $org_profile->Group as $group):?>
									<div class="row portfolio-block">
										<div class="col-md-5">
											<div class="portfolio-text">
												<div class="portfolio-text-info">
													<!-- <h4>Metronic - Responsive Template</h4> -->
													<h4>
														<?php echo $group->title;?>
													</h4>
												</div>
											</div>
										</div>
									</div>
								<?php endforeach;?>
							</div>
							<!--end tab-pane-->
						</div>
					</div>
					<!--END TABS-->
				</div>
			</div>
