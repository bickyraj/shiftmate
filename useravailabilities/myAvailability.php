<?php
// $userId = $_GET['user_id'];
//$userId = 6;


$url = URL . "Useravailabilities/useravailabilityList/" . $userId . ".json";
$data = \Httpful\Request::get($url)->send();

$availabilities = $data->body->availabilities;
$availability_status = $data->body->availabilities_status;

//  echo "<pre>";
// print_r($availabilities);
// print_r($availability_status);
// die();

$url = URL . "Shifts/shiftListByOrg/" . $userId . ".json";
$data = \Httpful\Request::get($url)->send();
$shifts = $data->body;
//fal($shifts);
?>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- Edit-->
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>User Availability <small> user Availability</small></h1>
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
    			<a href="javascript:;">Availability</a>
    		</li>
        </ul>
		<!-- row -->
		<div class="row">
			<div class="col-md-12 col-sm-12">

				<div class="portlet light">
					<div class="portlet-title tabbable-line">
						<div class="caption caption-md">
							<i class="icon-bar-chart theme-font hide"></i>
							<span class="caption-subject theme-font bold uppercase">My Availability</span>
							<!-- <span class="caption-helper hide">weekly stats...</span> -->
						</div>

						<ul class="nav nav-tabs pull-left" style="margin-left:40px;">
                            <li class="active">
                                <a aria-expanded="true" href="#tab_2_1" data-toggle="tab">
                                Availability By Day </a>
                            </li>
                            <li  class="">
                                <a aria-expanded="false" href="#tab_2_2" data-toggle="tab">
                                Availability By Shift </a>
                            </li>
                        </ul>

                        	<div class="btn-group pull-right">
				            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
				                Actions <i class="fa fa-angle-down"></i>
				            </button>
				                <ul class="dropdown-menu pull-right" role="menu">
				                	<?php if($availability_status == 1) { ?>
				                    <li>
				                        <a href="<?php echo URL_VIEW . 'useravailabilities/updateEmployeeAvailabilities?user_id='.$userId;?>">Edit Availability</a>
				                    </li>
				                    <?php
				                    	}
				                    	else
				            			{
				                    ?>
				                    <li>
				                        <a href="<?php echo URL_VIEW . 'useravailabilities/addEmployeeAvailabilities?user_id='.$userId;?>">Add Availability </a>
				                    </li>
				                    <?php } ?>
				                </ul>
				        	</div>

					</div>


					<div class="portlet-body">

                        <div class="tab-content">
							<div id="tab_2_1" class="tab-pane fade active in">
							<div class="row">
							
							<?php if($availability_status == 1):?>
							<?php foreach($availabilities as $availability):?>
								<?php if($availability->data->status == 0 || $availability->data->status == 1){ ?>
									<div class="col-md-4">
										<div class="portlet box green">

											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i><?php echo $availability->day->title;?>
												</div>
												<!-- <div class="actions">
								                    <a href="" class="btn btn-default btn-sm">
								                    <i class="fa fa-edit"></i> Edit </a>
								                </div> -->
											</div>
											<?php if($availability->data->status==0){ ?>
											<div class="portlet-body">
												<div class="scroller" style="height: 60px;">
													<h4>Available</h4>
												</div>
											</div>
											<?php
												}
											else {//if($availability->data->status==1) {
											?>
											<div class="portlet-body">
												<div class="scroller" style="height: 60px;">
													<h4>
														<?php foreach ($availability->time as $time):?>
															<div class="myavailDateTimeDiv"><?php echo hisToTime($time->starttime)."-".hisToTime($time->endtime);?>
														</div><?php endforeach;?>
													</h4>
												</div>
											</div>
											<?php
												 }
												// else {
											?>

											<!-- <div class="portlet-body">
												<div class="scroller" style="height: 60px;">
													<h4>Not Available</h4>
												</div>
											</div> -->
										<?php //} ?>
										</div>
									</div>
								<?php }
									else if ($availability->data->status == 2 ) {
								?>
									<div class="col-md-4">
										<div class="portlet box red">

											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i><?php echo $availability->day->title;?>
												</div>
											</div>
											<div class="portlet-body">
												<div class="scroller" style="height: 60px;">
													<h4>Not Available</h4>
												</div>
											</div>
										</div>
									</div>

								<?php
									}
									else{
								?>

								<?php
									}
								?>
							<?php endforeach; ?>
							<?php else:?>
								<div class="redFont" style="font-size: 1.5em;text-align: center;text-decoration: blue;">No availability.</div>
							<?php endif;?>
						</div>
					</div>


						<div id="tab_2_2" class="tab-pane fade">
							<div class="row">
								<div class="col-md-2 col-sm-2 col-xs-2 ">
                                    <ul class="nav nav-tabs tabs-left selectTab">
                                    	<?php $count = 0; if(!empty($shifts)){ ?>
                                    	<?php foreach($shifts as $key=>$s) { $count++; ?>
                                        <li count="<?php echo $count; ?>" class="<?php if($count == 1){ echo 'active'; } ?>">
                                            <a aria-expanded="true" href="#tab_6_<?php echo $count ?>" data-toggle="tab">
                                            <?php echo $key; ?> </a>
                                        </li>
                                        <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="col-md-10 col-sm-10">

									<div class="tab-content">
										<?php $c = 0; if(!empty($shifts)){ ?>
                                    	<?php foreach($shifts as $s) {  $c++; ?>
										<div id="tab_6_<?php echo $c; ?>" class="tab-pane fade <?php if($c==1){echo 'active in'; } ?> ">
											<div class="table table-responsive">	
												<table id="shiftTable_<?php echo $c; ?>" class="table table-hover table-light">
													<thead>
														<tr class='uppercase'>
															<th>SN</th>
															<th>Shift</th>
															<th>Time</th>
															<th>Status</th>
															<th>Action</th>
														</tr>

													</thead>
													<tbody>
													<?php if(!empty($s)){ ?>
													<?php $cn = 0; foreach($s as $s1){ $cn++;?>
														<tr data-availability="<?php echo $s1->availability; ?>" data-orgId="<?php echo $s1->organization_id; ?>" data-shiftId="<?php echo $s1->id; ?>">
															<td><?php echo $cn; ?></td>
															<td><?php echo $s1->title; ?></td>
															<td><?php echo hisToTime($s1->starttime).' to '.hisToTime($s1->endtime); ?></td>
															<td>
															<?php if($s1->availability == 0){ ?>
															<span class="label label-sm label-success">Available </span>
															<?php } else { ?>
															<span class="label label-sm label-warning">Not Available </span>
															<?php } ?>
															</td>
															<td> <span class="editAvailable btn purple btn-sm"><i class="fa fa-edit"> </i> Edit</span></td>

														</tr>
													<?php } ?>	
													<?php } ?>	

													</tbody>
												</table>
											</div>	
										</div>
										<?php } ?>
                                        <?php } ?>
							
									</div>
                                </div>
							</div>
						
						</div>
                   
                        </div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editAvailable" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Availability</h4>
			</div>
			<form id="editForm">
			<div class="modal-body">
				<div id="hidden-items">

				</div>
				 <div class="form-group">
	<!-- 					<label>Inline Radios</label> -->
					<div class="input-group">
						<div class="icheck-inline">
							<label>
							<input id="available" type="radio" name="data[Shiftavailability][status]" class="icheck" value="0"> Available </label>
							<label>
							<input id="notAvailable" type="radio" name="data[Shiftavailability][status]" class="icheck" value="1"> Not Available </label>
					
						</div>
					</div>
				</div>
			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn blue">Update</button>
			</div>
			</form>	
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
$(document).ready(function(){
	var countId = 1;
	

	$(".selectTab > li").on('click',function(){
		countId = $(this).attr('count');
		
	});
	$("#shiftTable_"+countId).DataTable({
		   	paging:false,
		   	bFilter:false,
		   	ordering:false,
		   	info:false
		   });
	

	$(".editAvailable").live('click',function(){
		var e = $(this);
		var html = "";
		var orgId = $(this).closest('tr').attr('data-orgId');
		var shiftId = $(this).closest('tr').attr('data-shiftId');
		var availability = $(this).closest('tr').attr('data-availability');

		var table = $("#shiftTable_"+countId).DataTable();
		var idx = table.row(e.closest('tr')).index();
		$("#editForm").attr('data-idx',idx);

		if(availability == 0){
			$("#available").attr('checked','checked');
		} else {
			$("#notAvailable").attr('checked','checked');
		}

		html += '<input type="hidden" name="data[Shiftavailability][organization_id]" value="'+orgId+'">';
		html += '<input type="hidden" name="data[Shiftavailability][shift_id]" value="'+shiftId+'">';
		$("#hidden-items").html(html);
		$("#editAvailable").modal();
	});

	$("#editForm").live("submit",function(event){
		event.preventDefault();
		var e = $(this);
		var data = e.serialize();
		var userId = '<?php echo $userId ?>';
		var url = '<?php echo URL;?>Shiftavailabilities/updateAvailability/'+userId+'.json';
		$.ajax({
			url:url,
			data:data,
			type:'post',
			datatype:'jsonp',
			success:function(response){
				var status = response.status ;
				e.closest('.modal').modal('hide');
				var idx = e.attr('data-idx');
				var table = $("#shiftTable_"+countId).DataTable();
				if(status == 0){
					table.cell(idx,3).data("<span class='label label-sm label-success'>Available </span>").draw();

					toastr.success("Records updated successfully");
				} else if(status == 1){
					table.cell(idx,3).data("<span class='label label-sm label-warning'>Not Available </span>").draw();

					toastr.success("Records updated successfully");
				}
				

			}
		});
	});
});
</script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>