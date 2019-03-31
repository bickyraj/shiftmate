
<?php

    
    $url = URL . "Branches/listBranchesName/".$orgId.".json";
    $branches = \Httpful\Request::post($url)->send()->body->branches;

?>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Shift Plans <small>View Shift Plans</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-circle"></i>
    			<a href="<?=URL_VIEW;?>">Home</a>
    			<i class="fa fa-circle"></i>
    		</li>
    		<li>
    			<a href="<?=URL_VIEW."shiftplans/showPlans";?>">Shift Plans</a>
    		</li>
        </ul>

            <!-- assign plan -->
            <?php
                if(isset($_POST['assignSpecificPlan']) && !empty($_POST['assignSpecificPlan'])){
                   // echo '<pre>';
                   // print_r($_POST['data']);
                    $count=0;
                    foreach($_POST['data']['ShiftUser']['user_id'] as $det){
                        $_POST['data1']['ShiftUser']['organization_id']=$_POST['data']['ShiftUser']['organization_id'];
                        $_POST['data1']['ShiftUser']['board_id']=$_POST['data']['ShiftUser']['board_id'];
                        $_POST['data1']['ShiftUser']['shift_id']=$_POST['data']['ShiftUser']['shift_id'];
                        $_POST['data1']['ShiftUser']['user_id']=$det;
                        $_POST['data1']['ShiftUser']['shift_date']=$_POST['data']['ShiftUser']['shift_date'];
                        $_POST['data1']['ShiftUser']['status']='1';
            //              
                        $_POST['data1']['ShiftplanUser']['0']['shiftplan_id']=$_POST['data']['ShiftplanUser']['shiftplan_id'];
                        
                        $planId = $_POST['data']['ShiftplanUser']['shiftplan_id'];

                        $_POST['data1']['ShiftplanUser']['0']['date']=$_POST['data']['ShiftUser']['shift_date'];;
                    
                   $url = URL . "ShiftUsers/assignShiftToUsers/".$planId.".json";
                    $response1 = \Httpful\Request::post($url)
                            ->sendsJson()
                            ->body($_POST['data1'])
                            ->send();

                            echo "<pre>";
                            print_r($response1);
                   ?>
                        <script>toastr.info('<?php echo $response1->body->message;?>','status')</script>
                <?php
                    }

                } 
            ?>
            <!-- make plan -->
            <?php
            if(isset($_POST['submitPlan'])){

                // echo '<pre>';
                // print_r($_POST['data']);
                // die();
                $url = URL . "Shiftplans/savePlan.json";
                    $response2 = \Httpful\Request::post($url)
                            ->sendsJson()
                            ->body($_POST['data'])
                            ->send();
            ?>
            <script>
            toastr.info("<?php echo $response2->body->message;?>","status");
            </script>
            <?php
            }
            ?>
            <!-- edit plan -->
            <?php if(isset($_POST['editPlan'])){
            $shiftplanId = $_POST['data']['Shiftplan']['id'];
               
                $url = URL . "Shiftplangroups/deleteGroup/".$shiftplanId.".json";
                    $response = \Httpful\Request::post($url)
                            ->sendsJson()
                            ->body($_POST['data'])
                            ->send();




                $url = URL . "Shiftplans/editPlan.json";
                    $response3 = \Httpful\Request::post($url)
                            ->sendsJson()
                            ->body($_POST['data'])
                            ->send();

                            // echo '<pre>';
                            // print_r($_POST['data']);
                            // die();
            ?>;
            <script>
            toastr.info("<?php echo $response3->body->message;?>","status");
            </script>
            <?php
            } ?>

            <!-- delete Plan -->
            <?php
            if(isset($_POST['deletePlan'])){
            $shiftplanId = $_POST['data']['Shiftplan']['id'];

                $url = URL . "Shiftplans/deletePlan.json";
                    $response4 = \Httpful\Request::post($url)
                            ->sendsJson()
                            ->body($_POST['data'])
                            ->send();

               $url = URL . "Shiftplangroups/deleteGroup/".$shiftplanId.".json";
                    $response = \Httpful\Request::post($url)
                            ->sendsJson()
                            ->body($_POST['data'])
                            ->send();
               $url = URL . "ShiftplanUsers/deleteShiftPlanUser/".$shiftplanId.".json";
                    $response = \Httpful\Request::post($url)
                            ->sendsJson()
                            ->body($_POST['data'])
                            ->send();             

                // $url = URL . "Shiftplangroups/deleteShiftUser.json";
                //      $response = \Httpful\Request::post($url)
                //              ->sendsJson()
                //              ->body($_POST['data'])
                //              ->send();                           


            ?>
            <script>
            toastr.info("<?php echo $response4->body->message;?>","status");
            </script>
            <?php
            }
            ?>

            <!-- show plan -->

            <?php
            $url = URL."Shiftplans/getPlans/".$orgId.".json";
            $data = \Httpful\Request::get($url)->send();
            $response = $data->body;
            // echo "<pre>";
            // print_r($response);
            // die();
            $url = URL."Groups/listGroup/".$orgId.".json";
            $data = \Httpful\Request::get($url)->send();
            $groups = $data->body;
            // print_r($groups);
            // die();
            ?>

            <div class="modal fade" id="assignDetail" tabindex="-1" role="basic" aria-hidden="true">            
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption" data-toggle="collapse" data-target=".todo-project-list-content">
                                    <span class="caption-subject font-green-sharp bold uppercase">Assigned User List</span>
                                </div>
                            </div>
                            <div class="user-details">
                               
                            </div>
                        </div>
                        <div class="modal-header">
                            <div class="form-actions right">
                                <button data-dismiss="modal" class="btn default" type="button">Close</button>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="deletePlan" tabindex="-1" role="basic" aria-hidden="true">            
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                            <h4 class="modal-title">Delete Plan</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are You Sure to delete plan ?</p>
                        </div>
                        <div class="modal-footer">
                            <form class="deletePlanForm" role="form" action="" method="post">
                                <input type="hidden" name="data[Shiftplan][id]" value=""/>
                                <!-- <input type="hidden" name="data[Shiftplangroup][shiftplan_id]" value=""/>
                                 -->
                                <input type="hidden" name="data[Shiftplan][status]" value="5"/>
                                <div class="form-actions right">
                                    <button class="btn green" type="submit" name="deletePlan">Delete</button>
                                    <button data-dismiss="modal" class="btn default" type="button">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="row">
                <!-- <button class="btn popovers" data-trigger="hover" data-container="body" data-placement="right" data-content="Popover body goes here! Popover body goes here!" data-original-title="Popover in right">Hover Right</button>
                 -->
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption caption-md">
                                <i class="icon-bar-chart theme-font hide"></i>
                                <span class="caption-subject theme-font bold uppercase">Shift Plans</span>
                            </div>
							<!-- <div class="tools">
								<div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="#basic" data-toggle="modal" id="sample_editable_1_new" class="btn green">
                                              Add New <i class="fa fa-plus"></i> </a>
                                              <a href="#assignShiftUser" data-toggle="modal" id="sample_editable_1_new" class="btn purple">
                                              Assign Task</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        
                                    </div>
							</div> -->
                            <div class="actions">
                                <a href="#basic" data-toggle="modal" id="sample_editable_1_new" class="btn green btn-sm">
                                <i class="fa fa-plus"></i> Add New </a>
                                <div class="btn-group">
                                    <a class="btn btn-sm purple" href="#assignShiftUser" data-toggle="modal" id="sample_editable_1_new">
                                    <i class="fa fa-user"></i> Assign Task
                                    </a>
                                </div>
                            </div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="addNewTable">
							<thead>
							<tr>
								<th>
									#
								</th>
								<th>
									 Title
								</th>
								<th>
									 Department
								</th>
								<th>
									 Shift
								</th>
                                <th style="min-width:90px;">
                                     Group
                                </th>
								<th>
									 Duration
								</th>
								<th>
									 Employees No.
								</th>
                                <th>
                                    Assigned
                                </th>
                                <th>
                                    Type
                                </th>
                                <th>
                                    Created
                                </th>
                                <th style="min-width:140px;">
                                    Actions
                                </th>
							</tr>
							</thead>
							<tbody id="shiftPlanBody">
                         
                               <?php
                               $count=0;
                               if(isset($response) && !empty($response)){
                                // echo '<pre>';print_r($response);
                                foreach($response as $res) {
                                    // echo '<pre>';
                                    // print_r($res);
                                    // die();
                                    if($res->ShiftplanUser == 1){
                                        $disabled = 1;
                                    } else {
                                        $disabled = 0;
                                    }
                                    $count++;
                                ?>                         
                            	<tr class="odd gradeX" count="<?php echo $count;?>" id="<?php echo $res->id ;?>">
		<td>
			<?php echo $count;?>
		</td>
		<td>
			 <?php echo $res->title;?>
		</td>
        
        <td>
            <?php echo $res->board;?>
        </td>
		<td>
			<?php echo $res->shift;?>
		</td>
        <td>
        <ul>
            <?php 
            if($res->group){
            foreach($res->group as $grp1) { 
                echo "<li>".$grp1->Group->title."</li>";
            }
            }
             ?>
         </ul>
        </td>
		<td>
			 <?php echo $res->duration;?>
		</td>
		<td class="center">
			 <?php echo $res->employee_no;?>
		</td>
        
        <td>
     
        <?php //echo $c0; ?>
        
        <a plan-id="<?php echo $res->id;?>" class="assignDetail btn green btn-xs">Assign Details</a>
        </td>

        <td>
            <?php if($res->documenttype==1){echo "Open";}elseif($res->documenttype==2){echo "Closed";} ?>
        </td>
        
        <td>
            <?php echo $res->created;?>
        </td>

     

        <td>
        
                 <!-- <a id="<?php echo $res->id;?>" data-toggle="delete" title="Delete" class="deletePlan btn red btn-xs"><i class="fa fa-trash-o"></i></a> -->
            <form action="" class="autoAssignForm" method="post">
                <a <?php if($disabled == 1){ echo "disabled" ;} ?> data-toggle="edit" title="Edit" data-Shiftplanid="<?php echo "#edit_".$res->id;?>"  class="editPlan sample_Shiftplan_9 btn-xs btn blue">
                    <i class="fa fa-edit"></i></a>
                <a <?php if($disabled == 1){ echo "disabled" ;} ?> id="<?php echo $res->id;?>" data-toggle="delete" title="Delete" class="deletePlan btn red btn-xs"><i class="fa fa-trash-o"></i></a>
                <input type="hidden" name="data[ShiftUser][organization_id]" value="<?php echo $orgId; ?>">
                <input type="hidden" name="data[ShiftUser][board_id]" value="<?php echo $res->boardId; ?>">
                <input type="hidden" name="data[ShiftUser][shift_id]" value="<?php echo $res->shiftId; ?>">
                <input type="hidden" name="data[ShiftplanUser][0][shiftplan_id]" value="<?php echo $res->id; ?>">
                 <button type="submit" data-planId="<?php echo $res->id;?>" name="autoAssign" class="autoAssign btn green btn-xs">Auto Assign</button>
            </form>
        </td>
	</tr>

<div class="modal fade" id="edit_<?php echo $res->id;?>" tabindex="-1" role="basic" aria-hidden="true">            

<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
<h4 class="modal-title">Edit Shift Plan</h4>
</div>
<div class="modal-body">    

<form method="post" action="" role="form" enctype="multipart/form-data">
<div class="form-body mainClassPlan">
<input type="hidden" name="data[Shiftplan][id]" value="<?php echo $res->id?>"/>
<input type="hidden" name="data[Shiftplan][organization_id]" value="<?php echo $orgId;?>" id="orgnid"/>
<input type="hidden" name="data[Shiftplan][user_id]" value="<?php echo $user_id;?>"/>
<!-- <input type="hidden" name="data[Shiftplan][shift_id]" value="<?php echo $siftId;?>"/>
<input type="hidden" name="data[Shiftplan][board_id]" value="<?php echo $boardId;?>"/> -->



<div class="form-group">
    <label>Title <span class="font-red">*</span></label>
    <input class="form-control " name="data[Shiftplan][title]" placeholder="title" required="required" value="<?php echo $res->title;?>"/>
</div>
<div class="form-group eboardid1">
    <label>Select Department <span class="font-red">*</span></label>
    <select name="data[Shiftplan][board_id]" id="boardid" class="eboardid form-control " required="required">
        <option value="<?php echo $res->boardId;?>" selected="selected"><?php echo $res->board;?></option>
    </select>

</div>

<!-- <input type="hidden" name="data[Shiftplangroup][shiftplan_id]" value="<?php echo $res->id?>"/>
 -->
<div class="form-group eshiftid1">
<label>Select Shift <span class="font-red">*</span> </label>
<select name="data[Shiftplan][shift_id]" class="form-control  eshiftid" required="required">
    <option value="<?php echo $res->shiftId;?>" selected="selected"><?php echo $res->shift;?></option>
</select>
</div>
<?php
 $groupId = array();
    $m = 0;
    if($res->group){
        foreach($res->group as $grp1) { 
            $groupId[$m] = $grp1->group_id; 
           $m++;
        }
    }
?>        
<div class="form-group eshiftid1">
<label>Select Group <span class="font-red">*</span> </label>

<select name="data[Shiftplangroup][][group_id]" class="form-control  group" required="required" multiple="multiple">
<?php 
foreach($groups as $group){ ?>
    <option value="<?php echo $group->Group->id;?>" <?php if(in_array($group->Group->id, $groupId)){ echo "selected" ;} ?>><?php echo $group->Group->title;?></option>
<?php } ?>
</select>
</div>

<div class="form-group">
<label>Number of Employee <span class="font-red">*</span></label>
<input type="number" min="1" name="data[Shiftplan][no_of_employer]" class="form-control " required="required" value="<?php echo $res->employee_no;?>"/>
</div>

<div class="form-group">
<label>Plan Interval <span class="font-red">*</span></label>
<div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
<input class="form-control " type="text" name="data[Shiftplan][start_date]" placeholder="from date" required="required" value="<?php echo $res->start_date;?>"/>
<span class="input-group-addon "> to </span>
<input class="form-control " type="text" name="data[Shiftplan][end_date]" placeholder="to date" required="required" value="<?php echo $res->end_date;?>"/>
</div>
</div>
<div class="form-group">
<label>Select Plan Type <span class="font-red">*</span> </label>
<select name="data[Shiftplan][documenttype]" class="form-control "  required="required">
<?php if($res->documenttype==1){?>
<option value="1" selected="selected">Open Shift</option>
<option value="2">Closed Shift</option>
<?php }elseif($res->documenttype==1){ ?>
<option value="1">Open Shift</option>
<option value="2" selected="selected">Closed Shift</option>
<?php }else{ ?>
<option value="1">Open Shift</option>
<option value="2">Closed Shift</option>
<?php } ?>
</select>
</div>
<div class="form-actions">
<button type="submit" class="btn green " name="editPlan">Submit</button>
<button data-dismiss="modal" class="btn default " type="button">Close</button>
</div>
</div>
</form>


</div>
<div class="modal-footer">

</div>
</div>   
</div>
</div>
                
          
<div class="modal fade" id="saveShiftUser_<?php echo $res->id;?>" tabindex="-1" role="basic" aria-hidden="true">            
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
<h4 class="modal-title">Assign the plan titled '<?php echo $res->title;?>' to Users</h4>
</div>
<div class="modal-body">

<form role="form" action="" method="post">

<div class="form-group">

    <input type="hidden" name="data[ShiftUser][organization_id]" value="<?php echo $orgId;?>"/>

    <input type="hidden" name="data[ShiftUser][board_id]" value="<?php echo $res->boardId;?>"/>
    <input type="hidden" name="data[ShiftUser][shift_id]" value="<?php echo $res->shiftId;?>"/>
    <input type="hidden" name="data[ShiftplanUser][shiftplan_id]" value="<?php echo $res->id;?>"/>
</div>
<?php
   // echo 'Already assigned : '. $c0; 
?>
<div class="form-group">

<?php
$startdate1=new DateTime();
//$startdate2=$startdate1->format('Y-m-d');
$datastartdate=DateTime::createFromFormat('Y-m-d', $res->start_date);
$dataenddate=DateTime::createFromFormat('Y-m-d', $res->end_date);
$startdate=$startdate1->diff($datastartdate);
$enddate=$startdate1->diff($dataenddate);
?>
<label class="control-label">Select Shift Date <span class="font-red">*</span></label>

<div class="input-group input-medium date date-picker shift-date<?php echo $res->id; ?>" data-date-format="yyyy-mm-dd" data-date-start-date="<?php echo $startdate->format('%R%ad');?>" data-date-end-date="<?php echo $enddate->format('%R%ad');?>">
    
    <input type="text" class="form-control" required="required" name="data[ShiftUser][shift_date]"/>

    <span class="input-group-btn">
    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
    </span>
</div><br>

<label>Select maximum <?php //echo ($res->no_of_employer - $c0);?> Users <span class="font-red">*</span></label>


<select class="js-example-<?php echo $res->id;?> form-control" id="exmple-<?php echo $res->id;?>" multiple="multiple" name="data[ShiftUser][user_id][]" required>
<option value=""></option>

</select>
<script>
$(".js-example-<?php echo $res->id;?>").select2({
  maximumSelectionSize: <?php echo ($res->employee_no-0);?>,
  placeholder: '--Select User--'
});
</script>




</div>


 <script>

    $(function() {

    function getAvailableUser(shiftId,boardId,shift_date){
    $.ajax({ 
        
        url: "<?php echo URL.'Useravailabilities/listAllAvailableUser/';?>"+shiftId+"/"+boardId+"/"+shift_date+".json",
        datatype:'jsonp',
        success:function(response){
             var data="";  
             if(response!='User not Found'){     
                $.each(response,function(key,user){
                    data+="<option value="+key+">"+user.name+"</option>";
                });
               $(".js-example-<?php echo $res->id;?>").select2('data',null);
                $('#exmple-<?php echo $res->id;?>').html(data);
            } else{
                $(".js-example-<?php echo $res->id;?>").select2('data',null);
                $('#exmple-<?php echo $res->id;?>').html("");
            }
        }

    });
    }



       $('.shift-date<?php echo $res->id;?>').on('changeDate', function(event)
        
        {

      var a = new Date(event.date);
      var year = a.getFullYear();
      var month = parseInt(a.getMonth())+1;
      var date = a.getDate();
      var shift_date = (year+"-"+month+"-"+date);

      var shiftId = "<?php echo $res->shiftId;?>";
      var boardId = "<?php echo $res->boardId;?>";
   
    getAvailableUser(shiftId,boardId,shift_date);
   
        });
   });
        
 </script>





</div>

<div class="modal-footer">
<div class="form-actions right">
    <button class="btn green" type="submit" name="assignSpecificPlan">Assign</button>
    <button data-dismiss="modal" class="btn default" type="button">Close</button>
</div>

</form>

</div>

</div>
<!-- /.modal-content -->
</div>
</div> 

                  
   <?php } } ?> <!--End of if(isset($response))-->                         
                            
                            
      
	</tbody>
	</table>
     <?php
   $count=0;
    foreach($response as $res){ 
        $count++; ?> 
<div class="modal fade" id="viewShiftUser_<?php echo $res->id;?>" tabindex="-1" role="basic" aria-hidden="true">            
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
<h4 class="modal-title">Assigned users Details</h4>
</div>
<div class="modal-body">
<?php if(!empty($resUser)){ ?>
<table class="table table-hover">
    <thead><tr><th>Image</th><th>Name</th><th>Email</th></tr></thead><tbody>
<?php foreach($resUser as $det){ ?>
<tr><td><img src="<?php echo URL."webroot/files/user/image/".$det->ShiftUser->User->image_dir."/".$det->ShiftUser->User->image;?>" style="height: 30px;width: 50px;"/></td><td><?php echo ucwords($det->ShiftUser->User->fname." ".$det->ShiftUser->User->lname);?></td><td><?php echo $det->ShiftUser->User->email;?></td></tr>
<?php } ?>
</tbody></table>
<?php }else{
    echo "No Users Assigned";
} ?>
</div>
<div class="modal-footer">
<div class="form-actions right">
    <button data-dismiss="modal" class="btn default" type="button">Close</button>
</div>
</div>
</div>
<!-- /.modal-content -->
</div>
</div>
<?php } ?>
   
   
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>


