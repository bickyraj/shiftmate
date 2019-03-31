<script>
	function pagination1(branchid,page){
		$.ajax({
			url: "<?php echo URL."OrganizationUsers/getBranchUsersAjax/";?>"+branchid+"/"+page+".json",
			datatype:"jsonp",
			success:function(alldata){
				var data1 = "";
				$.each(alldata.branchUser , function(k1,v1){

					if(ImageExist(v1['User']['imagepath']) && v1['User']['imagepath'] != ""){
						var imgurl = v1['User']['imagepath'];
					}else{
						if(v1['User']['gender']==0){
							var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/defaultuser.png";
						}else{
							var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/femaleadmin.png";
						}
					}
					data1 +='<tr class="odd gradeX"><td>'+
							'<img src="'+imgurl+'" alt="User Image" width="65" width="65"/>'+
							'</td><td>'+
							'<a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=';?>'+v1['User']['id']+'">'+v1['User']['fname']+" "+v1['User']['lname']+'</a>'+
							'</td> <td>'+v1['OrganizationUser']['designation']+
							'</td> <td>'+v1['User']['email']+
							'</td> <td>'+v1['User']['address']+
							'</td> <td>'+v1['User']['phone']+
							'</td> <td class="action_td">'+
							'<a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=';?>'+v1['User']['id']+'"><button class="btn btn-xs default btn-editable">'+
							'<i class="fa fa-eye"></i> View</button></a> </td></tr>';
				});

				$(".branchUsersAjax").html(data1);

				var pages=alldata.pageOption.page;
				var maxPage=alldata.pageOption.pageCount;

				var paging1='<div>Showing Page '+pages+' of '+maxPage+'</div>'+
						'<ul class="pagination" style="visibility: visible;">';
				if(alldata.pageOption.prevPage){
					paging1 += '<li><a title="First" href="javascript:;" onclick="pagination1(<?=$_GET['branch_id'];?>,1)"><i class="fa fa-angle-double-left"></i></a></li><li><a title="Prev" href="javascript:;" onclick="pagination1(<?=$_GET['branch_id'];?>,'+(parseInt(pages)-parseInt(1))+')"><i class="fa fa-angle-left"></i></a></li>';
				}else{
					paging1 += '<li class="disabled"><a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a></li><li class="disabled"><a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>';
				}

				if(maxPage<=5) {
					for (var i = 1; i <= maxPage; i++) {
						if (pages == i) {
							var class1 = "blue";
						} else {
							var class1 = "";
						}
						paging1 += '<li><a title="' + i + '" href="javascript:;" onclick="pagination1(<?=$_GET['branch_id'];?>, '+i+')" class="btn '+class1+'">'+i+'</a> </li>';
					}
				}else {
					if((pages-2)>=1 && (pages+2)<=maxPage){
						for(var i=(pages-2);i<=(pages+2);i++) {
							if (pages == i) {
								var class1 = "blue";
							} else {
								var class1 = "";
							}
							paging1 += '<li><a title="' + i + '" href="javascript:;" onclick="pagination1(<?=$_GET['branch_id'];?>, '+i+')" class="btn '+class1+'">'+i+'</a> </li>';
						}}else if((pages-2)<1){
							for(var i=1;i<=5;i++) {
								if (pages == i) {
									var class1 = "blue";
								} else {
									var class1 = "";
								}
								paging1 += '<li><a title="' + i + '" href="javascript:;" onclick="pagination1(<?=$_GET['branch_id'];?>, '+i+')" class="btn '+class1+'">'+i+'</a> </li>';
							}
						}else if((pages+2)>maxPage){
							for (var i=(maxPage-4);i<=maxPage;i++){
								if (pages == i) {
									var class1 = "blue";
								} else {
									var class1 = "";
								}
								paging1 += '<li><a title="' + i + '" href="javascript:;" onclick="pagination1(<?=$_GET['branch_id'];?>, '+i+')" class="btn '+class1+'">'+i+'</a> </li>';
							}
						}
					}
						if(alldata.pageOption.nextPage){
							paging1 += '<li><a title="Next" href="javascript:;" onclick="pagination1(<?=$_GET['branch_id'];?>,'+(parseInt(pages)+parseInt(1))+')"><i class="fa fa-angle-right"></i></a></li><li><a title="Last" href="javascript:;" onclick="pagination1(<?=$_GET['branch_id'];?>,'+maxPage+')"><i class="fa fa-angle-double-right"></i></a></li>';
						}else{
							paging1 += '<li class="disabled"><a title="Next" href="javascript:;"><i class="fa fa-angle-right"></i></a></li><li class="disabled"><a title="Last" href="javascript:;"><i class="fa fa-angle-double-right"></i></a></li>';
						}
						paging1 += '</ul>';
						$('.dataTables_paginate_branch_employees').html(paging1);
					}
				});
	}
	function ImageExist(url)
	{
		var img = new Image();
		img.src = url;
		return img.height != 0;
	}

	$(document).ready(function(){
		pagination1(<?=$_GET['branch_id'];?>,1);
	});
</script>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo URL_VIEW; ?>admin/pages/css/inbox.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->

<!-- *********************** Ashok Neupane ****************** -->
<?php 
    if(isset($_POST['saveStaffTrading'])){
        if(isset($_POST['data']['Stafftrading']['users'])){
            foreach($_POST['data']['Stafftrading']['users'] as $user){
                $_POST['data']['Stafftrading']['user_id'] = $user;
                $url = URL. "Stafftradings/saveNewTrading.json";
                 $response = \Httpful\Request::post($url)
                         ->sendsJson()
                         ->body($_POST['data'])
                         ->send();
                 ?>
                     <script>
                        toastr.info('<?php echo $response;?>','Staff Trading');
                     </script>
                 <?php
            }
        }
        
    }
?>
<!-- ******************************************************** -->

<?php
$branch_id = $_GET['branch_id'];
//print_r($branch_id);

$url = URL."Boards/getBoardListOfBranch/".$branchId.".json";
$data = \Httpful\Request::get($url)->send();
$departments = $data->body->boardList;
// echo '<pre>';
// print_r($departments);

$url = URL."Branches/viewBranch/".$branchId.".json";
$data = \Httpful\Request::get($url)->send();
$branch = $data->body->branch;


$orgId = $branch->Branch->organization_id;
$homeBranch = URL_VIEW.'branches/listBranches?org_id='.$orgId;
// print_r($orgId);

$url = URL."Shifts/myOrganizationShift/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$orgShifts = $data->body->shifts;
// echo "<pre>";
// print_r($shifts);
// die();

$url = URL . "Shifts/shiftAddByBranchList/" . $orgId . "/" . $branch_id . ".json";
$data = \Httpful\Request::get($url)->send();
$shiftAddByBranchs = $data->body->shiftList;

$shiftBranch = array();
if(isset($branch->ShiftBranch) && !empty($branch->ShiftBranch)){
	foreach($branch->ShiftBranch as $key=>$shiftB ){
		
		if(isset($shiftB->Shift) && !empty($shiftB->Shift) && $shiftB->status == 1 && $shiftB->Shift->status == 1 ){
			//print_r($shiftB->Shift->starttime);
			$st = explode(':',$shiftB->Shift->starttime);
			$shiftBranch[$key]['stime'] = $st[0];
			$shiftBranch[$key]['start_time'] = $shiftB->Shift->starttime;
			$shiftBranch[$key]['end_time'] = $shiftB->Shift->endtime;
			$shiftBranch[$key]['title'] = $shiftB->Shift->title;
			$shiftBranch[$key]['orgShiftId'] = $shiftB->Shift->id;
			$shiftBranch[$key]['testId'] = $shiftB->id;
		}

		
		// if($shiftB->Shift->starttime > $shiftB->Shift->starttime){
		// 	print_r("true");
		// }
	}
	function sortByOrder($a, $b) {
    	return $a['stime'] - $b['stime'];
	}

	usort($shiftBranch, 'sortByOrder');

}
// echo "<pre>";
// print_r($shiftBranch);
// die();

