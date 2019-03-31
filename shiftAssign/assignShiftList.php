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
// fal($assignShiftLists);

$url = URL."Boards/listBoards/".$orgId.".json";
$response1 = \Httpful\Request::get($url)->send();
$boards = $response1->body->boards;

// fal($boards);

?>


<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Assign Shift List <small>View Assign Shift List</small>
            </h1>
        </div> 
    </div> 
</div> 
<div class="page-content"> 
    <div class="container"> 
        <ul class="page-breadcrumb breadcrumb"> 
            <li> 
                <i class="fa fa-home"> 
                </i> 
                <a href="<?php echo URL_VIEW; ?>">Home</a> 
                <i class="fa fa-circle"> 
                </i> 
            </li> 
            <li> 
                <a href="<?=URL_VIEW."shifts/listShifts";?>">Shifts</a> 
                <i class="fa fa-circle"> 
                </i> 
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
                            <a id="assignShiftModalBtn"  data-toggle="modal" class="config" style="color:white; ">
                                <button class="btn btn-fit-height green dropdown-toggle btnAssign">
                                <i class="fa fa-plus"></i> Assign Shift </button></a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                                <table id="shiftAssingnTable" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>
                                         Employee
                                    </th>
                                    <th>
                                        Shift
                                    </th>
                                    <th>
                                         Assign Date
                                    </th>
                                    <th>
                                         Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="shiftAssignTbody">
                                    <?php if (isset($assignShiftLists) && !empty($assignShiftLists)): ?>
                                        <?php foreach ($assignShiftLists as $shiftUser): ?>
                                            <tr>
                                                <td>
                                                     <?php echo $shiftUser->User->fname." ".$shiftUser->User->lname; ?>
                                                </td>
                                                <td>
                                                     <?php echo $shiftUser->Shift->title; ?>
                                                </td>
                                                <td>
                                                     <?php echo convertDate($shiftUser->ShiftUser->shift_date); ?>
                                                </td>
                                                <td>
                                                    <button type="button" data-shiftUserId="<?php echo $shiftUser->ShiftUser->id; ?>" class="delete btn btn-sm red">Remove</button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <tr id="emptyRow">
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                                </table>
                            </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assignShiftModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Shift Assignation</h4>
            </div>
            <form id="shiftAssignFrom" role="form">
                <div style="display:none;">
                    <input type="hidden" name="data[ShiftUser][organization_id]" value="<?php echo $orgId;?>">
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                <input type="text" class="form-control shift-date" id="day_id" name="data[ShiftUser][shift_date]" required>
                                <span class="input-group-btn">
                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Department</label>
                            <select class="form-control" id="boardSelect" required name="data[ShiftUser][board_id]">
                                <option value="" selected>Select Board</option>
                                <?php foreach ($boards as $board): ?>
                                    <option value="<?php echo $board->Board->id; ?>"><?php echo $board->Board->title; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Shift</label>
                            <select id="shiftSelect" class="form-control" required name="data[ShiftUser][shift_id]">
                                <option value="" selected>Select Shift</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Employee</label>
                            <select class="form-control" id="empSelect" required name="data[ShiftUser][user_id]">
                                <option value="" selected>Select Employee</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn blue">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js">
</script>

<script src="<?php echo URL_VIEW; ?>js/date-format/date.format.js" type="text/javascript"></script>

