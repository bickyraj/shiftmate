<?php
require_once('config.php');
require_once('function.php');
$username = urlencode($_GET['userName']);
$url4 = URL . "OrganizationUsers/searchOrganizationUsers/" . $_GET['orgId'] . "/" . $username .'/'.$_GET['branchId'].'/'.$_GET['departmentId'].'/'.$_GET['status'].".json";
$data4 = \Httpful\Request::get($url4)->send();
$activeEmployees = $data4->body;

?>
<?php
if(empty($activeEmployees)){ ?>
    <tr><td style="text-align:center;">No Records Found</td></tr>
<?php } 
?>

<?php if(!empty($activeEmployees) && $_GET['status'] == 3){
 foreach ($activeEmployees as $orgEmployee):
    $userimage = URL.'webroot/files/user/image/'.$orgEmployee->User->image_dir.'/thumb2_'.$orgEmployee->User->image;
    $image = $orgEmployee->User->image;
    $gender = $orgEmployee->User->gender;
    $userimage = imageGenerate($userimage,$image,$gender);
 ?>

<tr id="tab-2-1-">
    <td class="fit">
        <img class="user-pic" src="<?php echo $userimage;?>" style="width:40px;height:40px;">
    </td>
    <td>
        <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $_GET['orgId'] . '&user_id=' . $orgEmployee->User->id; ?>" class="primary-link"><?php echo $orgEmployee->User->fname . ' ' . $orgEmployee->User->lname; ?>
        </a> 
    </td>
    <td><?php echo $orgEmployee->OrganizationUser->designation; ?></td>
    <td><?php echo $orgEmployee->User->email; ?></td>
    <td><?php echo (empty($orgEmployee->Branch->title))?"--":$orgEmployee->Branch->title; ?></td>
    <td><?php echo (empty($orgEmployee->User->address))?"--":$orgEmployee->User->address; ?></td>
    <td><?php echo (empty($orgEmployee->User->phone))?"--":$orgEmployee->User->phone; ?></td>
    <td>
        <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-sm green dropdown-toggle" aria-expanded="false">Review&nbsp;<i class="fa fa-angle-down"></i>
            </button>
            <ul role="menu" class="dropdown-menu">
                <li role="presentation">
                    <a href="<?php echo URL_VIEW."reviews/newReview?user_id=".$orgEmployee->User->id."&rev_typ=Review";?>">
                    General Review
                    </a>
                </li>
                <li role="presentation">
                    <a href="<?php echo URL_VIEW."reviews/newReview?user_id=".$orgEmployee->User->id."&rev_typ=verbal_warning";?>">
                    Verbal Warning
                    </a>
                </li>
                <li role="presentation">
                    <a href="<?php echo URL_VIEW."reviews/newReview?user_id=".$orgEmployee->User->id."&rev_typ=written_warning";?>">
                    Written  Warning

                    </a>
                </li>
                <li role="presentation">
                    <a href="<?php echo URL_VIEW."reviews/newReview?user_id=".$orgEmployee->User->id."&rev_typ=Feedback";?>">
                    Generel Feedback
                    </a>
                </li>
                <li class="divider" role="presentation">
                </li>
                <li role="presentation">
                    <a href="<?php echo URL_VIEW."reviews/sentSpecificReviews?user_id=".$orgEmployee->User->id ; ?>">
                    History
                    </a>
                </li>
            </ul>
        </div>
    </td>
    <td style="width: 118px;">
        <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-sm blue dropdown-toggle" aria-expanded="false">Action&nbsp;<i class="fa fa-angle-down"></i>
            </button>
            <ul role="menu" class="dropdown-menu dropdownMenu" style="margin-left:-66px;" permanent-id = "<?php echo $orgEmployee->User->id;?>" organizationUser-id="<?php echo $orgEmployee->OrganizationUser->id; ?>" fname="<?php echo $orgEmployee->User->fname; ?>" lname="<?php echo $orgEmployee->User->lname; ?>" >
                <li role="presentation">
                    <a class="make-permanent">Make Permanent</a>
                </li>
                <li role="presentation">
                    <a class="permanent-history">Permanent History</a>
                </li>
                <li role="presentation">
                    <a href="javascript:;" class="removeEmployee" id="<?php echo $orgEmployee->OrganizationUser->id; ?>">Remove</a>
                </li>
            </ul>
        </div>
        <div class="btn-group">
            <a class="btn btn-sm green editEmpBtn" data-userId="<?php echo $orgEmployee->OrganizationUser->user_id;?>" data-toggle="modal"><i class="fa fa-edit"></i></a>
        </div>
    </td>
</tr>


<?php endforeach;
    } ?>

 <?php
 $employeeRemoves = $activeEmployees;
    if(!empty($employeeRemoves) && $_GET['status'] == 4){
        foreach ($employeeRemoves as $employeeRemove) {
        $userimage = URL.'webroot/files/user/image/'.$employeeRemove->User->image_dir.'/thumb2_'.$employeeRemove->User->image;
        $image = $employeeRemove->User->image;
        $gender = $employeeRemove->User->gender;
        $userimage = imageGenerate($userimage,$image,$gender); 
    ?>
    <tr id="tab-2-5-">
        <td>
            <img src="<?php echo $userimage; ?>" style="height:60px;width:60px;"/><br>
           <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $_GET['orgId'] . '&user_id=' . $orgEmployee->User->id; ?>"><?php echo $employeeRemove->User->fname . ' ' . $employeeRemove->User->lname; ?></a> 
        </td>
        <td>
            <?php echo $employeeRemove->OrganizationUser->designation; ?>
        </td>
        <td>
            <?php echo $employeeRemove->User->email; ?>
        </td>
        <td>
            <?php echo $employeeRemove->Branch->title; ?>
        </td>
        <td>
            <?php echo $employeeRemove->User->address; ?>
        </td>
        <td>
            <?php if($employeeRemove->User->status == '1'){ ?>
                <button type="button" class="btn green-meadow">Active User</button>
            <?php } else { ?>
                <button type="button" class="btn red-sunglo">Inactive User</button>
            <?php } ?>
        </td>
        <td>
            <button type="button" class="activateEmployeeByOrg btn red-sunglo" id="<?php echo $employeeRemove->OrganizationUser->id; ?>">Activate Now</button>
        </td>
    </tr>
    <?php }}

