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
// fal($totalPage);
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
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Modal title</h4>
                        </div>
                        <div class="modal-body">
                             Widget settings form goes here
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn blue">Save changes</button>
                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN PAGE BREADCRUMB -->
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
            <!-- END PAGE BREADCRUMB -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="fa fa-list theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Department List</span>
                                <!-- <span class="caption-helper hide">weekly stats...</span> -->
                            </div>
                            <a class="btn btn-fit-height green dropdown-toggle pull-right" href="#portlet-config_1" class="news-block-btn" data-toggle="modal" class="config"><i class="fa fa-plus"></i> Add New Department </a>
                        </div>
                        <div class="portlet-body">
                            <div class="row margin-bottom-40">
                                <div class="col-md-12">
                                    <div class="table-scrollable table-scrollable-borderless">
                                        <table class="table table-light table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Sn
                                                </th>
                                                <th>
                                                    Department Name
                                                </th>
                                                <th>
                                                    Branch
                                                </th>

                                                <th>
                                                    Manager
                                                </th>

                                                <th>
                                                    No. Of Employee
                                                </th>

                                                <th>
                                                    Shift List
                                                </th>

                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody id="departmentTable">
                                                <?php 
                                                    if(isset($boards) && !empty($boards)){
                                                    $i = 1;
                                                ?>
                                                <?php foreach ($boards as $board): ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i++; ?>
                                                </td>
                                                <td class="hidden-xs">
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
                                                     if(isset($board->ShiftBoard) && !empty($board->ShiftBoard)){
                                                        foreach($board->ShiftBoard as $shift):
                                                        echo ($j != 0)?', ':'';
                                                        if(isset($shift->Shift) && !empty($shift->Shift)){
                                                            echo $shift->Shift->title;
                                                        }
                                                        
                                                        $j++;
                                                        endforeach;
                                                     }
                                                    
                                                ?>
                                                </td>
                                                <td class="listBoardAction">
                                                    <a data-container="body" data-placement="top" data-original-title="Details" href="<?php echo URL_VIEW . 'boards/viewBoard?board_id=' . $board->Board->id; ?>" class="text-default tooltips"><i class="fa fa-desktop"></i></a>

                                                    <a data-container="body" data-placement="top" data-original-title="Edit" href="#portlet-config_1_<?php echo $board->Board->id; ?>" class="text-success editButton tooltips" data-boardId="<?php echo $board->Board->id; ?>" data-toggle="modal" ><i class="fa fa-pencil"></i></a>

                                                    <a data-container="body" data-placement="top" data-original-title="Remove" class="text-danger removeBoard tooltips" data-BoardId="<?php echo $board->Board->id;?>"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                            <?php 
                                                endforeach;
                                                }
                                            ?>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END INLINE NOTIFICATIONS PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
        <!-- BEGIN PAGE CONTENT -->
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
    </div>
    


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
                var status = response.output.status;
                var boardLists = "";
                if(status == 2){
                    toastr.info('Department already exist.Please try again.');
                } else if(status == 1) {
                    $.each(response.output.boards,function(i,v){
                        if(v.User.id != null || v.User.id != null)
                        {
                            var boardUser = v.User.fname+' '+v.User.lname;
                        }
                        else
                        {
                           var boardUser = '--'; 
                        }

                        boardLists = '<tr><td>1</td><td><a href="<?php echo URL_VIEW; ?>boards/viewBoard?board_id='+v.Board.id+'">'+v.Board.title+'</a></td><td>'+v.Branch.title+'</td><td>'+boardUser+'</td><td>'+v.noOfBoardUser+'</td><td>--</td><td class="listBoardAction"><a href="<?php echo URL_VIEW; ?>boards/viewBoard?board_id='+v.Board.id+'" class="text-default"><i class="fa fa-desktop" ></i></a><a href="#portlet-config_1_'+v.Board.id+'" class="text-success editButton" data-toggle="modal" data-boardId="'+v.Board.id+'"><i class="fa fa-pencil"></i></a><a class="text-danger removeBoard" data-BoardId="'+v.Board.id+'"><i class="fa fa-times"></i> </a></td></tr>';
                       // console.log(boardLists);
                        toastr.success('Recorded Added Successfully');
                        $('#departmentTable tr').each(function(i, el) {
                            var obj = $(this).find('td').eq(0);
                            var newNumber = parseInt(obj.text())+1;
                                obj.text(newNumber);
                        });
                        $("#emptyBoards").remove();
                        $("#departmentTable").prepend(boardLists);
                        
                    });
                } else {
                    toastr.info("Something went wrong.Please try again.")
                }
                    ev.find('.addclear').click();
                    ev.find('.addclose').click();
                    ev.closest('.modal-dialog').find('.addclose').click();    
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
                var status = response.output;
                if(status == 1){
                    toastr.success('Recorded Updated Successfully');
                    window.location.reload(true);
                } else if(status == 2){
                    toastr.info("Department already exist.Please try again.");
                } else {
                    toastr.info("Something went wrong.Please try again.");
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

    UIAlertDialogApi.init();

   $(".removeBoard").live('click', function(event)
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

