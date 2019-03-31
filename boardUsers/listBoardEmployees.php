<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php
$boardId = $_GET['board_id'];
if(isset($_GET['page'])){
    $page = "page:".$_GET['page'];
}else{
    $page = '';
}
if (isset($_POST["submit"])) {
    // echo "<pre>";
    // print_r($_POST['data']);

    // die();

    if(!empty($_POST['data']))
    {

      // fal($_POST);
        $url = URL. "BoardUsers/assignEmployeeToBoard/".$boardId.".json";

        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();
        
        // echo "<pre>";
        // print_r($response);
        // die();
        
        if($response->body->output->status == '1')
                {
                     echo '<script>
                            toastr.success("Employee added to department Successfully.");
                    </script>';
                   
                }
                else
                {

                     echo '<script>
                            toastr.error("Something went wrong.Please try again.");
                    </script>';
                   
                }
    }
}

$url = URL."Boards/getBranchIdFromBoardId/".$boardId.".json";
$data = \Httpful\Request::get($url)->send();
$branchId = $data->body->branchId;


//get list of user related to organization but not assigned to specific board
$url = URL. "OrganizationUsers/getOrganizationUsersNotInBoard/".$orgId."/".$boardId."/".$branchId.".json";
$data = \Httpful\Request::get($url)->send();
$orgUsers = $data->body->orgUsers;
//fal($orgUsers);

$url = URL. "BoardUsers/listBoardEmployees/".$boardId."/".$page.".json";
$data = \Httpful\Request::get($url)->send();
$boardUsers = $data->body->boardUsers;
// echo "<pre>";
// print_r($boardUsers);die();
$totalPage = $data->body->output->pageCount;
$currentPage = $data->body->output->currentPage;

$url = URL."Boards/viewBoard/".$boardId.".json";
$data = \Httpful\Request::get($url)->send();
$board = $data->body->board;
// echo "<pre>";
// print_r($board);
// die();
// fal($board);

?>

<!-- Save Success Notification -->
<script type="text/javascript">
    $(document).ready(function()
        {
            var top_an = $("#save_success").css('top');
            $("#save_success").css('top','0px');

            <?php if(isset($_SESSION['success'])):?>
                $("#save_success").show().animate({top:top_an});
                <?php unset($_SESSION['success']);?>
                setTimeout(function()
                    {
                        $("#save_success").fadeOut();
                    }, 3000);
            <?php endif;?>
        });
</script>
<!-- End of Save Success Notification -->



<!-- Edit-->
<div class="modal fade" id="portlet-config_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Add Department Employee</h4>
          </div>
          <div class="modal-body">
              <form action="" id="BoardAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                <div style="display:none;">
                   <input type="hidden" name="data[ShiftBranch][branch_id]" value="<?php echo $branchId;?>" />
                    <input type="hidden" name="_method" value="POST"/>
                </div>
                <div class="modal-body">
                    <!-- bickyraj -->
                    <?php if(!empty($orgUsers)):
                                // echo "<pre>";
                                // print_r($orgUsers);
                                ?>
                      <div class="portlet">
                        <div class="portlet-body">
                          <table class="table table-striped table-bordered table-hover" id="membersTable">
                          <thead>
                          <tr>
                            <th>
                               Employees
                            </th>
                          </tr>
                          </thead>
                          <tbody>
                               
                                               <?php foreach($orgUsers as $orgUser):
                                               ?> 
                                               <tr class="odd gradeX">
                                                  <td>
                                                  <div class="md-checkbox">
                                                        <input type="checkbox" id="checkbox<?php echo $orgUser->User->id;?>" class="md-check" name="data[BoardUser][user_id][]" value="<?php echo $orgUser->User->id;?>">
                                                            <label for="checkbox<?php echo $orgUser->User->id;?>">
                                                                    <span class="inc"></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span>
                                                                    <?php
                                                                          $userimage = URL.'webroot/files/user/image/'.$orgUser->User->image_dir.'/thumb2_'.$orgUser->User->image;
                                                                          $image = $orgUser->User->image;
                                                                          $gender = $orgUser->User->gender;
                                                                          $user_image = imageGenerate($userimage,$image,$gender);
                                                                    ?>
                                                                    <img src="<?php echo $user_image; ?>" width="30" height="30" alt="image not found"/>
                                                                      <?php echo $orgUser->User->fname.' '.$orgUser->User->lname;?>
                                                                      (<?php echo $orgUser->OrganizationUser->designation;?>)
                                                                    </label>
                                                    </div>
                                                  </td>
                                                </tr>

                                            
                                         <?php endforeach;?>
                          </tbody>
                          </table>
                        </div>
                    </div>
                    <?php else:?>
                            <div class="empty_list">Sorry, no employees are available.</div>
                        <?php endif;?>
                </div>
                <div class="form-actions">
                   <div class="modal-footer">
                    
                        <div class="col-md-offset-3 col-md-9">
                            <input  type="submit" name="submit" value="Submit" class="btn green"/>
                           <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php //echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                            <input type="reset" name="cancel" value="Clear" class="btn default">
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
    
