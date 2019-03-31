<?php 

$url0 = URL."Userinductions/viewUser/0.json";
$response0 = \Httpful\Request::get($url0)->send();

$userinductions0 = $response0->body;

$url1 = URL."Userinductions/viewUser/1.json";
$response1 = \Httpful\Request::get($url1)->send();

$userinductions1 = $response1->body;

$url2 = URL."Userinductions/viewUser/2.json";
$response2 = \Httpful\Request::get($url2)->send();

$userinductions2 = $response2->body;
/* echo "<pre>";
 print_r($userinductions0);
 echo "<pre>";

die();*/


 ?>

<!-- BEGIN PAGE HEADER-->
<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Induction Checklist</h1>
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
                    <a href="javascript:;">Induction Checklist</a>
                </li>
            </ul>
<!-- END PAGE HEADER-->


<div class="row">
             <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet">
                        <div class="portlet-title tabbable-line">
                            
                            <ul class="nav nav-tabs">

                            	<?php if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)):?>
                            	<?php
                            		$count=0;
                            		foreach($loginUserRelationToOther->userOrganization as $orgid=>$org_detail){
	                            		$url=URL."Organizations/organizationProfile/".$orgid.".json";
	                            		$orgs=\Httpful\Request::get($url)->send();
                            	?>

                            		<li class="<?php if($count==0){echo 'active';}?>">
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
            <div class="tab-content">

            	<?php if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization)):?>
            	<?php
					$count=0;
            		 foreach ($loginUserRelationToOther->userOrganization as $orgid=>$org_detail):
					$count++;
            	 	?>


                    <div class="tab-pane <?php if($count==1){echo 'active';}?>" id="tab_1_<?php echo $orgid;?>">
                        <div class="portlet"  data-always-visible="1" data-rail-visible="0">
                             <ul class="feeds accordion task-list scrollable" id="accordion2">

                             			<!-- BEGIN TAB PORTLET-->
					
										<div class="portlet box green">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa icon-note"></i>Induction Checklist
												</div>
												<ul class="nav nav-tabs">
													<li>
														<a href="#portlet_tab2_3_<?php echo $orgid;?>" data-toggle="tab">
														Todo</a>
													</li>
													<li>
														<a href="#portlet_tab2_2_<?php echo $orgid;?>" data-toggle="tab">
														Not Todo</a>
													</li>
													<li class="active">
														<a href="#portlet_tab2_1_<?php echo $orgid;?>" data-toggle="tab">
														Work Related</a>
													</li>
												</ul>
											</div>
											<div class="portlet-body">
												<div class="tab-content">
													<div class="tab-pane active" id="portlet_tab2_1_<?php echo $orgid;?>">
															<div class="alert alert-success">
																	 List of Work Related Task:
															</div>

															<?php foreach ($userinductions2 as $user2): ?>
																			<?php if($user2->Userinduction->organization_id == $orgid){ ?>
																				<li><i class="fa fa-mail-forward"></i><?php echo $user2->Userinduction->induction_task;?></li>
																			<?php } ?>
															<?php endforeach; ?>

													</div>

													<div class="tab-pane" id="portlet_tab2_2_<?php echo $orgid;?>">
															<div class="alert alert-success">
																		 List of task Not Todo :
															</div>
															
															<?php foreach ($userinductions1 as $user1): ?>
																			<?php if($user1->Userinduction->organization_id == $orgid){ ?>
																				<li><i class="fa fa-times"></i><?php echo $user1->Userinduction->induction_task;?></li>
																			<?php } ?>												
															<?php endforeach; ?>

													</div>

													<div class="tab-pane" id="portlet_tab2_3_<?php echo $orgid;?>">
														
															<div class="alert alert-success">
																List of task Todo:
															</div>
															
																<?php foreach ($userinductions0 as $user): ?>
																			<?php if($user->Userinduction->organization_id == $orgid){ ?>
																				<li><i class="fa fa-check"></i><?php echo $user->Userinduction->induction_task;?></li>
																			<?php } ?>
																<?php endforeach; ?>

													</div>
												</div>
											</div>
										</div>
							</ul>
                        </div>
                    </div>

            	<?php endforeach;?>
            <?php else:?>
            <div>No Data.</div>
        <?php endif;?>
            </div>
            <!--END TABS-->
    </div>





