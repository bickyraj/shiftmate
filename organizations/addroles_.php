<?php
		//$orgId = $_GET['org_id'];
		if (isset($_POST["submit"])) {
			//$name=$_POST['name'];
			$url = URL. "Organizationroles/add.json";
    		$response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    //echo "<pre>";
    //print_r($response->body->output);
	 echo("<script>location.href = '".URL_VIEW."organizations/organizationrole?org_id=".$orgId."';</script>");
			}
	
	?>
<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Add Payment Factor</div>
    </div>
    <div class="clear"></div>
    

<div class="form createShift">
<form action="" method="post" accept-charset="utf-8">
<input type="hidden" name="data[Organizationrole][organization_id]" value="<?php echo $orgId;?>">
<input type="hidden" name="data[Organizationrole][status]" value="1">
	<table cellpadding="5px">
    	<tr>
    	<th>Name Of Role</th>
        <td><input type="text" name="data[Organizationrole][title]" required /></td>
    </tr>
    <tr>
    	<td colspan="2">
            <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>	
    </table>
</form>
</div>

<div class="clear"></div>