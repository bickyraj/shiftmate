

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

$view= URL."Feeds/orgview/".$orgId.".json";
$response = \Httpful\Request::post($view)->send();

/*echo "<pre>";
print_r($response->body);
die();*/

$feeds = $response->body;

// echo "<pre>";
// print_r($feeds);
//        die();


?>

<link href="<?php echo URL_VIEW;?>admin/pages/css/timeline.css" rel="stylesheet" type="text/css"/>






<div class="row">
    <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="glyphicon glyphicon-list-alt"></i></i>
                        <span class="caption-subject font-green-sharp bold uppercase">Feedback List</span>
                    </div>
                   <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab">
                            All</a>
                        </li>
                        <li>
                            <a href="#tab_1_2" data-toggle="tab">
                            Pinned </a>
                        </li>
                    </ul>      

            </div>
    <div class="portlet-body">
                            <!--BEGIN TABS-->
            <div class="tab-content">

            	

                    <div class="tab-pane active" id="tab_1_1">
                        <div class="scroller"  data-always-visible="1" data-rail-visible="0">
                            <ul class="feeds accordion task-list scrollable" id="accordion2">


                        <!-- BEGIN PAGE CONTENT-->
							<div class="timeline">
											
								<!-- TIMELINE ITEM -->
								<?php $feeds1=$feeds; ?>
								<?php foreach ($feeds as $feed):
									if($feed->Feed->pinned  == 0){
									$orgimage = URL.'webroot/files/user/image/'.$feed->User->image_dir.'/thumb2_'.$feed->User->image;
									$image = $feed->User->image;
									$gender = $feed->User->gender;
									$userImage = imageGenerate($orgimage,$image,$gender);
									// echo "<pre>";
									// print_r($feed);
								?>
								<div class="timeline-item">
									<div class="timeline-badge">
										<img class="timeline-badge-userpic" src="<?php echo $userImage; ?>">
									</div>
									<div class="timeline-body">
										<div class="timeline-body-arrow">
										</div>
										<div class="timeline-body-head">
											<div class="timeline-body-head-caption">
												<a href="javascript:;" class="timeline-body-title font-blue-madison"><?php echo $feed->User->fname." ".$feed->User->lname;?></a>
												<span class="timeline-body-time font-grey-cascade">Posted at : 
													<?php 

														$feeds = explode('-',$feed->Feed->createddate);
				/*										echo "<pre>";
														print_r($feeds);*/

														$times = explode(' ', $feeds['2']);
													/*	print_r($times);*/
														echo $times['1'];
													?>
												</span>

												<?php if($feed->Feed->status==1){ echo '<span class="label label-sm label-success">Received</span>';} else {echo '<span class="label label-sm label-danger">Pending</span>';}?>
													

											</div>
											
										</div>

										<div class="timeline-body-content">

										<!-- <button feed-id='<?php echo $feed->Feed->id;?>' class="btn blue" style="align:right" >Unpinned</button> -->
											<span class=" glyphicon glyphicon-pushpin pin "  feed-id='<?php echo $feed->Feed->id;?>'  style="font-size: 25px; float:right; color:<?php if($feed->Feed->pinned==0){echo 'black';} else{echo '#3598dc';}?>;"></span> 
											<span class="font-grey-cascade">
											<p>
												<strong>
													<?php echo $feed->Feed->title;?>
												</strong>
											</p>
											</span>
										</div>
										<div class="timeline-body-content">
											<span class="font-grey-cascade">
											<p>
												<?php echo $feed->Feed->purpose;?>
											</p>
											</span>

										</div>
									</div>
								</div>
								<!-- END TIMELINE ITEM -->

								<?php } endforeach;?>
							</div>
							<!-- END PAGE CONTENT-->

                            </ul>
                        </div>
                    </div>



                    <div class="tab-pane active" id="tab_1_2">
                        <div class="scroller"  data-always-visible="1" data-rail-visible="0">
                            <ul class="feeds accordion task-list scrollable" id="accordion2">
                            	
                            	

                            		            <!-- BEGIN PAGE CONTENT-->
							<div class="timeline">
											
								<!-- TIMELINE ITEM -->
								
								<?php foreach ($feeds1 as $feed):
									$orgimage = URL.'webroot/files/user/image/'.$feed->User->image_dir.'/thumb2_'.$feed->User->image;
									$image = $feed->User->image;
									$gender = $feed->User->gender;
									$userImage = imageGenerate($orgimage,$image,$gender);
								?>
								<?php if($feed->Feed->pinned == 1):?>
								<div class="timeline-item">
									<div class="timeline-badge">
										<img class="timeline-badge-userpic" src="<?php echo $userImage; ?>">
									</div>
									<div class="timeline-body">
										<div class="timeline-body-arrow">
										</div>
										<div class="timeline-body-head">
											<div class="timeline-body-head-caption">
												<a href="javascript:;" class="timeline-body-title font-blue-madison"><?php echo $feed->User->fname." ".$feed->User->lname;?></a>
												<span class="timeline-body-time font-grey-cascade">Posted at : 
													<?php 

														$feeds = explode('-',$feed->Feed->createddate);
				/*										echo "<pre>";
														print_r($feeds);*/

														$times = explode(' ', $feeds['2']);
													/*	print_r($times);*/
														echo $times['1'];
													?>
												</span>

												<?php if($feed->Feed->status==1){ echo '<span class="label label-sm label-success">Received</span>';} else {echo '<span class="label label-sm label-danger">Pending</span>';}?>
													

											</div>
											
										</div>

										<div class="timeline-body-content">

									
											<!-- <button feed-id='<?php echo $feed->Feed->id;?>' class="btn blue" style="align:right" >Unpinned</button> -->
											<span class=" glyphicon glyphicon-pushpin pin "  feed-id='<?php echo $feed->Feed->id;?>'  style="font-size: 25px; float:right; color:<?php if($feed->Feed->pinned==0){echo'black';}else{echo '#3598dc';}?>;"></span> 
											<span class="font-grey-cascade">
											<p>
												<strong>
													<?php echo $feed->Feed->title;?>
												</strong>
											</p>
											</span>
										</div>
										<div class="timeline-body-content">
											<span class="font-grey-cascade">
											<p>
												<?php echo $feed->Feed->purpose;?>
											</p>
											</span>
							
										</div>
									</div>
								</div>
								<!-- END TIMELINE ITEM -->

							<?php endif;?>
							<?php endforeach;?>
							
							</div>
							<!-- END PAGE CONTENT-->

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

















<script src="<?php echo URL_VIEW;?>admin/pages/scripts/timeline.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/1.11.3/jquery.min.js" type="text/javascript"></script>


<script type="text/javascript">

	$(function()
		{

			$(".pin").on('click', function(event)
				{
					var e = $(this);
					window.location.reload();

					// alert($(this).text());

					var feed_id = $(this).attr('feed-id');
					$.ajax({
							url:'<?php echo URL_VIEW."process.php";?>',
							data:"action=feedbackPin&feedId="+feed_id,
							type:'post',
							success:function(response)
							{

								
								if(response==0)
								{
									//e.text('Unpinned');
									e.css('color','black');


								}
								else
								{
									//e.text('Pinned');
									e.css('color','#3598dc');

								}
							}
					});
				});
		});
</script>

<script>
	jQuery(document).ready(function() {
		Timeline.init(); // init timeline page
	});
</script>






