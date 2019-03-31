<script src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
<?php
if(isset($_POST['submit'])){
    if(isset($_FILES['file'])){
            $_POST['data']['Jobagreement']['file']=array(
                'name'=>str_replace(" ","_",$_FILES["file"]["name"]),
                'type'=> $_FILES['file']['type'],
                'tmp_name'=> $_FILES['file']['tmp_name'],
                'error'=> $_FILES['file']['error'],
                'size'=> $_FILES['file']['size']
            );
        }

        // fal($_POST);
        
	$url = URL."Jobagreements/saveJobagreement/".$orgId.".json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

	if($response->body->output->status == '1')
           {
                $_SESSION['success']= "Success";
               echo("<script>location.href = '".URL_VIEW."jobagreements/jobagreements';</script>");
           }
           else if($response->body->output->status == '2'){
	            echo("<script>
	     			 toastr.info('Title for selected job agreement category already exists.');

	            </script>");
	            //echo("<script>location.href = '".URL_VIEW."jobagreements/jobagreement?org_id=".$orgId."';</script>");
           }        
}

$url = URL."Jobagreementtypes/categoryOfOrg/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$types = $data->body;

?>

<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Job Agreement <small> New Agrement</small></h1>
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
                        <a href="<?php echo URL_VIEW.'jobagreements/jobagreements'?>">Jobagreements</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">New Job Agreement</a>
                    </li>
                </ul>

<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
			<span class="caption-subject theme-font bold uppercase">Job Agreement</span>
		</div>
</div>
	<div class="portlet-body form">
	<!--BEGIN FORM-->
	<form action="" id="jobAgreementForm" method="post" class="form-horizontal" enctype="multipart/form-data">
		<div class="form-body">

			<div class="form-group">
				<label class="col-md-3 control-label">Title</label>
				<div class="col-md-6">
				<input type="text" name="data[Jobagreement][title]" class="form-control" required>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">Agreement Type</label>
				<div class="col-md-6">

				<select class="form-control " name='data[Jobagreement][jobagreementtype_id]' required>
				<option value="" disabled selected>--Select One--</option>
<?php

//die();
if(isset($types) && !empty($types))
{
foreach($types as $type){
?>
<option value="<?php echo $type->Jobagreementtype->id;?>"><?php echo $type->Jobagreementtype->type;?></option>
<?php
}
}
?>
				</select>

				</div>
				<?php if(empty($types)) { ?>
				<div class="col-md-2">
					<a type="button" target="_blank" href="<?php echo URL_VIEW; ?>jobagreements/jobagreements/#tab2" class="btn btn-sm green" value="">Add type</a>
				</div>
				<?php } ?>
			</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">Agreement Content</label>
				<div class="col-md-8">
				<textarea name="data[Jobagreement][content]" class="data-wysihtml5" id="editor" rows="10"></textarea>
				</div>
			</div>
            <div class="form-group">
				<label class="col-md-3 control-label">Related File</label>
				<div class="col-md-8">
				    <input type="file" name="file" class=" btn btn-default"/>
				</div>
			</div>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" name="submit" class="btn green">Submit</button>
						<button type="button" class="btn default">Cancel</button>
					</div>
				</div>
			</div>
	</form>
</div>
</div>
</div>
</div>


<link href="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>

<script>
    $('.data-wysihtml5').wysihtml5({
        "stylesheets": ["<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"],
        "image":false,
        "link":false,
        "html":false
        });
</script>
<script>
$(document).ready(function(){
	$('#jobAgreementForm').on('submit',function(event){
			var details = $('#editor').val();
			if(details == ''){
				toastr.info('Agreement content can not be empty..');
				return false;
			}	
		});
	});

</script>