<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Shiftmate Schedule</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<style>
.page-header-top{
    border-bottom: 3px solid #eff3f8;
    background-color: #333333;
}
#navi,#infoi {
  position: absolute;
}
#infoi {
  z-index: 10; 
  margin-left: 20px;
}
#navi{
    margin: auto;
}
</style>
<?php
   
    $branchManager = loginUserRelationToOther($user_id)->branchManager;
    if(isset($branchManager) && !empty($branchManager))
    {
        $arr = array();
        foreach ($branchManager as $key => $value) {

            $arr[] = $key;
        }
        $asAbranchManager =1;
        $listofbranchManagerArr = implode('_', $arr);
    }
    
    $boardManager = loginUserRelationToOther($user_id);

    $boardManager = $boardManager->boardManager;
    $asABoardManager =0;
    $listofBoardManagerArr = 0;

    if(isset($boardManager) && !empty($boardManager))
    {
        $arr = array();
        foreach ($boardManager as $key => $value) {

            $arr[] = $key;
        }
        $asABoardManager =1;
        $listofBoardManagerArr = implode('_', $arr);
    }


    $url_head = URL."Users/userDetail/".$user_id.".json";
    $response = \Httpful\Request::get($url_head)->send();
    $response = $response->body->message;
    if(isset($response) && empty($response))
    {
        $userRole = '2';
    }
    else
    {
        $userRole = $response->User->status;
    }


    $url_head = URL."Receivers/messageCount/".$userId.".json";
    $messageCount = \Httpful\Request::get($url_head)->send();
    $receivedMessage = $messageCount->body;
   
    $url_head = URL."Tasks/taskCount/".$userId.".json";
    $taskCount = \Httpful\Request::get($url_head)->send();
    $taskCounts = $taskCount->body->taskCount;
   
if ($_SESSION['user_type'] == 'user') {
    $status = 1;
   $url_head = URL."Users/userDetail/".$userId."/".$status.".json";
    $user = \Httpful\Request::get($url_head)->send();
    $userDetails = $user->body->message;

}
else{
    $status = 2;
 $url_head = URL."Users/orgDetail/".$userId."/".$status.".json";
$organization = \Httpful\Request::get($url_head)->send();
$orgDetails = $organization->body->message;
}
// echo "<pre>";
// print_r($userDetails);
// die();

$orgProfile = URL_VIEW."organizations/orgView?org_id=".$orgId;

    // Shift Swap Notification for manager api
if ($_SESSION['user_type'] == 'user') {

if(isset($user_id) && !empty($user_id))
{

        $loginUserRelationToOther = loginUserRelationToOther($user_id);

        // fal($loginUserRelationToOther);

        if(isset($loginUserRelationToOther->boardManager)&& !empty($loginUserRelationToOther->boardManager))
        {
            $boardarr = array();
            foreach ($loginUserRelationToOther->boardManager as $key => $value) {
                $boardarr[]=$key;
            }

            $boardarr = implode('_',$boardarr);

            $url_login = URL."Shiftswaps/swapNotification/".$boardarr.".json";
            $response = \Httpful\Request::get($url_login)->send();

            if($response->body->output->status == 1)
            {
                $shiftNotificationCount = $response->body->shifts;
                // fal($shiftNotificationCount);
            }
        }
}
}

    // End of shift swap notification for manager api
?>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="<?php echo URL_VIEW;?>global/css/shiftmate-style.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW ?>global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL_VIEW ?>global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL_VIEW ?>global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL_VIEW ?>global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL_VIEW;?>global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<link href="<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet"/>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW ?>global/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW ?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW ?>global/plugins/jquery-multi-select/css/multi-select.css"/>
<!-- BEGIN THEME STYLES -->
<link href="<?php echo URL_VIEW ?>global/css/components.css" id="style_components" rel="stylesheet" type="text/css">
<link href="<?php echo URL_VIEW ?>global/css/plugins.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL_VIEW ?>admin/layout3/css/layout.css" rel="stylesheet" type="text/css">
<link href="<?php echo URL_VIEW ?>admin/layout3/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color">
<link href="<?php echo URL_VIEW ?>admin/layout3/css/custom.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/clockface/css/clockface.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>

<!-- Toastr Notification CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-toastr/toastr.min.css"/>
<!-- End of Toastr Notification CSS -->

<link href="<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>


