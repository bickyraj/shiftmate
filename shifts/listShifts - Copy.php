
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
// echo "<pre>";
// print_r($shifts);
// die();
/*
Add shift start from here
*/
$url = URL."Branches/listBranchesName/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;
// echo "<pre>";
// print_r($branches);
// die();

// if (isset($_POST["submit"])) {
//     // echo "<pre>";
//     //  print_r($_POST['data']);
//     //  die();
//     $starttime = explode(':', $_POST['data']['Shift']['starttime']);
//     if($starttime[0] < 10):
//         $starttime='0'.$starttime[0].':'.$starttime[1].':00';
//     else:
//         $starttime=$_POST['data']['Shift']['starttime'].':00';
//     endif;

//     $endtime = explode(':', $_POST['data']['Shift']['endtime']);
//     if($endtime[0] < 10):
//         $endtime='0'.$endtime[0].':'.$endtime[1].':00';
//     else:
//         $endtime=$_POST['data']['Shift']['endtime'].':00';
//     endif;

//     $_POST['data']['Shift']['starttime']= $starttime;
//     $_POST['data']['Shift']['endtime']= $endtime;
//     //$_POST['data']['Shift']['starttime']['minute']= $starttime[1];
//    // $_POST['data']['Shift']['starttime']['seconds']= ':00';
//     $url = URL . "Shifts/createShift/" . $orgId . ".json";
//     $response = \Httpful\Request::post($url)
//     ->sendsJson()
//     ->body($_POST['data'])
//     ->send();
//     echo "<pre>";
//      print_r($response);
//      die();
//     if($response->body->output->status == '1')
//     {
//         echo("<script>location.href = '".URL_VIEW."shifts/listShifts?org_id=".$orgId."';</script>");

//         $_SESSION['success']="test";
//     }

//     else
//     {
//         $_SESSION['fail']= 'test';


//     }
// }

/*
Edit starts from here
*/
// if (isset($_POST["edit"])) {
//     // echo "<pre>";
//     // print_r($_POST['data']);
//     // print_r($_POST['data']['Shift']['id']);
//     // die();
//     $url = URL . "Shifts/editShift/" . $_POST['data']['Shift']['id'] . ".json";
//     $response = \Httpful\Request::post($url)
//             ->sendsJson()
//             ->body($_POST['data'])
//             ->send();
//     // echo "<pre>";
//     // print_r($response);

//     if($response->body->output->status == '1')
//     {
//         // echo("<script>location.href = '".URL_VIEW."shifts/listShifts?org_id=".$orgId."';</script>");

//         // $_SESSION['success']="test";
//         echo '<script>

//                             toastr.options = {
//                                       "closeButton": true,
//                                       "debug": false,
//                                       "positionClass": "toast-top-center",
//                                       "onclick": null,
//                                       "showDuration": "1000",
//                                       "hideDuration": "1000",
//                                       "timeOut": "10000",
//                                       "extendedTimeOut": "1000",
//                                       "showEasing": "swing",
//                                       "hideEasing": "linear",
//                                       "showMethod": "fadeIn",
//                                       "hideMethod": "fadeOut"
//                                     };
//                             toastr.success("Record Updated Successfully");
//                     </script>';
//     }
// }

/*Edit ends here*/

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
<!-- <div class="row">
    <?php if (isset($shifts) && !empty($shifts)) { ?>
        
    <?php $i = 1; ?>
    <?php foreach ($shifts as $shift): ?>
    <div class="col-md-3 col-sm-12">
        <div class="portlet" style="border:1px solid #26a69a;">
            <div class="portlet-title">
                <div class="caption" style="padding-left:10px;">
                    <i class="fa fa-cogs"></i><?php echo $shift->Shift->title; ?>     
                </div>
                <div class="actions">
                    <a href="<?php echo URL_VIEW . 'shifts/editShift?shift_id=' . $shift->Shift->id.'&org_id='.$orgId; ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-pencil"></i></a>
                     <form action="/newshiftmate/Organizations/delete/1" name="post_5476f94dde83b126092591" id="post_5476f94dde83b126092591" style="display:none;" method="post">
                        <input type="hidden" name="_method" value="POST"/>
                    </form>
                    <a href="" class="btn btn-default btn-sm" onclick="if (confirm( & quot; Are you sure you want to delete # 1? & quot; ))
                                        { 
                                            document.post_5476f94dde83b126092591.submit();
                                        }
                                        event.returnValue = false;
                                        return false;">
                           
                    <i class="fa fa-pencil"></i> Delete </a>
                </div>
            </div>
            <div class="portlet-body"> -->
                <!-- <div class="row static-info">
                    <div class="col-md-5 name">
                         Shift Name:
                    </div>
                    <div class="col-md-7 value">
                              
                    </div>
                </div>
                <div class="row static-info" style="padding-left:20px;">
                    <!-- <div class="col-md-5 name">
                         Start Time:
                    </div>
                    <div class="col-md-7 value" >
                         <?php echo $shift->Shift->starttime; ?>                
                    </div>
                </div>
                <div class="row static-info" style="padding-left:20px;">
                    <!-- <div class="col-md-5 name">
                         End TIme:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $shift->Shift->endtime; ?>                  
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;
    }
    else
    {
?>
     <div class="col-md-12 value">
         Add New Shiftmate...
         There is no shiftmate in list           
     </div>
<?php
    }
    
 ?>