<div class="modal fade addPlanModal" id="basic" tabindex="-1" role="basic" aria-hidden="true">            
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
<h4 class="modal-title">Add Shift Plan</h4>
</div>
<div class="modal-body">    

<form id="addShiftPlan" method="post" action="" role="form" enctype="multipart/form-data">
<div class="form-body">
<input type="hidden" name="data[Shiftplan][organization_id]" value="<?php echo $orgId;?>" id="orgnid"/>
<input type="hidden" name="data[Shiftplan][user_id]" value="<?php echo $user_id;?>"/>
<div class="form-group">
    <label>Title <span class="font-red">*</span></label>
    <input id="title" class="form-control " name="data[Shiftplan][title]" placeholder="title" required="required"/>
</div>

<div class="form-group">
    <label>Select Branch <span class="font-red">*</span></label>
    <select id="select-branchid" class="form-control " required="required">
        <option value="0">--Select Branch--</option>
        <?php foreach ($branches as $key => $value): ?>
            <option value="<?php echo $key;?>"><?php echo $value; ?></option>
        <?php endforeach ?>
    </select>
</div>

<div class="form-group">
    <label>Select Department <span class="font-red">*</span></label>
    <select name="data[Shiftplan][board_id]" id="select-boardid" class="form-control " required="required">
        <option value="0">--Select Department--</option>
    </select>

