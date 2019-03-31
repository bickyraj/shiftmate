<link href="<?php echo URL_VIEW;?>admin/pages/css/profile-old.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

<?php
	
	$url = URL . "Organizations/OrganizationProfile/" . $orgId . ".json";
	$data = \Httpful\Request::get($url)->send();
	$org_profile = $data->body->output;
	// echo "<pre>";
	// print_r($org_profile);


	// $url_head = URL."Messages/messageCount/".$org_profile->Organization->user_id."/".'received'.".json";
 //    $messageCount = \Httpful\Request::get($url_head)->send();
 //    $receivedMessage = $messageCount->body->receivedMessage;

	// echo "<pre>";
	// print_r($receivedMessage);
	// die();

?>

<?php 
	$url1= URL."OrganizationUsers/getOrganizationUsers/".$orgId.".json";
    $response1 = \Httpful\Request::get($url1)->send();
    
    $userLists=$response1->body;

   	// echo "<pre>";
   	// print_r($userLists);
   	// die();
	
	$allusers = array();
		
	foreach ($userLists->organizationUsers as $users) {
		
		 $allusers[] = $users->User->id;
		 

	}
	$users =json_encode($allusers);
	//echo "<pre>";
   	//echo($users);
   	//die();
 ?>


<div class="page-head">
    <div class="container">
	    <div class="page-title">
			<h1>Organisation Profile <small><?php echo $org_profile->Organization->title; ?></small></h1>
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
    			<a href="<?=URL_VIEW;?>organizations/organizationProfile">Organisation Profile</a>
    		</li>
        </ul>

		<div class="row profile">
			<div class="col-md-12">
				<div class="portlet light ">
					<div class="portlet-body">
						<div class="tabbable-line tabbable-full-width">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									Overview </a>
								</li>
							</ul>
							<?php
								
								$orgimage = URL."webroot/files/organization/logo/".$org_profile->Organization->logo_dir."/thumb_".$org_profile->Organization->logo;
								$image = $org_profile->Organization->logo;
								$gender = $org_profile->User->gender;
								$organizationImage = imageGenerate($orgimage,$image,$gender);


							?>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1_1">
									<div class="tab-pane active" id="tab_1_1">
										<div class="row">
											<div class="col-md-3">
												<ul class="list-unstyled profile-nav" style="width: 200px; height: 200px;">
													<li>
														<img src='<?php echo $organizationImage; ?>' alt="Orgtanization Image" width="200"/>
													</li>
													<li>
														<a href="<?php echo URL_VIEW; ?>messages/inboxMessages">
														Messages
														</a>
													
													</li>
													<li>

														<a href="<?php echo URL_VIEW . 'organizations/orgEdit?org_id='.$orgId ?>">
														Settings </a>
													</li>
												</ul>
											</div>
											<div class="col-md-9">
												<div class="row">
													<div class="col-md-8">
														<div class="portlet sale-summary">
															<div class="portlet-body">
																<div class="portlet sale-summary">
																	<div class="portlet-title">
																		<div class="caption theme-font text-green">
																			<strong><?php echo $org_profile->Organization->title;?></strong>
																		</div>
																	</div>
																	<div class="portlet-body">
																		<ul class="list-unstyled">
																			<li>
																				<span class="sale-info">
																				Website <i class="fa fa-img-up"></i>
																				</span>
																				<span class="sale-num">
																				<?php echo $org_profile->Organization->website;?> </span>
																			</li>
																			<li>
																				<span class="sale-info">
																				Phone Number</span>
																				<span class="sale-num">
																				<?php echo $org_profile->Organization->phone;?> </span>

																			</li>
																			
																			<li>
																				<span class="sale-info">
																				Fax </span>
																				<span class="sale-num">
																				<?php echo $org_profile->Organization->fax;?> </span>

																			</li>
																			
																			<li>
																				<span class="sale-info">

																				Address </span>
																				<span class="sale-num">
																				<?php echo $org_profile->Organization->address;?> </span>
																			</li>
																		</ul>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div> 
											</div>
										</div>
									</div>
								</div>

								<?php 

								 if(isset($_POST['submit_date'])){

								        $url2 = URL."ShiftUsers/organizationPaymentFactors/".$orgId."/0/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
								        $response2 = \Httpful\Request::get($url2)->send();
								    }else

								    {
								        $url2= URL."ShiftUsers/organizationPaymentFactors/".$orgId."/".".json";
											 $response2 = \Httpful\Request::get($url2)->send();
								    }

								    	 if($response2->body->output =='0')
								            {
								                // echo "<script> toastr.warning('No Valid Data.');</script>";
								            }


										if(isset($response2->body->arr)){
																					    
								   		 $grandMaster = $response2->body->arr;

								   		 // echo "<pre>";
								   		 // print_r($grandMaster);
								   		}

								 ?>							

								<div class="tab-pane" id="tab_1_2">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-7" >
												    <div class="well no-margin no-border">
												            <?php if(isset($grandMaster) && $response2->body->output == 1) { ?>
												            <div class="row">
												                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
												                    <span class="label label-info">
												                    Total Income: </span>
												                    <h4 id="totalPatment">$<?php echo $grandMaster->grandTotalPayment; ?></h4>
												                </div>
												                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
												                    <span class="label label-danger">
												                    Overall Tax :</span>
												                    <h4 id="tax">$<?php echo $grandMaster->taxableAmount; ?></h4>
												                </div>
												                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
												                    <span class="label label-warning">
												                    Net Earnings: </span>
												                    <h4 id="taxFree"><?php echo $grandMaster->afterTaxDeduction; ?></h4>
												                </div>
												                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
												                    <span class="label label-success">
												                    Total Work Hours: </span>
												                    <h4 id="totalTime"><?php echo $grandMaster->grandTotalHours; ?></h4>
												                </div>
												            </div>
												            <?php }else{ ?>

												             <div class="row">
												                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
												                    <span class="label label-info">
												                    Total Income: </span>
												                    <h4>$0.00</h4>
												                </div>
												                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
												                    <span class="label label-danger">
												                    Overall Tax :</span>
												                    <h4>$0.00</h4>
												                </div>
												                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
												                    <span class="label label-warning">
												                    Net Earnings: </span>
												                    <h4>$0.00</h4>
												                </div>
												                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
												                    <span class="label label-success">
												                    Total Work Hours: </span>
												                    <h4>00:00:00</h4>
												                </div>
												            </div>
												            <?php } ?>
											        </div>
											    </div>
											    <div class="collapse navbar-collapse navbar-ex1-collapse" style="float:right;">  
												    <form id="dateForm" role="form" method="post" action="">
												        <div class="form-group" >
												                 <label>Date Range</label>
												                 <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012"  data-date-format="yyyy-mm-dd">
												                    <input type="text" class="form-control" id="input_start" name="data[start_date]" required />
												                    <span class="input-group-addon">
												                    to </span>
												                    <input type="text" class="form-control" id="input_end" name="data[end_date]" required />
												                 </div> 
												        </div><span>
												            
												        <div class="form-actions applyBtn" style="float:right;">
												            <input type="submit" class="btn blue"  value="Submit">
												            
												        </div></span>
												    </form> 
												</div>	
												<br>
												<br>
												<br>
												<br>
												<br>
												<br>
												<br>
												<div class="col-md-12">
										            <!-- BEGIN EXAMPLE TABLE PORTLET-->
										            <div class="portlet box blue">
										                <div class="portlet-title">
										                    <div class="caption">
										                        <i class="fa fa-money"></i>Employee Income Summary
										                    </div>
										                    <div class="tools">
												                <a class="reload totalShiftSpinner"  data-original-title="" title="" style="display: none;">
												                </a>
												            </div>
										                </div>
										                <div class="portlet-body">
										                    <table class="table table-striped table-bordered table-hover" id="sample_2">
											                    <thead>
												                    <tr>
												                        <th>
												                         	User Name
												                        </th>
												                        
												                        <th>
												                             Working Hours
												                        </th>
												                        <th>
												                             Total Income
												                        </th>
												                        <th>
												                            Tax Amount
												                        </th>
												                        <th>
												                             Final Earning
												                        </th>
												                        <th>
												                             Details
												                        </th>
												                                                    
												                    </tr>

											                    </thead>
											                    <tbody>
											          			
												          			<?php foreach($userLists->organizationUsers as $userList):
														                
														                $userId = $userList->User->id;

													                	$userimage = URL.'webroot/files/user/image/'.$userList->User->image_dir.'/thumb2_'.$userList->User->image;
										                                $image = $userList->User->image;
										                                $gender = $userList->User->gender;
										                                $userimage = imageGenerate($userimage,$image,$gender);



														                if(isset($_POST['submit_date'])){

																		        $url2 = URL."ShiftUsers/organizationPaymentFactors/".$orgId."/".$userId."/".$_POST['data']['start_date']."/".$_POST['data']['end_date'].".json";
																		        $response2 = \Httpful\Request::get($url2)->send();
																		    }else

																		    {
																		        $url2= URL."ShiftUsers/organizationPaymentFactors/".$orgId."/".$userId.".json";
												                       			 $response2 = \Httpful\Request::get($url2)->send();
																		    }

																		    if(isset($response2->body->arr)){
																		        $paymentDetails = $response2->body->arr;
																		    }
														                
														                
												                        //$paymentDetails = $response2->body->arr;

												                       // print_r($paymentDetails) ;

												                        ?>

												                        <?php if(isset($paymentDetails) && $response2->body->output == 1) { ?>
												                  		<tr class="odd gradeX">
												                                <td> <?php if (isset($paymentDetails)) {?><img src="<?php echo $userimage;?>" style="height:40px;width:40px;"/><?php }?>
												                                <?php if (isset($paymentDetails)) {echo $userList->User->fname." ".$userList->User->lname;}else{echo 0;}?></td> 
												                                <td id="workinghours_<?php echo $userList->User->id;?>"><?php if (isset($paymentDetails)) { echo $paymentDetails->grandTotalHours;}else{echo 0;}?> </td>
												                                <td id="incomeTotal_<?php echo $userList->User->id;?>"> <?php if (isset($paymentDetails)) { echo $paymentDetails->grandTotalPayment;}else{echo 0;} ?></td>
												                                <td id="taxTotal_<?php echo $userList->User->id;?>"><?php if (isset($paymentDetails)) { echo $paymentDetails->taxableAmount; }else{echo 0;}?></td>
												                                <td id="earningTotal_<?php echo $userList->User->id;?>"> <?php if (isset($paymentDetails)) { echo $paymentDetails->afterTaxDeduction;}else{echo 0;} ?></td>
												                                <td><a href="#portlet-33_<?php echo $userId;?>"  data-toggle="modal">View details</a></td>
												                                
												                         </tr>
																	<!-- //*********************************************************************************************** -->

																	<div class="modal fade" id="portlet-33_<?php echo $userId;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
																	    <div class="modal-dialog">
																	        <div class="modal-content">
																	            <div class="modal-header">
																	                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	                            <h4 class="modal-title"><?php echo $userId;?> Income Summary</h4>
																	            </div>
																                <div class="modal-body">
																	                <div class="well">
																	                    <div class="row table" >
																	                        <div class="col-md-4">
																	                            PAYMENT TYPE
																	                        </div>
																	                        <div class="col-md-4">
																	                            WORKING HOURS
																	                        </div>
																	                        <div class="col-md-4">
																	                            PAYMENT
																	                        </div>
																	                        <hr/>

																	                        <div id="factorPayment_<?php echo $userId;?>">
																		                        <?php 
																		                        if(isset($paymentDetails) ){

																		                        foreach($paymentDetails as $title=>$factor){ ?>

																		                         <?php if(isset($factor->workingHour)){ ?>
																		                             <div class="col-md-4"><?php echo $title;?></div>
																		                             <div class="col-md-4"><?php echo $factor->workingHour;?></div>   
																		                             <div class="col-md-4">$<?php echo $factor->payment;?></div>  
																		                            <?php } ?>       
																		                        <?php }

																		                        }else{ ?>

																		                             <div class="col-md-4">-</div> 
																		                             <div class="col-md-4">- </div>   
																		                             <div class="col-md-4">-</div>  
																		                        <?php } ?>

																		                    </div> 
																		                    <hr/>
																		                    <hr/>
																		                    <hr/>
																		                    <div class="alert alert-block alert-danger fade in" >
																		                    	<div ><strong>Total</strong> </div>
																					
																		                    	<div id="factorPayment_1<?php echo $userId;?>"><?php if (isset($paymentDetails))
																								  { echo $paymentDetails->grandTotalPayment;}else{echo 0;}?>
																								 </div>
																		                    	
																		                    </div>   
																	                        
																	                    </div>
																	                </div>

																                </div>
																	        </div>
																        </div>

																	</div>

																	<?php  }else{?>

																	<tr class="odd gradeX">
													                            <td>
													                             <img src="<?php echo $userimage;?>" style="height:40px;width:40px;"/>
													                               <?php echo $userList->User->fname." ".$userList->User->lname; ?>
													                            </td>

													                            <td>
													                               -
													                            </td>
													                             <td>
													                               -
													                            </td>

													                            <td>
													                               -
													                            </td>

													                            <td>
													                               -
													                            </td>
													                            <td>
													                               -
													                            </td>
													                                                            
													                </tr>
													                        <?php } ?>

													                 <?php endforeach; ?>
													            </tbody>
										                    </table>
										                </div>
										            </div>
										            <!-- END EXAMPLE TABLE PORTLET-->
										        </div>
											</div>										
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>





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
var f ='<?php echo $users;?>';
console.log(f);
var g =JSON.parse(f);
console.log(g);

