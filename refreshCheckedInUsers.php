<?php
date_default_timezone_set('Asia/Kathmandu');
require_once('config.php');


    $orgId = $_GET['orgId'];
    $url = URL."ShiftUsers/listOfCheckedInUsers/".$orgId.".json";
    $response = \Httpful\Request::get($url)->send();
    $shiftUsers = $response->body->shiftUsers;

    // H:i:s to standart time format
function hisToTime($hisTime)
{
    $startTime = new DateTime($hisTime);
    return $startTime->format('g:i A');
}
?>

<?php if(isset($shiftUsers) && !empty($shiftUsers)):?>
<?php foreach($shiftUsers as $shiftUser):?>
                                        <?php if($shiftUser->ShiftUser->check_status == 2):?>
                                        <li>
                                            <i class="fa fa-share font-green-haze"></i>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <img src="<?php echo URL.'webroot/files/user/image/'.$shiftUser->User->image_dir.'/thumb2_'.$shiftUser->User->image;?>" width="30" height="30">
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc text-capitalize">
                                                             <?php echo $shiftUser->User->fname." ".$shiftUser->User->lname;?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                     <?php echo hisToTime($shiftUser->ShiftUser->check_in_time);?>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <i class="fa fa-reply font-red" style="float:right;"></i>
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <img src="<?php echo URL.'webroot/files/user/image/'.$shiftUser->User->image_dir.'/thumb2_'.$shiftUser->User->image;?>" width="30" height="30">
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc text-capitalize">
                                                             <?php echo $shiftUser->User->fname." ".$shiftUser->User->lname;?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date">
                                                     <?php echo hisToTime($shiftUser->ShiftUser->check_out_time);?>
                                                </div>
                                            </div>
                                            
                                        </li>
                                        <?php else:?>
                                            <li>
                                                <i class="fa fa-share font-green-haze"></i>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <img src="<?php echo URL.'webroot/files/user/image/'.$shiftUser->User->image_dir.'/thumb2_'.$shiftUser->User->image;?>" width="30" height="30">
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc text-capitalize">
                                                                 <?php echo $shiftUser->User->fname." ".$shiftUser->User->lname;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         <?php echo hisToTime($shiftUser->ShiftUser->check_in_time);?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endif;?>
<?php endforeach;?>
<?php else:?>
<li>No any employee logged in.</li>
<?php endif;?>