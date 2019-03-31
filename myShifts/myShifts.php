<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$url = URL."ShiftUsers/myShifts/".$user_id."/".$page.".json";
$response = \Httpful\Request::get($url)->send();

$myShifts = $response->body->myShifts;
$output = $response->body->output;

$url = URL."ShiftUsers/todaysShift/".$user_id.".json";
$response = \Httpful\Request::get($url)->send();
$todaysShift = $response->body;
//fal($todaysShift);

// date_default_timezone_set('Asia/Kathmandu');

/*function hisToTime($hisTime)
{
	$startTime = new DateTime($hisTime);
	return $startTime->format('g:i A');
}
*/

//edited by manohar
//$url = URL."ShiftUsers/myShifts/".$user_id

?>
<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>My Shifts <small>Related shifts</small></h1>
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
				<a href="<?=URL_VIEW."myShifts/myShifts";?>">My Shifts</a>
			</li>
        </ul>

		<div class="row">
			<div class="col-md-7">
				<!-- BEGIN PORTLET -->
				<div class="portlet light " style="min-height: 223px;">
					<div class="portlet-title">
						<div class="caption caption-md">
							<i class="icon-bar-chart theme-font hide"></i>
							<span class="caption-subject font-blue-madison bold uppercase">Your Shifts</span>
							<span class="caption-helper">Total 
											<?php $count=0; foreach ($todaysShift as $myShift):?>
											<?php $count++; endforeach;?>
											 <?php echo $count;?></span>
						</div>
						<div class="actions">
							<div class="btn-group btn-group-devided" data-toggle="buttons">
								<label class="btn btn-transparent grey-salsa btn-circle btn-sm active">
								<input type="radio" name="options" class="toggle" id="option1">Today</label>
							</div>
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-scrollable table-scrollable-borderless">
							<table class="table table-hover table-light">
							<?php if(!empty($todaysShift)):?>	
							<thead>


							<tr class="uppercase">
								<th>
									 SN
								</th>

								<th>
									Organisation
								</th>
								<th>
									 Department
								</th>
								<th>
									 Shift
								</th>
								<th>
									 Start
								</th>
								<th>
									 End
								</th>
								<th>
									Status
								</th>
							</tr>
							</thead>

							<?php if(isset($todaysShift)):?>
	                                <?php $n=1; foreach ($todaysShift as $myShift):?>

	                                
											<tr>
												<td>
													<?php echo $n++;?>
												</td>

												<td>
													<?php echo $myShift->org;?>
												</td>

												<td>
													<?php echo $myShift->board;?>
												</td>

												<td>
													 <?php echo $myShift->shift;?>
												</td>

												<td>
													<?php echo hisToTime($myShift->start);?>
												</td>

												<td>
													<?php echo hisToTime($myShift->end);?>
												</td>
												<?php $time = date('H:i:s');
													if( $time >= $myShift->start && $time <= $myShift->end):?>
														<td>
															<span class="label label-sm label-success">
															running</span>
														</td>
													<?php elseif( $time > $myShift->end):?>
														<td>
															<span class="bold theme-font">Finished</span>
														</td>
													<?php elseif($time > $myShift->end && $myShift->check_status ==0):?>
														<td>
															<span class="bold theme-font">Absent</span>
														</td>
													<?php else:?>
													<td>
															<span class="bold theme-font">Upcoming</span>
														</td>
												<?php endif;?>


											</tr>

									<?php endforeach;?>
							<?php endif;?>

						<?php else:?>
						<tr>No shifts for today.</tr>
					<?php endif;?>
							</table>
						</div>
					</div>
				</div>
				<!-- END PORTLET -->

			</div>
			<div class="col-md-5">
				<div class="portlet light bg-inverse">
							<div class="portlet-title">
								<div class="caption font-purple-plum">
									<i class="fa fa-share-alt font-purple-plum"></i>
									<span class="caption-subject bold uppercase"> Share Your Shift</span>
									<span class="caption-helper">facebook, gmail</span>
								</div>
							</div>
							<div class="portlet-body form">
								<form id="downloadShiftPdfForm" class="form-horizontal" action="" role="form">
									<div class="form-body">
										<div class="form-group">
											<label class="col-md-4 control-label">Select time slot</label>
											<div class="col-md-4">
												<select class="form-control" id="shiftPdfTime" name="data[timeSlot]">
													<option value="1">1 month</option>
													<option value="2">2 months</option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-actions right1">
										<!-- <button type="button" class="btn default">Cancel</button> -->
										<button type="submit" name="getPdfSubmit" class="btn green btn-sm">Get PDF</button>
										<button type="button" name="facebook" onclick="sharePdfLink();" class="btn blue btn-sm">
												<i class="fa fa-facebook"></i> Share on facebook</button>
										<button type="button" class="btn red btn-sm" onclick="sharePdfLinkOnGoogle();"><i class="fa fa-google-plus"></i> Share on google</button>

										<div ></div>
									</div>
								</form>
							</div>
						</div>
					</div>
		</div>

		<div class="row">
		    <div class="col-md-12">
		        <!-- BEGIN EXAMPLE TABLE PORTLET-->
		        <div class="portlet light">
		            <div class="portlet-title">
		            	<div class="caption caption-md">
							<i class="icon-bar-chart theme-font hide"></i>
							<span class="caption-subject font-blue-madison bold uppercase">My Shifts</span>
						</div>
						<div class="action">
							<div class="pull-right">
								<div class="input-group input-large date-picker input-daterange" data-date="10-11-2012" data-date-format="yyyy-mm-dd" style="float:left;width:150px;margin-right:3px;">
									<input type="text" class="dateFrom form-control" name="from">
									<span class="input-group-addon">
									to </span>
									<input type="text" class="dateTo form-control" name="to">
								</div>
									<input type="submit" name="search" value="Search" id="search" class="btn green" style="float:left;">	
							</div>
						</div>
		            </div>
		            <div class="portlet-body">
		                <table class="table table-striped table-bordered table-hover" id="">
		                <thead>

		                	
		                <tr>
		                   <!--  <th class="table-checkbox">
		                        <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
		                    </th> -->
		                    <th>
		                         S.N
		                    </th>
		                    <th>
		                         Organisation
		                    </th>
		                    <th>
		                         Department 
		                    </th>
		                    <th>
		                         Shift
		                    </th>
		                    <th>
		                    	Date
		                    </th>
		                    <th>
		                    	Start Time
		                    </th>
		                    <th>
		                    	End Time
		                    </th>
		                    <th>
		                    	Friends

		                    </th>

		                    <th>
		                    	Note
		                    </th>

		                    <th>
		                    	Status
		                    </th>
		                </tr>


		                </thead>
		                <tbody id="test">
		                	<?php if(isset($myShifts)):?>
		                    <?php $n=1; foreach ($myShifts as $myShift):?>
					                        <tr class="odd gradeX" data-id="<?php echo $myShift->ShiftUser->id; ?>">
					                               <!--  <td>
					                                    <input type="checkbox" class="checkboxes" value="1"/>
					                                </td> -->

					                                <td><?php echo $n++;?>
					                                </td>

					                                <td>
					                                	<?php echo $myShift->Board->Organization->title;?>
					                                </td>

					                                <td>
					                                	<?php echo $myShift->Board->title;?>
					                                </td>

					                                <td>
					                                	<?php echo $myShift->Shift->title;?>
					                                </td>
					                                <td>
					                                	<?php echo $myShift->ShiftUser->shift_date;?>
					                                </td>

					                                <td>
					                                	<?php echo hisToTime($myShift->Shift->starttime);?>
					                                </td>

					                                <td>
					                                	<?php echo hisToTime($myShift->Shift->endtime);?>
					                                </td>

					                           

					                                <td>  
					                                	<?php //$shift_type = array();  ?>                    	
					                                	<!-- <span class="label label-info popovers" style="cursor:pointer;" data-container="body" data-trigger="hover" data-html="true" data-content="
					                                	<?php 
					                                	foreach($myShift->Board->ShiftUser as $user){
					                                	 $fname = $user->User->fname;$lname = $user->User->lname;$UserID = $user->User->id;
					                                	 ?>

					                                	 	<?php 
					                                	 	if($UserID != $user_id && $user->Shift->id==$myShift->Shift->id){
					                                			echo "<i class='fa fa-user'></i> <span class='text-capitalize'>$fname $lname</span><br>";
					                                		}
					                                		?>

					                                		<?php 
					                                		}?>" data-placement="left" data-original-title="Friends">
					                                	 view friends</span> -->
					                                	 <a class="btn default btnFriends" >Friends</a>
					                       
					                                </td>


					                                <td>                      	
					                                	<!-- <span class="label label-info popovers" style="cursor:pointer;" data-container="body" data-trigger="hover" data-html="true" data-content="<?php foreach($myShift->Shift->Shiftnote as $note){$shift_note = $note->notes; ?>

					                                	 	<?php 
					                                		echo "<li>$shift_note</li>";

					                                		?>


					                                		<?php 
					                                		};?>" data-placement="left" data-original-title="Notes">
					                                	 view notes</span> -->
					                                	 <a class="btn default" data-toggle="modal" href="#static1">Notes</a>
					                                	 <div id="static1" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																		<h4 class="modal-title">Notes</h4>
																	</div>
																	<div class="modal-body">
																		<ul class="list-group">
																				
																				<table class="table table-bordered table-hover">
																					<thead>
																						<tr>
																							<th>Created date</th>
																							<th>Notes</th>
																						</tr>
																					</thead>
																					<tbody>
																						<?php foreach($myShift->Shift->Shiftnote as $note){ ?>
																						<tr>
																							<td>
																								<?php 
																									$cdate = $note->created;
																									$newcurrentdate = date("d/m/Y", strtotime($cdate));
																									echo $newcurrentdate;
																								 ?>

																							</td>
																							<td><?php echo $note->notes; ?></td>
																						</tr>
																						<?php
																							}
																						?>
																					</tbody>
																				</table>
																			
																		</ul>
																	</div>
																	<div class="modal-footer">
																		<button type="button" data-dismiss="modal" class="btn default">Close</button>
																	</div>
																</div>
															</div>
														</div>
					                                </td>
					                                <?php if($myShift->ShiftUser->status == 5){ ?>
					                                	<td> 
						                                	<span class="label label-sm label-success">
															Shift Rejected</span>
						                                	
						                                </td>
					                                <?php
					                                }
					                                else {
					                                	$date = date('Y-m-d');
					                                	if($date == $myShift->ShiftUser->shift_date):?>

					                                		<?php $time = date('H:i:s'); 

					                                		if( $time >= $myShift->Shift->starttime && $myShift->Shift->endtime <= $time):?>
								                                <td>
								                                	<span class="label label-sm label-success">
																			running</span>
								                                	
								                                </td>
								                            <?php else:?>
								                            	<td>
								                                	Today
								                                </td>
								                        	<?php endif;?>

					                            	<?php elseif($date > $myShift->ShiftUser->shift_date && $myShift->ShiftUser->check_status =='2'):?>
					                            		<td>
					                            			Finished
					                            		</td>
					                            	<?php elseif($date > $myShift->ShiftUser->shift_date && $myShift->ShiftUser->check_status =='0'):?>
														<td>
															<span class="bold theme-font">Absent</span>
														</td>
					                            	<?php else:?>
					                            		<td>Next</td>
					                            	<?php endif; }?>
					                            </tr>
		                <?php endforeach;?>
		            <?php else:?>

		            <tr class="odd gradeX">
		                    <td>
		                       -
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
		                        No data
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
		                <?php if($output->status ==1):?>
		                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
		                    <?php
		                    $page = $output->currentPage;
		                    $max = $output->page;
		                    if($max>0){
		                        ?>
		                        <div>Showing Page <?=$page;?> of <?=$max;?></div>
		                        <ul class="pagination" style="visibility: visible;">
		                            <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
		                                <?php if($page<=1){ ?>
		                                    <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
		                                <?php }else{ ?>
		                                    <a title="First" href="?page=1"><i class="fa fa-angle-double-left"></i></a>
		                                <?php } ?>
		                            </li>
		                            <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
		                                <?php if($page<=1){ ?>
		                                    <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
		                                <?php }else{ ?>
		                                    <a title="Prev" href="?page=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
		                                <?php } ?>
		                            </li>

		                            <?php if($max<=5){
		                                for($i=1;$i<=$max;$i++){ ?>
		                                    <li>
		                                        <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
		                                    </li>
		                                <?php }}else{
		                                if(($page-2)>=1 && ($page+2)<=$max){
		                                    for($i=($page-2);$i<=($page+2);$i++){ ?>
		                                        <li>
		                                            <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
		                                        </li>
		                                    <?php  }}elseif(($page-2)<1){
		                                    for($i=1;$i<=5;$i++){ ?>
		                                        <li>
		                                            <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
		                                        </li>
		                                    <?php }}elseif(($page+2)>$max){
		                                    for ($i=($max-4);$i<=$max;$i++){ ?>
		                                        <li>
		                                            <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page=<?=$i?>"><?=$i;?></a>
		                                        </li>
		                                    <?php }}} ?>

		                            <li class="next <?php if($page>=$max){echo 'disabled';}?>">
		                                <?php if($page>=$max){ ?>
		                                    <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
		                                <?php }else{ ?>
		                                    <a title="Next" href="?page=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
		                                <?php } ?></li>
		                            <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
		                                <?php if($max==0 || $max==1){ ?>
		                                    <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
		                                <?php }else{ ?>
		                                    <a title="Last" href="?page=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
		                                <?php } ?></li>
		                        </ul>
		                    <?php } ?>
		                </div>
		            <?php endif;?>
		            </div>
		        </div>
		        <!-- END EXAMPLE TABLE PORTLET-->
		    </div>
		</div>
	</div>
