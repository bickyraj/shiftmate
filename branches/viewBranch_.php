<?php
//$branchId = $_GET['branch_id'];

$url = URL."Branches/viewBranch/".$branchId.".json";
$data = \Httpful\Request::get($url)->send();
$branch = $data->body->branch;
//echo "<pre>";
//print_r($data->body->branch);
$orgId = $branch->Branch->organization_id;

$url = URL."Shifts/myOrganizationShift/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$orgShifts = $data->body->shifts;

if (isset($_POST["submit"])) {
	//print_r($_POST);die();
	$_POST['data']['Board']['branch_id'] = $branchId;
   
    $url = URL. "Boards/createBoard/" . $orgId . ".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
   echo("<script>location.href = '".URL_VIEW."branches/viewBranch?branch_id=".$branchId."';</script>");

}

?>

<div class="profile viewBranchProfile">
  <div class="profile_outer_div"><div class="profile_heading">Branch</div>
  
 
  </div>

  <div class="basic-info">
    <table>
      <tr>
        <!-- <th>Title <span>-</span></th> -->
        <td><h2><?php echo $branch->Branch->title;?></h2></td>
      </tr>
       <tr>
    <!--    <th>Email <span>-</span></th> -->
       <td><?php echo $branch->Branch->email;?></td>
     </tr>

      <tr>
      <!--  <th>Phone No <span>-</span></th> -->
       <td>Phone: <?php echo $branch->Branch->phone;?></td>
     </tr>

     <tr>
    <!--    <th>Email <span>-</span></th> -->
       <td>Fax: <?php echo $branch->Branch->fax;?></td>
     </tr>

     <tr>
      <!--  <th>City <span>-</span></th> -->
       <td><?php echo $branch->City->title;?></td>
     </tr> 

     <tr>
 <!--       <th>Country <span>-</span></th> -->
       <td><?php echo $branch->Country->title;?></td>
     </tr>  
   </table>
 </div>
</div>
<div class="clear"></div>
<div class="titleRow" style="width:1000px; font-size:14px; padding:10px; margin-top:50px;">
  	<span class="profile_heading">Board</span>
    <span style="float:right;"><a style="color:#000;" href="../boards/createBoard.php?org_id=<?php echo $orgId;?>&branch_id=<?php echo $branchId;?>&type=ajax" id="addBoardFromBranch">+Add Board</a></span>
  </div>
<table class="table_list" width="98%;" align="center">
  <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
   <th>Board Name</th>
   <th>Board Manager</th>
   <th>Action</th>
 </tr>
 <?php
  if(isset($branch->Board) && !empty($branch->Board)){
  foreach($branch->Board as $board){

   if($board->status == 1){?>
   <tr class="list_users">
     <td><?php echo $board->title;?></td>
     <td><?php
     if(isset($board->User->fname) && !empty($board->User->fname)){
	 ?><a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id='.$board->organization_id.'&user_id='.$board->user_id ;?>"><?php echo $board->User->fname." ".$board->User->lname;?></a>
     <?php }else{ ?>
     Not Assigned Yet.
     <?php } ?>
     </td>
     <td class="action_td">
      <ul class="action_btn">
        <li>
      <div class="hover_action"></div>
      <a href="<?php echo URL_VIEW . 'boards/viewBoard?board_id=' . $board->id; ?>"><button class="view_img"></button>
      </a>
    </li>
  </ul>
</td>
    </tr>
    <?php }}}else{?>
		<tr style="height:40px;"><td colspan="3">No Board.</td>
	<?php } ?>
  </table>	
  
  <div class="clear"></div>
  <div class="titleRow" style="width:1000px; font-size:14px; padding:10px; margin-top:50px;">
  	<span class="profile_heading">Shifts</span>
    <span style="float:right;"><a style="color:#000;" href="#addShiftFromBranch_form" id="addShiftFromBranch">+Add Shift</a></span>
  </div>

<table class="table_list" width="98%;" align="center">
  <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
   <th>Shift Name</th>
   <th>Start Time</th>
   <th>End Time</th>
  
 </tr>
 <?php 
 $orgShiftId = array();
 if(isset($branch->ShiftBranch) && !empty($branch->ShiftBranch)){
 foreach($branch->ShiftBranch as $shift){

   if($shift->status == 1){
	$orgShiftId[] = $shift->Shift->id;	   
?>
  <tr class="list_users" style="height:40px;">
     <td><?php echo $shift->Shift->title;?></td>
     <td><?php echo $shift->Shift->starttime;?></td>
     <td><?php echo $shift->Shift->endtime;?></td>
   </tr>
    <?php }}}else{?>
	<tr style="height:40px;"><td colspan="3">No Shift.</td>
	<?php } ?>
  </table>	
  
  
  <div class="clear"></div>
  <div class="titleRow" style="width:1000px; font-size:14px; padding:10px; margin-top:50px;">
  	<span class="profile_heading">Employee</span>
    <span style="float:right;"><a style="color:#000;" href="../employees/employeeRegistrationByOrg?org_id=<?php echo $orgId;?>&branch_id=<?php echo $branchId;?>" id="addEmployeeFromBranch">+Add Employee</a></span>
  </div>

	<!-- Table -->
    <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>SN</p></th>
        <th><p>Name</p></th>
        <th><p>Designation</p></th>
        <th><p>Email</p></th>
        <th><p>Address</p></th>
        <th><p>Phone</p></th>
        <th><p>Action</p></th>

        </tr>

