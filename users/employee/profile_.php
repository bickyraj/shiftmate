<?php
$url = URL ."Users/myProfile/".$user_id.".json";
$org = \Httpful\Request::get($url)->send();

$userDetail = $org->body->userDetail;
if(empty($userDetail))
{
	echo "<br/>";
	echo "An error occured in Server. Please contact the server administrator.";
	die();
}

?>

<a href="<?php echo URL_VIEW."employees/editEmployeeDetail?user_id=".$user_id;?>">Edit Profile</a>
<div class="clear"></div>
<div class="margin-top"></div>
<div class="breadcrum">
	<a href="#">Home</a>
		> 
	<a href="#">Profile</a>
</div>
<div class="clear"></div>

<div class="content">
	<div class="profile-sidebar">
	<div class="portlet">
		<div class="profile-userpic">
			<img src='<?php echo URL."webroot/files/user/image/".$userDetail->User->image_dir."/thumb2_".$userDetail->User->image;?>'/>
		</div>
		<div class="profile-usertitle-name">
			<?php echo $userDetail->User->fname." ".$userDetail->User->lname;?>
		</div>
		<div class="basic-info">
			<ul>
				<li><label>Username - </label>
					<?php echo $userDetail->User->username;?>
				</li>
				<li><label>Email - </label>
					<?php echo $userDetail->User->email;?>
				</li>
				<li><label>Phone No. - </label>
					<?php echo $userDetail->User->phone;?>
				</li>
				<li><label>Birth Date - </label>
					<?php echo $userDetail->User->dob;?>
				</li>
				<li><label>Address - </label>
					<?php echo $userDetail->User->address;?>
				</li>
				<li><label>City - </label>
					<?php echo $userDetail->City->title;?>
				</li>
				<li><label>State - </label>
					<?php echo $userDetail->User->state;?>
				</li>
				<li><label>Country - </label>
					<?php echo $userDetail->Country->title;?>
				</li>
			</ul>
		</div>
	</div><!--portlet-->
	</div><!--End profile-sidebar -->
	<div class="profile-content">
		<div class="portlet">
			<div class="portlet-title">
				<span>Earning</span>
			</div>
			<div class="table-scrollable">
				<?php
						$start_date = 0000-00-00;
						$end_date = 0000-00-00;
						// data for last week
						$last_week = date_duration_last(7);
						$start_date_last = $last_week[0];
						$end_date_last = $last_week[1];
						$myOrganizationLists = getEmployeeOrganizations($user_id);
							
						$priceCalculateOrgBranches_lastWeek = priceCalculateOrgBranches($user_id, $start_date_last, $end_date_last);
						//print_r($priceCalculateOrgBranches_lastWeek);
						
						$priceCalculateOrgBranchesPermanent_lastWeek = priceCalculateOrgBranchesPermanent($user_id, $start_date_last, $end_date_last);
						
						//print_r($priceCalculateOrgBranchesPermanent_lastWeek);
						$current_week = date_duration_current();
						$start_date_current = $current_week[0];
						$end_date_current = $current_week[1];
						
						$priceCalculateOrgBranches_currentWeek = priceCalculateOrgBranches($user_id, $start_date_current, $end_date_current);
						//print_r($priceCalculateOrgBranches_currentWeek);
						
						$priceCalculateOrgBranchesPermanent_currentWeek = priceCalculateOrgBranchesPermanent($user_id, $start_date_current, $end_date_current);
						//print_r($priceCalculateOrgBranchesPermanent_currentWeek);
						
						$total_earning_currentWeek = $priceCalculateOrgBranches_currentWeek->total_cost + $priceCalculateOrgBranchesPermanent_currentWeek->total_cost;
						$total_hour_worked_currentWeek = $priceCalculateOrgBranches_currentWeek->hour_worked + $priceCalculateOrgBranchesPermanent_currentWeek->hour_worked;
						
						$total_earning_lastWeek = $priceCalculateOrgBranches_lastWeek->total_cost + $priceCalculateOrgBranchesPermanent_lastWeek->total_cost;
						$total_hour_worked_lastWeek = $priceCalculateOrgBranches_lastWeek->hour_worked + $priceCalculateOrgBranchesPermanent_lastWeek->hour_worked;
				?>
				<table class="table table-light">
					<thead>
					<tr class="uppercase">
						<th></th>
				    	<th>Current Week Earning</th>
				        <th>Last Week Earning</th>
				    </tr>
				   </thead>
				   <tbody>
				   <tr>
				    	<th  class="uppercase">Worked Hours</th>
				        <td><?php echo $total_hour_worked_currentWeek;?> Hours</td>
				        <td><?php echo $total_hour_worked_lastWeek;?> Hours</td>
				    </tr>
				    <tr>
				    	<th  class="uppercase">Earning</th>
				        <td>$<?php echo $total_earning_currentWeek;?></td>
				        <td>$<?php echo $total_earning_lastWeek;?></td>
				    </tr>
				    </tbody>
				    <?php /*?><tr>
				    	<td>Remaining Hour</td>
				        <td>10 hour</td>
				        <td> - </td>
				    </tr>    <?php */?>

				</table>
			</div><!-- table-scrollable -->
		</div>
		<div class="clear"></div>
		<div class="margin-top"></div>
		<div class="portlet">
			<div class="portlet-title">
				<span>My Organization</span>
			</div>
			<table class="table table-light">
					<thead>
					<tr class="uppercase">
						<th>SN</th>
				        <th>Organization Name</th>
				        <th>Branch Name</th>
				        <th>Organization Role</th>
				        <th>Profile</th>
				    </tr>
				   </thead>
				   <tbody>
				   	 <?php
								$count = 1;
							 foreach($userDetail->OrganizationUser as $myOrganization){?>   
				   <tr>
				        <td><?php echo $count;?></td>
				        <td><a href="<?php echo URL_VIEW."organizationUsers/employee/orgView?org_id=".$myOrganization->Organization->id."&branch_id=".$myOrganization->Branch->id;?>"><?php echo $myOrganization->Organization->title;?></a></td>
				        <td><?php echo $myOrganization->Branch->title;?></td>
				        <td><?php echo $myOrganization->designation;?></td>
				        <td>
				        	<ul class="action_btn">
	                        <li><div class="hover_action"></div>
	                            <a href="<?php echo URL_VIEW."organizationUsers/employee/orgView?org_id=".$myOrganization->Organization->id."&branch_id=".$myOrganization->Branch->id;?>"><button 
	                                    class="view_img"></button>
	                            </a>
	                        </li>
	                    </ul>
				        </td>
				    </tr>

				    <?php  $count++; } ?>
				    </tbody>
			</table>
		</div>
		<div class="clear"></div>
	</div><!--End profile-content -->
	<div class="profile-content myShift">
		<div class="portlet">
			<div class="portlet-title">
				<span>My Shifts</span>
			</div>
			<?php
				// for temporary Shift
				$url_temp_shift = URL ."ShiftUsers/myTempShifts/".$user_id.".json";
				$response_temp_shift = \Httpful\Request::get($url_temp_shift)->send();
				$temp_shift = $response_temp_shift->body->temp_shift;
				
				foreach($temp_shift as $user_shift){
					//if($user_shift->ShiftUser->status != 0){
						$user_shift_datewise[$user_shift->ShiftUser->shift_date][] = $user_shift;	
					//}
					
				}

				// for permanent shift
				$url_p = URL."Permanentshifts/myPermanentShifts/".$user_id.".json";
				$r_p = \Httpful\Request::get($url_p)->send();
				$user_permanent_shifts = $r_p->body->perma_shift;
				//print_r($user_permanent_shifts);
				foreach($user_permanent_shifts as $permanent_shift){
					$user_shift_permanent[$permanent_shift->Permanentshift->day_id][] = $permanent_shift->Shift;	
				}
				//print_r($user_shift_permanent);


			?>
			<div class="table-scrollable">
			<?php 
				$today_date = date('Y-m-d');
				$calender_layout_type = 7; 
				$layoutFormat = weekLayout($today_date, $calender_layout_type);
					$newdays = $layoutFormat[0];
					$duration = $layoutFormat[1];
					$duration_name = $layoutFormat[2];
					$starting_date = $layoutFormat[3];
					$ending_date = $layoutFormat[4];
			?>
				<table class="table table-light">
					<thead>
					<tr class="uppercase">
						<th><p> <?php echo $duration_name;?> </p><p>(<?php echo $duration;?>)</p></th>
				    	<?php 
						   $date_change_value = 0;
						   foreach($newdays as $dayKey=>$dayVal){
							   foreach($dayVal as $k=>$v){
						?>
				    	<th><?php echo $v['day_date']; $dynamicDayFormat[$v['date']] = $k;?>
    					</th>
						<?php }} ?> 
				    </tr>
				   </thead>
				   <tbody>
					<tr>
					    <th>&nbsp;
						</th>
					    <?php foreach($dynamicDayFormat as $dayFormatKey=>$dayFormatVal){
							
							
							?>
					    <td id="<?php echo $user_id."_".$dayFormatVal."_".$dayFormatKey;?>">
						<?php 
								//$dayFormatKey is date and $dayFormatVal is day_id that is assign as key in above
								
								
								// for listing assigned shift for permanent employee
								
								if(isset($user_shift_permanent[$dayFormatVal]) && !empty($user_shift_permanent[$dayFormatVal])){
									foreach($user_shift_permanent[$dayFormatVal] as $permanent_shift){
										
										
										echo '<div id="'.$permanent_shift->id.'" class="confirm_div"><span>'.$permanent_shift->Organization->title.'</span><p>'.$permanent_shift->starttime.' - '.$permanent_shift->endtime.'</p></div>';

									}
								}
								
								
								// for listing assigned shift to the user.
								if(isset($user_shift_datewise[$dayFormatKey]) && !empty($user_shift_datewise[$dayFormatKey])){
									foreach($user_shift_datewise[$dayFormatKey] as $user_per_shift){
										if($user_per_shift->ShiftUser->status == 1){
											$classname = 'pending_div confirmPopup';	
											$type_name = "Pending";
											//$waiting_id = $user_per_shift->Shift->id.'_'.$user_detail->User->id.'_'.$dayFormatKey;
											$waiting_id = $user_per_shift->ShiftUser->id;
										}elseif($user_per_shift->ShiftUser->status == 2){
											$classname = 'waiting_div';
											$waiting_id = $user_per_shift->ShiftUser->id;
											$type_name = "Waiting";
										}elseif($user_per_shift->ShiftUser->status == 0){
											$classname = 'open_div confirmPopupOpen';	
											$waiting_id = $user_per_shift->ShiftUser->id;
											$type_name = "Open";
										}
										else{
											$classname = 'confirm_div';
											$waiting_id = $user_per_shift->Shift->id.'_'.$user_id.'_'.$dayFormatKey;
											$type_name = "Confirm";
										}
										$type_name = $user_per_shift->Shift->Organization->title;
								echo '<div id="'.$waiting_id.'" class="'.$classname.'"><span>'.$type_name.'</span><p>'.$user_per_shift->Shift->starttime.' - '.$user_per_shift->Shift->endtime.'</p></div>';

									
							}
								}
							?>
						    </td>
					    <?php } ?>
					    
				  	</tr>
  
				    </tbody>
				</table>
			</div><!-- table-scrollable -->
	</div><!--End profile-content -->
