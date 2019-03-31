<?php
$shiftId = $_GET['shift_id'];
$orgId = $_GET['org_id'];

$url = URL . "Shifts/editShift/" . $shiftId . ".json";
$data = \Httpful\Request::get($url)->send();
$shift = $data->body->shift;

$url = URL."Branches/listBranchesName/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;
// echo "<pre>";
// print_r($ranches);

$url = URL . "ShiftBranches/getShiftRelatedBranches/" . $shiftId . ".json";
$data = \Httpful\Request::get($url)->send();
$shiftBranchList = $data->body->shiftBranchList;
//echo "<pre>";
//print_r($shiftBranchList);

if(empty($shiftBranchList)){
   $shiftBranchList = array(); 
}else{
    $shiftBranchList = get_object_vars($shiftBranchList);
}


if (isset($_POST["submit"])) {
    //echo "<pre>";
    // print_r($_POST['data']);
    $url = URL . "Shifts/editShift/" . $shiftId . ".json";
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
}
?>

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Edit Shift <small>Edit Shift</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Shift</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Edit Shift</a>
            </li>
        </ul>

<div class="row">
    <div class="col-md-8 col-sm-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Edit Shift
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form class="form-horizontal"action=""  method="post" accept-charset="utf-8">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                        <input type="hidden" name="data[Group][id]" value="<?php echo $group->Group->id;?>">
                    </div>
                    <div class="form-body">
                    <input type="hidden" name="_method" value="POST"/>
        <input type="hidden" name="data[Shift][id]" value="<?php echo $shiftId; ?>"/>
                        <div class="form-group">
                            <label class="control-label col-md-4">Title <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" name="data[Shift][title]" value="<?php echo $shift->Shift->title;?>"maxlength="100" type="text" id="GroupTitle" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Start time <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" name="data[Shift][starttime]"  value="<?php echo $shift->Shift->starttime;?>" maxlength="100" type="text" id="GroupTitle" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">End time <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" name="data[Shift][endtime]" value="<?php echo $shift->Shift->endtime;?>" maxlength="100" type="text" id="GroupTitle" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Choose Branches to use shift <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                            <?php foreach($branches as $key=>$branch):?>

                                <?php echo $key; ?>
                               <input <?php echo (in_array($key, $shiftBranchList))?'checked="checked"':'';?> class="form-control" name="data[ShiftBranch][][branch_id]" value="<?php echo $key;?>" maxlength="100" type="checkbox" id="GroupTitle" required="required"/><label class="control-label"><?php echo $branch;?>`</label>
                                
                    
                                    <?php endforeach;?>
                            
                            </div>
                        </div>

                    </div>
                   <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <input type="submit" name="submit" value="Submit" class="btn green">
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




















<!-- 
<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Edit Shift</div>
    </div>
    <div class="clear"></div>

<div class="form createShift">
<form action=""  method="post" accept-charset="utf-8">
	<table cellpadding="5px">
     <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
        <input type="hidden" name="data[Shift][id]" value="<?php echo $shiftId; ?>"/>
    </div>
    <tr>
    	<th>Title</th>
        <td><input type="text" name="data[Shift][title]" value="<?php echo $shift->Shift->title;?>"/></td>
    </tr>
    
    <tr>
    	<th>Starttime</th>
        <td><input type="text" name="data[Shift][starttime]"  value="<?php echo $shift->Shift->starttime;?>" /></td>
    </tr>	
    
    <tr>
    	<th>Endtime</th>
        <td><input type="text" name="data[Shift][endtime]" value="<?php echo $shift->Shift->endtime;?>" /></td>
    </tr>
    <tr>
        <th>Choose Branches to use shift</th>

        <td>
        <ul>
            <?php foreach($branches as $key=>$branch):?>
                    
                        <li>
                            <input <?php echo (in_array($key, $shiftBranchList))?'checked="checked"':'';?> type="checkbox" name="data[ShiftBranch][][branch_id]" value="<?php echo $key;?>"><label><?php echo $branch;?></label><br/>
                        </li>
                    
                <?php endforeach;?>
        </ul>
    </td>
    
    </tr>
    
    <tr>
    	<td colspan="2">
            <a class="cancel_a" href="<?php echo URL_VIEW."shifts/listShifts?org_id=".$orgId;?>">Cancel</a>
            <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>	
    </table>
</form>
</div>
 -->
   <div class="clear"></div>