// if (isset($_POST["submit"])) {
//   //print_r($_POST);die();
//   $_POST['data']['Board']['branch_id'] = $branchId;
   
//     $url = URL. "Boards/createBoard/" . $orgId . ".json";
//     $response = \Httpful\Request::post($url)
//             ->sendsJson()
//             ->body($_POST['data'])
//             ->send();
//    echo("<script>location.href = '".URL_VIEW."branches/viewBranch?branch_id=".$branchId."';</script>");

// }

/*
for add board 
*/
if(isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] == 'ajax'){
  include('../httpful.phar');
  include('../config1.php');

  
  $showBranch = 'No';
}else{
  $showBranch = 'Yes';  
}

$url = URL. "OrganizationUsers/getOrganizationUsers/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$organizationUsers = $data->body->organizationUsers;
// echo "<pre>";
// print_r($organizationUsers);

$url = URL. "Branches/orgBranches/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

?>

<div class="page-head">
	<div class="container">
		<!-- BEGIN PAGE TITLE -->
		<div class="page-title">
			<h1>Branches <!-- <small>pricing table samples</small> --></h1>
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
                    <a href="<?php echo URL_VIEW; ?>">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="<?php echo $homeBranch; ?>">Branch</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="javascript:;">View Branch</a>
                </li>
            </ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
					<div class="portlet light" style="min-height:400px;">
						<!-- <div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>Pricing Tables
							</div>
						</div> -->
						<div class="portlet-body">
							<div class="row margin-bottom-40">
								<div class="col-md-12">
									<div class="tabbable-line tabbable-full-width">
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#tab_1_1" data-toggle="tab">
												Overview </a>
											</li>
											<li>
												<a href="#tab_1_3" data-toggle="tab">
												Department </a>
											</li>
											<li>
												<a href="#tab_1_4" data-toggle="tab">
												Shift </a>
											</li>
											<li>
												<a href="#tab_1_6" data-toggle="tab">
												Employee </a>
											</li>
								            <li>
												<a href="#tab_1_7" data-toggle="tab">
												Staff Trading </a>
											</li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="tab_1_1">
												<div class="row">
													<div class="col-md-6 col-sm-12">
												        <div class="portlet light">
												            <div class="portlet-title">
												                <div class="caption">
<!-- 												                    <i class="fa fa-user"></i>
 -->												                    <?php echo $branch->Branch->title;?>
												                </div>
								                                <div class="actions">
								                                    <a class="btn btn-sm btn-default" href="editBranch?branch_id=<?php echo $branch->Branch->id.'&org_id='.$orgId;?>">&nbsp;&nbsp;<i class="fa fa-pencil"></i>&nbsp;&nbsp;</a>
								                                </div>
												            </div>
												            <div class="portlet-body">
												                <div class="row static-info">
												                    <div class="col-md-5 name">
												                        Email:
												                    </div>
												                    <div class="col-md-7 value">
												                         <?php echo $branch->Branch->email;?>                   
												                    </div>
												                </div>
												                <div class="row static-info">
												                    <div class="col-md-5 name">
												                         Phone:
												                    </div>
												                    <div class="col-md-7 value">
												                         <?php echo $branch->Branch->phone;?>                    
												                    </div>
												                </div>
												                <div class="row static-info">
												                    <div class="col-md-5 name">
												                         Fax:
												                    </div>
												                    <div class="col-md-7 value">
												                         <?php echo $branch->Branch->fax;?>                  
												                    </div>
												                </div>
												                <div class="row static-info">
												                    <div class="col-md-5 name">
												                         Address:
												                    </div>
												                    <div class="col-md-7 value">
												                         <?php echo $branch->City->title;?>                    
												                    </div>
												                </div>
												                <div class="row static-info">
												                    <div class="col-md-5 name">
												                         Country:
												                    </div>
												                    <div class="col-md-7 value">
												                         <?php echo $branch->Country->title;?>                    
												                    </div>
												                </div>
												            </div>
												        </div>
												  	</div>
													<div class="col-md-6 col-sm-12">
														<div class="portlet sale-summary">
														 	<div class="portlet-body">
												                <div class="portlet sale-summary">
														            <div class="portlet-title">
														                <div class="caption">
														                     Branch summary
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
														                        Number Of Department<i class="fa fa-img-up"></i>
														                        </span>
														                        <span class="sale-num">
														                            <?php echo count($branch->Board); ?>
														                        </span>
														                    </li>
														                    <li>
														                        <span class="sale-info">
														                        Number Of Shifts<i class="fa fa-img-up"></i>
														                        </span>
														                        <span class="sale-num">
														                            <?php echo count($branch->ShiftBranch); ?>
														                        </span>
														                    </li>
														                    <li>
														                        <span class="sale-info">
														                        Number Of Employee<i class="fa fa-img-up"></i>
														                        </span>
														                        <span class="sale-num">
														                            <?php echo count($branch->OrganizationUser); ?>
														                        </span>
														                    </li>
														                    
														                </ul>
														            </div>
														        </div>
												            </div>
												        </div>
									            	</div>
									            </div>
											</div>
											<!--tab_1_2-->
											<div class="modal fade" id="portlet-config_1_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											  <div class="modal-dialog">
											      <div class="modal-content">
											          <div class="modal-header">
											              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											              <h4 class="modal-title">Add Department</h4>
											          </div>
											          <div class="modal-body">
											              <form action="" id="BoardAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
											                <div style="display:none;">
											                    <input type="hidden" name="_method" value="POST"/>
											                </div>
											                <div class="form-body">     
											                   <!--  <div class="form-group">
											                        <label class="control-label col-md-4">Branch <span class="required">
											                        * </span>
											                        </label>
											                        <div class="col-md-7">
											                            <?php
											                                if($showBranch == 'Yes'){
											                            ?>
											                           <select name="data[Board][branch_id]" class="form-control">
											                               <?php foreach($branches as $branche):

											                               ?>
											                                <option value="<?php echo $branche->Branch->id;?>"><?php echo $branche->Branch->title;?></option>
											                                <?php endforeach;?>
											                            </select>
											                            <?php } ?>
											                        </div>
											                    </div> -->
											                    <input type="hidden" name="data[Board][branch_id]" value="<?php echo $branch_id; ?>">
											                    <div class="form-group">
											                        <label class="control-label col-md-4">Department Name <span class="required">
											                        * </span>
											                        </label>
											                        <div class="col-md-7">
											                            <input class="form-control" type="text" name="data[Board][title]" required />
											                        </div>
											                    </div>
											                    <div class="form-group">
											                            <label class="control-label col-md-4">Department Manager <span class="required">
											                            * </span>
											                            </label>
											                            <div class="col-md-7">
											                                 <select class="form-control" name="data[Board][user_id]" id="BoardUserId" >
											                                 	<option value="0">Assign later</option>
											                                    <?php foreach($organizationUsers as $organizationUser):?>
											                                    <option value="<?php echo $organizationUser->User->id;?>"><?php echo $organizationUser->User->fname.' '.$organizationUser->User->lname;?></option>
											                                    <?php endforeach;?>
											                                </select>
											                            </div>
											                    </div>
											                </div>
											                <div class="form-actions">
											                   <div class="modal-footer">
											                    
											                        <div class="col-md-offset-3 col-md-9">
											                            <input  type="submit" name="submit" value="Submit" class="btn green"/>
											                           <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php //echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
											                            <input type="reset" name="cancel" value="Clear" class="Departmentclear btn default">
											                            <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
											                        </div>
											                    
											                  </div>
											                </div>
											            </form>
											          </div>
											          <!-- <div class="modal-footer">
											              <button type="button" class="btn default" data-dismiss="modal">Close</button>
											          </div> -->
											      </div>
											      <!-- /.modal-content -->
											  </div>
											                <!-- /.modal-dialog -->
											</div>
											<div class="tab-pane" id="tab_1_3">
												<div class="row profile-account">
													<div class="col-md-12 col-sm-12"  style="height:389px;">
													    <div class="portlet light">
													      	<div class="portlet-title">
														        <div class="caption">
