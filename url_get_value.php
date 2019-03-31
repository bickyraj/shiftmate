<?php
//print_r($_GET);
if(isset($_GET['orgId'])){
	$orgId = @$_GET['orgId'];
}else{
	$orgId = @$_GET['org_id'];
}
//$organization_id = @$_GET['org_id'];
$branch_id = @$_GET['branch_id'];
$branchId = @$_GET['branch_id'];
$board_id = @$_GET['board_id'];
$shift_id = @$_GET['shift_id'];

$user_id = @$_SESSION['user_id'];
$userId = @$_SESSION['user_id'];
$token = @$_SESSION['token'];
//$orgId = @$_SESSION['organization_id'];
$organization_id = @$_SESSION['organization_id'];
$user_type = @$_SESSION['user_type'];

if($user_type == 'organization'){
	$orgId = @$_SESSION['organization_id'];
}
if($user_type == 'user' && isset($board_id) && !empty($board_id)){
	$checkForManager = checkBoardManager($user_id, $board_id);
	if($checkForManager > 0){
		$user_role = 'manager';	
	}
		
}
?>