
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>

 <?php 


 if(isset($_POST['submit_date'])){

        $url = URL."ShiftUsers/paymentFactorsByShiftId/".$user_id."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
        $response = \Httpful\Request::get($url)->send();
    }else

    {
        $url = URL."ShiftUsers/paymentFactorsByShiftId/".$user_id.".json";
        $response = \Httpful\Request::get($url)->send();
    }

    if(isset($response->body->arr)){
        $shiftFactors = $response->body->arr;
    }
    
    // echo "<pre>";
    // echo $user_id;
    // echo print_r($shiftFactors);
    // die();
?>

<?php 

if(isset($_POST['submit_date'])){

     $url1 = URL."ShiftUsers/getTotalAttendace/".$user_id."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
    $response1 = \Httpful\Request::get($url1)->send();
}else{

     $url1 = URL."ShiftUsers/getTotalAttendace/".$user_id.".json";
      $response1 = \Httpful\Request::get($url1)->send();
}
    $total = $response1->body;

    // echo "<pre>";
    //     echo print_r($total);
    //     die();
 ?>

<!-- tab portion -->
<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>User Income</h1>
			</div>  
         </div>
         </div>
         <div class="page-content">
            <div class="container">
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?=URL_VIEW;?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?=URL_VIEW."factors/userFactors";?>">Income</a>
                    </li>
                </ul>

<!-- //**************************************** -->

<!-- //**************************************** -->
<div class="col-md-8">
<div class="tiles">
    <div class="tile bg-purple">
        <div class="tile-body">
            <i class="fa fa-bar-chart-o"></i>
        </div>
        <div class="tile-object">
            <div class="name">
                 Total Attendance
            </div>
            <div class="number">
            <?php echo $total->totalShifts; ?>
            </div>
        </div>
    </div>
    <div class="tile bg-purple">
        <div class="tile-body">
            <i class="fa fa-briefcase"></i>
        </div>
        <div class="tile-object">
            <div class="name">
                 Total Payment Offers
            </div>
            <div class="number">
                <?php echo $total->totalTitle; ?>
            </div>
        </div>
    </div>
    
   <!--  <div class="tile bg-purple">
        <div class="corner">
        </div>
        <div class="check">
        </div>
        <div class="tile-body">
            <i class="fa fa-cogs"></i>
        </div>
        <div class="tile-object">
            <div class="name">
                 Settings
            </div>
        </div>
    </div> -->
    <div class="tile bg-purple">
        <div class="tile-body">
            <i class="fa fa-plane"></i>
        </div>
        <div class="tile-object">
            <div class="name">
                 Projects
            </div>
            <div class="number">
                 34
            </div>
        </div>
    </div>
</div>
</div>
<div class="collapse navbar-collapse navbar-ex1-collapse">  
    <form role="form" method="post" action="">
        <div class="form-group" stlye="float:right;">
                 <label>Date Range</label>
                 <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"  data-date-format="yyyy-mm-dd">
                    <input type="text" class="form-control" name="data[start_date]" required />
                    <span class="input-group-addon">
                    to </span>
                    <input type="text" class="form-control" name="data[end_date]" required />
                 </div> 
        </div><span>
            
        <div class="form-actions">
            <input type="submit" class="btn blue"  value="Submit" name="submit_date">
            
        </div></span>
    </form> 
</div>

<br/>

<div class="col-md-4" >

    <div class="portlet sale-summary">
        <div class="portlet-title">
            <div class="caption label label-info">
                 Income Summary
            </div>
            <div class="tools">
                <a class="reload" href="javascript:;" data-original-title="" title="">
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <ul class="list-unstyled">
                <li>
                    <span class="sale-info">
                    Working hours  :<i class="fa fa-img-down"></i>
                    </span>
                    <span class="sale-num">
                    <?php if(isset($shiftFactors)){echo $shiftFactors->grandTotalHours;}else{echo 0;}?> </span>
                </li>


                <li>
                    <span class="sale-info">
                    Total Income :<i class="fa fa-img-up"></i>
                    </span>
                    <span class="sale-num">
                   $<?php if(isset($shiftFactors)){echo $shiftFactors->grandTotalPayment;}else{echo 0;} ?>
                   </span>
                </li>
                
                <li>
                    <span class="sale-info">
                    Tax Amount :</span>
                    <span class="sale-num">
                    $<?php if(isset($shiftFactors)){echo $shiftFactors->taxableAmount;}else{echo 0;}?> </span>
                </li>
                <li>
                    <span class="sale-info">
                    Final EARNING:</span>
                    <span class="sale-num">
                    $<?php if(isset($shiftFactors)){echo $shiftFactors->afterTaxDeduction;}else{echo 0;}?></span>
                </li>
            </ul>
        </div>
    </div>

        <div>
            <a href="#portlet-33"  data-toggle="modal">View all details</a>
        </div>
</div>


<!-- //*********************************************************** -->

<div class="modal fade" id="portlet-33" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Income Summary</h4>
            </div>
                <div class="modal-body">
                <div class="well">
                    <table class="table">
                        <thead>
                        <tr>
                            <td>PAYMENT TYPE</td>
                            <td>WORKING HOURS</td>
                            <td>PAYMENT</td>
                        </tr>
                        </thead>
                       <tbody>
                        <?php 
                        
                            if(isset($shiftFactors)){
                            foreach($shiftFactors as $title=>$factor){ ?>
                                <?php if(isset($factor->workingHour)){ ?>
                               <tr>
                                 <td><?php echo $title;?></td>
                                 <td><?php echo $factor->workingHour;?> </td>   
                                 <td>$<?php echo $factor->payment;?></td> 
                               </tr> 
                                <?php } ?>       
                            <?php }}else{ ?>
                            <tr>
                                 <td>-</td>
                                 <td>- </td>   
                                 <td>-</td> 
                               </tr> 
                            <?php } ?>

                        </tbody>
                        
                    </table>

                 
                </div>

                </div>

            </div>

    </div>

</div>




<!-- //*********************************************************** -->



<!-- ***************************************************************** -->
<!-- 
<div class="col-md-6" >
    <div class="well no-margin no-border">
            <div class="row" stlye="float:right;">
                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                    <span class="label label-success">
                    Revenue: </span>
                    <h3>$1,234.20</h3>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                    <span class="label label-info">
                    Total Tax: </span>
                    <h3>$134,90.10</h3>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                    <span class="label label-danger">
                    Working hours </span>
                    <h3>10:34:00</h3>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                    <span class="label label-warning">
                    Total Income: </span>
                    <h3>
                    $235090</h3>
                </div>
            </div>
        </div>

</div> -->
<!-- //********************************************************* -->


<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->


<!-- BEGIN PAGE LEVEL SCRIPTS -->


<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script>
jQuery(document).ready(function() {
   TableManaged.init();
   ComponentsPickers.init();

});
</script>