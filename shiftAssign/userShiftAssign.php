<?php 
$url = URL."Boards/listBoards/".$orgId.".json";
$response = \Httpful\Request::get($url)->send();
$boards = $response->body->boards;

// print_r($boards);
// die();


// $url = URL."Useravailabilities/listAllAvailableUser/".$orgId.".json";

// $response = \Httpful\Request::get($url)->send();
// $available = $response->body;

// echo '<pre>';
// print_r($available);
// die();

// echo "<pre>";
// print_r($shifts);

if(isset($_POST['submit']))
{

    $url = URL."ShiftUsers/assignShiftToUser.json";
    $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

                if($response->body->output->status == 0)
                {
                    echo '<script>
                            toastr.error("Could not be save.");
                    </script>';
                }

                else
                {
                    echo '<script>
                            toastr.success("Shift assigned successfully!!");
                    </script>';
                }
}
?>
<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Assign Shift </h1>
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
                    <a href="#">Assign Shift</a>
                </li>
            </ul>


<div class="row">
    <div class="col-md-1"></div>
        <div class="col-md-10">

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-gift"></i>Assign Shift</div>
                        <div class="tools">
                        <a class="reload" href="" data-original-title="" title=""></a>
                        <a class="remove" href="" data-original-title="" title=""></a>
                        </div>
                </div>
    <div class="portlet-body form">

            <form method="post" action="" role="form" enctype="multipart/form-data">
            <div class="form-body">

            <div class="form-group">
            <label >Date</label>
                        <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                            <input type="text" class="form-control" id="day_id" name="data[ShiftUser][shift_date]" required>
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                        <!-- /input-group -->
                        <span class="help-block">
                        Select date </span>
                    </div>


                    

                <div class="form-group">
                    <input type="hidden" name="data[ShiftUser][organization_id]" value="<?php echo $orgId;?>">
                       <div class="form-group">
                        <label >Board Name</label>
                        <select class="form-control" id="boardname" name="data[ShiftUser][board_id]">
                            <option value="">Select Board</option>
                            <?php foreach ($boards as $board):?>
                            <option value="<?php echo $board->Board->id;?>"><?php echo $board->Board->title;?></option>
                            <?php endforeach;?>

                        </select>                            
                        </div>
                    </div>

                  <div class="form-group">
                            <label >Assgin Shift</label>
                            <select id="shifts" class="form-control" name="data[ShiftUser][shift_id]">
                                <option value="">Select Shift</option>

                            </select>
                                                    
                        </div>
                                                

                

               <div class="form-group">
                        <label>User</label>
                        <select class="form-control" id="boardusers" name="data[ShiftUser][user_id]">
                        <option value="" selected disabled>Select User</option>
                        </select>
                            
                        </div>


                      

                       
            </div>
                            
                <div class="form-actions">
                <button type="submit" class="btn blue input-circle" name="submit">Submit</button>
                </div>
            
        </form>

        </div>
    </div>
</div>
</div>


<script type="text/javascript">
        $(document).ready(function(){
            $("#boardname").change(function(){
                var boardId = $("#boardname").val();

                getBoardUser(boardId);
                getShifts(boardId);

            });

            function getBoardUser(boardId)
            {
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getboarduser&boardId="+boardId,
                    type: "post",
                    success:function(response){
                        var data;
                        var users = JSON.parse(response);
                        
                        $.each(users, function(k,obj){
                            console.log(obj);
                           data+= "<option value=" + obj.User.id + ">" + obj.User.fname+" "+obj.User.lname+ "</option>";
                       });

                      $("#boardusers").html(data);
                    }
                });

            }

            function getShifts(boardId)
            {
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getShifts&boardId="+boardId,
                    type: "post",
                    success:function(response){
                        
                        $("#shifts").html("");
                        var data;
                        var shifts = JSON.parse(response);

                        if(jQuery.isEmptyObject(shifts))
                        {
                            
                            data = "<option value=''>No Shift on this board</option>";
                            $("#shifts").html(data);
                        }
                        else
                        {
                            $.each(shifts, function(k,obj){
                                data+= "<option value=" + obj.Shift.id + ">" +obj.Shift.title+ "</option>";
                                });
                            $("#shifts").html(data);
                        }

                        
                    }
                });
            }   


            function getAvailableUser(shiftId,boardId,shift_date)
            {
               // alert(orgId+" -- "+boardId+" -- "+dayId+" -- "+shiftId+" -- "+day);
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getAvailableUser&shiftId="+shiftId+"&boardId="+boardId+"&shift_date="+shift_date,
                    type: "post",
                    success:function(data){
                        var data1="";
                        data=JSON.parse(data);
                          console.log(data);
                     
                     if(data=='User not Found'){

                       data1+="<option value=''>No User Found</option>";
                        $('#boardusers').html(data1);
                     } else {

                      $.each(data,function(k,v){
                          
                        
                          data1+="<option value="+v.id+">"+v.name+"</option>";
                    });
                  }
                       $('#boardusers').html(data1);
                    }
                });

            }

            $('#shifts').change(function(){ 
                
                var shift_date=$('#day_id').val();

                var boardId =  $("#boardname").val();

                var shiftId = $("#shifts").val();
                
                getAvailableUser(shiftId,boardId,shift_date);
            });

        });
</script>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   ComponentsPickers.init();
});   
</script>
    

