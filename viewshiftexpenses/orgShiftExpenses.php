<link rel="stylesheet" type="text/css" href="<?php echo URL_VEIW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VEIW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php 

function fileExists($path){
    return (@fopen($path,"r")==true);
}
    
 /*   echo "<pre>";
    print_r($totalShiftAmounts);
    die();*/

    $url1 = URL."Shifts/myOrganizationShift/".$orgId.".json";
    $response1 = \Httpful\Request::get($url1)->send();
    $shiftlists = $response1->body->shifts;


   

    /*foreach ($shiftlists as $shift) {
       
        echo $shift->Shift->title."<br>";
    }
    die();*/


 ?>


<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<!-- ******************************************************************************************* -->

<!-- tab portion -->

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Organisation Shift Expenses <small>Overall Expenses</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo URL_VIEW; ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Organisation Shift Expenses </a>
            </li>
        </ul>
<!-- ******************************************************************************************* -->


<?php 


 if(isset($_POST['submit_date'])){

        $url = URL."Employeeshiftexpenses/getTotalAmount/".$orgId."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
    }else{
        $url = URL."Employeeshiftexpenses/getTotalAmount/".$orgId.".json";
    }
    $response = \Httpful\Request::get($url)->send();
    $totalShiftAmounts = $response->body;


 ?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-body">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="float:right;">
                    <div class="dashboard-stat blue-madison">
                        <div class="visual">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                  $<?php echo  $totalShiftAmounts->totalShiftAmount;?>
                            </div>
                            <div class="desc">
                                 Total Shift Expenses
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="float:right;">
                    <div class="dashboard-stat green-haze">
                        <div class="visual">
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                 <?php echo  $totalShiftAmounts->totalShiftNo;?>
                            </div>
                            <div class="desc">
                                Total Shift
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
                            <input type="submit" class="btn blue"  value="Filter" name="submit_date">
                            
                        </div></span>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>

                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-bar-chart theme-font hide"></i>
                                <span class="caption-subject theme-font bold uppercase">Shift Expenses</span>
                                <!-- <span class="caption-helper hide">weekly stats...</span> -->
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <ul class="nav nav-tabs tabs-left">

                                   <?php if(isset($shiftlists) && !empty($shiftlists)):?> 
                                    <?php $count=0;
                                    foreach ($shiftlists as $shift):?>
                                        <li class="<?php if($count==0){echo "active";}?>">
                                            <a href="#tab_<?php echo $shift->Shift->id;?>" data-toggle="tab">
                                            <?php echo $shift->Shift->title;?></a>
                                        </li>
                                    <?php $count++;endforeach;?>
                                    <?php else:?>
                                 <?php endif;?>
                                    </ul>
                                </div>

                                <div class="col-md-9 col-sm-9 col-xs-9">
                                    <div class="tab-content">
                                    <?php if(isset($shiftlists) && !empty($shiftlists)): ?>                                  
                                     <?php $count=0;
                                     foreach ($shiftlists as $shift):?>
                                        <?php 
                                        if(isset($_POST['submit_date'])){
                                            $url = URL."Employeeshiftexpenses/viewByShift/".$orgId."/".$shift->Shift->id."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
                                        }else{
                                            $url = URL."Employeeshiftexpenses/viewByShift/".$orgId."/".$shift->Shift->id.".json";
                                        }
                                            
                                            $response= \Httpful\Request::get($url)->send();
                                            $shiftExpenses = $response->body;

                                        ?>
                                        <?php if($shiftExpenses->output->status == 1){ ?>
                                            
                                            <div class="tab-pane <?php if($count==0){echo "active in";}?>" id="tab_<?php echo $shift->Shift->id;?>">
                                                
                                                    <table class="table" id="datatable_<?=$shift->Shift->id;?>">
                                                    <thead>
                                                            <tr>
                                                                <th>Title</th>
                                                                <th>Price</th>
                                                                <th>Date</th>
                                                                <th>Image</th>
                                                            </tr>
                                                        </thead><tbody>
                                                        <?php foreach ($shiftExpenses->shiftExpenses as $shiftExpense):?>
                                                            <tr class="note note-info block">
                                                                <td><?php echo $shiftExpense->Employeeshiftexpense->title;?></td>
                                                                <td><?php echo $shiftExpense->Employeeshiftexpense->price;?></td>
                                                                <td><?php echo getStandardDateTime($shiftExpense->Employeeshiftexpense->expense_on_date);?></td>
                                                                <td>
                                                                    <?php
                                                                        
                                                                        if(isset($shiftExpense->Employeeshiftexpense->image) && !empty($shiftExpense->Employeeshiftexpense->image) && fileExists($image)){
                                                                            $image=URL."webroot/files/employeeshiftexpense/image/".$shiftExpense->Employeeshiftexpense->image_dir."/".$shiftExpense->Employeeshiftexpense->image;
                                                                         ?>
                                                                        <a href="<?php echo $image; ?>" target="_blank"><img src="<?php echo $image; ?>" alt="no image" style="height: 50px;width: 70px;;"/></a>
                                                                    <?php }else{echo "-";} ?>
                                                                </td>
                                                            </tr>
                                                         <?php endforeach;?>
                                                    </tbody></table>
                                                    <script type="text/javascript">
                                                    $(document).ready(function(){
                                                        $('#datatable_<?=$shift->Shift->id;?>').dataTable();
                                                    });
                                                    </script>

                                                    <div>

                                                        <div class="badge badge-danger" style="font-size:14px !important;;">Total Expenses in this shift : $ <?php echo $shiftExpenses->totalShiftExpenses;?>
                                                        </div>

                                                        <p>
                                                            <a class="btn blue" data-toggle="modal" href="#basic_<?php echo $shift->Shift->id;?>" style="float:right;">
                                                            View Details </a>
                                                        </p>
                                                        <div class="modal fade" id="basic_<?php echo $shift->Shift->id;?>" tabindex="-1" role="basic" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                        <h4 class="modal-title">Detail View Shift Expenses</h4>
                                                                    </div>
                                                                    <div class="modal-body">                                                          
                                <?php 


                                if(isset($_POST['submit_date'])){
                                    $url2 = URL."Employeeshiftexpenses/getUserExpenses/".$orgId."/".$shift->Shift->id."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
                                }else{
                                    $url2 = URL."Employeeshiftexpenses/getUserExpenses/".$orgId."/".$shift->Shift->id.".json";
                                } 
                                
                                
                                $response2 = \Httpful\Request::get($url2)->send();
                                $userShiftAmounts = $response2->body;
                                    ?>
                                    <div class="portlet-body">  
                                        <div id="accordion3" class="panel-group accordion">
                                            <div class="panel panel-default">
                                               <div class="panel-heading">
                                                   <h4 class="panel-title">
                                                    
                                                   </h4>
                                                </div>
                                                <div class="panel-body">

                                                    <?php foreach($userShiftAmounts->userExpenses as $user){ ?>

                                                    <a aria-expanded="false" href="#collapse_3_<?php echo $shift->Shift->id."_".$user->ShiftUser->User->id;?>" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">
                                                        <p class="panel-heading green">
                                                            <h3 ><?php echo $user->ShiftUser->User->fname." ".$user->ShiftUser->User->lname; ?>
                                                            </h3>
                                                        </p>   
                                                    </a>
                                                    <div class="panel-collapse collapse" id="collapse_3_<?php echo $shift->Shift->id."_".$user->ShiftUser->User->id;?>" aria-expanded="false">
                                                        <?php $total=0; foreach($user->ShiftUser->Employeeshiftexpense as $details){
                                                            $total+=$details->price; ?> 
                                                        <?php } ?>

                                                        <span class="badge-danger circle" style="float:right;padding:3px;">Total Expenses =$<?= $total;?>
                                                        </span>
                                                        <br>
                                                        <br>

                                                        <table class="table">   
                                                              <thead>
                                                                  <tr>
                                                                      <th>title</th>
                                                                      <th>decription</th>
                                                                      <th>price</th>
                                                                      <th>date</th>
                                                                  </tr>
                                                              </thead>
                                                              <tbody>
                                                                  <?php $total=0; foreach($user->ShiftUser->Employeeshiftexpense as $details){


                                                                $total+=$details->price;
                                                                ?>
                                                                  <tr>
                                                                      <td>
                                                                          <?= $details->title; ?></td>
                                                                      <td>
                                                                          <?= $details->description; ?></td>
                                                                      <td>
                                                                          <?= $details->price; ?></td>
                                                                      <td>
                                                                          <?= date("Y-m-d",strtotime($details->expense_on_date)); ?></td>
                                                                  </tr>
                                                                  <?php } ?>
                                                              </tbody>
                                                        </table>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn default" data-dismiss="modal">Close</button>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <!-- /.modal-content -->
                                                            </div>
                                                            <!-- /.modal-dialog -->
                                                        </div>
                                                        <!-- /.modal -->
                                                        

                                                    </div>  
                                            </div>
                                        
                                        <?php }else{?>
                                            <div class="tab-pane <?php if($count==0){echo "active in";}?>" id="tab_<?php echo $shift->Shift->id;?>">
                                                <p>
                                                    <table class="table" id="tablex_<?php echo $shift->Shift->id;?>">
                                                            <tr>
                                                                <td>Title</td>
                                                                <td>Price</td>
                                                                <td>Date</td>

                                                            </tr>   
                                                            <tr>                                                         
                                                                <td>No data</td>
                                                                <td>No data</td>
                                                                <td>No data</td>

                                                            </tr>
                                                    </table>
                                                </p>
                                            </div>
                                        <?php } ?>
                                         <?php 
                                         $count++;
                                         endforeach;?>

                                    <?php else: ?>
                                        <div>No Shift/Data avaliable.</div>
                                    <?php endif; ?>     

                                    </div>
                            </div>
                        </div>
                        </div>
                    </div>
</div>


<!-- ******************************************************************************************* -->
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>


<script>
$(".date-picker").datepicker();
jQuery(document).ready(function() {       
 TableManaged.init();
 ComponentsPickers.init();
});
</script>