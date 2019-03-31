<?php
// $userId = $_GET['user_id'];

$url = URL . "Days/dayList.json";
$data = \Httpful\Request::get($url)->send();
$days = $data->body->days;
//echo "<pre>";
//print_r($days);

if (isset($_POST["submit"])) {
    // echo "<pre>";
    // print_r($_POST['data']);
    // die();
    $url = URL . "Useravailabilities/addEmployeeAvailabilities/" . $userId . ".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
   // echo "<pre>";
    //print_r($response);
	echo("<script>location.href = '".URL_VIEW."useravailabilities/myAvailability?user_id=".$userId."';</script>");
}
?>

<?php
/*
  for($hours=0; $hours<24; $hours++){ // the interval for hours is '1'
  for($mins=0; $mins<60; $mins+30){ // the interval for mins is '30'
  echo '<option>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
  .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
  }
  }
 */
?>

<?php /* ?>
  <form action="" id="UseravailabilityAddForm" method="post" accept-charset="utf-8">
  <div style="display:none;">
  <input type="hidden" name="_method" value="POST"/>
  </div>
  <fieldset>
  <legend>Add Useravailability</legend>

  <?php foreach($days as $key=>$day):?>
  <?php echo $day;?>
  <select name="data[Useravailability][<?php echo $key;?>][availabilities]" id="UseravailabilityEndtimeMeridian" required="required">
  <option value="0" selected="selected">Available</option>
  <option value="1">Avaliable time</option>
  <option value="2">Not Avaliable</option>
  </select>


  <div class="input time required">
  <label for="UseravailabilityStarttimeHour">Starttime</label>
  <select name="data[Useravailability][<?php echo $key;?>][time][0][starttime][hour]" id="UseravailabilityStarttimeHour" required="required">
  <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
  <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
  <?php } ?>

  </select>:<select name="data[Useravailability][<?php echo $key;?>][time][0][starttime][min]" id="UseravailabilityStarttimeMin" required="required">
  <?php for ($min = 0; $min < 60; $min+=15) { ?>
  <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
  <?php } ?>
  </select>
  <select name="data[Useravailability][<?php echo $key;?>][time][0][starttime][meridian]" id="UseravailabilityStarttimeMeridian" required="required">
  <option value="am" selected="selected">am</option>
  <option value="pm">pm</option>
  </select>
  </div>
  <div class="input time required">
  <label for="UseravailabilityEndtimeHour">Endtime</label>
  <select name="data[Useravailability][<?php echo $key;?>][time][0][endtime][hour]" id="UseravailabilityEndtimeHour" required="required">
  <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
  <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
  <?php } ?>
  </select>:<select name="data[Useravailability][<?php echo $key;?>][time][0][endtime][min]" id="UseravailabilityEndtimeMin" required="required">
  <?php for ($min = 0; $min < 60; $min+=15) { ?>
  <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
  <?php } ?>
  </select>
  <select name="data[Useravailability][<?php echo $key;?>][time][0][endtime][meridian]" id="UseravailabilityEndtimeMeridian" required="required">
  <option value="am" selected="selected">am</option>
  <option value="pm">pm</option>
  </select>
  </div>
  <?php if($key == 2){?>
  <div class="input time required">
  <label for="UseravailabilityStarttimeHour">Starttime</label>
  <select name="data[Useravailability][<?php echo $key;?>][time][1][starttime][hour]" id="UseravailabilityStarttimeHour" required="required">
  <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
  <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
  <?php } ?>

  </select>:<select name="data[Useravailability][<?php echo $key;?>][time][1][starttime][min]" id="UseravailabilityStarttimeMin" required="required">
  <?php for ($min = 0; $min < 60; $min+=15) { ?>
  <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
  <?php } ?>
  </select>
  <select name="data[Useravailability][<?php echo $key;?>][time][1][starttime][meridian]" id="UseravailabilityStarttimeMeridian" required="required">
  <option value="am" selected="selected">am</option>
  <option value="pm">pm</option>
  </select>
  </div>
  <div class="input time required">
  <label for="UseravailabilityEndtimeHour">Endtime</label>
  <select name="data[Useravailability][<?php echo $key;?>][time][1][endtime][hour]" id="UseravailabilityEndtimeHour" required="required">
  <?php for ($hours = 1; $hours <= 12; $hours++) { ?>
  <option value="<?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($hours, 2, '0', STR_PAD_LEFT); ?></option>
  <?php } ?>
  </select>:<select name="data[Useravailability][<?php echo $key;?>][time][1][endtime][min]" id="UseravailabilityEndtimeMin" required="required">
  <?php for ($min = 0; $min < 60; $min+=15) { ?>
  <option value="<?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($min, 2, '0', STR_PAD_LEFT); ?></option>
  <?php } ?>
  </select>
  <select name="data[Useravailability][<?php echo $key;?>][time][1][endtime][meridian]" id="UseravailabilityEndtimeMeridian" required="required">
  <option value="am" selected="selected">am</option>
  <option value="pm">pm</option>
  </select>
  </div>
  <?php }?>

  <br/>
  <?php endforeach;?>

  </fieldset>
  <div class="submit">
  <input  type="submit" name="submit" value="Submit"/>
  </div>
  </form><?php */ ?>

