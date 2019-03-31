
<?php 
    $url = URL."Accounts/getShiftHistory/".$orgId.".json";
    $response = \Httpful\Request::get($url)->send();

    $shiftHistoryStat = $response->body->status;
    // fal($response);
    $shiftHistories = $response->body->history;
    // fal($shiftHistories);
?>

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Shift History</h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <!-- BEGIN PAGE BREADCRUMB -->
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
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="fa fa-list-ul font-green-sharp"></i>
                            <span class="caption-subject theme-font bold uppercase">Shift History</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                        <!-- <div class="actions">
                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                <label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
                                <input type="radio" name="options" class="toggle" id="option1">Today</label>
                                <label class="btn btn-transparent grey-salsa btn-circle btn-sm">
                                <input type="radio" name="options" class="toggle" id="option2">Week</label>
                                <label class="btn btn-transparent grey-salsa btn-circle btn-sm">
                                <input type="radio" name="options" class="toggle" id="option2">Month</label>
                            </div>
                        </div> -->
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control input-sm" id="yearSelect">
                                        <?php $cm = date('m'); ?>
                                        <?php if ($m != 7) {
                                            $y = date('Y') -1;
                                        }else
                                        {
                                            $y = date('Y');
                                        } ?>
                                        <?php $daterange = range(2010, $y, 1);?>
                                        <?php foreach ($daterange as $year): ?>
                                            <option value="<?php echo $year; ?>" <?php echo ($year==$y)?"selected":"";?>><?php echo $year; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control input-sm" id="cycleType">
                                        <option value="1" selected>Week</option>
                                        <option value="2">Fortnight</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control input-sm" id="wfSelect">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <p class="help-block" id="yearInfo"></p>
                            </div>
                        </div>
                        <small>Fiscal Year starts from July 1st to June 30th.</small>
                        <div id="shiftHistoryLoading" style="text-align:center;">
                            <img src="<?php echo URL_VIEW; ?>admin/layout/img/loading.gif" alt="loading"/>
                        </div>
                        <div class="table-scrollable" id="sTable">
                            <!-- <table class="table table-striped table-bordered table-advance table-hover">
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
                                                     <?php echo round($shiftHistory->{0}->workedhours,2); ?> <span class="label label-sm label-success label-mini">
                                                                                                             Paid </span>
                                                </td>
                                                <td>
                                                     <?php echo round($shiftHistory->{0}->lesshours, 2); ?> <span class="label label-sm label-success label-mini">
                                                                                                             Paid </span>
                                                </td>
                                                <td>
                                                     <?php echo round($shiftHistory->{0}->morehours, 2); ?> <span class="label label-sm label-success label-mini">
                                                                                                             Paid </span>
                                                </td>
                                            </tr>  
                                        <?php endforeach ?>
                                        
                                    <?php endif ?>
                                </tbody>
                            </table> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URL_VIEW; ?>js/date-format/date.format.js" type="text/javascript"></script>
<script type="text/javascript">

    $(function()
        {
            function loadShiftHistory(range)
            {
                var str = range.split("/");
                var sD = new Date(str[0]);
                var sD = sD.format("dS mmm, yyyy");

                var eD = new Date(str[1]);
                var eD = eD.format("dS mmm, yyyy");

                $("#yearInfo").html("").append('<i style="color:#BFBFBF;">from</i> '+'<span class="font-green">'+sD+'</span>'+' <i style="color:#BFBFBF;">to</i> '+'<span class="font-green">'+eD+'</span>');

                $("#shiftHistoryLoading").show();
                $("#sTable").html("").load("../loadOrgShiftHistory.php?range="+range, function(event)
                    {
                        $("#shiftHistoryLoading").hide();
                    });
            }

            function populateWf(year, cycle)
            {
                if(cycle == 1)
                {
                    var url = "../getWeekOfFiscalYear.php?year=";
                }else
                {
                    var url = "../getFortnightOfFiscalYear.php?year=";
                }
                $.ajax(
                    {
                        url:url+year,
                        type:'post',
                        async:false,
                        success:function(res)
                        {
                            var data = JSON.parse(res);
                            var opts = "";

                            var c = "Week";

                            var d = new Date().getTime();
                            if(cycle == 2)
                            {
                                c = "Fortnight";
                            }
                            $.each(data, function (i,v)
                            {
                                var str = v.split("/");

                                var sD = new Date(str[0]).getTime();
                                var eD = new Date(str[1]).getTime();

                                var select = "";
                                if( d >= sD && d<=eD )
                                {
                                    select = "selected";
                                }
                              opts += "<option value="+v+" "+select+">"+c+" "+i+"</option>";
                            });

                            $("#wfSelect").html("").append(opts);

                        }

                    });
            }

            populateWf($("#yearSelect").val(), $("#cycleType").val());

            $("#yearSelect").on('change', function(event)
                {
                    var year = $(this).val();
                    var c = $("#cycleType").val();

                    populateWf(year, c);

                    var range = $("#wfSelect").val();

                    loadShiftHistory(range);

                });

            $("#cycleType").on('change', function(event)
                {
                    var year = $("#yearSelect").val();
                    var c = $(this).val();

                    populateWf(year, c);

                    var range = $("#wfSelect").val();

                    loadShiftHistory(range);

                });

            $("#wfSelect").on('change', function(event)
                {
                    var range = $(this).val();
                    loadShiftHistory(range);
                });

            loadShiftHistory($("#wfSelect").val());

        });
</script>