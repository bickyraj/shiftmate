<?php


$orgId = $_GET['org_id'];


if (isset($_POST["submit"])) {
    echo "<pre>";
    // print_r($_POST['data']);
    $url = URL . "Groups/createGroup/" . $orgId . ".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    // echo "<pre>";
    // print_r($response);

    if($response->body->output->status == '1')
    {
        echo("<script>location.href = '".URL_VIEW."groups/listGroups?org_id=".$orgId."';</script>");

        $_SESSION['success']="test";
    }
}
?>
    
<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Groups <small> Create Group</small></h1>
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
                    <a href="<?=URL_VIEW."groups/listGroups";?>">Groups</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="javascript:;">Create Group</a>
                </li>
            </ul>
            
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                Actions <i class="fa fa-angle-down"></i>
            </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li>
                        <a href="<?php echo URL_VIEW;?>employees/employeeRegistrationByOrg?org_id=1">Add new employee</a>
                    </li>
                    <li>
                        <a class="active" href="<?php echo URL_VIEW;?>organizationUsers/assignEmployeeToOrganization?org_id=1">Add existing employee</a>
                    </li>
                    <li>
                        <a href="<?php echo URL_VIEW;?>users/requestEmployeeToOrganization?org_id=1">Send Request</a>
                    </li>
                </ul>
        </div>
    </div><br /><br />

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Group Details
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" id="UserAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                    </div>
                    <div class="form-body">
                        <div style="display:none;">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="data[Shift][id]" value="1">
                        </div>
                       <div class="form-group">
                            <label class="control-label col-md-3">Title <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" id="GroupTitle" required="required" type="text" name="data[Group][title]">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <input type="submit" name="submit" value="Submit" class="btn green">
                                <a class="btn default" href="<?php echo URL_VIEW."groups/listGroups?org_id=".$orgId;?>">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                </form>
            </div>
        </div>
    </div>
</div>
