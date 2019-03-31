<?php

if(isset($_GET['page_no'])){
    $startlimit=$_GET['page_no'];
}else{
    $startlimit=1;
}
$user_id1=$_GET['user_id1'];
$url = URL."Leaverequests/myLeaveRequests/".$user_id1."/".$startlimit.".json";
$datas = \Httpful\Request::get($url)->send();
$response = $datas->body->myLeaveRequest->datas;

    $name=ucwords($response[0]->User->fname." ".$response[0]->User->lname);
?>
<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Leave Requests <small>Specific.</small></h1>
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
            			<a href="<?php echo URL_VIEW."leaverequests/userLeaveRequest";?>">Leave</a>
                        <i class="fa fa-circle"></i>
            		</li>
                    <li>
            			<a href="#">Specific user Leave Requests</a>
            		</li>
                </ul>

<div class="portlet box yellow">
   <div class="portlet-title">
    <div class="caption">
     <i class="fa fa-cogs"></i><?php echo "Leave Request History | <b>".$name."</b>"; ?>
    </div>
    <div class="tools">
     <a href="javascript:;" class="collapse" data-original-title="" title="">
     </a>
     <a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="">
     </a>
     <a href="javascript:;" class="reload" data-original-title="" title="">
     </a>
     <a href="javascript:;" class="remove" data-original-title="" title="">
     </a>
    </div>
   </div>
   <div class="portlet-body">
   <?php

?>
    <div class="table-responsive">
     <table class="table table-striped table-bordered table-hover">
     <thead>
     <tr>
      <th>
        #
      </th>
      <th>
        Type
      </th>
      <th>
        Branch
      </th>
      <th>
        Board
      </th>
      <th>
        Requested Date
      </th>
      <th>
        Requested For
      </th>
      <th>
        Details
      </th>
      <th>
        Attachment
      </th>
      <th>
        Status
      </th>
     </tr>
     </thead>
     <tbody>
     
<?php
$count=0;
foreach($response as $data){
    $count++;
?>
     
     <tr>
      <td>
        <?php echo $count; ?>
      </td>
      <td>
        <?php echo $data->Leavetype->name; ?>
      </td>
      <td>
        <?php echo $data->Branch->title; ?>
      </td>
      <td>
        <?php echo $data->Board->title; ?>
      </td>
      <td>
        <?php echo $data->Leaverequest->requestdate; ?>
      </td>
      <td>
        <?php echo $data->Leaverequest->startdate.'&nbsp; to &nbsp;'.$data->Leaverequest->enddate; ?>
      </td>
      <td>
        <?php echo $data->Leaverequest->detail; ?>
      </td>
      <td>
         <?php
                if($data->Leaverequest->image_type=="image/jpeg" || $data->Leaverequest->image_type=="image/png" || $data->Leaverequest->image_type=="image/gif"){
                ?>
                <img height="70px" width="80px" alt="simg" src="<?php echo URL;?>/webroot/files/leaverequest/image/<?php echo $data->Leaverequest->image_dir;?>/<?php echo $data->Leaverequest->image;?>">
                <?php
                }elseif($data->Leaverequest->image_type==""){
                    echo "N/A";
                }else{
                ?>
                <a href="<?php echo URL;?>/webroot/files/leaverequest/image/<?php echo $data->Leaverequest->image_dir;?>/<?php echo $data->Leaverequest->image;?>">Download attachment</a>
                <?php
                }
                ?>
      </td>
      <td>
        <?php if($data->Leaverequest->status==0){
                echo "<i class=\"glyphicon glyphicon-asterisk\"></i>&nbsp;&nbsp;Requested";
            }elseif($data->Leaverequest->status==1){
                echo "<i class=\"glyphicon glyphicon-ok\"></i>&nbsp;&nbsp;Accepted";
            }elseif($data->Leaverequest->status==2){
                echo "<i class=\"glyphicon glyphicon-remove\"></i>&nbsp;&nbsp;Rejected";
            }?>
      </td>

     </tr>
 <?php } ?>   
     </tbody>
     </table>
    </div>
   </div>
  </div>

<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
<?php
$limit=$datas->body->myLeaveRequest->limit;
$count1=$datas->body->myLeaveRequest->counts;
$max=ceil($count1/$limit);
?>
    <ul class="pagination" style="visibility: visible;">
        <li class="prev <?php if($_GET['page_no']<=1){ echo 'disabled';}?>">
            <a title="First" href="?page_no=1&user_id1=<?php echo $user_id1;?>"><i class="fa fa-angle-double-left"></i></a>
        </li>
        <li class="prev <?php if($_GET['page_no']<=1){ echo 'disabled';}?>">
            <a title="Prev" href="?page_no=<?php 
                                                if(isset($_GET['page_no'])){
                                                    if($_GET['page_no']<=1){
                                                        echo '1';
                                                    }else{
                                                        echo ($_GET['page_no']-1);
                                                    }
                                                }else{
                                                    echo "1";
                                                }
                                            ?>&user_id1=<?php echo $user_id1;?>"><i class="fa fa-angle-left"></i></a>
        </li>
        <li class="next <?php if($_GET['page_no']>=$max){echo 'disabled';}if($count<$limit){
			echo 'disabled';
		}?>">
         <?php if($count>$limit){?>
        <a title="Next" href="?page_no=<?php
            if(isset($_GET['page_no'])){
                if($_GET['page_no']<$max){
                    echo ($_GET['page_no']+1);
                }else{
                    echo $_GET['page_no'];
                }
            }else{
                if($max>'1'){
                    echo '2';
                }else{
                    echo '1';
                }                
            }
        ?>&user_id1=<?php echo $user_id1;?>">
        <?php }else{ ?>
        <a title="Next" href="javascript:">
        <?php } ?>

        <i class="fa fa-angle-right"></i></a></li>
        <li class="next"><a title="Last" href="?page_no=<?php echo $max;?>&user_id1=<?php echo $user_id1;?>"><i class="fa fa-angle-double-right"></i></a></li>
    </ul>
</div>