<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
<!-- end of light box css -->

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="<?php //echo $body_class;?>">
<!-- BEGIN HEADER -->
<div class="page-header">
    <div class="page-header-top">
        <!-- BEGIN HEADER INNER -->
        <div class="container">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="<?=URL_VIEW;?>"><img src="<?php echo URL_VIEW;?>admin/layout3/img/logo.png" alt="logo" class="logo-default"/></a>
            </div>
            
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    

                    <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                        <a href="javascript:;" id="clickMessage" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true" style="background-color: transparent;">
                        <i class="icon-envelope-open"></i>
                        <span class="badge badge-default" id="msgNotifBadge" style="right:12px;"></span>
                        </a>

                        <ul class="dropdown-menu" id="newMessageList">
                            <!-- <li class="external">
                                <h5>You have <span class="bold"><?php echo $receivedMessage; ?> New</span> Messages</h5>
                                <a class="viewAllMsg">view all</a>
                            </li> -->
                           
                        </ul>

                    </li>        


                    <!-- END INBOX DROPDOWN -->
                    <!-- BEGIN TODO DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
                        <?php if($taskCounts == '0'){ ?>
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="background-color: transparent;">
                                <i class="icon-calendar"></i>
                            </a>
                        <?php } else{ ?>
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="background-color: transparent;">
                                <i class="icon-calendar"></i>
                                <span class="badge badge-default"><?php echo $taskCounts; ?> </span>
                             </a>
                        <?php } ?>
                        
                        <ul class="dropdown-menu extended tasks">
                            <li class="external">
                                <h5>You have <span class="bold"><?php echo $taskCounts; ?> pending</span> tasks</h5>
                                <a href="<?php echo URL_VIEW; ?>tasks/listTask">view all</a>
                            </li>
                            
                        </ul>
                    </li>
      
                    <!-- END TODO DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->

                    <li class="dropdown dropdown-user dropdown-dark">
                         <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="background-color: transparent;">
                        <?php if ($_SESSION['user_type'] == 'admin') { ?>
                        <img src="<?php echo URL.'webroot/files/organization/logo/'.$userDetails->User->image_dir.'/thumb2_'.$userDetails->User->image; ?>" alt="Image Not Found" class="img-responsive headerImg">
                            <span class="username username-hide-on-mobile">
                        <?php echo $userDetails->User->username; ?></span>
                        <i class="fa fa-angle-down"></i>
                        <?php } 
                            else if($_SESSION['user_type'] == 'organization') {
                                $orgImage =URL.'webroot/files/organization/logo/'.$orgDetails->Organization->logo_dir.'/thumb_'.$orgDetails->Organization->logo;
                                if ($orgDetails->Organization->logo && @GetImageSize($orgImage)) {
                        ?>

                            <img src="<?php echo URL.'webroot/files/organization/logo/'.$orgDetails->Organization->logo_dir.'/thumb_'.$orgDetails->Organization->logo; ?>" alt="Image Not Found" class="img-responsive headerImg">
                            <span class="username username-hide-on-mobile">
                             <?php }else{
                            if ($orgDetails->User->gender == '0') {
                               
                            ?>
                            <img src="<?php echo URL.'webroot/files/user_image/defaultuser.png' ?>" alt="Image Not Found" class="img-responsive headerImg">
                            <?php 
                        }
                        else
                        {
                        ?><img src="<?php echo URL.'webroot/files/user_image/femaleadmin.png' ?>" alt="Image Not Found" class="img-responsive headerImg">
                        <?php
                        }
                        }
                        ?>
                        <?php echo $orgDetails->User->username; ?></span>

                        <i class="fa fa-angle-down"></i>
                        <?php } else{?>
                        <?php
                            $image_files = URL.'webroot/files/user/image/'.$userDetails->User->image_dir.'/thumb2_'.$userDetails->User->image;
                            // echo $image_files;
                            //$file_headers = @get_headers($image_files);
                            //print_r($image_files);
                            // if (@GetImageSize($image_files)) {
                            //     echo "image there";
                            // }
                            // else{
                            //     echo "no image";
                            // }

                            if ($userDetails->User->image && @GetImageSize($image_files)) {
                        ?>
                        <img src="<?php echo URL.'webroot/files/user/image/'.$userDetails->User->image_dir.'/thumb2_'.$userDetails->User->image; ?>"  class="img-responsive headerImg">
                        <?php }
                        elseif (isset($userDetails->User->fbid) && !empty($userDetails->User->fbid)) {?>
                            <img src="//graph.facebook.com/<?php echo $userDetails->User->fbid;?>/picture?type=large">
                        <?php }
                        else{
                            if ($userDetails->User->gender == '0') {
                               
                            ?>
                            <img src="<?php echo URL.'webroot/files/user_image/defaultuser.png' ?>" alt="Image Not Found" class="img-responsive headerImg">
                            <?php 
                        }
                        else
                        {
                        ?><img src="<?php echo URL.'webroot/files/user_image/femaleadmin.png' ?>" alt="Image Not Found" class="img-responsive headerImg">
                        <?php
                        }
                        }
                        ?>
                        <span class="username username-hide-on-mobile">
                        <?php echo $userDetails->User->username; ?></span>
                        <i class="fa fa-angle-down"></i>
                        <?php
                        } ?>

                        
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <?php if($_SESSION['user_type'] == 'organization'){ ?>
                                <a href="<?php echo URL_VIEW; ?>organizations/organizationProfile"><i class="icon-user"></i>Profile</a>
                                <?php } else { ?>
                                <a href="<?php echo URL_VIEW; ?>users/employee/profile"><i class="icon-user"></i>Profile</a>
                                <?php
                                } ?>
                                
                            </li>
                            <li>
                                <a href="page_calendar.html">
                                <i class="icon-calendar"></i> My Calendar </a>
                            </li>
                            <li>
                                <a href="<?php echo URL_VIEW; ?>users/employee/inboxMessages">
                                <?php if( $receivedMessage == '0'){ ?>
                                    <i class="icon-envelope-open"></i> My Inbox
                                <?php } else {?>
                                <i class="icon-envelope-open"></i> My Inbox
                                 <span class="badge badge-danger">
                                        <?php echo $receivedMessage; ?> 
                                 </span>
                                 <?php } ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo URL_VIEW; ?>tasks/listTask">
                                <?php if($taskCounts == '0'){ ?>
                                    <i class="icon-rocket"></i> My Tasks
                                <?php } else { ?>
                                     <i class="icon-rocket"></i> My Tasks <span class="badge badge-success">
                                    <?php echo $taskCounts; ?> </span>
                                <?php } ?>
                                </a>
                            </li>
                            <?php 
                                if ($_SESSION['user_type'] == 'admin') {
                            ?>
                            <li>
                                <a href="<?php echo URL_VIEW . 'organizations/orgEdit?admin_id='.$userId ?>">
                                <i class="icon-calendar"></i>Edit Profile</a>
                            </li>
                            <?php
                            }
                            else if ($_SESSION['user_type'] == 'organization') {
                                       
                            ?>
                            <li>
                                <a href="<?php echo URL_VIEW . 'organizations/orgEdit?org_id='.$orgId ?>">
                                <i class="icon-calendar"></i>Edit Profile</a>
                            </li>
                            <?php
                                }
                                else{
                            ?>
                             <li>
                                <a href="<?php echo URL_VIEW . 'users/userEdit?user_id='.$userId ?>">
                                <i class="icon-calendar"></i>Edit Profile</a>
                            </li>
                            <?php
                                }
                            ?>
                           <!--  <li>
                                <a href="<?php echo URL_VIEW . 'organizations/changePassword?org_id='.$orgId;?>">
                                <i class="icon-envelope-open"></i>Change Password</a>
                            </li> -->
                            <li class="divider">
                            </li>
                            <li>
                                <a href="extra_lock.html">
                                <i class="icon-lock"></i> Lock Screen </a>
                            </li>
                            <li>
                                <a href="<?php echo URL_VIEW . 'logout.php';?>">
                                <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-extended dropdown-dark dropdown-notification" id="header_notification_bar">
                        <a href="javascript:;" id="notificationPopupBtn" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="background-color:transparent;">
                        <i class="icon-bell"></i>
                        <span class="badge badge-default" id="notificationPopup" style="right:12px;"></span>
                        </a>
                    </li>  
                    <!-- <li>
                        <div class="page-toolbar">
            				<div class="btn-group btn-theme-panel">
            					<a href="javascript:;" class="btn dropdown-toggle" data-toggle="dropdown" id="notificationPopupBtn" style="background-color: transparent;">
                					<i class="icon-logout" id="navi"></i>
                                    <span class="badge badge-danger" id="infoi"><div id="notificationPopup">0</div></span>                        
            					</a>
                            </div>
                        </div>                                                                                                                                                                                                                            
                    </li>   -->              
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
        <!--test of header menu goes here by7 rabi -->
           
        <!--  <div class="page-quick-sidebar-wrapper">
            <div class="page-quick-sidebar">
                <div class="nav-justified">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active">
                            <a href="#quick_sidebar_tab_1" data-toggle="tab">
                            Notifications <span class="badge badge-danger"></span>
                            </a>
                        </li>
                        <li>
                            <a href="#quick_sidebar_tab_2" data-toggle="tab" id="alertBtn">
                            General <span class="badge badge-success"></span>
                            </a>
                        </li>
                        <!- <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            More<i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li>
                                    <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                    <i class="icon-bell"></i> Alerts </a>
                                </li>
                                <li>
                                    <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                    <i class="icon-info"></i> Notifications </a>
                                </li>
                                <li>
                                    <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                    <i class="icon-speech"></i> Activities </a>
                                </li>
                                <li class="divider">
                                </li>
                                <li>
                                    <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                    <i class="icon-settings"></i> Settings </a>
                                </li>
                            </ul>
                        </li> ->
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                            <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                                <!- <h3 class="list-heading">Staff</h3> ->
                                <ul class="media-list list-items notificationListsUl">
                                    <?php if($userRole != '2'):?>
                                        <li class="media" id="shiftAssignNotification">
                                            <div class="media-status">
                                                <span class="badge badge-success" id="shiftAssingNotificationCount">0</span>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">Shift Requests</h4>
                                                <div class="media-heading-sub">
                                                     By Manager
                                                </div>
                                            </div>
                                        </li>
                                    <?php endif;?>

                                    <?php if(isset($boardManager) && !empty($boardManager) || $userRole=='2'):?>
                                        <!- <li class="media">
                                            <div class="media-status">
                                                <span class="badge badge-success">0</span>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">Checked In Users</h4>
                                                <div class="media-heading-sub">
                                                </div>
                                            </div>
                                        </li> ->
                                    <?php endif;?>
                                </ul>
                            </div>
                            <div class="page-quick-sidebar-item">
                                <div class="page-quick-sidebar-chat-user">
                                    <div class="page-quick-sidebar-nav">
                                        <a href="javascript:;" class="page-quick-sidebar-back-to-list"><i class="icon-arrow-left"></i>Back</a>
                                    </div>
                                    <div class="page-quick-sidebar-chat-user-messages">
                                        <div class="post in notificationListDiv">
                                            <div class="message" style="margin:0px;">
                                                <a href="javascript:;" class="name">Oneplatinum</a>
                                                <div class="clear"></div>
                                                <span class="datetime">Morning 20:15</span>
                                                <span class="body">accept</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
                            <div class="page-quick-sidebar-alerts-list">
                                <!- <h3 class="list-heading">General</h3> ->
                                <ul class="feeds list-items" id="generalUlNotifications">
                                    <!- <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-danger">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         You have 5 pending membership that requires a quick review.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 24 mins
                                            </div>
                                        </div>
                                    </li> ->
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
                            <div class="page-quick-sidebar-settings-list">
                                <h3 class="list-heading">General Settings</h3>
                                <ul class="list-items borderless">
                                    <li>
                                         Enable Notifications <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                    <li>
                                         Allow Tracking <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                    <li>
                                         Log Errors <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                    <li>
                                         Auto Sumbit Issues <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                    <li>
                                         Enable SMS Alerts <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                </ul>
                                <h3 class="list-heading">System Settings</h3>
                                <ul class="list-items borderless">
                                    <li>
                                         Security Level
                                        <select class="form-control input-inline input-sm input-small">
                                            <option value="1">Normal</option>
                                            <option value="2" selected>Medium</option>
                                            <option value="e">High</option>
                                        </select>
                                    </li>
                                    <li>
                                         Failed Email Attempts <input class="form-control input-inline input-sm input-small" value="5"/>
                                    </li>
                                    <li>
                                         Secondary SMTP Port <input class="form-control input-inline input-sm input-small" value="3560"/>
                                    </li>
                                    <li>
                                         Notify On System Error <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                    <li>
                                         Notify On SMTP Error <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF">
                                    </li>
                                </ul>
                                <div class="inner-content">
                                    <button class="btn btn-success"><i class="icon-settings"></i> Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div> -->

        <!--test of header menu ends here by7 rabi -->
    </div>
    <div id="sideNotifyDiv" class="sideNotifyDivC" data-toggle="close" style="display:none;">
        <div class="col-md-12">

                <h3>Notifications</h3><hr />
                <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                    <ul class="media-list list-items notificationListsUl">
                        <?php if($userRole != '2'):?>
                            <div class="notificationListDiv"></div>
                        <?php endif;?>
                    </ul>
                    <ul class="feeds list-items" id="shiftResponseNotifDiv">
                        
                    </ul>
                    <ul class="feeds list-items" id="reviewNotification">
                        
                    </ul>
                </div>                                     
        </div>
    </div>
    <!-- END HEADER -->

    <!-- BEGIN CONTAINER -->

    <!-- BEGIN SIDEBAR -->
    <!-- include('menu.php') -->
        <?php 
            if($_SESSION['user_type'] == 'admin'){
                include('menu_admin.php');
            }elseif($_SESSION['user_type'] == 'organization'){
                 include('menu_organization.php');
            }else{
                include('menu.php');
            }
        ?>
