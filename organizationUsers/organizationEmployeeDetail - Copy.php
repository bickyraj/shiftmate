<?php


$orgId = $_GET['org_id'];
$userId = $_GET['user_id'];


$url = URL . "OrganizationUsers/organizationEmployeeDetail/".$orgId."/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$orgEmployee = $data->body->employee;
// echo "<pre>";
// print_r($orgEmployee);

$url = URL."UserGroups/findGroupOfUser/" . $userId . ".json";
$data = \Httpful\Request::get($url)->send();
$groups = $data->body;

$url = URL . "Organizationroles/orgRoleData/".$orgId.".json";
$orgRole = \Httpful\Request::get($url)->send();
$orgRoleLists = $orgRole->body->orgRole;
// echo "<pre>";
// print_r($orgRoleList);


$url = URL . "Branches/orgBranchList/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branchlist;
 // echo "<pre>";
 // print_r($branches);

$url = URL . "Groups/listGroup/".$orgId.".json";
$group = \Httpful\Request::get($url)->send();
$groupDatas = $group->body;
// echo "<pre>";
// print_r($groupData);

$url = URL . "OrganizationUsers/editUserData/".$userId."/".$orgId.".json";
$userData = \Httpful\Request::get($url)->send();
$orgUserData = $userData->body->orgUserData;
// echo "<pre>";
// print_r($orgUserData);
?>

