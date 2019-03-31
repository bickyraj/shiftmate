<?php
	function weekLayout($startdate, $dayCount = 7){
		$today_day = date('l');
		//$today_date = date('Y-m-d');
		$today_date = $startdate;
		
		$dayArr = array('Sunday'=>'1', 'Monday'=>'2', 'Tuesday'=>'3', 'Wednesday'=>'4', 'Thursday'=>'5', 'Friday'=>'6', 'Saturday'=>7);
		
		
		$date_change_value = 0;
		
			for($a=1; $a<=$dayCount; $a++){
				
				$date = date('Y-m-d', strtotime($today_date) + $date_change_value);
				$day =  date('l', strtotime($today_date) + $date_change_value);  
				$date_change_value = $date_change_value + 3600*24;
				
				$req_date_format = date('M d', strtotime($date));
				$newdays[$a][$dayArr[$day]]['day_date'] = "<p>".$day."</p><p>".$req_date_format."</p>";
				$newdays[$a][$dayArr[$day]]['day'] = $dayArr[$day];
				$newdays[$a][$dayArr[$day]]['date'] = $date;
				
			}
			
			$start_month = date('M', strtotime($today_date));
			$start_day = date('d', strtotime($today_date));
			
			$end_month = date('M', strtotime($today_date) + $date_change_value - 3600*24);
			$end_day = date('d', strtotime($today_date) + $date_change_value - 3600*24);
			
			if($start_month == $end_month){
				$duration = $start_month." ".$start_day." - ".$end_day;	
			}else{
				$duration = $start_month." ".$start_day." - ".$end_month." ".$end_day;	
			}
			
			if($dayCount == 7){
				$duration_name = "Week";	
			}elseif($dayCount == 15){
				$duration_name = "Fortnight";	
			}elseif($dayCount == 30){
				$duration_name = "Month";	
			}else{
				$duration_name = "Day";	
			}
			
			$starting_date = $startdate;
			$ending_date = $date;
			
			$returnVal = array($newdays, $duration, $duration_name, $starting_date, $ending_date);
		
		return $returnVal;
		
	}
	
	// for employees last fortnights startdate and end date
	function date_duration_last($date_diff){
		$dayArr = array('Sunday'=>'1', 'Monday'=>'2', 'Tuesday'=>'3', 'Wednesday'=>'4', 'Thursday'=>'5', 'Friday'=>'6', 'Saturday'=>7);
		$today = date('Y-m-d');
		$today_day = date('l');
		$day_num = $dayArr[$today_day];
		$fortnightCalculation_startDate = $date_diff + $day_num - 1;
		$fortnightCalculation_endDate = $day_num;
		$fortnightSec_startdate = 3600*24*$fortnightCalculation_startDate;
		$fortnightSec_enddate = 3600*24*$fortnightCalculation_endDate;
		
		$lastFortnight_startdate = date('Y-m-d', strtotime($today) - $fortnightSec_startdate);
		$lastFortnight_enddate = date('Y-m-d', strtotime($today) - $fortnightSec_enddate);
		
		$output = array($lastFortnight_startdate, $lastFortnight_enddate);
		//print_r($output);
		return $output; 	
	}
	
	// for employees current week startdate and to yesterday
	function date_duration_current($date_diff = 0){
		$dayArr = array('Sunday'=>'1', 'Monday'=>'2', 'Tuesday'=>'3', 'Wednesday'=>'4', 'Thursday'=>'5', 'Friday'=>'6', 'Saturday'=>7);
		$today = date('Y-m-d');
		$today_day = date('l');
		$day_num = $dayArr[$today_day];
		$fortnightCalculation_startDate = $date_diff + $day_num - 1;
		$fortnightCalculation_endDate = $day_num;
		$fortnightSec_startdate = 3600*24*$fortnightCalculation_startDate;
		
		
		$lastFortnight_startdate = date('Y-m-d', strtotime($today) - $fortnightSec_startdate);
		$lastFortnight_enddate = date('Y-m-d', strtotime($today) - 3600*24);
		//$lastFortnight_enddate = $today;
		$output = array($lastFortnight_startdate, $lastFortnight_enddate);
		
		return $output; 	
	}
	
	function hourCalculator($data){
		$hour_worked_sec = 0;
		foreach($data as $reports){
			$starttime = strtotime($reports->Shift->starttime);
			$endtime = strtotime($reports->Shift->endtime);
			$time_diff = $endtime - $starttime;
			if($time_diff < 0){
				$time_diff = $time_diff + 24*3600;	
			}
			$hour_worked_sec = $hour_worked_sec + $time_diff;
		}
		$last_fortnight_hour_worked_hour = $hour_worked_sec / 3600;
		
		return $last_fortnight_hour_worked_hour;
	}
	
	function myOrgShiftRange_url($user_id, $orgId, $branch_id, $start_date, $end_date){
			
		$url_report = URL . "ShiftUsers/myOrgShiftRange/" .$user_id. "/".$orgId."/".$branch_id."/".$start_date."/".$end_date.".json";
		$data_report = \Httpful\Request::get($url_report)->send();
		$report = $data_report->body->myOrgShiftRange;
		
		return $report;
	}
	
	
	function getHolidays($org_id = NULL, $branch_id = NULL, $start_date = NULL, $end_date = NULL){
		$status = 0; // for holidays
		/*if($branch_id == NULL){
			$branch_id = 0;	
		}*/
		$today = date('Y-m-d');
            if($start_date == NULL){
                $start_date = date('Y-m-d', strtotime($today) - 24*3600*90);
            }
            if($end_date == NULL){
                $end_date = date('Y-m-d', strtotime($today) + 24*3600*90);
            }
		$url = URL . "Organizationfunctions/holidays/".$org_id. "/".$branch_id. "/".$start_date."/".$end_date.".json";
		$data = \Httpful\Request::get($url)->send();
		$holidays = $data->body->holidays;
		$holiday_arr = array();
		foreach($holidays as $holiday){
			$holiday_arr[] = $holiday->Organizationfunction->function_date;
		}
		
		return $holiday_arr;
	}
	
	function priceCalculateOrgBranches($user_id, $start_date, $end_date){
		$url = URL . "OrganizationUsers/priceCalculateOrgBranches/".$user_id."/".$start_date."/".$end_date.".json";
		$data_url = \Httpful\Request::get($url)->send();
		$output = $data_url->body->output;
		return $output;
	}
	
	function priceCalculateOrgBranchesPermanent($user_id, $start_date, $end_date){
		$url = URL . "Permanentshifts/priceCalculateOrgBranchesPermanent/".$user_id."/".$start_date."/".$end_date.".json";
		$data_url = \Httpful\Request::get($url)->send();
		$output = $data_url->body->output;
		return $output;
	}
	
	
	function priceCalculator($user_id, $org_id, $branch_id, $start_date, $end_date){
		/*if($branch_id == NULL){
			$branch_id = 0;	
		}*/
		$holidays = getHolidays($org_id, $branch_id, $start_date, $end_date); 
		$paymentFactorRates  = getPaymentFactorRate($org_id, $branch_id);
		foreach($paymentFactorRates as $paymentFactorRate){
			$paymentFactorRateArray[$paymentFactorRate->Multiplypaymentfactortype->title] = $paymentFactorRate->MultiplyPaymentFactor->multiply_factor; 	
		}
		
		$data = myOrgShiftRange_url($user_id, $org_id, $branch_id, $start_date, $end_date);
		
		$output = array();
		$count = 0;
		$total_cost = 0;
		$sat_sun_count = 0;
		$hour_worked_sec = 0;
		foreach($data as $datas){
			$time_diff = 0;
			$time_diff_hour = 0;
			$rate = 0;
			$cost = 0;
			
			$starttime = strtotime($datas->Shift->starttime);
			$endtime = strtotime($datas->Shift->endtime);
			$time_diff = $endtime - $starttime;
			if($time_diff < 0){
				$time_diff = $time_diff + 24*3600;	
			}
			$time_diff_hour = $time_diff / 3600;
			$hour_worked_sec = $hour_worked_sec + $time_diff;
			
			if(in_array($datas->ShiftUser->shift_date, $holidays)){
				$output['yes'][$count][]= $datas->ShiftUser->shift_date;
				if(isset($paymentFactorRateArray['Holiday']) && !empty($paymentFactorRateArray['Holiday'])){
					$rate = $paymentFactorRateArray['Holiday'];
				}else{
					$rate = 1;	
				}
				$output['yes'][$count]['rate'] = $rate;
				$output['yes'][$count]['shift_duration'] = $time_diff_hour;
				$cost = $rate * $time_diff_hour;
				$output['yes'][$count]['cost'] = $cost;
				$total_cost = $total_cost + $cost;
			}else{
				$output['no'][$count][]= $datas->ShiftUser->shift_date;
				$day_name = date('l', strtotime($datas->ShiftUser->shift_date));
				$output['no'][$count]['day'] = $day_name;
				if(isset($paymentFactorRateArray[$day_name]) && !empty($paymentFactorRateArray[$day_name])){
					$rate = $paymentFactorRateArray[$day_name];
					$sat_sun_count++;
				}else{
					$rate = 1;
				}
				
				$output['no'][$count]['rate'] = $rate;
				$output['no'][$count]['shift_duration'] = $time_diff_hour;
				$cost = $rate * $time_diff_hour;
				$output['no'][$count]['cost'] = $cost;
				$total_cost = $total_cost + $cost;
			}
			$count++;
		}
			$hour_worked = $hour_worked_sec / 3600;
			$output['total_cost'] = $total_cost;
			$output['holiday'] = count($holidays);
			$output['sat_sun_count'] = $sat_sun_count;
			$output['hour_worked'] = $hour_worked;
			
			//$test = array($user_id, $org_id, $branch_id, $start_date, $end_date);
		return $output;
	}
	
	function getPaymentFactorRate($org_id = NULL, $branch_id){
		$url_report = URL . "MultiplyPaymentFactors/paymentFactorRates/" .$org_id. "/".$branch_id.".json";
		$data_report = \Httpful\Request::get($url_report)->send();
		$report = $data_report->body->paymentFactorRates;
		
		return $report;
	}
	
	function getEmployeeOrganizations($user_id){
		$url = URL . "OrganizationUsers/myOrganizationLists/".$user_id.".json";
		$data = \Httpful\Request::get($url)->send();
		$myOrganizations = $data->body->myOrganizations;
		
		return $myOrganizations;
	}
	
	function getOrgBranchList($org_id){
		$url = URL . "Branches/BranchesList/".$org_id.".json";
		$data = \Httpful\Request::get($url)->send();
		$branches = $data->body->branches;
		
		return $branches;
	}
	
	function getUserList(){
		$url = URL . "Users/userList.json";
		$data = \Httpful\Request::get($url)->send();
		$users = $data->body->users;
		
		return $users;
	}
	
	function getUserListSentMessage($user_id){
		$url = URL . "Users/getUserListSentMessage/".$user_id.".json";
		$data = \Httpful\Request::get($url)->send();
		$userListSentMessage = $data->body->userListSentMessage;
		
		return $userListSentMessage;
	}
	
	function getUserListReceiveMessage($user_id){
		$url = URL . "Users/getUserListReceiveMessage/".$user_id.".json";
		$data = \Httpful\Request::get($url)->send();
		$userListReceiveMessage = $data->body->userListReceiveMessage;
		
		return $userListReceiveMessage;
	}
	
	function getMessageDetail($message_id){
		$url = URL . "Messages/getMessageDetail/".$message_id.".json";
		$data = \Httpful\Request::get($url)->send();
		$messageDetail = $data->body->messageDetail;
		
		return $messageDetail;
	}
	
	function getBoardListReceiveMessage($user_id){
		$url = URL . "Users/getBoardListReceiveMessage/".$user_id.".json";
		$data = \Httpful\Request::get($url)->send();
		$userListReceiveMessage = $data->body->output;
		
		return $userListReceiveMessage;
	}
	
	function getMessageDetailBoard($message_id){
		$url = URL . "Boardmessages/getMessageDetail/".$message_id.".json";
		$data = \Httpful\Request::get($url)->send();
		$messageDetail = $data->body->messageDetail;
		
		return $messageDetail;
	}
	
	function getOrgListReceiveMessage($user_id){
		$url = URL . "Users/getOrgListReceiveMessage/".$user_id.".json";
		$data = \Httpful\Request::get($url)->send();
		$userListReceiveMessage = $data->body->output;
		
		return $userListReceiveMessage;
	}
	
	function getMessageDetailOrg($message_id){
		$url = URL . "Organizationmessages/getMessageDetail/".$message_id.".json";
		$data = \Httpful\Request::get($url)->send();
		$messageDetail = $data->body->messageDetail;
		
		return $messageDetail;
	}
	
	
	function getLoginUserDetail($login_detail){

		$_SESSION['user_status'] = $login_detail->status;
		$_SESSION['token'] = $login_detail->token;
		$_SESSION['user_id'] = $login_detail->user_id;
		
		if($login_detail->status == 1){ // normal user
			$_SESSION['user_type'] = 'user';
			$_SESSION['organization_id'] = 0;
			$login_type['status'] = 1;
			$login_type['name'] = 'Normal User';
			
		}elseif($login_detail->status == 2){ // organization
			$_SESSION['user_type'] = 'organization';
			$_SESSION['organization_id'] = $login_detail->organization_id;
			$login_type['status'] = 2;
			$login_type['name'] = "Organization";
			
		
		}elseif($login_detail->status == 3){ // suerp admin
			$_SESSION['organization_id'] = 0;
			$_SESSION['user_type'] = 'admin';
			$login_type['status'] = 3;
			$login_type['name'] = 'Admin';
			
		}else{
			$_SESSION['user_type'] = '';
			$_SESSION['token'] = '';
			$_SESSION['user_id'] = '';
			$login_type['status'] = 0;
			$login_type['name'] = 'Fail';
			$_SESSION['error_message'] = 'username / password incorrect';
			
		}

		//print_r($login_type);
		//die('inside');
	}
	
	function checkBoardManager($user_id, $board_id){
		$url = URL . "Boards/checkForBoardManager/".$user_id."/".$board_id.".json";
		$data = \Httpful\Request::get($url)->send();
		$status = $data->body->output;
		return $status;
	}

	function loginUserRelationToOther($user_id){
		$url_report = URL . "Users/loginUserRelationToOther/" .$user_id. ".json";
		$data_report = \Httpful\Request::get($url_report)->send();
		$report = $data_report->body->output;
		return $report;
	}

	function imageGenerate($orgimage,$image,$gender)

	{
		if($image && @GetImageSize($orgimage)){
			return $orgimage;
		}
		
		else
		{
			if ($gender == '0') {

				return URL.'webroot/files/user_image/defaultuser.png';
			}
			else if($gender == '1')
			{
				return URL.'webroot/files/user_image/femaleadmin.png';

			}
			else
			{
				return URL.'webroot/files/user_image/noimage.png';
			}
		}
	}
	// get date and time function by rabi
	function getStandardDateTime($dateTime)
	{
	    $startTime = new DateTime($dateTime);
	    return $startTime->format('jS F Y \, g:i A');
	}

	function convertDate($date)
	{
	    $startTime = new DateTime($date);
	    return $startTime->format('jS F Y');
	}
	

	// for debug by Bicky Raj Kayastha
	function fal($arr = null)
	{
	    echo "<pre>";
	    print_r($arr);
	    die();
	}

	// H:i:s to standart time format
	function hisToTime($hisTime)
	{
	    $startTime = new DateTime($hisTime);
	    return $startTime->format('g:i A');
	}
	// end of debug function
    
    function checkFileExists($file){
	    $file_headers = @get_headers($file);
	    if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
	        $exists = false;
	    }
	    else {
	        $exists = true;
	    }
	    return $exists;
	}

	function getStandardDateDayTime($dateTime)
	{
	    $startTime = new DateTime($dateTime);
	    return $startTime->format('D, F jS, Y \, g:i A');
	}

	function getStandardDateDay($dateTime)
	{
	    $startTime = new DateTime($dateTime);
	    return $startTime->format('D, F jS, Y');
	}

?>