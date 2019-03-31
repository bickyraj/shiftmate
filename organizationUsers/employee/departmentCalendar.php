<?php

    $url = URL."Boards/view/".$_GET['board_id'].".json";
    $response = \Httpful\Request::get($url)->send();
    $boardDetail = $response->body->board;
    // fal($boardDetail);


    $url = URL."ShiftBoards/getBoardShiftList/".$_GET['board_id'].".json";
    $response = \Httpful\Request::get($url)->send();
    $shiftList = $response->body->boardShifts;

    // fal($shiftList);
?>

<div class="page-head">
   <div class="container">
        <div class="page-title">
            <h1><?php echo $boardDetail->Board->title; ?> Calendar <small> for Holidays, Leaves &amp; Shifts</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo URL_VIEW;?>"><i class="fa fa-home"></i>&nbsp;Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo URL_VIEW.'calendar/showCalendar';?>">Calendar</a>
            </li>
        </ul>
        <div class="row margin-top-10">
            <div class="col-md-3 col-sm-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Labels</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <ul class="feeds">
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success" style="height: 20px;width: 20px;background-color:black;">
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc">
                                                Public Holidays
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <hr>
                        <div>Per Shift</div>
                        <br>
                        <ul class="feeds">

                            <?php 
                                   $count=0;
                                   if(isset($shiftList) && !empty($shiftList)){
                                       foreach($shiftList as $shift){
                                            $color = dechex(hexdec('100099') + hexdec($count));

                                            if($color >= 'eeeeee'){ 
                                                $count = dechex($shift->Shift->id*132);
                                            }
                                            
                                            echo "<input type='hidden' id='orgColor_".$shift->Shift->id."' value='#".$color."'/>";

                                            echo    '<li>
                                                        <div class="col1">
                                                            <div class="cont">
                                                                <div class="cont-col1">
                                                                    <div class="label label-sm label-success" style="height: 20px;width: 20px;background-color:#'.$color.';">
                                                                    </div>
                                                                </div>
                                                                <div class="cont-col2">
                                                                    <div class="desc">'.$shift->Shift->title.'
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>';
                                            $count=dechex(hexdec($count)+111166);
                                       }
                                   }
                                ?> 
                            
                        </ul>
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
                        <ul style="padding:0px;">
                            <li style="list-style-type:none; margin-bottom:10px;"><img src="<?php echo URL_VIEW."images/confirm.png";?>" alt="conform" style="height:18px;width:18px;"/>&nbsp;&nbsp;<span>Confirmed</span></li>
                            <li style="list-style-type:none; margin-bottom:10px;"><img src="<?php echo URL_VIEW."images/waiting.png";?>" alt="waiting" style="height:18px;width:18px;"/>&nbsp;&nbsp;<span>Waiting</span></li>
                            <li style="list-style-type:none; margin-bottom:10px;"><img src="<?php echo URL_VIEW."images/pendingimg.png";?>" alt="pending" style="height:18px;width:18px;"/>&nbsp;&nbsp;<span>Pending</span></li>
                            <li style="list-style-type:none; margin-bottom:10px;"><img src="<?php echo URL_VIEW."images/open.png";?>" alt="open" style="height:18px;width:18px;"/>&nbsp;&nbsp;<span>Open Shift</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Department Shift Schedule</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="<?=URL_IMAGE;?>loading-x.gif" id="loadingimage" alt="loading, Please wait..."/>
                                <style>
                                    #loadingimage{
                                        display: block;
                                        margin-left: auto;
                                        margin-right: auto
                                    }
                                </style>
                                <div id="calendar12" class="has-toolbar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {  
        
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "200",
      "timeOut": "9000",
      "extendedTimeOut": "12000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }

    function confirmShift(shiftUserId , status)
    {
        var userId = '<?php echo $userId; ?>'; 
        var url1 ="<?php echo URL; ?>Useravailabilities/confirmCalendarRequest/"+userId+'/'+shiftUserId+'.json';


        var userAvailable = 0;  
        $.ajax({
            url:url1,
            type:'post',
            datatype:'jsonp',
            async:false,
            success:function(response){
                if(response == 1){
                    userAvailable = 1;
                } else {
                    userAvailable = 0;
                }
            }
        });


        if(userAvailable == 1){

            var status;
            var url = '<?php echo URL."ShiftUsers/confirmShift/";?>'+shiftUserId+'/'+status+'/'+'<?php echo $user_id;?>'+'.json';

            $.ajax(
                {
                    url:url,
                    type:'post',
                    dataType:'jsonp',
                    async:false,
                    success:function(res)
                    {
                        status = res.message.status;
                    },
                    error:function()
                    {

                    }
                });
            return status;
        } else {
            toastr.info('You are not available to work for this shift.');
        }

        
    }

    function confirmOpenShift(openCShiftId, userId)
    {
        var status;
        var url = '<?php echo URL."Opencalendarshifts/userResponseToShift/";?>'+openCShiftId+'/'+userId+'.json';

        $.ajax(
            {
                url:url,
                type:'post',
                dataType:'jsonp',
                async:false,
                success:function(res)
                {
                    status = res.status;
                },
                error:function()
                {

                }
            });

        return status;
    }
        function loadCalender(){

            var boardId = <?php echo $_GET['board_id']; ?>;
            var url = '<?php echo URL."ShiftUsers/getEmpShiftOnBoard/".$user_id."/";?>'+boardId+".json";

        $.ajax({
            url:url,
            datatype:'jsonp',
            beforeSend: function(){
                $('#loadingimage').show();
            },
            complete: function(){
                $('#loadingimage').hide();
            },
            success:function(res){
                // console.log(res.data);
                if(res.status != 0){
                        var data3=$.map(res.data,function(k,v){

                            if(k.status != 0)
                            {

                                return {
                                    title:k.title,
                                    start:k.start,
                                    end:k.end,
                                    background_Color:$('#orgColor_'+k.shift_id).val(),
                                    description:k.description,
                                    stat:k.status,
                                    shiftUserId:k.id
                                }
                            }else
                            {
                                return {
                                                title:k.title,
                                                start:k.start,
                                                end:k.end,
                                                background_Color:$('#orgColor_'+k.shift_id).val(),
                                                description:k.description,
                                                stat:k.status,
                                                openCShiftId:k.openCShiftId,
                                                openCShiftcount:k.openCShiftcount
                                            }
                            }

                       });
                }else{
                    var data3={};
                }
            var data1=[];
          $.ajax({
                    url:'http://data.gov.au/api/action/datastore_search?resource_id=0f94ad45-c1b4-49de-bada-478ccd3805f0',
                    datatype:"jsonp",
                    async:false,
                    success:function(data){
                        if(data.result.records != null){
                            var data2=$.map(data.result.records,function(v,k){
                                if(v.ACT == "TRUE"){
                                    stY=v.DTSTART.substring(0,4);
                                    stM=v.DTSTART.substring(4,6);
                                    stD=v.DTSTART.substring(6,8);
                                    enY=v.DTEND.substring(0,4);
                                    enM=v.DTEND.substring(4,6);
                                    enD=v.DTEND.substring(6,8);
                                    return{
                                    title:v.Summary,
                                    start:stY+"-"+stM+"-"+stD,
                                    end:enY+"-"+enM+"-"+enD,
                                    borderColor:'black',
                                    backgroundColor:'black',
                                    textColor:'white',
                                    description:v.Description
                                    }
                                }
                            });
                        }else{
                            var data2={};
                        }
                        data1 = $.merge(data3, data2);
                    }
                });

                /*$.ajax(
                    {
                        url:'<?php echo URL."Opencalendarshifts/getOpenShiftOfBoard/";?>'+boardId+".json",
                        type:'post',
                        datatype:'josnp',
                        async:false,
                        success:function(res)
                        {
                            if(res.status == 1)
                            {
                                var openShift = $.map(res.result ,function(k,v){

                                    return {
                                                title:"Shift",
                                                start:k.start,
                                                end:k.end,
                                                background_Color:$('#orgColor_'+k.Shift.id).val(),
                                                description:k.Shift.title,
                                                stat:0,
                                                openCShiftId:k.openCShiftId,
                                                openCShiftcount:k.openCShiftcount
                                            }
                                });


                                data1 = $.merge(data1, openShift);
                            }
                        }
                    });*/

               $('#calendar12').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    defaultDate: new Date(),
                    //editable: true,
                    //droppable: true,
                    displayEventEnd:true,
                    eventLimit: true,
                    events: data1,
                    eventRender: function (event, element, view) {
                        //to all event add sth event.prepend();
                        if(event.title=='Shift'){
                            if(event.stat == 0){
                                var status = "Open shift";
                            }else if(event.stat == 1){
                                var status = "Pending";
                            }else if(event.stat == 2){
                                var status = "Waiting";
                            }else if(event.stat == 3){
                                var status = "Confirmed";
                            }
                        }else if(event.title == "Function"){
                            if(event.stat == 0){
                                var status = "Organization Holiday";
                            }else if(event.stat == 1){
                                var status = "event";
                            }
                        }else if(event.title == "Leave"){
                            if(event.stat == 0){
                                var status = "pending";
                            }else if(event.stat == 1){
                                var status = "Rejected";
                            }else if(event.stat == 2){
                                var status = "Accepted";
                            }
                        }
                        
                        if(event.title == 'Shift')
                        {
                            var statImg;
                            if(event.stat==3){

                                statImg = '<?php echo URL_VIEW."images/confirm.png";?>';
                            } else if(event.stat==1){
                                statImg = '<?php echo URL_VIEW."images/waiting.png";?>';

                            } else if(event.stat==2){
                                statImg = '<?php echo URL_VIEW."images/pendingimg.png";?>';
                            } else if(event.stat==0){
                                statImg = '<?php echo URL_VIEW."images/open.png";?>';
                            }

                            element.find('.fc-content').remove();

                            element.closest('.fc-day-grid-event').css({'background-color':"rgb(230, 230, 230)", 'border':"none"});

                            var tempTitle;

                            if(event.description != null) 
                            {
                                if(event.description.length > 10)
                                {
                                    tempTitle = event.description.substring(0,8) +"...";
                                }
                                else
                                {
                                    tempTitle = event.description;
                                }
                            }else
                            {
                                tempTitle = "No Title.";
                            }

                            var time = moment(event.start).format("ha").slice(0, -1)+' - '+moment(event.end).format('ha').slice(0, -1);
                            var content = '<div class="calEventContent">'+
                            '<div class="empCalShiftTime">'+time+'</div>'+
                            '<img class="empCalShiftStat" src="'+statImg+'">'+
                            '<div class="triTop" style="border-top:9px solid '+event.background_Color+'; border-right:9px solid '+event.background_Color+';"></div>'+
                            '<div class="empCalShiftTitle">'+tempTitle+'</div>';

                            
                            element.append(content);
                            
                            element.find('.calEventContent').addClass('popovers');
                            element.find('.calEventContent').attr('style',"cursor:pointer;");
                            element.find('.calEventContent').attr('data-container',"body");
                            element.find('.calEventContent').attr('data-trigger',"hover");
                            element.find('.calEventContent').attr('data-html',"true");
                            element.find('.calEventContent').attr('data-original-title',status);
                            element.find('.calEventContent').attr('data-placement',"left");
                            element.find('.calEventContent').attr('data-content',"<p><i>"+event.description+"</i></p>");
                        }
                        else
                        {
                            element.find('.fc-content').addClass('popovers');
                            element.find('.fc-content').attr('style',"cursor:pointer;");
                            element.find('.fc-content').attr('data-container',"body");
                            element.find('.fc-content').attr('data-trigger',"hover");
                            element.find('.fc-content').attr('data-html',"true");
                            element.find('.fc-content').attr('data-original-title',status);
                            element.find('.fc-content').attr('data-placement',"left");
                            element.find('.fc-content').attr('data-content',"<p><i>"+event.description+"</i></p>");
                        }

                    },
                    drop: function(date) { 
                        //when external events are dropped
                    },
                    eventDrop: function(event, delta, revertFunc ) {
                        //when events are moved to another date
                    },
                    loading: function(bool) {
                        //when calendar loads
                    },
                    eventClick: function(calEvent, jsEvent, view) {
                        //when an event is clicked 
                        // console.log(calEvent);

                        var eventId = calEvent._id;

                        var todayDate = new Date();
                        if(calEvent.start >= todayDate && calEvent.stat == 1)
                        {
                            
                            bootbox.dialog({
                              message: calEvent.description,
                              title: "Shift Confirmation",
                              buttons: {
                                success: {
                                  label: "Accept",
                                  className: "btn-success",
                                  callback: function() {

                                    var status = confirmShift(calEvent.shiftUserId, 1);

                                    if(status == "Ok")
                                    {
                                        calEvent.stat = 3;

                                        $('#calendar12').fullCalendar('updateEvent', calEvent);

                                        toastr.success('You\'ve accepted the shift.');

                                        // $('#calendar12').fullCalendar('renderEvent', copiedEventObject, true);
                                    }
                                  }
                                },
                                danger: {
                                  label: "Reject",
                                  className: "btn-danger",
                                  callback: function() {

                                    var status = confirmShift(calEvent.shiftUserId, 4);

                                    if(status == "Ok")
                                    {
                                        $("#calendar12").fullCalendar('removeEvents', eventId);
                                        toastr.success('You\'ve rejected the shift.');
                                    }
                                  }
                                }
                              }
                            });
                        }else if(calEvent.start >= todayDate && calEvent.stat == 0)
                        {
                            //do something
                            bootbox.dialog({
                              message: calEvent.description,
                              title: "Shift Confirmation",
                              buttons: {
                                success: {
                                  label: "Accept",
                                  className: "btn-success",
                                  callback: function() {

                                    var userId = '<?php echo $user_id;?>';
                                    var status = confirmOpenShift(calEvent.openCShiftId, userId);

                                    if(status == 1)
                                    {
                                        calEvent.stat = 3;

                                        $('#calendar12').fullCalendar('updateEvent', calEvent);

                                        toastr.success('You\'ve accepted the shift.');

                                        // $('#calendar12').fullCalendar('renderEvent', copiedEventObject, true);
                                    }
                                  }
                                }
                              }
                            });
                        }
                    },
                    eventMouseover:function( event, jsEvent, view ) { 
                        popoverActivete();                                                        
                        //toastr.info("<p>"+event.description +"</p><strong>"+ status+"</strong>","<strong><em>"+event.title+"</em></strong>");
                    },
                    eventMouseout:function( event, jsEvent, view ) { 
                      // toastr.clear();
                    }
                });
            }
       });   
       }
       loadCalender();
       popoverActivete();

           function popoverActivete(){
                $('.popovers').popover();
            }
       });
</script>