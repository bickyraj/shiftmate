<?php
if(isset($_POST['submit'])){

	// print_r($_POST['data']);
	// die();
	$url = URL."Jobagreementtypes/addJobAgreementCategory.json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();
} 


$url = URL."Jobagreementtypes/listJobAgreementType.json";
$data = \Httpful\Request::get($url)->send();
$types = $data->body;
// echo "<pre>";
// print_r($types);
// die();
foreach($types as $type){
 //echo $type->Jobagreementtype->type;
// echo $a->Jobagreement->id;
 }
?>
<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Job Agreement <small> Agrements Types</small></h1>
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
                        <a href="#">Jobagreement types</a>
                    </li>
                </ul>
<div class="row">
<div class="portlet box green col-md-offset-1 col-md-6">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-gift"></i>Job Agreement Category
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse" data-original-title="" title="">
			</a>
			<a href="javascript:;" class="remove" data-original-title="" title="">
			</a>
		</div>
</div>
<div class="portlet-body form">
		<div class="table-scrollable">
			<table class="table table-condensed table-hover">
			<thead>
			<tr>
				<th>
					 #
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
			<tbody>

			<?php $count = 1; ?>
			<?php foreach($types as $type) {  ?> 
			<tr>
				<td>
					 <?php echo $count; ?>
				</td>
				<td>
					 <?php echo $type->Jobagreementtype->type; ?>
				</td>
				<td>
					 <?php echo $type->Jobagreementtype->date; ?>
				</td>
				<td>
					<a class="btn btn-info" href="<?php echo URL_VIEW."/jobagreements/Jobagreementtype?id=".$type->Jobagreementtype->id?>">Edit</a>
				</td>
			</tr>
			<?php $count++; } ?>
			</tbody>
			</table>
		</div>

	</div>
</div>

</div>



<!-- BEGIN FORM-->
<div class="row">
<h4 class="col-md-offset-1">Add New Category</h4>
<form action="" method="post" class="form-horizontal">
	<div class="form-body">
		<div class="form-group">
			<label class="col-md-1 control-label"></label>
			<div class="col-md-4">
				<input type="text" name="data[Jobagreementtype][type]" class="form-control input-circle" placeholder="Enter Category Name">
			</div>
		</div>
		
	<div class="form-actions">
		<div class="row">
			<div class="col-md-offset-1 col-md-9">
				<button type="submit" name="submit" class="btn btn-circle blue">Add Category</button>
			</div>
		</div>
	</div>
</form>
</div>
	<!-- END FORM-->

