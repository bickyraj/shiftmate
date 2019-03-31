<style>
	#loading {
		display: none;
		position: absolute;
		top: 10px;
		right: 10px;
	}
    .fc-event{
        display: inline-block;
        cursor: move;
        margin-bottom: 5px;
        margin-left: 5px;
        padding:3px;
    }
</style>
<?php

if(isset($_POST['submit']))
{
    $url = URL."Organizationfunctions/addFunction.json";

    $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
}

if(isset($_POST['editSubmit']))
{
    $url = URL."Organizationfunctions/editFunction.json";
    $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
}

    $url_holiday = URL . "Organizationfunctions/listFunctionForOrganization/".$orgId. ".json";
    $data = \Httpful\Request::get($url_holiday)->send();

    if(isset($data->body->functions) && !empty($data->body->functions))
    {
        $holidays = $data->body->functions;

    }


    $url = URL. "Branches/orgBranches/" . $orgId . ".json";
    $data = \Httpful\Request::get($url)->send();
    $branches = $data->body->branches;


    $url = URL."Leaveholidays/branchEmployeesHolidays/".$orgId.".json";
    $data = \Httpful\Request::get($url)->send();
    $employeesRequests = $data->body->holidays;    

?>

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script>
jQuery(document).ready(function() {
   TableManaged.init();
   ComponentsPickers.init();
});
</script>

<!-- END JAVASCRIPTS -->


<!-- BEGIN PAGE HEADER-->
<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Holiday</h1>
		</div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo URL_VIEW; ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?=URL_VIEW."organizationfunctions/listHoliday";?>">Holiday</a>
            </li>
        </ul>
        <div class="row margin-top-10">
            <div class="col-md-12 col-sm-12">
                <link href="<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet"/>
                <div class="portlet light ">
            		<div class="portlet-title">
            			<div class="caption">
            				<i class="fa fa-gift"></i>Holidays
            			</div>
            		</div>
            		<div class="portlet-body">
            			<div class="row wrap">
            				<div class="col-md-3 col-sm-12">
                    			<h3>Events</h3>
                                <hr>
                                <div id='external-events'>
                                    <h4>Select Type</h4>
                                    <div class="form-group">
                                        <select id="holodaytype" class="form-control">
                                            <option value="0">Organisation holiday</option>
                                            <option value="1">Events</option>
                                        </select>
                                    </div>
                                    <h4>Select Branch</h4>
                                    <select id="branches" class="form-control">
                                        <option value="0">All</option>
                                        <?php foreach($branches as $br){
                                            echo "<option value=".$br->Branch->id.">".$br->Branch->title."</option>";
                                        } ?>
                                    </select>
                                    <br /><br />
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <input type="text" style="height: 35px;" class="form-control newevnt" placeholder="new event"/>
                                            </div>
                                        </div>
                                        <div class="col-md-3"><button class="addNewEvent btn blue">Add</button>
                                        </div>
                                    </div><br />
                        			<p>
                        				<input type='checkbox' id='drop-remove' />
                        				<label for='drop-remove'>remove after drop</label>
                        			</p>
                        		</div><hr>                   
                                <div>    
                                    <h3>Labels</h3>
                                    <hr>
                                    <ul style="padding:0px;"><li style="display:inline-block;height: 20px;width: 20px;background-color:red"></li><li style="display:inline-block;"><strong>&nbsp;&nbsp;Organisation Holiday</strong></li></ul>
                                    <ul style="padding:0px;"><li style="display:inline-block;height: 20px;width: 20px;background-color:green"></li><li style="display:inline-block;"><strong>&nbsp;&nbsp;Events</strong></li></ul>
                                    <ul style="padding:0px;"><li style="display:inline-block;height: 20px;width: 20px;background-color:black"></li><li style="display:inline-block;"><strong>&nbsp;&nbsp;Public Holidays</strong></li></ul>
                                </div>     
                                <hr>  
                                <div id='loading'>loading...</div>   
            			    </div>                                                       
            				<div class="col-md-9 col-sm-12">
            					<div id="calendar12" class="has-toolbar">
            					</div>
            				</div>
                        </div>
            	    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/calendar.js"></script>
