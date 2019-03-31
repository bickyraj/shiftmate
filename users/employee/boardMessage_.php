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

<!-- <div class="RightPart" style="float: left;">
        <form name="blockFunctionSelect" action="" method="post">
        	<table width="600" border="1" cellspacing="5" cellpadding="5">
            	<?php foreach($boardMessagesList as $org_key_1=>$branch_val_1){?>
                <tr>
                	<td colspan="5">Organization Name: <?php echo $org_key_1;?></td>
                 </tr>
                 <?php foreach($branch_val_1 as $branch_key_1=>$board_val_1){ ?>
                 <tr>
                	<td colspan="5">Branch Name: <?php echo $branch_key_1;?></td>
                 </tr>
                 <?php foreach($board_val_1 as $board_key_1=>$board_message_1){?>
                 
                 <tr>
                	<td colspan="5">Board Name: <?php echo $board_key_1;?></td>
                 </tr>
                 <?php 
        		 if(isset($board_message_1) && !empty($board_message_1)){
        			 $dataOrder = '';
        		 foreach($board_message_1 as $board_messages_1){
        			$dataOrder[] = $board_messages_1;
        		 }
        		 $count_dataOrder = count($dataOrder);
        		 for($a = $count_dataOrder; $a>0; $a--){
        		 ?>
                <tr>
                	<td></td>
                    <td><?php echo $dataOrder[$a-1]->User->fname." ".$dataOrder[$a-1]->User->lname;?></td>
                    <td><?php echo $dataOrder[$a-1]->content;?></td>
                    <td><?php echo $dataOrder[$a-1]->date_time;?></td>
                    <td> <a style="color:#000;" href="<?php echo URL_VIEW."users/employee/messageDetailBoard?type=receive&message_id=".$dataOrder[$a-1]->id;?>">View Detail</a></td>
                </tr>
                <?php 
        		 }
        		 ?>
                 <tr><td colspan="5">&nbsp;</td></tr>
        		 <?php
        		 }else{
        		?>
                 <tr><td colspan="5">No Message received</td></tr>
                 
                <?php }}}?>
                <tr><td colspan="5">&nbsp;</td></tr>
                <?php } ?>
               
                
             </table>
     </form>
</div> -->

<div class="RightPart">
    <div class="orgMsgContainer">
        <div class="orgMessageListDiv">Board Message List</div>

        <form name="blockFunctionSelect" action="" method="post">
            <div class="msgContainer">
                <?php foreach($boardMessagesList as $org_key_1=>$branch_val_1):?>
                <div class="organizationMessageDiv">
                    <div class="orgList">
                        <div class="orgMsgTitle"><?php echo $org_key_1;?></div><div class="orgMsgViewList orgBtn">Branches</div>             
                    </div>
                    <div class="branchList">
                            <?php foreach($branch_val_1 as $branch_key_1=>$board_val_1):?>
                            <div class="branchContainer">
                                <div class="branchListDiv">
                                    <div class="branchKey"><?php echo $branch_key_1;?></div><div class="orgMsgViewList branchBtn">Boards</div>
                                </div>
                                <div class="boardList">
                                    <?php foreach($board_val_1 as $board_key_1=>$board_message_1):?>
                                    <?php if(isset($board_message_1)){$countMessage = count($board_message_1);} else{$countMessage = "No Message";}?>
                                    <div class="boardContainer">
                                    <div class="boardListDiv">
                                        <div class="boardKey"><?php echo $board_key_1;?></div><div class="orgMsgViewList">List Messages</div><div class="orgMsgTotal"><span>Total</span> - <?php echo $countMessage;?></div>
                                    </div>
                                        <div class="msgListDiv">
                                            <table class="msgListTable">
                                                    <?php 
                                                         if(isset($board_message_1) && !empty($board_message_1)){
                                                             $dataOrder = '';
                                                         foreach($board_message_1 as $board_messages_1){
                                                            $dataOrder[] = $board_messages_1;
                                                         }
                                                         $count_dataOrder = count($dataOrder);
                                                         for($a = $count_dataOrder; $a>0; $a--){
                                                     ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?php echo $dataOrder[$a-1]->User->fname." ".$dataOrder[$a-1]->User->lname;?></td>
                                                        <td><?php echo $dataOrder[$a-1]->content;?></td>
                                                        <td><?php echo $dataOrder[$a-1]->date_time;?></td>
                                                        <td> <a style="color:#000;" href="<?php echo URL_VIEW."users/employee/messageDetailBoard?type=receive&message_id=".$dataOrder[$a-1]->id;?>">View</a></td>
                                                    </tr>
                                                    <?php }?>
                                                     <?php }else{?>
                                                    <tr><td colspan="5">No Message received</td></tr>
                                                    <?php }?>
                                            </table>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
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