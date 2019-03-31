<?php

if (isset($_POST['submit'])){ 
       // $_POST['data']['Leaverequest']['image'] = $_FILES['image']['name'];
        //if(move_uploaded_file($_FILES['image']['tmp_name'],URL_IMAGE));
        if(isset($_FILES['image'])){
            $_POST['data']['Leaverequest']['image']=array(
                'name'=>$_FILES['image']['name'],
                'type'=> $_FILES['image']['type'],
                'tmp_name'=> $_FILES['image']['tmp_name'],
                'error'=> $_FILES['image']['error'],
                'size'=> $_FILES['image']['size']
            );
        }
        $url = URL . "Leaverequests/saveLeaveRequest.json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
        if($response->body->message == '0'){
            ?><script>toastr.success('Your leave request has been successfully submitted');</script> <?php
        }elseif($response->body->message == '1'){
            ?><script>toastr.error('Sorry! could not submitted your request this time, try again latter.');</script> <?php
        }
}

?>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Leave Requests <small> New.</small></h1>
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
        			<a href="<?=URL_VIEW;?>leaverequests/myLeaveRequest">Leave</a>
                    <i class="fa fa-circle"></i>
        		</li>
                <li>
        			<a href="#">New Leave Request</a>
        		</li>
            </ul>

<div class="row">
<div class="col-md-12">

<div class="portlet light">
<div class="portlet-title">
    <div class="caption caption-md">
        <i class="icon-bar-chart theme-font hide"></i>
        <span class="caption-subject theme-font bold uppercase">Request Leave</span>
        <!-- <span class="caption-helper hide">weekly stats...</span> -->
    </div>
</div>
<div class="portlet-body form">

<form method="post" action="" role="form" enctype="multipart/form-data">
<div class="form-body">
<div class="form-group">
<?php if(isset($_GET['org_id'])){
    ?>
    <input class="form-control" type="hidden" name="data[Leaverequest][organization_id]" value="<?php echo $_GET['org_id'] ?>"/>
    <?php
}else{
    echo "<label>Select Organisation *</label>";
    echo "<select id=\"orgnid\" name=\"data[Leaverequest][organization_id]\" class=\"form-control\">";

    foreach($loginUserRelationToOther->userOrganization as $orgid => $otherDetail){
        $url = URL."Organizations/organizationProfile/".$orgid.".json";
        $orgs = \Httpful\Request::get($url)->send();
        
        echo "<option value=\"".$orgs->body->output->Organization->id."\">".$orgs->body->output->Organization->title."</option>";
    }
    echo "</select>";
} ?>
</div>
<div class="form-group">
<?php if(isset($_GET['branch_id']) && isset($_GET['org_id'])){
    ?>
    <input class="form-control" type="hidden" name="data[Leaverequest][branch_id]" value="<?php echo $_GET['branch_id'] ?>"/>
    <?php
}else{
    echo "<input type=\"hidden\" id=\"url\" value=\"".URL."\">";
    echo "<label>Select Branch *</label>";
    echo "<select name=\"data[Leaverequest][branch_id]\" id=\"branchid\" class=\"form-control\">";
    echo "</select>";
 ?>
    
 <?php } ?>
</div>
<div class="form-group">
<label>Select Board </label>
<select name="data[Leaverequest][board_id]" class="form-control" id="boardid">
</select>
</div>

<script>
        $(document).ready(function () {
            function getbranchlist(){
                var orgnid=$("#orgnid").val();
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getOrgProfile&orgid="+orgnid,
                    type: "post",
                    success:function(data){
                        var data1 = "";
                        var allbr=JSON.parse(data);            
                        $.each(allbr.Branch , function(k,obj){
                            data1 += "<option value=" + obj.id + ">" + obj.title + "</option>";
                        });

                        $("#branchid").html(data1);
                    }
                });

            }
            function getboardlist(){
                
                
                var orgnid=$("#orgnid").val();
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    data: "action=getOrgProfile&orgid="+orgnid,
                    type: "post",
                    success:function(data){
                        var data1 = "";
                        var allbrd=JSON.parse(data).Board;                  
                        $.each(allbrd, function(k,obj){
                            if(obj.branch_id == $("#branchid").val()){
                                data1 += "<option value=" + obj.id + ">" + obj.title + "</option>";
                            } 
                        });

                        $("#boardid").html(data1);
                    }
                });
                
                
            }
            getbranchlist();
            getboardlist();
            $("#orgnid").change(function(){
                getbranchlist();
                getboardlist();
                getLeaveType($('#orgnid').val());
            });
            $("#branchid").change(function(){
                getboardlist();
            });
        });
    </script>

<div class="form-group">
<label>Leave Type *</label>
<select name="data[Leaverequest][leavetype_id]" class="form-control" id="leaveType">
</select>
<?php 
if(isset($_GET['org_id'])){
    ?>
    <script>
        getLeaveType("<?php echo $_GET['org_id'];?>");
    </script>
<?php
}else{
    ?>
<script>
$(document).ready(function(){
    var orgid=$('#orgnid').val();
    getLeaveType(orgid);
});
</script>
    <?php
} ?>
     <script>
     function getLeaveType(orgId){
        $.ajax({
            url:"<?php echo URL."Leavetypes/getTypes/";?>"+orgId+".json",
            datatype:"jsonp",
            success:function(data){
                var data1 = "";
                if(data.leavetypes != null){
                   $.each(data.leavetypes,function(k,v){
                        data1 += "<option value='"+v.Leavetype.id+"'>"+v.Leavetype.name+"</option>";
                    }); 
                }else{
                    data1 += "No Types Defined";
                }
                
                $('#leaveType').html(data1);
            }
        });
     }
    </script>
</div>
<div class="form-group">
<label>Explanation on Leave *</label>
<textarea class="form-control" name="data[Leaverequest][detail]" placeholder="Detail"></textarea>
</div>
<div class="form-group">
<label>Leave Interval *</label>
<div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
<input class="form-control" type="text" name="data[Leaverequest][startdate]" placeholder="from date">
<span class="input-group-addon"> to </span>
<input class="form-control" type="text" name="data[Leaverequest][enddate]" placeholder="to date">
</div>
</div>

<div class="form-group">
<label>Supporting Documentation</label>
<input class="btn btn-default" type="file"  name='image'/>
</div>

<div class="form-group">
<input class="form-control" type="hidden"  name="data[Leaverequest][user_id]" value="<?php echo $user_id ?>"/>
</div>
<div class="form-actions">
<button type="submit" class="btn green" name="submit">Submit</button>
</div>
</div>
</form>
</div>
</div>
<div class="col-md-1"></div>
</div>



<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script>
jQuery(document).ready(function() {
   TableManaged.init();
   ComponentsPickers.init();

});
</script>