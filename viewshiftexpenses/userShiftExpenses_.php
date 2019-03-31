
<?php 

    $userOrganization = loginUserRelationToOther($user_id);
    $orgIds = array();

    if(isset($userOrganization->userOrganization) && !empty($userOrganization->userOrganization))
    {

        foreach ($userOrganization->userOrganization as $key => $value) {
            
            $orgIds[] = $key;
        }
        $listOrgIds = implode('_', $orgIds);

        $url1 = URL."Employeeshiftexpenses/view/".$user_id."/".$listOrgIds.".json";
        $response1 = \Httpful\Request::get($url1)->send();
        $employeeshiftexpenses = $response1->body;
    }

    $url2 = URL."Employeeshiftexpenses/getTotalAmount.json";
    $response2 = \Httpful\Request::get($url2)->send();
    $totalShiftAmounts = $response2->body;


   
   
    
    // echo "<pre>";
    // print_r($employeeshiftexpenses);
    // die();

 ?>

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>


<!-- tab portion -->
<h3 class="page-title">
   Shift Expenses <small>User Shift Expenses</small>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="#">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Shift Expenses</a>
        </li>
    </ul>
</div>


<div class="row">

                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-dollar"></i>User Expenses
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="sample_2">
                            <thead>
                            <tr>
                                <th>
                                     S.N
                                </th>
                                <th>
                                     Title
                                </th> 
                                <th>
                                     Organization Name
                                </th>
                                <th>
                                     Shift
                                </th>
                                <th>
                                    Description
                                </th>
                                <th>
                                     Cost
                                </th>
                                <th>
                                    Expense Date
                                </th>
                              
                            </tr>


                            </thead>
                            <tbody>

                           <?php if(isset($employeeshiftexpenses->employeeshiftexpenses)):?>
                          


                                 <?php  foreach ($employeeshiftexpenses->employeeshiftexpenses as $employeeshiftexpense):?> 
                                    <tr class="odd gradeX">
                                        <td> <?php echo $employeeshiftexpense->Employeeshiftexpense->id;?></td>                                                       
                                        <td> <?php echo $employeeshiftexpense->Employeeshiftexpense->title;?></td>


                                        <td> <?php echo $employeeshiftexpense->ShiftUser->Organization->title;?></td>
                                        <td> <?php echo $employeeshiftexpense->ShiftUser->Shift->title;?></td>


                                        <td> <?php echo $employeeshiftexpense->Employeeshiftexpense->description;?></td>
                                        <td>  $<?php echo $employeeshiftexpense->Employeeshiftexpense->price;?></td>
                                        <td>  <?php echo date("Y-m-d",strtotime($employeeshiftexpense->Employeeshiftexpense->expense_on_date));?></td>
                                    </tr>
                                 <?php endforeach ;?>

                         
                            <?php else:?>

                            <tr class="odd gradeX">
                                <td>
                                  No Data
                                </td>

                                <td>
                                   No Data
                                </td>

                                <td>
                                   No Data
                                </td>
                                 <td>
                                   No Data
                                </td>

                                <td>
                                   No Data
                                </td>

                                <td>
                                   No Data
                                </td>

                                <td>
                                   No Data
                                </td>

                                
                            </tr>

                        <?php endif;?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
</div>

<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE LEVEL PLUGINS -->
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