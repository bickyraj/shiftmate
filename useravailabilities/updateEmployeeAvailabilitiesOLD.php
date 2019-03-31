<?php
//$userId = $_GET['user_id'];

if (isset($_POST["submit"])) {
    // echo "<pre>";
    // print_r($_POST['data']);
    // die();
    $url = URL . "Useravailabilities/updateEmployeeAvailabilities/" . $userId . ".json";
    $response = \Httpful\Request::post($url)
    ->sendsJson()
    ->body($_POST['data'])
    ->send();
    //echo "<pre>";
    //print_r($response);
    // echo("<script>location.href = '".URL_VIEW."useravailabilities/myAvailability?user_id=".$userId."';</script>");
}

$url = URL . "Useravailabilities/useravailabilityList/" . $userId . ".json";
$data = \Httpful\Request::get($url)->send();

$availabilities = $data->body->availabilities;

// echo "<pre>";
// print_r($availabilities);
// die();



?>



<style>
.available-time {
    width: 100%;
    text-align: left !important;
}
table.margin-btn.table.table-hover {
    margin: 0px;
}
</style>
<!-- Edit -->
<h3 class="page-title">
    Update Availability <small> Update Availability</small>
</h3>

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Availability</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Update Availability</a>
        </li>
    </ul>
<div class="page-toolbar">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                        Actions <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li>
                                <a href="#">Action</a>
                            </li>
                            <li>
                                <a href="#">Another action</a>
                            </li>
                            <li>
                                <a href="#">Something else here</a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="#">Separated link</a>
                            </li>
                        </ul>
                    </div>
                </div>
</div>

<div class="row"> 
  <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Update Availability
                </div>
            </div>
            <div class="portlet-body form">
               <?php if(!empty($availabilities)):?>
                    <form action="" id="UseravailabilityAddForm" method="post" accept-charset="utf-8">
                <table width="100%"  class="margin-btn table table-hover">
                      <tr>
                          <th>Day</th>
                          <th>Type</th>
                      </tr>
                      <?php foreach ($availabilities as $key => $availability): ?>
                        <tr>
                            <td><div class="span_day"><?php echo $availability->day->title;?></div>

                            </td>
                            <th>
                            <div class="select_div">
                                <input type="hidden" name="data[Useravailability][<?php echo $key; ?>][id]" value="<?php echo $availability->data->id;?>">
                                <select name="data[Useravailability][<?php echo $key; ?>][availabilities]" size="1" class="timeSelect form-control" id="<?php echo $key; ?>">
                                    <option value="0" <?php echo ($availability->data->status == '0') ? "selected = 'selected'" : ''; ?>>Available</option>
                                    <option value="1" <?php echo ($availability->data->status == 1) ? "selected = 'selected'" : ''; ?>>Avaliable time</option>
                                    <option value="2" <?php echo ($availability->data->status == 2) ? "selected = 'selected'" : ''; ?>>Not Avaliable</option>
                                </select>



                            </div>

                            <div>
                                <div class="available-div update-available-div">
                                    <?php if ($availability->data->status == 1) { ?>
                                    <?php $i = 0; foreach ($availability->time as $time):?>



<div class="date_div">
    <div class="closeBtn">Close</div>
    <div class="row">
        <div class="col-md-1">
            <input type="hidden" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][id]" value="<?php echo $time->id;?>">
            From :
        </div>
        <div class="col-md-2">
            <select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][starttime][hour]" size="1" class="hourBox">
                <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
                <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>" <?php echo ($time->starttime->hour == str_pad($hours, 2, '0', STR_PAD_LEFT)) ? "selected = 'selected'" : ''; ?>><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][starttime][min]" size="1" class="hourBox">
                <?php for ($min = 0; $min < 60; $min+=15) { ?>
                <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>" <?php echo ($time->starttime->min == str_pad($min, 2, '0', STR_PAD_LEFT)) ? "selected = 'selected'" : ''; ?>><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][starttime][meridian]" size="1" class="hourBox">
                <option value="am" <?php echo ($time->starttime->meridian == 'am') ? "selected = 'selected'" : ''; ?>>am</option>
                <option value="pm" <?php echo ($time->starttime->meridian == 'pm') ? "selected = 'selected'" : ''; ?>>pm</option>
            </select>
        </div>
    </div>
    <div style="margin:5px 0"></div>
    <div class="row">
        <div class="col-md-1">To :</div>

        <div class="col-md-2">
            <select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][endtime][hour]" size="1" class="hourBox">
                <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
                <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>" <?php echo ($time->endtime->hour == str_pad($hours, 2, '0', STR_PAD_LEFT)) ? "selected = 'selected'" : ''; ?>><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][endtime][min]" size="1" class="hourBox">
                <?php for ($min = 0; $min < 60; $min+=15) { ?>
                <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>" <?php echo ($time->endtime->min == str_pad($min, 2, '0', STR_PAD_LEFT)) ? "selected = 'selected'" : ''; ?>><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-2">
            <select class="form-control" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][endtime][meridian]" size="1" class="hourBox">
                <option value="am" <?php echo ($time->endtime->meridian == 'am') ? "selected = 'selected'" : ''; ?>>am</option>
                <option value="pm" <?php echo ($time->endtime->meridian == 'pm') ? "selected = 'selected'" : ''; ?>>pm</option>
            </select>
        </div>
    </div>
