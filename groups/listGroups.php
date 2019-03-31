<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

<?php

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$url = URL . "Groups/listGroups/" . $orgId . "/" . $page . ".json";
$data = \Httpful\Request::get($url)->send();
$groups = $data->body->groups;

$totalPage = $data->body->output->pageCount;
$currentPage = $data->body->output->currentPage;

/*
    for add group
*/


// if (isset($_POST["submit"])) {
//     echo "<pre/>";
//     // print_r($_POST['data']);
//     $url = URL . "Groups/createGroup/" . $orgId . ".json";
//     $response = \Httpful\Request::post($url)
//             ->sendsJson()
//             ->body($_POST['data'])
//             ->send();
//     // echo "<pre>";
//     // print_r($response);

//     if($response->body->output->status == '1')
//     {
//         echo("<script>location.href = '".URL_VIEW."groups/listGroups?org_id=".$orgId."';</script>");

//         $_SESSION['success']="test";
//     }
// }

// if (isset($_POST["edit"])) {
//     // echo "<pre>";
//     // print_r($_POST);
//     // die();
//     $url = URL . "Groups/editGroup/" . $_POST['Group']['id'] . ".json";
//     $response = \Httpful\Request::post($url)
//             ->sendsJson()
//             ->body($_POST['data'])
//             ->send();
//     // echo "<pre>";
//     // print_r($response);

//     if($response->body->output->status == '1')
//     {
//         echo("<script>location.href = '".URL_VIEW."groups/listGroups?org_id=".$orgId."';</script>");

//         $_SESSION['success']="test";
//     }
// }
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
.bootbox-body {
    margin: 0 -15px;
}
</style>

<!-- Edit-->
    
<div class="page-head">
 <div class="container">
    <div class="page-title">
      <h1>Group List <small>View Group List</small></h1>
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
                    <a href="<?=URL_VIEW."groups/listGroups";?>">Groups</a>
                </li>
    </ul>
    <div class="modal fade" id="portlet-config_12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="addclose close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Group</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <form action="" id="addGroupForm" method="post" accept-charset="utf-8" class="form-horizontal">
                  <div style="display:none;">
                      <input type="hidden" name="_method" value="POST"/>
                  </div>
                  <div class="form-body">
                    <div class="form-group">
                      <label class="control-label col-md-4">Group Name <span class="required">
                          * </span>
                      </label>
                      <div class="col-md-7">
                        <input class="form-control" type="text" name="data[Group][title]" required />
                      </div>
                    </div>
                  </div>
                  <div class="form-actions">
                    <div class="modal-footer">
                      <div class="col-md-offset-3 col-md-9">
                          <input  type="submit" name="submit" value="Submit" class="btn green"/>
                         <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php //echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                          <button data-dismiss="modal" class="btn default" type="button">Close</button>
                          <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
                      </div>
                    </div>
                  </div>      
                </form>
              </div>
            </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-xs-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart theme-font hide"></i>
                    <span class="caption-subject theme-font bold uppercase">Organization Groups</span>
                    <!-- <span class="caption-helper">16 pending</span> -->
                </div>
                <div class="btn-group pull-right">
                  <a class="btn btn-fit-height btn-success dropdown-toggle" href="#portlet-config_12" class="news-block-btn" data-toggle="modal" class="config">
                    <i class="fa fa-plus"></i> Add New Group 
                  </a>
                </div>
            </div>
            <div class="portlet-body">
               <!--  <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button id="sample_editable_1_new" class="btn green">
                                Add New <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:;">
                                        Print </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        Save as PDF </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        Export to Excel </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->
                <table class="table-responsive table table-striped table-hover table-bordered" id="sample_editable_1_1">
                <thead>
                <tr>
                    <th >
                         Group Name
                    </th>
                    <th>No. of Employee</th>
                    <th width="180px">
                         Action
                    </th>
                    
                </tr>
                </thead>
                <tbody id="groupTable">
                 <?php 
                    if (isset($groups) && !empty($groups)) {
                        
                    $i = 1; ?>
                    <?php foreach ($groups as $group):
                        //print_r($group);
                 ?>
                 
                <!--  -->
                <tr>
                    <td>
                         <a href="<?php echo URL_VIEW . 'userGroups/listEmployeesInGroup?group_id=' . $group->Group->id;?>"><?php echo $group->Group->title; ?></a>
                    </td>
                    <td>
                      <?php echo $group->UserCount; ?>
                    </td>
                    <td>
                        <div class="editGroup btn btn-xs default" style="float:left;margin:0px;" data-groupId="<?php echo $group->Group->id; ?>"><a href="#portlet-config_1_<?php echo $group->Group->id; ?>" class="news-block-btn btn btn-xs default" style="margin:0px;float:left;" data-toggle="modal">
                        <i class="fa fa-pencil"></i> Edit  </a></div>
                        <!-- <a href="<?php echo URL_VIEW . 'groups/editGroup?group_id=' . $group->Group->id.'&org_id='.$orgId; ?>" class="btn btn-xs default"><i class="fa  fa-pencil"></i> Edit</a> -->
                        <div style="height:23px;"><a href="<?php echo URL_VIEW . 'userGroups/listEmployeesInGroup?group_id=' . $group->Group->id; ?>" style="float:right;margin:0px"class="btn btn-xs default"><i class="icon-user"></i> Employees</a></div>
                    </td>
                   
                    
                </tr>
                <?php
                        endforeach;
                    }
                    else{
                ?>
                   <tr id="noGroupData">
                       <td>-</td><td>-</td><td>-</td>
                   </tr>
                <?php
                    }
                ?>
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
        <!-- END EXAMPLE TABLE PORTLET-->
      </div>
    </div>

    <?php
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
                        <a class="no-underline" href="<?php echo URL_VIEW . 'groups/listGroups?org_id=' . $orgId . '&page=' . $previousPage; ?>"><</a></li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
                    <li><a class="<?php echo ($currentPage == $i) ? 'active' : ''; ?>" href="<?php echo URL_VIEW . 'groups/listGroups?org_id=' . $orgId . '&page=' . $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li>
                <?php if ($totalPage == $currentPage) { ?>
                        <div class="deactive">></div>
                <?php } else { ?>
                        <a class="no-underline" href="<?php echo URL_VIEW . 'groups/listGroups?org_id=' . $orgId . '&page=' . $nextPage; ?>">></a></li>
                    <?php } ?>
            </ul>
        </div>
    <?php }
        ?>
  </div>
