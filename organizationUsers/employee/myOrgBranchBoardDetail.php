<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php

$url = URL ."BoardUsers/myOrgBranchBoardDetail/".$board_id.".json";
$org = \Httpful\Request::get($url)->send();

//print_r($org);
$myOrgBranchBoardDetail = $org->body->myOrgBranchBoardDetail;

$url_board = URL ."Boards/getBoardManagerWithBoardId/".$board_id.".json";
$org_board = \Httpful\Request::get($url_board)->send();
$boardDetail = $org_board->body->boardDetail;

$boardManagerId = 0;
if(isset($boardDetail) && !empty($boardDetail)){
$boardManagerId = $boardDetail->Board->user_id;
}

// Shift Details
$url = URL."ShiftBoards/shiftListDetail/".$board_id.".json";
$shiftsDetails = \Httpful\Request::get($url)->send();
$boardShiftDetails = $shiftsDetails->body;

// fal($boardShiftDetails);

$loginUserRelationToOther = loginUserRelationToOther($userId);


$org_id = $_GET["org_id"];

$url = URL ."Shiftnotes/listNotes/".$board_id.".json";
$listNotes = \Httpful\Request::get($url)->send();
$listnoteDetails = $listNotes->body->shiftNotes;

if(isset($_POST['submit']))
{

	$_POST['data']['Shiftnote']['image'] = 
	array( 'name'=> $_FILES['image']['name'],
                'type'=> $_FILES['image']['type'],
                'tmp_name'=> $_FILES['image']['tmp_name'],
                'error'=> $_FILES['image']['error'],
                'size'=> $_FILES['image']['size']
                );
	
	$url = URL."Shiftnotes/addNotes.json";
	$response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

    $url = URL ."Shiftnotes/listNotes/".$board_id.".json";
	$listNotes = \Httpful\Request::get($url)->send();
	$listnoteDetails = $listNotes->body->shiftNotes;
}

if(isset($_POST['editSubmit']))
{

	$_POST['data']['Shiftnote']['image'] = 
	array( 'name'=> $_FILES['image']['name'],
                'type'=> $_FILES['image']['type'],
                'tmp_name'=> $_FILES['image']['tmp_name'],
                'error'=> $_FILES['image']['error'],
                'size'=> $_FILES['image']['size']
                );	
	$url = URL."Shiftnotes/editNotes.json";
	$response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

    $url = URL ."Shiftnotes/listNotes/".$board_id.".json";
	$listNotes = \Httpful\Request::get($url)->send();
	$listnoteDetails = $listNotes->body->shiftNotes;
}

// if(isset($_POST['addShiftCheckList'])){
// 	$url1 = URL."Shiftchecklists/addShiftchecklist.json";
//         $response1 = \Httpful\Request::post($url1)
//                 ->sendsJson()
//                 ->body($_POST['data'])
//                 ->send();
// }

// if(isset($_POST['editChecklist']))
// {
// 	foreach($_POST['data']['Checklist'] as $key=>$checklist){
// 		if(!isset($checklist['checklistdetail'])){
// 			$_POST['data']['Checklist'][$key]['status']=1;
// 		}
// 	}
// 	$url = URL."Shiftchecklists/editCheckList.json";
// 	$response = \Httpful\Request::post($url)
//                 ->sendsJson()
//                 ->body($_POST['data'])
//                 ->send();
// }

$url = URL ."Shiftchecklists/listCheckList/".$board_id.".json";
$listCheckList = \Httpful\Request::get($url)->send();
$CheckLists = $listCheckList->body;

$url = URL."ShiftBranches/shiftBranchList/".$_GET['branch_id'].".json";
$data = \Httpful\Request::get($url)->send();
$shiftBranchlists = $data->body;

// fal($shiftBranchlists);

$url = URL."ShiftBoards/userShiftList/".$board_id.".json";
$data = \Httpful\Request::get($url)->send();
$userShiftLists = $data->body;

?>

<div class="page-head">
	<div class="container">
	<div class="page-title">
		<h1>Department Overview<!-- <?php echo key($loginUserRelationToOther->userOrganization->$org_id); ?> --> <small></small>
		</h1>
	</div>  
	</div>
</div>

