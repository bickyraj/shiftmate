<?php 
//print_r($orgId);
$homeGroup = URL_VIEW.'groups/listGroups?org_id='.$orgId;
$groupId = $_GET['group_id'];

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}


//get list of user related to specific Group
$url = URL . "UserGroups/listEmployeesInGroup/".$groupId. "/" . $page .".json";
$data = \Httpful\Request::get($url)->send();


$userGroups = $data->body->userGroups;

$totalPage = $data->body->output->pageCount;
$currentPage = $data->body->output->currentPage;
// echo "<pre>";
// print_r($userGroups);
// die();


/*
By rabi Assign employ 
*/

//$groupId = $_GET['group_id'];
//$orgId = $_GET['org_id'];



//get list of user related to organization but not assigned to specific board
$url = URL . "UserGroups/getEmployeeListNotInGroup/".$groupId."/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$orgUsers = $data->body->orgUsersNotInGroup;

$url = URL . "Groups/getGroup/" . $groupId. ".json";
$data = \Httpful\Request::get($url)->send();
$groupList = $data->body->Group;
// echo "<pre>";
// print_r($groups);


if (isset($_POST["submit"]) && !empty($_POST['data'])) {
    // echo "<pre>";
    // print_r($_POST['data']);

    if(!empty($_POST['data']))
    {
        $url = URL . "UserGroups/assignEmployeeToGroup/".$groupId.".json";
        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();
        // echo "<pre>";
        // print_r($response);

        if($response->body->output->status == '1')
        {
            echo("<script>location.href = '".URL_VIEW."userGroups/listEmployeesInGroup?group_id=".$groupId."';</script>");

            $_SESSION['success']="test";
        } 
    }
}

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
<style>
a.label-danger {
    color: #ffffff
}
</style>
<!-- Edit-->
    <div class="modal fade" id="portlet-config_12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content" style="">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Assign Employee</h4>
              </div>
              <form class="form-horizontal" action="" id="GroupAddForm" method="post" accept-charset="utf-8">
                <div style="display:none;">
                    <input type="hidden" name="_method" value="POST"/>
                    <input type="hidden" name="data[Group][id]" value="<?php echo $group->Group->id;?>">
                </div>
                <?php if(!empty($orgUsers)):?> 
                <div class="modal-body">
                      <div class="form-group">
                            <?php foreach($orgUsers as $orgUser):?>
                            <div class="col-md-6 clear">
                                <label class="control-label"><input type="checkbox" name="data[UserGroup][user_id][]" value="<?php echo $orgUser->User->id;?>"/> <?php echo $orgUser->User->fname.' '.$orgUser->User->lname;?></label>
                            </div>
                            <?php endforeach;?>
                        </div>                         
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <input type="submit" id="employeeSubmit" name="submit" value="Submit" class="btn green">
                            <!-- <a class="btn default" href="<?php echo URL_VIEW."userGroups/listEmployeesInGroup?group_id=".$groupId;?>">Cancel</a> -->
                        </div>
                    </div>
                </div>
                <?php else:?>
                    <div class="modal-body">
                       <h5 class="modal-title">Sorry, no employee are available.</h5>
                            
                    </div> 
                
                <?php endif;?>
            </form>
            </div>                          
              <!-- <div class="modal-footer">
                  <button type="button" class="btn default" data-dismiss="modal">Close</button>
              </div> -->
          </div>
          <!-- /.modal-content -->
    </div>
                                                <!-- /.modal-dialog -->


