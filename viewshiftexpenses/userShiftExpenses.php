
<?php 
    // echo $user_id;
    $userOrganization = loginUserRelationToOther($user_id);
    //fal($userOrganization);
    $orgIds = array();

    if(isset($userOrganization->userOrganization) && !empty($userOrganization->userOrganization))
    {

        foreach ($userOrganization->userOrganization as $key => $value) {
            
            $orgIds[] = $key;
        }
        $listOrgIds = implode('_', $orgIds);

             if(isset($_POST['submit_date'])){

                $url1 = URL."Employeeshiftexpenses/view/".$user_id."/".$listOrgIds."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
                $response1 = \Httpful\Request::get($url1)->send();
                $employeeshiftexpenses = $response1->body;



             }else{

                $url1 = URL."Employeeshiftexpenses/view/".$user_id."/".$listOrgIds.".json";
                $response1 = \Httpful\Request::get($url1)->send();
                $employeeshiftexpenses = $response1->body;
             }

    }

    $url2 = URL."Employeeshiftexpenses/getTotalAmount.json";
    $response2 = \Httpful\Request::get($url2)->send();
    $totalShiftAmounts = $response2->body;

    // echo "<pre>";
    // print_r($employeeshiftexpenses);
    // die();

    $expensesList = array();
    $c = 0;
    foreach($employeeshiftexpenses->employeeshiftexpenses as $em){
        $expensesList[$em->ShiftUser->Organization->id][$c]['Employeeshiftexpense'] = $em->Employeeshiftexpense;
        $expensesList[$em->ShiftUser->Organization->id][$c]['ShiftUser'] = $em->ShiftUser->Shift;
        $c++;
    }
    //fal($expensesList);

 ?>

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<style>
    .feeds li {
        display: inline-block;
    }
    .feeds li:last-child {
        margin-bottom: 7px;
    }
</style>

<!-- tab portion -->

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Shift Expenses <small>User Shift Expenses</small></h1>
        </div>  
    </div>
</div>
<div class="page-content" style="min-height:500px;">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?=URL_VIEW;?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Shift Expenses</a>
            </li>
        </ul>


<!-- //*********************************************************************************************** -->



