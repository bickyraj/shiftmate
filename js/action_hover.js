// JavaScript Document


$(document).ready(function(){
  $(".btn").click(function(){

  	if($(".leftMenu").css('left')=="0px")
  	{
  		$(".leftMenu").animate({left:"-19%"});
  		$(".rightContent").animate({width:"99%"});
  	}

  	else
  	{
  		$(".leftMenu").animate({left:"0px"});
  		$(".rightContent").animate({width:"79.5%"});
  	}
});

//action_hover js
  $(".edit_img").hover(function()
					{
						var text = "Edit";
						hshow(text, $(this));
							
					},
					function()
					{
						hhide($(this));
	});
	
	$(".view_img").hover(function()
				{
					var text = "View";
					hshow(text, $(this));
				},
				function()
				{
					hhide($(this));
	});
	
	$(".delete_img").hover(function()
				{
					var text = "Delete";
					hshow(text, $(this));
				},
				function()
				{
					hhide($(this));
	});

	var timeout;
	function hshow(text, s)
	{
		s.parent().siblings(".hover_action").html(text);
		timeout = setTimeout(function()
			{
				s.parent().siblings(".hover_action").fadeIn(200);
			},150);
		
		
		// alert(s.parent().parent().parent().find(".hover_action").attr('class'));
			
			
			

	}
	
	function hhide(s)
	{
		clearTimeout(timeout);
			s.parent().siblings(".hover_action").hide();
			s.parent().siblings(".hover_action").stop();
	}
});