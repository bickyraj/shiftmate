
<li class="menu-dropdown classic-menu-dropdown <?php echo (($url_name[1]=="employee" && $url_name[2]=="myOrgBranchBoardDetail" || $url_name[1]=="ShiftUsers" && $url_name[2]=="myShiftCalendar" || $url_name[1]=="employee" && $url_name[2]=="orgView")) ? "active" : ""; ?>">
                <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                <i class="glyphicon glyphicon-time "></i>
                <span class="title">Department</span>
                <span class="selected"></span>
                <i class="fa fa-angle-down"></i>
                </a>
 <!-- <div class="hor-menu hor-menu-light hidden-sm hidden-xs"> -->
			<ul class="dropdown-menu">
				<!-- DOC: Remove data-hover="megadropdown" and data-close-others="true" attributes below to disable the horizontal opening on mouse hover -->
				
                 <!-- <li class="classic-menu-dropdown <?php if(@$url[2] == 'orgView'){echo 'active';}?>"><a href="<?php echo URL_VIEW . 'organizationUsers/employee/orgView?org_id='.$orgId.'&branch_id='.$branch_id;?>">Organization <?php if(@$url[2] == 'orgView'){echo '<span class="selected"></span>';}?></a></li> -->
                    <?php if(isset($board_id) && !empty($board_id)){?>   
                <li class="<?php if(@$url[2] == 'myOrgBranchBoardDetail'){echo 'active';}?>"><a href="<?php echo URL_VIEW . 'organizationUsers/employee/myOrgBranchBoardDetail?board_id='.$board_id.'&org_id='.$orgId.'&branch_id='.$branch_id;?>">Department Overview<?php if(@$url[2] == 'myOrgBranchBoardDetail'){echo '<span class="selected"></span>';}?></a></li>

                <li class="<?php if(@$url[2] == 'departmentCalendar'){echo 'active';}?>"><a href="<?php echo URL_VIEW . 'organizationUsers/employee/departmentCalendar?board_id='.$board_id.'&org_id='.$orgId.'&branch_id='.$branch_id;?>">Department Calendar<?php if(@$url[2] == 'departmentCalendar'){echo '<span class="selected"></span>';}?></a></li>

                <?php $arr = (array) $loginUserRelationToOther->board; $arr = array_keys($arr);?>
                <?php if(in_array($board_id, $arr)):?>
                  

                <?php endif;?>


                

                <?php } ?>
               <!-- <li>
                    <a href="<?php //echo URL_VIEW . 'organizationUsers/employee/myOrgBranchBoard?org_id='.$orgId.'&branch_id='.$branch_id;?>">Board</a> 
                </li> -->

                <!-- <li><a  class="active" href="<?php //echo URL_VIEW . 'organizations/changePassword?org_id=' . $organization->Organization->id; ?>">Shift</a></li> -->
				<?php if(isset($user_role) && $user_role == 'manager'){?>

              <li class="<?php if($url[1] == 'myShiftCalendar'){echo 'active';}?>"><a href="<?php echo URL_VIEW . 'ShiftUsers/assignShiftCalendar?org_id=' . $orgId .'&board_id='.$board_id.'&branch_id='.$branch_id; ?>">Manage Calendar<?php if($url[1] == 'myShiftCalendar'){echo '<span class="selected"></span>';}?></a></li>

                <li class="<?php if($url[1] == 'userShiftList'){echo 'active';}?>"><a href="<?php echo URL_VIEW . 'shifts/userShiftList?org_id=' . $orgId .'&board_id='.$board_id.'&branch_id='.$branch_id; ?>">Shift List<?php if($url[1] == 'userShiftList'){echo '<span class="selected"></span>';}?></a></li>

                <!-- <li class="<?php if($url[1] == 'userShiftAssigns'){echo 'active';}?>"><a href="<?php echo URL_VIEW . 'shifts/userShiftAssigns?org_id=' . $orgId .'&board_id='.$board_id.'&branch_id='.$branch_id;?>">Shift Schedule<?php if($url[1] == 'userShiftAssigns'){echo '<span class="selected"></span>';}?></a></li> -->

                <li class="<?php if($url[1] == 'shiftScheduleOverview'){echo 'active';}?>"><a href="<?php echo URL_VIEW . 'shifts/shiftScheduleOverview?org_id=' . $orgId .'&board_id='.$board_id.'&branch_id='.$branch_id; ?>">Shift Schedule Overview <?php if($url[1] == 'shiftScheduleOverview'){echo '<span class="selected"></span>';}?></a></li>
              <!--  <li class="<?php if($url[1] == 'userShiftList1'){echo 'active';}?>"><a href="#">Group</a></li> -->
                <?php } ?>
                
             </ul>
     <!-- </div> -->
 </li>
    
   