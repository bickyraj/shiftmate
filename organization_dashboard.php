
<link href="<?php echo URL_VIEW;?>admin/pages/css/news.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

<script>
jQuery(document).ready(function() {       
 TableManaged.init();
 $('#dashboard-report-range').daterangepicker({ format: 'YYYY-MM-DD'});
 $(".applyBtn").on('click', function(event)
    {
        var d = $('.daterangepicker_start_input').find('input').val();
        var e = $('.daterangepicker_end_input').find('input').val();
        var res =  converter(d) + ' - ' + converter(e);
        $(".visible-lg-inline-block").html(res);
        var orgId = '<?php echo $orgId;?>';
        var urli = '<?php echo  URL."ShiftUsers/getOrganizationDashboardTotal/"."'+orgId+'"."/"."'+d+'"."/"."'+e+'".".json";?>';
            // alert(url);
        $.ajax(
            {
                url:urli,
                type:'post',
                datatype:'jsonp',
                async:false,
                success:function(response)
                {
                    // console.log(orgTotalworkTime);
                    $('.totalShiftSpinner').click();
                    var StatsTotalShifts = response.totalOrganizationShifts;
                    var StatsTotalWork = response.totalWorkinHour;
                    var StatsTotalOvertime = response.totalOverTime;

                    $("#StatsTotalShifts").html(StatsTotalShifts);
                    // $("#StatsTotalWork").html(StatsTotalWork);
                    // $("#StatsTotalOvertime").html(StatsTotalOvertime);
                },
                error:function()
                {
                    alert('error');
                }
            });

        var url = '<?php echo URL;?>Accounts/getTotalWorkingAndOvertime/'+orgId+'/'+d+'/'+e+'.json';
        $.ajax(
            {
                url:url,
                type:'post',
                dataType:'jsonp',
                async:false,
                success:function(res)
                {
                    if(res.status ==1 )
                    {
                        // console.log(res);
                        if(res.total[0][0].workedhours != null)
                        {
                            $("#StatsTotalWork").html(parseFloat(res.total[0][0].workedhours).toFixed(2));
                        }
                        if(res.total[0][0].morehours != null)
                        {
                            $("#StatsTotalOvertime").html(parseFloat(res.total[0][0].morehours).toFixed(2));
                        }
                    }
                }
            });
        
        // $("#dateRangeStartDate").val(d);
        // $("#dateRangeEndDate").val(e);
        // $("#dateRangeFrmSubmit").click();

    });
  ComponentsPickers.init();
});


    function converter(s) {

          var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
          s =  s.replace(/-/g, '/');
          var d = new Date(s);

          return  months[d.getMonth()] + ' ' + d.getDate() + ' , ' + d.getFullYear();
        }
</script> 
<?php

date_default_timezone_set('Asia/Kathmandu');

	$url = URL."Users/Notices/".$user_id.".json";
	$org = \Httpful\Request::get($url)->send();
	$org_details = $org->body->output['0']->OrganizationUser;

    $url = URL."ShiftUsers/listOfCheckedInUsers/".$orgId.".json";
    $response = \Httpful\Request::get($url)->send();
    $shiftUsers = $response->body->shiftUsers;


// function getStandardDate($dateTime)
// {
//     $startTime = new DateTime($dateTime);
//     return $startTime->format('l \, jS F Y \, g:i A');
// }
// notices api
$url = URL."Noticeboards/getOrganizationNotice/".$orgId.".json";
$response = \Httpful\Request::get($url)->send();

if(isset($response->body->notices) && !empty($response->body->notices))
{

    $notices = $response->body->notices;
}

?>

<?php
//Edited By Manohar Khadka
$url = URL."Tasks/listTask/".$user_id.".json";
$data = \Httpful\Request::get($url)->send();
$tasks = $data->body->tasks;

$url = URL."ShiftUsers/todaysShiftForOrg/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$todaysShift = $data->body;
?>
<!-- ******************************** Ashok Neupane  ****************************** -->
<?php
    $url = URL."ShiftUsers/usersRequests/".$orgId.".json";
    $response = \Httpful\Request::get($url)->send();
    $UsersRequests = $response->body->allRequests;


$url_branches = URL."Branches/listBranchesName/".$orgId.".json";
$response_branches = \Httpful\Request::get($url_branches)->send();
$branches = $response_branches->body->branches;

$url = URL."Accounts/getTotalWorkingAndOvertime/".$orgId.".json";
$response = \Httpful\Request::get($url)->send();
$TotalWorkingAndOvertime = $response->body->total;

// fal($TotalWorkingAndOvertime);


?>

<!-- ******************************************************************************* -->

<?php
           if(isset($_POST['dateRangeFrmSubmit'])){

             // echo "<pre>";print_r($_POST);die();

                $url= URL."ShiftUsers/getOrganizationDashboardTotal/".$orgId."/".$_POST['startDate']."/".$_POST['endDate'].".json";
                
                }
                else
                { 
                  $url= URL."ShiftUsers/getOrganizationDashboardTotal/".$orgId.".json";
                  
                }
                      
                        $response = \Httpful\Request::get($url)->send();
                        $totalShiftDetails = $response->body;                       
                        /*echo "<pre>";
                        print_r($totalShiftDetails);
                        die();*/
?>
<!-- ******************************************************************************* -->
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
            background: url(images/dropdown.png) no-repeat top 14px right 7px !important;
        }
        .view-board option {
            color:#666;
        }
</style>
      
<!--<div class="page-content">-->
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Modal title</h4>
                        </div>
                        <div class="modal-body">
                             Widget settings form goes here
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn blue">Save changes</button>
                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <!-- BEGIN STYLE CUSTOMIZER -->
           
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Organisation Dashboard</h1>
			</div>  
         </div>
         </div>
         <div class="page-content">
            <div class="container">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="#">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                </ul>
