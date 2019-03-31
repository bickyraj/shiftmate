<?php 

session_start();
    include('config.php');
    include('function.php');
    //include('loginCheck.php');
    include('url_get_value.php');

    $range = explode("/", $_GET['range']);
    $sDate = $range[0];
    $eDate = $range[1];


    $request = URL."Accounts/getOrgUserData/".$_GET['orgId']."/".$userId."/".$sDate."/".$eDate.".json";
    $response = \Httpful\Request::get($request)->send();
?>
<div id="dTables">
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
                        <tr class="odd gradeX"><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="row tAmount">
                <div class="pull-right"><div class="btn">Total amount : <div class="btn blue"><?php echo "\$".round($totalAmount,3);?></div></div></div>
            </div>
</div>

<?php 

    $url = URL."Accounts/getEmpRelatedOrgHistory/".$_GET['orgId']."/".$user_id."/".$sDate."/".$eDate.".json";
    $response1 = \Httpful\Request::get($url)->send();

    $total = $response1->body;
 ?>

 <div class="portlet-body" id="totalSep">
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
