<?php 
$key = $_POST['key'];
$index = $_POST['index'];
// echo "<pre>";
// print_r($key);
?>
<div class="date_div">
    <div class="row">
        <div class="col-md-1">
            <a href="" class="close_date">close</a><br>
                From :
        </div>

        <div class="col-md-2">
            <select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $index;?>][starttime][hour]" size="1" class="hourBox">
                <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
                <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
            <?php } ?>
            </select> 
        </div>

        <div class="col-md-2">
            <select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $index;?>][starttime][min]" size="1" class="hourBox">
                <?php for ($min = 0; $min < 60; $min+=15) { ?>
                <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $index;?>][endtime][meridian]" size="1" class="hourBox">
                <option value="am">am</option>
                <option value="pm">pm</option>
            </select>
        </div>
    </div>
    <div style="margin:5px 0"></div>

    <div class="row">
        <div class="col-md-1">To :</div>

        <div class="col-md-2">
            <select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $index;?>][endtime][hour]" size="1" class="hourBox">
                <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
                <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
                <?php } ?>
            </select>  
        </div>
<div class="col-md-2">
<select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $index;?>][endtime][min]" size="1" class="hourBox">
<?php for ($min = 0; $min < 60; $min+=15) { ?>
<option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
<?php } ?>
</select>
</div>
<div class="col-md-2">
<select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $index;?>][endtime][meridian]" size="1" class="hourBox">
<option value="am">am</option>
<option value="pm">pm</option>
</select>
</div>
</div>

</div>  

<script>
    $(document).ready(
                        function()
                        {
                          
                            $(".close_date").click(function(ev)
                                                {
                                                  ev.preventDefault();
                                                    // alert('hello');
                                                    // die();
                                                    var e = $(this);

                                                    e.closest('.date_div').remove();
                                                    
                                                });
                        });
</script>
    
