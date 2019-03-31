<?php /*?><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script><?php */?>

<?php
$schedule_active = '';
$dashboard_active = '';

$url_name = null;
if(isset($url) && !empty($url)){
          /*$url_name = $url[1];
          $url_name1 = $url[2];*/

          $url_name = $url;
          //print_r(count($url));
          /* print_r($url_name);
           print_r('<br>');
          print_r($url_name1);*/
       

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

/*$branchList_link = URL_VIEW."branches/listBranches?org_id=".$orgId;
$shiftList_link = URL_VIEW."shifts/listShifts?org_id=".$orgId;
$boardList_link = URL_VIEW."boards/listBoards?org_id=".$orgId;
$groupList_link = URL_VIEW."groups/listGroups?org_id=".$orgId;
$orgProfile = URL_VIEW."organizations/orgView?org_id=".$orgId;*/
$shiftList_link = URL_VIEW."shifts/listShifts?org_id=".$orgId;

$availability_link = URL_VIEW."useravailabilities/myAvailability";
$shift_link = URL_VIEW."shiftUsers/mySchedule";
$shift_wise_link = URL_VIEW."shiftUsers/viewShift";
$todays_shift_link = URL_VIEW."myShifts/todaysShift";

$my_organizations_link = URL_VIEW."organizationUsers/employee/myOrganizations";

$message_link = URL_VIEW."users/employee/message";

$message_link = URL_VIEW."messages/employeeInbox";
$boardMessage_link = URL_VIEW."users/employee/boardMessage";
$generalMessage_link = URL_VIEW."users/employee/generalMessage";
$my_holiday_link = URL_VIEW."holiday/myholiday";
$holiday_link = URL_VIEW."leaveholidays/holiday";
$notice_link = URL_VIEW."users/noticeboard";

$feed_link = URL_VIEW."feedback/employerFeedback";
$myfeed_link = URL_VIEW."feedback/myFeedback";
$leave_link = URL_VIEW."leaverequests/myLeaveRequest";
$new_leave_link = URL_VIEW."leaverequests/newLeaveRequest";
$requestTimeOff = URL_VIEW."leaverequests/requestTimeOff";
$viewRequestTimeOff = URL_VIEW."leaverequests/allRequestTimeOff";

$myShifts_link = URL_VIEW."myShifts/myShifts";
$myShiftCalendar_link = URL_VIEW."myShifts/myShiftCalendar";

// Manohar
$jobagreement_link = URL_VIEW."jobagreements/agreementlist";

$userviewInduction_link = URL_VIEW."inductionChecklist/userviewInduction";

$my_review_link = URL_VIEW."reviews/myReview";
//$task_link = URL_VIEW."tasks/listTask";

// end

 //ashok shrestha

 $shiftHistory_link = URL_VIEW."shifthistories/viewShiftHistory";
 $userShiftExpense_link = URL_VIEW."viewshiftexpenses/userShiftExpenses";
 $paymentFactors = URL_VIEW."factors/userFactors";
  // 


 // shift swap
$shiftswap_link = URL_VIEW."shiftswaps/shiftswap";
 // end

//Ashok Neupane
$open_shifts=URL_VIEW."shiftplans/showOpenPlans";
$closed_shifts=URL_VIEW."shiftplans/showClosedPlans";
$calendar=URL_VIEW."calendar/showCalendar";
$account_link = URL_VIEW."Account/Details";
//

//manohar khadka
$departments_link = URL_VIEW."boards/listDepartments";
?>
<!-- BEGIN SIDEBAR -->
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
                <li class="menu-dropdown <?php echo (!$url_name) ? "start active open" : ""; ?>">
                    <a href="<?php echo URL_VIEW;?>" class="<?php echo(($url[0]=="users")? 'active':'');?>">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="menu-dropdown classic-menu-dropdown <?php echo ($url_name[1] == "showOpenPlans" || $url_name[1] == "showClosedPlans"  || $url_name[1]=="myShifts" || $url_name[1]=="myShiftCalendar" || $url_name[1]=="viewShiftHistory" || $url_name[1]=="userShiftExpenses" || $url_name[1]=="shiftswap") ? "active" : ""; ?>">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="<?php echo $shiftList_link;?>" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                    <i class="glyphicon glyphicon-time "></i>
                    <span class="title">Shift</span>
                    <span class="selected"></span>
                    <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-left">
                        <li class=" dropdown-submenu <?php if($url_name[1] == "showOpenPlans" || $url_name[1] == "showClosedPlans"){echo "active";} ?>">
                            <a href="javascript:;">
                            <i class="glyphicon glyphicon-time"></i>
                            <span class="title">Shift Plans</span>
                            <span class="selected"></span>
                            <span class="arrow"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li <?php echo ($url_name[1] == "showOpenPlans") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $open_shifts;?>" class="<?php echo(($url[0]=="shiftplans")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                    Open Shifts
                                    <span class="selected"></span></a>
                                </li>
                                <li <?php echo ($url_name[1] == "showClosedPlans") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $closed_shifts;?>" class="<?php echo(($url[0]=="shiftplans")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                  Closed Shifts
                                  <span class="selected"></span>
                                  </a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php echo (!$url_name) ? "" : ($url_name[1]=="shiftswap") ? "active" : ""; ?>">
                            <a href="<?php echo $shiftswap_link; ?>" class="<?php echo(($url[0]=="shiftswaps")? 'active':'');?>">
                            <i class="glyphicon glyphicon-time"></i>
                            <span class="title">Shift Swap</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li class="<?php echo (!$url_name) ? "" : ($url_name[1]=="userShiftExpenses") ? "active" : ""; ?>">
                            <a href="<?php echo $userShiftExpense_link; ?>" class="<?php echo(($url[0]=="viewshiftexpenses")? 'active':'');?>">
                            <i class="glyphicon glyphicon-time"></i>
                            <span class="title">Shift Expenses</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li <?php echo (!$url_name) ? "" : ($url_name[1]=="viewShiftHistory") ? "class='active'" : ""; ?>>
                            <a href="<?php echo $shiftHistory_link; ?>" class="<?php echo(($url[0]=="shifthistories")? 'active':'');?>">
                            <i class="glyphicon glyphicon-time"></i>
                            <span class="title">Shift History</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li <?php echo (!$url_name) ? "" : ($url_name[1]=="myShifts") ? "class='active'" : ""; ?>>
                            <a href="<?php echo $myShifts_link; ?>" class="<?php echo(($url[0]=="myShifts")? 'active':'');?>">
                            <i class="glyphicon glyphicon-time "></i>
                            <span class="title">My Shifts</span>
                            <span class="selected"></span>
                            </a>
                        </li>

                        <li <?php echo (!$url_name) ? "" : ($url_name[1]=="myShiftCalendar") ? "class='active'" : ""; ?>>
                            <a href="<?php echo $myShiftCalendar_link; ?>" class="<?php echo(($url[0]=="myShifts")? 'active':'');?>">
                            <i class="glyphicon glyphicon-time "></i>
                            <span class="title">My Shift Calendar</span>
                            <span class="selected"></span>
                            </a>
                        </li>

                        <li <?php echo (!$url_name) ? "" : ($url_name[1]=="todaysShift") ? "class='active'" : ""; ?>>
                            <a href="<?php echo $todays_shift_link; ?>" class="<?php echo(($url[0]=="myShifts")? 'active':'');?>">
                            <i class="glyphicon glyphicon-time "></i>
                            <span class="title">Today's Shifts</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-dropdown classic-menu-dropdown <?php echo (($url_name[1]=="Details" || $url_name[1]=="employee" && $url_name[2]=="profile") || $url_name[1]=="myAvailability" || $url_name[1] == "myReview") ? "active" : ""; ?>">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="<?php echo $shiftList_link;?>" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                    <i class="icon-user "></i>
                    <span class="title">My Account</span>
                    <span class="selected"></span>
                    <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-left">
                        <li  <?php echo (!$url_name) ? "" : ($url_name[1]=="employee" && $url_name[2]=="profile") ? "class='active'" : ""; ?>>
                            <a href="<?php echo URL_VIEW;?>users/employee/profile" class="<?php echo(($url[0]=="users")? 'active':'');?>">
                            <i class="icon-user "></i>
                            <span class="title">My Profile</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li  <?php echo (!$url_name) ? "" : ($url_name[1]=="myAvailability") ? "class='active'" : ""; ?>>
                            <a href="<?php echo $availability_link;?>" class="<?php echo(($url[0]=="useravailabilities")? 'active':'');?>">
                            <i class="glyphicon glyphicon-ok-circle "></i>
                            <span class="title">Availability</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li  <?php echo (!$url_name) ? "" : ($url_name[1]=="myReview") ? "class='active'" : ""; ?>>
                            <a href="<?php echo $my_review_link;?>" class="<?php echo(($url[0]=="reviews")? 'active':'');?>">
                            <i class="glyphicon glyphicon-ok-circle "></i>
                            <span class="title">Review</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <?php if(!empty($loginUserRelationToOther->userOrganization)):?>
                             <li class="menu-dropdown <?php echo ($url_name[1] == "Details") ? "active open" : ""; ?>">
                                <a href="<?php echo $account_link;?>" class="<?php echo(($url[0]=="Account")? 'active':'');?>">
                                <i class="fa fa-usd"></i>
                                <span class="title">My Figures</span>
                                <span class="selected"></span>
                                </a>
                            </li>
                        <?php endif;?>
                    </ul>
                </li>
                <li class="menu-dropdown classic-menu-dropdown <?php echo (($url_name[1]=="employee" && $url_name[2]=="myOrganizations" || ($url_name[1]=="employee" && $url_name[2]=="inboxMessages") || $url_name[1]=="noticeboard" || $url_name[1]=="employerFeedback" || $url_name[1] == "myLeaveRequest" || $url_name[1] == "agreementlist" || $url_name[1] == "newLeaveRequest")) ? "active" : ""; ?>">
                    <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="<?php echo $shiftList_link;?>" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                    <i class="glyphicon glyphicon-time "></i>
                    <span class="title">Organisations</span>
                    <span class="selected"></span>
                    <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-left">
                        <li  <?php echo (!$url_name) ? "" : ($url_name[1]=="employee" && $url_name[2]=="myOrganizations") ? "class='active'" : ""; ?>>
                            <a href="<?php echo $my_organizations_link;?>" class="<?php echo(($url[0]=="organizationUsers")? 'active':'');?>">
                            <i class="fa fa-building  "></i>
                            <span class="title">My Organisations</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                        <li  <?php echo (!$url_name) ? "" : ($url_name[1]=="boards" && $url_name[2]=="myDepartments") ? "class='active'" : ""; ?>>
                            <a href="<?php echo $departments_link;?>" class="<?php echo(($url[0]=="organizationUsers")? 'active':'');?>">
                            <i class="fa fa-building  "></i>
                            <span class="title">My Departments</span>
                            <span class="selected"></span>
                            </a>
                        </li>

                        <li <?php echo (!$url_name) ? "" : ($url_name[1]=="agreementlist") ? "class='active'" : ""; ?>>
                            <a href="<?php echo $jobagreement_link; ?>" class="<?php echo(($url[0]=="jobagreements")? 'active':'');?>">
                            <i class="icon-link"></i>
                            <span class="title">Job Agreement</span>
                            <span class="selected"></span>
                            </a>
                        </li>
                                <li <?php echo (!$url_name) ? "" : ($url_name[1]=="employee" && $url_name[2]=="inboxMessages") ? "class='active'" : ""; ?>>
                            <a href="<?php echo $message_link;?>" class="<?php echo(($url[0]=="users")? 'active':'');?>">
                                <i class="icon-envelope-open"></i>
                                <span class="title">Message</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li <?php echo (!$url_name) ? "" : ($url_name[1]=="noticeboard") ? "class='active'" : ""; ?>>
                            <a href="<?php echo $notice_link; ?>" class="<?php echo(($url[0]=="users")? 'active':'');?>">
                            <i class="glyphicon glyphicon-pushpin "></i>
                            <span class="title">Notice</span>
                            <span class="selected"></span>
                            </a>
                        </li>

                        <li class="dropdown-submenu <?php echo ($url_name[1] == "employerFeedback" || $url_name[1] == "myFeedback") ? "active":""; ?>">
                            <a href="javascript:;">
                            <i class="fa fa-umbrella "></i>
                            <span class="title">Feedback</span>
                            <span class="selected"></span>
                            <span class="arrow"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li <?php echo ($url_name[1] == "employerFeedback") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $feed_link; ?>" class="<?php echo(($url[0]=="feedback")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                    My Feeds
                                    <span class="selected"></span></a>
                                </li>
                                <li <?php echo ($url_name[1] == "myFeedback") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $myfeed_link;?>" class="<?php echo(($url[0]=="feedback")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                  Others Feedback
                                  <span class="selected"></span>
                                  </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu <?php echo ($url_name[1] == "requestTimeOff" || $url_name[1] == "allRequestTimeOff") ? "active":""; ?>">
                            <a href="javascript:;">
                            <i class="fa fa-umbrella "></i>
                            <span class="title">Leave</span>
                            <span class="selected"></span>
                            <span class="arrow"></span>
                            </a>
                            <ul class="dropdown-menu">
                                
                                <!-- <li <?php echo ($url_name[1] == "myLeaveRequest") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $leave_link; ?>" class="<?php echo(($url[0]=="leaverequests")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                    My requests
                                    <span class="selected"></span></a>
                                </li>
                                <li <?php echo ($url_name[1] == "newLeaveRequest") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $new_leave_link;?>" class="<?php echo(($url[0]=="leaverequests")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                  New request
                                  <span class="selected"></span>
                                  </a>
                                </li> -->

                                <li <?php echo ($url_name[1] == "requestTimeOff") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $requestTimeOff;?>" class="<?php echo(($url[0]=="leaverequests")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                  Request Time Off
                                  <span class="selected"></span>
                                  </a>
                                </li>
                                <li <?php echo ($url_name[1] == "allRequestTimeOff") ? "class = 'active'" : ""; ?>>
                                    <a href="<?php echo $viewRequestTimeOff;?>" class="<?php echo(($url[0]=="leaverequests")? 'active':'');?>">
                                    <i class="icon-tag"></i>
                                  All Request Time Off
                                  <span class="selected"></span>
                                  </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="menu-dropdown <?php echo (!$url_name) ? "" : ($url_name[1]=="showCalendar") ? "active" : ""; ?>">
                    <a href="<?php echo $calendar; ?>" class="<?php echo(($url[0]=="calendar")? 'active':'');?>">
                    <i class="glyphicon glyphicon-calendar"></i>
                    <span class="title">Calendar</span>
                    </a>
                </li>

            
                <?php include('top_menu.php');?>
                
          <!--      <li <?php echo (!$url_name) ? "" : ($url_name[1]=="agreementlist") ? "class='active'" : ""; ?>>
                    <a href="<?php echo $jobagreement_link; ?>" class="<?php echo(($url[0]=="jobagreements")? 'active':'');?>">
                    <i class="icon-link"></i>
                    <span class="title">Job Agreement</span>
                    <span class="selected"></span>
                    </a>
                </li>

                <li <?php echo (!$url_name) ? "" : ($url_name[1]=="userviewInduction") ? "class='active'" : ""; ?>>
                    <a href="<?php echo $userviewInduction_link; ?>" class="<?php echo(($url[0]=="inductionChecklist")? 'active':'');?>">
                    <i class="glyphicon glyphicon-list-alt"></i>
                    <span class="title">Induction Checklist</span>
                    <span class="selected"></span>
                    </a>
                </li> -->
            </ul>
        </div>
    </div>
</div>


                
        




