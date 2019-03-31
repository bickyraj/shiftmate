<link href="<?php echo URL_VIEW;?>styles/autocompleteCss/autocomplete.css" rel="stylesheet" type="text/css"/>
<?php
$orgId = $_GET['org_id'];
$homeEmployee = URL_VIEW.'organizationUsers/listOrganizationEmployees?org_id='.$orgId;


if (isset($_POST['submit'])) {
    
//     if($_POST['data1']['review1']['period'] == "Days"){
//         $_POST['data']['OrganizationUser']['reviewperiod']= $_POST['data1']['review1']['value']."D";
//     }elseif($_POST['data1']['review1']['period'] == "Weeks"){
//         $_POST['data']['OrganizationUser']['reviewperiod']= ($_POST['data1']['review1']['value']*7)."D";
//     }elseif($_POST['data1']['review1']['period'] == "Months"){
//         $_POST['data']['OrganizationUser']['reviewperiod']= $_POST['data1']['review1']['value']."M";
//     }elseif($_POST['data1']['review1']['period'] == "Years"){
//         $_POST['data']['OrganizationUser']['reviewperiod']= $_POST['data1']['review1']['value']."Y";
//     }

// $date = new DateTime();
// $date->add(new DateInterval('P'.$_POST['data']['OrganizationUser']['reviewperiod']));
// $_POST['data']['OrganizationUser']['reviewdate'] = $date->format('Y-m-d');

// echo "<pre>";print_r($_POST);die();

   $url = URL . "OrganizationUsers/assignEmployeeToOrganization/".$orgId.".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();

    if($response->body->output->status == 1){
        echo '<script>toastr.success("Employee assigned to organization successfully.");</script>';
    } else {
        echo '<script>toastr.success("Something went wrong.Please try again.");</script>';

    }       
    
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


$i = 0;
foreach ($employees as $employee ) {
    $orgimage = $employee->User->imagepath;

    $employ_name[$i]['User']['id'] = $employee->User->id;
    $employ_name[$i]['User']['name'] = $employee->User->fname." ".$employee->User->lname;

    if(!empty($orgimage)){
    $employ_name[$i]['User']['image'] = $orgimage;
    }
    else{
        $employ_name[$i]['User']['image'] = URL.'webroot/files/user_image/noimage.png';
    }
    $i++;
}

?>




<!-- Edit -->
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>Add Existing Employee <small> Add Existing Employee</small></h1>
		</div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
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

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN VALIDATION STATES-->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Employee Details</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-fit-height green dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                                Actions <i class="fa fa-angle-down"></i>
                            </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li>
                                        <a href="<?php echo URL_VIEW;?>employees/employeeRegistrationByOrg?org_id=<?php echo $orgId; ?>"><i class="fa fa-plus"></i> Add new employee</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo URL_VIEW;?>users/requestEmployeeToOrganization?org_id=<?php echo $orgId; ?>"><i class="fa fa-send (alias)"></i> Send Request</a>
                                    </li>
                                </ul>
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
                                        <label class="control-label col-md-3">Groups <span class="required">
                                        * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <select class="form-control" name="data[OrganizationUser][group_id]" required>
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
                                    <label class="control-label col-md-3">Location<span class="required">
                                    * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <input class="form-control" name="data[OrganizationUser][location]" type="text" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Position<span class="required">
                                    * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <input class="form-control" name="data[OrganizationUser][position]" type="text" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Designation <span class="required">
                                    * </span>
                                    </label>
                                    <div class="col-md-4">
<!--                                         <input class="form-control"  maxlength="200" type="text" id="OrganizationUserDesignation" required/>
 -->                                        <select class="form-control" name="data[OrganizationUser][designation]" maxlength="200"  id="OrganizationUserDesignation" required>
                                                    <option selected disabled>--Select One--</option>
                                                    <option value="Owner/General Manager">Owner/General Manager</option>
                                                    <option value="Manager">Manager</option>
                                                    <option value="Supervisor">Supervisor</option>
                                                    <option value="Leading Hand">Leading Hand</option>
                                                    <option value="Employee">Employee</option>
                                                    <option value="Junior Employee">Junior Employee</option>
                                                    <option value="Tradesman">Tradesman</option>
                                                    <option value="Apprentice">Apprentice</option>
                                                 </select> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Hire Date <span class="required">
                                    * </span>
                                    </label>
                                    <div class="col-md-4">
                                         <div class="input-append date" id="dp3">
                                            <input class="form-control form-control-inline date-picker" name="data[OrganizationUser][hire_date]" id="OrganizationUserHireDate" class="span2" size="16" type="text" value="" data-date-format="yyyy-mm-dd"/>
                                            <div class="add-on" style="cursor:pointer;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Wage <span class="required">
                                    * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <div class="checkbox-list">
                                            <div class="radio-list">
                                                <label class="radio-inline">
                                                <input type="radio" name="data[OrganizationUser][wage_status]" id="optionsRadios4" value="0" checked> Wage Per Hour </label>
                                                <label class="radio-inline">
                                                <input type="radio" name="data[OrganizationUser][wage_status]" id="optionsRadios5" value="1"> Salary</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div ng-app="">
                                    <div class="form-group" id="salaryDiv" style="display:none;">
                                        <label class="control-label col-md-3">Salary<span class="required">
                                        * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input class="form-control" min="0" step="any" name="data[OrganizationUser][salary]" type="number" id="OrganizationUserWage" ng-value="(wage * 52)*40" ng-model="salary" disabled required/>
                                        </div>
                                        <div>per year</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Wage Per Hour <span class="required">
                                        * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <input class="form-control" min="1" step="any" ng-model="wage" ng-value="(salary/52)/40" name="data[OrganizationUser][wage]" type="number" id="OrganizationUserWage" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Max Weekly Hour <span class="required">
                                    * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <input class="form-control" min="1" name="data[OrganizationUser][max_weekly_hour]" type="number" id="OrganizationUserMaxWeeklyHour" required/>
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
                                            <input class="form-control" min="1" type="number" name="data[OrganizationUser][reviewperiod]" required=""/>
                                            <select class="form-control" name="data[OrganizationUser][reviewtype]">
                                                
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
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/autocomplete/jquery.autocomplete.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/autocomplete/jquery.autocomplete.js"></script>

<script type="text/javascript">

    $(function()
        {

            $("input[name='data[OrganizationUser][wage_status]']").on('click', function(event)
                {
                    var e = $(this);
                    if(e.val() == 0)
                    {
                        $("input[name='data[OrganizationUser][salary]']").prop('disabled', true);
                        $("#salaryDiv").hide();
                    }else{

                        $("input[name='data[OrganizationUser][salary]']").prop('disabled', false);
                        $("#salaryDiv").show();
                    }
                });

    $('#autocomplete').autocomplete({
                        lookup: function (query, done) {
                            var searchString = $("#autocomplete").val();
                            var selectBranchId = $("#OrganizationUserBranchId").val();
                            var url = '<?php echo URL;?>OrganizationUsers/searchEmployeesNotInBranch/'+'<?php echo $orgId;?>/'+selectBranchId+'/'+searchString+'.json';
                            var userList;
                            $.ajax(
                                    {
                                        url:url,
                                        data:'jsonp',
                                        datatype:'post',
                                        async:false,
                                        success:function(res)
                                        {
                                            if(res.output.status ==1)
                                            {
                                                var employ = res.employees;
                                                userList = $.map(employ, function(value, index) {
                                                return {value:value.User.name,UserId:value.User.id, image:value.User.image,email:value.User.email};
                                                                });
                                                userList = {suggestions:userList};

                                            }else{
                                                userList = {suggestions:""};
                                            }
                                        }
                                    });
                            // Do ajax call or lookup locally, when done,
                            // call the callback and pass your results:
                            if(typeof userList != "undefined")
                            {
                                done(userList);
                            }
                        },
                        width:'347',
                        formatResult: function (suggestion, currentValue)
                                              {
                                                //console.log(suggestion);
                                                var dataHtml = '<div class="media"><div class="pull-left"><div class="media-object"><img src="'+
                                                suggestion['image']+
                                                '" width="50" height="50"/></div></div><div class="media-body"><h4 class="media-heading text-capitalize">'+suggestion['value']+'</h4><span>'+suggestion['email']+'</span></div></div>';
                                                return dataHtml;
                                              },
                        onSelect: function (suggestion) {
                            $('#user_id').val(suggestion['UserId']);
                        }
                    });
                
});
   
</script>



<script type="text/javascript">

$(function(){
      
$('.date-picker').datepicker().on('changeDate', function(ev){                 
        $(this).datepicker('hide');
    });
});

</script>

<!-- $('#autocomplete').autocomplete({
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
                      }); -->
