<!-- *************************** Ashok Neupane *************************** -->
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>


<script>
            function pagination1(type,userid,orgid,branchid,page,c){
                if(page=='-'){
                    var pages = parseFloat($(".page_"+c).val())-parseFloat(1);
                }else if(page=="+"){
                    var pages = parseFloat($(".page_"+c).val())+parseFloat(1);
                }else{
                    var pages = page;
                } 
                      
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getLimitReviews&revType="+type+"&userid="+userid+"&orgid="+orgid+"&branchid="+branchid+"&page="+pages,
                    type: "post",
                    success:function(data){
                        var data1 = "";
                        var alldata=JSON.parse(data); 
                      //  console.log(alldata);           
                        $.each(alldata.myReview.datas , function(k,obj){
                            data1 +="<li class='in'><div class='message'><span class='arrow'></span><span class='datetime' style='float: right;'><i>"+obj.Review.reviewdate+"</i></span><br/><span class='body'><b>"+obj.Review.details+"</b></span></div></li>";
                        });
                        
                        $(".ultab_"+c).html(data1);
                        
                        var pages1=alldata.myReview.pages;
                        var limit1=alldata.myReview.limit;
                        var count1=alldata.myReview.counts;
                        var max1=Math.ceil(parseFloat(alldata.myReview.counts)/parseFloat(alldata.myReview.limit));
                        
                        $(".page_"+c).val(pages1);
//                        $(".limit_"+c).val(limit1);
//                        $(".count_"+c).val(count1);
                        $(".max_"+c).val(max1);
                        
                        
                        if(pages1 > 1){
                            $(".prev_"+c).attr("onclick","pagination1('"+type+"','"+userid+"','"+orgid+"','"+branchid+"','-','"+c+"')");
                        }else{
                            $(".prev_"+c).attr("onclick","");
                        }
                        if(pages1 < max1 && count1 > limit1){
                            $(".next_"+c).attr("onclick","pagination1('"+type+"','"+userid+"','"+orgid+"','"+branchid+"','+','"+c+"')");
                        }else{
                            $(".next_"+c).attr("onclick","");
                        }
                    }
                });      
            }
    
            pagination1('written_warning',<?php echo $user_id;?>,<?php echo $_GET['org_id'];?>,<?php echo $_GET['branch_id'];?>,1,'5-5')
            pagination1('verbal_warning',<?php echo $user_id;?>,<?php echo $_GET['org_id'];?>,<?php echo $_GET['branch_id'];?>,1,'6-6')
            pagination1('Feedback',<?php echo $user_id;?>,<?php echo $_GET['org_id'];?>,<?php echo $_GET['branch_id'];?>,1,'7-7')
            pagination1('Review',<?php echo $user_id;?>,<?php echo $_GET['org_id'];?>,<?php echo $_GET['branch_id'];?>,1,'8-8')
</script>

<!-- ******************************************************************************* -->



<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>
<?php
/* ******************** Ashok Neupane **************************************** */
    $url1 = URL."Reviews/myReviews/written_warning/".$user_id."/".$_GET['org_id']."/".$_GET['branch_id']."/1.json";
    $datas_written = \Httpful\Request::get($url1)->send();
    
    $url1 = URL."Reviews/myReviews/verbal_warning/".$user_id."/".$_GET['org_id']."/".$_GET['branch_id']."/1.json";
    $datas_verbal = \Httpful\Request::get($url1)->send();
    
    $url1 = URL."Reviews/myReviews/Review/".$user_id."/".$_GET['org_id']."/".$_GET['branch_id']."/1.json";
    $datas_review = \Httpful\Request::get($url1)->send();
    
    $url1 = URL."Reviews/myReviews/Feedback/".$user_id."/".$_GET['org_id']."/".$_GET['branch_id']."/1.json";
    $datas_feedback = \Httpful\Request::get($url1)->send();
    
    
/* ************************************************************ */
?>
<?php
$orgId = $_GET['org_id'];
$branch_id = $_GET['branch_id'];
//print_r($user_id);

$url = URL ."OrganizationUsers/myOrganizationDetail/".$user_id."/".$orgId."/".$branch_id.".json";
$org = \Httpful\Request::get($url)->send();
$organization = $org->body->myOrganizationDetail;

// echo "<pre>"; print_r($organization);die();

$urlNotice = URL."Noticeboards/getOrganizationNotice/".$orgId.".json";
$numberOfNotices = \Httpful\Request::get($urlNotice)->send()->body;
 //echo "<pre>"; print_r($numberOfNotices);

$url = URL . "OrganizationUsers/organizationEmployeeDetail/".$orgId."/".$user_id.".json";
$data = \Httpful\Request::get($url)->send();
$orgEmployee = $data->body->employee;

// echo "<pre>";
// print_r($orgEmployee);



$orgimage = URL."webroot/files/organization/logo/".$organization->Organization->logo_dir."/thumb_".$organization->Organization->logo;
$image = $organization->Organization->logo;
$gender = $organization->User->gender;
$orgimage = imageGenerate($orgimage,$image,$gender);
											

?>

