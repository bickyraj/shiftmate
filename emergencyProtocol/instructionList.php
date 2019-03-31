
<?php

if(isset($_GET['proId']))
{
	$procedureId = $_GET['proId'];
}
	$url = URL."Emergencyprocedureinstructionlists/getInstruction/".$procedureId.".json";

	$response = \Httpful\Request::get($url)->send();
	$response = $response->body;
	if($response->output->status ==1)
	{
		$instructions = $response->instructions;
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
				<h1>Instructions <small>list </small></h1>
			</div>
			<!-- END PAGE TITLE -->
		</div>
	</div>
	<!-- END PAGE HEAD -->
	<!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
		<div class="container">
			<!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="<?php echo URL_VIEW;?>">Home</a><i class="fa fa-circle"></i>
				</li>
				<!-- <li>
					<a href="table_managed.html">Extra</a>
					<i class="fa fa-circle"></i>
				</li> -->
				<li>
					<a href="<?php echo URL_VIEW;?>emergencyProtocol/emergencyProcedures">Procedures</a>
					<i class="fa fa-circle"></i>
				</li>
				<li class="active">
					 Instructions
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
								<a href="#portlet-config_1" class="btn green-haze" data-toggle="modal" >
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
							<table class="table table-striped table-bordered table-hover" id="instructionTable">
							<thead>
							<tr>
								<th>
									 Instructions
								</th>
								<th>
									 Action
								</th>
							</tr>
							</thead>
								<?php if(!empty($instructions)):?>
									<?php foreach ($instructions as $list):?>
									<tr class="odd gradeX" id="row_<?php echo $list->Emergencyprocedureinstructionlist->id;?>">
										<td><?php echo $list->Emergencyprocedureinstructionlist->instruction;?></td>
										<td><a href="javascript:;"class="btn btn-xs green-haze editBtn" data-instId="<?php echo $list->Emergencyprocedureinstructionlist->id;?>"><i class="fa"></i>Edit</a></td>
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
                  <h4 class="modal-title">Add Instruction</h4>
              </div>
              <div class="row">
              <div class="modal-body">
                  <form action="" id="addInstruction" method="post" accept-charset="utf-8" class="form-horizontal">

                  	<input class="form-control" type="hidden" name="data[Emergencyprocedureinstructionlist][emergencyprocedure_id]" value="<?php echo $procedureId;?>"/>
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4">Instruction<span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <textarea class="form-control" type="text" name="data[Emergencyprocedureinstructionlist][instruction]"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <input  type="submit" name="submit" value="Submit" class="btn green"/>
                                    <input type="reset" class="addclear btn default" value="Clear">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
              </div>
            </div>
              <!-- <div class="modal-footer">
                  <button type="button" class="btn default" data-dismiss="modal">Close</button>
              </div> -->
        </div>
          <!-- /.modal-content -->
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

			$("#editForm").live('submit', function(event)
				{
					event.preventDefault();
					var e = $(this);

					var data = e.serialize();

					// console.log(data);
					var url = '<?php echo URL;?>Emergencyprocedureinstructionlists/editInstruction.json';
					$.ajax(
						{
							url:url,
							data:data,
							datatype:'jsonp',
							type:'post',
							success:function(res)
							{

								var output = res.output;
								// console.log(output);
								if(output.status == 1)
								{
									var data = "";

									var tbody = $("#instructionTable tbody");
									var instruction = output.data.instruction;
									var id = output.data.id;

									var table = $('#instructionTable').DataTable();

									var idx = e.attr('data-rowIndex');

									table.cell( idx, 0 ).data(instruction).draw();

									e.closest('.modal-dialog').find('.close').click();
									toastr.success('Updated Successfully');


								}
							}
						});
				});
			
			$("#addInstruction").on('submit', function(event)
				{
					event.preventDefault();
					var e = $(this);

					var data = e.serialize();

					// console.log(data);
					var url = '<?php echo URL;?>Emergencyprocedureinstructionlists/addInstruction.json';
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

									var tbody = $("#instructionTable tbody");
									var instruction = output.data.instruction;
									var id = output.data.id;
									var listBtn = '<a href="javascript:;" class="btn btn-xs green-haze editBtn" data-instId="'+id+'"><i class="fa"></i>Edit</a>';

									var table = $('#instructionTable').DataTable();
 
										var rowNode = table.row.add( [ instruction, listBtn ] )
										    .draw()
										    .node();
										 
										$( rowNode ).css( 'color', 'green' ).animate( { color: 'black' },2000);
										    e.trigger('reset');

										    e.closest('.modal-dialog').find('.close').click();
									toastr.success("Successfully added !!");


								}
							}
						});
				});

					
					$(".editBtn").live('click', function(event)
						{

							var e = $(this);
							var instId = e.attr('data-instId');

							var table = $('#instructionTable').DataTable();

									var idx = table.row(e.closest('tr')).index();
									// console.log(idx);
							$.ajax(
			                {
			                    url:'<?php echo URL;?>Emergencyprocedureinstructionlists/instructionDetail/'+instId+'.json',
			                    type:'post',
			                    datatype:'jsonp',
			                    success:function(res)
			                    {

			                    	// console.log(res);
			                        var data = res.output.instruction.Emergencyprocedureinstructionlist;

			                        bootbox.dialog({
			                                    title: "Edit Instruction",
			                                    message:
			                                        '<form class="form-body" id="editForm" data-rowIndex="'+idx+'" method="post"><div class="form-group">'+
			                                                    '<textarea type="text" name="data[Emergencyprocedureinstructionlist][instruction]" class="form-control">'+data.instruction+'</textarea>'+
			                                            '</div>'+

			                                        '<input type="hidden" name="data[Emergencyprocedureinstructionlist][id]" value="'+data.id+'"/>'+

			                                            '<input type="submit" name="editSubmit" value="Save" class="btn btn-success" />'+
			                                        '</form>'
			                                });
			                    }
			                });
						});
		});
</script>

<script>
jQuery(document).ready(function() {
   TableManaged.init();

   $("#instructionTable").DataTable();

});
</script>