</div>
<div class="form-group">
<label>Select Shift <span class="font-red">*</span> </label>
<select name="data[Shiftplan][shift_id]" class="form-control " id="select-shiftid" required="required">
    <option value="0">--Select Shift--</option>
</select>
</div>

<div class="form-group">
<label>Select Group <span class="font-red">*</span> </label>
<select id="group" name="data[Shiftplangroup][][group_id]" class="form-control  group" required="required" multiple="multiple">
<?php foreach($groups as $group){ ?>
    <option value="<?php echo $group->Group->id;?>"><?php echo $group->Group->title;?></option>
<?php } ?>
</select>
</div>

<div class="form-group">
<label>Number of Employee <span class="font-red">*</span></label>
<input id="noOfEmployee" min="1" type="number" name="data[Shiftplan][no_of_employer]" class="form-control " required="required">
</div>

<div class="form-group">
<label>Plan Interval <span class="font-red">*</span></label>
<div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
<input id="startDate" class="form-control " type="text" name="data[Shiftplan][start_date]" placeholder="from date" required="required"/>
<span class="input-group-addon "> to </span>
<input id="endDate" class="form-control " type="text" name="data[Shiftplan][end_date]" placeholder="to date" required="required"/>
</div>
</div>

<div class="form-group">
<label>Select Plan Type <span class="font-red">*</span> </label>
<select id="planType" name="data[Shiftplan][documenttype]" class="form-control "  required="required">
<option value="1">Open Shift</option>
<option value="2">Closed Shift</option>
</select>
</div>


