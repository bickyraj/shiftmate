
<?php

if (isset($_GET['page'])) {
    $page = "page:" . $_GET['page'];
} else {
    $page = '';
}


$url = URL . "Shifts/listShifts/" . $orgId . "/" . $page . ".json";
$data = \Httpful\Request::get($url)->send();
$shifts = $data->body->shifts;
// echo "<pre>";
// print_r($shifts);

$totalPage = $data->body->output->pageCount;
$currentPage = $data->body->output->currentPage;

/*
Add shift start from here
*/
$url = URL."Branches/listBranchesName/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

// fal($branches);

?>

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- Save Success Notification -->
<script type="text/javascript">
    $(document).ready(function()
        {
            var top_an = $("#save_success").css('top');
            $("#save_success").css('top','0px');

            <?php if(isset($_SESSION['success'])):?>
                $("#save_success").show().animate({top:top_an});
                <?php unset($_SESSION['success']);?>
                setTimeout(function()
                    {
                        $("#save_success").fadeOut();
                    }, 3000);
            <?php endif;?>
        });
</script>
<style type="text/css">
    .scroll {
      
        min-height: 35px;
        max-height:175px;
        overflow: auto;
    }
</style>
<!-- End of Save Success Notification -->


<div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Shiftpool <small>Shiftpool List</small></h1>
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
                <i class="fa fa-home"></i>
                <a href="<?php echo URL_VIEW; ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Shifts</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Shiftpool List</a>
            </li>
        </ul>
            <!-- END PAGE BREADCRUMB -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
                    <div class="portlet light" style="min-height:300px;">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="fa fa-th theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Shift List</span>
                                <!-- <span class="caption-helper hide">weekly stats...</span> -->
                            </div>
                                <a class="btn btn-success pull-right" id="addShiftBtn" class="news-block-btn" data-toggle="modal" class="config"><i class="fa fa-plus"></i> Add New Shift</a>
                        </div>
                        <div class="portlet-body">
                            <div class="table-actions-wrapper pull-right margin-bottom-10">
                                <select id="selectBranch" class="table-group-action-input form-control input-inline input-small input-sm">
                                    <option value="0">All Branch</option>
                                    <?php foreach ($branches as $key => $value): ?>
                                        <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                                    <?php endforeach ?>
                                </select>
                                <select id="selectDept" disabled class="table-group-action-input form-control input-inline input-small input-sm">
                                    <option value="0">All Department</option>
                                </select>
                                <button class="btn btn-sm yellow table-group-action-submit" id="filterBtn"><i class="fa fa-check"></i> Filter</button>
                            </div>
                            <div class="table-scrollable table-scrollable-borderless">
                                <table class="table table-hover table-light">
                                <thead>
                                <tr class="uppercase">
                                    <th>
                                         Shift Name
                                    </th>
                                    <th>
                                        Shift Time
                                    </th>
                                    <th>
                                         Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="shiftdisplay">
                                    <?php if (isset($shifts) && !empty($shifts)) { ?>
                                            
                                        <?php $i = 1; ?>
                                            <?php foreach ($shifts as $shift): 

                                                $url = URL . "ShiftBranches/getShiftRelatedBranches/" . $shift->Shift->id . ".json";
                                            $data = \Httpful\Request::get($url)->send();
                                            $shiftBranchList = $data->body->shiftBranchList;
                                            if(empty($shiftBranchList)){
                                               $shiftBranchList = array(); 
                                            }else{
                                                $shiftBranchList = get_object_vars($shiftBranchList);
                                            }

                                        ?> 
                                        <tr>
                                            <td>
                                                 <?php  echo $shift->Shift->title; ?>
                                            </td>
                                            <td>
                                                <?php echo hisToTime($shift->Shift->starttime)." - ".hisToTime($shift->Shift->endtime); ?>
                                            </td>
                                            <td>
                                                <div id="editShift" style="display:inline;" data-shiftId="<?php echo $shift->Shift->id; ?>"><a class="editShift btn btn-default btn-sm news-block-btn tooltips" data-container="body" data-placement="top" data-original-title="Edit"  href="#portlet-config_1_<?php echo $shift->Shift->id; ?>"   data-toggle="modal" class="config">edit</a></div>

                                                <div id="deleteShift" style="display:inline;"><a class="deleteShift btn btn-default btn-sm news-block-btn tooltips" data-shiftId="<?php echo $shift->Shift->id; ?>" data-container="body" data-placement="top" data-original-title="Delete"  href="javascript:;" class="config">delete</a></div>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                        <?php }else{?>
                                            <tr id="emptyShiftTr">
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                            </tr>
                                        <?php } ?>
                                </tbody>
                                </table>
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

