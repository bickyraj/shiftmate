
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/jquery-multi-select/css/multi-select.css"/>

<link href="<?php echo URL_VIEW;?>global/plugins/icheck/skins/all.css" rel="stylesheet"/>
<style>
.requestForm label{
    color:#697882 !important;
}

</style>
<?php 
    if(isset($_POST['requestTimeSubmit']))
    {
        if(isset($_FILES['document'])){
            $_POST['data']['Requesttimeoff']['document']=array(
                'name'=>$_FILES['document']['name'],
                'type'=> $_FILES['document']['type'],
                'tmp_name'=> $_FILES['document']['tmp_name'],
                'error'=> $_FILES['document']['error'],
                'size'=> $_FILES['document']['size']
            );
        }

        // fal($_POST);

        $url = URL . "Requesttimeoffs/addRequesttimeoff.json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

        if($response->body->status == 1){
            ?><script>toastr.success('Your leave request has been successfully submitted');</script> <?php
        }elseif($response->body->status == 0){
            ?><script>toastr.error('Sorry! could not submitted your request this time, please try again later.');</script> <?php
        }

    }

    $userRelationDetails = loginUserRelationToOther($user_id);

    $branchManagerList =  (array) $userRelationDetails->branchManager;
    $branchManagerListArr = array_keys($branchManagerList);

    $boardList = (array) $userRelationDetails->board;
    $boardListArr = array_keys($boardList);

    $url = URL."OrganizationUsers/getOrgListOfUser/".$user_id.".json";
    $userOrgList = \Httpful\Request::get($url)->send()->body;

    // fal($userOrgList);

    $url = URL."BranchUsers/getUserRelatedBranches/".$user_id.".json";
    $userBranchList = \Httpful\Request::get($url)->send()->body->list;

    $branchListArr;
    foreach ($userBranchList as $key => $value) {

        $branchListArr[] = $value->Branch->id;
    }
?>

<div class="page-head">
    <div class="container">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1>Request Time Off <!-- <small>statistics & reports</small> --></h1>
        </div>
        <!-- END PAGE TITLE -->
    </div>
