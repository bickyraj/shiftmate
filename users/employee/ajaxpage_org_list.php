<?php
include('../../httpful.phar');
include('../../config1.php');
//define("URL", "http://localhost/newshiftmate/");

$message = $_POST['message'];
$organization_id = $_POST['organization_id'];

	$url = URL."Organizationmessages/myOrganizationMessages/".$organization_id.".json";
	$r = \Httpful\Request::get($url)->send();
	$response = $r->body->message;
	print_r($response);
?>