<?php


$orgId = $_GET['org_id'];
$boardId = $_GET['board_id'];

//get deta related to board edit to populate form fields
$url = URL. "Boards/editBoard/" . $boardId . ".json";
$data = \Httpful\Request::get($url)->send();
$board = $data->body->board;


//Get User list related to particular organization
$url = URL. "OrganizationUsers/getOrganizationUsers/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$organizationUsers = $data->body->organizationUsers;

//get branch list related to particular organization
$url = URL. "Branches/orgBranches/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;



if (isset($_POST["submit"])) {
  //   echo "<pre>";
    // print_r($_POST['data']);
    // echo "<pre>";
    // print_r($_POST['data']);
    // die();
	 
    $url = URL. "Boards/editBoard/" . $boardId . ".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
//     echo "<pre>";
//      print_r($response->body->output);
// die();
    if($response->body->output->status == '1')
    {
        echo("<script>location.href = '".URL_VIEW."boards/listBoards?org_id=".$orgId."';</script>");

        $_SESSION['success']="test";
    }
}
?>
<style>
.sortable {
    min-
}
</style>
<!-- Edit -->
<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Department <small> Edit Department</small></h1>
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
                        <a href="<?=URL_VIEW."boards/listBoards";?>">Department</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="javascript:;">Edit Department</a>
                    </li>
                </ul>

<div class="row">
    <div class="col-md-6 col-sm-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Department Detail
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
                            <label class="control-label col-md-4">User <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <select name="data[Board][user_id]" class="form-control">
                                    <?php foreach($organizationUsers as $organizationUser):?>
                                    <option value="<?php echo $organizationUser->User->id;?>" <?php echo ($board->Board->user_id == $organizationUser->User->id)? 'selected="selected"':'';?>><?php echo $organizationUser->User->fname.' '.$organizationUser->User->lname;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-4">Branch <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-7">
                                    <select name="data[Board][branch_id]" class="form-control">
                                       <?php foreach($branches as $branche):?>
                                        <option value="<?php echo $branche->Branch->id;?>" <?php echo ($board->Board->branch_id == $branche->Branch->id)? 'selected="selected"':'';?>><?php echo $branche->Branch->title;?></option>
                                        <?php endforeach;?>
                                    </select>    
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Board Name <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" name="data[Board][title]" value="<?php echo $board->Board->title;?>" type="text"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                            <input  type="submit" name="submit" value="Submit" class="btn green"/>
                                <a href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>"  class="btn default" >Cancel</a>
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
        <div class="table-heading">Edit Board</div>
    </div>
    <div class="clear"></div>
<div class="form createShift">
<form action="" id="BoardAddForm" method="post" accept-charset="utf-8">
	<table cellpadding="5px">
    <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
    </div>
    <tr>
    	<th>User</th>
        <td><select name="data[Board][user_id]">
                <?php foreach($organizationUsers as $organizationUser):?>
                <option value="<?php echo $organizationUser->User->id;?>" <?php echo ($board->Board->user_id == $organizationUser->User->id)? 'selected="selected"':'';?>><?php echo $organizationUser->User->fname.' '.$organizationUser->User->lname;?></option>
                <?php endforeach;?>
            </select>
            </td>
    </tr>
    
    <tr>
    	<th>Branch</th>
        <td><select name="data[Board][branch_id]">
               <?php foreach($branches as $branche):?>
                <option value="<?php echo $branche->Branch->id;?>" <?php echo ($board->Board->branch_id == $branche->Branch->id)? 'selected="selected"':'';?>><?php echo $branche->Branch->title;?></option>
                <?php endforeach;?>
            </select>
            </td>
    </tr>	
    
    <tr>
    	<th>Title</th>
        <td><input name="data[Board][title]" value="<?php echo $board->Board->title;?>" type="text"/></td>
    </tr>
    
    <tr>
    	<td colspan="2">
            <a href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>"  class="cancel_a" >Cancel</a>
            <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>	
    </table>
</form>
</div>
 -->
<div class="clear"></div>
