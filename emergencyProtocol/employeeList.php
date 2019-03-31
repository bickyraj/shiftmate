<?php

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

	$url = URL."ShiftUsers/listOfCheckedInUsers/".$orgId.".json";
	$response = \Httpful\Request::get($url)->send();
	$loggedInUsers = $response->body->shiftUsers;
	// fal($loggedInUsers);

	$loggedInArr = array();
	foreach ($loggedInUsers as $employee) {
		$loggedInArr[] = $employee->User->id;
	}

	// fal($loggedInArr);

	$url = URL."OrganizationUsers/getOrganizationUsers/".$orgId."/".$page.".json";
	$response = \Httpful\Request::get($url)->send();
	$employeeList = $response->body->organizationUsers;
	// fal($employeeList);

	$output = $response->body->output;
	// fal($output);
?>

<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?php echo URL_VIEW;?>global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Employee List <small>Logged In, Total</small></h1>
        </div>  
    </div>
</div>
<div class="page-content" style="min-height:500px;">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
    			<i class="fa fa-home"></i>
    			<a href="<?php echo URL_VIEW;?>">Home</a>
    			<i class="fa fa-circle"></i>
    		</li>
    		<li>
    			<a href="<?php echo URL_VIEW;?>emergencyProtocol/employeeList">Employee List</a>
    		</li>
        </ul>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption caption-md">
							<i class="icon-bar-chart theme-font hide"></i>
							<span class="caption-subject theme-font bold uppercase">Employee List</span>
							<!-- <span class="caption-helper hide">weekly stats...</span> -->
						</div>
						<!-- <div class="tools">
							<a href="javascript:;" class="collapse">
							</a>
							<a href="#portlet-config" data-toggle="modal" class="config">
							</a>
						</div> -->
						
					</div>
					<div class="portlet-body">
						<div class="tabbable-line">
							<ul class="nav nav-tabs activeTab">
								<li class="active" status="3">
									<a href="#tab_15_1" data-toggle="tab">
									List </a>
								</li>
								<li status="4">
									<a href="#tab_15_2" data-toggle="tab">
									Logged In Users </a>
								</li>

								<div class="actions pull-right">
                                    <form id="searchForm" class="form-inline" role="form" action="" method="post">
                                        <span style="color:grey">Filter Employee :</span>
                                        
                                        <div class="form-group">
                                            <input id="username" name="username" value="" type="text" class="form-control input-sm" placeholder="Enter Employee Name" required>
                                        </div>
                                    </form>
                                </div>
							</ul>

							<div class="tab-content">
								<div class="tab-pane active" id="tab_15_1">
										<div class="portlet-body">
											<table class="table table-striped table-bordered table-hover" id="employeeList">
											<thead>
											<tr>
												<th>
													 Username
												</th>
											</tr>
											</thead>

											<tbody id="tab-15-1-" style="display:none;">

											</tbody>
											<tbody id="tab-15-1">
											<?php foreach ($employeeList as $employee):?>
												<tr class="odd gradeX">

													<?php
		                            $userimage = URL.'webroot/files/user/image/'.$employee->User->image_dir.'/thumb2_'.$employee->User->image;
		                            $image = $employee->User->image;
		                            $gender = $employee->User->gender;
		                            $user_image = imageGenerate($userimage,$image,$gender);
		                      ?>
		                      
													<td>
														<img src="<?php echo $user_image; ?>" width="40" height="40" alt="image not found"/>
														<?php echo $employee->User->fname." ".$employee->User->lname;?>

														<?php if(in_array($employee->User->id, $loggedInArr)):?>
														 <span class="label label-sm label-success">
														 	present </span>
														 <?php else:?>
														 	<span class="label label-sm label-warning">
														 	absent </span>
														<?php endif;?>
													</td>
												</tr>
											<?php endforeach;?>
											</tbody>
											</table>
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
										</div>
								</div>
								<div class="tab-pane" id="tab_15_2">
									<div class="portlet-body">
											<table class="table table-striped table-bordered table-hover" id="loggedInUserTable">
											<thead>
											<tr>
												<th>
													 Username
												</th>
											</tr>
											</thead>
											<tbody id="tab-15-2-" style="display:none;">

											</tbody>
											<tbody id="tab-15-2">
											<?php foreach ($loggedInUsers as $loggedInUser):?>
												<tr class="odd gradeX">
																	<?php
		                            $userimage = URL.'webroot/files/user/image/'.$employee->User->image_dir.'/thumb2_'.$employee->User->image;
		                            $image = $loggedInUser->User->image;
		                            $gender = $loggedInUser->User->gender;
		                            $user_image = imageGenerate($userimage,$image,$gender);
		                      ?>
		                      
													<td>
														<img src="<?php echo $user_image; ?>" width="40" height="40" alt="image not found"/>
														<?php echo $loggedInUser->User->fname." ".$loggedInUser->User->lname;?>
														 <span class="label label-sm label-success">
														 	present </span>
													</td>
												</tr>
											<?php endforeach;?>
											</tbody>
											</table>
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