<div class="page-head">
  <div class="container">
      <div class="page-title">
				<h1><?php echo $board->Board->title; ?> Department</h1>
			</div>  
  </div>
</div>
         <div class="page-content">
            <div class="container">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-circle"></i>
                        <a href="<?=URL_VIEW;?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?=URL_VIEW."boardUsers/listBoardEmployees";?>">Department Users</a>
                    </li>
                </ul>

<div class="row">
   <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption caption-md">
                  <i class="icon-bar-chart theme-font hide"></i>
                  <span class="caption-subject theme-font bold uppercase">Employee List</span>
                  <!-- <span class="caption-helper hide">weekly stats...</span> -->
                </div>
                <div class="btn-group pull-right">
                     <a class="btn btn-fit-height green dropdown-toggle" href="#portlet-config_1" class="news-block-btn" data-toggle="modal" class="config"><i class="fa fa-plus"></i> Add Employee</a>
                    <!--  <button class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                        <i class="fa fa-plus"></i> Add Employee To Board
                    </button> -->
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                <tr>
                    <th>
                        Name
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
                    <th>
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                    <?php if(!empty($boardUsers)):?>
                    <?php $i = 1; ?>
                    <?php foreach ($boardUsers as $boardUser):?>
                     <tr>
                        <td>

                            <?php
                                  $userimage = URL.'webroot/files/user/image/'.$boardUser->User->image_dir.'/thumb2_'.$boardUser->User->image;
                                  $image = $boardUser->User->image;
                                  $gender = $boardUser->User->gender;
                                  $user_image = imageGenerate($userimage,$image,$gender);
                            ?>
                            <img src="<?php echo $user_image; ?>" width="60" height="60" alt="image not found"/>
                            

                            <?php echo $boardUser->User->fname.' '.$boardUser->User->lname; ?>
                        </td>
                        <td>
                            <?php echo $boardUser->User->email; ?>
                        </td>
                        <td>
                            <?php echo $boardUser->User->address; ?>
                        </td>
                        <td>
                            <?php echo $boardUser->User->phone; ?>
                        </td>
                       <td>
                           <button class="btn btn-xs red removeEmployee" data-boardUserId="<?php echo $boardUser->BoardUser->id;?>"><i class="fa fa-trash-o"></i> Remove </button>
                       </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else:?>
                        <tr>
                            <td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
                        </tr>
                    <?php endif;?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>


<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/table-advanced.js"></script>
<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/table-managed.js"></script>

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/ui-alert-dialog-api.js"></script>

<script>
jQuery(document).ready(function() {       
    
    UIAlertDialogApi.init();

   $(".removeEmployee").on('click', function(event)
    {
        var e = $(this);
        var boardUserId = $(this).attr('data-boardUserId');
        bootbox.confirm("Are you sure you want to remove?", function(result) {
                      if(result === true)
                      {
                         var url = '<?php echo URL;?>BoardUsers/removeEmployee/'+boardUserId+'.json';

                         $.ajax(
                            {
                                url:url,
                                datatype:'jsonp',
                                type:'post',
                                success:function(res)
                                {
                                    if(res.output ===1)
                                    {
                                        e.closest('tr').remove();
                                        toastr.success('The Employee has been removed.');
                                    }
                                }
                            });
                      }
                    }); 
    });

    $("#membersTable").dataTable();
   TableAdvanced.init();
});
</script>