</div> --> 

<div class="row">
        <!--Add shift using mandel form-->

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
                        <!-- <div class="row">
                            <label class="control-label col-md-4">Start Time <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="form-control" name="data[Shift][starttime][hour]"  class="hourBox">
                                            <?php for ($hours = 1; $hours <= 23; $hours++) { ?>
                                            <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="data[Shift][starttime][min]" class="hourBox">
                                            <?php for ($min = 0; $min < 60; $min++) { ?>
                                            <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">End Time <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="form-control" name="data[Shift][endtime][hour]"  class="hourBox">
                                            <?php for ($hours = 1; $hours <= 23; $hours++) { ?>
                                            <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="data[Shift][endtime][min]" class="hourBox">
                                            <?php for ($min = 0; $min < 60; $min++) { ?>
                                            <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                   
                                </div>
                            </div>
                        </div> -->
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
                  <!-- <div class="modal-footer">
                      <button type="button" class="btn default" data-dismiss="modal">Close</button>
                  </div> -->
              </div>
              <!-- /.modal-content -->
          </div>
                        <!-- /.modal-dialog -->
        </div>
     <div class="col-md-2" align="center">
        <div class="well" style="padding-right: 15px;padding-left:15px">
            <a class="btn btn-default btn-sm" href="#portlet-config_12" class="news-block-btn" data-toggle="modal" class="config">
                        <i class="fa fa-plus"></i></a>
            <!-- <a href="<?php echo URL_VIEW . 'shifts/createShift?org_id=' . $orgId; ?>"><i class="fa fa-plus"></i></a> -->
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













<!-- Success Div -->
<!-- <div id="save_success">Saved Successfully !!</div> -->
<!-- End of Success Div -->


<!-- <div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Shift List</div>
        <a href="<?php echo URL_VIEW . 'shifts/createShift?org_id=' . $orgId; ?>"><button class="addBtn">Add New</button></a>
    </div>
    <div class="clear"></div> -->

    <!-- Table -->
   <!--  <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>SN</p></th>
        <th><p>Shift Name</p></th>
        <th><p>Start Time</p></th>
        <th><p>End Time</p></th>
        <th><p>Action</p></th>

        </tr>

        <?php $i = 1; ?>
        <?php foreach ($shifts as $shift): ?>
            <tr class="list_users">
                <td><?php echo $i++; ?><input class="listShift-checkbox" type="checkbox" name="<?php echo $shift->Shift->id;?>"/></td>
                <td><?php echo $shift->Shift->title; ?></td>
                <td><?php echo $shift->Shift->starttime; ?></td>
                <td><?php echo $shift->Shift->endtime; ?></td>

                <td class="action_td">
                    <ul class="action_btn">

                        <li>
                            <div class="hover_action"></div>
                            <a href="<?php echo URL_VIEW . 'shifts/editShift?shift_id=' . $shift->Shift->id.'&org_id='.$orgId; ?>"><button class="edit_img"></button>
                            </a>
                        </li>
                        <form action="/newshiftmate/Organizations/delete/1" name="post_5476f94dde83b126092591" id="post_5476f94dde83b126092591" style="display:none;" method="post">
                            <input type="hidden" name="_method" value="POST"/>
                        </form>
                        <li>
                            <div class="hover_action"></div>
                            <a href="" onclick="if (confirm( & quot; Are you sure you want to delete # 1? & quot; ))
                                        { 
                                            document.post_5476f94dde83b126092591.submit();
                                        }
                                        event.returnValue = false;
                                        return false;"><button class="delete_img"></button>
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        <?php endforeach; ?>
    </table> -->
    <!-- End of Table -->

    <!-- Bulk Action -->
                <!-- <div class="bulkaction-div">
                        <select>
                          <option value="volvo">Bulk Action</option>
                          <option value="saab">Delete</option>
                        </select>
                        <button id="bulkBtn">Apply</button>
                </div> -->
                <!-- End of Bulk Action -->


   <!--  <?php
    if ($totalPage > 1) {
        $previousPage = $currentPage - 1;
        $nextPage = $currentPage + 1;
        ?>
        <div class="paginator">
            <ul>
                <li>
                    <?php if ($currentPage == 1) { ?>
                        <div class="deactive"><</div>
                    <?php } else { ?>
                        <a class="no-underline" href="<?php echo URL_VIEW . 'shifts/listShifts?org_id=' . $orgId . '&page=' . $previousPage; ?>"><</a></li>
                <?php } ?>
                <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
                    <li><a class="<?php echo ($currentPage == $i) ? 'active' : ''; ?>" href="<?php echo URL_VIEW . 'shifts/listShifts?org_id=' . $orgId . '&page=' . $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li>
                    <?php if ($totalPage == $currentPage) { ?>
                        <div class="deactive">></div>
                    <?php } else { ?>
                        <a class="no-underline" href="<?php echo URL_VIEW . 'shifts/listShifts?org_id=' . $orgId . '&page=' . $nextPage; ?>">></a></li>
                    <?php } ?>
            </ul>
        </div>
    <?php }
    ?> -->
    
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script>
        jQuery(document).ready(function() {
           ComponentsPickers.init();
        });   
</script>
    