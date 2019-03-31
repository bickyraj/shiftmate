<?php


$orgId = $_GET['org_id'];
$homeEmployee = URL_VIEW.'organizationUsers/listOrganizationEmployees?org_id='.$orgId;
//get userId using org Id.
$url = URL . "Organizations/getUserIdFromOrgId/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$userId = $data->body->userId;


if (isset($_POST["submit"])) {
    // echo "<pre>";
    // print_r($_POST['data']);
    // die();
    $url = URL . "Users/requestEmployeeToOrganization/".$orgId.".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    // echo "<pre>";
    // print_r($response);
    // die();

  
    if(isset($response->body->output->status) && $response->body->output->status == '1')
    {
      
      echo("<script>
          toastr.success('Email Send Successfully');

        </script>");
      
    }
    else
    {
        echo("<script>
          toastr.error('Something Went Wrong');

                </script>");
    }
}
?>
<!-- Save Success Notification -->
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/ui-toastr.js"></script>
<!-- End of toastr notification js -->
<script>
jQuery(document).ready(function() {    
 
UIToastr.init(); //init Toastr Notification.
});
</script>
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


<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Send Request <small> Send Request</small></h1>
        </div> 
        <div class="page-toolbar">
            <div class="btn-group pull-right" style="margin-top: 15px;">
                <button type="button" class="btn btn-fit-height green dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                    Actions <i class="fa fa-angle-down"></i>
                </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li>
                            <a href="<?php echo URL_VIEW;?>employees/employeeRegistrationByOrg?org_id=<?php echo $orgId;?>"><i class="fa fa-plus"></i>  Add new employee</a>
                        </li>
                        <li>
                            <a class="active" href="<?php echo URL_VIEW;?>organizationUsers/assignEmployeeToOrganization?org_id=<?php echo $orgId;?>"><i class="fa fa-plus"></i>  Add existing employee</a>
                        </li>
                       <!--  <li>
                            <a href="<?php echo URL_VIEW;?>users/requestEmployeeToOrganization?org_id=1">Send Request</a>
                        </li> -->
                    </ul>
            </div>
        </div> 
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo URL_VIEW; ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo $homeEmployee; ?>">Employee</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Send Request</a>
            </li>
        </ul>
<div class="row">
    <div class="col-md-6">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet green box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Employee Details
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" id="UserAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                    </div>
                    <div class="form-body">
                       <!--  <div style="display:none;">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="data[Shift][id]" value="1">
                        </div> -->
                       <div class="form-group">
                            <label class="control-label col-md-4">Email <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" name="data[User][email]" maxlength="200" type="email" id="UserEmail" required="required"/>
                            </div>
                            <li style="list-style-type:none;">
                                <div class="loader" style="display:none;"><img src="<?php echo URL_IMAGE.'ajax-loader.gif';?>" /></div>
                                    <i id="error" style="display:none; float:right;padding-right:62px;"></i>
                            </li>
                        </div>
                         
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <input id="employeeSubmit" type="submit" name="submit" value="Submit" class="btn green">
                                <a class="btn default" href="http://192.168.1.104/shiftmate_view/organizationUsers/listOrganizationEmployees?org_id=1">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">

$(function()
    {

        var UserAddForm = false;
             $("#UserAddForm").on('submit', function(event)
                {
                    var email = $("#UserEmail").val();


                    if(UserAddForm === false)
                    {
                        //console.log(UserAddForm);
                        event.preventDefault();
                        checkEmail(email);
                    }

                    $(this).submit(function(){
                        return false;
                    });

                    return true;

                });

        function validateEmail(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return re.test(email);
        }

            $("#UserEmail").blur(function()
                {

                    var email = $(this).val();
                    var validEmail = validateEmail(email);

                    var urli = '<?php echo URL."Users/checkUniqueEmail1.json";?>';
                     var loader = $(".loader");
                     var error = $("#error");

                     error.css("display", "none");

                     if(email === "" || validEmail==false)
                     {
                        error.css("display", "block");
                        error.html("Invalid email.").css("color", "red");
                     }

                     else
                     {
                        loader.css("display", "block");

                         $.ajax({
                                  url:urli,
                                  type:'post',
                                  data:'email='+email,
                                  success:function(response)
                                                       {
                                                        console.log(response);
                                                            var status = response.output.status;
                                                            
                                                            console.log(status);
                                                            loader.css("display","none");

                                                            if(status == 0){

                                                                error.css("display", "block");
                                                                error.html("valid email.").css("color", "green");
                                                            }
                                                            else if(status == 1){
                                                                error.css("display", "block");
                                                                error.html("The email is already in use.").css("color", "red");
                                                            }
                                                            else {
                                                                error.css("display", "block");
                                                                error.html("Email Already in use.Contact personally for more detail.").css("color", "red");
                                                            }
                                                       }
                             });
                     }

                });


        function checkEmail(email)
        {
                     var urli = '<?php echo URL."Users/checkUniqueEmail1.json";?>';
                     var loader = $(".loader");
                     var error = $("#error");
                     error.css("display", "none");


                        loader.css("display", "block");

                         $.ajax({
                                  url:urli,
                                  type:'post',
                                  data:'email='+email,
                                  success:function(response)
                                                       {
                                                            var status = response.output.status;
                                                            loader.css("display","none");

                                                            if(status === 1){
                                                                error.css("display", "block");
                                                                error.html("The email is already in use.").css("color", "red");

                                                                UserAddForm = false;
                                                            }else if(status === 0){

                                                                error.css("display", "block");
                                                                error.html("valid email.").css("color", "green");

                                                                UserAddForm = true;
                                                                $('#UserAddForm').unbind('submit').submit();
                                                                $('#employeeSubmit').click();

                                                            } else {
                                                                error.css("display", "block");
                                                                error.html("The email is already in use.").css("color", "red");
                                                                UserAddForm = false;
                                                            }
                                                       }
                             });


        }
    });

</script>













