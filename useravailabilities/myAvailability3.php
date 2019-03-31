<?php
// $userId = $_GET['user_id'];
//$userId = 6;


$url = URL . "Useravailabilities/useravailabilityList/" . $userId . ".json";
$data = \Httpful\Request::get($url)->send();

$availabilities = $data->body->availabilities;
$availability_status = $data->body->availabilities_status;

//  echo "<pre>";
// print_r($availabilities);
// print_r($availability_status);
// die();



?>
<!-- Edit-->
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>User Availability <small> user Availability</small></h1>
        </div>  
        	<div class="page-toolbar">
        <div class="btn-group pull-right" style="margin-top: 15px;">
            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                Actions <i class="fa fa-angle-down"></i>
            </button>
                <ul class="dropdown-menu pull-right" role="menu">
                	<?php if($availability_status == 1) { ?>
                    <li>
                        <a href="<?php echo URL_VIEW . 'useravailabilities/updateEmployeeAvailabilities?user_id='.$userId;?>">Edit Availability</a>
                    </li>
                    <?php
                    	}
                    	else
            			{
                    ?>
                    <li>
                        <a href="<?php echo URL_VIEW . 'useravailabilities/addEmployeeAvailabilities?user_id='.$userId;?>">Add Availability </a>
                    </li>
                    <?php } ?>
                </ul>
        </div>
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
    			<a href="javascript:;">Availability</a>
    		</li>
        </ul>
<!-- row -->
	<div class="row">
		<?php if($availability_status == 1):?>
			<?php foreach($availabilities as $availability):?>
				<?php if($availability->data->status == 0 || $availability->data->status == 1){ ?>
					<div class="col-md-4">
						<div class="portlet box green">

							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs"></i><?php echo $availability->day->title;?>
								</div>
								<!-- <div class="actions">
				                    <a href="" class="btn btn-default btn-sm">
				                    <i class="fa fa-edit"></i> Edit </a>
				                </div> -->
							</div>
							<?php if($availability->data->status==0){ ?>
							<div class="portlet-body">
								<div class="scroller" style="height: 60px;">
									<h4>Available</h4>
								</div>
							</div>
							<?php
								}
							else {//if($availability->data->status==1) {
							?>
							<div class="portlet-body">
								<div class="scroller" style="height: 60px;">
									<h4>
										<?php foreach ($availability->time as $time):?>
											<div class="myavailDateTimeDiv"><?php echo hisToTime($time->starttime)."-".hisToTime($time->endtime);?>
										</div><?php endforeach;?>
									</h4>
								</div>
							</div>
							<?php
								 }
								// else {
							?>

							<!-- <div class="portlet-body">
								<div class="scroller" style="height: 60px;">
									<h4>Not Available</h4>
								</div>
							</div> -->
						<?php //} ?>
						</div>
					</div>
				<?php }
					else if ($availability->data->status == 2 ) {
				?>
					<div class="col-md-4">
						<div class="portlet box red">

							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-cogs"></i><?php echo $availability->day->title;?>
								</div>
							</div>
							<div class="portlet-body">
								<div class="scroller" style="height: 60px;">
									<h4>Not Available</h4>
								</div>
							</div>
						</div>
					</div>

				<?php
					}
					else{
				?>

				<?php
					}
				?>
			<?php endforeach; ?>
		<?php else:?>
	<div class="redFont" style="font-size: 1.5em;text-align: center;text-decoration: blue;">No availability.</div>
<?php endif;?>
	</div>
	<!-- End row-->
<!-- END Edit-->


<!-- <div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Availability</div>

    
        <?php if($availability_status == 1) { ?>
        <a href="<?php echo URL_VIEW . 'useravailabilities/updateEmployeeAvailabilities?user_id='.$userId;?>"><button class="addBtn">Edit Availability</button></a>
		<?php }
		else {
		 ?>
        
        <a href="<?php echo URL_VIEW . 'useravailabilities/addEmployeeAvailabilities?user_id='.$userId;?>"><button class="addBtn">Add Availability</button></a>
    <?php
		}
	?>

    </div>
    <div class="clear"></div>
<?php if($availability_status == 1):?>

<!-- The table styles and css is Specific for this page only  -->
	<!-- <table class="table_list useravailability_table" width="98%;" align="center">
		<tbody>
			<tr class="week-heading orgListing" style="background:#d7d7d7;height:40px;">
				<th>Day</th>
				<th>Available</th>
				<th>Not Available</th>
			</tr>

			<?php foreach($availabilities as $availability):?>
            
			<tr>
            	<?php if($availability->data->status==0){ ?>
				<td><p><?php echo $availability->day->title;?></p></td>
				<td>Available</td>
                <td>-</td>
                <?php } 
                else if ($availability->data->status==1){ ?>
                <td><p><?php echo $availability->day->title;?></p></td>
                
				<td><?php foreach ($availability->time as $time):?><div class="myavailDateTimeDiv"><?php echo $time->starttime->hour.":".$time->starttime->min." ".$time->starttime->meridian." - ".$time->endtime->hour.":".$time->endtime->min." ".$time->endtime->meridian;?></div><?php endforeach;?></td>
                <td>-</td>
                <?php }
				else {
				 ?>
                 	<td><p><?php echo $availability->day->title;?></p></td>
				<td>-</td>
                <td>Not Available</td>
                 <?php
				}
				?>
			</tr>
		<?php endforeach;?>
	</tbody>
</table> -->
<!-- End of Table -->



<?php else:?>
	<!-- <div class="redFont">No availability.</div> -->
<?php endif;?>
</div> -->





