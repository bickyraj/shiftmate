<?php 
$groupId = $_GET['group_id'];

if (isset($_GET['page'])) {
    $page = "page:" . $_GET['page'];
} else {
    $page = '';
}


//get list of user related to specific Group
$url = URL . "UserGroups/listEmployeesInGroup/".$groupId. "/" . $page .".json";
$data = \Httpful\Request::get($url)->send();

// echo "<pre>";
// print_r($data);


$userGroups = $data->body->userGroups;

$totalPage = $data->body->output->pageCount;
$currentPage = $data->body->output->currentPage;

?>

<!-- Save Success Notification -->
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

<!-- Success Div -->
<div id="save_success">Saved Successfully !!</div>
<!-- End of Success Div -->


<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Employees List of <span style="text-transform:capitalize;"></span></div>
        <a href="<?php echo URL_VIEW . 'userGroups/assignEmployeeToGroup?org_id=' . $orgId.'&group_id='.$groupId; ?>"><button class="addBtn">Assign New Employee</button></a>
    </div>
    <div class="clear"></div>

    <!-- Table -->
    <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>SN</p></th>
        <th><p>Name</p></th>
        <th><p>Email</p></th>
        <th><p>Address</p></th>
        <th><p>Phone</p></th>
        <th><p>Action</p></th>

        </tr>

        <?php if($userGroups):?>
                <?php $i = 1; ?>
                <?php foreach ($userGroups as $userGroup): ?>
                    <tr class="list_users">
                        <td><?php echo $i++; ?><input class="listShift-checkbox" type="checkbox" name="<?php echo $userGroup->User->id;?>"/></td>
                        <td><?php echo $userGroup->User->fname.' '.$userGroup->User->lname; ?></td>
                        <td><?php echo $userGroup->User->email; ?></td>
                        <td><?php echo $userGroup->User->address; ?></td>
                        <td><?php echo $userGroup->User->phone; ?></td>
                        <td class="action_td">
                            <ul class="action_btn">
                                
                                <form action="/newshiftmate/Organizations/delete/1" name="post_5476f94dde83b126092591" id="post_5476f94dde83b126092591" style="display:none;" method="post">
                                    <input type="hidden" name="_method" value="POST"/>
                                </form>
                                <li>
                                    <div class="hover_action"></div>
                                    <a href="#" onclick="if (confirm( & quot; Are you sure you want to delete # 1? & quot; ))
                                            {
                                                document.post_5476f94dde83b126092591.submit();
                                            }
                                            event.returnValue = false;
                                            return false;"><button class="delete_img"></button>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
            <?php endforeach; ?>

        <?php else:?>
            <div class="empty_list">No Employee are Assigned.</div>
        <?php endif;?>
        </table>
    <!-- End of Table -->

    <!-- Bulk Action -->
                <div class="bulkaction-div">
                        <select>
                          <option value="volvo">Bulk Action</option>
                          <option value="saab">Delete</option>
                        </select>
                        <button id="bulkBtn">Apply</button>
                </div>
    <!-- End of Bulk Action -->
    
    <?php
        if ($totalPage > 1) {
            $previousPage = $currentPage - 1;
            $nextPage = $currentPage + 1;
            ?>
        <div class="paginator">
            <ul>
                <li>
        <?php if ($currentPage == 1) { ?>
                        <div class="deactive"><</div>
    <?php } else { ?>
                        <a class="no-underline" href="<?php echo URL_VIEW . 'userGroups/listEmployeesInGroup?group_id=' . $groupId . '&page=' . $previousPage; ?>"><</a></li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
                    <li><a class="<?php echo ($currentPage == $i) ? 'active' : ''; ?>" href="<?php echo URL_VIEW . 'userGroups/listEmployeesInGroup?group_id=' . $groupId . '&page=' . $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li>
                <?php if ($totalPage == $currentPage) { ?>
                        <div class="deactive">></div>
                <?php } else { ?>
                        <a class="no-underline" href="<?php echo URL_VIEW . 'userGroups/listEmployeesInGroup?group_id=' . $groupId . '&page=' . $nextPage; ?>">></a></li>
                    <?php } ?>
            </ul>
        </div>
                <?php }
                ?>

