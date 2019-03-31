<link href="<?php echo URL_VIEW;?>styles/autocompleteCss/autocomplete.css" rel="stylesheet" type="text/css"/>
<?php
$orgId = $_GET['org_id'];
$homeEmployee = URL_VIEW.'organizationUsers/listOrganizationEmployees?org_id='.$orgId;


if (isset($_POST['submit'])) {
    
    if($_POST['data1']['review1']['period'] == "Days"){
        $_POST['data']['OrganizationUser']['reviewperiod']= $_POST['data1']['review1']['value']."D";
    }elseif($_POST['data1']['review1']['period'] == "Weeks"){
        $_POST['data']['OrganizationUser']['reviewperiod']= ($_POST['data1']['review1']['value']*7)."D";
    }elseif($_POST['data1']['review1']['period'] == "Months"){
        $_POST['data']['OrganizationUser']['reviewperiod']= $_POST['data1']['review1']['value']."M";
    }elseif($_POST['data1']['review1']['period'] == "Years"){
        $_POST['data']['OrganizationUser']['reviewperiod']= $_POST['data1']['review1']['value']."Y";
    }

$date = new DateTime();
$date->add(new DateInterval('P'.$_POST['data']['OrganizationUser']['reviewperiod']));
$_POST['data']['OrganizationUser']['reviewdate'] = $date->format('Y-m-d');

// echo "<pre>";print_r($_POST);die();

   $url = URL . "OrganizationUsers/assignEmployeeToOrganization/".$orgId.".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    
}

//get userId using org Id.
$url = URL . "Organizations/getUserIdFromOrgId/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$userId = $data->body->userId;

$url = URL . "Organizationroles/organizationRoleList/".$orgId.".json";
 $orgRole = \Httpful\Request::get($url)->send();
 $orgRoleList = $orgRole->body->orgRoleList;


$url = URL . "Branches/BranchesList/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

$url = URL . "Groups/listGroup/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$groups = $data->body;

$url = URL . "OrganizationUsers/listEmployeesNotInOrg/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$employees = $data->body->employees;

// fal($employees);


$i = 0;
foreach ($employees as $employee ) {
    $orgimage = URL.'webroot/files/user/image/'.$employee->User->image_dir.'/thumb2_'.$employee->User->image;
    $image = $employee->User->image;
    $employ_name[$i]['User']['id'] = $employee->User->id;
    $employ_name[$i]['User']['name'] = $employee->User->fname." ".$employee->User->lname;

    if($image && @GetImageSize($orgimage)){
    $employ_name[$i]['User']['image'] = URL.'webroot/files/user/image/'.$employee->User->image_dir.'/thumb2_'.$employee->User->image;
    }
    else{
        $employ_name[$i]['User']['image'] = URL.'webroot/files/user_image/noimage.png';
    }
    $i++;
}

?>




<!-- Edit -->
<h3 class="page-title">
    Add Existing Employee <small> Add Existing Employee</small>
</h3>

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo URL_VIEW; ?>">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="<?php echo $homeEmployee; ?>">Employee</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Add Existing Employee</a>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                Actions <i class="fa fa-angle-down"></i>
            </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li>
                        <a href="<?php echo URL_VIEW;?>employees/employeeRegistrationByOrg?org_id=<?php echo $orgId; ?>"><i class="fa fa-plus"></i> Add new employee</a>
                    </li>
                    <!-- <li>
                        <a class="active" href="<?php echo URL_VIEW;?>organizationUsers/assignEmployeeToOrganization?org_id=1">Add existing employee</a>
                    </li> -->
                    <li>
                        <a href="<?php echo URL_VIEW;?>users/requestEmployeeToOrganization?org_id=<?php echo $orgId; ?>"><i class="fa fa-send (alias)"></i> Send Request</a>
                    </li>
                </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet green box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Employee Details
                </div>
            </div>
             
                    
            
                <!-- BEGIN FORM-->
                   
                <div class="portlet-body form">
                     <form action="" id="OrganizationUserAddForm" method="post" accept-charset="utf-8"class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                        <input type="hidden" name="_method" value="POST"/>
                            <input type="hidden" name="data[OrganizationUser][user_id]" id="user_id">
                    </div>
                    <div class="form-body">
                       
                        <div class="form-group">
                            <label class="control-label col-md-3">Select User <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                               <div id="searchfield">
                                    <input class="form-control biginput" type="text" id="autocomplete" required="" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3">Branch <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control" name="data[OrganizationUser][branch_id]" id="OrganizationUserBranchId" required>
                                    <?php foreach ($branches as $key => $branch): ?>
                                        <option value="<?php echo $key; ?>"><?php echo $branch; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                </div>
                        </div>
                         <div class="form-group">
                                <label class="control-label col-md-3">Groups <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control" name="data[OrganizationUser][group_id]" id="OrganizationUserBranchId" required>
                                        <?php foreach ($groups as  $group): ?>
                                        <option value="<?php echo $group->Group->id; ?>"><?php echo $group->Group->title; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3">Organization Role <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control" name="data[OrganizationUser][organizationrole_id]" id="OrganizationUserOrganizationroleId" required>
                                        <?php foreach ($orgRoleList as $key => $role): ?>
                                            <option value="<?php echo $key; ?>"><?php echo $role; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Designation <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" name="data[OrganizationUser][designation]" maxlength="200" type="text" id="OrganizationUserDesignation" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Hire Date <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                 <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
                                    <input class="form-control form-control-inline date-picker" name="data[OrganizationUser][hire_date]" id="OrganizationUserHireDate" class="span2" size="16" type="text" value="" data-date-format="yyyy-mm-dd"/>
                                    <div class="add-on" style="cursor:pointer;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Wage Per Hour <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" name="data[OrganizationUser][wage]" type="number" id="OrganizationUserWage" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Max Weekly Hour <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" name="data[OrganizationUser][max_weekly_hour]" type="number" id="OrganizationUserMaxWeeklyHour" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Skills<span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" name="data[OrganizationUser][skills]" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3">Employee Type <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control" name="data[OrganizationUser][employee_status]" id="OrganizationUserStatus" required>
                                        <option value="1">Permanent</option>
                                        <option value="0">Temporary</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3">Review  Period <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-4 form-inline">
                                    <input class="form-control" type="number" name="data1[review1][value]" required=""/>
                                    <select class="form-control" name="data1[review1][period]">
                                        <option value="Days">Days</option>
                                        <option value="Weeks">Weeks</option>
                                        <option value="Months">Months</option>
                                        <option value="Years">Years</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                     <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                            <input  type="submit" name="submit" value="Submit" class="btn green"/>
                            </div>
                        </div>
                    </div>
                     </form>
                </div>
                <!-- END FORM-->
           
            
            
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>


