<?php
$orgId = $_GET['org_id'];
$branch_id = $_GET['branch_id'];

$url = URL . "OrganizationUsers/myOrgProfile/" .$user_id. "/".$orgId."/" . $branch_id . ".json";
$data = \Httpful\Request::get($url)->send();
$myOrgProfile = $data->body->myOrgProfile;
// echo "<pre>";
// print_r($myOrgProfile);
// die();
?>

<!-- <h1>My Organizations</h1> -->
<div class="tableHeader">
    <div class="profile branchprofile">

      <!--   <div class="profile_heading2">Organization Detail</div> -->
    <div class="submenu">
        <ul>
            <li><a href="">Organization Detail</a></li>
            <li><a href="">Branch Detail</a></li>
        </ul>
    </div>
        <!-- Table -->


        <div class="basic-info">
            <table>
            <!-- <tr>
                <th class="profileHeader" colspan="2">Basic Info</th>
            </tr> -->
            <tr>
                <th>Organization Name <span> -</span></th>
                <td><?php echo $myOrgProfile->Organization->title;?></td>
            </tr>

            <tr>
                <th>Name <span> -</span></th>
                <td><?php echo $myOrgProfile->User->fname." ".$myOrgProfile->User->lname;?></td>
            </tr>
           

            <tr>
                <th>Designation<span>-</span></th>
                <td><?php echo $myOrgProfile->OrganizationUser->designation;?></td>
            </tr>

            <tr>
                <th>Joining Date<span>-</span></th>
                <td><?php echo $myOrgProfile->OrganizationUser->hire_date;?></td>
            </tr>

            <tr>
                <th>Wage<span>-</span></th>
                <td>$<?php echo $myOrgProfile->OrganizationUser->wage;?> per hour </td>
            </tr>

            <tr>
                <th>Weekly per hour<span>-</span></th>
                <td><?php echo $myOrgProfile->OrganizationUser->max_weekly_hour;?> hours</td>
            </tr>

        </table>
    </div>

    <!-- End of Table -->
</div>

<!-- <div class="profile branchprofile">
    <div class="profile_heading2">Branch Detail</div> -->
        <!-- Table -->

<!-- 
        <div class="basic-info">
            <table>
            <tr>
                <th>Branch<span>-</span></th>
                <td><?php echo $myOrgProfile->Branch->title;?></td>
            </tr>

            <tr>
                <th>Email<span>-</span></th>
                <td><?php echo $myOrgProfile->Branch->email;?></td>
            </tr>

            <tr>
                <th>Phone<span>-</span></th>
                <td><?php echo $myOrgProfile->Branch->phone;?></td>
            </tr>

            <tr>
                <th>Address<span>-</span></th>
                <td><?php echo $myOrgProfile->Branch->address;?></td>
            </tr>

        </table>
    </div>



</div>

 -->

<div class="clear"></div>
<?php
$start_date = 0000-00-00;
$end_date = 0000-00-00;
// data for last fortnight
$fortnight = date_duration_last(14);
$start_date = $fortnight[0];
$end_date = $fortnight[1];

$lastFortnight = myOrgShiftRange_url($user_id, $orgId,$branch_id, $start_date, $end_date);

$lastFortnight_hour_worked = hourCalculator($lastFortnight);

$start_date = 0000-00-00;
$end_date = 0000-00-00;
// data for last week
$last_week = date_duration_last(7);
$start_date = $last_week[0];
$end_date = $last_week[1];

$lastWeek = myOrgShiftRange_url($user_id, $orgId, $branch_id, $start_date, $end_date);
//echo "<pre>";
//print_r($lastWeek);
//$lastWeek_hour_worked = hourCalculator($lastWeek);

$lastWeekDetail = priceCalculator($user_id, $orgId, $branch_id, $start_date, $end_date);
//echo "<pre>";
//print_r($lastWeekDetail);
//die();



$start_date = 0000-00-00;
$end_date = 0000-00-00;
// data for current week
$current_week = date_duration_current();
$start_date = $current_week[0];
$end_date = $current_week[1];
//$currentWeek = myOrgShiftRange_url($user_id, $orgId, $branch_id, $start_date, $end_date);

//$currentWeek_hour_worked = hourCalculator($currentWeek);
$currentWeekDetail = priceCalculator($user_id, $orgId, $branch_id, $start_date, $end_date);
//echo "<pre>";
//print_r($currentWeekDetail);

?>

<div class="profile_outer_div"><div class="profile_heading">Report</div></div>

<table>
	<tr>
    	<td>Total hour worked for the week :</td>
        <td><?php if(isset($currentWeekDetail['hour_worked']) && !empty($currentWeekDetail['hour_worked'])) {echo $currentWeekDetail['hour_worked'];} else {echo '0';}?> hours</td>
     </tr>
     <tr>
     	<td>Remaining hour for the week :</td>
        <td><?php if(isset($currentWeekDetail['hour_worked']) && !empty($currentWeekDetail['hour_worked'])) { echo $myOrgProfile->OrganizationUser->max_weekly_hour - $currentWeekDetail['hour_worked']; } else { echo $myOrgProfile->OrganizationUser->max_weekly_hour;}?> hours</td>
     </tr>
</table>

<div class="profile_outer_div"><div class="profile_heading">Account</div></div>

<table>
	<tr>
    	<td>Last week :</td>
        <td>$<?php echo $lastWeekDetail['total_cost'];?></td>
     </tr>
     <tr>
     	<td>Current week :</td>
        <td>$<?php echo $currentWeekDetail['total_cost'];?></td>
     </tr>
</table>