<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script>
jQuery(document).ready(function() {
   TableManaged.init();

   $("#employeeList").dataTable(
   	{
   		"paging":false,
   		"info":false,
   		"bFilter":false
   	});
   $("#loggedInUserTable").dataTable(
   	"bFilter":false
   	);

});
</script>

<script>
$(document).ready(function(){
	
	var status = 3;
	$(".activeTab > li").on('click',function(){
			status = $(this).attr('status');
			$("#username").val('');
			$("#tab-15-1-").hide();
			$("#tab-15-2-").hide();
			$("#tab-15-1").show();
			$("#tab-15-2").show();

	});

	function ImageExist(url)
      {
        var img = new Image();
        img.src = url;
        return img.height != 0;
      }

	var timer;
	var orgId = '<?php echo $orgId ;?>';
	var branchId = '0';
	var departmentId = '0';
	$('#username').on('keyup', function(e) {
        var username = $('#username').val();
        if(username == ''){
            username='0';    
        }

        clearTimeout(timer);
        timer = setTimeout(function (event) {
            filterEmployeeList(orgId,username,branchId,departmentId,status);           
        }, 600);

    });

    function filterEmployeeList(orgId,username,branchId,departmentId,status)
    {   
    	var url;
    	if(status == 3){
    		url = "<?php echo URL; ?>OrganizationUsers/filterEmployeeList/"+orgId+'/'+username+'/'+branchId+'/'+departmentId+'/'+status+'.json';

    	if(username != '0' && status == 3){
	    	$.ajax({
	    		url:url,
	    		type:'post',
	    		datatype:'jsonp',
	    		success:function(response){
	    			var html = "";
	    			$.each(response.output,function(key,val){
	    				if(ImageExist(val['User']['imagepath']) && val['User']['imagepath'] != ""){
	                          var imgurl = val['User']['imagepath'];
	                        }else{
	                          if(val['User']['gender']== 0){
	                            var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/defaultuser.png";
	                          }else{
	                            var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/femaleadmin.png";
	                          }
	                        }

		                html += '<tr class="odd gradeX">';
		                html += '<td><img src="'+imgurl+'" width="40" height="40" alt="image not found"/>';
						html += ' '+val.User.fname+' '+val.User.lname+' ';
						if(response.loggedInUsers.length != 0){
							$.each(response.loggedInUsers,function(k,v){
								if(v.User.id == val.User.id){
									html += '<span class="label label-sm label-success">present </span>';

								} else {
									html += '<span class="label label-sm label-warning">absent </span>';

								}
							});
						} else {
							html += '<span class="label label-sm label-warning">absent </span>';

						}
						html += '</td></tr>';
	    			});

					$("#tab-15-1-").html(html);
					$("#tab-15-1").hide();
					$("#tab-15-1-").show();

	    		}
	    	});
		} else {

				$("#tab-15-1").show();
				$("#tab-15-1-").hide();
		}

		}  else if(username != '0' && status == 4) {
    		url = "<?php echo URL; ?>ShiftUsers/filterEmployeeList/"+orgId+'/'+username+'.json';
    		$.ajax({
    			url:url,
    			type:'post',
    			datatype:'jsonp',
    			success:function(response){
    				
    				var html = "";
	    			$.each(response,function(key,val){
	    				if(ImageExist(val['User']['imagepath']) && val['User']['imagepath'] != ""){
	                          var imgurl = val['User']['imagepath'];
	                        }else{
	                          if(val['User']['gender']== 0){
	                            var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/defaultuser.png";
	                          }else{
	                            var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/femaleadmin.png";
	                          }
	                        }

		                html += '<tr class="odd gradeX">';
		                html += '<td><img src="'+imgurl+'" width="40" height="40" alt="image not found"/>';
						html += ' '+val.User.fname+' '+val.User.lname+' ';
						html += '<span class="label label-sm label-warning">present </span>';
						html += '</td></tr>';
	    			});
	    			$("#tab-15-2-").html(html);
					$("#tab-15-2").hide();
					$("#tab-15-2-").show();
    			}
    		});
    	}	else {

				$("#tab-15-2").show();
				$("#tab-15-2-").hide();
		}
    	
    }
});
</script>