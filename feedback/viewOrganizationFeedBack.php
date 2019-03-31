

<?php if(isset($_POST['submit']))
{

	    		 // echo "<pre>";
        //         print_r($_POST);
               
		$url= URL."Feeds/add.json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
 
//  echo "<pre>";
// print_r($response->body);
// die();

}

if(isset($_GET['page1'])){
    $page1 = $_GET['page1'];
}else{
    $page1 = 1;
}
$view0 = URL."Feeds/orgview/".$orgId."/0/".$page1.".json";
$response0 = \Httpful\Request::post($view0)->send();
$feeds0 = $response0->body;

if(isset($_GET['page2'])){
    $page2 = $_GET['page2'];
}else{
    $page2 = 1;
}
$view1 = URL."Feeds/orgview/".$orgId."/1/".$page2.".json";
$response1 = \Httpful\Request::post($view1)->send();
$feeds1 = $response1->body;

if(isset($_GET['page3'])){
    $page3 = $_GET['page3'];
}else{
    $page3 = 1;
}
$view2 = URL."Feeds/orgview/".$orgId."/2/".$page3.".json";
$response2 = \Httpful\Request::post($view2)->send();
$feeds2 = $response2->body;


?>

<link href="<?php echo URL_VIEW;?>admin/pages/css/timeline.css" rel="stylesheet" type="text/css"/>