<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Organization</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Branch &amp; Department details</a>
            </li>
        </ul>

        <div class="row">
        <?php if(isset($boardDetail) && !empty($boardDetail)){ ?>
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-globe font-green-haze"></i>
							<span class="caption-subject bold uppercase font-green-haze"><?php echo $boardDetail->Board->title; ?></span><small> ,<?php echo key($loginUserRelationToOther->userOrganization->$org_id); ?></small>
						</div>
					</div>
					<div class="portlet-body">
							<div class="col-md-4 col-md-offset-4">
								<div class="media">
									<?php $userimage = URL.'webroot/files/user/image/'.$boardDetail->User->image_dir."/thumb2_".$boardDetail->User->image;
										$image = $boardDetail->User->image;
										$gender = $boardDetail->User->gender;
										$userimage = imageGenerate($userimage,$image,$gender);?>
									<a href="javascript:;" class="pull-left">
									<img alt="no-image" src="<?php echo $userimage;?>" style="width:60px;height:60px;border-radius:100% !important;" class="circle">
									</a>
									<div class="media-body" style="padding-top:8px;">
										<?php if(isset($boardDetail->User->fname) && !empty($boardDetail->User->fname)):?>
											<h4 class="media-heading"><?php echo $boardDetail->User->fname." ".$boardDetail->User->lname;?> <span><a href="javascript:;"></a>
											</span>
											</h4>
											<p class="text-success">
												Department Manager
											</p>
										<?php else:?>
											<h6 class="media-heading">Manager is not assigned for this department.<span><a href="javascript:;"></a>
												</span>
											</h6>
										<?php endif;?>
										
									</div>
								</div>
							</div>
							<br/>
						<table class="table table-light table-hover">
							<thead>
	                            <tr>
	                                <th><i class="fa fa-user"></i> Name</th>
	                                <th><i class="fa fa-home"></i> Address</th>
	                                <th><i class="fa fa-phone"></i> Phone</th>
	                                <th><i class="fa fa-envelope"></i> Email</th>
	                            </tr>
	                        </thead>
                            <tbody>
                            	<?php
		                            $count = 1;
		                            foreach($myOrgBranchBoardDetail as $myOrgBranchBoardDetails){
		                        	$userimage = URL.'webroot/files/user/image/'.$myOrgBranchBoardDetails->User->image_dir."/thumb2_".$myOrgBranchBoardDetails->User->image;
									$image = $myOrgBranchBoardDetails->User->image;
									$gender = $myOrgBranchBoardDetails->User->gender;
									$userimage = imageGenerate($userimage,$image,$gender);
		                        ?>
		                       <tr class="odd gradeX">
		                            <td>
		                            	<img src="<?php echo $userimage;?>" style="height:30px;width:30px;" />&nbsp;
		                            	<?php echo $myOrgBranchBoardDetails->User->fname." ".$myOrgBranchBoardDetails->User->lname;?>
		                            </td>
		                            <td class="text-capitalize">
		                            	<?php echo (!empty($myOrgBranchBoardDetails->User->address)?$myOrgBranchBoardDetails->User->address:"--");?></td>
		                            <td><?php echo (!empty($myOrgBranchBoardDetails->User->phone)?$myOrgBranchBoardDetails->User->phone:"--");?></td>
		                            <td><a href="mailto:shuxer@gmail.com"><?php echo $myOrgBranchBoardDetails->User->email;?></a></td>
		                        </tr>   
		                        <?php } ?>
		                    </tbody>
						</table>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-clipboard font-green-haze"></i>
							<span class="caption-subject bold uppercase font-green-haze">Notes</span>
							<!-- <span class="caption-helper">column and line mix</span> -->
						</div>
						<?php if($boardManagerId == $user_id):?>
							<div class="btn-group pull-right">
								<a href="#portlet-config" data-toggle="modal" class="config btn blue"><i class="fa fa-plus"></i> 	Add note
								</a>
							</div>
						<?php endif;?>			
					</div>
					<div class="portlet-body">
						<div class="table-scrollable table-scrollable-borderless">
							<table class="table table-hover table-light" id="<?php echo ($boardManagerId == $user_id)?'shiftNoteTable':''; ?>">
								<thead>

									<tr class="uppercase">
										<th colspan="1">
											 Shifts
										</th>
										<th>
											 Notes
										</th>
										<th>
											 Start Date
										</th>
										<th>
											 End Date
										</th>
										<th>
											 Image
										</th>
										<?php if($boardManagerId == $user_id):?>
			                                <th>Action</th>
			                            <?php endif;?>
									</tr>
		                        </thead>
	                            <tbody>
									 <?php if(isset($listnoteDetails) && !empty($listnoteDetails))
		                                {?>

				                        <?php
				                            $sn=1;
				                            foreach($listnoteDetails as $listnoteDetail):
				                        ?>
				                       <tr class="odd gradeX" data-shiftNoteId= "<?php echo $listnoteDetail->Shiftnote->id; ?>">
				                            <td><?php echo $listnoteDetail->Shift->title?></td>
				                            <td><?php echo $listnoteDetail->Shiftnote->notes;?></td>
				                            <td><?php echo $listnoteDetail->Shiftnote->start_date;?></td>
				                            <td><?php echo $listnoteDetail->Shiftnote->end_date;?></td>
				                            <td>
				                            	<a href="<?php echo URL."webroot/files/shiftnote/image/".$listnoteDetail->Shiftnote->image_dir."/".$listnoteDetail->Shiftnote->image;?>" data-lightbox="image-1" ><img height="30px" width="30px"  src="<?php echo URL."webroot/files/shiftnote/image/".$listnoteDetail->Shiftnote->image_dir."/".$listnoteDetail->Shiftnote->image;?>"></a>
				                            </td>
				                            <?php if($boardManagerId == $user_id):?>
					                            <td>
																
													<a href="javascript:;" class="btn btn-xs grey edit_notes" shiftnote-id="<?php echo $listnoteDetail->Shiftnote->id;?>">
					                                                            <i class="fa fa-edit"></i> Edit 
					                                                            </a>
					                            </td>
					                        <?php endif;?>
				                        </tr>   
		                         		<?php 
				                        $sn++;
				                        endforeach;
				                        ?>
				                        <?php }else{?>

				                        <tr class="odd gradeX noData">
				                                <td>
				                                    no data
				                                </td>

				                                <td>
				                                    no data.
				                                </td>

				                                <td>
				                                    no data.
				                                </td>

				                                <td>
				                                    no data.
				                                </td>

				                                <td>
				                                    no data.
				                                </td>
				                                <?php if($boardManagerId == $user_id):?>
					                                <td>
					                                    no data.
					                                </td>
					                            <?php endif;?>
			                            </tr>

				                        <?php }?>
			                    </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
						<form id="addShiftNoteForm" method="post" action="" enctype="multipart/form-data">
							<input type="hidden" name="data[Shiftnote][board_id]" value="<?php echo $board_id;?>" />

							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<a href="#checklist_modal"  class="modal-title">Add Notes</a>
							</div>

							<div class="modal-body">
								<div class="form-group">
									<label>Select Shift</label>
									<select class="form-control" name='data[Shiftnote][shift_id]'>

										<?php foreach($boardShiftDetails as $boardShiftDetail):?>
										<option value="<?php echo $boardShiftDetail->Shift->id;?>"><?php echo $boardShiftDetail->Shift->title;?></option>

									<?php endforeach;?>
									</select>
								</div>

								<div class="form-group">
									<label>Date Range</label>
									<div class="input-group input-large date-picker input-daterange" data-date="" 	data-date-format="yyyy-mm-dd">
												<input type="text" class="form-control" name="data[Shiftnote][start_date]" required />
												<span class="input-group-addon">
												to </span>
												<input type="text" class="form-control" name="data[Shiftnote][end_date]" required>
									</div>
                            	</div>

                                <div class="form-group">
									<label>Note</label>
									<textarea style="min-height:150px;" class="form-control" name="data[Shiftnote][notes]" rows="3" required></textarea>
								</div>
               
				                <div class="form-group">
				                    <label for="image">Image</label>
				                    <input name="data[Shiftnote][image]" type="file" id="image"/>
				                </div>
				            </div>

							<div class="modal-footer">
									<input type="submit" name="submit" value="Submit" class="btn blue">
									<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
							</div>
						</form>
					</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-list-alt font-green-haze"></i>
							<span class="caption-subject bold uppercase font-green-haze">Checklists</span>
							<!-- <span class="caption-helper">column and line mix</span> -->
						</div>

						<?php if($boardManagerId == $user_id):?>
							<div class="btn-group pull-right">
								<a href="#" data-toggle="modal" class="config btn blue checklist_modal"><i class="fa fa-plus"></i> Add Checklist
								</a>
							</div>
						<?php endif;?>
					</div>
					<div class="portlet-body">
						<div class="table-scrollable">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th>SN</th>
										<th>Shifts</th>
										<th>Tasks List</th>
										<th>Date Interval</th>
										<?php if($boardManagerId == $user_id):?>
											<th>Action</th>
										<?php endif;?>
										

									</tr>
								</thead>
								<tbody id="checklistBody">
									<?php if(isset($CheckLists) && !empty($CheckLists)):?>
										<?php $count=1;?>
										<?php foreach($CheckLists as $Checklist){
											$countOfList=0;
										foreach ($Checklist->Checklist as $Check){
											$countOfList++;
										} ?>
										<tr data-items="<?php echo $countOfList;?>" class="data_row" count="<?php echo $count; ?>" data-id="<?php echo $Checklist->Shiftchecklist->id; ?>">
											<td><?php echo $count;?></td>
											<td><?php echo $Checklist->Shift->title; ?> </td>
											<td><?php foreach ($Checklist->Checklist as $Check){
											 if(!empty($Check->checklistdetail)){
											 	echo '<li>'.$Check->checklistdetail.'</li>'; 
											 }
											 } ?>
											 </td>
											
											 <?php if($Checklist->Shiftchecklist->everyday == 0) { ?>
											<td><?php echo $Checklist->Shiftchecklist->start_date.' to '.$Checklist->Shiftchecklist->end_date; ?></td>
											<?php } else {?>
											<td><span>Everyday</span></td>
											<?php } ?>

											<?php if($boardManagerId == $user_id):?>
												<td><a href="javascript:;" class="btn btn-xs grey edit_checklist" checklist-id="<?php echo $Checklist->Shiftchecklist->id;?>">
			                                                           <i class="fa fa-edit"></i> Edit 
			                                                            </a></td>
                                            <?php endif;?>
											
										
										</tr>
										<?php $count++;} ?>
									<?php else:?>
										<tr><td>No Checklists.</td></tr>
									<?php endif;?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<!--Checklist modal starts-->
			<div class="modal fade" id="checklist_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="post" id="addChecklistForm" action="" enctype="multipart/form-data">
							<input type="hidden" name="data[Shiftchecklist][board_id]" value="<?php echo $board_id;?>" />	
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">Add Checklist</h4>
							</div>

							<div class="modal-body">
								<div class="form-group">
									<label>Select Shift</label>
									<select class="form-control" id="shiftId" name='data[Shiftchecklist][shift_id]'>

										<?php foreach($boardShiftDetails as $boardShiftDetail):?>
										<option value="<?php echo $boardShiftDetail->Shift->id;?>"><?php echo $boardShiftDetail->Shift->title;?></option>

									<?php endforeach;?>
									</select>
								</div>

								<div class="form-group dateRange">
									<label>Date Range</label>
									<div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" 	data-date-format="yyyy-mm-dd">
												<input type="text" class="start_date form-control" name="data[Shiftchecklist][start_date]" required />
												<span class="input-group-addon">
												to </span>
												<input type="text" class="end_date form-control"  name="data[Shiftchecklist][end_date]" required  />
									</div>
                            	</div>

								<div class="form-group"><label><input type="checkbox" name="data[Shiftchecklist][everyday]" class="checkEveryDay" value="1" class="icheck" /> Everyday</label>
								</div>

								
								
								<div class="form-group input_fields_wrap">
									<div class="row">
										<div class="col-md-11">
										<textarea  id="task" placeholder="Task description.." style="min-height:40px;margin-bottom:12px;" class="form-control taskDescription" name="data[Checklist][0][checklistdetail]" rows="2" required></textarea>
										</div>
									</div>
									<div class="addedTask">

									</div>
								</div>

								
								<div class="form-group input_fields_wrap1">
									<button type="button"  class="add_field_button btn btn-success btn-sm"> <i class="fa fa-plus"></i> Add More</button>
								</div>

								<div class="modal-footer">
									<input type="submit" name="addShiftCheckList" value="Submit" class="btn blue">
									<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!--End of modal-->
		</div>

		<!-- shift table -->
		<div class="modal fade" id="portlet-addShift" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
		          <div class="modal-content">
		              <div class="modal-header">
		                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		                  <h4 class="modal-title">Add Shift</h4>
		              </div>
		              <form action="" id="BoardAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
		                <div style="display:none;">
		                 <input type="hidden" name="data[ShiftBoard][board_id]" value="<?php echo $board_id;?>" />
		                  <input type="hidden" id="openCloseValue"   name="data[ShiftBoard][shift_type]" value="0" >
		                    <input type="hidden" name="_method" value="POST"/>
		                </div>
		                <div class="modal-body">
		                  <div class="form-body" id="shiftCheckBox">

		                  	<?php 
				          	     $userShiftId = array();
				          	     if(isset($userShiftLists) && !empty($userShiftLists)){
				          	     foreach($userShiftLists as $userShiftList){
				            			if($userShiftList->ShiftBoard->status == 1){
				                        $userShiftId[] = $userShiftList->Shift->id;
				                    }
				                }
				            } else{
				            	echo 'Sorry , no shifts are available right now.';
				            }
				          	?>    
		                   <?php if(isset($shiftBranchlists)){?>
		                    	<?php foreach($shiftBranchlists as $shiftBranchlist):
		                			if (!in_array($shiftBranchlist->Shift->id, $userShiftId)) {
		                				
		                        ?>
		                        <div class="md-checkbox">
		                          <input type="checkbox" id="checkbox<?php echo $shiftBranchlist->Shift->id; ?>" class="checked md-check" name="data[ShiftBoard][shift_id][]" value="<?php echo $shiftBranchlist->Shift->id;?>">
		                          <label for="checkbox<?php echo $shiftBranchlist->Shift->id; ?>">
		                            <span class="inc"></span>
		                            <span class="check"></span>
		                            <span class="box"></span>
		                            <?php echo $shiftBranchlist->Shift->title;?> 
		                          </label>
		                        </div>
		                        <?php 
		                      }
		                        endforeach;?>
		                        <?php } else {?>
		                        <div class="empty_list">Sorry, no shifts are available.</div>
		                    <?php }?>
		                  </div>
		                </div>
		                <div class="modal-footer">
		                  <div class="col-md-offset-3 col-md-9">
		                      <input  type="submit" value="Submit" class="btn green"/>
		                      <input type="reset" name="cancel" value="Clear" class="btn default">
		                  </div>
		                </div>
		              </form>
		          </div>
	        </div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-globe font-green-haze"></i>
							<span class="caption-subject bold uppercase font-green-haze">Shift List</span>
						</div>
						<?php if($boardManagerId == $user_id):?>
							<div class="btn-group pull-right">
								<a href="#portlet-addShift" data-toggle="modal" class="config btn blue"><i class="fa fa-plus"></i> 	Add Shift
								</a>
							</div>
						<?php endif;?>
					</div>
					<div class="portlet-body">
						<table id="shiftTable" class="table table-light table-hover">
							<thead>
	                            <tr>
	                            	<th>SN</th>
	                                <th><i class="fa fa-user"></i> Shift</th>
	                                <th><i class="fa fa-home"></i> Time</th>
	                                <!-- <th><i class="fa fa-phone"></i> Phone</th>
	                                <th><i class="fa fa-envelope"></i> Email</th> -->
	                            </tr>
	                        </thead>
                            <tbody>
                            	<?php  $n = 1; foreach ($boardShiftDetails as $shift): ?>
			                       <tr class="odd gradeX">
			                       		<td><?php echo $n; ?></td>
			                            <td>
			                            	<?php echo $shift->Shift->title; ?>
			                            </td>
			                            <td class="text-capitalize"><?php echo hisToTime($shift->Shift->starttime)." - ".hisToTime($shift->Shift->endtime); ?></td>
			                        </tr>
                            	<?php $n++; endforeach; ?>
		                    </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.checklist_modal').on('click',function(){
			$(".addedTask").html("");
			$("#checklist_modal").modal();
		});

		$("#addShiftNoteForm").on('submit', function(event)
			{
				event.preventDefault();

				var formData = new FormData($(this)[0]);

				var url = '<?php echo URL; ?>Shiftnotes/addNotes.json';

				$.ajax({
					        url: url,
					        type: 'POST',
					        data: formData,
					        dataType:'jsonp',
					        async: false,
					        success: function (res) {
					            
					            if(res.output.status == 1)
					            {
					            	var data = res.output.data;
					            	var img = '<?php echo URL;?>webroot/files/shiftnote/image/'+data.Shiftnote.image_dir+'/'+data.Shiftnote.image;

						            var tr = '<tr class="odd gradeX" data-shiftNoteId="'+data.Shiftnote.id+'">'+
						            '<td>'+data.Shift.title+'</td>'+
						            '<td>'+data.Shiftnote.notes+'</td>'+
						            '<td>'+data.Shiftnote.start_date+'</td>'+
						            '<td>'+data.Shiftnote.end_date+'</td>'+
						            '<td>'+
						            '<a href="'+img+'" data-lightbox=\"image-1\"><img height="30px" width="30px" src="'+img+'"></a>'+
						            '</td>'+
						            '<td>'+
						            '<a href="javascript:;" class="btn btn-xs grey edit_notes" shiftnote-id='+data.Shiftnote.id+'><i class="fa fa-edit"></i> Edit</a>'+
						            '</td>'+
						            '</tr>';

						            if($("#shiftNoteTable").find(".noData").length == 1)
						            {
						            	$("#shiftNoteTable").find("tbody").html("");
						            }
						            $("#shiftNoteTable").find("tbody").prepend(tr);

						            $("#portlet-config").modal('hide');
						            toastr.success("Saved successfully.");
					            }else
					            {
					            	if(res.output.messageStatus ==1)
					            	{
					            		toastr.warning(res.output.message);
					            	}
					            }

					        },
					        cache: false,
					        contentType: false,
					        processData: false
					    });
			});

		$("#BoardAddForm").on('submit', function(event)
			{
				event.preventDefault();

				var e = $(this);

				var data = e.serialize();

				var boardId = '<?php echo $board_id ?>';
				var url = '<?php echo URL;?>ShiftBoards/assignShift/'+boardId+'.json';

				$.ajax(
					{
						url:url,
						type:'post',
						data:data,
						dataType:'jsonp',
						async:false,
						success:function(res)
						{
							// console.log(res);
							if(res.output == 1)
							{
								$.each(e.find("#shiftCheckBox .md-check"), function(v,k)
										{
											if(k.checked)
											{
												k.closest('.md-checkbox').remove();
											}
										});
								toastr.success("Shift has been added successfully.");

								if(e.find("#shiftCheckBox .md-checkbox").length == 0)
								{
									e.find("#shiftCheckBox").html("").html("<div>There aren't any shift on the branch.</div>");
								}
							}
						},
						error:function()
						{
							alert('Something went wrong, please try again.');
						}
					});
			});
	});
