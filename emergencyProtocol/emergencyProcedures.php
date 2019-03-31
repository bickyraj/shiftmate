<?php

// if(isset($_POST['submit']))
// {
// 	fal($_POST);
// }
if(isset($_GET['page']))
{
	$page = $_GET['page'];
}else
{
	$page = 1;
}
	$url = URL."Emergencyprocedures/procedureList/".$orgId."/".$page.".json";

	$response = \Httpful\Request::get($url)->send();
	$response = $response->body;

	if($response->output->status ==1)
	{
		$procedureList = $response->procedureList;
	}
?>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->

<div class="page-container">
	<!-- BEGIN PAGE HEAD -->
	<div class="page-head">
		<div class="container">
			<!-- BEGIN PAGE TITLE -->
			<div class="page-title">
				<h1>Emergency Procedures <small>instructions </small></h1>
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
					<i class="fa fa-circle"></i>
					<a href="<?php echo URL_VIEW;?>">Home</a><i class="fa fa-circle"></i>
				</li>
				<!-- <li>
					<a href="table_managed.html">Extra</a>
					<i class="fa fa-circle"></i>
				</li> -->
				<!-- <li>
					<a href="table_managed.html">Data Tables</a>
					<i class="fa fa-circle"></i>
				</li> -->
				<li class="active">
					 Emergency Procedures
				</li>
			</ul>
			<!-- END PAGE BREADCRUMB -->
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Table</span>
							</div>
							<div class="actions btn-set">
								<a href="javascript:;" id="addProcedureBtn" class="btn green-haze" data-toggle="modal" >
                                                            <i class="fa fa-plus"></i> Add  </a>
								<!-- <div class="btn-group">
									<a class="btn yellow btn-circle" href="javascript:;" data-toggle="dropdown">
									<i class="fa fa-check-circle"></i> Edit <i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="javascript:;">
											Duplicate </a>
										</li>
										<li>
											<a href="javascript:;">
											Delete </a>
										</li>
										<li class="divider">
										</li>
										<li>
											<a href="javascript:;">
											Print </a>
										</li>
									</ul>
								</div> -->
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="procedureTable">
							<thead>
							<tr>
								<th>
									 Title
								</th>
								<th>
									 Action
								</th>
							</tr>
							</thead>
								<?php if(!empty($procedureList)):?>
									<?php foreach ($procedureList as $list):?>
									<tr class="odd gradeX" id="row_<?php echo $list->Emergencyprocedure->id;?>">
										<td><?php echo $list->Emergencyprocedure->title;?></td>
										<td><a href="javascript:;" class="btn btn-xs green-haze viewInst" data-procedureid="<?php echo $list->Emergencyprocedure->id;?>">View Instruction List</a><a href="javascript:;" class="btn btn-xs green-haze editProcedure" data-procedureid="<?php echo $list->Emergencyprocedure->id;?>">Edit</a><a href="javascript:;" class="btn btn-xs red deleteProcedure" data-procedureid="<?php echo $list->Emergencyprocedure->id;?>">remove</a>
										</td>
									</tr>
								<?php endforeach;?>
								<?php endif;?>
							<tbody>
							</tbody>
							</table>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>

<div class="modal fade" id="portlet-config_1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
	          <div class="modal-header">
	              <button type="button" class="addclose close" data-dismiss="modal" aria-hidden="true"></button>
	              <h4 class="modal-title">Create Procedure</h4>
	          </div>
	          <div class="modal-body">
	            <form action="" id="addProcedure" method="post" accept-charset="utf-8" class="form-horizontal">
	              	<input class="form-control" type="hidden" name="data[Emergencyprocedure][organization_id]" value="<?php echo $orgId;?>"/>
	                <div style="display:none;">
	                    <input type="hidden" name="_method" value="POST"/>
	                </div>
	                <div class="form-body">

	                            <label class="control-label">Title<span class="required">
	                            * </span>
	                            </label>
	                            <div class="">
	                                <input class="form-control" type="text" name="data[Emergencyprocedure][title]" required />
	                            </div>

								<label class="control-label">Instructions</label>
								<div style="padding:5px 0px 20px 0px;">
									<input type="text" name="data[Emergencyprocedureinstructionlist][][instruction]" style="margin-bottom:15px;" class="form-control" placeholder="instruction.." required>
									<div id="addInstructionInput">

									</div>

								</div>
									<a href="javascript:;" id="addInstructionBtn" class="btn btn-xs green" style="margin-bottom:10px;"><i class="fa fa-plus"></i> Add more</a>
	                </div>
	                <div class="modal-footer">
	                    <div class="form-actions">
	                        <div class="row">
	                            <div class="col-md-offset-3 col-md-9">
	                                <input  type="submit" name="submit" id="procedureSubmit" value="Submit" class="btn green"/>
	                                <input type="reset" class="addclear btn default" value="Clear">
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </form>
	          </div>
              <!-- <div class="modal-footer">
                  <button type="button" class="btn default" data-dismiss="modal">Close</button>
              </div> -->
        </div>
          <!-- /.modal-content -->
    </div>
