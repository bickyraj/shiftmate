<link href="<?php echo URL_VIEW;?>admin/pages/css/news.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<style>
#new_meeting_request .modal-body {
    max-height: 520px;
    overflow-y: auto;
}
</style>
<?php 


$loginUserRelationToOther = loginUserRelationToOther($userId);
$branchManager = loginUserRelationToOther($userId)->branchManager;

//fal($loginUserRelationToOther);

$url = URL."BranchUsers/getUserRelatedBranches/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$userRelatedBranches = $data->body->list;

$branchIds = array();
foreach($userRelatedBranches as $b){
    $branchIds[] = $b->BranchUser->branch_id;
}


// if(isset($_POST['dateRangeFrmSubmit']))
// {
//     echo "<pre>";print_r($_POST);die();
// }

if(isset($_POST['saveMeetingRequest'])){

    //fal($_POST);
    $url = URL . "Senders/addRequest.json";
    $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();
?>
<script>
toastr.info("<?php echo $response->body->message;?>","Save Status");
</script>
<?php } ?>
<?php
  $url = URL."ShiftUsers/dashboardShift/".$user_id.".json";
    $data = \Httpful\Request::get($url)->send();
    $usershifts = $data->body->output;

$url = URL."Users/userDetail/".$user_id.".json";
    $data = \Httpful\Request::get($url)->send();
    $userName = $data->body->message->User->fname;

$url = URL."ShiftUsers/todaysShift/".$user_id.".json";
$data = \Httpful\Request::get($url)->send();
$todaysShift = $data->body;

// fal($loginUserRelationToOther);

// check if the user is boardManager
if(isset($loginUserRelationToOther->boardManager) && !empty($loginUserRelationToOther->boardManager))
{
    foreach ($loginUserRelationToOther->boardManager as $boardId => $boardTitle) {

        $boardIdList[] = $boardId;
        }

        $boardListIds = implode('_', $boardIdList);
}


function timeLeft($time)
{

    $time1 = new DateTime(date('H:i:s'));
    $time2 = new DateTime($time);
    $interval = $time1->diff($time2);

    if($interval->h > '0')
    {
       $timeLeft =  $interval->h.' hr '.$interval->i.' min left'; 
    }
    elseif($interval->i > '0')
    {
        $timeLeft =  $interval->i.' min left'; 
    }
    else
    {
        $timeLeft =  $interval->s.' sec left';
    }

    return $timeLeft;
}

function ymdtofjy($date)
{   
    $date = strtotime($date);
    return date('F j, Y', $date);
}


// end of checking board manager
$url = URL."Shiftswaps/getShiftSwapRequests/".$user_id.".json";
$response= \Httpful\Request::get($url)->send();
$shiftSwapRequestToYou = $response->body;
 

// date_default_timezone_set('Asia/Kathmandu');
	

    $url = URL."ShiftUsers/getRunningShifts/".$user_id.".json";
    $response = \Httpful\Request::get($url)->send();
    $response = $response->body->runningShift;

    if(isset($response) && !empty($response))
    {

        if(isset($response->runningShift) && !empty($response->runningShift))
        {
            $runningShift = $response->runningShift;
        }
        if(isset($response->nextShift) && !empty($response->nextShift))
        {
            $upcommingShift = $response->nextShift;
        }
    }

//Edited By Manohar Khadka
$url = URL."Tasks/listTask/".$user_id.".json";
$data = \Httpful\Request::get($url)->send();
$tasks = $data->body->tasks;

 // Ashok shrestha

 if(isset($_POST['submitExpense']))
    {
        if(isset($_FILES['expenseSupportingImage'])){
            $_POST['data']['Employeeshiftexpense']['image']=array(
                'name'=>$_FILES['expenseSupportingImage']['name'],
                'type'=> $_FILES['expenseSupportingImage']['type'],
                'tmp_name'=> $_FILES['expenseSupportingImage']['tmp_name'],
                'error'=> $_FILES['expenseSupportingImage']['error'],
                'size'=> $_FILES['expenseSupportingImage']['size']
            );
        }
        
        $url = URL."Employeeshiftexpenses/add.json";

        $response = \Httpful\Request::post($url)
                    ->sendsJson()
                    ->body($_POST['data'])
                    ->send();
    }

    $userOrganization = loginUserRelationToOther($user_id);
    $orgIds = array();

    if(isset($userOrganization->userOrganization) && !empty($userOrganization->userOrganization))
    {
        foreach ($userOrganization->userOrganization as $key => $value) {
            
            $orgIds[] = $key;
        }
        $listOrgIds = implode('_', $orgIds);
    }
    


     if(isset($runningShift) && !empty($runningShift))
    {

        $currentShiftUserId = $runningShift->ShiftUser->id;
        
        $url1 =URL."Employeeshiftexpenses/viewUserShiftById/".$currentShiftUserId.".json";
        $response1 = \Httpful\Request::get($url1)->send();
        $shiftuserexpenses = $response1->body;
        
        $url2 = URL."Employeeshiftexpenses/getUserTotal/".$currentShiftUserId.".json";
        $response2 = \Httpful\Request::get($url2)->send();
        $totalUserShiftAmount = $response2->body;
    
    }

    $url = URL."Users/Notices/".$user_id.".json";
    $org = \Httpful\Request::get($url)->send();
    $org_details = $org->body->output['0']->OrganizationUser;
?>


<?php


            $count=0;
            $totalShift =0;
            $totalWorking = 0;
            $overTimeDashboard = 0;
            $totalNormalWork=0;
            $overTimeDashboardInSeconds=0;

            if(isset($loginUserRelationToOther->OrganizationUser) && !empty($loginUserRelationToOther->OrganizationUser)):
             foreach ($loginUserRelationToOther->userOrganization as $orgid=>$org_detail):
          
                            $count++;
        
                           if(isset($_POST['dateRangeFrmSubmit'])){           
                                $url2= URL."ShiftUsers/getDashboardTotalWork/".$user_id."/".$orgid."/".$_POST['startDate']."/".$_POST['endDate'].".json";
                               
                                }
                                else
                                {
                                    $url2= URL."ShiftUsers/getDashboardTotalWork/".$user_id."/".$orgid.".json";
                                }
                                
                                        $response1 = \Httpful\Request::get($url2)->send();
                                        $totalShift += $response1->body->totalShiftCount;


                                        $totalWorking += $response1->body->totalWorkinHour;

                                        $totalNormalWork +=$response1->body->totalWorkinHourNormal;

                                        $overTimeDashboard+=$response1->body->totalOverTime;

                                        $overTimeDashboardInSeconds+=$response1->body->totalOverTimeNormal;

                        endforeach;

            endif;
?>


<!--<div class="page-content">-->

