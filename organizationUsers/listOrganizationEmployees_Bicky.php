<link href="<?php echo URL_VIEW;?>admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>
<?php
$orgId = $_GET['org_id'];

if (isset($_GET['page'])) {
    $page = "page:" . $_GET['page'];
} else {
    $page = '';
}

//get userId using org Id.
$url = URL . "Organizations/getUserIdFromOrgId/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$userId = $data->body->userId;

$url = URL . "OrganizationUsers/getOrganizationUsers/" . $orgId . "/" . $page . ".json";
$data = \Httpful\Request::get($url)->send();
$orgEmployees = $data->body->organizationUsers;
// echo "<pre>";
// print_r($orgEmployees);
// die();


$totalPage = $data->body->output->pageCount;
$currentPage = $data->body->output->currentPage;
?>

<!-- Employee Management List-->
<style>
.caption a {
    color: #ffffff;
}
</style>



<h3 class="page-title">
    Organization Employee List <small>view organization employee list</small>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
        <i class="fa fa-home"></i>
        <a href="#">Home</a>
        <i class="fa fa-angle-right"></i>
        </li>
        <li>
        <a href="#">Employee Management</a>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
        
            <a href="<?php echo URL_VIEW . 'employees/employeeRegistrationByOrg?org_id=' . $orgId; ?>"  class="btn btn-fit-height grey-salt dropdown-toggle">
                <!--<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">-->
                <i class="fa fa-plus"></i> Add Employee
            <!--</button>-->
            </a>
        </div>
    </div>
</div>




<div class="row">
<?php foreach ($orgEmployees as $orgEmployee): ?>
    <div class="col-md-4 col-sm-12">
        <div class="portlet blue-hoki box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i><a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>"><?php echo $orgEmployee->User->fname . ' ' . $orgEmployee->User->lname; ?></a>
                </div>
                <div class="actions">
                    <!-- <a href="javascript:;" class="btn btn-default btn-sm">
                    <i class="fa fa-pencil"></i> Edit </a> -->

                     <div class="page-toolbar">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true" style="border:none !important;">
           <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li>
                    <a href="#">Action</a>
                </li>
               
                <li>
                    <a href="#">Something else here</a>
                </li>
                <li class="divider">
                </li>
                <li>
                    <a href="#">Separated link</a>
                </li>
            </ul>
        </div>
    </div>





                </div>
            </div>
            <div class="portlet-body">
                <!-- <div class="row static-info">
                    <div class="col-md-5 name">
                         Name:
                    </div>
                    <div class="col-md-7 value">
                         <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>"><?php echo $orgEmployee->User->fname . ' ' . $orgEmployee->User->lname; ?></a>
                    </div>
                </div> -->
                <div class="row static-info">
                    
                    <div class="col-md-12 value">
                        <div class="profile-userpic">
                          <img class="img-responsive" alt="" src="<?php echo URL.'webroot/files/user/image/57/thumb2_w.jpg';//.$orgEmployee->User->image_dir.'/thumb2_'.'w.jpg');//$orgEmployee->User->image; ?>"/>
                        </div>
                    </div>
                </div>
               
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Designation:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->OrganizationUser->designation; ?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Email:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->User->email; ?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Address:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->User->address; ?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Phone:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $orgEmployee->User->phone; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>  
</div>




<!-- Save Success Notification -->
<script type="text/javascript">
    $(document).ready(function()
        {
            var top_an = $("#save_success").css('top');
            $("#save_success").css('top','0px');

            <?php if(isset($_SESSION['success'])):?>
                $("#save_success").show().animate({top:top_an});
                <?php unset($_SESSION['success']);?>
                setTimeout(function()
                    {
                        $("#save_success").fadeOut();
                    }, 3000);
            <?php endif;?>
        });
</script>
<!-- End of Save Success Notification -->

<!--Commented form here by rabi -->



