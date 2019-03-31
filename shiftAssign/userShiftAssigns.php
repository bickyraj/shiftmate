<?php 
$boardId = $_GET['board_id'];
$url = URL."Boards/listBoards/".$orgId.".json";
$response = \Httpful\Request::get($url)->send();
$boards = $response->body->boards;

// print_r($boards);
// die();


// $url = URL."Useravailabilities/listAllAvailableUser/".$orgId.".json";

// $response = \Httpful\Request::get($url)->send();
// $available = $response->body;

// echo '<pre>';
// print_r($available);
// die();

// echo "<pre>";
// print_r($shifts);

if(isset($_POST['submit']))
{

    $url = URL."ShiftUsers/assignShiftToUser.json";
    $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

                if($response->body->output->status == 0)
                {
                    echo '<script>
                            toastr.error("Could not be save.");
                    </script>';
                }

                else
                {
                    echo '<script>
                            toastr.success("Shift assigned successfully!!");
                    </script>';
                }
}
?>
<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Assign Shift </h1>
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
                    <a href="#">Assign Shift</a>
                </li>
            </ul>
            
<link href="<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet"/>
		<div class="row">
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box green-meadow">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>Calendar
							</div>
						</div>
						<div class="portlet-body">
							<div class="row">
			<div class="col-md-3 col-sm-12">
			<!--Form Begins-->
			<form method="post" action="" role="form" enctype="multipart/form-data">
            <div class="form-body">

            <div class="form-group">
            <label >Date</label>
                        <div class="input-group input-medium date date-picker shift-date" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                            <input type="text" class="form-control" id="day_id" name="data[ShiftUser][shift_date]" required>
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                        <!-- /input-group -->
                        <span class="help-block">
                        Select date </span>
                    </div>
                <div class="form-group">
                    <input type="hidden" name="data[ShiftUser][organization_id]" value="<?php echo $orgId;?>">
                       <div class="form-group">
                        <label >Board Name</label>
                        <select class="form-control" id="boardname" name="data[ShiftUser][board_id]">
                            <option value="" selected="" disabled="">Select Board</option>
                            <?php foreach ($boards as $board):?>
                            <option value="<?php echo $board->Board->id;?>"><?php echo $board->Board->title;?></option>
                            <?php endforeach;?>

                        </select>                            
                        </div>
                    </div>

                  <div class="form-group">
                            <label >Assgin Shift</label>
                            <select id="shifts" class="form-control" name="data[ShiftUser][shift_id]">
                                <option value="">Select Shift</option>

                            </select>
                                                    
                        </div>
       
            </div>  
        </form>
        <!--form ends-->
							<!-- BEGIN DRAGGABLE EVENTS PORTLET-->
							<div id='wrap'>
								<div id='external-events'>
									<h4>Users</h4>
									<p>
										<input type='checkbox' id='drop-remove' />
										<label for='drop-remove'>remove after drop</label>
									</p>
								</div>
								<div style='clear:both'></div>
							</div>
							<!-- END DRAGGABLE EVENTS PORTLET-->
						</div>
						<div class="col-md-9 col-sm-12">
							<div id="calendar123" class="has-toolbar">
							</div>
						</div>
					</div>
					<!-- END CALENDAR PORTLET-->
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT-->
</div>





<script>
$(document).ready(function() {
	addDragEvent();
});
		/* initialize the external events
		-----------------------------------------------------------------*/
	function addDragEvent(){
		$('#external-events .fc-event').each(function() {
		
			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};
			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});
			
		});
	}
</script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/fullcalendar.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/calendar.js"></script>
<script>
jQuery(document).ready(function() {       
   // Calendar.init();
});
</script>
<script type="text/javascript">
        $(document).ready(function(){
            $("#boardname").change(function(){
                var boardId = $("#boardname").val();

                getBoardUser(boardId);
                getShifts(boardId);

            });

            function getBoardUser(boardId)
            {
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getboarduser&boardId="+boardId,
                    type: "post",
                    success:function(response){
                        var data;
                        var users = JSON.parse(response);
                        
                        $.each(users, function(k,obj){
                           data+= "<option value=" + obj.User.id + ">" + obj.User.fname+" "+obj.User.lname+ "</option>";
                       });

                      $("#boardusers").html(data);
                    }
                });

            }

            function getShifts(boardId)
            {
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getShifts&boardId="+boardId,
                    type: "post",
                    success:function(response){
                        
                        $("#shifts").html("");
                        var data;
                        var shifts = JSON.parse(response);

                        if(jQuery.isEmptyObject(shifts))
                        {
                            
                            data = "<option value=''>No Shift on this board</option>";
                            $("#shifts").html(data);
                        }
                        else
                        {
                        	data+="<option value='' disabled selected>Select Shift</option>"
                            $.each(shifts, function(k,obj){
                                data+= "<option value=" + obj.Shift.id + ">" +obj.Shift.title+ "</option>";
                                });
                            $("#shifts").html(data);
                        }

                        
                    }
                });
            }   


            function getAvailableUser(shiftId,boardId,shift_date)
            {
               // alert(orgId+" -- "+boardId+" -- "+dayId+" -- "+shiftId+" -- "+day);
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getAvailableUser&shiftId="+shiftId+"&boardId="+boardId+"&shift_date="+shift_date,
                    type: "post",
                    success:function(data){
                        var data1="";
                        data=JSON.parse(data);
                     if(data=='User not Found'){

                       data1+="<div class='fc-event1'>No User Found</div>";
                        $('#boardusers').html(data1);
                     } else {

                      $.each(data,function(k,v){
                          data1+="<div class='fc-event' user_id='"+v.id+"'>"+v.name+"</div>";
                    });
                  }
                  		$('#external-events').find('.fc-event').remove();
                  		$('#external-events').find('.fc-event1').remove();
                       $('#external-events').append(data1);
                       addDragEvent();
                    }
                });

            }

          

            $('#shifts').change(function(){ 
                
                var shift_date=$('#day_id').val();

                var boardId =  $("#boardname").val();

                var shiftId = $("#shifts").val();
                
                getAvailableUser(shiftId,boardId,shift_date);
            });

                $('#boardname').change(function(){ 
                
                var shift_date=$('#day_id').val();

                var boardId =  $("#boardname").val();

                var shiftId = $("#shifts").val();
                
                getAvailableUser(shiftId,boardId,shift_date);
            });

	     $('.shift-date').on('changeDate', function(event)
	        
	        {
	      var shift_date=$('#day_id').val();
		  var shiftId = $("#shifts").val();;
	      var boardId = $("#boardname").val();
	   
	    getAvailableUser(shiftId,boardId,shift_date);
	      });
      });
</script>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   ComponentsPickers.init();
   $('#calendar123').fullCalendar({
   	header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: true,
			droppable: true, // this allows things to be dropped onto the calendar !!!
			drop: function(date) { // this function is called when something is dropped
			
				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');
				
				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);
				
				// assign it the date that was reported
				copiedEventObject.start = date;
				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
				$('#calendar123').fullCalendar('renderEvent', copiedEventObject, true);
				
				// is the "remove after drop" checkbox checked?
				if ($('#drop-remove').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}
				
			}
   });
});   
</script>