<!--  <div class="timeShift"> -->
<div class="row"> 
  <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Add Availability
                </div>
            </div>
            <div class="portlet-body form">
               <form action="" id="UseravailabilityAddForm" method="post" accept-charset="utf-8">
                  <table width="100%" class="table table-hover">
                      <tr>
                          <th>Day</th>
                          <th>Type</th>
                      </tr>
                      <?php foreach ($days as $key => $day): ?>
                          <tr>
                              <td><div class="span_day"><?php echo $day;?></div>
                                  
                              </td>
                              <td>
                                <div class="select_div">
                                     <select name="data[Useravailability][<?php echo $key;?>][availabilities]" size="1" class="timeSelect form-control" id="<?php echo $key;?>">
                                            <option value="0">Available</option>
                                            <option value="1">Available time</option>
                                            <option value="2">Not Avaliable</option>
                                      </select>
                                </div>

                                <div class="available-select">
                                    <div class="available-div">
                                    </div>
                                    <input id="add-date-div" class="add-date-div1" type="button" value="Add" />
                                </div>
                                </td>

                          </tr> 
                      <?php endforeach; ?>
                          <tr>
                              <td colspan="2"><input  type="submit" name="submit" value="Submit" class="btn green"/></td>
                          </tr>

                  </table>
               </form>
            </div>
        </div>
</div>
</div>

<!-- end timeShift-->



<!-- <div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
       <!-- <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Update Availability
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
              <!--<form action="" id="UseravailabilityAddForm" method="post" accept-charset="utf-8">
                  <table width="100%" class="table table-hover">
                      <tr>
                          <th>Day</th>
                          <th>Type</th>
                          
                      </tr>
                      <?php foreach ($days as $key => $day): ?>
                          <tr>
                              <td><div class="span_day"><?php echo $day;?></div>
                                  
                              </td>


                              <td>
                                   <select name="data[Useravailability][<?php echo $key;?>][availabilities]" size="1" class="timeSelect" id="<?php echo $key;?>" class="form-control">
                                          <option value="0" selected="selected">Available</option>
                                          <option value="1">Avaliable time</option>
                                          <option value="2">Not Avaliable</option>
                                    </select>

                                  <div class="available-select">
                                   
                                    <div class="available-div">


                                    </div>

                                      
                              <input id="add-date-div" class="addDateBtn" type="button" value="Add" />
                              
                                </div>
                          </td >

                          </tr> 
                      <?php endforeach; ?>
                          <tr>
                              <td colspan="2"><input  type="submit" name="submit" value="Submit" class="btn blue"/></td>
                          </tr>

                  </table>
              </form>
                <!-- END FORM-->
           <!-- </div>
        </div>
        <!-- END VALIDATION STATES-->
    <!--</div>
    

</div> -->

<script>
    $(document).ready(
function()
{

   $(".add-date-div1").hide();
  $(".timeSelect").change(function(ev){

            var that = $(this);
            var addbtn = $(this).closest('td').find('.add-date-div1');
            if(that.val()==1)

            {
              var index = that.parent().siblings().children().eq(0).children().size();                
                addbtn.show();

                  var key = that.attr('id');
                  
                  $.ajax({
                              type: "POST",
                              url: 'append.php',
                              data: 'index='+index+'&key='+key,
                              success: function(response)
                              {
                                  that.parent().siblings().fadeIn('fast');
                                  that.parent().siblings().children().eq(0).html(response);

                                  ComponentsPickers.init();
                                  
                              }
                          
                          });
              }else{
                    addbtn.hide();
                          $(this).closest('td').find('.available-select').hide();
                      }
                });
                
                
                $(".timeSelect").parent().siblings().find('input').click(function()
                  {
                    if($(this).siblings().css('height') > $(this).siblings().css('max-height'))
                    {
                      $(this).siblings().css({"overflow-y":"scroll"});
                    }
                                      var that = $(this);
                                       var index = that.siblings().children().size();
                                          //var key = that.parent().attr('id');
                                           var key = that.parent().siblings().find('select').attr('id');
                                           
                                          $.ajax({
                                                  type: "POST",
                                                  url: 'append.php',
                                                  data: 'index='+index+'&key='+key,
                                                  success: function(response){
                                                      that.siblings().append(response);
                                                      //that.parent().siblings().fadeIn('fast');
                                                      //that.parent().siblings().children().eq(0).html(response);
                                                  }
                                  
                                  });
                  
                    //var add_div = $(".available-div div:first-child").html();
                    //$(this).siblings().append("<div class="+"date_div"+">"+add_div+"</div>");
                                      
                    
                  });
          
    }); 
  
        </script>


