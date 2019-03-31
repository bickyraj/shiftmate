<div class="portlet box grey">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-gift"></i>Add New Task
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse" data-original-title="" title="">
			</a>
			<a href="javascript:;" class="remove" data-original-title="" title="">
			</a>
		</div>
</div>
	<div class="portlet-body form">
	<!--BEGIN FORM-->
	<br><br>
	<form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
		<div class="form-body">
			<div class="form-group">
				<label class="col-md-2 control-label">Task Description</label>
				<div class="col-md-8">
				<textarea  name="data[Task][task]" class="data-wysihtml5" required></textarea>
				</div>
			</div>

			<br><br>
			<div class="form-group">
			<label class="col-md-2 control-label">Task Date/Time</label>
			<div class="col-md-4">
			<div class="input-group date form_meridian_datetime">
			<input type="text" name="taskdate" size="16" class="form-control" required>
			<span class="input-group-btn">
			<button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
			<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
			</span>
			</div>
			</div>
			</div>

			<br><br>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-2 col-md-9">
						<button type="submit" name="submit" class="btn green">Submit</button>
						<button type="button" class="btn default">Cancel</button>
					</div>
				</div>
			</div>
			</div>
	</form>
</div>
</div>
<link href="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>

<script>
    $('.data-wysihtml5').wysihtml5({
        "stylesheets": ["<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"],
        "image":false,
        "link":false,
        "html":false
        });
</script>

<!-- BEGIN PAGE LEVEL PLUGINS -->

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       

	$(".date-picker").datepicker();
   ComponentsPickers.init();
});   
</script>