<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>Feedback <small>View Organisation Feedback</small></h1>
		</div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-circle"></i>
                <a href="<?php echo URL_VIEW; ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li><a href="<?=URL_VIEW."feedback/viewOrganizationFeedBack";?>">Organization Feedback</a></li>
        </ul>
        <div class="row">
        	<div class="col-md-12">
                <div class="portlet light">
            		<div class="tabbable-line">
            			<ul class="nav nav-tabs">
            				<li class="<?php if(!isset($_GET['page2']) && !isset($_GET['page3'])){echo "active";}?>">
            					<a href="#tab_15_1" data-toggle="tab">
            					All </a>
            				</li>
            				<li class="<?php if(isset($_GET['page2'])){echo "active";}?>">
            					<a href="#tab_15_2" data-toggle="tab">
            					Complete </a>
            				</li>
            				<li class="<?php if(isset($_GET['page3'])){echo "active";}?>">
            					<a href="#tab_15_3" data-toggle="tab">
            					In Process </a>
            				</li>
            			</ul>
            			<div class="tab-content">
                            <div class="tab-pane <?php if(!isset($_GET['page2']) && !isset($_GET['page3'])){echo "active in";}?>" id="tab_15_1">
            					<?php if(isset($feeds0->feeds) && !empty($feeds0->feeds)){?>
            						<?php foreach ($feeds0->feeds as $feed) {
            							$orgimage = URL.'webroot/files/user/image/'.$feed->User->image_dir.'/thumb2_'.$feed->User->image;
            							$image = $feed->User->image;
            							$gender = $feed->User->gender;
            							$userImage = imageGenerate($orgimage,$image,$gender);
            						 ?>
            							<div class="timeline-item">
            								<div class="timeline-badge">
            									<img style="height: 80px; width: 80px;" src="<?php echo $userImage; ?>">
            								</div>
            								<div class="timeline-body">
            									<div class="timeline-body-arrow">
            									</div>
            									<div class="timeline-body-head">
            										<div class="timeline-body-head-caption">
            											<a href="javascript:;" class="timeline-body-title font-blue-madison"><?php echo $feed->Feed->title; ?></a>
            											<span class="timeline-body-time font-grey-cascade">Created at
            												<?php 
            													$date = $feed->Feed->createddate;
            		                                         	echo getStandardDateTime($date);
            	                                         	?>
            											</span>
            										</div>
            										<div class="timeline-body-head-actions">
            											<div class="col-md-12">
            												<button type="button" data-feedId="<?php echo $feed->Feed->id;?>" class="btn blue btn-md forwardFeedBtn"> Forward</button>
            												<select id="growl_type" class="feedAction form-control input-small input-inline" data-feedId = "<?php echo $feed->Feed->id; ?>">
            													<option value="">Choose Action</option>
            													<option value="1">Complete</option>
            													<option value="2">In process</option>
            												</select>
            											</div>
                                                    </div>
                                                </div>
                                                <div class="timeline-body-content">
                                                    <span class="font-grey-cascade">
                                                    <?php echo $feed->Feed->purpose; ?></span>
                                                    <div class="margin-top-10">
                                                        <span class="font-green-haze">- <?=$feed->User->fname;?>&nbsp;<?=$feed->User->lname;?></span>
                                                    </div>
            									</div>
            								</div>
            							</div>
            						<?php } ?>
            					<?php }else{?>
            						<div>No recent feedback to show.</div>
            					<?php }?>
                                <br/>
                                <hr/>
                                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                    <?php
                                    $page=$feeds0->page;
                                    $max=$feeds0->maxPage;
                                    if($max>0){
                                    ?>
                                    <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                        <ul class="pagination" style="visibility: visible;">
                                            <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                            <?php if($page<=1){ ?>
                                                <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                            <?php }else{ ?>
                                                <a title="First" href="?page1=1"><i class="fa fa-angle-double-left"></i></a>
                                            <?php } ?>
                                            </li>
                                            <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                            <?php if($page<=1){ ?>
                                            <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                            <?php }else{ ?>
                                                <a title="Prev" href="?page1=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                            <?php } ?>
                                            </li>
                                            
                                            <?php if($max<=5){
                                                for($i=1;$i<=$max;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page1=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                             <?php }}else{
                                                if(($page-2)>=1 && ($page+2)<=$max){
                                                    for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                    <li>
                                                       <a title="<?=$i;?>" href="?page1=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                    </li>
                                              <?php  }}elseif(($page-2)<1){
                                                for($i=1;$i<=5;$i++){ ?>
                                                    <li>
                                                       <a title="<?=$i;?>" href="?page1=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                    </li>
                                             <?php }}elseif(($page+2)>$max){
                                                for ($i=($max-4);$i<=$max;$i++){ ?>
                                                    <li>
                                                       <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page1=<?=$i?>"><?=$i;?></a>
                                                    </li>
                                            <?php }}} ?>
                                            
                                            <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                            <?php if($page>=$max){ ?>
                                            <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                            <?php }else{ ?>
                                            <a title="Next" href="?page1=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                            <?php } ?></li>
                                            <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                            <?php if($max==0 || $max==1){ ?>
                                            <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                            <?php }else{ ?>
                                            <a title="Last" href="?page1=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                            <?php } ?></li>
                                        </ul>
                                    <?php } ?>
                                </div>                    
            				</div>
                            <div class="tab-pane <?php if(isset($_GET['page2'])){echo "active in";}?>" id="tab_15_2">
                                                    <?php if(isset($feeds1->feeds) && !empty($feeds1->feeds)){?>
                                        					<?php foreach ($feeds1->feeds as $feed) {
                                        						$orgimage = URL.'webroot/files/user/image/'.$feed->User->image_dir.'/thumb2_'.$feed->User->image;
                                        						$image = $feed->User->image;
                                        						$gender = $feed->User->gender;
                                        						$userImage = imageGenerate($orgimage,$image,$gender);
                                        					?>
                                        						<div class="timeline-item">
                                        							<div class="timeline-badge">
                                        								<img style="height: 80px; width: 80px;" src="<?php echo $userImage; ?>">
                                        							</div>
                                        							<div class="timeline-body">
                                        								<div class="timeline-body-arrow">
                                        								</div>
                                        								<div class="timeline-body-head">
                                        									<div class="timeline-body-head-caption">
                                        										<a href="javascript:;" class="timeline-body-title font-blue-madison"><?php echo $feed->Feed->title; ?></a>
                                        										<span class="timeline-body-time font-grey-cascade">Created at
                                        											<?php 
                                        												$date = $feed->Feed->createddate;
                                        												echo getStandardDateTime($date);
                                                                                 	?>
                                        										</span>
                                        									</div>
                                        									<div class="timeline-body-head-actions">
                                        										<!-- <div class="col-md-5">
                                        											<select id="growl_type" class="feedAction form-control input-small input-inline">
                                        												<option value="">Choose Action</option>
                                        												<option value="1">Complete</option>
                                        												<option value="2">In process</option>
                                        											</select>
                                        										</div> -->
                                        									</div>
                                        								</div>
                                        								<div class="timeline-body-content">
                                        									<span class="font-grey-cascade">
                                        									<?php echo $feed->Feed->purpose; ?></span>

                                                                            <div class="margin-top-10">
                                                                                <span class="font-green-haze">- <?=$feed->User->fname." ".$feed->User->lname;?></span>
                                                                            </div>
                                        								</div>
                                        							</div>
                                        						</div>
                                        					<?php }}else{?>
                                        						<div>No feeds.</div>
                                					<?php }?>
                                                        <br/><br/><hr/><div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                                        <?php
                                                        $page=$feeds1->page;
                                                        $max=$feeds1->maxPage;
                                                        if($max>0){
                                                        ?>
                                                        <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                                            <ul class="pagination" style="visibility: visible;">
                                                                <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                                                <?php if($page<=1){ ?>
                                                                    <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                                                <?php }else{ ?>
                                                                    <a title="First" href="?page2=1"><i class="fa fa-angle-double-left"></i></a>
                                                                <?php } ?>
                                                                </li>
                                                                <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                                                <?php if($page<=1){ ?>
                                                                <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                                                <?php }else{ ?>
                                                                    <a title="Prev" href="?page2=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                                                <?php } ?>
                                                                </li>
                                                                
                                                                <?php if($max<=5){
                                                                    for($i=1;$i<=$max;$i++){ ?>
                                                                    <li>
                                                                       <a title="<?=$i;?>" href="?page2=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                                    </li>
                                                                 <?php }}else{
                                                                    if(($page-2)>=1 && ($page+2)<=$max){
                                                                        for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                                        <li>
                                                                           <a title="<?=$i;?>" href="?page2=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                                        </li>
                                                                  <?php  }}elseif(($page-2)<1){
                                                                    for($i=1;$i<=5;$i++){ ?>
                                                                        <li>
                                                                           <a title="<?=$i;?>" href="?page2=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                                        </li>
                                                                 <?php }}elseif(($page+2)>$max){
                                                                    for ($i=($max-4);$i<=$max;$i++){ ?>
                                                                        <li>
                                                                           <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page2=<?=$i?>"><?=$i;?></a>
                                                                        </li>
                                                                <?php }}} ?>
                                                                
                                                                <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                                                <?php if($page>=$max){ ?>
                                                                <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                                                <?php }else{ ?>
                                                                <a title="Next" href="?page2=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                                                <?php } ?></li>
                                                                <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                                                <?php if($max==0 || $max==1){ ?>
                                                                <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                                                <?php }else{ ?>
                                                                <a title="Last" href="?page2=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                                                <?php } ?></li>
                                                            </ul>
                                                        <?php } ?>
                                                        </div>                    
            				</div>
                            <div class="tab-pane <?php if(isset($_GET['page3'])){echo "active in";}?>" id="tab_15_3">
                                <?php if(isset($feeds2->feeds) && !empty($feeds2->feeds)){?>
                                					<?php foreach ($feeds2->feeds as $feed) {
                                						$orgimage = URL.'webroot/files/user/image/'.$feed->User->image_dir.'/thumb2_'.$feed->User->image;
                                						$image = $feed->User->image;
                                						$gender = $feed->User->gender;
                                						$userImage = imageGenerate($orgimage,$image,$gender);
                                					?>
                                						<div class="timeline-item">
                                							<div class="timeline-badge">
                                								<img style="height: 80px; width: 80px;" src="<?php echo $userImage; ?>">
                                							</div>
                                							<div class="timeline-body">
                                								<div class="timeline-body-arrow">
                                								</div>
                                								<div class="timeline-body-head">
                                									<div class="timeline-body-head-caption">
                                										<a href="javascript:;" class="timeline-body-title font-blue-madison"><?php echo $feed->Feed->title; ?></a>
                                										<span class="timeline-body-time font-grey-cascade">Created at
                                											<?php 
                                												$date = $feed->Feed->createddate;
                                												echo getStandardDateTime($date);
                                                                         	?>
                                										</span>
                                									</div>
                                									<div class="timeline-body-head-actions">
                                										<div class="col-md-5">
                                											<select id="growl_type" class="feedAction form-control input-small input-inline" data-feedId = "<?php echo $feed->Feed->id; ?>">
                                												<option value="none">Choose Action</option>
                                												<option value="1">Complete</option>
                                											</select>
                                										</div>
                                									</div>
                                								</div>
                                								<div class="timeline-body-content">
                                									<span class="font-grey-cascade">
                                									<?php echo $feed->Feed->purpose; ?></span>
                                                                    <div class="margin-top-10">
                                                                        <span class="font-green-haze">- <?=$feed->User->fname." ".$feed->User->lname;?></span>
                                                                    </div>
                                								</div>
                                							</div>
                                						</div>
                                					<?php }}else{ ?> <div>No Feed</div><?php } ?>
                                <br/><br/><hr/>
                                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                    <?php
                                    $page=$feeds2->page;
                                    $max=$feeds2->maxPage;
                                    if($max>0){
                                    ?>
                                    <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                    <ul class="pagination" style="visibility: visible;">
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="First" href="?page3=1"><i class="fa fa-angle-double-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="Prev" href="?page3=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        
                                        <?php if($max<=5){
                                            for($i=1;$i<=$max;$i++){ ?>
                                            <li>
                                               <a title="<?=$i;?>" href="?page3=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                         <?php }}else{
                                            if(($page-2)>=1 && ($page+2)<=$max){
                                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page3=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                          <?php  }}elseif(($page-2)<1){
                                            for($i=1;$i<=5;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page3=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                         <?php }}elseif(($page+2)>$max){
                                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page3=<?=$i?>"><?=$i;?></a>
                                                </li>
                                        <?php }}} ?>
                                        
                                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                        <?php if($page>=$max){ ?>
                                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Next" href="?page3=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                        <?php } ?></li>
                                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                        <?php if($max==0 || $max==1){ ?>
                                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Last" href="?page3=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                        <?php } ?></li>
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
	$(document).ready(function(){

		function getBoardList(orgId)
		{
            var boardId;
			$.ajax(
				{
					url:'<?php echo URL;?>Boards/listBoards/'+orgId+'.json',
					type:'post',
                    async:false,
					datatype:'jsonp',
					success:function(res)
					{
						if(res.output.status == 1)
						{

							var boards = res.boards;

							var data = "";

                            var count = 0;
							$.each(boards, function(k,v)
								{
                                    if(count==0)
                                    {
                                        getBoardEmpList(v.Board.id);
                                        count++;
                                    }
									data+= '<option value="'+v.Board.id+'">'+v.Board.title+'</option>'
								});
							// console.log(data);

							$("#selectBoard").html("").append(data);
						}
					}
				});
		}

        function getBoardEmpList(boardId)
        {
            $.ajax(
                {
                    url:'<?php echo URL;?>BoardUsers/listBoardEmployees/'+boardId+'.json',
                    type:'post',
                    datatype:'jsonp',
                    success:function(res)
                    {
                        if(res.output.status == 1)
                        {
                            var boardUsers = res.boardUsers;

                            var data = "";

                            $.each(boardUsers, function(k,v)
                                {
                                    data+= '<option value="'+v.User.id+'">'+v.User.fname+' '+v.User.lname+'</option>'
                                });
                            // console.log(data);

                            $("#selectEmp").html("").append(data);
                        }
                    }
                });
        }

        $("#selectBoard").live('change', function(event)
            {
                var boardId = $(this).val();

                getBoardEmpList(boardId);
            });

		$(".forwardFeedBtn").click(function(event)
			{
				var feedId = $(this).attr('data-feedId');

				bootbox.dialog({
                title: "Forward Feed",
                message:
                    '<form action="" id="forwardFeedFrom" method="post" class="form-body"> ' +
                    '<input type="hidden" name="data[Userfeedback][feed_id]" value="'+feedId+'">'+

                    '<div class="form-group">'+
                    '<label>Select Board</label>'+
                    '<select class="form-control" id="selectBoard" name="data[Userfeedback][board_id]">'+
											'</select>'+
                    '<br/>'+
                    '<select class="form-control" id="selectEmp" name="data[Userfeedback][user_id]">'+
                                            '</select>'+
					'</div>'+
                        '<input type="submit" name="forwardFeedSubmit" value="Forward" class="btn btn-success" />'+

                    '</div> ' +
                    '</form>'
           
				});

				var orgId = '<?php echo $orgId;?>';

				getBoardList(orgId);



				
			});

	$("#forwardFeedFrom").live('submit',function(event){

        event.preventDefault();
        var data = $(this).serialize();
        var e = $(this);
        $.ajax({
            url : '<?php echo URL;?>Userfeedbacks/forwardFeedback.json',
            data:data,
            type : "post",
            datatype : "jsonp",
            success:function(response)
            {
            	if(response.status ==1)
            	{
            		toastr.success('Forwarded successfully!!.');

            		e.closest('.modal-dialog').find('.close').click();

            	}else if(response.status ==2)
                {
                    toastr.warning('The message has already been forwarded.');
                    e.closest('.modal-dialog').find('.close').click();
                }else
            	{
            		toastr.danger('Error forwarding. Please try again. Thank you.');
            	}
            }
        });
    });

		$(".feedAction").live('change',function(){

			var e = $(this);
			var feedId = $(this).attr('data-feedId');
			var feedActions = $(this).val();
			if(feedActions == ''){
				toastr.success('Choose Correct Input');
			}
			else{
				$.ajax({
	                url : '<?php echo URL."Feeds/updateFeedPin/"."'+feedId+'"."/"."'+feedActions+'".".json"; ?>',
	                type : "post",
	                datatype : "jsonp",
	                success:function(response)
	                {
	                	//console.log(response);
	                	var feedData = '';
	                	if(response.feedData.Feed.pinned == 1){
	                		toastr.success('Record Updated Successfully');
	                	feedData = '<div class="timeline-item"><div class="timeline-badge"><img style="height: 80px; width: 80px;" src="'+response.feedData.User.imagepath+'"></div><div class="timeline-body"><div class="timeline-body-arrow"></div><div class="timeline-body-head"><div class="timeline-body-head-caption"><a href="javascript:;" class="timeline-body-title font-blue-madison">'+response.feedData.Feed.title+'</a><span class="timeline-body-time font-grey-cascade">Created at'+response.finalCreatedDate+'</span></div><div class="timeline-body-head-actions"></div></div><div class="timeline-body-content"><span class="font-grey-cascade">'+response.feedData.Feed.purpose+'</span><div class="margin-top-10"><span class="font-green-haze">- '+response.feedData.User.fname+' '+response.feedData.User.lname+'</span></div></div></div></div>';
							if($("#tab_15_2 div").first().html() == "No feeds.") {
								$("#tab_15_2 div").first().remove();
							}
							$("#tab_15_2").prepend(feedData);
	                		e.closest('.timeline-item').remove();

	                	}
	                	else if(response.feedData.Feed.pinned == 2){
	                		toastr.success('Record Updated Successfully');
	                		feedData = '<div class="timeline-item"><div class="timeline-badge"><img style="height: 80px; width: 80px;" src="'+response.feedData.User.imagepath+'"></div><div class="timeline-body"><div class="timeline-body-arrow"></div><div class="timeline-body-head"><div class="timeline-body-head-caption"><a href="javascript:;" class="timeline-body-title font-blue-madison">'+response.feedData.Feed.title+'</a><span class="timeline-body-time font-grey-cascade">Created at'+response.finalCreatedDate+'</span></div><div class="timeline-body-head-actions"><div class="col-md-5"><select id="growl_type" class="feedAction form-control input-small input-inline" data-feedId = "'+response.feedData.Feed.id+'"><option value="none">Choose Action</option><option value="1">Complete</option></select></div></div></div><div class="timeline-body-content"><span class="font-grey-cascade">'+response.feedData.Feed.purpose+'</span><span class="font-green-haze">- '+response.feedData.User.fname+' '+response.feedData.User.lname+'</span></div></div></div>';
							if($("#tab_15_3 div").first().html() == "No Feed") {
								$("#tab_15_3 div").first().remove();
							}
							$("#tab_15_3").prepend(feedData);
	                		e.closest('.timeline-item').remove();
	                	}
	                }
            	});			
			}

		});
	});
</script>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/timeline.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/1.11.3/jquery.min.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() { 
Timeline.init(); // init timeline page
});
</script>
