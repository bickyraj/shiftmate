<?php


$orgId = $_GET['org_id'];

$url = URL."Branches/listBranchesName/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;


if (isset($_POST["submit"])) {
    // echo "<pre>";
     //print_r($_POST['data']);
	 //die();
    $url = URL . "Shifts/createShift/" . $orgId . ".json";
    $response = \Httpful\Request::post($url)
    ->sendsJson()
    ->body($_POST['data'])
    ->send();
    // echo "<pre>";
    // print_r($response);

    if($response->body->output->status == '1')
    {
        echo("<script>location.href = '".URL_VIEW."shifts/listShifts?org_id=".$orgId."';</script>");

        $_SESSION['success']="test";
    }

    else
    {
        $_SESSION['fail']= 'test';


    }
}


?>

<!-- Save Failed Notification -->
<script type="text/javascript">
$(document).ready(function()
{
    var top_an = $("#save_success").css('top');
    $("#save_success").css('top','0px');

    <?php if(isset($_SESSION['fail'])):?>
    $("#save_success").show().animate({top:top_an});
    <?php unset($_SESSION['fail']);?>
    setTimeout(function()
    {
        $("#save_success").fadeOut();
    }, 3000);
    <?php endif;?>
});
</script>
<!-- End of Save Failed Notification -->


<!-- Edit -->
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Create Shift <small> Create Shift</small></h1>
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
                <a href="#">Shifts</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Create shift</a>
            </li>
        </ul>

<div class="row">
    <div class="col-md-8 sol-sm-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Shift Detail
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
                            <label class="control-label col-md-4">Title <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="data[Shift][title]" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Start Time <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="form-control" name="data[Shift][starttime][hour]"  class="hourBox">
                                            <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
                                            <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="data[Shift][starttime][min]" class="hourBox">
                                            <?php for ($min = 0; $min < 60; $min++) { ?>
                                            <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="data[Shift][starttime][meridian]" size="1" class="hourBox">
                                            <option value="am">am</option>
                                            <option value="pm">pm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">End Time <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="form-control" name="data[Shift][endtime][hour]"  class="hourBox">
                                            <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
                                            <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="data[Shift][endtime][min]" class="hourBox">
                                            <?php for ($min = 0; $min < 60; $min++) { ?>
                                            <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="data[Shift][endtime][meridian]" size="1" class="hourBox">
                                        <option value="am">am</option>
                                        <option value="pm">pm</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Choose Branches to use shift <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <?php foreach($branches as $key=>$branch):?>
                                    <input type="checkbox" name="data[ShiftBranch][][branch_id]" value="<?php echo $key;?>">
                                    <label class="control-label"><?php echo $branch;?></label>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                            <input  type="submit" name="submit" value="Submit" class="btn green"/>
                            <a class="btn default" href="<?php echo URL_VIEW."shifts/listShifts?org_id=".$orgId;?>">Cancel</a>
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