<!-- ****************************Senpai************************************* -->

                <form id="dateRangeFrm" action="" method="post">
                        <input id="dateRangeStartDate" type="hidden" name="startDate">
                        <input id="dateRangeEndDate" type="hidden" name="endDate">
                        <input id="dateRangeFrmSubmit" type="submit" name="dateRangeFrmSubmit" hidden>     

                </form>
                <div class="page-toolbar">
                    <form action="" method="post">
                        <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm btn-default" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
                            <i class="icon-calendar"></i>&nbsp; <span class="thin uppercase visible-lg-inline-block"></span>&nbsp; <i class="fa fa-angle-down"></i>
                        </div>
                    </form>

                </div>
 <!-- **************************************************************************** -->
            <div class="row margin-bottom-10">
            </div>
            <!-- END PAGE HEADER-->
             <!-- BEGIN DASHBOARD STATS -->
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
                                    <div id="StatsTotalShifts" class="number">
                                         <?php echo $totalShiftDetails->totalOrganizationShifts; ?>
                                    </div>
                                    <div class="desc">
                                         Total Shifts
                                    </div>
                                </div>
                                <a class="more" href="<?php echo URL_VIEW;?>shifts/listShifts?org_id=<?php echo $orgId;?>">
                                View more <i class="m-icon-swapright m-icon-white"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
                                    <div id="StatsTotalWork" class="number">
                                  
                                          <?php echo round($TotalWorkingAndOvertime[0][0]->workedhours, 2); ?>
                                    </div>
                                    <div class="desc">
                                         Total Working Hours
                                    </div>
                                </div>
                                    <a class="more" href="<?php echo URL_VIEW;?>shifthistories/organizationShiftHistory">
                                    View more <i class="m-icon-swapright m-icon-white"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                </div>


                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
                                <div id="StatsTotalOvertime" class="number">
                                    <?php echo round($TotalWorkingAndOvertime[0][0]->morehours, 2); ?>
                                </div>
                                <div class="desc">
                                     Total Overtime
                                </div>
                            </div>
                                <a class="more" href="<?php echo URL_VIEW;?>shifthistories/organizationShiftHistory">
                                View more <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
                                 <div class="details">
                                    <div class="number">
                                         +89%
                                    </div>
                                    <div class="desc">
                                         Brand Popularity
                                    </div>
                                </div>
                                <a class="more" href="javascript:;">
                                View more <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div> -->
                <?php  
                    $BoardWidgetBranche = URL."Branches/orgBranchList/".$orgId.".json";
                    $BoardWidgetBranches = \Httpful\Request::get($BoardWidgetBranche)->send();
                ?>
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
                                    <i class="fa fa-futbol-o"></i>
                                </div>
                                <div class="details" style="padding-right:0px;width:89%">
                                    <select class="boardwidgetBranch form-control view-board">
                                        <option value="0"> -- Select Branch -- </option>
                                        <?php 
                                            foreach($BoardWidgetBranches->body->branchlist as $brnch){
                                                echo '<option value="'.$brnch->Branch->id .'">'.$brnch->Branch->title.'</option>';
                                            }
                                        ?>
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
                </div>
                <script>
                    $(document).ready(function(){
                        $("#boardWidget").click(function(){
                            var is = $(this);
                            if($(".boardwidgetBranch").val() == 0){
                                $(".boardwidgetBranch").focus();
                            }else if($(".boardwidgetBoard").val() == 0){
                                $(".boardwidgetBoard").focus();
                            }else{
                                window.location.href="<?php echo URL_VIEW;?>"+"shifts/shiftScheduleOverview?board_id="+$(".boardwidgetBoard").val();
                            }
                       });
                                                
        $(".boardwidgetBranch").change(function(){
            var f=$(this);
                $.ajax({
                    url:"<?php echo URL;?>"+"Boards/getBoardListOfBranch/"+f.val()+".json",
                    datatype:"jsonp",
                    success:function(data){
                        var data3="<option value='0'>-- Select Department --</option>";
                            $.each(data['boardList'],function(k6,v6){
                                data3+="<option value='"+v6['Board']['id']+"'>"+v6['Board']['title']+"</option>";
                            });
                        $(".boardwidgetBoard").html(data3);
                    }
                });
         });
                         
                     });
                </script>
                
            </div>
            <!-- END DASHBOARD STATS -->
            <div class="clearfix">
            </div>
            
                        <div class="row">

<?php    
$path = URL . "Branches/orgBranches/".$orgId.".json";
$result = \Httpful\request::get($path)->send();
$branchesName = $result->body->branches;
?>
        <div class="container">
      
            <!-- row -->
            <div class="row">
                <div class="col-md-12 col-sm-12">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bar-chart font-green-sharp hide"></i>
                <span style="font-style:italic;"> Today's Shift Schedule</span>
            </div>

<!--             <div class="actions">
-->         <div class="actions pull-right">
                <form id="searchForm" class="form-inline" role="form" action="" method="post">
                    <span style="color:grey">Filter Shift Schedule :</span>
                    <div class="form-group">
                        <select name="branchId" class="form-control input-sm" id="select-branch">
                            <option class="default" selected value="0">--All Branch--</option>

                            <?php foreach($branchesName as $b): ?>
                            <option value="<?php echo $b->Branch->id; ?>"><?php echo $b->Branch->title; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="departmentId" id="selectDepartment" class="form-control input-sm">
                        <option class="default" selected value="0">--All Department--</option>

                        </select>
                    </div>
                </form>
            </div>
                <!-- <div class="btn-group btn-group-devided" data-toggle="buttons">
                    <label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                    <input type="radio" name="options" class="toggle" id="option1">Today</label>
                </div>
            </div> -->
        </div>

        <div class="portlet-body">
        <div class="table">
            
            <table class="table table-hover table-light">
            <?php if(!empty($todaysShift)){ ?>
                <thead>
                    <tr class="uppercase">
                        <th>Employee Name</th>
                        <th>Shift</th>
                        <th>Start</th>
                        <th>End</th>
                    </tr>
                </thead>
                <tbody id="initialShift">
                    <?php foreach($todaysShift as $shift):
                            $userimage = URL.'webroot/files/user/image/'.$shift->User->image_dir.'/thumb2_'.$shift->User->image;
                            $image = $shift->User->image;
                            $gender = $shift->User->gender;
                            $userimage = imageGenerate($userimage,$image,$gender);
                    ?>
                        <tr>
                            <td><img src="<?php echo $userimage; ?>" style="width:40px;height:40px;"> <?php echo $shift->User->fname.' '.$shift->User->lname; ?></td>
                            <td><?php echo $shift->Shift->title; ?></td>
                            <td><?php echo hisToTime($shift->Shift->starttime);?></td>
                            <td><?php echo hisToTime($shift->Shift->endtime);?></td>
                        </tr>
                            
                    <?php endforeach; ?>    
                </tbody>
                <tbody id="laterShift" style="display:none;">

                </tbody>

                <?php } else { ?>
                <blockquote><small>There are no shifts scheduled for today till now.</small></blockquote>
            <?php } ?>
            </table>
            
        </div>
        <div id="modals_of_today_shift"></div>

         </div>
                </div>
            </div>
        </div>
    </div>

