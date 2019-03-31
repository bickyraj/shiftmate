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
                         console.log(response);
            }
        });
   }).bind(this), function (reason) {
       console.log('Failed to login. Error = ' + reason.message);
    });

</script>
<?php

 }

if(isset($_POST['exportToGoogleCalendar']) || isset($_GET['succAuthCal'])){
    $count=0;
    $cal_event=array();

    if(!empty($users_shifts)){
    foreach($users_shifts as $shft){
        if($shft->status == 3){
            $cal_event[$count]=array(
                'summary'=>"Shiftmate Shift : ".$shft->title,
                'location'=>'',
                'id'=>"sftusr".$shft->shiftUserId,
                'description'=>'Organization : '.$shft->org->title.'('.$shft->org->id.')',
                'start'=>array(
                            'dateTime'=>$shft->start."-00:00",
                            'timeZone' => 'Asia/Kathmandu',
                        ),
                'end'=>array(
                            'dateTime'=>$shft->end."-00:00",
                            'timeZone' => 'Asia/Kathmandu',
                        ),
            );
            $count++;
        }
    }
 }

require_once "calendarApi/vendor/autoload.php";

$client = new Google_Client();
$client->setAuthConfigFile(URL_VIEW.'calendarApi/client_secret.json');
$client->addScope(Google_Service_Calendar::CALENDAR);
$client->setAccessType('offline');
$client->setApprovalPrompt('force');

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

  unset($_SESSION['branch_id']);
  unset($_SESSION['board_id']);
  unset($_SESSION['org_id']);

  $client->setAccessToken($_SESSION['access_token']);
  $client->setIncludeGrantedScopes(true);
//  **********************
  if ($client->isAccessTokenExpired()) {
    $client->refreshToken($client->getAccessToken());
    file_put_contents('calendarApi/~/.credentials/calendar-api-quickstart.json', $client->getAccessToken());
  }


  $service = new Google_Service_Calendar($client);
  $calendarId = 'primary';

$optParams = array(
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
//  'timeMin' => date('c'),
);
$results = $service->events->listEvents($calendarId, $optParams);

if (count($results->getItems()) == 0) {
    foreach($cal_event as $ccc_eee){
        $event1 = new Google_Service_Calendar_Event($ccc_eee);
        $event2 = $service->events->insert($calendarId, $event1);
    ?>
        <script>
            toastr.info("<?php echo $event2->htmlLink;?>",'Event created');
        </script>
    <?php
    }
} else {
    foreach($cal_event as $ccc_eee){
    $count_x=0;
    foreach ($results->getItems() as $event) {
      if($event->getId() == $ccc_eee['id']){
        $count_x++;
      }
    }
      if($count_x == 0){
        $event3 = new Google_Service_Calendar_Event($ccc_eee);
        $event4 = $service->events->insert($calendarId, $event3);
    ?>
        <script>
            toastr.info("<?php echo $event4->htmlLink;?>",'Event Created');
        </script>
    <?php
    }else{
        $event3 = new Google_Service_Calendar_Event($ccc_eee);
        $event4 = $service->events->update($calendarId,$ccc_eee['id'],$event3);
        ?>
            <script>
                toastr.info("<?php echo $event4->htmlLink;?>",'Event Updated');
            </script>
        <?php
    }
  }
}
} else {
    $_SESSION['board_id']=$_GET['board_id'];
    $_SESSION['org_id']=$_GET['org_id'];
    $_SESSION['branch_id']=$_GET['branch_id'];
    $redirect_uri = URL_VIEW.'ShiftUsers/oauth2callback.php';
?>
<script>
    window.location="<?php echo filter_var($redirect_uri, FILTER_SANITIZE_URL);?>";
</script>
<?php }} ?>