</div>


<div class="modal-footer">
<div class="form-actions">
<button data-dismiss="modal" class="btn default " type="button">Cancel</button>
<button type="submit" class="btn green " name="submitPlan">Submit</button>
</div>
</div>
</form>
</div>


</div>   
</div>
</div>


<div class="modal fade" id="assignShiftUser" tabindex="-1" role="basic" aria-hidden="true">            
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
<h4 class="modal-title">Assign the plan to Users</h4>
</div>
<div class="modal-body">
<form role="form" action="" method="post">
<div class="form-group">
    <label>Select Shift Plan title</label>
    <select name="data[ShiftplanUser][shiftplan_id]" class="form-control shiftPlanOut">
        <option value="0" selected="" disabled="">--Select Plan Title--</option>
        <?php foreach($response as $r){
            echo "<option value='".$r->id."'>".$r->title."</option>";
        }?>
    </select>
    
<script>
    $(document).ready(function(){

    $("#addShiftPlan").submit(function() {
        $(this).submit(function(){
            return false;
        });
        return true;
        });

        $('.shiftPlanOut').change(function(){
            var e=$(this);
            var v=e.val();
        $.ajax({
            url: "<?php echo URL_VIEW."process.php";?>",
            data: "action=getShiftPlan&shiftplanId="+v,
            type: "post",
            success:function(data){
                var data1 = "";
                var cnt=0;
                var allDet=JSON.parse(data);  
                var aPlan=allDet.aPlans;
               // console.log(aPlan);
                $.each(aPlan.ShiftplanUser,function(k,v){
                   //console.log(cnt);
                   cnt++; 
                });
                
  data1 += '</div><div class="form-group">'+
    '<input type="hidden" name="data[ShiftUser][organization_id]" value="'+aPlan.Organization.id+'"/>'+
    '<input type="hidden" name="data[ShiftUser][board_id]" value="'+aPlan.Board.id+'"/>'+
    '<input type="hidden" name="data[ShiftUser][shift_id]" value="'+aPlan.Shift.id+'"/>'+
    '</div>'+
    '<div class="form-group">'+
    '<label>Already Assigned : '+parseInt(cnt)+'users </label><br/>'+
    '<label>Select maximum '+(parseInt(aPlan.Shiftplan.no_of_employer)-parseInt(cnt))+' Users <span class="font-red">*</span></label>'+
    '<select class="js-Out-Example form-control" id="exmple-Out" multiple="multiple" name="data[ShiftUser][user_id][]">'+
    '</select>'+
    '</div>'+
    '<label class="control-label">Select Shift Date (between '+aPlan.Shiftplan.start_date+' and '+aPlan.Shiftplan.end_date+')<span class="font-red">*</span></label>'+
    '<div class="input-group input-medium date date-picker-x" data-date-format="yyyy-mm-dd" data-date-start-date="'+aPlan.time.startdate+'"data-date-end-date="'+aPlan.time.enddate+'">'+   
    '<input type="text" class="form-control" readonly="" required="required" name="data[ShiftUser][shift_date]"/>'+
    '<span class="input-group-btn">'+
    '<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>'+
    '</span>'+
    '</div>';
    e.siblings().remove();
      e.parent().append(data1);
      
$(".js-Out-Example").select2({
  maximumSelectionSize: (parseInt(aPlan.Shiftplan.no_of_employer)-parseInt(cnt))
});

$(".date-picker-x").datepicker();

$.ajax({
    url: "<?php echo URL_VIEW."process.php";?>",
    data: "action=getboarduser&boardId="+aPlan.Board.id,
    type: "post",
    success:function(data){
        var data3 = "";
        var allUsers=JSON.parse(data);          
        $.each(allUsers , function(k,obj){
            data3 += "<option value='" + obj.User.id + "'>" + obj.User.fname + " " + obj.User.lname + "</option>";
        });
        $('#exmple-Out').html(data3);
        }
});
            }
            

        });
        });
    });
