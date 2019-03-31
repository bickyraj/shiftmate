<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery.ui.js"></script>
<script src="<?php echo URL_VIEW;?>js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo URL_VIEW;?>styles/colorbox.css" />
<?php
	$message_type = $_GET['type'];
	$message_id = $_GET['message_id']; 
	
	$messageDetail = getMessageDetailOrg($message_id);
	//echo "<pre>";
	//print_r($messageDetail);
if(isset($_POST['submit']) && $_POST['submit'] == 'Send'){
		$url = URL."Organizationmessages/add.json";
		$response = \Httpful\Request::put($url)                  // Build a PUT request...
    		->sendsJson()                               // tell it we're sending (Content-Type) JSON...
    		//->authenticateWith('username', 'password')  // authenticate with basic auth...
    		->body($_POST['data'])             // attach a body/payload...
    ->send();	
		if($response->body->output == 1){
			?>
            <script type="text/javascript">
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
			</script>
            <?php	
		}
	}
?>



<div id="save_success">Message Send Successfully !!</div>
<h2 class="newH2">Message Detail</h2>
<div class="viewMsgContainer">
	<div class="msgSender"><?php echo $messageDetail->User->fname." ".$messageDetail->User->lname;?></div>
    

    <?php $dateTime = explode(" ",$messageDetail->Organizationmessage->date_time);$date = ($dateTime['0']);$time = ($dateTime['1']);?>
    <?php $times = explode(":", $time);if($times['0'] > 12){ $meri= "pm";}else{ $meri = "am";}
        if($times['0'] >12){$hr = $times['0']-12;}else{$hr = $times['0'];}
    $atime = $hr.":".$times['1']." ".$meri;
     ?>

     <?php $dates = explode("-", $date);
        $month = date("F", mktime(0, 0, 0, $dates['1'], 10));
        $adate = ltrim($dates['2'], '0')." ".$month." ".$dates['0'];

     ?>


    <div class="msgDate"><?php echo $adate;?></div>
    <div class="msgTime"><?php echo $atime;?></div>
    <div class="msg"><?php echo $messageDetail->Organizationmessage->content;?></div>
</div>

<div class="clear"></div>
<?php
if($user_id != $messageDetail->User->id){
?>
	<a class='replyMessage' href="#reply">Reply</a>
<?php } ?>
<a class="backBtn" href="<?php echo URL_VIEW."users/employee/organizationMessage";?>" style="color:#000">Back</a> 

<div style="display:none;">
	<div id="reply">
    <form method="post" action="">
    <input type="hidden" name="data[Organizationmessage][user_id]" value="<?php echo $user_id;?>">
    <input type="hidden" name="data[Organizationmessage][parent_id]" value="<?php echo $messageDetail->Organizationmessage->id;?>">
    <input type="hidden" name="data[Organizationmessage][organization_id]" value="<?php echo $messageDetail->Organizationmessage->organization_id;?>">
		<table>
            <tr>
            	<td colspan="2">Message Compose</td>
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
        $(".replyMessage").colorbox({inline:true, width:"50%"});
		
    });
	
</script>