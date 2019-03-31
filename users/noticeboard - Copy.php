<?php

	$url = URL."Users/Notices/".$user_id.".json";
	$org = \Httpful\Request::get($url)->send();
	$org_details = $org->body->output['0']->OrganizationUser;
	// echo "<pre>";
	// print_r($org_details);

 //    die();

?>

<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
    Notice Board <small> view notice board</small>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="#">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Notice Board</a>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
            Actions <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li>
                    <a href="#">Another action</a>
                </li>
                <li>
                    <a href="#">Something else here</a>
                </li>
                <li class="divider">
                </li>
                <li>
                    <a href="#">Separated link</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- END PAGE HEADER-->
            
<!-- BEGIN PAGE CONTENT-->
<div class="note note-success">
    <p>
        The draggable portlets powered with jQueryUI Sortable Plugin. You can use the jQueryUI Sortable API to store the portlet positions in your backend.The draggable portlets powered with jQueryUI Sortable Plugin. You can use the jQueryUI Sortable API to store the portlet positions in your backend.
    </p>
</div>
<div class="row" id="sortable_portlets">

    <?php foreach ($org_details as $org_detail):?>
        <?php foreach($org_detail->Organization->Noticeboard as $notice):?>
    <div class="col-md-4 column sortable">

        

        <div class="portlet portlet-sortable light bg-inverse">
                                <div class="portlet-title ui-sortable-handle">
                                    <div class="caption">
                                        <i class="icon-puzzle font-red-flamingo"></i>
                                        <span class="caption-subject bold font-red-flamingo uppercase">
                                        Notice</span>
                                    </div>
                                    <div class="tools">
                                        <a href="" class="collapse" data-original-title="" title="">
                                        </a>
                                        <a data-toggle="modal" class="config edit_notice_btn" data-original-title="" title="Edit">
                                        </a>
                                        <a href="" class="reload" data-original-title="" title="">
                                        </a>
                                        <a href="" class="fullscreen" data-original-title="" title="">
                                        </a>
                                        <a href="" class="remove" data-original-title="" title="">
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <h4 class="notice_title"><?php echo $notice->title;?></h4>
                                    <h6><?php echo $notice->notice_date;?></h6>
                                    <p class="notice_description">
                                        <?php echo $notice->description;?>
                                    </p>
                                </div>
                            </div>
                            <!-- empty sortable porlet required for each columns! -->
        <div class="portlet portlet-sortable-empty">
        </div>

    </div>
        <?php endforeach;?>
    <?php endforeach;?>
</div>
<!-- END PAGE CONTENT-->


    <!-- BEGIN PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_VIEW;?>global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/demo.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- Page -->
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/portlet-draggable.js"></script>

<script>
jQuery(document).ready(function() {       
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   PortletDraggable.init();
});
</script>
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init(); // init quick sidebar
Demo.init(); // init demo features
   Index.init();   
   Index.initDashboardDaterange();
   Index.initJQVMAP(); // init index page's custom scripts
   Index.initCalendar(); // init index page's custom scripts
   Index.initCharts(); // init index page's custom scripts
   Index.initChat();
   Index.initMiniCharts();
   Tasks.initDashboardWidget();
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




<!-- Old notice board -->

<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery.ui.js"></script>
<script src="<?php echo URL_VIEW;?>js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo URL_VIEW;?>styles/colorbox.css" />

<script type="text/javascript">

    $(document).ready(function()
        {
            $(".orgBtn").on('click', function()
            {
                e = $(this);
                msgList = e.closest(".orgList").siblings(".branchList");
                   msgList.slideToggle();  
                   flag = 1;
                   
                
            });

            $(".branchBtn").on('click', function()
            {
                e = $(this);
                msgList = e.closest(".branchListDiv").siblings(".boardList");
                   msgList.slideToggle();  
                   flag = 1;
                   
                
            });

            $(".orgMsgViewList").on('click', function()
            {

                e = $(this);
                msgList = e.closest(".boardListDiv").siblings(".msgListDiv");
                   msgList.slideToggle();  
                   flag = 1;
                   
                
            });

            $('.branchList').on('mouseup', function(ev){
                boardList = $(".boardList");
            

                if(!boardList.is(ev.target) && boardList.has(ev.target).length === 0)
                {
                    boardList.slideUp();
                }
            });

            $('.boardList').on('mouseup', function(ev){
                msgListDiv = $(".msgListDiv");
            

                if(!msgListDiv.is(ev.target) && msgListDiv.has(ev.target).length === 0)
                {
                    msgListDiv.slideUp();
                }
            });


        });

    $(document).on('mouseup', function(ev)
        {
            branchList = $(".branchList");
            

            if(!branchList.is(ev.target) && branchList.has(ev.target).length === 0)
            {
                branchList.slideUp();
            }
        });