</script>


</div>
<div class="modal-footer">
<div class="form-actions right">
    <button data-dismiss="modal" class="btn default" type="button">Cancel</button>
    <button class="btn green" type="submit" name="assignSpecificPlan">Assign</button>
</div>
</form>
</div>
</div>
<!-- /.modal-content -->
</div>
</div> 

</div>
</div>

</div>
</div>

<script>
        $(document).ready(function () {

            $("#select-branchid").on('change', function(event)
                {
                    var branchId = $(this).val();
                    getboards(branchId);
                });
            function getboards(branchId)
            {
                var url = '<?php echo URL;?>Boards/getBoardListOfBranch/'+branchId+'.json';
                $.ajax(
                    {
                        url:url,
                        dataType:'jsonp',
                        async:false,
                        success:function(res)
                        {
                            // console.log(res.boardList);
                            var data1 = "<option value='0'>--Select Department--</option>";

                            if(res.boardList != "")
                            {
                                $.each(res.boardList , function(k,v){
                                        data1 += "<option value='" + v.Board.id + "'>" + v.Board.title + "</option>";
                                });
                                $("#select-boardid").html("").html(data1);
                            }else{
                                $("#select-boardid").html("").html(data1);
                            }
                        }
                    });
            }

            function getshiftlist(){
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getShifts&boardId="+$("#select-boardid").val(),
                    type: "post",
                    success:function(data){
                        var data1 = "<option value='0' disabled>--Select Shift--</option>";
                       
                        var allshft=JSON.parse(data);                  
                        $.each(allshft, function(k,obj){
                                data1 += "<option value='" + obj.Shift.id + "'>" + obj.Shift.title + "</option>";
                        });

                        $("#select-shiftid").html("").html(data1);
                    }
                });  
            }
            
            function geteshiftlist(n){
                var as=parseInt(n.val());
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getShifts&boardId="+as,
                    type: "post",
                    success:function(data){
                        var data1="";
                        var allshft=JSON.parse(data);                  
                        $.each(allshft, function(k,obj){
                            if(n.closest(".mainClassPlan").find(".eshiftid").val()==obj.Shift.id){
                                data1 += "<option value='"+ obj.Shift.id + "' selected='selected'>" + obj.Shift.title + "</option>";
                            }else{
                                data1 += "<option value='"+ obj.Shift.id + "'>" + obj.Shift.title + "</option>";
                            }
                                
                        });
                        n.closest(".mainClassPlan").find(".eshiftid").html(data1);
                    }
                });  
            }
            
            $("#select-boardid").change(function(){
                getshiftlist();
            });


            
            $(".eboardid").change(function(){
                var n=$(this);
                geteshiftlist(n);
            });
            
            $('.sample_Shiftplan_9').click(function(){
                var orgnid=$("#orgnid").val();
                var e=$(this);
                var f=$(this).attr('data-Shiftplanid');
                var i=$(f).find('.eboardid').val();
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getOrgProfile&orgid="+orgnid,
                    type: "post",
                    success:function(data){
                        var data1 = "";
                        var allbr=JSON.parse(data);            
                        $.each(allbr.Board , function(k,obj){
                            if(i == obj.id){
                               data1 += "<option value='"+obj.id+"' selected='selected'>"+obj.title+"</option>"; 
                            }else{
                                data1 += "<option value='"+obj.id+"'>"+obj.title+"</option>";
                            }
                            
                        });

                        $(f).find(".eboardid").html(data1);
                    }
                });
                
                $(f).modal('show');
               
            });
        });
    </script>
