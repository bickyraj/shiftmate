<?php
$board_id=$_GET['board_id'];

	$url = URL."ShiftBoards/shiftListDetail/".$board_id.".json";
	$data = \Httpful\Request::get($url)->send();
      
	$boardShifts = $data->body;
	$shiftColor = array();
	$color = '000000';
	foreach ($boardShifts as $boardShift) {
		$color = str_pad(dechex($color + 600),6,'0');
		$shiftColor[$boardShift->Shift->id]['title'] = $boardShift->Shift->title;
		$shiftColor[$boardShift->Shift->id]['color'] = '#'.$color;
	}
$url1 = URL."Boards/viewBoard/".$board_id.".json";
$data1 = \Httpful\Request::get($url1)->send();
$board = $data1->body->board;
?>

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1><?php echo $board->Board->title; ?> Department <small><?php echo $board->Branch->title; ?> Branch </small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
    			<i class="fa fa-home"></i>
    			<a href="<?=URL_VIEW;?>">Home</a>
    			<i class="fa fa-circle"></i>
    		</li>
    		<li>
    			<a href="javascript:;">Shifts</a>
                <i class="fa fa-circle"></i>
    		</li>
            <li>
                <a href="javascript:;">shift Schedule Overview</a>
            </li>
        </ul>
        
		<div class="row">
			<div class="col-md-3">
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption caption-md">
							<i class="icon-bar-chart theme-font hide"></i>
							<span class="caption-subject theme-font bold uppercase">Shifts</span>
							<!-- <span class="caption-helper hide">weekly stats...</span> -->
						</div>
					</div>
					<div class="portlet-body">
						<div class="form-group">
							<select class="form-control select2me shiftboard" data-placeholder="Select...">
								 <option value="0">Overall</option>
									 <?php foreach ($boardShifts as $shift): ?>
										<option value="<?php echo $shift->Shift->id; ?>"><?php echo $shift->Shift->title; ?></option>
									 <?php endforeach; ?>
							</select>
						</div>
			            <div class="form-group">
			                <?php foreach($shiftColor as $shft=>$clr){
			                    echo '<ul class="list-inline" style="margin-left:0px;"><li style="height:20px;width: 20px;background-color:'.$clr['color'].';"></li><li><strong>&nbsp;&nbsp;'.$clr['title'].'</strong></li></ul>';
			                }?>
			            </div>
			        </div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption caption-md">
							<i class="icon-bar-chart theme-font hide"></i>
							<span class="caption-subject theme-font bold uppercase">Calendar</span>
							<!-- <span class="caption-helper hide">weekly stats...</span> -->
						</div>
					</div>
					<div class="portlet-body">
						<div id="shiftcalendar"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo URL_VIEW; ?>global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script>
	$(function()
		{
			$('.shiftboard').on('change', function()
				{
					$('#shiftcalendar').fullCalendar('destroy');
					showCalendar($(this).val());
				}
			);

			function showCalendar(shiftid) {
				var board_id = '<?php echo $board_id; ?>';
				if (shiftid == '0') {
					$('#index').show();
				}
				else
				{
					$('#index').hide();
				}
				$.ajax(
					{
					url: '<?php echo URL."ShiftUsers/shiftUserList/";?>'+shiftid+"/"+board_id+".json",
					type: "post",
					datatype: "jsonp",
					success: function(response) {
							var shiftColor = JSON.parse('<?php echo json_encode($shiftColor);?>');
                            if(response.output != null){
                              var shiftUser = $.map(response.output, function(i, v){
                                    var sid = i.ShiftUser.shift_id;
                                    if(shiftColor[sid]){
                                        var color = shiftColor[sid]['color'];
    									return {
        									title: i.User.fname+' '+i.User.lname,
        									start: i.ShiftUser.shift_date,
        									backgroundColor: color
    									}
                                    }
                                    
								});
                            } else{
                                var shiftUser = {};
                            }

							$("#shiftcalendar").fullCalendar(
								{
								header: {
									left: 'prev,next today',
									center: 'title',
									right: 'month,agendaWeek,agendaDay'
									},
								defaultDate: new Date(),
								eventLimit: true,
								defaultView: 'month',
								events: shiftUser
								}
							);
						}

					}
				);
			}
			showCalendar('0');

		}
	);
</script>