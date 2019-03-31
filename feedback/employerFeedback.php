<?php

// if(isset($_POST['submit']))
// {

// 	    		 echo "<pre>";
//                 print_r($_POST);
//                 die();
               
// 		$url= URL."Feeds/add.json";
//         $response = \Httpful\Request::post($url)
//                 ->sendsJson()
//                 ->body($_POST['data'])
//                 ->send();
 
// //  echo "<pre>";
// // print_r($response->body);
// // die();

// }

//echo $user_id;

if(isset($_GET['page'])){
	$page = $_GET['page'];
}else{
	$page = 1;
}



	$view= URL."Feeds/view/".$user_id."/".$page.".json";
	$response = \Httpful\Request::post($view)->send();

/*echo "<pre>";
print_r($response->body);
die();*/


	$feeds = $response->body->feeds;
	$pages = $response->body->output;

       

	$nextPage = $page+1;
	$thisUrl = URL_VIEW."feedback/employerFeedback?page=".$nextPage;

	$prevPage = $page-1;
	$thisUrl2 = URL_VIEW."feedback/employerFeedback?page=".$prevPage;


/*echo "<pre>";
print_r($feeds);
die();*/
       

?>
<style>
.portlet > .portlet-title > .nav-tabs > li > a {
color: rgb(51, 51, 51);
}
</style>

<!-- tab portion -->
<div class="page-head">
	<div class="container">
	    <div class="page-title">
			<h1>Feedback <small> Feedback</small></h1>
		</div>  
    </div>
</div>
<div class="page-content" style="min-height:520px;">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?=URL_VIEW;?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?=URL_VIEW."feedback/employerFeedback";?>">Feedback</a>
            </li>
        </ul>
        <div class="row">
        <div class="col-md-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                	<div class="caption caption-md">
						<i class="icon-bar-chart theme-font hide"></i>
						<span class="caption-subject theme-font bold uppercase">Feedback List</span>
						<!-- <span class="caption-helper hide">weekly stats...</span> -->
					</div>
                    <ul class="nav nav-tabs orgNav">
                    	<?php if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)):?>
                    	<?php
                    		$count=0;
                    		foreach($loginUserRelationToOther->userOrganization as $orgid=>$org_detail){
                        		$url=URL."Organizations/organizationProfile/".$orgid.".json";
                        		$orgs=\Httpful\Request::get($url)->send();
                    	?>

                    		<li data-orgId="<?php echo $orgs->body->output->Organization->id;?>" class="<?php if($count==0){echo 'active';}?>">
                                <a href="#tab_1_<?php echo $orgs->body->output->Organization->id;?>" data-toggle="tab">
                                <?php echo $orgs->body->output->Organization->title;?></a>
                            </li>
                      	<?php
                      	$count++;
                   			 }
                   			?>
                   		<?php else:?>
                   	<?php endif;?>
                	</ul>
                </div>
			    <div class="portlet-body">
		            <div class="tab-content">
		            	<?php if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)):?>
		            	<?php
							$count=0;
		            		 foreach ($loginUserRelationToOther->userOrganization as $orgid=>$org_detail):
							$count++;
		            	 	?>


		                    <div class="tab-pane <?php if($count==1){echo 'active';}?>" id="tab_1_<?php echo $orgid;?>">
		                        <div class="portlet"  data-always-visible="1" data-rail-visible="0">
		                             <ul class="feeds accordion task-list scrollable" id="accordion2">

										<!-- BEGIN SAMPLE TABLE PORTLET-->
										<div class="portlet">
											<div class="portlet-title">
												<div class="actions">
													<a href="#regnew" role="button" class="btn btn-success btn-sm" data-toggle="modal">
													  <i class="fa fa-plus"></i> Add New
													</a>
												</div>
											</div>
											<div class="portlet-body">
												<div class="table-scrollable">
													<table class="table table-striped table-bordered table-hover dataTable no-footer" id="table_<?php echo $orgid;?>">
														<thead>
															<tr>
																<th>
																	Title
																</th>
																
																<th>
																	 Organisation 
																</th>
																<th>
																	 Purpose
																</th>
																<th>
																	 Created Date
																</th>
																<th>
																	 Status
																</th>
															</tr>
														</thead>
														<tbody>

														<?php foreach ($feeds as $feed):?>

															<?php if($feed->Feed->organization_id == $orgid):?>
														
														<tr>
																	<td><?php echo $feed->Feed->title;?></td>
																	
																<!-- Using the function relation of Pre made Function -->
																	<?php
																		$orgnames= URL."Organizations/orgView/".$feed->Feed->organization_id.".json";
																		$orgname = \Httpful\Request::post($orgnames)->send();
											                /*print_r($orgname->body->organization->Organization->title);*/
																	?>
																	<td><?php echo $orgname->body->organization->Organization->title;?></td>
																<!-- Using the function relation of Pre made Function -->		

																	<td>

																		<?php $text = $feed->Feed->purpose;
																		echo substr($text, 0, 15);
																		 ?>

																	</td>
																	<td><?php echo $feed->Feed->createddate;?></td>
																	<td><?php 
																	if($feed->Feed->status==1){ echo '<span class="label label-sm label-success">Sent</span>';} else {echo '<span class="label label-sm label-danger">Pending</span>';}?></td>
														</tr>

													
																<?php endif;?>			
															<?php endforeach;?>
															
														</tbody>		

													</table>

												</div>

											</div>



										</div>


		                               
		                            </ul>
		                        </div>
		                    </div>

		            	<?php endforeach;?>

				            <?php else:?>
				            <div>No Data.</div>
				        <?php endif;?>
		            </div>
		    	</div>
				<div class="row" >
					<div class="col-md-7 col-sm-12">
						<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
								<?php
								$page=$pages->currentPage;
								$max=$pages->totalPage;

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
				</div>

			</div>
    	</div>
		</div>
	</div>