<script>
// var TableManaged = function () {
// var initTable1 = function () {

//         var table = $('#addNewTable');

//         // begin first table
//         table.dataTable({

//             // Internationalisation. For more info refer to http://datatables.net/manual/i18n
//             "language": {
//                 "aria": {
//                     "sortAscending": ": activate to sort column ascending",
//                     "sortDescending": ": activate to sort column descending"
//                 },
//                 "emptyTable": "No data available in table",
//                 "info": "Showing _START_ to _END_ of _TOTAL_ entries",
//                 "infoEmpty": "No entries found",
//                 "infoFiltered": "(filtered1 from _MAX_ total entries)",
//                 "lengthMenu": "Show _MENU_ entries",
//                 "search": "Search:",
//                 "zeroRecords": "No matching records found"
//             },

//             // Or you can use remote translation file
//             //"language": {
//             //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
//             //},

//             // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
//             // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
//             // So when dropdowns used the scrollable div should be removed. 
//             "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

//             "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

//             "columns": [{
//                 "orderable": false
//             }, {
//                 "orderable": true,
//                 "searchable":true
//             }, {
//                 "orderable": true,
//                 "searchable":true
//             }, {
//                 "orderable": true,
//                 "searchable":true                
//             }, {
//                 "orderable": false
//             }, {
//                 "orderable": false
//             }, {
//                 "orderable": false
//             }, {
//                 "orderable": false
//             }, {
//                 "orderable": false
//             }],
//             "lengthMenu": [
//                 [5, 15, 20, -1],
//                 [5, 15, 20, "All"] // change per page values here
//             ],
//             // set the initial value
//             "pageLength": 5,            
//             "pagingType": "bootstrap_full_number",
//             "language": {
//                 "search": "My search: ",
//                 "lengthMenu": "  _MENU_ records",
//                 "paginate": {
//                     "previous":"Prev",
//                     "next": "Next",
//                     "last": "Last",
//                     "first": "First"
//                 }
//             },
//             "columnDefs": [{  // set default column settings
//                 'orderable': false,
//                 'targets': [0]
//             }, {
//                 "searchable": false,
//                 "targets": [0]
//             }],
//             "order": [
//                 [1, "asc"]
//             ] // set first column as a default sort by asc
//         });

