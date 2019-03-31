<link rel="stylesheet" type="text/css" href="<?php echo URL_VEIW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VEIW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php
if(isset($_POST['deleteContactList'])){
  $url9= URL."Contacts/deleteContactList.json";
  $response9 = \Httpful\Request::post($url9)
  ->sendsJson()
  ->body($_POST['data'])
  ->send();
  if($response9->body->message == '0'){ ?>
  <script>
    
    toastr.success("Contact deleted successfully");
  </script>
  <?php }elseif($response9->body->message == '1'){
    ?>
    <script>
   
      toastr.info("Something went wrong.Please try again.");
    </script>
    <?php
  } 
}
if(isset($_POST['editContact'])){
  $url8= URL."Contacts/editContactList.json";
  $response8 = \Httpful\Request::post($url8)
  ->sendsJson()
  ->body($_POST['data'])
  ->send();
 // fal($response8);
  if($response8->body->message == '0'){ ?>
  <script>
    
    toastr.info("Contact Edited successfully.");
  </script>
  <?php }elseif($response8->body->message == '1'){
    ?>
    <script>
   
      toastr.warning("Something went wrong.Please try again.");
    </script>
    <?php
  }else if($response8->body->message == '2'){
    echo '<script>toastr.info("Record already exist.Please try again.");</script>';
  }
}
if(isset($_POST['submitContact'])){
  $url3 = URL . "Contacts/saveContactList.json";
  $response3 = \Httpful\Request::post($url3)
  ->sendsJson()
  ->body($_POST['data'])
  ->send();
  if($response3->body->message == '0'){ ?>
  <script>
    
    toastr.success("Contact Saved successfully.");
  </script>
  <?php }elseif($response3->body->message == '1'){
    ?>
    <script>
   
      toastr.info("Something went wrong.Please try again.");
    </script>
    <?php
  } else if($response3->body->message == '2'){
    echo '<script>toastr.info("Record already exist.Please try again.");</script>';
  }
}
$url = URL."Contacts/getContactLists/".$orgId.".json";
$datas = \Httpful\Request::get($url)->send();
$response = $datas->body->contactList;
?>
<?php
$url1 = URL."Contacttypes/getContactTypes/".$orgId.".json";
$datas1 = \Httpful\Request::get($url1)->send();
$response1 = $datas1->body->contactTypes;
//print_r($response1);
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
      <h1>Emergency Protocol <small>Contact Lists</small></h1>
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
        <a href="<?=URL_VIEW."contacts/list";?>">Contact Lists</a>
      </li>
    </ul>        
    <div class="row">
      <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption caption-md">
              <i class="icon-bar-chart theme-font hide"></i>
              <span class="caption-subject theme-font bold uppercase">Emergency Protocol | Contact List</span>
              <!-- <span class="caption-helper hide">weekly stats...</span> -->
            </div>
            <div class="pull-right">
              <a href="#basic" data-toggle="modal" id="sample_editable_1_new" class="btn green">
                <i class="fa fa-plus"></i> Add New Contact 
              </a>
            </div>
          </div>
          <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover" id="contactTable">
              <thead>
                <tr>
                  <th class="table-checkbox">
                    #
                  </th>
                  <th>
                    Type
                  </th>
                  <th>
                    Full Name
                  </th>
                  <th>
                    Email
                  </th>
                  <th>
                    Contact No.
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
                <?php $count=1; foreach($response as $res){ ?>
                  <tr class="odd gradeX text-capitalize">
                    <td>
                      <?=$count++;?>
                    </td>
                    <td>
                      <?php echo $res->Contacttype->title;?>
                    </td>
                    <td>
                      <?php echo ucwords($res->Contact->fname." ".$res->Contact->lname);?>
                    </td>
                    <td>
                      <a href="mailto:<?php echo $res->Contact->email;?>">
                        <?php echo $res->Contact->email;?>
                      </a>
                    </td>
                    <td>
                      <?php echo $res->Contact->phone;?>
                    </td>
                    <td class="center">
                      <?php echo $res->Branch->title;?>
                    </td>
                    <td>
                      <a href="#edit_<?php echo $res->Contact->id;?>" data-toggle="modal" id="sample_editable_1_new" class="btn btn-xs green">
                        <i class="fa fa-pencil"></i>  edit  </a>
                      <a href="#delete_<?php echo $res->Contact->id;?>" data-toggle="modal" class="btn btn-xs red"><i class="fa fa-times"></i> Delete</a>
                    </td>
                  </tr>
                  <div class="modal fade" id="edit_<?php echo $res->Contact->id;?>" tabindex="-1" role="basic" aria-hidden="true">            
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                          <h4 class="modal-title">Edit Contact</h4>
                        </div>
                        <div class="modal-body">    
                          <form role="form" action="" method="post">
                            <input type="hidden" name="data[Contact][id]" value="<?php echo $res->Contact->id;?>"/>
                            <div class="form-body">
                              <div class="form-group">    
                              <div class="input-icon right">
                                  <label class="control-label">Branch</label>
                                  <select class="form-control" name="data[Contact][branch_id]">
                                    <?php foreach($response2 as $key2=>$value2){
                                      if($key2==$res->Contact->branch_id){
                                        echo "<option value='".$key2."' selected='selected'>".$value2."</option>";
                                      }else{
                                        echo "<option value='".$key2."'>".$value2."</option>"; 
                                      }
                                    }?>
                                  </select>
                                </div><br>
                                <div class="input-icon right">
                                  <label class="control-label">Contact Type</label>
                                  <select class="form-control" name="data[Contact][contacttype_id]">
                                    <option value="<?php echo $res->Contact->contacttype_id;?>"><?php echo $res->Contacttype->title;?></option>
                                    <?php foreach($response1 as $res1){
                                      echo "<option value='".$res1->Contacttype->id."'>".$res1->Contacttype->title."</option>";
                                    }?>
                                  </select>
                                </div> 
                                
                              </div>
                              <input type="hidden" class="form-control" name="data[Contact][organization_id]" value="<?php echo $orgId;?>"/>
                              <div class="form-group">
                                <label class="control-label">First Name</label>
                                <div class="input-icon right">
                                  <input type="text" class="form-control" name="data[Contact][fname]" value="<?php echo $res->Contact->fname;?>" required/>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label">Last Name</label>
                                <div class="input-icon right">
                                  <input type="text" class="form-control" name="data[Contact][lname]" value="<?php echo $res->Contact->lname;?>" required/>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label">Email</label>
                                <div class="input-icon right">
                                  <input type="email" class="form-control" name="data[Contact][email]" value="<?php echo $res->Contact->email;?>" required/>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label">Contact Number</label>
                                <div class="input-icon right">
                                  <input type="number" class="form-control" name="data[Contact][phone]" value="<?php echo $res->Contact->phone;?>" required/>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                            <div class="form-actions right">
                              <button class="btn green" type="submit" name="editContact">Update</button>
                              <button data-dismiss="modal" class="btn default" type="button">Close</button>
                            </div>
                            </div>
                          </form>
                        </div>
                      </div>   
                    </div>
                  </div>
                  <div class="modal fade" id="delete_<?php echo $res->Contact->id;?>" tabindex="-1" role="basic" aria-hidden="true">            
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                          <h4 class="modal-title">Delete Contact</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo "Are you sure you want to delete contact ? "; ?>
                        </div>
                        <div class="modal-footer">
                          <form role="form" action="" method="post">
                            <input type="hidden" name="data[Contact][id]" value="<?php echo $res->Contact->id;?>"/>
                            <div class="form-actions right">
                              <button class="btn green" type="submit" name="deleteContactList">Delete</button>
                              <button data-dismiss="modal" class="btn default" type="button">Close</button>
                            </div>
                          </form>
                        </div>
                      </div>
                      <!-- /.modal-content -->
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
            <h4 class="modal-title">Add Contact</h4>
          </div>
          <div class="modal-body">
            <form role="form" id="addContactForm" action="" method="post">
              <div class="form-body">
                <div class="form-group">
                  <div class="input-icon right">
                    <label class="control-label">Branch</label>
                    <select id="selectBranch" class="form-control" name="data[Contact][branch_id]" required>
                      <?php foreach($response2 as $key2=>$value2){
                        echo "<option value='".$key2."'>".$value2."</option>";
                      }?>
                    </select>
                  </div><br>

                  <div class="input-icon right">
                    <label class="control-label">Contact Type</label>
                    <select id="selectContactType" class="form-control" name="data[Contact][contacttype_id]" required>
                      
                    </select>
                  </div>
                  
                </div>
                <input type="hidden" class="form-control" name="data[Contact][organization_id]"  value="<?php echo $orgId;?>"/>
                <div class="form-group">
                  <label class="control-label">First Name</label>
                  <div class="input-icon right">
                    <input type="text" required class="form-control" name="data[Contact][fname]"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Last Name</label>
                  <div class="input-icon right">
                    <input type="text" required class="form-control" name="data[Contact][lname]"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Email</label>
                  <div class="input-icon right">
                    <input type="email" required class="form-control" name="data[Contact][email]"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Contact Number</label>
                  <div class="input-icon right">
                    <input type="number" min="0" required class="form-control" name="data[Contact][phone]"/>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
              <div class="form-actions right">
                <button class="btn green" type="submit" name="submitContact">Submit</button>
                <button data-dismiss="modal" class="btn default" type="button">Close</button>
              </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    var orgId = '<?php echo $orgId ; ?>';
    var branchId = $("#selectBranch option:selected").val();
    selectContactType(orgId,branchId);

    $("#selectBranch").on('change',function(){
      var branchId = $(this).find('option:selected').val();
      selectContactType(orgId,branchId);
    });

    function selectContactType(orgId,branchId){
      var url = '<?php echo URL; ?>Contacttypes/contactTypeByBranch/'+orgId+'/'+branchId+'.json';

      $.ajax({
          url:url,
          datatype:'jsonp',
          type:'post',
          success:function(response) {
            if(response.length != 0){
              var option = '';
              $.each(response,function(key,val){
                option += '<option value="'+val.Contacttype.id+'">'+val.Contacttype.title+'</option>';
              });

              
            } else {
              option = '<option value="">No contact type available</option>';
            }
            $("#selectContactType").html(option);
            
          }
      });
    }

  });
