<?php 
$boardId = $_GET['board_id'];


$url = URL."Boards/getOrgIdFromBoardId/".$boardId.".json";
$data = \Httpful\Request::get($url)->send();
$orgId = $data->body->orgId;

$url = URL."Boards/getBranchIdFromBoardId/".$boardId.".json";
$data = \Httpful\Request::get($url)->send();
$branchId = $data->body->branchId;

//get list of user related to organization but not assigned to specific board
$url = URL. "OrganizationUsers/getOrganizationUsersNotInBoard/".$orgId."/".$boardId."/".$branchId.".json";
$data = \Httpful\Request::get($url)->send();
$orgUsers = $data->body->orgUsers;
//echo "<pre>";
//print_r($orgUsers);


if (isset($_POST["submit"])) {
    // echo "<pre>";
    // print_r($_POST['data']);

    // die();

    if(!empty($_POST['data']))
    {
        $url = URL. "BoardUsers/assignEmployeeToBoard/".$boardId.".json";

        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();


        
        

        if($response->body->output->status == '1')
        {
            echo("<script>location.href = '".URL_VIEW."boardUsers/listBoardEmployees?org_id".$orgId."&board_id=".$boardId."';</script>");

            $_SESSION['success']="test";
        }   
    }
    

    // else
    // {
    //     echo("<script>location.href = '".URL_VIEW."boardUsers/assignEmployeeToBoard?board_id=".$boardId."';</script>");


    // }
}
?>
<div class="tableHeader">
    <div class="blueHeader">
        <ul class="subNav subNav_left">
            <li><a href="<?php echo URL_VIEW . 'boards/viewBoard?board_id=' . $boardId; ?>">Board</a></li>
            <li><a href="<?php echo URL_VIEW . 'shiftBoards/boardShiftList?org_id='.$orgId.'&board_id=' . $boardId; ?>">Shift List</a></li>
            <li><a href="<?php echo URL_VIEW . 'boardUsers/listBoardEmployees?org_id='.$orgId.'&board_id=' . $boardId; ?>">Board User List</a></li>
        </ul>
    </div>
    <div class="clear"></div>
<?php if(!empty($orgUsers)):?> 
    <div class="form createShift assignEmploy">
        <form action="" method="post">
           <table cellpadding="5px">

               <?php foreach($orgUsers as $orgUser):?> 
               <tr>
                <td>

                 <input type="checkbox" class="listShift-checkbox"name="data[BoardUser][user_id][]" value="<?php echo $orgUser->User->id;?>"><?php echo $orgUser->User->fname.' '.$orgUser->User->lname;?></td>

             </tr>
         <?php endforeach;?>
     </table>

     <div class="inneraction">
         <input type="submit" name="submit" value="Submit"/>
         <a href="<?php echo URL_VIEW."boardUsers/listBoardEmployees?org_id".$orgId."&board_id=".$boardId;?>"  class="cancel_a" >Cancel</a>
     </div>
 </form>
</div>
<?php else:?>
        <div class="empty_list">Sorry, no employees are available.</div>
    <?php endif;?>
</div>

<div class="clear"></div>