</div>
<!-- END PAGE HEAD -->
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="container">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?=URL_VIEW;?>">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="javascript:;">Leave</a>
                    <i class="fa fa-circle"></i>
                </li>
                 <li>
                    <a href="<?php echo URL_VIEW."leaverequests/requestTimeOff";?>">Request Time Off</a>
                </li>
            </ul>
        <!-- END PAGE BREADCRUMB -->
        <!-- BEGIN PAGE CONTENT INNER -->
        <div class="row margin-top-10">
            <div class="col-md-12 col-sm-12">
                <!-- BEGIN PORTLET-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Request Time Off</span>
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
                        <form action="" method="POST" role="form" enctype="multipart/form-data">
                            <div class="row requestForm">
                                <input type="hidden" name="data[Requesttimeoff][user_id]" value="<?php echo $user_id; ?>">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    
                                    <!-- <div class="uppercase font-hg font-red-flamingo">
                                         13,760 <span class="font-lg font-grey-mint">$</span>
                                    </div> -->
                                    <div class="form-group">
                                        <label class="font-grey-mint font-md" >
                                        Are you taking a portion of a day or a whole day?
                                        </label>
                                        <div class="input-group margin-top-10">
                                            <div class="icheck-inline">
                                                <label>
                                                <input type="radio" name="data[Requesttimeoff][timeoffdaytype_id]" value="1" checked class="icheck dayTypeRad" data-radio="iradio_flat-grey"> All Day</label>
                                                <label>
                                                <input type="radio" name="data[Requesttimeoff][timeoffdaytype_id]" value="2" class="icheck dayTypeRad" data-radio="iradio_flat-grey"> Multiple Day </label>
                                                <label>
                                                <input type="radio" name="data[Requesttimeoff][timeoffdaytype_id]" value="3" class="icheck dayTypeRad" data-radio="iradio_flat-grey"> Partial Day </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-3 col-xs-6">
                                    <div class="form-group col-md-4">
                                        <label class="font-grey-mint font-md" >
                                            Time-off Type
                                        </label>
                                        <div class="clear-fix"></div>
                                        <select required class="form-control margin-top-10 input-small select2me" id="leaveTypeSelect" name="data[Requesttimeoff][timeofftype_id]" data-placeholder="Select...">
                                            <option value="1">Paid</option>
                                            <option value="2">Unpaid</option>
                                            <option value="3">Sick</option>
                                            <option value="4">Compassionate</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3" id="document" style="display:none;">
                                        <label class="font-grey-mint font-md" >Document</label>
                                        <div class="clear-fix"></div>
                                        <div class="fileinput fileinput-new margin-top-10" style="margin-bottom:0px;" data-provides="fileinput">
                                            <span class="btn default btn-file">
                                            <span class="fileinput-new">
                                            Select file </span>
                                            <span class="fileinput-exists">
                                            Change </span>
                                            <input type="file" name="document" disabled required>
                                            </span>
                                            <span class="fileinput-filename">
                                            </span>
                                            &nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
                                            </a>
                                        </div>

                                    </div>
                                    <div class="form-group col-md-4" id="paidHour">
                                        <label class="font-grey-mint font-md" >
                                            Hour
                                        </label>
                                        <div class="clear-fix"></div>
                                        <input type="number" name="data[Requesttimeoff][paidhour]" class="form-control input-md" style="margin-top:9px;" min="1" value="8" required>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label class="font-grey-mint font-md" >Start Date</label>
                                    <div class="input-group input-medium date date-picker" id="startDate" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                        <input required type="text" name="data[Requesttimeoff][startdate]" class="form-control">
                                        <span class="input-group-btn">
                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3 form-group" id="endDateDiv">
                                    <label class="font-grey-mint font-md" >End Date</label>
                                    <div class="input-group input-medium date date-picker" id="endDate" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                        <input required type="text" name="data[Requesttimeoff][enddate]" class="form-control">
                                        <span class="input-group-btn">
                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>

                                <div id="timeDiv" style="display:none;">
                                    <div class="col-md-3 form-group">
                                        <label class="font-grey-mint font-md" >Start Time</label>
                                        <div class="input-icon">
                                            <i class="fa fa-clock-o"></i>
                                            <input required type="text" name="data[Requesttimeoff][starttime]" disabled class="form-control timepicker timepicker-no-seconds">
                                        </div>
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label class="font-grey-mint font-md" >End Time</label>
                                        <div class="input-icon">
                                            <i class="fa fa-clock-o"></i>
                                            <input type="text" required name="data[Requesttimeoff][endtime]" disabled class="form-control timepicker timepicker-no-seconds">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label class="font-grey-mint font-md" >Organisation</label>
                                    <select required class="form-control input-medium select2me" id="orgSelect" name="data[Requesttimeoff][organization_id]" data-placeholder="Select...">
                                        <?php foreach ($userOrgList->list as $org): ?>
                                            <option value="<?php echo $org->Organization->id; ?>"><?php echo $org->Organization->title; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label class="font-grey-mint font-md" >Branch</label>
                                    <select required class="form-control input-medium select2me" name="data[Requesttimeoff][branch_id]" id="branchSelect" data-placeholder="Select...">
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label class="font-grey-mint font-md" >Department</label>
                                    <select required class="form-control input-medium select2me" name="data[Requesttimeoff][board_id]" id="deptSelect" data-placeholder="Select...">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="font-grey-mint font-md" >Message</label>
                                    <textarea required class="form-control" rows="3" name="data[Requesttimeoff][message]" style="min-height:150px; max-width:500px;"></textarea>
                                </div>
                            </div>
                            <button type="submit" name="requestTimeSubmit" class="btn btn-md green">Submit</button>
                        </form>
                    </div>
                </div>
                <!-- END PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT INNER -->
    </div>
</div>


<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-dropdowns.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>

<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script src="<?php echo URL_VIEW;?>global/plugins/icheck/icheck.min.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/form-icheck.js"></script>

<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>


