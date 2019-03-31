<!-- tableHeader -->
<?php
//print_r($_SESSION);
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
	
$token = $_SESSION['token'];


$board_id = $_GET['board_id'];

?>
			<div class="tableHeader">
            
           
        
       
   
            
				<div class="blueHeader assignheader">
					<img src="<?php echo URL_IMAGE;?>CalenderIcon.png" alt="calender icon" />
					<span style="margin:10px 15px 0 0; float:left;">Calender  <span style="font-size:14px; margin-left:5px"><?php echo date('M Y');?></span></span>

					<ul class="subNav">
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/assignUserInShift?type=<?php echo $calender_layout_type;?>&show=prev&sDate=<?php echo $starting_date;?>&board_id=<?php echo $board_id;?>"> < </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/assignUserInShift?type=<?php echo $calender_layout_type;?>&show=next&eDate=<?php echo $ending_date;?>&board_id=<?php echo $board_id;?>"> > </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/assignUserInShift?type=1&board_id=<?php echo $board_id;?>"> Today </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/assignUserInShift?type=7&board_id=<?php echo $board_id;?>"> Week </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/assignUserInShift?type=15&board_id=<?php echo $board_id;?>"> Fortnight </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/assignUserInShift?type=30&board_id=<?php echo $board_id;?>"> Month </a></li>
					</ul>
				</div>

<div class="clear"></div>
<a class='addNewShiftToUser' href="#addNewForm"><button class="addBtn">Add New</button></a>
				
<div class="clear"></div>

<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery.ui.js"></script>
<script src="<?php echo URL_VIEW;?>js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo URL_VIEW;?>styles/colorbox.css" />

<?php include('include_script.php');?>

<?php
//echo date('l');
if(isset($_POST) && !empty($_POST) && isset($_POST['Submit_indivisual']) && $_POST['Submit_indivisual'] == "Submit"){
	$shift_id_indivisual = $_POST['shift_id_indivisual'];
	$userCellDetail = $_POST['userCellDetail'];
	
	$url = URL."ShiftUsers/addShiftFromCell.json";
	$response = \Httpful\Request::put($url)                  // Build a PUT request...
	->addHeader('token', $token)
    ->sendsJson()                               // tell it we're sending (Content-Type) JSON...
    //->authenticateWith('username', 'password')  // authenticate with basic auth...
    ->body(array('shift_id_indivisual'=>$shift_id_indivisual, 'userCellDetail'=>$userCellDetail, 'board_id'=>$board_id))           // attach a body/payload...
    ->send();
	
}

if(isset($_POST) && !empty($_POST) && $_POST['Submit_multiple'] == "Submit"){
	$shift_id = $_POST['shift_id'];
	$employee_id = $_POST['employee_id'];
	//$date = $_POST['date'];
	$board_id = $_POST['board_id'];
	
	$end_date = $_POST['end_date'];
	$recurring = $_POST['recurring'];
	$checked_days = $_POST['check_day']; 
	
	$url = URL."ShiftUsers/add.json";
	$response = \Httpful\Request::put($url)                  // Build a PUT request...
    ->sendsJson()                               // tell it we're sending (Content-Type) JSON...
    //->authenticateWith('username', 'password')  // authenticate with basic auth...
    ->body(array('ShiftUser'=>array('organization_id'=>$organization_id, 'shift_id'=>$shift_id, 'user_id'=>$employee_id, /*'shift_date'=>$date,*/ 'board_id'=>$board_id, 'status'=>'1', 'end_date'=>$end_date, 'recurring'=>$recurring, 'checked_days'=>$checked_days)))             // attach a body/payload...
    ->send();
	
echo "Shift is added successfully.";
}

?>