?>

    <?php 
        $addNewEmployeeByOrgs = $activeEmployees;
        if(!empty($addNewEmployeeByOrgs) && $_GET['status'] == 0){
        foreach ($addNewEmployeeByOrgs as $addNewEmployeeByOrg) {
        $userimage = URL.'webroot/files/user/image/'.$addNewEmployeeByOrg->User->image_dir.'/thumb2_'.$addNewEmployeeByOrg->User->image;
        $image = $addNewEmployeeByOrg->User->image;
        $gender = $addNewEmployeeByOrg->User->gender;
        $userimage = imageGenerate($userimage,$image,$gender);  
    ?>
        <tr>
            <td><?php echo $addNewEmployeeByOrg->User->email; ?></td>
            <td><?php echo $addNewEmployeeByOrg->Branch->title; ?></td>
            <td>
                <?php if($addNewEmployeeByOrg->User->status == '1'){ ?>
                    <span class="btn green-meadow">Active User</span>
                <?php } else { ?>
                    <span class="btn red-sunglo">Inactive User</span>
                <?php } ?>
            </td>
            <td>
                <button type="button" class="activateEmployeeByOrg btn green" id="<?php echo $addNewEmployeeByOrg->OrganizationUser->id; ?>">Activate Now</button>
            </td>
        </tr>
    <?php }} ?>

<?php 
    $assignEmployees = $activeEmployees;
    if(!empty($assignEmployees) && $_GET['status'] == 1){
    foreach ($assignEmployees as $assignEmployee) { 
        $userimage = URL.'webroot/files/user/image/'.$assignEmployee->User->image_dir.'/thumb2_'.$assignEmployee->User->image;
        $image = $assignEmployee->User->image;
        $gender = $assignEmployee->User->gender;
        $userimage = imageGenerate($userimage,$image,$gender); 
?>
    <tr>
        <td><?php echo $assignEmployee->User->email; ?></td>
        <td><?php echo $assignEmployee->Branch->title; ?></td>
        <td>
            <?php if($assignEmployee->OrganizationUser->status == '3'){ ?>
                <button type="button" class="btn green-meadow">Active User</button>
            <?php } else { ?>
                <button type="button" class="btn red-sunglo">InActive User</button>
            <?php } ?>
        </td>
    </tr>

<?php }} ?>


<?php
    $assignEmployeeByEmails = $activeEmployees;
    if(!empty($assignEmployeeByEmails) && $_GET['status'] == 2){
    foreach ($assignEmployeeByEmails as $assignEmployeeByEmail) { 
        $userimage = URL.'webroot/files/user/image/'.$assignEmployeeByEmail->User->image_dir.'/thumb2_'.$assignEmployeeByEmail->User->image;
        $image = $assignEmployeeByEmail->User->image;
        $gender = $assignEmployeeByEmail->User->gender;
        $userimage = imageGenerate($userimage,$image,$gender);
    ?>
    <tr>
        <td><?php echo $assignEmployeeByEmail->User->email; ?></td>
        <td>
            <?php if($assignEmployeeByEmail->User->status == '1'){ ?>
                <button type="button" class="btn green-meadow">Active User</button>
            <?php } else { ?>
                <button type="button" class="btn red-sunglo">Inactive User</button>
            <?php } ?>
        </td>
        <td>
            <button type="button" class="activateNow activateEmployeeByOrg btn green" id="<?php echo $assignEmployeeByEmail->OrganizationUser->id; ?>">Activate Now</button>
        </td>
    </tr>

    <?php }} ?>