</div>

	<div class="modal fade" id="regnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="addclose close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">FeedBack</h4>
				</div>
				<form role="form" method="post" action="" id="feedAddForm">
					<div class="modal-body">
							<div class="form-group">
								<?php	 echo "<label>Select Organisation</label>";
						    	echo "<select id=\"orgnid\" name=\"data[Feed][organization_id]\" class=\"form-control organizationSelect\">";
						   		foreach($loginUserRelationToOther->userOrganization as $orgid=>$org_detail){
						        $url = URL."Organizations/organizationProfile/".$orgid.".json";
						        $orgs = \Httpful\Request::get($url)->send();
						        
						        echo "<option value=\"".$orgs->body->output->Organization->id."\">".$orgs->body->output->Organization->title."</option>";
						   		 }
						   		 echo "</select>";
						  		  ?>
							</div>
			
							<div class="form-group">
								<label>Title</label>
									<input type="text" class="form-control"  name="data[Feed][title]"  placeholder="Title" required>
							</div>

							<div class="form-group">
								<input type="hidden" class="form-control"  name="data[Feed][user_id]" value="<?php echo $user_id ?>" placeholder="Employer Name" required>
							</div>

							<div class="form-group">
								<label>Message</label>
								<textarea class="form-control " name="data[Feed][purpose]" rows="3" placeholder="Message"></textarea>
							</div>
							<input type="hidden" name="data[Feed][status]" value="1" required>
						</div>
						<div class="modal-footer">
							<input type="reset" class="addclear btn default" value="Clear" style="display:none;">
							<input type="submit" class="btn blue"  value="Submit" name="submit">
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</form>
			</div>
		</div>
	</div>

<script>
var orgId;
$(".orgNav li").on('click',function(){
	orgId = $(this).attr('data-orgId');
	
	$("#orgnid").attr('selected','selected');

});
</script>
<script type="text/javascript">
	$("#feedAddForm").on('submit',function(event){
		event.preventDefault();
		var data = $(this).serialize();
		var userId = '<?php echo $user_id; ?>';
		var ev  = $(this);
		 $.ajax
		 ({
	            url : '<?php echo URL."Feeds/addWithData/"."'+userId+'".".json"; ?>',
	            type : "post",
	            data : data,
	            datatype : "jsonp",
	            success:function(response)
	            {
	            	console.log(response);
	            	var feedSent = '';
	            	var feedDisplay = '';
	                var feedMessage = response.feedData.Feed.purpose;
	                 var message = feedMessage.substring(0,15);
	                 
	            	if(response.feedData.Feed.status == 1){
	            		feedSent = '<span class="label label-sm label-success">Sent</span>';
	            	}
	            	else{
	            		feedSent = '<span class="label label-sm label-success">Pending</span>';
	            	}
	            	feedDisplay = '<tr><td>'+response.feedData.Feed.title+'</td><td>'+response.feedData.Organization.title+'</td><td>'+message+'</td><td>'+response.feedData.Feed.createddate+'</td><td>'+feedSent+'</td></tr>';
	            	$("#table_"+response.feedData.Feed.organization_id).append(feedDisplay);
	            	toastr.success('Thanks For Your FeedBack');
                    ev.find('.addclear').click();
                    ev.find('.addclose').click();
                    ev.closest('.modal-dialog').find('.addclose').click();
	            	// window.location.reload(true);
              //      ev.find('.addclose').click();
              //      toastr.success('Recorded Added Successfully');
	            }
        });

	});
</script>