<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Shift Plans <small>View Open plans.</small></h1>
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
    			<a href="javascript:;">Shift Plans</a>
                <i class="fa fa-circle"></i>
    		</li>
            <li>
    			<a href="<?=URL_VIEW."shiftplans/showOpenPlans";?>">View Open Plans</a>
    		</li>
        </ul>

<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>Open Shift Plans
							</div>
						</div>
						<div class="portlet-body">
							<div class="tabbable tabbable-tabdrop">
								<ul class="nav nav-tabs">
<?php
if(isset($loginUserRelationToOther->userOrganization ) && !empty($loginUserRelationToOther->userOrganization )){
    $count=0;
foreach($loginUserRelationToOther->userOrganization as $org_id=>$v){
    foreach($v as $org_name=>$v2){
?>
    <li class="<?php if($count==0){echo 'active';}?>"><a href="#tab<?php echo $org_id;?>" data-toggle="tab"><?php echo $org_name;?></a></li>
<?php } $count++; }}else{echo "Not in any organization";} ?>
</ul>
                                <div class="tab-content">
                                    <?php 
if(isset($loginUserRelationToOther->userOrganization ) && !empty($loginUserRelationToOther->userOrganization )){
                                    $count=0; 
        foreach($loginUserRelationToOther->userOrganization as $org_id=>$v){ ?>
									<div class="tab-pane <?php if($count==0){echo 'active';}?>" id="tab<?php echo $org_id?>">
										<?php
                                            $url8=URL."Shiftplans/getOrgOpenPlans/".$org_id.".json"; 
                                            $openShiftPlans=\Httpful\Request::get($url8)->send();
                                            $openShiftPlans1=$openShiftPlans->body->orgOpenPlans;
                                            //fal($openShiftPlans1);
                                            if($openShiftPlans1){ ?>
          <table class="table table-striped table-bordered table-hover" id="sample_<?php echo $org_id;?>">
							<thead>
							<tr>
								<th>
									#
								</th>
								<th>
									 Title
								</th>
								<th>
									 Board
								</th>
								<th>
									 Shift
								</th>
								<th>
									 Duration
								</th>
							</tr>
							</thead>
							<tbody>

                            <?php 
                            $c=0;
                            foreach($openShiftPlans1 as $data){ ?>
                            <tr>
                                <td><?php echo $c+1;?></td>
                                <td><?php echo $data->Shiftplan->title;?></td>
                                <td><?php echo $data->Board->title;?></td>
                                <td><?php echo $data->Shift->title;?></td>
                                <td><?php echo $data->Shiftplan->start_date." -to- ".$data->Shiftplan->end_date;?></td>
                            </tr>
                            <?php $c++;} ?>

                            </tbody>
                            </table>
                                        <?php   }else{
                                                echo "No Plans Onwards";
                                            }
                                        ?>
									</div>

<script>
jQuery(document).ready(function(){
    //var table = jQuery('#sample_<?php echo $org_id;?>');
        //table.dataTable({});
});     
</script>

                                    <?php $count++; } } ?>
								</div>
							</div>
							<p>&nbsp;
								 
							</p>
							<p>&nbsp;
								 
							</p>
					</div>
                    </div>
                    </div>
                    </div>
                    
                    
<script type="text/javascript" src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>                   
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script>
jQuery(document).ready(function() {
   //TableManaged.init();
});
</script>