</div>

<?php $i++;
endforeach; ?>
<?php } ?>


</div>

<?php if($availability->data->status == 1):?>
<script type="text/javascript">

$("#add-date-div").show();


</script>

<?php endif;?>
<input id="add-date-div" class="add-date-div1" type="button" value="add" />

                            </div>
                        </th>

                    </tr> 
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2">
                        <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" name="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
                            <button type="button" class="btn default">Cancel</button>
                        </div>
                    </div>
                    </td>

                    </tr>

                </table>
            </form>
             <?php else:?>
                <?php echo "sorry";?>
            <?php endif;?>
            </div>


<!-- <div class="timeShift">
    <?php if(!empty($availabilities)):?>
    <form action="" id="UseravailabilityAddForm" method="post" accept-charset="utf-8">
        <table class="useravailabletable" width="100%" cellpadding="10px">
            <tr>
                <th>Day</th>
                <th>Type</th>
            </tr>


            <?php foreach ($availabilities as $key => $availability): ?>
            <tr>
                <td><div class="span_day"><?php echo $availability->day->title; ?></div>

                </td>
                <th><div class="select_div">
                    <input type="hidden" name="data[Useravailability][<?php echo $key; ?>][id]" value="<?php echo $availability->data->id;?>">
                    <select name="data[Useravailability][<?php echo $key; ?>][availabilities]" size="1" class="timeSelect" id="<?php echo $key; ?>">
                        <option value="0" <?php echo ($availability->data->status == '0') ? "selected = 'selected'" : ''; ?>>Available</option>
                        <option value="1" <?php echo ($availability->data->status == 1) ? "selected = 'selected'" : ''; ?>>Avaliable time</option>
                        <option value="2" <?php echo ($availability->data->status == 2) ? "selected = 'selected'" : ''; ?>>Not Avaliable</option>
                    </select>



                </div>

                <div>
                    <div class="available-div update-available-div">
                        <?php if ($availability->data->status == 1) { ?>

                        <?php $i = 0; foreach ($availability->time as $time):?>
                        <div class="date_div">
                            <div class="closeBtn"></div>
                            <div><input type="hidden" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][id]" value="<?php echo $time->id;?>">
                                <span>From :</span>
                                <div>
                                    <select name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][starttime][hour]" size="1" class="hourBox">
                                        <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
                                        <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>" <?php echo ($time->starttime->hour == str_pad($hours, 2, '0', STR_PAD_LEFT)) ? "selected = 'selected'" : ''; ?>><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
                                        <?php } ?>
                                    </select>:

                                    <select name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][starttime][min]" size="1" class="hourBox">
                                        <?php for ($min = 0; $min < 60; $min+=15) { ?>
                                        <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>" <?php echo ($time->starttime->min == str_pad($min, 2, '0', STR_PAD_LEFT)) ? "selected = 'selected'" : ''; ?>><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
                                        <?php } ?>
                                    </select>

                                    <select name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][starttime][meridian]" size="1" class="hourBox">
                                        <option value="am" <?php echo ($time->starttime->meridian == 'am') ? "selected = 'selected'" : ''; ?>>am</option>
                                        <option value="pm" <?php echo ($time->starttime->meridian == 'pm') ? "selected = 'selected'" : ''; ?>>pm</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <span>To :</span>
                                <div>
                                    <select name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][endtime][hour] size="1" class="hourBox">
                                        <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
                                        <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>" <?php echo ($time->endtime->hour == str_pad($hours, 2, '0', STR_PAD_LEFT)) ? "selected = 'selected'" : ''; ?>><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
                                        <?php } ?>
                                    </select>: 
                                    <select name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][endtime][min] size="1" class="hourBox">
                                        <?php for ($min = 0; $min < 60; $min+=15) { ?>
                                        <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>" <?php echo ($time->endtime->min == str_pad($min, 2, '0', STR_PAD_LEFT)) ? "selected = 'selected'" : ''; ?>><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
                                        <?php } ?>
                                    </select>
                                    <select name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][endtime][meridian]" size="1" class="hourBox">
                                        <option value="am" <?php echo ($time->endtime->meridian == 'am') ? "selected = 'selected'" : ''; ?>>am</option>
                                        <option value="pm" <?php echo ($time->endtime->meridian == 'pm') ? "selected = 'selected'" : ''; ?>>pm</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <?php $i++;
                        endforeach; ?>
                        <?php } ?>

                        
                    </div>

                   <?php if($availability->data->status == 1):?>
                    <script type="text/javascript">
                            
                                    $("#add-date-div").show();
                                
                            
                    </script>
                
                <?php endif;?>
                <input id="add-date-div" type="button" value="add" />
                
                </div>
            </th>

        </tr> 
    <?php endforeach; ?>
    <tr>
        <td colspan="2"><input  type="submit" name="submit" value="Submit"/></td>

    </tr>

