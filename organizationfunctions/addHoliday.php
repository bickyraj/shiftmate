<?php
//get branch list related to particular organization
$url = URL. "Branches/orgBranches/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

if (isset($_POST["submit"])) {
    
    $url = URL. "Organizationfunctions/addFunction.json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
   /* echo "<pre>";
	print_r($response);
die();*/
if($response->body->output->status == '1')
    {
        echo("<script>location.href = '".URL_VIEW."organizationfunctions/listHoliday?org_id=".$orgId."';</script>");

        $_SESSION['success']="test";
    }
}
?>

<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Add Holiday</div>
    </div>
    <div class="clear"></div>

<div class="form createShift">
<form action="" method="post" accept-charset="utf-8">
<input type="hidden" name="data[Organizationfunction][organization_id]" value="<?php echo $orgId;?>">
<input type="hidden" name="data[Organizationfunction][status]" value="0">
	<table cellpadding="5px">
    	<tr>
    	<th>Branch</th>
        <td><select name="data[Organizationfunction][branch_id]">
        		<option value="0">All</option>
               <?php foreach($branches as $branche):?>
                <option value="<?php echo $branche->Branch->id;?>"><?php echo $branche->Branch->title;?></option>
                <?php endforeach;?>
            </select></td>
    </tr>
       <tr>
    	<th>Date</th>
        <td><!--<input type="text" name="data[Organizationfunction][function_date]"  required />-->
        <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
          <input name="data[Organizationfunction][function_date]" class="span2" size="16" type="text" value=""/>
          <div class="add-on" style="cursor:pointer;"></div>
        </div>
        </td>
    </tr>
    
    <tr>
    	<th>Note</th>
        <td><input type="text" name="data[Organizationfunction][note]" required /></td>
    </tr>	
    <tr>
    	<td colspan="2">
            <a class="cancel_a" href="<?php echo URL_VIEW."organizationfunctions/listHoliday?org_id=".$orgId;?>">Cancel</a>
            <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>	
    </table>
</form>
</div>

<div class="clear"></div>

