<?php 

	$request = URL."Userfeedbacks/getAllUserFeeds/".$userId.".json";
    $response = \Httpful\Request::get($request)->send()->body;

    // fal($response);
    $lists = $response->feedbacks;
?>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>Feedbacks <small>feeds from others</small></h1>
			</div>
			<!-- END PAGE TITLE -->
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="#">Home</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="table_basic.html">Extra</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="table_basic.html">Data Tables</a>
					<i class="fa fa-circle"></i>
				</li>
				<li class="active">
					 Basic Datatables
				</li>
			</ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp hide"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Feeds</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable table-scrollable-borderless">
								<table class="table table-hover table-light">
								<thead>
								<tr class="uppercase">
									<th colspan="2">
										 From
									</th>
									<th>
										 Board
									</th>
									<th>
										 Forwarded Date
									</th>
									<th>
										Action
									</th>
								</tr>
								</thead>
								<tbody>
									<?php if ($response->status == 1): ?>
										<?php foreach ($lists as $list): ?>
											<tr>
												<?php $orgimage = URL.'webroot/files/user/image/'.$list->Feed->User->image_dir.'/thumb2_'.$list->Feed->User->image;
													$image = $list->Feed->User->image;
													$gender = $list->Feed->User->gender;

													$userimage = imageGenerate($orgimage,$image,$gender); 
												?>
												<td class="fit">
													<img class="user-pic" src="<?php echo $userimage; ?>">
												</td>
												<td>
													<a href="javascript:;" class="primary-link"><?php echo $list->Feed->User->fname." ".$list->Feed->User->lname; ?></a>
												</td>
												<td>
													<?php echo $list->Board->title; ?>
												</td>
												<td>
													<!-- <span class="bold theme-font"></span> -->
													<?php echo getStandardDateDayTime($list->Userfeedback->created); ?>
												</td>
												<td>
													<button class="btn btn-sm blue viewFeed" data-userFeedbackId="<?php echo $list->Userfeedback->id; ?>">view</button>
												</td>
											</tr>
										<?php endforeach ?>
									<?php else: ?>
										<tr>
											<td colspan="4">No Data</td>
										</tr>
									<?php endif ?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<script type="text/javascript">
	
	jQuery(document).ready(function()
		{
			$(".viewFeed").live('click',function()
            {
                var e = $(this);

                var userFeedbackId = e.attr('data-userFeedbackId');

                $.ajax(
                    {
                        url:'<?php echo URL;?>Userfeedbacks/viewFeeds/'+userFeedbackId+'.json',
                        type:'post',
                        async:false,
                        datatype:'jsonp',
                        success:function(res)
                        {
                            var data = res.feedback;

                            bootbox.dialog({
                                        title: data.Feed.title,
                                        message:
                                        	'<div class="well">'+data.Feed.purpose+
											'</div>'
                                    });
                        }
                    });

                 
	        });
		});
</script>