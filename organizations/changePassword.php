<?php


$orgId = $_GET['org_id'];

//get userId using org Id.
$url = URL . "Organizations/getUserIdFromOrgId/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$userId = $data->body->userId;

if (isset($_POST["submit"])) {
    echo "<pre>";
    // print_r($_POST['data']);
    $url = URL. "Organizations/changePassword/" . $orgId . ".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    //echo "<pre>";
   // print_r($response);
    echo("<script>location.href = '".URL_VIEW."';</script>");
}
?>

<div class="tableHeader">
    <div class="blueHeader">
       <ul class="subNav subNav_left">
                <li><a href="<?php echo URL_VIEW . 'organizations/orgView?org_id='.$orgId;?>">Profile</a></li>
                <li><a href="<?php echo URL_VIEW . 'organizations/orgEdit?user_id=' .$userId?>">Edit Profile</a></li>
                <li><a class="active" href="<?php echo URL_VIEW . 'organizations/changePassword?org_id=' .$orgId; ?>">Change Password</a></li>
                <!-- <li><a href="<?php echo URL_VIEW . 'organizationUsers/listOrganizationEmployees?org_id=' . $organization->Organization->id; ?>">List Users in Organization</a></li> -->
                <!-- <li><a href="<?php echo URL_VIEW . 'users/requestEmployeeToOrganization?org_id=' . $organization->Organization->id; ?>">Request Employee</a></li> -->
        </ul>
    </div>
    <div class="clear"></div>

<div class="form createShift">
<form action=""  method="post" accept-charset="utf-8">
	<table cellpadding="5px">
    <tr>
    	<th>Old Password</th>
        <td><input type="password" name="data[User][old_password]" /></td>
    </tr>
    
    <tr>
    	<th>New Password</th>
        <td><input type="password" name="data[User][password]" /></td>
    </tr>	
    
    <tr>
    	<th>Confirm Password</th>
        <td><input type="password" name="data[User][confirm_password]" /></td>
    </tr>
    
    <tr>
    	<td colspan="2"><input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>	
    </table>
</form>
</div>

<div class="clear"></div>

