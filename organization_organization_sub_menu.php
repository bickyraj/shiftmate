<?php
$url_name = null;
if(isset($url) && !empty($url)){
    $url_name = $url[1];
    $url_name0 = $url[0];
}
?>
<li class="menu-dropdown classic-menu-dropdown <?php echo (($url_name == "boardShiftList" || $url_name=="listBoardEmployees" || $url_name == "assignUserInShift" || $url_name == "shiftScheduleOverview")) ? "active" : ""; ?>">
                <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" class="<?php echo(($url[0]=="shifts")? 'active':'');?>">
                <i class="glyphicon glyphicon-time "></i>
                <span class="title">Department</span>
                <span class="selected"></span>
                <i class="fa fa-angle-down"></i>
                </a>
			<ul class="dropdown-menu">
				<!-- DOC: Remove data-hover="megadropdown" and data-close-others="true" attributes below to disable the horizontal opening on mouse hover -->
				<li class="classic-menu-dropdown <?php echo ($url_name == "viewBoard") ? "active" : ""; ?>">
					<a href="<?php echo URL_VIEW . 'boards/viewBoard?board_id=' . $board_id; ?>">
					<i class="icon-home"></i> 
                    Department <?php if($url_name == 'viewBoard'){echo '<span class="selected"></span>';}?>
					</a>
				</li>
            <li <?php echo ($url_name == "boardShiftList") ? "class = 'active'" : ""; ?>><a href="<?php echo URL_VIEW . 'shiftBoards/boardShiftList?board_id=' . $board_id; ?>">Shift List<?php if($url_name == 'boardShiftList'){echo '<span class="selected"></span>';}?></a></li>
            <li <?php echo ($url_name == "listBoardEmployees") ? "class = 'active'" : ""; ?>><a href="<?php echo URL_VIEW . 'boardUsers/listBoardEmployees?board_id=' . $board_id; ?>">Members<?php if($url_name == 'listBoardEmployees'){echo '<span class="selected"></span>';}?></a></li>
            <li <?php echo ($url_name == "assignUserInShift") ? "class = 'active'" : ""; ?>><a class="active" href="<?php echo URL_VIEW . 'ShiftUsers/assignUserInShift?board_id=' . $board_id; ?>">Department Schedule<?php if($url_name == 'assignUserInShift'){echo '<span class="selected"></span>';}?></a></li>
            <li <?php echo ($url_name == "shiftScheduleOverview") ? "class = 'active'" : ""; ?>><a href="<?php echo URL_VIEW . 'shifts/shiftScheduleOverview?board_id=' . $board_id; ?>">Department Overview<?php if($url_name == 'shiftScheduleOverview'){echo '<span class="selected"></span>';}?></a></li>

            </ul>
</li>