<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1><?php echo $organization->Organization->title;?> <small>Company subtitle goes here.</small></h1>
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
					<a href="<?=URL_VIEW."organizationUsers/employee/myOrganizations";?>">My Organization</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="javascript:;">Organization Detail</a>
				</li>
            </ul>     
            <hr style="color: red;"/>       
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
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
								My Organization Profile </a>
							</li>
							<li>
								<a href="#tab_1_4" data-toggle="tab">
								Holidays </a>
							</li>
							<li>
								<a href="#tab_1_5" data-toggle="tab">
								Payment Summary </a>
							</li>
							<!--<li>
								<a href="#tab_1_6" data-toggle="tab">
								Help </a>
							</li>-->
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1_1">
								<div class="row">
									<div class="col-md-3">
										<ul class="list-unstyled profile-nav">
											<li>
											
                                             <img src='<?php echo $orgimage; ?>' alt="Organization Logo" class="img-responsive"/>
												
												<a href="javascript:;" class="profile-edit">
												edit </a>
											</li>
											<li>
												<a href="<?php echo URL_VIEW.'users/noticeboard';?>">
												Notices <span><?php echo $numberOfNotices->output;?></span></a>
											</li>
											<li>
												<a href="<?=URL_VIEW.'users/employee/inboxMessages';?>">
												Messages <span>
												<?=$receivedMessage;?> </span>
												</a>
											</li>
											<!--<li>
												<a href="javascript:;">
												Friends </a>
											</li>
											<li>
												<a href="javascript:;">
												Settings </a>
											</li>-->
										</ul>
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="col-md-8 profile-info">
												<h1><?php echo $organization->Organization->title;?></h1>
												<p>
													 Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt laoreet dolore magna aliquam tincidunt erat volutpat laoreet dolore magna aliquam tincidunt erat volutpat.
												</p>
												<p>
													<a href="http://<?php echo $organization->Organization->website;?>" target="_blank">
													<?php echo $organization->Organization->website;?></a>
												</p>
												<!--<ul class="list-inline">
													<li>
														<i class="fa fa-map-marker"></i> Spain
													</li>
													<li>
														<i class="fa fa-calendar"></i> 18 Jan 1982
													</li>
													<li>
														<i class="fa fa-briefcase"></i> Design
													</li>
													<li>
														<i class="fa fa-star"></i> Top Seller
													</li>
													<li>
														<i class="fa fa-heart"></i> BASE Jumping
													</li>
												</ul>-->
											</div>
											<!--end col-md-8-->
											<div class="col-md-4">
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
											<!--end col-md-4-->
										</div>
										<!--end row-->
										<div class="tabbable-line tabbable-custom-profile">
											<ul class="nav nav-tabs">
												<li class="active">
													<a href="#tab_1_11" data-toggle="tab">
													Boards</a>
												</li>
												<li>
													<a href="#tab_1_22" data-toggle="tab">
													Shifts </a>
												</li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="tab_1_11">
													<div class="portlet-body">
														<table class="table table-striped table-bordered table-advance table-hover">
														<thead>
														<tr>
															<th>
																<i class="fa fa-briefcase"></i> Board Name
															</th>
															<th class="hidden-xs">
																<i class="fa fa-question"></i> Board Manager
															</th>
															<th>
																<i class="fa fa-bookmark"></i> No. of Employee
															</th>
															<th>
															</th>
														</tr>
														</thead>
														<tbody>
                                                        <?php
                                                        if(!empty($organization)){
                                                        	
														foreach($organization->Branch->Board as $branchBoard){

														?>
                                                        <tr>
															<td>
																<a href="<?php echo URL_VIEW;?>organizationUsers/employee/myOrgBranchBoardDetail?board_id=<?php echo $branchBoard->id;?>&org_id=<?php echo $orgId;?>&branch_id=<?php echo $branch_id;?>">
																<?php echo $branchBoard->title;?> </a>
															</td>
															<td class="hidden-xs">
																<?php 
																	if($branchBoard->User){
																 	echo $branchBoard->User->fname." ".$branchBoard->User->lname;
																 }
																 else{
															 	
																 	echo "Board Manager not assigned";
																 }
															 	?>
															</td>
															<td>
																 <?php echo count($branchBoard->BoardUser);?> <!--<span class="label label-success label-sm">
																Paid </span>-->
															</td>
															<td>
																<a class="btn default btn-xs green-stripe" href="<?php echo URL_VIEW;?>organizationUsers/employee/myOrgBranchBoardDetail?board_id=<?php echo $branchBoard->id;?>&org_id=<?php echo $orgId;?>&branch_id=<?php echo $branch_id;?>">
																View </a>
															</td>
														</tr>
                                                        <?php }}else{?>
                                                        	<tr>
																<td colspan="4">
																	No data
																</td>
															</tr>
                                                        <?php } ?>
														
														</tbody>
														</table>
													</div>
												</div>
												<!--tab-pane-->
												<div class="tab-pane" id="tab_1_22">
													<div class="portlet-body">
														<table class="table table-striped table-bordered table-advance table-hover">
														<thead>
														<tr>
															<th>
																<i class="fa fa-briefcase"></i> Shift Name
															</th>
															<th class="hidden-xs">
																<i class="fa fa-question"></i> Shift Time
															</th>
															
														</tr>
														</thead>
														<tbody>
                                                        <?php
														foreach($organization->Branch->ShiftBranch as $shiftBranch){
														?>
														<tr>
															<td>
																<a href="javascript:;">
																<?php echo $shiftBranch->Shift->title;?> </a>
															</td>
															<td class="hidden-xs">
																 <?php echo $shiftBranch->Shift->starttime." - ".$shiftBranch->Shift->endtime;?>
															</td>
															
														</tr>
                                                        <?php } ?>
														
														</tbody>
														</table>
													</div>
												</div>
												<!--tab-pane-->
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--tab_1_2-->
							<div class="tab-pane" id="tab_1_3">
								<div class="row profile-account">
									<div class="col-md-3">
										<ul class="ver-inline-menu tabbable margin-bottom-10">
											<li class="active">
												<a data-toggle="tab" href="#tab_1-1">
												<i class="fa fa-cog"></i> Organization Info </a>
												<span class="after">
												</span>
											</li>
											
											<!-- ************************************************** Ashok Neupane ****************************** -->
                                            <li>
												<a data-toggle="tab" href="#tab_5-5">
												<i class="fa fa-exclamation-triangle"></i> Written Warnings 
                                                <span style="float: right;" class="badge badge-info"><?php echo $datas_written->body->myReview->counts;?></span></a>
											</li>
                                            <li>
												<a data-toggle="tab" href="#tab_6-6">
												<i class="fa fa-exclamation-triangle"></i> Verbal Warnings 
                                                <span style="float: right;" class="badge badge-info"><?php echo $datas_verbal->body->myReview->counts;?></span></a>
											</li>
                                            <li>
												<a data-toggle="tab" href="#tab_7-7">
												<i class="fa fa-comment-o"></i> General Feedbacks 
                                                <span style="float: right;" class="badge badge-info"><?php echo $datas_feedback->body->myReview->counts;?></span></a>
											</li>
                                            <li>
												<a data-toggle="tab" href="#tab_8-8">
												<i class="fa fa-comment"></i> General Reviews 
                                                <span style="float: right;" class="badge badge-info"><?php echo $datas_review->body->myReview->counts;?></span></a>
											</li>
											<!-- ******************************************************************************************************* -->
										</ul>
									</div>
									<div class="col-md-9">
										<div class="tab-content">
											<div id="tab_1-1" class="tab-pane active">
												<div class="col-md-10 col-sm-10">
													<div class="table-scrollable table-scrollable-borderless">

														<table class="table table-hover table-light">
														
														<tbody>
														<tr>
															<td>
																<span>Organization<i class="fa fa-img-up"></i></span><span style="float:right;"><?php echo $orgEmployee->Organization->title; ?></span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Organization Branch</span><span style="float:right;"><?php echo $orgEmployee->Branch->title; ?></span>
															</td>
														</tr>
														<tr>
															<td>
																<span>User</span><span style="float:right;"><?php echo $orgEmployee->User->fname.' '.$orgEmployee->User->lname; ?></span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Email</span><span style="float:right;"><?php echo $orgEmployee->User->email; ?></span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Address</span><span style="float:right;"><?php echo $orgEmployee->User->address; ?></span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Designation</span><span style="float:right;"><?php echo $orgEmployee->OrganizationUser->designation; ?></span>
																
															</td>
														</tr>
														<tr>
															<td>
																 <span>Hire Date</span><span style="float:right;"><?php echo $orgEmployee->OrganizationUser->hire_date; ?></span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Wage</span><span style="float:right;"><?php echo $orgEmployee->OrganizationUser->wage; ?></span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Maximum Weekly Hour</span><span style="float:right;"><?php echo $orgEmployee->OrganizationUser->max_weekly_hour; ?></span>
															</td>
														</tr>
														<tr>
															<td>
																<span>Skills</span><span style="float:right;"><?php echo $orgEmployee->OrganizationUser->skills; ?></span>
															</td>
														</tr>
														</tbody>
														</table>
													</div>
												</div>
											</div>
											<div id="tab_2-2" class="tab-pane">
												<p>
													 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
												</p>
												<form action="#" role="form">
													<div class="form-group">
														<div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
																<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
															</div>
															<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
															</div>
															<div>
																<span class="btn default btn-file">
																<span class="fileinput-new">
																Select image </span>
																<span class="fileinput-exists">
																Change </span>
																<input type="file" name="...">
																</span>
																<a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput">
																Remove </a>
															</div>
														</div>
														<div class="clearfix margin-top-10">
															<span class="label label-danger">
															NOTE! </span>
															<span>
															Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
														</div>
													</div>
													<div class="margin-top-10">
														<a href="javascript:;" class="btn green">
														Submit </a>
														<a href="javascript:;" class="btn default">
														Cancel </a>
													</div>
												</form>
											</div>
											<div id="tab_3-3" class="tab-pane">
												<form action="#">
													<div class="form-group">
														<label class="control-label">Current Password</label>
														<input type="password" class="form-control"/>
													</div>
													<div class="form-group">
														<label class="control-label">New Password</label>
														<input type="password" class="form-control"/>
													</div>
													<div class="form-group">
														<label class="control-label">Re-type New Password</label>
														<input type="password" class="form-control"/>
													</div>
													<div class="margin-top-10">
														<a href="javascript:;" class="btn green">
														Change Password </a>
														<a href="javascript:;" class="btn default">
														Cancel </a>
													</div>
												</form>
											</div>
											<div id="tab_4-4" class="tab-pane">
												<form action="#">
													<table class="table table-bordered table-striped">
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
														<a href="javascript:;" class="btn green">
														Save Changes </a>
														<a href="javascript:;" class="btn default">
														Cancel </a>
													</div>
												</form>
											</div>
											<!-- ******************************* Ashok Neupane ********************************* -->

											<div id="tab_5-5" class="tab-pane">
												<?php
												  if($datas_written->body->myReview->counts==0){
												    echo "No Written Warnings";
												  }else{
												    $max5=ceil($datas_written->body->myReview->counts/$datas_written->body->myReview->limit);
												?>
												  <ul class="chats ultab_6-6"></ul><hr />

												<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
												    <ul class="pagination" style="visibility: visible;">
												        <li class="prev">
												            <a title="First" href="#" onclick="pagination1('written_warning','<?php echo $user_id; ?>','<?php echo $_GET['org_id']; ?>','<?php echo $_GET['branch_id']; ?>','1','5-5')"><i class="fa fa-angle-double-left"></i></a>
												        </li>
												        <li class="prev">
												            <a title="Prev" href="#" class="prev_5-5" onclick=""><i class="fa fa-angle-left"></i></a>
												        </li>
												        <li class="next">
												            <a title="Next" href="#" class="next_5-5" onclick=""><i class="fa fa-angle-right"></i></a>
												        </li>
												        <li class="next">
												            <a title="Last" href="#" onclick="pagination1('written_warning','<?php echo $user_id; ?>','<?php echo $_GET['org_id']; ?>','<?php echo $_GET['branch_id']; ?>','<?php echo $max5;?>','5-5')"><i class="fa fa-angle-double-right"></i></a>
												        </li>
												    </ul>
												</div>
												<div class="row"><div class="col-sm-1">Page </div><input class="page_5-5 col-sm-1" disabled="disabled"/><div class="col-sm-1"> Of </div><input class="max_5-5 col-sm-1" disabled="disabled"/></div>
												<?php } ?>
											</div>
											<div id="tab_6-6" class="tab-pane">
												<?php
												  if($datas_verbal->body->myReview->counts==0){
												    echo "No Verbal Warnings";
												  }else{
												    $max6=ceil($datas_verbal->body->myReview->counts/$datas_verbal->body->myReview->limit);
												?>
												    <ul class="chats ultab_6-6"></ul><hr />
												<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
												    <ul class="pagination" style="visibility: visible;">
												        <li class="prev">
												            <a title="First" href="#" onclick="pagination1('verbal_warning','<?php echo $user_id; ?>','<?php echo $_GET['org_id']; ?>','<?php echo $_GET['branch_id']; ?>','1','6-6')"><i class="fa fa-angle-double-left"></i></a>
												        </li>
												        <li class="prev">
												            <a title="Prev" href="#" class="prev_6-6" onclick=""><i class="fa fa-angle-left"></i></a>
												        </li>
												        <li class="next">
												            <a title="Next" href="#" class="next_6-6" onclick=""><i class="fa fa-angle-right"></i></a>
												        </li>
												        <li class="next">
												            <a title="Last" href="#" onclick="pagination1('verbal_warning','<?php echo $user_id; ?>','<?php echo $_GET['org_id']; ?>','<?php echo $_GET['branch_id']; ?>','<?php echo $max6;?>','6-6')"><i class="fa fa-angle-double-right"></i></a>
												        </li>
												    </ul>

												</div>
												<div class="row"><div class="col-sm-1">Page </div><input class="page_6-6 col-sm-1" disabled="disabled"/><div class="col-sm-1"> Of </div><input class="max_6-6 col-sm-1" disabled="disabled"/></div>
												<?php } ?>
											</div>
											<div id="tab_7-7" class="tab-pane">
												<?php
												  if($datas_feedback->body->myReview->counts==0){
												    echo "No Feedbacks";
												  }else{
												    $max7=ceil($datas_feedback->body->myReview->counts/$datas_feedback->body->myReview->limit);
												?>
												    <ul class="chats ultab_7-7"></ul><hr />

												<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
												    <ul class="pagination" style="visibility: visible;">
												        <li class="prev">
												            <a title="First" href="#" onclick="pagination1('Feedback','<?php echo $user_id; ?>','<?php echo $_GET['org_id']; ?>','<?php echo $_GET['branch_id']; ?>','1','7-7')"><i class="fa fa-angle-double-left"></i></a>
												        </li>
												        <li class="prev">
												            <a title="Prev" href="#" class="prev_7-7" onclick=""><i class="fa fa-angle-left"></i></a>
												        </li>
												        <li class="next">
												            <a title="Next" href="#" class="next_7-7" onclick=""><i class="fa fa-angle-right"></i></a>
												        </li>
												        <li class="next">
												            <a title="Last" href="#" onclick="pagination1('Feedback','<?php echo $user_id; ?>','<?php echo $_GET['org_id']; ?>','<?php echo $_GET['branch_id']; ?>','<?php echo $max7;?>','7-7')"><i class="fa fa-angle-double-right"></i></a>
												        </li>
												    </ul>

												</div>
												<div class="row"><div class="col-sm-1">Page </div><input class="page_7-7 col-sm-1" disabled="disabled"/><div class="col-sm-1"> Of </div><input class="max_7-7 col-sm-1" disabled="disabled"/></div>
												<?php } ?>
											</div>
											<div id="tab_8-8" class="tab-pane">
												<?php
												  if($datas_review->body->myReview->counts==0){
												    echo "No Reviews";
												  }else{
												    $max8=ceil($datas_review->body->myReview->counts/$datas_review->body->myReview->limit);
												  ?>
												<ul class="chats ultab_8-8"></ul><hr />
												<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
												    <ul class="pagination" style="visibility: visible;">
												        <li class="prev">
												            <a title="First" href="#" onclick="pagination1('Review','<?php echo $user_id; ?>','<?php echo $_GET['org_id']; ?>','<?php echo $_GET['branch_id']; ?>','1','8-8')"><i class="fa fa-angle-double-left"></i></a>
												        </li>
												        <li class="prev">
												            <a title="Prev" href="#" class="prev_8-8" onclick=""><i class="fa fa-angle-left"></i></a>
												        </li>
												        <li class="next">
												            <a title="Next" href="#" class="next_8-8" onclick=""><i class="fa fa-angle-right"></i></a>
												        </li>
												        <li class="next">
												            <a title="Last" href="#" onclick="pagination1('Review','<?php echo $user_id; ?>','<?php echo $_GET['org_id']; ?>','<?php echo $_GET['branch_id']; ?>','<?php echo $max8;?>','8-8')"><i class="fa fa-angle-double-right"></i></a>
												        </li>

												    </ul>

												</div>
												<div class="row"><div class="col-sm-1">Page </div><input class="page_8-8 col-sm-1" disabled="disabled"/><div class="col-sm-1"> Of </div><input class="max_8-8 col-sm-1" disabled="disabled"/></div>
												<?php } ?>
											</div>
											<!-- ******************************************************************************* -->
										</div>
									</div>
									<!--end col-md-9-->
								</div>
							</div>
							<!--end tab-pane-->
							<div class="tab-pane" id="tab_1_4">
								<div class="row">
									<div class="col-md-12">
										<div class="add-portfolio">
											<span>
											502 Items sold this week </span>
											<a href="javascript:;" class="btn icn-only green">
											Add a new Project <i class="m-icon-swapright m-icon-white"></i>
											</a>
										</div>
									</div>
								</div>
								<!--end add-portfolio-->
								<div class="row portfolio-block">
									<div class="col-md-5">
										<div class="portfolio-text">
											<img src="../../assets/admin/pages/media/profile/logo_metronic.jpg" alt=""/>
											<div class="portfolio-text-info">
												<h4>Metronic - Responsive Template</h4>
												<p>
													 Lorem ipsum dolor sit consectetuer adipiscing elit.
												</p>
											</div>
										</div>
									</div>
									<div class="col-md-5 portfolio-stat">
										<div class="portfolio-info">
											 Today Sold <span>
											187 </span>
										</div>
										<div class="portfolio-info">
											 Total Sold <span>
											1789 </span>
										</div>
										<div class="portfolio-info">
											 Earns <span>
											$37.240 </span>
										</div>
									</div>
									<div class="col-md-2">
										<div class="portfolio-btn">
											<a href="javascript:;" class="btn bigicn-only">
											<span>
											Manage </span>
											</a>
										</div>
									</div>
								</div>
								<!--end row-->
								<div class="row portfolio-block">
									<div class="col-md-5 col-sm-12 portfolio-text">
										<img src="../../assets/admin/pages/media/profile/logo_azteca.jpg" alt=""/>
										<div class="portfolio-text-info">
											<h4>Metronic - Responsive Template</h4>
											<p>
												 Lorem ipsum dolor sit consectetuer adipiscing elit.
											</p>
										</div>
									</div>
									<div class="col-md-5 portfolio-stat">
										<div class="portfolio-info">
											 Today Sold <span>
											24 </span>
										</div>
										<div class="portfolio-info">
											 Total Sold <span>
											660 </span>
										</div>
										<div class="portfolio-info">
											 Earns <span>
											$7.060 </span>
										</div>
									</div>
									<div class="col-md-2 col-sm-12 portfolio-btn">
										<a href="javascript:;" class="btn bigicn-only">
										<span>
										Manage </span>
										</a>
									</div>
								</div>
								<!--end row-->
								<div class="row portfolio-block">
									<div class="col-md-5 portfolio-text">
										<img src="../../assets/admin/pages/media/profile/logo_conquer.jpg" alt=""/>
										<div class="portfolio-text-info">
											<h4>Metronic - Responsive Template</h4>
											<p>
												 Lorem ipsum dolor sit consectetuer adipiscing elit.
											</p>
										</div>
									</div>
									<div class="col-md-5 portfolio-stat">
										<div class="portfolio-info">
											 Today Sold <span>
											24 </span>
										</div>
										<div class="portfolio-info">
											 Total Sold <span>
											975 </span>
										</div>
										<div class="portfolio-info">
											 Earns <span>
											$21.700 </span>
										</div>
									</div>
									<div class="col-md-2 portfolio-btn">
										<a href="javascript:;" class="btn bigicn-only">
										<span>
										Manage </span>
										</a>
									</div>
								</div>
								<!--end row-->
							</div>
							<!--end tab-pane-->

							<!-- *****************************Ashok Senpai********************************************************** -->

							<div class="tab-pane" id="tab_1_5">
								<?php 
									 if(isset($_POST['submit_date'])){

								        $url = URL."ShiftUsers/paymentFactorsByShiftId/".$user_id."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
								        $response = \Httpful\Request::get($url)->send();
								    }else

								    {
								        $url = URL."ShiftUsers/paymentFactorsByShiftId/".$user_id.".json";
								        $response = \Httpful\Request::get($url)->send();
								    }

								    if($response->body->output =='0')
						            {
						                echo "<script> toastr.warning('No Valid Data.');</script>";
						            }

								    if(isset($response->body->arr)){
								        $shiftFactors = $response->body->arr;
								    }
								    
								    // echo "<pre>";
								    // echo print_r($shiftFactors);
								    // die();
								?>

								<?php 

								if(isset($_POST['submit_date'])){

								     $url1 = URL."ShiftUsers/getTotalAttendace/".$user_id."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
								    $response1 = \Httpful\Request::get($url1)->send();
								}else{

								     $url1 = URL."ShiftUsers/getTotalAttendace/".$user_id.".json";
								      $response1 = \Httpful\Request::get($url1)->send();
								}
								    $total = $response1->body;

								 if($response1->body->output =='0')
						            {
						                echo "<script> toastr.warning('No Valid Data.');</script>";
						            }   

								    // echo "<pre>";
								    //     echo print_r($total);
								    //     die();
								 ?>

								<!-- tab portion -->
								<h3 class="page-title">
								   User Income
								</h3>
								<div class="page-bar">
								    <ul class="page-breadcrumb">
								        <li>
								            <i class="fa fa-home"></i>
								            <a href="#">Home</a>
								            <i class="fa fa-angle-right"></i>
								        </li>
								        <li>
								            <a href="#">Income</a>
								        </li>
								    </ul>
								</div>

								<!-- //**************************************** -->

								<!-- //**************************************** -->
								<div class="col-md-8">
									<div class="tiles">
									    <div class="tile bg-purple">
									        <div class="tile-body">
									            <i class="fa fa-bar-chart-o"></i>
									        </div>
									        <div class="tile-object">
									            <div class="name">
									                 Total Attendance
									            </div>
									            <div id="grandShifts" class="number">
									            <?php echo $total->totalShifts; ?>
									            </div>
									        </div>
									    </div>
									    <div class="tile bg-purple">
									        <div class="tile-body">
									            <i class="fa fa-briefcase"></i>
									        </div>
									        <div class="tile-object">
									            <div class="name">
									                 Total Payment Offers
									            </div>
									            <div id="payfactors" class="number">
									                <?php echo $total->totalTitle; ?>
									            </div>
									        </div>
									    </div>
									    
									   <!--  <div class="tile bg-purple">
									        <div class="corner">
									        </div>
									        <div class="check">
									        </div>
									        <div class="tile-body">
									            <i class="fa fa-cogs"></i>
									        </div>
									        <div class="tile-object">
									            <div class="name">
									                 Settings
									            </div>
									        </div>
									    </div> -->
									    <div class="tile bg-purple">
									        <div class="tile-body">
									            <i class="fa fa-plane"></i>
									        </div>
									        <div class="tile-object">
									            <div class="name">
									                 Projects
									            </div>
									            <div class="number">
									                 34
									            </div>
									        </div>
									    </div>
									</div>
								</div>
								<div class="collapse navbar-collapse navbar-ex1-collapse">  
								    <form id="dateForm" role="form" method="post" action="">
								        <div class="form-group" stlye="float:right;">
								                 <label>Date Range</label>
								                 <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"  data-date-format="yyyy-mm-dd">
								                    <input type="text" class="form-control" id="input_start" name="data[start_date]" required />
								                    <span class="input-group-addon">
								                    to </span>
								                    <input type="text" class="form-control" id="input_end" name="data[end_date]" required />
								                 </div> 
								        </div><span>
								            
								        <div class="form-actions"> 
								            <input type="submit" class="btn blue applyBtn"  value="Submit" >
								            
								        </div></span> 
								    </form> 
								</div>
								<br/>

								<div class="col-md-4" >

								    <div class="portlet sale-summary">
								        <div class="portlet-title">
								            <div class="caption label label-info">
								                 Income Summary
								            </div>
								            <div class="tools">
								                <a class="reload totalShiftSpinner"  data-original-title="" title="">
								                </a>
								            </div>
								        </div>
								        <div class="portlet-body">
								            <ul class="list-unstyled">
								                <li>
								                    <span class="sale-info">
								                    Working hours  :<i class="fa fa-img-down"></i>
								                    </span>
								                    <span id="totalHours" class="sale-num">
								                    <?php if(isset($shiftFactors)){echo $shiftFactors->grandTotalHours;}else{echo 0;}?> </span>
								                </li>


								                <li>
								                    <span class="sale-info">
								                    Total Income :<i class="fa fa-img-up"></i>
								                    </span>
								                    <span id="totalAmount" class="sale-num">
								                   $<?php if(isset($shiftFactors)){echo $shiftFactors->grandTotalPayment;}else{echo 0;} ?>
								                   </span>
								                </li>
								                
								                <li>
								                    <span class="sale-info">
								                    Tax Amount :</span>
								                    <span id="taxAmount" class="sale-num">
								                    $<?php if(isset($shiftFactors)){echo $shiftFactors->taxableAmount;}else{echo 0;}?> </span>
								                </li>
								                <li>
								                    <span  class="sale-info">
								                    Final EARNING:</span>
								                    <span id="taxDeduction" class="sale-num">
								                    $<?php if(isset($shiftFactors)){echo $shiftFactors->afterTaxDeduction;}else{echo 0;}?></span>
								                </li>
								            </ul>
								        </div>
								    </div>
								    <div>
							            <a href="#portlet-33"  data-toggle="modal">View all details</a>
							        </div>
								</div>
								<!-- //*********************************************************** -->
								<div class="modal fade" id="portlet-33" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							    <div class="modal-dialog">
							        <div class="modal-content">
							            <div class="modal-header">
							                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							                            <h4 class="modal-title">Income Summary</h4>
							            </div>
							                <div class="modal-body">
							                <div class="well">
							                    <table class="table">
							                        <thead>
							                        <tr>
							                            <td>PAYMENT TYPE</td>
							                            <td>WORKING HOURS</td>
							                            <td>PAYMENT</td>
							                        </tr>
							                        </thead>
							                       <tbody id="factorPayment">
							                        <?php 
							                        
							                            if(isset($shiftFactors)){
							                            foreach($shiftFactors as $title=>$factor){ ?>
							                                <?php if(isset($factor->workingHour)){ ?>
							                               <tr>
							                                 <td><?php echo $title;?></td>
							                                 <td><?php echo $factor->workingHour;?> </td>   
							                                 <td>$<?php echo $factor->payment;?></td> 
							                               </tr> 
							                                <?php } ?>       
							                            <?php }}else{ ?>
							                            <tr>
							                                 <td>-</td>
							                                 <td>- </td>   
							                                 <td>-</td> 
							                               </tr> 
							                            <?php } ?>

							                        </tbody>
							                        
							                    </table>

							                 
							                </div>

							                </div>

							            </div>

							    </div>
								</div>
							</div>
							<!-- *****************************/Ashok Senpai********************************************************** -->

							<div class="tab-pane" id="tab_1_6">
								<div class="row">
									<div class="col-md-3">
										<ul class="ver-inline-menu tabbable margin-bottom-10">
											<li class="active">
												<a data-toggle="tab" href="#tab_1">
												<i class="fa fa-briefcase"></i> General Questions </a>
												<span class="after">
												</span>
											</li>
											<li>
												<a data-toggle="tab" href="#tab_2">
												<i class="fa fa-group"></i> Membership </a>
											</li>
											<li>
												<a data-toggle="tab" href="#tab_3">
												<i class="fa fa-leaf"></i> Terms Of Service </a>
											</li>
											<li>
												<a data-toggle="tab" href="#tab_1">
												<i class="fa fa-info-circle"></i> License Terms </a>
											</li>
											<li>
												<a data-toggle="tab" href="#tab_2">
												<i class="fa fa-tint"></i> Payment Rules </a>
											</li>
											<li>
												<a data-toggle="tab" href="#tab_3">
												<i class="fa fa-plus"></i> Other Questions </a>
											</li>
										</ul>
									</div>
									<div class="col-md-9">
										<div class="tab-content">
											<div id="tab_1" class="tab-pane active">
												<div id="accordion1" class="panel-group">
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_1">
															1. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
															</h4>
														</div>
														<div id="accordion1_1" class="panel-collapse collapse in">
															<div class="panel-body">
																 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_2">
															2. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
															</h4>
														</div>
														<div id="accordion1_2" class="panel-collapse collapse">
															<div class="panel-body">
																 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</div>
														</div>
													</div>
													<div class="panel panel-success">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_3">
															3. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor ? </a>
															</h4>
														</div>
														<div id="accordion1_3" class="panel-collapse collapse">
															<div class="panel-body">
																 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</div>
														</div>
													</div>
													<div class="panel panel-warning">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_4">
															4. Wolf moon officia aute, non cupidatat skateboard dolor brunch ? </a>
															</h4>
														</div>
														<div id="accordion1_4" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</div>
														</div>
													</div>
													<div class="panel panel-danger">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_5">
															5. Leggings occaecat craft beer farm-to-table, raw denim aesthetic ? </a>
															</h4>
														</div>
														<div id="accordion1_5" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_6">
															6. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth ? </a>
															</h4>
														</div>
														<div id="accordion1_6" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_7">
															7. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft ? </a>
															</h4>
														</div>
														<div id="accordion1_7" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
															</div>
														</div>
													</div>
												</div>
											</div>
											<div id="tab_2" class="tab-pane">
												<div id="accordion2" class="panel-group">
													<div class="panel panel-warning">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_1">
															1. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
															</h4>
														</div>
														<div id="accordion2_1" class="panel-collapse collapse in">
															<div class="panel-body">
																<p>
																	 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
																</p>
																<p>
																	 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
																</p>
															</div>
														</div>
													</div>
													<div class="panel panel-danger">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_2">
															2. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
															</h4>
														</div>
														<div id="accordion2_2" class="panel-collapse collapse">
															<div class="panel-body">
																 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</div>
														</div>
													</div>
													<div class="panel panel-success">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_3">
															3. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor ? </a>
															</h4>
														</div>
														<div id="accordion2_3" class="panel-collapse collapse">
															<div class="panel-body">
																 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_4">
															4. Wolf moon officia aute, non cupidatat skateboard dolor brunch ? </a>
															</h4>
														</div>
														<div id="accordion2_4" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_5">
															5. Leggings occaecat craft beer farm-to-table, raw denim aesthetic ? </a>
															</h4>
														</div>
														<div id="accordion2_5" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_6">
															6. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth ? </a>
															</h4>
														</div>
														<div id="accordion2_6" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_7">
															7. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft ? </a>
															</h4>
														</div>
														<div id="accordion2_7" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
															</div>
														</div>
													</div>
												</div>
											</div>
											<div id="tab_3" class="tab-pane">
												<div id="accordion3" class="panel-group">
													<div class="panel panel-danger">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_1">
															1. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
															</h4>
														</div>
														<div id="accordion3_1" class="panel-collapse collapse in">
															<div class="panel-body">
																<p>
																	 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
																</p>
																<p>
																	 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.
																</p>
																<p>
																	 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
																</p>
															</div>

														</div>
													</div>
													<div class="panel panel-success">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_2">
															2. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry ? </a>
															</h4>
														</div>
														<div id="accordion3_2" class="panel-collapse collapse">
															<div class="panel-body">
																 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_3">
															3. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor ? </a>
															</h4>
														</div>
														<div id="accordion3_3" class="panel-collapse collapse">
															<div class="panel-body">
																 Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_4">
															4. Wolf moon officia aute, non cupidatat skateboard dolor brunch ? </a>
															</h4>
														</div>
														<div id="accordion3_4" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_5">
															5. Leggings occaecat craft beer farm-to-table, raw denim aesthetic ? </a>
															</h4>
														</div>
														<div id="accordion3_5" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_6">
															6. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth ? </a>
															</h4>
														</div>
														<div id="accordion3_6" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
															</div>
														</div>
													</div>
													<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_7">
															7. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft ? </a>
															</h4>
														</div>
														<div id="accordion3_7" class="panel-collapse collapse">
															<div class="panel-body">
																 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--end tab-pane-->
						</div>
					</div>
					<!--END TABS-->
				</div>
			</div>
			<!-- END PAGE CONTENT-->












