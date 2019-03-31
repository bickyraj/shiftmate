<?php
//get branch list related to particular organization
$url = URL. "Branches/orgBranches/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

if (isset($_POST["submit"])) {
    
    $url = URL. "Multiplypaymentfactortypes/addPaymentFactorType.json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    

if($response->body->output->status == '1')
    {
        echo("<script>location.href = '".URL_VIEW."paymentRates/listPaymentFactorType?org_id=".$orgId."';</script>");

        $_SESSION['success']="test";
    }
}
?>


<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Payment Rates<small> Payment Factor Types</small></h1>
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
                    <a href="javascript:;">Add Payment Rate</a>
                </li>
            </ul>

<div class="row">
    <div class="col-md-6">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Add Payment Factor Type
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                        <input type="hidden" name="data[Multiplypaymentfactortype][organization_id]" value="<?php echo $orgId;?>">
                    </div>
                    <div class="form-body">
                        <!-- <div style="display:none;">
                            <input type="hidden" name="data[Organizationrole][organization_id]" value="<?php echo $orgId;?>">
                            <input type="hidden" name="data[Organizationrole][status]" value="1">
                        </div> -->
                       <div class="form-group">
                            <label class="control-label col-md-4">
                    Multiply Factor Name <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input  class="form-control"  type="text" name="data[Multiplypaymentfactortype][title]" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <input type="submit" name="submit" value="Submit" class="btn green">
                                <a class="btn default" href="<?php echo URL_VIEW."paymentRates/listPaymentFactorType?org_id=".$orgId;?>">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                </form>
            </div>
        </div>
    </div>
</div>

















<!-- 
<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Add Payment Factor Type</div>
    </div>
    <div class="clear"></div>

<div class="form createShift">
<form action="" method="post" accept-charset="utf-8">
<input type="hidden" name="data[Multiplypaymentfactortype][organization_id]" value="<?php echo $orgId;?>">

	<table cellpadding="5px"> -->
    	<?php /*?><tr>
    	<th>Branch</th>
        <td><select name="data[Multiplypaymentfactortype][branch_id]">
        		<option value="0">All</option>
               <?php foreach($branches as $branche):?>
                <option value="<?php echo $branche->Branch->id;?>"><?php echo $branche->Branch->title;?></option>
                <?php endforeach;?>
            </select></td>
    </tr><?php */?>
      <!--  <tr>
    	<th>Multiply Factor Name</th>
        <td><input type="text" name="data[Multiplypaymentfactortype][title]" required /></td>
    </tr>
    <tr>
    	<td colspan="2">
            <a class="cancel_a" href="<?php echo URL_VIEW."paymentRates/listPaymentFactorType?org_id=".$orgId;?>">Cancel</a>
            <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>	
    </table>
</form>
</div> -->

<div class="clear"></div>