<div class="row">
             <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            
                            <div class="caption caption-md">
                                <i class="icon-bar-chart theme-font hide"></i>
                                <span class="caption-subject theme-font bold uppercase">My Expenses</span>
                                <!-- <span class="caption-helper hide">weekly stats...</span> -->
                            </div>
                            <ul class="nav nav-tabs">

                                <?php if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)):?>
                                <?php
                                    $count=0;
                                    foreach($loginUserRelationToOther->userOrganization as $orgid=>$org_detail){
                                        $url=URL."Organizations/organizationProfile/".$orgid.".json";
                                        $orgs=\Httpful\Request::get($url)->send();
                                       
                                ?>

                                    <li class="<?php if($count==0){echo 'active';}?> ">
                                        <a href="#tab_1_<?php echo $orgs->body->output->Organization->id;?>" data-toggle="tab" style="color:black;">
                                        <?php echo $orgs->body->output->Organization->title;?></a>
                                    </li>
                                <?php
                                $count++;
                                     }
                                    ?>
                                <?php else:?>
                            <?php endif;?>
                            </ul>       

                        </div>



                        <div class="portlet-body">
                                                <!--BEGIN TABS-->
                                <div class="tab-content tabDiv">


                                    
                                    <?php $OrgIds = array(); if(isset($expensesList) && !empty($expensesList)):?>
                                    <?php
                                        $count=0;

                                         foreach ($expensesList as $orgid=>$org_detail):
                                           // echo '<pre>';
                                           // print_r($org_detail);
                                        $OrgIds[] = $orgid;
                                        $count++;
                                        ?>


                                        
                                        <div class="tab-pane <?php if($count==1){echo 'active';}?>" id="tab_1_<?php echo $orgid;?>">
                                            <div class="portlet"  data-always-visible="1" data-rail-visible="0">
                                                 <ul class="feeds accordion task-list scrollable" id="accordion2">

                                           <!--****************************************************  -->
                                           
                                           <!-- <div class="collapse navbar-collapse navbar-ex1-collapse">  
                                                <form id="dateForm" data-orgid="<?php echo $orgs->body->output->Organization->id;?>" role="form" method="post" action="">
                                                    <div class="form-group" stlye="float:right;">
                                                             <label>Date Range</label>
                                                             <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"  data-date-format="yyyy-mm-dd">
                                                                <input type="text" class="form-control" id="input_start" name="data[start_date]" required />
                                                                <span class="input-group-addon">
                                                                to </span>
                                                                <input type="text" class="form-control" id="input_end" name="data[end_date]" required />
                                                             </div> 
                                                    </div><span>
                                                                                                            
                                                    <div class="form-actions"> 
                                                    
                                                        <input type="submit" class="btn btn-default"  value="Submit">
                                                        
                                                    </div></span> 
                                                </form> 
                                            </div>
                                            <br/> -->
                                           <!--****************************************************  -->      

                                                <!-- **************************************************************************-->

                                                    <div class="row">

                                                            <div class="col-md-12">
                                                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                                                <div class="portlet box">
                                                                    <div class="portlet-body">
                                                                        <table class="table table-striped table-bordered table-hover">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>
                                                                                 S.N
                                                                            </th>
                                                                            <th>
                                                                                 Title
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
                                                                            <th>
                                                                                Attachment
                                                                            </th>
                                                                          
                                                                        </tr>


                                                                        </thead>
                                                                        <tbody id="tbody">

                                                                       <?php  if(isset($org_detail) && !empty($org_detail)):?>
  
                                                                             <?php $n=1; $total=0; foreach ($org_detail as $employeeshiftexpense):?> 
                                                                                   
                                                                                    <tr class="odd gradeX">
                                                                                    <td> <?php echo $n++; ?></td>                                                       
                                                                                    <td id="tableTitle"><?php echo $employeeshiftexpense['Employeeshiftexpense']->title;?></td>


                                                                                    <!--  <td> <?php echo $employeeshiftexpense['Employeeshiftexpense']->ShiftUser->Organization->title;?></td> -->
                                                                                    
                                                                                    <td id="tableShift"> <?php echo $employeeshiftexpense['ShiftUser']->title;?></td> 


                                                                                    <td id="tableDescription"> <?php echo $employeeshiftexpense['Employeeshiftexpense']->description;?></td>

                                                                                    <td id="tableCost">  $<?php echo $employeeshiftexpense['Employeeshiftexpense']->price;?></td>

                                                                                    <td id="tableDate">  <?php echo date("Y-m-d",strtotime($employeeshiftexpense['Employeeshiftexpense']->expense_on_date));?></td>
                                                                                    <!-- <td><a href="#"  data-toggle="modal">View details</a></td> -->
                                                                                     <td ><!-- <a href="#phinex" class="news-block-btn btn btn-xs red newex" data-toggle="modal" data-date="<?php echo date("Y-m-d",strtotime($employeeshiftexpense['Employeeshiftexpense']->expense_on_date));?>"  data-orgid="<?php echo $orgs->body->output->Organization->id;?>"><i class="fa fa-check-square-o" id="forex"></i> View Details </a> -->
                                                                                         
                                                                                         <?php if(!empty($employeeshiftexpense['Employeeshiftexpense']->image)){ 

                                                                                            ?>
                                                                                         <a target="blank" href="<?php echo URL.'/webroot/files/employeeshiftexpense/image/'.$employeeshiftexpense['Employeeshiftexpense']->image_dir.'/'.$employeeshiftexpense['Employeeshiftexpense']->image; ?>"> <i class="fa fa-download"></i> </a>   

                                                                                           <?php }else{ ?>

                                                                                                --
                                                                                           <?php } ?>
                                                                                     </td>
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
                                                <!-- **************************************************************************-->
                                        
                                                            
                                                </ul>
                                            </div>
                                        </div>

                                            <?php endforeach;?>
                                        <?php else:?>
                                        <div>No records to show.</div>
                                    <?php endif;?>

                                    <?php if(isset($OrgIds) && !empty($OrgIds) && !empty($orgIds)){
                                        foreach($orgIds as $id){
                                            
                                            if(!in_array($id, $OrgIds)){
                                               
                                                echo '<div class="tab-pane" id="tab_1_'.$id.'">No records to show.</div>';
                                            }
                                        }

                                        } ?>
                                </div>
                                <!--END TABS-->
                        </div>
                    </div>
             </div>
</div>
<!-- //*********************************************************************************************** -->

<div class="modal fade" id="phinex" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Expenses Summary</h4>
            </div>
                <div class="modal-body">
                <div class="well" style="overflow:hidden;">
                    <table class="table">
                        <thead>
                        <tr>
                            <td>Title</td>
                            <td>Description</td>
                            <td>Cost</td>
                        </tr>
                        </thead>
                       <tbody id="factorPayment">
                        <?php 
                            // echo "<pre>";
                            // print_r($employeeshiftexpenses);
                            // die();

                            if(isset($employeeshiftexpenses)){
                            foreach($employeeshiftexpenses->employeeshiftexpenses as $shiftexpense){ ?>
                                <?php foreach($shiftexpense->ShiftUser->Employeeshiftexpense as $employeeshiftexp):?>
                               <tr>
                                    
                                 <td id="mod_title"></td>
                                 <td id="mod_dec"> </td>   
                                 <td id="mod_price"></td> 

                               </tr> 
                           <?php endforeach;?>
                                       
                            <?php }}else{ ?>
                            <tr>
                                 <td>-</td>
                                 <td>- </td>   
                                 <td>-</td> 
                            </tr> 
                            <?php } ?>

                        </tbody>
                        
                    </table>
                        <div class="badge badge-danger" style="font-size:14px !important; float:right; padding:5px 20px; height:auto; ">Total Expenses in this shift : $ <span class="totalex"></span>
                        </div>

                 
                </div>

                </div>

            </div>

    </div>