<?php /* ?>
<div class="tableHeader">
   

<!-- Table -->
<div class="profile myorgprofile">
        <!-- Table -->


        <div class="basic-info">
            <table>
        <tbody>
        <tr>
            <th>Organization Name</th>
            <td>: <?php echo $organization->Organization->title;?></td>
        </tr>
        <tr>
            <th>Branch Name</th>
            <td>: <?php echo $organization->Branch->title;?></td>
        </tr>

        <tr>
            <th>Username</th>
            <td>: <?php echo $organization->User->username;?></td>
        </tr>
        
        <tr>
            <th>logo</th>
            <td>: 999</td>
        </tr>
        
        <tr>
            <th>Email</th>
            <td>: <?php echo $organization->Branch->email;?></td>
        </tr> 
        
        <tr>
            <th>Address</th>
            <td>: <?php echo $organization->Branch->address;?></td>
        </tr> 

        <tr>
            <th>Phone Number</th>
            <td>: <?php echo $organization->Branch->phone;?></td>
        </tr> 

        <tr>
            <th>Fax</th>
            <td>: <?php echo $organization->Branch->fax;?></td>
        </tr> 

        <tr>
            <th>Website</th>
            <td>: <?php echo $organization->Organization->website;?></td>
        </tr> 

        <tr>
            <th>City</th>
            <td>: <?php echo $organization->Branch->City->title;?></td>
        </tr> 

        <tr>
            <th>Country</th>
            <td>: <?php echo $organization->Branch->Country->title;?></td>
        </tr>  
    </tbody></table>
</div>
<div class="pic">
    </div>


<!-- End of Table -->
</div>
<?php */?>


