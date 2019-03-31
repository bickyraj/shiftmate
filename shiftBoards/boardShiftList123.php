<?php


$boardId = $_GET['board_id'];

if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}

if(isset($_POST['edit_submit'])){
     $url = URL . "ShiftBoards/editShiftBoardType.json";
        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();   
}


if (isset($_POST["submit"])) {
    if(!empty($_POST['data']))
    {
        // fal($_POST);
        $url = URL . "ShiftBoards/assignShiftToBoard/".$boardId.".json";
        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();

        // fal($response);
        if($response->body->output->status == '1')
        {
            echo("<script>location.href = '".URL_VIEW."shiftBoards/boardShiftList?org_id=".$orgId."&board_id=".$boardId."';</script>");

            $_SESSION['success']="test";
        }
    }
}



$url = URL."ShiftBoards/boardShiftList/".$boardId."/".$page.".json";
$data = \Httpful\Request::get($url)->send();
$BoardShifts = $data->body->boardShifts;
$totalPage = $data->body->output->pageCount;
$currentPage = $data->body->output->currentPage;

$url = URL."Boards/getBranchIdFromBoardId/".$boardId.".json";
$data = \Httpful\Request::get($url)->send();
$branchId = $data->body->branchId;




$url = URL."ShiftBoards/getShiftListNotInBoard/".$boardId."/".$branchId.".json";
$data = \Httpful\Request::get($url)->send();
$shiftsBoard = $data->body->shiftNotInBoard;
// echo "<pre>";
// print_r($data->body);
// die();

$url = URL."Boards/viewBoard/".$boardId.".json";
$data = \Httpful\Request::get($url)->send();
$board = $data->body->board;

// echo "<pre>";
// print_r($board);


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
                    <a href="#">View Shift List</a>
                </li>
            </ul>
            
<div class="row">
    <div class="modal fade" id="portlet-config_12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Add Shift</h4>
              </div>
              <form action="" id="BoardAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                    </div>
              <div class="modal-body">
                  
                    <div class="form-body">     
                       <?php if(!empty($shiftsBoard)):?>  
                        
                            <?php foreach($shiftsBoard as $shifts):?>
                                <div class="md-checkbox">
                                <input type="checkbox" id="checkbox<?php echo $shifts->Shift->id; ?>" class="md-check" name="data[ShiftBoard][<?=$shifts->Shift->id;?>][shift_id]" value="<?php echo $shifts->Shift->id;?>" />
                                    <label for="checkbox<?php echo $shifts->Shift->id; ?>">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            <?php echo $shifts->Shift->title;?> 
                                            </label>
                                        </div>
                                       <script>
                                            $(function(){
                                                var radios = '<div class="md-radio-inline">'+
            										'<div class="md-radio">'+
            											'<input type="radio" id="<?=$shifts->Shift->id;?>_1" name="data[ShiftBoard][<?=$shifts->Shift->id;?>][shift_type]" class="md-radiobtn" value="0"/>'+
            											'<label for="<?=$shifts->Shift->id;?>_1">'+
            											'<span class="inc"></span>'+
            											'<span class="check"></span>'+
            											'<span class="box"></span>'+
   											         'Close </label>'+
            										'</div>'+
            										'<div class="md-radio">'+
            											'<input type="radio" checked="checked" id="<?=$shifts->Shift->id;?>_2" name="data[ShiftBoard][<?=$shifts->Shift->id;?>][shift_type]" class="md-radiobtn" value="1"/>'+
            											'<label for="<?=$shifts->Shift->id;?>_2">'+
            											'<span class="inc"></span>'+
            											'<span class="check"></span>'+
            											'<span class="box"></span>'+
   											         'Open </label>'+
            										'</div>'+
            									'</div>';
                                                $('#checkbox<?php echo $shifts->Shift->id; ?>').change(function(){
                                                    if(this.checked){
                                                        $(this).closest('.md-checkbox').append(radios);
                                                    }else{
                                                       $(this).closest('.md-checkbox').find('.md-radio-inline').remove(); 
                                                    }
                                                })
                                            });
                                       </script>
                            <?php endforeach;?>
                            <?php else:?>
                            <div class="empty_list">Sorry, no shifts are available.</div>
                        <?php endif;?>
                       
                    </div>
                </div>
                       <div class="modal-footer">
                        
                            <div class="col-md-offset-3 col-md-9">
                                <input  type="submit" name="submit" value="Submit" class="btn green"/>
                                <input type="reset" name="cancel" value="Close" class="btn default" data-dismiss="modal" />
                            </div>
                      </div>
                </form>
             
          </div>
          <!-- /.modal-content -->
      </div>
                    <!-- /.modal-dialog -->
    </div>
    <div class="col-md-2" align="center">
        <div class="well">
           
            <h4 class="block"><a class="btn btn-default btn-sm" href="#portlet-config_12" class="news-block-btn" data-toggle="modal" class="config">
                        <i class="fa fa-plus"></i></a></h4>
            
        </div>
    </div>
        <?php if(isset($BoardShifts)):?>
        <?php $i = 1; ?>
        <?php foreach ($BoardShifts as $BoardShift): ?>
        <div class="col-md-2" align="center">
        <div class="well" style="padding-right: 15px;padding-left:15px;height:220px;overflow-x: hidden;overflow-y: scroll;">
            <a class="btn btn-default btn-sm" href="#edit_shift_type_<?=$BoardShift->ShiftBoard->id;?>" class="news-block-btn" data-toggle="modal" class="config">
                        <i class="fa fa-edit"></i></a>          
            <h4 class="block"><?php echo $BoardShift->Shift->title; ?></h4>
            <h6 class="block"><?php if($BoardShift->ShiftBoard->shift_type == 0){echo "Close";}elseif($BoardShift->ShiftBoard->shift_type == 1){echo "Open";}?></h6>
            <p>
                <?php 
                    $start_time = $BoardShift->Shift->starttime;;
                    $end_time = $BoardShift->Shift->endtime;
                    $startTime = explode(':', $start_time);
                    $endTime = explode(':', $end_time);
                     if ($startTime[1] == '00' && $endTime[1] == '00') {
                           echo (date("g a", strtotime($start_time))).' - '.(date("g a", strtotime($end_time)));
                        }
                        else if ($startTime[1] != '00' && $endTime[1] == '00') {
                            echo (date("g:i a", strtotime($start_time))).' - '.(date("g a", strtotime($end_time)));
                        }
                         else if ($startTime[1] == '00' && $endTime[1] != '00') {
                          echo (date("g a", strtotime($start_time))).' - '.(date("g:i a", strtotime($end_time)));
                        }
                        else{
                        echo (date("g:i a", strtotime($start_time))).' - '.(date("g:i a", strtotime($end_time)));
                    }
                    //echo hisToTime($shift->Shift->starttime);

                ?>
                <br />
                 <?php //echo hisToTime($shift->Shift->endtime); ?> 
            </p>              
        </div>
        </div>