<script type="text/javascript" src="<?php echo URL_VIEW;?>js/autocomplete/jquery.autocomplete.min.js"></script>

<script type="text/javascript">

$(function(){


    var employ = '<?php echo json_encode($employ_name);?>';
    //var imageUrl = '<?php echo URL."webroot/files/user/image/";?>';

    employ = JSON.parse(employ);
    // console.log(employ);


        
    var userList = $.map(employ, function(value, index) {
                            return {value:value.User.name,UserId:value.User.id, image:value.User.imagepath};
                                            });

   // console.log(userList);

      $('#autocomplete').autocomplete({
        lookup: userList,
         formatResult: function (suggestion, currentValue)
                              {
                                //console.log(suggestion);
                                var dataHtml = '<div class="media"><div class="pull-left"><div class="media-object"><img src="'+
                                suggestion['image']+
                                '" width="50" height="50"/></div></div><div class="media-body"><h4 class="media-heading text-capitalize">'+suggestion['value']+'</h4></div></div>';
                                return dataHtml;
                              },
        onSelect: function (suggestion) {
            $('#user_id').val(suggestion['UserId']);
        }
      });
      $(".date-picker").datepicker();
});

</script>










<!--  <div class="tableHeader">
   <div class="form createShift"> 
<form action="" id="OrganizationUserAddForm" method="post" accept-charset="utf-8">
    <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
    </div>

    Table
        <table cellpadding="5px">
     <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
        <input type="hidden" name="data[User][id]" value="<?php echo $userId;?>"/>
        <input type="hidden" name="data[Organization][id]" value="<?php echo $organization->id;?>"/>
    </div>
    <tr>
        <th>Select User</th> --> 
      <!-- <td> <select name="data[OrganizationUser][user_id]" id="OrganizationUserUserId" required>
                <?php foreach ($employees as  $employee): ?>
                    <option value="<?php echo $employee->User->id; ?>"><?php echo $employee->User->fname.' '.$employee->User->lname; ?></option>
                <?php endforeach; ?>
            </select></td> -->
          <!--  <td>
                <div id="searchfield">
                    <form><input type="text" name="data[OrganizationUser][user_id]"  class="biginput" id="autocomplete" required></form>
                </div>
            </td>
    </tr>

    <tr>
        <th>Branch</th>
        <td> <select name="data[OrganizationUser][branch_id]" id="OrganizationUserBranchId" required>
                <?php foreach ($branches as $key => $branch): ?>
                    <option value="<?php echo $key; ?>"><?php echo $branch; ?></option>
                <?php endforeach; ?>
            </select></td>
    </tr>  

    <tr>
        <th>Organization Role</th>
        <td><select name="data[OrganizationUser][organizationrole_id]" id="OrganizationUserOrganizationroleId" required>
                <?php foreach ($orgRoleList as $key => $role): ?>
                    <option value="<?php echo $key; ?>"><?php echo $role; ?></option>
                <?php endforeach; ?>
            </select></td>
    </tr>
   
     <tr>
        <th>Designation</th>
        <td><input name="data[OrganizationUser][designation]" maxlength="200" type="text" id="OrganizationUserDesignation" required/></td>
    </tr>

     <tr>
        <th>Hire Date</th>
         <td> <input name="data[OrganizationUser][hire_date]" type="text" id="OrganizationUserHireDate" required/>             <div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="yyyy-mm-dd">
          <input name="data[OrganizationUser][hire_date]" id="OrganizationUserHireDate" class="span2" size="16" type="text" value=""/>
          <div class="add-on" style="cursor:pointer;"></div>
        </td>
    </tr>
    
     <tr>
        <th>Wage Per Hour</th>
        <td><input name="data[OrganizationUser][wage]" type="number" id="OrganizationUserWage" required/></td>
    </tr>
   
    <tr>
        <th>Max Weekly Hour</th>
        <td> <input name="data[OrganizationUser][max_weekly_hour]" type="number" id="OrganizationUserMaxWeeklyHour" required/>
                </td>
    </tr>
  
     <tr>
        <th>Employee Type</th>
        <td> <select name="data[OrganizationUser][status]" id="OrganizationUserStatus" required>
                <option value="1">Permanent</option>
                <option value="0">Temporary</option>
            </select>
            </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <a class="cancel_a" href="http://192.168.1.104/shiftmate_view/organizationUsers/listOrganizationEmployees?org_id=1">Cancel</a>
            <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>   
    </table> 
     End Table 
 </form>
</div>
 -->