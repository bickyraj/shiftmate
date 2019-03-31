
<link href="<?php echo URL_VIEW; ?>admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>
<?php

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$homeBoard = URL_VIEW.'boards/listBoards?org_id='.$orgId;

$boardId = $_GET['board_id'];

$url = URL."Boards/viewBoard/".$boardId."/".$page.".json";
$data = \Httpful\Request::get($url)->send();
$board = $data->body->board;
// fal($board);

$totalPage = $data->body->output->pageCount;
$currentPage = $data->body->output->currentPage;

// fal($board);

// echo "<pre>";
// print_r($board);die();
// $url = URL. "Boards/editBoard/" . $boardId . ".json";
// $data = \Httpful\Request::get($url)->send();
// $board = $data->body->board;


//Get User list related to particular organization
$url = URL. "OrganizationUsers/getOrganizationUsers/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$organizationUsers = $data->body->organizationUsers;

//get branch list related to particular organization
$url = URL. "Branches/orgBranches/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;
// fal($branches);

?>

<div class="modal fade" id="portlet-config_14" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="editclose close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Department</h4>
            </div>
              <form action="" id="editBoardForm" method="post" accept-charset="utf-8" class="form-horizontal">
                  <input type="hidden" name="_method" value="POST"/>
                  <!-- <input type="hidden" name="data[Board][board_id]" value="<?php echo $board->Board->id;?>"> -->
                  <div class="row">
                    <div class="modal-body">
                         <div class="form-group">
                            <label class="control-label col-md-4">User <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <select name="data[Board][user_id]" class="form-control">
                                    <?php foreach($organizationUsers as $organizationUser):?>
                                    <option value="<?php echo $organizationUser->User->id;?>" <?php echo ($board->Board->user_id == $organizationUser->User->id)? 'selected="selected"':'';?>><?php echo $organizationUser->User->fname.' '.$organizationUser->User->lname;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-4">Branch <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-7">
                                    <select name="data[Board][branch_id]" class="form-control">
                                       <?php foreach($branches as $branche):?>
                                        <option value="<?php echo $branche->Branch->id;?>" <?php echo ($board->Board->branch_id == $branche->Branch->id)? 'selected="selected"':'';?>><?php echo $branche->Branch->title;?></option>
                                        <?php endforeach;?>
                                    </select>    
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Department Name <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" name="data[Board][title]" value="<?php echo $board->Board->title;?>" type="text"/>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <div class="col-md-offset-3 col-md-9">
                      <input type="submit" name="edit" value="Update" class="btn green">
                      <input type="reset" name="clear" value="Clear" class="editclear btn default">
                      <!-- <a class="btn default" href="<?php echo URL_VIEW."groups/listGroups?org_id=".$orgId;?>">Cancel</a> -->
                    </div>
                  </div>
              </form>
        </div>   
      </div>                       
            <!-- <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
            </div> -->
        
        <!-- /.modal-content -->
</div>
                                  

<!-- Edit-->

<div class="page-head">
  <div class="container">
    <div class="page-title">
      <h1><?php echo $board->Board->title; ?> Department <small><?php echo $board->Branch->title; ?> Branch <!--List Department Employees--></small></h1>
	  </div>  
  </div>
</div>

