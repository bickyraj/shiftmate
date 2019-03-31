<?php
//echo $userId;
$url_organization = URL ."OrganizationUsers/myOrganizations/".$user_id.".json";
$org = \Httpful\Request::get($url_organization)->send();

//print_r($org);
//echo "<pre>";
$myOrganizations = $org->body->myOrganizations;
//print_r($myOrganizations);

//echo $user_id;
?>

<script type="text/javascript">

  $(document).ready(function()
    {
          var elem = document.getElementById('msgBox');
              elem.scrollTop = elem.scrollHeight;

              
              
    });
</script>

<!-- <div class="leftPart" style="border:1px solid #000; width:300px; float:left;">
<ul>
	<li>
    	Organizations
        <ul>
        	<?php foreach($myOrganizations as $myOrganization){?>
        	<li><?php echo $myOrganization->Organization->title;?></li>
            <?php 
				$message = $myOrganization->Organization->Organizationmessage;
			} ?>
        </ul>
    
    </li>
    <li>Boards</li>
    <li>General</li>
</ul>
</div>
<div class="rightPart" style="border:1px solid #000; width:700px; float:left;">
<table border="1">
<?php
	if($message != '' && !empty($message)){
		$count = 0;
		foreach($message as $messages){
			$count++;
		?>
   <tr id="message_<?php echo $count;?>">
   	<td><?php echo $messages->User->fname." ".$messages->User->lname;?>:</td>
   	<td> 
    
	<input type="hidden" name="organization_id" id="organization_id" value="<?php echo $messages->organization_id;?>" />
	<?php echo $messages->text;?></td>
    <td><?php echo $messages->date_time;?></td>
   </tr> 
   <?php    
		}
		//echo "<pre>";
		//print_r($message);
	}else{
		echo "<tr><td colspan='3'>No Conversation</td></tr>";	
	}
?>
	<tr>
    	<td colspan="3">
        <input type="hiddent" name="messageCount" id="messageCount" value="message_<?php echo $count; ?>" />
        <textarea name="replyMessage" id="replyMessage"></textarea></td>
    </tr> 
    <tr>
    	<td colspan="2">&nbsp;</td>
        <td><input type="button" name="send" value="Send" id="send" /></td>
    </tr>
</table>
/////////////////////////////////////////////////////////////////////////////////////
</div>
<script>
$(document).ready(function(e) {
    $('#send').click(function(e) {
        replyMessage = $('#replyMessage').val();
		org_id = $('#organization_id').val();
		messageCount = $('#messageCount').val();
		//alert(messageCount);
		
		$.ajax({
		  type: "POST",
		  url: "<?php echo URL_VIEW;?>users/employee/ajaxpage_send_message.php",
		  data: { message: replyMessage, organization_id: org_id, user_id: <?php echo $user_id;?> }
		})
		  .done(function( msg ) {
			//alert( msg);
			if(msg == '1'){
				//alert('inn');
				$('#'+messageCount).after('<tr><td>user name</td><td>Message</td><td>Time</td></tr>');
			}
		  });
    });
});

</script>
////////////////////////////////////////////////////////////////////////////////////////////
</div> -->

<div class="userMsg">
<dl><label>Organization Name</label><img src="<?php echo URL_VIEW."images/whiteDropDown.png";?>"/></dl>
<dd class="active"><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" /><label>User Name</label></dd>
<dd><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" /><label>User Name</label></dd>
<dd><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" /><label>User Name</label></dd>
<dl>Organization Name</dl>
<dd><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" /><label>User Name</label></dd>
<dd><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" /><label>User Name</label></dd>
<dd><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" /><label>User Name</label></dd>
</div>
<div class="msgDetails" id="msgBox">

  <div class="sender">
  <dl>User Name <span style="float:right">19:00pm</span></dl>
  <dd><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" />It is a new innovative approach of problem solving. Today, we will provide you the complete information regarding the TRIZ invention, process, etc.</dd>
  </div>

  <div class="clear"></div>

  <div class="reciever">
  <dl>User Name</dl>
  <dd><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" />It is a new innovative approach of problem solving. Today, we will provide you the complete information regarding the TRIZ invention, process, etc.</dd>
  </div>

  <div class="clear"></div>

  <div class="sender">
  <dl>User Name</dl>
  <dd><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" />It is a new innovative approach of problem solving. Today, we will provide you the complete information regarding the TRIZ invention, process, etc.</dd>
  </div>

  <div class="clear"></div>

  <div class="reciever">
  <dl>User Name</dl>
  <dd><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" />It is a new innovative approach of problem solving. Today, we will provide you the complete information regarding the TRIZ invention, process, etc.</dd>
  </div>

  <div class="clear"></div>

  <div class="reciever">
  <dl>User Name</dl>
  <dd><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" />It is a new innovative approach of problem solving. Today, we will provide you the complete information regarding the TRIZ invention, process, etc.</dd>
  </div>

  <div class="clear"></div>

  <div class="sender">
  <dl>User Name</dl>
  <dd><img src="<?php echo URL_VIEW."images/EmployeeIcon.png";?>" />It is a new innovative approach of problem solving. Today, we will provide you the complete information regarding the TRIZ invention, process, etc.</dd>
  </div>

  <textarea placeholder="Write a Message..."></textarea>
  <div class="clear"></div>
  <input id="send" type="button" value="Send" class="sendBtn">
</div>
</div>
 
