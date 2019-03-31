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
// echo "<pre>";
// print_r($branches);
// die();


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

<!-- Edit -->
<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Department <small> Create Department</small></h1>
			</div>  
         </div>
         </div>
         <div class="page-content">
            <div class="container">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?=URL_VIEW;?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?=URL_VIEW."boards/listBoards";?>">Departments</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="javascript:;">Create Department</a>
                    </li>
                </ul>

<div class="row">
    <div class="col-md-6 col-sm-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Board Detail
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" id="BoardAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                    </div>
                    <div class="form-body">     
                        <div class="form-group">
                            <label class="control-label col-md-4">Branch <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <?php
                                    if($showBranch == 'Yes'){
                                ?>
                               <select name="data[Board][branch_id]" class="form-control">
                                   <?php foreach($branches as $branche):?>
                                    <option value="<?php echo $branche->Branch->id;?>"><?php echo $branche->Branch->title;?></option>
                                    <?php endforeach;?>
                                </select>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Board Name <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="data[Board][title]" required />
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-4">Board Manager <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-7">
                                     <select class="form-control" name="data[Board][user_id]" id="BoardUserId" >
                                        <?php foreach($organizationUsers as $organizationUser):?>
                                        <option value="<?php echo $organizationUser->User->id;?>"><?php echo $organizationUser->User->fname.' '.$organizationUser->User->lname;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <input  type="submit" name="submit" value="Submit" class="btn green"/>
                               <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                                <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>















<!-- <div class="tableHeader">
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

 -->