//         var tableWrapper = jQuery('#sample_1_wrapper');

//         table.find('.group-checkable').change(function () {
//             var set = jQuery(this).attr("data-set");
//             var checked = jQuery(this).is(":checked");
//             jQuery(set).each(function () {
//                 if (checked) {
//                     $(this).attr("checked", true);
//                     $(this).parents('tr').addClass("active");
//                 } else {
//                     $(this).attr("checked", false);
//                     $(this).parents('tr').removeClass("active");
//                 }
//             });
//             jQuery.uniform.update(set);
//         });

//         table.on('change', 'tbody tr .checkboxes', function () {
//             $(this).parents('tr').toggleClass("active");
//         });

//         tableWrapper.find('.dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
//     }
//         return {

//         //main function to initiate the module
//         init: function () {
//             if (!jQuery().dataTable) {
//                 return;
//             }

//             initTable1();
//         }

//     };

// }();
</script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script>
$(document).ready(function(){
    $("#addShiftPlan").on('submit',function(event){
        event.preventDefault();
        var  data = $(this).serialize();
        
        var title = $("#title").val();
        // console.log(title);
        var orgId = "<?php echo $orgId;?>";
        var boardText = $("#boardid option:selected").text();
        var boardId = $("#boardid option:selected").val();

        var shiftText = $("#shiftid option:selected").text();
        var shiftId = $("#shiftid option:selected").val();

        // var groupId = $("select#my_multiselect").val();
        // var groupText = $("select#group").text();

        var groupText= []; 
        $('#group :selected').each(function(i, selected){ 
          groupText[i] = $(selected).text(); 
        });


        var groupId = []; 
        $('#group :selected').each(function(i, selected){ 
          groupId[i] = $(selected).val(); 
        });

        var noOfEmployee = $("#noOfEmployee").val();

        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();

        var duration = startDate+' to '+ endDate;

        var planTypeText = $("#planType option:selected").text();
        // alert(planTypeText);
        var planTypeId = $("#planType option:selected").val();
        var count = $("#shiftPlanBody tr:last").attr('count');

        if(count == undefined){
            count = 0;
        }

        var url = '<?php echo URL; ?>Shiftplans/savePlan.json';
        $.ajax({
            url:url,
            type:'post',
            datatype:'jsonp',
            data:data,
            success:function(response){
               // console.log(response);
                var status = response.output.status;
                var id = response.output.id;
                var date = response.output.date;
                var html = '';
                count++;
                html +=   '<tr class="odd gradeX" count="'+count+'" id="'+id+'">';
                html +=   '<td>'+count+'</td>';
                html += '<td>'+title+'</td>';
                html += '<td>'+boardText+'</td>';
                html += '<td>'+shiftText+'</td>';
                html += '<td><ul>';
                $.each(groupText , function (key,val){
                    html += '<li>'+val+'</li>';
                });
                
                html += '</ul></td>';
                html += '<td>'+duration+'</td>';
                html += '<td class="center">'+noOfEmployee+'</td>';
                html += '<td><a plan-id="'+id+'" class="assignDetail btn green btn-xs">Assign Details</a></td>';
                html += '<td>'+planTypeText+'</td>'
                html += '<td>'+date+'</td>'
                html += '<td>';
                html += '<div><form action="" class="autoAssignForm" method="post">';
                html += '<a data-toggle="edit" title="Edit" data-Shiftplanid="id";  class="editPlan sample_Shiftplan_9 btn-xs btn blue"><i class="fa fa-edit"></i></a>';
                html += '<a id="'+id+'" data-toggle="delete" title="Delete" class="deletePlan btn red btn-xs"><i class="fa fa-trash-o"></i></a>';
                html += '<input type="hidden" name="data[ShiftUser][organization_id]" value="'+orgId+'">';
                html += '<input type="hidden" name="data[ShiftUser][board_id]" value="'+boardId+'">';
                html += '<input type="hidden" name="data[ShiftUser][shift_id]" value="'+shiftId+'">';
                html += '<input type="hidden" name="data[ShiftplanUser][0][shiftplan_id]" value="'+id+'">';
                html +=  '<button type="submit" data-planId="'+id+'" name="autoAssign" class="autoAssign btn green btn-xs">Auto Assign</button>';
                html += '</form></div>';
                html += '</td>';
                html += '</tr>';

                $("#shiftPlanBody").append(html);
                //$('#addNewTable').DataTable();
                $(".addPlanModal").modal("hide");

            }
            $(document).reload();
        });
    });
});
</script>

