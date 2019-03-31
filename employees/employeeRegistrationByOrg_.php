<?php

$orgId = $_GET['org_id'];
//Get list of countries
$url = URL . "Countries/getCountryList.json";
$countryList = \Httpful\Request::get($url)->send();
$countries = $countryList->body->countries;

//Get List of Cities
$url = URL . "Cities/cityList.json";
$cityList = \Httpful\Request::get($url)->send();
$cities = $cityList->body->cities;

$url = URL . "Organizationroles/orgRoleList/".$orgId.".json";
$orgRole = \Httpful\Request::get($url)->send();
$orgRoleList = $orgRole->body->orgRoleList;


$url = URL . "Branches/BranchesList/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

if (isset($_POST["submit"])) {
   
    // print_r($_POST['data']);
    $url = URL . "Users/employeeRegistrationByOrg/".$orgId.".json";
    $response = \Httpful\Request::post($url)
    ->sendsJson()
    ->body($_POST['data'])
    ->send();


   if($response->body->output->status == '1')
    {
        echo("<script>location.href = '".URL_VIEW."organizationUsers/listOrganizationEmployees?org_id=".$orgId."';</script>");

        $_SESSION['success']="test";
    }

    else
    {
        $_SESSION['fail']= 'test';


    }
}
?>



<div class="tableHeader">
    <div class="blueHeader">

        <ul class="subNav subNav_left subNav_edit">
            <li><a class="active" href="<?php echo URL_VIEW;?>employees/employeeRegistrationByOrg?org_id=<?php echo $orgId;?>">Add new employee</a></li>
            
            <li><a href="<?php echo URL_VIEW;?>organizationUsers/assignEmployeeToOrganization?org_id=<?php echo $orgId;?>">Add existing employee</a></li>

            <li><a href="<?php echo URL_VIEW;?>users/requestEmployeeToOrganization?org_id=<?php echo $orgId;?>">Send Request</a></li>
        </ul>

    </div>
    <div class="clear"></div>
    <div class="form createShift">

        <form action="" id="OrganizationUserAddForm" method="post" accept-charset="utf-8">
            <div style="display:none;">
                <input type="hidden" name="_method" value="POST"/>
            </div>
            <!-- Table -->
            <table cellpadding="5px">
             <tr>
                <th colspan="2" class="employee-h">User Details</th>
            </tr>

            <tr>
                <th>First Name</th>
                <td><input name="data[User][fname]" maxlength="200" type="text" id="UserFname" required/></td>
            </tr>

            <tr>
                <th>Last Name</th>
                <td><input name="data[User][lname]" maxlength="200" type="text" id="UserLname" required/></td>
            </tr>

            <tr>
                <th>Username</th>
                <td><input name="data[User][username]" maxlength="200" type="text" id="UserUsername" required/></td>
            </tr>

            <tr>
                <th>password</th>
                <td><input name="data[User][password]" maxlength="200" type="password" id="UserPassword" required/></td>
            </tr>

            <tr>
                <th>Confirm Password</th>
                <td><input name="data[User][confirm_password]" maxlength="200" type="password" required/></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><input name="data[User][email]" maxlength="200" type="email" id="UserEmail" required/></td>
            </tr>

            <tr>
                <th>Date Of Birth</th>
                <td>
                    <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
                      <input name="data[User][dob]" id="UserDob" class="span2" size="16" type="text" value=""/>
                      <div class="add-on" style="cursor:pointer;"></div>
                    </div>
                </td>
                <!-- <td><input name="data[User][dob]" maxlength="200" type="text" id="UserDob" required="required"/></td> -->
            </tr>

            <tr>
                <th>Address</th>
                <td><input name="data[User][address]" maxlength="200" type="text" id="UserAddress" required/></td>
            </tr>

            <tr>
                <th>Phone</th>
                <td><input name="data[User][phone]" maxlength="200" type="text" id="UserPhone" required/></td>
            </tr>

            <tr>
                <th>Country</th>
                <td><select name="data[User][country_id]" id="UserCountryId" required>
                    <?php foreach ($countries as $key => $country): ?>
                    <option value="<?php echo $key; ?>"><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select></td>
        </tr>

        <tr>
            <th>City</th>
            <td> <select name="data[User][city_id]" id="UserCityId" required>
                <?php foreach ($cities as $key => $city): ?>
                <option value="<?php echo $key; ?>"><?php echo $city; ?></option>
            <?php endforeach; ?>
        </select></td>
    </tr>

    <tr>
        <th>State</th>
        <td><input name="data[User][state]" maxlength="200" type="text" id="UserState" required/></td>
    </tr>

    <tr>
        <th>Zip Code</th>
        <td><input name="data[User][zipcode]" maxlength="200" type="text" id="UserZipcode" required/></td>
    </tr>

    <tr>
       <th colspan="2" class="employee-h">Organization User Detail</th>
   </tr>

   <tr>
    <th>Branch</th>
    <td> <select name="data[OrganizationUser][0][branch_id]" id="OrganizationUserBranchId" required>
        <?php foreach ($branches as $key => $branch): ?>
        <option value="<?php echo $key; ?>"><?php echo $branch; ?></option>
    <?php endforeach; ?>
</select></td>
</tr>  

<tr>
    <th >Organization Role</th>
    <td><select name="data[OrganizationUser][0][organizationrole_id]" id="OrganizationUserOrganizationroleId" required>
        <?php foreach ($orgRoleList as $key => $role): ?>
        <option value="<?php echo $key; ?>"><?php echo $role; ?></option>
    <?php endforeach; ?>
</select></td>
</tr>

<tr>
    <th>Designation</th>
    <td><input name="data[OrganizationUser][0][designation]" maxlength="200" type="text" id="OrganizationUserDesignation" required/></td>
</tr>

<tr>
    <th>Hire Date</th>
    <td><!--<input name="data[OrganizationUser][0][hire_date]" type="text" id="OrganizationUserHireDate" required/>-->
    	<div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
          <input name="data[OrganizationUser][0][hire_date]" id="OrganizationUserHireDate" class="span2" size="16" type="text" value=""/>
          <div class="add-on" style="cursor:pointer;"></div>
    </td>
</tr>

<tr>
    <th>Wage Per Hour</th>
    <td><input name="data[OrganizationUser][0][wage]" type="number" id="OrganizationUserWage" required/></td>
</tr>

<tr>
    <th>Max Weekly Hour</th>
    <td> <input name="data[OrganizationUser][0][max_weekly_hour]" type="number" id="OrganizationUserMaxWeeklyHour" required/>
    </td>
</tr>

<tr>
    <th>Employee Type</th>
    <td> <select name="data[OrganizationUser][0][status]" id="OrganizationUserStatus" required>
        <option value="1">Permanent</option>
        <option value="0">Temporary</option>
    </select>
</td>
</tr>

<tr>
    <td colspan="2">
        <a class="cancel_a" href="<?php echo URL_VIEW."organizationUsers/listOrganizationEmployees?org_id=1";?>">Cancel</a>
        <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
</tr>
</table>
<!-- End of Table -->
</form>


</div>



</div>





