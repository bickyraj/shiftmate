<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php 
    $request = URL."Accounts/getOrgUserData/".$orgId."/".$_GET['user_id'].".json";
    $response = \Httpful\Request::get($request)->send();
//    echo "<pre>";
//    print_r($response);
//    echo "</pre>";
?>

    <div class="page-head">
        <div class="container">
            <div class="page-title">
				<h1>Account <small> User Details</small></h1>
			</div>  
        </div>
    </div>
    <div class="page-content">
        <div class="container">
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo URL_VIEW;?>">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="<?php echo URL_VIEW."Account/orgDetails";?>">Account</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="<?php echo URL_VIEW."Account/orgUserDetails?user_id=".$_GET['user_id'];?>">User Account</a>
                </li>
            </ul>

            <div class="portlet light" style="min-height:50vh;">
            	<div class="portlet-title">
                    <div class="caption caption-md">
                        <i class="fa fa-usd fa-2x theme-font"></i>
                        <span class="caption-subject theme-font bold uppercase">Account of <span class="font-blue"><?php if(isset($response->body->result[0]->User)){echo ucwords($response->body->result[0]->User->fname." ".$response->body->result[0]->User->lname);}?></span></span>
                        <span class="caption-helper hide">from start of financial year</span>
                    </div>
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

                    <div class="margin-top-10" id="detailTable">
                        <!-- <table class="dataTable1 table table-bordered table-hover" id="sample_9">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Shift</th>
                                    <th>Date</th>
                                    <th>Worked Hours</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody1">
                                <?php
                                    $totalAmount = 0;
                                    if(isset($response->body->result) && !empty($response->body->result)){
                                        $count = 0;
                                        foreach($response->body->result as $key=>$value){ $count++;?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $count;?></td>
                                            <td><?php if(isset($value->Shift->title)){echo $value->Shift->title;}else{echo "-";}?></td>
                                            <td><?php echo $value->Account->date;?></td>
                                            <?php $worked = (int)$value->Account->workedhours;?>
                                            <td><?php echo $worked." Hours ".(int)(($value->Account->workedhours - $worked)*60)." Minutes";?></td>
                                            <?php $account_notax = (($value->Account->workedhours)*($value->Account->paymentfactor)*($value->Account->wage));
                                                    $account_tax = (($account_notax)-(($value->Account->tax)*($account_notax)));
                                            ?>
                                            <td><?php echo "\$ ".round($account_tax,3); ?></td>
                                        </tr>
                                        <?php
                                            $totalAmount += $account_tax ;
                                        }
                                    }else{ ?>
                                        <tr class="odd gradeX"><td>-</td><td>-</td><td>-</td><td>-</td><td></td><td></td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="btn pull-right">Total amount : 
                                <div class="btn blue" id="totalAmount"><?php echo "\$ ".round($totalAmount,3);?></div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>

<script>
    $(document).ready(function(){
        	TableManaged.init();
	       ComponentsPickers.init();
        // $('#sample_9').dataTable();
    });
</script>

<script src="<?php echo URL_VIEW; ?>js/date-format/date.format.js" type="text/javascript"></script>
<script type="text/javascript">

    $(function()
        {
            userId = <?php echo $_GET['user_id']; ?>;
            function loadShiftHistory(range)
            {
                var str = range.split("/");
                var sD = new Date(str[0]);
                var sD = sD.format("dS mmm, yyyy");

                var eD = new Date(str[1]);
                var eD = eD.format("dS mmm, yyyy");

                $("#yearInfo").html("").append('<i style="color:#BFBFBF;">from</i> '+'<span class="font-green">'+sD+'</span>'+' <i style="color:#BFBFBF;">to</i> '+'<span class="font-green">'+eD+'</span>');

                $("#shiftHistoryLoading").show();
                $("#detailTable").html("").load("../loadOrgUserDetails.php?range="+range+"&userId="+userId, function(event)
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