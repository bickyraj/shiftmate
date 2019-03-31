<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shiftmate</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>

<body>

<?php
//session_start();
//include('config.php');

if(isset($_POST['submit']) && $_POST['submit']=="Log In"){
	
	
	$email = $_POST['email'];
	$password = $_POST['password'];

	$url = URL."Users/login.json";
	$response = \Httpful\Request::put($url)                  // Build a PUT request...
    ->sendsJson()  
	//->addHeader('X-MyApiTokenHeader', '123456')                            // tell it we're sending (Content-Type) JSON...
    //->authenticateWith($username, $password)  // authenticate with basic auth...
    ->body(array('User'=>array('email'=>$email, 'password'=>$password)))             // attach a body/payload...
    ->send();
	//echo "<pre>";
	//print_r($response->body->message);
	//die();
	$login_detail = $response->body->message;
	//echo "<pre>";
	//print_r($login_detail);
	//die();
	$_SESSION['user_status'] = $login_detail->status;
	$_SESSION['token'] = $login_detail->token;
	$_SESSION['user_id'] = $login_detail->user_id;
	if($login_detail->status == 1){ // normal user
	$_SESSION['user_type'] = 'user';
		$_SESSION['organization_id'] = 0;
		
		echo '<script>window.location.assign("index.php")</script>';
	}elseif($login_detail->status == 2){ // organization
	$_SESSION['user_type'] = 'organization';
		$_SESSION['organization_id'] = $login_detail->organization_id;
		echo '<script>window.location.assign("index.php")</script>';
		
	}elseif($login_detail->status == 3){ // suerp admin
		$_SESSION['organization_id'] = 0;
		$_SESSION['user_type'] = 'admin';
		echo '<script>window.location.assign("index.php")</script>';
	}else{
		$_SESSION['user_type'] = '';
		$_SESSION['token'] = '';
		$_SESSION['user_id'] = '';
		echo "Email/password is incorrect";	
	}
}
?>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>styles/login.css"/>

<div class="clear"></div>
<form action="" method="post">
    <div class="loginBg">
            <div class="loginHeader">Shiftmate Login</span></div>
            
            <ul>
                <li>
                <label>Email Address</label></li>
                <li>
                <input type="text" name="email" id="email"></li>
                <li>
                <label>Password</label></li>
                <li>
                <input type="password" name="password" id="password">
                </li>
                <li>
                <div class="clear"></div>
                <input type="checkbox"><span class="check">Remember me</span>
                </li>
            </ul>
            <div class="clear"></div>
            <a href="#">Forget password?</a>
            <input type="submit" name="submit" value="Log In">
            <div class="clear"></div>
            <div class="registerLineLogin"><a href="<?php echo URL_VIEW;?>organizations/orgRegister">Register Organization</a> | <a href="<?php echo URL_VIEW;?>employees/employeeRegistration">Register User</a></div>
        </div>
</form>
</body>
</html>