<div class="modal fade" id="portlet-config_12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="addclose close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Add Shifts</h4>
              </div>
              <div class="modal-body">
                <form action="" id="AddShiftForm" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                    </div>
                    <div class="form-body">     
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
                                    <input type="text" class="form-control timepicker timepicker-24" name="data[Shift][starttime]" required>
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
                                    <input type="text" class="form-control timepicker timepicker-24" name="data[Shift][endtime]" required>
                                    <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4">Choose Branches to use shift <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7 scroll">


                                <?php 
                                  if(isset($branches) && !empty($branches)){  ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="md-checkbox-list">
                                            <div class="md-checkbox" id="checkBranch">
                                                <input type="checkbox"  id="selectAllBranch" class="md-check selectAllBranch">
                                                <label for="selectAllBranch">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                                Select All Branch</label>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            <?php
                                    foreach($branches as $key=>$branch):
                                ?>
                                   <!--  <input type="checkbox" name="data[ShiftBranch][][branch_id]" value="<?php echo $key;?>">
                                    <label class="control-label"><?php echo $branch;?></label> -->
                                    <div class="row">
                                        <div class="col-md-12">
                                    <div class="md-checkbox-list">
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox_<?php echo $key;?>" class="md-check" name="data[ShiftBranch][][branch_id]" value="<?php echo $key;?>">
                                            <label for="checkbox_<?php echo $key;?>">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <?php echo $branch;?></label>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                                <?php endforeach; } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="modal-footer">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                                <input  type="submit" name="submit" id="shiftSubmit" value="Submit" class="btn green"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){

        $("#addShiftBtn").on('click', function()
            {
                $("#AddShiftForm")[0].reset();
                $('#portlet-config_12').modal({
                    show: 'true'
                });
            }); 

        $(".selectAllBranch").click(function(){
            if($(this).is(":checked")){
                $(".md-check").each(function(i){
                    $(this).attr("checked","checked");
                });
            } else {
                $(".md-check").each(function(i){
                    $(this).removeAttr("checked");
                });
            }
        });

        $(".timepicker").timepicker({
                defaultTime: '',
                timeFormat: 'HH:mm',               
                 showSeconds: false,
                 showMeridian: false, 
        });
        var orgId = '<?php echo $orgId; ?>';
        $("#AddShiftForm").on('submit',function(event){
            $("#shiftSubmit").attr("disabled","disabled");
            
            event.preventDefault();
            var ev = $(this);
            
            var data = $(this).serialize();
            $.ajax({
                url : '<?php echo URL."Shifts/createShiftwithdata/"."'+orgId+'".".json"; ?>',
                type:"POST",
                data : data,
                crossDomain:true,
                // dataType : "json",
                success:function(response)
                {
                    // console.log(response);
                    //console.log($("#shiftdisplay"));
                    var status = response.output.status;

                    if(status == 2){
                        toastr.info("Shift already exist.Please try again.");
                    } else if(status == 1){
                    var shiftdata = "";
                    var starttime = response.output.shift.Shift.starttime;
                    var endtime = response.output.shift.Shift.endtime;

                    shiftdata =
                    '<tr>'+
                        '<td>'+response.output.shift.Shift.title+'</td>'+
                        '<td>'+tConvert(starttime)+' - '+tConvert(endtime)+'</td>'+
                        '<td><div id="editShift" style="display:inline;" data-shiftId="'+response.output.shift.Shift.id+'"><a class="btn btn-default btn-sm news-block-btn" style="margin-right: 9px;" href="#portlet-config_1_'+response.output.shift.Shift.id+'"   data-toggle="modal" class="config">edit</a></div><div id="deleteShift" style="display:inline;"><a class="deleteShift btn btn-default btn-sm news-block-btn tooltips" data-shiftId="'+response.output.shift.Shift.id+'" data-container="body" data-placement="top" data-original-title="Delete"  href="javascript:;" class="config">delete</a></div></td>'+
                    '</tr>';

                    $("#emptyShiftTr").remove();
                    $("#shiftdisplay").append(shiftdata);
                        toastr.success('Record Added Successfully');
                    } else {
                        toastr.info("Something went wrong.Please try again.");
                    }
                    ev.find('.addclear').click();
                    ev.find('.addclose').click();
                    ev.closest('.modal-dialog').find('.addclose').click();
                    $("#shiftSubmit").removeAttr("disabled");
                    

                }
            });
        });
        function tConvert (time) 
        {
            time = time.slice(0, -3);
                  // Check correct time format and split into components
          time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

          if (time.length > 1) { // If time format correct
            time = time.slice (1);  // Remove full string match value
            if(time[2] == '00'){
                time[1] = '';
                time[2] = '';
            }
            time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
          }
          // console.log(time);
          return time.join (''); // return adjusted time or original string
        }
        $(document.body).on('click',"#editShift",function()
        {
            var e = $(this);
            var shift__id = $(this).attr('data-shiftId');
            var row_index = $(this).closest('tr').index();            

            $.ajax
                ({
                    url : '<?php echo URL."Shifts/editShiftData/"."'+orgId+'"."/"."'+shift__id+'".".json"; ?>',
                    dataType : "jsonp",
                    success:function(response)
                    {
                        //console.log(response);
                        var changeShift = response.changeShift;
                        var shiftBranch = [];
                        var i = 0;
                        $.each(response.shiftBranch,function(i,j){
                            shiftBranch[i] = j.ShiftBranch.branch_id;
                            i++;
                        });
                        //console.log(shiftBranch)
                        var branchList = '';
                        var branch = [];
                        var i = 0;

                        $.each(response.branch,function(i,v){
                           branch[i] = v.Branch.id;
                            i++;
                            branchList +=  '<div class="row">'+
                                                '<div class="col-md-12">'+
                                                    '<div class="md-checkbox-list">'+
                                                        '<div class="md-checkbox">'+
                                                            '<input type="checkbox" id="checkbox_'+shift__id+'_'+v.Branch.id+'" class="md-check" name="data[ShiftBranch][][branch_id]" value="'+v.Branch.id+'">'+
                                                            '<label for="checkbox_'+shift__id+'_'+v.Branch.id+'">'+
                                                            '<span></span>'+
                                                            '<span class="check"></span>'+
                                                            '<span class="box"></span>'+
                                                            v.Branch.title+'</label>'+
                                                        '</div>'+

                                                    '</div>'+
                                                '</div>'+
                                            '</div>';
                        });

                        

                       var StartTime = '';
                       var shiftError = '';
                       var EndTime = '';
                       var timeStatus = '';

                       StartTime += '<div class="form-group"><label class="control-label col-md-4">Start Time</label><div class="col-md-7"><div class="input-group">';
                        
                        EndTime += '<div class="form-group"><label class="control-label col-md-4">End Time</label><div class="col-md-7"><div class="input-group">';

                        if(changeShift == 0){

                        StartTime += '<input type="text" class="form-control timepicker1 timepicker-24" name="data[Shift][starttime]"  value="'+response.shift.Shift.starttime+'" required>';

                        EndTime += '<input type="text" class="form-control timepicker1 timepicker-24" name="data[Shift][endtime]"  value="'+response.shift.Shift.endtime+'" required>';
                        
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

                                  
                        //console.log(jQuery.inArray(shiftBranch,branch));
                        //console.log(branch);
                      var box =  bootbox.dialog({
                            title: "Edit Shifts",
                            message:'<form action="" id="editShiftForm" data-rowId="'+row_index+'" data-shiftids="'+response.shift.Shift.id+'" method="post" accept-charset="utf-8" class="form-horizontal">' +
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
                                    '<div class="form-group">'+
                                        '<label class="control-label col-md-4">Choose Branches to use shift <span class="required">'+
                                            '* </span>'+
                                        '</label>'+
                                            '<div class="col-md-7 scroll">'+branchList+'</div>'+
                                    '</div>'+
                                    '</div>'+
                                    '<div class="form-actions">'+
                                    '<div class="modal-footer">'+
                                    '<div class="col-md-offset-3 col-md-9">'+
                                        '<button type="button" class="btn default" data-dismiss="modal">Close</button>'+
                                        '<input type="submit" name="submit" value="Update" class="btn btn-success" />'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>'+
                                    timeStatus+
                                '</form>' 
                        });
    
                        box.bind('shown.bs.modal', function(){
                            $(".timepicker1").timepicker({ timeFormat: 'HH:mm',               
                                                             showSeconds: false,
                                                             showMeridian: false, 
                                                         });
                        });
                        //$("#checkbox_7_1").prop("checked",true);
                        $.each(shiftBranch,function(m,n){
                            if(jQuery.inArray(n,branch) != -1){
                                    $("#checkbox_"+shift__id+'_'+n).prop("checked",true);
                            }
                        });
                    }
                });
        }); 
        $("#editShiftForm").live('submit',function(ev){
            ev.preventDefault();

            var e = $(this);
            var data = $(this).serialize();
            var shiftid = $(this).attr('data-shiftids');
            $.ajax({
                url : '<?php echo URL."Shifts/editShiftwithData/"."'+orgId+'"."/"."'+shiftid+'".".json"; ?>',
                type : "post",
                data : data,
                dataType : "jsonp",
                success:function(response)
                {
                    
                    var status = response.output.status;
                    if(status == 1){
                        var data = response.output.params.data;

                       toastr.success('Updated Successfully');
                        e.find('.editclear').click();
                        e.find('.bootbox-close-button').click();
                        e.closest('.modal-dialog').find('.bootbox-close-button').click();
                        
                        var title = data.Shift.title;
                        
                        var action = '<div id="editShift" style="display:inline;" data-shiftId="'+data.Shift.id+'"><a class="editShift btn btn-default btn-sm news-block-btn tooltips" data-container="body" data-placement="top" data-original-title="Edit"  href="#portlet-config_1_'+data.Shift.id+'"   data-toggle="modal" class="config">edit</a></div>'+
                        '<div id="deleteShift" style="display:inline;"><a class="deleteShift btn btn-default btn-sm news-block-btn tooltips" data-shiftId="'+data.Shift.id+'" data-container="body" data-placement="top" data-original-title="Delete"  href="javascript:;" class="config">delete</a></div>';
                        var tr = "";

                        if(data.Shift.starttime != null && data.Shift.starttime != undefined){
                            tr = '<td>'+title+'</td><td>'+tConvert(data.Shift.starttime)+' - '+tConvert(data.Shift.endtime)+'</td><td>'+action+'</td>';

                            var rowId = e.attr('data-rowid');
                            $("#shiftdisplay > tr").eq(rowId).html("").html(tr);
                        }

                    } else if(status == 2){
                        toastr.info('Shift already exist.Please try again.');
                    }
                    else{
                       toastr.info('Something went wrong.Please try again.');
                    }
                        e.find('.editclear').click();
                        e.find('.bootbox-close-button').click();
                        e.closest('.modal-dialog').find('.bootbox-close-button').click(); 
                }
            });
            
        });

        $(".deleteShift").live('click', function(event)
            {
                var e = $(this);
                bootbox.confirm("Are you sure?", function(result) {
                      if(result)
                      {
                        var shiftId = e.attr('data-shiftId');

                        // console.log(shiftId);
                        var url = '<?php echo URL;?>shifts/deleteShift/'+shiftId+'.json';
                        $.ajax(
                            {
                                url:url,
                                type:'post',
                                dataType:'jsonp',
                                async:false,
                                success:function(res)
                                {
                                    // console.log(res);
                                    if(res.status == 1)
                                    {
                                        toastr.success('Shift removed Successfully.');
                                        e.closest('tr').remove();
                                    }else
                                    {
                                        toastr.warning('This shiftpool is currently in use, please remove all the users assigned to this shift in order to delete this shift.');
                                    }
                                }
                            });
                      }
                    }); 
            });

    });
