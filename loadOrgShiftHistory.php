<?php

    session_start();
    include('config.php');
    include('function.php');
    //include('loginCheck.php');
    include('url_get_value.php');

    $range = explode("/", $_GET['range']);
    $sDate = $range[0];
    $eDate = $range[1];

    $url = URL."Accounts/getShiftHistory/".$orgId."/".$sDate."/".$eDate.".json";
    $response = \Httpful\Request::get($url)->send();

    $shiftHistoryStat = $response->body->status;
    // fal($response);
    $shiftHistories = $response->body->history;
    // fal($shiftHistories);
?>

<table class="table table-striped table-bordered table-advance table-hover">
    <thead>
    <tr>
        <th>
            <i class="fa fa-user"></i> Employee
        </th>

        <th>
            <i class="fa fa-clock-o"></i> Total Worked Hours
        </th>

        <th>
            <i class="fa fa-circle-o-notch"></i> Total Less To full Work Hours
        </th>

        <th>
            <i class="fa fa-dashboard"></i> Total OverTime Hours
        </th>
    </tr>
    </thead>
    <tbody>
        <?php if ($shiftHistoryStat ==1): ?>
          <?php foreach ($shiftHistories as $shiftHistory): ?>
              <tr>
                  <td>
                      <a href="javascript:;">
                          <?php
                                    $userimage = URL.'webroot/files/user/image/'.$shiftHistory->User->image_dir.'/thumb2_'.$shiftHistory->User->image;
                                    $image = $shiftHistory->User->image;
                                    $gender = $shiftHistory->User->gender;
                                    $user_image = imageGenerate($userimage,$image,$gender);
                            ?>
                            <img class="user-pic" src="<?php echo $user_image; ?>" width="40px" alt="image not found" style="height:40px;"/>
                      <?php echo $shiftHistory->User->fname." ".$shiftHistory->User->lname; ?></a>
                  </td>
                  <td>
                       <?php echo round($shiftHistory->{0}->workedhours,2); ?> <!-- <span class="label label-sm label-success label-mini">
                                                                               Paid </span> -->
                  </td>
                  <td>
                       <?php echo round($shiftHistory->{0}->lesshours, 2); ?> <!-- <span class="label label-sm label-success label-mini">
                                                                               Paid </span> -->
                  </td>
                  <td>
                       <?php echo round($shiftHistory->{0}->morehours, 2); ?> <!-- <span class="label label-sm label-success label-mini">
                                                                               Paid </span> -->
                  </td>
              </tr>  
          <?php endforeach ?>
        <?php else: ?>
                  <tr>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                </tr>    
        <?php endif ?>
    </tbody>
</table>