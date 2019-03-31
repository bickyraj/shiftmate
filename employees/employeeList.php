<?php


//Get list of countries
$url = URL."Users/employeeList.json";
$employee = \Httpful\Request::get($url)->send();
$employees = $employee->body->employees;
echo "<pre>";
print_r($employees);




?>
<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Username</th>
			<th>Email</th>
                        <th>Phone</th>
			<th>Country</th>
			<th>City</th>
                        <th>Address</th>
			<th class="actions">Actions</th>
	</tr>
	</thead>
	<tbody>
             <?php $i = 1;?>
            <?php foreach($employees as $employee):?>
           
		<tr>
		<td><?php echo $i++;?></td>
		<td><?php echo $employee->User->fname.' '.$employee->User->lname;?></td>
		<td><?php echo $employee->User->username;?></td>
		<td><?php echo $employee->User->email;?></td>
		<td><?php echo $employee->User->phone;?></td>
		<td><?php echo $employee->Country->title;?></td>
		<td><?php echo $employee->City->title;?></td>
                <td><?php echo $employee->User->address;?></td>
		
		<td class="actions">
			<a href="orgView.php?org_id=<?php echo $organization->Organization->id;?>">View</a>
                        <a href="editEmployeeDetail.php?user_id=<?php echo $employee->User->id;?>">Edit</a>
                        <form action="/newshiftmate/Organizations/delete/1" name="post_5476f94dde83b126092591" id="post_5476f94dde83b126092591" style="display:none;" method="post"><input type="hidden" name="_method" value="POST"/></form><a href="#" onclick="if (confirm(&quot;Are you sure you want to delete # 1?&quot;)) { document.post_5476f94dde83b126092591.submit(); } event.returnValue = false; return false;">Delete</a>		</td>
	</tr>
        <?php endforeach;?>
	
	</tbody>
	</table>