<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->


<!-- BEGIN PAGE LEVEL SCRIPTS -->


<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>


<script>
	$('.applyBtn').attr('type',"submit");
	$("#dateForm").submit(function(event)
    {
    	event.preventDefault();
	       // alert('hello');
	       var d = $("#input_start").val();
	       var e = $("#input_end").val();

        //var totalWork=0;
        var totalIncome=0;
        var totalTax=0;
        var netEarning=0;

        console.log(d);
        console.log(e);

        getPaymentFactorsById();
        function getPaymentFactorsById()
            {
                var userId = '<?php echo $user_id;?>';
                var url= '<?php echo URL."ShiftUsers/paymentFactorsByShiftId/"."'+userId+'"."/"."'+d+'"."/"."'+e+'".".json";?>';
                var url1= '<?php echo URL."ShiftUsers/getTotalAttendace/"."'+userId+'"."/"."'+d+'"."/"."'+e+'".".json";?>';
   				
   				

   				$.ajax(

                	{
                        url:url1,
                        data:'post',
                        datatype:'jsonp',
                        success:function(response)
                        {
                           // console.log(response);
                             if(response.output==1){

	                             totalShifts =  response.totalShifts;
	                             $("#grandShifts").html(totalShifts); 

	                          // // console.log(response.arr.grandTotalHours);

	                              totalTitle = response.totalTitle;
	                             $("#payfactors").html(totalTitle);
	                            
	                           
                             }else {

                             	$("#grandShifts").html('0');
                             	$("#payfactors").html('0');
                             }
                         
                        }
                    });



                $.ajax(

                	{
                        url:url,
                        data:'post',
                        datatype:'jsonp',
                        success:function(response)
                        {

                        	//console.log(response);

                            //console.log(response);
                            if(response.output==1){

                            	
	                            $('.totalShiftSpinner').click();

	                            totalIncome = totalIncome + response.arr.grandTotalPayment;
	                            $("#totalAmount").html(totalIncome); 

	                          // console.log(response.arr.grandTotalHours);

	                             totalTax = totalTax + response.arr.taxableAmount;
	                            $("#taxAmount").html(totalTax);
	                            
	                             netEarning = netEarning + response.arr.afterTaxDeduction;
	                            $("#taxDeduction").html(netEarning);


	                            totalWork = response.arr.grandTotalHours;
	                            $("#totalHours").html(totalWork);

								var data="";
								$("#factorPayment").html("");
	                            $.each(response.arr, function(key, value)
	                            	{
										

										if(typeof(value) === 'object')
										{
											data= "<tr><td>"+key+"</td><td>"+value.workingHour+"</td><td>"+value.payment+"</td></tr>";
											$("#factorPayment").append(data);

										}
	                            	});
                            }
                            else{

                            		// alert('Hello');
	                            $('.totalShiftSpinner').click();
	                            $("#totalAmount").html('$0.00'); 
	                            $("#taxAmount").html('$0.00');
	                            $("#taxDeduction").html('$0.00');
	                            $("#totalHours").html('00:00:00');

	                            $("#factorPayment").html("<tr><td>No data</td><td>No data</td><td>No data</td></tr> ");
	                           

                            }

                        }
                    });

                             // console.log(toHis('19563'));

            }

            //***********************************************************************************


            
            //***********************************************************************************
    
    });             	
</script>

<script>
jQuery(document).ready(function() {
   TableManaged.init();
   ComponentsPickers.init();

});
</script>