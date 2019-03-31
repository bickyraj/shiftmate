<!-- <div class="modal-content"><div class="modal-header"><button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true">×</button><h4 class="modal-title">Select Shift</h4></div><div class="modal-body"><div class="bootbox-body"><div class="form-group form-md-radios"><div class="md-radio-inline" id="data_shift"><div class="md-radio"><input type="radio" name="radio2" class="md-radiobtn" id="7"><label for="7"><span class="inc"></span><span class="check"></span><span class="box"></span>Day Shift</label></div><div class="md-radio"><input type="radio" name="radio2" class="md-radiobtn" id="14"><label for="14"><span class="inc"></span><span class="check"></span><span class="box"></span>Night Shift</label></div></div></div></div></div><div class="modal-footer"><button data-bb-handler="success" type="button" class="btn btn-success">Confirm</button></div></div> -->

<?php 
if(isset($_GET['board_id'])){
    $boardId = $_GET['board_id'];
}
if(isset($_GET['org_id'])){
    $orgId = $_GET['org_id'];
}
$url = URL."Boards/listBoards/".$orgId.".json";
$response = \Httpful\Request::get($url)->send();
$boards = $response->body->boards;
$url = URL."ShiftUsers/showShiftUserOfBoard/".$orgId."/".$boardId.".json";
$response = \Httpful\Request::get($url)->send();
$Users1 = $response->body->shiftUser;
// $url = URL."Useravailabilities/listAllAvailableUser/".$orgId.".json";

// $response = \Httpful\Request::get($url)->send();
// $available = $response->body;

// echo '<pre>';
// print_r($available);
// die();

// echo "<pre>";
// print_r($shifts);

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
?>

<link href="<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet"/>
<link href='<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />  
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
            <h1>Department <small> Assign User in shift</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Pages</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">ShiftAssign</a>
            </li>
        </ul>
        
       <div class="row">
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box green-meadow calendar">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>Calendar
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
            <div class="col-md-3 col-sm-12">
            <!--Form Begins-->
            <form method="post" action="" role="form" enctype="multipart/form-data">
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
            </form>
        <!--form ends-->
                            <!-- BEGIN DRAGGABLE EVENTS PORTLET-->
                            <div id='wrap'>
                                <div id='external-events'>
                                    <h4>Users</h4>
                                    <!-- <p>
                                        <input type='checkbox' id='drop-remove' />
                                        <label for='drop-remove'>remove after drop</label>
                                    </p>
 -->                                </div>
                                <div style='clear:both'></div>
                            </div>
                            <!-- END DRAGGABLE EVENTS PORTLET-->
<hr/><h4>Shift Label</h4>
<?php 
if(!empty($Users1)){
    foreach($Users1 as $shifts1){
        $shifts[$shifts1->Shift->id]=ucwords($shifts1->Shift->title);
    }
    $color=113311;
    foreach($shifts as $shft_id=>$shft_name){
        echo "<input type='hidden' id='".$shft_id."' value='#".$color."'/>";
        echo "<ul><li style='display:inline-block;height:20px;width:20px;background-color:#".$color."'></li><li style='display:inline-block;'>&nbsp;".$shft_name."</li></ul>";
        $color=dechex(hexdec($color)+111166);
    }
}
?>
<hr/><h4>Shift Status Label</h4>
<ul><li style="display:inline-block"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/confirm.png";?>" /></li>&nbsp;Confirmed</ul>
<ul><li style="display:inline-block"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/waiting.png";?>" /></li>&nbsp;waiting</ul>
<ul><li style="display:inline-block"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/open.png";?>" /></li>&nbsp;Open</ul>
<ul><li style="display:inline-block"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/pendingimg.png";?>" /></li>&nbsp;Pending</ul>
                        </div>
                        <div class="col-md-9 col-sm-12">
                            <div id="calendar123" class="has-toolbar">
                            </div>
                        </div>
                    </div>
                    <!-- END CALENDAR PORTLET-->
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>





<script>
$(document).ready(function() {
    addDragEvent();
   // addSelectEvent();
});
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

    // function addSelectEvent(){
    //     $('#users .fc-event').each(function() {
        
    //         // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
    //         // it doesn't need to have a start or end
    //         var eventObject1 = {
    //             title: $.trim($(this).text()) // use the element's text as the event title
    //         };
    //        // console.log(eventObject);
    //         // store the Event Object in the DOM element so we can get to it later
    //         $(this).data('eventObject', eventObject1);
    //         $(this).draggable({
    //             zIndex: 999,
    //             revert: true,      // will cause the event to go back to its
    //             revertDuration: 0  //  original position after the drag
    //         });
            
    //     });

        
    // }


