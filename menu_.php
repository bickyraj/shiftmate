<?php /*?><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script><?php */?>
<script type="text/javascript">
 $(document).ready(function()
    {
        $(".navigation > ul > li > a").hover(
            function()
            {
                 var e =$(this);
                 e.find("#ClickMenubtn").css(
                    {
                        'transform':'rotate(-90deg)'
                    });
              
            },
            function()
            {
                var e =$(this);
                 e.find("#ClickMenubtn").css(
                    {
                        'transform':'rotate(0deg)'
                    });
                
            });
        $(".navigation > ul > li > ul").hover(
            function()
            {
                 var e =$(this);
                 e.siblings("a").find("#ClickMenubtn").css(
                    {
                        'transform':'rotate(-90deg)'
                    });

            },
            function()
            {
                var e =$(this);
                 e.siblings("a").find("#ClickMenubtn").css(
                    {
                        'transform':'rotate(0deg)'
                    });
                
            });

    });
</script>

<?php
$schedule_active = '';
$dashboard_active = '';
if(isset($url) && !empty($url)){

          $url_name = $url[0];

       

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
$availability_link = URL_VIEW."useravailabilities/myAvailability";
$shift_link = URL_VIEW."shiftUsers/mySchedule";
$shift_wise_link = URL_VIEW."shiftUsers/viewShift";

$my_organizations_link = URL_VIEW."organizationUsers/employee/myOrganizations";

$message_link = URL_VIEW."users/employee/message";

$organizationMessage_link = URL_VIEW."users/employee/organizationMessage";
$boardMessage_link = URL_VIEW."users/employee/boardMessage";
$generalMessage_link = URL_VIEW."users/employee/generalMessage";
$my_holiday_link = URL_VIEW."holiday/myholiday";
$request_holiday_link = URL_VIEW."holiday/requestholiday";
$notice_link = URL_VIEW."users/noticeboard";

?>

<div class="leftMenu">
<!-- navigation -->
			<div class="navigation">
        		<ul>
                	<li>
                	<a href="<?php echo URL_VIEW;?>" class="<?php echo(($url[0]=="")? 'active':'');?>">
        			<img src="<?php echo URL_IMAGE;?>whiteHome.png" />
        			Dashboard
        			</a>
                	</li>
                </ul>
        	</div>

            <div class="navigation">
                <ul>
                    <li>
                        <a href="<?php echo URL_VIEW;?>users/employee/profile">
                        	<img src="<?php echo URL_IMAGE;?>whiteHome.png" />My Profile
                         </a>
                    </li>
                </ul>
            </div>
            
            <div class="navigation">
                	<ul>
                		<li>
                        	<a href="<?php echo $my_organizations_link;?>">
                                <img src="<?php echo URL_IMAGE;?>whiteHome.png" />
                        My Organizations</a>
                        </li>
                    </ul>
                </div>

        	 <div class="navigation">
        		<ul>
                	<li>

                          <a href="<?php echo $availability_link;?>">
                                <img src="<?php echo URL_IMAGE;?>whiteHome.png" />
                        Availability</a>
                </li>
                </ul>
        	</div> 

            
                
                <div class="navigation">
                	<ul>
                		<li>
                        	<a href="#<?php //echo $message_link;?>" class="">
                                <img src="<?php echo URL_IMAGE;?>whiteHome.png" />
                        Message</a>
                        <ul id="subMenu">
                    		<li><a href="<?php echo $organizationMessage_link;?>"><img src="<?php echo URL_IMAGE;?>whiteHome.png" />Organization Message</a></li>
                 			<li><a href="<?php echo $boardMessage_link;?>"><img src="<?php echo URL_IMAGE;?>whiteHome.png" />Board Message</a></li>
                            <li><a href="<?php echo $generalMessage_link;?>"><img src="<?php echo URL_IMAGE;?>whiteHome.png" />General Message</a></li>
                    	</ul>
                        </li>
                    </ul>
                </div>
                <div class="navigation">
                	<ul>
                		<li>
                        	<a href="#<?php //echo $message_link;?>" class="">
                                <img src="<?php echo URL_IMAGE;?>whiteHome.png" />
                        Holiday</a>
                        <ul id="subMenu">
                    		<li><a href="<?php echo $my_holiday_link;?>"><img src="<?php echo URL_IMAGE;?>whiteHome.png" />My Holiday</a></li>
                 			<li><a href="<?php echo $request_holiday_link;?>"><img src="<?php echo URL_IMAGE;?>whiteHome.png" />Request Holiday</a></li>
                           
                    	</ul>
                        </li>
                    </ul>
                </div>
                <div class="navigation">
                    <ul>
                        <li>
                            <a href="<?php echo $notice_link; ?>" class="">
                                <img src="<?php echo URL_IMAGE;?>whiteHome.png" />
                        Notice</a>
                           
                        </ul>
                        </li>
                    </ul>
                </div>
<?php /*?>
               

               <div class="navigation">
                	<ul>
                		<li>

                        	<a href="<?php echo $groupList_link;?>" class="<?php echo(($url[0]==("groups"))? 'active':'');?>">

                                <img src="<?php echo URL_IMAGE;?>whiteHome.png" />
                        Groups</a>
                        </li>
                    </ul>
                </div>

        	<div class="navigation">
            	<ul>
                	<li>
        				<a href="<?php echo $orgUser_link;?>" class="<?php echo(($url[0]=="organizationUsers")? 'active':'');?>">
        			<img src="<?php echo URL_IMAGE;?>whiteHome.png" />
        		Employee Management<!-- <span class="dropDownImage"><img src="<?php echo URL_IMAGE;?>subMenuDrop.png"/></span>--></a>
                		
                	</li>
               	 </ul>             
        	</div>

                <div class="navigation">
            	<ul>
                	<li>
        				<a href="#">
        			<img src="<?php echo URL_IMAGE;?>whiteHome.png" />
        		Staffs<input type="button" id="ClickMenubtn" /><!-- <span class="dropDownImage"><img src="<?php echo URL_IMAGE;?>subMenuDrop.png"/></span>--></a>
                		<ul id="subMenu">
                    		<li><a href="<?php echo $availability_link;?>"><img src="<?php echo URL_IMAGE;?>whiteHome.png" />Availabilities</a></li>
                 			<li><a href="<?php echo $shift_link;?>"><img src="<?php echo URL_IMAGE;?>whiteHome.png" />Indivisual Shifts</a></li>
                            <li><a href="<?php echo $shift_wise_link;?>"><img src="<?php echo URL_IMAGE;?>whiteHome.png" />Shifts Wise View</a></li>
                    	</ul>
                	</li>
               	 </ul>             
        	</div><?php */?>

                
            
          

        	
<!-- end navigation -->

</div>





