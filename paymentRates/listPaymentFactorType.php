<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php
$orgId = $_GET['org_id'];
$homePaymentrate = URL_VIEW.'paymentRates/listPaymentFactor?org_id='.$orgId;
$url_paymentFactorType = URL . "Multiplypaymentfactortypes/listPaymentFactorTypes/".$orgId. ".json";
$data = \Httpful\Request::get($url_paymentFactorType)->send();
$listPaymentFactorTypes = $data->body->listPaymentFactorTypes;
//echo "<pre>";
//print_r($listPaymentFactorTypes);
/*
Add payment factor type proce  by rabi
*/
$url = URL. "Branches/orgBranches/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

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
            <h4 class="modal-title">Add Payment Factor Type</h4>
        </div>
        <form action="" method="post" id="addListPayFactortype" accept-charset="utf-8" class="form-horizontal">
          <div style="display:none;">
                <input type="hidden" name="_method" value="POST"/>
                <input type="hidden" name="data[Multiplypaymentfactortype][organization_id]" value="<?php echo $orgId;?>">
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label class="control-label col-md-4">Multiply Factor Name <span class="required">
                * </span>
                </label>
                <div class="col-md-7">
                    <input  class="form-control"  type="text" name="data[Multiplypaymentfactortype][title]" required />
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="col-md-offset-3 col-md-9">
              <button data-dismiss="modal" class="btn default" type="button">Cancel</button>
              <input type="submit" name="submit" value="Add" class="btn green">
              <!-- <input type="reset" name="clear" value="Clear" class="addclear btn default"> -->
            </div>
          </div>
        </form>
      </div>
  </div>
</div>

<div class="page-head">
  <div class="container">
    <div class="page-title">
	     <h1>Payment Factor Type <small>Payment Factor Type</small></h1>
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
            <a href="<?php echo $homePaymentrate; ?>">Payment Factor</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="javascript:;">Payment Factor Type</a>
        </li>
    </ul>
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption caption-md">
              <i class="icon-bar-chart theme-font hide"></i>
              <span class="caption-subject theme-font bold uppercase">Role List</span>
              <!-- <span class="caption-helper hide">weekly stats...</span> -->
            </div>
            <div class="btn-group pull-right">
              <a href="#portlet-config_13" type="button" class="btn btn-fit-height green" data-toggle="modal">
              <i class="fa fa-plus"></i> Add Payment Factor Type
              </a>
          </div>
          </div>
          <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>
                     Sn
                  </th>
                 
                  <th>
                    Payment Factor Type Name
                  </th>
                  <!-- <th>
                    Action
                  </th> -->
                </tr>
              </thead>
              
              <tbody id = "paymentFactorTypeTable">
                <?php
                    if(isset($listPaymentFactorTypes) && !empty($listPaymentFactorTypes)){
                    $sno = 1;
                    foreach($listPaymentFactorTypes as $listPaymentFactorType){
                ?>
                    <tr class="odd gradeX">
                        <td><?php echo $sno++;?></td>
                        <td><?php echo $listPaymentFactorType->Multiplypaymentfactortype->title;?></td>
                        <!-- <td>
                            <!-- <button class="btn btn-xs default btn-editable">
                            <i class="fa fa-pencil"></i> Edit</button> -->
                            <!-- <button class="btn btn-xs label-danger">
                            <i class="fa fa-times"></i> Delete</button> 
                        </td> -->
                    </tr>
                <?php
                    }
                    }
                    else{
                ?>
                    <tr class="odd gradeX" id="noDataTr">
                        <td colspan="2">No Records Found.....</td>
                    </tr>  
                <?php
                    }
                ?>
              </tbody>
            </table>
              <script>
                  $(document).ready(function(){
                      $('#sample1_2_1').dataTable({});
                  })
              </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  $(function(){
      var orgId = '<?php echo $orgId; ?>';
     $("#addListPayFactortype").on('submit',function(event){
          event.preventDefault();
          var ev = $(this);
          var data = $(this).serialize();
          $.ajax({
              url : '<?php echo URL."Multiplypaymentfactortypes/addPaymentFactorTypewithData/"."'+orgId+'".".json"; ?>',
              type : "post",
              data : data,
              datatype : "jsonp",
              success:function(response)
              {
                 // console.log(response);
                  var listpayFacDisplay = '';
                  if(response.output == 1)
                  {
                    listpayFacDisplay = '<tr><td>1</td><td>'+response.mpft.Multiplypaymentfactortype.title+'</td></tr>';
                    toastr.success('Payment factor type added successfully.');
                    $('#paymentFactorTypeTable tr').each(function(i, el) {
                          var obj = $(this).find('td').eq(0);
                          var newNumber = parseInt(obj.text())+1;
                              obj.text(newNumber);
                      });
                    $("#paymentFactorTypeTable").prepend(listpayFacDisplay);
                    ev.find('.addclear').click();
                    ev.find('.addclose').click();
                    ev.closest('.modal-dialog').find('.addclose').click();

                    if($('#noDataTr'))
                    {
                        $("#noDataTr").remove();
                    }

                  }
                  else
                  {
                    toastr.danger('Something wrong. Please, try again.');
                  }

              }
          });
      });
  });
</script>

















<!-- Success Div -->
<!-- <div id="save_success">Saved Successfully !!</div> -->
<!-- End of Success Div -->


<!-- <div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Holiday List</div>
            
        <a href="<?php echo URL_VIEW . 'paymentRates/addPaymentFactorType'; ?>"><button class="addBtn">Add Payment Factor Type</button></a>
    </div>
    <div class="clear"></div>
     <div class="submenu">
<ul>
    <li><a style="color:#000;" href="<?php echo URL_VIEW . 'paymentRates/listPaymentFactor?org_id=' . $orgId; ?>">Payment Factor </a></li>
    
</ul>
</div> -->

    <!-- Table -->
    <!-- <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>S.No</p></th>
            <th><p>Payment Factor Type Name</p></th>
            <th><p>Action</p></th>
        </tr>
        <?php if(isset($listPaymentFactorTypes) && !empty($listPaymentFactorTypes)){
            $sno = 1;
                foreach($listPaymentFactorTypes as $listPaymentFactorType){
        ?>
        <tr style="height:40px;">
            <td><?php echo $sno++;?></td>
            <td><?php echo $listPaymentFactorType->Multiplypaymentfactortype->title;?></td>
            <td><button class="delete_img"></button></td>
         </tr>
        <?php } }?>
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
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