</div>

            <!-- BEGIN NOTICEBOARD -->
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-blue-steel hide"></i>
                                <span class="caption-subject font-blue-steel bold uppercase">Checked in employees</span>
                            </div>                            
                        </div>
                        <div class="portlet-body">                        
                            <div class="pull-right">                                                        
                                <select class="form-control selectBranchCheckin">
                                        <option value="0">All Branches</option>                                
                                    <?php foreach($branches as $branchid=>$branchtitle){ ?>
                                        <option value="<?=$branchid;?>"><?=$branchtitle;?></option>
                                  <?php   } ?>                                       
                                </select>
                            </div><br /><br /><br />                        
                            <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds checkedInEmployees">
                                    <?php if(isset($shiftUsers) && !empty($shiftUsers)):?>
                                    <?php foreach($shiftUsers as $shiftUser):?>
                                    <?php if(checkFileExists($shiftUser->User->imagepath) && $shiftUser->User->imagepath != ""){
                                                        $imgpath = $shiftUser->User->imagepath;
                                                    }else{
                                                        if($shiftUser->User->gender == 0){
                                                            $imgpath = URL."webroot/img/user_image/defaultuser.png";
                                                        }else{
                                                             $imgpath = URL."webroot/img/user_image/femaleadmin.png";
                                                        }
                                                    } ?>
                                        <?php if($shiftUser->ShiftUser->check_status == 2):?>
                                        <li class="row">
                                            <div class="col-md-1">
                                                <i class="fa fa-reply font-red" style="float:right;"></i>
                                            </div>
                                                <div class="col-md-3">
                                                    <img src="<?php echo $imgpath;?>" width="30" height="30"><br/>
                                                    <div class="desc text-capitalize">
                                                        <?php echo $shiftUser->User->fname." ".$shiftUser->User->lname;?>
                                                    </div>
                                                </div>
                                            <div class="col-md-3">
                                                <?php echo $shiftUser->Shift->title;?>
                                            </div>
                                          <!--  <div class="col-md-3">
                                                    <div class="Branch">
                                                         <?php echo $shiftUser->Board->Branch->title;?>
                                                    </div>
                                                </div> -->                                            
                                            <div class="col-md-3">
                                                    <div class="Board">
                                                         <?php echo $shiftUser->Board->title;?>
                                                    </div>
                                                </div>
                                            <div class="col-md-2">
                                                <div class="date">
                                                     <?php echo hisToTime($shiftUser->ShiftUser->check_out_time);?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php else:?>
                                            <li class="row">
                                            <div class="col-md-1">
                                                <i class="fa fa-reply font-blue" style="float:left;"></i>  
                                            </div>                                          
                                                    <div class="col-md-3">
                                                        <img src="<?php echo $imgpath;?>" width="30" height="30"><br/>
                                                        <div class="desc text-capitalize">
                                                            <?php echo $shiftUser->User->fname." ".$shiftUser->User->lname;?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <?php echo $shiftUser->Shift->title;?>
                                                </div>
                                        <!--    <div class="col-md-3">
                                                    <div class="Branch">
                                                         <?php echo $shiftUser->Board->Branch->title;?>
                                                    </div>
                                                </div> -->                                            
                                            <div class="col-md-3">
                                                    <div class="Board">
                                                         <?php echo $shiftUser->Board->title;?>
                                                    </div>
                                                </div>
                                            <div class="col-md-2">
                                                <div class="date">
                                                     <?php echo hisToTime($shiftUser->ShiftUser->check_in_time);?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                <?php else:?>
                                    <li>No any employee checked in/checked out in today.</li>
                                <?php endif;?>
                                </ul>
                            <script>
                                $(document).ready(function(){
                                    
                                    function ImageExist(url) 
                                    {
                                       var img = new Image();
                                       img.src = url;
                                       return img.height != 0;
                                    }
                                    
                                   $(".selectBranchCheckin").change(function(){
                                        var brnch = $(this);
                                        if(brnch.val() == 0){
                                            $.ajax({
                                               url :  "<?=URL."ShiftUsers/listOfCheckedInUsers/".$orgId.".json";?>",
                                               datatype:"jsonp",
                                               success : function(data) {
                                                   var d1 = "";
                                                   if ($.isEmptyObject(data.shiftUsers)) {
                                                       d1+="No any employee checked in/checked out in this Branch today.";
                                                   } else {

                                                   $.each(data.shiftUsers, function (k1, v1) {
                                                       if (ImageExist(v1['User']['imagepath']) && v1['User']['imagepath'] != "") {
                                                           var imgurl = v1['User']['imagepath'];
                                                       } else {
                                                           if (v1['User']['gender'] == 0) {
                                                               var imgurl = "<?php echo URL;?>" + "webroot/img/user_image/defaultuser.png";
                                                           } else {
                                                               var imgurl = "<?php echo URL;?>" + "webroot/img/user_image/femaleadmin.png";
                                                           }
                                                       }
                                                       if (v1['ShiftUser']['check_status'] == 1) {
                                                           h1 = v1['ShiftUser']['check_in_time'].substring(11, 13);
                                                           m1 = v1['ShiftUser']['check_in_time'].substring(14, 16);
                                                           if (h1 > 12) {
                                                               h1 = h1 - 12;
                                                               f1 = "PM";
                                                           } else {
                                                               f1 = "AM"
                                                           }
                                                           d1 += '<li class="row"><div class="col-md-1">' +
                                                               '<i class="fa fa-reply font-blue" style="float:left;"></i></div><div class="col-md-3">' +
                                                               '<img src="' + imgurl + '" width="30" height="30"><br/><div class="desc text-capitalize">' + v1['User']['fname'] + " " + v1['User']['lname'] +
                                                               '</div></div>' +
                                                               '<div class="col-md-3">' + v1['Shift']['title'] +
                                                               '</div>' +
                                                               '<div class="col-md-3"><div class="Board">' + v1['Board']['title'] +
                                                               '</div></div><div class="col-md-2">' +
                                                               '<div class="date">' + h1 + ":" + m1 + " " + f1 +
                                                               '</div></div></li>';
                                                       } else if (v1['ShiftUser']['check_status'] == 2) {
                                                           h1 = v1['ShiftUser']['check_out_time'].substring(11, 13);
                                                           m1 = v1['ShiftUser']['check_out_time'].substring(14, 16);
                                                           if (h1 > 12) {
                                                               h1 = h1 - 12;
                                                               f1 = "PM";
                                                           } else {
                                                               f1 = "AM"
                                                           }
                                                           d1 += '<li class="row"><div class="col-md-1">' +
                                                               '<i class="fa fa-reply font-red" style="float:left;"></i></div><div class="col-md-3">' +
                                                               '<img src="' + imgurl + '" width="30" height="30"><br/><div class="desc text-capitalize">' + v1['User']['fname'] + " " + v1['User']['lname'] +
                                                               '</div></div>' +
                                                               '<div class="col-md-3">' + v1['Shift']['title'] +
                                                               '</div>' +
                                                               '<div class="col-md-3"><div class="Board">' + v1['Board']['title'] +
                                                               '</div></div><div class="col-md-2">' +
                                                               '<div class="date">' + h1 + ":" + m1 + " " + f1 +
                                                               '</div></div></li>';
                                                       }
                                                   });
                                               }
                                                    $('.checkedInEmployees').html(d1);
                                               }
                                            });
                                        }else{
                                            $.ajax({
                                               url :  "<?=URL."ShiftUsers/listOfCheckedInUsersInBranch/".$orgId;?>"+"/"+brnch.val()+".json",
                                               datatype : "jsonp",
                                               success : function(data) {
                                                   var d1 = "";
                                                   if ($.isEmptyObject(data.shiftUsers)) {
                                                       d1 += "No any employee checked in/checked out in this Branch today.";
                                                   } else {
                                                   $.each(data.shiftUsers, function (k1, v1) {
                                                       if (ImageExist(v1['User']['imagepath']) && v1['User']['imagepath'] != "") {
                                                           var imgurl = v1['User']['imagepath'];
                                                       } else {
                                                           if (v1['User']['gender'] == 0) {
                                                               var imgurl = "<?php echo URL;?>" + "webroot/img/user_image/defaultuser.png";
                                                           } else {
                                                               var imgurl = "<?php echo URL;?>" + "webroot/img/user_image/femaleadmin.png";
                                                           }
                                                       }
                                                       if (v1['ShiftUser']['check_status'] == 1) {
                                                           h1 = v1['ShiftUser']['check_in_time'].substring(11, 13);
                                                           m1 = v1['ShiftUser']['check_in_time'].substring(14, 16);
                                                           if (h1 > 12) {
                                                               h1 = h1 - 12;
                                                               f1 = "PM";
                                                           } else {
                                                               f1 = "AM"
                                                           }
                                                           d1 += '<li class="row"><div class="col-md-1">' +
                                                               '<i class="fa fa-reply font-blue" style="float:left;"></i></div><div class="col-md-3">' +
                                                               '<img src="' + imgurl + '" width="30" height="30"><br/><div class="desc text-capitalize">' + v1['User']['fname'] + " " + v1['User']['lname'] +
                                                               '</div></div>' +
                                                               '<div class="col-md-3">' + v1['Shift']['title'] +
                                                               '</div>' +
                                                               '<div class="col-md-3"><div class="Board">' + v1['Board']['title'] +
                                                               '</div></div><div class="col-md-2">' +
                                                               '<div class="date">' + h1 + ":" + m1 + " " + f1 +
                                                               '</div></div></li>';
                                                       } else if (v1['ShiftUser']['check_status'] == 2) {
                                                           h1 = v1['ShiftUser']['check_out_time'].substring(11, 13);
                                                           m1 = v1['ShiftUser']['check_out_time'].substring(14, 16);
                                                           if (h1 > 12) {
                                                               h1 = h1 - 12;
                                                               f1 = "PM";
                                                           } else {
                                                               f1 = "AM"
                                                           }
                                                           d1 += '<li class="row"><div class="col-md-1">' +
                                                               '<i class="fa fa-reply font-red" style="float:left;"></i></div><div class="col-md-2">' +
                                                               '<img src="' + imgurl + '" width="30" height="30"><br/><div class="desc text-capitalize">' + v1['User']['fname'] + " " + v1['User']['lname'] +
                                                               '</div></div>' +
                                                               '<div class="col-md-3">' + v1['Shift']['title'] +
                                                               '</div>' +
                                                               '<div class="col-md-4"><div class="Board">' + v1['Board']['title'] +
                                                               '</div></div><div class="col-md-2">' +
                                                               '<div class="date">' + h1 + ":" + m1 + " " + f1 +
                                                               '</div></div></li>';
                                                       }
                                                   });
                                               }
                                                    $('.checkedInEmployees').html(d1);
                                                }
                                            });
                                        }
                                   });
                                });
                            </script>
                            </div>
                        </div>
                    </div>
                </div>



