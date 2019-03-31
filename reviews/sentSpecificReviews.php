<?php

if(isset($_GET['page_no'])){
    $startlimit=$_GET['page_no'];
}else{
    $startlimit=1;
}
$userId=$_GET['user_id'];
$url = URL."Reviews/sentReviews/".$userId."/".$orgId."/".$startlimit.".json";
$datas = \Httpful\Request::get($url)->send();
$response = $datas->body->sentReview->datas;

$userDetail = URL."Users/myProfile/".$userId.".json";
$user = \Httpful\Request::get($userDetail)->send();
if(isset($user->body->userDetail->User->fname)){
    $fname = $user->body->userDetail->User->fname;
}else{
    $fname = "";
}
if(isset($user->body->userDetail->User->lname)){
    $lname = $user->body->userDetail->User->lname;
}else{
    $lname = "";
}
?>
<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Reviews <small> Specific.</small></h1>
		</div>  
     </div>
     </div>
     <div class="page-content">
        <div class="container">
            <ul class="page-breadcrumb breadcrumb">
                <li>
        			<i class="fa fa-home fa-2x"></i>
        			<a href="<?php echo URL_VIew; ?>">Home</a>
        			<i class="fa fa-circle"></i>
        		</li>
        		<li>
        			<a href="<?=URL_VIEW."reviews/allReviews";?>">Reviews</a>
        		</li>
                <li>
        			<a href="javascript:;">Sent Specific Reviews</a>
                </li>
            </ul>
            
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption caption-md">
            <i class="icon-bar-chart theme-font hide"></i>
            <span class="caption-subject theme-font bold uppercase">Reviews of | <?php echo ucwords($fname." ".$lname);?></span>
            <!-- <span class="caption-helper hide">weekly stats...</span> -->
        </div>
    </div>
    <div class="portlet-body">
        <div id="accordion3" class="panel-group accordion">
            <?php $count=1; if(isset($response) && !empty($response)){
                foreach($response as $res){
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
            	   <h4 class="panel-title">
                        <a aria-expanded="false" href="#collapse_3_<?php echo $count;?>" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
                            <div class="table-responsive">
                                <table class="table">
                                    <?php if($count==1){ ?>
                                        <thead>
                                            <tr class="row"><th class="col-md-1">#</th><th class="col-md-3">Board</th><th class="col-md-3">Type</th><th class="col-md-3">Date</th><th class="col-md-2"></th></tr>
                                        </thead>
                                            <?php }else{ ?>

                                            <?php } ?>
                                        <tbody>
                                            <tr class="row">
                                                <td class="col-md-1"><?php echo $count;?></td>
                                                <td class="col-md-3"><?php echo $res->Board->title;?></td>
                                                <td class="col-md-3"><?php echo $res->Review->reviewtype;?></td>
                                                <td class="col-md-3"><?php echo $res->Review->reviewdate;?></td>
                                                <td class="col-md-2"><button class="btn btn-default">+/-</button></td>        
                                            </tr>
                                        </tbody>    
                                </table>
                            </div>
                        </a>
            	   </h4>
            	</div>
            	<div class="panel-collapse collapse" id="collapse_3_<?php echo $count;?>" aria-expanded="false">
            	   <div class="panel-body">
                    <dl>
                        <dt>Details : </dt>
                        <dd><ul class="chats"><li class="in"><div class='message'><span class='arrow'></span><span class='body'><?php echo $res->Review->details;?></span></div></li></ul></dd>
                    </dl>

            	   </div>
            	</div>
            </div>
            <?php $count++; } ?>
            <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
                <?php
                $page=$datas->body->sentReview->pages;
                $count1=$datas->body->sentReview->counts;
                $limit=$datas->body->sentReview->limit;
                $max=ceil($count1/$limit);
                ?>
                <ul class="pagination" style="visibility: visible;">
                    <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                    <?php if($page<=1){ ?>
                        <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                    <?php }else{ ?>
                        <a title="First" href="?user_id=<?php echo $userId;?>&page_no=1"><i class="fa fa-angle-double-left"></i></a>
                    <?php } ?>
                    </li>
                    <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                    <?php if($page<=1){ ?>
                    <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                    <?php }else{ ?>
                        <a title="Prev" href="?user_id=<?php echo $userId;?>&page_no=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                    <?php } ?>
                    </li>
                    <li class="next <?php if($page>=$max || $limit>$count1){echo 'disabled';}?>">
                    <?php if($page>=$max || $limit>$count1){ ?>
                    <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                    <?php }else{ ?>
                    <a title="Next" href="?user_id=<?php echo $userId;?>&page_no=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                    <?php } ?></li>
                    <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                    <?php if($max==0 || $max==1){ ?>
                    <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                    <?php }else{ ?>
                    <a title="Last" href="?user_id=<?php echo $userId;?>&page_no=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                    <?php } ?></li>
                </ul>
            </div>
            <?php }else{ ?>
                <p style="font-size: 1.5em;text-align: center;">No Reviews</p>
            <?php } ?>
        </div>
    </div>
</div>