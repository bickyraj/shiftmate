<?php


$orgId = $_GET['org_id'];
$userId = $_GET['user_id'];


$url = URL . "Organizationroles/orgRoleList/".$orgId.".json";
$orgRole = \Httpful\Request::get($url)->send();
$orgRoleList = $orgRole->body->orgRoleList;


$url = URL . "Branches/BranchesList/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

$url = URL . "Users/getUserDetailById/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$userDetail = $data->body->userDetail;




if (isset($_POST["submit"])) {
    echo "<pre>";
    // print_r($_POST['data']);
    $url = URL . "OrganizationUsers/updateRequestedEmployeeDetail/".$orgId."/".$userId.".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    echo "<pre>";
    print_r($response);
}
?>

<table>
    <tr>
        <th colspan="2">Employee Detail:</th>
    </tr>
    <tr>
        <td>Name</td>
        <td><?php echo $userDetail->User->fname.' '.$userDetail->User->lname;?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?php echo $userDetail->User->email;?></td>
    </tr>
    <tr>
        <td>Username</td>
        <td><?php echo $userDetail->User->username;?></td>
    </tr>
    <tr>
        <td>Address</td>
        <td><?php echo $userDetail->User->address;?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    
</table>

<form action="" id="OrganizationUserAddForm" method="post" accept-charset="utf-8">
    <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
    </div>
    <fieldset>
        <legend>Update Requested Employee Detail</legend>
        
        
        <div class="input select required">
            <label for="OrganizationUserBranchId">Branch</label>
            <select name="data[OrganizationUser][branch_id]" id="OrganizationUserBranchId" required="required">
                <?php foreach ($branches as $key => $branch): ?>
                    <option value="<?php echo $key; ?>"><?php echo $branch; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input select required">
            <label for="OrganizationUserOrganizationroleId">Organization Role</label>
            <select name="data[OrganizationUser][organizationrole_id]" id="OrganizationUserOrganizationroleId" required="required">
                <?php foreach ($orgRoleList as $key => $role): ?>
                    <option value="<?php echo $key; ?>"><?php echo $role; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input text required">
            <label for="OrganizationUserDesignation">Designation</label>
            <input name="data[OrganizationUser][designation]" maxlength="200" type="text" id="OrganizationUserDesignation" required="required"/>
        </div>
        <div class="input date required">
            <label for="OrganizationUserHireDateMonth">Hire Date</label>
            <input name="data[OrganizationUser][hire_date]" type="text" id="OrganizationUserHireDate" required="required"/>
            
        </div>
        <div class="input number required">
            <label for="OrganizationUserWage">Wage Per Hour</label>
            <input name="data[OrganizationUser][wage]" type="number" id="OrganizationUserWage" required="required"/>
        </div>
        <div class="input number required">
            <label for="OrganizationUserMaxWeeklyHour">Max Weekly Hour</label>
            <input name="data[OrganizationUser][max_weekly_hour]" type="number" id="OrganizationUserMaxWeeklyHour" required="required"/>
        </div>
        <div class="input number required">
            <label for="OrganizationUserStatus">Employee Type</label>
            <select name="data[OrganizationUser][status]" id="OrganizationUserStatus" required="required">
                <option value="1">Permanent</option>
                <option value="0">Temporary</option>
            </select>
        </div>
    </fieldset>
    <div class="submit">
        <input  type="submit" name="submit" value="Submit"/>
    </div>
</form>