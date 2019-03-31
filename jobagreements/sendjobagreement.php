<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->


<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script>
jQuery(document).ready(function() {
   TableManaged.init();
   ComponentsPickers.init();

});
</script>

<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-gift"></i>Job Agreement
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse" data-original-title="" title="">
			</a>
			<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title="">
			</a>
			<a href="javascript:;" class="remove" data-original-title="" title="">
			</a>
		</div>
	</div>
	<div class="portlet-body form">
		<!--BEGIN FORM-->
		<form action="#" class="form-horizontal" method="post" enctype="multipart/form-data">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-3 control-label">Job Type</label>
					<div class="col-md-6">
					<select class="form-control input-circle" name='data[Jobagreement][jobtype]'>
						<option disabled selected>--Select One--</option>
						<option value="Part Time">Part Time</option>
						<option value="Full Time">Full Time</option>
						<option value="Contract">Contract</option>
					</select>
					</div>
				</div>
				<br>	


				<div class="form-group">
					<label class="col-md-3 control-label">Job Level</label>
					<div class="col-md-6">
					<select class="form-control input-circle" name='data[Jobagreement][joblevel]'>
						<option disabled selected>--Select One--</option>
						<option value="Entry Level">Entry Level</option>
						<option value="Mid Level">Mid Level</option>
						<option value="Expert">Expert</option>
					</select>
					</div>
				</div>

				<br>
				<div class="form-group">
					<label class="col-md-3 control-label">Salary</label>
					<div class="col-md-2">
						<input type="text" class="form-control input-circle" name='data[Jobagreement][joblevel]'>
						<span class="help-block"></span>
					</div>

					<div class="col-md-2">
					<select class="form-control input-circle" name='data[Jobagreement][joblevel]'>
						<option value="Entry Level">ASD</option>
						<option value="Mid Level" selected>USD</option>
					</select>
					</div>

					<div class="col-md-2">
					<select class="form-control input-circle" name='data[Jobagreement][joblevel]'>
						<option value="Entry Level">per hour</option>
						<option value="Mid Level" selected>per month</option>
						<option value="Expert">per year</option>
					</select>
					</div>
				</div>

					<br>
					<div class="form-group">
					<label class="col-md-3 control-label">Contract Period</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-circle" name='data[Jobagreement][joblevel]'>
						<span class="help-block"></span>
					</div>

					<div class="col-md-3">
					<select class="form-control input-circle" name='data[Jobagreement][joblevel]'>
						<option value="Entry Level" selected>year</option>
						<option value="Mid Level">month</option>
					</select>
					</div>
					</div>

				<br>

				<div class="form-group">
				<label class="col-md-3 control-label">Working Hour</label>
				<div class="col-md-6">
					<div class="input-group">
					<input type="text" class="form-control timepicker timepicker-no-seconds input-circle">
					<span class="input-group-addon">to </span>
					<input type="text" class="form-control timepicker timepicker-no-seconds input-circle">

					</div>
				</div>
				</div>

				<br>
				<div class="form-group">
					<label class="col-md-3 control-label">Bonus</label>
					<div class="col-md-6">
						<input type="text" class="form-control input-circle" placeholder="Enter text" name='data[Jobagreement][joblevel]'>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Medical Plan</label>
					<div class="col-md-6">
						<input type="text" class="form-control input-circle" placeholder="Enter text" name='data[Jobagreement][joblevel]'>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Retirement Plan</label>
					<div class="col-md-6">
						<input type="text" class="form-control input-circle" placeholder="Enter text" name='data[Jobagreement][joblevel]'>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Leave</label>
					<div class="col-md-6">
						<input type="text" class="form-control input-circle" placeholder="Enter text" name='data[Jobagreement][joblevel]'>
						<span class="help-block"></span>
					</div>
				</div>

			<!-- 	<div class="form-group">
					<label class="col-md-3 control-label">Attachment</label>
					<div class="col-md-6">
						<input type="file" class="form-control input-circle" placeholder="Enter text" name='data[Jobagreement][joblevel]'>
						<span class="help-block"></span>
					</div>
				</div> -->

			</div>

			<br>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-circle blue">Submit</button>
						<button type="button" class="btn btn-circle default">Cancel</button>
					</div>
				</div>
			</div>
		</form>
		<!-- END FORM-->
	</div>
</div>
