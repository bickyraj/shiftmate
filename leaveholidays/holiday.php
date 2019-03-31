
<?php 
   // $board_id_array = implode('_', $loginUserRelationToOther->boardManager);
    //print_r($board_id_array);
    
    $url = URL."Users/userDetail/".$userId.".json";
    $data = \Httpful\Request::get($url)->send();
    $userDetail = $data->body->message;
    // echo "<pre>";
     //print_r($loginUserRelationToOther->boardManager);

    //$loginUserRelationToOther = loginUserRelationToOther($user_id);
   
   if(isset($loginUserRelationToOther->boardManager) && !empty($loginUserRelationToOther->boardManager))
   {

    	foreach($loginUserRelationToOther->boardManager as $board_key_id=>$board_title){
    		$board_id_array_keys[] = $board_key_id;
    	}
    	 //print_r($board_id_array_keys);
        $board_id_array = implode('_', $board_id_array_keys);
        
        $url = URL."leaveholidays/holidayRequestForBoardManager/".$board_id_array.".json";
        $data = \Httpful\Request::get($url)->send();
        // echo "<pre>";
         //print_r($userDetail);

       $url = URL."leaveholidays/holidayRequestForBoardManager/".$board_id_array.".json";
        $data = \Httpful\Request::get($url)->send();
        $board_details = $data->body->output;
   }
    // echo "<pre>";
    // print_r($board_details);
   
?>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>



<!-- BEGIN PAGE HEADER-->
<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Holiday</h1>
			</div>  
         </div>
         </div>
         <div class="page-content">
            <div class="container">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?=URL_VIEW;?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Holiday</a>
                    </li>
                </ul>
<!-- END PAGE HEADER-->
            
<!-- BEGIN PAGE CONTENT-->
<!-- <div class="note note-success">
    <p>
        The draggable portlets powered with jQueryUI Sortable Plugin. You can use the jQueryUI Sortable API to store the portlet positions in your backend.The draggable portlets powered with jQueryUI Sortable Plugin. You can use the jQueryUI Sortable API to store the portlet positions in your backend.
    </p>
</div> -->

<!-- SELECT ORGANIZATION DIVS -->

