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

$branchList_link = URL_VIEW."branches/listBranches?org_id=".$orgId;
$shiftList_link = URL_VIEW."shifts/listShifts?org_id=".$orgId;
$boardList_link = URL_VIEW."boards/listBoards?org_id=".$orgId;
$groupList_link = URL_VIEW."groups/listGroups?org_id=".$orgId;
$orgProfile = URL_VIEW."organizations/orgView?org_id=".$orgId;
$availability_link = URL_VIEW."useravailabilities/updateEmployeeAvailabilities?user_id=6";
$shift_link = URL_VIEW."shiftUsers/mySchedule";
$shift_wise_link = URL_VIEW."shiftUsers/viewShift";


$orgUser_link = URL_VIEW."organizationUsers/listOrganizationEmployees?org_id=".$orgId;

$holiday_link = URL_VIEW."organizationfunctions/listHoliday?org_id=".$orgId;

$payment_rate_link = URL_VIEW."paymentRates/listPaymentFactor?org_id=".$orgId;
/*
Add br rabi*/
$add_country = URL_VIEW."country/add_country";

$add_city = URL_VIEW."country/add_city";

?>

<div class="leftMenu">
<!-- navigation -->
			<div class="navigation">
        		<ul>
                	<li>
                	<a href="<?php echo URL_VIEW;?>" class="<?php echo(($url[0]=="")? 'active':'');?>">
        			<img src="<?php echo URL_IMAGE;?>whiteHome.png" />
        			Organization
        			</a>
                	</li>
                </ul>
        	</div>

        	
			<div class="navigation">
            	<ul>
                	<li>
        				<a href="<?php echo $add_country;?>" class="">
        				<img src="<?php echo URL_IMAGE;?>whiteHome.png" />
        				Add Country</a>
                		
                	</li>
               	 </ul>             
        	</div>
            <div class="navigation">
            	<ul>
                	<li>
        				<a href="<?php echo $add_city;?>" class="">
        				<img src="<?php echo URL_IMAGE;?>whiteHome.png" />
        				Add City</a>
                		
                	</li>
               	 </ul>             
        	</div>  
            
          

        	
<!-- end navigation -->

</div>





