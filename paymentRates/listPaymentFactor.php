<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php

$url_paymentFactor = URL . "MultiplyPaymentFactors/listPaymentFactors/".$orgId. ".json";
$data = \Httpful\Request::get($url_paymentFactor)->send();
$listPaymentFactors = $data->body->listPaymentFactors;
// fal($listPaymentFactors);
// echo "<pre>";
// print_r($listPaymentFactors);

// for payment factor type
$url = URL. "Branches/orgBranches/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;


$url_paymentFactorType = URL . "Multiplypaymentfactortypes/listPaymentFactorTypes/".$orgId. ".json";
$data = \Httpful\Request::get($url_paymentFactorType)->send();
$listPaymentFactorTypes = $data->body->listPaymentFactorTypes;

// fal($listPaymentFactorTypes);
// echo "<pre>";
// print_r($listPaymentFactorTypes);

// $url = URL. "ShiftBranches/getBranchRelatedShift/6.json";
// $data = \Httpful\Request::get($url)->send();
// $shifts = $data->body;

// echo "<pre>";
// print_r($shifts);

// if (isset($_POST["submit"])) {
//     //         echo "<pre>";
//     // print_r($_POST['data']);
//     // //die();
//     if($_POST['data']['MultiplyPaymentFactor']['status'] == 'on'){
//        $_POST['data']['MultiplyPaymentFactor']['status'] = 1; 
//     }else{
//         $_POST['data']['MultiplyPaymentFactor']['status'] = 0;
//     }
//     echo "<pre>";
//     print_r($_POST['data']);
//     die();
//     $url = URL. "MultiplyPaymentFactors/addPaymentFactor.json";
//     $response = \Httpful\Request::post($url)
//             ->sendsJson()
//             ->body($_POST['data'])
//             ->send();
//             echo "<pre>";
//     print_r($response);
//     die();

// if($response->body->output->status == '1')
//     {
//         echo("<script>location.href = '".URL_VIEW."paymentRates/listPaymentFactor?org_id=".$orgId."';</script>");
//     }
// }
?>

    <!-- Add payment Factor Model form -->
<div class="modal fade" id="portlet-config_13" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="addclose close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Payment Factor</h4>
            </div>
           <form action="" method="post" id="addListPaymentFactor" accept-charset="utf-8" class="form-horizontal">
                <div style="display:none;">
                  <input type="hidden" name="data[MultiplyPaymentFactor][organization_id]" value="<?php echo $orgId;?>">
                    <input type="hidden" name="data[MultiplyPaymentFactor][status]" value="1">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-4">Branch <span class="required">
                        * </span>
                        </label>
                        <!-- bickyraj -->
                        <div class="col-md-7">
                            <select id="select_branch" class="form-control" name="data[MultiplyPaymentFactor][branch_id]">
                                <option value="0">All</option>
                               <?php foreach($branches as $branche):?>
                                <option value="<?php echo $branche->Branch->id;?>"><?php echo $branche->Branch->title;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Factor Type <span class="required">
                        * </span>
                        </label>
                        <div class="col-md-7">
                             <select id="select_factorType" class="form-control" name="data[MultiplyPaymentFactor][multiplypaymentfactortype_id]">
                                <?php foreach($listPaymentFactorTypes as $listPaymentFactorType):?>
                                <option value="<?php echo $listPaymentFactorType->Multiplypaymentfactortype->id;?>"><?php echo $listPaymentFactorType->Multiplypaymentfactortype->title;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group shift_select_div" style="display:none">
                        <label class="control-label col-md-4">Shift <span class="required">
                        * </span>
                        </label>
                        <div class="col-md-7">
                             <select id="select_shift" required data-errormessage-value-missing="Please, Select Shift" class="form-control" name="data[MultiplyPaymentFactor][shift_id]" disabled>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Multiply Factor <span class="required">
                        * </span>
                        </label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="data[MultiplyPaymentFactor][multiply_factor]" required />
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="control-label col-md-4">Implement Date</label>
                        <div class="col-md-4">
                            <div class="input-group input-large date-picker input-daterange" data-date="12-02-2015" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control" name="data[MultiplyPaymentFactor][implement_date]">
                                <span class="input-group-addon">
                                Expire Date </span>
                                <input type="text" class="form-control" name="data[MultiplyPaymentFactor][end_date]">
                            </div>
                        </div>
                    </div> -->
                    <!-- <input type="checkbox" name="data[MultiplyPaymentFactor][status]" id="myCheckbox"> -->
                    <div id="dateImplementation">
                        <div class="form-group">
                            <label class="control-label col-md-4">Implement Date <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
                                <input required class="form-control date-picker" name="data[MultiplyPaymentFactor][implement_date]" data-date-format="yyyy-mm-dd" size="16" type="text" value="">
                                  <div class="add-on" style="cursor:pointer;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Expire Date <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
                                    <input required class="form-control date-picker" name="data[MultiplyPaymentFactor][end_date]" data-date-format="yyyy-mm-dd" size="16" type="text" value="">
                                    <div class="add-on" style="cursor:pointer;"></div>
                                </div>
                            </div>                              
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8" style="float:right;">
                            <div class="md-checkbox">
                                <input type="checkbox" id="checkbox1" class="md-check" name="data[MultiplyPaymentFactor][status]">
                                <label for="checkbox1">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                Always</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-offset-3 col-md-9">
                        <button data-dismiss="modal" class="btn default" type="button">Cancel</button>
                        <input type="submit" id="btnAdd" name="submit" value="Submit" class="addclear btn green">
                        <!-- <input type="reset" name="clear" value="Clear" class="addclear btn default"> -->
                        <!-- <a class="btn default" href="<?php echo URL_VIEW."groups/listGroups?org_id=".$orgId;?>">Cancel</a> -->
                    </div>
                </div>
          </form>
        </div>
    </div>
