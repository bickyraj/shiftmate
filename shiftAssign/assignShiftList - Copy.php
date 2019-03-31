<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php 

if(isset($_POST['submit']))
{

// echo '<pre>';
// print_r($_POST);
// die();
    $url = URL."ShiftUsers/assignShiftToUser.json";
    $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

                if($response->body->status == 0)
                {
                    echo '<script>
                            toastr.error("Shift assign could not be successful.");
                    </script>';
                }

                else
                {
                    echo '<script>
                            toastr.success("Shift assigned successfully!");
                    </script>';
                }
}

if(isset($_GET['page'])){
    $page_no = $_GET['page'];
}else{
    $page_no = 1;
}
$url = URL."ShiftUsers/assignShiftListByDate/".$orgId."/".$page_no.".json";
$response = \Httpful\Request::get($url)->send();

$assignShiftLists = $response->body->output;

$url = URL."Boards/listBoards/".$orgId.".json";
$response1 = \Httpful\Request::get($url)->send();
$boards = $response1->body->boards;

?>
<div class="modal fade" id="portlet-config_12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Assign Shift</h4>
          </div>
          <div class="modal-body">
  <!-- <form action="" id="BoardAddForm" method="post" accept-charset="utf-8" class="form-horizontal"> -->
	      <div style="display:none;">
	           <input type="hidden" id="org_Id" name="data[ShiftUser][organization_id]" value="<?php echo $orgId;?>">
	      </div>
         
	      <div class="form-body">     
          <?php if(isset($boards) && !empty($boards)){ ?>
         <div>
        <label >Date</label>
        <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
            <input type="text" class="form-control shift-date" id="day_id" name="data[ShiftUser][shift_date]" required>
            <span class="input-group-btn">
            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div>
        <!-- /input-group -->
        <span class="help-block">
        Select date </span>
    </div><br>
		          

               <div>
		        	<label >Department Name</label>
		    	
				    <select class="form-control" id="boardname" name="data[ShiftUser][board_id]">
				        <option value="" selected disabled>Select Department</option>
				        <?php foreach ($boards as $board):?>
				        <option value="<?php echo $board->Board->id;?>"><?php echo $board->Board->title;?></option>
				        <?php endforeach;?>

				    </select> 
		    	</div> <br>   


        <div>
            <label >Assgin Shift</label>
            <select id="shifts" class="form-control" name="data[ShiftUser][shift_id]">
                <option value="" selected disabled>Select Shift</option>
            </select>
            <div class="pull-right" id="emptyshift"></div>
                                    
        </div> <br>                      
            

        <div>
        	<label>User</label>
        <select class="form-control" id="boardusers" name="data[ShiftUser][user_id]">
        	<option value="" selected disabled>Select Employee</option>
        </select>
            
        </div><br/> 
        <?php }else{ ?>
        <div style="text-align: center;font-size: 2em;">There are currently no Departments.</div>
        <?php } ?>
      </div><br/>
      
      
      <div class="form-actions">
         <div class="modal-footer">
          
              <div class="col-md-offset-3 col-md-9">
                <?php if(isset($boards) && !empty($boards)){ ?>
                  <input data-dismiss="modal" type="submit" name="submit" class="btn btn-success submit_assign" value="Submit"/>
                 <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php //echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                  <input type="reset" data-dismiss="modal" name="cancel" value="Close" class="btn default">
                  <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
                <?php }else{ ?>
                    <a href="<?=URL_VIEW; ?>boards/listBoards?org_id=<?=$orgId;?>" class="btn btn-success">Add Department</a>  
                <?php } ?>
              </div>
          
        </div>
      </div><!-- </form> -->
          </div>
      </div><!-- /.modal-content -->
  </div>               <!-- /.modal-dialog -->
</div>