$('.applyBtn').attr('type',"submit");
$("#dateForm").submit(function(event)
    {
    	event.preventDefault();
	       // alert('hello');
	       var d = $("#input_start").val();
	       var e = $("#input_end").val();

        //var totalWork=0;
        var totalIncome=0;
        var totalTax=0;
        var netEarning=0;

        console.log(d);
        console.log(e);

        getPaymentFactorsByOrg();
        function getPaymentFactorsByOrg()
            {	
                
                var orgId = '<?php echo $orgId;?>';
                //console.log(orgId);
                var url= '<?php echo URL."ShiftUsers/organizationPaymentFactors/"."'+orgId+'"."/0/"."'+d+'"."/"."'+e+'".".json";?>';
               
             	console.log(url);

   				$.ajax(

                	{
                        url:url,
                        data:'post',
                        datatype:'jsonp',
                        success:function(response)
                        {
                            //console.log(response);
                             if(response.output==1){

	                             totalPay =  response.arr.grandTotalPayment;
	                             $("#totalPatment").html(totalPay); 

	                          // // console.log(response.arr.grandTotalHours);

	                              totalTax = response.arr.taxableAmount;
	                             $("#tax").html(totalTax);

	                               totalTaxFree = response.arr.afterTaxDeduction;
	                             $("#taxFree").html(totalTaxFree);
	                             
	                               totalTime = response.arr.grandTotalHours;
	                             $("#totalTime").html(totalTime);
	                            
	                           
                             }else {

                             	$("#totalPatment").html('$0.00');
                             	$("#tax").html('$0.00');
                             	$("#taxFree").html('$0.00');
                             	$("#totalTime").html('00:00:00');
                             }
                         
                        }
                    });
						
					$.each(g,function(i,v){


						var url1= '<?php echo URL."ShiftUsers/organizationPaymentFactors/"."'+orgId+'"."/"."'+v+'"."/"."'+d+'"."/"."'+e+'".".json";?>';
						
						//console.log(v);
						//console.log(url1);	

							$.ajax(

		                	{
		                        url:url1,
		                        data:'post',
		                        datatype:'jsonp',
		                        success:function(response)
		                        {
		                          console.log(response);
		                          
		                          $('.totalShiftSpinner').click();
		                          if(response.output==1){

		                         		totalWorking = response.arr.grandTotalHours;
		                         		$("#workinghours_"+v).html(totalWorking);
		                         		 
		                         		totalIncome = response.arr.grandTotalPayment;
		                         		$("#incomeTotal_"+v).html(totalIncome);
		                         		 
		                         		taxAmount = response.arr.taxableAmount; 
		                         		$("#taxTotal_"+v).html(taxAmount);
		                         		
		                         		finalEarning = response.arr.afterTaxDeduction;
		                         		$("#earningTotal_"+v).html(finalEarning);
		                         		 
		                         		var data="";
										$("#factorPayment_"+v).html("");

			                            $.each(response.arr, function(key, value)
			                            	{
												if(typeof(value) === 'object')
												{
													data= "<div class='col-md-4'>"+key+"</div><div class='col-md-4'>"+value.workingHour+"</div><div class='col-md-4'>"+value.payment+"</div>";
													$("#factorPayment_"+v).append(data);

			                            			$("#factorPayment_1"+v).html(totalIncome);
												}
												
			                            	}

			                            	);
		                         	
		                         	}else {

		                             	$("#workinghours_"+v).html('00:00:00');
		                             	$("#incomeTotal_"+v).html('$0.00');
		                             	$("#taxTotal_"+v).html('$0.00');
		                             	$("#earningTotal_"+v).html('$0.00');
		                             	$("#factorPayment_"+v).html("<div class='col-md-4'>No data</div><div class='col-md-4'>No data</div><div class='col-md-4'>No data</div>");
		                             	$("#factorPayment_1"+v).html('$0.00');
	                             		
                        			 }

		                         
		                        }
		                    });


						
					});

             

                             // console.log(toHis('19563'));

            }
    
    });             	
	
</script>
