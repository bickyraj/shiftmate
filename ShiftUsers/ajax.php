<?php
include('../httpful.phar');
include('../config1.php');

//define("URL", "http://192.168.0.112/newshiftmate/");

$source = $_POST['source'];
$destination = $_POST['destination'];
$board_id = $_POST['board_id'];
$status = $_POST['status'];

//print_r($_POST);

	$url = URL."ShiftUsers/changeShift/".$source."/".$destination."/".$board_id."/".$status.".json";
	$r = \Httpful\Request::get($url)->send();
	$response = $r->body->message;
	//print_r($response);
	if($response->status == 'notAvailable'){
		echo json_encode($response->available->availTime);	
	}else{
		echo json_encode($response->status);	
	}
	
?>