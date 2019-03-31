<?php
$boardId = $_GET['board_id'];
$branchId = $_GET['branch_id'];


if (isset($_POST['add'])) {
	// echo "<pre>";
	// print_r($_POST['data']);
	// die();
    	$url = URL . "ShiftBoards/assignShift/".$boardId.".json";
    	$response = \Httpful\Request::post($url)->sendsJson()->body($_POST['data'])->send();
        //echo "<pre>";
        //print_r($response);
        //die();
      
}


$url = URL."ShiftBoards/userShiftList/".$boardId.".json";
$data = \Httpful\Request::get($url)->send();
$userShiftLists = $data->body;
// echo "<pre>";
// print_r($userShiftLists);
// die();
$url = URL."ShiftBranches/shiftBranchList/".$branchId.".json";
$data = \Httpful\Request::get($url)->send();
$shiftBranchlists = $data->body;
// echo "<pre>";
// print_r($shiftBranchlists);





?>
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>User <small>Shift List</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
  <div class="container">
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="#">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">User</a>
        </li>
        <li>
            <a href="#">Shift List</a>
        </li>
    </ul>
    
        <div class="portlet light">
    <div class="row margin-top-10">
      <div class="col-md-12 col-sm-12">
          <div class="portlet-body">
          	<div class="col-md-2" align="center">
                <div class="well">
                  <a class="btn btn-default btn-sm" href="#portlet-config_12" class="news-block-btn" data-toggle="modal" class="config">
                    <i class="fa fa-plus">
                    
                    </i>
                  </a>          
                </div> 
            </div>

              <?php 
          	     $userShiftId = array();
          	     if(isset($userShiftLists) && !empty($userShiftLists)){
          	     foreach($userShiftLists as $userShiftList){
            			if($userShiftList->ShiftBoard->status == 1){
                        $userShiftId[] = $userShiftList->Shift->id;
          	  ?>
          	  <!-- <div class="col-md-2" align="center">
                    <div class="well">
                      <span class=" glyphicon glyphicon-pushpin shift response"   shiftBoardId='<?php echo $userShiftList->ShiftBoard->id;?>'  style="font-size: 25px; float:right; color:<?php if($userShiftList->ShiftBoard->shift_type==0){echo'black';}else{echo '#3598dc';}?>;cursor:default;"></span> 
                        <h4 class="block"><?php echo $userShiftList->Shift->title; ?></h4>
                        <?php if ($userShiftList->ShiftBoard->shift_type == 1) {?>
                                 <label class="text">(Open Shift)</label>
                        <?php }
                        else{ ?>
                         <label class="text">(Close Shift)</label>
                        <?php
                        }
                         ?>
                        
                       
                        <p>
                            <?php 
                                $start_time = $userShiftList->Shift->starttime;
                                $end_time = $userShiftList->Shift->endtime;
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
                  </div> -->

              <div class="col-md-2" align="center">
                  <div class="well shiftWell scroller" style="height: 220px;">
                      <span class="glyphicon glyphicon-pushpin shift response hide"   shiftBoardId='<?php echo $userShiftList->ShiftBoard->id;?>'  style="font-size: 25px; float:right; color:<?php if($userShiftList->ShiftBoard->shift_type==0){echo'black';}else{echo '#3598dc';}?>;cursor:default;"></span>        
                      <h4 class="block"><?php echo $userShiftList->Shift->title; ?></h4>
                      <h6 class="block"><?php if($userShiftList->ShiftBoard->shift_type == 0){echo "Close";}elseif($userShiftList->ShiftBoard->shift_type == 1){echo "Open";}?></h6>
                      <p>
                          <?php 
                              $start_time = $userShiftList->Shift->starttime;
                              $end_time = $userShiftList->Shift->endtime;
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

              <?php }}}else{?>
              		<tr style="height:40px;"><td colspan="3">No Shift.</td></tr>
            	<?php } ?>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="portlet-config_12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Add Shift</h4>
              </div>
              <form action="" id="BoardAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                <div style="display:none;">
                 <input type="hidden" name="data[ShiftBoard][board_id]" value="<?php echo $boardId;?>" />
                  <input type="hidden" id="openCloseValue"   name="data[ShiftBoard][shift_type]" value="0" >
                    <input type="hidden" name="_method" value="POST"/>
                </div>
                <div class="modal-body">
                  <div class="form-body">     
                   <?php if(isset($shiftBranchlists)){?>
                    	<?php foreach($shiftBranchlists as $shiftBranchlist):
                			if (!in_array($shiftBranchlist->Shift->id, $userShiftId)) {
                				
                        ?>
                        <div class="md-checkbox">
                          <input type="checkbox" id="checkbox<?php echo $shiftBranchlist->Shift->id; ?>" class="checked md-check" name="data[ShiftBoard][shift_id][]" value="<?php echo $shiftBranchlist->Shift->id;?>">
                          <label for="checkbox<?php echo $shiftBranchlist->Shift->id; ?>">
                            <span class="inc"></span>
                            <span class="check"></span>
                            <span class="box"></span>
                            <?php echo $shiftBranchlist->Shift->title;?> 
                          </label>
                        </div>
                        <?php 
                      }
                        endforeach;?>
                        <?php } else {?>
                        <div class="empty_list">Sorry, no shifts are available.</div>
                    <?php }?>
                  </div>
                    <!-- <div class="col-md-12" id="openShift">
                           <h4 class="modal-title">Open shift</h4>
                           <div class="md-checkbox">
                              <!-- <input type="checkbox" id="checkbox1" class="checkedOpen md-check" name="data[ShiftBoard][shift_type]" > -->
                              <!--<input type="checkbox" id="checkbox1" class="checkedOpen md-check" name="ravi" >
                                  <label for="checkbox1">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    Open Shift
                                  </label>
                            </div>
                            <div class="form-group" id="dateRange">
                              <label class="control-label col-md-3">Date Range</label>
                              <div class="col-md-4">
                                <div class="input-group input-large date-picker input-daterange" data-date="2015-1-1" data-date-format="yyyy-mm-dd">
                                  <input type="text" name="data[ShiftBoard][start_date]" class="form-control" name="from">
                                  <span class="input-group-addon">
                                  to </span>
                                  <input type="text" name="data[ShiftBoard][end_date]" class="form-control" name="to">
                                </div>
                                <!-- /input-group -->
                               <!-- <span class="help-block">
                                Select date range </span>
                              </div>
                            </div>
                      </div>  -->
                </div>
                <div class="modal-footer">
                  <div class="col-md-offset-3 col-md-9">
                      <input  type="submit" name="add" value="Submit" class="btn green"/>
                     <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php //echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                      <input type="reset" name="cancel" value="Clear" class="btn default">
                      <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
                  </div>
                </div>
              </form>
             
              <!-- <div class="modal-footer">
                  <button type="button" class="btn default" data-dismiss="modal">Close</button>
              </div> -->
          </div>
          <!-- /.modal-content -->
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
    $(function(){
        // $('#checkbox1').click(function(e) {
        //   var _val = this.checked ? 1 : 0;
        //   $('#openCloseValue').val(_val);
        // });
      $('.shift').on('click',function(){
        //alert('hello');
        var e = $(this);
        var shiftBoardId = $(this).attr('shiftBoardId');
        //alert(shiftBoardId);
        $.ajax({
                url:'<?php echo URL."ShiftBoards/updateShiftType/"."'+shiftBoardId+'".".json"; ?>',
                type:'post',
                datatype : 'jsonp',
                success:function(response)

                {
                 
                    var textchange = e.closest('.well').find('.text');
                  if(response.output==0)
                  {
                   
                    textchange.html('');
                    textchange.html('(closeshift)');
                    //e.text('Unpinned');
                   e.css('color','black');
                    

                  }
                  else
                  {
                    //alert(response+' else');
                     textchange.html('');
                    textchange.html('(Openshift)');
                   
                    e.css('color','#3598dc');

                  }
                }
              });
      });
    });
</script>
<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/components-pickers.js"></script>
<script>
    jQuery(document).ready(function() {       
       
       ComponentsPickers.init();
    });   
</script>