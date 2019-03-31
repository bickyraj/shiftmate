
<!-- *************************** Ashok Neupane ******************** -->
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/css/shiftmate-style.css"/>

<link href="<?php echo URL_VIEW; ?>global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<!-- END PAGE LEVEL STYLES -->
<?php

    if(isset($_POST['editEmployeeSubmit']))
    {
        // fal($_POST);
        $url = URL . "OrganizationUsers/editEmployeeByOrg.json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

    }
    if(isset($_POST['submitt'])){
        //fal($_POST);
       if(isset($_POST['data']['Permanentemploye']['day_id'])){
        $count1=0;
            foreach($_POST['data']['Permanentemploye']['day_id'] as $dayId=>$day){
                $_POST['data1']['Permanentemploye']['organization_user_id']=$_POST['data']['Permanentemploye']['organization_user_id'];
               $start_time=DateTime::createFromFormat('h:i A',$_POST['data']['Permanentemploye']['starttime']);
               $end_time=DateTime::createFromFormat('h:i A',$_POST['data']['Permanentemploye']['endtime']);
                $_POST['data1']['Permanentemploye']['starttime']=$start_time->format('H:i:s');
                $_POST['data1']['Permanentemploye']['endtime']=$end_time->format('H:i:s');
                $_POST['data1']['Permanentemploye']['day_id']=$dayId;
                
                if($dayId!=8){
                    $url = URL . "Permanentemployes/saveEmploye.json";
                    $response1 = \Httpful\Request::post($url)
                            ->sendsJson()
                            ->body($_POST['data1'])
                            ->send();
                            
                            
                    $count1++;
                } 
            } ?>
       <script> toastr.success('Employee was Successfully made permanent.');</script>
       <?php }else{ ?>
       <script> toastr.warning('Please select at least a day.');</script>
       <?php
       }
        
    }    
?> 

<!-- *************************** ******************** -->
<?php

if (isset($_GET['page1'])) {
    $page1 = $_GET['page1'];
} else {
    $page1 = 1;
}
$url1 = URL . "OrganizationUsers/getOrganizationUsers1/" . $orgId . "/" . $page1 ."/0.json";
$data1 = \Httpful\Request::get($url1)->send();
$addNewEmployeeByOrgs = $data1->body->result;
// echo "<pre>";
// print_r($addNewEmployeeByOrgs);
if (isset($_GET['page2'])) {
    $page2 = $_GET['page2'];
} else {
    $page2 = 1;
}
$url2 = URL . "OrganizationUsers/getOrganizationUsers1/" . $orgId . "/" . $page2 ."/1.json";
$data2 = \Httpful\Request::get($url2)->send();
$assignEmployees = $data2->body->result;

if (isset($_GET['page3'])) {
    $page3 = $_GET['page3'];
} else {
    $page3 = 1;
}
$url3 = URL . "OrganizationUsers/getOrganizationUsers1/" . $orgId . "/" . $page3 ."/2.json";
$data3 = \Httpful\Request::get($url3)->send();
$assignEmployeeByEmails = $data3->body->result;

if (isset($_GET['page4'])) {
    $page4 = $_GET['page4'];
} else {
    $page4 = 1;
}
$url4 = URL . "OrganizationUsers/getOrganizationUsers1/" . $orgId . "/" . $page4 ."/3.json";
$data4 = \Httpful\Request::get($url4)->send();
$activeEmployees = $data4->body->result;

if (isset($_GET['page5'])) {
    $page5 = $_GET['page5'];
} else {
    $page5 = 1;
}
$url5 = URL . "OrganizationUsers/getOrganizationUsers1/" . $orgId . "/" . $page5 ."/4.json";
$data5 = \Httpful\Request::get($url5)->send();
$employeeRemoves = $data5->body->result;


$path = URL . "Branches/orgBranches/".$orgId.".json";
$result = \Httpful\request::get($path)->send();
$branchesName = $result->body->branches;
// echo '<pre>';
// print_r($branchesName);
?>
<style>
.dropdownMenu:after,.dropdownMenu:before {
    left: 130px !important;
}
 
