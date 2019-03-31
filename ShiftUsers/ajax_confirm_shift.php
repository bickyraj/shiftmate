<?php
include('../httpful.phar');
include('../config1.php');
//define("URL", "http://192.168.0.112/newshiftmate/");

$shiftUserConfirmedId = $_POST['shiftUserId'];
$status = $_POST['status'];
if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
	$user_id = $_POST['user_id'];
}else{
	$user_id = 0;	
}

//print_r($_POST);

	$url = URL."ShiftUsers/confirmShift/".$shiftUserConfirmedId."/".$status."/".$user_id.".json";
	$r = \Httpful\Request::get($url)->send();
	$response = $r->body->message;
	//print_r($response);
	//echo $response;
	//echo json_encode ($response->shiftUserDetail->ShiftUser);
	
	
	$status = $response->status;
	if($status == 'Ok'){
		echo $status;	
	}else{
		$user_id = $response->shiftUserDetail->ShiftUser->user_id;
		$shift_id = $response->shiftUserDetail->ShiftUser->shift_id;
		$date = $response->shiftUserDetail->ShiftUser->shift_date;
		echo $status."_".$user_id."_".$shift_id."_".$date;
	}
	
?>