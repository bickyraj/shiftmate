<?php
$url = URL . "OrganizationUsers/myOrganizations/" . $user_id . ".json";
$data = \Httpful\Request::get($url)->send();
$myOrganizations = $data->body->myOrganizations;
//echo "<pre>";
//print_r($myOrganizations);
?>

<h1>My Organizations</h1>
<table class="table_list" width="98%;" align="center">
    <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
    	<th>SN</th>
        <th>Organization Name</th>
        <th>Branch Name</th>
        <th>Organization Role</th>
        <th>Action</th>
	</tr>
    <?php
		$count = 1;
	 foreach($myOrganizations as $myOrganization){?>   
    <tr class="list_users">
    	<td><?php echo $count;?></td>
        <td><a href="<?php echo URL_VIEW."organizationUsers/employee/orgView?org_id=".$myOrganization->Organization->id."&branch_id=".$myOrganization->Branch->id;?>"><?php echo $myOrganization->Organization->title;?></a></td>
        <td><?php echo $myOrganization->Branch->title;?></td>
        <td><?php echo $myOrganization->OrganizationUser->designation;?></td>
        <td class="action_td">
                    <ul class="action_btn">
                        <li><div class="hover_action"></div>
                            <a href="<?php echo URL_VIEW."organizationUsers/employee/orgView?org_id=".$myOrganization->Organization->id."&branch_id=".$myOrganization->Branch->id;?>"><button 
                                    class="view_img"></button>
                            </a>
                        </li>
                    </ul>
        </td>
    <?php $count++; } ?>
</table>