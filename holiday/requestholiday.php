<div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Request Holiday</div>
    </div>
    <div class="clear"></div>

    <div class="form createShift">
        <form action="" id="ShiftAddForm" method="post" accept-charset="utf-8" class="createShift form">
        
           <table class="create_form_table" cellpadding="5px">
            
   <?php /*?><!--         <tr>
               <td><div><input id="single_holiday" type="radio" name="holiday" required />Single holiday<input type="date" name="singleholiday" class="single_holiday"></div></td>
               </tr>
               <tr>
               <td><input type="radio" name="holiday" required />Multiple Holiday</td>
           </tr>--><?php */?>
			<tr>
    	
    </tr>
           <tr>
           		<th>
           		<input type="radio" name="holiday" value="single_holiday">Single Holiday<br>
                
                </th>
                <th>
                <input type="radio" name="holiday" value="multiple_holiday">Multiple Holiday<br>
                </th>
                
                <td class="single_holiday_list">
                
	                <div class="input-append date" id="dp3" data-date="12-02-2015" data-date-format="yyyy-mm-dd">
	                	<div class="leave-data" id="single_leave">
		                	<button class="add_field_button" >Add</button><br>
		                    <input type="text" id="single_holiday" name="single_holiday" class="span2" size="16" type="text" value=""/>
		                    <div class="add-on" style="cursor:pointer; margin-top:20px;">
		                    </div>
	                    </div>
	                </div>
                </td>
                
                <td>
                <div class="input-append date" id="dp3" data-date="12-02-2015" data-date-format="yyyy-mm-dd">
	                 <div class="leave-data" id="leave-from">
	                	<label>From ::</label><br> 
	                	<input type="text" id="from" name="from" class="span2 test" size="16" type="text" value="">
	                	<div class="add-on" style="cursor:pointer; margin-top:20px;">
		                    </div>
	                </div>
                </div>
                <br>
                <div class="input-append date" id="dp3" data-date="12-02-2015" data-date-format="yyyy-mm-dd">
                <div class="leave-data" id="leave-to">
                    <label>To ::</label><br>
                    <input type="text" id="to" name="to" class="span2 test" size="16" type="text" value="">
                    <div class="add-on" style="cursor:pointer; margin-top:20px;"></div>
                </div>
                </td>
                
               
           </tr>
        
    
<tr>
   <td>
    <!--<a class="cancel_a" href="<?php //echo URL_VIEW."shifts/listShifts?org_id=".$orgId;?>">Cancel</a>-->
    <input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
</tr>	
</table>
</form>
</div>

<div class="clear"></div>
<script>
	 $(document).ready(function()
		{
			
			var x=1;
			var add_button = $('.add_field_button');
			$(".leave-data").hide();
			$('input[name="holiday"]').click(function(e)
			{
				//console.log(this.value);
				switch (this.value){
					case 'single_holiday':
					$('#single_leave').show();
					$(document.body).find('.single_holiday_list').show();
					$('#leave-from,#leave-to').hide();
					break;
					case 'multiple_holiday':
					$(document.body).find('.single_holiday_list').hide();
					$('#leave-from,#leave-to').show();
					break;
					default:
					break;
					}
			});
			add_button.click(function(e){
				e.preventDefault();
				x++;
				$('.single_holiday_list')	
				.append
						('<div class="input-append date" id="dp3" data-date="12-02-2015" data-date-format="yyyy-mm-dd"><div class="leave-data" id="single_leave"><input type="text" id="single_holiday" name="single_holiday" class="span2" size="16" class="'+'datepicker'+x+'"/><div class="'+'add-on picker'+x+'" style="cursor:pointer;"></div><div class="remove_field">Remove</div></div></div></div>');
			
				$('.picker'+x).datepicker({
						startDate: '-6d'
					});
				//console.log(wrapper);
				})
				
				
				$(document.body).on("click", '.remove_field', remove_single_date); 
				
				
				function remove_single_date(event)
				{
					
					console.log('remove');
					
					var remove_field = $('remove_field');
					
					remove_field.unbind('click',remove_single_date);
					
					remove_field.bind('click',remove_single_date);
					$(this).closest('.leave-data').remove();
				}
				
				$('.test').blur(function(e){
					//alert ('hello');
									//console.log('hello');
				//console.log($('#from').val());
				if($('#to').val() != "" && $('#from').val() != "")
				{
					var start_date = $('#from').val();
					var end_date = $('#to').val();
					//alert(start_date);
					console.log(start_date,end_date);
					if(start_date > end_date){
						alert("error");
					}
					else
					{
						alert ("correct");
					}
				}
				});
				$.fn.datepicker.defaults.format = "mm/dd/yyyy";
					$('.datepicker').datepicker({
						startDate: '-6d'
					});
		
		
		});
</script>