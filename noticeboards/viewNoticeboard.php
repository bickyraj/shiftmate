<?php
$noticeboard_id = $_GET["noticeboard_id"];

	$url = URL . "Noticeboards/viewNoticeboards/".$noticeboard_id .".json";
	$data = \Httpful\Request::get($url)->send();
	$notice = $data->body->notice->Noticeboard;
	
	$datatime = explode(" ", $notice->notice_date);
	$date = $datatime['0'];
	$time = $datatime['1'];
?>


<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">View Notice</div>
    </div>
    <div class="clear"></div>
	<div>
		<b>Title:</b>
	</div>
	<div>
		<?php echo $notice->title; ?>
	</div>
	<br>
	<div>
		<b>Description:</b>
	</div>

	<div>
		<?php echo $notice->description; ?>
	</div>
	<br>
	<div>
		<b>Date:</b>
	</div>

	<div>
		<?php echo $date; ?>
	</div>
	<br>
	<div>
		<b>Time:</b>
	</div>

	<div>
		<?php echo $time; ?>
	</div>

</div>