<!-- Edit-->
<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Employee Detail <small> View Employee Detail</small></h1>
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
                    <a href="<?=URL_VIEW."organizationUsers/listOrganizationEmployees";?>">Employees</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="javascript:;">Employee Detail</a>
                </li>
            </ul>

 <div class="modal fade" id="portlet-config_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="editclose close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Create Departments</h4>
              </div>
              <div class="row">
              <div class="modal-body">
                  <form action="" id="editOrgUserForm" data-orgUser="<?php echo $orgUserData->OrganizationUser->id; ?>" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                    </div>
                    <div class="form-body">     
                        <div class="form-group">
                            <label class="control-label col-md-4">Branch <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <select class="form-control" name="data[OrganizationUser][branch_id]" id="BoardUserId" >
                                    
                                    <?php 
                                    if(isset($orgUserData->OrganizationUser->branch_id) && $orgUserData->OrganizationUser->branch_id != 0){
                                        ?>
                                      <option value="<?php echo $orgUserData->OrganizationUser->branch_id; ?>"><?php echo $orgUserData->Branch->title; ?></option>
                                    <?php }
                                    foreach($branches as $branch):

                                        if($branch->Branch->id != $orgUserData->OrganizationUser->branch_id){
                                        ?>
                                    <option value="<?php echo $branch->Branch->id;?>"><?php echo $branch->Branch->title; ?></option>
                                    <?php } endforeach;?>
                                </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-md-4">Group <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <select class="form-control" name="data[OrganizationUser][group_id]" id="BoardUserId" >
                                    
                                    <?php 
                                    if(isset($orgUserData->OrganizationUser->group_id) && $orgUserData->OrganizationUser->group_id != 0){
                                        ?>
                                      <option value="<?php echo $orgUserData->OrganizationUser->branch_id; ?>"><?php echo $orgUserData->Group->title; ?></option>
                                    <?php }
                                    foreach($groupDatas as $groupData):
                                        if($groupData->Group->id != $orgUserData->OrganizationUser->group_id){
                                        ?>
                                    <option value="<?php echo $groupData->Group->id;?>"><?php echo $groupData->Group->title; ?></option>
                                    <?php } endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Organization Role <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <select class="form-control" name="data[OrganizationUser][organizationrole_id]" id="BoardUserId" >
                                    
                                     <?php 
                                    if(isset($orgUserData->OrganizationUser->organizationrole_id) && $orgUserData->OrganizationUser->organizationrole_id != 0){
                                        ?>
                                      <option value="<?php echo $orgUserData->OrganizationUser->organizationrole_id; ?>"><?php echo $orgUserData->Organizationrole->title; ?></option>
                                    <?php }
                                    foreach($orgRoleLists as $orgRoleList):
                                        if($orgRoleList->Organizationrole->id != $orgUserData->OrganizationUser->organizationrole_id){
                                        ?>
                                    <option value="<?php echo $orgRoleList->Organizationrole->id;?>"><?php echo $orgRoleList->Organizationrole->title; ?></option>
                                    <?php } endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Designation<span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="data[OrganizationUser][designation]" value="<?php echo $orgUserData->OrganizationUser->designation; ?>" required />
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-4">Wage<span class="required">
                                * </span>
                                </label>
                                 <div class="col-md-7">
                                <input class="form-control" type="text" name="data[OrganizationUser][wage]" value="<?php echo $orgUserData->OrganizationUser->wage; ?>" required />
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-4">Working Hour<span class="required">
                                * </span>
                                </label>
                                 <div class="col-md-7">
                                <input class="form-control" type="text" name="data[OrganizationUser][max_weekly_hour]" value="<?php echo $orgUserData->OrganizationUser->max_weekly_hour; ?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                            <label class="control-label col-md-4">Employee Status<span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <select class="form-control" name="data[OrganizationUser][employee_status]" id="BoardUserId" >
                                      <option <?php if ($orgUserData->OrganizationUser->employee_status == 1 ) echo 'selected' ; ?> value="1">Permanent</option>
                                        <option <?php if ($orgUserData->OrganizationUser->employee_status == 0 ) echo 'selected' ; ?> value="0">Temporary</option>
                                    
                                </select>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <input  type="submit" name="submit" value="Update" class="btn green"/>
                                   
                                    <input type="reset" class="editclear btn default" value="Clear">
                                </div>
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
<div class="profile-content">
<div class="row">
   <div class="col-md-6 col-sm-12">
        <div class="portlet green box">
            <div class="portlet-title">
                <div class="caption uppercase">
                    <i class="glyphicon glyphicon-user"></i><?php echo $orgEmployee->User->fname." ".$orgEmployee->User->lname;?>  
                </div>
                <div class="btn-group pull-right">
                     <a class="btn btn-fit-height blue dropdown-toggle" href="#portlet-config_1" class="news-block-btn" data-toggle="modal" class="config"><i class="fa fa-pencil"></i></a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row static-info">
                    <div class="col-md-5 name">
                        <?php
                            $userimage = URL.'webroot/files/user/image/'.$orgEmployee->User->image_dir.'/thumb2_'.$orgEmployee->User->image;
                            $image = $orgEmployee->User->image;
                            $gender = $orgEmployee->User->gender;
                            $user_image = imageGenerate($userimage,$image,$gender);
                        ?>
                        <img src="<?php echo $user_image; ?>" width="100" height="100" alt="image not found"/>

                    </div>
                    
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                        <?php echo $orgEmployee->User->fname.' '.$orgEmployee->User->lname;?> 
                    </div> 
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Username:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->User->username;?>                   
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Designation
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->OrganizationUser->designation;?>                   
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Organization Branch:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->Branch->title;?>                   
                    </div>
                </div>

                   <div class="row static-info">
                    <div class="col-md-5 name">
                         Organization Group:
                    </div>
                    <div class="col-md-7 value">
                    <?php $count = 1; ?>
                  <?php foreach($groups as $group){

                    if($group->Group->organization_id == $orgId){ 
                    ?> 
                    
                         <span><?php echo $count.'.'.$group->Group->title;?></span>&nbsp; &nbsp;               
                    
                 <?php }$count++; } ?>    </div></div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Hired Date:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->OrganizationUser->hire_date;?>                  
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Wage:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->OrganizationUser->wage;?>                  
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         City:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->User->City->title;?>                  
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Country:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->User->Country->title;?>                  
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Skills:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->OrganizationUser->skills;?>                  
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- ***************************************************************************************** -->
<?php 
if(isset($_POST['submit_date'])){

        $url = URL."ShiftUsers/getOverTime/".$userId."/".$orgId."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
        $response = \Httpful\Request::get($url)->send();
        $url1 = URL."ShiftUsers/orgEmployeeDetails/".$userId."/".$orgId."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
        $response1 = \Httpful\Request::get($url1)->send();
    }else{

        $url = URL."ShiftUsers/getOverTime/".$userId."/".$orgId.".json";
        $response = \Httpful\Request::get($url)->send();
        $url1 = URL."ShiftUsers/orgEmployeeDetails/".$userId."/".$orgId.".json";
        $response1 = \Httpful\Request::get($url1)->send();
    }
        $total = $response->body;
        $allDetails = $response1->body;

        // echo "<pre>";
        // echo print_r($allDetails);
        // echo print_r($total);
        // die();
     ?>


     <!-- *************************************************************** -->


     <div class="col-md-6 col-sm-12">
        <div class="portlet green box">
            <div class="portlet-title">
                <div class="caption">
                    Shifts History  
                </div>
            </div>
            <div class="portlet-body">

                    <div class="portlet light box">
                       <!--  <div>
                            
                            <form id="dateRangeFrm" action=" " method="post">
                                    <input id="dateRangeStartDate" type="hidden" name="startDate">
                                    <input id="dateRangeEndDate" type="hidden" name="endDate">
                                    <input id="dateRangeFrmSubmit" type="submit" name="dateRangeFrmSubmit" hidden="">     

                                 </form>
                                <div class="page-toolbar">
                                    <form action="" method="post">
                                        <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm btn-default" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range" data-date-format="yyyy-mm-dd">
                                            <i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block">August 17, 2015 - September 15, 2015</span>&nbsp; <i class="fa fa-angle-down"></i>
                                        </div>
                                    </form>
                                </div>
                        </div> -->
                           <!--  <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase" style="float:right;">Shifts History</span>
                                </div>
                            </div> -->

                            <div class="collapse navbar-collapse navbar-ex1-collapse">  
                                <form id="dateForm" role="form" method="post" action="">
                                    <div class="form-group" stlye="float:right;">
                                             <label>Date Range</label>
                                             <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"  data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control" id="input_start" name="data[start_date]" required />
                                                <span class="input-group-addon">
                                                to </span>
                                                <input type="text" class="form-control" id="input_end" name="data[end_date]" required />
                                             </div> 
                                    </div><span>
                                        
                                    <div class="form-actions"> 
                                        <input type="submit" class="btn blue"  value="Submit" name="submit_date">
                                        
                                    </div></span> 
                                </form> 
                            </div>

                            <div class="portlet-title tabbable-line">
                                                
                                <ul class="nav nav-tabs">
                                                                
                                    <li class="active">
                                        <a href="#tab_1_4" data-toggle="tab" style="color:black;">
                                       <?php echo $orgEmployee->Branch->title;?>  </a>
                                    </li>
                               
                                </ul>   
                            </div>
                            <div class="portlet-body">
                                <!--BEGIN TABS-->
                                <div class="tab-content">
                                                                             
                                            <div class="tab-pane active" id="tab_1_4">
                                                <div class="table-scrollable table-scrollable-borderless">

                                                    <table class="table table-hover table-light">
                                                    
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                                    <div id="employeeShiftRecord" class="uppercase profile-stat-title" style="font-size:15px;">
                                                                         <?php echo $allDetails->number->totalShifts; ?>                                                                 </div>
                                                                    <div class="font-blue-madison bold uppercase">
                                                                         Total no of Shift
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                                    <div id="totalworkingRecord" class="uppercase profile-stat-title" style="font-size:15px;">
                                                                         <?php echo $allDetails->number->totalWorkingHours; ?>                                                                 </div>
                                                                    <div class="font-blue-madison bold uppercase">
                                                                         Working Hours
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-4 col-xs-6">
                                                                    <div id="totalOverTime" class="uppercase profile-stat-title" style="font-size:15px;">
                                                                        <?php echo gmdate("H:i:s",$total->output->totalOverTimeWorking); ?>                                                                   </div>
                                                                    <div class="font-blue-madison bold uppercase">
                                                                         Overtime hour
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <!-- <tr>
                                                            <td>
                                                                <span>Total no of Shift<i class="fa fa-img-up"></i></span><span style="float:right;">4  </span>
                                                            </td>
                                                        </tr> -->
                                                        <tr>
                                                            <td>
                                                                <span>Total Attendance<i class="fa fa-img-up"></i></span><span id="presentRecord" style="float:right;"><?php echo $allDetails->number->present; ?>   </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span>Absent Shifts<i class="fa fa-img-up"></i></span><span id="absentRecord" style="float:right;"><?php echo $allDetails->number->absent; ?> </span>
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>
                                                                <span>Late Checkin<i class="fa fa-img-up"></i></span><span id="totalNoOfLateCheckInRecord" style="float:right;"><?php echo $allDetails->number->totalNoOfLateCheckIn; ?> </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span>Early Checkout<i class="fa fa-img-up"></i></span><span id="earlyCheckOutRecord" style="float:right;"><?php echo $allDetails->number->earlyCheckOut; ?> </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span>Late Checkout<i class="fa fa-img-up"></i></span><span id="lateCheckRecord" style="float:right;"><?php echo $allDetails->number->lateCheck; ?> </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span>Total Late Checkin Hours<i class="fa fa-img-up"></i></span>
                                                                <span id="lateTime" style="float:right;"> 
                                                                    <?php echo gmdate("H:i:s",$total->output->totalLateCheckInTime); ?>                                                               </span>
                                                            </td>
                                                            

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span>Total Less To full Work Hours <i class="fa fa-img-up"></i></span>
                                                                <span id="lessWorkToFull" style="float:right;"> 
                                                                    <?php echo gmdate("H:i:s",$total->output->totalLessToFullWorkTime); ?>                                                              </span>
                                                            </td>
                                                            

                                                        </tr>
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                            </div>
                                             
                                       
                                         </div>
                                <!--END TABS-->
                            </div>
                        </div>
               
            </div>
        </div>
    </div>
     <!-- *************************************************************** -->


