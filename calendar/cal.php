



<link href='<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href="<?=URL_VIEW;?>calendar/libs/scheduler.min.css" rel='stylesheet'/>


<div class="page-container">
  <div class="page-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="portlet light">
              <div class="portlet-body">
                <div id="external-events">
                  
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-9 col-sm-12">
            <div class="portlet light">
              <div class="portlet-body">
                <div id="calendar123">
              
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
  </div>
</div>
<script src='<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.js'></script>

<script src="<?=URL_VIEW;?>calendar/libs/fullcalendar-scheduler/scheduler.min.js"></script>

<script type="text/javascript">

var n= 5, i;
for(i=0;i<n;i++)
{
    var evnt="<div class='fc-event orgDragShift'> Event "+i+"</div>";
    $('#external-events').append(evnt);
}
addDrageable();
function addDrageable(){
            $('#external-events .fc-event').each(function() {
                    $(this).draggable({
                        zIndex: 999,
                        revert: true, 
                        revertDuration: 0  
                    });
                });
          }
  
$('#calendar123').fullCalendar({
    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    defaultView: 'timelineWeek',
    droppable:true,
    events: [
        // events go here
    ],
    resources: [
        { id: 'a', title: 'Room A' },
        { id: 'b', title: 'Room B' },
        { id: 'c', title: 'Room C' },
        { id: 'd', title: 'Room D' }
    ],
    drop: function(date, jsEvent, ui, resourceId )
                {
                  console.log(resourceId);
                }
});
</script>