</script>
<script>
		var max_fields      = 10; //maximum input boxes allowed
		var wrapper         = $(".addedTask"); //Fields wrapper
		var add_button      = $(".add_field_button"); //Add button ID

		var x = 1; //initlal text box count
		$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
		    x++; //text box increment
		    $(wrapper).append(
		    '<div class="form-group">'+
		    '<div class="row">'+
		    '<div class="col-md-11">'+
			'<textarea placeholder="Task description.." id="task" class="form-control" name="data[Checklist]['+x+'][checklistdetail]" rows="2" required></textarea>'+
			'</div>'+
			'<div class="col-md-1">'+
			'<a href="javascript://" class="remove_field"><i class="fa fa-minus-circle" style="margin-top:20px;"></i> </a>'+
			'</div>'+
		'</div>'
		    ); //add input box
		}
		});

		$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').prev().remove(); x--;
		e.preventDefault(); $(this).parent('div').remove(); x--;
		});

</script>
<script>
	$(".checkEveryDay").on('click',function(event)
		{
			var e = $(this);
			var dateRange = e.closest('.modal-body').find('.dateRange');

			var startDate = dateRange.find('.start_date');
			var endDate = dateRange.find('.end_date');

			if(startDate.prop('disabled')==false)
			{
				startDate.prop('disabled', true);
				endDate.prop('disabled', true);
			}
			else
			{
				startDate.prop('disabled', false);
				endDate.prop('disabled', false);
			}


		});
