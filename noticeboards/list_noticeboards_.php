<?php
$orgId = $_GET['org_id'];

// if (isset($_GET['page'])) {
//     $page = "page:" . $_GET['page'];
// } else {
//     $page = '';
// }


$url = URL . "Noticeboards/listNoticeboards/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();
$notices = $data->body->notices;

//$totalPage = $data->body->output->pageCount;
//$currentPage = $data->body->output->currentPage;
// echo "<pre>";
// print_r($notices);
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
// </script>
<!-- End of Save Success Notification -->

<!-- Success Div -->
<div id="save_success">Saved Successfully !!</div>
<!-- End of Success Div -->


<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Notice Board</div>
        <a href="<?php echo URL_VIEW . 'noticeboards/addnoticeboards?org_id=' . $orgId; ?>"><button class="addBtn">Add New</button></a>
    </div>
    <div class="clear"></div>

    <!-- Table -->
    <table class="table_list" width="98%;" align="center">
        <tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
            <th><p>SN</p></th>
        <th><p>Title</p></th>
        <th><p>Date</p></th>
        <th><p>Action</p></th>

        </tr>

        <?php $i = 1; ?>
        <?php foreach ($notices as $notice):

            
         ?>
            <?php
                $datetime = explode(" ",$notice->Noticeboard->notice_date);
                $date = $datetime['0'];
            ?>
            <tr class="list_users">
                <td><?php echo $i++; ?></td>
                <td><?php echo $notice->Noticeboard->title; ?></td>
                <td><?php echo $date; ?></td>

                <td class="action_td">
                    <ul class="action_btn">
                        <li><div class="hover_action"></div>
                                    <a href="<?php echo URL_VIEW . 'Noticeboards/viewNoticeboard?noticeboard_id=' . $notice->Noticeboard->id; ?>"><button 
                                        class="view_img"></button>
                                    </a>
                                </li>
                        <li>
                            <div class="hover_action"></div>
                            <a href="<?php echo URL_VIEW . 'Noticeboards/editNoticeboard?noticeboard_id=' . $notice->Noticeboard->id.'&org_id='.$orgId; ?>"><button class="edit_img"></button>
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


    