<!-- ******************************** Ashok Neupane  ****************************** -->

<div class="col-md-4 col-sm-4">

                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-blue-steel hide"></i>
                                <span class="caption-subject font-blue-steel bold uppercase">Sent Shift Requests</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds">
                                    <?php if(isset($UsersRequests) && !empty($UsersRequests)):

                                    ?>
                                    <?php foreach($UsersRequests as $shiftUser):
                                            $orgimage = URL.'webroot/files/user/image/'.$shiftUser->User->image_dir.'/thumb2_'.$shiftUser->User->image;
                                            $image = $shiftUser->User->image;
                                            $gender = $shiftUser->User->gender;
                                            $fbid = $shiftUser->User->fbid;

                                            $userimage = imageGenerate($orgimage,$fbid,$image,$gender);

                                        

                                    ?>

                                        <li>
                                            <div class="row note <?php
                                                if($shiftUser->ShiftUser->status==3){
                                                    echo 'note-success';
                                                }elseif($shiftUser->ShiftUser->status==0){
                                                    echo 'note-danger';
                                                }elseif($shiftUser->ShiftUser->status==1){
                                                    echo 'note-warning';
                                                }
                                            ?>">
                                                <div class="col-md-3">
                                                        <!-- <img src="<?php echo URL.'webroot/files/user/image/'.$shiftUser->User->image_dir.'/thumb2_'.$shiftUser->User->image;?>" width="50" height="30"> -->
                                                        <img src="<?php echo $userimage;?>" width="50" height="30">
                                                       <br /><span><?php if($shiftUser->ShiftUser->status==3){
                                                            echo 'Accepted';
                                                        }elseif($shiftUser->ShiftUser->status==0){
                                                            echo 'Rejected';
                                                        }elseif($shiftUser->ShiftUser->status==1){
                                                            echo 'Pending';
                                                        } ?></span> 
                                                </div>
                                                <div class="col-md-9">
                                                    <span><?php echo ucwords($shiftUser->User->fname." ".$shiftUser->User->lname);?></span><br />
                                                        <?php
                                                        $date1=DateTime::createFromFormat('H:i:s',$shiftUser->Shift->starttime);
                                                        $date2=$date1->format('g:ia');
                                                        $date3=DateTime::createFromFormat('H:i:s',$shiftUser->Shift->endtime);
                                                        $date4=$date3->format('g:ia');
                                                        $date5=DateTime::createFromFormat('Y-m-d',$shiftUser->ShiftUser->shift_date);
                                                        $date6=$date5->format('jS F Y');
                                                        ?>
                                                <span><?php echo $shiftUser->Shift->title;?>&nbsp;(<span><?php echo $date2."-".$date4;?></span>)</span><br />
                                                <span><?php echo $date6;?></span>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach;?>
                                <?php else:?>
                                    <li>No any Shift Requests Send.</li>
                                <?php endif;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
<!-- Notice Board column -->
<div class="col-md-4">
    <div class="portlet sale-summary portlet light calendar ">
        <div class="portlet-title ">
            <div class="caption">
                <i class="icon-calendar font-green-sharp"></i>
                <span class="caption-subject font-green-sharp bold uppercase">Notice Board</span>
            </div>
        </div>
        <div class="portlet-body" style="max-height:274px;">
                <ul class="list-unstyled">

                    <?php if(isset($notices) && !empty($notices)):?>
                    <?php foreach ($notices as $notice):?>
                    <li>
                                <h4 class="sale-info list-group-item-heading">
                                    <?php echo $notice->Noticeboard->title;?>
                                </h4> 
                                <div class="news-block-tags">
                                <em class="sale-info small" style="font-style:normal;clear:both"><?php echo getStandardDateTime($notice->Noticeboard->notice_date);?></em>
                                </div>
                                <p style="clear:both">
                                    <?php 
                                        $notice_desc=$notice->Noticeboard->description;
                                        //echo $notice_desc;
                                        echo substr($notice_desc,0,370);
                                         
                                     ?>
                                </p>

                                
                                 <?php
                                    if(str_word_count($notice_desc) < 10 ){}
                                
                                else{
                                    ?>
                                       <a href="#portlet-config_<?php echo $notice->Noticeboard->id; ?>" class="news-block-btn config" data-toggle="modal">
                            Read more <i class="m-icon-swapright m-icon-black"></i>
                            </a>
                                <?php
                                }
                                ?>                                                       
                    </li>
                    <!--pop-up content for News board-->

                    <div class="modal fade" id="portlet-config_<?php echo $notice->Noticeboard->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title"><?php echo $notice->Noticeboard->title;?></h4>
                                </div>
                                <div class="modal-body">
                                     <?php echo $notice->Noticeboard->description;?>
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

                        <?php endforeach;?>
                    <?php else:?>
                        <div>No notices to show.</div>
                    <?php endif;?>
            
                </ul>
            
        </div>
        <?php if(isset($notices) && !empty($notices)):?>
        <a href="<?php echo URL_VIEW.'noticeboards/list_noticeboards';?>" class="btn red-sunglo">View All</a>
        <?php endif; ?>
    </div>
</div>
<!-- End of Notice board column -->

<div class="col-md-8" style="margin-top:10px;">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bar-chart font-green-sharp hide"></i>
                <span class="caption-subject font-green-sharp bold uppercase">Meetings</span>
            </div>
            <div class="actions">
                <div data-toggle="buttons" class="btn-group btn-group-devided">
                    
                </div>
            </div>
        </div>
        <div class="portlet-body">
