<?php
        // $html = array();
        // foreach($result as $key=>$r){
 
        //     $folderImage = $this->webroot.'webroot/files/user/image/'.$r['User']['image_dir'].'/thumb2_'.$r['User']['image'];
        //     $image = $r['User']['image'];
        //     $gender = $r['User']['gender'];
        //     $genImage = 'webroot/files/user/image/'.$r['User']['image_dir'].'/thumb2_'.$r['User']['image'];
        //     $this->loadModel('User');

        //     $image =$this->User->checkImage($folderImage,$image,$gender,$genImage);

        //     $html[$key] = ''; 
        //     $html[$key] .= '<tr>';
        //     $html[$key] .= '<td class="fit"><img class="user-pic" src="'.$this->webroot.$image.'" style="width:40px;height:40px;"></td>';
        //     $html[$key] .= '<td><a href=" '.URL_VIEW.'organizationUsers/organizationEmployeeDetail?org_id='.$orgId. '&user_id='.$r['User']['id'].'" class="primary-link">'.$r['User']['fname'].' '.$r['User']['lname'].'</a></td>';
        //     $html[$key] .= '<td>'.$r['OrganizationUser']['designation'].'</td>';
        //     $html[$key] .= '<td>'.$r['User']['email'].'</td>';
        //     $html[$key] .= '<td>'.$r['Branch']['title'].'</td>';
        //     $html[$key] .= '<td>'.$r['User']['address'].'</td>';
        //     $html[$key] .= '<td>'.$r['User']['phone'].'</td>';
        //     $html[$key] .= '<td><div class="btn-group"><button data-toggle="dropdown" class="btn btn-sm green dropdown-toggle" aria-expanded="false">Review&nbsp;<i class="fa fa-angle-down"></i></button>';
        //     $html[$key] .= '<ul role="menu" class="dropdown-menu">';
        //     $html[$key] .= '<li role="presentation"><a href="'.URL_VIEW.'reviews/newReview?user_id='.$r['User']['id'].'&rev_typ=Review">General Review</a></li>';
        //     $html[$key] .= '<li role="presentation"><a href='.URL_VIEW.'reviews/newReview?user_id='.$r['User']['id'].'&rev_typ=verbal_warning">Verbal Warning</a></li>';
        //     $html[$key] .= '<li role="presentation"><a href="'.URL_VIEW.'reviews/newReview?user_id='.$r['User']['id'].'&rev_typ=written_warning">Written  Warning</a></li>';
        //     $html[$key] .= '<li role="presentation"><a href="'.URL_VIEW.'reviews/newReview?user_id='.$r['User']['id'].'&rev_typ=Feedback">Generel Feedback</a></li>';
        //     $html[$key] .= '<li class="divider" role="presentation"></li><li role="presentation"><a href="'.URL_VIEW.'reviews/sentSpecificReviews?user_id='.$r['User']['id'].'">History</a></li>';
        //     $html[$key] .= '</ul></div></td>';
        //     $html[$key] .= '<td style="width: 118px;"><div class="btn-group"><button data-toggle="dropdown" class="btn btn-sm blue dropdown-toggle" aria-expanded="false">Action&nbsp;<i class="fa fa-angle-down"></i></button>';
        //     $html[$key] .= '<ul role="menu" class="dropdown-menu dropdownMenu" style="margin-left:-66px;" permanent-id = "'.$r['User']['id'].'" organizationUser-id="'.$r['OrganizationUser']['id'].'" fname="'.$r['User']['fname'].'" lname="'.$r['User']['lname'].'" >';
        //     $html[$key] .= '<li role="presentation"><a class="make-permanent">Make Permanent</a></li>';
        //     $html[$key] .= '<li role="presentation"><a class="permanent-history">Permanent History</a></li>';
        //     $html[$key] .= '<li role="presentation"><a href="javascript:;" class="removeEmployee" id="'.$r['OrganizationUser']['id'].'">Remove</a></li>';
        //     $html[$key] .= '</ul></div>';
        //     $html[$key] .= '<div class="btn-group"><a class="btn btn-sm green editEmpBtn" data-userId="'.$r['User']['id'].'" data-toggle="modal"><i class="fa fa-edit"></i></a></div></td>';
        //     $html[$key] .= '</tr>';  


        // }
        // //debug($html);
        // if(empty($result)){
        //     $html[0] = '<br/><p>No records found.</p>';
        // }


require_once('config.php');
fal($_GET);
$url4 = URL . "OrganizationUsers/searchOrganizationUsers/" . $_GET['orgId'] . "/" . $_GET['userName'] .'/'.$_GET['branchId'].'/'.$_GET['departmentId'].".json";
$data4 = \Httpful\Request::get($url4)->send();
$activeEmployees = $data4->body->result;

