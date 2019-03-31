<?php 

    if(isset($_POST['boardformSubmit']))
    {
            
            $url6= URL."ShiftUsers/getByDateBoard.json";
            $response6 = \Httpful\Request::post($url6)
                    ->sendsJson()
                    ->body($_POST['data'])
                    ->send();

            $response6=$response6->body;

            if($response6->status =='0')
            {
                echo "<script> toastr.warning('No Valid Data.');</script>";
            }

    }


    if(isset($_POST['submit1']))
    {
          //echo "<pre>";print_r($_POST);die();

            $url7= URL."ShiftUsers/getByDateBoard.json";
            $response = \Httpful\Request::post($url7)
                    ->sendsJson()
                    ->body($_POST['data'])
                    ->send();
            $response7=$response->body;


            if($response7->status =='0')
            {
                echo "<script> toastr.warning('No Valid Data .');</script>";
            }

            else{

                $response7=$response->body;

            }

}


 
    $url= URL."Boards/listBoards/".$orgId.".json";
    $response = \Httpful\Request::get($url)->send();
    $boardList = $response->body->boards;
    // echo "<pre>";print_r($boardList);die();

    $url11= URL."OrganizationUsers/getOrganizationUsers/".$orgId.".json";
    $response11 = \Httpful\Request::get($url11)->send();
    
    $response11=$response11->body;
    
   /* echo "<pre>";
    print_r($response11);
    die();*/

    $url1 = URL."ShiftUsers/getOrganizationCount.json";
    $response1 = \Httpful\Request::get($url1)->send();
    $number = $response1->body->number;

    $url2= URL."ShiftUsers/getOrganizationTotal/".$orgId.".json";
    $response2 = \Httpful\Request::get($url2)->send();
    $totalWorkinHour = $response2->body->output;

    // fal($totalWorkinHour);

 ?>


<link href="<?php echo URL_VIEW;?>admin/pages/css/profile.css" rel="stylesheet" type="text/css"/>

<!-- BEGIN PAGE HEADER-->

<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Shift History</h1>
		</div>  
     </div>
     </div>
     <div class="page-content">
        <div class="container">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo URL_VIEW; ?>">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="<?=URL_VIEW."shifthistories/organizationShiftHistory";?>">Organization Shift History</a>
                </li>
            </ul>
<!-- END PAGE HEADER-->
                   
