<link rel="stylesheet" type="text/css" href="<?php echo URL_VEIW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VEIW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php
if(isset($_POST['submitContactType'])){
    $url3 = URL . "Contacttypes/saveContactType.json";
        $response3 = \Httpful\Request::post($url3)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
        if($response3->body->message == '0'){ ?>
<script>
toastr.success("Contact type saved successfully.");
</script>
<?php
        }elseif($response3->body->message == '1'){
?>
<script>
toastr.info("Something went wrong.Please try again.");
</script>
<?php
        } else if($response3->body->message == '2'){
          echo '<script>toastr.info("Record already exist.Please try again.");</script>';
        }
}

if(isset($_POST['deleteContactType'])){
    $url9 = URL . "Contacttypes/deleteContactType.json";
        $response9 = \Httpful\Request::post($url9)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
        if($response9->body->message == '0'){ ?>
<script>
toastr.success("Record deleted successfully.");
</script>
<?php
        }elseif($response9->body->message == '1'){
?>
<script>
toastr.info("Something went wrong.Please try again.");
</script>
<?php
        }
}


if(isset($_POST['editContactType'])){
    $url8 = URL . "Contacttypes/editContactType.json";
        $response8 = \Httpful\Request::post($url8)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
        if($response8->body->message == '0'){ ?>
<script>
toastr.success("Record updated successfully.");
</script>
<?php
        }elseif($response8->body->message == '1'){
?>
<script>
toastr.info("Something went wrong.Please try again.");
</script>
<?php
        } else if($response8->body->message == '2'){
          echo '<script>toastr.info("Record already exist.Please try again.");</script>';
        }
}

$url = URL."Contacttypes/getContactTypes/".$orgId.".json";
$datas = \Httpful\Request::get($url)->send();
$response = $datas->body->contactTypes;

?>
        
<?php
$url2 = URL."Branches/listBranchesName/".$orgId.".json";
$datas2 = \Httpful\Request::get($url2)->send();
$response2 = $datas2->body->branches;
//echo "<pre>";
//print_r($response2);
//echo "</pre>";
?>                      
<div class="page-head">
  <div class="container">
    <div class="page-title">
			<h1>Emergency Protocol <small>Contact Types</small></h1>
		</div>  
  </div>
</div>
<div class="page-content">
  <div class="container">
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo URL_VEIW; ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="<?=URL_VIEW."contacts/list";?>">Emergency Protocol</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="<?=URL_VIEW."contacts/type";?>">Contact types</a>
        </li>
    </ul>         

    <div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light">
					<div class="portlet-title">
            <div class="caption caption-md">
              <i class="icon-bar-chart theme-font hide"></i>
              <span class="caption-subject theme-font bold uppercase">Emergency Protocol | Contact Types</span>
              <!-- <span class="caption-helper hide">weekly stats...</span> -->
            </div>
						<div class="tools">
              <div class="btn-group pull-right">
                <a href="#basic" data-toggle="modal" id="sample_editable_1_new" class="btn green">
                <i class="fa fa-plus"></i>  Add New  </a>
              </div>
						</div>
					</div>
					<div class="portlet-body" id="sample_1_wrapper">
            <table class="table table-striped table-bordered table-hover" id="sample_1_1">
							<thead>
  							<tr>
  								<th class="table-checkbox">
  									#
  								</th>
  								<th>
  									 Title
  								</th>
  								<th>
  									 Branch
  								</th>
                  <th>
                      Option
                  </th>
  							</tr>
							</thead>
							<tbody>
                <?php $count=1;
                  foreach($response as $res){ ?>                         
              							<tr class="odd gradeX">
              								<td>
              									<?=$count++;?>
              								</td>
              								<td>
              									 <?php echo $res->Contacttype->title;?>
              								</td>
                                              
                                              <td>
                                                  <?php echo $res->Branch->title;?>
                                              </td>
                                              <td>
                                                  <a href="#edit_<?php echo $res->Contacttype->id;?>" data-toggle="modal" id="sample_editable_1_new" class="btn btn-xs blue">
                                                        <i class="fa fa-pencil"></i>  edit  </a>
                                                  <a href="#delete_<?php echo $res->Contacttype->id;?>" data-toggle="modal" class="btn btn-xs red"><i class="fa fa-times"></i> Delete</a>
                                              </td>
              							</tr>

                  <div class="modal fade" id="edit_<?php echo $res->Contacttype->id;?>" tabindex="-1" role="basic" aria-hidden="true">            
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
                                  <input type="hidden" name="data[Contacttype][id]" value="<?php echo $res->Contacttype->id;?>"/>
                                  <div class="input-icon right">
                                    <label class="control-label">Branch</label>
                										<select class="form-control" name="data[Contacttype][branch_id]">
                                      <?php foreach($response2 as $key2=>$value2){
                                        if($res->Contacttype->branch_id==$key2){
                                         echo "<option value='".$key2."' selected='selected'>".$value2."</option>"; 
                                          }else{
                                                echo "<option value='".$key2."'>".$value2."</option>";
                                                }                                          
                                      }?>
                                    </select>
                									</div>
                							</div>
                              <input type="hidden" class="form-control" name="data[Contacttype][organization_id]" value="<?php echo $orgId;?>"/>
                								<div class="form-group">
                									<label class="control-label">Title</label>
                									<div class="input-icon right">
                										<input type="text" class="form-control" name="data[Contacttype][title]" value="<?php echo $res->Contacttype->title;?>" required />
                									</div>
                								</div>
                						</div>
                            <div class="modal-footer">
                						<div class="form-actions right">
                							<button class="btn green" type="submit" name="editContactType">Update</button>
                              <button data-dismiss="modal" class="btn default" type="button">Close</button>
                						</div>
                            </div>
                  				</form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="delete_<?php echo $res->Contacttype->id;?>" tabindex="-1" role="basic" aria-hidden="true">            
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                          <h4 class="modal-title">Delete Contact Type</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo "Are you sure you want to delete ?";?>
                        </div>
                        <div class="modal-footer">
                          <form role="form" action="" method="post">
                            <input type="hidden" name="data[Contacttype][id]" value="<?php echo $res->Contacttype->id;?>"/>
                            <div class="form-actions">
                                <button data-dismiss="modal" class="btn default" type="button">Close</button>
                                <button class="btn green" type="submit" name="deleteContactType">Delete</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>                         
                <?php }?>
              </tbody>
						</table>
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
            <h4 class="modal-title">Add Contact Type</h4>
          </div>
          <div class="modal-body">
            <form role="form" action="" method="post">
							<div class="form-body">
                <div class="form-group">
                  <div class="input-icon right">
                   <label class="control-label">Branch</label>
                   <select class="form-control" name="data[Contacttype][branch_id]">
                        <?php foreach($response2 as $key2=>$value2){
                            echo "<option value='".$key2."'>".$value2."</option>";
                        }?>
                    </select>
									</div>
								</div>
                <input type="hidden" class="form-control" name="data[Contacttype][organization_id]" value="<?php echo $orgId;?>"/>
			          <div class="form-group">
									<label class="control-label">Title</label>

									<div class="input-icon right">
										<input type="text" class="form-control" name="data[Contacttype][title]" required />
									</div>
			          </div>
		          </div>
              <div class="modal-footer">
		          <div class="form-actions right">
			          <button class="btn green" type="submit" name="submitContactType">Submit</button>
                <button data-dismiss="modal" class="btn default" type="button">Close</button>
		          </div>
              </div>
	          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script>
jQuery(document).ready(function() {       
   TableManaged.init();
});
</script>