</script>

<script>
  $(document).ready(function(){

    // $("#addContactForm").on('submit', function(event)
    //   {
    //     event.preventDefault();

    //     var e = $(this);
    //     var data = e.serialize();

    //     var url = '<?php echo URL;?>Contacts/saveContactList.json';

    //     $.ajax(
    //       {
    //         url:url,
    //         data:data,
    //         datatype:'jsonp',
    //         type:'post',
    //         async:false,
    //         success:function(res)
    //         {
    //           console.log(res);
    //           console.log(res.message);

    //           var table = $('#contactTable').DataTable({
    //             paginate:false,
    //             info:false,
    //             filter:false
    //           });
              
    //           var fname = res.resData.Contact.fname;
    //           var lname = res.resData.Contact.lname;
    //           var email = res.resData.Contact.email;
    //           var phone = res.resData.Contact.phone;
    //           var contype = res.resData.Contacttype.title;
    //           var branch = res.resData.Branch.title;
    //           var action = 

    //           <a href="#edit_<?php echo $res->Contact->id;?>" data-toggle="modal" id="sample_editable_1_new" class="btn green">
    //           <i class="fa fa-pencil"></i>  edit  </a><a href="#delete_<?php echo $res->Contact->id;?>" data-toggle="modal" class="btn red">
    //           <i class="fa fa-times"></i> Delete</a>

    //                 var rowNode = table
    //                     .row.add( [ 1,contype, fname+' '+lname, email, phone, branch ] )
    //                     .draw()
    //                     .node();
                     
    //                 $( rowNode )
    //                     .css( 'color', 'green' )
    //                     .animate( { color: 'black' } );
    //                     e.trigger('reset');
    //               e.closest('.modal-dialog').find('.close').click();
    //               toastr.success("Successfully added !!");
    //         }
    //       });
    //   });
    $('#contactTable').DataTable({

      paginate:false,
      info:false,
      filter:false
    }); 
  });
</script>
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