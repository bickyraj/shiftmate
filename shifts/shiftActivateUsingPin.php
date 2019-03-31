<div class="row">
	<div>
    	<label >Organization</label>
	
	    <select class="form-control" id="organization" name="data[ShiftUser][board_id]">
	        <option value="">Select organization</option>
	        <option value="1">Oneplatinum</option>
	    </select> 
	</div>
	<div>
    	<label >Employee List</label>
	
	    <select class="form-control" id="boardname" name="data[ShiftUser][board_id]">
	        <option value="default">Select employee</option>
	        <option value="1">Oneplatinum</option>
	    </select> 
	</div>
</div>
<script src="<?php echo URL_VIEW;?>global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#organization").on('change',function(){
		var e = $(this);
		var orgId = e.val();
		// var url = '<?php echo URL."Shift/shiftCheckin/"."'+orgId+'".".json";?>';
		// alert(url);
		$.ajax({
					
            url:'<?php echo URL."ShiftUsers/shiftRelatedEmploy/"."'+orgId+'".".json";?>',
            type:'post',
            datatype:'jsonp',
           success:function(response)
                    {
                    }
        });
	});
});
</script>
<?php // str_rot13() example
$a  = 'test';
$b = 'hello';
$encoded = str_rot13($a.'/'.$b);
$decoded = str_rot13(str_rot13($a.'/'.$b));
echo $encoded ."\n";
echo $decoded;
?>
<br>----------------------------------
<?php // base64_encode()/base64_decode() example
$string  = 'Encoding and Decoding Encrypted PHP Code';
$encoded = base64_encode($string);
$decoded = base64_decode($encoded);
echo $encoded ."\n";
echo $decoded;
?>
<br>-----------------------------