<?php $i = 1; ?>
        <?php 
		if(isset($branch->OrganizationUser) && !empty($branch->OrganizationUser)){
		foreach ($branch->OrganizationUser as $orgEmployee): ?>
            <tr class="list_users">
                <td><?php echo $i++; ?><input class="listShift-checkbox" type="checkbox" name="<?php echo $orgEmployee->User->id;?>"/></td>
                <td><a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>"><?php echo $orgEmployee->User->fname . ' ' . $orgEmployee->User->lname; ?></a></td>
                <td><?php echo $orgEmployee->designation; ?></td>
                <td><?php echo $orgEmployee->User->email; ?></td>
                <td><?php echo $orgEmployee->User->address; ?></td>
                <td><?php echo $orgEmployee->User->phone; ?></td>
                <td class="action_td">
                    <ul class="action_btn">
                        <li><div class="hover_action"></div>
                            <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>"><button 
                                    class="view_img"></button>
                            </a>
                        </li>
                        <form action="/newshiftmate/Organizations/delete/1" name="post_5476f94dde83b126092591" id="post_5476f94dde83b126092591" style="display:none;" method="post">
                            <input type="hidden" name="_method" value="POST"/>
                        </form>
                        <li>
                            <div class="hover_action"></div>
                            <a href="#" onclick="if (confirm( & quot; Are you sure you want to delete # 1? & quot; ))
                                        {
                                            document.post_5476f94dde83b126092591.submit();
                                        }
                                        event.returnValue = false;
                                        return false;"><button class="delete_img"></button>
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
<?php endforeach;
		}else{
 ?>
	<tr  class="list_users" style="height:40px;"><td colspan="7">No Employee</td></tr>
<?php } ?>
    </table>
    <!-- End of Table -->
  
  
  
  
 <div style="display:none;"> 
          <div class="form createShift" id="addShiftFromBranch_form">
          <h1>Organization Shifts</h1>
                <form name="assignShiftToBranchForm" id="assignShiftToBranchForm" action="" method="post">
                 <table cellpadding="5px">
        
                    <?php 
					$countShift = 0;
					if(!empty($orgShifts) || $orgShifts != 0):?>  
                    <tr>
                        <?php foreach($orgShifts as $orgShift):
						if(!in_array($orgShift->Shift->id, $orgShiftId)){
							$countShift++;
						?>
                        <td>
                        	<input type="hidden" name="data[ShiftBranch][branch_id]" value="<?php echo $branchId;?>" />
                            <input type="checkbox" class="listShift-checkbox" name="data[ShiftBranch][shift_id][]" value="<?php echo $orgShift->Shift->id;?>"><?php echo $orgShift->Shift->title;?></td>
                            
                        <?php
						}
						 endforeach;
                      if($countShift == 0){   
                        ?>
                        <td><div class="empty_list">Sorry, no shifts to add.</div></td>
                        <?php } ?>
                    </tr>
        
                    <tr>
                     <td>
                        <input type="submit" name="submit" value="Submit" id="submit"/>
                    </td>
        
                </tr>	
        
            <?php else:?>
                <tr><td>
            <div class="empty_list">Sorry, no shifts are available.</div>
            </td>
            </tr>
        <?php endif;?>
        </table>
        </form>
        </div>
  </div>
  
  <script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery.ui.js"></script>
<script src="<?php echo URL_VIEW;?>js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo URL_VIEW;?>styles/colorbox.css" />
 <script>
 	$(document).ready(function(e) {
      // $("#addShiftFromBranch").colorbox();
	   $("#addShiftFromBranch").colorbox({inline:true, width:"50%"});
	   $("#addBoardFromBranch").colorbox();
	   $("#assignShiftToBranchForm").submit(function(e)
{
    var postData = $(this).serializeArray();
    //var formURL = $(this).attr("action");
	//alert(postData);
    $.ajax(
    {
        url : '<?php echo URL_VIEW;?>shiftBranches/ajax_assignShiftToBranch.php',
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) 
        {
            //data: return data from server
			//if(data == 1){
				$.fn.colorbox.close();
				location.reload();
			//}
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //if fails     
			alert('fail'); 
        }
    });
    e.preventDefault(); //STOP default action
    e.unbind(); //unbind. to stop multiple form submit.
});
    });
 
 </script>
 
 