<script>
    $(document).ready(function() {  
        $('#branches').select2();
        $('#holodaytype').select2();
        $('.newevnt').keypress(function(k) {
        var e = $(this);
        if(k.which == 13) {
            if($('.newevnt').val().length != 0){
                var evnt="<div class='fc-event'>"+e.val()+"</div>";
                e.closest('#external-events').append(evnt);
                addDrageable();
           }
        }
    });
        $('.addNewEvent').click(function(){
            var e = $(this);
           if($('.newevnt').val() != ""){
                var evnt="<div class='fc-event'>"+$('.newevnt').val()+"</div>";
                e.closest('#external-events').append(evnt);
                addDrageable();
           } 
        });
        function addDrageable(){
            $('#external-events .fc-event').each(function() {
        			var eventObject = {
        				title: $.trim($(this).text())
        			};
        			$(this).data('eventObject', eventObject);
        			$(this).draggable({
        				zIndex: 999,
        				revert: true, 
        				revertDuration: 0  
        			});
        		});
          }
               
        function loadCalender(){
            $('.popover').remove();
        $.ajax({
            url:'<?php echo URL."Organizationfunctions/listFunctionForOrganization/".$orgId.".json";?>',
            datatype:'jsonp',
            success:function(data){
                if(data.functions != null){
                    var data3=$.map(data.functions,function(V,K){
                            if(V.status==0){
                                var color_a='red';
                            }else if(V.status==1){
                                var color_a='green';
                            }
                            return {
                                title:V.note,
                                description:V.note,
                                start:V.function_date,
                                borderColor:'black',
                                backgroundColor:color_a,
                                textColor:'white',
                                fxnId:V.id,
                                stat:V.status,
                                branchId:V.branch_id
                            }
                   });
                }else{
                    var data3 = {};
                }
    var data1=[];
          $.ajax({
            url:'http://data.gov.au/api/action/datastore_search?resource_id=0f94ad45-c1b4-49de-bada-478ccd3805f0',
            datatype:"jsonp",
            async:false,
            success:function(data){
                if(data.result.records != null){
                    var data2=$.map(data.result.records,function(v,k){
                        if(v.ACT == "TRUE"){
                            stY=v.DTSTART.substring(0,4);
                            stM=v.DTSTART.substring(4,6);
                            stD=v.DTSTART.substring(6,8);
                            enY=v.DTEND.substring(0,4);
                            enM=v.DTEND.substring(4,6);
                            enD=v.DTEND.substring(6,8);
                            return{
                            title:v.Summary,
                            start:stY+"-"+stM+"-"+stD,
                            end:enY+"-"+enM+"-"+enD,
                            borderColor:'black',
                            backgroundColor:'black',
                            textColor:'white',
                            description:v.Description
                            }
                        }
                    });
                }else{
                    var data2={};
                }
                data1 = $.merge(data3, data2);
            }
          });
               $('#calendar12').fullCalendar({
        			header: {
        				left: 'prev,next today',
        				center: 'title',
        				right: 'month,agendaWeek'
        			},
        			defaultDate: new Date(),
        			editable: true,
                    droppable: true,
        			eventLimit: true,
        			events: data1,
                    eventRender: function (event, element, view) {  
                        var e = element;
                        e.find('.fc-content').attr('style',"cursor:pointer;");
                        e.find('.fc-content').attr('data-container',"body");
                        e.find('.fc-content').attr('data-trigger',"hover");
                        e.find('.fc-content').attr('data-html',"true");
                        
                        var branch = <?php echo json_encode($branches);?>;
                        var branch1="";
                       // console.log(event.branchId);
                       if(event.branchId){
                            $.each(branch, function(key, value){
                                $.each(event.branchId,function(key1,value1){
                                    if( value['Branch']['id'] == value1){
                                        branch1 += value['Branch']['title'] + "<br/>";
                                    }
                                });
                            });
                            e.find('.fc-content').attr('data-content',"<p><b>Branches list</b></p><p><i>"+ branch1 +"</i></p>");
                       }
                         
                        e.find('.fc-content').attr('data-original-title',event.description);
                        e.find('.fc-content').attr('data-placement',"left");
                        e.find('.fc-content').addClass('popovers');
                        
                        
                        popoverActivete();
                    },
        			drop: function(date) { 
        			         var e = $(this);
        					var originalEventObject = $(this).data('eventObject');
    				        var copiedEventObject = $.extend({}, originalEventObject);
    				        copiedEventObject.start = date;
                    
                        var a = new Date();
                        if(date < a){
                            alert("This is past date");
                        }else{
                            if($('#branches').val() == 0){
                                $.ajax({
                                    url:'<?php echo URL."Organizationfunctions/addFunction.json";?>',
                                    data:"data[Organizationfunction][organization_id]=<?php echo $orgId;?>&data[Organizationfunction][branch_id]="+$('#branches').val()+"&data[Organizationfunction][status]="+$('#holodaytype').val()+"&data[Organizationfunction][function_date]="+date.format('YYYY-MM-DD')+"&data[Organizationfunction][note]="+copiedEventObject.title,
                                    type:'post',
                                    datatype:'jsonp',
                                    success:function(data){
                                        if(data.output.status == 1){
                                            if ($('#drop-remove').is(':checked')) {
                            					e.remove();
                            				}
                                            $('#calendar12').fullCalendar( 'destroy' );
                                            loadCalender();
                                        }else{
                                            alert("sorry something went wrong");
                                        }
                                        
                                    }
                                });
                            }else{
                                $.ajax({
                                    url:'<?php echo URL."Organizationfunctions/addFunctionAjax.json";?>',
                                    data:"data[Organizationfunction][organization_id]=<?php echo $orgId;?>&data[Organizationfunction][branch_id]="+$('#branches').val()+"&data[Organizationfunction][status]="+$('#holodaytype').val()+"&data[Organizationfunction][function_date]="+date.format('YYYY-MM-DD')+"&data[Organizationfunction][note]="+copiedEventObject.title,
                                    type:'post',
                                    datatype:'jsonp',
                                    success:function(data1){
                                        if(data1.fxn != "error"){
                                            if ($('#drop-remove').is(':checked')) {
                            					e.remove();
                            				}
                                            $('#calendar12').fullCalendar( 'destroy' );
                                            loadCalender(); 
                                        }else{
                                            alert("sorry something went wrong");
                                        }
                                        
                                    }
                                });
                            }
                            
                        }
        			},
                    eventDrop: function(event, delta, revertFunc ) {
                        var a = new Date();
                        if(event.start < a){
                            alert('Past date');
                            revertFunc();
                        }else{
                            $.ajax({
                               url: "<?php echo URL."Organizationfunctions/editFunctionDate.json";?>",
                               data:"data[Organizationfunction][organization_id]="+<?=$orgId;?>+
                                    "&data[Organizationfunction][function_date]="+event.start.format("YYYY-MM-DD")+
                                    "&data[Organizationfunction][ids]="+JSON.stringify(event.fxnId),
                               type:"post",
                               datatype:"jsonp",
                               success:function(data){
                                    if(data.success == 0){
                                        revertFunc();
                                    }
                               }
                            });
                        }
                    },
                    loading: function(bool) {
        				$('#loading').toggle(bool);
        			},
                    eventClick: function(calEvent, jsEvent, view) {
                         if(calEvent.stat == 0){
                            var Typeoptn='<option value="0" selected>Public Holiday</option><option value="1">Event</option>';
                        }else if(calEvent.stat == 1){
                            var Typeoptn='<option value="0">Public Holiday</option><option value="1" selected>Event</option>';
                        }
                            bootbox.dialog({
                                title: "Edit Holiday",
                                message: '<div class="form-group">'+
                                        '<label>Branch</label>'+
                                        '<select class="bs-select form-control branchOption1" id="branchOption1" name="data[Organizationfunction][branch_id]">'+
                                        '</select>'+
                                        '<label>Holoday type</label>'+
                                        '<select class="bs-select form-control holodayType" id="holidayType" name="data[Organizationfunction][branch_id]">'+
                                        Typeoptn+
                                        '</select>'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label>Note</label>'+
                                        '<textarea style="min-height:200px;" class="form-control text-left fxnNote" name="data[Organizationfunction][note]" rows="3" required>'+calEvent.title+'</textarea>'+
                                    '</div>',
                                buttons: {
                                    success: {
                                      label: "Edit",
                                      className: "btn-success",
                                      callback: function() {
                                        var e=$(this);
                                        $.ajax({
                                           url: "<?php echo URL."Organizationfunctions/editFunction.json";?>",
                                           data:"data[Organizationfunction][id] ="+ JSON.stringify(calEvent.fxnId) +
                                                "&data[Organizationfunction][organization_id] = <?php echo $orgId;?>"+
                                                "&data[Organizationfunction][branch_id] ="+ e.find('.branchOption1').val()+
                                                "&data[Organizationfunction][note] ="+ e.find('.fxnNote').val()+
                                                "&data[Organizationfunction][status]="+e.find('.holodayType').val()+
                                                "&data[Organizationfunction][function_date]="+calEvent.start.format("YYYY-MM-DD"),
                                           type:'post',
                                           datatype:'jsonp',
                                           success:function(data){
                                                if(data.output.status == 1){
                                                    $('#calendar12').fullCalendar( 'destroy' );
                                                    loadCalender(); 
                                                }else{
                                                    alert("Sorry something went wrong");
                                                }
                                           }
                                        });
                                      }
                                    },
                                    error: {
                                        label : "Delete",
                                        className:"btn red",
                                        callback: function(){
                                            var e=$(this);
                                            $.ajax({
                                               url: "<?php echo URL."Organizationfunctions/deleteFunction.json";?>",
                                               data:"data[Organizationfunction][ids] ="+ JSON.stringify(calEvent.fxnId),
                                               type:'post',
                                               datatype:'jsonp',
                                               success:function(data){
                                                    if(data.called == 1){
                                                        $('#calendar12').fullCalendar( 'destroy' );
                                                        loadCalender();
                                                    }
                                               }
                                            });                                        
                                        }
                                    },
                                    warning:{
                                        label : "Close",
                                        className : "data-dismiss",
                                        callback : function(){
                                        }
                                    }
                                  }
                            });
                            $(".fxndate").datepicker();
                            var branch = <?php echo json_encode($branches);?>;
                                
                                    var len = $.map(calEvent.branchId, function(n, i) { return i; }).length;
                                    if(len > 1){
                                        $("#branchOption1").append('<option value="0" selected="selected">All</option>');
                                        $.each(branch, function(key, value){
                                            $("#branchOption1").append('<option value="'+value['Branch']['id']+'">'+value['Branch']['title']+'</option>');
                                        });
                                    }else{
                                        $("#branchOption1").append('<option value="0">All</option>');
                                        $.each(branch, function(key, value){
                                            $.each(calEvent.branchId,function(k,v){
                                                if( value['Branch']['id'] == v){
                                                    $("#branchOption1").append('<option value="'
                                                    +value['Branch']['id']+'" selected="selected">'+value['Branch']['title']+'</option>');
                                                }else{
                                                    $("#branchOption1").append('<option value="'+value['Branch']['id']+'">'+value['Branch']['title']+'</option>');
                                                }
                                            });
                                        });
                                    }
                        },
                        eventMouseover:function( event, jsEvent, view ) { 
                           popoverActivete();
                        },
                        eventMouseout:function( event, jsEvent, view ) { 
                           // toastr.clear();
                        }
                });
            }
       });   
       }
       loadCalender();
            function popoverActivete(){
    			$('.popovers').popover();
    		}
       });
