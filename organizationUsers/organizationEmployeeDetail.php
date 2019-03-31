<?php


$orgId = $_GET['org_id'];
$userId = $_GET['user_id'];


$url = URL ."Vaccinations/view/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$vaccination = $data->body;

$url = URL ."Liscenses/view/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
if(isset($data->body->Liscense)){
   $liscenses = $data->body->Liscense; 
}



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


$url = URL . "OrganizationUsers/organizationEmployeeDetail/".$orgId."/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$orgEmployee = $data->body->employee;
// echo "<pre>";
// print_r($orgEmployee);

$url = URL . "OrganizationUsers/getUserBranchesInOrgs/".$orgId."/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$employeeBranches = $data->body->employeeBranches;
// fal($employeeBranches);


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

<link href="<?php echo URL_VIEW;?>js/bootstrap-star-rating/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo URL_VIEW;?>js/bootstrap-star-rating/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />

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
                <div class="col-md-12 portlet light" style="padding:0px;">
                    <div class="col-md-3 col-sm-3 col-xs-3 sidebarKs">
                        <div class="userLi @new" id="empProfName">
                            <?php
                            $userimage = URL.'webroot/files/user/image/'.$orgEmployee->User->image_dir.'/thumb2_'.$orgEmployee->User->image;
                            $image = $orgEmployee->User->image;
                            $gender = $orgEmployee->User->gender;
                            $user_image = imageGenerate($userimage,$image,$gender);
                        ?>
                                <img id="empImage" src="<?php echo $user_image; ?>" alt="image"><span><?php echo $orgEmployee->User->fname." ".$orgEmployee->User->lname;?></span>
                        </div>
                        <ul class="navUl @new" id="editTavNav">
                            <li class="active">
                                <a href="#tab_6_1" data-toggle="tab">
                                EMPLOYEE DETAILS  </a>
                            </li>
                            <li>
                                <a href="#tab_6_2" data-toggle="tab">
                                 LOCATIONS / POSITIONS</a>
                            </li>
                            <li>
                                <a href="#tab_6_3" data-toggle="tab">
                                PAYROLL / WAGE / REVIEW </a>
                            </li>
                            <li>
                                <a href="#tab_6_4" data-toggle="tab">
                                LOG / NOTES </a>
                            </li>
                            <li>
                                <a href="#tab_6_5" data-toggle="tab">Shift History</a>
                            </li>
                            <li>
                                <a href="#tab_6_6" data-toggle="tab">Other Details</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <form action="" method="POST" accept-charset="UTF-8">
                                <input type="hidden" name="data[OrganizationUser][id]" value="<?php echo $orgEmployee->OrganizationUser->id;?>">
                                <input type="hidden" name="data[User][id]" value="<?php echo $userId;?>">
                        <div class="tab-content editEmpProf">

                            <div class="tab-pane active" id="tab_6_1">
                                <div class="row">
                                    <div class="right-container-top @new" style="padding-bottom:12px;">
                                        <strong>Employee Details</strong>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <br/>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="firstname">FIRST NAME</label>
                                                    <input disabled type="firstname" value="<?php echo $orgEmployee->User->fname;?>" name="data[User][fname]" class="form-control editFormControl @new" id="firstname">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="lastname">LAST NAME</label>
                                                    <input disabled name="data[User][lname]" type="lastname" value="<?php echo $orgEmployee->User->lname;?>" class="form-control editFormControl @new" id="lastname" >
                                                </div>
                                            </div>
                                            <br/>
                                            <label for="Emailaddress">EMAIL ADDRESS</label>
                                            <input disabled name="data[User][email]" value="<?php echo $orgEmployee->User->email;?>" type="Emailaddress" class="form-control editFormControl @new" id="Emailaddress" >

                                            <br/>
        
                                            <label for="mobilenumber">MOBILE NUMBER</label>
                                                <input disabled name="data[User][phone]" value="<?php echo $orgEmployee->User->phone;?>" type="mobilenumber" class="form-control editFormControl @new" id="mobilenumber" >
                                        </div>

                                        <div class="col-md-6">
                                            <br/>
                                            <div class="profileimage" style="text-align:centre; float:none;">
                                                <?php
                                                        $userimage = URL.'webroot/files/user/image/'.$orgEmployee->User->image_dir.'/thumb2_'.$orgEmployee->User->image;
                                                        $image = $orgEmployee->User->image;
                                                        $gender = $orgEmployee->User->gender;
                                                        $user_image = imageGenerate($userimage,$image,$gender);
                                                    ?>
                                                <img src="<?php echo $user_image;?>" id="empProfImage" alt="image" height=157px width=157px>
                                            </div>
                                            <br/>
                                            <div class="changeBtn">
                                                <label for="lastname">Ratings</label>
                                                <input id="empRating" type="number" style="display:none;" class="rating" min="0" max="10" step="1" data-size="xs" data-OrgId="<?php echo $orgId; ?>" data-UserId="<?php echo $orgEmployee->User->id; ?>" value="<?php echo $orgEmployee->User->Rating[0]->ratings; ?>">
                                                <button id="updEmpRatingBtn" class="btn btn-xs green">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                            <div class="row topGroup">
                                                <div class="col-md-6">
                                                    
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
                            <div class="tab-pane fade" id="tab_6_2">
                                <div class="right-container-top @new" style="padding-bottom:12px;">
                                        <strong>Positions</strong>
                                    </div>
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
                                                            <?php  
                                                            if(isset($boardIdArr) && !empty($boardIdArr))
                                                            {

                                                            $boardIdArr = implode(',', $boardIdArr);
                                                            }
                                                            ?>
                                                            <input type="hidden" name="data[boardIds]" multiple value="<?php echo $boardIdArr;?>" />
                                                            <div class="form-group">
                                                                    <button type="button" class="btn default pull-right">CLEAR</button>
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
                                                                    <button type="button" class="btn default pull-right">CLEAR</button>
                                                                    <button type="button" class="btn default pull-right all-clr">ALL</button>
                                                            </div>


                                                </div>
                                                

                                        </div>

                                        <hr class="lineBreak">
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="tab_6_3">
                                <div class="right-container-top @new" style="padding-bottom:12px;">
                                    <strong>Payroll / Wages</strong>
                                </div>
                                <div class="col-md-12">
                                    <?php if (count($employeeBranches) >1): ?>
                                        <?php foreach ($employeeBranches as $employeeBranch): ?>
                                            <div class="row topGroup">
                                                <div class="col-md-4 verticalLine">
                                                    <div class="form-group">
                                                        <label for="hourRate">BASE HOURLY RATE</label>
                                                        <input class="baseHour" disabled name="data[OrganizationUser][wage]" value="<?php echo $employeeBranch->OrganizationUser->wage;?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-8 padZero">

                                                                <label  for="hourRate">MAX HOURS / WEEKS</label>
                                                        </div>
                                                            <input disabled class="col-md-4" value="<?php echo $employeeBranch->OrganizationUser->max_weekly_hour;?>" name="data[OrganizationUser][max_weekly_hour]">
                                                        <!-- <div class="col-md-8 padZero">
                                                                <div class="exempt">
                                                                <input type="checkbox" name="my-checkbox">
                                                                EMPLOYEE IS EXEMPT 
                                                                <span class="questionMark"><i class="fa fa-question-circle"></i></span>
                                                                </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                            <label for="hourRate">Branch</label>
                                                            <input disabled class="baseHour text-capitalize" value="<?php echo $employeeBranch->Branch->title; ?>">
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-4">

                                                    <input disabled class="hourlyCleaning" value="<?php echo $employeeBranch->OrganizationUser->max_weekly_hour; ?>">
                                                </div> -->
                                            </div>
                                            <hr>

                                        <?php endforeach ?>
                                    <?php else: ?>
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
                                        </div>
                                    <?php endif ?>
                                        
                                    <div class="row topGroup">
                                        <div class="col-md-4 verticalLine">
                                            <br/>
                                           
                                            <label for="Emailaddress">REVIEW PERIOD</label>
                                            <input class="form-control" type="number" value="<?php echo $orgEmployee->OrganizationUser->reviewperiod;?>" name="data[OrganizationUser][reviewperiod]">

                                            <br/>
        
                                            
                                        <select class="form-control" name="data[OrganizationUser][reviewtype]">
                                            
                                                <option value="Weeks" <?php if($orgEmployee->OrganizationUser->reviewtype == "Weeks")  echo 'selected'; ?> >Weeks</option>
                                                <option value="Months" <?php if($orgEmployee->OrganizationUser->reviewtype == "Months")  echo 'selected'; ?> >Months</option>
                                                <option value="Years" <?php if($orgEmployee->OrganizationUser->reviewtype == "Years")  echo 'selected'; ?>>Years</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <hr class="lineBreak">
                            </div>
                            <div class="tab-pane fade" id="tab_6_4">
                                <div class="right-container-top @new" style="padding-bottom:12px;">
                                        <strong>Log / Notes</strong>
                                    </div>
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

                            <div class="tab-pane fade" id="tab_6_5">
                                <div class="right-container-top @new" style="padding-bottom:12px;">
                                        <strong>Shift History</strong>
                                    </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="portlet-body">

                                            <div class="portlet light box">

                                                    <div class="collapse navbar-collapse navbar-ex1-collapse">  
                                                        <!-- <form id="dateForm" role="form" method="post" action="">
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
                                                        </form>  -->
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

                            <div class="tab-pane fade" id="tab_6_6">
                                <div class="right-container-top @new" style="padding-bottom:12px;">
                                        <strong>Other Details</strong>
                                    </div>
                                <div class="col-md-12">
                                    <br/>
                                    <?php if(isset($liscenses) && !empty($liscenses)) { ?>
                                    <div class="row liscense">
                                        
                                        <div class="col-md-4">
                                            <label for="firstname">LISCENSE NAME</label>
                                            <input disabled value="<?php echo $liscenses->type;?>" name="" class="form-control editFormControl @new" >
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="lastname">ISSUE DATE</label>
                                            <input disabled name=""  value="<?php echo $liscenses->issuedate;?>" class="form-control editFormControl @new" >
                                        </div>
                                        
                                        <?php
                                        $expiryDate = strtotime($liscenses->expirydate);
                                        $currentDate = strtotime(date('Y-m-d'));
                                        
                                        ?>
                                        <div class="col-md-4">
                                            <label for="lastname">EXPIRY DATE</label>
                                            <input disabled name="" style=" <?php if($currentDate > $expiryDate){ echo " background:#B74341 "; } ?> "  value="<?php echo $liscenses->expirydate;?>" class="form-control editFormControl @new">
                                        </div>
                                    
                                    </div>
                                    <hr>
                                    <?php } ?>
                                    <?php if(isset($vaccination) && !empty($vaccination)){  ?>
                                    <?php foreach($vaccination as $v){ ?>
                                    
                                    <div class="row vaccination">
                                        
                                        <div class="col-md-4">
                                            <label for="firstname">VACCINATION NAME</label>
                                            <input disabled value="<?php echo $v->Vaccination->type;?>" name="" class="form-control editFormControl @new" >
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="lastname">DATE</label>
                                            <input disabled name=""  value="<?php echo $v->Vaccination->date;?>" class="form-control editFormControl @new" >
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label for="lastname">STATUS</label>
                                            <input disabled name=""  value="<?php echo $v->Vaccination->status;?>" class="form-control editFormControl @new">
                                        </div>
                                    
                                    </div>
                                    <br/>

                                    <?php } } ?>
                                    

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
                        </div>
                    </form>
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