</div>


<div id="myFriend" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Friends List</h4>
			</div>
			<div class="modal-body">
				<ul class="list-group">
					
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn default">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
 $(document).ready(function(){

 	$('.btnFriends').live('click',function(){
 		var shiftUserId = $(this).closest('tr').attr('data-id');
 		$("#myFriend .list-group").html('');
 		$("#myFriend").modal();
 		
 		var userId = '<?php echo $userId; ?>';
 		var url = "<?php echo  URL ?>ShiftUsers/myFriend/"+shiftUserId+'.json';

 		$.ajax({
 			url:url,
 			type:'post',
 			datatype:'jsonp',
 			success:function(response){
 				var friends = '';
 				
 				if(response.length > 1){
 					$.each(response,function(key,val){
 						if(val.User.id != userId){
 							friends += '<li class="list-group-item">'+val.User.fname+' '+val.User.lname+'</li>';
 						}
 					});
 					
 				} else {
 					friends += '<span>No friends to show.</span>';
 				}
 				$("#myFriend .list-group").html(friends);
 			}
 		}) ;
 	});

	$("#search").on('click',function(){
		var sn = 1;
		var from = $(".dateFrom").val();
		var to = $(".dateTo").val();
		var uId = '<?php echo $user_id ?>';
		var today = new Date();
		var date = formatDate(today);
		var time = new Date();
		var h = time.getHours();
	    var m = time.getMinutes();
	    var s = time.getSeconds();
	    var todayTime = h+':'+m+':'+s;
           console.log(todayTime);
		$.ajax({  
            url:'<?php echo URL."ShiftUsers/searchUserShifts/"."'+uId+'"."/"."'+from+'"."/"."'+to+'".".json";?>',
            type:'post',
            datatype:'jsonp',
           success:function(response)
                    {
                    	console.log(response);
                    	var td = "";
                    	var sn = 1;
                    	if(response.output != "")
                    	{
		                    	$.each(response.output,function(i,v)
		                    	{

		                    		var shiftId = v.Shift.id;
		                    		var friends = "";
		                    		var note = "";
		                    		var shiftStatus = "";
		                    		$.each(v.Board.ShiftUser,function(i,j){
		                    			
		                    			if (uId != j.user_id && j.shift_id == shiftId) {
		                    				 friends+='<li class="list-group-item">'+j.User.fname+" "+j.User.lname+'</li>';
		                    			}
		                    		});

		                    		// var span = '<span class="label label-info popovers" style="cursor:pointer;" data-container="body" data-trigger="hover" data-html="true" data-content="'+friends+'" data-placement="left" data-original-title="Friends">view friends</span>';
		                    		var createddate ="";
		                    		$.each(v.Shift.Shiftnote,function(i,k){
		                    			var cDate = k.created;
		                    			createddate = new Date(cDate);
		                    			
		                    			note += '<tr><td>'+(createddate.getDate() + 1) + '/' + createddate.getMonth() + '/' +  createddate.getFullYear()+'</td><td>'+k.notes+'</td></tr>';
		                    		});
		                			if(v.ShiftUser.status == 5){
		                				shiftStatus+='<span class="label label-sm label-success">Shift Rejected</span>';
		                			}
		                			else{
		                				if(date == v.ShiftUser.shift_date){
		                					if(todayTime >= v.Shift.starttime && todayTime <= v.Shift.endtime){
		                						shiftStatus += '<span class="label label-sm label-success">Running</span>';
		                					}
		                					else{
		                						shiftStatus += '<span class="label label-sm label-success">Today</span>';
		                					}
		            					}
		            					else if(date > v.ShiftUser.shift_date)
		            					{
		            						shiftStatus += 'Finished';
		            					}
		            					else
		            					{
		            						shiftStatus += 'Next';
		            					}
		                			}
		                			td+='<tr class="odd gradeX">'+'<td>'+sn+'</td><td>'+v.Board.Organization.title+'</td>'+'<td>'+v.Board.title+'</td>'+'<td>'+v.Shift.title+'</td>'+'<td>'+v.ShiftUser.shift_date+'</td>'+'<td>'+tConvert(v.Shift.starttime)+'</td>'+'<td>'+tConvert(v.Shift.endtime)+'</td>'+'<td><input class="friends btn btn-default" type="button" name="friends"  value="Friends" /></td>'+'<td><input class="nots btn btn-default" type="button" name="note" value="Notes" /></td><td>'+shiftStatus+'</td></tr>';
			                    	sn++;
			                    	
			                    	//$("#test").html("");
			                    	
									 $("#test").html(td);
				                    	
										$(".popovers").popover();
										$(".friends").on('click',function(){
											bootbox.dialog({
				                            title: "Friends List",
				                            message:'<form method="post" action="" class="form-body"> ' +
				                            		'<ul class="list-group">'+friends+'</ul>'+

				                                    '<button type="button" class="btn default" data-dismiss="modal">Close</button>'+
				                                    
				                                '</form>'
				                            });

										});
										$(".nots").on('click',function(){
											bootbox.dialog({
				                            title: "Notes",
				                            message:'<form method="post" action="" class="form-body"> ' +
				                            		'<table class="table table-bordered table-hover"><thead><tr><th>Created date</th><th>Notes</th></tr></thead><tbody>'+note+'</tbody></table>'+

				                                    '<button type="button" class="btn default" data-dismiss="modal">Close</button>'+
				                                    
				                                '</form>'
				                            });

											});
		            			});
						}
						else{
							td='<tr class="odd gradeX"><td colspan="10">No Result Found</td></tr>';
							$("#test").html(td);
						}	
	
			}
        });
	});
function tConvert (time) 
    {
        time = time.slice(0, -3);
              // Check correct time format and split into components
      time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

      if (time.length > 1) { // If time format correct
        time = time.slice (1);  // Remove full string match value
        time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
        time[0] = +time[0] % 12 || 12; // Adjust hours
      }
      return time.join (''); // return adjusted time or original string
    }
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
});
</script>




