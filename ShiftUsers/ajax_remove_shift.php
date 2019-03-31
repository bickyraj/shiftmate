<?php
include('../httpful.phar');
include('../config1.php');
//define("URL", "http://192.168.0.112/newshiftmate/");

$shift_user_date = $_POST['source'];
$board_id  = $_POST['board_id'];

//print_r($_POST);

	$url = URL."ShiftUsers/deleteShift/".$shift_user_date."/".$board_id.".json";
	$r = \Httpful\Request::get($url)->send();
	$response = $r->body->message->status;
	//print_r($response);
	echo $response;
	
	
?>