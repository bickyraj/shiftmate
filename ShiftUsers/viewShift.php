<!-- tableHeader -->
<?php
//  for calender for today, week, fortnight , month, depending the parameter
	 if(isset($_GET['type']) && !empty($_GET['type'])){
		 $calender_layout_type = $_GET['type'];
	 }else{
		$calender_layout_type = 7; 
	 }
	 	
	if(isset($_GET['show'])){
		if($_GET['show']=='prev'){
			
				$starting_date = $_GET['sDate'];		
				$date_change_value =  3600*24*$calender_layout_type;
				$today_date = date('Y-m-d', strtotime($starting_date) - $date_change_value);
				
				
			
		}
		if($_GET['show']=='next'){
				
				$ending_date = $_GET['eDate'];
				//$date_change_value =  3600*24*$calender_layout_type;
				$today_date = date('Y-m-d', strtotime($ending_date) + 3600*24);
			
		}
		
	}else{
		$today_date = date('Y-m-d');
	}
	$layoutFormat = weekLayout($today_date, $calender_layout_type);
	$newdays = $layoutFormat[0];
	$duration = $layoutFormat[1];
	$duration_name = $layoutFormat[2];
	$starting_date = $layoutFormat[3];
	$ending_date = $layoutFormat[4];
	
	if(isset($_GET['org_id']) && !empty($_GET['org_id'])){
	$organization_id = $_GET['org_id'];
	}else{
		$organization_id = $orgId;	
	}
	
	$board_id = $_GET['board_id'];
	
	
?>
			<div class="tableHeader">
           		<div class="blueHeader assignheader">
					<img src="<?php echo URL_IMAGE;?>CalenderIcon.png" alt="calender icon" />
					<span style="margin:10px 15px 0 0; float:left;">Calender  <span style="font-size:14px; margin-left:5px"><?php echo date('M Y');?></span></span>

					<ul class="subNav">
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/viewShift?org_id=<?php echo $organization_id;?>&board_id=<?php echo $board_id;?>&type=<?php echo $calender_layout_type;?>&show=prev&sDate=<?php echo $starting_date;?>"> < </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/viewShift?org_id=<?php echo $organization_id;?>&board_id=<?php echo $board_id;?>&type=<?php echo $calender_layout_type;?>&show=next&eDate=<?php echo $ending_date;?>"> > </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/viewShift?org_id=<?php echo $organization_id;?>&board_id=<?php echo $board_id;?>&type=1"> Today </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/viewShift?org_id=<?php echo $organization_id;?>&board_id=<?php echo $board_id;?>&type=7"> Week </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/viewShift?org_id=<?php echo $organization_id;?>&board_id=<?php echo $board_id;?>&type=15"> Fortnight </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/viewShift?org_id=<?php echo $organization_id;?>&board_id=<?php echo $board_id;?>&type=30"> Month </a></li>
					</ul>
				</div>
				<br/>

<div class="clear"></div>

<?php
	// for organization shift list
	$url_org_shift_list = URL."ShiftUsers/organizationShiftList/".$organization_id.".json";
	$r_org_shift_list = \Httpful\Request::get($url_org_shift_list)->send();
	$organization_shifts = $r_org_shift_list->body->message->shiftList;
	//print_r($organization_shifts);
	
	// for board employee list
	$url_board_emp_list = URL."BoardUsers/boardEmployeeList/".$board_id.".json";
	$r_board_emp_list = \Httpful\Request::get($url_board_emp_list)->send();
	$board_employees = $r_board_emp_list->body->message->employeeList;
	
	$classname = '';
	// for boards shift user list
	$url_1 = URL."ShiftUsers/userShift/".$board_id.".json";
	$r_1 = \Httpful\Request::get($url_1)->send();
	$user_shifts = $r_1->body->message;
	//print_r($user_shifts);die();
	foreach($user_shifts as $user_shift){
		$user_shift_datewise[$user_shift->ShiftUser->shift_id][$user_shift->ShiftUser->shift_date][] = $user_shift;	
		
	}
	
	// for permanent shift
	$url_p = URL."Permanentshifts/permanentlist/".$board_id.".json";
	$r_p = \Httpful\Request::get($url_p)->send();
	$user_permanent_shifts = $r_p->body->message;
	//print_r($user_permanent_shifts);
	foreach($user_permanent_shifts as $permanent_shift){
		$user_shift_permanent[$permanent_shift->Permanentshift->shift_id][$permanent_shift->Permanentshift->day_id][] = $permanent_shift->User;	
	}
	foreach($board_employees as $employee_avail){
		// for user availability
		$url = URL."Useravailabilities/userAvailability/".$employee_avail->User->id.".json";
		$r = \Httpful\Request::get($url)->send();
		$user_availability = $r->body->message;
		foreach($user_availability as $availability){
			$availability_day[$employee_avail->User->id][$availability->Useravailability->day_id]['organization_id'] = $availability->Useravailability->organization_id;
			$availability_day[$employee_avail->User->id][$availability->Useravailability->day_id]['status'] = $availability->Useravailability->status;
		}
	}
	