<script src="<?php echo URL_VIEW;?>js/bootstrap-star-rating/js/star-rating.min.js" type="text/javascript"></script>
<!-- optionally if you need translation for your language then include locale file as mentioned below -->
<script src="<?php echo URL_VIEW;?>js/bootstrap-star-rating/js/star-rating_locale_<lang>.js"></script>

<script>
jQuery(document).ready(function() {

    FormiCheck.init(); // init page demo
    FormSamples.init();
   TableManaged.init();
   ComponentsPickers.init();

   // initialize with defaults
    $("#empRating").rating();

    // with plugin options
    $("#empRating").rating({'size':'xs'});
    $("#empRating").show();

   $(".select2Branch").select2();

   $('input[name="radio2"]').live('ifClicked', function (event) {
    $('input[name$="data[OrganizationUser][organizationrole_id]"]').val(this.value);
    });

});
</script>

<script>

    $("#updEmpRatingBtn").on('click', function(event)
    {
        event.preventDefault();

        var empRating = $("#empRating");
        var rating = empRating.val();
        var empId = empRating.attr('data-UserId');
        var orgId = empRating.attr('data-OrgId');

        var url = '<?php echo URL; ?>Ratings/updateEmpRatings/'+orgId+'/'+empId+'/'+rating+'.json';
        $.ajax(
            {
                url:url,
                type:'post',
                dataType:'jsonp',
                async:false,
                success:function(res)
                {
                    console.log(res);

                    if(res.status == 1)
                    {
                        toastr.success("Updated Successfully.");
                    }else
                    {
                        toastr.warning('Something went wrong, please try again.');
                    }
                }
            });
    });
    
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