<!-- 														          <i class="fa fa-user"></i>
 -->														          Department
														        </div>
														        <div class="actions">
														          <!-- <a class="btn btn-default btn-sm" href="../boards/createBoard.php?org_id=<?php echo $orgId;?>&branch_id=<?php echo $branchId;?>&type=ajax" id="addBoardFromBranch">
														              <i class="fa fa-plus"></i> Add Board </a> -->
														              <a class="btn btn-default btn-sm" href="#portlet-config_1_2" class="news-block-btn" data-toggle="modal" class="config">
														              <i class="fa fa-plus"></i> Add Department </a>
														        </div>
														    </div>
														    <div class="portlet-body">
														        <table class="table table-striped table-bordered table-hover" id="department_id">
														        	<thead>
															            <tr>
															            	<th>
																                 Department Manager
																              </th>
																              <th>
																                 Department Name
																              </th>
																             
																              <th>Department Detail</th>
															            </tr>
															        </thead>
															        <tbody id="departmentTable">
															            <?php
															             if(isset($branch->Board) && !empty($branch->Board)){
															                  foreach($branch->Board as $board){
															                  	

															                   if($board->status == 1){
															            ?>
															            <tr class="odd gradeX">
															            	<td>
															            		<?php
															            			if(!empty($board->User) && ($board->User)){
															            			$userimage = URL.'webroot/files/user/image/'.$board->User->image_dir.'/thumb2_'.$board->User->image;
																					$image = $board->User->image;
																					$gender = $board->User->gender;
																					$user_image = imageGenerate($userimage,$image,$gender);
																					
															            		?>

															            		<img src="<?php echo $user_image; ?>" width="40px" height="40px" alt="image not found"/>
															            		<?php } else { ?>
															            				<img src="<?php echo URL.'webroot/files/user_image/noimage.png'; ?>" width="40px" height="40px" alt="image not found"/>	
															            		<?php }?>

															                <?php
															                 if(isset($board->User->fname) && !empty($board->User->fname)){?>
															                 <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id='.$board->organization_id.'&user_id='.$board->user_id ;?>"><?php echo $board->User->fname." ".$board->User->lname;?></a>
															                 <?php }else{ ?>
															                 Not Assigned Yet.
															                 <?php } ?> </a>
															              </td>
															              <td>
															                 <?php echo $board->title;?>
															              </td>
															             
															              <td>
															                <a href="<?php echo URL_VIEW . 'boards/viewBoard?board_id=' . $board->id; ?>">
															                <button class="btn btn-xs default btn-editable">
															                      <i class="fa fa-eye"></i> View
															                </button>
															              </td>
															            </tr>
															            <?php }}}else{?>
															          	<tr style="height:40px;" id="noBoards"><td>-</td><td>-</td><td>-</td><td>-</td></tr>
															        	<?php } ?>
																	</tbody>
																</table>
															</div>
													    </div>
													</div>
												</div>
											</div>
											<!--end tab-pane-->
											 <!--Shift Section Start From Here-->
											<div class="tab-pane" id="tab_1_4">
												<div class="row inbox">
													<div class="col-md-3 col-sm-3 col-xs-3">
														<ul class="inbox-nav margin-bottom-10">
															<li class="active">
																<a href="#tab_6_1" data-toggle="tab" class="btn">
																Add Shift From Organisation </a>
																<b></b>
															</li>
															<li>
																<a class="btn" href="#tab_6_2" data-toggle="tab">
																Add Shift By Branch </a>
																<b></b>
															</li>
														</ul>
														<!-- <ul class="nav nav-tabs tabs-left">
															<li class="active">
																<a href="#tab_6_1" data-toggle="tab">
																Add Shift From Organization </a>
															</li>
															<li>
																<a href="#tab_6_2" data-toggle="tab">
																Add Shift By Branch </a>
															</li>
														</ul> -->
													</div>
													<div class="col-md-9 col-sm-9 col-xs-9">
														<div class="tab-content">
															<div class="tab-pane active" id="tab_6_1">
																<div class="row">
																	<div class="col-md-12">
																		<a class="btn btn-sm btn-success pull-right" href="#portlet-config_1_addbyorg" data-toggle="modal"><i class="fa fa-plus"></i> Add Shift</a>
																	</div>
																</div>
																<div class="table-scrollable table-scrollable-borderless">
																	<table class="table table-light table-hover" id="ShiftTable">
																	<thead>
																	<tr>
																		<th>
																			<i class="fa fa-clock-o"></i> Shift time
																		</th>
																		<th class="hidden-xs">
																			<i class="fa fa-calendar-o"></i> Position
																		</th>
																		<th>
																			<i class="fa fa-wrench"></i> Action
																		</th>
																		<th>
																		</th>
																	</tr>
																	</thead>
																	<tbody id="wellAppend">
																		<?php 
																		     $orgShiftId = array();
																		     if(!empty($shiftBranch)){
																		     foreach($shiftBranch as $shift){

																		      $orgShiftId[] = $shift['orgShiftId'];
																		      $testId = $shift['testId'];     
																		  ?>
																		<tr>
																			<td>
																				<?php 
																		            $start_time = $shift['start_time'];
																		            $end_time = $shift['end_time'];
																		            $startTime = explode(':', $start_time);
																		            $endTime = explode(':', $end_time);
																		             if ($startTime[1] == '00' && $endTime[1] == '00') {
																		                   echo (date("g a", strtotime($start_time))).' - '.(date("g a", strtotime($end_time)));
																		                }
																		                else if ($startTime[1] != '00' && $endTime[1] == '00') {
																		                    echo (date("g:i a", strtotime($start_time))).' - '.(date("g a", strtotime($end_time)));
																		                }
																		                 else if ($startTime[1] == '00' && $endTime[1] != '00') {
																		                  echo (date("g a", strtotime($start_time))).' - '.(date("g:i a", strtotime($end_time)));
																		                }
																		                else{
																		                echo (date("g:i a", strtotime($start_time))).' - '.(date("g:i a", strtotime($end_time)));
																		            }
																		            //echo hisToTime($shift->Shift->starttime);

																		        ?>
																			</td>
																			<td class="hidden-xs">
																				 <?php echo $shift['title']; ?>
																			</td>
																			<td>
																				<a href="javascript:;" class="delete btn btn-default btn-sm"  data-shiftBranchId="<?php echo $testId; ?>" id="<?php echo $shift['orgShiftId']; ?>"><i class="fa fa-times"></i></a>

																			</td>
																		</tr>

																		<?php }}?>
																	</tbody>
																	</table>
																</div>
															</div>
															<div class="tab-pane fade" id="tab_6_2">
																<div class="row">
																	<div class="col-md-12">
																		<a href="#portlet-config_1_5" data-toggle="modal" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> Add Shift</a>
																	</div>
																</div>
																<div class="table-scrollable table-scrollable-borderless">
																	<table class="table table-light table-hover">
																	<thead>
																	<tr>
																		<th>
																			<i class="fa fa-clock-o"></i> Shift time
																		</th>
																		<th class="hidden-xs">
																			<i class="fa fa-calendar-o"></i> Position
																		</th>
																		<th>
																			<i class="fa fa-wrench"></i> Action
																		</th>
																		<th>
																		</th>
																	</tr>
																	</thead>
																	<tbody id="displayShiftAddByBranch">
																		<?php 
																			if(!empty($shiftAddByBranchs)){
																			foreach ($shiftAddByBranchs as $shiftAddByBranch) { 
																		?>
																			<tr>
																				<td>
																					<?php 
															                            $start_time = $shiftAddByBranch->Shift->starttime;
															                            $end_time = $shiftAddByBranch->Shift->endtime;
															                            $startTime = explode(':', $start_time);
															                            $endTime = explode(':', $end_time);
															                             if ($startTime[1] == '00' && $endTime[1] == '00') {
															                                   echo (date("g a", strtotime($start_time))).' - '.(date("g a", strtotime($end_time)));
															                                }
															                                else if ($startTime[1] != '00' && $endTime[1] == '00') {
															                                    echo (date("g:i a", strtotime($start_time))).' - '.(date("g a", strtotime($end_time)));
															                                }
															                                 else if ($startTime[1] == '00' && $endTime[1] != '00') {
															                                  echo (date("g a", strtotime($start_time))).' - '.(date("g:i a", strtotime($end_time)));
															                                }
															                                else{
															                                echo (date("g:i a", strtotime($start_time))).' - '.(date("g:i a", strtotime($end_time)));
															                            }
															                            //echo hisToTime($shift->Shift->starttime);

															                        ?>
																				</td>
																				<td class="hidden-xs">
																					 <?php echo $shiftAddByBranch->Shift->title; ?>
																				</td>
																				<td>
																					<div id="editShift" data-shiftId="<?php echo $shiftAddByBranch->Shift->id; ?>"><a class="editShift btn btn-default" href="#portlet-config_1_<?php echo $shiftAddByBranch->Shift->id; ?>"   data-toggle="modal" class="config"><i class="fa fa-pencil"></i></a></div>

																				</td>
																			</tr>
																		<?php }} ?>
																	</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="modal fade addShiftModal" id="portlet-config_1_addbyorg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
											      <div class="modal-content">
											          <div class="modal-header">
											              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											              <h4 class="modal-title">Add Shift</h4>
											          </div>
											          <div class="modal-body">

											              <form action="" id="addShiftForm" method="post" accept-charset="utf-8" class="form-horizontal">
											                <div style="display:none;">
											                  <input type="hidden" name="data[ShiftBranch][branch_id]" value="<?php echo $branchId;?>" />
											                    <input type="hidden" name="_method" value="POST"/>
											                </div>
											                <div class="modal-body">     
											                    <div class="form-group orm-md-checkboxes" id="modalCheckbox">
											                       
											        
											                    <?php 
											                        $countShift = 0;
											                        if(!empty($orgShifts) || $orgShifts != 0):?>  
											                                  <tr>
											                                      <?php foreach($orgShifts as $orgShift):
											                          if(!in_array($orgShift->Shift->id, $orgShiftId)){
											                            $countShift++;
											                          ?>
											                                    <div class="md-checkbox" id="checkboxdiv<?php echo $orgShift->Shift->id; ?>">
													                                <input type="checkbox" id="checkbox<?php echo $orgShift->Shift->id; ?>" class="md-check" name="data[ShiftBranch][shift_id][]" value="<?php echo $orgShift->Shift->id;?>">
													                                    <label for="checkbox<?php echo $orgShift->Shift->id; ?>">
												                                            <span class="inc"></span>
												                                            <span class="check"></span>
												                                            <span class="box"></span>
												                                            <?php echo $orgShift->Shift->title;?>
											                                            </label>
													                            </div>
											                                        
											                                         <!--  <input type="checkbox" class="listShift-checkbox" name="data[ShiftBranch][shift_id][]" value="<?php echo $orgShift->Shift->id;?>"><?php echo $orgShift->Shift->title;?></td> -->
											                                          
											                                      <?php
											                          }
											                           endforeach;
											                                    if($countShift == 0){   
											                                      ?>
											                                      <div class="empty_list">Sorry, no shifts to add....</div>
											                                      <?php } ?>
											                                  
											                      
											                                 
											                          <?php else:?>
											                              <tr><td>
											                          <div class="empty_list">Sorry, no shifts are available.</div>
											                          
											                      <?php endif;?>
											                     
											                     </div>
											                    
											                    
											                </div>
											                <div class="form-actions">
											                   <div class="modal-footer">
											                    
											                        <div class="col-md-offset-3 col-md-9">
											                            <input  type="submit" name="save" value="Submit" class="btn green"/>
											                           <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php //echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
											                           <button type="button" class="btn default" data-dismiss="modal">Close</button>
											                            <!-- <input type="reset" name="cancel" value="Cancel" class="btn default"> -->
											                            <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
											                        </div>
											                    
											                  </div>
											                </div>
											            </form>
											          </div>
											          <!-- <div class="modal-footer">
											              <button type="button" class="btn default" data-dismiss="modal">Close</button>
											          </div> -->
											      </div>
											      <!-- /.modal-content -->
												</div>
										  	</div>
											<!--end tab-pane-->
											<!--end tab-pane-->
											<div class="tab-pane" id="tab_1_6">
												<div class="row">
													<div class="col-md-12 col-sm-12">
													    <div class="portlet light">
													      <div class="portlet-title">
													        <div class="caption">
													          <i class="fa fa-user"></i><span class="caption-subject theme-font bold uppercase">Employee</span>
													        </div>
													         <div class="actions">
														        <div class="btn-group pull-right">
															        <form id="searchForm" class="form-inline" role="form" action="" method="post">
															        	<span style="color:grey">Filter Employee :</span>
																        <div class="form-group">
																        	<input tyoe="text" value=" <?php echo $branch->Branch->title;?>" disabled>
					
																        </div>
																        <div class="form-group">
																        <?php //fal($departments);?>
																            <select name="departmentId" id="selectDepartment" class="form-control input-sm">
																      
																            <option class="default" selected value="0">--All Department--</option>
																            
																            <?php if(!empty($departments)): ?>
																	            <?php  foreach($departments as $d): ?>
																	            	<option value="<?php echo $d->Board->id; ?>"><?php echo $d->Board->title; ?></option>
																	            <?php endforeach; ?>
																        	<?php endif; ?>

																            </select>
																        </div>
																        <div class="form-group">
																            <input id="username" name="username" value="" type="text" class="form-control input-sm" placeholder="Enter Employee Name" required>
																        </div>
				<!-- 												        	<button type="button" class="btn btn-fit-height btn-default dropdown-toggle input-sm" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
														                	Actions <i class="fa fa-angle-down"></i>
														            	</button>
 -->
										    						</form>
														            
													                <ul class="dropdown-menu pull-right" role="menu">
													                    <li>
													                        <a class="active" href="<?php echo URL_VIEW;?>employees/employeeRegistrationByOrg?org_id=<?php echo $orgId;?>">Add new employee</a>
													                    </li>
													                    <li>
													                        <a href="<?php echo URL_VIEW;?>organizationUsers/assignEmployeeToOrganization?org_id=<?php echo $orgId;?>">Add existing employee</a>
													                    </li>
													                    <li>
													                        <a href="<?php echo URL_VIEW;?>users/requestEmployeeToOrganization?org_id=<?php echo $orgId;?>">Send Request</a>
													                    </li>
													                </ul>
														        </div>
														    </div>
													         <!-- <div class="actions">

													        <a class="btn btn-default btn-sm" href="../employees/employeeRegistrationByOrg?org_id=<?php echo $orgId;?>&branch_id=<?php echo $branchId;?>" id="addEmployeeFromBranch">
													                                <i class="fa fa-plus"></i> Add Employee </a>
													                            </div> -->
													      </div>
														    <div class="portlet-body">
														        <table class="table table-striped table-bordered table-hover" id="table_employee">
														          <thead>
														            <tr>
														              <th>
														              	
														              </th>
														              <th>
														                 Name
														              </th>
														              <th>
														                 Designation
														              </th>
														              <th>
														                 Email
														              </th>
														              <th>
														                 Address
														              </th>
														              <th>
														                 Phone
														              </th>
														              <th>Action</th>
														            </tr>
														          </thead>
														          <tbody id="branchUser" style="display:none;">

														          </tbody>
														          <tbody class="branchUsersAjax">
														            <?php
																		/*$page = 1;
																		$url_branchUser= URL."OrganizationUsers/getBranchUsersAjax/".$_GET['branch_id']."/".$page.".json";
																		$data_branchUser = \Httpful\Request::get($url_branchUser)->send();*/

														                //if(isset($branch->OrganizationUser) && !empty($branch->OrganizationUser)){
														                //foreach ($branch->OrganizationUser as $orgEmployee):
														            ?>
														            <!--<tr class="odd gradeX">
														              <td>
														              	<?php
																		/*							              		$orgimage = URL."webroot/files/user/image/".$orgEmployee->User->image_dir."/thumb2_".$orgEmployee->User->image;
																			$image = $orgEmployee->User->image;
																			$gender = $orgEmployee->User->gender;

																			$userImage = imageGenerate($orgimage,$image,$gender);

																			*/?>
														                <img src='<?php /*echo $userImage; */?>' alt="User Image" width="65" width="65"/>
														              </td>
														              <td>
														                <a href="<?php /*echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; */?>"><?php /*echo $orgEmployee->User->fname . ' ' . $orgEmployee->User->lname; */?></a>
														              </td>
														              <td>
														                <?php /*echo $orgEmployee->designation; */?>
														              </td>
														              <td>
														                <?php /*echo $orgEmployee->User->email; */?>
														              </td>
														              <td>
														                <?php /*echo $orgEmployee->User->address; */?>
														              </td>
														              <td>
														                <?php /*echo $orgEmployee->User->phone; */?>
														              </td>
														              <td class="action_td">
														                <a href="<?php /*echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; */?>"><button class="btn btn-xs default btn-editable">
														                      <i class="fa fa-eye"></i> View
														                </button></a>
														                </td>
														            </tr> -->
														            <?php //endforeach;
														              //}else{
														           ?>
														            <!--<tr  class="list_users" style="height:40px;"><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>-->
														          <?php //} ?>
														          </tbody>
														        </table>

																  <input type="hidden" class="page_employee_list">
																  <div class="dataTables_paginate_branch_employees paging_bootstrap_full_number" id="sample_1_paginate">
																  </div>


																	<script>
												                        $(document).ready(function(){
												                           $('#table_employee').dataTable({
												                           	paging:false,
												                           	searching: false,
												                           	info:false

												                           });
												                           $('#department_id').dataTable({

												                           	paging:false,
												                           	searching: false,
												                           	info:false
												                           });
												                        });
												                    </script>		        

														    </div>
													    </div>
													  </div>
													</div>
											</div>
											<!-- ********************** Ashok Neupane ******************** -->
								            <div class="tab-pane" id="tab_1_7">
												<div class="portlet light form-fit">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-exchange font-green-haze"></i>
															<span class="caption-subject font-green-haze bold uppercase">Trading Staffs</span>
															<span class="caption-helper">from one Branch to another.</span>
														</div>
														<!-- <div class="actions">
															<a href="javascript:;" class="btn btn-circle btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>
															<a href="javascript:;" class="btn btn-circle btn-default btn-sm">
															<i class="fa fa-plus"></i> Add </a>
														</div> -->
													</div>
													<div class="portlet-body form">
														<!-- BEGIN FORM-->
														<form action="" method="POST" class="form-horizontal form-row-seperated">
															<input type="hidden" name="data[Stafftrading][organization_id]" value="<?= $orgId; ?>"/>
								                            <input type="hidden" name="data[Stafftrading][frombranch_id]" value="<?= $_GET['branch_id'];?>"/>
								                            <input type="hidden" name="data[Stafftrading][status]" value="0"/>
								                            <input type="hidden" name="data[Stafftrading][date]" value="<?=date('Y-m-d');?>"/>
															<div class="form-body">
																<div class="form-group">
																	<label class="control-label col-md-3">Branch</label>
																	<div class="col-md-9">
																		<?php
																			$url = URL."Branches/listBranchesName/".$orgId.".json";
																			$allBranches = \Httpful\Request::get($url)->send();
																			?>                                    
																			<select id="form_control_branch" class="form-control edited" name="data[Stafftrading][branch_id]">
									                                            <?php if(isset($allBranches->body->branches) && !empty($allBranches->body->branches)){
									                                                foreach($allBranches->body->branches as $k=>$v){

									                                                    if($k != $_GET['branch_id']){
									                                                        echo "<option value=".$k.">".$v."</option>";
									                                                    }

									                                                }
									                                            } ?>
																			</select>
																		<span class="help-block">Select one branch to which you want to trade users.</span>
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-md-3">Department</label>
																	<div class="col-md-9">
																		<select id="form_control_board" class="form-control edited" name="data[Stafftrading][board_id]">
																		</select>
																		<span class="help-block">Select Department to which you wish to assign traded users.</span>
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-md-3">Employee Group</label>
																	<div class="col-md-9">
																		<?php
																		$url = URL."Groups/listGroups/".$orgId.".json";
																		$allGroups = \Httpful\Request::get($url)->send();
																		?>                                   
																			<select id="form_control_group" class="form-control edited" name="data[Stafftrading][group_id]">
									                                            <?php if(isset($allGroups->body->groups) && !empty($allGroups->body->groups)){
									                                                foreach($allGroups->body->groups as $k=>$v){
									                                                    echo "<option value=".$v->Group->id.">".$v->Group->title."</option>";
									                                                }
									                                            } ?>
																			</select>
																		<span class="help-block">Select one Employee group from where users can be choosen.</span>
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-md-3">Shift</label>
																	<div class="col-md-9">
																		<select id="form_control_shift" class="form-control edited" name="data[Stafftrading][shift_id]">
																		</select>
																		<span class="help-block">Select shift to which you wish to trade users.</span>
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-md-3">Shift Date</label>
																	<div class="col-md-9">
																		<input class="form-control date-picker" id="date-picker-shift" data-date-format="yyyy-mm-dd" size="16" type="text" value="" name="data[Stafftrading][shiftdate]" data-date-start-date="+0d" />
																		<span class="help-block">Select date in which you want to trade staff.</span>
																	</div>
																</div>
																<div class="form-group last">
																	<label class="control-label col-md-3">Users</label>
																	<div class="col-md-9">
																		<select id="form_control_user_group" class="form-control edited" multiple="multiple" name="data[Stafftrading][users][]">
																		</select>
																		<span class="help-block">Select atleast one User to proceed</span>
																	</div>
																</div>
																<script>
																    $(document).ready(function(){
																        $("#date-picker-shift").datepicker();
																        $('#form_control_user_group').select2();
																       function getGroupUser(groupid,branchid){
																             $.ajax({
																                    url: "<?php echo URL."UserGroups/listAllEmployeeInGroup/";?>"+groupid+".json",
																                    datatype:'jsonp',
																                    success:function(data){   
																                        var allInGroup = data.allInGroup;
																                        getBranchUser(branchid,allInGroup);          
																                    }
																                });
																       }
																       function getBranchUser(branchid,allInGroup){
																            data1="";
																            $.ajax({
																                    url: "<?php echo URL."BranchUsers/getBranchUsers/";?>"+branchid+".json",
																                    datatype:'jsonp',
																                    success:function(data){
																                        allInBranch = data.branchUser;
																                        $.each(allInGroup , function(k,obj){
																                            var count=0;
																                            $.each(allInBranch, function(k1,obj1){
																                                if(obj.User.id == obj1.User.id){
																                                    count = parseInt(count)+1;
																                                }
																                            });
																                            if(count == 0){
																                                data1 += "<option value=" + obj.User.id + ">" + obj.User.fname +"&nbsp"+ obj.User.lname + "</option>";
																                            }
																                        }); 
																                        $("#form_control_user_group").select2('data', null);
																                        $("#form_control_user_group").html(data1);         
																                    }
																                });    
																       }
																       function getBranchShifts(branchid){
																        data2="";
																            $.ajax({
																                    url: "<?php echo URL."ShiftBranches/getBranchRelatedShift/";?>"+branchid+".json",
																                    datatype:'jsonp',
																                    success:function(data){   
																                        var allShifts = data.shiftList;
																                        $.each(allShifts,function(k,obj){
																                           data2+= "<option value=" + obj.Shift.id + ">" + obj.Shift.title + "</option>";
																                        });
																                        $('#form_control_shift').html(data2);        
																                    }
																                });
																       }
																       function getBranchBoards(branchid){
																            data3="";
																            $.ajax({
																                    url: "<?php echo URL."Boards/getBoardListOfBranch/";?>"+branchid+".json",
																                    datatype:'jsonp',
																                    success:function(data){   
																                        var allBoard = data.boardList;
																                        console.log(allBoard);
																                        $.each(allBoard,function(k,obj){
																                           data3+= "<option value=" + obj.Board.id + ">" + obj.Board.title + "</option>";
																                        });
																                        $('#form_control_board').html(data3);        
																                    }
																                });
																       }
																       
																        getGroupUser($('#form_control_group').val(),$('#form_control_branch').val());
																        getBranchBoards($('#form_control_branch').val());
																        getBranchShifts($('#form_control_branch').val());
																        $('#form_control_group').change(function(){
																            getGroupUser($(this).val(),$('#form_control_branch').val());
																        });
																        $('#form_control_branch').change(function(){
																            getGroupUser($('#form_control_group').val(),$(this).val());
																            getBranchShifts($(this).val());
																            getBranchBoards($(this).val());
																        });
																  
																    });
																</script>
															</div>
															<div class="form-actions">
																<div class="row">
																	<div class="col-md-offset-3 col-md-9">
																		<button type="submit" name="saveStaffTrading" class="btn green">Submit</button>
																		<button type="button" class="btn default">Cancel</button>
																	</div>
																</div>
															</div>
														</form>
														<!-- END FORM-->
													</div>
												</div>
								            </div>
											<!--end tab-pane-->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END INLINE NOTIFICATIONS PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
		<!-- BEGIN PAGE CONTENT -->
	</div>


