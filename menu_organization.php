 
 <?php /*?><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script><?php */?>
<?php
$schedule_active = '';
$dashboard_active = '';

$url_name = null;
if(isset($url) && !empty($url)){

          $url_name = $url[1];
          $url_name0 = $url[0];

      // print_r($url_name);

    // if($url[0] == 'shiftUsers')
 //        {
    //        $schedule_active = 'active';  
 //        }

 //        else
 //        {
 //                $dashboard_active = 'active';    
 //        }

}
        // else{
           // $dashboard_active = 'active'; 
        // }


if(isset($_GET['organization_role_id']) && !empty($_GET['organization_role_id'])){
    if($_GET['organization_role_id'] == 2){
        $schedule_link =  URL_VIEW."ShiftUsers/mySchedule"; 
    }else{
        $schedule_link =  URL_VIEW."ShiftUsers/assignUserInshift";  
    }
}else{
    $schedule_link =  URL_VIEW."ShiftUsers/assignUserInshift";  
}

//$orgId = "1";
//$userId = "2";

$branchList_link = URL_VIEW."branches/listBranches";
$shiftList_link = URL_VIEW."shifts/listShifts";
$boardList_link = URL_VIEW."boards/listBoards";
$groupList_link = URL_VIEW."groups/listGroups";
$orgProfile = URL_VIEW."organizations/orgView";
$availability_link = URL_VIEW."useravailabilities/updateEmployeeAvailabilities?user_id=6";
$shift_link = URL_VIEW."shiftUsers/mySchedule";
$shift_wise_link = URL_VIEW."shiftUsers/viewShift";


$orgUser_link = URL_VIEW."organizationUsers/listOrganizationEmployees";

$holiday_link = URL_VIEW."organizationfunctions/listHoliday";

$payment_rate_link = URL_VIEW."paymentRates/listPaymentFactor";
$payment_factor_link = URL_VIEW."paymentRates/listPaymentFactorType?org_id=".$orgId;

$organization_role_link = URL_VIEW."organizations/organizationRole";

$noticeboard_link = URL_VIEW."noticeboards/list_noticeboards";

$newsboard_link = URL_VIEW."newsboards/list_newsboards";

$organization_profile_link = URL_VIEW."organizations/organizationProfile";

$message_link = URL_VIEW."messages/inboxMessages";

$feed_link = URL_VIEW."feedback/viewOrganizationFeedBack";

$leave_link = URL_VIEW."leaverequests/userLeaveRequest";
$leave_type_link = URL_VIEW."leaverequests/leaveTypes";
$leave_accepted_link = URL_VIEW."leaverequests/userAcceptedLeaveRequest";
$leave_rejected_link = URL_VIEW."leaverequests/userRejectedLeaveRequest";
$allReviews_link= URL_VIEW."reviews/allReviews";
$viewLeaveRequest = URL_VIEW."leaverequests/viewRequests";

// ashok
$shift_assign_link= URL_VIEW."shiftAssign/assignShiftList";
$orgShiftExpense_link = URL_VIEW."viewshiftexpenses/orgShiftExpenses";

$jobagreements_link = URL_VIEW."jobagreements/jobagreements";
// $task_link = URL_VIEW."tasks/listTask";

$createInduction_link= URL_VIEW."inductionChecklist/createInduction";
$organizationShiftHistory_link = URL_VIEW."shifthistories/organizationShiftHistory";

// ashok neupane
$emergency_protocol_link=URL_VIEW."contacts/list";
$emergency_protocol_type=URL_VIEW."contacts/type";
$emergency_protocol_employeeList=URL_VIEW."emergencyProtocol/employeeList";
$emergency_protocol_procedures=URL_VIEW."emergencyProtocol/emergencyProcedures";

$new_shift_plan_link=URL_VIEW."shiftplans/makePlan";
$view_shift_plan_link=URL_VIEW."shiftplans/showPlans";

$account_link = URL_VIEW."Account/orgDetails";
// end
?>
<style type="text/css">
/*.page-sidebar .page-sidebar-menu .sub-menu > li.active > a{
        background: #1caf9a !important;
        color: #ffffff;
    }
    .page-sidebar .page-sidebar-menu .sub-menu > li.active > a > i {
        color: #ffffff;
    }*/
</style>