</div>
</div>
</div>
<!-- //*********************************************************************************************** -->



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

<script>
    
    
      $(".newex").live('click',function(eveent)
        {

            var id = <?php echo $user_id; ?>;
            var orgId = $(this).attr("data-orgid");
            var e = $(this).attr("data-date");
                    
            var url = '<?php echo URL."Employeeshiftexpenses/detailsByDate/"."'+id+'"."/"."'+orgId+'"."/"."'+e+'".".json";?>';
            $.ajax({

                url:url,  
                type:'post',
                datatype:'jsonp',
                success:function(response){

                    console.log(response);
                    var a = response.detailsBasedOnDate;
                    //console.log(a);
                    var data="";
                    var total =0;

                    a.forEach(function(entry){

                        total = total + parseInt(entry.Employeeshiftexpense.price);
                        

                        data+='<tr><td>'+entry.Employeeshiftexpense.title+'</td><td>'+entry.Employeeshiftexpense.description+'</td><td>'+entry.Employeeshiftexpense.price+'</td></tr>';
                    

                   
                    });

                        $(".totalex").html(total);
                        //console.log(total);

                    $("#factorPayment").html(data);
                        //console.log(data);
                    
                }

            });


        });
 
</script>

<script>
        $('.applyBtn').attr('type',"submit");
        $("#dateForm").submit(function(event)
            {
                event.preventDefault();
                   // alert('hello');
                   var d = $("#input_start").val();
                   var e = $("#input_end").val();

                   console.log(d);
                   console.log(e);

                var orgId = $(this).attr("data-orgid");
                //console.log(orgId);

                   // alert('hello');
                  
             
        getDetails();
        function getDetails()
            {
                var userId = '<?php echo $user_id;?>';
                console.log(userId);

               
                

                var url= '<?php echo URL."Employeeshiftexpenses/view/"."'+userId+'"."/"."'+orgId+'"."/"."'+d+'"."/"."'+e+'".".json";?>';
                
                $.ajax(

                    {
                        url:url,
                        data:'post',
                        datatype:'jsonp',
                        success:function(response)
                        {
                            if(response.output==1){
                              console.log(response);

                              var data ="";

                                var b = response.employeeshiftexpenses;
                                 console.log(b);

                              var n= 1;   
                              var dataum = "";   
                              b.forEach(function(entry){

                                    ShiftTitle =  entry.ShiftUser.Shift.title;
                                    //console.log(ShiftTitle);

                                    g = entry.Employeeshiftexpense.description;
                                    console.log(g);
                                   
                                    dataum += '<tr><td>'+n+'</td><td>'+entry.Employeeshiftexpense.title+'</td><td>'+ShiftTitle+'</td><td>'+entry.Employeeshiftexpense.description+'</td><td>'+ entry.Employeeshiftexpense.price+'</td><td>'+entry.Employeeshiftexpense.expense_on_date+'</td><td ><a href="#phinex" class="news-block-btn btn btn-xs red newex" data-toggle="modal" data-date="'+entry.Employeeshiftexpense.expense_on_date+'"  data-orgid="<?php echo $orgs->body->output->Organization->id;?>"><i class="fa fa-check-square-o" ></i> View Details </a></td></tr>';
                                    $("#tbody").html(dataum);

                                    var expTotal = 0;
                                    var c = entry.ShiftUser.Employeeshiftexpense;
                                    console.log(c);
                                    
                                        c.forEach(function(last){

                                            ExpenTitle = last.title;
                                            //console.log(ExpenTitle);
                                            

                                            expenDescription = last.description;
                                            //console.log(expenDescription);
                                           

                                            expenDate = last.expense_on_date;
                                            //console.log(expenDate);
                                            

                                            expTotal = expTotal + parseInt(last.price);

                                            expenCost = last.price;
                                            //console.log(expenCost);

                                            
                                            data+='<tr><td>'+last.title+'</td><td>'+last.description+'</td><td>'+ last.price+'</td><td>'+last.expense_on_date+'</td></tr>';

                                          $("#factorPayment").html(data);

                                           $(".totalex").html(expTotal);

                                            console.log(data);
                                        });

                    n++;
                                });
                                    

                                     // $("#tableShift").html(ShiftTitle);
                                     // $("#tableTitle").html(ExpenTitle); 
                                     //  $("#tableDescription").html(expenDescription);  
                                     //  $("#tableDate").html(expenDate);
                                     //  $("#tableCost").html(expenCost);

                             } 

                             else{

                               dataum+='<tr><td>-</td><td>No data</td><td>No data</td><td>No data</td><td>No data</td><td>No data</td><td>No data</td></tr>';

                               $("#tbody").html(dataum);
                               }

                         
                        }
                    }); 
            } 

        });
                   

</script>