<!-- Add shift by branch -->
<div class="modal fade" id="portlet-config_1_5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	      <div class="modal-content">
	          <div class="modal-header">
	              <button type="button" class="addclose close" data-dismiss="modal" aria-hidden="true"></button>
	              <h4 class="modal-title">Add Shift by Branch</h4>
	          </div>
	          <div class="modal-body">
	              <form action="" id="addShiftByBranchForm" method="post" accept-charset="utf-8" class="form-horizontal">
	                
	                <div class="modal-body"> 
	                	<div class="form-group">
	                        <label class="control-label col-md-4">Title <span class="required">
	                        * </span>
	                        </label>
	                        <div class="col-md-7">
	                            <input class="form-control" type="text" name="data[Shift][title]" required="" />
	                        </div>
	                    </div>    
	                   	<div class="form-group">
	                        <label class="control-label col-md-4">Start Time</label>
	                        <div class="col-md-7">
	                            <div class="input-group">
	                                <input type="text" class="form-control timepicker timepicker-24" name="data[Shift][starttime]">
	                                <span class="input-group-btn">
	                                <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
	                                </span>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="control-label col-md-4">End Time</label>
	                        <div class="col-md-7">
	                            <div class="input-group">
	                                <input type="text" class="form-control timepicker timepicker-24" name="data[Shift][endtime]">
	                                <span class="input-group-btn">
	                                <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
	                                </span>
	                            </div>
	                        </div>
	                    </div> 
	                </div>
	                <div class="form-actions">
	                   <div class="modal-footer">
	                    
	                        <div class="col-md-offset-3 col-md-9">
	                            <input  type="submit" name="save" value="Submit" class="btn green"/>
	                            <input type="reset" class="addclear btn default" value="Clear">
	                        </div>
	                    
	                  </div>
	                </div>
	            </form>
	          </div>
	          <!-- <div class="modal-footer">
	              <button type="button" class="btn default" data-dismiss="modal">Close</button>
	          </div> -->
	      </div>
	      <!-- /.modal-content -->
	  </div>
