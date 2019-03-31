<?php

$url_open = URL."ShiftUsers/myScheduleForCalender/".$user_id.".json";
$r_open = \Httpful\Request::get($url_open)->send();
$users_shifts = $r_open->body->mySchedule;
// fal($users_shifts);

 if (isset($_POST['exportToOutlookCalendar'])){
    $count=0;
    $cal_event1=array();

    if(!empty($users_shifts)){
        foreach($users_shifts as $shft){
            if($shft->status == 3){
                $cal_event1[$count]=array(
                  "Subject"=> "Shiftmate Shift : ".$shft->title,
                  "Body"=>array(
                    "ContentType"=> "HTML",
                    "Content"=> 'Organization : '.$shft->org->title.'('.$shft->org->id.')'
                  ),
                  "Start"=> $shft->start."-00:00",
                  "StartTimeZone"=> "Pacific Standard Time",
                  "End"=> $shft->end."-00:00",
                  "EndTimeZone"=> "Pacific Standard Time",
                );
                $count++;
            }
        }
    }
?>
<script src="http://outlook.office.com/Calendars.ReadWrite"></script>
<script>

var authContext;
var authToken; // for use with creating an outlookClient later.
authContext = new O365Auth.Context();
authContext.getIdToken("https://outlook.office365.com/")
   .then((function (token) {
       authToken = token;
       userName = token.givenName + " " + token.familyName;
       var outlookClient = new Microsoft.OutlookServices.Client('https://outlook.office365.com/api/v1.0', authToken.getAccessTokenFn('https://outlook.office365.com'));
        $.ajax({
            url:"https://outlook.office.com/api/v1.0/me/events",
            data:<?php echo json_encode($cal_event1);?>,
            type:"post",
            contentType: "application/json",
            success:function(response){
                         // console.log(response);
            }
        });
   }).bind(this), function (reason) {
       // console.log('Failed to login. Error = ' + reason.message);
    });

</script>
<?php

 }


if(isset($_POST['exportToGoogleCalendar']) || isset($_SESSION['succAuthCal'])){

    unset($_SESSION['succAuthCal']);

    $count=0;
    $cal_event=array();

    if(!empty($users_shifts)){
        foreach($users_shifts as $shft){

            $timeStart = explode('T', $shft->start);

            $objDateTimeStart = new DateTime($timeStart[0]." ".$timeStart[1]);

            $isoDateStart = $objDateTimeStart->format(DateTime::ISO8601);

            $timeEnd = explode('T', $shft->end);

            $objDateTimeEnd = new DateTime($timeEnd[0]." ".$timeEnd[1]);

            $isoDateEnd = $objDateTimeEnd->format(DateTime::ISO8601);

            // fal($isoDate);
            if($shft->status == 3){
                $cal_event[$count]=array(
                    'summary'=>"Shiftmate Shift : ".$shft->title,
                    'location'=>'',
                    'colorId'=>'1',
                    // 'id'=>"sftusr".$shft->shiftUserId,
                    'description'=>'Organization : '.$shft->org->title.'('.$shft->org->id.')',
                    'start'=>array(
                                'dateTime'=>$isoDateStart,
                                // 'timeZone' => 'Asia/Kathmandu',
                            ),
                    'end'=>array(
                                'dateTime'=>$isoDateEnd,
                                // 'timeZone' => 'Asia/Kathmandu',
                            ),
                    'extendedProperties'=>array(
                                    'private'=>array(),
                                    'shared'=>array(
                                            'shiftUser_id'=>$shft->shiftUserId
                                        )
                        )
                );
                $count++;
            }
        }
     }

  require_once __DIR__ . '/../calendarApi/vendor/autoload.php';

  $client = new Google_Client();
  $client->setAuthConfigFile(URL_VIEW.'calendarApi/client_secrets.json');
  $client->addScope(Google_Service_Calendar::CALENDAR);
  // $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
  // $client->setAccessType('offline');
  // $client->setApprovalPrompt('force');    

  if (isset($_SESSION['access_token']) && $_SESSION['access_token'])
  {
    $client->setAccessToken($_SESSION['access_token']);

    if($client->isAccessTokenExpired())
    {
        $redirect_uri = URL_VIEW.'calendarApi/calendarCallback';
    ?>
        <script>
            window.location="<?php echo filter_var($redirect_uri, FILTER_SANITIZE_URL);?>";
        </script>
    <?php

    }

    if(isset($_SESSION['branch_id']))
    {
        
        unset($_SESSION['branch_id']);
        unset($_SESSION['board_id']);
        unset($_SESSION['org_id']);
    }
    
    
    $service = new Google_Service_Calendar($client);
        $calendarId = 'primary';

        $optParams = array(
          'orderBy' => 'startTime',
          'singleEvents' => TRUE,
        //  'timeMin' => date('c'),
        );
        $results = $service->events->listEvents($calendarId, $optParams);

        // echo "<pre>";print_r($cal_event);
        // echo "<pre>";print_r($results);die();

        if (count($results->getItems()) == 0){
            foreach($cal_event as $ccc_eee){

                $event1 = new Google_Service_Calendar_Event($ccc_eee);
                $event2 = $service->events->insert($calendarId, $event1);
                }
            ?>
            <?php
        } else {

            $googleEventIds = array();
            foreach($cal_event as $ccc_eee){
            $count_x=0;
            foreach ($results->getItems() as $event) {                
                $googleEventIds[$event['id']] = $event['extendedProperties']['shared']['shiftUser_id'];
            }


            if(!in_array($ccc_eee['extendedProperties']['shared']['shiftUser_id'], $googleEventIds))
            {
                $event3 = new Google_Service_Calendar_Event($ccc_eee);
                $event4 = $service->events->insert($calendarId, $event3);
                
            ?>
            <?php
            }else{
                $event3 = new Google_Service_Calendar_Event($ccc_eee);
                $eventId = array_search($ccc_eee['extendedProperties']['shared']['shiftUser_id'], $googleEventIds);

                $event4 = $service->events->update($calendarId,$eventId,$event3);
                ?>
                <?php
            }
          }
        }?>

        <script>
            toastr.info("Successfully exported to Google Calendar.");
        </script>

<?php
  }
  else
  {
    $_SESSION['board_id']=$_GET['board_id'];
    $_SESSION['org_id']=$_GET['org_id'];
    $_SESSION['branch_id']=$_GET['branch_id'];
    $redirect_uri = URL_VIEW.'calendarApi/calendarCallback';
?>

    <script>
        window.location="<?php echo filter_var($redirect_uri, FILTER_SANITIZE_URL);?>";
    </script>
<?php
    
  }
}

