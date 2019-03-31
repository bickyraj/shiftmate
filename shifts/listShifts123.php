
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

?>



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


<!-- Edit-->

<div class="page-container">

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Shift List <small>View Shift List</small></h1>
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
                <a href="#">Shifts</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Shift</span>
                            <span class="caption-helper hide">list ...</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
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
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">Choose Branches to use shift <span class="required">
                                                        * </span>
                                                        </label>
                                                        <div class="col-md-7 scroll">
                                                            <?php foreach($branches as $key=>$branch):?>
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
                                                            <?php endforeach;?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    <div class="modal-footer">
                                                        <div class="col-md-offset-3 col-md-9">
                                                              <input  type="submit" name="submit" value="Submit" class="btn green"/>
                                                             <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php //echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                                                              <input type="reset" name="cancel" value="Clear" class="addclear btn default" />
                                                              <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
                                                          </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2" align="center">
                                <div class="well" style="padding-right: 15px;padding-left:15px">
                                    <a class="btn btn-default btn-sm" href="#portlet-config_12" class="news-block-btn" data-toggle="modal" class="config">
                                                <i class="fa fa-plus"></i></a>
                                </div> 
                            </div>
                            <div id="shiftdisplay">
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
                                // echo "<pre>";
                                // print_r($shiftBranchList);
                            ?> 
                            <div class="col-md-2" align="center">

                                <div class="well" style="padding-right: 15px;padding-left:15px;height:200px;overflow-x: hidden;overflow-y: scroll;">
                                    <div id="editShift" data-shiftId="<?php echo $shift->Shift->id; ?>"><a class="editShift btn btn-default btn-sm news-block-btn" href="#portlet-config_1_<?php echo $shift->Shift->id; ?>"   data-toggle="modal" class="config">
                                            <i class="fa fa-pencil"></i></a></div>
                                <!-- <a href="<?php //echo URL_VIEW . 'shifts/editShift?shift_id=' . $shift->Shift->id.'&org_id='.$orgId; ?>" class="btn btn-default btn-sm">
                                        <i class="fa fa-pencil"></i></a> -->
                                    <h4 class="block"><?php echo $shift->Shift->title; ?></h4>
                                    <p>
                                        <?php 
                                            $start_time = $shift->Shift->starttime;
                                            $end_time = $shift->Shift->endtime;
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
                                        <br />
                                         <?php //echo hisToTime($shift->Shift->endtime); ?> 
                                    </p>
                                </div>
                            </div>
                                     <?php endforeach;
                            }
                            else
                            {
                            ?>
                              <div class="col-sm-6 col-md-3" id="shiftRemove">
                                    <div class="well well-lg">
                                        <h4 class="block">No Record found</h4>
                                        
                                    </div>
                                </div>
                            <?php
                                }
                                
                             ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function(){
        var orgId = '<?php echo $orgId; ?>';
        $("#AddShiftForm").on('submit',function(event){
            event.preventDefault();
            var ev = $(this);
            
            var data = $(this).serialize();
            $.ajax({
                url : '<?php echo URL."Shifts/createShiftwithdata/"."'+orgId+'".".json"; ?>',
                type : "post",
                data : data,
                datatype : "jsonp",
                success:function(response)
                {
                    //console.log($("#shiftdisplay"));
                    var shiftdata = "";
                    var starttime = response.output.shift.Shift.starttime;
                    var endtime = response.output.shift.Shift.endtime;

                    shiftdata = '<div class="col-md-2" align="center"><div class="well" style="padding-right: 15px;padding-left:15px;height:200px;overflow-x: hidden;overflow-y: scroll;"><div id="editShift" data-shiftId="'+response.output.shift.Shift.id+'"><a class="btn btn-default btn-sm news-block-btn" href="#portlet-config_1_'+response.output.shift.Shift.id+'"   data-toggle="modal" class="config"><i class="fa fa-pencil"></i></a></div><h4 class="block">'+response.output.shift.Shift.title+'</h4><p>'+tConvert(starttime)+'-'+tConvert(endtime)+'</p></div></div>';
                    console.log(shiftdata);
                    $("#shiftRemove").remove();
                    $("#shiftdisplay").append(shiftdata);
                    ev.find('.addclear').click();
                    ev.find('.addclose').click();
                    ev.closest('.modal-dialog').find('.addclose').click();
                    toastr.success('Record Added Successfully');

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
          console.log(time);
          return time.join (''); // return adjusted time or original string
        }
        $(document.body).on('click',"#editShift",function()
        {
            var shift__id = $(this).attr('data-shiftId');
            $.ajax
                ({
                    url : '<?php echo URL."Shifts/editShiftData/"."'+orgId+'"."/"."'+shift__id+'".".json"; ?>',
                    datatype : "jsonp",
                    success:function(response)
                    {
                        //console.log(response);
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
                            branchList += '<div class="row">'+
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

                       
                        //console.log(jQuery.inArray(shiftBranch,branch));
                        //console.log(branch);
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
                                   '<div class="form-group">'+
                                        '<label class="control-label col-md-4">Start Time</label>'+
                                        '<div class="col-md-7">'+
                                            '<div class="input-group">'+
                                                '<input type="text" class="form-control timepicker1 timepicker-24" name="data[Shift][starttime]"  value="'+response.shift.Shift.starttime+'">'+
                                                '<span class="input-group-btn">'+
                                                '<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label col-md-4">End Time</label>'+
                                        '<div class="col-md-7">'+
                                            '<div class="input-group">'+
                                                '<input type="text" class="form-control timepicker1 timepicker-24" name="data[Shift][endtime]" value="'+response.shift.Shift.endtime+'">'+
                                                '<span class="input-group-btn">'+
                                                '<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>'+
                                                '</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
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
                                        '<input type="submit" name="submit" value="Update" class="btn btn-success" />'+
                                        '<input type="reset" name="clear" value="Clear" class="editclear btn default">'+
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
                datatype : "jsonp",
                success:function(response)
                {
                    if(response.output.status == 1){
                       window.location.reload(true);
                       toastr.success('Recorded Updated Successfully');
                        e.find('.editclear').click();
                        e.find('.bootbox-close-button').click();
                        e.closest('.modal-dialog').find('.bootbox-close-button').click();
                    }
                    else{
                       toastr.success('Recorded Updated Successfully');
                        e.find('.editclear').click();
                        e.find('.bootbox-close-button').click();
                        e.closest('.modal-dialog').find('.bootbox-close-button').click(); 
                    }
                }
            });
            
        });

    });
</script>
    
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script>
        jQuery(document).ready(function() {
           ComponentsPickers.init();
        });   
</script>
    