</div>
        
        <!-- BEGIN CONTENT -->


<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo URL_VIEW;?>global/plugins/respond.min.js"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/excanvas.min.js"></script> 
<![endif]-->
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



<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_VIEW;?>global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout3/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout3/scripts/demo.js" type="text/javascript"></script>




<!-- Page -->
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/index.js" type="text/javascript"></script>       
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/tasks.js" type="text/javascript"></script>
<!-- End Page-->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo URL_VIEW;?>global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>


<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!-- toastr notification js-->
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/ui-toastr.js"></script>
<!-- End of toastr notification js -->

<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->


<script src="<?php echo URL_VIEW;?>global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/ui-confirmations.js"></script>

<script src="<?php echo URL_VIEW;?>js/notification-sounds/js/ion.sound.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.js"></script>  
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/placeholders.js"></script>

<script src="<?php echo URL_VIEW;?>js/node_modules/socket.io/node_modules/socket.io-client/socket.io.js"></script>



<!-- END PAGE LEVEL PLUGINS -->
<script>
jQuery(document).ready(function() {    
                Metronic.init(); // init metronic core componets
                Layout.init(); // init layout
                QuickSidebar.init(); // init quick sidebar
                Demo.init(); // init demo features
                Index.init();   
                Index.initDashboardDaterange();
                //Index.initJQVMAP(); // init index page's custom scripts
                UIConfirmations.init(); // init page demo
                // Index.initCalendar(); // init index page's custom scripts
                Index.initCharts(); // init index page's custom scripts
                Index.initChat();
                Index.initMiniCharts();
                Tasks.initDashboardWidget();
                UIToastr.init(); //init Toastr Notification.

                ion.sound({
                    sounds: [
                        {name: "quick_notification"}
                    ],

                    // main config
                    path: "<?php echo URL_VIEW;?>js/notification-sounds/sounds/",
                    preload: true,
                    multiplay: true,
                    volume: 0.9
                });

});
</script>