?>

<link href="<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet"/>
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>My Shift Calendar <small> shift schedule overview</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="">My Shift Calendar</a>
            </li>
        </ul>

        <div class="row">
			<div class="col-md-3">
				<div class="portlet light">
                    <div class="portlet-title margin-top-10">
                        <form action="" method="post">
                            <button class="btn green" name="exportToGoogleCalendar" type="submit">Export to google calendar</button>
                        </form>
                        <hr>
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Labels&nbsp;&nbsp;</span>
                            <small>per organisation</small>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                    </div>
					<div class="portlet-body">
                        <div>
                            <?php
                               $count=0;
                               if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)){
                                   foreach($loginUserRelationToOther->userOrganization as $k=>$v){
                                        $color = dechex(hexdec('100099') + hexdec($count));

                                        if($color >= 'eeeeee'){
                                            $count = dechex($k*132);
                                        }
                                        foreach($v as $k1=>$v1){
                                            echo "<input type='hidden' id='orgColor_".$k."' value='#".$color."'/>";
                                        }
                                        echo '<ul style="padding:0px;"><li style="height: 10px;width: 20px;background-color:#'.$color.';display:inline-block;"></li><li style="display:inline-block;"><strong>&nbsp;&nbsp;'.$k1.'</strong></li></ul>';
                                        $count=dechex(hexdec($count)+111166);
                                   }
                               }
                            ?>
                        </div>

                        
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


<script src="<?php echo URL_VIEW;?>global/plugins/moment.min.js"></script>

<script src="<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/calendar.js"></script>

<script src="<?php echo URL_VIEW;?>global/plugins/bootbox/bootbox.min.js"></script>

<script>
    $(document).ready(function() {

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
                toastr.info('You are not available to work on this shift');
t            }
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
            var url = '<?php echo URL."ShiftUsers/getEmpShiftSchedule/".$user_id;?>.json';
            $.ajax({
                url:url,
                dataType:'jsonp',
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
                                        background_Color:$('#orgColor_'+k.orgId).val(),
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
                                                    background_Color:$('#orgColor_'+k.orgId).val(),
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
                                // console.log(event);
                                if(event.description.length > 10) 
                                    {
                                        tempTitle = event.description.substring(0,8) +"...";
                                    }else
                                    {
                                        tempTitle = event.description;
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