<?php
	
	// for organization shift list
	$url_org_shift_list = URL."ShiftUsers/organizationShiftList/".$organization_id.".json";
	$r_org_shift_list = \Httpful\Request::get($url_org_shift_list)->send();
	$organization_shifts = $r_org_shift_list->body->message->shiftList;
	
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
		$user_shift_datewise[$user_shift->ShiftUser->user_id][$user_shift->ShiftUser->shift_date][] = $user_shift;	
		
	}
	
	// for permanent shift
	$url_p = URL."Permanentshifts/permanentlist/".$board_id.".json";
	$r_p = \Httpful\Request::get($url_p)->send();
	$user_permanent_shifts = $r_p->body->message;
	
	foreach($user_permanent_shifts as $permanent_shift){
		$user_shift_permanent[$permanent_shift->Permanentshift->user_id][$permanent_shift->Permanentshift->day_id][] = $permanent_shift->Shift;	
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

foreach($board_employees as $employee){
	
	
?>
  <tr>
    <th><img src="<?php echo URL_IMAGE;?>EmployeeIcon.png" alt="Employee Icon" style="float:left; padding-right:5px;"/>
							<?php echo $employee->User->fname." ".$employee->User->lname;?>
							<br>
							<span class="employeeName">(Position)</span>
	</th>
    <?php 
	//$waiting_arr = array();
	foreach($dynamicDayFormat as $dayFormatKey=>$dayFormatVal){
    
    // for checking availability of the User.
		
		if(isset($availability_day[$employee->User->id][$dayFormatVal]['status']) && (@$availability_day[$employee->User->id][$dayFormatVal]['status'] == 0 || @$availability_day[$employee->User->id][$dayFormatVal]['status'] == 1)):
		$availableClass = "available directAdd";	
	else:
		$availableClass = "notavailable";
	endif;
    ?>
    <td id="<?php echo $employee->User->id."_".$dayFormatVal."_".$dayFormatKey;?>" class="<?php echo $availableClass;?>">
    
		<?php 
		//$dayFormatKey is date and $dayFormatVal is day_id that is assign as key in above
		
		
		// for listing assigned shift for permanent employee
		
		if(isset($user_shift_permanent[$employee->User->id][$dayFormatVal]) && !empty($user_shift_permanent[$employee->User->id][$dayFormatVal])){
			foreach($user_shift_permanent[$employee->User->id][$dayFormatVal] as $permanent_shift){
				//echo $permanent_shift->title."<br>(".$permanent_shift->starttime." - ".$permanent_shift->endtime.")<br>";
				//echo '<div id="'.$permanent_shift->id.'" class="confirm_div">'.$permanent_shift->starttime.' - '.$permanent_shift->endtime.'<div class="blueBorder"></div>'.$permanent_shift->title.'</div>';
				echo '<div id="'.$permanent_shift->id.'" class="confirm_div"><span>Confirm</span><p>'.$permanent_shift->starttime.' - '.$permanent_shift->endtime.'</p></div>';
				?>
               <?php /*?> <script>
				$(document).ready(function(e) {
					$('#<?php echo $employee->User->id."_".$dayFormatVal."_".$dayFormatKey;?>').attr('class', 'available directAdd');
				});
				</script><?php */?>
                <?php
			}
		}
		
		
		// for listing assigned shift to the user.
		if(isset($user_shift_datewise[$employee->User->id][$dayFormatKey]) && !empty($user_shift_datewise[$employee->User->id][$dayFormatKey])){
			foreach($user_shift_datewise[$employee->User->id][$dayFormatKey] as $user_per_shift){
				if($user_per_shift->ShiftUser->status == 1){
					$classname = 'waiting_div drag';	
					$type_name = "Waiting";
					$waiting_id = $user_per_shift->Shift->id.'_'.$employee->User->id.'_'.$dayFormatKey;
					?>
                    <?php /*?><script>
				$(document).ready(function(e) {
					$('#<?php echo $employee->User->id."_".$dayFormatVal."_".$dayFormatKey;?>').attr('class', 'available directAdd');
				});
				</script><?php */?>
                    <?php
				}elseif($user_per_shift->ShiftUser->status == 2){
					$classname = 'pending_div confirmPopup';
					$waiting_id = $user_per_shift->ShiftUser->id;
					$type_name = "Pending";
					?>
                    <?php /*?><script>
				$(document).ready(function(e) {
					$('#<?php echo $employee->User->id."_".$dayFormatVal."_".$dayFormatKey;?>').attr('class', 'available directAdd');
				});
				</script><?php */?>
                    <?php
				}elseif($user_per_shift->ShiftUser->status == 0){
					$classname = 'open_div';	
					$waiting_id = $user_per_shift->ShiftUser->id;
					$type_name = "Open";
				}
				else{
					$classname = 'confirm_div';
					$waiting_id = $user_per_shift->Shift->id.'_'.$employee->User->id.'_'.$dayFormatKey;
					$type_name = "Confirm";
					?>
                    <?php /*?><script>
				$(document).ready(function(e) {
					$('#<?php echo $employee->User->id."_".$dayFormatVal."_".$dayFormatKey;?>').attr('class', 'available directAdd');
				});
				</script><?php */?>
                    <?php
				}
				//$waiting_arr[] = $waiting_id; 
				//print_r($waiting_arr);
				echo '<div id="'.$waiting_id.'" class="'.$classname.'"><span>'.$type_name.'</span><p>'.$user_per_shift->Shift->starttime.' - '.$user_per_shift->Shift->endtime.'</p></div>';
			
	}
		}
	?>
    </td>
    <?php } ?>
  </tr>
<?php } ?>

	<?php /*?><tr>
		<th><img src="<?php echo URL_IMAGE;?>EmployeeIcon.png" alt="Employee Icon" style="float:left; padding-right:5px;"/>
							<?php echo $employee->User->fname." ".$employee->User->lname;?>
							<br>
							<span class="employeeName">(Position)</span>
	</th>
		<td><div class="confirm_div">
				<span>confirm</span>
				<p>19:50 am - 24:50 pm</p>
		</div></td>

		<td><div class="pending_div">
				<span>pending</span>
				<p>19:50 am - 24:50 pm</p>
		</div></td>

		<td><div class="waiting_div">
				<span>waiting</span>
				<p>19:50 am - 24:50 pm</p>
		</div></td>

		<td><div class="open_div">
				<span>open</span>
				<p>19:50 am - 24:50 pm</p>
		</div></td>
	</tr><?php */?>

</table>
</div>
</div>
<div id="dragDiv">
<table>
	<tr>
    	<th style="border:none;" colspan="<?php echo count($organization_shifts);?>">Organization Shifts</th>
    </tr> 

	<tr>
<?php
	foreach($organization_shifts as $drag_shifts){
		echo '<td><div class="tableData"><div id="'.$drag_shifts->Shift->id.'" class="drag" >'.$drag_shifts->Shift->starttime.' - '.$drag_shifts->Shift->endtime.'</div><div class="activeBorder"></div>'.$drag_shifts->Shift->title.'</div></td>';
} ?>
</tr>
</table>
<input type="hidden" name="dragged_id" id="dragged_id" />
<input type="hidden" name="shiftUserConfirmationId" id="shiftUserConfirmationId" />

</div>

<div  style="display:none;">
<div id="directAddForm">
<form action="" method="post">
<table class="popup-adduser" width="500" cellpadding="5px" align="center">
	<tr>
    	<td colspan="3" class="popup-header">Assign Shift To User</td>
     </tr>
     <tr>
     	<td>Shift</td>
        <td>:</td>
        <td>
        <input type="text" name="userCellDetail" id="userCellDetail" />
        <select name="shift_id_indivisual" id="shift_id_indivisual">
      	<?php
			foreach($organization_shifts as $shifts_indivisual){
		?>
        	<option value="<?php echo $shifts_indivisual->Shift->id;?>"><?php echo $shifts_indivisual->Shift->title."(".$shifts_indivisual->Shift->starttime." - ".$shifts_indivisual->Shift->endtime.")";?></option>
        <?php } ?>	
      </select>
        </td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="Submit_indivisual" type="submit" value="Submit"></td>
  </tr>  
</table>
</form>
</div>
<div id="addNewForm">
<form action="" method="post">
<table class="popup-adduser" width="500" cellpadding="5px" align="center">
  <tr>
    <td class="popup-header" colspan="3">Add New Employee To Shift</td>
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
  <!--<tr>
    <td>Date</td>
    <td>:</td>
    <td><label for="date"></label>
      <input type="text" name="date" id="date"></td>
  </tr>-->
  <tr>
  	<td>Day</td>
  	<td>:</td>
    <td>Sunday <input type="checkbox" name="check_day[]" value="1" /> Monday <input type="checkbox" name="check_day[]" value="2" /> Tuesday <input type="checkbox" name="check_day[]" value="3" /> Wednesday <input type="checkbox" name="check_day[]" value="4" /> Thursday <input type="checkbox" name="check_day[]" value="5" /> Friday <input type="checkbox" name="check_day[]" value="6" /> Saturday <input type="checkbox" name="check_day[]" value="7" /></td>
  </tr>
  <tr>
  	<td>Recurring</td>
    <td>:</td>
    <td>Yes <input type="radio" id="rec_yes" name="recurring" value="1" /> No <input id="rec_no" type="radio" name="recurring" /></td>
  </tr>
  <tr id="end_date_row" style="display:none;">
  	<td>End Date</td>
    <td>:</td>
    <td> <input type="text" name="end_date" id="end_date" /> </td>
  
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="Submit_multiple" type="submit" value="Submit"></td>
  </tr>
</table>
</form>
</div>
<div id="confirmShift" class="confirmBoxProperty">
    <table cellpadding="12px" width="400px">
        <ul class="confirm-table">
            <li><span class="popup-header popupAccept">Do you want to accept / reject?</span></li>
            <li><input type="button" id="accept" name="Accept" value="Accept" />
            <input type="button" id="reject" name="Reject" value="Reject" /></li>
        </ul> 
    </table>          
</div>
</div>
</div>
<script>
	$(document).ready(function(e) {
		$('#rec_yes').click(function(e) {
           if ($(this).is(':checked')){
			
				$('#end_date_row').show();	
			}else{
				$('#end_date_row').hide();
			}
        });
		
		$('#rec_no').click(function(e) {
           if ($(this).is(':checked')){
			
				$('#end_date_row').hide();	
			}
        });
		
		
        $('#accept').click(function(){
			shiftUserConfirmedId = $('#shiftUserConfirmationId').val();
			$.ajax({
			  type: "POST",
			  url: "<?php echo URL_VIEW;?>shiftUsers/ajax_confirm_shift.php",
			  data: { shiftUserId: shiftUserConfirmedId, status: 1 }
			})
			  .done(function(response) {
				  resArr = response.split('_');
				  statusCheck = resArr[0];
				  user_id = resArr[1];
				  shift_id = resArr[2];
				  shift_date = resArr[3];
				  
				
				if(statusCheck == 'Ok'){
					//$('#'+shiftUserConfirmedId).attr('class', 'tableData');
					$('#'+shiftUserConfirmedId).attr('class', 'confirm_div');
					$('#'+shiftUserConfirmedId+' span').html('Confirm');
					$('#'+shiftUserConfirmedId).attr('id', shift_id+'_'+user_id+'_'+shift_date);
					$.fn.colorbox.close();
					//alert('Shift Accepted');	
				}
				
			  });
			
		});
		
		$('#reject').click(function(){
			shiftUserConfirmedId = $('#shiftUserConfirmationId').val();
			$.ajax({
			  type: "POST",
			  url: "<?php echo URL_VIEW;?>shiftUsers/ajax_confirm_shift.php",
			  data: { shiftUserId: shiftUserConfirmedId, status: 0 }
			})
			  .done(function( msg ) {
				if(msg == 'Ok'){
					$('#'+shiftUserConfirmedId).remove();
					$.fn.colorbox.close();
				}
				
			  });	
		});
    });
</script>