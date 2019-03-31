
<script type="text/javascript">
	$(function()
		{
			$.ajax(
				{
					url:'http://52.40.237.147/Users/getu.json',
					// url:'<?php echo URL; ?>Users/getu.json',
					type:"POST",
					// dataType:"jsonp",
					data:{access_token:'<?php echo $_SESSION["token"]->access_token; ?>', api_key:"008b98c7209c83359461bdbcc5784f9d"},
					async:false,
					success:function(res)
					{
						console.log(res);
					}
				});
		});
</script>