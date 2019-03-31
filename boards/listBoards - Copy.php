<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php


// $orgId = $_GET['org_id'];
if(isset($_GET['page4'])){
    $page = $_GET['page4'];
}else{
    $page = 1;
}
$url = URL."Boards/listBoards/".$orgId."/".$page.".json";
$data = \Httpful\Request::get($url)->send();
$boards = $data->body->boards;

// echo "<pre>";
// print_r($boards);
// die();

$totalPage = $data->body->output->pageCount;
$currentPage = $data->body->output->currentPage;

if(isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] == 'ajax'){
    include('../httpful.phar');
    include('../config1.php');
    //define("URL", "http://192.168.0.112/newshiftmate/");
    //define("URL_VIEW", "http://192.168.0.112/shiftmate/");
    
    $showBranch = 'No';
}else{
    $showBranch = 'Yes';    
}


//Get User list related to particular organization
$url = URL. "OrganizationUsers/getOrganizationUsers/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$organizationUsers = $data->body->organizationUsers;

//get branch list related to particular organization
$url = URL. "Branches/orgBranches/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;
// echo "<pre>";
// print_r($branches);
// die();

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
.label-danger,.yellow a {
    color: #ffffff;
}

</style>


<!-- Edit-->    
    <div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Departments <small> Lists</small></h1>
			</div>  
                <div class="page-toolbar">
        <div class="btn-group pull-right" style="margin-top: 15px;">
             <!-- <a href="<?php echo URL_VIEW . 'boards/createBoard?org_id=' . $orgId; ?>"><button class="btn btn-fit-height grey-salt dropdown-toggle"><i class="fa fa-plus"></i> Add New</button></a> -->
             <a class="btn btn-fit-height grey-salt dropdown-toggle" href="#portlet-config_1" class="news-block-btn" data-toggle="modal" class="config">
                                          <i class="fa fa-plus"></i> Add New Department </a>
        </div>
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
                        <a href="javascript:;">Departments</a>
                    </li>
                </ul>

    <div class="modal fade" id="portlet-config_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                      <button type="button" class="addclose close" data-dismiss="modal" aria-hidden="true"></button>
                      <h4 class="modal-title">Create Departments</h4>
                </div>
                <div class="row">
                      <div class="modal-body">
                            <form action="" id="addBoardForm" method="post" accept-charset="utf-8" class="form-horizontal">
                                <div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>
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
                                               <?php foreach($branches as $branche):?>
                                                <option value="<?php echo $branche->Branch->id;?>"><?php echo $branche->Branch->title;?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Department Name <span class="required">
                                        * </span>
                                        </label>
                                        <div class="col-md-7">
                                            <input class="form-control" type="text" name="data[Board][title]" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <label class="control-label col-md-4">Department Manager <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                 <select class="form-control" name="data[Board][user_id]" id="BoardUserId" >
                                                    <option value="0">Assign Later</option>
                                                    <?php foreach($organizationUsers as $organizationUser):?>
                                                    <option value="<?php echo $organizationUser->User->id;?>"><?php echo $organizationUser->User->fname.' '.$organizationUser->User->lname;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <input  type="submit" name="submit" value="Submit" class="btn green"/>
                                               <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                                                <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
                                                <input type="reset" class="addclear btn default" value="Clear">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                      </div>
                </div>
            </div>
        </div>
    </div>


<!-- <div class="row">
    <?php 
        //if (isset($boards) && !empty($boards)) {
        $i = 1; 
    ?>
    <?php //foreach ($boards as $board): ?>
   <div class="col-md-6 col-sm-12">
        <div class="portlet green box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>Organization Name
                </div>
                <div class="actions">
                    <a href="javascript:;" class="btn btn-circle btn-default btn-sm">
                    <i class="fa fa-eye"></i> View details </a> 
                    <a href="javascript:;" class="btn btn-circle btn-default btn-sm">
                    <i class="fa fa-pencil"></i> Edit </a>
                    <a href="javascript:;" class="btn btn-circle btn-default btn-sm">
                    <i class="fa  fa-times"></i> Delete </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Board Name
                    </div>
                    <div class="col-md-7 value">
                         Web                   
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Branch:
                    </div>
                    <div class="col-md-7 value">
                         One Platinum(Kathmandu Branch)                    
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Manager
                    </div>
                    <div class="col-md-7 value">
                         ajay maharjan                    
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Shift List:
                    </div>
                    <div class="col-md-7 value">
                         day shift, Night Shift                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        //}
        //else{
    ?>
        <div class="row static-info">No board List</div>
    <?php
        //}
    ?>
