<?php


$boardId = $_GET['board_id'];

if(isset($_GET['page'])){
    $page = "page:".$_GET['page'];
}else{
    $page = '';
}


$url = URL."ShiftBoards/boardShiftList/".$boardId."/".$page.".json";
$data = \Httpful\Request::get($url)->send();
$BoardShifts = $data->body->boardShifts;
// echo "<pre>";
// print_r($BoardShifts);

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

    
        <a href="<?php echo URL_VIEW . 'shiftBoards/assignShiftToBoard?board_id='.$boardId; ?>"><button class="addBtn">Add Shift To Board</button></a>
    
    <div class="clear"></div>

    <!-- Table -->
    <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>SN</p></th>
        <th><p>Shift Name</p></th>
        <th><p>Start Time</p></th>
        <th><p>End Time</p></th>
        
        <th><p>Action</p></th>

        </tr>

        <?php if(isset($BoardShifts)):?>
                <?php $i = 1; ?>
                <?php foreach ($BoardShifts as $BoardShift): ?>
                    <tr class="list_users">
                        <td><?php echo $i++; ?><input class="listShift-checkbox" type="checkbox"/></td>
                        <td><?php echo $BoardShift->Shift->title; ?></td>
                        <td><?php echo $BoardShift->Shift->starttime; ?></td>
                        <td><?php echo $BoardShift->Shift->endtime; ?></td>
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

            <div class="empty_list">No Shifts Added.</div>
        <?php endif;?>
        </table>
    <!-- End of Table -->
    
    <?php 
            if($totalPage >1){
                $previousPage = $currentPage-1;
                $nextPage = $currentPage+1;
                ?>
            <div class="paginator">
                        <ul>
                            <li>
                                 <?php if($currentPage == 1){?>
                                <div class="deactive"><</div>
                                <?php }else{?>
                                <a class="no-underline" href="<?php echo URL_VIEW . 'shiftBoards/boardShiftList?board_id=' . $boardId.'&page='.$previousPage; ?>"><</a></li>
                                <?php }?>
                                    <?php  for($i=1; $i<=$totalPage; $i++){?>
                                <li><a class="<?php echo ($currentPage==$i)? 'active':'';?>" href="<?php echo URL_VIEW . 'shiftBoards/boardShiftList?board_id=' . $boardId.'&page='.$i; ?>"><?php echo $i;?></a></li>
                             <?php  }?>
                            <li>
                                <?php if($totalPage == $currentPage){?>
                                <div class="deactive">></div>
                                <?php }else{?>
                                <a class="no-underline" href="<?php echo URL_VIEW . 'shiftBoards/boardShiftList?board_id=' . $boardId.'&page='.$nextPage; ?>">></a></li>
                                <?php }?>
                        </ul>
                    </div>
            <?php }
                 ?>