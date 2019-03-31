<?php
	session_start();
	include('config.php');
	include('function.php');
	//include('loginCheck.php');
	include('url_get_value.php');

	$range = explode("/", $_GET['range']);
	$sDate = $range[0];
	$eDate = $range[1];

    $request = URL."Accounts/getOrgUserData/".$orgId."/".$_GET['userId']."/".$sDate."/".$eDate.".json";
    $response = \Httpful\Request::get($request)->send();
?>
<table class="dataTable1 table table-bordered table-hover" id="sample_9">
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
</div>