<div class="page-header-menu">
    <div class="container">
        <!-- <form class="search-form" action="extra_search.html" method="GET">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search" name="query">
				<span class="input-group-btn">
				<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
				</span>
			</div>
		</form> -->
        <!-- BEGIN SIDEBAR MENU -->
        <div class="hor-menu ">
            <ul class="nav navbar-nav">
                <li class="menu-dropdown <?php echo (!isset($url_name) && !$url_name) ? "start active" : ""; ?>">
                    <a href="<?php echo URL_VIEW;?>" class="<?php echo(($url[0]=="")? 'active':'');?>">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
                    </a>
                </li>
               <li class="menu-dropdown classic-menu-dropdown <?php echo ($url_name == "allReviews" || $url_name == "createInduction" || $url_name == "jobagreements" || $url_name == "listOrganizationEmployees" || $url_name == "userAcceptedLeaveRequest" || $url_name == "userRejectedLeaveRequest" || $url_name == "leaveTypes" || $url_name == "userLeaveRequest") ? "active" : ""; ?>">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="<?php echo $shiftList_link;?>" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                        <i class="icon-user"></i>
                        <span class="title">Employees</span>
                        <span class="selected"></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-left">
                        <li class="<?php echo ($url_name == "listOrganizationEmployees") ? "active" : ""; ?>">
                            <a href="<?php echo $orgUser_link;?>" class="<?php echo(($url[0]=="organizationUsers")? 'active':'');?>">
                            <i class="icon-user"></i>
                            <span class="title">Employee Management</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="dropdown-submenu <?php echo ($url_name == "userLeaveRequest" || $url_name == "userAcceptedLeaveRequest" || $url_name == "userRejectedLeaveRequest" || $url_name == "leaveTypes") ? "active" : ""; ?>">
                            <a href="javascript:;">
                            <i class="fa fa-umbrella"></i>
                            <span class="title">Leave</span>
                            <span class="selected"></span>
                            <span class="arrow"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- <li class="<?php echo ($url_name == "userLeaveRequest") ? "active" : ""; ?>">
                                    <a href="<?php echo $leave_link;?>" class="<?php echo(($url[0]=="leaverequests")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                    Pending Requests
                                    <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="<?php echo ($url_name == "userAcceptedLeaveRequest") ? "active" : ""; ?>">
                                    <a href="<?php echo $leave_accepted_link;?>" class="<?php echo(($url[0]=="leaverequests")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                    Accepted Requests
                                    <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="<?php echo ($url_name == "userRejectedLeaveRequest") ? "active" : ""; ?>">
                                    <a href="<?php echo $leave_rejected_link;?>" class="<?php echo(($url[0]=="leaverequests")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                  Rejected Requests
                                  <span class="selected"></span>
                                    </a>
                                </li> 
                                <li class="<?php echo ($url_name == "leaveTypes") ? "active" : ""; ?>">
                                    <a href="<?php echo $leave_type_link;?>" class="<?php echo(($url[0]=="leaverequests")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                    Leave Types
                                    <span class="selected"></span>
                                    </a>
                                </li>-->
                                <li class="<?php echo ($url_name == "leaveTypes") ? "active" : ""; ?>">
                                    <a href="<?php echo $viewLeaveRequest;?>" class="<?php echo(($url[0]=="leaverequests")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                    All Requests
                                    <span class="selected"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php echo ($url_name == "jobagreements") ? "active" : ""; ?>">
                            <a href="<?php echo $jobagreements_link;?>" class="<?php echo(($url[0]=="jobagreements")? 'active':'');?>">
                            <i class="icon-link "></i>
                            <span class="title">Job Agreements</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "createInduction") ? "active" : ""; ?>">
                            <a href="<?php echo $createInduction_link;?>" class="<?php echo(($url[0]=="inductionChecklist")? 'active':'');?>">
                            <i class="icon-diamond"></i>
                            <span class="title">Inductions</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "allReviews") ? "active" : ""; ?>">
                            <a href="<?php echo $allReviews_link;?>" class="<?php echo(($url[0]=="reviews")? 'active':'');?>">
                            <i class="glyphicon glyphicon-check"></i>
                            <span class="title">Reviews</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                    </ul>
               </li>
               <li class="menu-dropdown classic-menu-dropdown <?php echo ($url_name == "organizationRole" || $url_name == "listHoliday" || $url_name == "list" || $url_name == "type" || $url_name == "employeeList" || $url_name == "listGroups" || $url_name == "listBoards" || $url_name == "listBranches" || $url_name == "organizationProfile" || $url_name == "emergencyProcedures") ? "active" : ""; ?>">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="<?php echo $shiftList_link;?>" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                        <i class="fa fa-users"></i>
                        <span class="title">Organisation</span>
                        <span class="selected"></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-left">
                        <li class="<?php echo ($url_name == "organizationRole") ? "active" : ""; ?>">
                            <a href="<?php echo $organization_role_link;?>" class="<?php echo(($url[0]=="organizations")? 'active':'');?>">
                            <i class="icon-diamond"></i>
                            <span class="title">Organisation Role</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "organizationProfile") ? "active" : ""; ?>">
                            <a href="<?php echo $organization_profile_link;?>" class="<?php echo(($url[0]=="organizations")? 'active':'');?>">
                            <i class="icon-user"></i>
                            <span class="title">Organisation Profile</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "listBranches") ? "active" : ""; ?>">
                            <a href="<?php echo $branchList_link;?>" class="<?php echo(($url[0]=="branches")? 'active':'');?>">
                            <i class="icon-share"></i>
                            <span class="title">Branches</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "listBoards") ? "active" : ""; ?>">
                            <a href="<?php echo $boardList_link;?>" class="<?php echo(($url[0]=="boards")? 'active':'');?>">
                            <i class="fa  fa-lightbulb-o "></i>
                            <span class="title">Departments</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "listGroups") ? "active" : ""; ?>">
                            <a href="<?php echo $groupList_link;?>" class="<?php echo(($url[0]==("groups"))? 'active':'');?>">
                            <i class="fa  fa-users"></i>
                            <span class="title">Groups</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="dropdown-submenu <?php echo ($url_name == "list" || $url_name == "emergencyProcedures" || $url_name == "type" || $url_name == "employeeList") ? "active":""; ?>">
                            <a href="javascript:;">
                            <i class="icon-diamond"></i>
                            <span class="title">Emergency Protocol</span>
                            <span class="selected"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="<?php echo ($url_name == "list") ? "active" : ""; ?>">
                                    <a href="<?php echo $emergency_protocol_link;?>" class="<?php echo(($url[0]=="contacts")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                    Contacts
                                    <span class="selected"></span></a>
                                </li>
                                <li class="<?php echo ($url_name == "type") ? "active" : ""; ?>">
                                    <a href="<?php echo $emergency_protocol_type;?>" class="<?php echo(($url[0]=="contacts")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                  Types
                                  <span class="selected"></span>
                                  </a>
                                </li>
                                <li <?php echo ($url_name == "employeeList") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $emergency_protocol_employeeList;?>" class="<?php echo(($url[0]=="emergencyProtocol")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                      Employee List
                                      <span class="selected"></span>
                                      </a>
                                </li>
                                <li <?php echo ($url_name == "emergencyProcedures") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $emergency_protocol_procedures;?>" class="<?php echo(($url[0]=="emergencyProtocol")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                    Emergency Procedures
                                  <span class="selected"></span>
                                  </a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php echo ($url_name == "listHoliday") ? "active" : ""; ?>">
                            <a href="<?php echo $holiday_link;?>" class="<?php echo(($url[0]=="organizationfunctions")? 'active':'');?>">
                            <i class="fa fa-umbrella "></i>
                            <span class="title">Events / Holidays</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                    </ul>
               </li>
               <li class="menu-dropdown classic-menu-dropdown <?php echo ($url_name == "viewOrganizationFeedBack" || $url_name == "employee" || $url_name == "list_newsboards" || $url_name == "list_noticeboards") ? "active" : ""; ?>">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="<?php echo $shiftList_link;?>" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                        <i class="fa fa-newspaper-o"></i>
                        <span class="title">News</span>
                        <span class="selected"></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-left">
                        <li class="<?php echo ($url_name == "list_noticeboards") ? "active" : ""; ?>">
                            <a href="<?php echo $noticeboard_link;?>" class="<?php echo(($url[0]=="noticeboards")? 'active':'');?>">
                            <i class="glyphicon glyphicon-pushpin "></i>
                            <span class="title">Notice Board</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                       <li class="<?php echo ($url_name == "list_newsboards") ? "active" : ""; ?>">
                            <a href="<?php echo $newsboard_link;?>" class="<?php echo(($url[0]=="newsboards")? 'active':'');?>">
                            <i class="icon-book-open "></i>
                            <span class="title">News Board</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "employee") ? "active" : ""; ?>">
                            <a href="<?php echo $message_link;?>" class="<?php echo(($url[0]=="organizationfunctions")? 'active':'');?>">
                                <i class="icon-envelope-open"></i>
                                <span class="title">Message</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "viewOrganizationFeedBack") ? "active" : ""; ?>">
                            <a href="<?php echo $feed_link;?>" class="<?php echo(($url[0]=="feedback")? 'active':'');?>">
                            <i class="glyphicon glyphicon-comment"></i>
                            <span class="title">Feedback</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                    </ul>
               </li>
               <li class="menu-dropdown classic-menu-dropdown <?php echo ($url_name == "orgCalendar" || $url_name == "orgShiftExpenses" || $url_name == "organizationShiftHistory" || $url_name == "showPlans" || $url_name == "listShifts" || $url_name == "assignShiftList") ? "active" : ""; ?>">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="<?php echo $shiftList_link;?>" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                        <i class="fa fa-clock-o"></i>
                        <span class="title">Shifts</span>
                        <span class="selected"></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu <?php echo ($url_name == "listShifts" || $url_name == "assignShiftList") ? "active" : ""; ?>">
                            <a href="<?php echo $shiftList_link;?>" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                            <i class="glyphicon glyphicon-time "></i>
                            <span class="title">Shiftpool</span>
                            <span class="selected"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="<?php echo ($url_name == "listShifts") ? "active" : ""; ?>">
                                    <a href="<?php echo $shiftList_link;?>" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                                    <i class="glyphicon glyphicon-time "></i>
                                    <span class="title">Shiftpool List</span>
                                    <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="<?php echo ($url_name == "assignShiftList") ? "active" : ""; ?>">
                                    <a href="<?php echo $shift_assign_link;?>" class="<?php echo(($url[0]=="shiftAssign")? 'active':'');?>">
                                    <i class="glyphicon glyphicon-time "></i>
                                    <span class="title">Shiftpool Assign</span>
                                    <span class="selected"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php echo ($url_name == "orgCalendar") ? "active" : ""; ?>">
                            <a href="<?=URL_VIEW."calendar/orgCalendar";?>" class="<?php echo(($url[0]=="calendar")? 'active':'');?>">
                            <i class="glyphicon glyphicon-time "></i>
                            <span class="title">Calendar</span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "showPlans") ? "active" : ""; ?>">
                            <a href="<?php echo $view_shift_plan_link;?>" class="<?php echo(($url[0]=="shiftplans")? 'active':'');?>">
                            <i class="glyphicon glyphicon-time "></i>
                            <span class="title">Shift Plans</span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "organizationShiftHistory") ? "active" : ""; ?>">
                            <a href="<?php echo $organizationShiftHistory_link; ?>" class="<?php echo(($url[0]=="shifthistories")? 'active':'');?>">
                            <i class="glyphicon glyphicon-time "></i>
                            <span class="title">Shift History</span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "orgShiftExpenses") ? "active" : ""; ?>">
                            <a href="<?php echo $orgShiftExpense_link;?>" class="<?php echo(($url[0]=="viewshiftexpenses")? 'active':'');?>">
                            <i class="icon-diamond"></i>
                            <span class="title">Shift Expenses</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                    </ul>
               </li>
               <li class="menu-dropdown classic-menu-dropdown <?php echo ($url_name == "orgDetails" || $url_name == "listPaymentFactor" || $url_name == "listPaymentFactorType") ? "active" : ""; ?>">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="<?php echo $shiftList_link;?>" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                        <i class="fa fa-usd"></i>
                        <span class="title">Account</span>
                        <span class="selected"></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="<?php echo ($url_name == "listPaymentFactor") ? "active" : ""; ?>">
                            <a href="<?php echo $payment_rate_link;?>" class="<?php echo(($url[0]=="paymentRates")? 'active':'');?>">
                            <i class=" icon-credit-card "></i>
                            <span class="title">Payment Rate</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "listPaymentFactorType") ? "active" : ""; ?>">
                            <a href="<?php echo $payment_factor_link;?>" class="<?php echo(($url[0]=="paymentRates")? 'active':'');?>">
                            <i class=" icon-credit-card "></i>
                            <span class="title">Payment Factor Type</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="<?php echo ($url_name == "orgDetails") ? "active" : ""; ?>">
                            <a href="<?php echo $account_link;?>" class="<?php echo(($url[0]=="Account")? 'active':'');?>">
                                <i class="fa fa-usd"></i>
                                <span class="title">Account</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    </ul>
               </li>

               <?php include('top_menu.php');?>
        
                    <!-- *************************************************************************** -->    
                                <!-- <li <?php echo ($url_name == "assignShiftList") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $shift_assign_link;?>" class="<?php echo(($url[0]=="shiftAssign")? 'active':'');?>">
                                    <i class="glyphicon glyphicon-time "></i>
                                    <span class="title">Shift Assign</span>
                                    <span class="selected"></span>
                                    </a>
                                </li> -->
                              <!--   <li <?php echo ($url_name == "listTask") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $task_link; ?>" class="<?php echo(($url[0]=="tasks")? 'active':'');?>">
                                    <i class="icon-hourglass"></i>
                                    <span class="title">To-Do Task</span>
                                    <span class="selected"></span>
                                    </a>
                                </li> -->
            </ul>
        </div>
    </div>
</div>
