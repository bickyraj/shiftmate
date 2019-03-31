<link href='<?php echo URL_VIEW;?>global/plugins/fullcalendar-1/fullcalendar.min.css' rel='stylesheet' />
<link href='<?php echo URL_VIEW;?>global/plugins/fullcalendar-1/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href="<?=URL_VIEW;?>calendar/libs/fullcalendar-scheduler/scheduler.min.css" rel='stylesheet'/>

<script src='<?php echo URL_VIEW;?>global/plugins/fullcalendar-1/fullcalendar.min.js'></script>
<script src="<?=URL_VIEW;?>calendar/libs/fullcalendar-scheduler/scheduler.min.js"></script>

<?php
if(isset($_GET['board_id'])){
    $boardId = $_GET['board_id'];
}

$url = URL."Boards/listBoards/".$orgId.".json";
$response = \Httpful\Request::get($url)->send();
$boards = $response->body->boards;
$url = URL."ShiftUsers/showShiftUserOfBoard/".$orgId."/".$boardId.".json";
$response = \Httpful\Request::get($url)->send();
$Users1 = $response->body->shiftUser;

$url = URL."ShiftBoards/boardShiftList/".$boardId.".json";
$response = \Httpful\Request::get($url)->send();

$boardShifts = $response->body->boardShifts;

// fal($boardShifts);


if(isset($_POST['submit']))
{

    $url = URL."ShiftUsers/assignShiftToUser.json";
    $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

                if($response->body->output->status == 0)
                {
                    echo '<script>
                            toastr.error("Could not be save.");
                    </script>';
                }

                else
                {
                    echo '<script>
                            toastr.success("Shift assigned successfully!!");
                    </script>';
                }
}

$url = URL."Boards/viewBoard/".$boardId.".json";
$data = \Httpful\Request::get($url)->send();
$board = $data->body->board;
?>

<style type="text/css">
.fc-event{
    display: inline-block;
    cursor: move;
    margin-bottom: 5px;
    margin-left: 5px;
    padding:3px;
}
</style>

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1><?php echo $board->Board->title; ?> Department <small> Of <?php echo $board->Branch->title; ?> Branch <!--List Department Employees--></small></h1>
        </div>  
        <!-- <div class="page-toolbar">
            <div class="btn-group pull-right" style="margin-top: 15px;">
                 <a class="btn btn-fit-height grey-salt dropdown-toggle" href="#portlet-config_1" class="news-block-btn" data-toggle="modal" class="config">
                    <i class="fa fa-plus"></i></a>
            </div>
        </div> -->
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
                <a href="#">Board Management</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Add Employee To Board</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-3">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Shifts</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                    </div>
                    <div class="portlet-body">
                                <!--Form Begins-->
                                <!--     <form method="post" action="" role="form" enctype="multipart/form-data">
                                <div class="form-body">
                                  <div class="form-group">
                                    <label >Assgin Shift</label>
                                    <select id="shifts" class="form-control" name="data[ShiftUser][shift_id]">
                                        <option value="">Select Shift</option>

                                    </select>
                                                            
                                </div>
                                <div class="form-group">
                                    <label >Select User</label>
                                    <select id="users" class="form-control" name="data[ShiftUser][shift_id]" multiple="multiple">
                                        <option value=""></option>

                                    </select>
                                                            
                                </div>
                       
                                </div>  
                                </form> -->
                                <!--form ends-->
                                <!-- BEGIN DRAGGABLE EVENTS PORTLET-->
                                <!-- <div id='wrap'>
                                    <div id='external-events'></div>
                                    <div style='clear:both'></div>
                                </div> -->
                                <?php 
                                if(!empty($boardShifts)){
                                    foreach($boardShifts as $shifts1){
                                        $shifts[$shifts1->Shift->id]=ucwords($shifts1->Shift->title);
                                    }
                                    $color=113311;
                                    foreach($shifts as $shft_id=>$shft_name){
                                        echo "<input type='hidden' id='".$shft_id."' value='#".$color."'/>";
                                        echo "<ul style='padding:0px;'><li style='display:inline-block;padding:5px;width:20px;background-color:#".$color."'></li><li style='display:inline-block;'>&nbsp;".$shft_name."</li></ul>";
                                        $color=dechex(hexdec($color)+111166);
                                    }
                                }
                                ?>
                        <!-- END CALENDAR PORTLET-->
                    </div>
                </div>

                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Remark</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <!--Form Begins-->
                                <!--     <form method="post" action="" role="form" enctype="multipart/form-data">
                                <div class="form-body">
                                  <div class="form-group">
                                    <label >Assgin Shift</label>
                                    <select id="shifts" class="form-control" name="data[ShiftUser][shift_id]">
                                        <option value="">Select Shift</option>

                                    </select>
                                                            
                                </div>
                                <div class="form-group">
                                    <label >Select User</label>
                                    <select id="users" class="form-control" name="data[ShiftUser][shift_id]" multiple="multiple">
                                        <option value=""></option>

                                    </select>
                                                            
                                </div>
                       
                                </div>  
                                </form> -->
                                <!--form ends-->
                                <!-- BEGIN DRAGGABLE EVENTS PORTLET-->
                                <ul style="padding:0px;">
                                    <li style="list-style-type: none; margin-bottom: 10px;"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/confirm.png";?>" />&nbsp;Confirmed</li>
                                    <li style="list-style-type: none; margin-bottom: 10px;"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/waiting.png";?>" />&nbsp;waiting</li>
                                    <li style="list-style-type: none; margin-bottom: 10px;"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/open.png";?>" />&nbsp;Open</li>
                                    <li style="list-style-type: none; margin-bottom: 10px;"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/pendingimg.png";?>" />&nbsp;Pending</li>
                                </ul>
                            </div>
                        </div>
                        <!-- END CALENDAR PORTLET-->
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Calendar</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div id="calendar123" class="has-toolbar">
                                </div>
                            </div>
                        </div>
                        <!-- END CALENDAR PORTLET-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>

        addDragEvent();
        /* initialize the external events
        -----------------------------------------------------------------*/
    function addDragEvent(){
        $('#external-events .fc-event').each(function() {
        
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
            
        });


    }


