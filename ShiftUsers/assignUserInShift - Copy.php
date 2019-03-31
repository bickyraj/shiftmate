<?php


$organization_id = 1;
$board_id = 1;
//echo $day = date('l', strtotime('2014-11-29'));
echo "<pre>";
?>
<?php
if(isset($_POST) && !empty($_POST)){
	$shift_id = $_POST['shift_id'];
	$employee_id = $_POST['employee_id'];
	$date = $_POST['date'];
	$board_id = $_POST['board_id'];
		
	$url = URL."ShiftUsers/add.json";
	$response = \Httpful\Request::put($url)                  // Build a PUT request...
    ->sendsJson()                               // tell it we're sending (Content-Type) JSON...
    ->authenticateWith('username', 'password')  // authenticate with basic auth...
    ->body(array('ShiftUser'=>array('organization_id'=>$organization_id, 'shift_id'=>$shift_id, 'user_id'=>$employee_id, 'shift_date'=>$date, 'board_id'=>$board_id, 'status'=>'1')))             // attach a body/payload...
    ->send();
	//print_r($response->body);	die();
echo "Shift is added successfully.";
}

?>
<?php

	$url = URL."ShiftUsers/addUserInShift/".$organization_id.".json";
	$r = \Httpful\Request::get($url)->send();
	//echo "<pre>";
	//print_r($r->body->message->shiftlists);
	
	$organization_shifts = $r->body->message->shiftList;
	$board_employees = $r->body->message->employeeList;
	
	
	// for boards shift user list
	$url_1 = URL."ShiftUsers/userShift/".$board_id.".json";
	$r_1 = \Httpful\Request::get($url_1)->send();
	$user_shifts = $r_1->body->message;
	foreach($user_shifts as $user_shift){
		$user_shift_datewise[$user_shift->User->id][$user_shift->ShiftUser->shift_date][] = $user_shift->Shift;	
	}
	
	// for permanent shift
	$url_p = URL."Permanentshifts/permanentlist/".$board_id.".json";
	$r_p = \Httpful\Request::get($url_p)->send();
	$user_permanent_shifts = $r_p->body->message;
	
	foreach($user_permanent_shifts as $permanent_shift){
		$user_shift_permanent[$permanent_shift->Permanentshift->user_id][$permanent_shift->Permanentshift->day_id][] = $permanent_shift->Shift;	
	}
	
	//print_r($user_shift_permanent);die();
	
	 //  for calender for today, week, fortnight , month, depending the parameter
	$newdays = weekLayout(7);
	//print_r($newdays);die();

?>

<table width="98%" align="center">
  <tr class="week-heading">
    <th><p>Week 2</p><p>(Nov 23-29)</p></th>
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

foreach($board_employees as $employee){
	$url = URL."Useravailabilities/userAvailability/".$employee->User->id.".json";
	$r = \Httpful\Request::get($url)->send();
	$user_availability = $r->body->message;
	foreach($user_availability as $availability){
		$availability_day[$employee->User->id][$availability->Useravailability->day_id]['organization_id'] = $availability->Useravailability->organization_id; 	
		$availability_day[$employee->User->id][$availability->Useravailability->day_id]['status'] = $availability->Useravailability->status;
	}
	
?>
  <tr>
    <td><?php echo $employee->User->fname." ".$employee->User->lname;?></td>
    <?php foreach($dynamicDayFormat as $dayFormatKey=>$dayFormatVal){?>
    <td>
		<?php 
		//$dayFormatKey is date that is assign as key in above
		
		
		// for listing assigned shift for permanent employee
		
		if(isset($user_shift_permanent[$employee->User->id][$dayFormatVal]) && !empty($user_shift_permanent[$employee->User->id][$dayFormatVal])){
			foreach($user_shift_permanent[$employee->User->id][$dayFormatVal] as $permanent_shift){
				echo $permanent_shift->title."<br>(".$permanent_shift->starttime." - ".$permanent_shift->endtime.")<br>";
			}
		}
		
		
		// for listing assigned shift to the user.
		if(isset($user_shift_datewise[$employee->User->id][$dayFormatKey]) && !empty($user_shift_datewise[$employee->User->id][$dayFormatKey])){
			foreach($user_shift_datewise[$employee->User->id][$dayFormatKey] as $user_per_shift){
				echo $user_per_shift->title."<br>(".$user_per_shift->starttime." - ".$user_per_shift->endtime.")<br>";
			}
		}
		
		// for checking availability of the User.
		if(@$availability_day[$employee->User->id][$dayFormatVal]['organization_id'] == $organization_id && @$availability_day[$employee->User->id][$dayFormatVal]['status'] == 0){
		echo "Available";	
	}
	?></td>
    <?php } ?>
    
  </tr>
<?php } ?>
</table>

<form action="" method="post">
<table width="500" border="1">
  <tr>
    <td colspan="3">Add New Employee To Shift</td>
  </tr>
  <tr>
    <td width="112">Shift</td>
    <td width="16">:</td>
    <td width="350">
    <input type="hidden" name="board_id" id="board_id" value="<?php echo $employee->Board->id;?>" />
      <select name="shift_id" id="shift_id">
      	<?php
			foreach($organization_shifts as $shifts){
		?>
        	<option value="<?php echo $shifts->Shift->id;?>"><?php echo $shifts->Shift->title."(".$shifts->Shift->starttime." - ".$shifts->Shift->endtime.")";?></option>
        <?php } ?>	
      </select>
     </td>
  </tr>
  <tr>
  	<td>Employee</td>
    <td>:</td>
    <td>
    	<select name="employee_id" id="employee_id">
        	<?php 
				foreach($board_employees as $employee){
			?>
            	<option value="<?php echo $employee->User->id;?>"><?php echo $employee->User->fname." ".$employee->User->lname;?></option>
            <?php } ?>
        </select>	
    </td>
  </tr>
  <tr>
    <td>Date</td>
    <td>:</td>
    <td><label for="date"></label>
      <input type="text" name="date" id="date"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="Submit" type="submit" value="Submit"></td>
  </tr>
</table>
</form>