</script>
<script type="text/javascript">
 var boardId = '<?php echo $boardId;?>';
        $(document).ready(function(){
            
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

                        
                    //$('#external-events').find('.fc-event').remove();
                    //$('#external-events').find('.fc-event1').remove();
                    //$('#external-events').append(data1);
                    //bootbox.alert(data);
                $('#users').append(data);
                $('#users').change(function() {

                var user = {};
                if($(this).val()){    
                user = $(this).val();
                //break;
                }

                var data1 = '';
                $.each(users, function(k,obj){
                    //console.log(obj);
                   // if($(this).val()==obj.User.id){
                       // bootbox.alert(obj.User.id);
                $.each(user,function(k1,v1){
                    if(v1==obj.User.id){
                        data1+= "<div class='fc-event' data-userId=" + obj.User.id + ">" + ((obj.User.fname).charAt(0).toUpperCase() + obj.User.fname.slice(1))+" "+((obj.User.lname).charAt(0).toUpperCase() + obj.User.lname.slice(1))+ "</div>";
                    }
                });
                   
                   //}
                });

                $('#external-events').find('.fc-event').remove();
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

      });
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
jQuery(document).ready(function() {       
    $.ajax({
        url:'<?php echo URL."ShiftUsers/showShiftUserOfBoard/".$orgId."/".$_GET["board_id"].".json";?>',
        datatype:'jsonp',
        success:function(data){
            if(data.shiftUser != null){
                var data1=$.map(data.shiftUser,function(k,v){
                    return {
                        title:k.title,
                        start:k.start,
                        end:k.end,
                        backgroundColor:$('#'+k.Shift.id).val(),
                        shiftUserId:k.shiftUserId,
                        userId:k.userId,
                        shift_status:k.shift_status,
                        shiftId:k.Shift.id

                    }
               });
            }  else{
                var data1 = {};
            }

           $('#calendar123').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
              eventClick: function(calEvent, jsEvent, view) {

            },

                eventRender: function(event, element, view) {

                element.closest('.fc-event').attr("data-toggle","confirmation"); 
                element.closest('.fc-event').attr("title","Are you sure to delete?"); 
                element.closest('.fc-event').attr("data-on-confirm","cnfrmOk");
                element.closest('.fc-event').attr("data-evntID",event._id);
                element.closest('.fc-event').attr("data-shftusrID",event.shiftUserId);


                    // bootbox.alert(event.shift_status);
                if(event.shift_status==3){
                    $(element).find('span:first').append('&nbsp<img width="18px" height="18px" src="<?php echo URL_VIEW."images/confirm.png";?>" />');
                } else if(event.shift_status==1){
                    $(element).find('span:first').append('&nbsp<img width="18px" height="18px" src="<?php echo URL_VIEW."images/waiting.png";?>" />');

                } else if(event.shift_status==2){
                    $(element).find('span:first').append('&nbsp<img width="18px" height="18px" src="<?php echo URL_VIEW."images/pendingimg.png";?>" />');
                } else if(event.shift_status==0){
                    $(element).find('span:first').append('&nbsp<img width="18px" height="18px" src="<?php echo URL_VIEW."images/open.png";?>" />');
                }
            },

            
            editable: true,
            defaultDate: new Date(),
            droppable: true,
            events: data1,
        eventMouseover:function( event, jsEvent, view ) { 
                $('.fc-event').confirmation();                                                      
            },
        eventDrop: function(event, delta, revertFunc ) {
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
                            label: "Confirm",
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
            
            
            // var dd = today2.getDate();
            // var mm = today2.getMonth()+1; //January is 0!
            // var yyyy = today2.getFullYear();
            
            // if(dd<10){
            // dd='0'+dd
            // } 
            // if(mm<10){
            //     mm='0'+mm
            // } 
            // var day2 = (yyyy+'-'+mm+'-'+dd);
        //     bootbox.alert(shift_date);
        // bootbox.alert(day2);
        if((dateObj.getTime()) >= (today2.getTime())){
           updateShiftUser(shiftId,boardId,shift_date,userId,shiftUserId);
        } else{
            //bootbox.alert('This is passed date');
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
            //bootbox.alert('No shift assigned on this board');
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

        }

        else if((dateObj.getTime()) < (today2.getTime())){
            //bootbox.alert('This is passed date');
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
       
        else  {


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

//bootbox.alert(shiftUser_Id);
data_shift+='<div class="md-radio">'+
'<input type="radio" name="radio2" class="md-radiobtn" value="'+obj5.Shift.id+'" id="'+obj5.Shift.id+"_"+shiftUserId+'" ><label for="'+obj5.Shift.id+"_"+shiftUserId+'">'+
'<span class="inc"></span><span class="check"></span>'+
'<span class="box"></span>'+obj5.Shift.title+'</label>'+
'</div>';
                        });
                            //bootbox.alert(obj.Shift.id);
                            $("#data_shift").html(data_shift);

                        }

                        

                        
                    }
                });

             

                revertFunc();
            } 

        }
            else {
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

        },    
            drop: function(date) { // this function is called when something is dropped     
                var e=$(this);
                // retrieve the dropped element's stored Event Object
                var originalEventObject = e.data('eventObject');        
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);
                // assign it the date that was reported
                copiedEventObject.start = date;

            function saveShiftUser(shiftId,boardId,shift_date,userId,orgId){

                $.ajax({
                url: "<?php echo URL.'ShiftUsers/checkUserIfAvailable/'?>"+shiftId+"/"+boardId+"/"+shift_date+"/"+userId+"/"+orgId+".json",
                datatype:'jsonp',
                type : 'post',
                success:function(data){
                        if(data.status.status == 'Saved'){
                            copiedEventObject.shiftUserId = data.status.id;
                            copiedEventObject.shift_status = data.status.shift_status;
                            copiedEventObject.start = data.status.start;
                            // copiedEventObject.end = data.status.end;
                            copiedEventObject.userId = userId;
                            copiedEventObject.backgroundColor = $('#'+shiftId).val();
                            $('#calendar123').fullCalendar('renderEvent', copiedEventObject, true);
                        }else{
                            //bootbox.alert(data.status.status);
                               $.ajax({
                                    url:"<?php echo URL.'Useravailabilities/findDurationIfNotAvailable/'?>"+userId+"/"+shift_date+".json",
                                    datatype:'jsonp',
                                    success:function(response){
                                        //bootbox.alert('The employee is not available to work from '+response.starttime+' to '+response.endtime);
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
});
Calender.init();
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
<script src='<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.js'></script>
<script src="<?php echo URL_VIEW;?>global/plugins/moment.min.js"></script>
<script src="<?php echo URL_VIEW; ?>global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