</div><!--End Content-->
<!--
<div class="profile_outer_div"><div class="profile_heading"></div></div>
<?php
// for temporary Shift
	$url_temp_shift = URL ."ShiftUsers/myTempShifts/".$user_id.".json";
	$response_temp_shift = \Httpful\Request::get($url_temp_shift)->send();
	$temp_shift = $response_temp_shift->body->temp_shift;
	
	foreach($temp_shift as $user_shift){
		//if($user_shift->ShiftUser->status != 0){
			$user_shift_datewise[$user_shift->ShiftUser->shift_date][] = $user_shift;	
		//}
		
	}

// for permanent shift
	$url_p = URL."Permanentshifts/myPermanentShifts/".$user_id.".json";
	$r_p = \Httpful\Request::get($url_p)->send();
	$user_permanent_shifts = $r_p->body->perma_shift;
	//print_r($user_permanent_shifts);
	foreach($user_permanent_shifts as $permanent_shift){
		$user_shift_permanent[$permanent_shift->Permanentshift->day_id][] = $permanent_shift->Shift;	
	}
	//print_r($user_shift_permanent);


?>
<div class="schedule_table">
<?php 
$today_date = date('Y-m-d');
$calender_layout_type = 7; 
$layoutFormat = weekLayout($today_date, $calender_layout_type);
	$newdays = $layoutFormat[0];
	$duration = $layoutFormat[1];
	$duration_name = $layoutFormat[2];
	$starting_date = $layoutFormat[3];
	$ending_date = $layoutFormat[4];
