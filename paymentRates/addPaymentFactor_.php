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

if (isset($_POST["submit"])) {
    
    $url = URL. "MultiplyPaymentFactors/addPaymentFactor.json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    

if($response->body->output->status == '1')
    {
        echo("<script>location.href = '".URL_VIEW."paymentRates/listPaymentFactor?org_id=".$orgId."';</script>");

        $_SESSION['success']="test";
    }
}
?>

<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Add Payment Factor</div>
    </div>
    <div class="clear"></div>

<div class="form createShift">
<form action="" method="post" accept-charset="utf-8">
<input type="hidden" name="data[MultiplyPaymentFactor][organization_id]" value="<?php echo $orgId;?>">
<input type="hidden" name="data[MultiplyPaymentFactor][status]" value="1">
	<table cellpadding="5px">
    	<tr>
    	<th>Branch</th>
        <td><select name="data[MultiplyPaymentFactor][branch_id]">
        		<option value="0">All</option>
               <?php foreach($branches as $branche):?>
                <option value="<?php echo $branche->Branch->id;?>"><?php echo $branche->Branch->title;?></option>
                <?php endforeach;?>
            </select></td>
    </tr>
    <tr>
    	<th>Factor Type</th>
        <td><select name="data[MultiplyPaymentFactor][multiplypaymentfactortype_id]">
        		<?php foreach($listPaymentFactorTypes as $listPaymentFactorType):?>
                <option value="<?php echo $listPaymentFactorType->Multiplypaymentfactortype->id;?>"><?php echo $listPaymentFactorType->Multiplypaymentfactortype->title;?></option>
                <?php endforeach;?>
            </select></td>
    </tr>
       <tr>
    	<th>Multiply Factor</th>
        <td><input type="text" name="data[MultiplyPaymentFactor][multiply_factor]" required /></td>
    </tr>
    
    <tr>
    	<th>Implement Date</th>
        <td><!--<input type="text" name="data[MultiplyPaymentFactor][implement_date]" required />-->
        	<div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
          <input name="data[MultiplyPaymentFactor][implement_date]" class="span2" size="16" type="text" value=""/>
          <div class="add-on" style="cursor:pointer;"></div>
        </td>
    </tr>
     <tr>
    	<th>Expire Date</th>
        <td><!--<input type="text" name="data[MultiplyPaymentFactor][end_date]" required />-->
        	   <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
              <input name="data[MultiplyPaymentFactor][end_date]" class="span2" size="16" type="text" value=""/>
              <div class="add-on" style="cursor:pointer;"></div>
        </td>
    </tr>	
    <tr>
    	<td colspan="2">
            <a class="cancel_a" href="<?php echo URL_VIEW."paymentRates/listPaymentFactor?org_id=".$orgId;?>">Cancel</a>
            <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>	
    </table>
</form>
</div>

<div class="clear"></div>