<?php     
$url=URL."Messages/orgMeetingRequests/".$orgId.".json"; 
$result=\Httpful\Request::get($url)->send();
?>
<div class="table-responsive">
<table class="table org_meeting_table" style="margin-bottom: 40px;overflow-y: scroll;max-height: 500px;">
<!-- <thead><tr><th>#</th><th style="width: 25%;">Title</th><th>From</th><th>To</th><th>Meeting Date</th><th>Option</th></tr></thead> -->
<tbody>
<?php 
if($result->body->orgMeetingRequests){
    $count=1;
foreach($result->body->orgMeetingRequests as $data){ ?>
<tr>
    <td><?php echo $count;?></td>
    <td><?php echo $data->Message->title;?></td>
    <td><?php echo ucwords($data->UserFrom->fname." ".$data->UserFrom->lname);?></td>
    <td><?php echo ucwords($data->UserTo->fname." ".$data->UserTo->lname);?></td>
    <td><?php
    $date=DateTime::createFromFormat('Y-m-d',$data->Message->requesteddate); 
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
            		 <?php if($data->Message->requeststatus == 0){
            		     echo "Not Responded";
            		 }elseif($data->Message->requeststatus == 1){
            		     echo "Accepted";
            		 }elseif($data->Message->requeststatus == 2){
            		     echo "Rejected";
            		 }?>
            	</div>
            </li>
				<li>
					<button class="btn btn-xs blue col-md-12 col-sm-12 col-xs-12" title="View" data-toggle="modal" data-target="#my_request<?php echo $data->Message->id;?>"><i class="fa fa-external-link"></i>&nbsp;View</button>
				</li>
			</ul>
		</div>
	</div> 
    </td>
</tr>

<div id="my_request<?php echo $data->Message->id;?>" class="modal fade" tabindex="-1" role="dialog">
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
    							 Title:
    						</div>
    						<div class="col-md-8 value">
    							 <?php echo $data->Message->title;?>
    						</div>
    					</div><hr />
    					<div class="row static-info">
    						<div class="col-md-4 name">
    							 Description:
    						</div>
    						<div class="col-md-8 value">
    							 <?=$data->Message->content;?>
    						</div>
    					</div><hr />
    					<div class="row static-info">
    						<div class="col-md-4 name">
    							 From:
    						</div>
    						<div class="col-md-8 value">
    							 <?php echo ucwords($data->UserFrom->fname." ".$data->UserFrom->lname);?>
                                 <img src="<?php echo URL."webroot/files/user/image/".$data->UserFrom->image_dir."/".$data->UserFrom->image;?>" alt="pp" style="height: 30px;width: 40px;"/>
    						</div>
    					</div><hr />
    					<div class="row static-info">
    						<div class="col-md-4 name">
    							 To:
    						</div>
    						<div class="col-md-8 value">
    							 <?php echo ucwords($data->UserTo->fname." ".$data->UserTo->lname);?>
                                 <img src="<?php echo URL."webroot/files/user/image/".$data->UserTo->image_dir."/".$data->UserTo->image;?>" alt="pp" style="height: 30px;width: 40px;"/>
    						</div>
    					</div><hr />
                        <div class="row static-info">
    						<div class="col-md-4 name">
    							 Meeting Date:
    						</div>
    						<div class="col-md-8 value"><?php
                                $date=DateTime::createFromFormat('Y-m-d',$data->Message->requesteddate); 
                                echo $date->format('jS F Y');?>
    						</div>
    					</div><hr />
                        <div class="row static-info">
    						<div class="col-md-12 col-sm-12 col-xs-12 value label <?php if($data->Message->requeststatus == 0){
    							     echo "label-info";
    							 }elseif($data->Message->requeststatus == 1){
    							     echo "label-success";
    							 }elseif($data->Message->requeststatus == 2){
    							     echo "label-danger";
    							 }?>">
    							 <?php if($data->Message->requeststatus == 0){
    							     echo "Not Responded";
    							 }elseif($data->Message->requeststatus == 1){
    							     echo "Accepted";
    							 }elseif($data->Message->requeststatus == 2){
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

<?php $count++; }}else{ ?>
<p>No sent requests</p>
<?php } ?>
</tbody>
<tr style="height: 60px;"><td></td><td></td><td></td><td></td><td></td><td></td></tr>
</table></div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function(){
    jQuery('.org_meeting_table').dataTable();
});
</script>

</div>


<div class="row">

