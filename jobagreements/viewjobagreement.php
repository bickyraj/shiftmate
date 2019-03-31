<?php
$jobagreement_id = $_GET['id'];
if(isset($_POST['save_as_new'])){

	// print_r($_POST['data']);
	// die();
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
$url = URL."Jobagreements/jobAgreementById/".$orgId."/".$jobagreement_id.".json";
$data = \Httpful\Request::get($url)->send();
$agreement = $data->body->agreement;
// echo "<pre>";
// print_r($agreement);
// die();



$url1 = URL."OrganizationUsers/getOrganizationUsers/".$orgId.".json";
$data1 = \Httpful\Request::get($url1)->send();
$users = $data1->body->organizationUsers;
// echo '<pre>';
// print_r($users);
?>
<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Jobagreements <small> View Job Agreement</small></h1>
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
                    <a href="<?php echo URL_VIEW.'jobagreements/jobagreements'?>">Jobagreements</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">View Job Agreements</a>
                </li>
            </ul>
<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
				Jobagreement
			</div>
			<div class="tools">
			</div>
		</div>
        <div class="portlet-body form row">
            <div class="col-md-offset-1 col-md-2" style="font-size: 1.3em;"> Title : </div>
            <div class="col-md-7">
              <span><?php echo $agreement->Jobagreement->title; ?></span>
            </div>
        </div>
		<div class="portlet-body form row">
    		<div class="col-md-offset-1 col-md-2" style="font-size: 1.3em;"> Content : </div>
            <div class="col-md-7">
    		  <span><?php echo $agreement->Jobagreement->content; ?></span>
    		</div>
    	</div>
        <div class="portlet-body form row">
    		<div class="col-md-offset-1 col-md-2" style="font-size: 1.3em;"> Type : </div>
            <div class="col-md-7">
    		  <span><?php echo $agreement->Jobagreementtype->type; ?></span>
    		</div>
    	</div>
        <div class="portlet-body form row">
    		<div class="col-md-offset-1 col-md-2" style="font-size: 1.3em;"> Date : </div>
            <div class="col-md-7">
    		  <span><?php echo convertDate($agreement->Jobagreement->date); ?></span>
    		</div>
    	</div>
        <div class="portlet-body form row">
    		<div class="col-md-offset-1 col-md-2" style="font-size: 1.3em;"> Attachment : </div>
            <div class="col-md-7">
    		  <?php 
                    $file_name = URL."webroot/files/jobagreement/file/".$agreement->Jobagreement->file_dir."/".$agreement->Jobagreement->file;
                    $file_headers = @get_headers($file_name);
                    if($file_headers[0] == 'HTTP/1.1 404 Not Found'){ ?>
                        --
                    <?php }else{?>
                        <a target="_blank" href="<?=$file_name?>"><i class="fa fa-download"></i></a>
                    <?php } ?>
    		</div><br />
    	</div>
</div>
</div>
</div>


<script>
$(document).ready(function(){
  $(".user").select2({
  placeholder: " --Select User--",
  allowClear: true
});
});

</script>