</script>
<!--Begins Shiftchecklist edit script-->
<script type="text/javascript">
	// $(function()
	// 	{

			$(".edit_checklist").live('click',function(e)
	        {
	        	var x=$(this).closest('.data_row').attr("data-items");
	        	var shiftCheckListId = $(this).attr('checklist-id');
	        	//var CheckLists = <?php echo json_encode($CheckLists);?>;
	        	//console.log(CheckLists);

	        	// console.log(shiftCheckListId);
	        	var shiftdetails = <?php echo json_encode($boardShiftDetails);?>;
	        	// console.log(shiftdetails);


	            $.ajax(
	            	{
	            		url: '<?php echo URL_VIEW."process.php";?>',
	            		data:"action=editChecklist&shiftId="+shiftCheckListId,
	            		type:'post',
	            		success:function(response)
	            		{

	            			var response = JSON.parse(response);
	            			// console.log(response);
	            			var checklist = response.checklist;

	            			// console.log(checklist);
	            			var everyday = checklist.Shiftchecklist.everyday;
	            			var checked = '';
	            			var disabled = '';
	            			var evDay = '<input type="hidden" name="data[Shiftchecklist][everyday]" value="0"/>';

	            			if(everyday == 1){
	            				checked="checked";
	            				disabled = "disabled";
	            				evDay = '<input type="hidden" name="data[Shiftchecklist][everyday]" value="1"/>';
	            			}


	            			var shiftId = parseInt(checklist.Shift.id);

	            			bootbox.dialog({
								                title: "Edit Checklist",
								                message:
								                    '<form class="form-body" action="" method="post" id="editChecklistForm"> ' +
								                    '<input type="hidden" name="data[Shiftchecklist][id]" value="'+checklist.Shiftchecklist.id+'"/>'+
								                    '<input type="hidden" value="'+x+'" class="listCount">'+
								                    '<div class="form-group">'+
														'<label>Select Shift</label>'+
														'<select id="shift-id" class="form-control shiftOptions" name="data[Shiftchecklist][shift_id]">'+
														'</select>'+
													'</div>'+

												'<div class="form-group dateRange">'+
												'<label>Date Range</label>'+
												'<div class="input-group input-large date-picker input-daterange" data-date="" 	data-date-format="yyyy-mm-dd">'+
															'<input type="text" class="start_date form-control" name="data[Shiftchecklist][start_date]" '+disabled+' value="'+checklist.Shiftchecklist.start_date+'" required />'+
															'<span class="input-group-addon">to</span>'+
															'<input type="text" class="end_date form-control" name="data[Shiftchecklist][end_date]" '+disabled+' value="'+checklist.Shiftchecklist.end_date+'" required>'+
												'</div>'+
			                            		'</div>'+ 

			                     				'<div class="form-group"><label><input type="checkbox" name="data[Shiftchecklist][everyday]" class="checkEveryDay" value="1" class="icheck" '+checked+'> Everyday</label></div>'+
	  

												'<div class="form-group taskLiksts">'+
													
												'</div>'+


												'<button type="button"  class="add_button btn btn-success btn-sm"> <i class="fa fa-plus"></i> Add More</button><hr>'+
												'<input type="submit" name="editChecklist" value="Update Now" class="btn blue">'+
								                '</form>'


	                            			}

	                          );

								var max_fields      = 7; //maximum input boxes allowed
								var wrapper1       = $(".taskLiksts"); //Fields wrapper
								var add_button1    = $(".add_button");
							$(add_button1).click(function(e){ //on add input button click
								var x=$(this).siblings('.listCount').val();
								e.preventDefault();
								if(x < max_fields){ //max input box allowed
								   $(this).siblings('.listCount').val(parseInt(x)+parseInt(1)); //text box increment
								    x++;
								    var html = "";
								    html += '<div class="row nput_fields_wrap"><div class="col-md-11">';

								    html += '<textarea id="task" style="min-height:40px;margin-bottom:10px;" class="form-control" name="data[Checklist]['+x+'][checklistdetail]" placeholder="Task description" rows="2" required></textarea>';
								    html += '</div>';
								    
								    if(x != 0){
											//list += '<a href="#" class="remove">Remove</a>';
											html += '<div class="col-md-1">'+
												'<a href="javascript://" class="remove"><i class="fa fa-minus-circle" style="margin-top:20px;"></i> </a>'+
												'</div>';
										}

								    
								    html += '</div>';


								    $(wrapper1).append(html); //add input box
								}

								});

								$(wrapper1).on("click",".remove", function(e){ //user click on remove text
								e.preventDefault(); 
								$(this).parent('div').closest('.nput_fields_wrap').remove(); x--;
								$(this).parent('div').remove();
								});
								
								
								

								$(".checkEveryDay").on('click',function(event)
									{
										var e = $(this);
										var dateRange = e.closest('.modal-body').find('.dateRange');

										var startDate = dateRange.find('.start_date');
										var endDate = dateRange.find('.end_date');

										if(startDate.prop('disabled')==false)
										{
											startDate.prop('disabled', true);
											endDate.prop('disabled', true);
										}
										else
										{
											startDate.prop('disabled', false);
											endDate.prop('disabled', false);
										}


									});

								$(".date-picker").datepicker();
								var count=0;
								$.each(checklist.Checklist, function(key, value)
									{
										// var list = '<div class="form-group nput_fields_wrap"><textarea id="task" style="min-height:40px;" class="form-control" name="data[Checklist]['+count+'][checklistdetail]" rows="2" required>'+value.checklistdetail+'</textarea>';

										var list = '<div class="row nput_fields_wrap">'+
											    '<div class="col-md-11">'+
												'<textarea id="task" style="min-height:40px;margin-bottom:10px;" class="form-control" name="data[Checklist]['+count+'][checklistdetail]" rows="2" required>'+value.checklistdetail+'</textarea>'+
												'</div>';

												
										if(count != 0){
											//list += '<a href="#" class="remove">Remove</a>';
											list += '<div class="col-md-1">'+
												'<a href="javascript://" class="remove"><i class="fa fa-minus-circle" style="margin-top:20px;"></i> </a>'+
												'</div>';
										}
										
										list += '<input type="hidden" name="data[Checklist]['+count+'][id]" value="'+value.id+'">';
										list += '</div>';
										list += '</div>';

										$("body .taskLiksts").append(list);
												
										count=count+1;	
										
									});
								$.each(shiftdetails, function(key, value)
                                    {
                                        if( value['Shift']['id'] == shiftId)
                                        {
                                            $(".shiftOptions").append('<option value="'
                                            +value['Shift']['id']+'" selected="selected">'+value['Shift']['title']+'</option>');
                                        }
                                        else
                                        {

                                            $(".shiftOptions").append('<option value="'
                                                +value['Shift']['id']+
                                                '">'+value['Shift']['title']+'</option>');
                                        }

                                    });
	            		}
	            	});

	                
	        });
		// });
