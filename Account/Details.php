<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>
global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php 
    $request1 = URL."Accounts/getUserData/".$user_id.".json";
    $response1 = \Httpful\Request::get($request1)->
send();
?>
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>
                Account
                <small>Details</small>
            </h1>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li> <i class="fa fa-home"></i>
                <a href="<?php echo URL_VIEW;?>">Home</a> <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo URL_VIEW."Account/Details";?>">Account</a>
            </li>
        </ul>

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart theme-font hide"></i>
                    <span class="caption-subject theme-font bold uppercase">Account Details</span>
                    <!-- <span class="caption-helper hide">weekly stats...</span> -->
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar"></div>

                <table class="dataTable1 table table-bordered table-hover" id="sample_9">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Organisation</th>
                            <th>Amount</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $totalAmount = 0;
                            if(isset($response1->
                                                    body->result) && !empty($response1->body->result)){
                                $count = 0;
                                foreach($response1->body->result as $key=>$value){ 
                                    $count++;
                                    $value2=get_object_vars($value);
                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td>
                                                            <?php echo $count;?></td>
                                                        <td>
                                                            <img src="<?php echo URL."webroot/files/organization/logo/".$value->
                                                            Organization->logo_dir."/thumb_".$value->Organization->logo;?>" alt="logo" style="height: 40px;width: 40px;border: 1px solid blue;"/>&nbsp;&nbsp;&nbsp;
                                                            <?php echo ucwords($value->Organization->title);?></td>
                                                        <td>
                                                            <?php echo "\$ ".round($value2['0']->amount,3);?></td>
                                                        <td>
                                                            <a class="btn btn-xs green" href="<?=URL_VIEW."Account/userOrgDetails?org_id=".$value->Account->organization_id;?>">View All</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                    $totalAmount += $value2['0']->
                                                    amount;
                                }
                            }else{ ?>
                        <tr class="odd gradeX">
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-right">
                        <div class="btn">
                            Total amount :
                            <div class="btn blue">
                                <?php echo "\$ ".round($totalAmount,3);?></div>
                        </div>
                    </div>
                    
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
            $('#sample_9').dataTable();
    });
</script>