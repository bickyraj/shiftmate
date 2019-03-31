<?php
if(isset($_SESSION['user_type']) && !empty($_SESSION['user_type'])){
	/*echo '<script>window.location = "'.URL_VIEW.'";</script>';*/
}else{
	$_SESSION['access_error_message'] = 'Please login for the access';
	
}


?>