</script>
    
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script>
        jQuery(document).ready(function() {
           ComponentsPickers.init();
           TableManaged.init();

        function getBoardListOfBranch(branchId)
        {
            var boardList;
            var url = '<?php echo URL;?>Boards/getBoardListOfBranch/'+branchId+'.json';
            $.ajax(
                {
                    url:url,
                    async:false,
                    // dataType:'jsonp',
                    crossDomain:true,
                    success:function(res)
                    {
                        console.log(res);
                        boardList = res.boardList;
                    }
                });

            console.log(boardList);

            return boardList;
        }

        $("#selectBranch").on('change', function(event)
            {
                var selectDept = $("#selectDept");
                var bId = $(this).val();

                if(bId != 0 )
                {
                    selectDept.prop('disabled', false);
                    var boardList = getBoardListOfBranch(bId);

                    var opt = "";

                    opt += '<option value="0">All Department</options>';

                    if(typeof boardList !== "undefined")
                    {
                        $.each(boardList, function(k, v)
                            {
                                opt += '<option value="'+v.Board.id+'">'+v.Board.title+'</option>';
                            });

                        // console.log(opt);
                        $("#selectDept").html("").html(opt);
                    }

                    
                }else
                {
                    selectDept.val(0);
                    selectDept.prop('disabled', true);
                }
            });

        function filterShift(branchId, boardId)
        {
            var data;
            var url = '<?php echo URL; ?>ShiftBranches/filterShiftByBranch/'+branchId+'/'+boardId+'.json';
            $.ajax(
                {
                    url:url,
                    async:false,
                    // dataType:'jsonp',
                    success:function(res)
                    {
                        data = res.result;
                    }
                });

            return data;
        }

        function getAllShifts()
        {
            var data;
            var page = 0;
            var url = '<?php echo URL; ?>Shifts/listShifts/'+'<?php echo $orgId; ?>'+'/'+page+'.json';
            $.ajax(
                {
                    url:url,
                    // dataType:'jsonp',
                    async:false,
                    success:function(res)
                    {
                       data = res.shifts;
                    }
                });
            return data;
        }

        function tConvert (time) 
                {
                    time = time.slice(0, -3);
                          // Check correct time format and split into components
                  time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

                  if (time.length > 1) { // If time format correct
                    time = time.slice (1);  // Remove full string match value
                    if(time[2] == '00'){
                        time[1] = '';
                        time[2] = '';
                    }
                    time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
                    time[0] = +time[0] % 12 || 12; // Adjust hours
                  }
                  // console.log(time);
                  return time.join (''); // return adjusted time or original string
                }
        $("#filterBtn").on('click', function(event)
            {
                var branchId = $("#selectBranch").val();
                var boardId = $("#selectDept").val();

                // console.log(branchId+' '+ boardId);

                if(branchId == 0)
                {
                    var list = getAllShifts();
                }else
                {
                    var list = filterShift(branchId, boardId);
                }

                var data =[];
                var tr = "";
                $.each(list, function(k,v)
                    {
                        var act = '<div id="editShift" style="display:inline;" data-shiftId="'+v.Shift.id+'">'+
                        '<a class="editShift btn btn-default btn-sm news-block-btn tooltips" data-container="body" data-placement="top" data-original-title="Edit"  href="#portlet-config_1_'+v.Shift.id+'"   data-toggle="modal" class="config">edit</a></div>'+
                        '<div id="deleteShift" style="display:inline;"><a class="deleteShift btn btn-default btn-sm news-block-btn tooltips" data-shiftId="'+v.Shift.id+'" data-container="body" data-placement="top" data-original-title="Delete"  href="javascript:;" class="config">delete</a></div>';

                        tr+= '<tr><td>'+v.Shift.title+'</td><td>'+tConvert(v.Shift.starttime)+' - '+tConvert(v.Shift.endtime)+'</td><td>'+act+'</td></tr>';

                    });

                    $("#shiftdisplay").html("").html(tr);
                
            });
        
         
        });   
</script>
    