<script type="text/javascript">


	$(function()
		{
			$('.popovers').popover({ 
						    html : true,
						    content: function() {
						      return "what";
						    }
						  });
		});
</script>
<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->


<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script type="text/javascript">

 window.fbAsyncInit = function() {
          FB.init({
            appId: '856196677767887',
            cookie: true, // This is important, it's not enabled by default
            version: 'v2.2'
          });
        };

        (function(d, s, id){
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) {return;}
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));


  function sharePdfLink()
  {
  	var shiftSlotTime = $('#shiftPdfTime').val();

      FB.ui(
              {
                method: 'share',
                href: '<?php echo URL;?>ShiftUsers/getShiftPdf/<?php echo $user_id;?>/'+shiftSlotTime+'.pdf',
              },
              // callback
              function(response) {
                if (response && !response.error_code) {
                  toastr.success('Posting completed.');
                } else {
                  toastr.error('Error while posting.');
                }
              }
            );
  }

  //Google share api
  function sharePdfLinkOnGoogle()
	{
		var userId = '<?php echo $user_id;?>';
		var timeslot = $("#shiftPdfTime").val();
		var currentURL = '<?php echo URL;?>shiftmate_api/ShiftUsers/getShiftPdf/'+userId+'/'+timeslot+'.pdf';
		window.open("https://plus.google.com/share?url="+currentURL,"","menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600");
		return false;

	}

</script>




<!-- end of google share api -->


<script type="text/javascript">
	$(function()
		{
			$("#downloadShiftPdfForm").on('submit', function(event)
			{
				event.preventDefault();
				var e = $(this);

				var userId = '<?php echo $user_id;?>';
				var timeslot = $("#shiftPdfTime").val();

				var shareUrl = '<?php echo URL."ShiftUsers/getShiftPdf/"."'+userId+'"."/"."'+timeslot+'".".pdf";?>';

				location.href=shareUrl;
			});
		});
</script>
<script>
jQuery(document).ready(function() {
   TableManaged.init();
   ComponentsPickers.init();

});
</script>