<div class="modal fade" id="edit_shift_type_<?=$BoardShift->ShiftBoard->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Update Shift</h4>
              </div>
              <form action="" id="BoardAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                    </div>
              <div class="modal-body">
                <div class="form-body"> 
                    <input type="hidden" value="<?=$BoardShift->ShiftBoard->id;?>" name="data[ShiftBoard][id]"/>
                    <div class="md-radio-inline">
						<div class="md-radio">
							<input type="radio" <?php if($BoardShift->ShiftBoard->shift_type == 0){echo "checked";}?> id="<?=$BoardShift->ShiftBoard->id;?>_3" name="data[ShiftBoard][shift_type]" class="md-radiobtn" value="0"/>
							<label for="<?=$BoardShift->ShiftBoard->id;?>_3">
							<span class="inc"></span>
							<span class="check"></span>
							<span class="box"></span>
				         Close </label>
						</div>
						<div class="md-radio">
							<input type="radio" <?php if($BoardShift->ShiftBoard->shift_type == 1){echo "checked";}?> id="<?=$BoardShift->ShiftBoard->id;?>_4" name="data[ShiftBoard][shift_type]" class="md-radiobtn" value="1"/>
							<label for="<?=$BoardShift->ShiftBoard->id;?>_4">
							<span class="inc"></span>
							<span class="check"></span>
							<span class="box"></span>
				         Open </label>
						</div>
					</div>
                </div>
              </div>
              <div class="modal-footer">
                <div class="col-md-offset-3 col-md-9">
                    <input  type="submit" name="edit_submit" value="Update" class="btn green"/>
                    <input type="reset" name="cancel" value="Close" class="btn default" data-dismiss="modal" />
                </div>
              </div>
            </form>
             
          </div>
      </div>
</div>
        <?php endforeach; ?>
        <?php else:?>

            <div class="empty_list">No Shifts Added.</div>
        <?php endif;?>
    
