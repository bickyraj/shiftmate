<?php
$orgId = $_GET['org_id'];

$url = URL ."Organizations/orgView/".$orgId.".json";
$org = \Httpful\Request::get($url)->send();
$organization = $org->body->organization;

// echo "<pre>";
// print_r($organization);
// die();





?>

<?php 
$userId = $organization->Organization->user_id;
//$orgId = $organization->Organization->id;
?>

<div class="tableHeader">
    

<!-- Table -->
<div class="branchDetails">
    <table width="100%">
        <tbody>
        <tr>
            <th>Organisation Name</th>
            <td>: <?php echo $organization->Organization->title;?></td>
        </tr>

        <tr>
            <th>Username</th>
            <td>: <?php echo $organization->User->username;?></td>
        </tr>
        
        <tr>
            <th>logo</th>
            <td>: 999</td>
        </tr>
        
        <tr>
            <th>Email</th>
            <td>: <?php echo $organization->Organization->email;?></td>
        </tr> 
        
        <tr>
            <th>Address</th>
            <td>: <?php echo $organization->Organization->address;?></td>
        </tr> 

        <tr>
            <th>Phone Number</th>
            <td>: <?php echo $organization->Organization->phone;?></td>
        </tr> 

        <tr>
            <th>Fax</th>
            <td>: <?php echo $organization->Organization->fax;?></td>
        </tr> 

        <tr>
            <th>Website</th>
            <td>: <?php echo $organization->Organization->website;?></td>
        </tr> 

        <tr>
            <th>City</th>
            <td>: <?php echo $organization->City->title;?></td>
        </tr> 

        <tr>
            <th>Country</th>
            <td>: <?php echo $organization->Country->title;?></td>
        </tr>  
    </tbody></table>
</div>
<!-- End of Table -->