<link href="<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet"/>
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Shift <small> Calendar</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container-fluid">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="#">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Shift Calendar</a>
            </li>
        </ul>

        <div class="row">
			<div class="col-md-3">
				<div class="portlet light">
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-12">
                                <div>
                                    <form action="" method="post">
                                        <button class="btn green" name="exportToGoogleCalendar" type="submit">Export to google calendar</button>
                                    </form>
                                    <hr>
                                     <!--<form action="" method="post">
                                        <button class="btn btn-xs green" name="exportToOutlookCalendar" type="submit">Export to outlook calendar</button>
                                    </form>-->
                                </div>
                                <div>
                                    <h3>Images Assigned</h3>
                                    <img src="<?php echo URL_VIEW."images/confirm.png";?>" alt="conform" style="height:18px;width:18px;"/>&nbsp;&nbsp;<span>Confirmed</span><br />
                                    <img src="<?php echo URL_VIEW."images/waiting.png";?>" alt="waiting" style="height:18px;width:18px;"/>&nbsp;&nbsp;<span>Waiting</span><br />
                                    <img src="<?php echo URL_VIEW."images/pendingimg.png";?>" alt="pending" style="height:18px;width:18px;"/>&nbsp;&nbsp;<span>Pending</span><br />
                                    <img src="<?php echo URL_VIEW."images/open.png";?>" alt="open" style="height:18px;width:18px;"/>&nbsp;&nbsp;<span>Open Shift</span>
                                </div>
                                <hr />
                                <div>
                                    <h3>Labels&nbsp;&nbsp;<small><small>per Organization</small></small></h3>
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
                                                echo '<ul style="padding:0px;"><li style="height: 20px;width: 20px;background-color:#'.$color.';display:inline-block;"></li><li style="display:inline-block;"><strong>&nbsp;&nbsp;'.$k1.'</strong></li></ul>';
                                                $count=dechex(hexdec($count)+111166);
                                           }
                                       }
                                    ?>
                                </div>
								<!-- END DRAGGABLE EVENTS PORTLET-->
							</div>
						</div>
						<!-- END CALENDAR PORTLET-->
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
    function loadCalender(){
    $.ajax({
        url:'<?php echo URL."ShiftUsers/myScheduleForCalender/".$user_id.".json";?>',
        datatype:'jsonp',
        beforeSend: function(){
            $('#loadingimage').show();
        },
        complete: function(){
            $('#loadingimage').hide();
        },
        success:function(data){
            var data2 = {};
            if(data.mySchedule != null){
                var data1=$.map(data.mySchedule,function(k,v){
                    return {
                        //title:k.title+"\n"+k.org.title,
                        title:"\n"+k.title,
                        start:k.start,
                        end:k.end,
                        borderColor:'black',
                        background_Color:$('#orgColor_'+k.org.id).val(),
                        textColor:'white',
                        stats:k.status,
                        orgname:k.org.title,
                        orgimgdir:k.org.img_dir,
                        orgimg:k.org.img,
                        shftUsrId:k.shiftUserId,
                        type:1
                    }
               });
            }else{
                var data1={};
            }
            $.ajax({
                url:'<?php echo URL."Opencalendarshifts/openScheduleForCalender/".$user_id.".json";?>',
                    datatype:'jsonp',
                    async:false,
                    success : function(data){
                        if(!($.isEmptyObject(data.result))){
                            data2=$.map(data.result,function(k,v){
                                return {
                                    //title:k.title+"\n"+k.org.title,
                                    title:"\n"+k.title,
                                    start:k.start,
                                    end:k.end,
                                    borderColor:'black',
                                    background_Color:$('#orgColor_'+k.org.id).val(),
                                    textColor:'white',
                                    stats:k.status,
                                    orgname:k.org.title,
                                    orgimgdir:k.org.img_dir,
                                    orgimg:k.org.img,
                                    openCalId:k.openCalId,
                                    type:0
                                }
                            });
                        }
                    }
                });
                data1 = $.merge(data1,data2);

               $('#calendar12').fullCalendar({
        			header: {
        				left: 'prev,next today',
        				center: 'title',
        				right: 'month,agendaWeek,agendaDay'
        			},
        			defaultDate: new Date(),
                    displayEventEnd:true,
        			//editable: true,
        			eventLimit: true, // allow "more" link when too many events
        			events: data1,
                    eventRender: function (event, element, view) {

                        var statImg;
                        if(event.stats==3){

                            statImg = '<?php echo URL_VIEW."images/confirm.png";?>';
                        } else if(event.stats==1){
                            statImg = '<?php echo URL_VIEW."images/waiting.png";?>';

                        } else if(event.stats==2){
                            statImg = '<?php echo URL_VIEW."images/pendingimg.png";?>';
                        } else if(event.stats==0){
                            statImg = '<?php echo URL_VIEW."images/open.png";?>';
                        }


                        element.find('.fc-content').remove();

                        element.closest('.fc-day-grid-event').css({'background-color':"rgb(230, 230, 230)", 'border':"none"});

                            var tempTitle;
                            if(event.title.length > 10) 
                                {
                                    tempTitle = event.title.substring(0,8) +"...";
                                }else
                                {
                                    tempTitle = event.title;
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
                            element.find('.calEventContent').attr('data-original-title', event.orgname);
                            element.find('.calEventContent').attr('data-placement',"left");
                            element.find('.calEventContent').attr('data-content',"<p><i>"+event.title+"</i></p>");



                    },
                    eventClick: function(calEvent, jsEvent, view) {
                        if(calEvent.type == 0){
                            bootbox.dialog({
                                title: "Response to Shift Requests",
                                message:'<div class="task-title row">'+
                                            '<div class="col-md-3">'+
                                                '<img style="height: 70px;width: 80px;" alt="logo" src="<?php echo URL;?>webroot/files/organization/logo/'+calEvent.orgimgdir+'/'+calEvent.orgimg+'">'+
                                            '</div>'+
                                            '<div class="col-md-9">'+
                                               '<h3>'+calEvent.orgname+'</h3>'+
                                               '<span>'+calEvent.title+'&nbsp;(<span>'+calEvent.start.format('hh:mm A')+'-'+calEvent.end.format('hh:mm A')+'</span>)</span><br>'+
                                               '<span>'+calEvent.start.format('DD MMMM YYYY')+'</span><br/>'+
                                           '</div>'+
                                        '</div>',
                                    buttons: {
                                    success: {
                                      label: "Accept",
                                      className: "btn-success",
                                      callback: function() {
                                        var res=responseopenShiftReq(calEvent.openCalId,<?php echo $user_id;?>);
                                      }
                                    },
                                    danger: {
                                      label: "Close",
                                      className: "btn-danger"
                                    }
                                  }
                            });
                        }else{
                        if(calEvent.stats==1 || calEvent.stats==0){
                            bootbox.dialog({
                                title: "Response to Shift Requests",
                                message:'<div class="task-title row">'+
                                            '<div class="col-md-3">'+
                                                '<img style="height: 70px;width: 80px;" alt="logo" src="<?php echo URL; ?>webroot/files/organization/logo/'+calEvent.orgimgdir+'/'+calEvent.orgimg+'">'+
                                            '</div>'+
                                            '<div class="col-md-9">'+
                                               '<h3>'+calEvent.orgname+'</h3>'+
                                               '<span>'+calEvent.title+'&nbsp;(<span>'+calEvent.start.format('hh:mm A')+'-'+calEvent.end.format('hh:mm A')+'</span>)</span><br>'+
                                               '<span>'+calEvent.start.format('DD MMMM YYYY')+'</span><br/>'+
                                           '</div>'+
                                        '</div>',
                                    buttons: {
                                    success: {
                                      label: "Accept",
                                      className: "btn-success",
                                      callback: function() {
                                        if(calEvent.stats == 0){
                                            var res=responseShiftReq(calEvent.shftUsrId,<?php echo $user_id;?>,2);
                                        }else if(calEvent.stats == 1){
                                            var res=responseShiftReq(calEvent.shftUsrId,<?php echo $user_id;?>,3);
                                        }
                                      }
                                    },
                                    danger: {
                                      label: "Reject",
                                      className: "btn-danger",
                                      callback: function() {
                                        if(calEvent.stats == 1){
                                            var res=responseShiftReq(calEvent.shftUsrId,<?php echo $user_id;?>,0);
                                        }
                                      }
                                    }
                                  }
                            });
                        }
                        }
                    },
                    eventMouseover:function( event, jsEvent, view ) { 
                        popoverActivete();                                                        
                        //toastr.info("<p>"+event.description +"</p><strong>"+ status+"</strong>","<strong><em>"+event.title+"</em></strong>");
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

    function responseShiftReq(shiftId,userId,type){
        $.ajax({
            url: "<?php echo URL;?>ShiftUsers/UserResponseFromCalender.json",
            data: "type="+type+"&shiftId="+shiftId+"&userId="+userId,
            type: "post",
            datatype:'jsonp',
            success:function(data){
                if(data.result==1){
                    toastr.success('Responded to Shift Request successfully','status');
                    $('#calendar12').fullCalendar( 'destroy' );
                    loadCalender();
                }else{
                    toastr.warning('Could not respond to Shift Request, Try after manual reloading of the page','status');
                }

            }
        });
    }
    
    function responseopenShiftReq(openCalId,userId){
        $.ajax({
            url: "<?php echo URL;?>Opencalendarshifts/UserResponseFromCalender.json",
            data: "openCalId="+openCalId+"&userId="+userId,
            type: "post",
            datatype:'jsonp',
            success:function(data){
                if(data.result==1){
                    toastr.success('Responded to Shift Request successfully','status');
                    $('#calendar12').fullCalendar( 'destroy' );
                    loadCalender();
                }else{
                    toastr.warning('Could not respond to Shift Request, Try after reloading the page','status');
                }
            }
        });
    }
</script>