<?php


//Get list of countries
$url = URL."Organizations/orgList.json";
$org = \Httpful\Request::get($url)->send();
$organizations = $org->body->organizations;
echo "<pre>";
//print_r($org->body->users);




?>
<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Email</th>
			<th>Website</th>
			<th>Country</th>
			<th>City</th>
			<th class="actions">Actions</th>
	</tr>
	</thead>
	<tbody>
             <?php $i = 1;?>
            <?php foreach($organizations as $organization):?>
           
		<tr>
		<td><?php echo $i++;?></td>
		<td><?php echo $organization->Organization->title;?></td>
		<td><?php $organization->User->email;?></td>
		<td><?php echo $organization->Organization->website;?></td>
		<td><?php echo $organization->Country->title;?></td>
		<td><?php echo $organization->City->title;?></td>
		<td>9999999999&nbsp;</td>
		
		<td class="actions">
			<a href="orgView.php?org_id=<?php echo $organization->Organization->id;?>">View</a>
                        <a href="orgEdit.php?user_id=<?php echo $organization->Organization->user_id;?>">Edit</a>
                        <form action="/newshiftmate/Organizations/delete/1" name="post_5476f94dde83b126092591" id="post_5476f94dde83b126092591" style="display:none;" method="post"><input type="hidden" name="_method" value="POST"/></form><a href="#" onclick="if (confirm(&quot;Are you sure you want to delete # 1?&quot;)) { document.post_5476f94dde83b126092591.submit(); } event.returnValue = false; return false;">Delete</a>		</td>
	</tr>
        <?php endforeach;?>
	
	</tbody>
	</table>