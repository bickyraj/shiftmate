<!-- tableHeader -->
<?php
$organization_id = $_GET['org_id'];
$board_id = $_GET['board_id'];

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
	
	
?>
			<div class="tableHeader">
				<div class="blueHeader">
					<img src="<?php echo URL_IMAGE;?>CalenderIcon.png" alt="calender icon" />
					<span style="margin:10px 15px 0 0; float:left;">Calender  <span style="font-size:14px; margin-left:5px"><?php echo date('m Y');?></span></span>

					<ul class="subNav">
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/mySchedule?org_id=<?php echo $organization_id;?>&type=<?php echo $calender_layout_type;?>&show=prev&sDate=<?php echo $starting_date;?>"> < </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/mySchedule?org_id=<?php echo $organization_id;?>&type=<?php echo $calender_layout_type;?>&show=next&eDate=<?php echo $ending_date;?>"> > </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/mySchedule?org_id=<?php echo $organization_id;?>&type=1"> Today </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/mySchedule?org_id=<?php echo $organization_id;?>&type=7"> Week </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/mySchedule?org_id=<?php echo $organization_id;?>&type=15"> Fortnight </a></li>
						<li><a href="<?php echo URL_VIEW;?>/shiftUsers/mySchedule?org_id=<?php echo $organization_id;?>&type=30"> Month </a></li>
					</ul>
				</div>

<div class="clear"></div>
				
<div class="clear"></div>

<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery.ui.js"></script>
<script src="<?php echo URL_VIEW;?>js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo URL_VIEW;?>styles/colorbox.css" />

<?php include('include_script_employee.php');?>
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
    ->body(array('ShiftUser'=>array('organization_id'=>$organization_id, 'shift_id'=>$shift_id, 'user_id'=>$employee_id, 'shift_date'=>$date, 'board_id'=>$board_id, 'status'=>'2')))             // attach a body/payload...
    ->send();
	
echo "Shift is added successfully.";
}

?>

<?php
	// for open shift
	$url_open = URL."ShiftUsers/openShift.json";
	$r_open = \Httpful\Request::get($url_open)->send();
	$user_open_shifts = $r_open->body->message;
	//print_r($user_open_shifts);die();
	foreach($user_open_shifts as $user_open_shifts){
		
			$user_shift_open[$user_open_shifts->ShiftUser->shift_date][] = $user_open_shifts;	
		
		
	}
	
	// for permanent shift
	$url_p = URL."Permanentshifts/permanentlist/".$board_id.".json";
	$r_p = \Httpful\Request::get($url_p)->send();
	$user_permanent_shifts = $r_p->body->message;
	//print_r($user_permanent_shifts);
	foreach($user_permanent_shifts as $permanent_shift){
		$user_shift_permanent[$permanent_shift->Permanentshift->user_id][$permanent_shift->Permanentshift->day_id][] = $permanent_shift->Shift;	
	}
	
	

	//login user detail
	$url_user_detail = URL."Users/userDetail/".$user_id.".json";
	$r_user_detail = \Httpful\Request::get($url_user_detail)->send();
	$user_detail = $r_user_detail->body->message;
	
		
	$classname = '';
	// for boards shift user list
	$url_1 = URL."ShiftUsers/mySchedule/".$user_id.".json";
	$r_1 = \Httpful\Request::get($url_1)->send();
	$user_shifts = $r_1->body->message;
	//print_r($user_shifts);die();
	foreach($user_shifts as $user_shift){
		if($user_shift->ShiftUser->status != 0){
			$user_shift_datewise[$user_detail->User->id][$user_shift->ShiftUser->shift_date][] = $user_shift;	
		}
		
	}
	
?>

<div id="drop">
<div class="schedule_table">
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
  
  </tr>

  <tr>
    <th><img src="<?php echo URL_IMAGE;?>EmployeeIcon.png" alt="Employee Icon" style="float:left; padding-right:5px;"/>
							<?php echo $user_detail->User->fname." ".$user_detail->User->lname;?>
							<br>
							<span class="employeeName">(Position)</span>
	</th>
    <?php foreach($dynamicDayFormat as $dayFormatKey=>$dayFormatVal){
		
		
		?>
    <td id="<?php echo $user_detail->User->id."_".$dayFormatVal."_".$dayFormatKey;?>" class="<?php echo $availableClass;?>">
		<?php 
		//$dayFormatKey is date and $dayFormatVal is day_id that is assign as key in above
		
		
		// for listing assigned shift for permanent employee
		
		if(isset($user_shift_permanent[$user_detail->User->id][$dayFormatVal]) && !empty($user_shift_permanent[$user_detail->User->id][$dayFormatVal])){
			foreach($user_shift_permanent[$user_detail->User->id][$dayFormatVal] as $permanent_shift){
							
				echo '<div id="'.$permanent_shift->id.'" class="confirm_div"><span>Confirm</span><p>'.$permanent_shift->starttime.' - '.$permanent_shift->endtime.'</p></div>';

			}
		}
		
		
		// for listing assigned shift to the user.
		if(isset($user_shift_datewise[$user_detail->User->id][$dayFormatKey]) && !empty($user_shift_datewise[$user_detail->User->id][$dayFormatKey])){
			foreach($user_shift_datewise[$user_detail->User->id][$dayFormatKey] as $user_per_shift){
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
					$waiting_id = $user_per_shift->Shift->id.'_'.$user_detail->User->id.'_'.$dayFormatKey;
					$type_name = "Confirm";
				}
		echo '<div id="'.$waiting_id.'" class="'.$classname.'"><span>'.$type_name.'</span><p>'.$user_per_shift->Shift->starttime.' - '.$user_per_shift->Shift->endtime.'</p></div>';

			
	}
		}
		if(isset($user_shift_open[$dayFormatKey]) && !empty($user_shift_open[$dayFormatKey])){
			foreach($user_shift_open[$dayFormatKey] as $user_per_shift_open){
				if($user_per_shift_open->ShiftUser->status == 1){
					$classname = 'pending_div confirmPopup';	
					$type_name = "Pending";
					//$waiting_id = $user_per_shift->Shift->id.'_'.$user_detail->User->id.'_'.$dayFormatKey;
					$waiting_id = $user_per_shift_open->ShiftUser->id;
				}elseif($user_per_shift_open->ShiftUser->status == 2){
					$classname = 'waiting_div';
					$waiting_id = $user_per_shift_open->ShiftUser->id;
					$type_name = "Waiting";
				}elseif($user_per_shift_open->ShiftUser->status == 0){
					$classname = 'open_div confirmPopupOpen';	
					$waiting_id = $user_per_shift_open->ShiftUser->id;
					$type_name = "Open";
				}
				else{
					$classname = 'confirm_div';
					$waiting_id = $user_per_shift_open->Shift->id.'_'.$user_detail->User->id.'_'.$dayFormatKey;
					$type_name = "Confirm";
				}
				
				echo '<div id="'.$waiting_id.'" class="open_div confirmPopupOpen"><span>Open</span><p>'.$user_per_shift_open->Shift->starttime.' - '.$user_per_shift_open->Shift->endtime.'</p></div>';
			}
		}
		
		// for checking availability of the User.
		if(@$availability_day[$user_detail->User->id][$dayFormatVal]['organization_id'] == $organization_id && @$availability_day[$user_detail->User->id][$dayFormatVal]['status'] == 0){
		echo "Available";	
	}
	?></td>
    <?php } ?>
    
  </tr>