<script>
    
    function dateToString(date)
    {
        today = new Date(date);
        var dateString = today.format("dS mmmm yyyy");

        return dateString;
    }

    function getShiftList(boardId)
    {
        var url = '<?php echo URL; ?>ShiftBoards/getBoardShiftList/'+boardId+'.json';
        var list = [];
        $.ajax(
            {
                url:url,
                async:false,
                dataType:'jsonp',
                success:function(res)
                {
                    // console.log(res);
                    list = res.boardShifts;
                }

            });
        return list;
    }

    function getAvailableUser(shiftId,boardId,shift_date)
    {
        $.ajax({
            url: "<?php echo URL_VIEW."process.php";?>",
            data: "action=getAvailableUser&shiftId="+shiftId+"&boardId="+boardId+"&shift_date="+shift_date,
            type: "post",
            async:false,
            success:function(data){
                var data1="";
                data=JSON.parse(data);

                if(data=='User not Found')
                {
                    data1+="<option value=''>No User Found</option>"; 
                    $('#empSelect').html(data1); 
                }else 
                {
                    data1 = '<option value="" selected>Select Employee</option>';
                    $.each(data,function(k,v){
                        data1+="<option value="+v.user_id+">"+v.name+"</option>"; 
                    }); 
                } 

                $('#empSelect').html(data1);
            }
        });
    }

    $("#day_id").on('change', function(event)
        {
            if($("#boardSelect").val() =="" || $("#shiftSelect").val() == "")
            {
                // console.log('h');
            }
            else
            {
                getAvailableUser($("#shiftSelect").val(), $("#boardSelect").val(), $(this).val());
            }
        });

    $("#boardSelect").on('change', function(event)
        {
            var boardId = $(this).val();

            var list = getShiftList(boardId);
            // console.log(list);

            var opt = '<option value="" selected>Select Shift</option>';
            $.each(list, function(i,v)
                {
                    opt+='<option value="'+v.Shift.id+'">'+v.Shift.title+'</option>';
                });

            $("#shiftSelect").html("").html(opt);
            $("#empSelect").html("").html('<option value="" selected>Select Employee</option>');
        });

    $("#shiftSelect").on('change', function(event)
        {
            var shift_date=$('#day_id').val();

            var boardId =  $("#boardSelect").val();
            
            var shiftId = $(this).val();

            if(shift_date != "" && shiftId != ""){
                if($(this).val() !="")
                {
                    getAvailableUser(shiftId,boardId,shift_date);
                }
            } else {
                $("#day_id").focus();
            }
        });

    $("#shiftAssignFrom").on('submit', function(event)
    {
        event.preventDefault();

        var shiftDate = $("#day_id").val();
        var userId = $("#empSelect").val();
        var orgId = '<?php echo $orgId; ?>';
        var shiftId = $("#shiftSelect").val();
        var boardId = $("#boardSelect").val();
        $.ajax({
            url:'<?php echo URL."ShiftUsers/addShiftForUser/";?>'+orgId+'/'+shiftId+'/'+boardId+'/'+userId+'/'+shiftDate+'.json',
            datatype:'jsonp',
            async:false,
            success: function (response){
                if(response.status == 1) {
                    var sdate = dateToString(shiftDate);
                    var data ='<tr><td>'+response.fullname+'</td><td>'+response.shift+'</td><td>'+sdate+'</td><td><button type="button" data-shiftUserId="'+response.id+'" class="delete btn btn-sm red">Remove</button></td></tr>';
                    var row = document.getElementById('shiftAssignTbody');
                    row.innerHTML = row.innerHTML + data;
                    $("#assignShiftModal").modal('hide');

                    $("#emptyRow").remove();
                    toastr.success('The employee has been assigned to the shift.');

                } else {
                    $("#assignShiftModal").modal('hide');
                    toastr.info('Something went wrong');
                }
            }  
        });
    });

    $("#assignShiftModalBtn").on('click', function(event)
        {
            $("#shiftAssignFrom")[0].reset();
            $("#assignShiftModal").modal('toggle');   
            var shift_date=$('#day_id').val();

            var boardId =  $("#boardSelect").val();
            
            var shiftId = $(shiftSelect).val();

            if(shift_date != "" && shiftId != ""){
                if($("#shiftSelect").val() !="")
                {
                    getAvailableUser(shiftId,boardId,shift_date);
                }
            }
        });
</script>

<script type="text/javascript">
	$(document).ready(function(){

		$('.delete').live('click',function(){
            var e= $(this);
			var shiftId = e.attr('data-shiftUserId');

            var url ='<?php echo URL_VIEW;?>process.php';
            $.ajax({
                url: url,
                data:"action=userAssignShift&shiftUserid="+shiftId,
                type:'post',
                async:false,
                success: function (response)
                {

                    if (response == 1) {

                        var tr = e.closest('tr');
                        var n = $('#shiftAssignTbody tr').length;
                        tr.remove();

                        if(n===1)
                        {
                            console.log(n);
                            $("#shiftAssignTbody").append('<tr id="emptyRow"><td>--</td><td>--</td><td>--</td><td>--</td></tr>');
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


<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   ComponentsPickers.init();
});   

</script>