</script>

<?php 
$inboxMessage_link = URL_VIEW."users/employee/boardMessage";

$boardListMessage = getBoardListReceiveMessage($user_id);

foreach($boardListMessage as $org_key=>$branch_val){
	$organization_name = $org_key;
	
	foreach($branch_val as $branch_key=>$board_val){
		$branch_name = $branch_key;
		
		foreach($board_val as $boards){
			$boardList[$organization_name][$branch_name][$boards->id]=$boards->title;
			
			if(isset($boards->Boardmessage) && !empty($boards->Boardmessage)){
				foreach($boards->Boardmessage as $boardmessages){
					$boardMessagesList[$organization_name][$branch_name][$boards->title][] = $boardmessages;
				}
			}else{
				$boardMessagesList[$organization_name][$branch_name][$boards->title] = 	'';
			}
		}
	}
	
}

	if(isset($_POST['submit']) && $_POST['submit'] == 'Send'){
		$url = URL."Boardmessages/add.json";
		$response = \Httpful\Request::put($url)                  // Build a PUT request...
    		->sendsJson()                               // tell it we're sending (Content-Type) JSON...
    		//->authenticateWith('username', 'password')  // authenticate with basic auth...
    		->body($_POST['data'])             // attach a body/payload...
    ->send();	
		if($response->body->output == 1){
			?>
            <script>
			$(document).ready(function()
			{
				window.location.href = '<?php echo $inboxMessage_link;?>';
				});
			</script>
            
            <?php	
		}
	}
	
	
?>



<h1>Board Message</h1>

<!-- Success Div -->
<div id="save_success">Message Send Successfully !!</div>
<!-- End of Success Div -->

<div class="leftPart">
    <a class='composeMessage' href="#compose"><button class="composeBtn">Compose</button></a>

</div>


<div class="RightPart">
    <div class="orgMsgContainer">
        <div class="orgMessageListDiv">Organization Notice Board</div>

        <form name="blockFunctionSelect" action="" method="post">
            <div class="msgContainer">
                <?php foreach($org_details as $org_detail):?>
                <div class="organizationMessageDiv">
                    <div class="orgList">
                        <div class="orgMsgTitle"><?php echo $org_detail->Organization->title;?></div><div class="orgMsgViewList orgBtn">List Notices</div>             
                    </div>
                    <div class="branchList">
                            <?php foreach($org_detail->Organization->Noticeboard as $org_notice):?>
                            <div class="branchContainer">
                                <div class="branchListDiv">
                                    <div class="branchKey"><?php echo $org_notice->title;?></div><div class="orgMsgViewList branchBtn">Organization Notification</div>
                                </div>
                                <div class="boardList">
                                    
                                   
                                    <div class="boardContainer">
                                    <div class="boardListDiv">
                                        <div class="boardKey"><?php echo $org_notice->description;?></div>
                                    </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            <?php endforeach;?>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </form>
    </div>
</div>

<div style="display:none;">
	<div id="compose">
    <form method="post" action="">
    <input type="hidden" name="data[Boardmessage][user_id]" value="<?php echo $user_id;?>">
    <input type="hidden" name="data[Boardmessage][parent_id]" value="0">
		<table>
            <tr>
            	<td colspan="2">Message Compose</td>
            </tr>
            <tr>
            	<td>To:</td>
                <td>
                <select name="data[Boardmessage][board_id]" id="send_to">
                	<option value="0">Select User</option>
                <?php 
					foreach($boardList as $key_org_dd=>$val_branch_dd){
				?>
                	<optgroup label="<?php echo $key_org_dd;?>">
                <?php 
						foreach($val_branch_dd as $key_branch_dd=>$val_board_dd){
				?>
                	<optgroup label="-><?php echo $key_branch_dd;?>">
                 <?php
				 	foreach($val_board_dd as $val_board_dd_list_key=>$val_board_dd_list_val){
				 ?>   
                	<option value="<?php echo $val_board_dd_list_key;?>"><?php echo $val_board_dd_list_val;?></option>
                <?php }}
				?>
                </optgroup>
                </optgroup>
                <?php
				} ?>    
                </select>
                </td>
            </tr>
            <tr>
            	<td colspan="2">Message</td>
            </tr>
            <tr>
            	<td colspan="2"><textarea name="data[Boardmessage][content]" id="messageContent"></textarea></td>
            </tr>
            <tr>
            	<td colspan="2"><input type="submit" name="submit" id="submit" value="Send"></td>
            </tr>
    	</table>
        </form>
    </div>
</div>

<script>
	$(document).ready(function(e) {
        $(".composeMessage").colorbox({inline:true, width:"50%"});
    });
	
</script>