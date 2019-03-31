<style>
.dl-horizontal dt{
	width: 100px !important;
}
.dl-horizontal dd {
    margin-left: 120px !important;
}
</style>
<?php
// if(isset($_POST['modal_submit'])){
// // echo "<pre>";
// //             print_r($_POST['data']);
// //             die();

// $url = URL."Jobagreementtypes/editJobAgreementCategory.json";
//     $response = \Httpful\Request::post($url)
//             ->sendsJson()
//             ->body($_POST['data'])
//             ->send();

//             $status = $response->body->output->status;
//             if($status==2){
//             	
// 				<script>
// 					toastr.options = {
// 					"closeButton": true,
// 					"debug": false,
// 					"positionClass": "toast-top-center",
// 					"onclick": null,
// 					"showDuration": "1000",
// 					"hideDuration": "1000",
// 					"timeOut": "5000",
// 					"extendedTimeOut": "1000",
// 					"showEasing": "swing",
// 					"hideEasing": "linear",
// 					"showMethod": "fadeIn",
// 					"hideMethod": "fadeOut"
// 					}
// 					toastr.warning('Category Already exists',"Error");
// 				</script>


//             }
            
// }            
/*add  by rabi*/
if(isset($_SESSION['success']))
{
  
  echo("<script>
      toastr.success('Job Agreement Saved Successfully.');

            </script>");
  
  unset($_SESSION['success']);
}

/*end here*/

if(isset($_GET['page_no'])){
    $startlimit=$_GET['page_no'];
}else{
    $startlimit=1;
}

if(isset($_GET['page_num'])){
    $startpage=$_GET['page_num'];
}else{
    $startpage=1;
}


$url_types = URL."Jobagreementtypes/listJobAgreementType/".$startpage.'/'.$orgId.".json";
$data_types = \Httpful\Request::get($url_types)->send();
$types = $data_types->body->types;
//$types = $data_types->body->page;
// echo "<pre>";
// print_r($types);
// die();

// if(isset($_POST['submit'])){

// 	// print_r($_POST['data']);
// 	// die();
// 	$n = 0;
// 	foreach($types as $type){
// 		if($type->Jobagreementtype->type==$_POST['data']['Jobagreementtype']['type']){
// 			$n++;
// 		}
// 	}
	
// 	if($n==0){
// 	$url = URL."Jobagreementtypes/addJobAgreementCategory.json";
//         $response = \Httpful\Request::post($url)
//                 ->sendsJson()
//                 ->body($_POST['data'])
//                 ->send();
//         if($response->body->output->status == '1')
//         {
//         	echo '<script>
// 					toastr.options = {
// 					  "closeButton": true,
// 					  "debug": false,
// 					  "positionClass": "toast-top-center",
// 					  "onclick": null,
// 					  "showDuration": "1000",
// 					  "hideDuration": "1000",
// 					  "timeOut": "5000",
// 					  "extendedTimeOut": "1000",
// 					  "showEasing": "swing",
// 					  "hideEasing": "linear",
// 					  "showMethod": "fadeIn",
// 					  "hideMethod": "fadeOut"
// 					}
// 					toastr.success("Record Added Successfully");
// 		     	</script>';
//         }else
//         {
//         	echo '<script>
// 					toastr.options = {
// 					  "closeButton": true,
// 					  "debug": false,
// 					  "positionClass": "toast-top-center",
// 					  "onclick": null,
// 					  "showDuration": "1000",
// 					  "hideDuration": "1000",
// 					  "timeOut": "5000",
// 					  "extendedTimeOut": "1000",
// 					  "showEasing": "swing",
// 					  "hideEasing": "linear",
// 					  "showMethod": "fadeIn",
// 					  "hideMethod": "fadeOut"
// 					}
// 					toastr.error("Record Added Successfully");
// 		     	</script>';
//         }

//      }else{
  
//      echo '<script>
// 			toastr.options = {
// 			  "closeButton": true,
// 			  "debug": false,
// 			  "positionClass": "toast-top-center",
// 			  "onclick": null,
// 			  "showDuration": "1000",
// 			  "hideDuration": "1000",
// 			  "timeOut": "5000",
// 			  "extendedTimeOut": "1000",
// 			  "showEasing": "swing",
// 			  "hideEasing": "linear",
// 			  "showMethod": "fadeIn",
// 			  "hideMethod": "fadeOut"
// 			}
// 			toastr.warning("Agreement Type Already Exists", "Duplication");
//      	</script>';
//      }
// }



foreach($types as $type){
 //echo $type->Jobagreementtype->type;
// echo $a->Jobagreement->id;
 }
?>
<?php
if(isset($_POST['save_as_new'])){
	$jobagreement_id = $_GET['id'];

	
	//print_r($_POST['data']);
	if($user_id = $_POST['data']['Sentagreement']['user_id']){
	foreach($user_id as $userId){
	
	$url = URL."Sentagreements/sendAgreement/".$jobagreement_id."/".$orgId."/".$userId.".json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

            }
    }
}
//to list job agreements
$url = URL."Jobagreements/jobAgreementList/".$orgId."/".$startlimit.".json";
$data = \Httpful\Request::get($url)->send();
$agreements = $data->body->agreements->agreements;
// fal($agreements);
// echo "<pre>";
// print_r($agreements);
// die();
// foreach($agreements as $a){
// echo $a->Jobagreement->content;
// echo $a->Jobagreement->id;
// }

if(isset($_GET['page_num'])){
	$pageForSent = $_GET['page_num'];
} else {
	$pageForSent = 1;
}

$url = URL."Sentagreements/listSentAgreement/".$orgId.'/'.$pageForSent.".json";
$data2 = \Httpful\Request::get($url)->send();
$sentAgreements = $data2->body->data;
$sentAgreementsData = $data2->body;
//fal($sentAgreements);

$url1 = URL."OrganizationUsers/getOrganizationUsers/".$orgId.".json";
$data1 = \Httpful\Request::get($url1)->send();
$users = $data1->body->organizationUsers;
// echo '<pre>';
// print_r($users);
?>

<!-- 
<div class="portlet light col-md-offset-2 col-md-7">
	<div class="portlet-title tabbable-line">
		<div class="caption">
			<i class="icon-pin font-yellow-crusta"></i>
			<span class="caption-subject bold font-yellow-crusta uppercase">
			Job Agreement </span>
			<span class="caption-helper">more samples...</span>
		</div>

		<?php $tab=1; ?>
		<ul class="nav nav-tabs">
		<?php $type=1;?>
		<?php foreach($agreements as $agreement) { ?>
			<li class="<?php if($type==1){echo 'active';}?>">
				<a href="#<?php echo $type;?>" data-toggle="tab">
				Type  <?php echo $type;?></a>
			</li>
			<?php $type++;?>
			<?php } ?>
		</ul>
	</div>
	<div class="portlet-body">
		<div class="tab-content">
			<?php $type=1;?>
			<?php foreach($agreements as $agreement) { ?>
			<div class="tab-pane <?php if($type==1){echo 'active';}?>" id="<?php echo $type;?>">
					<h4 class="text-success">Agreement Templete <?php echo $type; ?></h4>
					<hr style="height:2px;width:200px;background-color:orange">
					<?php echo $agreement->Jobagreement->content; $type++;?>
		
	
		<form action="?id=<?php echo $agreement->Jobagreement->id;?>" method="post" class="form-horizontal" enctype="multipart/form-data">
		<div class="form-group">
			<div class="col-md-6">
			<select name="data[Sentagreement][user_id][]" class="user form-control" multiple="multiple">
				<option value=""></option>
				<?php
				foreach($users as $user){
				?>
				<option value="<?php echo $user->User->id;?>">
					<?php echo $user->User->fname.' '.$user->User->lname;?>
				</option>
				
				<?php
				}
				?>
			</select>
			</div>
			
		</div>
		<br>
		<div class="form-group">
			<div class="col-md-10">
				<button type="submit" value="Update" name="update" class="btn btn-success">Update</button>
				<button type="submit" value="Save as New" name="save_as_new" class="btn btn-success">Save As New</button>
			</div>
		</div>
		</form>


			</div>
			<?php } ?>
		
		</div>
	</div>
</div>
	 -->

		<!-- <hr style="height:2px;width:200px;background-color:orange"> -->
<div class="modal fade draggable-modal" id="edit-category" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Edit Job Agreement Category</h4>
			</div>
			<div class="modal-body">
			
			<!--forms begins-->
			<form class="editForm" action="" method="post">
			
		<div class="form-body">
		<div class="form-group">
			<label class="control-label">Job Agreement Category</label>
				<input type="text" name="data[Jobagreementtype][type]" value="" class="form-control input-sm" placeholder="Enter Category Name">
				<input type="hidden" name="data[Jobagreementtype][id]" value="">
				<input type="hidden" name="data[Jobagreementtype][organization_id]" value="<?php echo $orgId; ?>">
		</div>
	

		</div>

			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
				<button type="submit" name="modal_submit" class="btn green">Update Category</button>
			</div>
				</form><!--forms Ends-->
			

			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="page-head">
	<div class="container">
	    <div class="page-title">
			<h1>Job Agreements <small> List Agrements</small></h1>
		</div>  
	</div>
</div>

<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo URL_VIEW;?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Jobagreements</a>
            </li>
        </ul>
		<div class="portlet light bordered">
			<div class="portlet-title tabbable-line pull-left">
				<div class="caption">
				</div>
				<ul class="nav nav-tabs">
					<li class="<?php if(!isset($_GET['page_num'])){echo 'active';} ?>">
						<a href="#portlet_tab1" data-toggle="tab">
						Job Agreement </a>
					</li>
					<li class="<?php if(isset($_GET['page_num'])){echo 'active';} ?>">
						<a href="#tab2" data-toggle="tab">
						Job Agreement Type </a>
					</li>
					<li class="<?php if(isset($_GET['page_num'])){echo 'active';} ?>">
						<a href="#portlet_tab3" data-toggle="tab">
						Employee List </a>
					</li>
				</ul>
			</div>

			<div class="portlet-body">
				<div class="tab-content">
					<div class="tab-pane <?php if(!isset($_GET['page_num'])){echo 'active';} ?>" id="portlet_tab1">
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<span class="caption-subject theme-font bold uppercase">Job Agreements</span>
								</div>
								<div class="actions">
									<a href="<?php echo URL_VIEW.'jobagreements/jobagreement';?>" class="btn green btn-sm">New Agreement</a>
									<a href="<?php echo URL_VIEW.'jobagreements/sendtouser';?>" class="btn btn-sm purple">Send To User</a>
								</div>
							</div>
							<div class="portlet-body">
								<?php
									if(empty($agreements)){
									$noJobAgreement = 'No job agreement right now, Click to New  Agreement to make New Job Agreement';
									echo $noJobAgreement;
								} else {
								?>
								<div class="table-scrollable table-scrollable-borderless">
									<table class="table table-condensed table-hover">
										<thead>
											<tr>
												<th>
													 SN
												</th>
												<th>
													Category 
												</th>
												<th>
													 Title
												</th>
												<th>
													 Date
												</th>
								                <th>
								                    Attachment
								                </th>
												<th>
													 Action
												</th>
											</tr>
										</thead>
										<tbody>
											<?php $count=1; ?>
											<?php foreach($agreements as $agreement) {  ?> 
												<tr>
													<td>
														 <?php echo $count; ?>
													</td>
													<td>
														 <?php echo $agreement->Jobagreementtype->type; ?>
													</td>
													<td>
														 <?php echo $agreement->Jobagreement->title; ?>
													</td>
													<td>
														 <?php echo convertDate($agreement->Jobagreement->date); ?>
													</td>
									                <td>
									                    <?php 
									                    $file_name = URL."webroot/files/jobagreement/file/".$agreement->Jobagreement->file_dir."/".$agreement->Jobagreement->file;
									                    // $file_headers = @get_headers($file_name);
									                    /*$file_headers[0] == 'HTTP/1.1 404 Not Found'*/?>
									                    <a target="_blank" href="<?=$file_name?>"><i class="fa fa-download"></i></a>
									                </td>
													<td>
														<a class="btn btn-success btn-sm" href="<?php echo URL_VIEW."jobagreements/viewjobagreement?id=".$agreement->Jobagreement->id;?>"> <i class="fa fa-eye"></i> View</a>
													</td>
												</tr>
											<?php $count++; } ?>
										</tbody>
									</table>
								</div>
								<?php } ?>
							</div>
						</div>
						<!--pagination starts-->
				<!-- 		<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
							<?php
							$page=$data->body->agreements->page;
							$count1=$data->body->agreements->count;
							$limit1=$data->body->agreements->limit;
							$max=ceil($count1/$limit1);

							if($max>0){
							?>
							<div>Showing Page <?=$page;?> of <?=$max;?></div>
							    <ul class="pagination" style="visibility: visible;">
							        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
							        <?php if($page<=1){ ?>
							            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
							        <?php }else{ ?>
							            <a title="First" href="?page_no=1"><i class="fa fa-angle-double-left"></i></a>
							        <?php } ?>
							        </li>
							        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
							        <?php if($page<=1){ ?>
							        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
							        <?php }else{ ?>
							            <a title="Prev" href="?page_no=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
							        <?php } ?>
							        </li>
							        
							        <?php if($max<=5){
							            for($i=1;$i<=$max;$i++){ ?>
							            <li>
							               <a title="<?=$i;?>" href="?page_no=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
							            </li>
							         <?php }}else{
							            if(($page-2)>=1 && ($page+2)<=$max){
							                for($i=($page-2);$i<=($page+2);$i++){ ?>
							                <li>
							                   <a title="<?=$i;?>" href="?page_no=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
							                </li>
							          <?php  }}elseif(($page-2)<1){
							            for($i=1;$i<=5;$i++){ ?>
							                <li>
							                   <a title="<?=$i;?>" href="?page_no=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
							                </li>
							         <?php }}elseif(($page+2)>$max){
							            for ($i=($max-4);$i<=$max;$i++){ ?>
							                <li>
							                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page_no=<?=$i?>"><?=$i;?></a>
							                </li>
							        <?php }}} ?>
							        
							        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
							        <?php if($page>=$max){ ?>
							        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
							        <?php }else{ ?>
							        <a title="Next" href="?page_no=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
							        <?php } ?></li>
							        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
							        <?php if($max==0 || $max==1){ ?>
							        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
							        <?php }else{ ?>
							        <a title="Last" href="?page_no=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
							        <?php } ?></li>
							    </ul>
							<?php } ?>
						</div> -->
					</div>
					<div class="tab-pane <?php if(isset($_GET['page_num'])){echo 'active';} ?>" id="portlet_tab3"><!--starts tab2-->
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<span class="caption-subject theme-font bold uppercase">Sent Job Agreements</span> 
								</div>
							</div>
							<div class="portlet-body">
								
								<div class="panel-group accordion" id="accordion3">
									<div class="row"><div class="col-md-2 col-sm-2">
													 <h4>SN</h4>
												</div>
												<div class="col-md-5 col-sm-5">
												
													<h4>Employee Name</h4> 
												
												</div>
												<div class="col-md-5 col-sm-5">
												
													 <h4>Action</h4>
												
												</div>

											
									</div>
									<hr>
									<div id="resultPanel">
									<?php 
										
										$co = 1; if(isset($sentAgreements) && !empty($sentAgreements)){ 
											foreach($sentAgreements as $sent){
											?>
									

									<div class="panel panel-light">
										<div class="panel-heading">
											<div class="row">
									
											<div class="col-md-2 col-sm-2"><?php echo $co; ?></div>
											<div class="col-md-5 col-sm-5"><?php echo $sent->User->fname.' '.$sent->User->lname; ?></div>
											<div class="col-md-5 col-sm-5"><a data-userId="<?php echo $sent->User->id; ?>" class="btnDetails btn btn-sm green accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#<?php echo $sent->User->id; ?>">Details</a></div>
										

											</div>
										</div>
										<div id="<?php echo $sent->User->id; ?>" class="panel-collapse collapse">
											<div class="table-scrollable table-scrollable">
												<table  id="categoryTable" class="table table-light table-hover">
													<thead>
														<tr>
															<th>
																 SN
															</th>
															<th>
																Title 
															</th>
															<!-- <th>
																 Category
															</th> -->
															<th>
																 Sent Date
															</th>
															<th>
																Action
															</th>
														</tr>
													</thead>
													<tbody id="sentBody_<?php echo $sent->User->id; ?>">


													</tbody>
												</table>
											</div>
										</div>

									</div>
									


								
									<?php $co++; } } //else{ ?>
									</div>
								<?php if(empty($sentAgreements)) { ?>
										<span id="noRecord">No records found.</span>
									<?php } ?>
								</div>

								<!-- <div class="table-scrollable table-scrollable-borderless">
									<table id="categoryTable" class="table table-light table-hover">
										<thead>
											<tr>
												<th>
													 SN
												</th>
												<th>
													Employee Name 
												</th>
												<th>
													 Action
												</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										$co = 1; if(isset($sentAgreements) && !empty($sentAgreements)){ 
											foreach($sentAgreements as $sent){
											?>
											<tr data-userId="<?php echo $sent->User->id; ?>">
												<td><?php echo $co; ?></td>
												<td><?php echo $sent->User->fname.' '.$sent->User->lname; ?></td>
												<td><a class="btnDetails btn btn-sm green">Details</a></td>

											</tr>
										<?php $co++; }  }?>
										</tbody>
									</table>
								</div> -->
							</div>
							<hr>
							
							<div id="paginationDiv">
							<?php
							//fal($sentAgreements);
								$currentPage = $sentAgreementsData->currentPage;
								$pageCount = $sentAgreementsData->pageCount;
								//print_r($currentPage.' '.$pageCount); die();

								if($pageCount>0){
							?>
								<div>Showing Page <?=$currentPage;?> of <?=$pageCount;?></div>
							    <ul class="pagination" style="visibility: visible;">
							        <li class="prev <?php if($currentPage<=1){ echo 'disabled';}?>">
							        <?php if($currentPage<=1){ ?>
							            <a title="First" class="btnPage" data-page="javascript:;"><i class="fa fa-angle-double-left"></i></a>
							        <?php }else{ ?>
							            <a title="First" class="btnPage" data-page="1"><i class="fa fa-angle-double-left"></i></a>
							        <?php } ?>
							        </li>
							        <li class="prev <?php if($currentPage<=1){ echo 'disabled';}?>">
							        <?php if($currentPage<=1){ ?>
							        <a title="Prev" data-page="javascript:;"><i class="fa fa-angle-left"></i></a>
							        <?php }else{ ?>
							            <a title="Prev" class="btnPage" data-page="<?php echo ($currentPage-1); ?>"><i class="fa fa-angle-left"></i></a>
							        <?php } ?>
							        </li>
							        
							        <?php if($pageCount<=5){
							            for($i=1;$i<=$pageCount;$i++){ ?>
							            <li>
							               <a title="<?=$i;?>" data-page="<?=$i?>" class="btn btnPage <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
							            </li>
							         <?php }}else{
							            if(($currentPage-2)>=1 && ($currentPage+2)<=$pageCount){
							                for($i=($currentPage-2);$i<=($currentPage+2);$i++){ ?>
							                <li>
							                   <a title="<?=$i;?>" data-page="?pacurrentPagege_num=<?=$i?>" class="btn btnPage <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
							                </li>
							          <?php  }}elseif(($currentPage-2)<1){
							            for($i=1;$i<=5;$i++){ ?>
							                <li>
							                   <a title="<?=$i;?>" data-page="<?=$i?>" class="btn btnPage <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
							                </li>
							         <?php }}elseif(($currentPage+2)>$pageCount){
							            for ($i=($pageCount-4);$i<=$pageCount;$i++){ ?>
							                <li>
							                   <a title="<?=$i;?>" class="btn btnPage <?php if($currentPage==$i){echo "blue";}?>" data-page="<?=$i?>"><?=$i;?></a>
							                </li>
							        <?php }}} ?>
							        
							        <li class="next <?php if($currentPage>=$pageCount){echo 'disabled';}?>">
							        <?php if($currentPage>=$pageCount){ ?>
							        <a data-page="javascript:;" title="Next" class="btnPage"><i class="fa fa-angle-right"></i></a>
							        <?php }else{ ?>
							        <a title="Next" class="btnPage" data-page="<?php echo ($currentPage+1);?>"><i class="fa fa-angle-right"></i></a>
							        <?php } ?></li>
							        <li class="next <?php if($pageCount==0 || $pageCount==1){ echo "disabled"; }?>">
							        <?php if($pageCount==0 || $pageCount==1){ ?>
							        <a title="Last" class="btnPage" data-page="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
							        <?php }else{ ?>
							        <a title="Last" class="btnPage" data-page="<?php echo $pageCount;?>"><i class="fa fa-angle-double-right"></i></a>
							        <?php } ?></li>
							    </ul>
							<?php } ?>
					</div>	
					</div>	
					</div>	

					<div class="tab-pane <?php if(isset($_GET['page_num'])){echo 'active';} ?>" id="tab2"><!--starts tab2-->
						<div class="portlet light">
							<div class="portlet-title">
								<div class="caption">
									<span class="caption-subject theme-font bold uppercase">Job Agreement Categories</span> 
								</div>
								<form id="addCategory" action="" method="post" class="form-inline pull-right">
									<div class="form-group">
										<label class="control-label">Add New Category</label>
											<input id="categoryName" type="text" name="data[Jobagreementtype][type]" class="form-control" placeholder="Enter Category Name" required>
											<input type="hidden" name="data[Jobagreementtype][organization_id]" value="<?php echo $orgId; ?>" class="form-control">
										<button  name="submit" class="btn green">Add Category</button>
									</div>
								</form>			
							</div>
						
						<div class="portlet-body form">
							<div class="table-scrollable table-scrollable-borderless">
								<table id="categoryTable" class="table table-light table-hover">
									<thead>
										<tr>
											<th>
												 SN
											</th>
											<th>
												Category 
											</th>
											<th>
												 Date
											</th>
											<th>
												 Action
											</th>
										</tr>
									</thead>
									<tbody class="categoryBody">
										<?php $count = 1; ?>

										<?php 
										if(isset($types) && !empty($types)){
										foreach($types as $type) {  ?> 
										<tr count = "<?php echo $count; ?>">
											<td>
												 <?php echo $count; ?>
											</td>
											<td id="<?php echo $type->Jobagreementtype->id;?>">
												 <?php echo $type->Jobagreementtype->type; ?>
											</td>
											<td>
												 <?php echo convertDate($type->Jobagreementtype->date); ?>
											</td>
											<td>
												<a href="javascript:;" class="edit-category btn btn-xs btn-primary" data-categoryId="<?php echo $type->Jobagreementtype->id;?>"><i class="fa fa-edit"></i>Edit</a>
												<a href="javascript:;" class="deleteAgTypeBtn btn btn-xs btn-danger" data-categoryId="<?php echo $type->Jobagreementtype->id;?>"><i class="fa fa-edit"></i>Delete</a>
											</td>
										</tr>
										<?php $count++; } } else { ?>
										<tr class="jobAgretypeEmpty"><td>--</td><td>--</td><td>--</td><td>--</td></tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						</div>
					
	<!-- 					<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
							<?php
								$page=$data_types->body->page;
								$count_types=$data_types->body->count;
								$limit_types=$data_types->body->limit;
								$max=ceil($count_types/$limit_types);

								if($max>0){
							?>
								<div>Showing Page <?=$page;?> of <?=$max;?></div>
							    <ul class="pagination" style="visibility: visible;">
							        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
							        <?php if($page<=1){ ?>
							            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
							        <?php }else{ ?>
							            <a title="First" href="?page_num=1"><i class="fa fa-angle-double-left"></i></a>
							        <?php } ?>
							        </li>
							        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
							        <?php if($page<=1){ ?>
							        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
							        <?php }else{ ?>
							            <a title="Prev" href="?page_num=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
							        <?php } ?>
							        </li>
							        
							        <?php if($max<=5){
							            for($i=1;$i<=$max;$i++){ ?>
							            <li>
							               <a title="<?=$i;?>" href="?page_num=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
							            </li>
							         <?php }}else{
							            if(($page-2)>=1 && ($page+2)<=$max){
							                for($i=($page-2);$i<=($page+2);$i++){ ?>
							                <li>
							                   <a title="<?=$i;?>" href="?page_num=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
							                </li>
							          <?php  }}elseif(($page-2)<1){
							            for($i=1;$i<=5;$i++){ ?>
							                <li>
							                   <a title="<?=$i;?>" href="?page_num=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
							                </li>
							         <?php }}elseif(($page+2)>$max){
							            for ($i=($max-4);$i<=$max;$i++){ ?>
							                <li>
							                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page_num=<?=$i?>"><?=$i;?></a>
							                </li>
							        <?php }}} ?>
							        
							        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
							        <?php if($page>=$max){ ?>
							        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
							        <?php }else{ ?>
							        <a title="Next" href="?page_num=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
							        <?php } ?></li>
							        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
							        <?php if($max==0 || $max==1){ ?>
							        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
							        <?php }else{ ?>
							        <a title="Last" href="?page_num=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
							        <?php } ?></li>
							    </ul>
							<?php } ?>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade draggable-modal" id="modalView" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Sent Jobagreement</h4>
			</div>
			<div class="modal-body">
				<div class="row" id='viewContent'>

				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>

</div>

<!-- <div class="modal fade draggable-modal" id="modalDetails" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
			

			<form class="editForm" action="" method="post">
			
		<div class="form-body">
			<div class="table-scrollable table-scrollable-borderless">
				<table id="categoryTable" class="table table-light table-hover">
					<thead>
						<tr>
							<th>
								 SN
							</th>
							<th>
								Title 
							</th>
	
							<th>
								 Sent Date
							</th>
							<th>
								Action
							</th>
						</tr>
					</thead>
					<tbody id="sentBody">


					</tbody>
				</table>
			</div>

		</div>

			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Close</button>
			</div>
				</form>
			

			</div>
		</div>

	</div>

</div>
 -->
<!--pagination starts-->
<!-- <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
<?php
$page=$data->body->agreements->page;
$count1=$data->body->agreements->count;
$limit=$data->body->agreements->limit;
$max=ceil($count1/$limit);
?>


<ul class="pagination" style="visibility: visible;">
        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
        <?php if($page<=1){ ?>
            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
        <?php }else{ ?>
            <a title="First" href="?page_no=1"><i class="fa fa-angle-double-left"></i></a>
        <?php } ?>
        </li>
        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
        <?php if($page<=1){ ?>
        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
        <?php }else{ ?>
            <a title="Prev" href="?page_no=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
        <?php } ?>
        </li>
        <li class="next <?php if($page>=$max || $limit>$count1){echo 'disabled';}?>">
        <?php if($page>=$max || $limit>$count1){ ?>
        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
        <?php }else{ ?>
        <a title="Next" href="?page_no=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
        <?php } ?></li>
        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
        <?php if($max==0 || $max==1){ ?>
        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
        <?php }else{ ?>
        <a title="Last" href="?page_no=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
        <?php } ?></li>
    </ul>
</div> -->

<!--pagination ends-->

<script>
	$(document).ready(function(){

		$(".deleteAgTypeBtn").live('click',function(event)
			{
				var e = $(this);

				bootbox.confirm("Are you sure you want to delete ?", function(result) {

					if(result)
					{
						var id = e.attr('data-categoryId');

						var url = '<?php echo URL; ?>Jobagreementtypes/deleteJobAgreementType.json';
						$.ajax(
							{
								url:url,
								dataType:'jsonp',
								data:{typeId:id},
								type:'POST',
								success:function(res)
								{
									if(res ==1)
									{
										if($(".categoryBody tr").length == 1)
										{
											var tr = '<tr class="jobAgretypeEmpty"><td>--</td><td>--</td><td>--</td><td>--</td></tr>';
											$(".categoryBody").html(tr);
										}

										e.closest('tr').remove();
									}
									toastr.success('Job agreement type deleted successfully.');
								},
								error:function()
								{

								}
							});
					}
				}); 
			});
		
		var orgId = '<?php echo $orgId; ?>';
		$(".btnPage").live('click',function(){
			var page = $(this).attr('data-page');
			var url = '<?php echo URL; ?>Sentagreements/listSentAgreement/'+orgId+'/'+page+".json";
		
			$.ajax({
				url:url,
				datatype:'jsonp',
				type:'post',
				success:function(response){
					console.log(response);
					var result = '';
					if(response.length != 0){
						var currentPage = response.currentPage;
						var pageCount = response.pageCount;

						if(response.data.length != 0){
						var data = response.data;
						$.each(data,function(key,val){
						key++;

						result += '<div class="panel panel-light">';
						result += '<div class="panel-heading"><div class="row">';
						result += '<div class="col-md-2 col-sm-2">'+key+'</div>';
						result += '<div class="col-md-5 col-sm-5">'+val.User.fname+' '+val.User.lname+'</div>';
						result += '<div class="col-md-5 col-sm-5"><a data-userId="'+val.User.id+'" class="btnDetails btn btn-sm green accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#'+val.User.id+'">Details</a></div>';
						result += '</div></div>';
						result += '<div id="'+val.User.id+'" class="panel-collapse collapse">';
						result += '<div style="background:#CAD0CA;" class="panel-body">';
						result += '<div class="table-scrollable table-scrollable-borderless">';
						result += '<table  id="categoryTable" class="table table-light table-hover">';
						result += '<thead><tr><th>SN</th><th>Title</th><th>Sent Date</th><th>Action</th></tr></thead><tbody id="sentBody_'+val.User.id+'"></tbody></table></div></div></div>';
						result += '</div>';
							});			
						}				
					}
					//console.log(result);
					$("#paginationDiv").load('<?php echo URL_VIEW; ?>pagination.php?currentPage='+currentPage+'&pageCount='+pageCount);
					$("#resultPanel").html(result);
				}
			});
		});
		
		if (location.hash !== '') {
			$('a[href="' + location.hash + '"]').tab('show');
		    //return $('a[data-toggle="tab"]').on('shown', function(e) {
		     // return location.hash = $(e.target).attr('href').substr(1);
		//});
		}

		$(".btnView").live("click",function(){
			var orgId = '<?php echo $orgId; ?>';
			var jobAgreementId = $(this).closest('tr').attr('data-jobagreementId');
			var modal = $("#modalView");
			modal.modal();
			var url = '<?php echo URL; ?>Jobagreements/jobAgreementById/'+orgId+'/'+jobAgreementId+'.json';
			
			$.ajax({
				url:url,
				type:'post',
				datatype:'jsonp',
				success:function(response){
					var content ='';
					var agreement = response.agreement;
					var downloadLink = '';
					console.log(response);
					if(agreement.length != 0){
						href = "<?php echo URL; ?>webroot/files/jobagreement/file/"+agreement.Jobagreement.file_dir+'/'+agreement.Jobagreement.file;

						if(agreement.Jobagreement.file != '' && agreement.Jobagreement.file_dir != '0'){
							console.log(agreement.Jobagreement.file)
							downloadLink = '<a target="_blank" href="'+href+'"><i class="fa fa-download"></i></a>';
						} else {
							downloadLink = 'No attachment';
						}
						//console.log(downloadLink);
						

						content += '<dl class="dl-horizontal">';
					  	content += '<dt>Title:</dt>';
					  	content += '<dd>'+agreement.Jobagreement.title+'</dd>';
					  	
					  	content += '<dt>Category:</dt>';
					  	content += '<dd>'+agreement.Jobagreementtype.type+'</dd>';

					  	content += '<dt>Content:</dt>';
					  	content += '<dd>'+agreement.Jobagreement.content+'</dd>';
					  	content += '<dt>Attachment:</dt>';
					  	content += '<dd>'+downloadLink+'</dd>';

					    content += '</dl>';

					}

					modal.find("#viewContent").html(content);
					
				}
			});
		
		});

		$(".btnDetails").live("click",function(){
			var userId = $(this).attr("data-userId");
			var url = '<?php echo URL ?>Sentagreements/myJobagreement/'+userId+'.json';

			
			$.ajax({
				url:url,
				type:'post',
				datatype:'jsonp',
				success:function(response){

					var agreements ;
					agreements = response.myjobagreement;
					var username;
					var sentBody = '';
					var count = 1;
					
					if(agreements.length != 0){
						$.each(agreements,function(key,val){
							//console.log(val);
							username = val.User.fname+' '+val.User.lname;
							sentBody += '<tr data-jobagreementId="'+val.Jobagreement.id+'">';
							sentBody += '<td>'+count+'</td>';
							sentBody += '<td>'+val.Jobagreement.title+'</td>';
							// sentBody += '<td>'+val.Jobagreementtype.title+'</td>';
							sentBody += '<td>'+val.Sentagreement.date+'</td>';
							sentBody += '<td><a class="btnView btn btn-sm purple">View</a></td>';
							sentBody += '</tr>';

							count++;	
						});
						
						$("#sentBody_"+userId).html(sentBody);
						// modal.find("#sentBody").html(sentBody);
						// modal.find('.modal-title').html('Sent Jobagreements to '+'<span style="font-weight:500;">'+username+'</span>');
					}
				}
			});
		});
		
	  $(".user").select2({
	  placeholder: " --Select User--",
	  allowClear: true
	});

	  $("#addCategory").on('submit',function(event){
	  	event.preventDefault();

	  	var count = $("#categoryTable tr:last").attr('count');

	  	if(count == undefined){
	  		count = 0;
	  	}
	  	//var count = "<?php echo $count; ?>";
	  	var data = $(this).serialize();

	  	var url = '<?php echo URL; ?>Jobagreementtypes/addJobAgreementCategory.json';

	  	$.ajax({
	  		url:url,
	  		data:data,
	  		type:'post',
	  		datatype:'jsonp',
	  		success:function(response){
	  			if(response.output.status == 2){
	  				toastr.info('Category already exist with that name.');
	  			}
	  			else if(response.output.status == 1 ){
	  				count++;
	  				var category = response.output.category;
	  				var date = response.output.date;
	  				var id = response.output.id;

	  				var html1 = '<tr count = "'+count+'"><td>'+count+'</td><td id="'+id+'">'+category+'</td><td>'+date+'</td><td><a href="javascript:;" class="edit-category btn btn-xs btn-primary"  data-categoryId="'+id+'"><i class="fa fa-edit"></i>Edit</a><a href="javascript:;" class="deleteAgTypeBtn btn btn-xs btn-danger" data-categoryId="'+id+'"><i class="fa fa-edit"></i>Delete</a></td></tr>';
	  				
	  				if($(".jobAgretypeEmpty").length)
	  				{
	  					$(".jobAgretypeEmpty").remove();
	  				}

	  				$(".categoryBody").append(html1);
	  				toastr.success('Category added successfully.');
	  				
	  			} else {
	  				toastr.danger('Category could not be added');
	  			}
	  		}
	  	});

	  	$("#categoryName").val("");

	  });
		
		$(".editForm").on('submit',function(event){

			event.preventDefault();
			var data = $(this).serialize();



			var url = '<?php echo URL;?>Jobagreementtypes/editJobAgreementCategory.json';

			$.ajax({
				url:url,
				type:'post',
				data:data,
				datatype:'jsonp',
				success:function(response){
					$('#edit-category').modal('hide');
					var status = response.output.status;
					var category = response.output.category;
					var id = response.output.id;

					var body = (".categoryBody tr #"+id);
					if(status == 1){
						$(body).text(category);
						toastr.success('category edited successfully');
					} else if(status == 2){
						toastr.info('Category already exist with that name.');
					} else {
						toastr.danger('Category could not be added');
					}
					
					
				}
			});
		});

		$(".edit-category").live('click',function(event){
			var categoryId = $(this).attr('data-categoryId');

			var url = '<?php echo URL; ?>Jobagreementtypes/jobAgreementTypeById/'+categoryId+'.json';
			$.ajax({
				url:url,
				datatype:'jsonp',
				type:'post',
				async:false,
				success:function(response){
					var id = response.output.id;
					var category = response.output.category;
					$("#edit-category").find('input[name$="data[Jobagreementtype][type]"]').val(category);
					$("#edit-category").find('input[name$="data[Jobagreementtype][id]"]').val(id);
					$("#edit-category").modal();
				}
			});
		});
	});

</script>