<script type="text/javascript">
    $(document).ready(function(){

        function ImageExist(url)
      {
        var img = new Image();
        img.src = url;
        return img.height != 0;
      }

      function findTime(seconds){
        var time;
        if(seconds > 60){
            var minute = seconds/60;
            time = Math.round(minute)+' minutes ago';
            if(minute > 60){
                var hour = minute/60;
                time = Math.round(hour)+' hours ago';
                if(hour > 24){
                    var day = hour/24;
                    time = Math.round(day)+' days ago';
                    if(day > 30){
                        var month = day/30;
                        time = Math.round(month)+' months ago';
                    }
                }
            }
        } else {
            time = 'just now';
        }
        return time;
      }
        
        var url = '<?php echo URL_VIEW; ?>messages/employeeInbox';
        var userId = '<?php echo $user_id;?>';

        $("#clickMessage").on('click',function(){
            var url = '<?php echo URL; ?>Receivers/myNewMessages/'+userId+'.json';
            $.ajax({
                url:url,
                type:'post',
                datatype:'jsonp',
                success:function(response){

                    var sender;
                    var html ="";
                    var count = response.count; 

                    if (count < 1){
                        count = 'no';
                    }

                    html += '<li class="external">';
                    
                    html += '<h3>You have <span class="bold">'+ count +'</span> new messages</h3>';
                    html += '<a href="<?php echo URL_VIEW;?>messages/employeeInbox" class="viewAllMsg">view all</a>';
                    html += '</li>';
                    html += '<li>';
                    if(response.receivedMessage != 0){ 
                        $.each(response.receivedMessage,function(key,val){
                            var send_time= new Date(val.Sender.date_time);
                            var current_time = new Date();
                            
                            var seconds =  (current_time- send_time)/1000;
                            var time = findTime(seconds);


                            if(val.Sender.user_id == 0){
                                
                                sender_name = val.Sender.Organization.title;
                                var orgImgPath = '<?php echo URL ?>webroot/files/organization/logo/'+val.Sender.Organization.logo_dir+'/'+val.Sender.Organization.logo;
                            
                                var imgurl = orgImgPath;
                                
                            } else{
                                
                                sender_name = val.Sender.User.fname+' '+val.Sender.User.lname;
                                if(ImageExist(val.Sender.User.imagepath) && val.Sender.User.imagepath != ""){
                                  var imgurl = val.Sender.User.imagepath;
                                }else{
                                  if(val.Sender.User.gender== 0){
                                    var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/defaultuser.png";
                                  }else{
                                    var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/femaleadmin.png";
                                  }
                                }
                            }

                                html += '<div class="slimScrollDiv" style=""><ul class="dropdown-menu-list scroller" style="" data-handle-color="#637283" data-initialized="1">';
                                html += '<li><a href="<?php echo URL_VIEW; ?>messages/viewEmployeeInbox?msgId='+val.Receiver.id+'">';
                                html +=  '<span class="photo"><img src="'+imgurl+'" class="img-circle" alt=""></span>';
                                html += '<span class="subject"><span class="from">'+sender_name+' </span>';
                                html +=  '<span class="time">'+time+'</span>';
                                html +=  '</span>';
                                html +=  '<span class="message">'+val.Sender.content.substr(0,60)+'...'+'</span>';
                                html +=  '</a></li>';
                                html += '</div>';
                                html += '</li>';   
                        });
                    }
                    $("#newMessageList").html(html);
                    
                }
            });
        });

        $(".viewAllMsg").live('click',function(){

            $.ajax({
                url:'<?php echo URL; ?>Receivers/viewHeaderMsg/'+userId
                +'.json',
                type:'post',
                datatype:'jsonp',
                success:function(response){
                    //console.log(response);
                    $(location).attr('href',url);
                }

            });

            
        });
    
    });