?>

<div id="drop">
<div class="schedule_table">
<table class="schedule_table" width="98%" align="center">
  <tr class="week-heading">
    <th><p>Week 2</p><p>(<?php echo $duration;?>)</p></th>
   <?php 
   $date_change_value = 0;
   foreach($newdays as $dayKey=>$dayVal){
	   foreach($dayVal as $k=>$v){
	?>
    <th>
		<?php echo $v['day_date']; $dynamicDayFormat[$v['date']] = $k;?>
    	
    </th>
   <?php }} ?> 
  
  </tr>
<?php

foreach($organization_shifts as $organization_shift){
?>
	<tr>
    	<th><p class="shift_p"><?php echo $organization_shift->Shift->title;?></p><p class="shift_time">(<?php echo $organization_shift->Shift->starttime." - ".$organization_shift->Shift->endtime;?>)</p></th>
        <?php foreach($dynamicDayFormat as $dayFormatKey=>$dayFormatVal){?>
		<td>
        <?php
			if(isset($user_shift_permanent[$organization_shift->Shift->id][$dayFormatVal]) && !empty($user_shift_permanent[$organization_shift->Shift->id][$dayFormatVal])){
			foreach($user_shift_permanent[$organization_shift->Shift->id][$dayFormatVal] as $permanent_shift){
				//echo $permanent_shift->title."<br>(".$permanent_shift->starttime." - ".$permanent_shift->endtime.")<br>";
				//echo '<div id="'.$permanent_shift->id.'" class="confirm_div">'.$permanent_shift->starttime.' - '.$permanent_shift->endtime.'<div class="blueBorder"></div>'.$permanent_shift->title.'</div>';
				echo '<div id="'.$permanent_shift->id.'" class="confirm_div"><span>'.$permanent_shift->fname.' '.$permanent_shift->lname.'</span></div>';
			}
		}
		
		if(isset($user_shift_datewise[$organization_shift->Shift->id][$dayFormatKey]) && !empty($user_shift_datewise[$organization_shift->Shift->id][$dayFormatKey])){
			foreach($user_shift_datewise[$organization_shift->Shift->id][$dayFormatKey] as $user_per_shift){
				if($user_per_shift->ShiftUser->status == 1){
					$classname = 'waiting_div';	
					$type_name = "Waiting";
					//$waiting_id = $user_per_shift->Shift->id.'_'.$employee->User->id.'_'.$dayFormatKey;
				}elseif($user_per_shift->ShiftUser->status == 2){
					$classname = 'pending_div confirmPopup';
					//$waiting_id = $user_per_shift->ShiftUser->id;
					$type_name = "Pending";
				}elseif($user_per_shift->ShiftUser->status == 0){
					$classname = 'open_div';	
					//$waiting_id = $user_per_shift->ShiftUser->id;
					$type_name = "Open";
				}
				else{
					$classname = 'confirm_div';
					//$waiting_id = $user_per_shift->Shift->id.'_'.$employee->User->id.'_'.$dayFormatKey;
					$type_name = "Confirm";
				}
				//echo '<div id="'.$waiting_id.'" class="'.$classname.'"><span>'.$type_name.'</span><p>'.$user_per_shift->Shift->starttime.' - '.$user_per_shift->Shift->endtime.'</p></div>';
				echo '<div class="'.$classname.'"><span>'.$user_per_shift->User->fname.' '.$user_per_shift->User->lname.'</span></div>';
			
	}
		}
        ?>
        </td>	
		<?php } ?>	
    </tr>
<?php	
} ?>

	

</table>
</div>
</div>