</div>

<div class="modal fade" id="instructionsList" tabindex="-1" role="basic" aria-hidden="true" data-procedureId="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Instructions </h4>
			</div>
			<div class="modal-body">
				 <div class="table-scrollable">
					<table class="table table-hover">
					<thead>
					<tr>
						<th>
							 #
						</th>
						<th>
							 Instruction
						</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					</tbody>
					</table>
				</div>
				<form id="addMoreInstForm" method="POST" action"">
					<div id="instListAddMore">

					</div>
					<button type="button" id="addMoreInstBtn" class="btn btn-sm blue">Add more</button>
					<input  type="submit" style="display:none;" name="submit" value="Submit" class="btn btn-sm green"/>
				</form>
			</div>
			<div class="modal-footer">
				<!-- <button type="button" class="btn default" data-dismiss="modal">Close</button>
				<button type="button" class="btn blue">Save changes</button> -->
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="editProcedure" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<form action="" method="POST" id="editProcedureForm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Edit Procedure </h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label">Title</label>
						<div class="titleinput">
							<input type="hidden" name="data[Emergencyprocedure][id]"/>
							<input type="text" name="data[Emergencyprocedure][title]" class="form-control" required />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
					<input type="submit" class="btn blue" value="Save Changes"/>
				</div>
			</div>
		</form>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>