</script>
<!--Ends Shiftchecklist edit script-->
<script>
	$(document).ready(function(){
		$("#addChecklistForm").on('submit',function(event){
			event.preventDefault();
			var e = $(this);
			var data = e.serialize();

			shiftId = e.find('#shiftId option:selected').val();
			shiftText = e.find('#shiftId option:selected').text();

			var boardManagerId = "<?php echo $boardManagerId ; ?>";
			var user_id = "<?php echo $user_id; ?>";
			var url = '<?php echo URL; ?>Shiftchecklists/addShiftchecklist.json';
			$.ajax({
				url:url,
				data:data,
				datatype:'jsonp',
				type:'post',
				success:function(response){
					var html = '';
					var count = $("#checklistBody tr").last().attr('count');
					if(count == undefined){
						count = 0;
					}
					var status = response.output.status;
					
					if(status == 1){
						count++;
						var data = response.output.data;

						var shiftChecklistId = response.output.shiftChecklistId;

						html += '<tr data-items="" class="data_row" count="'+count+'" data-id = "'+shiftChecklistId+'">';
						html += '<td>'+count+'</td>';
						html += '<td>'+shiftText+'</td>';
						html += '<td>';


						$.each(data.Checklist,function(key,val){
							if(val.checklistdetail.length != 0){
								html += '<li>'+val.checklistdetail+'</li>';
							}
							
						});
						

						html += '</td>';

						if(data.Shiftchecklist.everyday != null && data.Shiftchecklist.everyday == 1){
							html += '<td>Everyday</td>';
						} else {
							html += '<td>'+data.Shiftchecklist.start_date+' to '+data.Shiftchecklist.end_date+'</td>';
						}

						if(boardManagerId == user_id){
							html += '<td><a href="javascript:;" class="btn btn-xs grey edit_checklist" checklist-id="'+shiftChecklistId+'"><i class="fa fa-edit"></i> Edit </a></td>';
						}
						
						html += '</tr>';
					}

					$("#checklistBody").append(html);
					if($("#checklist_modal").modal('hide')){
						$(".taskDescription").val('');
					}
				}
			});
		});

		$("#editChecklistForm").live('submit',function(event){
			
			event.preventDefault();
			var e = $(this);
			var data = e.serialize();
			var url = '<?php echo URL; ?>Shiftchecklists/editCheckList.json';
			
			shiftId = e.find('#shift-id option:selected').val();
			shiftText = e.find('#shift-id option:selected').text();

			$.ajax({
				url:url,
				type:'post',
				datatype:'jsonp',
				data:data,
				success:function(response){
					var data = response.output.params.data;
					var shiftCheckListId = data.Shiftchecklist.id;
					var tr = $('#checklistBody tr[data-id="'+shiftCheckListId+'"]');
					console.log(tr);
					var count = tr.attr('count');
					console.log(count);
					var html = "";
					var status = response.output.status;

					if(status == 1){
						
						html += '<td>'+count+'</td>';
						html += '<td>'+shiftText+'</td>';
						html += '<td>';


						$.each(data.Checklist,function(key,val){
							if(val.checklistdetail.length != 0){
								html += '<li>'+val.checklistdetail+'</li>';
							}
							
						});
						

						html += '</td>';
						if(data.Shiftchecklist.everyday != undefined && data.Shiftchecklist.everyday == 1){
							html +=  '<td><span>Everyday</span></td>';
						} else {
							html += '<td>'+data.Shiftchecklist.start_date+' to '+data.Shiftchecklist.end_date+'</td>';


						}	
			
		

						html += '<td><a href="javascript:;" class="btn btn-xs grey edit_checklist" checklist-id="'+data.Shiftchecklist.id+'"><i class="fa fa-edit"></i> Edit </a></td>';

						console.log(html);
						tr.html(html);
						toastr.success("Records edited successfully..");
					} else {
						toastr.info("Something goes wrong..Try again.")
					}
					e.closest('.modal').modal('hide')
					
				}
			});
		});
	});