</style>
<!-- Employee Management List-->
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>Employee Management <small>View organisation employee list</small></h1>
		</div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-circle"></i>
                <a href="<?php echo URL_VIEW; ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?=URL_VIEW."organizationUsers/listOrganizationEmployees";?>">Employee Management</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="fa fa-users theme-font"></i>
                            <span class="caption-subject theme-font bold uppercase">Employee Lists</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-fit-height green dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                                Actions <i class="fa fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li>
                                    <a href="<?php echo URL_VIEW . 'employees/employeeRegistrationByOrg?org_id=' . $orgId; ?>" >
                                     <i class="fa fa-plus"></i> Add New Employee

                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo URL_VIEW;?>organizationUsers/assignEmployeeToOrganization?org_id=<?php echo $orgId;?>"><i class="fa fa-plus"></i> Add existing employee</a>
                                </li>
                                <li>
                                    <a href="<?php echo URL_VIEW;?>users/requestEmployeeToOrganization?org_id=<?php echo $orgId;?>"><i class="fa fa-send (alias)"></i> Send Request</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="portlet-body tabbable-line tabbable-full-width">
                        <ul class="nav nav-tabs activeTab">
                            <li data-status="3" class="<?php if (isset($_GET['page4']) || (!isset($_GET['page1']) && !isset($_GET['page2']) && !isset($_GET['page3']) && !isset($_GET['page5']))){echo "active";}?>">
                                <a href="#tab_2_1" data-toggle="tab">
                                Employee List </a>
                            </li>
                            <li data-status="0" class="<?php if (isset($_GET['page1']) || isset($_GET['page2']) || isset($_GET['page3'])){echo "active";}?>">
                                <a href="#tab_2_2" data-toggle="tab">
                                Employee Register </a>
                            </li>
                            <li data-status="4" class="<?php if(isset($_GET['page5'])){echo "active";}?>">
                                <a href="#tab_2_5" data-toggle="tab">
                                X-employee</a>
                            </li>
                                <div class="actions pull-right">
                                    <form id="searchForm" class="form-inline" role="form" action="" method="post">
                                        <span style="color:grey">Filter Employee :</span>
                                        <div class="form-group">
                                            <select name="branchId" class="form-control input-sm" id="select-branch">
                                                <option class="default" selected value="0">--All Branch--</option>

                                                <?php foreach($branchesName as $b): ?>
                                                <option value="<?php echo $b->Branch->id; ?>"><?php echo $b->Branch->title; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select name="departmentId" id="selectDepartment" class="form-control input-sm">
                                            <option class="default" selected value="0">--All Department--</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input id="username" name="username" value="" type="text" class="form-control input-sm" placeholder="Enter Employee Name" required>
                                        </div>
                                    </form>
                                </div>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade <?php if (isset($_GET['page4']) || (!isset($_GET['page1']) && !isset($_GET['page2']) && !isset($_GET['page3']) && !isset($_GET['page5']))){echo "active in";}?>" id="tab_2_1">
                                <!-- <table class="table table-striped table-bordered table-hover" id="test_1"> -->
                                <table class="table table-hover table-light table-striped" id="test_1">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Employee Name</th>
                                            <th>Designation</th>
                                            <th>Email</th>
                                            <th>Branch</th>
                                            <!-- <th>Address</th> -->
                                            <th>Contact</th>
                                            <th>Reviews</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tab-2-1">
                                        <?php if(!empty($activeEmployees)){
                                         foreach ($activeEmployees as $orgEmployee):
                                            $userimage = URL.'webroot/files/user/image/'.$orgEmployee->User->image_dir.'/thumb2_'.$orgEmployee->User->image;
                                            $image = $orgEmployee->User->image;
                                            $gender = $orgEmployee->User->gender;
                                            $userimage = imageGenerate($userimage,$image,$gender);
                                         ?>
                                        <tr>
                                            <td class="fit">
                                                <img class="user-pic" src="<?php echo $userimage;?>" style="width:40px;height:40px;">
                                            </td>
                                            <td>
                                                <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>" class="primary-link"><?php echo $orgEmployee->User->fname . ' ' . $orgEmployee->User->lname; ?>
                                                </a> 
                                            </td>
                                            <td><?php echo $orgEmployee->OrganizationUser->designation; ?></td>
                                            <td><?php echo $orgEmployee->User->email; ?></td>
                                            <td><?php echo (empty($orgEmployee->Branch->title))?"--":$orgEmployee->Branch->title; ?></td>
                                            <!-- <td><?php echo (empty($orgEmployee->User->address))?"--":$orgEmployee->User->address; ?></td> -->
                                            <td><?php echo (empty($orgEmployee->User->phone))?"--":$orgEmployee->User->phone; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-sm green dropdown-toggle" aria-expanded="false">Review&nbsp;<i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li role="presentation">
                                                            <a href="<?php echo URL_VIEW."reviews/newReview?user_id=".$orgEmployee->User->id."&rev_typ=Review";?>">
                                                            General Review
                                                            </a>
                                                        </li>
                                                        <li role="presentation">
                                                            <a href="<?php echo URL_VIEW."reviews/newReview?user_id=".$orgEmployee->User->id."&rev_typ=verbal_warning";?>">
                                                            Verbal Warning
                                                            </a>
                                                        </li>
                                                        <li role="presentation">
                                                            <a href="<?php echo URL_VIEW."reviews/newReview?user_id=".$orgEmployee->User->id."&rev_typ=written_warning";?>">
                                                            Written  Warning

                                                            </a>
                                                        </li>
                                                        <li role="presentation">
                                                            <a href="<?php echo URL_VIEW."reviews/newReview?user_id=".$orgEmployee->User->id."&rev_typ=Feedback";?>">
                                                            General Feedback
                                                            </a>
                                                        </li>
                                                        <li class="divider" role="presentation">
                                                        </li>
                                                        <li role="presentation">
                                                            <a href="<?php echo URL_VIEW."reviews/sentSpecificReviews?user_id=".$orgEmployee->User->id ; ?>">
                                                            History
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td style="width: 118px;">
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-sm blue dropdown-toggle" aria-expanded="false">Action&nbsp;<i class="fa fa-angle-down"></i>
                                                    </button>
                                                    <ul role="menu" class="dropdown-menu dropdownMenu" style="margin-left:-66px;" permanent-id = "<?php echo $orgEmployee->User->id;?>" organizationUser-id="<?php echo $orgEmployee->OrganizationUser->id; ?>" fname="<?php echo $orgEmployee->User->fname; ?>" lname="<?php echo $orgEmployee->User->lname; ?>" >
                                                        <li role="presentation">
                                                            <a class="make-permanent">Make Permanent</a>
                                                        </li>
                                                        <li role="presentation">
                                                            <a class="permanent-history">Permanent History</a>
                                                        </li>
                                                        <li role="presentation">
                                                            <a href="javascript:;" class="removeEmployee" id="<?php echo $orgEmployee->OrganizationUser->id; ?>">Remove</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="btn-group">
                                                    <a class="btn btn-sm green editEmpBtn" data-userId="<?php echo $orgEmployee->OrganizationUser->user_id;?>" data-toggle="modal"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    
                                        <div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modalOuter">
                                                <div class="modal-content modalCustom">
                                                    <div class="col-md-3 col-sm-3 col-xs-3 sidebarKs">
                                                        <div class="userLi @new" id="empProfName">
                                                                <img id="empImage" src="<?php echo URL_VIEW;?>images/a.png" alt="image"><span>Kevin ham</span>
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
                                                                <input type="hidden" name="data[boardIds]" multiple value="" />
                                                                <input type="hidden" name="data[OrganizationUser][id]" value="">
                                                                <input type="hidden" name="data[User][id]" value="">
                                                                <div class="row">
                                                                    <div class="right-container-top @new">
                                                                        <strong>Edit Employee</strong>
                                                                        <div class="btn @new closeBtn">
                                                                        <button type="button" class=" btn btn-default" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" style="color:#eeeeee"></span></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane active" id="tab_7_1">
                                                                        <div class="col-md-12">
                                                                            <div class="row">
                                                                                <div class="form-group topGroup">
                                                                                    <div class="col-md-3">
                                                                                        <label for="firstname">FIRST NAME</label>
                                                                                        <input disabled type="firstname" name="data[User][fname]" class="form-control @new" id="firstname">
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <label for="lastname">LAST NAME</label>
                                                                                        <input disabled name="data[User][lname]" type="lastname" class="form-control @new" id="lastname" >
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
                                                                                    <input disabled name="data[User][email]" type="Emailaddress" class="form-control @new" id="Emailaddress" >
                                                                                </div>
                                                                                    <div class="col-md-6">
                                                                                        <label for="mobilenumber">MOBILE NUMBER</label>
                                                                                        <input disabled name="data[User][phone]" type="mobilenumber" class="form-control @new" id="mobilenumber" >
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

                                                                                        <input type="hidden" value="" name="data[OrganizationUser][organizationrole_id]">
                                                                                        <div class="input-group" id="editEmpRoleRadio">
                                                                                            <div class="icheck-inline">
                                                                                                <label>
                                                                                                <input type="radio" name="radio2" class="icheck" data-radio="iradio_flat-green" checked> Manager </label>
                                                                                                <label>
                                                                                                <input type="radio" name="radio2" class="icheck" data-radio="iradio_flat-green"> Supervisor </label>
                                                                                                <label>
                                                                                                <input type="radio" name="radio2" class="icheck" data-radio="iradio_flat-green"> Employee </label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                                <div style="margin-bottom: 9px;"><label for="employeeId">EMPLOYEE ID</label></div>
                                                                                            <div class="mid-empid">
                                                                                                <input disabled type="employeeId" class="form-control @new" id="employeeId" >
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
                                                                                                <select name="data[BoardUser][][board_id]" id="selectDept" class="form-control select2Branch" multiple="multiple"></select>
                                                                                            </div>
                                                                                            
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
                                                                                    <input class="baseHour" name="data[OrganizationUser][wage]">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-8 padZero">

                                                                                            <label  for="hourRate">MAX HOURS / WEEKS</label>
                                                                                    </div>
                                                                                        <input class="col-md-4" name="data[OrganizationUser][max_weekly_hour]">
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
                                                                                <textarea name="data[OrganizationUser][notes]" class="logInput"></textarea>
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
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <?php endforeach;
                                            }else{ ?>
                                                <tr><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <hr>
                                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                    <?php
                                    $page=$data4->body->page;
                                    $max=$data4->body->maxPage;
                                    ?>
                                    <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                    <ul class="pagination" style="visibility: visible;">
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="First" href="?page4=1"><i class="fa fa-angle-double-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="Prev" href="?page4=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        
                                        <?php if($max<=5){
                                            for($i=1;$i<=$max;$i++){ ?>
                                            <li>
                                               <a title="<?=$i;?>" href="?page4=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                         <?php }}else{
                                            if(($page-2)>=1 && ($page+2)<=$max){
                                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page4=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                          <?php  }}elseif(($page-2)<1){
                                            for($i=1;$i<=5;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page4=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                         <?php }}elseif(($page+2)>$max){
                                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page4=<?=$i?>"><?=$i;?></a>
                                                </li>
                                        <?php }}} ?>
                                        
                                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                        <?php if($page>=$max){ ?>
                                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Next" href="?page4=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                        <?php } ?></li>
                                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                        <?php if($max==0 || $max==1){ ?>
                                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Last" href="?page4=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                        <?php } ?></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade <?php if(isset($_GET['page1']) || isset($_GET['page2']) || isset($_GET['page3'])){echo "active in";}?>" id="tab_2_2">
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <ul class="nav nav-tabs tabs-left">
                                            <li data-status="0" class="<?php if(isset($_GET['page1']) || (!isset($_GET['page2']) && !isset($_GET['page3']))){echo "active";}?>">
                                                <a href="#tab_6_1" data-toggle="tab">
                                                Employee Added By Organisation </a>
                                            </li>
                                            <li data-status="1" class="<?php if(isset($_GET['page2'])){echo "active";}?>">
                                                <a href="#tab_6_2" data-toggle="tab">
                                                Assign Employee By Organisation </a>
                                            </li>
                                            <li data-status="2" class="<?php if(isset($_GET['page3'])){echo "active";}?>">
                                                <a href="#tab_6_3" data-toggle="tab">
                                                Assign Employee By Email </a>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                        <div class="tab-content">
                                            <div class="tab-pane <?php if(isset($_GET['page1']) || (!isset($_GET['page2']) && !isset($_GET['page3']))){echo "active in";}?>" id="tab_6_1">
                                                <table class="table table-striped table-bordered table-hover" id="sadmple_2">
                                                    <thead>
                                                        <tr>
                                                           
                                                            <th>Email</th>
                                                            <th>Branch</th>
                                                            <th>Status</th>
                                                            <th>Activate Here</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody  id="tab-6-1-" style="display:none;">

                                                    </tbody>  
                                                    <tbody id="tab-6-1">

                                                        <?php 
                                                            if(!empty($addNewEmployeeByOrgs)){
                                                            foreach ($addNewEmployeeByOrgs as $addNewEmployeeByOrg) {  
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $addNewEmployeeByOrg->User->email; ?></td>
                                                                <td><?php echo $addNewEmployeeByOrg->Branch->title; ?></td>
                                                                <td>
                                                                    <?php if($addNewEmployeeByOrg->User->status == '1'){ ?>
                                                                        <span class="btn green-meadow">Active User</span>
                                                                    <?php } else { ?>
                                                                        <span class="btn red-sunglo">Inactive User</span>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="activateEmployeeByOrg btn green" id="<?php echo $addNewEmployeeByOrg->OrganizationUser->id; ?>">Activate Now</button>
                                                                </td>
                                                            </tr>
                                                        <?php }}else{ ?>
                                                            <tr><td colspan="4">No Record Found</td></tr>
                                                    </tbody>
                                                    <?php } ?>
                                                </table>
                                                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                                    <?php
                                                    $page=$data1->body->page;
                                                    $max=$data1->body->maxPage;
                                                    ?>
                                                    <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                                    <ul class="pagination" style="visibility: visible;">
                                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                                        <?php if($page<=1){ ?>
                                                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                                        <?php }else{ ?>
                                                            <a title="First" href="?page1=1"><i class="fa fa-angle-double-left"></i></a>
                                                        <?php } ?>
                                                        </li>
                                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                                        <?php if($page<=1){ ?>
                                                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                                        <?php }else{ ?>
                                                            <a title="Prev" href="?page1=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                                        <?php } ?>
                                                        </li>
                                                        
                                                        <?php if($max<=5){
                                                            for($i=1;$i<=$max;$i++){ ?>
                                                            <li>
                                                               <a title="<?=$i;?>" href="?page1=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                            </li>
                                                         <?php }}else{
                                                            if(($page-2)>=1 && ($page+2)<=$max){
                                                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                                <li>
                                                                   <a title="<?=$i;?>" href="?page1=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                                </li>
                                                          <?php  }}elseif(($page-2)<1){
                                                            for($i=1;$i<=5;$i++){ ?>
                                                                <li>
                                                                   <a title="<?=$i;?>" href="?page1=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                                </li>
                                                         <?php }}elseif(($page+2)>$max){
                                                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                                                <li>
                                                                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page1=<?=$i?>"><?=$i;?></a>
                                                                </li>
                                                        <?php }}} ?>
                                                        
                                                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                                        <?php if($page>=$max){ ?>
                                                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                                        <?php }else{ ?>
                                                        <a title="Next" href="?page1=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                                        <?php } ?></li>
                                                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                                        <?php if($max==0 || $max==1){ ?>
                                                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                                        <?php }else{ ?>
                                                        <a title="Last" href="?page1=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                                        <?php } ?></li>
                                                    </ul>
                                                </div>                                           
                                            </div>
                                            <div class="tab-pane <?php if(isset($_GET['page2'])){echo "active in";}?> fade" id="tab_6_2">
                                                <table class="table table-striped table-bordered table-hover" id="sampdle_3">
                                                    <thead>
                                                        <tr>
                                                           
                                                            <th>Email</th>
                                                            <th>Branch</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead> 
                                                    <tbody id="tab-6-2-" style="dispaly:none;">

                                                    </tbody> 
                                                    <tbody id="tab-6-2">

                                                    <?php 
                                                        if(!empty($assignEmployees)){
                                                        foreach ($assignEmployees as $assignEmployee) { 
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $assignEmployee->User->email; ?></td>
                                                            <td><?php echo $assignEmployee->Branch->title; ?></td>
                                                            <td>
                                                                <?php if($assignEmployee->OrganizationUser->status == '3'){ ?>
                                                                    <button type="button" class="btn green-meadow">Active User</button>
                                                                <?php } else { ?>
                                                                    <button type="button" class="btn red-sunglo">InActive User</button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>

                                                    <?php }}else{ ?>
                                                        <tr><td colspan="4">No Record Found</td></tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                                    <?php
                                                    $page=$data2->body->page;
                                                    $max=$data2->body->maxPage;
                                                    ?>
                                                    <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                                    <ul class="pagination" style="visibility: visible;">
                                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                                        <?php if($page<=1){ ?>
                                                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                                        <?php }else{ ?>
                                                            <a title="First" href="?page2=1"><i class="fa fa-angle-double-left"></i></a>
                                                        <?php } ?>
                                                        </li>
                                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                                        <?php if($page<=1){ ?>
                                                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                                        <?php }else{ ?>
                                                            <a title="Prev" href="?page2=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                                        <?php } ?>
                                                        </li>
                                                        
                                                        <?php if($max<=5){
                                                            for($i=1;$i<=$max;$i++){ ?>
                                                            <li>
                                                               <a title="<?=$i;?>" href="?page2=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                            </li>
                                                         <?php }}else{
                                                            if(($page-2)>=1 && ($page+2)<=$max){
                                                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                                <li>
                                                                   <a title="<?=$i;?>" href="?page2=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                                </li>
                                                          <?php  }}elseif(($page-2)<1){
                                                            for($i=1;$i<=5;$i++){ ?>
                                                                <li>
                                                                   <a title="<?=$i;?>" href="?page2=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                                </li>
                                                         <?php }}elseif(($page+2)>$max){
                                                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                                                <li>
                                                                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page2=<?=$i?>"><?=$i;?></a>
                                                                </li>
                                                        <?php }}} ?>
                                                        
                                                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                                        <?php if($page>=$max){ ?>
                                                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                                        <?php }else{ ?>
                                                        <a title="Next" href="?page2=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                                        <?php } ?></li>
                                                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                                        <?php if($max==0 || $max==1){ ?>
                                                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                                        <?php }else{ ?>
                                                        <a title="Last" href="?page2=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                                        <?php } ?></li>
                                                    </ul>
                                                </div>                                            
                                            </div>
                                            <div class="tab-pane <?php if(isset($_GET['page3'])){echo "active in";}?> fade" id="tab_6_3">
                                                <table class="table table-striped table-bordered table-hover" id="samdple_4">
                                                    <thead>
                                                        <tr>
                                                           
                                                            <th>Email</th>
                                                            <th>Status</th>
                                                            <th>Activate Here</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tab-6-3-" style="dispaly:none;">

                                                    </tbody>  
                                                    <tbody id="tab-6-3">
                                                        <?php
                                                        if(!empty($assignEmployeeByEmails)){
                                                        foreach ($assignEmployeeByEmails as $assignEmployeeByEmail) { 
                                                            
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $assignEmployeeByEmail->User->email; ?></td>
                                                            <td>
                                                                <?php if($assignEmployeeByEmail->User->status == '1'){ ?>
                                                                    <button type="button" class="btn green-meadow">Active User</button>
                                                                <?php } else { ?>
                                                                    <button type="button" class="btn red-sunglo">Inactive User</button>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="activateNow activateEmployeeByOrg btn green" id="<?php echo $assignEmployeeByEmail->OrganizationUser->id; ?>">Activate Now</button>
                                                            </td>
                                                        </tr>

                                                        <?php }}else{ ?>
                                                            <tr><td colspan="3">No Record Found</td></tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                                    <?php
                                                    $page=$data3->body->page;
                                                    $max=$data3->body->maxPage;
                                                    ?>
                                                    <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                                    <ul class="pagination" style="visibility: visible;">
                                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                                        <?php if($page<=1){ ?>
                                                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                                        <?php }else{ ?>
                                                            <a title="First" href="?page3=1"><i class="fa fa-angle-double-left"></i></a>
                                                        <?php } ?>
                                                        </li>
                                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                                        <?php if($page<=1){ ?>
                                                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                                        <?php }else{ ?>
                                                            <a title="Prev" href="?page3=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                                        <?php } ?>
                                                        </li>
                                                        
                                                        <?php if($max<=5){
                                                            for($i=1;$i<=$max;$i++){ ?>
                                                            <li>
                                                               <a title="<?=$i;?>" href="?page3=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                            </li>
                                                         <?php }}else{
                                                            if(($page-2)>=1 && ($page+2)<=$max){
                                                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                                <li>
                                                                   <a title="<?=$i;?>" href="?page3=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                                </li>
                                                          <?php  }}elseif(($page-2)<1){
                                                            for($i=1;$i<=5;$i++){ ?>
                                                                <li>
                                                                   <a title="<?=$i;?>" href="?page3=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                                </li>
                                                         <?php }}elseif(($page+2)>$max){
                                                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                                                <li>
                                                                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page3=<?=$i?>"><?=$i;?></a>
                                                                </li>
                                                        <?php }}} ?>
                                                        
                                                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                                        <?php if($page>=$max){ ?>
                                                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                                        <?php }else{ ?>
                                                        <a title="Next" href="?page3=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                                        <?php } ?></li>
                                                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                                        <?php if($max==0 || $max==1){ ?>
                                                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                                        <?php }else{ ?>
                                                        <a title="Last" href="?page3=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                                        <?php } ?></li>
                                                    </ul>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane <?php if(isset($_GET['page5'])){echo "active in";}?> fade" id="tab_2_5">
                                <table class="table table-striped table-bordered table-hover" id="sadmple_5">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Designation</th>
                                            <th>Email</th>
                                            <th>Branch</th>
                                            <th>Address</th>
                                            <th>Active By User</th>
                                            <th>Active By Org</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody id="tab-2-5-" style="dispaly:none;">

                                    </tbody>
                                                
                                    <tbody id="tab-2-5">
                                        <?php
                                            if(!empty($employeeRemoves)){
                                            foreach ($employeeRemoves as $employeeRemove) { 
                                        ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo $userimage; ?>" style="height:60px;width:60px;"/><br>
                                               <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>"><?php echo $employeeRemove->User->fname . ' ' . $employeeRemove->User->lname; ?></a> 
                                            </td>
                                            <td>
                                                <?php echo $employeeRemove->OrganizationUser->designation; ?>
                                            </td>
                                            <td>
                                                <?php echo $employeeRemove->User->email; ?>
                                            </td>
                                            <td>
                                                <?php echo $employeeRemove->Branch->title; ?>
                                            </td>
                                            <td>
                                                <?php echo $employeeRemove->User->address; ?>
                                            </td>
                                            <td>
                                                <?php if($employeeRemove->User->status == '1'){ ?>
                                                    <button type="button" class="btn green-meadow">Active User</button>
                                                <?php } else { ?>
                                                    <button type="button" class="btn red-sunglo">Inactive User</button>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <button type="button" class="activateEmployeeByOrg btn red-sunglo" id="<?php echo $employeeRemove->OrganizationUser->id; ?>">Activate Now</button>
                                            </td>
                                        </tr>
                                        <?php }}else{ ?>
                                            <tr><td colspan="7">No Record Found</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                    <?php
                                    $page=$data5->body->page;
                                    $max=$data5->body->maxPage;
                                    ?>
                                    <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                    <ul class="pagination" style="visibility: visible;">
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="First" href="?page5=1"><i class="fa fa-angle-double-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="Prev" href="?page5=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        
                                        <?php if($max<=5){
                                            for($i=1;$i<=$max;$i++){ ?>
                                            <li>
                                               <a title="<?=$i;?>" href="?page5=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                         <?php }}else{
                                            if(($page-2)>=1 && ($page+2)<=$max){
                                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page5=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                          <?php  }}elseif(($page-2)<1){
                                            for($i=1;$i<=5;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page5=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                         <?php }}elseif(($page+2)>$max){
                                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page5=<?=$i?>"><?=$i;?></a>
                                                </li>
                                        <?php }}} ?>
                                        
                                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                        <?php if($page>=$max){ ?>
                                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Next" href="?page5=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                        <?php } ?></li>
                                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                        <?php if($max==0 || $max==1){ ?>
                                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Last" href="?page5=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                        <?php } ?></li>
                                    </ul>
                                </div>                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="permanent_" tabindex="-1" role="basic" aria-hidden="true">            
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            <div class="col-md-12" id="histries">
                            
                </div>
                <form role="form" action="" method="post" id="permanentForm">
                    <div class="form-body mainChecks">
                        <input type="hidden" name="data[Permanentemploye][organization_user_id]" value=""/>
                        <div class="form-group form-md-checkboxes checkboxes">
                            <label>Select Day</label>
                            <div class="md-checkbox-inline">

                                <div class="md-checkbox">
                                    <input type="checkbox" id="checkbox1"  class="md-check" name="data[Permanentemploye][day_id][1]"/>
                                    <label for="checkbox1">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    Sunday </label>
                                </div>
                                <div class="md-checkbox">
                                    <input type="checkbox" id="checkbox2" class="md-check" name="data[Permanentemploye][day_id][2]"/>
                                    <label for="checkbox2">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    Monday </label>
                                </div>
                                <div class="md-checkbox">
                                    <input type="checkbox" id="checkbox3" class="md-check" name="data[Permanentemploye][day_id][3]"/>
                                    <label for="checkbox3">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    Tuesday </label>
                                </div>
                                <div class="md-checkbox">
                                    <input type="checkbox" id="checkbox4" class="md-check" name="data[Permanentemploye][day_id][4]"/>
                                    <label for="checkbox4">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    Wednesday </label>
                                </div><br /><br />
                                <div class="md-checkbox">
                                    <input type="checkbox" id="checkbox5" class="md-check" name="data[Permanentemploye][day_id][5]"/>
                                    <label for="checkbox5">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    Thursday </label>
                                </div>
                                <div class="md-checkbox">
                                    <input type="checkbox" id="checkbox6" class="md-check" name="data[Permanentemploye][day_id][6]"/>
                                    <label for="checkbox6">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    Friday </label>
                                </div>
                                <div class="md-checkbox">
                                    <input type="checkbox" id="checkbox7" class="md-check" name="data[Permanentemploye][day_id][7]"/>
                                    <label for="checkbox7">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    Saturday </label>
                                </div>
                                <div class="md-checkbox">

                                    <input type="checkbox" id="checkbox8" class="md-check" name="data[Permanentemploye][day_id][8]"/>
                                    <label for="checkbox8">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    Everyday </label>
                                </div>
                            </div>
                        </div>                               
                        <label class="control-label">Select time range</label>
                        <div class="input-group">
                        <div>
                            <input type="text" class="form-control timepicker timepicker-24" name="data[Permanentemploye][starttime]"/>
                            </div>
                            <span class="input-group-addon">to</span>
                            <div>
                            <input type="text" class="form-control timepicker timepicker-24" name="data[Permanentemploye][endtime]"/>
                        </div>
                        </div>
                        <!-- <div class="input-group">
                        <input type="text" class="form-control timepicker timepicker-24" name="data[Permanentemploye][endtime]"/>
                        </div> -->
                    </div>
                    <br/>
                    <br/>
                    <div class="form-actions noborder pull-right">
                        <button type="button submit" class="btn blue" name="submitt">Submit</button>
                        <button data-dismiss="modal" class="btn default" type="button">Cancel</button>
                    </div>
                </form>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="permanent_history" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="history-record">
                            
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn default" type="button">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function(){

    $('.timepicker').timepicker(); 

    $('#permanent_').on('hide.bs.modal', function(e){
        $('#permanent_ .mainChecks :input').each(function(){
            $(this).removeAttr('checked');
        });
    });

    $('.permanent-history').live('click',function(){
        var e = $(this).closest('ul');
        var id = e.attr('permanent-id');
        var fname = e.attr('fname');
        var lname = e.attr('lname');
        var modal = $("#permanent_history");
        modal.modal();
        var organizationUserId = e.attr('organizationUser-id');
        modal.find('.modal-title').text('Permanent history of '+ fname +' '+lname);

        var url = '<?php echo URL;?>Permanentemployes/getPerm/'+organizationUserId+'.json';
        $.ajax({
            url:url,
            type:'post',
            datatype:'jsonp',
            success:function(response){
                var getPerm = response.getPerm;
                var html = "";
                if(getPerm.length != 0){
                    $.each(getPerm , function(days,times){
                        html += '<ul class="list-group">';
                        html += '<strong><li class="list-group-item">'+days+'</li></strong>';
                        $.each(times,function(key,time){
                            html += '<li class="list-group-item">'+time+'</li>';
                        });
                        html += '</ul>';

                    });
                } else {
                    html += '<p>No history to show.</p>';
                }
                
                    $("#permanent_history #history-record").html(html);
            }
        });
    });

    $('.make-permanent').live('click',function(){
        var e = $(this).closest('ul');
        var id = e.attr('permanent-id');
        var fname = e.attr('fname');
        var lname = e.attr('lname');
        var organizationUserId = e.attr('organizationUser-id');

        var url = '<?php echo URL;?>Permanentemployes/getPerm/'+organizationUserId+'.json';
        $.ajax({
            url:url,
            type:'post',
            datatype:'jsonp',
            success:function(response){
                var getPerm = response.getPerm;
                var html = "";
                if(getPerm.length != 0){
                html += '<span><strong>Permanent History</span></strong><hr>';
                $.each(getPerm , function(days,times){
                    html += '<dl class="dl-horizontal">';
                    html += '<dt>'+days+'</dt>';
                    $.each(times,function(key,time){
                        html += '<dd>'+time+'</dd>';
                    });
                    html += '</dl>';

                });
                html += '<hr>';
                    
                }
                $("#permanent_ #histries").html(html);
                
            }
        });

        var modal = $('#permanent_');
        $('#permanent_ .modal-title').text('Make '+ fname +' '+lname+' Permanent');
        $('#permanent_').find('input[name="data[Permanentemploye][organization_user_id]"]').val(organizationUserId);
        modal.modal();    

    $("#checkbox8").change(function() {
        var clo=$(this).closest('.mainChecks');
        if(this.checked) {
            clo.find('#checkbox1').attr('checked','checked');
            clo.find('#checkbox2').attr('checked','checked');
            clo.find('#checkbox3').attr('checked','checked');
            clo.find('#checkbox4').attr('checked','checked');
            clo.find('#checkbox5').attr('checked','checked');
            clo.find('#checkbox6').attr('checked','checked');
            clo.find('#checkbox7').attr('checked','checked');
        }else{
            clo.find('#checkbox1').removeAttr('checked');
            clo.find('#checkbox2').removeAttr('checked');
            clo.find('#checkbox3').removeAttr('checked');
            clo.find('#checkbox4').removeAttr('checked');
            clo.find('#checkbox5').removeAttr('checked');
            clo.find('#checkbox6').removeAttr('checked');
            clo.find('#checkbox7').removeAttr('checked');
        }
    });

    $("#checkbox1").change(function(){
        var clo=$(this).closest('.mainChecks');
        if(this.checked) {
            if(clo.find('#checkbox2').attr('checked') && clo.find('#checkbox3').attr('checked') && clo.find('#checkbox4').attr('checked') && clo.find('#checkbox5').attr('checked') && clo.find('#checkbox6').attr('checked') && clo.find('#checkbox7').attr('checked')){
                clo.find('#checkbox8').attr('checked','checked');
            }
        }else{
            if(clo.find('#checkbox8').attr('checked')){
                clo.find('#checkbox8').removeAttr('checked');
            }
        }
    });
    $("#checkbox2").change(function(){
        var clo=$(this).closest('.mainChecks');
        if(this.checked) {
            if(clo.find('#checkbox1').attr('checked') && clo.find('#checkbox3').attr('checked') && clo.find('#checkbox4').attr('checked') && clo.find('#checkbox5').attr('checked') && clo.find('#checkbox6').attr('checked') && clo.find('#checkbox7').attr('checked')){
                clo.find('#checkbox8').attr('checked','checked');
            }
        }else{
            if(clo.find('#checkbox8').attr('checked')){
                clo.find('#checkbox8').removeAttr('checked');
            }
        }
    });
    $("#checkbox3").change(function(){
        var clo=$(this).closest('.mainChecks');
        if(this.checked) {
            if(clo.find('#checkbox1').attr('checked') && clo.find('#checkbox2').attr('checked') && clo.find('#checkbox4').attr('checked') && clo.find('#checkbox5').attr('checked') && clo.find('#checkbox6').attr('checked') && clo.find('#checkbox7').attr('checked')){
                clo.find('#checkbox8').attr('checked','checked');
            }
        }else{
            if(clo.find('#checkbox8').attr('checked')){
                clo.find('#checkbox8').removeAttr('checked');
            }
        }
    });
    $("#checkbox4").change(function(){
        var clo=$(this).closest('.mainChecks');
        if(this.checked) {
            if(clo.find('#checkbox1').attr('checked') && clo.find('#checkbox2').attr('checked') && clo.find('#checkbox3').attr('checked') && clo.find('#checkbox5').attr('checked') && clo.find('#checkbox6').attr('checked') && clo.find('#checkbox7').attr('checked')){
                clo.find('#checkbox8').attr('checked','checked');
            }
        }else{
            if(clo.find('#checkbox8').attr('checked')){
                clo.find('#checkbox8').removeAttr('checked');
            }
        }
    });
    $("#checkbox5").change(function(){
        var clo=$(this).closest('.mainChecks');
        if(this.checked) {
            if(clo.find('#checkbox2').attr('checked') && clo.find('#checkbox3').attr('checked') && clo.find('#checkbox4').attr('checked') && clo.find('#checkbox1').attr('checked') && clo.find('#checkbox6').attr('checked') && clo.find('#checkbox7').attr('checked')){
                clo.find('#checkbox8').attr('checked','checked');
            }
        }else{
            if(clo.find('#checkbox8').attr('checked')){
                clo.find('#checkbox8').removeAttr('checked');
            }
        }
    });
    $("#checkbox6").change(function(){
        var clo=$(this).closest('.mainChecks');
        if(this.checked) {
            if(clo.find('#checkbox2').attr('checked') && clo.find('#checkbox3').attr('checked') && clo.find('#checkbox4').attr('checked') && clo.find('#checkbox5').attr('checked') && clo.find('#checkbox1').attr('checked') && clo.find('#checkbox7').attr('checked')){
                clo.find('#checkbox8').attr('checked','checked');
            }
        }else{
            if(clo.find('#checkbox8').attr('checked')){
                clo.find('#checkbox8').removeAttr('checked');
            }
        }
    });
    $("#checkbox7").change(function(){
        var clo=$(this).closest('.mainChecks');
        if(this.checked) {
            if(clo.find('#checkbox2').attr('checked') && clo.find('#checkbox3').attr('checked') && clo.find('#checkbox4').attr('checked') && clo.find('#checkbox5').attr('checked') && clo.find('#checkbox6').attr('checked') && clo.find('#checkbox1').attr('checked')){
                clo.find('#checkbox8').attr('checked','checked');
            }
        }else{
            if(clo.find('#checkbox8').attr('checked')){
                clo.find('#checkbox8').removeAttr('checked');
            }
        }
    });

});
    }); 


</script> 





<script src="<?php echo URL_VIEW; ?>global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>


<!-- BEGIN PAGE LEVEL PLUGINS -->


<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script src="<?php echo URL_VIEW; ?>global/plugins/icheck/icheck.min.js"></script>
<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/form-icheck.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/form-samples.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
    var timer;
    var tabStatus=3;
    var orgId = "<?php echo $orgId;?>";
    $(".activeTab > li").on('click',function(){
        $("#select-branch").find('.default').attr('selected',true);
        $("#selectDepartment").find('.default').attr('selected',true);
        $("#selectDepartment").html("").append('<option selected value="0">--All Department--</option>');
        $("#username").val('');
         tabStatus = $(this).attr('data-status');
         
         $("#tab-2-1").show();
         $("#tab-2-5").show();
         $("#tab-6-1").show();
         $("#tab-6-2").show();
         $("#tab-6-3").show();

         $("#tab-2-1-").hide();
         $("#tab-2-5-").hide();
         $("#tab-6-1-").hide();
         $("#tab-6-2-").hide();
         $("#tab-6-3-").hide();

    });  

    
    //function selectBybranch(){}
    $("#select-branch").on('change',function(){      
        var e = $(this);
        var username = $('#username').val();
        if(username == ''){
            username = '0';
        }
        var status = tabStatus;
        var departmentId = '0';
        var branchId = e.find("option:selected").val();
        var data =  getBoardList(branchId);
        //console.log(data);
        var html = ""; 
        html += '<option selected value="0">--All Department--</option>';
        $.each(data,function(key,val){
            var departmentId = val.Board.id;
            var title = val.Board.title;
            html += '<option value="'+departmentId+'">'+title+'</option>';
        });
        $("#selectDepartment").html("").append(html);
        filterEmplLoad(orgId,username,branchId,departmentId,status); 
    });


    $("#selectDepartment").on('change',function(){

        var e = $(this);
        var username = $('#username').val();
        if(username == ''){
            username = '0';
        }
        var status = tabStatus;
        var branchId = $("#select-branch option:selected").val();
        var departmentId = e.find("option:selected").val();
        filterEmplLoad(orgId,username,branchId,departmentId,status);           

    });
   
    //var branchId = 0;


    $('#username').on('keyup', function(e) {
        var branchId = $("#select-branch option:selected").val();
        var departmentId = $("#selectDepartment option:selected").val();
        
        var username = $('#username').val();
        if(username == ''){
            username='0';    
        }
        var status = tabStatus;
        clearTimeout(timer);
        timer = setTimeout(function (event) {
            
            filterEmplLoad(orgId,username,branchId,departmentId,status);           
        }, 600);

    });

    function filterEmplLoad(orgId,username,branchId,departmentId,status)
    {   

        if(status == 3){
            var thatTabId = '#tab-2-1-';
            var thisTabId = '#tab-2-1';
        } else if(status == 4){
            var thatTabId = '#tab-2-5-';
            var thisTabId = '#tab-2-5';
        } else if(status == 0){
            var thatTabId = '#tab-6-1-';
            var thisTabId = '#tab-6-1';
        } else if(status == 1){
            var thatTabId = '#tab-6-2-';
            var thisTabId = '#tab-6-2';
        } else if(status == 2){
            var thatTabId = '#tab-6-3-';
            var thisTabId = '#tab-6-3';
        }
        if(username != '0' || branchId != '0' || departmentId != '0'){
            username = encodeURIComponent(username);
            $(""+thatTabId+"").load('<?php echo URL_VIEW; ?>filterEmployee.php?orgId='+orgId+'&userName='+username+'&branchId='+branchId+'&departmentId='+departmentId + '&status='+status);
            console.log(orgId);
            $(""+thisTabId+"").hide();
            $(""+thatTabId+"").show();

        } else {
            $(""+thisTabId+"").show();
            $(""+thatTabId+"").hide();            
        }
    }

    function filterOrganizationUser(orgId,username,branchId,departmentId){
        var url = '<?php echo URL; ?>OrganizationUsers/searchOrganizationUsers/'+orgId+'/'+username+'/'+branchId+'/'+departmentId+'.json';

         $.ajax({
                url:url,
                datatype:'jsonp',
                type:'post',
                success:function(response){
                    $("#tab-2-1-").html("");
                    if(username != ""){
                        $("#tab-2-1").hide();
                        $("#tab-2-1-").show();
                        $(".pagination").hide();
                        $.each(response,function(key,val){
                            $("#tab-2-1-").append(val);
                        });
                    } 
                    else {
                        $("#tab-2-1").show();
                        $("#tab-2-1-").hide();
                        $(".pagination").show();
                    }
                   
                }
            });

    }



        $(".select2Branch").select2(
            {
                allowClear: true
            });

        $(".editEmpBtn").live('click', function(event)
            {
                var $modal = $("#large");

                var e = $(this);
                var userId = e.attr('data-userId');
                var orgId = '<?php echo $orgId;?>';
                $modal.data({"userId":userId});

                var url = '<?php echo URL;?>OrganizationUsers/organizationEmployeeDetail/'+orgId+'/'+userId+'.json';
                $.ajax(
                    {
                        url:url,
                        datatype:'jsonp',
                        async:false,
                        type:'post',
                        success:function(res)
                        {
                            var employee = res.employee;
                            console.log(employee);
                            var user = employee.User;
                            $("#empProfName").find('span').html("").html(user.fname+' '+user.lname);
                            $("#large").find('input[name$="data[OrganizationUser][id]"]').val(employee.OrganizationUser.id);
                            $("#large").find('input[name$="data[User][id]"]').val(user.id);

                            $("#large").find('textarea[name$="data[OrganizationUser][notes]"]').val(employee.OrganizationUser.notes);

                            $("#large").find('input[name$="data[User][fname]"]').val(user.fname);
                            $("#large").find('input[name$="data[User][lname]"]').val(user.lname);
                            $("#large").find('input[name$="data[User][email]"]').val(user.email);
                            $("#large").find('input[name$="data[User][phone]"]').val(user.phone);
                            $("#large").find('input[name$="data[OrganizationUser][wage]"]').val(employee.OrganizationUser.wage);
                            $("#large").find('input[name$="data[OrganizationUser][max_weekly_hour]"]').val(employee.OrganizationUser.max_weekly_hour);

                            
                            $("#employeeId").val(userId);

                            if(user.image !="")
                            {var userimage = '<?php echo URL;?>webroot/files/user/image/'+user.image_dir+'/thumb2_'+user.image;
                                $("#empImage").attr('src', userimage); 
                                $("#empProfImage").attr('src', userimage); 
                            }else{
                                var userimage = '<?php echo URL_VIEW;?>images/a.png';
                                $("#empImage").attr('src', userimage); 
                                $("#empProfImage").attr('src', userimage); 
                            }


                            
                            $("#large").find('input[name$="data[OrganizationUser][organizationrole_id]"]').val(employee.OrganizationUser.organizationrole_id);

                            switch(employee.OrganizationUser.organizationrole_id)
                            {

                                case "1":
                                    var managerCheck = "checked";
                                    var superCheck ="";
                                    var employeeCheck = "";
                                    break;

                                case "2":
                                    var managerCheck = "";
                                    var superCheck ="checked";
                                    var employeeCheck = "";
                                    break;

                                case "3":
                                    var managerCheck = "";
                                    var superCheck ="";
                                    var employeeCheck = "checked";
                                    break;

                                default:
                                    var managerCheck = "";
                                    var superCheck ="";
                                    var employeeCheck = "";                                                       
                            }

                            var roleRadio = '<div class="icheck-inline">'+
                                                '<label>'+
                                                '<input type="radio" name="radio2" class="icheck" value="1" data-radio="iradio_flat-green"'+managerCheck+'> Manager </label>'+
                                                '<label>'+
                                                '<input type="radio" name="radio2" class="icheck" value="2" data-radio="iradio_flat-green"'+superCheck+'> Supervisor </label>'+
                                                '<label>'+
                                                '<input type="radio" name="radio2" class="icheck" value="3" data-radio="iradio_flat-green"'+employeeCheck+'> Employee </label>'+
                                            '</div>';

                            $("#editEmpRoleRadio").html("").html(roleRadio);

                            var branches = getBranchList();                      

                            var selectBranch ="" ;

                            $.each(branches, function(k,v)
                                {
                                    if(employee.Branch.id == v.Branch.id)
                                    {
                                        selectBranch+= '<option selected value="'+v.Branch.id+'">'+v.Branch.title+'</option>';
                                    }else
                                    {
                                        selectBranch+= '<option value="'+v.Branch.id+'">'+v.Branch.title+'</option>';
                                    }
                                });

                            $("#selectBranch").html(selectBranch);


                            var boardUsers = getRelatedBoardOfUser(userId);

                            var depts =  getBoardList(employee.Branch.id);
                            // console.log(depts);
                            var selectDept ="";

                            var boardIdArr = [];
                            $.each(depts, function(k,v)
                                {
                                    if($.inArray(v.Board.id, boardUsers) != -1)
                                    {
                                        selectDept+= '<option value="'+v.Board.id+'" selected>'+v.Board.title+'</option>';

                                        boardIdArr.push(v.Board.id);
                                        
                                        
                                    }else
                                    {
                                        selectDept+= '<option value="'+v.Board.id+'">'+v.Board.title+'</option>';
                                    }
                                });

                            // console.log(boardIdArr);
                            $("#large").find('input[name$="data[boardIds]"]').val(boardIdArr);

                            $("#selectDept").html("").html(selectDept);

                            $(".select2Branch").select2('destroy');
                            $(".select2Branch").select2(
                                                        {
                                                            allowClear: true
                                                        });


                            $('input').iCheck({
                                                checkboxClass: 'icheckbox_flat-green',
                                                radioClass: 'iradio_flat-green'
                                              });

                            $('a[href="#tab_7_1"]').tab('show');
                            $modal.modal();
                            
                        }
                    });
            });

$('input[name="radio2"]').live('ifClicked', function (event) {
    $("#large").find('input[name$="data[OrganizationUser][organizationrole_id]"]').val(this.value);
    });

        $("#selectBranch").on('change', function(event)
            {
                var e = $(this);
                var branchId = e.val();

                var userId = $("#large").data('userId');

                var boardUsers = getRelatedBoardOfUser(userId);
                // console.log(boardUsers);

                var depts =  getBoardList(branchId);

                var selectDept ="";

                $.each(depts, function(k,v)
                    {
                        if($.inArray(v.Board.id, boardUsers) != -1)
                        {
                            selectDept+= '<option value="'+v.Board.id+'" selected>'+v.Board.title+'</option>';
                        }else
                        {
                            selectDept+= '<option value="'+v.Board.id+'">'+v.Board.title+'</option>';
                        }
                    });

                $("#selectDept").html("").html(selectDept);

                $(".select2Branch").select2('destroy');
                $(".select2Branch").select2();
            });

        function getRelatedBoardOfUser(userId)
        {
            var boardUsers;
            var url = '<?php echo URL;?>BoardUsers/getRelatedBoardOfUser/'+userId+'.json';
            $.ajax(
            {
                url:url,
                type:'post',
                async:false,
                datatype:'jsonp',
                success:function(res)
                {
                    boardUsers = res.boardIds;
                }
            })
                    return boardUsers;
        }

        function getBoardList(branchId)
        {
            var boards;
            var orgId = '<?php echo $orgId;?>';
            var url = '<?php echo URL;?>Boards/getBoardListOfBranch/'+branchId+'.json';
            $.ajax(
            {
                url:url,
                type:'post',
                async:false,
                datatype:'jsonp',
                success:function(res)
                {
                    boards = res.boardList;
                }
            })
                    return boards;
        }

        function getBranchList()
        {
            var branches;
            var orgId = '<?php echo $orgId;?>';
            var url = '<?php echo URL;?>Branches/listBranches/'+orgId+'/'+1+'.json';
            $.ajax(
            {
                url:url,
                type:'post',
                async:false,
                datatype:'jsonp',
                success:function(res)
                {
                    branches = res.branches;
                }
            })
                    return branches;
        }


        $(".activateEmployeeByOrg").live('click',function(){
            var e = $(this);
            var orguser_id = this.id;
            var org_id = '<?php echo $orgId; ?>';
           //console.log(orguser_id);
           //console.log(org_id);
             $.ajax({

                url:'<?php echo URL."OrganizationUsers/activateNewUser/"."'+orguser_id+'"."/"."'+org_id+'".".json";?>',
                type:'post',
                datatype:'jsonp',
               success:function(response)
                        {   
                            if(response.output == 1)
                            { 
                                e.closest("tr").remove();
                                toastr.success("User activated Successfully.");
                            }else if(response.output == 3){
                                toastr.info("User has not activated account yet.");
                            }
                            else{
                                toastr.info("Something Went Wrong.");
                            }
                        }
            });

           
        });
        $(".removeEmployee").live('click',function(){
            var e =$(this);
            var orgUserId = e.attr('id');
            $.ajax({
                url:'<?php echo URL."OrganizationUsers/removeOrgUser/"."'+orgUserId+'".".json";?>',
                type:'post',
                datatype:'jsonp',
               success:function(response)
                        {
                            if(response.output == 1)
                            {
                                alert("Employee Removed Successfully");
                                window.location.reload();
                            }else{
                                alert("Something is missing");
                            }
                        }
            });
        });
        var table = $('#test_1');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "columns": [{
                "orderable": false
            }, {
                "orderable": true
            }, {
                "orderable": false
            }, {
                "orderable": false
            }, {
                "orderable": true
            }, {
                "orderable": false
            }],
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 5,            
            "pagingType": "bootstrap_full_number",
            "language": {
                "search": "My search: ",
                "lengthMenu": "  _MENU_ records",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });
});
</script>
<script>
jQuery(document).ready(function() { 
    FormiCheck.init(); // init page demo
    FormSamples.init();
    ComponentsPickers.init();
    TableManaged.init();
});
</script>