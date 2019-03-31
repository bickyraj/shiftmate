<?php

// echo "<pre>";
// print_r($tasks);
// die();

if(isset($_POST['submit'])){
	
	// print_r($_POST['data']);
	// die();

	$taskdate = $_POST['taskdate'];

	$date1 = DateTime::createFromFormat('d M Y - h:i A',$taskdate);
	$_POST['data']['Task']['taskdate']=$date1->format('Y-m-d H:i:s');
	$_POST['data']['Task']['user_id']=$user_id;
	// echo $date2;
	// die();
	$url = URL."Tasks/addTask.json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

        
//echo '<script> window.location="'.URL_VIEW.'tasks/listTask";</script>';
 //header('Location:URL_VIEW."/jobagreements/jobagreements'); 
}



// if(isset($_POST['submit_complete'])){
// 	$url = URL."Tasks/completeTask.json";
// 	 $response = \Httpful\Request::post($url)
//                 ->sendsJson()
//                 ->body($_POST['data'])
//                 ->send();

// echo '<script> window.location="'.URL_VIEW.'tasks/listTask";</script>';
                // print_r($response);
                // die();
//}
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}
$url = URL."Tasks/listTask/".$user_id."/".$page.".json";
$data = \Httpful\Request::get($url)->send();
$tasks = $data->body->tasks->tasks;
?>

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Task <small>task list</small></h1>
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
                <a href="#">Tasks</a>
            </li>
        </ul>


<div class="row">
<div class=" col-md-12 col-sm-12">
	<div class="portlet light tasks-widget">
		<div class="portlet-title tabbable-line">
			<div class="caption">
				<i class="icon-share font-green-haze hide"></i>
				<span class="caption-subject font-green-haze bold uppercase">Tasks</span>
				<span class="caption-helper">tasks summary...</span>
			</div>

			<ul class="nav nav-tabs">
								<li class="active">
									<a href="#portlet_tab1" data-toggle="tab">
									Your Current Task </a>
								</li>
								<li>
									<a href="#portlet_tab2" data-toggle="tab">
									Add New Task</a>
								</li>
							</ul>
		</div>
		<div class="portlet-body">
			<div class="task-content tab-content">
				<div class="tab-pane active" id="portlet_tab1">
					<!-- START TASK LIST -->
<!-- 					<div style=" max-height:300px; overflow:scroll">
 -->					
				<div>
 				<ul class="task-list">
					<?php if(!empty($tasks)){ ?>
					<?php foreach($tasks as $task) { ?>
						<li class="removeli">
							<div class="task-checkbox">
								<div><span><input type="checkbox" class="liChild" value=""></span></div>
							</div>
							<div class="task-title">
								<span class="task-title-sp">
								<?php echo $task->Task->task;?>
								 </span>
								<span class="label label-sm label-success">
								<?php 
									$taskdate = $task->Task->taskdate;
									$date1 = DateTime::createFromFormat('Y-m-d H:i:s',$taskdate);
									$date2=$date1->format('d M Y - h:i A');
									echo $date2;

								?></span>
								<span class="task-bell">
		
								</span>
							</div>
							<div class="task-config">
								<div class="task-config-btn btn-group">
									<a class="btn btn-xs default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
									<i class="fa fa-cog"></i><i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu pull-right" style="z-index:2;">
										<!-- <form action="" method="post"> -->
										<li>
											<i class="fa fa-check"></i> <button class="submit_task">Complete</button>
											<input type="hidden" class="id" value="<?php echo $task->Task->id;?>">
											<a href="javascript:;">
											<i class="fa fa-trash-o"></i> Cancel </a>
										</li>
										<!-- <input type="hidden" name="data[Task][status]">-->
										
										<!--</form> -->
										<!-- <li>
											<a href="javascript:;">
											<i class="fa fa-pencil"></i> Edit </a>
										</li> -->
										<!-- <li>
											<a href="javascript:;">
											<i class="fa fa-trash-o"></i> Cancel </a>
										</li> -->
									</ul>
								</div>
							</div>
						</li>
						<?php } ?>
						<?php } else { echo 'You dont have any task schedule right Now.'; } ?>
					</ul><!-- <br><br><br> -->
					</div>
					<!-- END START TASK LIST -->
<hr>
					<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
<?php
$page=$data->body->tasks->page;
$max=$data->body->tasks->maxPage;

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



				<div class="tab-pane" id="portlet_tab2">

					<?php include 'addTask.php';?>

				</div>
			</div>
			<!-- <div class="task-footer">
				<div class="btn-arrow-link pull-right">
					<a href="javascript:;">See All Records</a>
					<i class="icon-arrow-right"></i>
				</div>
			</div> -->
		</div>


	</div>
</div>

</div>
</div>
</div>

<script>
$(document).ready(function (){
	$('.submit_task').click(function(){
		var th=$(this);
		var id=$(this).siblings(".id").val();			    	
$.ajax({
  url: '<?php echo URL."Tasks/completeTask/";?>'+id+".json",
  datatype: 'jsonp',
  success: function( msg ) {
    var status = JSON.parse(msg);
    if(status==1){
    	toastr.success('Your Task is removed from the list');
    	th.parents('.removeli').hide();
  	} else
  		{
  		toastr.warning('Action not completed, please try again');
  		}

  }
});
});
});
  </script>