</script>
<script type="text/javascript">
    $(function()
        {

            $('.approve_btn').on('click',function(e){
                var leave_id = $(this).attr("data-id");

            //console.log(leave_id);

                var leaveList = $(this).closest('.leave_list');
                $.ajax({

                      url: "<?php echo URL_VIEW.'process.php';?>",
                      data: "action=approveHoliday&leaveId="+leave_id,
                      type: 'POST',
                    success:function(response)
                    {
                        if (response == 1) {

                            leaveList.fadeOut('slow').remove();

                            
                        }
                        else{
                            alert('Could not save.');

                        }
                    }
                });
           }); 




            
            
            $("#add_new_holiday").click(function()
            {
                var branch = <?php echo json_encode($branches);?>;

                bootbox.dialog({
                    title: "Add Holiday",
                    message:
                        '<form class="form-body" action="" method="post"> ' +
                        '<input type="hidden" name="data[Organizationfunction][organization_id]" value="<?php echo $orgId;?>">'+
                        '<input type="hidden" name="data[Organizationfunction][status]" value="0">'+

                    '<div class="form-group">'+
                        '<label>Branch</label>'+

                        '<select class="bs-select form-control" id="branchOption" name="data[Organizationfunction][branch_id]">'+

                            '<option value="0">All</option>'+
                        '</select>'+
                    '</div>'+

                        '<div class="form-group">'+
                        '<label>Date</label>'+
                        '<input class="form-control input-medium date-picker date-picker-modal" data-date-format="yyyy-mm-dd" size="16" type="text" value="" name="data[Organizationfunction][function_date]">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>Note</label>'+
                                '<textarea style="min-height:200px;" class="form-control" name="data[Organizationfunction][note]" rows="3" required></textarea>'+
                            '</div>'+

                            '<input type="submit" name="submit" value="Save" class="btn btn-success" />'+
                        '</form>'
                                }
                                );

                    $(".date-picker-modal").datepicker();
                    $.each(branch, function(key, value){
                        $("#branchOption").append('<option value="0">'+value['Branch']['title']+'</option>');
                    });
                    
            });

            $(".edit_holiday").click(function(e)
            {

                var function_id = $(this).siblings(".function_id").text();
                var function_date = $(this).closest(".orgFun_row").find('#function_date').text();
                var function_note = $(this).closest(".orgFun_row").find('#function_note').text();
                var function_branch_id = $(this).closest(".orgFun_row").find('#function_branch_id').text();
                
                var branch = <?php echo json_encode($branches);?>;

                bootbox.dialog({
                    title: "Edit Holiday",
                    message:
                        '<form class="form-body" action="" method="post"> ' +

                        '<input type="hidden" name="data[Organizationfunction][id]" value="'+function_id+'">'+
                        '<input type="hidden" name="data[Organizationfunction][organization_id]" value="<?php echo $orgId;?>">'+
                        '<input type="hidden" name="data[Organizationfunction][status]" value="0">'+

                    '<div class="form-group">'+
                        '<label>Branch</label>'+

                        '<select class="bs-select form-control" id="branchOption" name="data[Organizationfunction][branch_id]">'+

                            '<option value="0">All</option>'+
                        '</select>'+
                    '</div>'+

                        '<div class="form-group">'+
                        '<label>Date</label>'+
                        '<input class="form-control input-medium date-picker date-picker-modal text-left" data-date-format="yyyy-mm-dd" size="16" type="text" value="'+function_date+'" name="data[Organizationfunction][function_date]">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label>Note</label>'+
                                '<textarea style="min-height:200px;" class="form-control text-left" name="data[Organizationfunction][note]" rows="3" required>'+function_note+'</textarea>'+
                            '</div>'+

                            '<input type="submit" name="editSubmit" value="Save" class="btn btn-success" />'+
                        '</form>'
                                }
                            );

                    $(".date-picker-modal").datepicker();
                    $.each(branch, function(key, value){
                        if( value['Branch']['id'] == function_branch_id)
                        {
                            $("#branchOption").append('<option value="'
                            +value['Branch']['id']+'" selected="selected">'+value['Branch']['title']+'</option>');
                        }else{
                            $("#branchOption").append('<option value="'
                                +value['Branch']['id']+
                                '">'+value['Branch']['title']+'</option>');
                        }

                    });

            });
        });
</script>