</div>
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>List Payment Factor <small>View List Payment Factor</small></h1>
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
                    <a href="<?=URL_VIEW."paymentRates/listPaymentFactor";?>">Payment Factors</a>
                </li>
        </ul>

        <div class="row" id="portletDisplay">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Payment Factor</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                        <div class="btn-group pull-right">
                            <a href="#portlet-config_13" data-toggle="modal" class="btn btn-fit-height green" type="button"><i class="fa fa-plus"></i> Add Payment Factor
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-hover table-bordered" id="paymentTable">
                            <thead>
                            <tr>
                                <th >
                                    Branch
                                </th>
                                <th>Payment Factor Type</th>
                                <th>Multiply Factor</th>
                                <th>Implement Date</th>
                                <th>Expire Date</th>
                                <th>Always</th>
                            </tr>
                            </thead>
                            <tbody id="groupTable">
                                 <?php if(isset($listPaymentFactors) && !empty($listPaymentFactors)){
                                        $sno = 1;
                                        foreach($listPaymentFactors as $listPaymentFactor){
                                    ?>
                                    <tr class="text-capitalize">
                                        <td><?php echo $listPaymentFactor->Branch->title;?> </td>
                                        <td>
                                            <?php if ($listPaymentFactor->MultiplyPaymentFactor->multiplypaymentfactortype_id ==0): ?>
                                                <?php echo $listPaymentFactor->Shift->title;?> (Shift)
                                            <?php else: ?>
                                                    <?php echo $listPaymentFactor->Multiplypaymentfactortype->title ;?>
                                            <?php endif ?>
                                        </td>
                                        <td><?php echo $listPaymentFactor->MultiplyPaymentFactor->multiply_factor ;?> </td>
                                        <td>
                                            <?php 
                                                if (strtotime($listPaymentFactor->MultiplyPaymentFactor->implement_date) !="") {
                                                    # code...
                                                     $date = $listPaymentFactor->MultiplyPaymentFactor->implement_date;
                                                     $ImplementDate= DateTime::createFromFormat('Y-m-d', $date);
                                                     echo $ImplementDate->format('M d,Y');
                                                }
                                                else
                                                {
                                                    echo "--";
                                                }
                                            ?>
                                         </td>
                                        <td>
                                            <?php 
                                            if (strtotime($listPaymentFactor->MultiplyPaymentFactor->end_date) !="") {
                                                # code...
                                                 $date = $listPaymentFactor->MultiplyPaymentFactor->end_date;
                                                 $ExpireDate= DateTime::createFromFormat('Y-m-d', $date);
                                                 echo $ExpireDate->format('M d,Y');
                                            }
                                            else
                                            {
                                                echo "--";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if($listPaymentFactor->MultiplyPaymentFactor->status == 2){ ?>
                                                Always
                                            <?php } else{ ?>
                                            --
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php 
                                        }
                                    }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


     <!--<?php if(isset($listPaymentFactors) && !empty($listPaymentFactors)){
            $sno = 1;
                foreach($listPaymentFactors as $listPaymentFactor){
            ?>
                
               <div class="col-md-6 col-sm-12">
                    <div class="portlet green box">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i><?php echo $listPaymentFactor->Branch->title;?>  
                            </div>
                            <div class="actions">
                                <!-- <a href="javascript:;" class="btn btn-default btn-sm">
                                <i class="fa fa-pencil"></i> Edit </a> -->
                                <!-- <a href="javascript:;" class="btn btn-default btn-sm">
                                <i class="fa fa-times"></i> Delete </a> -->
                           <!-- </div>
                        </div>
                        <div class="portlet-body" style="height:140px;">
                            <!-- <div class="row static-info">
                                <div class="col-md-5 name">
                                    Branch Name:
                                </div>
                                <div class="col-md-7 value">
                                     <?php echo $listPaymentFactor->Branch->title;?>                   
                                </div>
                            </div> -->
                           <!-- <div class="row static-info">
                                <div class="col-md-5 name">
                                     Payment Factor Type:
                                </div>
                                <div class="col-md-7 value">
                                     <?php echo $listPaymentFactor->Multiplypaymentfactortype->title ;?>                    
                                </div>
                            </div>
                            <div class="row static-info">
                                <div class="col-md-5 name">
                                     Multiply Factor:
                                </div>
                                <div class="col-md-7 value">
                                     <?php echo $listPaymentFactor->MultiplyPaymentFactor->multiply_factor ;?>                
                                </div>
                            </div>
                            <?php if($listPaymentFactor->MultiplyPaymentFactor->status == 2){ ?>
                             <div class="row static-info">
                                <div class="col-md-5 name">
                                     Implement For:
                                </div>
                                <div class="col-md-7 value">
                                     Always        
                                </div>
                            </div>
                            
                            <?php }else{ ?>
                                <div class="row static-info">
                                    <div class="col-md-5 name">
                                         Implement Date:
                                    </div>
                                    <div class="col-md-7 value">
                                         <?php 
                                         $date = $listPaymentFactor->MultiplyPaymentFactor->implement_date;
                                         $ImplementDate= DateTime::createFromFormat('Y-m-d', $date);
                                         echo $ImplementDate->format('M d,Y');
                                         ?>                  
                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">
                                         Expire Date:
                                    </div>
                                    <div class="col-md-7 value">
                                         <?php 
                                             $date = $listPaymentFactor->MultiplyPaymentFactor->end_date;
                                             $ExpireDate= DateTime::createFromFormat('Y-m-d', $date);
                                             echo $ExpireDate->format('M d,Y');
                                         ?>                
                                    </div>
                                </div> 
                            <?php } ?>
                        </div>
                    </div>
                </div>

        <?php 
            }
        }else {
        ?>
            <div class="col-md-6 col-sm-12" style="border:1px solid #fdfdfd;" id="noRecord">
                
                            No Record Found....
                        
                   
            </div>
        <?php } ?>
    
 </div> -->  




 













<!-- Success Div -->
<!-- <div id="save_success">Saved Successfully !!</div>
 --><!-- End of Success Div -->


<!-- <div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Holiday List</div>
            
        <a href="<?php echo URL_VIEW . 'paymentRates/addPaymentFactor'; ?>"><button class="addBtn">Add Payment Factor</button></a>
    </div>
    <div class="clear"></div>
     <div class="submenu">
<ul>
	<li><a style="color:#000;" href="<?php echo URL_VIEW . 'paymentRates/listPaymentFactorType?org_id=' . $orgId; ?>">Payment Factor Type</a></li>
    
</ul>
</div> -->

    <!-- Table -->
   <!--  <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>S.No</p></th>
            <th><p>Branch Name</p></th>
            <th><p>Payment Factor Type</p></th>
            <th><p>Multiply Factor</p></th>
            <th><p>Implement Date</p></th>
            <th><p>Expire Date</p></th>
            <th><p>Action</p></th>
		</tr>
        <?php if(isset($listPaymentFactors) && !empty($listPaymentFactors)){
			$sno = 1;
				foreach($listPaymentFactors as $listPaymentFactor){
			?>
        <tr style="height:40px;">
        	<td><?php echo $sno++;?></td>
            <td><?php echo $listPaymentFactor->Branch->title;?></td>
            <td><?php echo $listPaymentFactor->Multiplypaymentfactortype->title ;?></td>    
            <td><?php echo $listPaymentFactor->MultiplyPaymentFactor->multiply_factor ;?></td>
            <td><?php echo $listPaymentFactor->MultiplyPaymentFactor->implement_date ;?></td>
            <td><?php echo $listPaymentFactor->MultiplyPaymentFactor->end_date ;?></td>
            <td><button class="delete_img"></button></td>
         <?php 
			}}
		?>
		
        </table> -->
    <!-- End of Table -->

    <!-- Bulk Action -->
                <!-- div class="bulkaction-div">
                        <select>
                          <option value="volvo">Bulk Action</option>
                          <option value="saab">Delete</option>
                        </select>
                        <button id="bulkBtn">Apply</button>
                </div> -->
                <!-- End of Bulk Action -->

<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script src="<?php echo URL_VIEW; ?>js/date-format/date.format.js" type="text/javascript"></script>

<script type="text/javascript">

    $(function()
        {
            // $("#addListPaymentFactor").submit(function() {
            //     $(this).submit(function() {
            //         return false;
            //     });
            //     return true;
            // });

            $("#paymentTable").DataTable({info:false, paging:false, searching:false});

            var fTypeVal = $("#select_factorType").val();

            function checkAlways(status)
            {
                if(status == 1)
                {
                    $("#dateImplementation").hide();
                    $("input[name='data[MultiplyPaymentFactor][implement_date]']").prop('disabled', true);
                    $("input[name='data[MultiplyPaymentFactor][end_date]']").prop('disabled', true);
                    $("#checkbox1").prop("disabled", true);
                    $("#checkbox1").closest('.md-checkbox').hide();
                }else
                {
                    $("#dateImplementation").show();
                    $("input[name='data[MultiplyPaymentFactor][implement_date]']").prop('disabled', false);
                    $("input[name='data[MultiplyPaymentFactor][end_date]']").prop('disabled', false);
                    $("#checkbox1").prop("disabled", false);
                    $("#checkbox1").closest('.md-checkbox').show();
                }
            }

            if(fTypeVal == 1 || fTypeVal == 2)
            {
                checkAlways(1);
            }

            $("#checkbox1").on('click', function(event)
            {
                if($(this).is(':checked'))
                {
                    $("#dateImplementation").hide();
                    $("input[name='data[MultiplyPaymentFactor][implement_date]']").prop('disabled', true);
                    $("input[name='data[MultiplyPaymentFactor][end_date]']").prop('disabled', true);
                }else
                {
                    $("#dateImplementation").show();
                    $("input[name='data[MultiplyPaymentFactor][implement_date]']").prop('disabled', false);
                    $("input[name='data[MultiplyPaymentFactor][end_date]']").prop('disabled', false);
                }
            });

            if($("#select_branch").val() != 0)
            {
                $("#select_factorType").append("<option value='0'>Shift</option>");
            }else
            {
                $("select[name='data[MultiplyPaymentFactor][shift_id]']").prop('disabled', true);
            }

            $("#select_branch").change(function(ev)
                {
                    var branch_id = $(this).val();

                    if(branch_id == 0)
                    {
                        console.log(branch_id);

                        var selectObject = $("#select_factorType");

                       $("#select_factorType option[value='0']").remove();

                       $('#select_factorType option:first-child').attr("selected", "selected");

                       $("#select_shift").removeAttr('name');
                       $(".shift_select_div").hide();
                       $("select[name='data[MultiplyPaymentFactor][shift_id]']").prop('disabled', true);

                        // selectObject.remove();

                        if(selectObject.val() == 1 || selectObject.val() == 2)
                        {
                            checkAlways(1);
                        }else
                        {
                            checkAlways(2);
                        }
                    }

                    else
                    {   
                        var selectObject = $("#select_factorType");

                        $("#select_factorType option[value='0']").remove();
                        $("#select_factorType").append("<option value='0'>Shift</option>");

                        if($("#select_factorType").val()==0)
                        {
                            $(".shift_select_div").show();
                            $("select[name='data[MultiplyPaymentFactor][shift_id]']").prop('disabled', false);
                        }else
                        {
                            $(".shift_select_div").hide();
                            $("select[name='data[MultiplyPaymentFactor][shift_id]']").prop('disabled', true);
                        }
                        if(selectObject.val() == 1 || selectObject.val() == 2)
                        {
                            checkAlways(1);
                        }else
                        {
                            checkAlways(2);
                        }
                    }

                    populateShiftSelect(branch_id);
                });

            $("#select_factorType").change(function(ev)
                {
                    var e = $(this);

                    var ftval = e.val();
                    var shift_select_div = $(".shift_select_div");

                    if(ftval == 0)
                    {
                        $("#select_shift").attr('name','data[MultiplyPaymentFactor][shift_id]');  
                        var branch_id = $("#select_branch").val();
                        shift_select_div.show();
                        $("select[name='data[MultiplyPaymentFactor][shift_id]']").prop('disabled', false);
                        populateShiftSelect(branch_id);
                        checkAlways(2);
                    }
                    else if (ftval == 1 || ftval == 2)
                    {
                        $("#select_shift").removeAttr('name');
                        shift_select_div.hide();
                        $("select[name='data[MultiplyPaymentFactor][shift_id]']").prop('disabled', true);
                        checkAlways(1);
                    }
                    else
                    {

                        $("#select_shift").removeAttr('name');
                        shift_select_div.hide();
                        $("select[name='data[MultiplyPaymentFactor][shift_id]']").prop('disabled', true);
                        checkAlways(2);
                    }
                });

                function populateShiftSelect(branchId)
                {
                    $("#select_shift").html('');
                    var url = '<?php echo URL;?>ShiftBranches/getBranchRelatedShift/'+branchId+'.json';

                    $.ajax(
                        {
                            url:url,
                            type:'post',
                            dataType:'jsonp',
                            asycnc:false,
                            success:function(response)
                            {
                                console.log("shift:"+response.status);
                                var option_data = "";

                                if(response.status ==1)
                                {

                                    $.each(response.shiftList,function(key, value)
                                        {
                                            var shift = value.Shift;
                                            option_data += '<option value="'+shift.id+'">'+shift.title+'</option>';

                                        });
                                }
                                else
                                {
                                    option_data = '<option value="">No shifts on this branch.</option>';   
                                }
                                $("#select_shift").html("").append(option_data);
                            }
                        });
                }

                $(".date-picker").datepicker();
           $("#addListPaymentFactor").on('submit',function(event)
               {
                    $("#btnAdd").attr("disabled","disabled");
                    event.preventDefault();
                    
                    var ev = $(this);
                    var orgid = '<?php echo $orgId; ?>';

                    var data1 = ev.serializeArray();
                    // console.log(data1);
                    var data = $(this).serialize();
                    // console.log(data);
                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth()+1; //January is 0!
                    var yyyy = today.getFullYear();

                    if(dd<10) {
                        dd='0'+dd
                    } 

                    if(mm<10) {
                        mm='0'+mm
                    } 

                    todaydate = yyyy+'-'+mm+'-'+dd;
                        $.ajax({
                            url : '<?php echo URL."MultiplyPaymentFactors/addPaymentFactor/"."'+orgid+'".".json"; ?>',
                            type : "post",
                            data : data,
                            datatype : "jsonp",
                            success:function(response)
                            {
                                
                                console.log(response);
                                // window.location.reload(true);
                                if (response.output.status ==1) {

                                    var data = response.output.data;
                                    var table = $('#paymentTable').DataTable();
                                    table.destroy();
                                    
                                    var table = $('#paymentTable').DataTable({info:false, paging:false, searching:false});
                                    
                                    if(data.constructor === Array)
                                    {
                                        $.each(data, function(k,v)
                                        {
                                            var status= "--";
                                            if(v.MultiplyPaymentFactor.status == 2)
                                            {
                                                status = "Always";
                                            }

                                            if(!isNaN(Date.parse(v.MultiplyPaymentFactor.implement_date)))
                                            {
                                                var impD = dateToString(v.MultiplyPaymentFactor.implement_date);
                                                var endD = dateToString(v.MultiplyPaymentFactor.end_date);
                                            }
                                            else
                                            {
                                                var impD = "--";
                                                var endD = "--";
                                            }
                                            table.row.add([v.Branch.title,v.Multiplypaymentfactortype.title , v.MultiplyPaymentFactor.multiply_factor,impD, endD, status]).draw().node();
                                        });
                                    }
                                    else
                                    {
                                        var status= "--";
                                            if(data.MultiplyPaymentFactor.status == 2)
                                            {
                                                status = "Always";
                                            }

                                            if(data.MultiplyPaymentFactor.shift_id != 0)
                                            {
                                                var fTitle = data.Shift.title +' (Shift)';
                                            }
                                            else
                                            {
                                                var fTitle = data.Multiplypaymentfactortype.title;
                                            }

                                        if(!isNaN(Date.parse(data.MultiplyPaymentFactor.implement_date)))
                                            {
                                                var impD = dateToString(data.MultiplyPaymentFactor.implement_date);
                                                var endD = dateToString(data.MultiplyPaymentFactor.end_date);
                                            }
                                            else
                                            {
                                                var impD = "--";
                                                var endD = "--";
                                            }
                                            table.row.add([data.Branch.title, fTitle, data.MultiplyPaymentFactor.multiply_factor, impD, endD,  status]).draw().node();
                                    }                            

                                    if($("#portlet-config_13").modal('hide')){
                                        $("#btnAdd").removeAttr("disabled");
                                    }
                                    toastr.success('Record saved successfully.');
                                }
                                


                            }
                        });
                });

            function dateToString(date)
                {
                    today = new Date(date);
                    var dateString = today.format("mmm d, yyyy");

                    return dateString;
                } 
        });
</script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   TableManaged.init();
    
   // TableEditable.init();
});
</script>