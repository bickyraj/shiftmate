<?php
if (isset($_POST['acceptLeaveRequest'])){ 
    $url = URL . "Leaverequests/respondRequest/".$_POST['leaverequestid'].".json";
        $response1 = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
}
if (isset($_POST['rejectLeaveRequest'])){ 
    $url = URL . "Leaverequests/respondRequest/".$_POST['leaverequestid'].".json";
        $response1 = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
}

?>
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>Leave Requests <small>Accepted.</small></h1>
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
            			<a href="#">Accepted Leave Requests</a>
            		</li>
                </ul>


                <input type="hidden" id="url" value="<?php echo URL; ?>"/>
                <input type="hidden" id="viewurl" value="<?php echo URL_VIEW; ?>"/>



                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">User Accepted Leave Requests</span>
                            <!-- <span class="caption-helper">16 pending</span> -->
                        </div>
                        <div class="tools">
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                <?php
                if(isset($_GET['page_no'])){
                    $startlimit=$_GET['page_no'];
                }else{
                    $startlimit=1;
                }

                $status=1; //0-requested 1-accepted 2-rejected
                $url = URL."Leaverequests/distinctLeaveUsers/".$orgId."/".$startlimit."/".$status.".json";
                $leaveDistinct = \Httpful\Request::get($url)->send();
                $count=0;

                foreach($leaveDistinct->body->leaveDistinct->datas as $u111){
                    $count++;
                    $u11=$u111->Leaverequest->user_id;
                    
                $url8 = URL."Leaverequests/userLeaveRequests/".$orgId."/".$u11."/".$status.".json";
                $datas = \Httpful\Request::get($url8)->send();

                $data = $datas->body->userLeaveRequest;

                ?>
                <div class="thumbnail col-sm-3 col-md-3" style="margin-left: 40px;">
                	 <?php
                            $userimage = URL."webroot/files/user/image/".$data->User->image_dir."/".$data->User->image;
                            $image = $data->User->image;
                            $gender = $data->User->gender;
                            $mimage = URL.'webroot/img/user_image/defaultuser.png';
                            $fimage = URL.'webroot/img/user_image/femaleadmin.png';
                            $user_image = imageGenerate($userimage,$image,$gender,$mimage,$fimage);
                      ?>
                      <img src="<?php echo $user_image; ?>" alt="image not found" style="width: 150px; height: 150px; display: block;"/>
                	<div class="caption">
                <div class="row">
                <div class="col-md-8 col-sm-8">
                    <p><strong><a href="<?php echo URL_VIEW."organizationUsers/organizationEmployeeDetail?org_id=".$orgId."&user_id=".$data->User->id;?>"><?php echo ucwords($data->User->fname." ".$data->User->lname); ?></a></strong></p>
                    
                    <?php
                        date_default_timezone_set("Asia/Kathmandu");
                        $date=new DateTime();
                        $date1=DateTime::createFromFormat('Y-m-d H:i:s',$data->Leaverequest->requestdate);
                        
                        $date3=$date->diff($date1);
                        
                        $day= $date3->format('%d'); 
                        $hour=$date3->format('%h');
                        $minute=$date3->format('%i');
                        if($day != 0){
                            $date2 = $day." Days ago";
                        }elseif($hour !=0 ){
                            $date2=$hour." Hours ago";
                        }else{
                            $date2=$minute." Minutes ago";
                        }
                    ?>
                    
                <p style="color: green;"><?php echo $date2;?></p>
                </div>
                <div class="col-md-4 col-sm-4">
                				<dl class="alert" style="color: darkkhaki;">
                				<dt><?php echo $data->Leavetype->name;?></dt>
                			</dl>
                </div>
                </div>
                <span>For:&nbsp;&nbsp;<i><?php echo $data->Leaverequest->startdate;?></i>&nbsp;&nbsp;to&nbsp;<i>
                <?php echo $data->Leaverequest->enddate;?></i></span>
                	<table class="table table-bordered" style="background-color:ghostwhite;">
                        <thead><tr><th>Leaves</th><th>Hours</th><th>Department</th></tr></thead>
                        <tbody>
                            <tr><td><?php $url1 = URL."Leaverequests/countAcceptedLeave/".$orgId."/".$data->Leaverequest->user_id.".json";
                                        $datas2 = \Httpful\Request::get($url1)->send();
                                        $leavec=$datas2->body->count;
                                        echo $leavec;
                                   ?> times</td>
                                   <td><?php echo 25;?></td>
                                   <td><?php echo $data->Board->title;?></td>
                            </tr>
                        </tbody>
                    </table>

                <!--		<dl class="dl-horizontal alert" style="background-color: antiquewhite;">
                				<dt>Branch</dt>
                				<dd><?php echo $data->Branch->title;?></dd>
                				<dt>Requested on</dt>
                				<dd><?php echo $data->Leaverequest->requestdate;?></dd>
                				<dt>Requested for</dt>
                				<dd>
                					<?php echo $data->Leaverequest->startdate;?> to 
                					<?php echo $data->Leaverequest->enddate;?>
                				</dd>
                			</dl>
                -->

                			     <dl>
                			         <dt>Details</dt>
                			         <dd style="height: 80px;overflow: scroll;"><?php echo $data->Leaverequest->detail;?></dd>
                			     </dl>
                           <!-- <div>
                            <br />
                            <img alt="lv" class="img-responsive" src="<?php echo URL."webroot/files/leaverequest/image/".$data->Leaverequest->image_dir."/".$data->Leaverequest->image; ?>" style="height: 60px; width: 80px;"/>
                            </div> -->

                <?php if($data->Leaverequest->status==0 && $leavec<3 ){ ?>
                		<div class="note note-success">
                			Qualified
                		</div>
                <?php }elseif($data->Leaverequest->status==0 && $leavec>=3){ ?>
                		<div class="note note-danger">
                			Not Qualified
                		</div>
                <?php }elseif($data->Leaverequest->status==2){ ?>
                		<div class="note note-warning">
                			Rejected
                		</div>
                <?php }elseif($data->Leaverequest->status==1){ ?>
                		<div class="note note-info">
                			Accepted
                		</div>
                <?php } ?>
                <div>
                <div style="float: left;">
                <div style="float: left;">
                <?php if($data->Leaverequest->image!=""){ ?>
                        <a target="_blank" title="Download" href="<?php echo URL."webroot/files/leaverequest/image/".$data->Leaverequest->image_dir."/".$data->Leaverequest->image; ?>"><i class="fa fa-download fa-lg"></i></a>
                    <?php }else{ ?>
                    <?php    } ?>
                </div>
                <div style="float: right;margin-left: 20px;">
                    <a href="<?php echo URL_VIEW."leaverequests/specificUserRequests?user_id1=".$u11;?>" target="_blank" title="History">History</a>
                </div>
                </div><div style="float: right;">
                <div style="float: left;">
                <!-- <form action="" method="post">
                    <input type="hidden" value="<?php echo $data->Leaverequest->id; ?>" name="leaverequestid">
                     <input type="hidden" name="data[Leaverequest][status]" value="1">
                    <button class="btn blue btn-sm" name="acceptLeaveRequest"> Accept</button>
                </form> -->
                </div>&nbsp;&nbsp;
                <div style="float: right;">
                <form action="" method="post">
                    <input type="hidden" value="<?php echo $data->Leaverequest->id; ?>" name="leaverequestid">
                    <input type="hidden" name="data[Leaverequest][status]" value="2">
                    <button class="btn red btn-sm" name="rejectLeaveRequest">Reject</button>
                </form> 
                </div>           
                </div>
                </div>
                <!-- <div> 
                    <select name="data[Leaverequest][status]" class="changeRequest btn btn-default">
                    <option value="0">Respond</option>
                    <option value="1">Accept</option>
                    <option value="2">Reject</option>
                    </select>
                    <input type="hidden" value="<?php echo $data->Leaverequest->id; ?>" class="thisid">
                   </div>
                    <script>
                    $(document).ready(function(){
                       $(".changeRequest").change(function(){
                        var leavereqid=$(this).siblings(".thisid").val();
                        $.ajax({
                            url: "<?php echo URL_VIEW."process.php";?>",
                            data: "action=approveRequest&leaverequestid="+leavereqid+"&opt="+$(this).val(),
                            type: "post",
                            success:function(response){
                                document.location.reload(true);
                            }
                        });
                            //$.get( $("#url").val()+"Leaverequests/respondRequest/"+$(this).siblings(".thisid").val()+"/"+$(this).val()+".json",function(data,status){
                             //   document.location.reload(true);
                            //});
                       }); 
                    });
                    </script>
                -->
                	</div>
                </div>
                   <?php  } ?> 
                </div>
                    
                 <?php 
                 if($count1=$leaveDistinct->body->leaveDistinct->counts==0){
                    echo "<h5>No Accepted Leaves.</h5>";
                 }
                 ?> 
                </div>
                </div>
                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                <?php
                $page = $leaveDistinct->body->leaveDistinct->page;
                $limit1=$leaveDistinct->body->leaveDistinct->limit;
                $count1=$leaveDistinct->body->leaveDistinct->counts;
                $max=ceil($count1/$limit1);

                if($max>0){
                ?>
                <div>Showing Page <?=$page;?> of <?=$max;?></div>
                    <ul class="pagination" style="visibility: visible;">
                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                        <?php if($page<=1){ ?>
                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                        <?php }else{ ?>
                            <a title="First" href="?page_no=1"><i class="fa fa-angle-double-left"></i></a>
                        <?php } ?>
                        </li>
                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                        <?php if($page<=1){ ?>
                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                        <?php }else{ ?>
                            <a title="Prev" href="?page_no=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                        <?php } ?>
                        </li>
                        
                        <?php if($max<=5){
                            for($i=1;$i<=$max;$i++){ ?>
                            <li>
                               <a title="<?=$i;?>" href="?page_no=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                            </li>
                         <?php }}else{
                            if(($page-2)>=1 && ($page+2)<=$max){
                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                <li>
                                   <a title="<?=$i;?>" href="?page_no=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                </li>
                          <?php  }}elseif(($page-2)<1){
                            for($i=1;$i<=5;$i++){ ?>
                                <li>
                                   <a title="<?=$i;?>" href="?page_no=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                </li>
                         <?php }}elseif(($page+2)>$max){
                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                <li>
                                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page_no=<?=$i?>"><?=$i;?></a>
                                </li>
                        <?php }}} ?>
                        
                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                        <?php if($page>=$max){ ?>
                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                        <?php }else{ ?>
                        <a title="Next" href="?page_no=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                        <?php } ?></li>
                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                        <?php if($max==0 || $max==1){ ?>
                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                        <?php }else{ ?>
                        <a title="Last" href="?page_no=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                        <?php } ?></li>
                    </ul>
                <?php } ?>
                </div>
            </div>
        </div>