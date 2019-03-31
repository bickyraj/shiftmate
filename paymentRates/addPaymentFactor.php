<?php
//get branch list related to particular organization
$url = URL. "Branches/orgBranches/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

// for payment factor type
$url_paymentFactorType = URL . "Multiplypaymentfactortypes/listPaymentFactorTypes/".$orgId. ".json";
$data = \Httpful\Request::get($url_paymentFactorType)->send();
$listPaymentFactorTypes = $data->body->listPaymentFactorTypes;
//echo "<pre>";
//print_r($listPaymentFactorTypes);

// $url = URL. "ShiftBranches/getBranchRelatedShift/6.json";
// $data = \Httpful\Request::get($url)->send();
// $shifts = $data->body;

// echo "<pre>";
// print_r($shifts);

if (isset($_POST["submit"])) {

    $url = URL. "MultiplyPaymentFactors/addPaymentFactor.json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    

if($response->body->output->status == '1')
    {
        echo("<script>location.href = '".URL_VIEW."paymentRates/listPaymentFactor?org_id=".$orgId."';</script>");
    }
}
?>
<!-- Edit -->
<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Add Payment Factor <small> Add Payment Factor</small></h1>
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
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">Add Payment Factor</a>
                </li>
            </ul><br />
            
<div class="row">
    <div class="col-md-6">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Payment Factor
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" method="post" accept-charset="utf-8" class="form-horizontal">
                    <input type="hidden" name="data[MultiplyPaymentFactor][organization_id]" value="<?php echo $orgId;?>">
                    <input type="hidden" name="data[MultiplyPaymentFactor][status]" value="1">
                    <div class="form-body">     
                        <div class="form-group">
                            <label class="control-label col-md-4">Branch <span class="required">
                            * </span>
                            </label>
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
                                     <select id="select_shift" class="form-control">
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
                        <div class="form-group">
                            <label class="control-label col-md-4">Implement Date <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
                                <input class="form-control date-picker" name="data[MultiplyPaymentFactor][implement_date]" data-date-format="yyyy-mm-dd" size="16" type="text" value="">
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
                                <input class="form-control date-picker" name="data[MultiplyPaymentFactor][end_date]" data-date-format="yyyy-mm-dd" size="16" type="text" value="">
                                <div class="add-on" style="cursor:pointer;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <input type="submit" name="submit" class="btn green" value="Add" />
                                <a class="btn default" href="<?php echo URL_VIEW."paymentRates/listPaymentFactor?org_id=".$orgId;?>">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script type="text/javascript">

    $(function()
        {

            if($("#select_branch").val() == 0)
            {
                $("#select_factorType option[value='6']").hide();
            }
            else
            {
                $("#select_factorType option[value='6']").show();
            }

            $("#select_branch").change(function(ev)
                {
                    var branch_id = $(this).val();

                    if(branch_id == 0)
                    {

                        var selectObject = $("#select_factorType");

                       $("#select_factorType option[value='6']").hide();

                       $('#select_factorType option:first-child').attr("selected", "selected");

                       $("#select_shift").removeAttr('name');
                        $(".shift_select_div").hide();
                        // selectObject.remove();
                    }

                    else
                    {
                        $("#select_factorType option[value='6']").show();
                    }

                    populateShiftSelect(branch_id);
                });

            $("#select_factorType").change(function(ev)
                {
                    var e = $(this);
                    var shift_select_div = $(".shift_select_div");

                    if(e.val() == 6)
                    {
                        $("#select_shift").attr('name','data[MultiplyPaymentFactor][shift_id]');  
                        var branch_id = $("#select_branch").val();
                        shift_select_div.show();
                        populateShiftSelect(branch_id);
                    }
                    else
                    {

                        $("#select_shift").removeAttr('name');
                        shift_select_div.hide();
                    }
                });

                function populateShiftSelect(branchId)
                {
                    $("#select_shift").html('');
                    // var urli = '<?php echo URL. "ShiftBranches/getBranchRelatedShift/"."'+branchId+'".".json";?>';

                        $.ajax(
                            {
                                url:'<?php echo URL_VIEW."process.php";?>',
                                type:'post',
                                data:"action=getBranchRelatedShift&branchId="+branchId,
                                success:function(response)
                                {
                                    var response = JSON.parse(response);
                                    // console.log(response);
                                    $.each(response,function(key, value)
                                        {
                                            var shift = value.Shift;
                                            var option_data = '<option value="'+shift.id+'">'+shift.title+'</option>';

                                            $("#select_shift").append(option_data);
                                        });
                                }
                            });

                }

                $(".date-picker").datepicker();
        });
</script>