<!-- Success Div -->
<!--
<div id="save_success">Employee Added Successfully !!</div> -->
<!-- End of Success Div -->
<!--
<div class="tableHeader">
    <div class="blueHeader">

        <ul class="subNav subNav_left subNav_edit">
            <li><a class="active" href="<?php echo URL_VIEW . 'organizationUsers/listOrganizationEmployees?org_id=' . $orgId; ?>">Employee List</a></li>
                <!-- <li><a href="<?php echo URL_VIEW . 'organizations/changePassword?org_id=' . $orgId; ?>">Add New Employee</a></li>
                
                <li><a href="<?php echo URL_VIEW . 'users/requestEmployeeToOrganization?org_id=' . $orgId; ?>">Request Employee</a></li> -->
        </ul>
       <!-- <a href="<?php echo URL_VIEW . 'employees/employeeRegistrationByOrg?org_id=' . $orgId; ?>"><button class="addBtn">Add Employee</button></a>

    </div>
    <div class="clear"></div>

    <!-- Table -->
    <!--
    <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>SN</p></th>
        <th><p>Name</p></th>
        <th><p>Designation</p></th>
        <th><p>Email</p></th>
        <th><p>Address</p></th>
        <th><p>Phone</p></th>
        <th><p>Action</p></th>

        </tr>

<?php $i = 1; ?>
        <?php foreach ($orgEmployees as $orgEmployee): ?>
            <tr class="list_users">
                <td><?php echo $i++; ?><input class="listShift-checkbox" type="checkbox" name="<?php echo $orgEmployee->User->id;?>"/></td>
                <td><a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>"><?php echo $orgEmployee->User->fname . ' ' . $orgEmployee->User->lname; ?></a></td>
                <td><?php echo $orgEmployee->OrganizationUser->designation; ?></td>
                <td><?php echo $orgEmployee->User->email; ?></td>
                <td><?php echo $orgEmployee->User->address; ?></td>
                <td><?php echo $orgEmployee->User->phone; ?></td>
                <td class="action_td">
                    <ul class="action_btn">
                        <li><div class="hover_action"></div>
                            <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>"><button 
                                    class="view_img"></button>
                            </a>
                        </li>
                        <form action="/newshiftmate/Organizations/delete/1" name="post_5476f94dde83b126092591" id="post_5476f94dde83b126092591" style="display:none;" method="post">
                            <input type="hidden" name="_method" value="POST"/>
                        </form>
                        <li>
                            <div class="hover_action"></div>
                            <a href="#" onclick="if (confirm( & quot; Are you sure you want to delete # 1? & quot; ))
                                        {
                                            document.post_5476f94dde83b126092591.submit();
                                        }
                                        event.returnValue = false;
                                        return false;"><button class="delete_img"></button>
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
<?php endforeach; ?>

    </table>
    <!-- End of Table -->

    <!-- Bulk Action -->
    <!--
                <div class="bulkaction-div">
                        <select>
                          <option value="volvo">Bulk Action</option>
                          <option value="saab">Delete</option>
                        </select>
                        <button id="bulkBtn">Apply</button>
                </div>
    <!-- End of Bulk Action -->

<?php
if ($totalPage > 1) {
    $previousPage = $currentPage - 1;
    $nextPage = $currentPage + 1;
    ?>
        <div class="paginator">
            <ul>
                <li>
    <?php if ($currentPage == 1) { ?>
                        <div class="deactive"><</div>
                    <?php } else { ?>
                        <a class="no-underline" href="<?php echo URL_VIEW . 'organizationUsers/listOrganizationEmployees?org_id=' . $orgId . '&page=' . $previousPage; ?>"><</a></li>
                    <?php } ?>
                <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
                    <li><a class="<?php echo ($currentPage == $i) ? 'active' : ''; ?>" href="<?php echo URL_VIEW . 'organizationUsers/listOrganizationEmployees?org_id=' . $orgId . '&page=' . $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li>
                <?php if ($totalPage == $currentPage) { ?>
                        <div class="deactive">></div>
                    <?php } else { ?>
                        <a class="no-underline" href="<?php echo URL_VIEW . 'organizationUsers/listOrganizationEmployees?org_id=' . $orgId . '&page=' . $nextPage; ?>">></a></li>
                    <?php } ?>
            </ul>
        </div>
<?php }
?>
