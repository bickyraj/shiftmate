<?php


$orgId = $_GET['org_id'];


//get userId using org Id.
$url = URL . "Organizations/getUserIdFromOrgId/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$userId = $data->body->userId;

// $url = URL . "Organizationroles/orgRoleList/".$orgId.".json";
// $orgRole = \Httpful\Request::get($url)->send();
// $orgRoleList = $orgRole->body->orgRoleList;
$url = URL . "Organizationroles/organizationRoleList/".$orgId.".json";
 $orgRole = \Httpful\Request::get($url)->send();
 $orgRoleList = $orgRole->body->orgRoleList;
// echo "<pre>";
// print_r($orgRoleList);

$url = URL . "Branches/BranchesList/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;


$url = URL . "OrganizationUsers/listEmployeesNotInOrg/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$employees = $data->body->employees;

foreach ($employees as $employee ) {
    $employ_name[] = $employee->User->fname." ".$employee->User->lname;
}
// echo "<pre>";
// print_r($employ_name);



if (isset($_POST["submit"])) {
   // echo "<pre>";
    // print_r($_POST['data']);
    $url = URL . "OrganizationUsers/assignEmployeeToOrganization/".$orgId.".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    //echo "<pre>";
    //print_r($response);
}
?>

<script type="text/javascript">

$(function(){


    var employ = <?php echo json_encode($employ_name);?>
    // var employ = [{ value: 'Afghan afghani', data: 'AFN' },
    //     { value: 'Albanian lek', data: 'ALL' },
    //     { value: 'Algerian dinar', data: 'DZD' },
    //     { value: 'European euro', data: 'EUR' },
    //     { value: 'Angolan kwanza', data: 'AOA' },
    //     { value: 'East Caribbean dollar', data: 'XCD' },
    // ];

    



      $('#autocomplete').autocomplete({
        lookup: employ,
        onSelect: function (suggestion) {
          var thehtml = '<strong>Currency Name:</strong> ' + suggestion.value + ' <br> <strong>Symbol:</strong> ' + suggestion.data;
          $('#outputcontent').html(thehtml);
        }
      });
});

</script>
<div class="tableHeader">
    <div class="blueHeader">

        <ul class="subNav subNav_left subNav_edit">

            <li><a href="<?php echo URL_VIEW;?>employees/employeeRegistrationByOrg?org_id=1">Add new employee</a></li>
            
            <li><a class="active" href="<?php echo URL_VIEW;?>organizationUsers/assignEmployeeToOrganization?org_id=1">Add existing employee</a></li>

            <li><a href="<?php echo URL_VIEW;?>users/requestEmployeeToOrganization?org_id=1">Send Request</a></li>
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
     <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
        <input type="hidden" name="data[User][id]" value="<?php echo $userId;?>"/>
        <input type="hidden" name="data[Organization][id]" value="<?php echo $organization->id;?>"/>
    </div>
    <tr>
        <th>Select User</th>
        <!-- <td> <select name="data[OrganizationUser][user_id]" id="OrganizationUserUserId" required>
                <?php foreach ($employees as  $employee): ?>
                    <option value="<?php echo $employee->User->id; ?>"><?php echo $employee->User->fname.' '.$employee->User->lname; ?></option>
                <?php endforeach; ?>
            </select></td> -->
            <td>
                <div id="searchfield">
                    <form><input type="text" name="data[OrganizationUser][user_id]"  class="biginput" id="autocomplete" required></form>
              	</div>
          	</td>
    </tr>

    <tr>
        <th>Branch</th>
        <td> <select name="data[OrganizationUser][branch_id]" id="OrganizationUserBranchId" required>
                <?php foreach ($branches as $key => $branch): ?>
                    <option value="<?php echo $key; ?>"><?php echo $branch; ?></option>
                <?php endforeach; ?>
            </select></td>
    </tr>  

    <tr>
        <th>Organization Role</th>
        <td><select name="data[OrganizationUser][organizationrole_id]" id="OrganizationUserOrganizationroleId" required>
                <?php foreach ($orgRoleList as $key => $role): ?>
                    <option value="<?php echo $key; ?>"><?php echo $role; ?></option>
                <?php endforeach; ?>
            </select></td>
    </tr>
   
     <tr>
        <th>Designation</th>
        <td><input name="data[OrganizationUser][designation]" maxlength="200" type="text" id="OrganizationUserDesignation" required/></td>
    </tr>

     <tr>
        <th>Hire Date</th>
        <td><!--<input name="data[OrganizationUser][hire_date]" type="text" id="OrganizationUserHireDate" required/>-->
        	<div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
          <input name="data[OrganizationUser][hire_date]" id="OrganizationUserHireDate" class="span2" size="16" type="text" value=""/>
          <div class="add-on" style="cursor:pointer;"></div>
        </td>
    </tr>
    
     <tr>
        <th>Wage Per Hour</th>
        <td><input name="data[OrganizationUser][wage]" type="number" id="OrganizationUserWage" required/></td>
    </tr>
   
    <tr>
        <th>Max Weekly Hour</th>
        <td> <input name="data[OrganizationUser][max_weekly_hour]" type="number" id="OrganizationUserMaxWeeklyHour" required/>
                </td>
    </tr>
  
     <tr>
        <th>Employee Type</th>
        <td> <select name="data[OrganizationUser][status]" id="OrganizationUserStatus" required>
                <option value="1">Permanent</option>
                <option value="0">Temporary</option>
            </select>
            </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <a class="cancel_a" href="http://192.168.1.104/shiftmate_view/organizationUsers/listOrganizationEmployees?org_id=1">Cancel</a>
            <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>   
    </table>
    <!-- End Table -->
</form>
</div>
