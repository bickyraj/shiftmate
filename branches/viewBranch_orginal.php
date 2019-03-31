
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->



<?php
//$branchId = $_GET['branch_id'];

$url = URL."Branches/viewBranch/".$branchId.".json";
$data = \Httpful\Request::get($url)->send();
$branch = $data->body->branch;
// echo "<pre>";
// print_r($data->body->branch);
$orgId = $branch->Branch->organization_id;

$url = URL."Shifts/myOrganizationShift/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$orgShifts = $data->body->shifts;
// echo "<pre>";
// print_r($orgShifts);
// die();

// if (isset($_POST["submit"])) {
//   //print_r($_POST);die();
//   $_POST['data']['Board']['branch_id'] = $branchId;
   
//     $url = URL. "Boards/createBoard/" . $orgId . ".json";
//     $response = \Httpful\Request::post($url)
//             ->sendsJson()
//             ->body($_POST['data'])
//             ->send();
//    echo("<script>location.href = '".URL_VIEW."branches/viewBranch?branch_id=".$branchId."';</script>");

// }

/*
for add board 
*/
if(isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] == 'ajax'){
  include('../httpful.phar');
  include('../config1.php');
  //define("URL", "http://192.168.0.112/newshiftmate/");
  //define("URL_VIEW", "http://192.168.0.112/shiftmate/");
  
  $showBranch = 'No';
}else{
  $showBranch = 'Yes';  
}
//$orgId = $branch->Branch->organization_id;
// print_r($orgId);
// die();
$url = URL. "OrganizationUsers/getOrganizationUsers/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$organizationUsers = $data->body->organizationUsers;
// echo "<pre>";
// print_r($organizationUsers);

$url = URL. "Branches/orgBranches/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

// echo "<pre>";
// print_r($branches);

if (isset($_POST["submit"])) {
  //   echo "<pre>";
  //    print_r($_POST['data']);
  // die();
    $url = URL. "Boards/createBoard/" . $orgId . ".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    // echo "<pre>";
    // print_r($response);

if($response->body->output->status == '1')
    {
        echo("<script>location.href = '".URL_VIEW."branches/viewBranch?branch_id=".$branchId."';</script>");

        $_SESSION['success']="test";
    }
}
/*
ends here add boards
*/
/*
for shift add
*/
if (isset($_POST['save'])) {
   // print_r($_POST['data']);
   // die();
    if(!empty($_POST['data']))
    {
        $url = URL . "ShiftBranches/assignShiftToBranch.json";
        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();
     }
}


?>
<!-- Edit-->

<h3 class="page-title">
    View Branch <small>View Branch</small>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Branch</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">View Branch</a>
        </li>
    </ul>
    <div class="page-toolbar">
    <!-- <div class="btn-group pull-right">
        <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
        Actions <i class="fa fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>
                <a href="#">Action</a>
            </li>
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
    </div> -->
</div>
</div>

<div class="row">
   <div class="col-md-6 col-sm-12">
        <div class="portlet purple box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i><?php echo $branch->Branch->title;?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row static-info">
                    <div class="col-md-5 name">
                        Email:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $branch->Branch->email;?>                   
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Phone:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $branch->Branch->phone;?>                    
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Fax:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $branch->Branch->fax;?>                  
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Address:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $branch->City->title;?>                    
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Country:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $branch->Country->title;?>                    
                    </div>
                </div>
            </div>
        </div>
  </div>
  <div class="col-md-6 col-sm-12">
        <div class="portlet purple box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Branch Detail
                </div>
            </div>
            <div class="portlet-body">
               
            </div>
        </div>
  </div>