</script>
<script type="text/javascript">
 var boardId = '<?php echo $boardId;?>';
        // $(document).ready(function(){

            // alert('h');
            
            getBoardUser(boardId);
            getShifts(boardId);

            function getBoardUser(boardId)
            {
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getboarduser&boardId="+boardId,
                    type: "post",
                    success:function(response){
                        var data="";
                        var users = JSON.parse(response);
                        $.each(users, function(k,obj){
                           data+= "<option class='fc-event' value="+obj.User.id+">"+((obj.User.fname).charAt(0).toUpperCase() + obj.User.fname.slice(1))+" "+((obj.User.lname).charAt(0).toUpperCase() + obj.User.lname.slice(1))+"</option>";
                       });
                $('#users').append(data);
                $('#users').change(function() {

                var user = {};
                if($(this).val()){    
                user = $(this).val();

                }

                var data1 = '';
                $.each(users, function(k,obj){

                $.each(user,function(k1,v1){
                    if(v1==obj.User.id){
                        data1+= "<div class='fc-event' data-userId=" + obj.User.id + ">" + ((obj.User.fname).charAt(0).toUpperCase() + obj.User.fname.slice(1))+" "+((obj.User.lname).charAt(0).toUpperCase() + obj.User.lname.slice(1))+ "</div>";
                    }
                });
                   
                   //}
                });

               // $('#external-events').find('.fc-event').remove();
                $('#external-events').find('.fc-event').remove();
                $('#external-events').find('.fc-event1').remove();
                $('#external-events').append(data1);
                addDragEvent();
               // addSelectEvent();
                });

                    
                    }
                });

            }  

            function getShifts(boardId)
            {
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getShifts&boardId="+boardId,
                    type: "post",
                    success:function(response){
                        
                        $("#shifts").html("");
                        var data='';
                        var data_shift='';
                        var shifts = JSON.parse(response);

                        if(jQuery.isEmptyObject(shifts))
                        {
                            
                            data = "<option value='0'>No Shift on this board</option>";
                            $("#shifts").html(data);
                        }
                        else
                        {
                            data+="<option value='0' disabled selected>Select Shift</option>";
                            $.each(shifts, function(k,obj){
                                data+= "<option value=" + obj.Shift.id + ">" +obj.Shift.title+ "</option>";
                                });
                 
                            $("#shifts").html(data);

                        }


                        
                    }
                });
            }

      // });
</script>
<input type="hidden" id="shift_start_time" name="starttime" />
<script>


$('#shifts').on('change',function(){

shiftId = $(this).val();
//function getShiftTime(shiftId){
    $.ajax({
        url:"<?php echo URL.'shifts/findShiftTime/'?>"+shiftId+".json",
        datatype:"jsonp",
        success:function(response){
            var starttime = response;
            //return starttime;
           $("#shift_start_time").val(starttime);
        }
    });
//}
});
            