<!-- BEGIN END LEVEL SCRIPTS -->
<script>
     jQuery(document).ready(function(){
        FormiCheck.init(); // init page demo
        ComponentsDropdowns.init();
        ComponentsPickers.init();

        $("#leaveTypeSelect").on('change', function(event)
            {
                var e = $(this);

                if(e.val() == 1)
                {
                    $("#paidHour").show();
                    $('input[name="data[Requesttimeoff][paidHour]"]').prop('disabled', false);
                }else{
                    $("#paidHour").hide();
                    $('input[name="data[Requesttimeoff][paidHour]"]').prop('disabled', true);
                }
            });

        $('#startDate').on('changeDate', function(selected)
            {
                var e = $(this);
                var dayType = $('input[name="data[Requesttimeoff][timeoffdaytype_id]"]:checked').val();
                if( dayType == 1 )
                {
                    var minDate = new Date(selected.date.valueOf());
                    $('#endDate').datepicker('remove');
                    $('#endDate').datepicker('setStartDate', minDate);
                    $('#endDate').datepicker('setEndDate', minDate);
                    $('#endDate').datepicker('setDate', minDate);
                }
                else if( dayType == 2 )
                {
                    var minDate = new Date(selected.date.valueOf());
                    $('#endDate').datepicker('remove');
                    $('#endDate').datepicker('setStartDate', minDate);
                    $('#endDate').datepicker('setDate', minDate);
                }
            });

        $('input[name="data[Requesttimeoff][timeoffdaytype_id]"]').live('ifToggled', function (event)
            {
                var dayType = $(this).val();
                    $('#startDate').datepicker('remove');
                    $('#startDate').datepicker();

                    $('#endDate').datepicker('remove');
                    $('#endDate').datepicker();

                    $('input[name="data[Requesttimeoff][startdate]"]').val('');
                    $('input[name="data[Requesttimeoff][enddate]"]').val('');

                    if(dayType == 3)
                    {
                        $("#endDateDiv").hide();
                        $('input[name="data[Requesttimeoff][enddate]"]').prop('disabled', true);
                        $("#timeDiv").show();
                        $("#timeDiv").find('.timepicker').prop('disabled', false);
                    }else
                    {
                        $("#endDateDiv").show();
                        $('input[name="data[Requesttimeoff][enddate]"]').prop('disabled', false);
                        $("#timeDiv").hide();
                        $("#timeDiv").find('.timepicker').prop('disabled', true);
                    }
                
            });

        $("#orgSelect").on('change', function(event)
            {
                var orgId = $(this).val();

                var branchManagerArr = '<?php echo json_encode($branchManagerListArr);?>';
                var arr = JSON.parse(branchManagerArr);
                // if($.inArray(orgId, arr) != -1)
                // {
                //     $("#branchSelect").prop("disabled", true);
                //     $("#deptSelect").prop("disabled", true);
                // }else
                // {
                    getBranchList(orgId);
                    var branchId = $("#branchSelect").val();
                    getDeptList(branchId);
                // }
            });

        $("#branchSelect").on('change', function(event)
            {
                var branchId = $(this).val();
                    getDeptList(branchId);

            });

        $("#leaveTypeSelect").on('change', function(event)
            {
                var leaveType = $(this).val();

                if( leaveType == "3")
                {
                    $("#document").show();

                    $('input[name="document"]').prop("disabled", false);
                }else
                {
                    $("#document").hide();

                    $('input[name="document"]').prop("disabled", true);
                }
            });

        function getBranchList(orgId)
        {
            var url = '<?php echo URL; ?>/Branches/BranchesList/'+orgId+'.json';
            var data;

            $.ajax(
                {
                    url:url,
                    dataType:'jsonp',
                    async:false,
                    success:function(res)
                    {
                        data = res.branches;
                    }
                });

            // var arr = '<?php echo json_encode($branchListArr); ?>';
            // var branchArr = JSON.parse(arr);
            var opt="";
            if(typeof data !=="undefined")
            {

                $.each(data, function(k,v)
                    {
                        // if($.inArray(k, branchArr) != -1)
                        // {
                            opt += '<option value="'+k+'">'+v+'</option>';
                        // }
                        
                    });
            }else
            {
                opt = '<option value="">No Branches</option>';
            }

            $("#branchSelect").html("").append(opt);
            $("#branchSelect").select2();


        }

        function getDeptList(branchId)
        {   
            //console.log(branchId);
            var url = '<?php echo URL; ?>/Boards/getBoardListOfBranch/'+branchId+'.json';
            var data;

            $.ajax(
                {
                    url:url,
                    type:'POST',
                    dataType:'jsonp',
                    async:false,
                    success:function(res)
                    {

                        data = res.boardList;
                    }
                });

            var arr = '<?php echo json_encode($boardListArr); ?>';

            var boardListArr = JSON.parse(arr);
            var opt="";

            $.each(data, function(k,v)
                {
                    if($.inArray(v.Board.id, boardListArr) != -1)
                    {
                        opt += '<option value="'+v.Board.id+'">'+v.Board.title+'</option>';
                    }
                    
                });

            $("#deptSelect").html("").append(opt);
            $("#deptSelect").select2();
        }

        function initSelectBox()
        {
            var orgId = $("#orgSelect").val();
            getBranchList(orgId);


            var branchId = $("#branchSelect").val();
            getDeptList(branchId);
        }

        initSelectBox();
      });
</script>