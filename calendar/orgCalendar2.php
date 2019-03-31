<link href='<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href="<?=URL_VIEW;?>calendar/libs/scheduler.min.css" rel='stylesheet'/>

<script src='<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.js'></script>
<script src="<?=URL_VIEW;?>calendar/libs/scheduler.min.js"></script>
<?php
        $branches_url = URL."Branches/listBranchesName/".$orgId.".json";
        $branches = \Httpful\Request::get($branches_url)->send();
        
        $roles_url = URL."Organizationroles/organizationRoleList/".$orgId.".json";
        $roles = \Httpful\Request::get($roles_url)->send();
        
        $boards_url = URL."Boards/getAllOrganizationBoards/".$orgId.".json";
        $boards = \Httpful\Request::get($boards_url)->send();
?>
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Organisation <small> calendar</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container-fluid">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-circle"></i>
                <a href="<?=URL_VIEW;?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?=URL_VIEW."organizations/organizationProfile";?>">Organisation Management</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?=URL_VIEW."calendar/orgCalendar";?>">Assign Employee to shift</a>
            </li>
        </ul>
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-bar-chart theme-font hide"></i>
                                <span class="caption-subject theme-font bold uppercase">Branches</span>
                                <!-- <span class="caption-helper hide">weekly stats...</span> -->
                            </div>
                        </div>
                        <div class="portlet-body">
                                <div>
                                    <input type="checkbox" name="test" value="0" class="Calbranches1" checked="checked"/>
                                    <span>All</span>
                                </div>
                                <?php
                                    if(isset($branches->body->branches) && !empty($branches->body->branches)){
                                        foreach($branches->body->branches as $branch_id=>$branch_title){ ?>
                                 <div>
                                    <input type="checkbox" name="test" value="<?=$branch_id;?>" class="Calbranches" checked="checked"/>
                                    <span><?=$branch_title;?></span>
                                </div>           
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="icon-bar-chart theme-font hide"></i>
                                    <span class="caption-subject theme-font bold uppercase">Roles</span>
                                    <!-- <span class="caption-helper hide">weekly stats...</span> -->
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div>
                                    <input type="checkbox" name="test" value="0" class="Calroles1" checked="checked"/>
                                    <span>All</span>
                                </div>
                                 <?php
                                  //  echo"<pre>";print_R($roles);echo"</pre>";
                                    if(isset($roles->body->orgRoleList) && !empty($roles->body->orgRoleList)){
                                        foreach($roles->body->orgRoleList as $roles_id=>$roles_title){ ?>
                                 <div>
                                    <input type="checkbox" name="test" value="<?=$roles_id;?>" class="Calroles" checked="checked"/>
                                    <span><?=$roles_title;?></span>
                                </div>           
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="icon-bar-chart theme-font hide"></i>
                                    <span class="caption-subject theme-font bold uppercase">Departments</span>
                                    <!-- <span class="caption-helper hide">weekly stats...</span> -->
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div>
                                    <input type="checkbox" name="test" value="0" class="Calboards1" checked="checked"/>
                                    <span>All</span>
                                </div>
                                <?php
                                    //echo"<pre>";print_R($boards);echo"</pre>";
                                    if(isset($boards->body->boards) && !empty($boards->body->boards)){
                                        foreach($boards->body->boards as $boards_id=>$boards_title){ ?>
                                 <div>
                                    <input type="checkbox" name="test" value="<?=$boards_id;?>" class="Calboards" checked="checked"/>
                                    <span><?=$boards_title;?></span>
                                </div>           
                                <?php }} ?>
                            </div>
                        </div>
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="icon-bar-chart theme-font hide"></i>
                                    <span class="caption-subject theme-font bold uppercase">Shifts</span>
                                    <!-- <span class="caption-helper hide">weekly stats...</span> -->
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php 
                                $urlShifts = URL."Shifts/myOrganizationShift/".$orgId.".json";
                                $shifts12 = \Httpful\Request::get($urlShifts)->send();

                                if(!empty($shifts12->body->shifts)){
                                    foreach($shifts12->body->shifts as $shifts1){
                                        $shifts[$shifts1->Shift->id]=ucwords($shifts1->Shift->title);
                                    }
                                    $color=113311;
                                    foreach($shifts as $shft_id=>$shft_name){
                                        echo "<input type='hidden' id='".$shft_id."' value='#".$color."'/>";
                                        echo "<ul style='padding-left:0px;'><li style='display:inline-block;height:20px;width:20px;background-color:#".$color."'></li><li style='display:inline-block;'>&nbsp;".$shft_name."</li></ul>";
                                        $color=dechex(hexdec($color)+111166);
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="icon-bar-chart theme-font hide"></i>
                                    <span class="caption-subject theme-font bold uppercase">image assigned</span>
                                    <!-- <span class="caption-helper hide">weekly stats...</span> -->
                                </div>
                            </div>
                            <div class="portlet-body">
                                <ul><li style="display:inline-block"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/confirm.png";?>" /></li>&nbsp;Confirmed</ul>
                                <ul><li style="display:inline-block"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/waiting.png";?>" /></li>&nbsp;waiting</ul>
                                <ul><li style="display:inline-block"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/open.png";?>" /></li>&nbsp;Open</ul>
                                <ul><li style="display:inline-block"><img width="24px" height="24px" src="<?php echo URL_VIEW."images/pendingimg.png";?>" /></li>&nbsp;Pending</ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="portlet light">
                        <div class="portlet-body">
                            <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <img src="<?=URL_IMAGE;?>loading-x.gif" id="loadingimage" alt="loading, Please wait..."/>
                                <style>
                                    #loadingimage{
                                        display: block;
                                        margin-left: auto;
                                        margin-right: auto
                                    }
                                </style>
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

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    function saveShiftUser(shiftId,boardId,shift_date,userId,orgId){
        $.ajax({
            url: "<?php echo URL.'ShiftUsers/checkUserIfAvailable/'?>"+shiftId+"/"+boardId+"/"+shift_date+"/"+userId+"/"+orgId+".json",
            datatype:'jsonp',
            type : 'post',
            success:function(data){
                //console.log(data.status.status);
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
                    // console.log(copiedEventObject);
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

    function saveOpenShiftUser(orgId,boardId,shiftId,shiftDate,noEmp, resourceId)
    {
                $.ajax({
            url: "<?php echo URL.'Opencalendarshifts/saveOpenShifts/'?>"+orgId+"/"+boardId+"/"+shiftId+"/"+shiftDate+"/"+noEmp+".json",
            datatype:'jsonp',
            type : 'post',
            success:function(data){
                if(data.result == 1){
                    var copiedEventObject = {};
                    copiedEventObject.resourceId = resourceId;
                    copiedEventObject.shiftUserId = data.status.id;
                    copiedEventObject.shift_status = data.status.shift_status;
                    copiedEventObject.start = data.status.start;
                    // copiedEventObject.end = data.status.end;
                    copiedEventObject.userId = userId;
                    copiedEventObject.backgroundColor = $('#'+shiftId).val();
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
    function updateOpenShiftUser(id,boardId,shiftId,noEmp){
        $.ajax({
            url:"<?php echo URL.'Opencalendarshifts/updateOpenShifts1/'?>"+id+"/"+boardId+"/"+shiftId+"/"+noEmp+".json",
            datatype:'jsonp',
            success:function(data){
                if(data.result==1){
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(1);
                    toastr.info("Update success","success");
                }else{
                    toastr.warning("Cannot edit this time","Try again");
                }
            }
        });
    }
function show_board_shift(boardId){
    var shiftsOptn = "";
        $.ajax({
           url: "<?php echo URL_VIEW."process.php";?>",
           data: "action=getShifts&boardId="+boardId,
           type: "post",
           async:false,
           success:function(response) {
               var shifts = JSON.parse(response);
               if($.isEmptyObject(shifts)){
                   return 1;
               }else{
                   $.each(shifts,function(k,v){
                       shiftsOptn+='<option value="'+v['Shift']['id']+'">'+v['Shift']['title']+'</option>';
                   });
               }
           }
       });
       return shiftsOptn;
   }

   function ImageExist(url)
      {
        var img = new Image();
        img.src = url;
        return img.height != 0;
      }

function loadCalendar(loadTime) {       
    $.ajax({
        url:'<?php echo URL."ShiftUsers/getOrganizationShiftUsers/".$orgId.".json";?>',
        datatype:'jsonp',
        beforeSend: function(){
            $('#loadingimage').show();
        },
        complete: function(){
            $('#loadingimage').hide();
        },
        success:function(data){

            // console.log(data);
            if($.isEmptyObject(data.shftUsers)){
                var data1 = {};
            }else{
                var data1=$.map(data.shftUsers,function(k,v){
                    return {
                        title:k.shift.title,
                        start:k.start,
                        end:k.end,
                        backgroundColor:$('#'+k.shift.id).val(),
                        shiftUserId:k.id,
                        userId:k.user.id,
                        resourceId:k.user.id,
                        shift_status:k.status,
                        shiftId:k.shift.id,
                        boardId:k.board.id
                    }
                });
               }

               // console.log(data1);

               var data2 = {};
               $.ajax({
                  url :  '<?php echo URL."Opencalendarshifts/showOrgOpenCalendarShifts/".$orgId.".json";?>',
                  datatype:'jsonp',
                  async:false,
                  success:function(data){
                    // console.log(data);
                        if(!($.isEmptyObject(data.result))){
                            data2=$.map(data.result,function(k,v){
                                return {
                                    title:k.Shift.title,
                                    start:k.start,
                                    end:k.end,
                                    backgroundColor:$('#'+k.Shift.id).val(),
                                    openCalendarShiftId:k.openCShiftId,
                                    noEmp:k.openCShiftcount,
                                    assignedEmp:k.assignedcount,
                                    resourceId:'0',
                                    shift_status:'0',
                                    shiftId:k.Shift.id,
                                    boardId:k.Board.id
                                }
                            });
                        }
                  }
               });

                var data3 = {};

                $.ajax(
                    {
                        url:'<?php echo URL;?>Requesttimeoffs/getAllEmployeeLeaves/'+'<?php echo $orgId;?>'+'.json',
                        dataType:'jsonp',
                        type:'post',
                        async:false,
                        success:function(res)
                        {
                            // console.log(res);

                            if(res.status == 1){
                                data3 =$.map(res.list,function(k,v){
                                    return {
                                                title:k.title,
                                                start:k.start,
                                                // backgroundColor:"#FF2C2C",
                                                userId:k.user.id,
                                                resourceId:k.user.id,
                                                leaveStatus:1,
                                                allDay: false,
                                                  editable: false,
                                                  backgroundColor: '#FF2C2C',
                                                  borderColor: '#FF2C2C'
                                            }
                                });
                            }
                        }
                    });

                    // console.log(data3);
               data1 = $.merge(data1,data2);
               data1 = $.merge(data1, data3);
               // console.log(data1);
                var dataResource = [{'id':'0','title':'Open Shifts ... '}];
               $.ajax({
                        url: "<?php echo URL."OrganizationUsers/getAllOrganizationUser/".$orgId.".json";?>",
                        datatype: "jsonp",
                        async:false,
                        success:function(users)
                        {
                            if(!($.isEmptyObject(users.orgUsr)))
                            {
                                $.each(users.orgUsr,function(k,v)
                                    {
                                        if(loadTime == 1)
                                        {
                                            // console.log(v.User.imagepath);

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

                                            dataResource.push({title : v.User.fname + " " + v.User.lname,id : v.User.id, image:imgurl});
                                        }else
                                        {

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

                                            $(".Calbranches").each(function(){
                                                var th = $(this);
                                               if(th.is(":checked") && th.val() == v.OrganizationUser.branch_id){
                                                    dataResource.push({title : v.User.fname + " " + v.User.lname,id : v.User.id,image:imgurl});
                                                }
                                            });
                                            $(".Calroles").each(function(){
                                                var th1 = $(this);
                                                // console.log(v);
                                               if(th1.is(":checked") && th1.val()== v.OrganizationUser.organizationrole_id){
                                                    dataResource.push({title : v.User.fname + " " + v.User.lname,id : v.User.id,image:imgurl});
                                                }
                                            });  
                                            $(".Calboards").each(function()
                                            {
                                                   var th3 = $(this);
                                                   if(th3.is(":checked")){
                                                            $.ajax({
                                                                url: "<?php echo URL."BoardUsers/boardEmployeeList/";?>"+th3.val()+".json",
                                                                datatype: "jsonp",
                                                                async:false,
                                                                success:function(users) {
                                                                    if(!($.isEmptyObject(users.message))){
                                                                    $.each(users.message.employeeList,function(k,v){
                                                                        if(v.User.imagepath != ""){
                                                                              var imgurl = v.User.imagepath;
                                                                            }else{
                                                                              if(v.User.gender==0){
                                                                                var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/defaultuser.png";
                                                                              }else{
                                                                                var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/femaleadmin.png";
                                                                              }
                                                                            }
                                                                        dataResource.push({title : v.User.fname + " " + v.User.lname,id : v.User.id, image:imgurl});
                                                                    });
                                                            }
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                            }
                            // console.log(dataResource);
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
                left: 'title',
                right: 'prev,next, today, timelineDay,timelineWeek,timelineMonth'
            },
            defaultView: 'timelineMonth',
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

                var d = new Date(date);
                var a = d.toISOString().substring(0, 10);

                var leaveStatus = 0;

                $.each(view.options.events, function(k,v)
                    {
                        if(!isNaN(v))
                        {
                            console.log(v);
                            var b = new Date(v.start);
                            if(b.toISOString().substring(0, 10) == a && resource.id == v.resourceId)
                            {
                                leaveStatus = 1;
                            }
                        }
                    });

                if(leaveStatus !=1)
                {

                    if(new Date(date.format("YYYY-MM-DD")+"T24:00:00") < new Date()){
                        alert("Cannot assign Shift in past date");
                    }else{    
                      if(resource.id == 0){
                           var boardOptn = "<?php
                                            if(isset($boards->body->boards) && !empty($boards->body->boards)){
                                                foreach($boards->body->boards as $boards_id=>$boards_title){ 
                                                    echo "<option value=".$boards_id.">".$boards_title."</option>";
                                                }} ?>";
                           bootbox.dialog({
                               title: 'Assign Shift',
                               message: 'Select Department <select id="boardDateClick" class="form-control" required="required">'+boardOptn+'</select><br/><br/>Select Shift <select id="schedularTaskDateClick" class="form-control" required="required">'+shiftsOptn+'</select><br/><div id="shftErr"></div><br/>Input number of employee<input required="required" placeholder="No of Employee" id="empNoCal" type="number" class="form-control"/>',
                               buttons: {
                                   success: {
                                       label: "Confirm",
                                       className: "btn-info",
                                       callback: function() {
                                           saveOpenShiftUser(<?=$orgId;?>,$('#boardDateClick').val(),$('#schedularTaskDateClick').val(),date.format("YYYY-MM-DD"),$('#empNoCal').val(), resource.id);
                                       }
                                   }

                               }
                           });
                           var shiftsOptn = show_board_shift($('#boardDateClick').val());
                                if(shiftsOptn==1){
                                    $("#shftErr").html("No Shifts in this board");
                                }else{
                                     $("#shftErr").html(" ");
                                     $('#schedularTaskDateClick').html(shiftsOptn);
                                }
                           $('#boardDateClick').change(function(){
                                var shiftsOptn = show_board_shift($(this).val());
                                if(shiftsOptn==1){
                                    $("#shftErr").html("No Shifts in this board");
                                }else{
                                     $("#shftErr").html(" ");
                                     $('#schedularTaskDateClick').html(shiftsOptn);
                                }
                           });
                      }else{
                        var boardOptn1=<?=$boards;?>;
                        var boardOptn = "";
                        $.ajax({
                            url:"<?=URL."BoardUsers/getUserBoard/";?>"+resource.id+".json",
                            datatype:"jsonp",
                            async:false,
                            success:function(data){
                                if(!$.isEmptyObject(data.Boards)){
                                    $.each(data.Boards,function(k,v){
                                        $.each(boardOptn1.boards,function(k1,v1){
                                             if(v.BoardUser.board_id == k1){
                                                boardOptn+="<option value="+k1+">"+v1+"</option>";
                                             }
                                        });
                                    });
                                }
                            }
                        });
                           bootbox.dialog({
                               title: 'Assign Shift',
                               message: 'Select Department <select id="boardDateClick" class="form-control" required="required">'+boardOptn+'</select><br/><br/>Select Shift <select id="schedularTaskDateClick" class="form-control">'+shiftsOptn+'</select><div id="shftErr"></div>',
                               buttons: {
                                   success: {
                                       label: "Confirm",
                                       className: "btn-info",
                                       callback: function() {
                                           saveShiftUser($('#schedularTaskDateClick').val(),$('#boardDateClick').val(),date.format("YYYY-MM-DD"),resource.id,<?=$orgId;?>);

                                       }
                                   }

                               }
                           });
                           var shiftsOptn = show_board_shift($('#boardDateClick').val());
                                if(shiftsOptn==1){
                                    $("#shftErr").html("No Shifts in this board");
                                    $('#schedularTaskDateClick').html("");
                                }else{
                                     $("#shftErr").html("");
                                     $('#schedularTaskDateClick').html(shiftsOptn);
                                }
                           $('#boardDateClick').change(function(){
                                var shiftsOptn = show_board_shift($(this).val());
                                if(shiftsOptn==1){
                                    $("#shftErr").html("No Shifts in this board");
                                    $('#schedularTaskDateClick').html("");
                                }else{
                                     $("#shftErr").html("");
                                     $('#schedularTaskDateClick').html(shiftsOptn);
                                }
                           });
                       }
                    }
                }
            },
            eventClick: function(calEvent, jsEvent, view) {

                if(calEvent.leaveStatus == 1)
                {

                }else
                {

                    if(calEvent.resourceId == 0){
                        var boardId = calEvent.boardId;
                        var boardOptns = <?=$boards;?>;
                        boardOptn = "";
                        $.each(boardOptns.boards,function(k,v){
                            if(k == boardId){
                                boardOptn+='<option value="'+k+'" selected="selected">'+v+'</option>';
                            }else{
                                boardOptn+='<option value="'+k+'">'+v+'</option>';
                            }
                        });
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
                                           message: 'Select Board <select class="boardEventClick form-control" required="required">'+boardOptn+'</select><br/><br/>Select Shift <select class="schedularTaskEventClick form-control" required="required">'+shiftsOptn+'</select><br/><br/>Number of employees to be assigned<input value="'+calEvent.noEmp+'" required="required" placeholder="No of Employee" id="empNoCal" type="number" class="form-control"/><br/><br/>Confirmed number of Employees<input type="text" class="form-control" disabled="disabled" value="'+calEvent.assignedEmp+'">',
                                           buttons: {
                                               success: {
                                                   label: "Confirm",
                                                   className: "btn-info",
                                                   callback: function() {
                                                       updateOpenShiftUser(calEvent.openCalendarShiftId,$(".boardEventClick").val(),$('.schedularTaskEventClick').val(),$('#empNoCal').val());
                                                   }
                                               }
            
                                           }
                                    });
                                    $('.boardEventClick').change(function(){
                                    var shiftsOptn = show_board_shift($(this).val());
                                    if(shiftsOptn==1){
                                        $(".schedularTaskEventClick").html("");
                                    }else{
                                         $('.schedularTaskEventClick').html(shiftsOptn);
                                    }
                               });
                               
                           }
                           });
                    }
                }

            },
            resourceRender: function(resourceObj, labelTds, bodyTds) {

                // console.log(labelTds);
                // console.log(resourceObj);
                var img = resourceObj.image;



                if(resourceObj.id != 0)
                {
                    labelTds.find(".fc-cell-content").append('<img class="calLabelImg" src="'+img+'" />');

                    labelTds.find(".fc-icon").hide();
                }
            },
            eventRender: function(event, element, view) {

                if(event.leaveStatus == 1)
                {
                    view.leaveStatus =1; 
                    event.editable = false;
                    $(element).closest(".fc-timeline-event").find('.fc-time').remove();
                }
                else
                {
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

                        // bootbox.alert(event.shift_status);
                    var tempTitle;
                    if(event.title.length > 10) 
                        {
                            tempTitle = event.title.substring(0,8) +"...";
                        }else
                        {
                            tempTitle = event.title;
                        }
                    $(element).closest(".fc-timeline-event").addClass("calendarEventBox");
                    $(element).closest(".fc-timeline-event").find('.fc-title').hide();
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
                }
            },
            
            eventMouseover:function( event, jsEvent, view ) { 
                
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
                        var boardId=event.boardId;
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
                        var boardId = event.boardId;
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
                        }

                        });
                    }
       });   
}

$(document).ready(function(){
   loadCalendar(1); 
});
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
    <script>
        $(document).ready(function(){
            $('.Calbranches1').click(function(){
                if($(this).is(":checked")){
                    $(".Calbranches").each(function(){
                        $(this).closest("span").addClass("checked");
                        $(this).attr("checked","checked");
                    });
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }else{
                    $(".Calbranches").each(function(){
                        $(this).closest("span").removeClass("checked");
                        $(this).removeAttr("checked");
                    });
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }
            });
            $(".Calbranches").click(function(){
                if($(this).is(":checked")){
                    $(this).closest("span").addClass("checked");
                    $(this).attr("checked","checked");
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }else if($(".Calbranches1").is(":checked")){
                    $(".Calbranches1").closest("span").removeClass("checked");
                    $(".Calbranches1").removeAttr("checked");
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }else{
                    $(this).closest("span").removeClass("checked");
                    $(this).removeAttr("checked");
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }
            });
            
            $('.Calroles1').click(function(){
                if($(this).is(":checked")){
                    $(".Calroles").each(function(){
                        $(this).closest("span").addClass("checked");
                        $(this).attr("checked","checked");
                    });
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }else{
                    $(".Calroles").each(function(){
                        $(this).closest("span").removeClass("checked");
                        $(this).removeAttr("checked");
                    });
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }
            });
            $(".Calroles").click(function(){
                if($(this).is(":checked")){
                    $(this).closest("span").addClass("checked");
                    $(this).attr("checked","checked");
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }else if($(".Calroles1").is(":checked")){
                    $(".Calroles1").closest("span").removeClass("checked");
                    $(".Calroles1").removeAttr("checked");
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }else{
                    $(this).closest("span").removeClass("checked");
                    $(this).removeAttr("checked");
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }
            });
            
            $('.Calboards1').click(function(){
                if($(this).is(":checked")){
                    $(".Calboards").each(function(){
                        $(this).closest("span").addClass("checked");
                        $(this).attr("checked","checked");
                    });
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }else{
                    $(".Calboards").each(function(){
                        $(this).closest("span").removeClass("checked");
                        $(this).removeAttr("checked");
                    });
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }
            });
            $(".Calboards").click(function(){
                if($(this).is(":checked")){
                    $(this).closest("span").addClass("checked");
                    $(this).attr("checked","checked");
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }else if($(".Calroles1").is(":checked")){
                    $(".Calboards1").closest("span").removeClass("checked");
                    $(".Calboards1").removeAttr("checked");
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }else{
                    $(this).closest("span").removeClass("checked");
                    $(this).removeAttr("checked");
                    $('#calendar123').fullCalendar('destroy');
                    loadCalendar(2);
                }
            });
        });
    </script>