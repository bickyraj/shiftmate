<?php
	
	$url = URL . "Organizations/OrganizationProfile/" . $orgId . ".json";
	$data = \Httpful\Request::get($url)->send();
	$org_profile = $data->body->output;

	// echo "<pre>";
	// print_r($org_profile);

?>


<h1><?php echo $org_profile->Organization->title;?></h1>

<img src='<?php echo URL."webroot/files/organization/logo/".$org_profile->Organization->logo_dir."/thumb_".$org_profile->Organization->logo;?>'/>

<ul>
	<li><?php echo $org_profile->Organization->address;?></li>
	<li><?php echo $org_profile->Organization->phone;?></li>
	<li><?php echo $org_profile->Organization->fax;?></li>
	<li><?php echo $org_profile->Organization->website;?></li>

	<li><?php echo $org_profile->City->title;?></li>
	<li><?php echo $org_profile->Country->title;?></li>
</ul>

<?php $number_of_branches = count($org_profile->Branch);?>
<h2>Branches (<?php echo $number_of_branches;?>)</h2>

<ul>
<?php foreach( $org_profile->Branch as $branch):?>


	<li><a href="<?php echo URL_VIEW.'Branches/viewBranch?branch_id='.$branch->id;?>"><?php echo $branch->title;?></a></li>
<?php endforeach;?>
</ul>



<?php $number_of_boards = count($org_profile->Board);?>
<h2>Boards (<?php echo $number_of_boards;?>)</h2>

<ul>
<?php foreach( $org_profile->Board as $board):?>

	<li><?php echo $board->title;?></li>
<?php endforeach;?>
</ul>


<?php $number_of_groups = count($org_profile->Group);?>
<h2>Groups (<?php echo $number_of_groups;?>)</h2>

<ul>
<?php foreach( $org_profile->Group as $group):?>

	<li><?php echo $group->title;?></li>
<?php endforeach;?>
</ul>