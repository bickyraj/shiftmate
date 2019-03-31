<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery.ui.js"></script>
<script src="<?php echo URL_VIEW;?>js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo URL_VIEW;?>styles/colorbox.css" />

<?php 
$inboxMessage_link = URL_VIEW."users/employee/organizationMessage";

$orgListMessage = getOrgListReceiveMessage($user_id);
// echo "<pre>";print_r($orgListMessage);

foreach($orgListMessage->OrganizationUser as $orgListMessages){
	$orgList[$orgListMessages->Organization->id] = $orgListMessages->Organization->title;
	$orgMessages[$orgListMessages->Organization->title] = $orgListMessages->Organization->Organizationmessage;
	
}


	if(isset($_POST['submit']) && $_POST['submit'] == 'Send'){
		$url = URL."Organizationmessages/add.json";
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

<script type="text/javascript">

    $(document).ready(function()
        {
            $(".orgMsgViewList").on('click', function()
            {

                e = $(this);
                msgList = e.closest(".orgList").siblings(".msgListDiv");
                   msgList.slideDown();  
                   flag = 1;
                   
                
            });
        });

    $(document).on('mouseup', function(ev)
        {
            msgListDiv = $(".msgListDiv");
            

            if(!msgListDiv.is(ev.target) && msgListDiv.has(ev.target).length === 0)
            {
                msgListDiv.slideUp();
            }
        });
</script>

<h1>Organization Message</h1>

<!-- Success Div -->
<div id="save_success">Message Send Successfully !!</div>
<!-- End of Success Div -->

<div class="leftPart">
    <a class='composeMessage' href="#compose"><button class="composeBtn">Compose</button></a>
</div>



<!-- Organization Message -->
<div class="RightPart">
    <div class="orgMsgContainer">
        <div class="orgMessageListDiv">Organization Message List</div>

        <form name="blockFunctionSelect" action="" method="post">
            <div class="msgContainer">
                <?php foreach($orgMessages as $org_key=>$message_val):?>
                <div class="organizationMessageDiv">

                    <?php if(isset($message_val) && !empty($message_val)){$dataOrder = '';foreach($message_val as $org_messages){$dataOrder[] = $org_messages;}$count_dataOrder = count($dataOrder);}?>
                    <div class="orgList">
                        <div class="orgMsgTitle"><?php echo $org_key;?></div><div class="orgMsgViewList">Message List</div><div class="orgMsgTotal"><span>Total</span> - <?php echo $count_dataOrder;?></div>
                    </div>
                    <div class="msgListDiv">
                        <table class="msgListTable">
                                <?php 
                                     if(isset($message_val) && !empty($message_val)){
                                         $dataOrder = '';
                                     foreach($message_val as $org_messages){
                                        $dataOrder[] = $org_messages;
                                     }
                                     $count_dataOrder = count($dataOrder);
                                     for($a = $count_dataOrder; $a>0; $a--){
                                ?>
                                <tr>
                                    <td><?php echo $dataOrder[$a-1]->User->fname." ".$dataOrder[$a-1]->User->lname;?></td>
                                    <td class="msgContent"><span><?php echo $dataOrder[$a-1]->content;?></span></td>
                                    <td><?php echo $dataOrder[$a-1]->date_time;?></td>
                                    <td> <a href="<?php echo URL_VIEW."users/employee/messageDetailOrganization?type=receive&message_id=".$dataOrder[$a-1]->id;?>">view</a></td>
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
        </form>
    </div>
</div>


<div style="display:none;">
	<div id="compose">
    <form method="post" action="">
    <input type="hidden" name="data[Organizationmessage][user_id]" value="<?php echo $user_id;?>">
    <input type="hidden" name="data[Organizationmessage][parent_id]" value="0">
		<table>
            <tr>
            	<td colspan="2">Message Compose</td>
            </tr>
            <tr>
            	<td>To:</td>
                <td>
                <select name="data[Organizationmessage][organization_id]" id="send_to">
                	<option value="0">Select User</option>
                <?php 
					foreach($orgList as $key_org_dd=>$val_org_dd){
				?>
                	
                	<option value="<?php echo $key_org_dd;?>"><?php echo $val_org_dd;?></option>
                <?php 
				} ?>    
                </select>
                </td>
            </tr>
            <tr>
            	<td colspan="2">Message</td>
            </tr>
            <tr>
            	<td colspan="2"><textarea name="data[Organizationmessage][content]" id="messageContent"></textarea></td>
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