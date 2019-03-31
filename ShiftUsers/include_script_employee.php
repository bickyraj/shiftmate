<script>

$(document).ready(function()
	{
		// colorbox pop
		$(".addNewShiftToUser").colorbox({inline:true, width:"50%"});
		
		// shift confirm Reject
		$(".confirmPopup").click(function(){ 
			id = $(this).attr('id');
			$('#shiftUserConfirmationId').val(id);
			//alert(id);
			$("#confirmShift").colorbox({inline:true, open:true ,href:'#confirmShift'});
			//$.fn.colorbox({inline:true, href:"#confirmShift", open:true}); 
			//alert('you here');
			
		});
		
		// accept open shift
		$(".confirmPopupOpen").click(function(){ 
			id = $(this).attr('id');
			$('#shiftUserConfirmationId').val(id);
			//alert(id);
			$("#confirmShiftOpen").colorbox({inline:true, open:true ,href:'#confirmShiftOpen'});
			//$.fn.colorbox({inline:true, href:"#confirmShift", open:true}); 
			//alert('you here');
			
		});
		
		// drag n drop
		
		$("#dragDiv div").draggable(
		{
			start: function (){ 
								var source_id = $(this).attr('id');
								$('#dragged_id').val(source_id);
					},
			revert:true
			
		});
		
						
		$("#drop td div.drag").draggable(
		{
			start: function (){ 
								var source_id = $(this).attr('id');
								$('#dragged_id').val(source_id);
					},
			revert:true
			
		});
		
		$("#drop td").droppable(
		{
			drop: handleDropEvent
		});
		
		$('body').droppable(
		{
				drop : delete_drag
		});
		function delete_drag(event, ui){
			
				var source_id = $('#dragged_id').val(); // shift_id / user_id / date
				sourceArr = source_id.split('_');
				numArr = sourceArr.length;
				if(numArr > 1){
				$.ajax({
				  type: "POST",
				  url: "<?php echo URL_VIEW;?>shiftUsers/ajax_remove_shift.php",
				  data: { source: source_id, board_id: <?php echo $board_id;?> }
				})
				  .done(function( msg ) {
					if(msg == 'Ok'){
						ui.draggable.remove();
					}
					//alert( msg );
				  });
				}
				//ui.draggable.remove();
		}
		
		
		function handleDropEvent(event, ui)
		{
			var check_id = ui.draggable.parent().closest('div').attr('id');
			var datas = ui.draggable.html();
			
			// destination_id = user_id / day_id / date
			var destination_id = $(this).attr('id');
			//alert(destination_id);
			// source_id = shift_id / user_id / date or just shift_id
			var source_id = $('#dragged_id').val();
			
			destination_id_arr = destination_id.split('_');
			
			
			source_id_arr = source_id.split('_');
									
			$(this).append('<div class="drag tableData_pending2" id="'+source_id_arr[0]+'_'+destination_id_arr[0]+'_'+destination_id_arr[2]+'"></div>');
			$('#'+source_id_arr[0]+'_'+destination_id_arr[0]+'_'+destination_id_arr[2]).html(datas);
			
			
			//alert(check_id);
			 if(check_id == "drop"){
				ui.draggable.remove(); 
			}
			
			$.ajax({
			  type: "POST",
			  url: "<?php echo URL_VIEW;?>shiftUsers/ajax.php",
			  data: { source: source_id, destination: destination_id, status: 2, board_id: <?php echo $board_id;?> }
			})
			  .done(function( msg ) {
				 var obj = $.parseJSON(msg);
				 if(obj == 'Exist'){
					$('#'+source_id_arr[0]+'_'+destination_id_arr[0]+'_'+destination_id_arr[2]).remove();
					  
					alert('Shift already exist.');
				 }else if(obj == 'Ok'){
					//alert('Ok');
				 }else{
					 //alert('else');
				  $('#availableShifts').html('');
				$('#availableShifts').append('<h2 style="color: rgb(29, 136, 145); margin:0px">You are available only in:</h2>');
				  for(var i =0; i < obj.length ; i++) {
					  $('#availableShifts').append('<div class="popup-time">Time : '+obj[i].Useravailability.starttime+' - '+obj[i].Useravailability.endtime+'</div>');
					  
					  }
					 $('#'+source_id_arr[0]+'_'+destination_id_arr[0]+'_'+destination_id_arr[2]).remove();
					  $("#availableShifts").colorbox({inline:true, open:true ,href:'#availableShifts'});
				 }
			  });
			
			$("#drop td div.drag").draggable(
			{
				start: function (){ 
									var source_id = $(this).attr('id');
									$('#dragged_id').val(source_id);
						},
				revert:true
				
			});
			
			
		}
	});
</script>
<div style="display:none;">
<div id="availableShifts" style="margin:0 10px; line-height:30px;">

        
      
</div>
</div>