</script>
<!--Managed Table scripts begins-->
<script>
	// var TableManaged = function () {
	// var initTable1 = function () {

	//         var table = $('#sample_1');

	//         // begin first table
	//         table.dataTable({

	//             // Internationalisation. For more info refer to http://datatables.net/manual/i18n
	//             "language": {
	//                 "aria": {
	//                     "sortAscending": ": activate to sort column ascending",
	//                     "sortDescending": ": activate to sort column descending"
	//                 },
	//                 "emptyTable": "No data available in table",
	//                 "info": "Showing _START_ to _END_ of _TOTAL_ entries",
	//                 "infoEmpty": "No entries found",
	//                 "infoFiltered": "(filtered1 from _MAX_ total entries)",
	//                 "lengthMenu": "Show _MENU_ entries",
	//                 "search": "Search:",
	//                 "zeroRecords": "No matching records found"
	//             },

	//             // Or you can use remote translation file
	//             //"language": {
	//             //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
	//             //},

	//             // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
	//             // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
	//             // So when dropdowns used the scrollable div should be removed. 
	//             "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

	//             "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

	//             "columns": [{
	//                 "orderable": false
	//             }, {
	//                 "orderable": true
	//             }, {
	//                 "orderable": true
	//             }, {
	//                 "orderable": false
	//             }, {
	//                 "orderable": false
	//             }, {
	//                 "orderable": false
	//             }],
	//             "lengthMenu": [
	//                 [5, 15, 20, -1],
	//                 [5, 15, 20, "All"] // change per page values here
	//             ],
	//             // set the initial value
	//             "pageLength": 5,            
	//             "pagingType": "bootstrap_full_number",
	//             "language": {
	//                 "search": "My search: ",
	//                 "lengthMenu": "  _MENU_ records",
	//                 "paginate": {
	//                     "previous":"Prev",
	//                     "next": "Next",
	//                     "last": "Last",
	//                     "first": "First"
	//                 }
	//             },
	//             "columnDefs": [{  // set default column settings
	//                 'orderable': false,
	//                 'targets': [0]
	//             }, {
	//                 "searchable": false,
	//                 "targets": [0]
	//             }],
	//             "order": [
	//                 [1, "asc"]
	//             ] // set first column as a default sort by asc
	//         });

	//         var tableWrapper = jQuery('#sample_1_wrapper');

	//         table.find('.group-checkable').change(function () {
	//             var set = jQuery(this).attr("data-set");
	//             var checked = jQuery(this).is(":checked");
	//             jQuery(set).each(function () {
	//                 if (checked) {
	//                     $(this).attr("checked", true);
	//                     $(this).parents('tr').addClass("active");
	//                 } else {
	//                     $(this).attr("checked", false);
	//                     $(this).parents('tr').removeClass("active");
	//                 }
	//             });
	//             jQuery.uniform.update(set);
	//         });

	//         table.on('change', 'tbody tr .checkboxes', function () {
	//             $(this).parents('tr').toggleClass("active");
	//         });

	//         tableWrapper.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
	//     }
	//         return {

	//         //main function to initiate the module
	//         init: function () {
	//             if (!jQuery().dataTable) {
	//                 return;
	//             }

	//             initTable1();
	//         }

	//     };

	// }();