</div>
<!-- End of add Shift by branch -->

<!-- Add shift by organization -->
<div class="modal fade" id="portlet-config_1_addbyorg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Add Shift</h4>
          </div>
          <div class="modal-body">
              <form action="" id="addShiftForm" method="post" accept-charset="utf-8" class="form-horizontal">
                <div style="display:none;">
                  <input type="hidden" name="data[ShiftBranch][branch_id]" value="<?php echo $branchId;?>" />
                    <input type="hidden" name="_method" value="POST"/>
                </div>
                <div class="modal-body">     
                    <div class="form-group orm-md-checkboxes" id="modalCheckbox">
                       
        
                    <?php 
                        $countShift = 0;
                        if(!empty($orgShifts) || $orgShifts != 0):?>  
                                  <tr>
                                      <?php foreach($orgShifts as $orgShift):
                          if(!in_array($orgShift->Shift->id, $orgShiftId)){
                            $countShift++;
                          ?>
                                    <div class="md-checkbox">
		                                <input type="checkbox" id="checkbox<?php echo $orgShift->Shift->id; ?>" class="md-check" name="data[ShiftBranch][shift_id][]" value="<?php echo $orgShift->Shift->id;?>">
		                                    <label for="checkbox<?php echo $orgShift->Shift->id; ?>">
	                                            <span class="inc"></span>
	                                            <span class="check"></span>
	                                            <span class="box"></span>
	                                            <?php echo $orgShift->Shift->title;?>
                                            </label>
		                            </div>
                                        
                                         <!--  <input type="checkbox" class="listShift-checkbox" name="data[ShiftBranch][shift_id][]" value="<?php echo $orgShift->Shift->id;?>"><?php echo $orgShift->Shift->title;?></td> -->
                                          
                                      <?php
                          }
                           endforeach;
                                    if($countShift == 0){   
                                      ?>
                                      <div class="empty_list">Sorry, no shifts to add....</div>
                                      <?php } ?>
                                  
                      
                                 
                          <?php else:?>
                              <tr><td>
                          <div class="empty_list">Sorry, no shifts are available.</div>
                          
                      <?php endif;?>
                     
                     </div>
                    
                    
                </div>
                <div class="form-actions">
                   <div class="modal-footer">
                    
                        <div class="col-md-offset-3 col-md-9">
                            <input  type="submit" name="save" value="Submit" class="btn green"/>
                           <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php //echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                           <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            <!-- <input type="reset" name="cancel" value="Cancel" class="btn default"> -->
                            <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
                        </div>
                    
                  </div>
                </div>
            </form>
          </div>
          <!-- <div class="modal-footer">
              <button type="button" class="btn default" data-dismiss="modal">Close</button>
          </div> -->
      </div>
      <!-- /.modal-content -->
  </div>
