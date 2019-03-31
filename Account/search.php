
<style type="text/css">
	
	.suggestionBox
	{
		        border: 1px solid #E5E5E5;
			    overflow: hidden;
			    z-index: 9999;
			    position: absolute;
			    /* height: 200px; */
			    width: 380px;
			    background-color: #FFFFFF;
	}

	.sugList{padding: 15px;}
	.sugList:hover
	{
		background-color: #F5F5F5;
	}
	li.media.sugList.hover {
	    background-color: #F5F5F5;
	}

</style>
<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>BootstrapForm Controls <small>bootstrap form controls and more</small></h1>
			</div>
			<!-- END PAGE TITLE -->
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="#">Home</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="form_controls.html">UI Components</a>
					<i class="fa fa-circle"></i>
				</li>
				<li class="active">
					 Bootstrap<br>
					Form Controls
				</li>
			</ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-6 ">
					<!-- BEGIN SAMPLE FORM PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Horizontal Form</span>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
							<form class="form-horizontal" role="form">
								<div class="form-body">
									<div class="form-group">
										<label class="col-md-3 control-label">Block Help</label>
										<div class="col-md-9">
											<input type="text" id="searchEmp" autocomplete="off" class="form-control" placeholder="Enter text">
											<div class="suggestionBox" id="suggBox" style="display:none;">
												<ul class="media-list">
												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" class="btn green">Submit</button>
											<button type="button" class="btn default">Cancel</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<script>
        jQuery(document).ready(function() {
        	
        	$("#searchEmp").on('keyup', function(event)
        		{
        			var e = $(this);
        			console.log($(this).val());
        			var searchString = e.val();

        			var keycode = event.which || event.keyCode;


				    if (keycode == 40) {
				    	// $("#suggBox > .media-list li").next().focus();
				        // $("#suggBox > .media-list li").focus();
				        var autoComplete = $('#suggBox > .media-list');

			         	if (autoComplete.children('li').length > 0) {

			         		autoComplete.children('li').next().focus();
				        }
				    }
					else
					{
						if(keycode == 38)
						{
						}
						else
						{
		        			if(searchString == "")
		        			{
		        				$("#suggBox > .media-list").html("");
		        				$("#suggBox").hide();
		        			}
		        			else
		        			{
			        			var url = '<?php echo URL;?>OrganizationUsers/searchEmployeesNotInBranch/1/4/'+searchString+'.json';
			        			console.log(url);
			        			$.ajax(
			        				{
			        					url:url,
			        					type:'POST',
			        					dataType:'jsonp',
			        					async:false,
			        					success:function(res)
			        					{
			        						console.log(res);
			        						if(res.output.status == 1)
			        						{
			        							var data = "";
			        							$.each(res.employees, function(k,v)
			        								{
			        									data += '<li class="media sugList" data-empId="'+v.User.id+'">'+
																	'<a class="pull-left" href="javascript:;">'+
																	'<img class="media-object" style="height:45px;width:45px;" src="'+v.User.image+'" alt="">'+
																	'</a>'+
																	'<div class="media-body">'+
																		'<h4 class="media-heading">'+v.User.name+'</h4>'+
																		'<p>'+v.User.email
																		'</p>'+
																	'</div>'+
																'</li>'; 
			        								});

			        							$("#suggBox > .media-list").html("").html(data);
			        							$("#suggBox").show();
			        						}else
			        						{
			        							$("#suggBox > .media-list").html("");
			        							$("#suggBox").hide();
			        						}
			        					}
			        				});
		        			}
						}
					}
        		});
        });   
</script>