<div class="row">
    <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
        <div class="portlet">
            <div class="portlet-title tabbable-line">

                <ul class="nav nav-tabs" id="myTabs">
                
                                      
                    <?php
                    $count=0;
                     foreach( $boardList as $board):                                       
                    $count++;

                    ?><li >
                      <a  href="#tab_9_<?php echo $board->Board->id;?>" data-toggle="tab" style="color:black;">
                      <?php  echo  $board->Board->title; ?></a>

                    </li>

                    <?php endforeach; ?>
                    

                    <li class="active">
                        <a  href="#tab_9_def" data-toggle="tab" style="color:black;">
                        All Details</a>
                    </li>
                </ul>       

            </div>
        </div>



        <div class="portlet-body">
                                <!--BEGIN TABS-->
                <div class="tab-content">

                        <?php
                                $count=0;
                                /*echo "<pre>";
                                print_r($board);
                                die();*/

                                // fal($boardList);
                                foreach ($boardList as $board):

                                    $boardid = $board->Board->id;


                                    if(isset($response6) && $response6->status=='1' && $response6->boardId == $boardid)
                                    {

                                        $worksDetails = $response6->output;
                                    }
                                    else
                                    {
                                        $url10= URL."ShiftUsers/getOrganizationUsersWorkHistory/".$orgId."/".$boardid.".json";
                                        $response10 = \Httpful\Request::get($url10)->send();

                                        if(isset($response10->body->output) && !empty($response10->body->output))
                                        {

                                        $worksDetails = $response10->body->output;
                                        }
                                    }

                                    
                                    $url4= URL."ShiftUsers/organizationBoardShiftCalculation/".$boardid.".json";
                                    $response4 = \Httpful\Request::get($url4)->send();

                                    $numberBoard = $response4->body;
                                   


                                    $url5= URL."ShiftUsers/getBoardOrganizationTotal/".$boardid.".json";
                                    $response5 = \Httpful\Request::get($url5)->send();

                                    $totalBoardWorkingHour = $response5->body;

                                  

                                // echo "<pre>";print_r($totalBoardWorkingHour);die();
                        ?>


                            <div class="tab-pane <?php if($count==1){echo 'active';}?>" id="tab_9_<?php echo $board->Board->id;?>">
                                <div class="portlet"  data-always-visible="1" data-rail-visible="0">

                                    <!-- Form for Date Start -->
                                    <form role="form" method="post" action="">
                                        <div class="form-group" stlye="float:right;">
                                        <input type="hidden" value="0" name="data[ShiftUser][organization_id]" />
                                        <input type="hidden" value="<?php echo $board->Board->id;?>" name="data[ShiftUser][board_id]" />
                                                 <label>Date Range</label>
                                                 <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"  data-date-format="yyyy-mm-dd">
                                                    <input type="text" class="form-control" name="data[ShiftUser][start_date]" required />
                                                    <span class="input-group-addon">
                                                    to </span>
                                                    <input type="text" class="form-control" name="data[ShiftUser][end_date]" required />
                                                 </div> <span ></span>
                                        </div>
                                            
                                        <div class="form-actions">
                                            <input type="submit" class="btn blue"  value="Submit" name="boardformSubmit">
                                            
                                        </div>
                                    </form> 

                                    <br/>           
                                    <br/>    

                               
                                    <!--  Form for Date Start -->
                                    <ul class="feeds accordion task-list scrollable" id="accordion2">
                                       
                                            <div class="portlet light">

                                                <div class="row list-separated profile-stat" >
                                                    <div class="col-md-3 ">
                                                        <div class="uppercase profile-stat-title">
                                                             <?php echo $numberBoard->number->noOfShifts;?> 
                                                        </div>
                                                        <div class="uppercase profile-stat-text">
                                                             Total no Shifts
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 ">
                                                        <div class="uppercase profile-stat-title">
                                                             <?php echo $numberBoard->number->presentPercent."%";?> 
                                                        </div>
                                                        <div class="uppercase profile-stat-text">
                                                             Present Percentage
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 ">
                                                        <div class="uppercase profile-stat-title">
                                                             <?php echo $numberBoard->number->absentPercent."%";?> 
                                                        </div>
                                                        <div class="uppercase profile-stat-text">
                                                             Absent Percentage
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-md-3 ">
                                                        <div class="profile-stat-title" style="font-size:18px;">
                                                            
                                                            <?php
                                                                $init = $totalBoardWorkingHour->output;
                                                                $hours = floor($init / 3600);
                                                                $minutes = floor(($init / 60) % 60);
                                                                $seconds = $init % 60;

                                                                echo $hours."Hrs ".$minutes."mins ".$seconds."sec ";

                                                                ?>
                                                        </div>
                                                        <div class="uppercase profile-stat-text">
                                                            Total Working Hours
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END STAT -->
                                            </div>  

                                        <div class="portlet grey-cascade box">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-cogs"></i>Individual Shift History
                                                </div>
                                                
                                            </div>
                                            <div class="portlet-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered table-striped">
                                                        <thead>
                                                            <tr>

                                                                    <th>
                                                                    Users Id
                                                                    </th> 
                                                                     <th>
                                                                         Name of Users
                                                                    </th>
                                                                                                                                   
                                                                    <th>
                                                                          Late Checkin
                                                                    </th>
                                                                    <th>
                                                                         Early Checkout 
                                                                    </th>
                                                                    <th>
                                                                        Late Checkout
                                                                    </th>
                                                                    <th>
                                                                        Total Late Checkin Hours 
                                                                    </th>
                                                                    <th>
                                                                        Total Less To full Work Hours 
                                                                    </th>
                                                                    <th>
                                                                        Total OverTime Hours 
                                                                    </th>
                                                                                                                               
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                       
                                                            <?php if(isset($worksDetails) && !empty($worksDetails)):?>
                                                            <?php foreach ($worksDetails as $worksDetail):?>        
                                                                <tr>
                                                                    <td>
                                                                    <?php echo $worksDetail->UserDetail->id;?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="label label-sm label-success">
                                                                        <?php echo $worksDetail->UserDetail->fname.' '.$worksDetail->UserDetail->lname;?>
                                                                    </span></td>
                                                                                                                                    
                                                                    <td>
                                                                         <?php echo $worksDetail->workDetail->totalNoOfLateCheckIn; ?>
                                                                    </td>
                                                                    <td>
                                                                         <?php echo $worksDetail->workDetail->earlyCheckOut; ?>
                                                                    </td>
                                                                    <td>
                                                                         <?php echo $worksDetail->workDetail->lateCheck; ?>
                                                                    </td>
                                                                    <td>
                                                                          <?php
                                                                        $init =$worksDetail->workDetailInHour->totalLateCheckInTime;
                                                                        $hours = floor($init / 3600);
                                                                        $minutes = floor(($init / 60) % 60);
                                                                        $seconds = $init % 60;

                                                                        echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $init =$worksDetail->workDetailInHour->totalLessToFullWorkTime;
                                                                        $hours = floor($init / 3600);
                                                                        $minutes = floor(($init / 60) % 60);
                                                                        $seconds = $init % 60;

                                                                        echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

                                                                        ?>
                                                                    </td>

                                                                     <td>
                                                                        <?php
                                                                        $init =$worksDetail->workDetailInHour->totalOverTimeWorking;
                                                                        $hours = floor($init / 3600);
                                                                        $minutes = floor(($init / 60) % 60);
                                                                        $seconds = $init % 60;

                                                                        echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                            <?php else:?>
                                                                <tr>No Data.</tr>
                                                            <?php endif;?>                                                  
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </ul>

                                
                                </div>
                            </div>



                        <?php endforeach;?>

                        <?php 
                                    if(isset($response7) && $response7->organization_id == $orgId)
                                    {
                                        $worksDetails = $response7->output;
                                        $numberOrg = $response7->orgPercenHistory;

                                        /*echo "<pre>";
                                        print_r($response7);
                                        die();*/
                                        $totalWorkinHour = $response7->getOrganizationTotal;
                                    }
                                    else
                                    {
                                        $url10= URL."ShiftUsers/getOrganizationUsersWorkHistory/".$orgId.".json";
                                        $response10 = \Httpful\Request::get($url10)->send();

                                        if(isset($response10->body->output) && !empty($response10->body->output))
                                        {

                                            $worksDetails = $response10->body->output;
                                        }

                                        $url3= URL."ShiftUsers/organizationShiftCalculation/".$orgId.".json";
                                        $response3 = \Httpful\Request::get($url3)->send();
                                        $numberOrg = $response3->body->number;


                                    }


                                          


                            ?>
                        <div class="tab-pane active" id="tab_9_def">
                                <div class="portlet"  data-always-visible="1" data-rail-visible="0">

                                    <!-- Form for Date Start -->
                                    <form role="form" method="post" action="">
                                        <div class="form-group" stlye="float:right;">
                                        
                                             <label>Date Range</label>
                                             <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"  data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control" name="data[ShiftUser][start_date]" required />
                                                <span class="input-group-addon">
                                                to </span>
                                                <input type="text" class="form-control" name="data[ShiftUser][end_date]" required />
                                             </div> 
                                             <input type="hidden" value="<?php echo $orgId;?>" name="data[ShiftUser][organization_id]" />
                                             <input type="hidden" value="0" name="data[ShiftUser][board_id]" />
                                        </div>
                                            
                                        <div class="form-actions">
                                            <input type="submit" class="btn blue"  value="Submit" name="submit1">
                                            
                                        </div>
                                    </form> 

                                    <br/>           
                                    <br/>           
                                    <!--  Form for Date Start -->
                                    <ul class="feeds accordion task-list scrollable" id="accordion2">
                                                
                                        <div class="portlet light">

                                     

                                                        <!-- STAT -->
                                                <div class="row list-separated profile-stat" >
                                                    <div class="col-md-3 ">
                                                        <div class="uppercase profile-stat-title">
                                                             <?php echo $numberOrg->noOfShifts;?> 
                                                        </div>
                                                        <div class="uppercase profile-stat-text">
                                                             Total Shifts
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 ">
                                                        <div class="uppercase profile-stat-title">
                                                             <?php echo $numberOrg->presentPercent."%";?> 
                                                        </div>
                                                        <div class="uppercase profile-stat-text">
                                                             Present Percentage
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 ">
                                                        <div class="uppercase profile-stat-title">
                                                             <?php echo $numberOrg->absentPercent."%";?> 
                                                        </div>
                                                        <div class="uppercase profile-stat-text">
                                                             Absent Percentage
                                                        </div>
                                                    </div>
                                                   <!--  <div class="col-md-3 ">
                                                        <div class="uppercase profile-stat-title">
                                                             <?php echo $number->absent;?> 
                                                        </div>
                                                        <div class="uppercase profile-stat-text">
                                                             Absent Users Shifts
                                                        </div>
                                                    </div> -->
                                                    <div class="col-md-3 ">
                                                        <div class="profile-stat-title" style="font-size:18px;">
                                                            
                                                            <?php
                                                                $init = $totalWorkinHour;
                                                                $hours = floor($init / 3600);
                                                                $minutes = floor(($init / 60) % 60);
                                                                $seconds = $init % 60;

                                                                echo $hours."Hrs ".$minutes."mins ".$seconds."sec ";

                                                                ?>
                                                        </div>
                                                        <div class="uppercase profile-stat-text">
                                                            Total Working Hours
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END STAT -->
                                            </div>   

                                        <div class="portlet grey-cascade box">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-cogs"></i>Individual Shift History
                                                </div>
                                                
                                            </div>
                                            <div class="portlet-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered table-striped">
                                                        <thead>
                                                            <tr>

                                                                    <th>
                                                                    Users Id
                                                                    </th> 
                                                                     <th>
                                                                         Name of Users
                                                                    </th>
                                                                    <th>
                                                                          Late Checkin
                                                                    </th>
                                                                    <th>
                                                                         Early Checkout 
                                                                    </th>
                                                                    <th>
                                                                        Late Checkout
                                                                    </th>
                                                                    <th>
                                                                        Total Late Checkin Hours 
                                                                    </th>
                                                                    <th>
                                                                        Total Less To full Work Hours 
                                                                    </th>
                                                                    <th>
                                                                        Total OverTime Hours 
                                                                    </th>
                                                                                                                               
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                       
                                                        <?php if(isset($worksDetails) && !empty($worksDetails)):?>
                                                            <?php foreach ($worksDetails as $worksDetail):?>        
                                                                <tr>
                                                                    <td>
                                                                    <?php echo $worksDetail->UserDetail->id;?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="label label-sm label-success">
                                                                        <?php echo $worksDetail->UserDetail->fname.' '.$worksDetail->UserDetail->lname;?>
                                                                    </span></td>
                                                                    
                                                                    <td>
                                                                         <?php echo $worksDetail->workDetail->totalNoOfLateCheckIn; ?>
                                                                    </td>
                                                                    <td>
                                                                         <?php echo $worksDetail->workDetail->earlyCheckOut; ?>
                                                                    </td>
                                                                    <td>
                                                                         <?php echo $worksDetail->workDetail->lateCheck; ?>
                                                                    </td>
                                                                    <td>
                                                                          <?php
                                                                        $init =$worksDetail->workDetailInHour->totalLateCheckInTime;
                                                                        $hours = floor($init / 3600);
                                                                        $minutes = floor(($init / 60) % 60);
                                                                        $seconds = $init % 60;

                                                                        echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $init =$worksDetail->workDetailInHour->totalLessToFullWorkTime;
                                                                        $hours = floor($init / 3600);
                                                                        $minutes = floor(($init / 60) % 60);
                                                                        $seconds = $init % 60;

                                                                        echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

                                                                        ?>
                                                                    </td>

                                                                     <td>
                                                                        <?php
                                                                        $init =$worksDetail->workDetailInHour->totalOverTimeWorking;
                                                                        $hours = floor($init / 3600);
                                                                        $minutes = floor(($init / 60) % 60);
                                                                        $seconds = $init % 60;

                                                                        echo $hours."hrs ".$minutes."mins ".$seconds."sec ";

                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else:?>
                                                            <tr>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>
                                                        <?php endif;?>                                                       
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                </div>
        </div>
    </div>

<div class="col-md-6 col-sm-6">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-bar-chart font-green-sharp hide"></i>
                                <span class="caption-subject font-green-sharp bold uppercase">Site Visits</span>
                                <span class="caption-helper">weekly stats...</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                    <input type="radio" name="options" class="toggle" id="option1">New</label>
                                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm">
                                    <input type="radio" name="options" class="toggle" id="option2">Returning</label>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="site_statistics_loading">
                                <img src="../../assets/admin/layout/img/loading.gif" alt="loading"/>
                            </div>
                            <div id="site_statistics_content" class="display-none">
                                <div id="site_statistics" class="chart">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET-->
</div>
</div>



<!-- Graphs............................ -->



                



<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script>

$(".date-picker").datepicker();

jQuery(document).ready(function() {       
 TableManaged.init();
 ComponentsPickers.init();
});
</script>

<script>
    $('#myTabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('#myTabs a[href="' + hash + '"]').tab('show');
</script>