</script> 

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
$("#users").select2({
placeholder: "Select Users"
});
</script>
<script>
    function saveShiftUser(shiftId,boardId,shift_date,userId,orgId){
        
        $.ajax({
            url: "<?php echo URL.'ShiftUsers/checkUserIfAvailable/'?>"+shiftId+"/"+boardId+"/"+shift_date+"/"+userId+"/"+orgId+".json",
            dataType:'jsonp',
            success:function(data){
                // console.log(data);
                if(data.status.status == 'Saved'){
                    var copiedEventObject = {};
                    copiedEventObject.title = data.status.shift_title;
                    copiedEventObject.resourceId = userId;
                    copiedEventObject.shiftUserId = data.status.id;
                    copiedEventObject.shift_status = data.status.shift_status;
                    copiedEventObject.start = data.status.start;
                    copiedEventObject.end = data.status.end;
                    copiedEventObject.userId = userId;
                    copiedEventObject.backgroundColor = $('#'+shiftId).val();
                    $('#calendar123').fullCalendar('renderEvent', copiedEventObject, true);
                }else{
                    //bootbox.alert(data.status.status);
                    $.ajax({
                        url:"<?php echo URL.'Useravailabilities/findDurationIfNotAvailable/'?>"+userId+"/"+shift_date+".json",
                        dataType:"jsonp",
                        crossDomain:true,
                        success:function(response){
                            //bootbox.alert('The employee is not available to work from '+response.starttime+' to '+response.endtime);
                            bootbox.dialog({
                                title: 'Message',
                                message: 'The employee is not available to work in the given time.',
                                buttons: {
                                    success: {
                                        label: "Ok",
                                        className: "btn-info"
                                    }
                                }
                            });
                        }
                    });

                }
            }
        });
    }
    function saveOpenShiftUser(orgId,boardId,shiftId,shiftDate,noEmp){
                $.ajax({
            url: "<?php echo URL.'Opencalendarshifts/saveOpenShifts/'?>"+orgId+"/"+boardId+"/"+shiftId+"/"+shiftDate+"/"+noEmp+".json",
            datatype:'jsonp',
            type : 'post',
            success:function(data){
                if(data.result.status == 1){
                    var copiedEventObject = {};

                    copiedEventObject.title = data.result.result.Shift.title;
                    copiedEventObject.start = data.result.result.start;
                    copiedEventObject.end = data.result.result.end;
                    copiedEventObject.backgroundColor = $('#'+data.result.result.Shift.id).val();
                    copiedEventObject.openCalendarShiftId = data.result.result.openCShiftId;
                    copiedEventObject.noEmp = data.result.result.openCShiftcount;
                    copiedEventObject.assignedEmp = data.result.result.assignedcount;
                    copiedEventObject.resourceId = '0';
                    copiedEventObject.shift_status = '0';
                    copiedEventObject.shiftId = data.result.result.Shift.id;
                    copiedEventObject.boardId = data.result.result.Board.id;

                    // copiedEventObject.resourceId = resourceId;
                    // copiedEventObject.shiftUserId = data.status.id;
                    // copiedEventObject.shift_status = data.status.shift_status;
                    // copiedEventObject.start = data.status.start;
                    // // copiedEventObject.end = data.status.end;
                    // copiedEventObject.userId = userId;
                    // copiedEventObject.backgroundColor = $('#'+shiftId).val();
                    $('#calendar123').fullCalendar('renderEvent', copiedEventObject, true);
                }else{
                    bootbox.dialog({
                        title: 'Message',
                        message: 'Sorry Something Went Wrong',
                        buttons: {
                            success: {
                                label: "Ok",
                                className: "btn-info"
                            }
                        }
                    });

                }
            }
        });
    }
    function updateOpenShiftUser(id,shiftId,noEmp){
        $.ajax({
            url:"<?php echo URL.'Opencalendarshifts/updateOpenShifts/'?>"+id+"/"+shiftId+"/"+noEmp+".json",
            datatype:'jsonp',
            success:function(data){
                if(data.result==1){
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar();
                    toastr.info("Update success","success");
                }else{
                    toastr.warning("Cannot edit this time","Try again");
                }
            }
        });
    }

    function ImageExist(url)
      {
        var img = new Image();
        img.src = url;
        return img.height != 0;
      }