</div>
<!-- End of shift by organization -->
<script>

//$(document).ready(function(){
$(".timepicker").timepicker({ timeFormat: 'HH:mm',               
                                 showSeconds: false,
                                 showMeridian: false, 
                             });
//});
</script>

<script type="text/javascript">
    $(document).ready(function(){
    var timer;
    var orgId = "<?php echo $orgId;?>";
    var branchId = "<?php echo $_GET['branch_id']; ?>";
    var status = 3;
    $("#selectDepartment").on('change',function(){

        var e = $(this);
        var username = $('#username').val();
        if(username == ''){
            username = '0';
        }
        
        var departmentId = e.find("option:selected").val();
        filterEmplLoad(orgId,username,branchId,departmentId,status);           

    });
   
    //var branchId = 0;


    $('#username').on('keyup', function(e) {
        var departmentId = $("#selectDepartment option:selected").val();
        
        var username = $('#username').val();
        if(username == ''){
            username='0';    
        }

        clearTimeout(timer);
        timer = setTimeout(function (event) {
            filterEmplLoad(orgId,username,branchId,departmentId,status);           
        }, 600);

    });

    function filterEmplLoad(orgId,username,branchId,departmentId,status)
    {   
    	var url = '<?php echo URL; ?>OrganizationUsers/filterByBranch/'+orgId+'/'+username+'/'+branchId+'/'+departmentId+'/'+status+'.json';
    	$.ajax({
    		url:url,
    		datatype:'jsonp',
    		type:'post',
    		success:function(response){
    			var html = "";
    			console.log(response);
    			if(response.length == 0){
    				html += '<tr><td>No records found</td></tr>';
    			}

    			$.each(response , function(k1,v1){

					if(ImageExist(v1['User']['imagepath']) && v1['User']['imagepath'] != ""){
						var imgurl = v1['User']['imagepath'];
					}else{
						if(v1['User']['gender']==0){
							var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/defaultuser.png";
						}else{
							var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/femaleadmin.png";
						}
					}
					html +='<tr class="odd gradeX"><td>'+
							'<img src="'+imgurl+'" alt="User Image" width="65" width="65"/>'+
							'</td><td>'+
							'<a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=';?>'+v1['User']['id']+'">'+v1['User']['fname']+" "+v1['User']['lname']+'</a>'+
							'</td> <td>'+v1['OrganizationUser']['designation']+
							'</td> <td>'+v1['User']['email']+
							'</td> <td>'+v1['User']['address']+
							'</td> <td>'+v1['User']['phone']+
							'</td> <td class="action_td">'+
							'<a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=';?>'+v1['User']['id']+'"><button class="btn btn-xs default btn-editable">'+
							'<i class="fa fa-eye"></i> View</button></a> </td></tr>';
				});
				$("#branchUser").html(html);
				if(departmentId != '0' || username != '0'){
					$('.branchUsersAjax').hide();
					$("#branchUser").show();

				} else {
					$('.branchUsersAjax').show();
					$("#branchUser").hide();
				}
    		}
    		
    	});
    }

    });
