<?php
if(isset($_POST['save_as_new'])){
	//fal($_POST['data']);

	if($user_id = $_POST['data']['Sentagreement']['user_id']){
	foreach($user_id as $userId){
	
	$url = URL."Sentagreements/sendAgreements/".$orgId."/".$userId.".json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

  	
            }
//fal($response);
            if($response->body->status == '1'){
            	echo("<script>
	     			 toastr.success('Job agreement sent to employee successfully.');

	            </script>");
            } else {
            	echo("<script>
	     			 toastr.info('Something went wrong.Please try again.');

	            </script>");
            }
	}
} else {

if(isset($_POST['update'])){
	//fal($_POST['data']);
	if($user_id = $_POST['data']['Sentagreement']['user_id']){

		foreach($user_id as $userId){
		$url = URL."Sentagreements/updateSentAgreements/".$orgId."/".$userId.".json";
        	$response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

                
		}
		if($response->body->status == '1'){
            	echo("<script>
	     			 toastr.success('Job agreement sent to employee successfully.');

	            </script>");
            } else {
            	echo("<script>
	     			 toastr.info('Something went wrong.Please try again.');

	            </script>");
            }


	}
}
}

$url = URL."OrganizationUsers/getOrganizationUsers/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$users = $data->body->organizationUsers;



$url1 = URL."Jobagreements/jobAgreementList/".$orgId."/".".json";
$data1 = \Httpful\Request::get($url1)->send();
$agreements = $data1->body->agreements->agreements;

// echo '<pre>';
// print_r($agreements);
// die();
// $url = URL."Jobagreementtypes/listJobAgreementType.json";
// $data = \Httpful\Request::get($url)->send();
// $types = $data->body->types;

$url = URL."Jobagreementtypes/categoryOfOrg/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$types = $data->body;
//fal($types);

?>

<div class="page-head">
	<div class="container">
	    <div class="page-title">
			<h1>Job Agreements <small> Send to user</small></h1>
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
                <a href="<?php echo URL_VIEW.'jobagreements/jobagreements'?>">Job Agreements</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Send to User</a>
            </li>
        </ul>


	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
				<span class="caption-subject theme-font bold uppercase">Send Job Agreement to User</span>
			</div>
			<!-- <div class="caption font-red-intense">
				<i class="icon-speech font-red-intense"></i>
				<span class="caption-subject bold uppercase"></span>
				<span class="caption-helper">Send Job Agreement to User</span>
			</div> -->
		</div>
		<div class="portlet-body">
			<div id="context2" data-toggle="context" data-target="#context-menu">
				<div class="row col-md-offset-1">
		<form action="" method="post" class="form-horizontal">
		<div class="form-body">

			<div class="form-group">
			<div class="col-md-6">
			<select id="selectType" name="" class="form-control" required>
				<option value="" disabled selected>--Select Category--</option>
				<?php foreach($types as $type) { ?>
				<option value="<?php echo $type->Jobagreementtype->id;?>">
					<?php echo $type->Jobagreementtype->type;?>
				</option>
				<?php } ?>
			</select>
			</div>
		</div>
			
			<div class="form-group">
				<div class="col-md-6">
				<select id="selectTitle" name="data[Sentagreement][jobagreement_id]" class="form-control" required>
					<option value="" disabled selected>--Select Title--</option>
				</select>
				</div>
			</div>

			<div class="form-group">
			<div class="col-md-6">
			<select name="data[Sentagreement][user_id][]" class="user form-control input-circle" multiple="multiple" required>
				<option value=""></option>
				<?php foreach($users as $user) { ?>
				<option value="<?php echo $user->User->id;?>">
					<?php echo $user->User->fname.' '.$user->User->lname;?>
				</option>
				<?php } ?>
			</select>
			</div>
		</div>
		<br>
		</div>

		<div class="row">
			<div class="actions">
				<div class="col-md-9">
					<button type="submit" name="update" class="btn btn-success">Update</button>
					<button type="submit" name="save_as_new" class="btn btn-success">Save As New</button>
				</div>
			</div>
		</div>
				
		</form>
		</div>

			</div>
			<!-- Your custom menu with dropdown-menu as default styling -->
		</div>
	</div>
	</div>
</div>



<script>
$(document).ready(function(){

$("#selectType").on("change",function(){
	var typeId = $("#selectType").val();
	var orgId = '<?php echo $orgId; ?>';
	var url = '<?php echo URL; ?>Jobagreements/listTitle/'+typeId+'/'+orgId+'.json';
	
	$.ajax({
		url:url,
		type:'post',
		datatype:'jsonp',
		success:function(response){
			if(response.length != 0){
				var option;
				$.each(response,function(key,val){
					option += '<option value="'+val.Jobagreement.id+'">'+val.Jobagreement.title+'</option>'
				});

				$("#selectTitle").append(option);
			}
		}
	});

});

  $(".user").select2({
  placeholder: " --Select User--",
  allowClear: true
});
});

</script>