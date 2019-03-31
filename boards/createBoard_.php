<?php
if(isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] == 'ajax'){
	include('../httpful.phar');
	include('../config1.php');
	//define("URL", "http://192.168.0.112/newshiftmate/");
	//define("URL_VIEW", "http://192.168.0.112/shiftmate/");
	
	$showBranch = 'No';
}else{
	$showBranch = 'Yes';	
}

$orgId = $_GET['org_id'];

//Get User list related to particular organization
$url = URL. "OrganizationUsers/getOrganizationUsers/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$organizationUsers = $data->body->organizationUsers;

//get branch list related to particular organization
$url = URL. "Branches/orgBranches/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;



if (isset($_POST["submit"])) {
    //echo "<pre>";
     //print_r($_POST['data']);
	// die();
    $url = URL. "Boards/createBoard/" . $orgId . ".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    // echo "<pre>";
    // print_r($response);

if($response->body->output->status == '1')
    {
        echo("<script>location.href = '".URL_VIEW."boards/listBoards?org_id=".$orgId."';</script>");

        $_SESSION['success']="test";
    }
}
?>

<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Create Board</div>
    </div>
    <div class="clear"></div>

<div class="form createShift">
<form action="" id="BoardAddForm" method="post" accept-charset="utf-8">
	<table cellpadding="5px">
    <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
    </div>
    <?php
	if($showBranch == 'Yes'){
	?>
    <tr>
    	<th>Branch</th>
        <td><select name="data[Board][branch_id]">
               <?php foreach($branches as $branche):?>
                <option value="<?php echo $branche->Branch->id;?>"><?php echo $branche->Branch->title;?></option>
                <?php endforeach;?>
            </select></td>
    </tr>
    <?php } ?>
    <tr>
    	<th>Board Name</th>
        <td><input type="text" name="data[Board][title]" required /></td>
    </tr>	
    
    <tr>
    	<th>Board Manager</th>
        <td><select name="data[Board][user_id]" id="BoardUserId" >
                <?php foreach($organizationUsers as $organizationUser):?>
                <option value="<?php echo $organizationUser->User->id;?>"><?php echo $organizationUser->User->fname.' '.$organizationUser->User->lname;?></option>
                <?php endforeach;?>
            </select></td>
    </tr>
    
    <tr>
    	<td colspan="2">
            <a class="cancel_a" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a>
            <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>	
    </table>
</form>
</div>

<div class="clear"></div>

