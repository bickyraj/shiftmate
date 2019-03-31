<?php
//echo $userId;
$url = URL ."Messages/myMessage/".$user_id.".json";
$org = \Httpful\Request::get($url)->send();

//print_r($org);
$myMessage = $org->body->myMessage;
//print_r($myMessage);

if(isset($_POST) && !empty($_POST) && $_POST['submit'] == 'Send'){
	
print_r($_POST);	
}

?>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery.ui.js"></script>
<script src="<?php echo URL_VIEW;?>js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo URL_VIEW;?>styles/colorbox.css" />

<table border="1">
	<tr>
    	<td><a href="#composeMessageBox" id="composeMessage" style="color:#000;">Compose</a></td>
        <td>Inbox</td>
        <td>Sent</td>
    </tr>    
</table>


<table width="500" border="1">
	<tr>
    	<td>S.No</td>
        <td>Organization</td>
        <td>From</td>
        <td>Date</td>
        <td>Action</td>
    </tr>    
</table>

<div  style="display:none;">
<div id="composeMessageBox" class="composeMessageBox">
<form action="" method="post">
    <table cellpadding="12px" width="500px">
       <tr>
       		<td colspan="2">New Message</td>
       </tr>
       <tr>
       	<td>To :</td>
        <td><input type="text" name="username" id="username" /></td>
       </tr>
       <tr>
       	<td colspan="2">Message</td>
      </tr>
      <tr>
      	<td colspan="2">
        <textarea name="messageContent" id="messageContent"></textarea>
        </td>
       </tr> 
      <tr>
      	<td>&nbsp;</td>
        <td><input type="submit" name="submit" value="Send" /></td>  
     </tr>      
    </table>
</form>
</div>
</div>

<script>
$(document).ready(function(e) {
   // $('#composeMessage').click(function(e) {
		//alert('you here');
        $("#composeMessage").colorbox({inline:true });
   // });
});

</script>





