<style>
    .view-board{ 
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    .view-board::-ms-expand {
        display: none;
    }
    .view-board {
        background-color: transparent;
        border: 0px none;
        border-bottom: 1px solid #999;
        width: 100%;
        height: 32px;
        color: #ffffff;
    }
    .view-board {
            background: url(images/dropdown.png) no-repeat top 14px right 7px;
        }
        .view-board option {
            color:#666;
        }
</style>
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Dashboard &amp; statistics</h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?=URL_VIEW;?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Dashboard</a>
            </li>
        </ul>

        <form id="dateRangeFrm" action=" " method="post">
            <input id="dateRangeStartDate" type="hidden" name="startDate">
            <input id="dateRangeEndDate" type="hidden" name="endDate">
            <input id="dateRangeFrmSubmit" type="submit" name="dateRangeFrmSubmit" hidden>
        </form>
        <!-- <div class="page-toolbar">
            <form action="" method="post">
                <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm btn-default" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range" data-date-format="yyyy-mm-dd">
                    <i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block"></span>&nbsp; <i class="fa fa-angle-down"></i>
                </div>
            </form>
        </div> -->
        <!-- <div class="page-toolbar">
            <form action="" method="post">
                <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm btn-default" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range" data-date-format = "yyyy-mm-dd">
                    <i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block"></span>&nbsp; <i class="fa fa-angle-down"></i>
                </div>
            </form>
        </div -->

        <!--   <h3 class="page-title">
            Shiftmate
        </h3> -->
        <!-- END PAGE HEADER-->

        <!-- Organization requests. -->
            <?php if(isset($loginUserRelationToOther->userOrganization) && empty($loginUserRelationToOther->userOrganization)):?>
                <!-- <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="portlet">
                            <div class="portlet-title" style="display:none;">
                                <div class="tools">
                                    <a href=""  class="reload totalShiftSpinner" data-original-title="" title="">
                                    </a>
                                </div>
                            </div>

                            <div class="portlet-body">
                                <div class="dashboard-stat purple-plum">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details" style="padding: 25px !important;margin-right:0px;">
                                        <div class="scroller" style="height:80px;" data-always-visible="1" data-rail-visible="0">
                                        <ul class="media-list" id="organizationRequestsDiv">
                                            
                                        </ul>
                                    </div>
                                    </div>
                                    <a class="more" href="javascript:;">
                                    Organization Requests <i class="m-icon-swapright m-icon-white"></i>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            <?php endif;?>



            <?php if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)):?>
             <!-- BEGIN DASHBOARD STATS -->
    

            <!-- row -->
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-bar-chart font-green-sharp hide"></i>
                                <span>Hi <span style="font-style:italic;">&nbsp;<?php echo $userName; ?>!</span>&nbsp; Today's Shift Schedule</span>
                          </div>
                            <div class="actions" style="display:none;">
                                <select class="orgn">
                                    <option value="0">All Organizations</option>
                                    <?php if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)){
                                        foreach($loginUserRelationToOther->userOrganization as $ordnid=>$orgndet){
                                            foreach($orgndet as $key=>$value){
                                                echo "<option value='".$ordnid."'>".$key."</option>";
                                            }
                                        }
                                    } ?>
                                </select>
                                <select class="brnch">
                                    <option value="0">All Branches</option>
                                </select>
                                <select class="brd">
                                    <option value="0">All Depatrment</option>
                                </select>
                            </div>

                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                    <input type="radio" name="options" class="toggle" id="option1">Today</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table">
                                <table class="table table-hover table-light" id="sample_today_shift">
                                       <?php if(!empty($todaysShift)){ ?>
                                    <thead>
                                    <thead>
                                    <tr class='uppercase'>
                                        <th>Shift</th>
                                        <th>Organization</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>No.of Employee</th>
                                    </tr>
                                    </thead>
                                       
                                    </thead>

                                    <?php 
                                    // $count = 0; foreach($todaysShift as $shift):
                                    // $count++;
                                    // endforeach;
                                    ?>
                                    <tbody>
                                        <?php foreach($todaysShift as $shift):
                                            
                                        ?>
                                            <tr>
                                                <td><?php echo $shift->shift; ?></td>
                                                <td><?php echo $shift->org; ?></td>
                                                <td><?php echo hisToTime($shift->start);?> </td>
                                                <td><?php echo hisToTime($shift->end);?></td>
                                                <td><?php echo $shift->count; ?></td>
                                            </tr>
                                                
                                        <?php endforeach; ?>    
                                    </tbody>
                                    <?php } else { ?>
                                    <blockquote><small>There are no shifts scheduled for today till now.</small></blockquote>
                                <?php } ?>
                                </table>
                            </div>
                            <div id="modals_of_today_shift"></div>
                            <div class="portlet-body">
                                <div class="table">
                                    <table class="table table-hover table-light" id="sample_today_shift">
                                    
                                    </table>
                                </div>
                                <div id="modals_of_today_shift"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

               <!--  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

                    <div class="portlet">
                    <div class="portlet-title" style="display:none;">
                                <div class="tools">
                                    <a href=""  class="reload totalShiftSpinner" data-original-title="" title="">
                                    </a>

                                </div>
                    </div>
                        <div class="portlet-body">
                            <div class="dashboard-stat blue-madison">
                                <div class="visual">
                                    <i class="fa fa-comments"></i>
                                </div>

                                <div class="details">
                                    <div id="statsTotalshift" class="number">
                                         <?php echo $totalShift;?>
                                    </div>
                                    <div class="desc">
                                         Total Shift
                                    </div>
                                    <!-- <div>
                                        <img  src="<?php echo URL_VIEW; ?>global/img/loading.gif" />
                                    </div> -->

                    <!--             </div>
                                <a class="more" href="javascript:;">
                                View more <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>
                    </div> -->
                <!-- </div>  -->


                <!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="portlet">
                        <div class="portlet-title" style="display:none;">
                                    <div class="tools">
                                        <a href=""  class="reload totalShiftSpinner" data-original-title="" title="">
                                        </a>
                                    </div>
                        </div>
                            <div class="portlet-body">
                                <div class="dashboard-stat red-intense">
                                    <div class="visual">
                                        <i class="fa fa-bar-chart-o"></i>

                                    </div>
                                    <div class="details">
                                        <div id="statsTotalworking" class="number">
                                             <?php

                                               $init= $totalNormalWork ;
                                                $hours = floor($init / 3600);
                                                $minutes = floor(($init / 60) % 60);
                                                $seconds = $init % 60;

                                                echo "$hours:$minutes:$seconds";
                                                // echo $init;

                                             ?>
                                        </div>
                                        <div class="desc">
                                             Working Hour
                                        </div>

                                    </div>
                                    <a class="more" href="javascript:;">
                                    View more <i class="m-icon-swapright m-icon-white"></i>
                                    </a>
                                </div>
                            </div>
                    </div>
                </div> -->


             <!--    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

                    <div class="portlet">
                        <div class="portlet-title" style="display:none;">
                                    <div class="tools">
                                        <a href=""  class="reload totalShiftSpinner" data-original-title="" title="">
                                        </a>

                                    </div>
                        </div>
                        <div class="portlet-body">
                            <div class="dashboard-stat green-haze">
                                <div class="visual">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>

                                <div class="details">
                                    <div id="statsOvertime" class="number">
                                        <?php 
                                            $init= $overTimeDashboardInSeconds ;
                                            $hours = floor($init / 3600);
                                            $minutes = floor(($init / 60) % 60);
                                            $seconds = $init % 60;

                                            echo "$hours:$minutes:$seconds";
                                         ?>
                                    </div>
                                    <div class="desc">
                                         Overtime
                                    </div>

                                </div>
                                <a class="more" href="javascript:;">
                                View more <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div> -->

                 <!-- Organization requests. -->
                   <!--  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

                        <div class="portlet">
                            <div class="portlet-title" style="display:none;">
                                        <div class="tools">
                                            <a href=""  class="reload totalShiftSpinner" data-original-title="" title="">
                                            </a>

                                        </div>
                            </div>
                            <div class="portlet-body" style="background-color:white;">
                                
                                <ul class="nav nav-pills nav-stacked" style="max-width: 260px; margin-bottom:0px;">
                                        <li class="active">
                                            <a href="javascript:;">
                                            Organization Requests </a>
                                        </li>
                                    </ul>
                                    <div class="scroller" style="height:80px;" data-always-visible="1" data-rail-visible="0">
                                    <ul class="media-list" id="organizationRequestsDiv" style="max-width: 260px;padding: 9px;">
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> -->


           <!--      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="portlet">
                        <div class="portlet-title" style="display:none;">
                                    <div class="tools">
                                        <a href=""  class="reload totalShiftSpinner" data-original-title="" title="">
                                        </a>
                                    </div>
                        </div>

                        <div class="portlet-body">
                            <div class="dashboard-stat purple-plum">
                                <div class="visual">
                                    <i class="fa fa-globe"></i>
                                </div>
                                <div class="details" style="padding: 25px !important;margin-right:0px;">
                                    <div class="scroller" style="height:80px;" data-always-visible="1" data-rail-visible="0">
                                    <ul class="media-list" id="organizationRequestsDiv">
                                        
                                    </ul>
                                </div>
                                </div>
                                <a class="more" href="javascript:;">
                                Organization Requests <i class="m-icon-swapright m-icon-white"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                </div> -->
                <?php if(isset($loginUserRelationToOther->boardManager) && !empty($loginUserRelationToOther->boardManager)){ ?>
        <!--          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="portlet">
                        <div class="portlet-title" style="display:none;">
                                    <div class="tools">
                                        <a href=""  class="reload totalShiftSpinner" data-original-title="" title="">
                                        </a>
                                    </div>
                        </div>

                        <div class="portlet-body">
                            <div class="dashboard-stat purple-plum">
                                <div class="visual">
                                    <i class="fa fa-futbol-o"></i>
                                </div>
                                <div class="details" style="padding-right:0px;width:89%">
                                    <select class="boardwidgetOrgn form-control view-board">
                                        <option value="0"> -- Select Organization -- </option>
                                        <?php foreach($loginUserRelationToOther->userOrganization as $key=>$val){
                                        foreach($val as $key2=>$val2){
                                            echo '<option value="'.$key.'">'.$key2.'</option>';
                                            }} ?>
                                    </select>
                                    <select class="boardwidgetBranch form-control view-board">
                                        <option value="0"> -- Select Branch -- </option>
                                    </select>
                                    <select class="boardwidgetBoard form-control view-board">
                                        <option value="0"> -- Select Department -- </option>
                                    </select>
                                </div>
                                <a class="more" id="boardWidget" href="javascript:;">
                                View Department Schedule<i class="m-icon-swapright m-icon-white"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                </div> -->
        <script>
            $(document).ready(function(){
                
                var userRelation = <?php echo json_encode($loginUserRelationToOther);?>;
                                        
               $("#boardWidget").click(function(){
                    var is = $(this);
                    if($(".boardwidgetOrgn").val() == 0){
                        $(".boardwidgetOrgn").focus();
                    }else if($(".boardwidgetBranch").val() == 0){
                        $(".boardwidgetBranch").focus();
                    }else if($(".boardwidgetBoard").val() == 0){
                        $(".boardwidgetBoard").focus();
                    }else{
                        window.location.href="<?php echo URL_VIEW;?>"+"shifts/shiftScheduleOverview?org_id="+$(".boardwidgetOrgn").val()+"&board_id="+$(".boardwidgetBoard").val()+"&branch_id="+$(".boardwidgetBranch").val();
                    }
               });
               $(".boardwidgetOrgn").change(function(){
                    var e=$(this);
                    loadBrdNBrnch2(e);
               });
               
            $(".boardwidgetBranch").change(function(){
                        var f=$(this);
                            $.ajax({
                                url:"<?php echo URL;?>"+"Boards/getBoardListOfBranch/"+f.val()+".json",
                                datatype:"jsonp",
                                success:function(data){
                                    var data3="<option value='0'>-- Select Department --</option>";
                                    $.each(userRelation['boardManager'],function(k5,v5){
                                        $.each(data['boardList'],function(k6,v6){
                                            if(k5==v6['Board']['id']){
                                                data3+="<option value='"+v6['Board']['id']+"'>"+v6['Board']['title']+"</option>";
                                            }
                                        });
                                    });
                                    $(".boardwidgetBoard").html(data3);
                                }
                            });
                     });
                                   
                        function loadBrdNBrnch2(e){
                            $.ajax({
                            url:"<?php echo URL;?>"+"Boards/listBoards/"+e.val()+".json",
                            datatype:"jsonp",
                            success:function(data){
                               var data1="<option value='0'> -- Select  Department -- </option>";
                                $.each(userRelation['boardManager'],function(k4,v4){
                                    $.each(data['boards'],function(k,v){
                                        if(k4==v['Board']['id']){
                                            data1+="<option value='"+v['Board']['id']+"'>"+v['Board']['title']+"</option>";
                                        }
                                    });
                                });
                                $(".boardwidgetBoard").html(data1);
                            }
                        });
                        $.ajax({
                            url:"<?php echo URL;?>"+"Branches/BranchesList/"+e.val()+".json",
                            datatype:"jsonp",
                            success:function(data){
                                var data2="<option value='0'> -- Select Branch -- </option>";
                                $.each(userRelation['userOrganization'],function(k1,v1){
                                    $.each(v1,function(k2,v2){
                                        $.each(v2,function(k3,v3){
                                            $.each(data['branches'],function(k,v){
                                                if(k3 == k){
                                                    data2+="<option value='"+k+"'>"+v+"</option>";
                                                } 
                                            });
                                        });
                                    });
                                });
                                $(".boardwidgetBranch").html(data2);
                            }
                        });
                    }
                                });
        </script>
        <?php } ?>
                
        <!-- END DASHBOARD STATS -->
        <div class="clearfix">
        </div>

        <div class="row">

            <!-- 1st column -->
            <div class="col-md-4">
                <div class="portlet light">
                    <div class="portlet-title ">
                        <div class="caption">
                           
                            <span class="caption-subject font-green-sharp bold uppercase">Top Stories</span>
                        </div>
                        <div class="actions">
                        <a href="<?php echo URL_VIEW.'users/newsboard';?>" class="btn btn-sm red-sunglo"><i class="fa fa-street-view"></i> View All</a>

                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php if(isset($org_details) && !empty($org_details)):?>
                            <?php foreach ($org_details as $organization):?>
                                <div class="scroller panel panel-default" style="max-height: 350px;">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php echo $organization->Organization->title; ?></h3>
                                    </div>
                                    <div class="panel-body">
                                        <?php if(isset($organization->Organization->Newsboard) && !empty($organization->Organization->Newsboard)){
                                         $i = 1; ?>
                                            <ul class="list-unstyled">
                                                <?php foreach ($organization->Organization->Newsboard as $news):
                                                    
                                                    if($i == 6) break; 
                                                     else { 
                                                      $i++;
                                                     ?>
                                                    
                                                    <li>
                                                    <h4 class="sale-info list-group-item-heading">
                                                                            <?php echo $news->title; ?>
                                                                        </h4>
                                                         <div class="news-block-tags">
                                                         <?php $n_date = explode(" ", $news->news_date);?>
                                                              <em class="sale-info small" style="font-style:normal;clear:both"><?php echo $n_date['0'];?></em>
                                                        </div>                                              
                                                    
                                                        <p style="clear:both">
                                                            <?php echo substr($news->description,0,100);
                                                               $data=$news->description;
                                                            ?>
                                                        </p>
                                                        <?php
                                                            if(str_word_count($data) > 9 ){
                                                        ?>
                                                            <a href="#portlet-config_<?php echo $i;?>" class="news-block-btn config" data-toggle="modal">
                                                            Read more <i class="m-icon-swapright m-icon-black"></i>
                                                            </a>
                                                        <?php }?>
                                                           </li> 
                                                        <!--pop-up content for News board-->
                                                            <div class="modal fade" id="portlet-config_<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                            <h4 class="modal-title"><?php echo $news->title;?></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <?php echo $news->description; ?>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                            <!-- /.modal-dialog -->
                                                            </div>
                                                        <!--end pop-up content for news board-->
                                                    <?php }?>
                                                <?php endforeach;?>
                                            </ul>
                                        <?php }else{?>
                                            <span>No recent news to show.</span>
                                        <?php }?>
                                    </div>
                                </div>
                                <br>
                            <?php endforeach;?>
                        <?php else:?>
                            <span>No recent news to show.</span>
                        <?php endif;?>
                    </div>
                </div>

                <div class="portlet light tasks-widget">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-share font-green-haze hide"></i>
                            <span class="caption-subject font-green-haze bold uppercase">Shift Requests</span>
                            <span class="caption-helper"></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="task-content">
                            <div class="scroller" style="height: 305px;" data-always-visible="1" data-rail-visible1="1">
                                <!-- START TASK LIST -->
                                <ul class="task-list">

                                        <!-- *********************************** Ashok Neupane **************** -->
                                        <?php
                                            $urla = URL."ShiftUsers/shiftRequests/".$user_id.".json";
                                            $shft_req = \Httpful\Request::get($urla)->send();
                                            $shftreq_details = $shft_req->body->allShifts;
                                           // echo "<pre>";
                                           // print_r($shftreq_details);
                                           // echo "</pre>";
                                           // die();
                                        if(isset($shftreq_details) && !empty($shftreq_details)){
                                        foreach($shftreq_details as $det){ ?>

                                            <li class="parentreqdiv ">
                                                <div class="task-title row">

                                                    <div class="col-md-3">
                                                        <img src="<?php echo URL."webroot/files/organization/logo/".$det->Organization->logo_dir."/thumb_".$det->Organization->logo;?>" alt="logo" style="height: 50px;width: 60px;"/>
                                                    </div>
                                                <div class="col-md-9">
                                                       <span><?php echo $det->Organization->title;?></span><br /> 
                                                        
                                        <?php
                                        $date1=DateTime::createFromFormat('H:i:s',$det->Shift->starttime);
                                        $date2=$date1->format('g:ia');
                                        $date3=DateTime::createFromFormat('H:i:s',$det->Shift->endtime);
                                        $date4=$date3->format('g:ia');
                                        $date5=DateTime::createFromFormat('Y-m-d',$det->ShiftUser->shift_date);
                                        $date6=$date5->format('jS F Y');
                                        ?>
                                                        <span><?php echo $det->Shift->title;?>&nbsp;(<span><?php echo $date2."-".$date4;?></span>)</span><br />
                                                        <span><?php echo $date6;?></span>
                                                  <br />   
                                                  <div style="float: right;">
                                                        <input type="hidden" name="data[ShiftUser][id]" value="<?php echo $det->ShiftUser->id;?>" class="shftId"/>
                                                        <button data-shiftId="<?php echo $det->ShiftUser->shift_id; ?>" data-boardId="<?php echo $det->ShiftUser->board_id; ?>" data-shiftDate="<?php echo $det->ShiftUser->shift_date; ?>" class="btn btn-xs blue acceptShiftRequest">Accept</button>
                                                        <button class="btn btn-xs red rejectShiftRequest">Reject</button>  
                                                   </div>
                                                   </div>
                                                </div>
                                            </li>
                                            <?php } ?>  
                                            <script>
                                            
                                            
                                                $(document).ready(function(){
                                                    function responseShiftReq(type,shiftId){
                                                        $.ajax({
                                                            url: "<?php echo URL_VIEW."process.php";?>",
                                                            data: "action=responseShiftReq&type="+type+"&shiftId="+shiftId,
                                                            type: "post",
                                                            success:function(data){
                                                                if(data==1){
                                                                    toastr.success('Responded to Shift Request successfully.');
                                                                    return 1;
                                                                }else{
                                                                    toastr.warning('Could not respond to Shift Request, Try after manual reloading of the page','status');
                                                                    return 0;
                                                                }
                                                                
                                                            }
                                                        });
                                                    }
                                                    $('.acceptShiftRequest').click(function(){
                                                        var e = $(this);
                                                        var id = e.siblings('.shftId').val();
                                                        var userId = '<?php echo $userId; ?>';
                                                        
                                                        var shiftId = e.attr('data-shiftId');
                                                        
                                                        var shiftDate = e.attr('data-shiftDate');

                                                        var url ="<?php echo URL; ?>Useravailabilities/checkToConfirm/"+userId+'/'+shiftId+'/'+shiftDate+'.json';
                                                        $.ajax({
                                                            
                                                            url:url,
                                                            type:'post',
                                                            datatype:'jsonp',
                                                            success:function(response){
                                                                
                                                                if(response == 1 ){
                                                                    res=responseShiftReq(3,id);        
                                                                    e.parents('.parentreqdiv').fadeOut(300);

                                                                }else if(response == 0){
                                                                    toastr.info('You are not available to work for that shift.');
                                                                    e.parents('.parentreqdiv').fadeOut(300);
                                                                    
                                                                } else {
                                                                         var res=responseShiftReq(0,id);

                                                                    // toastr.info('You are not available to work for that shift.');
                                                                      e.parents('.parentreqdiv').fadeOut(300);
                                                                }
                                                            

                                                            }
                                                        });

                                                        

                                                    });

                                                    $('.rejectShiftRequest').click(function(){
                                                        var id=$(this).siblings('.shftId').val();
                                                         var res=responseShiftReq(0,id);

                                                         $(this).parents('.parentreqdiv').fadeOut(300);

                                                    });
                                                })
                                            </script>  
                                        <?php }else{ ?>
                                        <span>No Pending Requests Onwards</span>
                                        <?php } ?>

                                        <!-- ********************************************************************************** -->
                                </ul>
                                <!-- END START TASK LIST -->
                            </div>
                        </div>
                        <!-- <div class="task-footer">
                            <div class="btn-arrow-link pull-right">
                                <a href="javascript:;">See All Records</a>
                                <i class="icon-arrow-right"></i>
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="portlet light tasks-widget">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-share font-green-haze hide"></i>
                            <span class="caption-subject font-green-haze bold uppercase">Reject Shift</span>
                            <span class="caption-helper"></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="task-content">
                            <div class="scroller" style="height: 305px;" data-always-visible="1" data-rail-visible1="1">
                                <!-- START TASK LIST -->
                                <ul class="task-list">

                                        <!-- *********************************** Rabi Nakarmi **************** -->
                                        <?php
                                            $url = URL."ShiftUsers/shiftCancel/".$user_id.".json";
                                            $request = \Httpful\Request::get($url)->send();
                                            $shiftCancels = $request->body->output;
                                           // echo "<pre>";
                                           // print_r($shiftCancels);
                                           // echo "</pre>";
                                           // die();
                                        if(isset($shiftCancels) && !empty($shiftCancels)){
                                        foreach($shiftCancels as $shiftCancel){ ?>
                                            <li>
                                <div class="task-checkbox">
                                    <span class="task-bell">
                                    <i class="fa fa-bell-o"></i>
                                    </span>
                                </div>
                                <div class="task-title">
                                    <span class="task-title-sp">
                                    <?php 
                                    $start_time= $shiftCancel->Shift->starttime;
                                    $end_time = $shiftCancel->Shift->endtime;
                                    $startTime =explode(':',$start_time);
                                    $endTime =explode(':',$end_time);
                                    if ($startTime[1] == '00' && $endTime[1] == '00') {
                                        echo $shiftCancel->Shift->title.' ('.(date("g a", strtotime($start_time))).' to '.(date("g a", strtotime($end_time))).')';
                                    }
                                    else if ($startTime[1] != '00' && $endTime[1] == '00') {
                                        echo $shiftCancel->Shift->title.' ('.(date("g:i a", strtotime($start_time))).' to '.(date("g a", strtotime($end_time))).')';
                                    }
                                     else if ($startTime[1] == '00' && $endTime[1] != '00') {
                                        echo $shiftCancel->Shift->title.' ('.(date("g a", strtotime($start_time))).' to '.(date("g:i a", strtotime($end_time))).')';
                                    }
                                    else{
                                    echo $shiftCancel->Shift->title.' ('.(date("g:i a", strtotime($start_time))).' to '.(date("g:i a", strtotime($end_time))).')';
                                }
                                    // $end_time = $shiftCancel->Shift->endtime;
                                    // $data = echo("H:i a", strtotime($end_time)));
                                    // $value = explode(":", $data);
                                    // print_r($value);
                                    ?></span>
                                    <span class="label label-sm label-success"><?php echo $shiftCancel->Organization->title;?></span>
                                    
                                </div>
                               
                            </li>
                                           

                                            <?php } ?>
                                            

                   
                                                                                                 
                                        <?php }else{ ?>
                                        <span>No Rejected Shift</span>
                                        <?php } ?>
                                </ul>
                                <!-- END START TASK LIST -->
                            </div>
                        </div>
                        <!-- <div class="task-footer">
                            <div class="btn-arrow-link pull-right">
                                <a href="javascript:;">See All Records</a>
                                <i class="icon-arrow-right"></i>
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-sharp hide"></i>
                            <span class="caption-subject font-green-sharp bold uppercase">Closed Shift Plans</span>
                        </div>
                        <div class="actions">
                            <div data-toggle="a" class="btn-group btn-group-devided">
                                <a href="<?php echo URL_VIEW."shiftplans/showClosedPlans";?>" class="btn red-sunglo">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                            if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)){
                                foreach($loginUserRelationToOther->userOrganization as $org_id=>$v){
                                    $url8=URL."Shiftplans/getClosedPlans/".$org_id."/".$user_id.".json"; 
                                    $closeShiftPlans1=\Httpful\Request::get($url8)->send();
                                    //echo"<pre>";print_r($closeShiftPlans1);echo "</pre>";
                                    $closeShiftPlans2[]=$closeShiftPlans1->body->closedPlans;
                                }
                            }else{
                                echo "Not in any organization";
                            }
                            ?>
                            <?php
                            if (isset($closeShiftPlans2) && !empty($closeShiftPlans2)) {
                            foreach ($closeShiftPlans2 as $openShiftPlan) {?>
                            <?php if($openShiftPlan){?>
                            <div class="news-blocks"> 
                                <h3>
                                
                                <?php echo $openShiftPlan->Shiftplan->Organization->title; ?>
                                </h3>
                                <div class="news-block-tags">
                                   
                                    <em>Title: <?php echo $openShiftPlan->Shiftplan->title; ?></em><br>
                                    <?php $start_date=DateTime::createFromFormat('Y-m-d',$openShiftPlan->Shiftplan->start_date);
                                     $end_date=DateTime::createFromFormat('Y-m-d',$openShiftPlan->Shiftplan->end_date);
                                     ?>
                                    Start date : <?php echo $start_date->format('jS F Y'); ?><br>
                                    End date : <?php echo $end_date->format("jS F Y"); ?>
                                </div>
                                <p>

                                </p>
                            </div>
                        <?php }} ?>
                        <?php  }else{ ?>
                            <h3>No Colsed Shifts</h3>
                        <?php } ?>
                    </div>
                </div>

                <div>
                    <?php
                    $url_trade = URL."Stafftradings/getUserRequests/".$user_id.".json";
                    $response_trade = \Httpful\Request::get($url_trade)->send();
                    //echo"<pre>";print_r($response_trade);echo"</pre>";
                    if(isset($response_trade->body->tradingList) && !empty($response_trade->body->tradingList)){
                    ?>
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-bar-chart font-green-sharp hide"></i>
                                    <span class="caption-subject font-green-sharp bold uppercase">Trading Request To you</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive" style="overflow-y: scroll;max-height: 500px;">
                                    <table class="table table-trading-requests">
                                        <thead><tr> <th>Organization</th> <th>From (Branch)</th> <th>To (Branch)</th> <th>Group</th> <th>Shift</th> <th>Shift Date</th> <th>Option</th> </tr></thead>
                                        <tbody>
                                        <?php
                                            foreach($response_trade->body->tradingList as $list){
                                        ?>
                                        <tr class="removeThis">
                                            <td><?=$list->Organization->title?></td>
                                            <td><?=$list->fromBranch->title; ?></td>
                                            <td><?=$list->toBranch->title; ?></td>
                                            <td><?=$list->Group->title; ?></td>
                                            <td><?=$list->Shift->title; ?></td>
                                            <td><?php $date_trade=DateTime::createFromFormat('Y-m-d',$list->Stafftrading->shiftdate);
                                                    $date_trade=$date_trade->format('jS F Y');
                                                    echo $date_trade; ?></td>
                                            <td>
                                                <button class="btn btn-xs green acceptTradeRequest" style="margin-bottom: 5px;" trading_id="<?=$list->Stafftrading->id;?>">Accept</button> 
                                                <button class="btn btn-xs red rejectTradeRequest" trading_id="<?=$list->Stafftrading->id;?>">Reject</button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php  } ?>
                    <script>
                        jQuery(document).ready(function(){
                            jQuery('.acceptTradeRequest').click(function(){
                                var e = jQuery(this);
                                var tradeid = e.attr('trading_id');
                                jQuery.ajax({
                                   url: "<?php echo URL."Stafftradings/orgResponse/3/";?>"+tradeid+".json", 
                                    datatype:'jsonp',
                                    success:function(data){   
                                        if(data.message == 0){
                                            toastr.warning('Response not saved','Warning');
                                        }else if(data.message == 1){
                                            toastr.info('Response saved','Info');
                                        }
                                        e.closest('.removeThis').hide();
                                    } 
                                });
                            });
                            jQuery('.rejectTradeRequest').click(function(){
                                var e = jQuery(this);
                                var tradeid = e.attr('trading_id');
                                jQuery.ajax({
                                   url: "<?php echo URL."Stafftradings/orgResponse/4/";?>"+tradeid+".json",
                                    datatype:'jsonp',
                                    success:function(data){   
                                        if(data.message == 0){
                                            toastr.warning('Response not saved','Warning');
                                        }else if(data.message == 1){
                                            toastr.info('Response saved','Info');
                                        }
                                        e.closest('.removeThis').hide();
                                    } 
                                });
                            });
                        });
                    </script>
                </div>
            </div>

            <!-- 2nd column -->
            <div class="col-md-4">
                <?php 
                $OrgIds = array();
                if(isset($org_details) && !empty($org_details)){
                ?>
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green-sharp bold uppercase">Notice Board </span>
                        </div>
                        <div class="actions">
                            <a href="<?php echo URL_VIEW.'users/noticeboard';?>" class="btn btn-sm red-sunglo"> <i class="fa fa-street-view"></i> View All</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php foreach ($org_details as $organization): 
                            if ( in_array($organization->organization_id, $OrgIds)) {
                                continue;
                            }
                            
                            $OrgIds[] = $organization->organization_id;

                        ?>
                            <div class="scroller panel panel-default" style="max-height: 350px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo $organization->Organization->title; ?></h3>
                                </div>
                                <div class="panel-body">
                                    <?php $notices = $organization->Organization->Noticeboard;
                                            usort($notices, function($a1, $a2) {
                                                       $v1 = strtotime($a1->notice_date);
                                                       $v2 = strtotime($a2->notice_date);
                                                       return $v2 - $v1; // $v2 - $v1 to reverse direction
                                                    });
                                     ?>
                                    <?php if(!empty($notices)):?>
                                        <ul class="list-unstyled">
                                            <?php $i = 0;foreach ($notices as $notice):?>
                                                <?php if($notice->branch_id == 0 || in_array($notice->branch_id, $branchIds)):?>
                                                    <?php 

                                                        $datetime = explode(" ", $notice->notice_date);
                                                        $date = $datetime['0'];
                                                        $time = $datetime['1'];
                                                    ?>

                                                    <?php  $i++; 
                                                    if($i==6) 
                                                        {
                                                            break;
                                                        }
                                                    else 
                                                    {?>
                                                        <li>
                                                            <h4 class="sale-info list-group-item-heading">
                                                                <?php echo $notice->title; ?>
                                                            </h4> 
                                                            <div class="news-block-tags">
                                                                <em class="sale-info small" style="font-style:normal;clear:both"><?php echo $date; ?>,<?php echo $time; ?></em>
                                                            </div>
                                                            <p style="clear:both">
                                                                <?php 
                                                                    $notice_desc=$notice->description;
                                                                    //echo $notice_desc;
                                                                    echo substr($notice_desc,0,370);
                                                                     
                                                                 ?>
                                                            </p>
                                                            <?php
                                                                if(str_word_count($notice_desc) < 10 ){
                                                                }
                                                                else{ ?>
                                                                   <a href="#portlet-config_<?php echo $notice->id; ?>" class="news-block-btn config" data-toggle="modal"> Read more <i class="m-icon-swapright m-icon-black"></i> 
                                                                   </a>
                                                            <?php } ?>
                                                        </li>
                                                        <!--pop-up content for News board-->
                                                        <div class="modal fade" id="portlet-config_<?php echo $notice->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                        <h4 class="modal-title"><?php echo $notice->title;?></h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                         <?php echo $notice->description; ?>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn default" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end pop-up content for news board-->
                                                    <?php }?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>                                        
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div><br>                           
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php } ?>

                <div>
                    <?php if(isset($boardListIds)&& !empty($boardListIds)):
                        $url=URL."Shiftswaps/getShiftSwapRequestOfBoards/".$user_id."/".$boardListIds.".json";
                        $response= \Httpful\Request::get($url)->send();
                        $listSwapRequests = $response->body;
                        //echo "<pre>";
                        //print_r($listSwapRequests);
                    ?>
                        <div class="portlet light tasks-widget">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-share font-green-haze hide"></i>
                                    <span class="caption-subject font-green-haze bold uppercase">Shift Swap Request</span>
                                    <span class="caption-helper"></span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                                    <?php if($listSwapRequests->output->status == 1):?>
                                        <?php foreach($listSwapRequests->listSwapRequests as $swapRequest):?>
                                        <div class="media">
                                            <a href="javascript:;" class="pull-left">
                                            <img src="<?php echo URL.'webroot/files/user/image/'.$swapRequest->From_User->image_dir.'/thumb2_'.$swapRequest->From_User->image;?>" width="75" height="75">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading"><?php echo $swapRequest->Shift->title;?><span>
                                                </span>
                                                </h4>
                                                <span><?php echo $swapRequest->Board->title;?></span><br/>
                                                <span class="font-grey-cascade">
                                                    From : </span>
                                                <span class="font-blue text-capitalize"><?php echo $swapRequest->From_User->fname." ".$swapRequest->From_User->lname;?></span>
                                                
                                                <br/>
                                                <span class="font-grey-cascade">
                                                    To :</span>
                                                <span class="font-blue text-capitalize"><?php echo $swapRequest->To_User->fname." ".$swapRequest->To_User->lname;?></span>
                                                
                                            </div>
                                            <br/>
                                            <div>
                                                <button type="button" data-shiftSwapId="<?php echo $swapRequest->Shiftswap->id;?>" class="btn btn-xs btn-circle btn-default acceptShiftSwapBtn">Accept</button>
                                                <button type="button" data-shiftSwapId="<?php echo $swapRequest->Shiftswap->id;?>" class="btn btn-xs btn-circle btn-default rejectShiftSwapBtn">Reject</button>
                                            </div>
                                            <hr>
                                        </div>
                                        
                                        <?php endforeach;?>
                                    <?php else:?>
                                        <div>No swap requests.</div>
                                    <?php endif;?>
                                </div>
                                <!-- <div class="scroller-footer">
                                    <div class="btn-arrow-link pull-right">
                                        <a href="javascript:;">See All Records</a>
                                        <i class="icon-arrow-right"></i>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    <?php else:?>
                    <?php endif;?>
                </div>

                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-sharp hide"></i>
                            <span class="caption-subject font-green-sharp bold uppercase">Shifts</span>
                        </div>
                        <div class="actions">
                            <div data-toggle="a" class="btn-group btn-group-devided">
                                <a href="<?php echo URL_VIEW.'myShifts/myShifts';?>" class="btn red-sunglo">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php  
                            if ($usershifts)
                            {
                                foreach ($usershifts as $usershift) {?>
                                    <div class="news-blocks"> 
                                        <h3>
                                        <?php echo $usershift->Shift->title; ?>
                                        </h3>
                                        <div class="news-block-tags">
                                            <em><?php echo $usershift->ShiftUser->shift_date; ?></em><br>
                                            Start time : <?php echo $usershift->Shift->starttime; ?><br>
                                            End time : <?php echo $usershift->Shift->endtime; ?>
                                        </div>
                                        <p>

                                        </p>
                                    </div>
                           <?php }} else{
                        ?>
                        <h3>Shifts are not assigned</h3>
                        <?php
                            }
                        ?>
                    </div>
                </div>

                <div class="portlet light tasks-widget">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-share font-green-haze hide"></i>
                            <span class="caption-subject font-green-haze bold uppercase">Tasks</span>
                            <span class="caption-helper">tasks summary...</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="task-content tab-content">
                            <div class="tab-pane active" id="portlet_tab1">
                                <!-- START TASK LIST -->
                                <div style=" max-height:300px; overflow:scroll">
                                <ul class="task-list">
                                <?php if(!empty($tasks)){ ?>
                                <?php foreach($tasks->tasks as $task) { ?>
                                    <li class="removeli">
                                        <div class="task-checkbox">
                                            <div><span><input type="checkbox" class="liChild" value=""></span></div>
                                        </div>
                                        <div class="task-title">
                                            <span class="task-title-sp">
                                            <?php echo $task->Task->task;?>
                                             </span>
                                            <span class="label label-sm label-success">
                                            <?php 
                                                $taskdate = $task->Task->taskdate;
                                                $date1 = DateTime::createFromFormat('Y-m-d H:i:s',$taskdate);
                                                $date2=$date1->format('d M Y - h:i A');
                                                echo $date2;

                                            ?></span>
                                            <span class="task-bell">
                    
                                            </span>
                                        </div>
                                        <div class="task-config">
                                            <div class="task-config-btn btn-group">
                                                <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu pull-right" style="z-index:2;">
                                                    <!-- <form action="" method="post"> -->
                                                    <li>
                                                        <i class="fa fa-check"></i> <button class="submit_task">Complete</button>
                                                        <input type="hidden" class="id" value="<?php echo $task->Task->id;?>">
                                                    </li>
                                                    <!-- <input type="hidden" name="data[Task][status]">-->
                                                    
                                                    <!--</form> -->
                                                    <!-- <li>
                                                        <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                    </li> -->
                                                    <li>
                                                        <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Cancel </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                    <?php } else { echo 'You dont have any task schedule right Now.'; } ?>
                                </ul><br><br><br>
                                </div>
                                <!-- END START TASK LIST -->
                            </div>

                            <div class="tab-pane" id="portlet_tab2">

                                <?php include 'addTask.php';?>

                            </div>
                        </div>
                    </div>
                    <script>
                        $('.submit_task').click(function(){
                                var th=$(this);
                                var id=$(this).siblings(".id").val();                   
                        $.ajax({
                                  url: '<?php echo URL."Tasks/completeTask/";?>'+id+".json",
                                  datatype: 'jsonp',
                                  success: function( msg ) {
                                    var status = JSON.parse(msg);
                                    if(status==1){
                                        toastr.success('Your Task is removed from the list');
                                        th.parents('.removeli').hide();
                                    } else
                                        {
                                        toastr.warning('Action not completed, please try again');
                                        }

                                  }
                                });
                            });
                    </script>
                </div>

                <div>
                    <!-- Requested meetings  -->
                    <?php if($loginUserRelationToOther->boardManager || $loginUserRelationToOther->branchManager){ ?>
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-bar-chart font-green-sharp hide"></i>
                                    <span class="caption-subject font-green-sharp bold uppercase">Requested Meetings</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php     
                                $url=URL."Receivers/myReceivedRequests/".$user_id.".json"; 
                                $result=\Httpful\Request::get($url)->send();
                                //fal($result);
                                ?>
                                <div class="table-responsive" style="max-height: 500px;overflow-y: scroll;">
                                    <table class="table"  style="margin-bottom: 100px;">
                                        <!-- <thead><tr><th></th><th></th><th></th><th></th><th></th></tr></thead> -->
                                        <tbody>
                                            <?php 
                                            if(!empty($result->body->myReceivedRequests)){
                                            foreach($result->body->myReceivedRequests as $data){ ?>
                                            <tr>
                                                <td><?php echo $data->Sender->title;?></td>
                                                <td><strong><?php echo $data->Sender->Organization->title;?></strong></td>
                                                <td><?php echo ucwords($data->Sender->User->fname." ".$data->Sender->User->lname);?></td>
                                                <td><?php
                                                $date=DateTime::createFromFormat('Y-m-d',$data->Sender->requesteddate); 
                                                echo $date->format('jS F Y');?></td>
                                                <td>
                                                    <div class="task-config">
                                                        <div class="task-config-btn btn-group">
                                                            <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="javascript:;" class="btn btn-xs default">
                                                            <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                            </a>
                                                            <ul class="dropdown-menu pull-right">
                                                                <li>
                                                                    <div style="margin-bottom: 5px;text-align: center;font-size: 1.2em;color: grey;" class="col-md-12 col-sm-12 col-xs-12">
                                                                         <?php if($data->Sender->requeststatus == 0){
                                                                             echo "Not Responded";
                                                                         }elseif($data->Sender->requeststatus == 1){
                                                                             echo "Accepted";
                                                                         }elseif($data->Sender->requeststatus == 2){
                                                                             echo "Rejected";
                                                                         }?>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <button class="btn btn-xs blue col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 5px;" title="View" data-toggle="modal" data-target="#rec_request<?php echo $data->Sender->id;?>"><i class="fa fa-external-link"></i>View</button>
                                                                </li>
                                                                <li>
                                                                    <button class="btn btn-xs green req_accept_btn col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 5px;" request_id="<?php echo $data->Sender->id;?>" title="Accept"><i class="fa fa-check"></i>Accept</button>
                                                                </li>
                                                                <li>
                                                                    <button class="btn btn-xs red req_reject_btn col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 5px;" request_id="<?php echo $data->Sender->id;?>" title="Reject"><i class="fa fa-times"></i>Reject</button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div id="rec_request<?php echo $data->Sender->id;?>" class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Received Meeting Request</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="portlet box">
                                                                <div class="portlet-body">
                                                                    <div class="row static-info">
                                                                        <div class="col-md-4 name">
                                                                             Organization:
                                                                        </div>
                                                                        <div class="col-md-8 value">
                                                                             <?php echo $data->Sender->Organization->title;?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row static-info">
                                                                        <div class="col-md-4 name">
                                                                             Title:
                                                                        </div>
                                                                        <div class="col-md-8 value">
                                                                             <?php echo $data->Sender->title;?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row static-info">
                                                                        <div class="col-md-4 name">
                                                                             Description:
                                                                        </div>
                                                                        <div class="col-md-8 value">
                                                                             <?=$data->Sender->content;?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row static-info">
                                                                        <div class="col-md-4 name">
                                                                             From:
                                                                        </div>
                                                                        <div class="col-md-8 value">
                                                                             <?php echo ucwords($data->Sender->User->fname." ".$data->Sender->User->lname);?>
                                                                             <img src="<?php echo URL."webroot/files/user/image/".$data->Sender->User->image_dir."/".$data->Sender->User->image;?>" alt="pp" style="height: 30px;width: 40px;"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row static-info">
                                                                        <div class="col-md-4 name">
                                                                             Meeting Date:
                                                                        </div>
                                                                        <div class="col-md-8 value"><?php
                                                                            $date=DateTime::createFromFormat('Y-m-d',$data->Sender->requesteddate); 
                                                                            echo $date->format('jS F Y');?>
                                                                        </div>
                                                                    </div><br />
                                                                    <div class="row static-info">
                                                                        <div class="col-md-12 col-sm-12 col-xs-12 value label <?php if($data->Sender->requeststatus == 0){
                                                                                 echo "label-info";
                                                                             }elseif($data->Sender->requeststatus == 1){
                                                                                 echo "label-success";
                                                                             }elseif($data->Sender->requeststatus == 2){
                                                                                 echo "label-danger";
                                                                             }?>">
                                                                             <?php if($data->Sender->requeststatus == 0){
                                                                                 echo "Not Responded";
                                                                             }elseif($data->Sender->requeststatus == 1){
                                                                                 echo "Accepted";
                                                                             }elseif($data->Sender->requeststatus == 2){
                                                                                 echo "Rejected";
                                                                             }?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-xs green req_accept_btn" title="Accept" request_id="<?php echo $data->Sender->id;?>"><i class="fa fa-check"></i>&nbsp;Accept</button>
                                                            <button class="btn btn-xs red req_reject_btn" title="Reject" request_id="<?php echo $data->Sender->id;?>"><i class="fa fa-times">&nbsp;Reject</i></button>
                                                            <button type="button" class="btn btn-xs blue" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php }}else{ ?>
                                            <p>No Received requests</p>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function(){
                                $('.req_accept_btn').click(function(){
                                    var e=$(this);
                                    $.ajax({
                                        url: "<?php echo URL;?>Senders/respondRequest/"+e.attr('request_id')+"/1"+".json",
                                        datatype: "jsonp",
                                        success:function(data){ 
                                            if(data){
                                                if(data.message==1){
                                                    toastr.info("Accepted meeting",'Respond Status');
                                                        if (!window.location.hash) {
                                                            window.location = document.URL;
                                                        } else {
                                                            window.location.reload(true);
                                                        }
                                                }else if(data.message==0){
                                                    toastr.info("Failed to respond. Please try again latter");
                                                }
                                            }
                                        }
                                    });
                                });
                                $('.req_reject_btn').click(function(){
                                    var e=$(this);
                                    $.ajax({
                                        url: "<?php echo URL;?>Senders/respondRequest/"+e.attr('request_id')+"/2"+".json",
                                        datatype: "jsonp",
                                        success:function(data){ 
                                            if(data){
                                                if(data.message==1){
                                                    toastr.info("Rejected meeting",'Respond Status');
                                                        if (!window.location.hash) {
                                                            window.location.href = window.location.href;
                                                        } else {
                                                            window.location.reload(true);
                                                        }
                                                }else if(data.message==0){
                                                    toastr.info("Failed to respond. Please try again latter");
                                                }
                                            }
                                        }
                                    });
                                });
                            })
                        </script>
                    <?php } ?>
                    <!-- end of requested meetings -->
                </div>
            </div>

            <!-- 3rd column -->
            <div class="col-md-4">
                <div>
                    <div class="form-group form-md-line-input portlet light">
                        <div class="portlet-title">
                            <div class="caption checkInCaption" id="checkInCaptionDiv">
                                <i class="icon-calendar font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp uppercase">Check In</span>
                            </div>
                            <div style="margin-top: 10px;float: right; color:#737373;"><span class="caption-subject uppercase" id="checkInTimeDiv"></span></div>
                        </div>
                        <div class="form-group form-md-checkboxes runnshiftCheckboxes">
                            <div id="showRunningShift">No shifts Now.</div><br/>
                            <div>
                                <div class="font-blue" style="margin-bottom:5px;">Next Shift  <i class="fa fa-caret-up"></i></div>
                                <div id="showNextShift">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="portlet">
                            <div class="portlet-title" style="display:none;">
                                <div class="tools">
                                    <a href=""  class="reload totalShiftSpinner" data-original-title="" title="">
                                    </a>
                                </div>
                            </div>

                            <div class="portlet-body">
                                <div id="dasboardOrgRequestDiv" class="dashboard-stat purple-plum" style="display:none;">
                                    <div class="visual">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="details" style="padding: 25px !important;margin-right:0px;">
                                        <div class="scroller" style="height:80px;" data-always-visible="1" data-rail-visible="0">
                                        <ul class="media-list" id="organizationRequestsDiv">
                                            
                                        </ul>
                                    </div>
                                    </div>
                                    <a class="more" href="javascript:;">
                                    Organization Requests <i class="m-icon-swapright m-icon-white"></i>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="ShiftCheckListModal" role="basic" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div id="loadingForShiftChecklist" style="display:none;"><img src="<?php echo URL_VIEW;?>global/img/loading-spinner-grey.gif" alt="" class="loading">
                                <span>
                                &nbsp;&nbsp;Loading... </span></div>
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title">Shift Checklists</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="md-checkbox-list" id="shiftChecklistCheckboxes">
                                        <div class="md-checkbox">
                                            <input type="checkbox" id="checkbox30" class="md-check">
                                            <label for="checkbox30">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            Option 1 </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portlet light tasks-widget">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-share font-green-haze hide"></i>
                            <span class="caption-subject font-green-haze bold uppercase">Shift Swap Request To You</span>
                            <span class="caption-helper"></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <?php if($shiftSwapRequestToYou->output->status == 1):?>
                                <?php foreach($shiftSwapRequestToYou->listSwapRequests as $swapRequest):?>
                                <div class="media">
                                    <a href="javascript:;" class="pull-left">
                                    <img src="<?php echo URL.'webroot/files/user/image/'.$swapRequest->From_User->image_dir.'/thumb2_'.$swapRequest->From_User->image;?>" width="75" height="75">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $swapRequest->Shift->title;?><span>
                                        </span>
                                        </h4>
                                        <span><?php echo $swapRequest->Board->title;?></span><br/>
                                        <span class="font-grey-cascade">
                                            From : </span>
                                        <span class="font-blue text-capitalize"><?php echo $swapRequest->From_User->fname." ".$swapRequest->From_User->lname;?></span>
                                        
                                    </div>
                                    <br/>
                                    <br/>
                                    <div>
                                        <button type="button" data-shiftSwapId="<?php echo $swapRequest->Shiftswap->id;?>" class="btn btn-xs btn-circle btn-default acceptShiftSwapByYouBtn">Accept</button>
                                        <button type="button" data-shiftSwapId="<?php echo $swapRequest->Shiftswap->id;?>" class="btn btn-xs btn-circle btn-default rejectShiftSwapByYouBtn">Reject</button>
                                    </div>
                                    <hr>
                                </div>
                                
                                <?php endforeach;?>
                            <?php else:?>
                                <div>No swap requests.</div>
                            <?php endif;?>
                        </div>
                        <!-- <div class="scroller-footer">
                            <div class="btn-arrow-link pull-right">
                                <a href="javascript:;">See All Records</a>
                                <i class="icon-arrow-right"></i>
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-sharp hide"></i>
                            <span class="caption-subject font-green-sharp bold uppercase">Open Shift Plans</span>
                        </div>
                        <div class="actions">
                            <div data-toggle="a" class="btn-group btn-group-devided">
                                <a href="<?php echo URL_VIEW."shiftplans/showOpenPlans";?>" class="btn red-sunglo">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        if(isset($loginUserRelationToOther->userOrganization ) && !empty($loginUserRelationToOther->userOrganization)){
                            foreach($loginUserRelationToOther->userOrganization as $org_id=>$v){
                                $url8=URL."Shiftplans/getOpenPlans/".$org_id.".json"; 
                                $openShiftPlans1=\Httpful\Request::get($url8)->send();
                                $openShiftPlans2[]=$openShiftPlans1->body->openPlans;
                            }
                        }else{
                            echo "Not in any organization";
                        }
                         ?>
                            <?php  
                            if (isset($openShiftPlans2) && !empty($openShiftPlans2)) {
                            foreach ($openShiftPlans2 as $openShiftPlan) {?>
                            <?php if($openShiftPlan){?>
                            <div class="news-blocks"> 
                                <h3>
                                
                                <?php echo $openShiftPlan->Organization->title; ?>
                                </h3>
                                <div class="news-block-tags">
                                   
                                    <em>Title: <?php echo $openShiftPlan->Shiftplan->title; ?></em><br>
                                    <?php $start_date=DateTime::createFromFormat('Y-m-d',$openShiftPlan->Shiftplan->start_date);
                                     $end_date=DateTime::createFromFormat('Y-m-d',$openShiftPlan->Shiftplan->end_date);
                                     ?>
                                    Start date : <?php echo $start_date->format('jS F Y'); ?><br>
                                    End date : <?php echo $end_date->format("jS F Y"); ?>
                                </div>
                                <p>

                                </p>
                            </div>
                           
                           
                           <?php }} ?>
                      <?php  }else{ ?>
                        <h3>No open shifts</h3>
                      <?php } ?>
                    </div>
                </div>

                <div>                           
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-bar-chart font-green-sharp hide"></i>
                                <span class="caption-subject font-green-sharp bold uppercase">Request Meeting</span>
                            </div>
                            <div class="actions">
                                <div data-toggle="buttons" class="btn-group btn-group-devided">
                                    <button class="btn btn-transparent grey-salsa btn-circle btn-sm" data-toggle="modal" data-target="#new_meeting_request"><i class="fa fa-plus"></i>  New</button>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php     
                            $url = URL."Senders/mySentRequests/".$user_id.".json"; 
                            $result = \Httpful\Request::get($url)->send();
                            //fal($result);
                            ?>
                            <div class="table-responsive" style="max-height: 500px;overflow-y: scroll;">
                                <table class="table" style="margin-bottom: 40px;">
                                    <tbody>
                                    <?php 
                                    //print_r($request);
                                    if($result->body->mySentRequests){
                                    foreach($result->body->mySentRequests as $data){ ?>
                                    <tr>
                                        <td><?php echo $data->Sender->title;?></td>
                                        <td><strong><?php echo $data->Organization->title;?></strong></td>
                                        <td><?php 
                                        if(!empty($data->Receiver)){
                                        echo ucwords($data->Receiver[0]->User->fname." ".$data->Receiver[0]->User->lname);
                                        }
                                        ?></td>
                                        <td><?php
                                        $date=DateTime::createFromFormat('Y-m-d',$data->Sender->requesteddate); 
                                        echo $date->format('jS F Y');?></td>
                                        <td>
                                        <button class="btn btn-xs blue col-md-12 col-sm-12 col-xs-12" title="View" data-toggle="modal" data-target="#my_request<?php echo $data->Sender->id;?>"><i class="fa fa-external-link"></i>&nbsp;View</button>
                                            <!-- <div class="task-config">
                                            <div class="task-config-btn btn-group">
                                                <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="javascript:;" class="btn btn-xs default">
                                                <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <div style="margin-bottom: 5px;text-align: center;font-size: 1.2em;color: grey;" class="col-md-12 col-sm-12 col-xs-12">
                                                         <?php if($data->Sender->requeststatus == 0){
                                                             echo "Not Responded";
                                                         }elseif($data->Sender->requeststatus == 1){
                                                             echo "Accepted";
                                                         }elseif($data->Sender->requeststatus == 2){
                                                             echo "Rejected";
                                                         }?>
                                                    </div>
                                                </li>
                                                    <li>
                                                        <button class="btn btn-xs blue col-md-12 col-sm-12 col-xs-12" title="View" data-toggle="modal" data-target="#my_request<?php echo $data->Sender->id;?>"><i class="fa fa-external-link"></i>&nbsp;View</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div> --> 
                                        </td>
                                    </tr>
                                    <div id="my_request<?php echo $data->Sender->id;?>" class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Sent Meeting Request</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="portlet box">
                                                        <div class="portlet-body">
                                                            <div class="row static-info">
                                                                <div class="col-md-4 name">
                                                                     Organization:
                                                                </div>
                                                                <div class="col-md-8 value">
                                                                     <?php echo $data->Organization->title;?>
                                                                </div>
                                                            </div>
                                                            <div class="row static-info">
                                                                <div class="col-md-4 name">
                                                                     Title:
                                                                </div>
                                                                <div class="col-md-8 value">
                                                                     <?php echo $data->Sender->title;?>
                                                                </div>
                                                            </div>
                                                            <div class="row static-info">
                                                                <div class="col-md-4 name">
                                                                     Description:
                                                                </div>
                                                                <div class="col-md-8 value">
                                                                     <?=$data->Sender->content;?>
                                                                </div>
                                                            </div>
                                                            <div class="row static-info">
                                                                <div class="col-md-4 name">
                                                                     To:
                                                                </div>
                                                                <?php if(!empty($data->Receiver)){ ?>


                                                                <div class="col-md-8 value">
                                                                     <?php  echo ucwords($data->Receiver[0]->User->fname." ".$data->Receiver[0]->User->lname);?>
                                                                     <img src="<?php echo URL."webroot/files/user/image/".$data->Receiver[0]->User->image_dir."/".$data->Receiver[0]->User->image;?>" alt="pp" style="height: 30px;width: 40px;"/>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="row static-info">
                                                                <div class="col-md-4 name">
                                                                     Meeting Date:
                                                                </div>
                                                                <div class="col-md-8 value"><?php
                                                                    $date=DateTime::createFromFormat('Y-m-d',$data->Sender->requesteddate); 
                                                                    echo $date->format('jS F Y');?>
                                                                </div>
                                                            </div><br />
                                                            <div class="row static-info">
                                                                <div class="col-md-12 col-sm-12 col-xs-12 value label <?php if($data->Message->requeststatus == 0){
                                                                         echo "label-info";
                                                                     }elseif($data->Sender->requeststatus == 1){
                                                                         echo "label-success";
                                                                     }elseif($data->Sender->requeststatus == 2){
                                                                         echo "label-danger";
                                                                     }?>">
                                                                     <?php if($data->Sender->requeststatus == 0){
                                                                         echo "Not Responded";
                                                                     }elseif($data->Sender->requeststatus == 1){
                                                                         echo "Accepted";
                                                                     }elseif($data->Sender->requeststatus == 2){
                                                                         echo "Rejected";
                                                                     }?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php }}else{ ?>
                                    <p>No sent requests</p>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="new_meeting_request" class="modal fade "  tabindex="-1" role="dialog">
                        <div class="modal-dialog " role="document" >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Request for meeting</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post">
                                        <input type="hidden" name="data[Sender][status]" value="3"/>
                                        <input type="hidden" name="data[Sender][user_id]" value="<?php echo $user_id;?>"/>
                                        <label for="data[Message][requesteddate]">Meeting Date</label>
                                        <div class="input-group input-medium date date-pickerxy" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                            <input type="text" name="data[Sender][requesteddate]" class="form-control" readonly=""/>
                                            <span class="input-group-btn">
                                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div><br>

                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <select class="form-control edited" id="form_control_org_name" name="data[Sender][organization_id]">
                                                                    
                                                <?php
                                                    if($loginUserRelationToOther->userOrganization){
                                                        foreach($loginUserRelationToOther->userOrganization as $k=>$v){
                                                            foreach($v as $k1=>$v1){
                                                                echo "<option value='".$k."'>".$k1."</option>";
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <label for="form_control_1">Organization</label>
                                        </div>
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <select class="form-control edited" id="form_control_select_type">
                                                <option value="1">Department</option>
                                                <option value="2">Branch</option>
                                            </select>
                                            <label for="form_control_select_type">Select Manager From</label>
                                        </div>
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <select class="form-control edited" id="form_control_value">

                                            </select>
                                            <label for="form_control_3" id="name_req_lvl">Select Department</label>
                                        </div>
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <select class="form-control edited" id="form_control_manager_list" name="data[Receiver][user_id]">

                                            </select>
                                            <label for="form_control_3">Manager</label>
                                        </div>
                                        
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <input type="text" class="form-control" name="data[Sender][title]"/>
                                            <label for="form_control_1">Title</label>
                                        </div>
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <textarea class="form-control" rows="3" name="data[Sender][content]"></textarea>
                                            <label for="form_control_1">Description</label>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="saveMeetingRequest">Save</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function(){
                            $('#form_control_select_type').change(function(){
                                if($('#form_control_select_type').val()==1){
                                    var type="Select Board";
                                    getBoard();
                                }else{
                                    var type="Select Branch";
                                    getBranch();
                                }
                                $('#name_req_lvl').html(type);
                            });
                            function getBoard(){
                                var orgnid=$("#form_control_org_name").val();
                                        $.ajax({
                                            url: "<?php echo URL_VIEW."process.php";?>",
                                            data: "action=getOrgProfile&orgid="+orgnid,
                                            type: "post",
                                            success:function(data){
                                                var data1 = "";
                                                var allbrd=JSON.parse(data).Board;  
                        var brd=<?php if($loginUserRelationToOther->board){
                                $data=array();
                                foreach($loginUserRelationToOther->board as $k=>$v){
                                    $data[$k]=$v;
                                }
                           echo json_encode($data); 
                        }
                        ?>;                 
                                                $.each(brd,function(k1,obj1){
                                                    $.each(allbrd, function(k,obj){
                                                        if(k1 == obj.id){
                                                            data1+="<option value='"+obj.id+"'>"+obj.title+"</option>";
                                                        }
                                                    });   
                                                });

                                                $("#form_control_value").html(data1);
                                                getmanager();
                                            }
                                        });
                            }
                            function getBranch(){
                                var orgnid=$("#form_control_org_name").val();
                                        $.ajax({
                                            url: "<?php echo URL_VIEW."process.php";?>",
                                            data: "action=getOrgProfile&orgid="+orgnid,
                                            type: "post",
                                            success:function(data){
                                                var data1 = "";
                                                var allbr=JSON.parse(data);  
                                                
                         var br=<?php if($loginUserRelationToOther->userOrganization){
                            $data=array();
                            foreach($loginUserRelationToOther->userOrganization as $k1=>$v1){
                                if($v1){
                                    foreach($v1 as $k2=>$v2){
                                        if($v2){
                                            foreach($v2 as $k3=>$v3){
                                                $data[$k3]=$v3;
                                            }
                                        }
                                    }
                                } 
                            }                         
                            echo json_encode($data);
                        } ?>;
                                                $.each(br,function(k1,v1){
                                                    $.each(allbr.Branch , function(k,obj){
                                                        if(k1 == obj.id){
                                                            data1 += "<option value=" + obj.id + ">" + obj.title + "</option>";
                                                        }
                                                    });
                                                });
                                                $("#form_control_value").html(data1);
                                                getmanager();
                                            }
                                        });
                            }
                            function getmanager(){
                                if($('#form_control_select_type').val()==1){
                                    $.ajax({
                                            url: "<?php echo URL;?>Boards/viewBoard/"+$('#form_control_value').val()+".json",
                                            datatype: "jsonp",
                                            success:function(data){
                                                var data1 = "";
                                                 // console.log(data);
                                                if(data.board.length != 0){
                                                    if(data.board.User.fname == ""){
                                                        data1 = "<option value=" + data.board.User.id + ">" + data.board.User.email + "</option>";
                                                    }else if(data.board.User.fname != null){
                                                        data1 = "<option value=" + data.board.User.id + ">" + data.board.User.fname+" "+data.board.User.lname + "</option>";
                                                    }
                                                }
                                                $("#form_control_manager_list").html(data1);
                                            }
                                        });
                                }else{
                                    $.ajax({
                                            url: "<?php echo URL;?>Branches/viewBranch/"+$('#form_control_value').val()+".json",
                                            datatype: "jsonp",
                                            success:function(data){
                                                var data1 = ""; 
                                                // console.log(data);
                                                if(data.branch.length != 0){
                                                    if(data.branch.User.fname == ""){
                                                        data1 = "<option value=" + data.branch.User.id + ">" + data.branch.User.email + "</option>";
                                                    }else if(data.branch.User.fname != null){
                                                        data1 = "<option value=" + data.branch.User.id + ">" + data.branch.User.fname+" "+data.branch.User.lname + "</option>";
                                                    }
                                                }                    
                                                $("#form_control_manager_list").html(data1);
                                            }
                                        });
                                }
                            }
                            
                            getBoard();
                            $("#form_control_org_name").change(function(){
                                if($('#form_control_select_type').val()==1){
                                    getBoard();
                                }else{
                                    getBranch();
                                }
                            });
                            $('#form_control_value').change(function(){
                               getmanager();
                            });
                        });
                    </script>
                    <script>
                         $(document).ready(function(){
                           var datePicker = $('.date-pickerxy').datepicker({
                            autoclose: true,
                           }); 
                           
                           $('.selectManager').select2();
                        });
                    </script>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <!-- BEGIN PORTLET-->
            <?php /*?><div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bubble font-red-sunglo"></i>
                        <span class="caption-subject font-red-sunglo bold uppercase">Chats</span>
                    </div>
                    <div class="actions">
                        <div class="portlet-input input-inline">
                            <div class="input-icon right">
                                <i class="icon-magnifier"></i>
                                <input type="text" class="form-control input-circle" placeholder="search...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet-body" id="chats">
                    <div class="scroller" style="height: 341px;" data-always-visible="1" data-rail-visible1="1">
                        <ul class="chats">
                            <li class="in">
                                <img class="avatar" alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar1.jpg"/>
                                <div class="message">
                                    <span class="arrow">
                                    </span>
                                    <a href="javascript:;" class="name">
                                    Bob Nilson </a>
                                    <span class="datetime">
                                    at 20:09 </span>
                                    <span class="body">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar2.jpg"/>
                                <div class="message">
                                    <span class="arrow">
                                    </span>
                                    <a href="javascript:;" class="name">
                                    Lisa Wong </a>
                                    <span class="datetime">
                                    at 20:11 </span>
                                    <span class="body">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="in">
                                <img class="avatar" alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar1.jpg"/>
                                <div class="message">
                                    <span class="arrow">
                                    </span>
                                    <a href="javascript:;" class="name">
                                    Bob Nilson </a>
                                    <span class="datetime">
                                    at 20:30 </span>
                                    <span class="body">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar3.jpg"/>
                                <div class="message">
                                    <span class="arrow">
                                    </span>
                                    <a href="javascript:;" class="name">
                                    Richard Doe </a>
                                    <span class="datetime">
                                    at 20:33 </span>
                                    <span class="body">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="in">
                                <img class="avatar" alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar3.jpg"/>
                                <div class="message">
                                    <span class="arrow">
                                    </span>
                                    <a href="javascript:;" class="name">
                                    Richard Doe </a>
                                    <span class="datetime">
                                    at 20:35 </span>
                                    <span class="body">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar1.jpg"/>
                                <div class="message">
                                    <span class="arrow">
                                    </span>
                                    <a href="javascript:;" class="name">
                                    Bob Nilson </a>
                                    <span class="datetime">
                                    at 20:40 </span>
                                    <span class="body">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="in">
                                <img class="avatar" alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar3.jpg"/>
                                <div class="message">
                                    <span class="arrow">
                                    </span>
                                    <a href="javascript:;" class="name">
                                    Richard Doe </a>
                                    <span class="datetime">
                                    at 20:40 </span>
                                    <span class="body">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar1.jpg"/>
                                <div class="message">
                                    <span class="arrow">
                                    </span>
                                    <a href="javascript:;" class="name">
                                    Bob Nilson </a>
                                    <span class="datetime">
                                    at 20:54 </span>
                                    <span class="body">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. sed diam nonummy nibh euismod tincidunt ut laoreet. </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="chat-form">
                        <div class="input-cont">
                            <input class="form-control" type="text" placeholder="Type a message here..."/>
                        </div>
                        <div class="btn-cont">
                            <span class="arrow">
                            </span>
                            <a href="" class="btn blue icn-only">
                            <i class="fa fa-check icon-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div><?php */?>
            <!-- END PORTLET-->
        </div>

        <div class="clearfix">
        </div>
    </div>
</div>

<div class="modal fade" id="addshiftexpanse" tabindex="-1" role="dialog"    aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                      <h4 class="modal-title">Add Shift Expenses</h4>
                  </div>
                  <form class="form-horizontal" id="shiftexpenses" action=""  method="post"  accept-charset="utf-8" enctype="multipart/form-data">
                                           
                        <div class="modal-body">
                              
                             
                                
                                <div class="form-group">
                                    <div class="row">
                                        <label class="control-label col-md-4">Title<span class="required">
                                        * </span>
                                        </label>
                                        <div class="col-md-7">
                                            <input class="form-control" id="inputExpensesTitle" name="data[Employeeshiftexpense][title]" value=""  required="required"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="control-label col-md-4">Cost<span class="required">
                                        * </span>
                                        </label>
                                        <div class="col-md-7">
                                            <input class="form-control" id="inputExpensesCost" name="data[Employeeshiftexpense][price]" value=""  required="required"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label  class="control-label col-md-4" row="3">Description<span class="required">
                                        * </span>
                                        </label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="data[Employeeshiftexpense][description]" value=""  type="text"  required="required"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label  class="control-label col-md-4" row="3">Supporting Image<span class="required">
                                        </span>
                                        </label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="expenseSupportingImage"  type="file" style="height: 100%;"/>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden"  name="data[Employeeshiftexpense][status]" value="1">
                                <input type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>" name="data[Employeeshiftexpense][expense_on_date]">
                              
                                
                                                                  
                        </div>
                        <div class="modal-footer">

                            <div class="col-md-offset-3 col-md-9">
                                <input type="submit" name="submitExpense" value="Submit" class="btn green">
                                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                </form>
                </div>                          
                  
             </div>
              <!-- /.modal-content -->
</div>


<div class="modal fade" id="portlet-33" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Your Shift Expenses List</h4>
            </div>
            <div class="modal-body">
                <div class="table-scrollable table-scrollable-borderless">
                    <table id="shiftExpensesModal" class="table table-hover table-light">
                        <thead>
                            <tr class="uppercase">
                                <th>
                                     Expenses
                                </th>
                                <th>
                                     Cost
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($shiftuserexpenses->shiftuserexpenses) && !empty($shiftuserexpenses->shiftuserexpenses)):?>
                                <?php foreach($shiftuserexpenses->shiftuserexpenses as $employeeshiftexpense):?> 
                                    <tr>
                                        <td>
                                            <a href="javascript:;" class="primary-link"><?php echo $employeeshiftexpense->Employeeshiftexpense->title;?></a>
                                        </td>
                                        <td>
                                             $ <?php echo $employeeshiftexpense->Employeeshiftexpense->price;?>
                                        </td>
                                    </tr>
                                <?php endforeach ;?>
                            <?php endif; ?>
                                <tr>
                                    <td>
                                        <a href="javascript:;" class="green">Total</a>
                                    </td>
                                    <td>
                                         $ <?php echo  $totalUserShiftAmount->totalUserShiftAmount;?>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php else:?>

    <div class="row" style="min-height:400px;">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs font-green-sharp hide"></i>
                        <span class="caption-subject uppercase">Welcome to Shiftmate <span class="font-green-sharp"><?php echo $userName; ?></span></span>
                    </div>
                </div>
                <div class="portlet-body">
                    <!-- <h4 class="block">Custom Content</h4> -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="list-group">
                                <a href="javascript:;" class="list-group-item active">
                                <h4 class="list-group-item-heading">Learning</h4>
                                <p class="list-group-item-text">
                                    You'll be getting notification from organization till then you can tour our system. Thank you. 
                                </p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <?php if(isset($loginUserRelationToOther->userOrganization) && empty($loginUserRelationToOther->userOrganization)):?>
                             <!-- Organization requests. -->
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <h3>Organization Requests</h3>
                                <div class="portlet">
                                    <div class="portlet-title" style="display:none;">
                                                <div class="tools">
                                                    <a href=""  class="reload totalShiftSpinner" data-original-title="" title="">
                                                    </a>
                                                </div>
                                    </div>

                                    <div class="portlet-body">
                                        <div class="dashboard-stat purple-plum">
                                            <div class="visual">
                                                <i class="fa fa-globe"></i>
                                            </div>
                                            <div class="details" style="padding: 25px !important;margin-right:0px;">
                                                <div class="scroller" style="height:80px;" data-always-visible="1" data-rail-visible="0">
                                                <ul class="media-list" id="organizationRequestsDiv">
                                                    
                                                </ul>
                                            </div>
                                            </div>
                                            <a class="more" href="javascript:;">
                                            Organization Requests <i class="m-icon-swapright m-icon-white"></i>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>

<!-- *****************************************Ashok Senpai******************************************* -->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-knob/js/jquery.knob.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-knob-dials.js"></script>
<script type="text/javascript">

    $(function()
        {
var currenttime = '<?php date_default_timezone_set("Asia/Kathmandu"); $todayTimeZone = date("F d, Y H:i:s", time()); echo $todayTimeZone;?>';
var serverdate=new Date(currenttime);
function padlength(what){
    var output=(what.toString().length==1)? "0"+what : what;
    return output;
}
function displaytime(){
    serverdate.setSeconds(serverdate.getSeconds()+1);
    var timestring = padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+ ":" + padlength(serverdate.getSeconds());
    $("#checkInTimeDiv").html(timestring);
    // console.log(timestring);
    // return timestring;
}
setInterval(function()
    {
        displaytime();
    }, 1000);

$("#addshiftexpanse").click(function(event)
    {
        $("#showExpenseDivList").show();
    });

            $(".shiftCheckIn").live('click',checkIn);

            //setTimeout(function(){alert('aa')}, 1000*2);

            function checkIn()
            {
                var e = $(this);
                    var checkInCaption = $(".checkInCaption");

                    // console.log(checkInCaption);
                    var userId = '<?php echo $user_id;?>';
                    var shiftId =  e.closest(".md-checkbox-list").find(".box").attr('id');

                    $.ajax(
                        {
                            url:'<?php echo URL_VIEW."process.php";?>',
                            data:'action=shiftCheckIn&userId='+userId+'&shiftUserId='+shiftId,
                            type:'POST',
                            success:function(response)
                            {

                                if(response=='1')
                                {

                                    toastr.success("Welcome");
                                    e.closest('.md-checkbox').removeClass('has-success').addClass('has-error');

                                    checkInCaption.html("");

                                    var data = '<i class="icon-calendar font-red-sharp"></i><span class="caption-subject font-red-sharp uppercase">Check Out</span>';
                                    checkInCaption.html(data);
                                    e.removeClass('shiftCheckIn').addClass('shiftCheckOut');
                                    e.attr('data-checkStatus', 1);
                                    $(".addshiftexpanseBtn").show();
                                    // $(".expensesListDiv").show();
                                    var expenseDiv = '<hr>'+
                             '<div class="expensesListDiv">'+
                                '<a href="#addshiftexpanse" class="news-block-btn btn btn-xs blue" data-toggle="modal" style="float:right;"><i class="fa fa-plus" ></i> Add Expenses </a>'+
                                '<div id="showExpenseDivList" style="display:none;">'+
                                    '<p><strong>Expenses list</strong></p>'+
                                    '<table class="expensesListUl">'+
                                    '</table>'+
                                    '<hr>'+
                                    '<span class="totalExpensesCost"><strong>Total Expenses</strong>&nbsp :$<i></i></span><br/>'+
                                    '</div>'+
                                    '<a href="#portlet-33"  data-toggle="modal" id="shiftExpDetailBtn" data-shiftUserId="'+shiftId+'">View Details</a>'+
                                    '<div style="padding-top:15px;border-bottom:1px solid #eee;margin-bottom:10px;"></div>'+
                                    '</div>';
                                    $("#shiftCheckList").show();
                                    $("#runningShiftNote").show();

                                    $("#showRunningShift").append(expenseDiv);

                                }
                                else
                                {
                                    toastr.error("Error checking in.");
                                }
                            }
                        });
            }

            $(".shiftCheckOut").live('click', checkOut);

            function checkOut(event)
            {
                var e = $(this);
                e.prop("disabled", true);
                var checkInCaption = $(".checkInCaption");
                var userId = '<?php echo $user_id;?>';
                var shiftId =  e.closest(".md-checkbox-list").find(".box").attr('id');
                $.ajax(
                    {
                        url:'<?php echo URL_VIEW."process.php";?>',
                        data:'action=shiftCheckOut&shiftUserId='+shiftId+'&userId='+userId,
                        type:'POST',
                        success:function(html)
                        {
                            var dataHtml = JSON.parse(html);

                            if(typeof html !="undefined")
                            {
                                toastr.success("You've Checked out.");

                                checkInCaption.html("");

                                var data = '<i class="icon-calendar font-green-sharp"></i><span class="caption-subject font-green-sharp uppercase">Check In</span>';
                                checkInCaption.html(data);

                                var checkInBox = e.closest('.md-checkbox-list');
                                
                                var addExpBtn = '<a href="#addshiftexpanse" class="addshiftexpanseBtn news-block-btn btn btn-xs blue" data-toggle="modal"  style="float:right;display:none;"><i class="fa fa-plus" ></i> Add Expenses </a>';
                                checkInBox.html("");
                                checkInBox.html(dataHtml.now);
                                $("#upcommingShiftDiv").html("").html(dataHtml.next);
                                checkInBox.append(addExpBtn);

                                var checkInClick = checkInBox.find(".shiftCheckIn");

                                checkInClick.bind('click', checkIn);

                                $(".expensesListDiv").hide();
                            }
                            else
                            {
                                toastr.error("Error checking out.");
                            }
                        }
                    });
            }

            $(".acceptShiftSwapBtn").on('click', function(event)
                {
                    var e = $(this);
                    var shiftSwapId = e.attr('data-shiftSwapId');

                    var block = e.closest('.media');

                    $.ajax(
                        {
                            url:'<?php echo URL."Shiftswaps/acceptSwapRequestByManager/"."'+shiftSwapId+'".".json";?>',
                            type:'post', 
                            datatype:'jsonp',
                            success:function(response)
                            {
                                var output = response.output;

                                if(output.status ==1)
                                {
                                    toastr.success(output.error);
                                    block.fadeOut('2000').remove();
                                }
                                else
                                {
                                    toastr.error(output.error);
                                }
                            }
                        });
                });

            $(".rejectShiftSwapBtn").on('click', function(event)
                {
                    var e = $(this);
                    var shiftSwapId = e.attr('data-shiftSwapId');

                    var block = e.closest('.media');

                    $.ajax(
                        {
                            url:'<?php echo URL."Shiftswaps/rejectSwapRequestByManager/"."'+shiftSwapId+'".".json";?>',
                            type:'post', 
                            datatype:'jsonp',
                            success:function(response)
                            {
                                var output = response.output;

                                if(output.status ==1)
                                {
                                    toastr.success(output.error);
                                    block.fadeOut('2000').remove();
                                }
                                else
                                {
                                    toastr.error(output.error);
                                }
                            }
                        }); 
                });

            $(".acceptShiftSwapByYouBtn").on('click',function(event)
                {
                    var e = $(this);
                    var shiftSwapId = e.attr('data-shiftSwapId');

                    var block = e.closest('.media');

                    $.ajax(
                        {
                            url:'<?php echo URL."Shiftswaps/acceptSwapRequest/"."'+shiftSwapId+'".".json";?>',
                            type:'post', 
                            datatype:'jsonp',
                            success:function(response)
                            {
                                var output = response.output;

                                if(output.status ==1)
                                {
                                    toastr.success(output.error);
                                    block.fadeOut('2000').remove();
                                }
                                else
                                {
                                    toastr.error(output.error);
                                }
                            }
                        });
                });

                
                $(".rejectShiftSwapByYouBtn").on('click',function(event)
                {
                    var e = $(this);
                    var shiftSwapId = e.attr('data-shiftSwapId');

                    var block = e.closest('.media');

                    $.ajax(
                        {
                            url:'<?php echo URL."Shiftswaps/rejectSwapRequest/"."'+shiftSwapId+'".".json";?>',
                            type:'post', 
                            datatype:'jsonp',
                            success:function(response)
                            {
                                var output = response.output;

                                if(output.status ==1)
                                {
                                    toastr.success(output.error);
                                    block.fadeOut('2000').remove();
                                }
                                else
                                {
                                    toastr.error(output.error);
                                }
                            }
                        });
                });



                $("#shiftexpenses").on('submit', function(event)
                    {
                        event.preventDefault();// to stop form submit from controller
                        var e = $(this);
                        var data = e.serialize();
                        
                        var shiftUserId = $("body .runnshiftCheckboxes").find('.box').attr('id');

                        var url = '<?php echo URL."Employeeshiftexpenses/add/"."'+shiftUserId+'".".json";?>';

                        var title = e.find("#inputExpensesTitle").val();
                        var cost  = e.find("#inputExpensesCost").val();
                        $('.expensesListDiv').show();
                        var expensesListUl = $(".expensesListUl");
                        $.ajax(
                            {
                                url:url,
                                data:new FormData(this),
                                type:'post',
                                datatype:'jsonp',
                                contentType: false,
                                processData: false,
                                cache: false,
                                success:function(response)
                                {                                    
                                    var status = response.output.status;
                                    if(status == 1)
                                    {
                                        toastr.success('saved');
                                        $( '#shiftexpenses' ).each(function(){
                                            this.reset();
                                        });
                                        var list = '<tr><td>'+title+':&nbsp;&nbsp;<span class="pull-right">&#36;</span></td><td class="expensesCostSum">'+cost+'</td></tr>';
                                        expensesListUl.append(list);

                                        var expCosts = $(".expensesCostSum");
                                        var totalCost =0;

                                        $.each(expCosts, function(key, value)
                                        {
                                            totalCost+=parseFloat($(value).html());   
                                        });

                                        $(".totalExpensesCost > i").html(totalCost);
                                        // console.log(totalCost);


                                    }else{
                                        toastr.error('try again.');
                                    }
                                }
                            });
                    });
        });
</script>
<script src="<?php echo URL_VIEW;?>global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>                   
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo URL_VIEW; ?>global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

<script type="text/javascript" src="<?php echo URL_VIEW;?>js/getRunningShift.js"></script>

<script>
jQuery(document).ready(function(){
   ComponentsKnobDials.init();
});

</script>

<script>

jQuery(document).ready(function() {       
 TableManaged.init();
 ComponentsPickers.init();
var userId = '<?php echo $userId;?>';
var urlApi = '<?php echo URL;?>';

setInterval(function()
    {
        var checkInBox = $("#checkbox9").attr('data-shiftUserId');

        if(typeof checkInBox !== "undefined")
        {
            // console.log(checkInBox);
            if($("#checkbox9").attr('data-checkStatus') ==1)
            {
                var nowTime = $("#checkInTimeDiv").html();
                var eTime = $("#checkbox9").attr("data-shiftendtime");
                if(nowTime >= eTime)
                {
                    $("#checkbox9").click();
                }
            }
        }else{
                getRunningShift(urlApi,userId);
        }
    }, 1000);

 // clickexp
$("#shiftExpDetailBtn").live('click', function(event)
    {
        var e = $(this);
        var shiftUserId = e.attr('data-shiftUserId');

        var url = '<?php echo URL;?>Employeeshiftexpenses/viewUserShiftById/'+shiftUserId+'.json';

        $.ajax(
            {
                url:url,
                type:'post',
                datatype:'jsonp',
                success:function(res)
                {
                    // console.log(res.shiftuserexpenses);

                    var tr = "";
                    if (res.shiftuserexpenses[0] != null)
                    {

                        $.each(res.shiftuserexpenses, function(k,v)
                            {
                                tr+= '<tr>'+
                                '<td>'+v.Employeeshiftexpense.title+
                                '</td>'+
                                '<td>'+
                                '$ '+v.Employeeshiftexpense.price+
                                '</td>'+
                                '</tr>';
                            });
                    }

                    var total = res.shiftExpenseTotal;

                    tr+= '<tr>'+
                    '<td>'+
                    '<a href="javascript:;" class="bold theme-font">Total</a>'+
                    '</td>'+
                    '<td class="bold theme-font">'+
                    '$ '+total+
                    '</td>'+
                    '</tr>';

                    $("#portlet-33").find('#shiftExpensesModal').find('tbody').html("").html(tr);
                    
                }
            });
    });
 $('#dashboard-report-range').daterangepicker({format:'YYYY-MM-DD'});

 $('.applyBtn').attr('type',"submit");
 $('.applyBtn').attr('name',"dateRangeDashboard");

    $(".applyBtn").on('click', function(event)
    {
        var d = $('.daterangepicker_start_input').find('input').val();
        var e = $('.daterangepicker_end_input').find('input').val();
        var res =  converter(d) + ' - ' + converter(e);
        
        $(".visible-lg-inline-block").html(res);
        //$(".lb").html(e);

        var userRelation = JSON.parse('<?php echo json_encode($loginUserRelationToOther->userOrganization);?>');
        // console.log(userRelation);
        var totalShift=0;
        var totalWorking=0;
        var overTimeDashboard=0;

        $.each(userRelation, function(i,v)
            {
                var userId = '<?php echo $user_id;?>';
                var url2= '<?php echo URL."ShiftUsers/getDashboardTotalWork/"."'+userId+'"."/"."'+i+'"."/"."'+d+'"."/"."'+e+'".".json";?>';
   

                $.ajax(
                    {
                        url:url2,
                        type:'post',
                        datatype:'jsonp',
                        success:function(response)
                        {
                            // console.log(response);
                            $('.totalShiftSpinner').click();
                            // console.log(response);

                             totalShift = totalShift + response.totalShiftCount;
                            $("#statsTotalshift").html(totalShift);

                            var hms = response.totalWorkinHour;

                            // console.log(hms);
                            var a = hms.split(':');
                            var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 

                            // totalShift = totalShift + response.totalShiftCount;
                            totalWorking = totalWorking + seconds;


                           var statsTotalworkingTime = secondsToHms(totalWorking);

                           $("#statsTotalworking").html(statsTotalworkingTime);
                            // overTimeDashboard = overTimeDashboard + response.totalOverTime;

                             // console.log(totalWorking);

                            

                            var hmss = response.totalOverTime;   // your input string
                            var a = hmss.split(':'); // split it at the colons

                            var over = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
                            // $("#statsOvertime").html(overTimeDashboard);
                            overTimeDashboard = overTimeDashboard + over;

                            var statsOverTotalworkingTime = secondsToHms(overTimeDashboard);

                             $("#statsOvertime").html(statsOverTotalworkingTime);

                        }
                    });

                             // console.log(toHis('19563'));



            });
    
    });


$("#shiftCheckList").live('click', onClickshiftCheckList);


// bickyraj
    var userId = '<?php echo $userId;?>';
    var organizationRequestListArr = [];
    function checkOrganizationRequests(userId)
    {
        var url = '<?php echo URL;?>OrganizationUsers/getOrganizationRequests/'+userId+'.json';
        $.ajax(
            {
                url:url,
                type:'post',
                datatype:'jonsp',
                success:function(res)
                {
                    if(res.status ==1)
                    {
                        $("#dasboardOrgRequestDiv").show();
                        var list = res.list;
                        // console.log(list);
                        var data="";

                        $.each(list, function(k,v)
                            {
                                var orgid = v.Organization.id;

                                if($.inArray(orgid, organizationRequestListArr)=== -1)
                                {

                                    organizationRequestListArr.push(orgid);

                                        data+= '<li class="media">'+
                                        '<a class="pull-left" href="javascript:;">'+
                                        '<img class="media-object" src="<?php echo URL;?>webroot/files/organization/logo/'+v.Organization.logo_dir+'/thumb_'+v.Organization.logo+'" alt="64x64" style="width: 50px; height:50px;">'+
                                        '</a>'+
                                        '<div class="media-body">'+
                                        '<h4 class="media-heading" style="color: white;">'+v.Organization.title+'</h4>'+
                                        '<div class="media-heading-sub">'+
                                        '<button class="btn btn-circle green btn-xs organizationConfirm" data-organizationuserId="'+v.OrganizationUser.id+'">Confirm</button>'+
                                        '</div>'+
                                        '</div>'+
                                        '</li>';
                                        
                                }
                            });

                        $("#organizationRequestsDiv").prepend(data);

                        // $('[data-toggle="confirmation"]').confirmation();
                    }else
                    {
                        $("#dasboardOrgRequestDiv").hide();
                    }
                }
            });
    }

    setInterval(function(event)
        {
            checkOrganizationRequests(userId);
        }, 1000);

    
});

$("#runningShiftNote").live('click', function(event)
    {
        var e = $(this);
        var shiftId = e.attr('data-shiftid');
        var url = '<?php echo URL;?>Shiftnotes/viewShiftnotes/'+shiftId+'.json';

        $.ajax(
            {
                url:url,
                type:'post',
                dataType:'jsonp',
                async:false,
                success:function(res)
                {
                    // console.log(res);
                    var notes;
                    if(res.status == 1)
                    {
                        notes = res.notes.Shiftnote.notes;
                    }
                    else
                    {
                        notes = "No notes for this shift.";
                    }
                    bootbox.dialog({
                                      title: "Notes",
                                      message: notes,
                                      buttons: {
                                        success: {
                                          label: "Close",
                                          className: "btn-default",
                                          callback: function() {
                                          }
                                        }
                                      }
                                    });
                }
            });
    });

function onClickshiftCheckList()
{
    var e = $(this);
    var userId = '<?php echo $user_id;?>';
    var shiftId = e.attr("data-shiftId");
    var shiftDate = e.attr("data-shiftDate");
    var shiftUserId = e.attr("data-shfitUserId");
    // console.log(shiftUserId);

    $("#loadingForShiftChecklist").show();
    // alert(shiftCheckListId);
    var url1 = '<?php echo URL;?>Shiftchecklists/listShiftChecklists/'+shiftId+'/'+shiftDate+'/'+userId+'/'+shiftUserId+'.json';
                        $.ajax({
                                url: url1,
                                type:'post',
                                datatype:'jsonp',
                                success: function(response)
                                {
                                    $("#loadingForShiftChecklist").hide();
                                    if(response.output.status ==1)
                                    {
                                        // console.log(response);

                                        var data="";
                                        
                                        $.each(response.listShiftChecklist, function(i,v)
                                            {
                                                // console.log(i);
                                                var disabled = v.status==1 ? 'disabled':'';
                                                var checked = v.status==1 ? 'checked':'';
                                                data+= '<div class="md-checkbox">'+
                                                            '<input type="checkbox" data-shiftUserId="'+shiftUserId+'" data-userid="'+'<?php echo $user_id;?>'+'" data-checklistid="'+v.id+'" id="checkbox_'+v.id+'" class="md-check tickChecklist"'+disabled+' '+checked+'>'+
                                                            '<label for="checkbox_'+v.id+'">'+
                                                            '<span></span>'+
                                                            '<span class="check"></span>'+
                                                            '<span class="box"></span>'+v.checklistdetail+
                                                            '</label>'+
                                                        '</div>';

                                            });
                                        $("#shiftChecklistCheckboxes").html(data);
                                        $('#ShiftCheckListModal').modal('show');
                                        $(".tickChecklist").bind('click', tickChecklist);
                                    }
                                    else
                                    {
                                        data = '<div>No checklists.</div>';
                                        $("#shiftChecklistCheckboxes").html(data);
                                        $('#ShiftCheckListModal').modal('show');
                                    }
                                }
                              });
                        

}

$(".organizationConfirm").live('click',organizationConfirm);
function organizationConfirm(event)
{
    var e = $(this);

    var orgUserId = e.attr('data-organizationuserId');

    url = '<?php echo URL;?>OrganizationUsers/activateUser/'+orgUserId+'.json';

    $.ajax(
        {
            url:url,
            type:'post',
            datatype:'jsonp',
            success:function(res)
            {
                if(res.output ==1)
                {
                    location.href = '<?php echo URL_VIEW;?>';
                }
            }
        });
}

// $(".tickChecklist").on('click', tickChecklist);

  function tickChecklist()
  {
    var e = $(this);
    var userid = e.attr('data-userid');
    var checklist = e.attr('data-checklistid');
    var shiftUserId = e.attr('data-shiftuserid');

    var data= {UserChecklist:{user_id:userid, checklist_id:checklist, status:1, shiftUser_id:shiftUserId}};
    var url = '<?php echo URL;?>UserChecklists/addUserCheckList.json';

    $.ajax(
        {
            url:url,
            data:data,
            type:'post',
            datatype:'jsonp',
            success:function(response)
            {
                if(response.output.status ==1)
                {
                    e.prop('disabled', true);
                }
            }
        });
  }
    function secondsToHms(d) {
        d = Number(d);
        var h = Math.floor(d / 3600);
        var m = Math.floor(d % 3600 / 60);
        var s = Math.floor(d % 3600 % 60);
        return ((h > 0 ? h + ":" + (m < 10 ? "0" : "") : "") + m + ":" + (s < 10 ? "0" : "") + s); }


    function converter(s) {

         var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
          s =  s.replace(/-/g, '/');
          var d = new Date(s);

          

          return  months[d.getMonth()] + ' ' + d.getDate() + ' , ' + d.getFullYear();
        }

    //console.log(converter('2013-03-10'));    

</script>

 <script>
 //    $(document).ready(function(){    
 //        var userRelation = <?php echo json_encode($loginUserRelationToOther);?>;
 //        $(".orgn").change(function(){
 //            var e=$(this);
 //            loadBrdNBrnch(e); 
 //            loadBoardUser12(e.val(),$(".brd").val()); 
 //        });
        
 //        function loadBrdNBrnch(e){
 //            if(e.val() != 0){
 //                $.ajax({
 //                url:"<?php echo URL;?>"+"Boards/listBoards/"+e.val()+".json",
 //                datatype:"jsonp",
 //                success:function(data){
 //                    data1="<option value='0'>All Departments</option>";
 //                    //console.log(userRelation);
 //                    $.each(userRelation['board'],function(k4,v4){
 //                        $.each(data['boards'],function(k,v){
 //                            if(k4==v['Board']['id']){
 //                                data1+="<option value='"+v['Board']['id']+"'>"+v['Board']['title']+"</option>";
 //                            }
 //                        });
 //                    });
 //                    $(".brd").html(data1);
 //                }
 //            });
 //            $.ajax({
 //                url:"<?php echo URL;?>"+"Branches/BranchesList/"+e.val()+".json",
 //                datatype:"jsonp",
 //                success:function(data){
 //                    data2="<option value='0'>All Branches</option>";
 //                    $.each(userRelation['userOrganization'],function(k1,v1){
 //                        $.each(v1,function(k2,v2){
 //                            $.each(v2,function(k3,v3){
 //                                $.each(data['branches'],function(k,v){
 //                                    if(k3 == k){
 //                                        data2+="<option value='"+k+"'>"+v+"</option>";
 //                                    } 
 //                                });
 //                            });
 //                        });
 //                    });
 //                    $(".brnch").html(data2);
 //                }
 //            });
 //            }else{
 //                $(".brd").html("<option value='0'>All Departments</option>");
 //                $(".brnch").html("<option value='0'>All Branches</option>");
 //            }
 //        }

 //         $(".brnch").change(function(){
 //            var f=$(this);
 //            if(f.val() != 0){
 //                $.ajax({
 //                    url:"<?php echo URL;?>"+"Boards/getBoardListOfBranch/"+f.val()+".json",
 //                    datatype:"jsonp",
 //                    success:function(data){
 //                        //console.log(data);
 //                        data3="<option value='0'>All Departments</option>";
 //                        $.each(userRelation['board'],function(k5,v5){
 //                            $.each(data['boardList'],function(k6,v6){
 //                                if(k5==v6['Board']['id']){
 //                                    data3+="<option value='"+v6['Board']['id']+"'>"+v6['Board']['title']+"</option>";
 //                                }
 //                            });
 //                        });
 //                        $(".brd").html(data3);
 //                        loadBoardUser12($(".orgn").val(),$(".brd").val()); 
 //                    }
 //                });
 //            }else{
 //                loadBrdNBrnch($(".orgn").val());
 //                loadBoardUser12($(".orgn").val(),$(".brd").val()); 
 //            }
 //         }); 
            
 //         $(".brd").change(function(){
 //            var g=$(this);
 //            loadBoardUser12($(".orgn").val(),g.val());    
 //         });
         
 // loadBoardUser12($(".orgn").val(),$(".brd").val());  
 //        function loadBoardUser12(orgn,brd){
 //            // alert(orgn+' '+brd);
 //            var shiftboard=[];
 //            if(orgn == "0"){
 //                if(userRelation['userOrganization'] && userRelation['userOrganization'] != null){
 //                    $.each(userRelation['userOrganization'],function(k,v){
 //                        $.ajax({
 //                            url:"<?php echo URL."ShiftBoards/openShifts/";?>"+k+".json",
 //                            datatype:"jsonp",
 //                            async:false,
 //                            success:function(data){
 //                                if(data['openShifts'] != null){
 //                                   shiftboard.push(data['openShifts']); 
 //                                }
 //                            }
 //                        });
 //                        if(userRelation['board'] && userRelation['board'] != null)
 //                        $.each(userRelation['board'],function(k1,v1){
 //                            $.ajax({
 //                               url:"<?php echo URL."ShiftBoards/closedShifts/".$user_id."/";?>"+k+"/"+k1+".json",
 //                               datatype:"jsonp",
 //                               async:false,
 //                               success:function(data){
 //                                    if(data['closedShifts'] != null){
 //                                       shiftboard.push(data['closedShifts']); 
 //                                    }
 //                               } 
 //                            });
 //                        });
 //                    });
 //                    //console.log(shiftboard.shift());
 //                }
 //            }else{
 //                if(brd == "0"){
 //                    $.ajax({
 //                        url:"<?php echo URL."ShiftBoards/openShifts/";?>"+orgn+".json",
 //                        datatype:"jsonp",
 //                        async:false,
 //                        success:function(data){
 //                            if(data['openShifts'] != null){
 //                                shiftboard.push(data['openShifts']);
 //                            }
 //                        }
 //                    });
 //                    $.each(userRelation['board'],function(k1,v1){
 //                        $.ajax({
 //                               url:"<?php echo URL."ShiftBoards/closedShifts/".$user_id."/";?>"+orgn+"/"+k1+".json",
 //                               datatype:"jsonp",
 //                               async:false,
 //                               success:function(data){
 //                                if(data['closedShifts'] != null){
 //                                    shiftboard.push(data['closedShifts']);
 //                                }
 //                               } 
 //                            });
 //                    });
 //                }else{
 //                     $.ajax({
 //                        url:"<?php echo URL."ShiftBoards/openShifts/";?>"+orgn+".json",
 //                        datatype:"jsonp",
 //                        async:false,
 //                        success:function(data){
 //                            if(data['openShifts'] != null){
 //                                shiftboard.push(data['openShifts']);
 //                            }
 //                        }
 //                    });
 //                    $.ajax({
 //                       url:"<?php echo URL."ShiftBoards/closedShifts/".$user_id."/";?>"+orgn+"/"+brd+".json",
 //                       datatype:"jsonp",
 //                       async:false,
 //                       success:function(data){
 //                            if(data['closedShifts'] != null){
 //                                shiftboard.push(data['closedShifts']);
 //                            }
 //                       } 
 //                    });
 //                }
 //            }
 //            datax="<blockquote><small>There are no shifts scheduled for today till now.</small></blockquote>";
 //            datay="";
 //            $.each(shiftboard,function(ky,vy){
 //                //console.log(shiftboard);
 //                if(vy.length !=0 ){
 //                    datax="<thead><tr class='uppercase'><th>Shift</th><th>Organization</th><th>Time</th><th>No.of Employer</th><th>Option</th></tr></thead><tbody>";
 //                    $.each(vy,function(kx,vx){
 //                        dataz="";
 //                        var count=0;
 //                        console.log(vx);
 //                        if(vx["Shift"]["ShiftUser"].length != 0){
 //                        $.each(vx["Shift"]["ShiftUser"],function(k1,v1){
 //                            dataz += "<div class='row'><div class='col-md-2 col-sm-2 col-xs-3'><img class='img-responsive' style='height:50px;width:100px;' src='<?php echo URL."webroot/files/user/image/";?>"+v1['User']['image_dir']+"/"+v1['User']['image']+"'/></div><div class='col-md-4 col-sm-4 col-xs-4'><strong>"+v1['User']['fname']+" "+v1['User']['lname']+"</strong></div></div><hr/>";
 //                            count++;
 //                        });
 //                        }
                    
 //                    var t1 = ''+vx["Shift"]["starttime"]+'';
 //                    var t2 = ''+vx["Shift"]["endtime"]+'';
 //                    var s1 = t1.split(':');
 //                    var s2 = t2.split(':');
 //                    if(s1[0] < 12){
 //                        time3 = parseInt(s1[0])+":"+s1[1]+" AM";
 //                    } else if(s1[0] == 12) {
 //                        time3 = parseInt(s1[0])+":"+s1[1]+" PM";
 //                    } else {
 //                        time3 = (parseInt(s1[0]) - 12)+":"+s1[1]+" PM";
 //                    }

 //                    if(s2[0] < 12){
 //                        time4 = parseInt(s2[0])+":"+s2[1]+" AM";
 //                    } else if(s2[0] == 12) {
 //                        time4 = parseInt(s2[0])+":"+s2[1]+" PM";
 //                    } else {
 //                        time4 = (parseInt(s2[0]) - 12)+":"+s2[1]+" PM"; 
 //                    }


 //                        // var time1 = new Date("2015-05-31T"+vx["Shift"]["starttime"]);
 //                        // var time2 = new Date("2015-05-31T"+vx["Shift"]["endtime"]);
 //                        // console.log(time1.format('h:MM:ss').toLocaleString());
 //                        // console.log(time1.getHours());
                        
 //                        // if(time1.getHours() < 12){

 //                        //     time3 = time1.getHours()+":"+time1.getMinutes()+" AM";
 //                        // }else{
 //                        //     time3 = (time1.getHours() - 12)+":"+time1.getMinutes()+" PM";
 //                        // }   
 //                        // if(time2.getHours() < 12){
 //                        //     time4 = time2.getHours()+":"+time2.getMinutes()+" AM";
 //                        // }else{
 //                        //     time4 = (time2.getHours() - 12)+":"+time2.getMinutes()+" PM";
 //                        // }
                        
                                         
 //                        datax += "<tr><td>"+vx["Shift"]["title"]+"</td><td>"+vx["Board"]["Organization"]["title"]+"</td><td>"+time3+" - to - "+time4+"</td><td>"+count+"</td><td>"+'<button type="button" data-toggle="modal" class="btn btn-sm btn-default" data-target="#employer_'+vx["ShiftBoard"]["id"]+'">View</button>'+"</td>";
 //                        datay+='<div class="modal fade" id="employer_'+vx["ShiftBoard"]["id"]+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+
 //                                        '<div class="modal-dialog" role="document">'+
 //                                           '<div class="modal-content">'+
 //                                            '<div class="modal-header">'+
 //                                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
 //                                            '<h4 class="modal-title" id="myModalLabel">Shift Users</h4>'+
 //                                          '</div>'+
 //                                          '<div class="modal-body">'+dataz+
 //                                        '</div>'+
 //                                        '<div class="modal-footer">'+
 //                                        '<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>'+
 //                                      '</div>'+
 //                                        '</div>'+
 //                                      '</div>'+
 //                                    '</div>';
 //                    });
 //                }
 //            });
 //            datax += "</body>";
 //            $("#sample_today_shift").html(datax);
 //            $("#modals_of_today_shift").html(datay);
 //         }
 //        });
 </script>
<script src="<?php echo URL_VIEW; ?>js/date-format/date.format.js" type="text/javascript"></script>