</div>

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
                                                <a title="First" href="?board_id=<?=$_GET['board_id']?>&page=1"><i class="fa fa-angle-double-left"></i></a>
                                            <?php } ?>
                                        </li>
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                            <?php if($page<=1){ ?>
                                                <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                            <?php }else{ ?>
                                                <a title="Prev" href="?board_id=<?=$_GET['board_id']?>&page=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                            <?php } ?>
                                        </li>

                                        <?php if($max<=5){
                                            for($i=1;$i<=$max;$i++){ ?>
                                                <li>
                                                    <a title="<?=$i;?>" href="?board_id=<?=$_GET['board_id']?>&page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                            <?php }}else{
                                            if(($page-2)>=1 && ($page+2)<=$max){
                                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                    <li>
                                                        <a title="<?=$i;?>" href="?board_id=<?=$_GET['board_id']?>&page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                    </li>
                                                <?php  }}elseif(($page-2)<1){
                                                for($i=1;$i<=5;$i++){ ?>
                                                    <li>
                                                        <a title="<?=$i;?>" href="?board_id=<?=$_GET['board_id']?>&page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                    </li>
                                                <?php }}elseif(($page+2)>$max){
                                                for ($i=($max-4);$i<=$max;$i++){ ?>
                                                    <li>
                                                        <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?board_id=<?=$_GET['board_id']?>&page=<?=$i?>"><?=$i;?></a>
                                                    </li>
                                                <?php }}} ?>

                                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                            <?php if($page>=$max){ ?>
                                                <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                            <?php }else{ ?>
                                                <a title="Next" href="?board_id=<?=$_GET['board_id']?>&page=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                            <?php } ?></li>
                                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                            <?php if($max==0 || $max==1){ ?>
                                                <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                            <?php }else{ ?>
                                                <a title="Last" href="?board_id=<?=$_GET['board_id']?>&page=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                            <?php } ?></li>
                                    </ul>
                                <?php } ?>
                            </div>
















<!-- Success Div -->
<!-- <div id="save_success">Saved Successfully !!</div> -->
<!-- End of Success Div -->

<!-- <div class="tableHeader">

    
        <a href="<?php echo URL_VIEW . 'shiftBoards/assignShiftToBoard?board_id='.$boardId; ?>"><button class="addBtn">Add Shift To Board</button></a>
    
    <div class="clear"></div> -->

    <!-- Table -->
   <!--  <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>SN</p></th>
        <th><p>Shift Name</p></th>
        <th><p>Start Time</p></th>
        <th><p>End Time</p></th>
        
        <th><p>Action</p></th>

        </tr>

        <?php if(isset($BoardShifts)):?>
                <?php $i = 1; ?>
                <?php foreach ($BoardShifts as $BoardShift): ?>
                    <tr class="list_users">
                        <td><?php echo $i++; ?><input class="listShift-checkbox" type="checkbox"/></td>
                        <td><?php echo $BoardShift->Shift->title; ?></td>
                        <td><?php echo $BoardShift->Shift->starttime; ?></td>
                        <td><?php echo $BoardShift->Shift->endtime; ?></td>
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

            <div class="empty_list">No Shifts Added.</div>
        <?php endif;?>
        </table> -->
    <!-- End of Table -->
    
    <?php 
            // if($totalPage >1){
            //     $previousPage = $currentPage-1;
            //     $nextPage = $currentPage+1;
                ?>
           <!--  <div class="paginator">
                        <ul>
                            <li>
                                 <?php if($currentPage == 1){?>
                                <div class="deactive"><</div>
                                <?php }else{?>
                                <a class="no-underline" href="<?php echo URL_VIEW . 'shiftBoards/boardShiftList?board_id=' . $boardId.'&page='.$previousPage; ?>"><</a></li>
                                <?php }?>
                                    <?php  for($i=1; $i<=$totalPage; $i++){?>
                                <li><a class="<?php echo ($currentPage==$i)? 'active':'';?>" href="<?php echo URL_VIEW . 'shiftBoards/boardShiftList?board_id=' . $boardId.'&page='.$i; ?>"><?php echo $i;?></a></li>
                             <?php  }?>
                            <li>
                                <?php if($totalPage == $currentPage){?>
                                <div class="deactive">></div>
                                <?php }else{?>
                                <a class="no-underline" href="<?php echo URL_VIEW . 'shiftBoards/boardShiftList?board_id=' . $boardId.'&page='.$nextPage; ?>">></a></li>
                                <?php }?>
                        </ul>
                    </div> -->
            <?php //}
                 ?>