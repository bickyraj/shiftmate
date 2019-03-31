<?php


$orgId = $_GET['org_id'];


if (isset($_POST["submit"])) {
    echo "<pre>";
    // print_r($_POST['data']);
    $url = URL . "Groups/createGroup/" . $orgId . ".json";
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

<form action="" id="GroupAddForm" method="post" accept-charset="utf-8">
    <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
    </div>
    <!-- Create Group Table -->
    <div class="tableHeader">
        <div class="blueHeader">
        <div class="table-heading">Create Group</div>
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
                        <td><input id="GroupTitle" required="required" type="text" name="data[Group][title]"></td>
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

</div>
    <!-- end of Create Group Table -->
</form>