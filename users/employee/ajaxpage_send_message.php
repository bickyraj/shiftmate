<?php
include('../../httpful.phar');
include('../../config1.php');
//define("URL", "http://localhost/newshiftmate/");

$message = $_POST['message'];
$organization_id = $_POST['organization_id'];
$datetime = date('Y-m-d H:i:s');
$user_id = $_POST['user_id'];
//print_r($_POST);
	$url = URL."Organizationmessages/add_message.json";
	
	$response = \Httpful\Request::put($url)                  // Build a PUT request...
	//->addHeader('token', $token)
    ->sendsJson()                               // tell it we're sending (Content-Type) JSON...
    //->authenticateWith('username', 'password')  // authenticate with basic auth...
    ->body(array('Organizationmessage' => array('organization_id'=>$organization_id, 'user_id'=>$user_id, 'text'=>$message, 'status'=> 1, 'date_time'=>$datetime)))          // attach a body/payload...
    ->send();
	
	echo $response->body->message;
?>