</div>



<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/table-editable.js"></script>
<script type="text/javascript">
$(function(){
    var orgId = '<?php echo $orgId; ?>';
    $("#addGroupForm").on('submit',function(event){
      event.preventDefault();
      var ev = $(this);
      var data = $(this).serialize();
      
      //console.log(orgId)
      //console.log('<?php echo URL."Boards/createGroupWithData/"."'+orgId+'".".json"; ?>');
        $.ajax({
            url : '<?php echo URL."Groups/createGroupWithData/"."'+orgId+'".".json"; ?>',
            type : "post",
            data : data,
            datatype : "jsonp",
            success:function(response)
            {
                var status = response.output.status;

                //console.log(response.output.group.Group.id);
                 if(status == 2){
                    toastr.info("Group already exist.Please try again.");
                 } else if(status == 1){
                 var groupList = "";

                    groupList = '<tr><td><a href="<?php echo URL_VIEW; ?>userGroups/listEmployeesInGroup?group_id='+response.output.group.Group.id+'">'+response.output.group.Group.title+'</td>'+
                    '<td>0</td>'+
                    '<td>'+
                    '<div class="editGroup btn btn-xs default" style="float:left;margin:0px;" data-groupId="'+response.output.group.Group.id+'">'+
                    '<a href="javascript:;" class="news-block-btn btn btn-xs default" style="margin:0px;float:left;"><i class="fa fa-pencil"></i> Edit </a>'+ '</div>'+
                    '<div style="height:23px;">'+
                    '<a href="<?php echo URL_VIEW; ?>userGroups/listEmployeesInGroup?group_id='+response.output.group.Group.id+'" style="float:right;margin:0px" class="btn btn-xs default"><i class="icon-user"></i> Employ List</a>'+
                    '</div>'+
                    '</td></tr>';
                    $("#noGroupData").remove();
                    toastr.success('Recorded Added Successfully');
                    $("#groupTable").prepend(groupList);
                } else {
                    toastr.info("Something went wrong.Please try again.");
                }
                    ev.find('.addclear').click();
                    ev.find('.addclose').click();
                    ev.find('input:text').val('');
                    ev.closest('.modal-dialog').find('.addclose').click();
                
            }
        });
    });
    $(".editGroup").live('click',function()
    {
      
        var group_id = $(this).attr('data-groupId');
        //console.log('<?php echo URL."Boards/editGroupData/"."'+orgId+'"."/"."'+group_id+'".".json"; ?>');
        $.ajax
        ({
            url : '<?php echo URL."Groups/editGroupData/"."'+orgId+'"."/"."'+group_id+'".".json"; ?>',
            datatype : "jsonp",
            success:function(response)
            {
              bootbox.dialog({
                        title: "Edit Groups",
                        message:'<form action="" id="editGroupForm" data-groupids="'+response.output.Group.id+'" method="post" accept-charset="utf-8" class="form-horizontal">' +
                                '<div class="form-body">'+
                                '<div class="form-group">'+
                                    '<div class="row">'+
                                        '<label class="control-label col-md-4">Group Name <span class="required">'+
                                        '* </span>'+
                                        '</label>'+
                                        '<div class="col-md-7">'+
                                            '<input class="form-control" name="data[Group][title]" value="'+response.output.Group.title+'" maxlength="100" type="text" id="GroupTitle" required="required"/>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '</div>'+
                                '<div class="form-actions">'+
                                '<div class="modal-footer">'+
                                '<div class="col-md-offset-3 col-md-9">'+
                                    '<input type="submit" name="submit" value="Update" class="btn btn-success" />'+
                                    '<button data-dismiss="modal" class="btn default" type="button">Close</button>'+
                                '</div>'+
                                '</div>'+
                                '</div>'+
                            '</form>' 
                    });
            }
        });
    });
    $("#editGroupForm").live('submit',function(ev){
        ev.preventDefault();
        var data = $(this).serialize();
        var groupids = $(this).attr('data-groupids');
        var e = $(this);
        //console.log(groupids);
        $.ajax({
            url : '<?php echo URL."Groups/editGroupwithdata/"."'+orgId+'"."/"."'+groupids+'".".json"; ?>',
            type : "post",
            data : data,
            datatype : "jsonp",
            success:function(response)
            {
               
               var status = response.output.status;
               if(status == 1){
                    window.location.reload(true);
                    toastr.success('Record Updated Successfully');
               } else if(status == 2){
                    toastr.info('Group already exist.Please try again.');
               } else {
                    toastr.info('Something went wrong.Please try again');
               }
                e.find('.editclear').click();
                e.find('.bootbox-close-button').click();
                e.closest('.modal-dialog').find('.bootbox-close-button').click();
               
            }
        });
    });
});
</script>
<script>
jQuery(document).ready(function() {       
   
   TableEditable.init();
});
</script>

