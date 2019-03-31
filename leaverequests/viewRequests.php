<?php 
	
	$url = URL."Requesttimeoffs/getAllRequests/".$orgId.".json";
	$response = \Httpful\Request::get($url)->send()->body;

	$reqlist = $response->list;
 ?>
 <link href="<?php echo URL_VIEW; ?>admin/pages/css/timeline.css" rel="stylesheet" type="text/css"/>
<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>All Time Off Requests <small><!-- input spinner, switches, input masks and more --></small></h1>
			</div>
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="#">Home</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="components_form_tools.html">UI Components</a>
					<i class="fa fa-circle"></i>
				</li>
				<li class="active">
					 Form Widgets & Tools
				</li>
			</ul>
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp hide"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Time Off Requests</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable table-scrollable-borderless">
								<table class="table table-hover table-light">
								<thead>
								<tr class="uppercase">
									<th colspan="2">
										 Request
									</th>
									<th>
										 Status
									</th>
									<th>
										Time Off Type
									</th>
									<th>
										 Requested On
									</th>
								</tr>
								</thead>
								<tbody>
									<?php if ($response->status == 1): ?>
										<?php foreach ($reqlist as $list): ?>
											<?php 
												$userimage = URL.'webroot/files/user/image/'.$list->User->image_dir.'/thumb2_'.$list->User->image;
						                            $image = $list->User->image;
						                            $gender = $list->User->gender;
						                            $user_image = imageGenerate($userimage,$image,$gender);
											 ?>
											<tr class="listRow" style="cursor:pointer;" data-reqTimeOffId="<?php echo $list->Requesttimeoff->id; ?>">
												<td class="fit">
													<img class="user-pic" style="width:35px;height:35px;" src="<?php echo $user_image; ?>">

												</td>
												<td>
													<a href="javascript:;" class="primary-link"><?php echo $list->User->fname." ".$list->User->lname; ?></a>
													<div class="clear-fix"></div>
													<small>requested for <?php echo getStandardDateDay($list->Requesttimeoff->startdate); ?></small>
												</td>
												<td class="statTd">
													 <?php if($list->Requesttimeoff->status == 0): ?>
													 	<span class="label label-sm label-info">
															Pending </span>
													<?php elseif($list->Requesttimeoff->status == 2): ?>
														<span class="label label-sm label-success">
															Accepted </span>
													<?php else: ?>
														<span class="label label-sm label-danger">
															Denied </span>
													<?php endif; ?>
												</td>
												<td>
													 <?php echo $list->Timeofftype->type; ?>
												</td>
												<td>
													<!-- <span class="bold theme-font">80%</span> -->
													<?php echo getStandardDateDayTime($list->Requesttimeoff->created); ?>
												</td>
											</tr>	
										<?php endforeach ?>
									<?php else: ?>
										<tr><td>No time of requests to show.</td></tr>
									<?php endif ?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
			</div>
		</div>
	</div>

	<!-- END PAGE CONTENT -->
<script src="<?php echo URL_VIEW; ?>js/date-format/date.format.js" type="text/javascript"></script>

