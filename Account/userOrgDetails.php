<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php 
    $request = URL."Accounts/getOrgUserData/".$_GET['org_id']."/".$user_id.".json";
    $response = \Httpful\Request::get($request)->send();

    // fal($response->body);

    $url = URL."Accounts/getEmpRelatedOrgHistory/".$_GET['org_id']."/".$user_id.".json";
    $response1 = \Httpful\Request::get($url)->send();

    $total = $response1->body;
    
?>
<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Account <small> Organisation Details</small></h1>
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
                        <a href="<?php echo URL_VIEW."Account/Details";?>">My Figures</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?php echo URL_VIEW."Account/userOrgDetails?org_id=".$_GET['org_id'];?>">Organisation Account</a>
                    </li>
                </ul>

<div class="portlet light ">
    <div class="portlet-title">
        <div class="caption caption-md">
            <i class="icon-bar-chart theme-font hide"></i>
            <span class="caption-subject theme-font bold uppercase">Account Overview</span>
            <!-- <span class="caption-helper hide">weekly stats...</span> -->
        </div>
        <div class="tools">
            <select id="yearSelect" class="table-group-action-input form-control input-inline input-small input-sm">
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
            <select id="cycleType" class="table-group-action-input form-control input-inline input-small input-sm">
                <option value="1" selected>Week</option>
                <option value="2">Fortnight</option>
            </select>
            <select id="wfSelect" class="table-group-action-input form-control input-inline input-small input-sm">
            </select>
            <div class="row">
                <div class="col-md-12">
                    <p class="help-block" id="yearInfo"></p>
                </div>
            </div>
        </div>
    </div>
    <div id="shiftHistoryLoading1" style="text-align:center;">
        <img src="<?php echo URL_VIEW; ?>admin/layout/img/loading.gif" alt="loading"/>
    </div>
    <div id="totalSep">
        <div class="portlet-body">
            <?php if ($total->status == 1): ?>
                <div class="row list-separated">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="font-grey-mint font-sm">
                             Total Shifts
                        </div>
                        <div class="uppercase font-hg font-red-flamingo">
                             <?php echo $total->total->Account->totalShifts;?> <!-- <span class="font-lg font-grey-mint">$</span> -->
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="font-grey-mint font-sm">
                             Worked Hours
                        </div>
                        <div class="uppercase font-hg theme-font">
                             <?php echo round($total->total->Account->workedhours, 3);?> <!-- <span class="font-lg font-grey-mint">$</span> -->
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="font-grey-mint font-sm">
                             Total Amount
                        </div>
                        <div class="uppercase font-hg font-purple">
                             <?php echo round($total->total->Account->totalAmount, 3);?> <span class="font-lg font-grey-mint">$</span>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row list-separated">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="font-grey-mint font-sm">
                             Total Shifts
                        </div>
                        <div class="uppercase font-hg font-red-flamingo">
                             0 <!-- <span class="font-lg font-grey-mint">$</span> -->
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="font-grey-mint font-sm">
                             Worked Hours
                        </div>
                        <div class="uppercase font-hg theme-font">
                             0.00 <!-- <span class="font-lg font-grey-mint">$</span> -->
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="font-grey-mint font-sm">
                             Total Amount
                        </div>
                        <div class="uppercase font-hg font-purple">
                             0 <span class="font-lg font-grey-mint">$</span>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="portlet light">
	<div class="portlet-title">
        <div class="caption caption-md">
            <i class="fa theme-font hide"></i>
            <span class="caption-subject theme-font bold uppercase">Organisation Account Of <i class="font-blue"><?php if(isset($response->body->result[0]->Organization)){echo ucwords($response->body->result[0]->Organization->title);}?></i> &nbsp;&nbsp;</span>
            <!-- <span class="caption-helper">from start of financial year</span> -->
        </div>
	</div>
	<div class="portlet-body">
		<div class="table-toolbar">
        </div>
        <!-- <div id="shiftHistoryLoading" style="text-align:center;">
            <img src="<?php echo URL_VIEW; ?>admin/layout/img/loading.gif" alt="loading"/>
        </div> -->
        <div id="dTable">
            <table class="dataTable1 table table-bordered table-hover">
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
                                    $account_tax = (($account_notax)-($value->Account->tax)*($account_notax));
                            ?>
                            <td><?php echo "\$ ".round($account_tax,3);?></td>
                        </tr>
                        <?php
                            $totalAmount += $account_tax ;
                        }
                    }else{ ?>
                        <tr class="odd gradeX"><td>-</td><td>-</td><td>-</td><td>-</td></tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="row tAmount">
                <div class="pull-right"><div class="btn">Total amount : <div class="btn blue"><?php echo "\$".round($totalAmount,3);?></div></div></div>
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
            function loadAccountTableEmp(range)
            {
                var str = range.split("/");
                var sD = new Date(str[0]);
                var sD = sD.format("dS mmm, yyyy");

                var eD = new Date(str[1]);
                var eD = eD.format("dS mmm, yyyy");

                $("#yearInfo").html("").append('<i style="color:#BFBFBF;">from</i> '+'<span class="font-green">'+sD+'</span>'+' <i style="color:#BFBFBF;">to</i> '+'<span class="font-green">'+eD+'</span>');

                var orgId = <?php echo $_GET['org_id'];?>;

                // $("#shiftHistoryLoading").show();
                $("#shiftHistoryLoading1").show();

                $("#totalSep").html("").load("../loadAccountTableEmp.php?range="+range+"&orgId="+orgId+" #totalSep", function(event)
                    {
                    });

                $("#dTable").html("").load("../loadAccountTableEmp.php?range="+range+"&orgId="+orgId+" #dTables", function(event)
                    {
                        $("#shiftHistoryLoading1").hide();
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

                    loadAccountTableEmp(range);

                });

            $("#cycleType").on('change', function(event)
                {
                    var year = $("#yearSelect").val();
                    var c = $(this).val();

                    populateWf(year, c);

                    var range = $("#wfSelect").val();

                    loadAccountTableEmp(range);

                });

            $("#wfSelect").on('change', function(event)
                {
                    var range = $(this).val();
                    loadAccountTableEmp(range);
                });

            loadAccountTableEmp($("#wfSelect").val());

        });
</script>