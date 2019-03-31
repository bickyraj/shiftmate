<?php
//$orgId = $_GET['org_id'];
//$branch_id = $_GET['branch_id'];

$url = URL ."BoardUsers/myOrgBranchBoard/".$user_id."/".$orgId."/".$branch_id.".json";
$org = \Httpful\Request::get($url)->send();


//echo "<pre>";
//print_r($org);
$myOrgBranchBoard = $org->body->myOrgBranchBoard;

//print_r($myOrgBranchBoard);
//die();


?>

<div class="tableHeader">
    

        <!-- Table -->
        <table class="table_list" width="98%;" align="center">
            <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
                <th><p>SN</p></th>
                <th><p>Board</p></th>
                <th><p>Action</p></th>
            </tr>
            <?php
            $count = 1;
            foreach($myOrgBranchBoard as $myOrgBranchBoards){
              ?>
              <tr class="list_users">
               <td><?php echo $count; $count++;?></td>
               <td><a href="<?php echo URL_VIEW . 'organizationUsers/employee/myOrgBranchBoardDetail?board_id='.$myOrgBranchBoards->Board->id;?>&org_id=<?php echo $orgId;?>&branch_id=<?php echo $branch_id;?>"><?php echo $myOrgBranchBoards->Board->title;?></a></td>
               <td class="action_td">
                <ul class="action_btn">
                    <li><div class="hover_action"></div>
                        <a href="<?php echo URL_VIEW . 'organizationUsers/employee/myOrgBranchBoardDetail?board_id='.$myOrgBranchBoards->Board->id;?>&org_id=<?php echo $orgId;?>&branch_id=<?php echo $branch_id;?>"><button 
                            class="view_img"></button>
                        </a>
                    </li>
                </ul>
            </td>
        </tr>   

        <?php } ?>
    </table>
    <!-- End of Table -->


