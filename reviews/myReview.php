<?php
if(isset($_GET['pages'])){
	$page = $_GET['pages'];
} else {
	$page = 1;
}
$url1 = URL . "Reviews/viewMyReview/".$userId.'/'.$page.".json";
$data1 = \Httpful\Request::get($url1)->send();
$reviews = $data1->body->result;
//fal($reviews);

if(isset($_POST['saveMeetingRequest'])){

    // fal($_POST);
    $url = URL . "Senders/addRequest.json";
    $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();
?>
<script>
toastr.info("Your appeal has been successfully sent to manager.");
</script>
<?php } ?>
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>My Review <small>view your review</small></h1>
		</div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo URL_VIEW; ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?=URL_VIEW."reviews/myReview";?>">Review</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 col-sm-12">
	            <div class="portlet light">
	            	<div class="portlet-title">
	                    <div class="caption caption-md">
<!-- 	                        <i class="fa fa-users theme-font"></i>
 -->	                        <span class="caption-subject theme-font bold uppercase">Review Lists</span>
	                        <!-- <span class="caption-helper hide">weekly stats...</span> -->
	                    </div>
	                </div> 
	                <div class="portlet-body">
						<div class="table-scrollable">
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th>
							 SN
						</th>
						<th>
							Organisation 
						</th>
						<th>
							 Branch
						</th>
						<th>
							 Department
						</th>
		                <th>
		                    Review Type
		                </th>
						<th>
							Review Date
						</th>
						<th>
							View
						</th>
						<th>
							Action
						</th>	
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($reviews)) { ?>
						<?php $count = 1; foreach($reviews as $k=>$r): ?>
							<tr review-id="<?php echo $r->Review->id; ?>">
								<td><?php echo $count; ?></td>
								<td><?php echo $r->Organization->title; ?></td>
								<td><?php echo $r->Branch->title; ?></td>
								<td><?php echo $r->Board->title; ?></td>
								<td><?php echo $r->Review->reviewtype; ?></td>
								<td><?php echo convertDate($r->Review->reviewdate); ?></td>
								<td><span class="btn btn-sm purple view"><i class="fa fa-eye"> </i> View</span></td>
								<td><span class="btn btn-sm green appeal">Appeal</span></td>
							</tr>
						<?php $count++; endforeach;?>		
					<?php } ?>
				</tbody>
			</table>

			    <hr>
                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                    <?php
                    $page=$data1->body->page;
                    $max=$data1->body->maxPage;
                    ?>
                    <div>Showing Page <?=$page;?> of <?=$max;?></div>
                    <ul class="pagination" style="visibility: visible;">
                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                        <?php if($page<=1){ ?>
                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                        <?php }else{ ?>
                            <a title="First" href="?pages=1"><i class="fa fa-angle-double-left"></i></a>
                        <?php } ?>
                        </li>
                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                        <?php if($page<=1){ ?>
                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                        <?php }else{ ?>
                            <a title="Prev" href="?pages=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                        <?php } ?>
                        </li>
                        
                        <?php if($max<=5){
                            for($i=1;$i<=$max;$i++){ ?>
                            <li>
                               <a title="<?=$i;?>" href="?pages=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                            </li>
                         <?php }}else{
                            if(($page-2)>=1 && ($page+2)<=$max){
                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                <li>
                                   <a title="<?=$i;?>" href="?pages=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                </li>
                          <?php  }}elseif(($page-2)<1){
                            for($i=1;$i<=5;$i++){ ?>
                                <li>
                                   <a title="<?=$i;?>" href="?pages=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                </li>
                         <?php }}elseif(($page+2)>$max){
                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                <li>
                                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?pages=<?=$i?>"><?=$i;?></a>
                                </li>
                        <?php }}} ?>
                        
                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                        <?php if($page>=$max){ ?>
                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                        <?php }else{ ?>
                        <a title="Next" href="?pages=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                        <?php } ?></li>
                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                        <?php if($max==0 || $max==1){ ?>
                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                        <?php }else{ ?>
                        <a title="Last" href="?pages=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                        <?php } ?></li>
                    </ul>
                </div>

		</div>
			</div>       
	            </div>
            </div>
        </div>
    </div>
</div> 
<div id="new_meeting_request" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Request for meeting</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="data[Sender][status]" value="3"/>
                    <input type="hidden" name="data[Sender][user_id]" value="<?php echo $user_id;?>"/>
                    <div class="form-group form-md-line-input form-md-floating-label">
					
					<select class="form-control edited" id="form_control_org_name" name="data[Sender][organization_id]">
					
					</select>
					<label for="form_control_1">Organisation</label>
					</div>
                    <div class="form-group form-md-line-input form-md-floating-label">
						<select class="form-control edited" id="form_control_select_type">
							<option value="1">Department</option>
							<option value="2">Branch</option>
						</select>
						<label for="form_control_select_type">Select Manager From</label>
					</div>
                    <div class="form-group form-md-line-input form-md-floating-label">
						<select class="form-control edited" id="form_control_value">

						</select>
						<label for="form_control_3" id="name_req_lvl">Department</label>
					</div>
                    <div class="form-group form-md-line-input form-md-floating-label">
						<select class="form-control edited" id="form_control_manager_list" name="data[Receiver][user_id]">

						</select>
						<label for="form_control_3">Manager</label>
					</div>
                    <label for="data[Message][requesteddate]">Meeting Date</label>
                    <div class="input-group input-medium date date-pickerxy" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
						<input type="text" name="data[Sender][requesteddate]" class="form-control" readonly=""/>
						<span class="input-group-btn">
						<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
					</div>
                    <div class="form-group form-md-line-input form-md-floating-label">
    					<input type="text" class="form-control" name="data[Sender][title]"/>
    					<label for="form_control_1">Title</label>
				    </div>
                    <div class="form-group form-md-line-input form-md-floating-label">
    					<textarea class="form-control" rows="3" name="data[Sender][content]"></textarea>
    					<label for="form_control_1">Description</label>
				    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="saveMeetingRequest">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>  
<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Review Details</h4>
		</div>
		<div class="modal-body">
			 Modal body goes here
		</div>
		<div class="modal-footer">
			<span id="acknowledge-button">
				<span style="font-style:italic; margin-right:10px;">Click , Acknowledge button to accept this review.</span><button type="button" class="btn btn-sm green acknowledge">Acknowledge</button>
			</span>
			<button type="button" class="btn btn-sm default" data-dismiss="modal">Close</button>
			
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
$(document).ready(function(){
	
	$('.view').on('click',function(){
		var reviewId = $(this).closest('tr').attr('review-id');
		var reviewStatus = 2;
		var url = "<?php echo URL; ?>Reviews/reviewById/"+reviewId+'/'+reviewStatus+'.json';
		var modal = $("#basic");
		$.ajax({
			url:url,
			type:'post',
			datatype:'jsonp',
			success:function(response){
				console.log(response);
				var details = response.Review.details;
				var status = response.Review.status;
				if(status == 1){
					$("#acknowledge-button").hide();
				} else {
					$("#acknowledge-button").show();
				}
				var body = '.modal-body';
				
				modal.find(""+body+"").html(details);
				modal.find(""+body+"").attr("review-id",''+reviewId+'');
			}
		});
		modal.modal();
	});

	$('.acknowledge').on('click',function(){
		var reviewId = $("#basic").find(".modal-body").attr('review-id');
		var reviewStatus = 1;
		var url = '<?php echo URL;?>/Reviews/updateReviewStatus/'+reviewId+'/'+reviewStatus+'.json';
		$.ajax({
			url:url,
			type:'post',
			datatype:'jsonp',
			success:function(response){
				var status = response.status;
				//console.log(status);
				if(status == 1){
					toastr.success("You have acceted the review successfully.");
				} else {
					toastr.info("Sorry, something goes wrong, try again");
				}
			}
		});
		$("#basic").modal('hide');
	});

	$(".appeal").on('click',function(){
		var reviewId = $(this).closest('tr').attr('review-id');
		var modal = $("#new_meeting_request");
		var url = "<?php echo URL;?>Reviews/reviewById/"+reviewId+'.json';
		modal.modal();
		$.ajax({
			url:url,
			type:'post',
			datatype:'jsonp',
			success:function(response){
				var orgName = response.Organization.title;
				var orgId = response.Organization.id;
				var boardId = response.Board.id;
				var boardName = response.Board.title;
				var branchName = response.Branch.title;
				var branchId = response.Branch.id;
				var dataFor = $("#form_control_value");
				$("#form_control_org_name").html('<option value="'+orgId+'">'+orgName+'</option>');
					dataFor.html('<option value="'+boardId+'">'+boardName+'</option>');
					dataFor.attr('board-name',boardName);
					dataFor.attr('board-id',boardId);
					dataFor.attr('branch-name',branchName);
					dataFor.attr('branch-id',branchId);
					getmanager(boardId);

				//console.log(response);
			}
		});
	});

	
	$("#form_control_select_type").on('change',function(){
		var formControl = $("#form_control_value");
		var selected = $(this).find('option:selected').val();
		var boardId = formControl.attr('board-id');
		var boardName = formControl.attr('board-name');
		var branchId = formControl.attr('branch-id');
		
		var branchName = formControl.attr('branch-name');

		if(selected == 2){
			getmanager(branchId);
			formControl.html('<option value="'+branchId+'">'+branchName+'</option>');
			$("#name_req_lvl").text("Branch");
		} else {
			getmanager(boardId);
			formControl.html('<option value="'+boardId+'">'+boardName+'</option>');
			$("#name_req_lvl").text("Department");
		}
	});

	function getmanager(selectedId){
		var selected = $('#form_control_select_type option:selected').val();
		console.log(selectedId);
        if(selected == 1){
            $.ajax({
                    url: "<?php echo URL;?>Boards/viewBoard/"+selectedId+".json",
                    datatype: "jsonp",
                    success:function(data){
                    	console.log(data);
                        var data1 = "";
                        if(data.board.length != 0){
                            if(data.board.User.fname == ""){
                                data1 = "<option value=" + data.board.User.id + ">" + data.board.User.email + "</option>";
                            }else if(data.board.Board.user_id != 0){
                                data1 = "<option value=" + data.board.User.id + ">" + data.board.User.fname+" "+data.board.User.lname + "</option>";
                            } else {
                            	data1 = "<option>Manager not available for this department.</option>"
                            }
                        } else {
                        	data1 = "<option>Manager not available for this department.</option>"

                        }
                        $("#form_control_manager_list").html(data1);
                    }
                });
        }
        else{
            $.ajax({
                    url: "<?php echo URL;?>Branches/viewBranch/"+selectedId+".json",
                    datatype: "jsonp",
                    success:function(data){
                        var data1 = ""; 
                        console.log(data);
                        if(data.branch.length != 0){
                            if(data.branch.User.fname == ""){
                                data1 = "<option value=" + data.branch.User.id + ">" + data.branch.User.email + "</option>";
                            }else if(data.branch.Branch.user_id != 0){
                                data1 = "<option value=" + data.branch.User.id + ">" + data.branch.User.fname+" "+data.branch.User.lname + "</option>";
                            } else {
                            	data1 = "<option>Manager not available for this branch.</option>";
                            }
                        } else {
                        	data1 = "<option>Manager not available for this branch.</option>";

                        }                    
                        $("#form_control_manager_list").html(data1);
                    }
                });
        }
    }

$('.date-pickerxy').datepicker(); 
});
</script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>