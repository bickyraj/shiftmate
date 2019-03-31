<?php

 $org_id = $_GET["org_id"]; 
  if (isset($_POST["submit"])) {
    $url = URL."Noticeboards/add/".$org_id.".json";
    $response = \Httpful\Request::post($url)
              -> sendsJson()
              -> body($_POST['data'])
              ->send(); 

// print_r($response->body->output); die();


if($response->body->output == '1')
    {
        echo("<script>location.href = '".URL_VIEW."Noticeboards/list_noticeboards?org_id=".$orgId."';</script>");

        $_SESSION['success']="test";
    }
  }
  
?>


<div id="save_success" class="redFont">There was some error during saving. Please try again.</div>
<!-- End of Failed Div -->



<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Add Notice</div>
    </div>
    <div class="clear"></div>

    <div class="createShift form">
        <form action="" id="NoticeAddForm" method="post" accept-charset="utf-8" class="createShift form">
           <table class="create_form_table" cellpadding="5px">
            <div style="display:none;">
                <input type="hidden" name="_method" value="POST"/>
            </div>
            <tr>
               <th>Title</th>
               <td><input type="text" name="data[Noticeboard][title]" required /></td>
           </tr>
       		<tr>
               <th>Description</th>
               <td><input type="text" name="data[Noticeboard][description]" required /></td>
           </tr>
          
       
   
<tr>
   <td colspan="2">
    <a class="cancel_a" href="<?php echo URL_VIEW."noticeboards/noticeboards?org_id=".$orgId;?>">Cancel</a>
    <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
</tr>	
</table>
</form>
</div>

<div class="clear"></div>