<?php

// require_once('httpful.phar');
require_once('config.php');
// require_once('config1.php');

$action = $_GET['action'];

switch ($action) {

 		case 'composeMsgUserSearch':

 		if(isset($_GET["query"]))
	 	{
	 		$query = $_GET["query"];

			$max = rand(5, 10);
			$results = array();

			for($i = 0; $i <= $max; $i++) {
				$results[] = array(
					"value" => $query . ' - ' . rand(10, 100),
					"desc" => "some description goes here...",
					"img" => "http://lorempixel.com/50/50/?" . (rand(1, 10000) . rand(1, 10000)),
					"tokens" => array($query, $query . rand(1, 10))
				);
			}

			echo json_encode($results);


	 	}


	
	default:
		# code...
		break;
}

?>