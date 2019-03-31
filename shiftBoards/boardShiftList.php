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
    // fal($_POST);
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
// fal($shiftsBoard);
// echo "<pre/>";
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
        
        <div class="row margin-top-10">
            <div class="col-md-12 col-sm-12">
                <div class="portlet light" style="min-height:400px;">
                    <div class="portlet-body">
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
                                                                <input type="checkbox" id="checkbox<?php echo $shifts->Shift->id; ?>" class="md-check shiftCheck" name="data[ShiftBoard][<?=$shifts->Shift->id;?>][shift_id]" value="<?php echo $shifts->Shift->id;?>" />
                                                                <label for="checkbox<?php echo $shifts->Shift->id; ?>">
                                                                        <span class="inc"></span>
                                                                        <span class="check"></span>
                                                                        <span class="box"></span>
                                                                        <?php echo $shifts->Shift->title;?> 
                                                                </label>
                                                                <div class="md-radio-inline ocDiv" style="display:none;" data-toggle="close">
                                                                    <div class="md-radio">
                                                                        <input type="radio" disabled id="<?php echo $shifts->Shift->id;?>_1" name="data[ShiftBoard][<?php echo $shifts->Shift->id;?>][shift_type]" class="md-radiobtn" value="0"/>
                                                                        <label for="<?php echo $shifts->Shift->id;?>_1">
                                                                        <span class="inc"></span>
                                                                        <span class="check"></span>
                                                                        <span class="box"></span>
                                                                        Close </label>
                                                                    </div>
                                                                    <div class="md-radio">
                                                                        <input type="radio" disabled checked="checked" id="<?php echo $shifts->Shift->id;?>_2" name="data[ShiftBoard][<?php echo $shifts->Shift->id;?>][shift_type]" class="md-radiobtn" value="1"/>
                                                                        <label for="<?php echo $shifts->Shift->id;?>_2">
                                                                        <span class="inc"></span>
                                                                        <span class="check"></span>
                                                                        <span class="box"></span>Open </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach;?>
                                                        <?php else:?>
                                                        <div class="empty_list">Sorry, no shifts are available.</div>
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <input  type="submit" id="btnSubmit" name="submit" value="Submit" class="btn green"/>
                                                    <input type="reset" name="cancel" value="Close" class="btn default" data-dismiss="modal" />
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2" align="center">
                                <div class="well">
                                    <h4 class="block">
                                        <a class="btn btn-default btn-sm" href="#portlet-config_12" class="news-block-btn" data-toggle="modal" class="config"><i class="fa fa-plus"></i>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <?php if(isset($BoardShifts)):?>
                            <?php $i = 1; ?>
                            <?php foreach ($BoardShifts as $BoardShift): ?>
                                <div class="col-md-2" align="center">
                                    <div class="well shiftWell scroller" style="height: 220px;">
                                        <a class="btn btn-default btn-sm" href="#edit_shift_type_<?=$BoardShift->ShiftBoard->id;?>" class="news-block-btn" data-toggle="modal" class="config">
                                                    <i class="fa fa-edit"></i></a>          
                                        <h4 class="block"><?php echo $BoardShift->Shift->title; ?></h4>
                                        <h6 class="block"><?php if($BoardShift->ShiftBoard->shift_type == 0){echo "Close";}elseif($BoardShift->ShiftBoard->shift_type == 1){echo "Open";}?></h6>
                                        <p>
                                            <?php 
                                                $start_time = $BoardShift->Shift->starttime;
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
                                              <form action="" id="BoardEditForm" method="post" accept-charset="utf-8" class="form-horizontal">

                                                    <div style="display:none;">
                                                        <input type="hidden" name="_method" value="POST"/>
                                                    </div>
                                              <div class="modal-body">
                                                <div class="form-body"> 
                                                <input type="hidden" value="<?php echo $BoardShift->Shift->id; ?>" name="data[Shift][id]">
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
                        
                        

                        <?php
                        // $url = URL."ShiftUsers/changeShiftTime/".$BoardShift->Shift->id.".json";
                        // $data = \Httpful\Request::get($url)->send();
                        // $changeShift = $data->body;
                        
                        // $begin = $startTime[0].':'.$startTime[1];
                        // $end = $endTime[0].':'.$endTime[1];

                        ?>
                    

                        <!-- <div class="form-group"><label class="control-label col-md-2">Start Time</label>
                            <div class="col-md-7">
                                <div class="input-group">
                                
                                <input type="text" class="form-control timepicker1 timepicker-24" <?php if($changeShift == 0){ echo 'name="data[Shift][starttime]"'; } ?>   value="<?php echo $begin; ?>" <?php if($changeShift != 0){ echo 'disabled'; } ?>>
                                
                                <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group"><label class="control-label col-md-2">End Time</label>
                            <div class="col-md-7">
                                <div class="input-group">
                                
                                <input type="text" class="form-control timepicker1 timepicker-24" name="data[Shift][endtime]"  value="<?php echo $end; ?>" <?php if($changeShift != 0){ echo 'disabled'; } ?>>
                                
                                <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span>
                                </div>
                            </div>
                        </div> -->


                      

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
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
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
                                                <?php } ?>
                                            </li>
                                        </ul>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<script type="text/javascript">

$("#BoardAddForm").submit(function() {
    $(this).submit(function() {
        return false;
    });
    return true;
});

$(".timepicker1").timepicker({ timeFormat: 'HH:mm',               
     showSeconds: false,
     showMeridian: false, 
});
</script>

<script>


        $(".shiftCheck").live('click', function(event)
            {
                var e = $(this);

                var ocDiv = e.closest('.md-checkbox').find('.ocDiv');

                if(ocDiv.attr('data-toggle') === "close")
                {
                    ocDiv.attr('data-toggle', 'open');
                    ocDiv.find('input[type="radio"]').prop('disabled', false);
                    ocDiv.show();
                }else
                {
                    ocDiv.find('input[type="radio"]').prop('disabled', true);
                    ocDiv.attr('data-toggle', 'close');
                    ocDiv.hide();
                }
            });
</script>

<script>
    // $(function(){
    //     var radios = '<div class="md-radio-inline">'+
    //         '<div class="md-radio">'+
    //             '<input type="radio" id="<?=$shifts->Shift->id;?>_1" name="data[ShiftBoard][<?=$shifts->Shift->id;?>][shift_type]" class="md-radiobtn" value="0"/>'+
    //             '<label for="<?=$shifts->Shift->id;?>_1">'+
    //             '<span class="inc"></span>'+
    //             '<span class="check"></span>'+
    //             '<span class="box"></span>'+
    //          'Close </label>'+
    //         '</div>'+
    //         '<div class="md-radio">'+
    //             '<input type="radio" checked="checked" id="<?=$shifts->Shift->id;?>_2" name="data[ShiftBoard][<?=$shifts->Shift->id;?>][shift_type]" class="md-radiobtn" value="1"/>'+
    //             '<label for="<?=$shifts->Shift->id;?>_2">'+
    //             '<span class="inc"></span>'+
    //             '<span class="check"></span>'+
    //             '<span class="box"></span>'+
    //          'Open </label>'+
    //         '</div>'+
    //     '</div>';
    //     $('#checkbox<?php echo $shifts->Shift->id; ?>').change(function(){
    //         if(this.checked){
    //             $(this).closest('.md-checkbox').append(radios);
    //         }else{
    //            $(this).closest('.md-checkbox').find('.md-radio-inline').remove(); 
    //         }
    //     })
    // });
</script>