</div>
<!--
Add board form start from here
-->
<div class="modal fade" id="portlet-config_1_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Add Board</h4>
          </div>
          <div class="modal-body">
              <form action="" id="BoardAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                <div style="display:none;">
                    <input type="hidden" name="_method" value="POST"/>
                </div>
                <div class="form-body">     
                    <div class="form-group">
                        <label class="control-label col-md-4">Branch <span class="required">
                        * </span>
                        </label>
                        <div class="col-md-7">
                            <?php
                                if($showBranch == 'Yes'){
                            ?>
                           <select name="data[Board][branch_id]" class="form-control">
                               <?php foreach($branches as $branche):

                               ?>
                                <option value="<?php echo $branche->Branch->id;?>"><?php echo $branche->Branch->title;?></option>
                                <?php endforeach;?>
                            </select>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Board Name <span class="required">
                        * </span>
                        </label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="data[Board][title]" required />
                        </div>
                    </div>
                    <div class="form-group">
                            <label class="control-label col-md-4">Board Manager <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                 <select class="form-control" name="data[Board][user_id]" id="BoardUserId" >
                                    <?php foreach($organizationUsers as $organizationUser):?>
                                    <option value="<?php echo $organizationUser->User->id;?>"><?php echo $organizationUser->User->fname.' '.$organizationUser->User->lname;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                    </div>
                </div>
                <div class="form-actions">
                   <div class="modal-footer">
                    
                        <div class="col-md-offset-3 col-md-9">
                            <input  type="submit" name="submit" value="Submit" class="btn green"/>
                           <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php //echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                            <input type="reset" name="cancel" value="Cancel" class="btn default">
                            <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
                        </div>
                    
                  </div>
                </div>
            </form>
          </div>
          <!-- <div class="modal-footer">
              <button type="button" class="btn default" data-dismiss="modal">Close</button>
          </div> -->
      </div>
      <!-- /.modal-content -->
  </div>
                <!-- /.modal-dialog -->
</div>
<!--
Add board form Ends here
-->
<div class="row">
  <div class="col-md-12 col-sm-12"  style="height:389px;">
    <div class="portlet box purple">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-user"></i>Board
        </div>
        <div class="actions">
          <!-- <a class="btn btn-default btn-sm" href="../boards/createBoard.php?org_id=<?php echo $orgId;?>&branch_id=<?php echo $branchId;?>&type=ajax" id="addBoardFromBranch">
              <i class="fa fa-plus"></i> Add Board </a> -->
              <a class="btn btn-default btn-sm" href="#portlet-config_1_2" class="news-block-btn" data-toggle="modal" class="config">
              <i class="fa fa-plus"></i> Add Board </a>

             

        </div>
      </div>
      <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover" id="sample_1">
          <thead>
            <tr>
              <th>
                 Board Name
              </th>
              <th>
                 Board Manager
              </th>
              <th>Board Detail</th>
            </tr>
          </thead>
          <tbody>
            <?php
             if(isset($branch->Board) && !empty($branch->Board)){
                  foreach($branch->Board as $board){

                   if($board->status == 1){
            ?>
            <tr class="odd gradeX">
              <td>
                 <?php echo $board->title;?>
              </td>
              <td>
                <?php
                 if(isset($board->User->fname) && !empty($board->User->fname)){
               ?><a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id='.$board->organization_id.'&user_id='.$board->user_id ;?>"><?php echo $board->User->fname." ".$board->User->lname;?></a>
                 <?php }else{ ?>
                 Not Assigned Yet.
                 <?php } ?> </a>
              </td>
              <td>
                <a href="<?php echo URL_VIEW . 'boards/viewBoard?board_id=' . $board->id; ?>">
                <button class="btn btn-xs default btn-editable">
                      <i class="fa fa-eye"></i> View
                </button>
              </td>
            </tr>
                  <?php }}}else{?>
          <tr style="height:40px;"><td colspan="3">No Board.</td></tr>
        <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<!--
Add shift form start from here
-->

<!--
Add shift form Ends here -->
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="portlet box purple">
    <div class="portlet-title">
      <div class="caption">
        <i class="fa fa-user"></i>Shifts
      </div>
     <!--  <div class="actions">
        <a style="color:#000;" href="#addShiftFromBranch_form" id="addShiftFromBranch" class="btn btn-default btn-sm"> <i class="fa fa-plus"></i>Add Shift</a>
       
      </div>
 -->   
 <div class="actions">
        <a class="btn btn-default btn-sm" href="#portlet-config_1_4" class="news-block-btn" data-toggle="modal" class="config">
              <i class="fa fa-plus"></i> Add Shift </a>
        <!-- <a class="btn btn-default btn-sm" href="#addShiftFromBranch_form" id="addShiftFromBranch">
        <i class="fa fa-plus"></i> Add Shift </a> -->
    </div>
                             </div>
    <div class="portlet-body">
      
      <table class="table table-striped table-bordered table-hover" id="sample_2">
        <thead>
          <tr>
            <th>
               Shift Name
            </th>
            <th>
               Start Time
            </th>
            <th>
               End Time
            </th>
          </tr>
        </thead>
        <tbody>
          <?php 
             $orgShiftId = array();
             if(isset($branch->ShiftBranch) && !empty($branch->ShiftBranch)){
             foreach($branch->ShiftBranch as $shift){

               if($shift->status == 1){
              $orgShiftId[] = $shift->Shift->id;     
          ?>
          <tr class="odd gradeX">
            <td>
               <?php echo $shift->Shift->title;?>
            </td>
            <td>
              <?php echo $shift->Shift->starttime;?>
            </td>
            <td>
              <?php echo $shift->Shift->endtime;?>
            </td>
          </tr>
          <?php }}}else{?>
            <tr style="height:40px;"><td colspan="3">No Shift.</td>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  </div>
  <div class="modal fade" id="portlet-config_1_4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Add Shift</h4>
          </div>
          <div class="modal-body">
              <form action="" id="BoardAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                <div style="display:none;">
                  <input type="hidden" name="data[ShiftBranch][branch_id]" value="<?php echo $branchId;?>" />
                    <input type="hidden" name="_method" value="POST"/>
                </div>
                <div class="form-body">     
                    <div class="form-group orm-md-checkboxes">
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
                                        
                                          <input type="checkbox" class="listShift-checkbox" name="data[ShiftBranch][shift_id][]" value="<?php echo $orgShift->Shift->id;?>"><?php echo $orgShift->Shift->title;?></td>
                                          
                                      <?php
                          }
                           endforeach;
                                    if($countShift == 0){   
                                      ?>
                                      <td><div class="empty_list">Sorry, no shifts to add.</div></td>
                                      <?php } ?>
                                  </tr>
                      
                                 
                          <?php else:?>
                              <tr><td>
                          <div class="empty_list">Sorry, no shifts are available.</div>
                          </td>
                          </tr>
                      <?php endif;?>
                      </table>
                     </div>
                    
                    
                </div>
                <div class="form-actions">
                   <div class="modal-footer">
                    
                        <div class="col-md-offset-3 col-md-9">
                            <input  type="submit" name="save" value="Submit" class="btn green"/>
                           <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php //echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                           <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            <!-- <input type="reset" name="cancel" value="Cancel" class="btn default"> -->
                            <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
                        </div>
                    
                  </div>
                </div>
            </form>
          </div>
          <!-- <div class="modal-footer">
              <button type="button" class="btn default" data-dismiss="modal">Close</button>
          </div> -->
      </div>
      <!-- /.modal-content -->
  </div>
                <!-- /.modal-dialog -->
</div>
<div class="col-md-12 col-sm-12">
    <div class="portlet box purple">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-user"></i>Employee
        </div>
         <div class="actions">
        <a class="btn btn-default btn-sm" href="../employees/employeeRegistrationByOrg?org_id=<?php echo $orgId;?>&branch_id=<?php echo $branchId;?>" id="addEmployeeFromBranch">
                                <i class="fa fa-plus"></i> Add Employee </a>
                            </div>
      </div>
      <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover" id="sample_3">
          <thead>
            <tr>
              <th>
                Sn.
              </th>
              <th>
                 Name
              </th>
              <th>
                 Designation
              </th>
              <th>
                 Email
              </th>
              <th>
                 Address
              </th>
              <th>
                 Phone
              </th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php 
                if(isset($branch->OrganizationUser) && !empty($branch->OrganizationUser)){
                foreach ($branch->OrganizationUser as $orgEmployee): 
            ?>
            <tr class="odd gradeX">
              <td>
                <?php echo $i++; ?>
              </td>
              <td>
                <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>"><?php echo $orgEmployee->User->fname . ' ' . $orgEmployee->User->lname; ?></a>
              </td>
              <td>
                <?php echo $orgEmployee->designation; ?>
              </td>
              <td>
                <?php echo $orgEmployee->User->email; ?>
              </td>
              <td>
                <?php echo $orgEmployee->User->address; ?>
              </td>
              <td>
                <?php echo $orgEmployee->User->phone; ?>
              </td>
              <td class="action_td">
                <!-- <ul class="action_btn">
                    <li><div class="hover_action"></div>
                        <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>"><button 
                                class="view_img">Employ Detail</button>
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
                                    return false;"><button class="delete_img">View Branch</button>
                        </a>
                    </li>
                </ul> -->
                <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>"><button class="btn btn-xs default btn-editable">
                      <i class="fa fa-eye"></i> View
                </button></a>
                <!-- <form action="/newshiftmate/Organizations/delete/1" name="post_5476f94dde83b126092591" id="post_5476f94dde83b126092591" style="display:none;" method="post">
                        <input type="hidden" name="_method" value="POST"/>
                    </form>
                <a href="#" onclick="if (confirm( & quot; Are you sure you want to delete # 1? & quot; ))
                                    {
                                        document.post_5476f94dde83b126092591.submit();
                                    }
                                    event.returnValue = false;
                                    return false;"><button class="btn btn-xs default btn-editable">
                      <i class="fa fa-eye"></i> Delete
                </button></a> -->
                </td>
            </tr> 
            <?php endforeach;
              }else{
           ?>
            <tr  class="list_users" style="height:40px;"><td colspan="7">No Employee</td></tr>
          <?php } ?>
          </tbody>
        </table>
        
      </div>
    </div>
  </div>
</div>











<!--<div class="profile viewBranchProfile">
  <div class="profile_outer_div"><div class="profile_heading">Branch</div>
  
 
  </div>

  <div class="basic-info">
    <table>
      <tr>-->
        <!-- <th>Title <span>-</span></th> -->
        <!--<td><h2><?php echo $branch->Branch->title;?></h2></td>
      </tr>
       <tr>-->
    <!--    <th>Email <span>-</span></th> -->
      <!-- <td><?php echo $branch->Branch->email;?></td>
     </tr>

      <tr>-->
      <!--  <th>Phone No <span>-</span></th> -->
      <!-- <td>Phone: <?php echo $branch->Branch->phone;?></td>
     </tr>

     <tr>->
    <!--    <th>Email <span>-</span></th> -->
      <!-- <td>Fax: <?php echo $branch->Branch->fax;?></td>
     </tr>

     <tr>-->
      <!--  <th>City <span>-</span></th> -->
       <!--<td><?php echo $branch->City->title;?></td>
     </tr> 

     <tr>-->
 <!--       <th>Country <span>-</span></th> -->
      <!-- <td><?php echo $branch->Country->title;?></td>
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
    <!--<table class="table_list" width="98%;" align="center">
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
    </table>-->
    <!-- End of Table -->
  
  

  <!--
 <div style="display:none;"> 
          <div class="form createShift" id="addShiftFromBranch_form">
          <h2>Organization Shifts</h2>
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


  </div> -->

  
  
<!--<script src="<?php echo URL_VIEW;?>js/jquery.colorbox.js"></script>
// <link rel="stylesheet" href="<?php echo URL_VIEW;?>styles/colorbox.css" />
//  <script>
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
 
//  </script>
 
// <script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>
//  <script type="text/javascript" src="<?php echo URL_VIEW;?>js/jquery.ui.js"></script>-->
<script src="<?php echo URL_VIEW; ?>global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>




<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>

<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/table-advanced.js"></script>
<script>
jQuery(document).ready(function() {       
  
   TableAdvanced.init();
});
</script>