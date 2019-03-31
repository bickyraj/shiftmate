<?php 
$orgId = $_GET['org_id'];
?>

<div class="tableHeader">
    <div class="blueHeader">

        <ul class="subNav subNav_left subNav_edit">
            
            <li><a href="<?php echo URL_VIEW . 'employees/employeeRegistrationByOrg?org_id=' . $orgId; ?>">Add new employee</a></li>
            
            <li><a href="<?php echo URL_VIEW . 'organizationUsers/assignEmployeeToOrganization?org_id=' . $orgId; ?>">Add existing employee</a></li>

            <li><a href="<?php echo URL_VIEW . 'users/requestEmployeeToOrganization?org_id=' . $orgId; ?>">Send Request</a></li>
        </ul>
       <!--  <a href="http://192.168.1.104/shiftmate_view/organizationUsers/addEmployee?org_id=1"><button class="addBtn">Add Employee</button></a> -->

    </div>
    <div class="clear"></div>

    <!-- Table -->
    <table class="table_list" width="98%;" align="center">
        <tbody>
        	<tr>

            </tr>
            </tbody></table>
    <!-- End of Table -->


</div>