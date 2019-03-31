<?php


$orgId = $_GET['org_id'];
$userId = $_GET['user_id'];


$url = URL . "OrganizationUsers/organizationEmployeeDetail/".$orgId."/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$orgEmployee = $data->body->employee;

// echo "<pre>";
// print_r($orgEmployee);
?>

<div class="profile_outer_div"><div class="profile_heading">Employee Detail</div></div>

<div class="profile">
    
    <div class="basic-info">
        <table>
        <tbody><tr>
            <th>Name <span>-</span></th>
            <td><?php echo $orgEmployee->User->fname." ".$orgEmployee->User->lname;?></td>
        </tr>
        
        <tr>
            <th>Username <span>-</span></th>
            <td><?php echo $orgEmployee->User->username;?></td>
        </tr> 

        <tr>
            <th>Designation <span>-</span></th>
            <td><?php echo $orgEmployee->OrganizationUser->designation;?></td>
        </tr> 

        <tr>
            <th>Organization Branch <span>-</span></th>
            <td><?php echo $orgEmployee->Branch->title;?></td>
        </tr> 

        <tr>
            <th>Hired Date <span>-</span></th>
            <td><?php echo $orgEmployee->OrganizationUser->hire_date;?></td>
        </tr> 

        <tr>
            <th>Wage <span>-</span></th>
            <td><?php echo $orgEmployee->OrganizationUser->wage;?></td>
        </tr> 



        </tr>

        <tr>
            <th>City <span>-</span></th>
            <td><?php echo $orgEmployee->User->City->title;?></td>
        </tr> 

        <tr>
            <th>Country <span>-</span></th>
            <td><?php echo $orgEmployee->User->Country->title;?></td>
        </tr>
    </tbody></table>
</div>