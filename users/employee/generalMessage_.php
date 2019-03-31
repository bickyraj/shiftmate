<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery.ui.js"></script>
<script src="<?php echo URL_VIEW;?>js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo URL_VIEW;?>styles/colorbox.css" />

<?php 
$sentMessage_link = URL_VIEW."users/employee/sentMessage";
	$inboxMessage_link = URL_VIEW."users/employee/generalMessage";
	
$userListSentMessage = getUserListReceiveMessage($user_id);
	//print_r($_POST);
	if(isset($_POST['submit']) && $_POST['submit'] == 'Send'){
		$url = URL."Messages/add.json";
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
            <?php /*?><script type="text/javascript">
				$(document).ready(function()
					{
						var top_an = $("#save_success").css('top');
						$("#save_success").css('top','0px');
			
						
							$("#save_success").show().animate({top:top_an});
							
							setTimeout(function()
								{
									$("#save_success").fadeOut();
								}, 3000);
						
					});
			</script><?php */?>
            <?php	
		}
	}
	
	if(isset($_POST['submit']) && $_POST['submit'] == 'Delete'){
		$url = URL."Messages/deleteMessages.json";
		$response = \Httpful\Request::put($url)                  // Build a PUT request...
    		->sendsJson()                               // tell it we're sending (Content-Type) JSON...
    		//->authenticateWith('username', 'password')  // authenticate with basic auth...
    		->body($_POST['data'])             // attach a body/payload...
    ->send();
	//echo "<pre>";
	//print_r($response->body->output);	
		if($response->body->output == 1){
			/*$_SESSION['output'] = 1;
			echo "<script>windows.location";
		}
		if($_SESSION['output'] == 1){*/
			?>
            <script type="text/javascript">
				$(document).ready(function()
					{
						var top_an = $("#delete_success").css('top');
						$("#delete_success").css('top','0px');
						<?php foreach($_POST['data']['id'] as $message_id){?>
						$('#message_id_<?php echo $message_id;?>').hide();
						<?php }?>
							$("#delete_success").show().animate({top:top_an});
							
							setTimeout(function()
								{
									$("#delete_success").fadeOut();
								}, 3000);
						
					});
			</script>
            <?php	
		}
	}
	
	
?>

<!-- Url of current page -->
<?php $url = $_SERVER['REQUEST_URI'];preg_match("/[^\/]+$/", $url, $matches);$page = $matches[0];?>
<!-- End of url of current page -->

<h1>General Message</h1>

<!-- Success Div -->
<div id="save_success">Message Send Successfully !!</div>
<!-- End of Success Div -->

<div class="leftPart">
    <a class='composeMessage' href="#compose"><button class="composeBtn">Compose</button></a>

    <ul class="generalMsgUl">
        <li><a class="<?php echo($page =='generalMessage')? 'active':'';?>" href="<?php echo $inboxMessage_link;?>">Inbox</a></li>
        <li><a class="<?php echo($page =='sentMessage')? 'active':'';?>" href="<?php echo $sentMessage_link;?>">Sent</a></li>
     </ul>

</div>

<div class="RightPart">
    <div class="orgMsgContainer">
        <div class="orgMessageListDiv"><div class="msgSelectAll"><input type="checkbox" name="data[Message][groupCheck]" value="1" id="groupCheck">Select All</div><div class="generalTotal">Total - <?php if(isset($userListSentMessage->sentMessage)){echo count($userListSentMessage->sentMessage);}else{ echo "0";}?></div></div>

        <form name="blockFunctionSelect" action="" method="post">
            <div class="msgContainer">
                
                <div class="organizationMessageDiv">

                    <table class="msgListTable generalMsgTable">
                    	<?php 
							if(isset($userListSentMessage->receiveMessage) && !empty($userListSentMessage->receiveMessage))
							{

								foreach($userListSentMessage->receiveMessage as $messages){?>

                                <tr id="message_id_<?php echo $messages->Message->id;?>">
                                	<td><input type="checkbox" name="data[Message][id][]" value="<?php echo $messages->Message->id;?>" class="chk_boxes1"></td>
                                    <td class="msgFname"><?php echo $messages->UserTo->fname." ".$messages->UserTo->lname;?></td>
                                    <td class="msgContent"><span><?php echo $messages->Message->content;?></span></td>
                                    <td><?php echo $messages->Message->date_time;?></td>
                                    <td><a href="<?php echo URL_VIEW."users/employee/messageDetail?type=sent&message_id=".$messages->Message->id;?>">view</a></td>
                                </tr>
                                <?php }?>
                                <?php } else{?>

                                		<tr><td colspan="5">No Message received</td></tr>

                            <?php }?>
                        </table>

                        <input type="submit" id="deleteMessages" class="addBtn" value="Delete" name="submit" />
                </div>
                
            </div>
        </form>
    </div>
</div>

<div style="display:none;">
	<div id="compose">
    <form method="post" action="">
    <input type="hidden" name="data[Message][from]" value="<?php echo $user_id;?>">
    <input type="hidden" name="data[Message][parent_id]" value="0">
		<table>
            <tr>
            	<td colspan="2">Message Compose</td>
            </tr>
            <tr>
            	<td>To:</td>
                <td>
                <select name="data[Message][to]" id="send_to">
                	<option value="0">Select User</option>
                <?php foreach($userListSentMessage->userList as $user){ 
				if($user->User->id != $user_id){
				?>
                	<option value="<?php echo $user->User->id;?>"><?php echo $user->User->fname." ".$user->User->lname;?></option>
                <?php }} ?>    
                </select>
                </td>
            </tr>
            <tr>
            	<td colspan="2">Message</td>
            </tr>
            <tr>
            	<td colspan="2"><textarea name="data[Message][content]" id="messageContent"></textarea></td>
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
		
		$('#groupCheck').click(function() {
			$('.chk_boxes1').prop('checked', this.checked);
		});
		$('#deleteMessages').click(function(e) {
            return confirm("Are you sure you want to delete?");
		});
    });
	
</script>