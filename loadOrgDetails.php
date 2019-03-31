<?php 

    session_start();
    include('config.php');
    include('function.php');
    //include('loginCheck.php');
    include('url_get_value.php');

    $range = explode("/", $_GET['range']);
    $sDate = $range[0];
    $eDate = $range[1];

    $request1 = URL."Accounts/getOrgOverall/".$orgId."/".$sDate."/".$eDate.".json";
    $response1 = \Httpful\Request::get($request1)->send();
?>
<table class="dataTable1 table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Amount</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalAmount = 0;
        if(isset($response1->body->result) && !empty($response1->body->result)){
            $count = 0;
            foreach($response1->body->result as $key=>$value){ 
                $count++;
                $value2=get_object_vars($value);
                ?>
            <tr class="odd gradeX">
                <td><?php echo $count;?></td>
                <td><img src="<?php echo URL."webroot/files/user/image/".$value->User->image_dir."/thumb2_".$value->User->image;?>" alt="<?php echo strtoupper($value->User->fname{0}.$value->User->lname{0});?>" style="height: 30px;width: 30px;"/>&nbsp;&nbsp;&nbsp;<?php echo ucwords($value->User->fname." ".$value->User->lname);?></td>
                <td><?php echo "\$ ".round($value2['0']->amount,3);?></td>
                <td><a class="btn btn-xs green" href="<?=URL_VIEW."Account/orgUserDetails?user_id=".$value->Account->user_id;?>">View All</a></td>
            </tr>
            <?php
                $totalAmount += $value2['0']->amount;
            }
        }else{ ?>
            <tr class="odd gradeX"><td>--</td><td>--</td><td>--</td><td>--</td></tr>
        <?php } ?>
    </tbody>
</table>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <div>Total amount - <span class="label label-primary"><?php echo "\$ ".round($totalAmount,3);?></span></div>
        </div>
    </div>
</div>