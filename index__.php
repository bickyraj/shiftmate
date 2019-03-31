<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Shiftmate Shedule</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 
	include('config.php');
	include('function.php');

	if(isset($_GET['url'])){
		$url = rtrim($_GET['url'], '/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/', $url);
	}
?>
<script src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
<!--<script src="<?php echo URL_VIEW;?>js/date-dropdown.js"></script>-->
<script>
$(document).ready(function(){
  $(".btn").click(function(){

  	if($(".leftMenu").css('left')=="0px")
  	{
  		$(".leftMenu").animate({left:"-19%"});
  		$(".rightContent").animate({width:"99%"});
		$(".workingEmployee").animate({width:"46%"});
		$(".feedContent").animate({width:"52%"});
  	}

  	else
  	{
  		$(".leftMenu").animate({left:"0px"});
  		$(".rightContent").animate({width:"79.5%"});
		$(".feedContent").animate({width:"58%"});
		$(".workingEmployee").animate({width:"40%"});
  	}
});

});

</script>
<script src="<?php echo URL_VIEW;?>js/action_hover.js"></script>
<!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>styles/style.css"/>
</head>

<?php	
	include('header.php');
?>		

<div class="clear"></div>
	<?php 
	if(isset($_GET['url'])){
		if(is_dir($url[0]) && file_exists($url[0]."/".$url[1].".php")){
			include($url[0]."/".$url[1].".php");
		}else{
			include('404.php');	
		}
	}else{
		include('dashboard.php');
	}?>


</div>
<!--end container-->

</div>
</div>

<?php include('footer.php');?>
</body>