</div> -->

<div class="portlet green box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Department List
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse">
                                </a>
                                <a href="javascript:;" class="reload">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">
                                         S.N
                                    </th>
                                    <th scope="col">
                                         Department Name
                                    </th>
                                    <th scope="col">
                                         Branch
                                    </th>
                                    <th scope="col">
                                        Manager
                                    </th>
                                    <th>
                                        No. Of Employee
                                    </th>
                                    <th scope="col">
                                        Shift List
                                    </th>
                                    <th scope="col">
                                         Action
                                    </th>
                                   
                                </tr>
                                </thead>
                                <tbody  id="departmentTable">
                                    <?php 
                                        if(isset($boards) && !empty($boards)){
                                        $i = 1;
                                    ?>
                                    <?php foreach ($boards as $board): ?>
                                        <tr id="<?php echo $board->Board->id; ?>">
                                            <td>
                                                 <?php echo $i++; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo URL_VIEW . 'boards/viewBoard?board_id=' . $board->Board->id; ?>"><?php echo $board->Board->title; ?></a>
                                            </td>
                                            <td>
                                                <?php echo $board->Branch->title; ?>
                                            </td>
                                            <td>
                                                <?php echo $board->User->fname.' '.$board->User->lname; ?>
                                            </td>
                                            <td>
                                                <?php echo $board->noOfBoardUser; ?>
                                            </td>
                                            <td>
                                                <?php $j = 0; 
                                                    foreach($board->ShiftBoard as $shift):
                                                        echo ($j != 0)?', ':'';
                                                        echo $shift->Shift->title;
                                                    $j++;
                                                    endforeach;
                                                ?>
                                            </td>
                                            <td>
                     
                                              <a href="<?php echo URL_VIEW . 'boards/viewBoard?board_id=' . $board->Board->id; ?>" class="btn btn-xs yellow"><i class="fa fa-eye"></i>  View</a>
                                              <div class="editButton" data-boardId="<?php echo $board->Board->id; ?>"><a href="#portlet-config_1_<?php echo $board->Board->id; ?>" class="btn btn-xs default btn-editable" data-toggle="modal" >
                                                            <i class="fa fa-pencil"></i> Edit  </a> </div>

                                                <button class="btn btn-xs red removeBoard" data-BoardId="<?php echo $board->Board->id;?>"> Remove </button>


                                            </td>
                                            
                                        </tr>
                                    <?php 
                                        endforeach;
                                        }
                                        else{
                                    ?>
                                        <tr id="emptyBoards">
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                                </table>
                            <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                <?php
                                $page=$currentPage;
                                $max=$totalPage;
                                ?>
                                <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                <ul class="pagination" style="visibility: visible;">
                                    <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="First" href="?page4=1"><i class="fa fa-angle-double-left"></i></a>
                                        <?php } ?>
                                    </li>
                                    <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                            <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="Prev" href="?page4=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                        <?php } ?>
                                    </li>

                                    <?php if($max<=5){
                                        for($i=1;$i<=$max;$i++){ ?>
                                            <li>
                                                <a title="<?=$i;?>" href="?page4=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                        <?php }}else{
                                        if(($page-2)>=1 && ($page+2)<=$max){
                                            for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                <li>
                                                    <a title="<?=$i;?>" href="?page4=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                            <?php  }}elseif(($page-2)<1){
                                            for($i=1;$i<=5;$i++){ ?>
                                                <li>
                                                    <a title="<?=$i;?>" href="?page4=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                            <?php }}elseif(($page+2)>$max){
                                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                                <li>
                                                    <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page4=<?=$i?>"><?=$i;?></a>
                                                </li>
                                            <?php }}} ?>

                                    <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                        <?php if($page>=$max){ ?>
                                            <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                        <?php }else{ ?>
                                            <a title="Next" href="?page4=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                        <?php } ?></li>
                                    <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                        <?php if($max==0 || $max==1){ ?>
                                            <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                        <?php }else{ ?>
                                            <a title="Last" href="?page4=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                        <?php } ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
    
    <?php 
if($totalPage >1){
    $previousPage = $currentPage-1;
    $nextPage = $currentPage+1;
    ?>
<div class="paginator">
            <ul>
                <li>
                     <?php if($currentPage == 1){?>
                    <div class="deactive"><</div>
                    <?php }else{?>
                    <a class="no-underline" href="<?php echo URL_VIEW . 'boards/listBoards?org_id=' . $orgId.'&page='.$previousPage; ?>"><</a></li>
                    <?php }?>
                        <?php  for($i=1; $i<=$totalPage; $i++){?>
                    <li><a class="<?php echo ($currentPage==$i)? 'active':'';?>" href="<?php echo URL_VIEW . 'boards/listBoards?org_id=' . $orgId.'&page='.$i; ?>"><?php echo $i;?></a></li>
                 <?php  }?>
                <li>
                    <?php if($totalPage == $currentPage){?>
                    <div class="deactive">></div>
                    <?php }else{?>
                    <a class="no-underline" href="<?php echo URL_VIEW . 'boards/listBoards?org_id=' . $orgId.'&page='.$nextPage; ?>">></a></li>
                    <?php }?>
            </ul>
        </div>
<?php }
     ?>
 
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>

<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/ui-alert-dialog-api.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/table-advanced.js"></script>
<script>
$(function(){
    var orgId = '<?php echo $orgId; ?>';
   $("#addBoardForm").on('submit',function(event){
        event.preventDefault();
        var ev = $(this);
        
        var data = $(this).serialize();
        // var testss = '<?php echo URL."Boards/createBoardwithdata/"."'+orgId+'".".json" ?>';
        // console.log(testss);
        $.ajax({
            url : '<?php echo URL."Boards/createBoardwithdata/"."'+orgId+'".".json"; ?>',
            type : "post",
            data : data,
            datatype : "jsonp",
            success:function(response)
            {
                console.log(response);
                var boardLists = "";
                $.each(response.output.boards,function(i,v){
                    console.log(v);
                    if(v.User.id != null || v.User.id != null)
                    {
                        var boardUser = v.User.fname+' '+v.User.lname;
                    }
                    else
                    {
                       var boardUser = '--'; 
                    }

                    boardLists = '<tr><td>1</td><td><a href="<?php echo URL_VIEW; ?>boards/viewBoard?board_id='+v.Board.id+'">'+v.Board.title+'</a></td><td>'+v.Branch.title+'</td><td>'+boardUser+'</td><td>'+v.noOfBoardUser+'</td><td>--</td><td><a href="<?php echo URL_VIEW; ?>boards/viewBoard?board_id='+v.Board.id+'" class="btn btn-xs yellow"><i class="fa fa-eye" ></i>  View</a><div class="editButton" data-boardId="'+v.Board.id+'"><a href="#portlet-config_1_'+v.Board.id+'" class="btn btn-xs default btn-editable" data-toggle="modal"><i class="fa fa-pencil"></i> Edit  </a></div></td></tr>';
                   // console.log(boardLists);
                    toastr.success('Recorded Added Successfully');
                    $('#departmentTable tr').each(function(i, el) {
                        var obj = $(this).find('td').eq(0);
                        var newNumber = parseInt(obj.text())+1;
                            obj.text(newNumber);
                    });
                    $("#emptyBoards").remove();
                    $("#departmentTable").prepend(boardLists);
                    ev.find('.addclear').click();
                    ev.find('.addclose').click();
                    ev.closest('.modal-dialog').find('.addclose').click();
                });

            }
        });
    });
    $(".editButton").live('click',function(){
        var board__id = $(this).attr('data-boardId');
        $.ajax
        ({
            url : '<?php echo URL."Boards/editBoardData/"."'+orgId+'"."/"."'+board__id+'".".json"; ?>',
            datatype : "jsonp",
            success:function(response)
            {
                console.log(response);
                var data = response.output.Board.id;
                var option = "";
                var userIdcom = "";
                var branchList = "";
                var branchoption = "";
                $.each(response.orguser,function(e,i){
                    if (response.output.Board.user_id == i.User.id) {
                        userIdcom = 'selected="selected"';
                    }
                    else{
                        userIdcom =  '';
                    }
                    if(i.User.fname != null){
                        option += '<option value="'+i.User.id+'"'+userIdcom+'>'+i.User.fname+' '+i.User.lname+'</option>';
                    }
                });
                $.each(response.branchList,function(i,j){
                    
                    if(response.output.Board.branch_id == j.Branch.id){
                        branchList = 'selected="selected"';
                    }else{
                        branchList = '';
                    }
                    if(j.Branch.title != null){
                       branchoption += '<option value="'+j.Branch.id+'"'+branchList+'>'+j.Branch.title+'</option>'; 
                    }
                    //console.log(branchoption);
                });
                var board = response.output.Board.title;
                var boardid = response.output.Board.id;
                bootbox.dialog({
                            title: "Edit Department",
                            message:'<form action="" id="editBoardForm" data-boardids="'+boardid+'" method="post" accept-charset="utf-8" class="form-horizontal">' +
                                    
                                    
                                    '<div class="form-group">'+
                                        '<label class="control-label col-md-4">Manager <span class="required">'+
                                        '* </span>'+
                                        '</label>'+
                                        '<div class="col-md-7">'+
                                            '<select name="data[Board][user_id]" class="form-control">'+
                                            '<option value="0">Assign Later</option>'+
                                            option+
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label col-md-4">Branch <span class="required">'+
                                        '* </span>'+
                                        '</label>'+
                                        '<div class="col-md-7">'+
                                            '<select name="data[Board][branch_id]" class="form-control">'+
                                            branchoption+
                                            '</select>'+ 
                                        '</div>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label class="control-label col-md-4">Department Name <span class="required">'+
                                        '* </span>'+
                                        '</label>'+
                                        '<div class="col-md-7">'+
                                            '<input class="form-control" name="data[Board][title]" value="'+board+'" type="text"/>'+
                                        '</div>'+
                                    '</div>'+
                                    '<input type="submit" name="submit" value="Update" class="btn btn-success" />'+
                                    '<input type="reset" name="clear" value="Clear" class="editclear btn default">'+
                                '</form>' 
                        });
            }
        });
    });
    $("#editBoardForm").live('submit',function(ev){
        ev.preventDefault();
        var e = $(this);
        var data = $(this).serialize();
        var boardids = $(this).attr('data-boardids');
        
        $.ajax({
            url : '<?php echo URL."Boards/editBoardwithdata/"."'+boardids+'"."/"."'+orgId+'".".json"; ?>',
            type : "post",
            data : data,
            datatype : "jsonp",
            success:function(response)
            {
                   window.location.reload(true);
                   toastr.success('Recorded Updated Successfully');
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

    UIAlertDialogApi.init();

   $(".removeBoard").on('click', function(event)
    {
        var e = $(this);
        var boardId = $(this).attr('data-boardId');
        bootbox.confirm("Are you sure you want to remove?", function(result) {
                      if(result === true)
                      {
                         var url = '<?php echo URL;?>Boards/removeBoard/'+boardId+'.json';

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
                                        toastr.success('The board has been removed.');
                                    }
                                }
                            });
                      }
                    }); 
    });
   TableAdvanced.init();

   
  
});
</script>