<script type="text/javascript">

	$(function()
		{
			function dateToString(date)
			{
				var today = new Date(date);
				var dateString = today.format("dddd, mmmm dS, yyyy");

				return dateString;
			}

			function dateTimeToString(d)
			{
				var today = new Date(d.substr(0, 4), d.substr(5, 2), d.substr(8, 2), d.substr(11, 2), d.substr(14, 2), d.substr(17, 2));
				var dateString = today.format("dddd, mmmm dS, yyyy, h:MM TT");
				return dateString;
			}

			// $modal = $("#respModal");
			$(".listRow").on('click', function(event)
				{
					var e = $(this);
					var reqTOffId = e.attr("data-reqTimeOffId");

					var url = '<?php echo URL;?>Requesttimeoffs/getSingleRequests/'+reqTOffId+'.json';
					$.ajax(
						{
							url:url,
							type:'POST',
							dataType:'jsonp',
							async:false,
							success:function(res)
							{
								var list = res.list;
								var image;

								var startdate = dateToString(list.Requesttimeoff.startdate);
								var created = dateTimeToString(list.Requesttimeoff.created);

								if(typeof list.User.image =="undefined")
								{
									image = '<img class="user-pic" style="width:25px;height:25px;" src="<?php echo URL; ?>webroot/files/user_image/noimage.png">';
								}else
								{
									// /user/image/'.$list->User->image_dir.'/thumb2_'.$list->User->image;
									image = '<img class="user-pic" style="width:25px;height:25px;" src="<?php echo URL; ?>webroot/files/user/image/'+list.User.image_dir+'/thumb2_'+list.User.image+'">';
								}

								var docLink ="--";
								if(list.Timeofftype.id == 3)
								{
									 docLink = '<a target="_blank" href="<?php echo URL; ?>webroot/files/requesttimeoff/document/'+list.Requesttimeoff.document_dir+'/'+list.Requesttimeoff.document+'" id="downloadDocument" class="fa fa-download font-blue"></a>';
								}

								bootbox.dialog({
                                    title: "Time Off Request",
                                    message:
                                        '<form class="form-body" method="post">'+
                                        '<div class="well"><small>'+list.User.fname+' '+list.User.lname+' Requested Time Off</small><h4>'+startdate+' ('+list.Timeoffdaytype.type+')</h4><small>Time Off Type</small><h4>'+list.Timeofftype.type+'</h4><h6>Document '+docLink+'</h6>'+
										'</div>'+
										'<div class="row">'+
										'<div class="col-md-12">'+
										'<div class="fit col-md-1">'+image+'</div><div><span style="margin-left:0px;font-size: 11px;" class="timeline-body-time font-grey-cascade">'+list.User.fname+' '+list.User.lname+' made this request for the time off on '+created+'</span></div></div>'+
										'<div class="col-md-12 margin-top-20">'+
										'<div class="col-md-12"><h4 class="font-red-intense">Message</h4></div>'+
										'<div class="col-md-12"><span class="font-grey-cascade">'+list.Requesttimeoff.message+'</span></div>'+
										'</div>'+
										 '</div>'+
                                        '</form>',
                                    buttons:{
							                    success: {
							                        label: "Approve",
							                        className: "btn-sm btn-success",
							                        callback: function () {
							                        	var url = '<?php echo URL; ?>Requesttimeoffs/approveRequest/'+list.Requesttimeoff.id+'.json';
							                        	$.ajax(
							                        		{
							                        			url:url,
							                        			type:'POSt',
							                        			dataType:'jsonp',
							                        			async:false,
							                        			success:function(res)
							                        			{
							                        				if(res.status == 1)
							                        				{
							                        					e.find(".statTd").html("").html('<span class="label label-sm label-success"> Approved </span>');
							                        					toastr.success("You've approved the request.");
							                        				}
							                        			}
							                        		});
							                        }
							                    },
							                    danger: {
														      label: "Deny",
														      className: "btn-sm btn-danger",
														      callback: function() {
														      	var url = '<?php echo URL; ?>Requesttimeoffs/denyRequest/'+list.Requesttimeoff.id+'.json';
										                        	$.ajax(
										                        		{
										                        			url:url,
										                        			type:'POSt',
										                        			dataType:'jsonp',
										                        			async:false,
										                        			success:function(res)
										                        			{
										                        				if(res.status == 1)
										                        				{
										                        					e.find(".statTd").html("").html('<span class="label label-sm label-danger"> Denied </span>');
										                        					toastr.success("You've denied the request.");
										                        				}
										                        			}
										                        		});
														      }
														  }
							                }
							        
                                });
							}
						});
					// $modal.modal();
				});

			

			$("#downloadDocument").on('click', function(event)
				{
					alert('download');
				});
			
		});
</script>