?>
<table class="schedule_table" width="98%" align="center">
  <tr class="week-heading">
    <th width="10%"><p> <?php echo $duration_name;?> </p><p>(<?php echo $duration;?>)</p></th>
   <?php 
   $date_change_value = 0;
   foreach($newdays as $dayKey=>$dayVal){
	   foreach($dayVal as $k=>$v){
	?>
    <th>
		<?php echo $v['day_date']; $dynamicDayFormat[$v['date']] = $k;?>
    	
    </th>
   <?php }} ?> 
   <tr>
    <th>&nbsp;
	</th>
    <?php foreach($dynamicDayFormat as $dayFormatKey=>$dayFormatVal){
		
		
		?>
    <td id="<?php echo $user_id."_".$dayFormatVal."_".$dayFormatKey;?>">
		<?php 
		//$dayFormatKey is date and $dayFormatVal is day_id that is assign as key in above
		
		
		// for listing assigned shift for permanent employee
		
		if(isset($user_shift_permanent[$dayFormatVal]) && !empty($user_shift_permanent[$dayFormatVal])){
			foreach($user_shift_permanent[$dayFormatVal] as $permanent_shift){
				
				
				echo '<div id="'.$permanent_shift->id.'" class="confirm_div"><span>'.$permanent_shift->Organization->title.'</span><p>'.$permanent_shift->starttime.' - '.$permanent_shift->endtime.'</p></div>';

			}
		}
		
		
		// for listing assigned shift to the user.
		if(isset($user_shift_datewise[$dayFormatKey]) && !empty($user_shift_datewise[$dayFormatKey])){
			foreach($user_shift_datewise[$dayFormatKey] as $user_per_shift){
				if($user_per_shift->ShiftUser->status == 1){
					$classname = 'pending_div confirmPopup';	
					$type_name = "Pending";
					//$waiting_id = $user_per_shift->Shift->id.'_'.$user_detail->User->id.'_'.$dayFormatKey;
					$waiting_id = $user_per_shift->ShiftUser->id;
				}elseif($user_per_shift->ShiftUser->status == 2){
					$classname = 'waiting_div';
					$waiting_id = $user_per_shift->ShiftUser->id;
					$type_name = "Waiting";
				}elseif($user_per_shift->ShiftUser->status == 0){
					$classname = 'open_div confirmPopupOpen';	
					$waiting_id = $user_per_shift->ShiftUser->id;
					$type_name = "Open";
				}
				else{
					$classname = 'confirm_div';
					$waiting_id = $user_per_shift->Shift->id.'_'.$user_id.'_'.$dayFormatKey;
					$type_name = "Confirm";
				}
				$type_name = $user_per_shift->Shift->Organization->title;
		echo '<div id="'.$waiting_id.'" class="'.$classname.'"><span>'.$type_name.'</span><p>'.$user_per_shift->Shift->starttime.' - '.$user_per_shift->Shift->endtime.'</p></div>';

			
	}
		}
	?>
    </td>
    <?php } ?>
    
  </tr>
  
  </tr>
 </table>
 </div>