function loadCalendar() {       
    $.ajax({
        url:'<?php echo URL."ShiftUsers/showShiftUserOfBoard/".$orgId."/".$_GET["board_id"].".json";?>',
        datatype:'jsonp',
        success:function(data){
            if($.isEmptyObject(data.shiftUser)){
                var data1 = {};
            }else{
                var data1=$.map(data.shiftUser,function(k,v){
                    return {
//                      title:k.title,
                        title:k.Shift.title,
                        start:k.start,
                        end:k.end,
                        backgroundColor:$('#'+k.Shift.id).val(),
                        shiftUserId:k.shiftUserId,
                        userId:k.userId,
                        resourceId:k.userId,
                        shift_status:k.shift_status,
                        shiftId:k.Shift.id
                    }
               });
               var data2 = {};
               $.ajax({
                  url :  '<?php echo URL."Opencalendarshifts/showOpenCalendarShifts/".$orgId."/".$_GET["board_id"].".json";?>',
                  datatype:'jsonp',
                  async:false,
                  success:function(data){
                        //console.log(data);
                        if(!($.isEmptyObject(data.result))){
                            data2=$.map(data.result,function(k,v){
                                return {
                                    title:k.Shift.title,
                                    start:k.start,
                                    end:k.end,
                                    backgroundColor:$('#'+k.Shift.id).val(),
                                    openCalendarShiftId:k.openCShiftId,
                                    noEmp:k.openCShiftcount,
                                    //userId:k.userId,
                                    resourceId:'0',
                                    shift_status:'0',
                                    shiftId:k.Shift.id
                                }
                            });
                        }
                  }
               });
//               console.log(data2);
               data1 = $.merge(data1,data2);
              // console.log(data1);
            }
                var dataResource = [];
                $.ajax({
                    url: "<?php echo URL."BoardUsers/boardEmployeeList/".$_GET['board_id'].".json";?>",
                    datatype: "jsonp",
                    async:false,
                    success:function(users) {
                        if(!($.isEmptyObject(users.message))){
                       // console.log(users.message.employeeList);
                        dataResource = $.map(users.message.employeeList,function(v,k){

                            if(v.User.imagepath != "")
                                {
                                  var imgurl = v.User.imagepath;
                                }
                                else
                                {
                                  if(v.User.gender==0){
                                    var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/defaultuser.png";
                                  }else{
                                    var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/femaleadmin.png";
                                  }
                                }
                            return {
                                title : v.User.fname + " " + v.User.lname,
                                id : v.User.id,
                                image:imgurl
                            }
                        });
            
                        }
                        dataResource.unshift({'id':'0','title':'Open Shifts ... '});
                    }
                });

           $('#calendar123').fullCalendar({
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            editable: true,
            defaultDate:new Date(),
            droppable: true,
            aspectRatio: 1.8,
            scrollTime:new Date(),
            displayEventEnd:true,
            slotWidth:95,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'timelineDay,timelineWeek,timelineMonth'
            },
            defaultView: 'timelineWeek',
            views: {
				timelineWeek: {
					type: 'timeline',
					duration: { days: 7 },
                    slotDuration:{days:1}
				}
			},
            resourceLabelText: 'Users',
            resources: dataResource,
            events: data1,
            
           dayClick: function(date, jsEvent, view, resource) {
                    if(new Date(date.format("YYYY-MM-DD")+"T24:00:00") < new Date()){
                        alert("Cannot assign Shift in past date");
                    }else{
                      var boardId = <?=$_GET['board_id'];?>;
                      
                      if(resource.id == 0){
                        $.ajax({
                           url: "<?php echo URL_VIEW."process.php";?>",
                           data: "action=getShifts&boardId="+boardId,
                           type: "post",
                           async:false,
                           success:function(response) {
                               var shifts = JSON.parse(response);
                               if($.isEmptyObject(shifts)){
                                   alert("no any shift available");
                               }else{
                                   var shiftsOptn = "";
                                   $.each(shifts,function(k,v){
                                       shiftsOptn+='<option value="'+v['Shift']['id']+'">'+v['Shift']['title']+'</option>';
                                   });
                                   bootbox.dialog({
                                       title: 'Assign Shift',
                                       message: 'Select Shift <select id="schedularTaskDateClick" class="form-control" required="required">'+shiftsOptn+'</select><br/><br/>Input number of employee<input required="required" placeholder="No of Employee" id="empNoCal" type="number" class="form-control"/>',
                                       buttons: {
                                           success: {
                                               label: "Confirm",
                                               className: "btn-info",
                                               callback: function() {
                                                   saveOpenShiftUser(<?=$orgId;?>,boardId,$('#schedularTaskDateClick').val(),date.format("YYYY-MM-DD"),$('#empNoCal').val());
                                               }
                                           }
        
                                       }
                           });
                       }
                       }
                       });
                      }else{
                       $.ajax({
                           url: "<?php echo URL_VIEW."process.php";?>",
                           data: "action=getShifts&boardId="+boardId,
                           type: "post",
                           async:false,
                           success:function(response) {
                               var shifts = JSON.parse(response);
                               if($.isEmptyObject(shifts)){
                                   alert("no any shift available");
                               }else{
                                   var shiftsOptn = "";
                                   $.each(shifts,function(k,v){
                                       shiftsOptn+='<option value="'+v['Shift']['id']+'">'+v['Shift']['title']+'</option>';
                                   });
                                   bootbox.dialog({
                                       title: 'Assign Shift',
                                       message: 'Select Shift <select id="schedularTaskDateClick" class="form-control">'+shiftsOptn+'</select>',
                                       buttons: {
                                           success: {
                                               label: "Confirm",
                                               className: "btn-info",
                                               callback: function() {
                                                   saveShiftUser($('#schedularTaskDateClick').val(),boardId,date.format("YYYY-MM-DD"),resource.id,<?=$orgId;?>);
                                                   //alert('Shift:'+$('#schedularTaskDateClick').val()+"/Board:"+boardId+"/Date:"+date.format("YYYY-MM-DD")+"/USer:"+resource.id+"/Org:"+<?=$orgId;?>);
                                               }
                                           }
        
                                       }
                           });
                       }
                       }
                       });
                       }
                        // saveShiftUser(shiftId,boardId,shift_date,userId,orgId)
                       //  alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                      // alert('Current view: ' + view.name);
                       // change the day's background color just for fun
                      // $(this).css('background-color', 'red');
                    }
           },
           
            eventClick: function(calEvent, jsEvent, view) {
                if(calEvent.resourceId == 0){
                    $.ajax({
                           url: "<?php echo URL_VIEW."process.php";?>",
                           data: "action=getShifts&boardId="+boardId,
                           type: "post",
                           async:false,
                           success:function(response) {
                               var shifts = JSON.parse(response);
                                   var shiftsOptn = "";
                                   $.each(shifts,function(k,v){
                                        if(v['Shift']['id'] == calEvent.shiftId){
                                            shiftsOptn+='<option value="'+v['Shift']['id']+'" selected="selected">'+v['Shift']['title']+'</option>';
                                        }else{
                                            shiftsOptn+='<option value="'+v['Shift']['id']+'">'+v['Shift']['title']+'</option>';
                                        }
                                   });
                                   bootbox.dialog({
                                       title: 'Update Shift',
                                       message: 'Select Shift <select class="schedularTaskEventClick form-control" required="required">'+shiftsOptn+'</select><br/><br/>Input number of employee<input value="'+calEvent.noEmp+'" required="required" placeholder="No of Employee" id="empNoCal" type="number" class="form-control"/>',
                                       buttons: {
                                           success: {
                                               label: "Confirm",
                                               className: "btn-info",
                                               callback: function() {
                                                   updateOpenShiftUser(calEvent.openCalendarShiftId,$('.schedularTaskEventClick').val(),$('#empNoCal').val());
                                               }
                                           }
        
                                       }
                           });
                       }
                       });
                }
            },
            resourceRender: function(resourceObj, labelTds, bodyTds) {

                // console.log(labelTds);
                // console.log(resourceObj);
                var img = resourceObj.image;

                if(resourceObj.id != 0)
                {
                    labelTds.find(".fc-cell-content").prepend('<img class="calLabelImg" src="'+img+'" />');

                    labelTds.find(".fc-icon").hide();
                }
            },

            eventRender: function(event, element, view) {
                
                if(event.resourceId == 0){
                    
                }else{
                    element.closest('.fc-event').addClass('tooltips');
                    element.closest('.fc-event').attr("data-container","body");
                    // element.closest('.fc-event').attr("data-toggle","confirmation"); 
                    element.closest('.fc-event').attr("data-on-confirm","cnfrmOk");
                    element.closest('.fc-event').attr("data-evntID",event._id);
                    element.closest('.fc-event').attr("data-shftusrID",event.shiftUserId);
                    element.closest('.fc-event').confirmation({
                        "singleton":true,
                        "popout":true,
                        "placement":"bottom",
                        "title":"Sure to delete?",
                    });

                    // element.closest('.fc-event').tooltip(
                    //     {
                    //         "title":event.title
                    //     }); 
                }

                var tempTitle;
                if(event.title.length > 10) 
                    {
                        tempTitle = event.title.substring(0,8) +"...";
                    }else
                    {
                        tempTitle = event.title;
                    }

                    // bootbox.alert(event.shift_status);

                $(element).closest(".fc-timeline-event").addClass("calendarEventBox");
                $(element).closest(".fc-timeline-event").find('.fc-title').hide()
                $(element).closest(".fc-timeline-event").append('<div>'+tempTitle+'</div>').addClass("eventTitle");
                $(element).closest(".fc-timeline-event").find('.fc-time').addClass("fcTimeAlign");
                $(element).closest(".fc-timeline-event").append("<div class='triTop'></div>");
                $(element).closest(".fc-timeline-event").find(".triTop").css({"border-top": "9px solid "+event.backgroundColor, "border-right":"9px solid "+event.backgroundColor});

                if(event.shift_status==3){
                    $(element).closest('.fc-timeline-event').append('<img class="eventImage" width="18px" height="18px" src="<?php echo URL_VIEW."images/confirm.png";?>" />');
                } else if(event.shift_status==1){
                    $(element).closest('.fc-timeline-event').append('<img class="eventImage" width="18px" height="18px" src="<?php echo URL_VIEW."images/waiting.png";?>" />');

                } else if(event.shift_status==2){
                    $(element).closest('.fc-timeline-event').append('<img class="eventImage" width="18px" height="18px" src="<?php echo URL_VIEW."images/pendingimg.png";?>" />');
                } else if(event.shift_status==0){
                    $(element).closest('.fc-timeline-event').append('<img class="eventImage" width="18px" height="18px" src="<?php echo URL_VIEW."images/open.png";?>" />');
                }
            },
            
            eventMouseover:function( event, jsEvent, view ){

            },
            
        eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {
            if(event.resourceId == 0){
                var shiftDate = event.start.format('YYYY-MM-DD');
                var dateObj = moment(event.start, "YYY-MM-DDTHH:mm:ssZ").toDate();
                var openCId = event.openCalendarShiftId;
                //var empNo = (event.noEmp - 1);
                var today2 = new Date();
                if((dateObj.getTime()) >= (today2.getTime())){
                    $.ajax({
                       url: "<?php echo URL.'Opencalendarshifts/updateFromCalender/'?>"+openCId+"/"+shiftDate+".json",
                       datatype:"jsonp",
                       success:function(data){
                            if(data.result == 0){
                                bootbox.dialog({
                                    title: 'Message',
                                    message: 'Couldnot edit this time, try again later',
                                        buttons: {
                                        success: {
                                            label: "Ok",
                                            className: "btn-info"
                                        }
                                    }
                                });
                                revertFunc();
                            }
                       }
                    });
                }else{
                    bootbox.dialog({
                            title: 'Message',
                            message: 'This is passed date',
                                buttons: {
                                success: {
                                    label: "Ok",
                                    className: "btn-info"
                                }
                            }
                        });
                    revertFunc();
                }
            }else{
            var boardId="<?php echo $_GET['board_id'];?>";
            var orgId="<?php $orgId;?>";
            var shift_date = event.start.format('YYYY-MM-DD');
            var dateObj = moment(event.start, "YYY-MM-DDTHH:mm:ssZ").toDate();
            var userId = event.userId;
            var shiftUserId = event.shiftUserId;
            var today2 = new Date();  
        
            function updateShiftUser(shiftId,boardId,shift_date,userId,shiftUserId){
             $.ajax({
                    url: "<?php echo URL.'ShiftUsers/updateUserFromCalender/'?>"+shiftId+"/"+boardId+"/"+shift_date+"/"+userId+"/"+shiftUserId+".json",
                    datatype:'jsonp',
                    success:function(data){
                        if(data.status.status == 'Saved'){
                             event.start=data.status.start;
                             event.end=data.status.end;
                            event.backgroundColor=$('#'+data.status.Shift.id).val();
                            $('#calendar123').fullCalendar('updateEvent', event);
                            }else{
                                revertFunc();
                                //bootbox.alert(data.status.status);
        
                                $.ajax({
                                    url:"<?php echo URL.'Useravailabilities/findDurationIfNotAvailable/'?>"+userId+"/"+shift_date+".json",
                                    datatype:'jsonp',
                                    success:function(response){
                                       // bootbox.alert('The employee is not available to work from '+response.starttime+' to '+response.endtime);
                                        bootbox.dialog({
                    title: 'Message',
                    message: 'The employee is not available to work from '+response.starttime+' to '+response.endtime,
                        buttons: {
                        success: {
                            label: "Ok",
                            className: "btn-info"
                        }
                    }
                });
                             }
                    });
                            }
                     }    
                  });
              }
        //var userId = event.attr('data-userId');

      if(event.shift_status!=3){  
      if($('#shifts').val() != null){
            var shiftId=$('#shifts').val();
            if(shiftId != 0){
                if((dateObj.getTime()) >= (today2.getTime())){
                   updateShiftUser(shiftId,boardId,shift_date,userId,shiftUserId);
                } else{
                    bootbox.dialog({
                            title: 'Message',
                            message: 'This is passed date',
                                buttons: {
                                success: {
                                    label: "Confirm",
                                    className: "btn-info"
                                }
                            }
                        });
                    revertFunc();
                }

            } else {
                bootbox.dialog({
                    title: 'Message',
                    message: 'No shift assigned on this board',
                        buttons: {
                        success: {
                            label: "Confirm",
                            className: "btn-info"
                        }
                    }
                });
            }
        }else if((dateObj.getTime()) < (today2.getTime())){
            bootbox.dialog({
                title: 'Message',
                message: 'This is passed date',
                    buttons: {
                    success: {
                        label: "Confirm",
                        className: "btn-info"
                    }
                }
            });
            revertFunc();
        }else  {
                var boardId = "<?php echo $_GET['board_id'];?>";
               // bootbox.alert(boardId);
//                    bootbox.dialog({
//                             title: "Select Shift",
//                             message:'<div class="form-group form-md-radios">'+
//                             '<div class="md-radio-inline" id="data_shift">'+
//                            '</div>'+
//                            '</div>',
//                                 buttons: {
//                                 success: {
//                                   label: "Confirm",
//                                   className: "btn-success",
//                                   callback: function() {
//                                    //var a = $(this); 
//     var selected = $("input[type='radio'][name=radio2]:checked");
//     var shiftId = selected.val();
//     if((dateObj.getTime()) >= (today2.getTime())){

//         //bootbox.alert(shiftId+"/"+boardId+"/"+shift_date+"/"+userId+"/"+shiftUserId);
//         if(shiftId != 0){
//             updateShiftUser(shiftId,boardId,shift_date,userId,shiftUserId);
//         } else {
//             bootbox.alert('No shift assigned on this board');
//         }
//     }
// }
//                                 }
//                               }
//                         });
            var shiftId = event.shiftId;
            bootbox.dialog({
                    title: 'Message',
                    message: 'Are you sure to update ?',
                        buttons: {
                            success: {
                                label: "Ok",
                                className: "btn-success",
                                callback: function() {
                                    if(shiftId != 0){
                                        updateShiftUser(shiftId,boardId,shift_date,userId,shiftUserId);
                                    } else{
                                        //bootbox.alert('No shift assign on this board');
                                        bootbox.dialog({
                                            title: 'Message',
                                            message: 'No shift assigned on this board',
                                                buttons: {
                                                success: {
                                                    label: "Ok",
                                                    className: "btn-info"
                                                }
                                            }
                                        });
                                    }  
                                }    
                            }    
                        }
                });

                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getShifts&boardId="+boardId,
                    type: "post",
                    success:function(response1){
                        //bootbox.alert(response);
                        var data_shift='';
                        var shifts1 = JSON.parse(response1);

                        if(jQuery.isEmptyObject(shifts1))
                        { 
                            data_shift = "No Shift on this board";
                            $("#data_shift").html(data);
                        }
                        else
                        {      
                           $.each(shifts1, function(k5,obj5){
data_shift+='<div class="md-radio">'+
'<input type="radio" name="radio2" class="md-radiobtn" value="'+obj5.Shift.id+'" id="'+obj5.Shift.id+"_"+shiftUserId+'" ><label for="'+obj5.Shift.id+"_"+shiftUserId+'">'+
'<span class="inc"></span><span class="check"></span>'+
'<span class="box"></span>'+obj5.Shift.title+'</label>'+
'</div>';
                        });
                            $("#data_shift").html(data_shift);

                        }

                        

                        
                    }
                });
                    revertFunc();
                } 
            }else{
                    //bootbox.alert("Shift already confirmed");
                    bootbox.dialog({
                        title: 'Message',
                        message: 'Shift already confirmed',
                            buttons: {
                            success: {
                                label: "Confirm",
                                className: "btn-info"
                            }
                        }
                    });
                    revertFunc();   
                }
            }
            },    
        
        
        drop: function(date) { // this function is called when something is dropped     
                var e=$(this);
                // retrieve the dropped element's stored Event Object
                var originalEventObject = e.data('eventObject');        
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);
                // assign it the date that was reported
                copiedEventObject.start = date;
        
          var a = new Date(date);
          var year = a.getFullYear();
          var month = parseInt(a.getMonth())+1;
          if(month<10){
            month = '0'+month;
          }
          var date = a.getDate();
           if(date<10){
            date = '0'+date;
          }

          var shift_date = (year+"-"+month+"-"+date);
          var starttime = $("#shift_start_time").val();
          var y = starttime.split(':');
          var shift_start_time = (+y[0]) * 60 * 60 + (+y[1]) * 60 + (+y[2]);
          var boardId="<?php echo $_GET['board_id'];?>";
          var orgId="<?php echo $orgId;?>";
          var userId = e.attr('data-userId');
            var today1 = new Date();
            var dd = today1.getDate();
            var mm = today1.getMonth()+1; //January is 0!
            var yyyy = today1.getFullYear();
            var today = (yyyy+'-'+mm+'-'+dd);
            var seconds1 = a.getTime() / 1000;
            var seconds2 = new Date().getTime() / 1000;
        
          if($('#shifts').val() != null){
            var shiftId=$('#shifts').val();
        //bootbox.alert(shift_date);
        // bootbox.alert(today);
        if(shiftId != 0 ){
          if((seconds1+shift_start_time) >= seconds2 ){
              saveShiftUser(shiftId,boardId,shift_date,userId,orgId);
            }else{
               // bootbox.alert("This is passed date");
                        bootbox.dialog({
                    title: 'Message',
                    message: 'This is passed date',
                        buttons: {
                        success: {
                            label: "Ok",
                            className: "btn-info"
                        }
                    }
                });

            }
        } else {
            //bootbox.alert("No Shift assigned on this board");
                  bootbox.dialog({
                    title: 'Message',
                    message: 'No Shift assigned on this board',
                        buttons: {
                        success: {
                            label: "Ok",
                            className: "btn-info"
                        }
                    }
                });
        }

        } else if((seconds1+24*60*60) <= seconds2){
            //bootbox.alert("This is passed date");
                bootbox.dialog({
                    title: 'Message',
                    message: 'This is passed date',
                        buttons: {
                        success: {
                            label: "Ok",
                            className: "btn-info"
                        }
                    }
                });

            //bootbox.alert(seconds1+'/'+seconds2);
        }

       // 
        // else if((seconds1+shift_start_time) < seconds2 ){
        //     bootbox.alert(seconds1+shift_start_time);
        //     bootbox.alert(seconds2);
        //     bootbox.alert("This is passed date");
        // }    

        else {

            
                var boardId = "<?php echo $_GET['board_id'];?>";
               // bootbox.alert(boardId);
                   bootbox.dialog({
                            title: "Select Shift",
                            message:'<div class="form-group form-md-radios">'+
                            '<div class="md-radio-inline" id="data_shift">'+
                           '</div>'+
                           '</div>',
                                buttons: {
                                success: {
                                  label: "Ok",
                                  className: "btn-success",
                                  callback: function() {
                                   //var a = $(this); 
 var selected = $("input[type='radio'][name=radio2]:checked");
    var shiftId = selected.val();
    //if((dateObj.getTime()) >= (today2.getTime())){

        //bootbox.alert(shiftId+"/"+boardId+"/"+shift_date+"/"+userId+"/"+shiftUserId);
                              if(shiftId != 0 ){
                                    saveShiftUser(shiftId,boardId,shift_date,userId,orgId);
                                } else {
                                    //bootbox.alert('No Shift assigned on this board');
                                        bootbox.dialog({
                    title: 'Message',
                    message: 'No Shift assigned on this board',
                        buttons: {
                        success: {
                            label: "Ok",
                            className: "btn-info"
                        }
                    }
                });
                                }
    //}
}
                                }
                              }
                        });

                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getShifts&boardId="+boardId,
                    type: "post",
                    success:function(response1){
                        //bootbox.alert(response);
                        var data_shift='';
                        var shifts1 = JSON.parse(response1);

                        if(jQuery.isEmptyObject(shifts1))
                        {
                            
                            data_shift = "No Shift on this board";
                            $("#data_shift").html(data);
                        }

                        else
                        {      
                           $.each(shifts1, function(k5,obj5){

data_shift+='<div class="md-radio">'+
'<input type="radio" name="radio2" class="md-radiobtn" value="'+obj5.Shift.id+'" id="'+obj5.Shift.id+'_'+shift_date+'_'+userId+'" ><label for="'+obj5.Shift.id+'_'+shift_date+'_'+userId+'">'+
'<span class="inc"></span><span class="check"></span>'+
'<span class="box"></span>'+obj5.Shift.title+'</label>'+
'</div>';
                        });
                            //bootbox.alert(obj.Shift.id);
                            $("#data_shift").html(data_shift);

                        }

                        

                        
                    }
                });

             

                //revertFunc();
            }
                    // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            }

            });
        }
   });   
}

// $(document).ready(function(){
   loadCalendar(); 
// });
//Calender.init();
function cnfrmOk(){
    //$('#calendar123').fullCalendar(removeEvents,)
    var eventID = ($(this).attr('data-evntID'));
    var shiftUserID = ($(this).attr('data-shftusrID'));
    $.ajax({
        url:'<?php echo URL."ShiftUsers/deleteShiftById/";?>'+shiftUserID+".json",
        datatype:'jsonp',
        success:function(data){
            if(data == 1){
             $('#calendar123').fullCalendar('removeEvents',eventID);
            }
            
        }
    });
}
</script>

<script>
jQuery(document).ready(function() {       
   ComponentsPickers.init();
});   
</script>

<script src="<?php echo URL_VIEW;?>global/plugins/moment.min.js"></script>
<script src="<?php echo URL_VIEW; ?>global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