</table>
</div>
</div>
<input type="hidden" name="shiftUserConfirmationId" id="shiftUserConfirmationId" />
<div  style="display:none;">
<div id="addNewForm">
<form action="" method="post">
<table width="500" border="1" style="color:#000;">
  <tr>

    <td colspan="3">Add New Employee To Shift</td>
  </tr>
  <tr>
    <td width="112">Shift</td>
    <td width="16">:</td>
    <td width="350">
    <input type="hidden" name="board_id" id="board_id" value="<?php echo $user_shifts[0]->Board->id;?>" />
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
    <td>Date</td>
    <td>:</td>
    <td><label for="date"></label>
      <input type="text" name="date" id="date"></td>
  </tr>
  <tr>
    <td>&nbsp;<input type="text" name="employee_id" id="employee_id" value="7"></td>
    <td>&nbsp;</td>
    <td><input name="Submit" type="submit" value="Submit"></td>
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

<div id="confirmShiftOpen" class="confirmBoxProperty">
    <table cellpadding="12px" width="400px">
        <ul class="confirm-table">
            <li><span class="popup-header popupAccept">Do you want to take this shift?</span></li>
            <li><input type="button" id="accept_open" name="Accept" value="Accept" />
            <input type="button" id="cancle" name="Cancle" value="Cancle" /></li>
        </ul> 
    </table>          
</div>

</div>
<script>
	$(document).ready(function(e) {
		$('#cancle').click(function(){
			$.fn.colorbox.close();
			});
		
		   $('#accept_open').click(function(){
			shiftUserConfirmedId = $('#shiftUserConfirmationId').val();
			//alert(shiftUserConfirmedId);
			$.ajax({
			  type: "POST",
			  url: "<?php echo URL_VIEW;?>shiftUsers/ajax_confirm_shift.php",
			  data: { shiftUserId: shiftUserConfirmedId, status: 2, user_id:<?php echo $user_id;?> }
			})
			  .done(function(response) {
				  resArr = response.split('_');
				  statusCheck = resArr[0];
				  user_id = resArr[1];
				  shift_id = resArr[2];
				  shift_date = resArr[3];
				  
				
				if(statusCheck == 'Ok'){
					$('#'+shiftUserConfirmedId).attr('class', 'waiting_div');
					$('#'+shiftUserConfirmedId+' span').html('Waiting');
					$('#'+shiftUserConfirmedId).attr('id', shift_id+'_'+user_id+'_'+shift_date);
					$.fn.colorbox.close();
					//alert('Shift Accepted');	
				}
				
			  });
			
		});	
			
		
        $('#accept').click(function(){
			shiftUserConfirmedId = $('#shiftUserConfirmationId').val();
			$.ajax({
			  type: "POST",
			  url: "<?php echo URL_VIEW;?>shiftUsers/ajax_confirm_shift.php",
			  data: { shiftUserId: shiftUserConfirmedId, status: 1, user_id:<?php echo $user_id;?> }
			})
			  .done(function(response) {
				  resArr = response.split('_');
				  statusCheck = resArr[0];
				  user_id = resArr[1];
				  shift_id = resArr[2];
				  shift_date = resArr[3];
				  
				
				if(statusCheck == 'Ok'){
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
			  data: { shiftUserId: shiftUserConfirmedId, status: 0, user_id:<?php echo $user_id;?> }
			})
			  .done(function( response ) {
				  resArr = response.split('_');
				  statusCheck = resArr[0];
				  user_id = resArr[1];
				  shift_id = resArr[2];
				  shift_date = resArr[3];
				  
				
				if(statusCheck == 'Ok'){
					$('#'+shiftUserConfirmedId).attr('class', 'open_div confirmPopupOpen');
					$('#'+shiftUserConfirmedId+' span').html('Open');
					$('#'+shiftUserConfirmedId).attr('id', shift_id+'_'+user_id+'_'+shift_date);
					$.fn.colorbox.close();
					//alert('Shift Accepted');	
				}
			  });	
		});
		
		
    });
</script>