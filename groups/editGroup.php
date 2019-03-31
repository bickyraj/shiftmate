<?php


$orgId = $_GET['org_id'];
$groupId = $_GET['group_id'];

$url = URL . "Groups/editGroup/".$groupId.".json";
$data = \Httpful\Request::get($url)->send();
$group = $data->body->group;
//echo "<pre>";
//print_r($group);

if (isset($_POST["submit"])) {
    $url = URL . "Groups/editGroup/" . $groupId . ".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    // echo "<pre>";
    // print_r($response);

    if($response->body->output->status == '1')
    {
        echo("<script>location.href = '".URL_VIEW."groups/listGroups?org_id=".$orgId."';</script>");

        $_SESSION['success']="test";
    }
}
?>

<!-- <form action="" id="GroupAddForm" method="post" accept-charset="utf-8">
    <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
        <input type="hidden" name="data[Group][id]" value="<?php echo $group->Group->id;?>">
    </div>

    <!-- Create Group Table -->
    <!--<div class="tableHeader">
        <div class="blueHeader">
        <div class="table-heading">Edit Group</div>
        </div>
        <div class="clear"></div>

        <div class="form createShift">
            <form action="" method="post" accept-charset="utf-8">
                <div style="display:none;">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="data[Shift][id]" value="1">
                </div>
                <table cellpadding="5px">

                    <tbody><tr>
                        <th>Title</th>
                        <td><input name="data[Group][title]" value="<?php echo $group->Group->title;?>" maxlength="100" type="text" id="GroupTitle" required="required"/></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <a class="cancel_a" href="<?php echo URL_VIEW."groups/listGroups?org_id=".$orgId;?>">Cancel</a>
                            <input type="submit" name="submit" value="Submit" class="rightbtn"></td>
                    </tr>   
                </tbody>
            </table>
        </form>
    </div>

    <div class="clear"></div>

</div> -->
    <!-- end of Create Group Table -->
<!-- </form> -->



<div class="page-head">
    <div class="container">
        <div class="page-title">
    		<h1>Groups <small> Edit Group</small></h1>
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
                    <a href="<?=URL_VIEW."groups/listGroups";?>">Groups</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="javascript:;">Edit Group</a>
                </li>
            </ul>

<div class="row">
    <div class="col-md-6 col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Edit Group
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form class="form-horizontal" action="" id="GroupAddForm" method="post" accept-charset="utf-8">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                        <input type="hidden" name="data[Group][id]" value="<?php echo $group->Group->id;?>">
                    </div>
                    <div class="form-body">
                    <div style="display:none;">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="data[Shift][id]" value="1">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Title <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" name="data[Group][title]" value="<?php echo $group->Group->title;?>" maxlength="100" type="text" id="GroupTitle" required="required"/>
                            </div>
                        </div>
                    </div>
                   <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <input type="submit" name="submit" value="Submit" class="btn green">
                                <a class="btn default" href="<?php echo URL_VIEW."groups/listGroups?org_id=".$orgId;?>">Cancel</a>
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