<?php 
session_start();
date_default_timezone_set("Asia/Kathmandu"); 
	include('config.php');
	include('function.php');
	//include('loginCheck.php');
	include('url_get_value.php');


//echo $_GET['url'];die();
	if(isset($_GET['url'])){
		$url = rtrim($_GET['url'], '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/', $url);
		//print_r($url);die();
		
		if(@$url[0] == 'users' && @$url[1]=='employee' && @$url[2] == 'profile'){
			$body_class = "page-sidebar-closed-hide-logo page-container-bg-solid";	
		}else{
			$body_class = "page-quick-sidebar-over-content";
		}
		
	}else{
		$body_class = "page-sidebar-closed-hide-logo page-container-bg-solid";	
	}
	
	if(isset($user_id) && !empty($user_id) && $user_id != '' ){
		if(@$url[1] != 'orgRegisterActivation' && @$url[1] != 'registerByEmail' && @$url[1] != 'activateOrg' ){
			include('header.php');
			$loginUserRelationToOther = loginUserRelationToOther($user_id);
		}

	}
	//echo $branch_id.$org_id;
	
	 
?>

<!-- END SIDEBAR -->
<div class="page-container">

	<?php 



	if(isset($url) && @$url[1] == 'orgRegister' || @$url[1]=='employeeRegistration' || @$url[1]=='activateNewUser' || @$url[1]=='shiftActivateUsingPin' || @$url[1]=='activeAssignUser' || @$url[1]=='orgRegisterActivation' || @$url[1]=='registerByEmail' || @$url[1]=='resetPassword'|| @$url[1]=='activateOrg' || @$url[1]=='enterNewPassword' || @$url[1]=='activateNewUserAssignByOrg' || @$url[1]=='testRegistration'){


		if(is_dir($url[0]) && count($url)==2  && file_exists($url[0]."/".$url[1].".php")){
			//echo "2";
			
				include($url[0]."/".$url[1].".php");
				}elseif(is_dir($url[0]) && count($url)==3 && file_exists($url[0]."/".$url[1]."/".$url[2].".php")){
					include($url[0]."/".$url[1]."/".$url[2].".php");
				}else{
					//echo "test";
					include('404.php');	
				}
		
	}else{
	//print_r($url);
	//if(isset($token) && !empty($token)){
		if(isset($user_id) && !empty($user_id) && $user_id != ''){
			if(isset($_GET['url'])){
				// print_r($url[1]);
				// die();
				if(is_dir($url[0]) && count($url)==2  && file_exists($url[0]."/".$url[1].".php")){
					include($url[0]."/".$url[1].".php");
				}elseif(is_dir($url[0]) && count($url)==3 && file_exists($url[0]."/".$url[1]."/".$url[2].".php")){
					include($url[0]."/".$url[1]."/".$url[2].".php");
				}else{
					include('404.php');	
				}
			}else{
				if($user_type == 'user'){
					include('dashboard.php');
				}elseif($user_type == 'organization'){
					include('organization_dashboard.php');
				}else{
					include('admin_dashboard.php');	
				}
			}
		}else{
			include('login.php');
		}
	}
	?>

</div>
<!--end container-->
<?php 
if(isset($user_id) && !empty($user_id) && $user_id != ''){

	if(isset($_GET['url'])){
		$url = rtrim($_GET['url'], '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/', $url);
	}
	
	if(@$url[1] != 'orgRegisterActivation' && @$url[1] != 'registerByEmail' && @$url[1] != 'activateOrg'){
		include('footer.php');
    }
}
?>
</body>
</html>