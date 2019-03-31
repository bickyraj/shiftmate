<script>

$(document).ready(function()
	{
		// colorbox pop
		$(".addNewShiftToUser").colorbox({inline:true, width:"50%"});
		
		// shift confirm Reject
		$(".confirmPopup").click(function(){ 
		//alert('u here');
			id = $(this).attr('id');
			//alert(id);
			$('#shiftUserConfirmationId').val(id);
			//alert(id);
			$("#confirmShift").colorbox({inline:true, open:true ,href:'#confirmShift'});
			//$("#confirmShift").colorbox({inline:true, open:true ,href:'#confirmShift'});
			//$.fn.colorbox({inline:true, href:"#confirmShift", open:true}); 
			//alert('you here');
			
		});
		
		// for directly adding shift to employee in shift
		/*$(".directAdd").click(function(){
			id = $(this).attr('id');
			//alert(id);
			$('#userCellDetail').val(id);
			$("#directAddForm").colorbox({inline:true, open:true ,href:'#directAddForm'});
		});*/
		
		
		// drag n drop
		
		$("#dragDiv div.drag").draggable(
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
		
		$("#drop td.available").droppable(
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
			
			// source_id = shift_id / user_id / date or just shift_id
			var source_id = $('#dragged_id').val();
			
			
			destination_id_arr = destination_id.split('_');
			
			
			source_id_arr = source_id.split('_');
			
			if(destination_id_arr[0] == source_id_arr[1] && source_id_arr[2]==destination_id_arr[2]){
				
			}else{
				//var	pathTo = $(this);	
				if(source_id_arr.length > 1){
							
			$(this).append('<div class="waiting_div drag" id="'+source_id_arr[0]+'_'+destination_id_arr[0]+'_'+destination_id_arr[2]+'"></div>');
			$('#'+source_id_arr[0]+'_'+destination_id_arr[0]+'_'+destination_id_arr[2]).html(datas);
			
				}else{
					$(this).append('<div class="waiting_div drag" id="'+source_id_arr[0]+'_'+destination_id_arr[0]+'_'+destination_id_arr[2]+'"></div>');
			$('#'+source_id_arr[0]+'_'+destination_id_arr[0]+'_'+destination_id_arr[2]).html('<span>waiting</span><p>'+datas+'</p>');
					
				}
			
			
			
			 if(check_id == "drop"){
				ui.draggable.remove(); 
			}
			
			$.ajax({
			  type: "POST",
			  url: "<?php echo URL_VIEW;?>shiftUsers/ajax.php",
			  data: { source: source_id, destination: destination_id, status: 1, board_id: <?php echo $board_id;?> }
			})
			  .done(function( msg ) {
				//alert(msg); 
				//die();
				  var obj = $.parseJSON(msg);
				 if(obj == 'Exist'){
					$('#'+source_id_arr[0]+'_'+destination_id_arr[0]+'_'+destination_id_arr[2]).remove();
					  
					alert('Shift already exist.');
				 }else if(obj == 'Ok'){
					
				 }else{
				  $('#availableShifts').html('');
				$('#availableShifts').append('<h2 style="color: rgb(29, 136, 145); margin:0px">Available Time:</h2>');
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
			
		}
	});
</script>
<div style="display:none;">
<div id="availableShifts" style="margin:0 10px; line-height:30px;">

        
      
</div>
</div>