</script>
<!--Managed Table scripts Ends-->

<script type="text/javascript">


			$(".edit_notes").live('click',function(e)
	        {
	        	var shiftNoteId = $(this).attr('shiftnote-id');

	        	var shiftdetails = <?php echo json_encode($boardShiftDetails);?>;	            

	            $.ajax(
	            	{
	            		// url:'<?php echo URL."Shiftnotes/editNotes/"."'+shiftNoteId+'".".json";?>',

	            		url: '<?php echo URL_VIEW."process.php";?>',
	            		data:"action=editNotes&shiftId="+shiftNoteId,
	            		type:'post',
	            		success:function(response)
	            		{

	            			var response = JSON.parse(response);
	            			// console.log(response);
	            			var shiftnote = response.shiftnote;

	            			var shiftId = parseInt(shiftnote.Shift.id);

	            			bootbox.dialog({
								                title: "Edit Note",
								                message:
								                    '<form id="editShiftNoteForm" class="form-body" action="" method="post" enctype="multipart/form-data"> ' +
								                    '<input type="hidden" name="data[Shiftnote][board_id]" value="'+shiftnote.Board.id+'"/>'+
								                    '<input type="hidden" name="data[Shiftnote][id]" value="'+shiftnote.Shiftnote.id+'"/>'+

								                    '<div class="form-group">'+
														'<label>Select Shift</label>'+
														'<select class="form-control shiftOptions" name="data[Shiftnote][shift_id]">'+
														'</select>'+
													'</div>'+

													'<div class="form-group">'+
												'<label>Date Range</label>'+
												'<div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" 	data-date-format="yyyy-mm-dd">'+
															'<input type="text" class="form-control" name="data[Shiftnote][start_date]" value="'+shiftnote.Shiftnote.start_date+'" required />'+
															'<span class="input-group-addon">to</span>'+
															'<input type="text" class="form-control" name="data[Shiftnote][end_date]" value="'+shiftnote.Shiftnote.end_date+'" required>'+
												'</div>'+
			                            		'</div>'+

												'<div class="form-group">'+
													'<label>Note</label>'+
													'<textarea style="min-height:150px;" class="form-control" name="data[Shiftnote][notes]" rows="3" required>'+shiftnote.Shiftnote.notes+'</textarea>'+
												'</div>'+

												'<div class="form-group">'+
				                    			'<label for="image">Image</label>'+
				                    			'<input name="data[Shiftnote][image]" type="file" id="image"/>'+
				                				'</div>'+
				                				'<input type="submit" name="editShiftNote" value="Save" class="btn blue hide">'+
				                				'</form>',
				                				buttons: {
														    success: {
														      label: "Save",
														      className: "btn-success",
														      callback: function() {
														        $("#editShiftNoteForm").submit();
														      }
														    }
														}


	                            			});
								
								$("#editShiftNoteForm").on('submit', function(event)
									{
										event.preventDefault();

										var formData = new FormData($(this)[0]);
										var url = '<?php echo URL; ?>Shiftnotes/editNotes.json';

										$.ajax({
											        url: url,
											        type: 'POST',
											        data: formData,
											        dataType:'jsonp',
											        async: false,
											        success: function (res) {
											            
											            if(res.output.status == 1)
											            {
											            	var data = res.output.data;
											            	var img = '<?php echo URL;?>webroot/files/shiftnote/image/'+data.Shiftnote.image_dir+'/'+data.Shiftnote.image;

												            var tr ='<td>'+data.Shift.title+'</td>'+
												            '<td>'+data.Shiftnote.notes+'</td>'+
												            '<td>'+data.Shiftnote.start_date+'</td>'+
												            '<td>'+data.Shiftnote.end_date+'</td>'+
												            '<td>'+
												            '<a href="'+img+'" data-lightbox=\"image-1\"><img height="30px" width="30px" src="'+img+'"></a>'+
												            '</td>'+
												            '<td>'+
												            '<a href="javascript:;" class="btn btn-xs grey edit_notes" shiftnote-id='+data.Shiftnote.id+'><i class="fa fa-edit"></i> Edit</a>'+
												            '</td>';

												            if($("#shiftNoteTable").find(".noData").length == 1)
												            {
												            	$("#shiftNoteTable").find("tbody").html("");
												            }
												            $("#shiftNoteTable").find("tbody").find('[data-shiftNoteId="'+data.Shiftnote.id+'"]').html("").html(tr);
												            toastr.success("Saved successfully.");
											            }

											        },
											        cache: false,
											        contentType: false,
											        processData: false
											    });

									});

								
								$(".date-picker").datepicker();

								$.each(shiftdetails, function(key, value)
                                    {
                                        if( value['Shift']['id'] == shiftId)
                                        {
                                            $(".shiftOptions").append('<option value="'
                                            +value['Shift']['id']+'" selected="selected">'+value['Shift']['title']+'</option>');
                                        }
                                        else
                                        {

                                            $(".shiftOptions").append('<option value="'
                                                +value['Shift']['id']+
                                                '">'+value['Shift']['title']+'</option>');
                                        }

                                    });
	            		}
	            	});

	                
	        });
</script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script src="<?php echo URL_VIEW; ?>js/date-format/date.format.js" type="text/javascript"></script>
<script>
// jQuery(document).ready(function() {   

	ComponentsPickers.init();
	TableManaged.init();
// });
</script>




