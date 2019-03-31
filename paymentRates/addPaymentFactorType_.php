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

<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Add Payment Factor Type</div>
    </div>
    <div class="clear"></div>

<div class="form createShift">
<form action="" method="post" accept-charset="utf-8">
<input type="hidden" name="data[Multiplypaymentfactortype][organization_id]" value="<?php echo $orgId;?>">

	<table cellpadding="5px">
    	<?php /*?><tr>
    	<th>Branch</th>
        <td><select name="data[Multiplypaymentfactortype][branch_id]">
        		<option value="0">All</option>
               <?php foreach($branches as $branche):?>
                <option value="<?php echo $branche->Branch->id;?>"><?php echo $branche->Branch->title;?></option>
                <?php endforeach;?>
            </select></td>
    </tr><?php */?>
       <tr>
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
</div>

<div class="clear"></div>