</script>

<script type="text/javascript">

      function ImageExist(url)
      {
        var img = new Image();
        img.src = url;
        return img.height != 0;
      }


    $(function()
        {
            var orgId = '<?php echo $orgId; ?>';

            if(orgId == "")
            {
                orgId = 0;
            }

            var userId = '<?php echo $user_id; ?>';
            var socket = io.connect( 'http://'+window.location.hostname+':3000', {query: 'userId='+userId+'&orgId='+orgId});

                var notificationPopup = document.getElementById('notificationPopup');
                
                var notificationPopupValue;
                // setInterval(function()
                //     {                        
                //         notificationPopupValue = parseInt(notificationPopup.innerHTML);
                //     });
                var userId = "<?php echo $user_id;?>";
                var orgId = "<?php echo $orgId;?>";
                var asABoardManager = "<?php echo $asABoardManager;?>";

                
                function callToShiftassignNotification()
                {   
                    var shiftNotificationNumber = 0;

                    // setInterval(function(){
                    //     var url = '<?php echo URL; ?>OrganizationUsers/reviewNotification/'+orgId+'.json';
                    //     $.ajax({
                    //         url:url,
                    //         type:'post',
                    //         datatype:'jsonp',
                    //         success:function(response){
                    //             var html = '';
                    //             var count = response.count;
                    //             //console.log(response);

                    //             if(response.length != 0){
                    //                 $.each(response,function(key,val){
                    //                     var reviewnotification = val.reviewnotification;
                    //                     //console.log(reviewnotification);
                    //                     if(reviewnotification == 0){
                    //                         $(notificationPopup).html(notificationPopupValue+1);
                    //                         ion.sound.play("quick_notification");
                    //                     }
                    //                 });
                                    
                                    
                    //             }
                    //         }
                    //     });
                    // },1000);

                    function reviewNotification(event){

                        var url = '<?php echo URL; ?>OrganizationUsers/listReviewNotification/'+orgId+'.json';
                        $.ajax({
                            url:url,
                            type:'post',
                            datatype:'jsonp',
                            success:function(response){
                                console.log(response);
                                var html = '';
                                if(response.length != 0){
                                    html += '<h5><strong>Review Notification</strong></h5>'; 
                                    $.each(response,function(key,val){
                                        if(ImageExist(val.User.imagepath) && val.User.imagepath != ""){
                                          var imgurl = val.User.imagepath;
                                        }else{
                                          if(val.User.gender== 0){
                                            var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/defaultuser.png";
                                          }else{
                                            var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/femaleadmin.png";
                                          }
                                        }
                                    console.log(imgurl);
                                        //var reviewnotification = val.reviewnotification; 
                                        var username = val.User.fname + ' ' + val.User.lname;
                                        
                                        var userUrl = '<a href="<?php echo URL_VIEW; ?>organizationUsers/organizationEmployeeDetail?org_id='+orgId+'&user_id='+val.User.id+'">';    
                                            html += '<li>';
                                            html += '<span class="details">'
                                            html +=  '<span class="photo" style="float:left;"><img height="35px" width="35px" style="" src="'+imgurl+'" class="img-circle" alt=""></span>';
                                            html += userUrl+username+'</a> will have review period by tomarrow.</span>';
                                            html += '</li>';
                                            html += '<hr/>';

                                            

                                            $("#reviewNotification").html(html);
                                    
                                    });
                                    
                                }
                            }
                        });
                    }

                    var reviewNotificationArr = new Array();
                    socket.on('updateReviewNotification', function(data)
                        {
                            if($.inArray(data.id, reviewNotificationArr) == -1)
                            {
                                reviewNotificationArr.push(data.id);

                                var count = parseInt($(notificationPopup).html());
                                if(isNaN(count))
                                {
                                    count = 0;
                                }
                                $(notificationPopup).html(count + 1);
                                ion.sound.play("quick_notification");
                            }
                        });

                    var shiftRequestNotificationArr = new Array();
                    socket.on('shiftRequestNotification', function (data)
                        {
                            // console.log(data);
                            if($.inArray(data.id, shiftRequestNotificationArr) == -1)
                            {
                                shiftRequestNotificationArr.push(data.id);

                                var count = parseInt($(notificationPopup).html());
                                if(isNaN(count))
                                {
                                    count = 0;
                                }
                                $(notificationPopup).html(count + 1);
                                ion.sound.play("quick_notification");
                            }
                        });

                    var msgNotifArr = new Array();
                    socket.on('updateMsgNotification', function(data)
                        {
                            if($.inArray(data.id, msgNotifArr) == -1)
                            {
                                msgNotifArr.push(data.id);


                                var count = parseInt($("#msgNotifBadge").html());
                                
                                if(isNaN(count))
                                {
                                    count = 0;
                                }
                                $("#msgNotifBadge").html(count + 1);
                                ion.sound.play("quick_notification");
                            }
                            // console.log(data);
                        });

                    var lisExpNotifArr = new Array();
                    socket.on('updateLiscExpNotification', function(data)
                        {
                            if($.inArray(data.id, lisExpNotifArr) == -1)
                            {
                                lisExpNotifArr.push(data.id);

                                var count = parseInt($(notificationPopup).html());
                                if(isNaN(count))
                                {
                                    count = 0;
                                }
                                $(notificationPopup).html(count + 1);
                                ion.sound.play("quick_notification");
                            }
                            // console.log(data);
                        });
                    // setInterval(function()
                    // {
                    //     var url1 = '<?php echo URL;?>shiftUsers/shiftAssignNotificationUser/'+userId+'.json';
                    //     $.ajax({
                    //             url: url1,
                    //             type:'post',
                    //             datatype:'jsonp',
                    //             success: function(response)
                    //             {   
                    //                 var shiftAssingNotificationCount = $("#shiftAssingNotificationCount");

                    //                 if(response.status==1)
                    //                 {
                    //                     if(response.output.count != shiftAssingNotificationCount.html())
                    //                     {
                    //                         shiftAssingNotificationCount.html(response.output.count);
                    //                     }

                    //                     if(response.output.unreadNotification > 0)
                    //                     {
                    //                         var i;
                    //                         var n = response.output.unreadNotification;
                    //                         for(i=0;i<n;i++)
                    //                         {
                    //                             // alert('h');
                    //                             $(notificationPopup).html(notificationPopupValue+1);
                    //                             ion.sound.play("quick_notification");
                    //                         }
                                            
                    //                     }
                                        
                    //                 }
                    //                 else
                    //                 {
                    //                     $("#shiftAssingNotificationCount").html('0');
                    //                 }
                    //             }
                    //           });
                    // }, 1000);

                    // $("#shiftAssignNotification").on('click', shiftassignNotification);

                    function tConvert (time) 
                    {
                        time = time.slice(0, -3);
                              // Check correct time format and split into components
                      time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

                      if (time.length > 1) { // If time format correct
                        time = time.slice (1);  // Remove full string match value
                        time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
                        time[0] = +time[0] % 12 || 12; // Adjust hours
                      }
                      return time.join (''); // return adjusted time or original string
                    }

                    function shiftassignNotification(event)
                    {
                        var url = '<?php echo URL;?>shiftUsers/shiftAssignNotificationUser/'+userId+'.json';
                        var data="";
                        var notificationListDiv = $(".notificationListDiv");
                        notificationListDiv.html("");
                        $.ajax({
                                    url: url,
                                    type:'post',
                                    datatype:'jsonp',
                                    success: function(response)
                                    {
                                        if(response.status==1)
                                        {

                                            $.each(response.output.shiftList, function(i, v)
                                                {
                                                    data+='<div class="post in notificationListDiv well">'+
                                                    '<div class="message" style="margin:0px;">'+
                                                        '<a href="javascript:;" class="name">'+v.Organization.title+'</a>'+
                                                        '<div class="clear"></div>'+
                                                        '<span class="datetime">'+v.Shift.title+' ( '+tConvert(v.Shift.starttime)+' - '+tConvert(v.Shift.endtime)+' ) </span>'+
                                                        '<div class="clear">'+
                                                            '<button class="btn btn-xs blue acceptShiftRequestBtn" data-shiftreqId="'+v.ShiftUser.id+'">Accept</button>'+
                                                            '<button class="btn btn-xs red rejectShiftRequestBtn" style="margin-left:5px;" data-shiftreqId="'+v.ShiftUser.id+'">Reject</button>'+
                                                        '</div>'+
                                                    '</div>'+'</div>';
                                                });

                                            notificationListDiv.html(data);
                                            $(".acceptShiftRequestBtn").bind('click', acceptShiftRequestClick);
                                            $(".rejectShiftRequestBtn").bind('click', rejectShiftRequestClick);
                                            
                                        }
                                        else
                                        {
                                            // notificationListDiv.html('No shift requests.');
                                        }
                                    }
                                  });
                    }

                    function viewLiscExpNotif(event)
                    {
                        var userId = '<?php echo $user_id; ?>';
                        var url = '<?php echo URL; ?>Liscenses/getUserExpLiscenseList/'+userId+'.json';

                        $.ajax(
                            {
                                url:url,
                                type:'post',
                                dataType:'jsonp',
                                async:false,
                                success:function(res)
                                {
                                    // console.log(res);
                                    var data ="";

                                    $.each(res.output, function(i,v)
                                        {

                                            data+='<li>'+
                                            '<div class="col1">'+
                                            '<div class="cont">'+
                                            '<div class="cont-col1">'+
                                            '<div class="label label-sm label-danger">'+
                                            '<i class="fa fa-user"></i>'+
                                            '</div>'+
                                            '</div>'+
                                            '<div class="cont-col2">'+
                                            '<div class="desc">'+
                                            'Your liscense of '+v.Liscense.type+' is expiring tomorrow.'+
                                            '</div>'+
                                            '</div>'+
                                            '</div>'+
                                            '</div>'+
                                            '<div class="col2">'+
                                            '<div class="date">'+
                                            '</div>'+
                                            '</div>'+
                                            '</li>';
                                        });
                                    console.log(data);

                                    $("#shiftResponseNotifDiv").prepend(data);
                                },
                                error:function()
                                {

                                }
                            });
                    }

                    $("#notificationPopupBtn").live('click', function(event)
                    {
                        $(notificationPopup).html("");
                        var sideNotifyDiv = $("#sideNotifyDiv");

                        if(sideNotifyDiv.attr('data-toggle') == "close")
                        {
                            sideNotifyDiv.attr("data-toggle", "open");
                            sideNotifyDiv.show();
                        }else
                        {
                            sideNotifyDiv.attr("data-toggle", "close");
                            sideNotifyDiv.hide();
                        }
                        shiftassignNotification(event);
                        reviewNotification(event);
                        viewLiscExpNotif(event);
                    });

                    function rejectShiftRequestClick(event)
                    {
                        var e = $(this);
                        var shiftId=$(this).attr('data-shiftreqId');
                        var type = 0;

                        $.ajax({
                                url: "<?php echo URL_VIEW."process.php";?>",
                                data: "action=responseShiftReq&type="+type+"&shiftId="+shiftId,
                                type: "post",
                                success:function(data){
                                    if(data==1){
                                        toastr.success('Responded to Shift Request successfully','status');
                                        e.closest('.notificationListDiv').fadeOut(300);
                                        return 1;
                                    }else{
                                        toastr.warning('Could not respond to Shift Request, Try after manual reloading of the page','status');
                                        return 0;
                                    }
                                    
                                }
                            });
                    }

                    function acceptShiftRequestClick(event)
                    {
                        var e = $(this);
                        var shiftId=$(this).attr('data-shiftreqId');
                        var type = 3;

                        $.ajax({
                            url: "<?php echo URL_VIEW."process.php";?>",
                            data: "action=responseShiftReq&type="+type+"&shiftId="+shiftId,
                            type: "post",
                            success:function(data){
                                if(data==1){
                                    toastr.success('Responded to Shift Request successfully','status');
                                    e.closest('.notificationListDiv').fadeOut(300);
                                    return 1;
                                }else{
                                    toastr.warning('Could not respond to Shift Request, Try after manual reloading of the page','status');
                                    return 0;
                                }
                                
                            }
                        });
                    } 
                }
                callToShiftassignNotification();


                if(asABoardManager == '1' || orgId !=0)
                {
                    var userId = '<?php echo $user_id; ?>';

                    function shiftRequestResponseNotif()
                    {
                        if(orgId =="")
                        {
                            orgId = 0;
                            var boardManagerList = '<?php echo $listofBoardManagerArr;?>';
                        }
                        else
                        {
                            var boardManagerList =0;
                        }
                            

                        socket.emit( 'shiftRequestResponseNotif' , {'userId':userId,'orgId':orgId, 'boardManagerList':boardManagerList} );


                        var managerShiftRespNotiArr = new Array();
                        socket.on('managerShiftRespNoti', function(data)
                            {
                                if($.inArray(data.id, managerShiftRespNotiArr) == -1)
                                {
                                    managerShiftRespNotiArr.push(data.id);

                                    var count = parseInt($(notificationPopup).html());
                                    if(isNaN(count))
                                    {
                                        count = 0;
                                    }
                                    $(notificationPopup).html(count + 1);
                                    ion.sound.play("quick_notification");
                                    // console.log(data);

                                    var url = '<?php echo URL;?>ShiftUsers/getShiftUser/'+data.id+'.json';
                                    $.ajax(
                                        {
                                            url:url, 
                                            datatype:'jsonp',
                                            type:'post', 
                                            success:function(response)
                                            {
                                                console.log(response);
                                                if(response.output ===1)
                                                {

                                                    var notif = response.notifications;
                                                    var data = "";

                                                    var res;
                                                    if(notif.ShiftUser.status === '3')
                                                    {
                                                        res = "accepted";
                                                    }
                                                    else
                                                    {
                                                        res = "denied";
                                                    }

                                                    data ='<li>'+
                                                                '<div class="col1">'+
                                                                    '<div class="cont">'+
                                                                        '<div class="cont-col1">'+
                                                                            '<div class="label label-sm label-danger">'+
                                                                                '<i class="fa fa-user"></i>'+
                                                                            '</div>'+
                                                                        '</div>'+
                                                                        '<div class="cont-col2">'+
                                                                            '<div class="desc">'+
                                                                            notif.User.fname+' '+notif.User.lname+' '+res+' your shift request.'+
                                                                            '</div>'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                                '<div class="col2">'+
                                                                    '<div class="date">'+
                                                                    '</div>'+
                                                                '</div>'+
                                                            '</li>';
                                                            console.log(data);

                                                            $("#shiftResponseNotifDiv").prepend(data);
                                                }
                                            }
                                        });
                                }
                            });
                    }
                    shiftRequestResponseNotif();
                }

                if(asABoardManager =='1')
                {

                    function meetingRequestNotification()
                        {
                            setInterval(function(event)
                                {
                                    var userId = '<?php echo $user_id;?>';
                                    var url = '<?php echo URL;?>Messages/meetingRequestNotifications/'+userId+'.json';
                                    var data="";
                                    $.ajax({
                                            url: url,
                                            type:'post',
                                            datatype:'jsonp',
                                            success: function(response)
                                            {
                                                if(response.output.status ==1)
                                                {
                                                    $.each(response.output.meetingRequests, function(i, v)
                                                        {
                                                            data+='<li>'+
                                                                            '<div class="col1">'+
                                                                                '<div class="cont">'+
                                                                                    '<div class="cont-col1">'+
                                                                                        '<div class="label label-sm label-danger">'+
                                                                                            '<i class="fa fa-user"></i>'+
                                                                                        '</div>'+
                                                                                    '</div>'+
                                                                                    '<div class="cont-col2">'+
                                                                                        '<div class="desc">Meeting Request</div>'+
                                                                                        '<div class="clear"></div>'+
                                                                                        '<div class="desc">From: '+v.UserFrom.fname+' '+v.UserFrom.lname+'</div>'+
                                                                                        '<div class="clear"></div>'+
                                                                                        '<div class="desc">Title: '+v.Message.title+'</div>'+
                                                                                    '</div>'+
                                                                                '</div>'+
                                                                            '</div>'+
                                                                            '<div class="col2">'+
                                                                                '<div class="date">'+
                                                                                '</div>'+
                                                                            '</div>'+
                                                                        '</li>';

                                                            $(notificationPopup).html(notificationPopupValue+1);
                                                            ion.sound.play("quick_notification");
                                                        });

                                                    $("#generalUlNotifications").prepend(data);
                                                    // $(".acceptShiftRequestBtn").bind('click', acceptShiftRequestClick);
                                                    // $(".rejectShiftRequestBtn").bind('click', rejectShiftRequestClick);
                                                    
                                                }
                                            }
                                        });
                                },1000);
                            
                            
                        }
                    meetingRequestNotification();
                }
            });
</script>
<!-- END JAVASCRIPTS -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../../../../../www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-37564768-1', 'keenthemes.com');
  ga('send', 'pageview');
</script>
