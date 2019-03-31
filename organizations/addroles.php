<?php
		//$orgId = $_GET['org_id'];
		if (isset($_POST["submit"])) {
			//$name=$_POST['name'];
			$url = URL. "Organizationroles/add.json";
    		$response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    //echo "<pre>";
    //print_r($response->body->output);
	 echo("<script>location.href = '".URL_VIEW."organizations/organizationrole?org_id=".$orgId."';</script>");
			}
	
	?>


<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Add Role<small> Add Role</small></h1>
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
                    <a href="<?=URL_VIEW.'organizations/organizationRole';?>">Oranization Role</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="javascript:;">Add Role</a>
                </li>
            </ul>

<div class="row">
    <div class="col-md-6 col-sm-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Add Role
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                    </div>
                    <div class="form-body">
                        <div style="display:none;">
                            <input type="hidden" name="data[Organizationrole][organization_id]" value="<?php echo $orgId;?>">
                            <input type="hidden" name="data[Organizationrole][status]" value="1">
                        </div>
                       <div class="form-group">
                            <label class="control-label col-md-4">
                    Name Of Role <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="data[Organizationrole][title]" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <input type="submit" name="submit" value="Submit" class="btn green">
                                <a class="btn default">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                </form>
            </div>
        </div>
    </div>
</div>