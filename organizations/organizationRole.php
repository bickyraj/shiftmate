<?php
$listRole = '';
$url_paymentFactor = URL . "Organizationroles/organizationRoleList/".$orgId. ".json";
$data = \Httpful\Request::get($url_paymentFactor)->send();
$listRole = $data->body->orgRoleList;
// echo "<pre>";
// print_r($listRole);

//$orgId = $_GET['org_id'];
   //  if (isset($_POST["submit"])) {
   //    //$name=$_POST['name'];
   //    $url = URL. "Organizationroles/add.json";
   //      $response = \Httpful\Request::post($url)
   //          ->sendsJson()
   //          ->body($_POST['data'])
   //          ->send();
   //  //echo "<pre>";
   //  //print_r($response->body->output);
   // echo("<script>location.href = '".URL_VIEW."organizations/organizationRole?org_id=".$orgId."';</script>");
   //    }
?>


<!-- Save Success Notification -->
<script type="text/javascript">
    $(document).ready(function()
        {
            var top_an = $("#save_success").css('top');
            $("#save_success").css('top','0px');

            <?php if(isset($_SESSION['success'])):?>
                $("#save_success").show().animate({top:top_an});
                <?php unset($_SESSION['success']);?>
                setTimeout(function()
                    {
                        $("#save_success").fadeOut();
                    }, 3000);
            <?php endif;?>
        });
</script>
<!-- End of Save Success Notification -->
<style>
.label-danger {
  color: #ffffff;
}
</style>
<!-- Edit-->
<div class="modal fade" id="portlet-config_13" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="addclose close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Add Role</h4>
        </div>
        <form action="" method="post" id="addOrgRole" accept-charset="utf-8" class="form-horizontal">
          <div style="display:none;">
               <input type="hidden" name="data[Organizationrole][organization_id]" value="<?php echo $orgId;?>">
                <input type="hidden" name="data[Organizationrole][status]" value="1">
          </div>
          <div class="modal-body">
               <div class="form-group">
                 <label class="control-label col-md-4">
                  Name Of Role <span class="required">
                          * </span>
                  </label>
                  <div class="col-md-7">
                    <input class="form-control" type="text" name="data[Organizationrole][title]" required />
                  </div>
                </div>
          </div>
          <div class="modal-footer">
            <div class="col-md-offset-3 col-md-9">
              <input type="submit" name="submit" value="Add" class="btn green">
              <input type="reset" name="clear" value="Clear" class="addClear btn default">
            </div>
          </div>
        </form>
    </div>                        
  </div>
</div>
    
<div class="page-head">
  <div class="container">
    <div class="page-title">
	   <h1> Organisation Roles <!-- <small>View Role List</small> --></h1>
    </div>
  </div>
</div>
<div class="page-content">
  <div class="container">
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo URL_VIEW; ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="<?=URL_VIEW.'organizations/organizationRole';?>">Oranisation Roles</a>
        </li>
    </ul>

    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="portlet light">
          <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-user font-green-sharp"></i>
                <span class="caption-subject font-green-sharp bold uppercase">Organisation Roles</span>
                <!-- <span class="caption-helper">alert samples...</span> -->
              </div>
              <div class="btn-group pull-right">
                <a href="#portlet-config_13" class="btn btn-md btn-success btn-fit-height dropdown-toggle" data-toggle="modal">
                  <i class="fa fa-plus"></i> Add New Role  
                </a>
              </div>
          </div>
          <div class="portlet-body">
                  <table class="table table-striped table-bordered table-hover" id="sample_1">
                  <thead>
                  <tr>
                   
                    <th>
                      SN
                    </th>
                    <th>
                      Role Name
                    </th>
                    <th>
                       Action
                    </th>
                  </tr>
                  </thead>
                  <tbody id="displayOrgRole">
                  <?php 
                      if(isset($listRole) && !empty($listRole)){
                      if(count($listRole) > 0){
                      $sno = 1;
                      foreach($listRole as $key=>$listRoles){
                        //print_r($key);
                    ?>
                      <tr data-roleId="<?php echo $key; ?>" data-roleValue="<?php echo $listRoles; ?>">
                        
                        <td>
                           <?php echo $sno++;?>
                        </td>
                        <td id="role_<?php echo $key; ?>">
                          <?php echo $listRoles; ?>
                        </td>
                        <td>
                            <span class="btn btn-primary btn-sm editButton"> <i class="fa fa-pencil"></i>Edit</span>&nbsp;&nbsp;

                            <span class="btn btn-danger btn-sm deleteButton"><i class="fa fa-trash-o"></i> Delete</span>
                        </td>
                        
                      </tr>
                     <?php 
                        }}}
                         else{
                          ?>
                                  <tr style="height:40px;" id = "noOrgroleData">
                                  <td>-</td>
                                  <td>-</td>
                                  <td>-</td>
                                  </tr>
                                  <?php
                          }
                      ?>
                 
                  </tbody>
                  </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="addclose close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Edit Role</h4>
        </div>
        <form action="" method="post" id="editForm" accept-charset="utf-8" class="form-horizontal">
          <div class="modal-body">
               <div class="form-group">
                 <label class="control-label col-md-4">
                  Name Of Role <span class="required">
                          * </span>
                  </label>
                  <div class="col-md-7">
                    <input value="" class="form-control" type="text" name="data[Organizationrole][title]" required />
                    <input value="" class="form-control" type="hidden" name="data[Organizationrole][id]">
                  </div>
                </div>
          </div>
          <div class="modal-footer">
            <div class="col-md-offset-3 col-md-9">
              <input type="submit" name="submit" value="Update" class="btn green">
              <input type="reset" name="clear" value="Clear" class="addClear btn default">
            </div>
          </div>
        </form>
    </div>                        
  </div>