<script type="text/javascript">

	$(function()
		{

			$(".removeInst").live('click', function(event)
				{

					var e = $(this);

					bootbox.confirm("Are you sure you want to remove ?", function(result)
					{
						if(result === true)
						{

							var instId = e.attr('data-instructionId');

							var url = '<?php echo URL;?>Emergencyprocedureinstructionlists/deleteInst/'+instId+'.json';

							$.ajax(
								{
									url:url,
									async:false,
									datatype:'jsonp',
									type:'post',
									success:function(res)
									{

										if(res.output ===1)
										{
											e.closest('tr').remove();
										    toastr.success('Removed Successfully !!');
										}else
										{
											toastr.danger('Something went wrong.');
										}
									}
								});
						}
					});
				});

			$("#addMoreInstForm").on('submit', function(event)
				{
					event.preventDefault();
					var e = $(this);

					var data = e.serialize();

					// console.log(data);
					var procedureId = e.closest('#instructionsList').attr('data-procedureId');
					var url = '<?php echo URL;?>Emergencyprocedureinstructionlists/addInstruction/'+procedureId+'.json';

					$.ajax(
						{
							url:url,
							data:data,
							datatype:'jsonp',
							type:'post',
							success:function(res)
							{
								// console.log(res);
								var n = $("#instructionsList").find('table tbody tr').length + 1;
								var data = "";
								$.each(res.dataArr, function(k, v)
									{
										data+= '<tr>'+
										'<td>'+n+'</td>'+
											'<td>'+
												v.instruction+
											'</td><td><button type="button" class="btn btn-xs red removeInst" data-instructionId="'+v.id+'"><i class="fa fa-times"></i></button></td></tr>';
											n++;
									});

								$("#instructionsList").find('table tbody').append(data);
								$("#instListAddMore").html("");
								$("#addMoreInstForm").find('input[name$="submit"]').hide();
								
							}
						});
				});

			$("#addMoreInstBtn").on('click', function(event)
				{
					

					var data = '<input type="text" style="margin-bottom:15px;" name="data[Emergencyprocedureinstructionlist][]" class="form-control" placeholder="instruction..">';

					$("#instListAddMore").append(data);
					$("#addMoreInstForm").find('input[name$="submit"]').show();
				});

			$(".deleteProcedure").live('click', function(event)
				{
						var e = $(this);
					bootbox.confirm("Are you sure you want to delete ?", function(result)
					{
						if(result === true)
						{
							var proId = e.attr('data-procedureid');

							var url = '<?php echo URL;?>Emergencyprocedures/deleteProcedure/'+proId+'.json';

							$.ajax(
								{
									url:url,
									async:false,
									datatype:'jsonp',
									type:'post',
									success:function(res)
									{

										if(res.output ===1)
										{

											var table = $('#procedureTable').DataTable();
	 
											var rows = table
											    .rows(e.closest('tr'))
											    .remove()
											    .draw();

											    toastr.success('Removed Successfully !!');
										}else
										{
											toastr.danger('Something went wrong.');
										}
									}
								});
						}
					}); 
				});
			$("#editProcedureForm").on('submit', function(event)
				{
					event.preventDefault();
					var e = $(this);

					var data = e.serialize();

					// console.log(data);
					var url = '<?php echo URL;?>Emergencyprocedures/editProcedure.json';
					$.ajax(
						{
							url:url,
							data:data,
							async:false,
							datatype:'jsonp',
							type:'post',
							success:function(res)
							{

								var output = res.output;
								// console.log(output);
								if(output.status == 1)
								{
									var data = "";

									var tbody = $("#procedureTable tbody");
									var title = output.data.procedure;
									var id = output.data.id;

									var table = $('#procedureTable').DataTable();

									var idx = e.attr('data-rowIndex');

									table.cell(idx,0).data(title).draw();

									e.closest('.modal-dialog').find('.close').click();
									toastr.success('Updated Successfully');


								}
							}
						});
				});
			$(".editProcedure").live('click', function(event)
				{
					var e = $(this);
					var procedureid = e.attr('data-procedureid');

					var table = $('#procedureTable').DataTable();
					var idx = table.row(e.closest('tr')).index();
					$("#editProcedureForm").attr('data-rowIndex', idx);

					var url = '<?php echo URL;?>Emergencyprocedures/procedureDetail/'+procedureid+'.json';

					$.ajax(
						{
							url:url,
							type:'post',
							datatype:'jsonp',
							async:false,
							success:function(res)
							{
								var emergencyprocedure = res.procedure.Emergencyprocedure;

								$("#editProcedure").find('input[name$="data[Emergencyprocedure][id]"]').val(emergencyprocedure.id);
								$("#editProcedure").find('input[name$="data[Emergencyprocedure][title]"]').val(emergencyprocedure.title);
								$modal = $("#editProcedure");
								$modal.modal();
							}
						});
				});

			$(".viewInst").live('click', function(event)
				{
					var e = $(this);
					var procedureid = e.attr('data-procedureid');

					$("#instructionsList").attr('data-procedureId', procedureid);
					// alert(procedureid);
					var url = '<?php echo URL;?>Emergencyprocedureinstructionlists/getInstruction/'+procedureid+'.json';
					$.ajax(
						{
							url:url,
							datatype:'jsonp',
							type:'post',
							async:false,
							success:function(res)
							{
								var instructions = res.instructions;
								console.log(instructions);
								var data = "";
								var sn = 1;
								$.each(instructions, function(k,v)
									{
										data+= '<tr>'+
										'<td>'+sn+'</td>'+
											'<td>'+
												v.Emergencyprocedureinstructionlist.instruction+
											'</td><td><button type="button" class="btn btn-xs red removeInst" data-instructionId="'+v.Emergencyprocedureinstructionlist.id+'"><i class="fa fa-times"></i></button></td></tr>';
											sn++;
									});
								// console.log(data);

								$("#instructionsList").find('table tbody').html("").html(data);
								$("#instListAddMore").html("");
								$("#addMoreInstForm").find('input[name$="submit"]').hide();
								$modal = $("#instructionsList");
								$modal.modal();
							}
						});
				});
			$("#addProcedureBtn").on('click', function(event)
				{
					$("#procedureSubmit").removeAttr('disabled');
					$("#addInstructionInput").html("");
					$modal = $("#portlet-config_1");
					$modal.modal();
				});

			$("#addInstructionBtn").live('click', function(event)
				{
					var data = "";
					 data = '<input type="text" style="margin-bottom:15px;" name="data[Emergencyprocedureinstructionlist][][instruction]" class="form-control" placeholder="instruction..">';

					 $("#addInstructionInput").append(data);
				});
			
			$("#addProcedure").on('submit', function(event)
				{
					$("#procedureSubmit").attr("disabled","disabled");
					event.preventDefault();
					var e = $(this);

					var data = e.serialize();

					// console.log(data);
					var url = '<?php echo URL;?>Emergencyprocedures/addProcedure.json';
					$.ajax(
						{
							url:url,
							data:data,
							datatype:'jsonp',
							type:'post',
							success:function(res)
							{

								var output = res.output;
								if(output.status == 1)
								{
									var data = "";

									var tbody = $("#procedureTable tbody");
									var title = output.data.title;
									var id = output.data.id;

									// var tr = '<tr class="odd gradeX"><td data-id="'+id+'">'+title+'</td><td></td></tr>';
									// tbody.prepend(tr);
									var listBtn = '<a href="javascript:;" class="btn btn-xs green-haze viewInst" data-procedureid="'+id+'"><i class="fa"></i>View Instruction List</a><a href="javascript:;" class="btn btn-xs green-haze editProcedure" data-procedureid="'+id+'">Edit</a><a href="javascript:;" class="btn btn-xs red deleteProcedure" data-procedureid="'+id+'">remove</a>';

									var table = $('#procedureTable').DataTable();
 
										var rowNode = table
										    .row.add( [ title, listBtn ] )
										    .draw()
										    .node();
										 
										$( rowNode )
										    .css( 'color', 'green' )
										    .animate( { color: 'black' } );
										    e.trigger('reset');
										    e.closest('.modal-dialog').find('.close').click();
									toastr.success("Successfully added !!");

								}
							}
						});
				});
		});
</script>

<script>
jQuery(document).ready(function() {
   TableManaged.init();

   $("#procedureTable").DataTable();

});
</script>