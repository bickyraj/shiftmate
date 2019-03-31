<?php 

if(isset($_POST['submit']))
{
    // echo "<pre>";
    // print_r($_POST['data']);
    $url = URL."UserInductions/add.json";

    $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
// echo"</pre>";
if($response->body->output == 0){ ?>
<script>
    toastr.error("Could not be save.");
</script>
<?php }else{ ?>
<script>
        toastr.success("Induction saved successfully!!");
</script>
<?php }
}


if (isset($_POST['editSubmit'])) {
// echo "<pre>";
// print_r($_POST['data']);
// die();
            $url = URL."Userinductions/editInductions.json";
            $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

?>
<script>
toastr.info('<?php echo $response->body->message; ?>','Edit Status');
</script>
<?php } ?>
<?php
$url = URL."Branches/listBranchesName/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

$url = URL."Branches/inductionList/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$inductionLists = $data->body->inductionList;
// echo "<pre>";
// print_r($inductionLists);
// die();
$url = URL."Branches/inductionListofnotTodo/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$inductionNotTodoLists = $data->body->inductionList;

$url = URL."Branches/inductionListofTodo/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$inductionTodoLists = $data->body->inductionList;

?>


<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>Create Induction</h1>
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
                <a href="<?=URL_VIEW."inductionChecklist/createInduction";?>">Inductions</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:;">Create Induction</a>
            </li>
        </ul>
        <!-- END PAGE HEADER-->

        <div class="row">
            <div class="modal fade" id="regnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Create Induction</h4>
                        </div>
                        <form method="post" action="" role="form" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-body">
                                                
                                    <input type="hidden" value="<?php echo $orgId;?>" name="data[Userinduction][organization_id]">
                                    <div class="form-group">
                                        <label >Induction Task</label>
                                        <textarea class="form-control" rows="3" name="data[Userinduction][induction_task]"></textarea>
                                                                
                                    </div>

                                                                  
                                            
                                    <input type="hidden" class="form-control" name="data[Userinduction][created_date]" value="<?php echo date('Y-m-d'); ?>" >
                                               
                                    

                                    <div class="form-group">
                                        <label>Assign Task</label>
                                        <select class="form-control" id="" name="data[Userinduction][status]">
                                        <option value= "0">Todo</option>
                                        <option value= "1" >Not Todo</option>
                                        <option value= "2" >Work Related</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Choose Branch</label>
                                        <select class="form-control" id="" name="data[Userinduction][branch_id]">
                                            
                                            <?php foreach($branches as $key=>$branch):?>
                                                <option value= "<?php echo $key;?>"><?php echo $branch;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn green" value="Submit" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <?php 
            if(isset($_GET['page1'])){
                $page1 = $_GET['page1'];
            }else{
                $page1 = 1;
            }
                    $url0 = URL."Userinductions/view/0/".$orgId."/".$page1.".json";
                    $response0 = \Httpful\Request::get($url0)->send();
                    $userinductions0 = $response0->body;

            if(isset($_GET['page2'])){
                $page2 = $_GET['page2'];
            }else{
                $page2 = 1;
            }
                    $url1 = URL."Userinductions/view/1/".$orgId."/".$page2.".json";
                    $response1 = \Httpful\Request::get($url1)->send();
                    $userinductions1 = $response1->body;

            if(isset($_GET['page3'])){
                $page3 = $_GET['page3'];
            }else{
                $page3 = 1;
            }
                    $url2 = URL."Userinductions/view/2/".$orgId."/".$page3.".json";
                    $response2 = \Httpful\Request::get($url2)->send();
                    $userinductions2 = $response2->body;



             ?>
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption caption-md">
                        <i class="icon-bar-chart theme-font hide"></i>
                        <span class="caption-subject theme-font bold uppercase">Induction Checklist</span>
                        <!-- <span class="caption-helper hide">weekly stats...</span> -->
                    </div>
                    <div class="pull-right ">
                        <button href="#regnew" type="button" class="btn btn-primary" data-toggle="modal">
                            <i class="fa fa-plus"></i> Add New
                        </button>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="tabbable-line">
                        <ul class="nav nav-tabs">
                        
                            <li class="<?php if(isset($_GET['page1'])){echo active;}?>">
                                <a href="#portlet_tab2_3" data-toggle="tab" aria-expanded="false">
                                Todo</a>
                            </li>
                            <li class="<?php if(isset($_GET['page2'])){echo active;}?>">
                                <a href="#portlet_tab2_2" data-toggle="tab" aria-expanded="false">
                                Not Todo </a>
                            </li>
                            <li class="<?php if(!isset($_GET['page1']) && !isset($_GET['page2'])){ echo "active";}?>">
                                <a href="#portlet_tab2_1" data-toggle="tab" aria-expanded="true">
                                Work Related </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane <?php if(!isset($_GET['page1']) && !isset($_GET['page2'])){ echo "active in";}?>" id="portlet_tab2_1">
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <ul class="nav nav-tabs tabs-left">
                                            <?php foreach($inductionLists as $inductionList):
                                            ?>
                                            <li class="<?php if(isset($_GET['page2'])){echo "active";}?>">
                                                <a href="#tab_6_<?php echo $inductionList->Branch->id; ?>" data-toggle="tab">
                                                <?php echo $inductionList->Branch->title; ?> </a>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                        <div class="tab-content">
                                            <?php foreach($inductionLists as $inductionList):?>
                                            <div class="tab-pane <?php if(isset($_GET['page2'])){echo "active in";}?> fade" id="tab_6_<?php echo $inductionList->Branch->id; ?>">
                                                <?php 
                                                    if(!empty($inductionList->Userinduction)){
                                                    foreach($inductionList->Userinduction as $induction):
                                                ?>
                                                    <div class="modal fade" id="portlet-config_1_<?php echo $induction->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                <h4 class="modal-title">Edit Induction</h4>
                                                        </div>
                                                        <div class="modal-body">


                                                        <form method="post" action="" role="form" enctype="multipart/form-data">
                                                                <div class="form-body">
                                                                                    
                                                                        <input type="hidden" value="<?php echo $orgId;?>" name="data[Userinduction][organization_id]">
                                                                        <div class="form-group">
                                                                            <label >Induction Task</label>
                                                                            <textarea class="form-control" rows="3" name="data[Userinduction][induction_task]" ><?php echo $induction->induction_task;?></textarea>
                                                                                                    
                                                                        </div>

                                                                                                      
                                                                                
                                                                        <input type="hidden" class="form-control" name="data[Userinduction][created_date]" value="<?php echo date('Y-m-d'); ?>" >
                                                                        <input type="hidden" name="data[Userinduction][id]" value="<?php echo $induction->id;?>">         
                                                                        

                                                                        <div class="form-group">
                                                                            <label>Assign Task</label>
                                                                            <select class="form-control" id="" name="data[Userinduction][status]">
                                                                            <?php if($induction->status==0){ ?>
                                                                                <option value= "0" selected="">Todo</option>
                                                                                <option value= "1" >Not Todo</option>
                                                                                <option value= "2" >Work Related</option>
                                                                            <?php }elseif ($induction->status ==1) { ?>
                                                                                 <option value= "0">Todo</option>
                                                                                <option value= "1" selected="">Not Todo</option>
                                                                                <option value= "2" >Work Related</option>
                                                                            <?php }elseif ($induction->status==2) { ?>
                                                                                <option value= "0">Todo</option>
                                                                                <option value= "1" >Not Todo</option>
                                                                                <option value= "2" selected="">Work Related</option>
                                                                            <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Choose Branch</label>
                                                                            <select class="form-control" id="" name="data[Userinduction][branch_id]">
                                                                                
                                                                                <?php foreach($branches as $key=>$branch):?>
                                                                                    <option value= "<?php echo $key;?>"<?php echo ($key == $induction->branch_id)? 'selected="selected"':'';?>><?php echo $branch;?></option>
                                                                                <?php endforeach;?>
                                                                            </select>
                                                                        </div>

                                                                </div>
                                                                
                                                                <div class="form-actions">
                                                                        <button type="submit" class="btn green" value="Submit" name="editSubmit">Submit</button>
                                                                        <button data-dismiss="modal" class="btn default">Close</button>
                                                                </div>

                                                        </form>

                                                          </div>

                                                     </div>

                                                </div>

                                                </div>
                                                    <p style= "background-color:#f7f7f7">
                                                        <a href="#portlet-config_1_<?php echo $induction->id; ?>"  data-toggle="modal" class="config" style="color:white; ">
                                                        <button class="btn btn-fit-height grey-salt">
                                                             <i class="fa fa-wrench"></i>
                                                        </button></a>
                                                        <i class="feeds fa fa-check" style="padding:5px ;"></i>
                                                        <?php echo $induction->induction_task; ?>
                                                    </p>
                                                <?php endforeach; ?>
                                                <?php } else { ?>
                                                        <p style= "background-color:#f7f7f7">
                                                            No Record Found
                                                        </p>
                                                <?php } ?>
                                            </div>
                                            <?php endforeach; ?>
                                            <!--<div class="tab-pane <?php if(isset($_GET['page2'])){echo "active in";}?> fade" id="tab_6_3">
                                                test3
                                            </div> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                <?php

                                $page=$userinductions2->page;
                                $max=$userinductions2->maxPage;
                                if($max>0){
                                ?>
                                <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                    <ul class="pagination" style="visibility: visible;">
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="First" href="?page3=1"><i class="fa fa-angle-double-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="Prev" href="?page3=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        
                                        <?php if($max<=5){
                                            for($i=1;$i<=$max;$i++){ ?>
                                            <li>
                                               <a title="<?=$i;?>" href="?page3=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                         <?php }}else{
                                            if(($page-2)>=1 && ($page+2)<=$max){
                                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page3=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                          <?php  }}elseif(($page-2)<1){
                                            for($i=1;$i<=5;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page3=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                         <?php }}elseif(($page+2)>$max){
                                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page3=<?=$i?>"><?=$i;?></a>
                                                </li>
                                        <?php }}} ?>
                                        
                                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                        <?php if($page>=$max){ ?>
                                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Next" href="?page3=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                        <?php } ?></li>
                                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                        <?php if($max==0 || $max==1){ ?>
                                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Last" href="?page3=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                        <?php } ?></li>
                                    </ul>
                                <?php } ?>
                                </div> -->
                            </div>

                            <div class="tab-pane <?php echo isset($_GET['page2'])?"active in":"";?>" id="portlet_tab2_2">
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <ul class="nav nav-tabs tabs-left">
                                            <?php foreach($inductionNotTodoLists as $inductionNottodoList):
                                            ?>
                                            <li class="<?php if(isset($_GET['page2'])){echo "active";}?>">
                                                <a href="#tab_71_<?php echo $inductionNottodoList->Branch->id; ?>" data-toggle="tab">
                                                <?php echo $inductionNottodoList->Branch->title; ?> </a>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                        <div class="tab-content">
                                            <?php foreach($inductionNotTodoLists as $inductionNottodoList): ?>
                                            <div class="tab-pane <?php if(isset($_GET['page2'])){echo "active in";}?> fade" id="tab_71_<?php echo $inductionNottodoList->Branch->id; ?>">
                                                <?php 
                                                    if(!empty($inductionNottodoList->Userinduction)){
                                                    foreach($inductionNottodoList->Userinduction as $induction):
                                                       
                                                ?>
                                                    <div class="modal fade" id="portlet-config_22_<?php echo $induction->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                <h4 class="modal-title">Edit Induction</h4>
                                                        </div>
                                                        <div class="modal-body">


                                                        <form method="post" action="" role="form" enctype="multipart/form-data">
                                                                <div class="form-body">
                                                                                    
                                                                        <input type="hidden" value="<?php echo $orgId;?>" name="data[Userinduction][organization_id]">
                                                                        <div class="form-group">
                                                                            <label >Induction Task</label>
                                                                            <textarea class="form-control" rows="3" name="data[Userinduction][induction_task]" ><?php echo $induction->induction_task;?></textarea>
                                                                                                    
                                                                        </div>

                                                                                                      
                                                                                
                                                                        <input type="hidden" class="form-control" name="data[Userinduction][created_date]" value="<?php echo date('Y-m-d'); ?>" >
                                                                        <input type="hidden" name="data[Userinduction][id]" value="<?php echo $induction->id;?>">         
                                                                        

                                                                        <div class="form-group">
                                                                            <label>Assign Task</label>
                                                                            <select class="form-control" id="" name="data[Userinduction][status]">
                                                                            <?php if($induction->status==0){ ?>
                                                                                <option value= "0" selected="">Todo</option>
                                                                                <option value= "1" >Not Todo</option>
                                                                                <option value= "2" >Work Related</option>
                                                                            <?php }elseif ($induction->status ==1) { ?>
                                                                                 <option value= "0">Todo</option>
                                                                                <option value= "1" selected="">Not Todo</option>
                                                                                <option value= "2" >Work Related</option>
                                                                            <?php }elseif ($induction->status==2) { ?>
                                                                                <option value= "0">Todo</option>
                                                                                <option value= "1" >Not Todo</option>
                                                                                <option value= "2" selected="">Work Related</option>
                                                                            <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Choose Branch</label>
                                                                            <select class="form-control" id="" name="data[Userinduction][branch_id]">
                                                                                
                                                                                <?php foreach($branches as $key=>$branch):?>
                                                                                    <option value= "<?php echo $key;?>"<?php echo ($key == $induction->branch_id)? 'selected="selected"':'';?>><?php echo $branch;?></option>
                                                                                <?php endforeach;?>
                                                                            </select>
                                                                        </div>

                                                                </div>
                                                                
                                                                <div class="form-actions">
                                                                        <button type="submit" class="btn green" value="Submit" name="editSubmit">Submit</button>
                                                                        <button data-dismiss="modal" class="btn default">Close</button>
                                                                </div>

                                                        </form>

                                                          </div>

                                                     </div>

                                                </div>

                                                </div>
                                                    <p style= "background-color:#f7f7f7">
                                                        <a href="#portlet-config_22_<?php echo $induction->id; ?>"  data-toggle="modal" class="config" style="color:white; ">
                                                        <button class="btn btn-fit-height grey-salt">
                                                             <i class="fa fa-wrench"></i>
                                                        </button></a>
                                                        <i class="feeds fa fa-check" style="padding:5px ;"></i>
                                                        <?php echo $induction->induction_task; ?>
                                                    </p>
                                                <?php endforeach; ?>
                                                <?php } else { ?>
                                                        <p style= "background-color:#f7f7f7">
                                                            No Record Found
                                                        </p>
                                                <?php } ?>
                                            </div>
                                            <?php endforeach; ?>
                                            <!--<div class="tab-pane <?php if(isset($_GET['page2'])){echo "active in";}?> fade" id="tab_6_3">
                                                test3
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                <?php
                                $page=$userinductions1->page;
                                $max=$userinductions1->maxPage;

                                if($max>0){
                                ?>
                                <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                    <ul class="pagination" style="visibility: visible;">
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="First" href="?page2=1"><i class="fa fa-angle-double-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="Prev" href="?page2=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        
                                        <?php if($max<=5){
                                            for($i=1;$i<=$max;$i++){ ?>
                                            <li>
                                               <a title="<?=$i;?>" href="?page2=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                         <?php }}else{
                                            if(($page-2)>=1 && ($page+2)<=$max){
                                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page2=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                          <?php  }}elseif(($page-2)<1){
                                            for($i=1;$i<=5;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page2=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                         <?php }}elseif(($page+2)>$max){
                                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page2=<?=$i?>"><?=$i;?></a>
                                                </li>
                                        <?php }}} ?>
                                        
                                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                        <?php if($page>=$max){ ?>
                                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Next" href="?page2=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                        <?php } ?></li>
                                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                        <?php if($max==0 || $max==1){ ?>
                                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Last" href="?page2=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                        <?php } ?></li>
                                    </ul>
                                <?php } ?>
                                </div> -->                        
                            </div>
                            <div class="tab-pane <?php echo isset($_GET['page1'])?"active in":"";?>" id="portlet_tab2_3">
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <ul class="nav nav-tabs tabs-left">
                                            <?php foreach($inductionTodoLists as $inductionTodoList):
                                            ?>
                                            <li class="<?php if(isset($_GET['page2'])){echo "active";}?>">
                                                <a href="#tab_73_<?php echo $inductionTodoList->Branch->id; ?>" data-toggle="tab">
                                                <?php echo $inductionTodoList->Branch->title; ?> </a>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-10">
                                        <div class="tab-content">
                                            <?php foreach($inductionTodoLists as $inductionTodoList): ?>
                                            <div class="tab-pane <?php if(isset($_GET['page2'])){echo "active in";}?> fade" id="tab_73_<?php echo $inductionTodoList->Branch->id; ?>">
                                                <?php 
                                                    if(!empty($inductionTodoList->Userinduction)){
                                                    foreach($inductionTodoList->Userinduction as $induction):
                                                       
                                                ?>
                                                    <div class="modal fade" id="portlet-config_33_<?php echo $induction->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                <h4 class="modal-title">Edit Induction</h4>
                                                        </div>
                                                        <div class="modal-body">


                                                        <form method="post" action="" role="form" enctype="multipart/form-data">
                                                                <div class="form-body">
                                                                                    
                                                                        <input type="hidden" value="<?php echo $orgId;?>" name="data[Userinduction][organization_id]">
                                                                        <div class="form-group">
                                                                            <label >Induction Task</label>
                                                                            <textarea class="form-control" rows="3" name="data[Userinduction][induction_task]" ><?php echo $induction->induction_task;?></textarea>
                                                                                                    
                                                                        </div>

                                                                                                      
                                                                                
                                                                        <input type="hidden" class="form-control" name="data[Userinduction][created_date]" value="<?php echo date('Y-m-d'); ?>" >
                                                                        <input type="hidden" name="data[Userinduction][id]" value="<?php echo $induction->id;?>">         
                                                                        

                                                                        <div class="form-group">
                                                                            <label>Assign Task</label>
                                                                            <select class="form-control" id="" name="data[Userinduction][status]">
                                                                            <?php if($induction->status==0){ ?>
                                                                                <option value= "0" selected="">Todo</option>
                                                                                <option value= "1" >Not Todo</option>
                                                                                <option value= "2" >Work Related</option>
                                                                            <?php }elseif ($induction->status ==1) { ?>
                                                                                 <option value= "0">Todo</option>
                                                                                <option value= "1" selected="">Not Todo</option>
                                                                                <option value= "2" >Work Related</option>
                                                                            <?php }elseif ($induction->status==2) { ?>
                                                                                <option value= "0">Todo</option>
                                                                                <option value= "1" >Not Todo</option>
                                                                                <option value= "2" selected="">Work Related</option>
                                                                            <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Choose Branch</label>
                                                                            <select class="form-control" id="" name="data[Userinduction][branch_id]">
                                                                                
                                                                                <?php foreach($branches as $key=>$branch):?>
                                                                                    <option value= "<?php echo $key;?>"<?php echo ($key == $induction->branch_id)? 'selected="selected"':'';?>><?php echo $branch;?></option>
                                                                                <?php endforeach;?>
                                                                            </select>
                                                                        </div>

                                                                </div>
                                                                
                                                                <div class="form-actions">
                                                                        <button type="submit" class="btn green" value="Submit" name="editSubmit">Submit</button>
                                                                        <button data-dismiss="modal" class="btn default">Close</button>
                                                                </div>

                                                        </form>

                                                          </div>

                                                     </div>

                                                </div>

                                                </div>
                                                    <p style= "background-color:#f7f7f7">
                                                        <a href="#portlet-config_33_<?php echo $induction->id; ?>"  data-toggle="modal" class="config" style="color:white; ">
                                                        <button class="btn btn-fit-height grey-salt">
                                                             <i class="fa fa-wrench"></i>
                                                        </button></a>
                                                        <i class="feeds fa fa-check" style="padding:5px ;"></i>
                                                        <?php echo $induction->induction_task; ?>
                                                    </p>
                                                <?php endforeach; ?>
                                                <?php } else { ?>
                                                        <p style= "background-color:#f7f7f7">
                                                            No Record Found
                                                        </p>
                                                <?php } ?>
                                            </div>
                                            <?php endforeach; ?>
                                            <!--<div class="tab-pane <?php if(isset($_GET['page2'])){echo "active in";}?> fade" id="tab_6_3">
                                                test3
                                            </div> -->
                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                <?php
                                $page=$userinductions0->page;
                                $max=$userinductions0->maxPage;

                                if($max>0){
                                ?>
                                <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                    <ul class="pagination" style="visibility: visible;">
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="First" href="?page1=1"><i class="fa fa-angle-double-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                        <?php if($page<=1){ ?>
                                        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                        <?php }else{ ?>
                                            <a title="Prev" href="?page1=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                        <?php } ?>
                                        </li>
                                        
                                        <?php if($max<=5){
                                            for($i=1;$i<=$max;$i++){ ?>
                                            <li>
                                               <a title="<?=$i;?>" href="?page1=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                         <?php }}else{
                                            if(($page-2)>=1 && ($page+2)<=$max){
                                                for($i=($page-2);$i<=($page+2);$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page1=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                          <?php  }}elseif(($page-2)<1){
                                            for($i=1;$i<=5;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" href="?page1=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                                </li>
                                         <?php }}elseif(($page+2)>$max){
                                            for ($i=($max-4);$i<=$max;$i++){ ?>
                                                <li>
                                                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page1=<?=$i?>"><?=$i;?></a>
                                                </li>
                                        <?php }}} ?>
                                        
                                        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                        <?php if($page>=$max){ ?>
                                        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Next" href="?page1=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                        <?php } ?></li>
                                        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                        <?php if($max==0 || $max==1){ ?>
                                        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                        <?php }else{ ?>
                                        <a title="Last" href="?page1=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
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
    </div>
</div>