<div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-blue-steel hide"></i>
                                <span class="caption-subject font-blue-steel bold uppercase">Select Organization</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-default btn-circle" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    Filter By <i class="fa fa-angle-down"></i>
                                    </a>
                                    <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                                        <label><input type="checkbox"/> Finance</label>
                                        <label><input type="checkbox" checked=""/> Membership</label>
                                        <label><input type="checkbox"/> Customer Support</label>
                                        <label><input type="checkbox" checked=""/> HR</label>
                                        <label><input type="checkbox"/> System</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="scroller" style="height: auto;" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds">

                                    <?php if(isset($userDetail->OrganizationUser) && !empty($userDetail->OrganizationUser)){?>

                                    <?php foreach ($userDetail->OrganizationUser as $organizationUser):?>
                                    <li>
                                        <a href="<?php echo URL_VIEW."leaveholidays/userBranches?orgId=".$organizationUser->Organization->id;?>">
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">

                                                        <div style="padding-right:14px;width:50px;display:block; overflow:hidden;"><img width="100%" src='<?php echo URL."webroot/files/organization/logo/".$organizationUser->Organization->logo_dir."/thumb_".$organizationUser->Organization->logo;?>'/></div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         <?php echo $organizationUser->Organization->title;?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                    </li>

                                <?php endforeach;?>

                                    <?php }else{?>
                                        <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         No Organization.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php }?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                                 

         </div>

         <div class="row">
             <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-globe font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp bold uppercase">Holiday Requests</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab">
                                    My Requests </a>
                                </li>
                                <li>
                                    <a href="#tab_1_2" data-toggle="tab">
                                    Employee Requests </a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <!--BEGIN TABS-->
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1">
                                    <div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
                                         <ul class="feeds accordion task-list scrollable" id="accordion2">

                                            <?php if(isset($board_details) && !empty($board_details)):?>

                                            <?php if(isset($board_details) && !empty($board_details))
                                                                {?>

                                                         <?php 
                                
                                                             usort($board_details, function($a1, $a2) {
                                                                                   $v1 = strtotime($a1->Leaveholiday->requested_date);
                                                                                   $v2 = strtotime($a2->Leaveholiday->requested_date);
                                                                                   return $v2 - $v1; // $v2 - $v1 to reverse direction
                                                                                });

                                                        }?>
                                             <?php 
                                                $count=0; foreach ($board_details as $board_detail):
                                                    if ($userId == $board_detail->User->id) {
                                                            $count++;
                                                        }
                                                    endforeach;
                                            ?>
                                            <?php
                                                
                                                  if($count >0):
                                                 foreach ($board_details as $board_detail):
                                                    if ($userId == $board_detail->User->id) {
                                            ?>
                                             <li class="panel leave_list" style="padding:5px; margin-bottom:1px;">
                                                <div>
                                                    <?php //echo $n++;?>

                                                     <span class="task-title-sp text-capitalize col-md-3"><?php echo $board_detail->User->fname." ".$board_detail->User->lname;?></span>
                                                    <span class="task-title-sp text-capitalize col-md-3"><?php echo $board_detail->Organization->title; ?></span>

                                                     
                                                    <span class="task-title-sp text-capitalize col-md-3"><?php echo $board_detail->Leaveholiday->requested_date; ?></span>

                                                    <?php if($board_detail->Leaveholiday->status == 1):?>

                                                    <span class="label label-sm label-success">
                                                        Approved <i class="fa fa-check"></i> </span>

                                                    <?php else:?>
                                                    <span class="label label-sm label-warning ">
                                                        Pending <i class="fa fa-share"></i>
                                                        </span>

                                                    <?php endif;?>
                                                   
                                                    <a class="accordion-toggle pull-right btn btn-xs blue" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_<?php echo $board_detail->Leaveholiday->id; ?>">
                                                    <i class="fa fa-file-o"></i>view
                                                    </a>
                                                    
                                                </div>

                                                <div id="collapse_2_<?php echo $board_detail->Leaveholiday->id; ?>" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <p>
                                                            <?php echo $board_detail->Leaveholiday->note;?>
                                                        </p>
                                                    </div>
                                                </div>

                                                
                                                
                                            </li>
                                            <?php
                                            }
                                                endforeach;
                                            ?>
                                            <?php else:?>
                                        <li>No requested Holiday.</li>
                                    <?php endif;?>
                                <?php else:?>
                                <li>No requested Holiday.</li>
                                        </ul>
                                    <?php endif;?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_1_2">
                                    <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                                    
                                        <ul class="feeds accordion task-list scrollable" id="accordion2">

                                            <?php if(isset($board_details) && !empty($board_details)):?>
                                            <?php $count=0; $n=1; foreach ($board_details as $board_detail):?>
                                                <?php if ($board_detail->Leaveholiday->status== 0) {
                                                        if ($userId != $board_detail->User->id){

                                                            $count++;

                                                        }

                                                    }?>

                                                <?php endforeach;?>

                                                <?php if($count >0):?>
                                         
                                        <?php $n=1; foreach ($board_details as $board_detail):?>
                                                <?php if ($board_detail->Leaveholiday->status== 0) {
                                                        if ($userId != $board_detail->User->id) {?>

                                                        <li class="panel leave_list" style="padding:5px; margin-bottom:1px;">
                                                            <div>
                                                                <?php //echo $n++;?>
                                                                 <span class="task-title-sp text-capitalize"><?php echo $board_detail->User->fname." ".$board_detail->User->lname;?></span>
                                                                <span class="label label-sm label-success"><?php echo $board_detail->Organization->title; ?></span>
                                                                <span class="label label-sm label-success"><?php echo $board_detail->Leaveholiday->requested_date; ?></span>
                                                               
                                                                <a class="accordion-toggle text-capitalize" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_<?php echo $board_detail->Leaveholiday->id; ?>">
                                                                Holiday Request Note
                                                                </a>
                                                                <div class="task-config-btn btn-group pull-right">
                                                                <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                                <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right">
                                                                    <li>
                                                                        <a class="approve_btn" data-id="<?php echo $board_detail->Leaveholiday->id;?>">
                                                                        <i class="fa fa-check"></i> Approve </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="reject_btn" data-id="<?php echo $board_detail->Leaveholiday->id;?>">
                                                                        <i class="fa fa-times"></i> Reject </a>
                                                                    </li>
                                                                   
                                                                </ul>
                                                            </div> 
                                                            </div>

                                                            <div id="collapse_2_<?php echo $board_detail->Leaveholiday->id; ?>" class="panel-collapse collapse">
                                                                <div class="panel-body">
                                                                    <p>
                                                                        <?php echo $board_detail->Leaveholiday->note;?>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            
                                                            
                                                        </li>

                                        

                                                    <?php 
                                                }
                                            }?>
                                            <?php endforeach;?>

                                    <?php else:?>
                                        <li>No new requests.</li>
                                    <?php endif;?>

                                          <?php else:?>
                                            <li>No new requests.</li>
                                      <?php endif;?>
                                        </ul>
                                         
                                    </div>
                                </div>
                            </div>
                            <!--END TABS-->
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
         </div>

        
<script type="text/javascript">
    $(function()
    {
       $('.approve_btn').on('click',function(e){
            var leave_id = $(this).attr("data-id");

            var leaveList = $(this).closest('.leave_list');
            var urli = '<?php echo URL."leaveholidays/approveHoliday/"."'+leave_id+'".".json"; ?>';
            $.ajax({
                url:urli,
                type:'post',
                success:function(response)
                {
                    var status =response.output.status;

                    

                    if (status == 1) {

                        leaveList.fadeOut('slow').remove();

                        
                    }
                    else{
                        alert('bye');

                    }
                }
            });
       }); 
       $('.reject_btn').on('click',function(e){
            var leave_id = $(this).attr("data-id");
            var urli = '<?php echo URL."leaveholidays/rejectHoliday/"."'+leave_id+'".".json"; ?>';

            $.ajax({
                url:urli,
                type:'post',
                success:function(response)
                {
                    var status =response.output.status;

                    if (status == 1) {
                        alert('rejected');
                    }
                    else{
                        alert('bye');
                        
                    }
                }
            });
       });
    }
    );

</script>



                                       