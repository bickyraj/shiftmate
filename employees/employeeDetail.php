<?php


$userId = $_GET['user_id'];


$url = URL."Users/employeeDetail/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$employee = $data->body->employee;
echo "<pre>";
print_r($employee);




?>