<script>
$(document).ready(function(){
    $('[data-toggle="edit"]').tooltip();   
    $('[data-toggle="delete"]').tooltip();   
    
    $(".assignDetail").live('click',function(){
        html = "";
        var planId = $(this).attr('plan-id');
        var url = '<?php echo URL;?>ShiftplanUsers/assignDetail/'+planId+'.json';
        $.ajax({
            url:url,
            type:'post',
            datatype:'jsonp',
            success:function(response){
                if(response == 1){
                    html += '<p>No user assigned yet</p>';
                } else {
                    $.each(response, function(i, item) {
                    html += '<div id="'+planId+'" class="panel panel-default">';
                    html += '<div class="panel-heading">';
                    html += '<h3 class="panel-title">'+i+'</h3>';
                    html += '</div>';
                    html += '<div class="panel-body">';
                     
                    $.each(item,function(key , val){ 
                        html += '<ul><li style="list-style:none;">'+val.user+'</li></ul>';
                    });
                    html += '</div>';
                    html += '</div>';


                });
                }
                
                //$(".user-details").attr("id",""+planId+"");
                $("#assignDetail").modal();
                $(".user-details").html(html);
                    
            }

        });
    });

    $(".autoAssignForm").live('submit',function(event){
        event.preventDefault();

        var shiftPlanId = $(this).find("button").attr("data-planId");
        var data = $(this).serialize();
        var url = '<?php echo URL ?>ShiftUsers/assignShiftToUsers/'+shiftPlanId+'.json';

        $.ajax({
            url:url,
            datatype:'jsonp',
            type:'post',
            data:data,
            success:function(response){
                console.log(response);
                var status = response.output.status;
                if(status == 2){
                    toastr.info("Not enough user or user already assigned.");
                } else if(status == 1){
                    toastr.success("User assigned for available dates.");
                    $("#addNewTable #"+shiftPlanId+" .deletePlan").attr('disabled','disabled');
                    $("#addNewTable #"+shiftPlanId+" .editPlan").attr('disabled','disabled');
                } 
                else {
                    toastr.info("Sorry , Employee might not be added in  the respective group.");
                }

            }
        });
    });

    $(".deletePlan").live('click',function(){
        var id = $(this).attr('id');
        var del = $("#deletePlan");
        del.modal();
        del.find('input[name="data[Shiftplan][id]"]').val(id);
    });

    $(".deletePlanForm").live('submit',function(){
        event.preventDefault();
        var data = $(this).serialize();
        var planId = $(this).find('input[name="data[Shiftplan][id]"]').val();
        var url = '<?php echo URL;?>Shiftplans/deletePlan.json';
        $("#deletePlan").modal('hide');
        $.ajax({
            url:url,
            data:data,
            type:'post',
            datatype:'json',
            success:function(response){
                var status = response.output.status;
                if(status == 1){
                    //$('#addNewTable').DataTable();
                    toastr.success('Shift plan successfully deleted..');
                    $("#shiftPlanBody #" + planId).remove();
                } else {
                    toastr.info('Shift plan could not be deleted');
                }
            }

        });

        $.ajax({
            url:'<?php echo URL; ?>Shiftplangroups/deleteGroup/'+planId+'.json',
            datatype:'jsonp',
            type:'post'
        });

        $.ajax({
            url:'<?php echo URL; ?>ShiftplanUsers/deleteShiftPlanUser/'+planId+'.json',
            datatype:'jsonp',
            type:'post'
        });
    });
   
});
</script>

<script>
jQuery(document).ready(function() {
   TableManaged.init();
   ComponentsPickers.init();
    $('#addNewTable').DataTable();

   $('.group').select2({
    placeholder: '--Select Group--'
   });

});
</script>