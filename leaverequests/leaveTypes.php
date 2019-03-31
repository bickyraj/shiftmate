<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>Leave Types <small> view Leave Types</small></h1>
		</div>  
        <div class="page-toolbar">
            
        </div>
    </div>
</div>
         <div class="page-content">
            <div class="container">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo URL_VIEW;?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?php echo URL_VIEW."leaverequests/userLeaveRequest";?>">Leave</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="javascript:;">Leave Types</a>
                    </li>
                </ul>
                <?php
                if(isset($_POST['submitLeaveType'])){
                    $url7 = URL . "Leavetypes/addLeaveType.json";
                        $response7 = \Httpful\Request::post($url7)
                                ->sendsJson()
                                ->body($_POST['data'])
                                ->send();
                        if($response7->body->message == '0'){
                            ?><script>toastr.success('Leave Type Added');</script> <?php
                        }elseif($response7->body->message == '1'){
                            ?><script>toastr.error('Sorry! could not submitted your request this time, try again latter.');</script> <?php
                        }
                }
                if(isset($_POST['editLeaveType'])){
                    $url8 = URL . "Leavetypes/editLeaveType.json";
                        $response8 = \Httpful\Request::post($url8)
                                ->sendsJson()
                                ->body($_POST['data'])
                                ->send();
                        if($response8->body->message == '0'){ ?>
                <script>
                toastr.info("Type Edited", "Edit status");
                </script>
                <?php
                        }elseif($response8->body->message == '1'){
                ?>
                <script>
                toastr.warning("Type Not Edited", "Edit status");
                </script>
                <?php
                        }
                }

                if(isset($_POST['deleteLeaveType'])){
                    $url9 = URL . "Leavetypes/deleteLeaveType.json";
                        $response9 = \Httpful\Request::post($url9)
                                ->sendsJson()
                                ->body($_POST['data'])
                                ->send();
                        if($response9->body->message == '0'){ ?>
                <script>
                toastr.info("Type Deleted", "Delete status");
                </script>
                <?php
                        }elseif($response9->body->message == '1'){
                ?>
                <script>
                toastr.warning("Type could Not be Deleted", "Delete status");
                </script>
                <?php
                        }
                }

                $url = URL."Leavetypes/getTypes/".$orgId.".json";
                $datas = \Httpful\Request::get($url)->send();
                $response = $datas->body->leavetypes;
                ?>
                <div class="row">
                                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                    <div class="portlet light">
                                        <div class="portlet-title">
                                            <div class="caption caption-md">
                                                <i class="icon-bar-chart theme-font hide"></i>
                                                <span class="caption-subject theme-font bold uppercase">Leave Types</span>
                                                <!-- <span class="caption-helper">16 pending</span> -->
                                            </div>
                                            <div class="btn-group pull-right">
                                                <a href="#basic" data-toggle="modal" id="sample_editable_1_new" class="btn btn-success btn-fit-height dropdown-toggle">
                                                    <i class="fa fa-plus"></i>&nbsp;&nbsp;Add Leave Type</a>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <table class="table table-striped table-bordered table-hover" id="sample_2_2_2">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                             SN
                                                        </th>
                                                        <th>
                                                             Name
                                                        </th>
                                                        <th>
                                                            Options
                                                        </th>
                                                    </tr>
                                                </thead>
                                            <tbody>
                                            <?php if(isset($response) && !empty($response)) {?>

                                            <?php $n=1; foreach ($response as $leavetype){?>
                                            <tr class="odd gradeX orgFun_row">
                                                <td>
                                                    <?php echo $n++;?>
                                                </td>
                                                <td id="function_date">
                                                     <?php echo $leavetype->Leavetype->name;?>
                                                </td>
                                                <td>
                                                    <a href="#edit_<?php echo $leavetype->Leavetype->id;?>" data-toggle="modal" id="sample_editable_1_new" class="btn btn-xs blue">
                                                          <i class="fa fa-pencil"></i>  edit  </a>
                                                    <a href="#delete_<?php echo $leavetype->Leavetype->id;?>" data-toggle="modal" class="btn btn-xs red"><i class="fa fa-times"></i> Delete</a>
                                                </td>
                                            </tr>
                                            
                <div class="modal fade" id="edit_<?php echo $leavetype->Leavetype->id;?>" tabindex="-1" role="basic" aria-hidden="true">            
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                <h4 class="modal-title">Edit Contact Type</h4>
                </div>
                <div class="modal-body">

                							<form role="form" action="" method="post">
                								<div class="form-body">
                                                    <div class="form-group">
                <input type="hidden" class="form-control" name="data[Leavetype][organization_id]" value="<?php echo $orgId;?>"/>
                <input type="hidden" name="data[Leavetype][id]" value="<?php echo $leavetype->Leavetype->id;?>"/>
                									</div>
                									<div class="form-group">
                										<label class="control-label">Title</label>
                										<div class="input-icon right">
                											<input type="text" class="form-control" name="data[Leavetype][name]" value="<?php echo $leavetype->Leavetype->name;?>"/>
                										</div>
                									</div>
                								</div>
                								<div class="form-actions right">
                									<button class="btn green" type="submit" name="editLeaveType">edit</button>
                                                    <button data-dismiss="modal" class="btn default" type="button">Close</button>
                								</div>
                							</form>



                </div>
                <div class="modal-footer">

                </div>
                </div>
                <!-- /.modal-content -->
                </div>
                </div>                         
                    
                    
                    
                   <div class="modal fade" id="delete_<?php echo $leavetype->Leavetype->id;?>" tabindex="-1" role="basic" aria-hidden="true">            
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                <h4 class="modal-title">Delete Contact Type</h4>
                </div>
                <div class="modal-body">
                <?php echo "Sure to delete the type: '".$leavetype->Leavetype->name."'";?>
                </div>
                <div class="modal-footer">
                <form role="form" action="" method="post">
                <input type="hidden" name="data[Leavetype][id]" value="<?php echo $leavetype->Leavetype->id;?>"/>
                <div class="form-actions right">
                    <button class="btn green" type="submit" name="deleteLeaveType">Delete</button>
                    <button data-dismiss="modal" class="btn default" type="button">Close</button>
                </div>
                </form>
                </div>
                </div>
                <!-- /.modal-content -->
                </div>
                </div>                             

                                        <?php } ?>

                                        <?php } else{ ?>

                                            <tr class="odd gradeX">
                                                <td>
                                                    -
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                            </tr>

                                        <?php }?>
                                            </tbody>
                                            </table>
                                            <script>
                                                $(document).ready(function(){
                                                   $('#sample_2_2_2 ').dataTable({});
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <!-- END EXAMPLE TABLE PORTLET-->
                                </div>
                </div>
                <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">            
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                                <h4 class="modal-title">Add Leave Type</h4>
                            </div>
                            <div class="modal-body">
                            	<form role="form" action="" method="post">
                            		<div class="form-body">
                                        <div class="form-group">
                            			</div>
                                       <input type="hidden" class="form-control" name="data[Leavetype][organization_id]" value="<?php echo $orgId;?>"/>
                            			<div class="form-group">
                            				<label class="control-label">Title</label>
                            				<div class="input-icon right">
                            					<input type="text" class="form-control" name="data[Leavetype][name]"/>
                            				</div>
                            			</div>
                            		</div>
                            		<div class="form-actions right">
                            			<button class="btn green" type="submit" name="submitLeaveType">Submit</button>
                                        <button data-dismiss="modal" class="btn default" type="button">Close</button>
                            		</div>
                            	</form>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                </div>
            </div>

<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>