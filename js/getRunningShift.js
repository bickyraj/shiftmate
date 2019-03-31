
function getRunningShift(urlApi,userId)
{
	var url= urlApi+'ShiftUsers/getRunningShifts/'+userId+'.json';
	$.ajax(
		{
			url:url,
			data:'post',
			dataType:'jsonp',
			async:false,
			success:function(res)
			{
				var runData = "";
				if(res.runningShiftStatus ===1)
				{
					var runningShift = res.runningShift.runningShift;

					if(runningShift.ShiftUser.check_status == 1)
					{
						var hasColor = 'has-error';
						var checkClass = 'shiftCheckOut';
						var checkStatus = 1;

						var checkInCaption = '<i class="icon-calendar font-red-sharp"></i>'+
                                        '<span class="caption-subject font-red-sharp uppercase">Check Out</span>';

                        var expenseDiv = '<hr>'+
						    '<div class="expensesListDiv">'+
							    '<a href="#addshiftexpanse" class="news-block-btn btn btn-xs blue" data-toggle="modal" style="float:right;"><i class="fa fa-plus" ></i> Add Expenses </a>'+
							    	'<div id="showExpenseDivList" style="display:none;">'+
							    	'<p><strong>Expenses list</strong></p>'+
							    	'<table class="expensesListUl">'+
							    	'</table>'+
							    	'<hr>'+
							    	'<span class="totalExpensesCost"><strong>Total Expenses</strong>&nbsp :$<i></i></span><br/>'+'</div>'+
							    	'<a href="#portlet-33"  data-toggle="modal" id="shiftExpDetailBtn" data-shiftUserId="'+runningShift.ShiftUser.id+'">View Details</a>'+
							    	'<div style="padding-top:15px;border-bottom:1px solid #eee;margin-bottom:10px;"></div>'+
					    	'</div>';
					}else{
						var checkStatus = 0;
						var hasColor = 'has-success';
						var checkClass = 'shiftCheckIn';

						var checkInCaption = '<i class="icon-calendar font-green-sharp"></i>'+
                                        '<span class="caption-subject font-green-sharp uppercase">Check In</span>';
                                        var expenseDiv='';
						ion.sound.play("quick_notification");
						toastr.success('Your shift has started.');

					}

					$("#checkInCaptionDiv").html("").html(checkInCaption);
					runData = '<div class="md-checkbox-list">'+
                                                '<div class="md-checkbox '+hasColor+'">'+
                                                    '<input type="checkbox" id="checkbox9" data-shiftEndTime="'+runningShift.Shift.endtime+'" data-checkStatus="'+checkStatus+'" data-shiftUserId="'+runningShift.ShiftUser.id+'" class="md-check '+checkClass+'">'+
                                                    '<label for="checkbox9">'+
                                                    '<span></span>'+
                                                    '<span class="check"></span>'+
                                                    '<span class="box" id="'+runningShift.ShiftUser.id+'"></span>'+
                                                    runningShift.Shift.title+', '+runningShift.Board.title+'</label><br/>'+
                                                    '<span class="caption-helper blue" style="color: rgb(111, 115, 114);font-size: 11px;padding-left: 30px;">'+runningShift.Shift.stime+' to '+runningShift.Shift.etime+'</span><br/>'+
                                                    '<span class="caption-helper blue" style="color: rgb(13, 155, 20);font-size: 11px;padding-left: 30px;"></span>'+
                                                    '</div>'+
                                                    '<button class="btn blue btn-xs" style="display:none;" data-shfitUserId="'+runningShift.ShiftUser.id+'" type="button" data-shiftDate="'+runningShift.ShiftUser.shift_date+'" id="shiftCheckList" data-shiftId="'+runningShift.Shift.id+'"><i class="fa fa-list"></i> Checklists</button>'+
                                                    '<button class="btn btn-xs purple" style="display:none;" type="button" id="runningShiftNote" data-shiftid="'+runningShift.Shift.id+'"><i class="fa fa-pencil-square-o"></i> Notes</button>'+
                                                '<div class="clear"></div>'+
                                                '</div>';

                                               $("#showRunningShift").html("").html(runData).append(expenseDiv);
                                               if(runningShift.ShiftUser.check_status == 1)
                                               {
                                               		$("#shiftCheckList").show();
                                               		$("#runningShiftNote").show();
                                               }
				}else
				{

				}

				if(res.nextShiftStatus ===1)
				{
					var nextShift = res.runningShift.nextShift;

					var nextData = "";
					nextData = '<div class="md-checkbox has-success" id="upcommingShiftDiv">'+
                        '<span class="box" id="'+nextShift.ShiftUser.id+'"></span>'+nextShift.Shift.title+', '+nextShift.Board.title+'<br/>'+
                        '<span class="caption-helper blue" style="color: rgb(111, 115, 114);font-size: 11px;">'+nextShift.ShiftUser.sdate+'</span>'+
                        '<div class="clear"></div>'+
                        '<span class="caption-helper blue" style="color: rgb(111, 115, 114);font-size: 11px;">'+nextShift.Shift.stime+' to '+nextShift.Shift.etime+'</span>'+
                    '</div>';

                    $("#showNextShift").html("").html(nextData);
				}else
				{
					$("#showNextShift").html('<div>No upcomming shift.</div>');
				}
			}
		});


}



