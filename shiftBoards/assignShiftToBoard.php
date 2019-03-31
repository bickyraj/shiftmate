<?php


$boardId = $_GET['board_id'];
//$orgId = $_GET['org_id'];
$url = URL."Boards/getBranchIdFromBoardId/".$boardId.".json";
$data = \Httpful\Request::get($url)->send();
$branchId = $data->body->branchId;



$url = URL."ShiftBoards/getShiftListNotInBoard/".$boardId."/".$branchId.".json";
$data = \Httpful\Request::get($url)->send();
$shiftsBoard = $data->body->shiftNotInBoard;
// echo "<pre>";
// print_r($shiftsBoard);

if (isset($_POST["submit"])) {
    // echo "<pre>";
    // print_r($_POST['data']);

    if(!empty($_POST['data']))
    {
        $url = URL . "ShiftBoards/assignShiftToBoard/".$boardId.".json";
        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();
        // echo "<pre>";
        // print_r($response);

        if($response->body->output->status == '1')
        {
            echo("<script>location.href = '".URL_VIEW."shiftBoards/boardShiftList?org_id=".$orgId."&board_id=".$boardId."';</script>");

            $_SESSION['success']="test";
        }
    }
    

    
}


?>

<div class="tableHeader">
   <!--  <div class="blueHeader">
        <ul class="subNav subNav_left">
            <li><a href="<?php echo URL_VIEW . 'boards/viewBoard?board_id=' . $boardId; ?>">Board</a></li>
            <li><a href="<?php echo URL_VIEW . 'shiftBoards/boardShiftList?org_id='.$orgId.'&board_id=' . $boardId; ?>">Shift List</a></li>
            <li><a href="<?php echo URL_VIEW . 'boardUsers/listBoardEmployees?org_id='.$orgId.'&board_id=' . $boardId; ?>">Board User List</a></li>
        </ul>
    </div> -->
    <div class="clear"></div>

    

    <div class="form createShift">
        <form action="" method="post">
         <table cellpadding="5px">

            <?php if(!empty($shiftsBoard)):?>  
            <tr>
                <?php foreach($shiftsBoard as $shifts):?>
                <td>
                    <input type="checkbox" class="listShift-checkbox" name="data[ShiftBoard][shift_id][]" value="<?php echo $shifts->Shift->id;?>"><?php echo $shifts->Shift->title;?></td>
                <?php endforeach;?>
                
            </tr>

            <tr>
             <td>
                <input type="submit" name="submit" value="Submit"/>
                <a class="cancel_a" href="<?php echo URL_VIEW."shiftBoards/boardShiftList?org_id=".$orgId."&board_id=".$boardId;?>">Cancel</a>
            </td>

        </tr>	

    <?php else:?>
    <div class="empty_list">Sorry, no shifts are available.</div>
<?php endif;?>
</table>
</form>
</div>



<div class="clear"></div>