<div class="page-content">
  <div class="container">
      <ul class="page-breadcrumb breadcrumb">
          <li>
              <i class="fa fa-home"></i>
              <a href="<?=URL_VIEW;?>">Home</a>
              <i class="fa fa-circle"></i>
          </li>
          <li>
              <a href="<?=URL_VIEW."boards/listBoards";?>">Departments</a>
              <i class="fa fa-circle"></i>
          </li>
          <li>
              <a href="javascript:;">view Department</a>
          </li>
      </ul>

      <div class="row">
          <div class="col-md-6 col-sm-12">
              <div class="portlet light" style="height:220px;">
                  <div class="portlet-title">
                      <div class="caption">
                        <i class="fa fa-user font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp uppercase"> Manager</span>
                      </div>
                      <div class="actions">
                          <a href="#portlet-config_14" class="btn btn-default btn-sm" data-toggle="modal">
                                          <i class="fa fa-pencil"></i> Edit Department  </a>
                      </div>
                  </div>
                  <!-- <div class="portlet-body">
                      <div class="row static-info">
                          <div class="col-md-5 name">
                             <?php
                                  $userimage = URL.'webroot/files/user/image/'.$board->User->image_dir.'/thumb2_'.$board->User->image;
                                  $image = $board->User->image;
                                  $gender = $board->User->gender;
                                  $user_image = imageGenerate($userimage,$image,$gender);
                            ?>
                            <img src="<?php echo $user_image; ?>" width="60" height="60" alt="image not found"/>
                          </div>
                      </div>
                      <div class="row static-info">
                          <div class="col-md-5 name">
                               Manager
                          </div>
                          <div class="col-md-7 value">
                               <?php echo $board->User->fname.' '.$board->User->lname;?>                    
                          </div>
                      </div>
                      <div class="row static-info">
                          <div class="col-md-5 name">
                               Department Name:
                          </div>
                          <div class="col-md-7 value">
                               <?php echo $board->Board->title;?>                   
                          </div>
                      </div>                
                      <div class="row static-info">
                          <div class="col-md-5 name">
                               Shift List:
                          </div>
                          <div class="col-md-7 value">
                               <?php $j = 0; 
                                  foreach($board->ShiftBoard as $shift):
                                      echo ($j != 0)?', ':'';
                                      echo $shift->Shift->title;
                                  $j++;
                                  endforeach;?>                    
                          </div>
                      </div>
                  </div> -->

                  <div class="portlet-body">
                    <div class="row">
                      <div class="col-md-3">
                        <a href="javascript:;" class="thumbnail">
                        <img src="<?php echo $user_image; ?>" alt="100%x180" style="width:100%; display: block;">
                        </a>
                      </div>
                      <div class="col-md-9">
                        <div class="row static-info">
                          <div class="col-md-5" style="color:#6B6B6B;">
                               Name
                          </div>
                          <div class="col-md-7">
                               <?php echo $board->User->fname.' '.$board->User->lname;?>                    
                          </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5" style="color:#6B6B6B;">
                                 Department
                            </div>
                            <div class="col-md-7">
                                 <?php echo $board->Board->title;?>                   
                            </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5" style="color:#6B6B6B;">
                                 Email
                            </div>
                            <div class="col-md-7">
                                 <?php echo $board->User->email;?>                   
                            </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5" style="color:#6B6B6B;">
                                 Phone No.
                            </div>
                            <div class="col-md-7">
                                 <?php echo (!empty($board->User->phone))?$board->User->phone:"--";?>                   
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
          <div class="col-md-6 col-sm-12">
              <div class="portlet light" style="height:220px;">
                  <div class="portlet-title">
                      <div class="caption">
                        <i class="fa fa-building font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp uppercase">Overview</span>
                      </div>
                  </div>
                  <div class="portlet-body">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="row list-separated">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                              <div class="uppercase profile-stat-title">
                                 <?php echo count($board->BoardUser);?>
                              </div>
                              <div class="uppercase profile-stat-text">
                                 Members
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                              <div class="uppercase profile-stat-title">
                                 <?php echo count($board->ShiftBoard);?>
                              </div>
                              <div class="uppercase profile-stat-text">
                                 Shifts
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-8">
                            <h4>Shift list</h4>
                            <p>
                            <div class="scroller" style="height:90px;">
                            <?php if(isset($board->ShiftBoard) && !empty($board->ShiftBoard)):?>
                              <?php foreach($board->ShiftBoard as $shift):?>
                              <div style="margin:2px; display:inline-block;">
                                <span class="label label-sm label-primary"><?php echo $shift->Shift->title;?></span>
                              </div>
                              <?php endforeach;?>
                            <?php else:?>
                              <span>No shift created on this department.</span>
                            <?php endif;?>
                            </div>
                            </p>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="portlet light">
              <div class="portlet-title">
                <div class="caption">
                  <i class="fa fa-group font-green-sharp"></i>
                  <span class="caption-subject font-green-sharp uppercase"><?php echo $board->Board->title; ?> Department </span><small>employee list</small>
                </div>
                 <div class="actions pull-right">
                      <form id="searchForm" class="form-inline" role="form" action="" method="post">
                          <span style="color:grey">Filter Employee :</span>
                        
                          <div class="form-group">
                              <input id="username" name="username" value="" type="text" class="form-control input-sm" placeholder="Enter Employee Name" required>
                          </div>
                      </form>
                  </div>
              </div>
                 
              <div class="portlet-body">
                <div class="table-scrollable table-scrollable-borderless">
                  <table class="table table-hover table-light">
                  <thead>
                    <tr class="uppercase">
                      <th colspan="2">
                         Employee Name
                      </th>
                      <th>
                         Address
                      </th>
                      <th>
                         Email
                      </th>
                      <th>Contact no.</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="employeeTwo" style="display:none;">

                  </tbody>
                  <tbody id="employeeOne">
                    <?php
                         if(isset($board) && !empty($board)){
                              foreach($board->BoardUser as $board){
                               // fal($board);
                        ?>
                    <tr boardUserId = <?php echo $board->BoardUser->id; ?>>
                      <td class="fit">
                        <?php
                                  $userimage = URL.'webroot/files/user/image/'.$board->User->image_dir.'/thumb2_'.$board->User->image;
                                  $image = $board->User->image;
                                  $gender = $board->User->gender;
                                  $user_image = imageGenerate($userimage,$image,$gender);
                          ?>
                          <img class="user-pic" src="<?php echo $user_image; ?>" width="40px" alt="image not found" style="height:40px;"/>

                      </td>
                      <td>
                        <a href="<?php echo URL_VIEW.'organizationUsers/organizationEmployeeDetail?org_id='.$orgId.'&user_id='.$board->User->id;?>" class="primary-link"><?php echo $board->User->fname.' '.$board->User->lname; ?></a>
                      </td>
                      <td>
                            <?php echo (!empty($board->User->address))?$board->User->address:"--"; ?>
                          </td>
                          <td>
                            <?php echo (!empty($board->User->email))?$board->User->email:"--"; ?>
                          </td>
                          <td>
                              <?php echo (!empty($board->User->phone))?$board->User->phone:"--"; ?>
                      </td>
                      <td>
                          <span class="remove-user btn btn-sm btn-danger"><i class="fa fa-remove"></i> Remove</span>
                      </td>
                    </tr>
                    <?php }}else{?>
                      <tr style="height:40px;"><td colspan="3">No Department.</td></tr>
                    <?php } ?>
                  </tbody>
                  </table>
                </div>
              </div>

              <hr>

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
                                    <a title="First" href="?board_id=<?php echo $boardId;?>&page=1"><i class="fa fa-angle-double-left"></i></a>
                                <?php } ?>
                            </li>
                            <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                <?php if($page<=1){ ?>
                                    <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                <?php }else{ ?>
                                    <a title="Prev" href="?board_id=<?php echo $boardId;?>&page=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                <?php } ?>
                            </li>

                            <?php if($max<=5){
                                for($i=1;$i<=$max;$i++){ ?>
                                    <li>
                                        <a title="<?=$i;?>" href="?board_id=<?php echo $boardId;?>&page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                    </li>
                                <?php }}else{
                                if(($page-2)>=1 && ($page+2)<=$max){
                                    for($i=($page-2);$i<=($page+2);$i++){ ?>
                                        <li>
                                            <a title="<?=$i;?>" href="?board_id=<?php echo $boardId;?>&page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                        </li>
                                    <?php  }}elseif(($page-2)<1){
                                    for($i=1;$i<=5;$i++){ ?>
                                        <li>
                                            <a title="<?=$i;?>" href="?board_id=<?php echo $boardId;?>&page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
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
                                    <a title="Next" href="?board_id=<?php echo $boardId;?>&page=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                <?php } ?></li>
                            <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                <?php if($max==0 || $max==1){ ?>
                                    <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                <?php }else{ ?>
                                    <a title="Last" href="?board_id=<?php echo $boardId;?>&page=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                <?php } ?></li>
                        </ul>
                    <?php } ?>
              </div>
            </div>
          </div>
      </div>
  </div>
</div>


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
  var orgId = "<?php echo $orgId ;?>"; 
  var departmentId = "<?php echo $boardId ;?>";
  var timer;

  function ImageExist(url)
  {
    var img = new Image();
    img.src = url;
    return img.height != 0;
  }

    var boardUserId = 0;
    $('.remove-user').live('click',function(){
      var e =  $(this);
      boardUserId = e.closest('tr').attr('boardUserId');
      var url = '<?php echo URL; ?>BoardUsers/removeEmployee/'+boardUserId+'.json';
      $.ajax({
        url:url,
        type:'post',
        datatype:'jsonp',
        success:function(response){
          var status = response.output;
          bootbox.confirm("Are you sure you want to remove Employee?", function(result){
            if(result === true){
              if(status == 1){
                if(e.closest('tr').remove()){
                  removeStatus = 1;
                  toastr.success("User Successfully removed from this department");

                }
              } else {
                toastr.info("Something goes wrong, please try again");
              }
            }  
              
          });
        }  
      });
  });

  function filterEmployee(departmentId,username){
    var url = '<?php echo URL; ?>BoardUsers/filterByDepartment/'+departmentId+'/'+username+'.json';
    if(boardUserId != 0){
      $('#employeeOne tr[boardUserId="'+boardUserId+'"]').hide();
    }
    $.ajax({
      url:url,
      datatype:'jsonp',
      type:'post',
      success:function(response){
        var html = '';
        if(response.length == 0){
          html += '<tr><td>No records found</td></tr>';
        }
        $.each(response,function(key,val){
          if(ImageExist(val['User']['imagepath']) && val['User']['imagepath'] != ""){
              var imgurl = val['User']['imagepath'];
            }else{
              if(val['User']['gender']==0){
                var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/defaultuser.png";
              }else{
                var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/femaleadmin.png";
              }
            }
            
            html += '<tr boardUserId="'+val.BoardUser.id+'">';
            html += '<td class="fit"><img class="user-pic" src="'+imgurl+'" width="40px" alt="image not found" style="height:40px;"/></td>';
            html += '<td><a href="<?php echo URL_VIEW; ?>organizationUsers/organizationEmployeeDetail?org_id='+orgId+'&user_id='+val.User.id+'" class="primary-link">'+val.User.fname+' '+val.User.lname+'</a></td>';
            html += '<td>'+val.User.address+'</td>';
            html += '<td>'+val.User.email+'</td>';
            html += '<td>'+val.User.phone+'</td>';
            html += '<td><span class="remove-user btn btn-sm btn-danger"><i class="fa fa-remove"></i> Remove</span></td>';
            html += '</tr>';
        });

        $("#employeeTwo").html(html);
         if(username != '0'){
            $("#employeeOne").hide();
            $("#employeeTwo").show();
         } else {
            $("#employeeOne").show();
            $("#employeeTwo").hide();
         }

          
      }
    });
  }
 

  $('#username').on('keyup', function(e) {
      
      var username = $('#username').val();
      if(username == ''){
          username='0';    
      }
      console.log(username);
      clearTimeout(timer);
      timer = setTimeout(function (event) {
          
          filterEmployee(departmentId,username);           
      }, 600);

  });



</script>

<script>
// $(function(){
  // alert('h');
   
   $("#editBoardForm").on('submit',function(event){
        event.preventDefault();
         var orgId = '<?php echo $orgId; ?>';
         var boardid='<?php  echo $boardId; ?>';
        var ev = $(this);
        
        var data = $(this).serialize();
        // var testss = '<?php echo URL."Boards/createBoardwithdata/"."'+orgId+'".".json" ?>';
        // console.log(testss);
        $.ajax({
            url : '<?php echo URL."Boards/editBoardwithdata/"."'+boardid+'"."/"."'+orgId+'".".json"; ?>',
            type : "post",
            data : data,
            datatype : "jsonp",
            success:function(response)
            {   

                var status = response.output;
                if(status == 1){
                    toastr.success('Records Updated Successfully');
                    window.location.reload(true);
                } else if(status == 2){
                    toastr.info("Department already exist.Please try again.");
                } else {
                    toastr.info("Something went wrong.Please try again.");
                }
                
                ev.find('.editclear').click();
                ev.find('.bootbox-close-button').click();
                ev.closest('.modal-dialog').find('.bootbox-close-button').click();

            }
        });
    });
// });
</script>
<script>
jQuery(document).ready(function() {       
  
   TableAdvanced.init();
});
</script>