<?php


$orgId = $_GET['org_id'];
$userId = $_GET['user_id'];

if(isset($_POST['editEmployeeSubmit']))
    {
        // fal($_POST);
        $url = URL . "OrganizationUsers/editEmployeeByOrg.json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
        // fal($response);


    }


$url = URL . "OrganizationUsers/organizationEmployeeDetail/".$orgId."/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$orgEmployee = $data->body->employee;
// echo "<pre>";
// print_r($orgEmployee);


$url = URL ."Boards/getBoardListOfBranch/".$orgEmployee->Branch->id.".json";
$data = \Httpful\Request::get($url)->send();
$boardList = $data->body->boardList;
// fal($boardList);


$url = URL ."BoardUsers/getRelatedBoardOfUser/".$userId.".json";
$data = \Httpful\Request::get($url)->send();

if(isset($data->body->boardIds) && !empty($data->body->boardIds))
{

$boardIds = $data->body->boardIds;
// fal($boardIds);
}


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
<link href="<?php echo URL_VIEW; ?>global/plugins/icheck/skins/all.css" rel="stylesheet"/>

<div class="page-container">
    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <div class="container">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Employee Detail <small> View Employee Detail</small></h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
    </div>
    <!-- END PAGE HEAD -->
    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="container">
            <!-- BEGIN PAGE BREADCRUMB -->
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
            <!-- END PAGE BREADCRUMB -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="row">
                <div class="col-md-12 portlet light">
                    <div class="col-md-3 col-sm-3 col-xs-3 sidebarKs">
                        <div class="userLi @new" id="empProfName">
                                <img id="empImage" src="<?php echo URL_VIEW;?>images/a.png" alt="image"><span><?php echo $orgEmployee->User->fname." ".$orgEmployee->User->lname;?></span>
                        </div>
                        <ul class="navUl @new" id="editTavNav">
                            <li class="active">
                                <a href="#tab_7_1" data-toggle="tab">
                                EMPLOYEE DETAILS  </a>
                            </li>
                            <li>
                                <a href="#tab_7_2" data-toggle="tab">
                                 LOCATIONS / POSITIONS</a>
                            </li>
                            <li>
                                <a href="#tab_7_3" data-toggle="tab">
                                PAYROLL / WAGE </a>
                            </li>
                            <li>
                                <a href="#tab_7_4" data-toggle="tab">
                                LOG / NOTES </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <div class="tab-content editEmpProf">
                            <form action="" method="POST" accept-charset="UTF-8">
                                <input type="hidden" name="data[OrganizationUser][id]" value="<?php echo $orgEmployee->OrganizationUser->id;?>">
                                <input type="hidden" name="data[User][id]" value="<?php echo $userId;?>">
                                <div class="row">
                                    <div class="right-container-top @new">
                                        <strong>Edit Employee</strong>
                                    </div>
                                </div>
                                <div class="tab-pane active" id="tab_7_1">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="form-group topGroup">
                                                    <div class="col-md-3">
                                                        <label for="firstname">FIRST NAME</label>
                                                        <input disabled type="firstname" value="<?php echo $orgEmployee->User->fname;?>" name="data[User][fname]" class="form-control @new" id="firstname">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="lastname">LAST NAME</label>
                                                        <input disabled name="data[User][lname]" type="lastname" value="<?php echo $orgEmployee->User->lname;?>" class="form-control @new" id="lastname" >
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="profileimage">
                                                            <img src="<?php echo URL_VIEW;?>images/a.png" id="empProfImage" alt="image" height=70px width=70px>
                                                        </div>
                                                        <div class="profile">
                                                            PROFILE PICTURE<br>
                                                            <!-- Maximum size 500kb,png,jpg.<br> -->
                                                        </div>
                                                        <!-- <div class="changeBtn">
                                                            <button type="button" class="btn btn-sm btn-success">change</button>
                                                        </div> -->
                                                        </div>
                                                    </div>
                                            </div>

                                            <div class="row topGroup">
                                                <div class="col-md-6">
                                                    <label for="Emailaddress">EMAIL ADDRESS</label>
                                                    <input disabled name="data[User][email]" value="<?php echo $orgEmployee->User->email;?>" type="Emailaddress" class="form-control @new" id="Emailaddress" >
                                                </div>
                                                    <div class="col-md-6">
                                                        <label for="mobilenumber">MOBILE NUMBER</label>
                                                        <input disabled name="data[User][phone]" value="<?php echo $orgEmployee->User->phone;?>" type="mobilenumber" class="form-control @new" id="mobilenumber" >
                                                    </div>
                                            </div>

                                            <hr class="lineBreak">
                                            <!-- Bottom Row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- <div class="form-group">
                                                        <div class="time">
                                                            <input type="checkbox" name="my-checkbox">
                                                            USE CUSTOM TIME ZONE<br>
                                                        </div>

                                                        <div class="btn-group">
                                                          <button type="button" class="btn btn-default timeDrop ">(GMT+11)Sydney</button>
                                                          <button type="button" class="btn btn-default dropdown-toggle timeDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                          </button>
                                                          <ul class="dropdown-menu">
                                                            <li><a href="#">Action</a></li>
                                                            <li><a href="#">Another action</a></li>
                                                            <li><a href="#">Something else here</a></li>
                                                            <li role="separator" class="divider"></li>
                                                            <li><a href="#">Separated link</a></li>
                                                          </ul>
                                                        </div>
                                                    </div> -->
                                                    <div class="form-group">
                                                        <label>ACCESS PRIVILEGES <a class="learnMore"href="#">Learn More</a></label>

                                                        <input type="hidden" value="<?php echo $orgEmployee->OrganizationUser->organizationrole_id;?>" name="data[OrganizationUser][organizationrole_id]">
                                                        <div class="input-group" id="editEmpRoleRadio">
                                                            <div class="icheck-inline">
                                                                <label>
                                                                <input type="radio" value="1" name="radio2" class="icheck" data-radio="iradio_flat-green" <?php echo (($orgEmployee->OrganizationUser->organizationrole_id==1)?"checked":"");?>> Manager </label>
                                                                <label>
                                                                <input type="radio" value="2" name="radio2" class="icheck" data-radio="iradio_flat-green" <?php echo (($orgEmployee->OrganizationUser->organizationrole_id==2)?"checked":"");?>> Supervisor </label>
                                                                <label>
                                                                <input type="radio" value="3" name="radio2" class="icheck" data-radio="iradio_flat-green" <?php echo (($orgEmployee->OrganizationUser->organizationrole_id==3)?"checked":"");?>> Employee </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                                <div style="margin-bottom: 9px;"><label for="employeeId">EMPLOYEE ID</label></div>
                                                            <div class="mid-empid">
                                                                <input disabled type="employeeId" class="form-control @new" id="employeeId" value="<?php echo $orgEmployee->User->id;?>">
                                                            </div>
                                                </div>
                                                    
                                            </div>
                                            
                                        </div>
                                </div>

                                <div class="tab-pane" id="tab_7_2">
                                    <div class="col-md-12">
                                        <div class="row topGroup">
                                            <div class="col-md-6 verticalLine">
                                                <label for="Positions">POSITIONS</label>
                                                <!-- <div class="btn-group "> -->
                                                            <!-- <div class="col-md-6 positionDrop"> -->
                                                            <div class="form-group">
                                                                <select name="data[BoardUser][][board_id]" id="selectDept" class="form-control select2Branch" multiple="multiple">
                                                                    <?php foreach ($boardList as $board):?>
                                                                        <?php if(in_array($board->Board->id, $boardIds)):?>
                                                                            <option selected value="<?php echo $board->Board->id;?>"><?php echo $board->Board->title;?></option>

                                                                            <?php $boardIdArr[] = $board->Board->id;?>
                                                                        <?php else:?>
                                                                            <option value="<?php echo $board->Board->id;?>"><?php echo $board->Board->title;?></option>
                                                                        <?php endif;?>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                            <?php  $boardIdArr = implode(',', $boardIdArr);?>
                                                            <input type="hidden" name="data[boardIds]" multiple value="<?php echo $boardIdArr;?>" />
                                                            <div class="form-group">
                                                                    <button type="submit" class="btn default pull-right">CLEAR</button>
                                                                    <button type="button" class="btn default pull-right all-clr">ALL</button>
                                                            </div>

                                                                

                                                        
                                                <!-- </div> -->
                                            </div>

                                                <div class="col-md-6 ">
                                                    <label for="Locations" class="locationText">LOCATIONS</label>
                                                
                                                            <div class="form-group">
                                                                <select class="form-control" disabled id="selectBranch" data-placeholder="Select...">
                                                                    <option value="<?php echo $orgEmployee->Branch->id;?>"><?php echo $orgEmployee->Branch->title;?></option>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                    <button type="submit" class="btn default pull-right">CLEAR</button>
                                                                    <button type="button" class="btn default pull-right all-clr">ALL</button>
                                                            </div>


                                                </div>
                                                

                                        </div>

                                        <hr class="lineBreak">
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_7_3">
                                    <div class="col-md-12">
                                        <div class="row topGroup">
                                            <div class="col-md-4 verticalLine">
                                                <div class="form-group">
                                                    <label for="hourRate">BASE HOURLY RATE</label>
                                                    <input class="baseHour" name="data[OrganizationUser][wage]" value="<?php echo $orgEmployee->OrganizationUser->wage;?>">
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-8 padZero">

                                                            <label  for="hourRate">MAX HOURS / WEEKS</label>
                                                    </div>
                                                        <input class="col-md-4" value="<?php echo $orgEmployee->OrganizationUser->max_weekly_hour;?>" name="data[OrganizationUser][max_weekly_hour]">
                                                    <div class="col-md-8 padZero">
                                                            <div class="exempt">
                                                            <input type="checkbox" name="my-checkbox">
                                                            EMPLOYEE IS EXEMPT 
                                                            <span class="questionMark"><i class="fa fa-question-circle"></i></span>
                                                            </div>
                                                    </div>
                                                    <!-- <div class="col-md-11 padZero">
                                                            <div class="exempt">
                                                            <input type="checkbox" name="my-checkbox">
                                                            DISABLE ATTENDENCE ALERTS & 
                                                            </div>
                                                            <span class="allow">
                                                            ALLOW TIMESHEET EDITING 
                                                            <span class="questionMark"><i class="fa fa-question-circle"></i></span>
                                                            </span>
                                                            
                                                    </div> -->
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-4">
                                                <div class="form-group">
                                                        <label for="hourRate">HOURLY RATE BY POSITION</label>
                                                        <input class="baseHour">
                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <input class="hourlyCleaning">
                                            </div> -->
                                        </div>
                                    </div>
                                        <hr class="lineBreak">
                                </div>

                                <div class="tab-pane" id="tab_7_4">
                                    <div class="col-md-12">
                                        <div class="row topGroup">
                                            <div class="col-md-12">
                                                <label>LOG / NOTES - <span class="visible"> Visible to only Managers and Supervisors </span></label>
                                                <textarea name="data[OrganizationUser][notes]" class="logInput"><?php echo $orgEmployee->OrganizationUser->notes;?></textarea>
                                            </div>
                                        </div>
                                        <hr class="lineBreak">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="foot">
                                        <div class="col-md-3">
                                            <div class="changeBtn">
                                                <button type="button" class="btn btn-danger">DELETE EMPLOYEE</button>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="saveEmployee">
                                                <div class="changeBtn">
                                                    <input type="submit" class="btn btn-success" name="editEmployeeSubmit" value="SAVE EMPLOYEE"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Bottom Row -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
    <!-- END PAGE CONTENT -->
</div>

<script src="<?php echo URL_VIEW; ?>global/plugins/icheck/icheck.min.js"></script>
<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/form-icheck.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/form-samples.js"></script>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script>
jQuery(document).ready(function() {

    FormiCheck.init(); // init page demo
    FormSamples.init();
   TableManaged.init();
   ComponentsPickers.init();

   $(".select2Branch").select2();

   $('input[name="radio2"]').live('ifClicked', function (event) {
    $('input[name$="data[OrganizationUser][organizationrole_id]"]').val(this.value);
    });

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