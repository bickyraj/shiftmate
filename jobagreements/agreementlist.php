<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php
//to list job agreements
$url = URL."Sentagreements/myJobagreement/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$agreements = $data->body->myjobagreement;

// echo "<pre>";
// print_r($agreements);
//  // foreach($agreements as $agreement){
//  // 	print_r($agreement);
//  // }
// die();

?>
<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Job Agreement <small>View job agreement list</small></h1>
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
                        <a href="javascript:;">Job Agreement</a>
                    </li>
                </ul>

<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-gift"></i> Job Agreement lists</div>
			<div class="tools">
			</div>
		</div>
		<div class="portlet-body">
            		<?php
			if(empty($agreements)){ ?>
            <div style="text-align: center;">No job agreement right now</div>
			<?php } else  { ?>
		
		<div class="table-scrollable" style="margin: 20px;">
			<table id="table_1_1" class="table table-condensed table-hover" style="margin: 20px;">
			<thead>
			<tr>
				<th>
					 SN
				</th>
				<th>
					Title 
				</th>
				<th>
					Organization 
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
			<?php foreach($agreements as $agreement) {  ?> 
			<?php// print_r($agreement);?>
			<tr>
				<td>
					 <?php echo $count; ?>
				</td>
				<td>
					 <?php echo $agreement->Jobagreement->title; ?>
				</td>
				<td>
					 <?php echo $agreement->Organization->title; ?>
				</td>
				<td>
					 <?php echo $agreement->Sentagreement->date; ?>
				</td>
				<td>
					<a class="btn btn-success" href="<?php echo URL_VIEW."jobagreements/viewagreement?id=".$agreement->Sentagreement->jobagreement_id;?>">View</a>
				</td>
			</tr>
			<?php $count++; } ?>
			</tbody>
			</table>
            <script>
                $(document).ready(function(){
                   //$("#table_1_1").dataTable({}); 
                });
            </script>
		</div>
		<?php } ?>
	</div>

</div>
</div>
</div>


<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->


<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>
<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>

<script>
jQuery(document).ready(function() {
   TableManaged.init();
   ComponentsPickers.init();

});
</script>
					




