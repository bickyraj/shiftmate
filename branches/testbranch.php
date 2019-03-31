<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Branch <small> Test branch</small></h1>
			</div>  
         </div>
         </div>
         <div class="page-content">
            <div class="container">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?=URL_VIEW;?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?=URL_VIEW."branches/listBranches";?>">Branch Lists</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="javascript:;">Test Branch</a>
                    </li>
                </ul>

<link rel="stylesheet" type="text/css" href="<?php echo URL_VEIW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VEIW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Managed Table
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
						<div class="portlet-body">
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<button id="sample_editable_1_new" class="btn green">
											Add New <i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
									<div class="col-md-6">
										<div class="btn-group pull-right">
											<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu pull-right">
												<li>
													<a href="javascript:;">
													Print </a>
												</li>
												<li>
													<a href="javascript:;">
													Save as PDF </a>
												</li>
												<li>
													<a href="javascript:;">
													Export to Excel </a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
							<tr>
								<th class="table-checkbox">
									<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
								</th>
								<th>
									 Username
								</th>
								<th>
									 Email
								</th>
								<th>
									 Points
								</th>
								<th>
									 Joined
								</th>
								<th>
									 Status
								</th>
								<th>
									hello
								</th>
							</tr>
							</thead>
							<tbody>
							<tr class="odd gradeX">
								<td>
									<input type="checkbox" class="checkboxes" value="1"/>
								</td>
								<td>
									 shuxer
								</td>
								<td>
									<a href="mailto:shuxer@gmail.com">
									shuxer@gmail.com </a>
								</td>
								<td>
									 120
								</td>
								<td class="center">
									 12 Jan 2012
								</td>
								<td>
									<span class="label label-sm label-success">
									Approved </span>
								</td>	
							</tr>
							</tbody>
							</table>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>







<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script>
jQuery(document).ready(function() {
   TableManaged.init();
});
</script>