<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1><?php echo $groupList->title; ?> <small> View Employee List</small></h1>
        </div> 
        <div class="page-toolbar">
            
        </div> 
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo URL_VIEW; ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo $homeGroup; ?>">Groups</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Employee List</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Employee List</span>
                            <!-- <span class="caption-helper">16 pending</span> -->
                        </div>
                        <div class="btn-group pull-right">
                            <a href="#portlet-config_12" class="btn btn-fit-height btn-success dropdown-toggle" data-toggle="modal">
                                <i class="fa fa-plus"></i> Add Member  </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_2">
                            <thead>
                                <tr>
                                    <!-- <th>
                                        S.N
                                    </th> -->
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
                                    <!-- <th>
                                         Action
                                    </th> -->
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="odd gradeX">
                                    <?php if($userGroups):?>
                                        <?php $i = 1; ?>
                                        <?php foreach ($userGroups as $userGroup): ?>
                                    <td class="fit">
                                        <?php
                                          $userimage = URL."webroot/files/user/image/".$userGroup->User->image_dir."/thumb2_".$userGroup->User->image;
                                          $image = $userGroup->User->image;
                                          $gender = $userGroup->User->gender;
                                          $user_image = imageGenerate($userimage,$image,$gender);
                                        ?>
                                        <img class="user-pic" src="<?php echo $user_image; ?>" width="40" height="40" alt="image not found"/>
                                              
                                        <?php echo $userGroup->User->fname.' '.$userGroup->User->lname; ?>
                                    </td>
                                    
                                    <td><?php echo $userGroup->User->email; ?></td>
                                    <td><?php echo $userGroup->User->address; ?></td>
                                    <td><?php echo $userGroup->User->phone; ?></td>
                                     <!-- <td class="action_td">
                                                     <form action="/newshiftmate/Organizations/delete/1" name="post_5476f94dde83b126092591" id="post_5476f94dde83b126092591" style="display:none;" method="post">
                                                <input type="hidden" name="_method" value="POST"/>
                                            </form>
                                                <div class="hover_action"></div>
                                                <a class="btn btn-xs label-danger" href="#" onclick="if (confirm( & quot; Are you sure you want to delete # 1? & quot; ))
                                                        {
                                                            document.post_5476f94dde83b126092591.submit();
                                                        }
                                                        event.returnValue = false;
                                                        return false;">
                                              <i class="fa fa-times"></i> Delete
                                                </a>
                                    </td> -->
                                </tr>
                                <?php endforeach; ?>

                                <?php else:?>
                                    <tr><td colspan="5">No Employee are Assigned...</td></tr>
                                    <!-- <div class="empty_list">No Employee are Assigned.</div> -->
                                <?php endif;?>
                            </tbody>
                        </table>
                        <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                            <?php
                            $page = $currentPage;
                            $max = $totalPage;
                            if($max>0){
                                ?>
                                <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                <ul class="pagination" style="visibility: visible;">
                                    <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="First" href="?page=1"><i class="fa fa-angle-double-left"></i></a>
                                        <?php } ?>
                                    </li>
                                    <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                            <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="Prev" href="?page=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                        <?php } ?>
                                    </li>

                                    <?php if($max<=5){
                                        for($i=1;$i<=$max;$i++){ ?>
                                            <li>
                                                <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                        <?php }}else{
                                        if(($page-2)>=1 && ($page+2)<=$max){
                                            for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                <li>
                                                    <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                            <?php  }}elseif(($page-2)<1){
                                            for($i=1;$i<=5;$i++){ ?>
                                                <li>
                                                    <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                            <?php }}elseif(($page+2)>$max){
                                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                                <li>
                                                    <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page=<?=$i?>"><?=$i;?></a>
                                                </li>
                                            <?php }}} ?>

                                    <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                        <?php if($page>=$max){ ?>
                                            <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                        <?php }else{ ?>
                                            <a title="Next" href="?page=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                        <?php } ?></li>
                                    <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                        <?php if($max==0 || $max==1){ ?>
                                            <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                        <?php }else{ ?>
                                            <a title="Last" href="?page=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                        <?php } ?></li>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
<div class="row">
   <div class="col-md-6 col-sm-12">
        <div class="portlet green box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Organization Name
                </div>
            </div>
            <div class="portlet-body">
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Name:
                    </div>
                    <div class="col-md-7 value">
                        ajay maharjan                   
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Email:
                    </div>
                    <div class="col-md-7 value">
                         ajay@gmail.com                    
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Address:
                    </div>
                    <div class="col-md-7 value">
                         lubu                    
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Phone:
                    </div>
                    <div class="col-md-7 value">
                         12345678                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <div class="portlet green box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Organization Name
                </div>
            </div>
            <div class="portlet-body">
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Name:
                    </div>
                    <div class="col-md-7 value">
                        ajay maharjan                   
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Email:
                    </div>
                    <div class="col-md-7 value">
                         ajay@gmail.com                    
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Address:
                    </div>
                    <div class="col-md-7 value">
                         lubu                    
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Phone:
                    </div>
                    <div class="col-md-7 value">
                         12345678                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->






<!-- Success Div -->
<!-- <div id="save_success">Saved Successfully !!</div> -->
<!-- End of Success Div -->


<!-- <div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Employees List of <span style="text-transform:capitalize;"></span></div>
        <a href="<?php echo URL_VIEW . 'userGroups/assignEmployeeToGroup?org_id=' . $orgId.'&group_id='.$groupId; ?>"><button class="addBtn">Assign New Employee</button></a>
    </div>
    <div class="clear"></div> -->

    <!-- Table -->
   <!--  <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>SN</p></th>
        <th><p>Name</p></th>
        <th><p>Email</p></th>
        <th><p>Address</p></th>
        <th><p>Phone</p></th>
        <th><p>Action</p></th>

        </tr>

        <?php if($userGroups):?>
                <?php $i = 1; ?>
                <?php foreach ($userGroups as $userGroup): ?>
                    <tr class="list_users">
                        <td><?php echo $i++; ?><input class="listShift-checkbox" type="checkbox" name="<?php echo $userGroup->User->id;?>"/></td>
                        <td><?php echo $userGroup->User->fname.' '.$userGroup->User->lname; ?></td>
                        <td><?php echo $userGroup->User->email; ?></td>
                        <td><?php echo $userGroup->User->address; ?></td>
                        <td><?php echo $userGroup->User->phone; ?></td>
                        <td class="action_td">
                            <ul class="action_btn">
                                
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
            <?php endforeach; ?>

        <?php else:?>
            <div class="empty_list">No Employee are Assigned.</div>
        <?php endif;?>
        </table>
    <!-- End of Table -->

    <!-- Bulk Action -->
               <!--  <div class="bulkaction-div">
                        <select>
                          <option value="volvo">Bulk Action</option>
                          <option value="saab">Delete</option>
                        </select>
                        <button id="bulkBtn">Apply</button>
                </div> -->
    <!-- End of Bulk Action -->
    
   <!--  <?php
        if ($totalPage > 1) {
            $previousPage = $currentPage - 1;
            $nextPage = $currentPage + 1;
            ?>
        <div class="paginator">
            <ul>
                <li>
        <?php if ($currentPage == 1) { ?>
                        <div class="deactive"><</div>
    <?php } else { ?>
                        <a class="no-underline" href="<?php echo URL_VIEW . 'userGroups/listEmployeesInGroup?group_id=' . $groupId . '&page=' . $previousPage; ?>"><</a></li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
                    <li><a class="<?php echo ($currentPage == $i) ? 'active' : ''; ?>" href="<?php echo URL_VIEW . 'userGroups/listEmployeesInGroup?group_id=' . $groupId . '&page=' . $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li>
                <?php if ($totalPage == $currentPage) { ?>
                        <div class="deactive">></div>
                <?php } else { ?>
                        <a class="no-underline" href="<?php echo URL_VIEW . 'userGroups/listEmployeesInGroup?group_id=' . $groupId . '&page=' . $nextPage; ?>">></a></li>
                    <?php } ?>
            </ul>
        </div>
                <?php }
                ?> -->

