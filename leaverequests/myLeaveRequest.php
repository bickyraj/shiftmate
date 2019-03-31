<?php

if(isset($_GET['page_no'])){
    $startlimit=$_GET['page_no'];
}else{
    $startlimit=1;
}

$url = URL."Leaverequests/myLeaveRequests/".$user_id."/".$startlimit.".json";
$datas = \Httpful\Request::get($url)->send();
$response = $datas->body->myLeaveRequest->datas;

$new_leave_link=URL_VIEW."leaverequests/newLeaveRequest";
?>
<style>
.portlet-body table th,.portlet-body table td{
    border-top: none !important;
}
.table {
    margin-bottom: 10px;
    margin-top: 10px;
}
.dl-horizontal dt {
    text-align: left;
    width: 90px;
}
.dl-horizontal dd {
    margin-left: 0px;
}
/*.table>thead>tr>th {
    border-bottom: 0px none;
}*/
</style>
<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>Leave List <small> view Leave List</small></h1>
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
                        <a href="javascript:;">Leave</a>
                        <i class="fa fa-circle"></i>
                    </li>
                     <li>
                        <a href="<?php echo URL_VIEW."leaverequests/myLeaveRequest";?>">My Leave Request</a>
                    </li>
                </ul>
<!-- END PAGE HEADER-->
<div class="portlet light" style="min-height:400px;">
    <div class="portlet-title">
        <div class="caption caption-md">
            <i class="icon-bar-chart theme-font hide"></i>
            <span class="caption-subject theme-font bold uppercase">My Leave Requests</span>
            <!-- <span class="caption-helper hide">weekly stats...</span> -->
        </div>
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
            Actions <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li>
                    <a id="create_new_notice" href="<?php echo $new_leave_link; ?>">Create New Leave Request</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="portlet-body">
    
	<div id="accordion3" class="panel-group accordion">
<?php
$count=0;
foreach($response as $data){
    $count++;
?>

	   <div class="panel panel-default">
	   <div class="panel-heading">
	   <h4 class="panel-title">
        <a aria-expanded="false" href="#collapse_3_<?php echo $count;?>" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
        <div class="table-responsive">
            <table class="table">
                <?php if($count==1){ ?>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>leavetype</th>
                        <th>Organisation</th>
                        <th>Requested On</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <?php } ?>
                <tbody>
                    <tr>
                        <td><?php echo $count;?></td>
                        <td><?php echo $data->Leavetype->name;?></td>
                        <td><?php echo $data->Organization->title;?></td>
                        <td><?php echo $data->Leaverequest->requestdate;?></td>
                        <td><?php if($data->Leaverequest->status==0){
                                echo "<i class=\"glyphicon glyphicon-asterisk\"></i>&nbsp;&nbsp;Requested";
                            }elseif($data->Leaverequest->status==1){
                                echo "<i class=\"glyphicon glyphicon-ok\"></i>&nbsp;&nbsp;Accepted";
                            }elseif($data->Leaverequest->status==2){
                                echo "<i class=\"glyphicon glyphicon-remove\"></i>&nbsp;&nbsp;Rejected";
                            }?>
                        </td>
                        <td><button class="btn btn-default">+/-</button></td>        
                    </tr>
                </tbody>    
            </table>
        </div>
        </a>
	   </h4>
	</div>
	<div class="panel-collapse collapse" id="collapse_3_<?php echo $count;?>" aria-expanded="false">
	   <div class="panel-body">
<div class="row">
    <div class="col-md-4">
        <dl class="dl-horizontal">
            <dt>Branch :</dt>
            <dd><?php echo $data->Branch->title;?></dd>
            <dt>Board :</dt>
            <dd><?php echo $data->Board->title;?></dd>
            <dt>Start date :</dt>
            <dd><?php echo $data->Leaverequest->startdate;?></dd>
            <dt>End date :</dt>
            <dd><?php echo $data->Leaverequest->enddate;?></dd>
        </dl>
    </div>
    <div class="col-md-8">
        <dl>
        <dt>Detail</dt>
        <dd>
            <div class="row">
                <div class="col-md-2">
                <?php
                if($data->Leaverequest->image_type=="image/jpeg" || $data->Leaverequest->image_type=="image/png" || $data->Leaverequest->image_type=="image/gif"){
                ?>
                <img height="70px" width="80px" alt="simg" src="<?php echo URL;?>/webroot/files/leaverequest/image/<?php echo $data->Leaverequest->image_dir;?>/<?php echo $data->Leaverequest->image;?>">
                <?php
                }elseif($data->Leaverequest->image_type==""){
                }else{
                ?>
                <a href="<?php echo URL;?>/webroot/files/leaverequest/image/<?php echo $data->Leaverequest->image_dir;?>/<?php echo $data->Leaverequest->image;?>">Download attachment</a>
                <?php
                }
                ?>
                    
                </div>
                <div class="col-md-10">
                    <p><?php echo $data->Leaverequest->detail;?></p>
                </div>
            </div>
        </dd>
        </dl>
    </div>
</div>

	   </div>
	</div>
	</div>
<?php
}
?>

 </div>
<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
<?php
$limit=$datas->body->myLeaveRequest->limit;
$count1=$datas->body->myLeaveRequest->counts;
$page=$datas->body->myLeaveRequest->page;
$max=ceil($count1/$limit);

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

