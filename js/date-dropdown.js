// JavaScript Document

$(document).ready(
function()
{
	$(".timeSelect").change(function(){
			 
		 var sel = $(this).val();
		 
		 if( sel == "AvailableFrom")
		 {
			 
			 $(this).parent().siblings().fadeIn('fast');
		 }
		 else
		 {
			$(this).parent().siblings().hide();
		 }
		 
		$(this).parent().siblings().find('input').click(function()
		{
			if($(this).siblings().css('height') > $(this).siblings().css('max-height'))
			{
				$(this).siblings().css({"overflow-y":"scroll"});
			}
		
			var add_div = $(".available-div div:first-child").html();
			$(this).siblings().append("<div class="+"date_div"+">"+add_div+"</div>");
			
		});
	});
	
	/*$("#add-date-div").click(function()
	{
		if($(this).siblings().css('height') > $(this).siblings().css('max-height'))
		{
			$(this).siblings().css({"overflow-y":"scroll"});
		}
		
		var add_div = $(".available-div div:first-child").html();
		$(this).siblings().append("<div class="+"date_div"+">"+add_div+"</div>");
	});*/
});

	

	 