<?php 
$url_trade = URL."Stafftradings/getOrgRequests/".$orgId.".json";
$response_trade = \Httpful\Request::get($url_trade)->send();
?>
<div class="col-md-8" style="margin-top:10px;">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bar-chart font-green-sharp hide"></i>
                <span class="caption-subject font-green-sharp bold uppercase">Staff Trading Requests</span>

            </div>
            <div class="actions">
                <div data-toggle="buttons" class="btn-group btn-group-devided">
                    
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-responsive" style="overflow-y: scroll;max-height: 500px;">
                <table class="table table-trading-requests">
                    <thead><tr> <th>User</th> <th>From (Branch)</th> <th>To (Branch)</th> <th>Group</th> <th>Shift</th> <th>Shift Date</th> <th>Option</th> </tr></thead>
                    <tbody>
                    <?php if(isset($response_trade->body->tradingList) && !empty($response_trade->body->tradingList)){
                        foreach($response_trade->body->tradingList as $list){
                    ?>
                    <tr class="removeThis1">
                        <td><?=ucwords($list->User->fname." ".$list->User->lname); ?></td>
                        <td><?=$list->fromBranch->title; ?></td>
                        <td><?=$list->toBranch->title; ?></td>
                        <td><?=$list->Group->title; ?></td>
                        <td><?=$list->Shift->title; ?></td>
                        <td><?php $date_trade=DateTime::createFromFormat('Y-m-d',$list->Stafftrading->shiftdate);
                                $date_trade=$date_trade->format('jS F Y');
                                echo $date_trade; ?></td>
                        <td>
                            <button class="btn btn-xs green acceptTradeRequest1" style="margin-bottom: 5px;" trading_id="<?=$list->Stafftrading->id;?>">Accept</button> 
                            <button class="btn btn-xs red rejectTradeRequest1" trading_id="<?=$list->Stafftrading->id;?>">Reject</button>
                        </td>
                    </tr>
                    <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
        jQuery('.acceptTradeRequest1').click(function(){
            var e = jQuery(this);
            var tradeid = e.attr('trading_id');
            jQuery.ajax({
               url: "<?php echo URL.'Stafftradings/orgResponse/1/';?>"+tradeid+".json", 
                datatype:'jsonp',
                success:function(data){   
                    if(data.message == 0){
                        toastr.warning('Response not saved','Warning');
                    }else if(data.message == 1){
                        toastr.info('Accepted staff trading request','Info');
                        e.closest('.removeThis1').hide();
                    }
                } 
            });
        });
        jQuery('.rejectTradeRequest1').click(function(){
            var e = jQuery(this);
            var tradeid = e.attr('trading_id');
            jQuery.ajax({
               url: "<?php echo URL.'Stafftradings/orgResponse/2/';?>"+tradeid+".json",
                datatype:'jsonp',
                success:function(data){   
                    if(data.message == 0){
                        toastr.warning('Response not saved','Warning');
                    }else if(data.message == 1){
                        toastr.info('Rejected staff trading request','Info');
                        e.closest('.removeThis1').hide();
                    }
                } 
            });
        });
</script>
<!-- ****************************************************************************** -->     


</div>


            <!-- END NOTICE BOARD -->


                        <!--Starts to do task list-->
<div class="row">
<div class="col-md-8 col-sm-8">
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
                    <div>
                    <ul class="task-list">
                    <?php if(!empty($tasks->tasks)){?>
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
                        <?php } else { echo "You don't have any task schedule right Now."; } ?>
                    </ul>
                    </div>
                    <!-- END START TASK LIST -->
                </div>

                <div class="tab-pane" id="portlet_tab2">

                    <?php include 'addTask.php';?>

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
</div>
</div>


<script>

// $(document).ready(function (){
    
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
// });
  </script>

<script>
   // $(document).ready(function(){
    function ImageExist(url)
    {
        var img = new Image();
        img.src = url;
        return img.height != 0;
    }

    function tConvert (time) 
        {
            time = time.slice(0, -3);
                  // Check correct time format and split into components
          time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

          if (time.length > 1) { // If time format correct
            time = time.slice (1);  // Remove full string match value
            if(time[2] == '00'){
                time[1] = '';
                time[2] = '';
            }
            time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
            time[0] = +time[0] % 12 || 12; // Adjust hours
          }
          // console.log(time);
          return time.join (''); // return adjusted time or original string
        }

    var orgId = '<?php echo $orgId; ?>';

        $("#select-branch").on('change',function(){      
            console.log(orgId);
            var e = $(this);
            var branchId = e.find("option:selected").val();
            var departId = $("#selectDepartment option:selected").val();


            var data =  getBoardList(branchId);
            var html = ""; 
            html += '<option selected value="0">--All Department--</option>';
            $.each(data,function(key,val){
                var departmentId = val.Board.id;
                var title = val.Board.title;
                html += '<option value="'+departmentId+'">'+title+'</option>';
            });
            $("#selectDepartment").html("").append(html);

            if(branchId != '0'){
               filterShift(orgId,branchId,departId); 
            } else {
                $("#initialShift").show();
                $("#laterShift").hide();
            }
            
            

        
        });

        $("#selectDepartment").on('change',function(){
            var e = $(this);
            var branchId = $("#select-branch option:selected").val();
            var departId = e.find("option:selected").val();
            if(branchId != '0'){
              filterShift(orgId,branchId,departId);  
            }
            

        });

        function filterShift(orgId,branchId,departId){
            var url = '<?php echo URL; ?>ShiftUsers/filterTodayShift/'+orgId+'/'+branchId+'/'+departId+'.json';
            
            $.ajax({
                url:url,
                type:'post',
                datatype:'jsonp',
                success:function(response){
                    var html ='';

                    if(response.length != 0){
                        $.each(response,function(key,val){
                            if(ImageExist(val['User']['imagepath']) && val['User']['imagepath'] != ""){
                                  var imgurl = val['User']['imagepath'];
                                }else{
                                  if(val['User']['gender']== 0){
                                    var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/defaultuser.png";
                                  }else{
                                    var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/femaleadmin.png";
                                  }
                                }
                            
                            html += '<tr>';
                            html += '<td><img src="'+imgurl+'" style="width:40px;height:40px;"> '+val.User.fname+' '+val.User.lname+'</td>';
                            html += '<td>'+val.Shift.title+'</td>';
                            html += '<td>'+ tConvert(val.Shift.starttime)+'</td>';
                            html += '<td>'+ tConvert(val.Shift.endtime) +'</td>';
                            html += '</tr>';
                        });
                    } else {
                        html += '<td>No results found</td>';
                    }
                    
                    $("#laterShift").html(html);
                    if(branchId != '0'){
                        $("#initialShift").hide();
                        $("#laterShift").show();
                    } else {
                        $("#initialShift").show();
                        $("#laterShift").hide();
                    }
                    
                    
                }
            })
        }

        function getBoardList(branchId)
        {
            var boards;
            var orgId = '<?php echo $orgId;?>';
            var url = '<?php echo URL;?>Boards/getBoardListOfBranch/'+branchId+'.json';
            $.ajax(
            {
                url:url,
                type:'post',
                async:false,
                datatype:'jsonp',
                success:function(res)
                {
                    boards = res.boardList;
                }
            });
                    return boards;
        }
    //});
</script>
<!--Ends to-do list-->
            <div class="clearfix">
            </div>
           <?php /*?
            <div class="row">
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
                                <img src="<?php echo URL_VIEW;?>admin/layout/img/loading.gif" alt="loading"/>
                            </div>
                            <div id="site_statistics_content" class="display-none">
                                <div id="site_statistics" class="chart">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
                <div class="col-md-6 col-sm-6">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-red-sunglo hide"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Revenue</span>
                                <span class="caption-helper">monthly stats...</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group">
                                    <a href="" class="btn grey-salsa btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    Filter Range<span class="fa fa-angle-down">
                                    </span>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="javascript:;">
                                            Q1 2014 <span class="label label-sm label-default">
                                            past </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                            Q2 2014 <span class="label label-sm label-default">
                                            past </span>
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="javascript:;">
                                            Q3 2014 <span class="label label-sm label-success">
                                            current </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                            Q4 2014 <span class="label label-sm label-warning">
                                            upcoming </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="site_activities_loading">
                                <img src="<?php echo URL_VIEW;?>admin/layout/img/loading.gif" alt="loading"/>
                            </div>
                            <div id="site_activities_content" class="display-none">
                                <div id="site_activities" style="height: 228px;">
                                </div>
                            </div>
                            <div style="margin: 20px 0 10px 30px">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                                        <span class="label label-sm label-success">
                                        Revenue: </span>
                                        <h3>$13,234</h3>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                                        <span class="label label-sm label-info">
                                        Tax: </span>
                                        <h3>$134,900</h3>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                                        <span class="label label-sm label-danger">
                                        Shipment: </span>
                                        <h3>$1,134</h3>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                                        <span class="label label-sm label-warning">
                                        Orders: </span>
                                        <h3>235090</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>
            <div class="clearfix">
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-blue-steel hide"></i>
                                <span class="caption-subject font-blue-steel bold uppercase">Recent Activities</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-default btn-circle" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    Filter By <i class="fa fa-angle-down"></i>
                                    </a>
                                    <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                                        <label><input type="checkbox"/> Finance</label>
                                        <label><input type="checkbox" checked=""/> Membership</label>
                                        <label><input type="checkbox"/> Customer Support</label>
                                        <label><input type="checkbox" checked=""/> HR</label>
                                        <label><input type="checkbox"/> System</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds">
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         You have 4 pending tasks. <span class="label label-sm label-warning ">
                                                        Take action <i class="fa fa-share"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 Just now
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-bar-chart-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         Finance Report for year 2013 has been released.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 20 mins
                                            </div>
                                        </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-danger">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         You have 5 pending membership that requires a quick review.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 24 mins
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         New order received with <span class="label label-sm label-success">
                                                        Reference Number: DR23923 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 30 mins
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         You have 5 pending membership that requires a quick review.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 24 mins
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-default">
                                                        <i class="fa fa-bell-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         Web server hardware needs to be upgraded. <span class="label label-sm label-default ">
                                                        Overdue </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 2 hours
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-default">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         IPO Report for year 2013 has been released.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 20 mins
                                            </div>
                                        </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         You have 4 pending tasks. <span class="label label-sm label-warning ">
                                                        Take action <i class="fa fa-share"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 Just now
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-danger">
                                                        <i class="fa fa-bar-chart-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         Finance Report for year 2013 has been released.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 20 mins
                                            </div>
                                        </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-default">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         You have 5 pending membership that requires a quick review.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 24 mins
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         New order received with <span class="label label-sm label-success">
                                                        Reference Number: DR23923 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 30 mins
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         You have 5 pending membership that requires a quick review.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 24 mins
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         Web server hardware needs to be upgraded. <span class="label label-sm label-default ">
                                                        Overdue </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 2 hours
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc">
                                                         IPO Report for year 2013 has been released.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date">
                                                 20 mins
                                            </div>
                                        </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="scroller-footer">
                                <div class="btn-arrow-link pull-right">
                                    <a href="javascript:;">See All Records</a>
                                    <i class="icon-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="portlet light tasks-widget">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-green-haze hide"></i>
                                <span class="caption-subject font-green-haze bold uppercase">Tasks</span>
                                <span class="caption-helper">tasks summary...</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group">
                                    <a class="btn green-haze btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    More <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="javascript:;">
                                            <i class="i"></i> All Project </a>
                                        </li>
                                        <li class="divider">
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                            AirAsia </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                            Cruise </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                            HSBC </a>
                                        </li>
                                        <li class="divider">
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                            Pending <span class="badge badge-danger">
                                            4 </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                            Completed <span class="badge badge-success">
                                            12 </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                            Overdue <span class="badge badge-warning">
                                            9 </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="task-content">
                                <div class="scroller" style="height: 305px;" data-always-visible="1" data-rail-visible1="1">
                                    <!-- START TASK LIST -->
                                    <ul class="task-list">
                                        <li>
                                            <div class="task-checkbox">
                                                <input type="checkbox" class="liChild" value=""/>
                                            </div>
                                            <div class="task-title">
                                                <span class="task-title-sp">
                                                Present 2013 Year IPO Statistics at Board Meeting </span>
                                                <span class="label label-sm label-success">Company</span>
                                                <span class="task-bell">
                                                <i class="fa fa-bell-o"></i>
                                                </span>
                                            </div>
                                            <div class="task-config">
                                                <div class="task-config-btn btn-group">
                                                    <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-check"></i> Complete </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-pencil"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-trash-o"></i> Cancel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="task-checkbox">
                                                <input type="checkbox" class="liChild" value=""/>
                                            </div>
                                            <div class="task-title">
                                                <span class="task-title-sp">
                                                Hold An Interview for Marketing Manager Position </span>
                                                <span class="label label-sm label-danger">Marketing</span>
                                            </div>
                                            <div class="task-config">
                                                <div class="task-config-btn btn-group">
                                                    <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-check"></i> Complete </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-pencil"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-trash-o"></i> Cancel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="task-checkbox">
                                                <input type="checkbox" class="liChild" value=""/>
                                            </div>
                                            <div class="task-title">
                                                <span class="task-title-sp">
                                                AirAsia Intranet System Project Internal Meeting </span>
                                                <span class="label label-sm label-success">AirAsia</span>
                                                <span class="task-bell">
                                                <i class="fa fa-bell-o"></i>
                                                </span>
                                            </div>
                                            <div class="task-config">
                                                <div class="task-config-btn btn-group">
                                                    <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-check"></i> Complete </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-pencil"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-trash-o"></i> Cancel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="task-checkbox">
                                                <input type="checkbox" class="liChild" value=""/>
                                            </div>
                                            <div class="task-title">
                                                <span class="task-title-sp">
                                                Technical Management Meeting </span>
                                                <span class="label label-sm label-warning">Company</span>
                                            </div>
                                            <div class="task-config">
                                                <div class="task-config-btn btn-group">
                                                    <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-check"></i> Complete </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-pencil"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-trash-o"></i> Cancel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="task-checkbox">
                                                <input type="checkbox" class="liChild" value=""/>
                                            </div>
                                            <div class="task-title">
                                                <span class="task-title-sp">
                                                Kick-off Company CRM Mobile App Development </span>
                                                <span class="label label-sm label-info">Internal Products</span>
                                            </div>
                                            <div class="task-config">
                                                <div class="task-config-btn btn-group">
                                                    <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-check"></i> Complete </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-pencil"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-trash-o"></i> Cancel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="task-checkbox">
                                                <input type="checkbox" class="liChild" value=""/>
                                            </div>
                                            <div class="task-title">
                                                <span class="task-title-sp">
                                                Prepare Commercial Offer For SmartVision Website Rewamp </span>
                                                <span class="label label-sm label-danger">SmartVision</span>
                                            </div>
                                            <div class="task-config">
                                                <div class="task-config-btn btn-group">
                                                    <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-check"></i> Complete </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-pencil"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-trash-o"></i> Cancel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="task-checkbox">
                                                <input type="checkbox" class="liChild" value=""/>
                                            </div>
                                            <div class="task-title">
                                                <span class="task-title-sp">
                                                Sign-Off The Comercial Agreement With AutoSmart </span>
                                                <span class="label label-sm label-default">AutoSmart</span>
                                                <span class="task-bell">
                                                <i class="fa fa-bell-o"></i>
                                                </span>
                                            </div>
                                            <div class="task-config">
                                                <div class="task-config-btn btn-group">
                                                    <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-check"></i> Complete </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-pencil"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-trash-o"></i> Cancel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="task-checkbox">
                                                <input type="checkbox" class="liChild" value=""/>
                                            </div>
                                            <div class="task-title">
                                                <span class="task-title-sp">
                                                Company Staff Meeting </span>
                                                <span class="label label-sm label-success">Cruise</span>
                                                <span class="task-bell">
                                                <i class="fa fa-bell-o"></i>
                                                </span>
                                            </div>
                                            <div class="task-config">
                                                <div class="task-config-btn btn-group">
                                                    <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-check"></i> Complete </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-pencil"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-trash-o"></i> Cancel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="last-line">
                                            <div class="task-checkbox">
                                                <input type="checkbox" class="liChild" value=""/>
                                            </div>
                                            <div class="task-title">
                                                <span class="task-title-sp">
                                                KeenThemes Investment Discussion </span>
                                                <span class="label label-sm label-warning">KeenThemes </span>
                                            </div>
                                            <div class="task-config">
                                                <div class="task-config-btn btn-group">
                                                    <a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                    <i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-check"></i> Complete </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-pencil"></i> Edit </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;">
                                                            <i class="fa fa-trash-o"></i> Cancel </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <!-- END START TASK LIST -->
                                </div>
                            </div>
                            <div class="task-footer">
                                <div class="btn-arrow-link pull-right">
                                    <a href="javascript:;">See All Records</a>
                                    <i class="icon-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix">
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-cursor font-purple-intense hide"></i>
                                <span class="caption-subject font-purple-intense bold uppercase">General Stats</span>
                            </div>
                            <div class="actions">
                                <a href="javascript:;" class="btn btn-sm btn-circle btn-default easy-pie-chart-reload">
                                <i class="fa fa-repeat"></i> Reload </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="easy-pie-chart">
                                        <div class="number transactions" data-percent="55">
                                            <span>
                                            +55 </span>
                                            %
                                        </div>
                                        <a class="title" href="javascript:;">
                                        Transactions <i class="icon-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="margin-bottom-10 visible-sm">
                                </div>
                                <div class="col-md-4">
                                    <div class="easy-pie-chart">
                                        <div class="number visits" data-percent="85">
                                            <span>
                                            +85 </span>
                                            %
                                        </div>
                                        <a class="title" href="javascript:;">
                                        New Visits <i class="icon-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="margin-bottom-10 visible-sm">
                                </div>
                                <div class="col-md-4">
                                    <div class="easy-pie-chart">
                                        <div class="number bounce" data-percent="46">
                                            <span>
                                            -46 </span>
                                            %
                                        </div>
                                        <a class="title" href="javascript:;">
                                        Bounce <i class="icon-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-purple-plum hide"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Server Stats</span>
                                <span class="caption-helper">monthly stats...</span>
                            </div>
                            <div class="tools">
                                <a href="" class="collapse">
                                </a>
                                <a href="#portlet-config" data-toggle="modal" class="config">
                                </a>
                                <a href="" class="reload">
                                </a>
                                <a href="" class="remove">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="sparkline-chart">
                                        <div class="number" id="sparkline_bar"></div>
                                        <a class="title" href="javascript:;">
                                        Network <i class="icon-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="margin-bottom-10 visible-sm">
                                </div>
                                <div class="col-md-4">
                                    <div class="sparkline-chart">
                                        <div class="number" id="sparkline_bar2"></div>
                                        <a class="title" href="javascript:;">
                                        CPU Load <i class="icon-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="margin-bottom-10 visible-sm">
                                </div>
                                <div class="col-md-4">
                                    <div class="sparkline-chart">
                                        <div class="number" id="sparkline_line"></div>
                                        <a class="title" href="javascript:;">
                                        Load Rate <i class="icon-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix">
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <!-- BEGIN REGIONAL STATS PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-red-sunglo"></i>
                                <span class="caption-subject font-red-sunglo bold uppercase">Regional Stats</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                <i class="icon-cloud-upload"></i>
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                <i class="icon-wrench"></i>
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;">
                                </a>
                                <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                <i class="icon-trash"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="region_statistics_loading">
                                <img src="<?php echo URL_VIEW;?>admin/layout/img/loading.gif" alt="loading"/>
                            </div>
                            <div id="region_statistics_content" class="display-none">
                                <div class="btn-toolbar margin-bottom-10">
                                    <div class="btn-group btn-group-circle" data-toggle="buttons">
                                        <a href="" class="btn grey-salsa btn-sm active">
                                        Users </a>
                                        <a href="" class="btn grey-salsa btn-sm">
                                        Orders </a>
                                    </div>
                                    <div class="btn-group pull-right">
                                        <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        Select Region <span class="fa fa-angle-down">
                                        </span>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li>
                                                <a href="javascript:;" id="regional_stat_world">
                                                World </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" id="regional_stat_usa">
                                                USA </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" id="regional_stat_europe">
                                                Europe </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" id="regional_stat_russia">
                                                Russia </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" id="regional_stat_germany">
                                                Germany </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="vmap_world" class="vmaps display-none">
                                </div>
                                <div id="vmap_usa" class="vmaps display-none">
                                </div>
                                <div id="vmap_europe" class="vmaps display-none">
                                </div>
                                <div id="vmap_russia" class="vmaps display-none">
                                </div>
                                <div id="vmap_germany" class="vmaps display-none">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END REGIONAL STATS PORTLET-->
                </div>
                <div class="col-md-6 col-sm-6">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-globe font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp bold uppercase">Feeds</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab">
                                    System </a>
                                </li>
                                <li>
                                    <a href="#tab_1_2" data-toggle="tab">
                                    Activities </a>
                                </li>
                                <li>
                                    <a href="#tab_1_3" data-toggle="tab">
                                    Recent Users </a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <!--BEGIN TABS-->
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1">
                                    <div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
                                        <ul class="feeds">
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 You have 4 pending tasks. <span class="label label-sm label-info">
                                                                Take action <i class="fa fa-share"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         Just now
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New version v1.4 just lunched!
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         20 mins
                                                    </div>
                                                </div>
                                                </a>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-danger">
                                                                <i class="fa fa-bolt"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 Database server #12 overloaded. Please fix the issue.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         24 mins
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         30 mins
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         40 mins
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-warning">
                                                                <i class="fa fa-plus"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New user registered.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         1.5 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 Web server hardware needs to be upgraded. <span class="label label-sm label-default ">
                                                                Overdue </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         2 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-default">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         3 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-warning">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         5 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         18 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-default">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         21 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         22 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-default">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         21 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         22 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-default">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         21 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         22 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-default">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         21 hours
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-info">
                                                                <i class="fa fa-bullhorn"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received. Please take care of it.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         22 hours
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_1_2">
                                    <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                                        <ul class="feeds">
                                            <li>
                                                <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New user registered
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         Just now
                                                    </div>
                                                </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New order received
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         10 mins
                                                    </div>
                                                </div>
                                                </a>
                                            </li>
                                            <li>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-danger">
                                                                <i class="fa fa-bolt"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 Order #24DOP4 has been rejected. <span class="label label-sm label-danger ">
                                                                Take action <i class="fa fa-share"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         24 mins
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New user registered
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         Just now
                                                    </div>
                                                </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New user registered
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         Just now
                                                    </div>
                                                </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New user registered
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         Just now
                                                    </div>
                                                </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New user registered
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         Just now
                                                    </div>
                                                </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New user registered
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         Just now
                                                    </div>
                                                </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New user registered
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         Just now
                                                    </div>
                                                </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <i class="fa fa-bell-o"></i>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                 New user registered
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">
                                                         Just now
                                                    </div>
                                                </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_1_3">
                                    <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                                        <div class="row">
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Robert Nilson </a>
                                                        <span class="label label-sm label-success label-mini">
                                                        Approved </span>
                                                    </div>
                                                    <div>
                                                         29 Jan 2013 10:45AM
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Lisa Miller </a>
                                                        <span class="label label-sm label-info">
                                                        Pending </span>
                                                    </div>
                                                    <div>
                                                         19 Jan 2013 10:45AM
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Eric Kim </a>
                                                        <span class="label label-sm label-info">
                                                        Pending </span>
                                                    </div>
                                                    <div>
                                                         19 Jan 2013 12:45PM
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Lisa Miller </a>
                                                        <span class="label label-sm label-danger">
                                                        In progress </span>
                                                    </div>
                                                    <div>
                                                         19 Jan 2013 11:55PM
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Eric Kim </a>
                                                        <span class="label label-sm label-info">
                                                        Pending </span>
                                                    </div>
                                                    <div>
                                                         19 Jan 2013 12:45PM
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Lisa Miller </a>
                                                        <span class="label label-sm label-danger">
                                                        In progress </span>
                                                    </div>
                                                    <div>
                                                         19 Jan 2013 11:55PM
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Eric Kim </a>
                                                        <span class="label label-sm label-info">
                                                        Pending </span>
                                                    </div>
                                                    <div>
                                                         19 Jan 2013 12:45PM
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Lisa Miller </a>
                                                        <span class="label label-sm label-danger">
                                                        In progress </span>
                                                    </div>
                                                    <div>
                                                         19 Jan 2013 11:55PM
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Eric Kim </a>
                                                        <span class="label label-sm label-info">
                                                        Pending </span>
                                                    </div>
                                                    <div>
                                                         19 Jan 2013 12:45PM
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Lisa Miller </a>
                                                        <span class="label label-sm label-danger">
                                                        In progress </span>
                                                    </div>
                                                    <div>
                                                         19 Jan 2013 11:55PM
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Eric Kim </a>
                                                        <span class="label label-sm label-info">
                                                        Pending </span>
                                                    </div>
                                                    <div>
                                                         19 Jan 2013 12:45PM
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 user-info">
                                                <img alt="" src="<?php echo URL_VIEW;?>admin/layout/img/avatar.png" class="img-responsive"/>
                                                <div class="details">
                                                    <div>
                                                        <a href="javascript:;">
                                                        Lisa Miller </a>
                                                        <span class="label label-sm label-danger">
                                                        In progress </span>
                                                    </div>
                                                    <div>
                                                         19 Jan 2013 11:55PM
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END TABS-->
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>
            <div class="clearfix">
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light calendar ">
                        <div class="portlet-title ">
                            <div class="caption">
                                <i class="icon-calendar font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp bold uppercase">Feeds</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="calendar">
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
                <div class="col-md-6 col-sm-6">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light ">
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
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>
            <?php */?>
            
            
        </div>
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->

</div>
<!-- END CONTAINER -->


<script type="text/javascript">

    jQuery(function()
        {
            setInterval(function()
                {
                    var orgId = '<?php echo $orgId;?>';
                    jQuery(".checkedInEmployees").load('refreshCheckedInUsers.php?orgId='+orgId);
                }, 1000);
            
        });
</script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>                   
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script src="<?php echo URL_VIEW;?>global/plugins/jquery-knob/js/jquery.knob.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-knob-dials.js"></script>





<script src="<?php echo URL_VIEW; ?>global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>


