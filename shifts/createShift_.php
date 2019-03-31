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

<!-- Failed Div -->
<div id="save_success" class="redFont">There was some error during saving. Please try again.</div>
<!-- End of Failed Div -->



<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Create Shift</div>
    </div>
    <div class="clear"></div>

    <div class="createShift form">
        <form action="" id="ShiftAddForm" method="post" accept-charset="utf-8" class="createShift form">
           <table class="create_form_table" cellpadding="5px">
            <div style="display:none;">
                <input type="hidden" name="_method" value="POST"/>
            </div>
            <tr>
               <th>Title</th>
               <td><input type="text" name="data[Shift][title]" required /></td>
           </tr>

           <tr>
               <th>Starttime</th>
               <td>
                <div>
                    <select name="data[Shift][starttime][hour]"  class="hourBox">
                        <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
                        <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
                        <?php } ?>
                    </select>:

                    <select name="data[Shift][starttime][min]" class="hourBox">
                        <?php for ($min = 0; $min < 60; $min++) { ?>
                        <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
                        <?php }?>
                    </select>

                    <select name="data[Shift][starttime][meridian]" size="1" class="hourBox">
                        <option value="am">am</option>
                        <option value="pm">pm</option>
                    </select>
                </div>
            </td>

        </tr>	

        <tr>
           <th>Endtime</th>
           <td>
            <div>
                <select name="data[Shift][endtime][hour]"  class="hourBox">
                    <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
                    <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
                    <?php } ?>
                </select>:

                <select name="data[Shift][endtime][min]" class="hourBox">
                    <?php for ($min = 0; $min < 60; $min++) { ?>
                    <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
                    <?php }?>
                </select>

                <select name="data[Shift][endtime][meridian]" size="1" class="hourBox">
                    <option value="am">am</option>
                    <option value="pm">pm</option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
        <th>Choose Branches to use shift</th>


        <td>
            <ul>
                <?php foreach($branches as $key=>$branch):?>
                <li><input type="checkbox" name="data[ShiftBranch][][branch_id]" value="<?php echo $key;?>"><label><?php echo $branch;?></label></li>
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

<div class="clear"></div>