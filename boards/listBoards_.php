<?php


$orgId = $_GET['org_id'];
if(isset($_GET['page'])){
    $page = "page:".$_GET['page'];
}else{
    $page = '';
}

$url = URL."Boards/listBoards/".$orgId."/".$page.".json";
$data = \Httpful\Request::get($url)->send();
$boards = $data->body->boards;

//echo "<pre>";
//print_r($boards);

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
        <div class="table-heading">Board List</div>
        <a href="<?php echo URL_VIEW . 'boards/createBoard?org_id=' . $orgId; ?>"><button class="addBtn">Add New</button></a>
    </div>
    <div class="clear"></div>

    <!-- Table -->
    <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>SN</p></th>
        <th><p>Board Name</p></th>
        <th><p>Branch</p></th>
        <th><p>Manager</p></th>
        <th><p>Shift List</p></th>
        
        <th><p>Action</p></th>

        </tr>

        <?php $i = 1; ?>
        <?php foreach ($boards as $board): ?>
            <tr class="list_users">
                <td><?php echo $i++; ?><input class="listShift-checkbox" type="checkbox"/></td>
                <td><a href="<?php echo URL_VIEW . 'boards/viewBoard?board_id=' . $board->Board->id; ?>"><?php echo $board->Board->title; ?></a></td>
                <td><?php echo $board->Branch->title; ?></td>
                <td><?php echo $board->User->fname.' '.$board->User->lname; ?></td>
                
                <td>
                    <?php $j = 0; 
                    foreach($board->ShiftBoard as $shift):
                        echo ($j != 0)?', ':'';
                        echo $shift->Shift->title;
                    $j++;
                    endforeach;?>
                    
                </td>
                <!--<td><a href="<?php echo URL_VIEW . 'shiftBoards/boardShiftList?org_id='.$orgId.'&board_id=' . $board->Board->id; ?>">Board Shifts</a></td>
                <td><a href="<?php echo URL_VIEW . 'boardUsers/listBoardEmployees?org_id='.$orgId.'&board_id=' . $board->Board->id; ?>">Board Users</a></td>-->
                <td class="action_td">
                    <ul class="action_btn">
                         <li>
                            <div class="hover_action"></div>
                            <a href="<?php echo URL_VIEW . 'boards/viewBoard?board_id=' . $board->Board->id; ?>"><button class="view_img"></button>
                            </a>
                        </li>
                        <li>
                            <div class="hover_action"></div>
                            <a href="<?php echo URL_VIEW . 'boards/editBoard?org_id='.$orgId.'&board_id=' . $board->Board->id; ?>"><button class="edit_img"></button>
                            </a>
                        </li>
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
                    <a class="no-underline" href="<?php echo URL_VIEW . 'boards/listBoards?org_id=' . $orgId.'&page='.$previousPage; ?>"><</a></li>
                    <?php }?>
                        <?php  for($i=1; $i<=$totalPage; $i++){?>
                    <li><a class="<?php echo ($currentPage==$i)? 'active':'';?>" href="<?php echo URL_VIEW . 'boards/listBoards?org_id=' . $orgId.'&page='.$i; ?>"><?php echo $i;?></a></li>
                 <?php  }?>
                <li>
                    <?php if($totalPage == $currentPage){?>
                    <div class="deactive">></div>
                    <?php }else{?>
                    <a class="no-underline" href="<?php echo URL_VIEW . 'boards/listBoards?org_id=' . $orgId.'&page='.$nextPage; ?>">></a></li>
                    <?php }?>
            </ul>
        </div>
<?php }
     ?>