</div>










<!-- Success Div -->
<!-- <div id="save_success">Saved Successfully !!</div> -->
<!-- End of Success Div -->


<!-- <div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Roles List</div>
            
        <a href="<?php echo URL_VIEW . 'organizations/addroles'; ?>?org_id=<?php echo $orgId ?>"><button class="addBtn">Add Roles</button></a>
    </div>
    <div class="clear"></div>
     

    <!-- Table -->
    <!--<table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>S.No</p></th>
            <th><p>Role Name</p></th>
            <th><p>Action</p></th>
    </tr>
        <?php if(isset($listRole) && !empty($listRole)){
      if(count($listRole) > 0){
      $sno = 1;
        foreach($listRole as $listRoles){
          
      ?>
        <tr style="height:40px;">
          <td><?php echo $sno++;?></td>
            <td><?php echo $listRoles; ?></td>
            <td><button class="delete_img"></button></td>
         <?php 
      }}}
       else{
        ?>
                <tr style="height:40px;">
                <td colspan="4"><h4>No records found</h4></td>
                </tr>
                <?php
        }
    ?>
    
        </table> -->
    <!-- End of Table -->

    <!-- Bulk Action -->
                <!-- <div class="bulkaction-div">
                        <select>
                          <option value="volvo">Bulk Action</option>
                          <option value="saab">Delete</option>
                        </select>
                        <button id="bulkBtn">Apply</button>
                </div> -->
                <!-- End of Bulk Action -->

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/table-advanced.js"></script>
<script>
  $(document).ready(function(){
   
    $(".editButton").live("click",function(){
      var roleId = $(this).closest('tr').attr('data-roleId');
      var roleValue = $(this).closest('tr').attr('data-roleValue');
      var modal = $("#editModal");
      modal.find("input[name='data[Organizationrole][title]']").val(roleValue);
      modal.find("input[name='data[Organizationrole][id]']").val(roleId);
      modal.modal();
    });

    $("#editForm").on('submit',function(event){
      var orgId = '<?php echo $orgId;?>';
      event.preventDefault();
      var ev = $(this);
      var data = ev.serialize();
      var url = "<?php echo URL; ?>Organizationroles/editRole/"+orgId+".json";
      $.ajax({
        url:url,
        type:'post',
        datatype:'jsonp',
        data:data,
        success:function(response){
          var status = response.status;
          if(status == 1){
            window.location.reload(true);
            var id = response.data.Organizationrole.id;
            var title = response.data.Organizationrole.title;
            $("#role_"+id).text(title);

            toastr.success("Organization role updated Successfully.");
          } else if(status == 2) {
            toastr.info("Record already exist.Please try again.");
          } else {
            toastr.info("Something went wrong.Please try again.");
          }
        }
      });

      $("#editModal").modal('hide');
    });

    $(".deleteButton").live("click",function(){
      var th = $(this);
      var roleId = $(this).closest('tr').attr('data-roleId');
      console.log("test");
      var url = "<?php echo URL; ?>Organizationroles/deleteRole/"+roleId+".json";
      $.ajax({
        url:url,
        type:'post',
        datatype:'jsonp',
        success:function(response){
          var status = response.status;
          if(status == 1){
            th.closest('tr').remove();

            if($("#displayOrgRole").find('tr').length == 0)
            {
              $("#displayOrgRole").html("").html('<tr id="noOrgroleData"><td>--</td><td>--</td><td>--</td></tr>');
            }
            toastr.success("Record successfully deleted.");
          } else {
            toastr.info("Something went wrong.Please try again.");
          }
        }
      });

    });

  });
</script>
<script>
$(function(){
    var orgId = '<?php echo $orgId; ?>';
   $("#addOrgRole").on('submit',function(event){
        event.preventDefault();
        var ev = $(this);
        var data = $(this).serialize();
        $.ajax({
            url : '<?php echo URL."Organizationroles/addorgRolewithData/"."'+orgId+'".".json"; ?>',
            type : "post",
            data : data,
            datatype : "jsonp",
            success:function(response)
            {
                console.log(response);
                var orgRoledata = '';
                if(response.output == 1)
                {
                  orgRoledata = '<tr data-roleId="'+response.orgRole.Organizationrole.id+'" data-roleValue="'+response.orgRole.Organizationrole.title+'"><td>1</td><td id="role_'+response.orgRole.Organizationrole.id+'">'+response.orgRole.Organizationrole.title+'</td><td><span class="btn btn-primary btn-sm editButton"><i class="fa fa-pencil"></i>Edit</span>&nbsp;&nbsp;<span class="btn btn-danger btn-sm deleteButton"><i class="fa fa-trash-o"></i> Delete</span></td></tr>';
                  toastr.success('Roles added Successfully');
                  $('#displayOrgRole tr').each(function(i, el) {
                        var obj = $(this).find('td').eq(0);
                        var newNumber = parseInt(obj.text())+1;
                            obj.text(newNumber);
                    });
                  $("#noOrgroleData").remove();
                  $("#displayOrgRole").prepend(orgRoledata);
                  
                }
                else if(response.output == 2){
                  toastr.info("Organisation role already exists.");
                } else
                {
                  toastr.success('Something went wrong.Please try again.');
                }

                ev.closest('.modal-dialog').find('.addClear').click();
                ev.closest('.modal-dialog').find('.addclose').click();

            }
        });
    });
});
</script>
<script>

jQuery(document).ready(function() {       
  
   TableAdvanced.init();
});
</script>