<div class="profile_outer_div"><div class="profile_heading">Earning</div></div>
<div class="schedule_table">
<pre>
<?php
	$start_date = 0000-00-00;
	$end_date = 0000-00-00;
	// data for last week
	$last_week = date_duration_last(7);
	$start_date_last = $last_week[0];
	$end_date_last = $last_week[1];
	$myOrganizationLists = getEmployeeOrganizations($user_id);
		
	$priceCalculateOrgBranches_lastWeek = priceCalculateOrgBranches($user_id, $start_date_last, $end_date_last);
	//print_r($priceCalculateOrgBranches_lastWeek);
	
	$priceCalculateOrgBranchesPermanent_lastWeek = priceCalculateOrgBranchesPermanent($user_id, $start_date_last, $end_date_last);
	
	//print_r($priceCalculateOrgBranchesPermanent_lastWeek);
	$current_week = date_duration_current();
	$start_date_current = $current_week[0];
	$end_date_current = $current_week[1];
	
	$priceCalculateOrgBranches_currentWeek = priceCalculateOrgBranches($user_id, $start_date_current, $end_date_current);
	//print_r($priceCalculateOrgBranches_currentWeek);
	
	$priceCalculateOrgBranchesPermanent_currentWeek = priceCalculateOrgBranchesPermanent($user_id, $start_date_current, $end_date_current);
	//print_r($priceCalculateOrgBranchesPermanent_currentWeek);
	
	$total_earning_currentWeek = $priceCalculateOrgBranches_currentWeek->total_cost + $priceCalculateOrgBranchesPermanent_currentWeek->total_cost;
	$total_hour_worked_currentWeek = $priceCalculateOrgBranches_currentWeek->hour_worked + $priceCalculateOrgBranchesPermanent_currentWeek->hour_worked;
	
	$total_earning_lastWeek = $priceCalculateOrgBranches_lastWeek->total_cost + $priceCalculateOrgBranchesPermanent_lastWeek->total_cost;
	$total_hour_worked_lastWeek = $priceCalculateOrgBranches_lastWeek->hour_worked + $priceCalculateOrgBranchesPermanent_lastWeek->hour_worked;
?>
<table>
	<tr>
    	<td>&nbsp;</td>
    	<td>Current Week Earning</td>
        <td>Last Week Earning</td>
    </tr>
    <tr>
    	<td>Worked Hours</td>
        <td><?php echo $total_hour_worked_currentWeek;?> Hours</td>
        <td><?php echo $total_hour_worked_lastWeek;?> Hours</td>
    </tr>
    <tr>
    	<td>Earning</td>
        <td>$<?php echo $total_earning_currentWeek;?></td>
        <td>$<?php echo $total_earning_lastWeek;?></td>
    </tr>
    <?php /*?><tr>
    	<td>Remaining Hour</td>
        <td>10 hour</td>
        <td> - </td>
    </tr>    <?php */?>

</table>
</div>
</div><!--End Content-->