fal($activeEmployees);
?>

<?php if(!empty($activeEmployees)){
 foreach ($activeEmployees as $orgEmployee):
    $userimage = URL.'webroot/files/user/image/'.$orgEmployee->User->image_dir.'/thumb2_'.$orgEmployee->User->image;
    $image = $orgEmployee->User->image;
    $gender = $orgEmployee->User->gender;
    $userimage = imageGenerate($userimage,$image,$gender);
 ?>
<tr>
    <td class="fit">
        <img class="user-pic" src="<?php echo $userimage;?>" style="width:40px;height:40px;">
    </td>
    <td>
        <a href="<?php echo URL_VIEW . 'organizationUsers/organizationEmployeeDetail?org_id=' . $orgId . '&user_id=' . $orgEmployee->User->id; ?>" class="primary-link"><?php echo $orgEmployee->User->fname . ' ' . $orgEmployee->User->lname; ?>
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

<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modalOuter">
        <div class="modal-content modalCustom">
            <div class="col-md-3 col-sm-3 col-xs-3 sidebarKs">
                <div class="userLi @new" id="empProfName">
                        <img id="empImage" src="<?php echo URL_VIEW;?>images/a.png" alt="image"><span>Kevin ham</span>
                </div>
                <ul class="navUl @new" id="editTavNav">
                    <li class="active">
                        <a href="#tab_7_1" data-toggle="tab">
                        EMPLOYEE DETAILS  </a>
                    </li>
                    <li>
                        <a href="#tab_7_2" data-toggle="tab">
                         LOCATIONS / POSITIONS</a>
                    </li>
                    <li>
                        <a href="#tab_7_3" data-toggle="tab">
                        PAYROLL / WAGE </a>
                    </li>
                    <li>
                        <a href="#tab_7_4" data-toggle="tab">
                        LOG / NOTES </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <div class="tab-content editEmpProf">
                    <form action="" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="data[boardIds]" multiple value="" />
                        <input type="hidden" name="data[OrganizationUser][id]" value="">
                        <input type="hidden" name="data[User][id]" value="">
                        <div class="row">
                            <div class="right-container-top @new">
                                <strong>Edit Employee</strong>
                                <div class="btn @new closeBtn">
                                <button type="button" class=" btn btn-default" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" style="color:#eeeeee"></span></button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane active" id="tab_7_1">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group topGroup">
                                            <div class="col-md-3">
                                                <label for="firstname">FIRST NAME</label>
                                                <input disabled type="firstname" name="data[User][fname]" class="form-control @new" id="firstname">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="lastname">LAST NAME</label>
                                                <input disabled name="data[User][lname]" type="lastname" class="form-control @new" id="lastname" >
                                            </div>
                                            <div class="col-md-6">
                                                <div class="profileimage">
                                                    <img src="<?php echo URL_VIEW;?>images/a.png" id="empProfImage" alt="image" height=70px width=70px>
                                                </div>
                                                <div class="profile">
                                                    PROFILE PICTURE<br>
                                                    <!-- Maximum size 500kb,png,jpg.<br> -->
                                                </div>
                                                <!-- <div class="changeBtn">
                                                    <button type="button" class="btn btn-sm btn-success">change</button>
                                                </div> -->
                                                </div>
                                            </div>
                                    </div>

                                    <div class="row topGroup">
                                        <div class="col-md-6">
                                            <label for="Emailaddress">EMAIL ADDRESS</label>
                                            <input disabled name="data[User][email]" type="Emailaddress" class="form-control @new" id="Emailaddress" >
                                        </div>
                                            <div class="col-md-6">
                                                <label for="mobilenumber">MOBILE NUMBER</label>
                                                <input disabled name="data[User][phone]" type="mobilenumber" class="form-control @new" id="mobilenumber" >
                                            </div>
                                    </div>

                                    <hr class="lineBreak">
                                    <!-- Bottom Row -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- <div class="form-group">
                                                <div class="time">
                                                    <input type="checkbox" name="my-checkbox">
                                                    USE CUSTOM TIME ZONE<br>
                                                </div>

                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-default timeDrop ">(GMT+11)Sydney</button>
                                                  <button type="button" class="btn btn-default dropdown-toggle timeDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                  </button>
                                                  <ul class="dropdown-menu">
                                                    <li><a href="#">Action</a></li>
                                                    <li><a href="#">Another action</a></li>
                                                    <li><a href="#">Something else here</a></li>
                                                    <li role="separator" class="divider"></li>
                                                    <li><a href="#">Separated link</a></li>
                                                  </ul>
                                                </div>
                                            </div> -->
                                            <div class="form-group">
                                                <label>ACCESS PRIVILEGES <a class="learnMore"href="#">Learn More</a></label>

                                                <input type="hidden" value="" name="data[OrganizationUser][organizationrole_id]">
                                                <div class="input-group" id="editEmpRoleRadio">
                                                    <div class="icheck-inline">
                                                        <label>
                                                        <input type="radio" name="radio2" class="icheck" data-radio="iradio_flat-green" checked> Manager </label>
                                                        <label>
                                                        <input type="radio" name="radio2" class="icheck" data-radio="iradio_flat-green"> Supervisor </label>
                                                        <label>
                                                        <input type="radio" name="radio2" class="icheck" data-radio="iradio_flat-green"> Employee </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                                        <div style="margin-bottom: 9px;"><label for="employeeId">EMPLOYEE ID</label></div>
                                                    <div class="mid-empid">
                                                        <input disabled type="employeeId" class="form-control @new" id="employeeId" >
                                                    </div>
                                        </div>
                                            
                                    </div>
                                    
                                </div>
                        </div>

                        <div class="tab-pane" id="tab_7_2">
                            <div class="col-md-12">
                                <div class="row topGroup">
                                    <div class="col-md-6 verticalLine">
                                        <label for="Positions">POSITIONS</label>
                                        <!-- <div class="btn-group "> -->
                                                    <!-- <div class="col-md-6 positionDrop"> -->
                                                    <div class="form-group">
                                                        <select name="data[BoardUser][][board_id]" id="selectDept" class="form-control select2Branch" multiple="multiple"></select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                            <button type="submit" class="btn default pull-right">CLEAR</button>
                                                            <button type="button" class="btn default pull-right all-clr">ALL</button>
                                                    </div>

                                                        

                                                
                                        <!-- </div> -->
                                    </div>

                                        <div class="col-md-6 ">
                                            <label for="Locations" class="locationText">LOCATIONS</label>
                                        
                                                    <div class="form-group">
                                                        <select class="form-control" disabled id="selectBranch" data-placeholder="Select...">
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                            <button type="submit" class="btn default pull-right">CLEAR</button>
                                                            <button type="button" class="btn default pull-right all-clr">ALL</button>
                                                    </div>


                                        </div>
                                        

                                </div>

                                <hr class="lineBreak">
                            </div>
                        </div>

                        <div class="tab-pane" id="tab_7_3">
                            <div class="col-md-12">
                                <div class="row topGroup">
                                    <div class="col-md-4 verticalLine">
                                        <div class="form-group">
                                            <label for="hourRate">BASE HOURLY RATE</label>
                                            <input class="baseHour" name="data[OrganizationUser][wage]">
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8 padZero">

                                                    <label  for="hourRate">MAX HOURS / WEEKS</label>
                                            </div>
                                                <input class="col-md-4" name="data[OrganizationUser][max_weekly_hour]">
                                            <div class="col-md-8 padZero">
                                                    <div class="exempt">
                                                    <input type="checkbox" name="my-checkbox">
                                                    EMPLOYEE IS EXEMPT 
                                                    <span class="questionMark"><i class="fa fa-question-circle"></i></span>
                                                    </div>
                                            </div>
                                            <!-- <div class="col-md-11 padZero">
                                                    <div class="exempt">
                                                    <input type="checkbox" name="my-checkbox">
                                                    DISABLE ATTENDENCE ALERTS & 
                                                    </div>
                                                    <span class="allow">
                                                    ALLOW TIMESHEET EDITING 
                                                    <span class="questionMark"><i class="fa fa-question-circle"></i></span>
                                                    </span>
                                                    
                                            </div> -->
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-4">
                                        <div class="form-group">
                                                <label for="hourRate">HOURLY RATE BY POSITION</label>
                                                <input class="baseHour">
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                        <input class="hourlyCleaning">
                                    </div> -->
                                </div>
                            </div>
                                <hr class="lineBreak">
                        </div>

                        <div class="tab-pane" id="tab_7_4">
                            <div class="col-md-12">
                                <div class="row topGroup">
                                    <div class="col-md-12">
                                        <label>LOG / NOTES - <span class="visible"> Visible to only Managers and Supervisors </span></label>
                                        <textarea name="data[OrganizationUser][notes]" class="logInput"></textarea>
                                    </div>
                                </div>
                                <hr class="lineBreak">
                            </div>
                        </div>

                        <div class="row">
                            <div class="foot">
                                <div class="col-md-3">
                                    <div class="changeBtn">
                                        <button type="button" class="btn btn-danger">DELETE EMPLOYEE</button>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="saveEmployee">
                                        <div class="changeBtn">
                                            <input type="submit" class="btn btn-success" name="editEmployeeSubmit" value="SAVE EMPLOYEE"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Bottom Row -->
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php endforeach;
    }else{ ?>
        <tr><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td></tr>
<?php } ?>