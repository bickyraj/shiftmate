<link href='<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href="<?=URL_VIEW;?>calendar/libs/scheduler.min.css" rel='stylesheet'/>

<script src='<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.js'></script>
<script src="<?=URL_VIEW;?>calendar/libs/scheduler.min.js"></script>
<?php
$url = URL . "Useravailabilities/useravailabilityList/" . $userId . ".json";
$data = \Httpful\Request::get($url)->send();

$availabilities = $data->body->availabilities;
$availability_status = $data->body->availabilities_status;
?>
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>User Availability <small> user Availability</small></h1>
        </div>  
        	<div class="page-toolbar">
        <div class="btn-group pull-right" style="margin-top: 15px;">
            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                Actions <i class="fa fa-angle-down"></i>
            </button>
                <ul class="dropdown-menu pull-right" role="menu">
                	<?php if($availability_status == 1) { ?>
                    <li>
                        <a href="<?php echo URL_VIEW . 'useravailabilities/updateEmployeeAvailabilities?user_id='.$userId;?>">Edit Availability</a>
                    </li>
                    <?php
                    	}
                    	else
            			{
                    ?>
                    <li>
                        <a href="<?php echo URL_VIEW . 'useravailabilities/addEmployeeAvailabilities?user_id='.$userId;?>">Add Availability </a>
                    </li>
                    <?php } ?>
                </ul>
        </div>
    </div>
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
    			<a href="javascript:;">Availability</a>
    		</li>
        </ul>
 <div id="calendar123"></div>
 <script>
 $.ajax({
    url:"<?=URL."Useravailabilities/useravailabilityList/".$userId.".json";?>",
    datatype:"jsonp",
    beforeSend: function(){
        $('#loadingimage').show();
    },
    complete: function(){
        $('#loadingimage').hide();
    },
    success:function(data){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 
        if(data.availabilities_status==1){
            var data1=$.map(data.availabilities,function(k,v){
                if(k.data.status == 0){
                    return {
                        title:"",
                        allDay:true,
                        start:yyyy+"-"+mm+"-"+dd,
                        availibilityId:k.data.id,
                        userId:k.data.user_id,
                        backgroundColor :"blue",
                        status:k.data.status,
                        resourceId:k.data.day_id
                    }
                }else if(k.data.status == 1){
                    return {
                        title:"",
                        start:k.data.starttime,
                        end:k.data.endtime,
                        backgroundColor :"green",
                        availibilityId:k.data.id,
                        userId:k.data.user_id,
                        status:k.data.status,
                        resourceId:k.data.day_id
                    }
                }else if(k.data.status == 2){
                    return {
                        title:"",
                        allDay:true,
                        start:yyyy+"-"+mm+"-"+dd,
                        backgroundColor :"red",
                        availibilityId:k.data.id,
                        userId:k.data.user_id,
                        status:k.data.status,
                        resourceId:k.data.day_id
                    }
                }
                });
        }else{
            var data1={};
        }
         $('#calendar123').fullCalendar({
            schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
            editable: true,
            defaultDate:new Date(),
            droppable: true,
            aspectRatio: 3.0,
            scrollTime:new Date(),
            displayEventEnd:true,
            header: {
                center: 'title',
                right: 'timelineDay'
            },
            defaultView: 'timelineDay',
            resourceLabelText: 'Users',
            resources: [
                {id:1,title:"Sunday"},
                {id:2,title:"Monday"},
                {id:3,title:"Tuesday"},
                {id:4,title:"Wednesday"},
                {id:5,title:"Thursday"},
                {id:6,title:"Friday"},
                {id:7,title:"Saturday"}
            ],
            events: data1,
        });
    }
 });

 </script>