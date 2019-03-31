<?php 
$groupId = $_GET['group_id'];
$orgId = $_GET['org_id'];

//get list of user related to organization but not assigned to specific board
$url = URL . "UserGroups/getEmployeeListNotInGroup/".$groupId."/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$orgUsers = $data->body->orgUsersNotInGroup;
//echo "<pre>";
//print_r($orgUsers);


if (isset($_POST["submit"]) && !empty($_POST['data'])) {
    // echo "<pre>";
    // print_r($_POST['data']);

    if(!empty($_POST['data']))
    {
        $url = URL . "UserGroups/assignEmployeeToGroup/".$groupId.".json";
        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();
        // echo "<pre>";
        // print_r($response);

        if($response->body->output->status == '1')
        {
            echo("<script>location.href = '".URL_VIEW."userGroups/listEmployeesInGroup?group_id=".$groupId."';</script>");

            $_SESSION['success']="test";
        } 
    }
    

    

   
}

?>
<style>
.clear {
    clear:both;
}
</style>
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1> Assign Employee <small>Assign Employee</small></h1>
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
                <a href="<?=URL_VIEW;?>groups/listGroups">Groups</a>
                <i class="fa fa-circlet"></i>
            </li>
            <li>
                <a href="#">Assign Employee</a>
            </li>
        </ul>
        
<div class="row">
    <div class="col-md-6 col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Assign Employee
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                 <form action="" method="post">
                    <?php if(!empty($orgUsers)):?> 
                            <div class="form-body">
                            
                                <div class="form-body">                       
                                <div class="form-group">
                                    <?php foreach($orgUsers as $orgUser):?>
                                    <div class="col-md-6 clear">
                                        <label class="control-label"><input type="checkbox" name="data[UserGroup][user_id][]" value="<?php echo $orgUser->User->id;?>"/> <?php echo $orgUser->User->fname.' '.$orgUser->User->lname;?></label>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                            </div>
                           <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <input type="submit" id="employeeSubmit" name="submit" value="Submit" class="btn green">
                                        <a class="btn default" href="<?php echo URL_VIEW."userGroups/listEmployeesInGroup?group_id=".$groupId;?>">Cancel</a>
                                    </div>
                                </div>
                            </div>
                    <?php else:?>
                         <div class="form-body">
                            
                                <div class="form-body">                       
                                <div class="form-group">
                                   Sorry, no employees are available.
                                </div>
                            </div>
                            </div>
                    <?php endif;?>
                </form>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>






<!-- <form action="" method="post"> -->
    <!-- Assign Employ Table -->
    <!-- <div class="tableHeader">
        <div class="blueHeader">
            <div class="table-heading">Assign Employee</div>
        </div>
        <div class="clear"></div>

        <div class="form createShift assignEmploy">
            <form action="" method="post">
                <?php if(!empty($orgUsers)):?> 
               <table cellpadding="5px"> 

                   <tbody>

                    <?php foreach($orgUsers as $orgUser):?>
                    <tr>
                        <td>
                            <input type="checkbox" name="data[UserGroup][user_id][]" value="<?php echo $orgUser->User->id;?>"><label><?php echo $orgUser->User->fname.' '.$orgUser->User->lname;?></label><br/>
                        </td>
                    </tr>
                <?php endforeach;?>
                
            </tbody></table>
            <input type="submit" id="employeeSubmit" name="submit" value="Submit">
            <a class="cancel_a cancel_left" href="<?php echo URL_VIEW."userGroups/listEmployeesInGroup?group_id=".$groupId;?>">Cancel</a>
            <?php else:?>
        <div class="empty_list">Sorry, no employees are available.</div>
    <?php endif;?>
        </form>
    </div>

    <div class="clear"></div>

</div> -->
<!-- End of Assign Employ table -->
<!-- </form> -->