</table>
</form>

<?php else:?>
    <?php echo "sorry";?>
<?php endif;?>
</div> --><!-- end timeShift-->
<script type="text/javascript">

// $(document).ready(function()
//     {
        
//             $(".add-date-div1").hide();
       
        
        
      
//     });

// $(".closeBtn").click(function()
//         {
//             var e = $(this);

//             e.parent('.date_div').remove();
//         });

// </script>
<script>
$(document).ready(
    function()
    {

        var addBtn = $(".add-date-div1");

        addBtn.hide();

        $( ".timeSelect" ).each(function(index){

                                var e = $(this);

                                var option = e.val();

                                if(option ==1)
                                {
                                    e.closest('th').find('.add-date-div1').show();
                                }
                        });
        
        
        $(".timeSelect").change(function() {

            // console.log('change');

                    var that = $(this);
                    if (that.val() == 1) 
                    {
                        that.closest('th').find('.add-date-div1').show();
                        that.closest('th').find('.available-div').show();

                        var index = that.parent().siblings().children().eq(0).children().size();
                        var key = that.attr('id');
                        $.ajax({
                            type: "POST",
                            url: 'append.php',
                            data: 'index=' + index + '&key=' + key,
                            success: function(response) {
                                that.parent().siblings().fadeIn('fast');
                                // that.parent().siblings().children().eq(0).append(response);
                            }

                        });
                    } else {
                        that.closest('th').find('.available-div').hide();
                        that.closest('th').find('.add-date-div1').hide();
                    }
                });


        $(".timeSelect").parent().siblings().find('input').click(function()
        {

            var that = $(this);
            var index = that.siblings().children().size();
            //var key = that.parent().attr('id');
            var key = that.parent().siblings().find('select').attr('id');
            $.ajax({
                type: "POST",
                url: 'append.php',
                data: 'index=' + index + '&key=' + key,
                success: function(response) {
                    that.siblings().append(response);
                    that.siblings().children().append("<div class="+'closeBtn'+"></div>");

                    $(".closeBtn").click(function()
                        {
                            var e = $(this);

                            e.parent('.date_div').remove();
                        });
                    //that.parent().siblings().fadeIn('fast');
                    //that.parent().siblings().children().eq(0).html(response);
                }

            });

            //var add_div = $(".available-div div:first-child").html();
            //$(this).siblings().append("<div class="+"date_div"+">"+add_div+"</div>");


        });
    });
</script>