</script>
<script type="text/javascript">
			$("#BoardAddForm").on('submit',function(event){
				event.preventDefault();
				var ev = $(this);
				var orgid = '<?php echo $orgId; ?>';
				var branchid = '<?php echo $branch_id; ?>';
				var data = $(this).serialize();
				$.ajax({
			            url : '<?php echo URL."Boards/createBoardWithInfo/"."'+orgid+'"."/"."'+branchid+'"."/".".json";?>',
			            type : "post",
			            data : data,
			            datatype : "jsonp",
			            success:function(response)
			            { 
			            	var boardTable ="";
			            	//console.log(response);
			            	var test = response.output.boardinfo;
			            	console.log(test);
			            	var url1 = '<a href="<?php echo URL_VIEW . "boards/viewBoard?board_id='+test.Board.id+'"?>" >';
			            	var test55 = '<a href="<?php echo URL_VIEW . "organizationUsers/organizationEmployeeDetail?org_id='+orgid+'&user_id='+test.User.id+'"?>">';
			            	var image = response.output.image;
			            	console.log(response.output.image);
			            	if(response.output.status === 1){
			            	//boardTable='<tr class="odd gradeX"><td><img src="<?php echo URL;?>'+image+'" width="60" height="60" alt="image not found"/></td><td>'+test55+''+test.User.fname+' '+test.User.lname+'</a></td><td>'+test.Board.title+'</td><td>'+url1+'<button class="btn btn-xs default btn-editable"><i class="fa fa-eye"></i> View</button></a></td></tr>';
			            	
			            	boardTable += '<tr class="odd gradeX">';
							if(test.User.fname == null){
								boardTable += '<td><img src="<?php echo URL;?>'+image+'" width="40px" height="40px" alt="image not found"/>';
								boardTable += ' Not Assigned Yet</td>';
							} else {
							boardTable += '<td><img src="<?php echo URL;?>'+image+'" width="40px" height="40px" alt="image not found"/>';

							boardTable +=  ''+test55+' '+test.User.fname+' '+test.User.lname+'</a></td>';
							}
							boardTable += '<td>'+test.Board.title+'</td>';
							boardTable += '<td>'+url1+'<button class="btn btn-xs default btn-editable"><i class="fa fa-eye"></i> View</button></a></td>';
							boardTable += '</tr>';
			            		
			            		$("#noBoards").remove();
			            		toastr.success('Recorded Added Successfully');
								$("#departmentTable").prepend(boardTable);
								ev.find('.Departmentclear').click();
								ev.find('.close').click();
		                   	 	ev.closest('.modal-dialog').find('.close').click();
							}
							else{
								toastr.success('Sorry Recorded Cannot Be Added');
							}

							
			            }
					
				});
			});
			$(".modalShift").live('click',function()
			{
				//alert('a');
				$("#modalCheckbox").html('');
				var org__id = '<?php echo $orgId; ?>';
				var branch__id = '<?php echo $branch_id; ?>';
				// var url35 = '<?php echo URL."Shift/deleteBranchShift/"."'+org__id+'"."/"."'+branch__id+'".".json";?>';
				// console.log(url35);
				$.ajax({
		            url : '<?php echo URL."Shifts/notInBranch/"."'+org__id+'"."/"."'+branch__id+'".".json";?>',
		            type : "post",
		            datatype : "jsonp",
		            success:function(response)
		            {
		            	console.log(response);
		            	var shiftModal = "";
		            	// console.log(response.shift);
		            	if (response.output.status ===1) {
		            		//alert('l');
		            	$.each(response.shift,function(e,v){
	            			//console.log(v.Shift.id);
	            			shiftModal+='<div class="md-checkbox"><input type="checkbox" id="checkbox'+v.Shift.id+'" class="md-check" name="data[ShiftBranch][shift_id][]" value="'+v.Shift.id+'"><label for="checkbox'+v.Shift.id+'"><span class="inc"></span><span class="check"></span><span class="box"></span>'+v.Shift.title+'</label></div>';
	            				//console.log(shiftModal);

		            	});
		            	}
		            	else{
		            		//alert('n');
		            		shiftModal='<div class="empty_list">No Shift Found</div>';
		            	}
	    				$("#modalCheckbox").html(shiftModal);
		            }
				
				});
			});
			function tConvert(time)
			{
				var a = time.split(":");
				var hr = a['0'] < 12 ? a['0']: (24-a['0']);
				var m = a['0'] < 12 ? 'AM' : 'PM';
				// console.log(hr);

				if(a['1'] != '00')
				{
					return (hr+':'+a['1']+' '+m);
				}
				else
				{

					return (hr+' '+m);
				}


			}

	        $("#addShiftForm").on('submit',function(event)
	        {
	        	var e = $(this);
	        	event.preventDefault();
	        	var data = $(this).serialize();
	        	e.find('input:submit').attr('disabled','disabled');
	        	
	        	$.ajax({
		            url : '<?php echo URL."ShiftBranches/assignShiftBranch.json" ?>',
		            type : "post",
		            data : data,
		            datatype : "jsonp",
		            success:function(response)
		            {

		            	var well = "";
		               	$.each(response.output,function(i,v){
		               		$("#checkboxdiv"+v.Shift.id).remove();
		               		var starttime=v.Shift.starttime;
		               		var endtime=v.Shift.endtime;

		               		well+='<tr>'+
		               				'<td>'+tConvert(starttime)+' - '+tConvert(endtime)+'</td>'+
	            					'<td class="hidden-xs">'+v.Shift.title+'</td>'+
	            					'<td><a class="delete btn btn-default"  data-shiftBranchId="'+v.ShiftBranch.id+'" id="'+v.Shift.id+'"><i class="fa fa-times"></i></a></td>'+
	            				'</tr>';
		            		
		            	});
	            		toastr.success('Shifts added Successfully.');
	            		$("#wellAppend").append(well);
               				if($(".addShiftModal").modal('hide')){
               					e.find('input:submit').removeAttr('disabled');
               				}
		            }
		        });
				

	        });
	        $(".delete").live('click',function(event)
	        {
	        	var e = $(this);
	        	var shiftId = e.attr('id');
	        	var branchId = '<?php echo $branch_id; ?>';
	        	var shiftBranchId = $(this).attr('data-shiftBranchId');
	        	 $.ajax({
						url:'<?php echo URL."ShiftBranches/deleteBranchShift/"."'+branchId+'"."/"."'+shiftId+'"."/"."'+shiftBranchId+'".".json";?>',
						type:'post',
						datatype:'jsonp',
						success:function(response)
						{
							//console.log(response);
							if(response == '0')
							{
								toastr.success('Recorded Deleted Successfully');
								e.closest('tr').remove();
								
							}
							else
							{
								toastr.error('Sorry You cannot delete this Shift');

							}
						}	
	        		});
	        });

	        

	        $("#addShiftByBranchForm").on('submit',function(event){
	        	event.preventDefault();
	        	var branchId = '<?php echo $branch_id; ?>';
	        	var orgid = '<?php echo $orgId; ?>';
				var data = $(this).serialize();
				var ev = $(this);
				$.ajax({
			            url : '<?php echo URL."Shifts/createShiftbyBranch/"."'+branchId+'"."/"."'+orgid+'"."/".".json";?>',
			             type : "post",
			            data : data,
			            datatype : "jsonp",
			            success:function(response)
			            { 
			            	console.log(response);
			            	var shiftdata = "";

			            	shiftdata = '<tr>'+
			            					'<td>'+response.finalStime+'-'+response.finalEtime+'</td>'+
			            					'<td class="hidden-xs">'+response.shiftByBranch.Shift.title+'</td>'+
			            					'<td><div id="editShift" data-shiftId="'+response.shiftByBranch.Shift.id+'"><a class="btn btn-default" href="#portlet-config_1_'+response.shiftByBranch.Shift.id+'"   data-toggle="modal"><i class="fa fa-pencil"></i></a></div></td>'+
			            				'</tr>';
		                    $("#displayShiftAddByBranch").append(shiftdata);
		                    ev.find('.addclear').click();
		                    ev.find('.addclose').click();
		                    ev.closest('.modal-dialog').find('.addclose').click();
		                    toastr.success('Record Added Successfully');
							
			            }
					
				});
	        });
			$(document.body).on('click',"#editShift",function()
	        {
	        	var orgid = '<?php echo $orgId; ?>';
	            var shift__id = $(this).attr('data-shiftId');
	            $.ajax
	                ({
	                    url : '<?php echo URL."Shifts/editShiftData/"."'+orgid+'"."/"."'+shift__id+'".".json"; ?>',
	                    datatype : "jsonp",
	                    success:function(response)
	                    {
	                        var changeShift = response.changeShift;
	                     var StartTime = '';
                       var shiftError = '';
                       var EndTime = '';

                       StartTime += '<div class="form-group"><label class="control-label col-md-4">Start Time</label><div class="col-md-7"><div class="input-group">';
                        
                        EndTime += '<div class="form-group"><label class="control-label col-md-4">End Time</label><div class="col-md-7"><div class="input-group">';

                        if(changeShift == 0){

                        StartTime += '<input type="text" class="form-control timepicker1 timepicker-24" name="data[Shift][starttime]"  value="'+response.shift.Shift.starttime+'">';

                        EndTime += '<input type="text" class="form-control timepicker1 timepicker-24" name="data[Shift][endtime]"  value="'+response.shift.Shift.endtime+'">';
                        
                        } else if(changeShift == 1){
                       
                        StartTime += '<input type="text" class="form-control timepicker1 timepicker-24" name=""  value="'+response.shift.Shift.starttime+'" disabled>';

                        shiftError += '<div class="form-group"><div class="col-md-offset-4 col-md-7"><li class="list-group-item list-group-item-danger">Shift already in progress, you can not change shift time.</li></div></div>';

                        EndTime += '<input type="text" class="form-control timepicker1 timepicker-24" name=""  value="'+response.shift.Shift.endtime+'" disabled>';
                       
                        } else if(changeShift == 2){
                            StartTime += '<input type="text" class="form-control timepicker1 timepicker-24" name=""  value="'+response.shift.Shift.starttime+'" disabled>';

                            shiftError += '<div class="form-group"><div class="col-md-offset-4 col-md-7"><li class="list-group-item list-group-item-danger">This shift is currently in use, please remove all the users assigned to this shift in order to update shift time.</li></div></div>';

                            EndTime += '<input type="text" class="form-control timepicker1 timepicker-24" name=""  value="'+response.shift.Shift.endtime+'" disabled>';
                        }
                        
                        StartTime += '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span></div></div></div>';

                        
                        EndTime += '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span></div></div></div>';
	                      var box =  bootbox.dialog({
	                            title: "Edit Shifts",
	                            message:'<form action="" id="editShiftForm" data-shiftids="'+response.shift.Shift.id+'" method="post" accept-charset="utf-8" class="form-horizontal">' +
	                                    '<div class="form-body">'+
	                                    '<div class="form-group">'+
	                                        '<label class="control-label col-md-4">Title <span class="required">'+
	                                       ' * </span>'+
	                                        '</label>'+
	                                        '<div class="col-md-7">'+
	                                            '<input class="form-control" name="data[Shift][title]" value="'+response.shift.Shift.title+'"maxlength="100" type="text" id="GroupTitle" required="required"/>'+
	                                        '</div>'+
	                                    '</div> '+
	                                    shiftError+
	                                   StartTime+
	                                    EndTime+
	                                    '<div class="form-actions">'+
	                                    '<div class="modal-footer">'+
	                                    '<div class="col-md-offset-3 col-md-9">'+
	                                        '<input type="submit" name="submit" value="Update" class="btn btn-success" />'+
	                                        // '<input type="reset" name="clear" value="Clear" class="editclear btn default">'+
	                                    '</div>'+
	                                    '</div>'+
	                                    '</div>'+
	                                '</form>' 
	                        });

	                        box.bind('shown.bs.modal', function(){
	                            $(".timepicker1").timepicker({ timeFormat: 'HH:mm',               
	                                                             showSeconds: false,
	                                                             showMeridian: false, 
	                                                         });
	                        });

	                    }
	                });
	        }); 

			$("#editShiftForm").live('submit',function(ev){
            ev.preventDefault();
            var e = $(this);
            var orgId = '<?php echo $orgId; ?>';
            var data = $(this).serialize();
            var shiftid = $(this).attr('data-shiftids');
            var branchId = '<?php echo $branch_id; ?>';
            $.ajax({
                url : '<?php echo URL."Shifts/shifteditBybranch/"."'+branchId+'"."/"."'+orgId+'"."/"."'+shiftid+'".".json"; ?>',
                type : "post",
                data : data,
                datatype : "jsonp",
                success:function(response)
                {
                	console.log(response);
                   if(response.output == 1){
                       window.location.reload(true);
                       toastr.success('Recorded Updated Successfully');
                        e.find('.editclear').click();
                        e.find('.bootbox-close-button').click();
                        e.closest('.modal-dialog').find('.bootbox-close-button').click();
                    }
                    else if(response.output == 3){
                       toastr.success('Shift Already Used');
                        e.find('.editclear').click();
                        e.find('.bootbox-close-button').click();
                        e.closest('.modal-dialog').find('.bootbox-close-button').click(); 
                    }
                    else{
                    	toastr.success('Shift Cannot Update');
                        e.find('.editclear').click();
                        e.find('.bootbox-close-button').click();
                        e.closest('.modal-dialog').find('.bootbox-close-button').click(); 
                    }
                }
            });
            
        });
</script>
<script>

</script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/table-advanced.js"></script>
<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/components-pickers.js"></script>

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/inbox.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
   ComponentsPickers.init();
	Inbox.init();
   TableAdvanced.init();
   
});
</script>