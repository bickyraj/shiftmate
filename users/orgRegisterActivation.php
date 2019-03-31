<?php
    
    $orgUserId= base64_decode($_GET['b3JnVXNlcklk']);
    $userId= base64_decode($_GET['dXNlcklk']);
    $url = URL . "OrganizationUsers/getUserDetail/".$orgUserId.".json";
    $data = \Httpful\Request::get($url)->send();
    $userDetail = $data->body->userDetail;
    
?>
<!--Click Here For Activation<br>
<button type="button" class="btn btn-primary" id="activate">Click For Activate</button>
<script src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#activate').on('click',function(){
            //alert('hello');
            var orgUserId = '<?php echo $_GET['orgUserId']; ?>';
            var user_id = '<?php echo $_GET['userId']; ?>'; 
            
            
            $.ajax({                    
                        url:'<?php echo URL."Users/activeOrgRegister/"."'+orgUserId+'"."/"."'+user_id+'".".json";?>',
                        type:'post',
                        datatype:'jsonp',
                       success:function(response)
                                {
                                    
                                    if (response.output == 1) {

                                        alert('Your Account is activated');

                                    }
                                    else if(response.output == 3){
                                        alert('already activated');
                                    }
                                    else{
                                        alert('Sorry Something went wrong');
                                    }
                                    
                        }
                    });

        });
    });
</script>-->

<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Shiftmate</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo URL_VIEW;?>admin/pages/css/coming-soon.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->

<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12 coming-soon-header" style="text-align:center;">
            <img src="<?php echo URL_VIEW;?>admin/layout3/img/logo.png" alt="logo">
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 coming-soon-content" style="text-align:center;">
            <h3>Hi <?php echo $userDetail->User->fname.' '.$userDetail->User->lname; ?>,please Confirm to join <?php echo $userDetail->Organization->title; ?></h3>
            <form class="form-inline" action="#">
                <div class="input-group input-large">
                   <button type="button" class="btn blue" id="activate">Activate Here</button>
                    
                </div>
            </form>
            
        </div>
        <!-- <div class="col-md-6 coming-soon-countdown">
            <div id="defaultCountdown">
            </div>
        </div> -->
    </div>
    <!--/end row-->
    <div class="row">
        <div class="col-md-12 coming-soon-content" style="text-align:center;">
             Designed &amp; Developed By: <a href="#" target="_blank">OnePlatinum Technology</a>
        </div>
    </div>
</div>

<script src="<?php echo URL_VIEW;?>global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo URL_VIEW;?>global/plugins/countdown/jquery.countdown.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_VIEW;?>global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/coming-soon.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/ui-alert-dialog-api.js"></script>
<!-- END PAGE LEVEL SCRIPTS 
<script src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>-->

<script type="text/javascript">
   $(document).ready(function(){
        $('#activate').on('click',function(){
            //alert('hello');
            var orgUserId = '<?php echo $orgUserId; ?>';
            var user_id = '<?php echo $userId; ?>'; 
            
            
            $.ajax({                    
                        url:'<?php echo URL."Users/activeOrgRegister/"."'+orgUserId+'"."/"."'+user_id+'".".json";?>',
                        type:'post',
                        datatype:'jsonp',
                       success:function(response)
                                {
                                    
                                    if (response.output == 1) {

                                        bootbox.dialog({
                                            title: '<div style="text-align:center;">Account is  Activated</div>',
                                            message:'<form method="post" action="" class="form-body"> ' +
                                                    '<div style="text-align:center;"><a href="<?php  echo URL_VIEW; ?>" class="btn btn-success">ok</a>'+
                                                    
                                                '</form>'
                                            });

                                    }
                                    else if(response.output == 3){
                                        bootbox.dialog({
                                            title: '<div style="text-align:center;">Already Activated</div>',
                                            message:'<form method="post" action="" class="form-body"> ' +
                                                    '<div style="text-align:center;"><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button></div></div>'+
                                                    
                                                '</form>'
                                            });
                                    }
                                    else{
                                        bootbox.dialog({
                                            title: '<div style="text-align:center;">Sorry Something Went Wrong</div>',
                                            message:'<form method="post" action="" class="form-body"> ' +
                                                    '<div style="text-align:center;"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div>'+
                                                    
                                                '</form>'
                                            });
                                    }
                                    
                        }
                    });

        });
    });
</script>
<script>
jQuery(document).ready(function() {     
  Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
  ComingSoon.init();
  // init background slide images
     $.backstretch([
            "<?php echo URL_VIEW;?>admin/pages/media/bg/1.jpg",
            "<?php echo URL_VIEW;?>admin/pages/media/bg/2.jpg",
            "<?php echo URL_VIEW;?>admin/pages/media/bg/3.jpg",
    "<?php echo URL_VIEW;?>admin/pages/media/bg/4.jpg"
        ], {
        fade: 1000,
        duration: 10000
   });
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>