<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Assign Shift List <small>View Assign Shift List</small></h1>
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
                <a href="<?=URL_VIEW."shifts/listShifts";?>">Shifts</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?=URL_VIEW."shiftAssign/assignShiftList";?>">Shiftpool Assign</a>
            </li>
        </ul> 
        
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Assign Shifts</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                        <div class="pull-right">
                            <a href="#portlet-config_123"  data-toggle="modal" class="config" style="color:white; ">
                                <button class="btn btn-fit-height green dropdown-toggle btnAssign">
                                <i class="fa fa-plus"></i> Assign Shift </button></a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                        <thead>
                        <tr>
                            <th >
                                 Employ
                            </th>
                            <th >
                                 Shifts
                            </th>
                            <th>
                            	Shift Start Time
                            </th>
                            <th>
                            	Shift End Time
                            </th>
                            <th >
                                 Date
                            </th>
                            <th width="150px">
                                 Action
                            </th>
                            
                        </tr>
                        </thead>
                        <tbody id="test">
                         <?php 

                            if (isset($assignShiftLists) && !empty($assignShiftLists)) {
                            $i = 1; 
                            
                            foreach ($assignShiftLists as $assignShiftList):
                            	//die();
                                //print_r($group);
                         ?>
                        <tr>
                            <td>
                                <?php echo $assignShiftList->User->fname.' '.$assignShiftList->User->lname; ?>
                            </td>
                            <td>
                               <?php echo $assignShiftList->Shift->title; ?>
                            </td>
                            <td>
                        		<?php
                        			$start_time = $assignShiftList->Shift->starttime;
                            		echo (date("g:i a", strtotime($start_time)));
                        		?>
                            </td>
                            <td>
                            	<?php
                        			$end_time = $assignShiftList->Shift->endtime;
                            		echo (date("g:i a", strtotime($end_time)));
                        		?>
                            </td>
                           <td>
                           		<?php echo $assignShiftList->ShiftUser->shift_date; ?>
                           </td>
                            <td>
                            	<?php
                            		if ($assignShiftList->ShiftUser->status == 0) {
                            			echo 'open Shift';
                        			?>
                        			<button class="delete"	id="<?php echo $assignShiftList->ShiftUser->id; ?>"><i class="fa fa-close"></i></button>
                        			<?php
                            		}
                            		elseif ($assignShiftList->ShiftUser->status == 1) {
                            			echo 'Manager Assigned Shift';
                            			?>
                            			<button class="delete" id="<?php echo $assignShiftList->ShiftUser->id; ?>"><i class="fa fa-close"></i></button>
                            			<?php
                            		}
                            		elseif ($assignShiftList->ShiftUser->status == 2) {
                            			echo 'Employ Requested For Shift';
                        			?>
                        			<button class="delete" id="<?php echo $assignShiftList->ShiftUser->id; ?>"><i class="fa fa-close"></i></button>
                        			<?php
                            		}
                            		elseif ($assignShiftList->ShiftUser->status == 3) {
                            			echo 'Shift Confirm';
                        			?>
                            			<button class="btn blue delete" id="<?php echo $assignShiftList->ShiftUser->id; ?>"><i class="fa fa-close"></i></button>
                            		<?php
                            		}
                            		else
                            		{
                            			echo "Something Went Wrong";
                            		}
                            	?>
                            </td>
                        </tr>
                        <?php

                                endforeach;

                            }
                            else{
                        ?>
                        <tr style="text-align: center;font-size: 1.5em"><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
                        <?php
                            }
                        ?>
                        </tbody>
                        </table>
                        <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                            <?php
                            $page = $response->body->page;
                            $max = $response->body->maxPage;
                            if($max>0){
                            ?>
                            <div>Showing Page <?=$page;?> of <?=$max;?></div>
                            <ul class="pagination" style="visibility: visible;">
                                <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                    <?php if($page<=1){ ?>
                                        <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                    <?php }else{ ?>
                                        <a title="First" href="?page=1"><i class="fa fa-angle-double-left"></i></a>
                                    <?php } ?>
                                </li>
                                <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                    <?php if($page<=1){ ?>
                                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                    <?php }else{ ?>
                                        <a title="Prev" href="?page=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                    <?php } ?>
                                </li>

                                <?php if($max<=5){
                                    for($i=1;$i<=$max;$i++){ ?>
                                        <li>
                                            <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                        </li>
                                    <?php }}else{
                                    if(($page-2)>=1 && ($page+2)<=$max){
                                        for($i=($page-2);$i<=($page+2);$i++){ ?>
                                            <li>
                                                <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                        <?php  }}elseif(($page-2)<1){
                                        for($i=1;$i<=5;$i++){ ?>
                                            <li>
                                                <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                        <?php }}elseif(($page+2)>$max){
                                        for ($i=($max-4);$i<=$max;$i++){ ?>
                                            <li>
                                                <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page=<?=$i?>"><?=$i;?></a>
                                            </li>
                                        <?php }}} ?>

                                <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                    <?php if($page>=$max){ ?>
                                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                    <?php }else{ ?>
                                        <a title="Next" href="?page=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                    <?php } ?></li>
                                <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                    <?php if($max==0 || $max==1){ ?>
                                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                    <?php }else{ ?>
                                        <a title="Last" href="?page=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                    <?php } ?></li>
                            </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script>

$(".btnAssign").on("click",function(){
    $("#portlet-config_12").modal();
});

$("#portlet-config_12").on("hidden.bs.modal",function(){
    // $("#day_id").val('');
    // $("#boardusers").val("Select Department").attr("selected","selected");
});

$(".submit_assign").click(function(){
    var shiftDate = $("#day_id").val();
    var userId = $("#boardusers").val();
    var orgId = $("#org_Id").val();
    var shiftId = $("#shifts").val();
    var boardId = $("#boardname").val();
    $.ajax({
        url:'<?php echo URL."ShiftUsers/addShiftForUser/";?>'+orgId+'/'+shiftId+'/'+boardId+'/'+userId+'/'+shiftDate+'.json',
        datatype:'jsonp',
        async:false,
        success: function (response){
            if(response.status == 1) {
                toastr.info('Employee successfully assigned for that shift');
                 var data ='<tbody><tr><td>'+response.fullname+'</td><td>'+response.shift+'</td><td>'+response.starttime+'</td><td>'+response.starttime+'</td><td >'+shiftDate+'</td><td width="150px">open Shift<button class="delete"><i class="fa fa-close"></i></button></td></tr></tbody>';
                var row = document.getElementById('sample_editable_1');
                row.innerHTML = row.innerHTML + data;       
            } else {
                toastr.info('Something goes wrong');
            }
        }  
    });

});
</script>

<script type="text/javascript">
	$(document).ready(function(){

//     $('#day_id').datepicker().on('changeDate',function(ev){
//     alert("h");
// });
		$('.delete').on('click',function(){
            var e= $(this);
			var shiftId = this.id;//$('#id').val();
           //alert (shiftId);
            $.ajax({
                url: "<?php echo URL_VIEW."process.php";  ?>",
                data:"action=userAssignShift&shiftUserid="+shiftId,
                type:'post',
                async:false,
                success: function (response)
                {

                    if (response.output == 1) {
                        //var n = e.closest('table tbody tr').length;
                        var n = $('#test tr').length;
                        
                        if (n == 1) {
                            var tr =e.closest('tr');
                            tr.html("");
                            tr.html('<td colspan="6">No Assigned Shift</td>');
                        }
                        else
                        {
                            e.closest('tr').remove();
                        }
                       
                         toastr.success('Removed successfully');   

                    }
                    else
                    {
                        toastr.error('something went wrong');
                    }
                }, 
                error: function (msg) {
                    alert(msg + 'error');
                }
            });
		});
	});
</script>


<script type="text/javascript">

        $(document).ready(function(){
            $("#boardname").change(function(){
                var shift_date=$('#day_id').val();

                var boardId =  $("#boardname").val();

                //getBoardUser(boardId);
                getShifts(boardId);
                
                var shiftId = $("#shifts").val();
                //console.log(shiftId+" "+boardId);

                if(shift_date != "" && shiftId != ""){
                    getAvailableUser(shiftId,boardId,shift_date);
                } else {
                    $("#day_id").focus();
                }

            });

            function getBoardUser(boardId)
            {
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getboarduser&boardId="+boardId,
                    type: "post",
                    async:false,
                    success:function(response){
                        var data;
                        var users = JSON.parse(response);
                        
                        $.each(users, function(k,obj){
                            console.log(obj);
                           data+= "<option value=" + obj.User.id + ">" + obj.User.fname+" "+obj.User.lname+ "</option>";
                       });

                      $("#boardusers").html(data);
                    }
                });

            }

            function getShifts(boardId)
            {
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getShifts&boardId="+boardId,
                    type: "post",
                    async:false,
                    success:function(response){
                        
                        $("#shifts").html("");
                        var data;
                        var shifts = JSON.parse(response);

                        if(jQuery.isEmptyObject(shifts))
                        {
                            
                            data = "<option value=''>No Shift on this board</option>";
                            data1 = "<a class='btn blue' style='margin-top:10px; margin-bottom:10px;' href='<?= URL_VIEW."shiftBoards/boardShiftList?board_id="?>"+boardId+"'>Add Shift</a>";
                            $("#emptyshift").html(data1);
                            $("#shifts").html(data);
                        }
                        else
                        {
                            $.each(shifts, function(k,obj){
                                data+= "<option value=" + obj.Shift.id + ">" +obj.Shift.title+ "</option>";
                                });
                            $("#emptyshift").html("");
                            $("#shifts").html(data);
                        }

                        
                    }
                });
            }   


            function getAvailableUser(shiftId,boardId,shift_date)
            {
               // alert(orgId+" -- "+boardId+" -- "+dayId+" -- "+shiftId+" -- "+day);
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getAvailableUser&shiftId="+shiftId+"&boardId="+boardId+"&shift_date="+shift_date,
                    type: "post",
                    async:false,
                    success:function(data){
                        //console.log(data);
                        var data1="";
                        data=JSON.parse(data);

                         // console.log(data);

                     
                     if(data=='User not Found'){


                       data1+="<option value=''>No User Found</option>";
                        $('#boardusers').html(data1);
                     } else {

                      $.each(data,function(k,v){

                          
                           // alert(v.user_id);
                          data1+="<option value="+v.user_id+">"+v.name+"</option>";

                    });
                  }
                       $('#boardusers').html(data1);
                    }
                });

            }

            $('#shifts').change(function(){ 
                
                var shift_date=$('#day_id').val();

                var boardId =  $("#boardname").val();

                var shiftId = $("#shifts").val();
                if(shift_date != ""){
                    getAvailableUser(shiftId,boardId,shift_date);
                } else {
                    $("#day_id").focus();
                }
                
            });

        });
</script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   ComponentsPickers.init();
});   

</script>