<!-- ***************************************************************************************** -->

 </div>
   
</div>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script>
jQuery(document).ready(function() {
   TableManaged.init();
   ComponentsPickers.init();

});
</script>

<script>

    $("#editOrgUserForm").on('submit',function(e){
        e.preventDefault();
        var data = $(this).serialize();
        var orgUserId = $(this).attr('data-orgUser');
        var orgId = '<?php echo $orgId; ?>';
        var ev = $(this);
       // console.log('<?php echo URL."OrganizationUsers/editOrgUser/"."'+orgUserId+'"."/"."'+orgId+'".".json"; ?>');
        $.ajax({
            url : '<?php echo URL."OrganizationUsers/editOrgUser/"."'+orgUserId+'"."/"."'+orgId+'".".json"; ?>',
            type : "post",
            data : data,
            datatype : "jsonp",
            success:function(response)
            {
                ev.find('.editclear').click();
                ev.find('.editclose').click();
                ev.closest('.modal-dialog').find('.editclose').click();
                window.location.reload(true);
                toastr.success('Record Updated Successfully');
                
            }
        });
    });
    $('applyBtn').attr('type',"submit");
    $("#dateForm").submit(function(event)
    {
        event.preventDefault();

        var d = $("#input_start").val();
        var e = $("#input_end").val();

        console.log(d);
        console.log(e);

        getEmployeeDetails();
        function getEmployeeDetails()
        {
            var userId = '<?php echo $userId;?>';
            var orgId = '<?php echo $orgId;?>';
            var url = '<?php echo URL."ShiftUsers/getOverTime/"."'+userId+'"."/"."'+orgId+'"."/"."'+d+'"."/"."'+e+'".".json";?>';
            var url1 = '<?php echo URL."ShiftUsers/orgEmployeeDetails/"."'+userId+'"."/"."'+orgId+'"."/"."'+d+'"."/"."'+e+'".".json";?>';
            var totalWorking=0;
            console.log(url);
            console.log(url1);
            $.ajax(
            {
                url:url,
                data:'post',
                datatype:'jsonp',
                success:function(response)
                {
                    console.log(response);

                    if(response){

                        totalLateTime = response.output.totalLateCheckInTime;
                        var finalTotalLateTime = secondsToHms(totalLateTime);
                        $("#lateTime").html(finalTotalLateTime);
                        //console.log(finalTotalLateTime);

                        lessToFullWork =response.output.totalLessToFullWorkTime;
                        var finalLessToFullWork = secondsToHms(lessToFullWork);
                        $("#lessWorkToFull").html(finalLessToFullWork);
                        console.log(finalLessToFullWork);


                        overTimeWork = response.output.totalOverTimeWorking;
                        var finalOverTimeWork = secondsToHms(overTimeWork);
                        $("#totalOverTime").html(finalOverTimeWork);
                        //console.log(finalOverTimeWork);    

                    }
                } 
            }



                );

            $.ajax({

                url : url1,
                data: 'post',
                datatype:'jsonp',
                success:function(response)
                {

                    console.log(response);

                    if(response){

                        totalAbsent = response.number.absent;
                        $("#absentRecord").html(totalAbsent);

                        totalEarlyCheckOut = response.number.earlyCheckOut;
                        $("#earlyCheckOutRecord").html(totalEarlyCheckOut);

                        totalLateCheck = response.number.lateCheck;
                        $("#lateCheckRecord").html(totalLateCheck);

                        totalPresent = response.number.present;
                        $("#presentRecord").html(totalPresent);

                        totalLateCheckIn = response.number.totalNoOfLateCheckIn;
                        $("#totalNoOfLateCheckInRecord").html(totalLateCheckIn); 

                        totalEmployeeShifts = response.number.totalShifts;
                        $("#employeeShiftRecord").html(totalEmployeeShifts);
 
                        var hms = response.number.totalWorkingHours;
                        var a = hms.split(':');
                        var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
                        totalWorking = totalWorking + seconds;
                        
                        var statsTotalworkingTime = secondsToHms(totalWorking);
                       $("#totalworkingRecord").html(statsTotalworkingTime);
                      // console.log(statsTotalworkingTime);
                    }
                }

            });




        }
    }


        );

function secondsToHms(d) {
        d = Number(d);
        var h = Math.floor(d / 3600);
        var m = Math.floor(d % 3600 / 60);
        var s = Math.floor(d % 3600 % 60);
        return ((h > 0 ? h + ":" + (m < 10 ? "0" : "") : "") + m + ":" + (s < 10 ? "0" : "") + s);
         }

</script>