<style>
.dl-horizontal dt{
    width: 100px !important;
}
.dl-horizontal dd {
    margin-left: 120px !important;
}
</style>
<?php
$jobagreement_id = $_GET['id'];
//to list job agreements
$url = URL."Sentagreements/myJobagreementBYId/".$userId."/".$jobagreement_id.".json";
$data = \Httpful\Request::get($url)->send();
$agreement = $data->body->myjobagreement;
// echo "<pre>";
// print_r($agreements);
// die();

?>

<div class="page-head">
   <div class="container">
        <div class="page-title">
			<h1>Jobagreements <small> View</small></h1>
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
                    <a href="<?php echo URL_VIEW.'jobagreements/agreementlist'?>">Jobagreement</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">View Jobagreement</a>
                </li>
            </ul>

<div class="portlet light">
		<div class="portlet-title">
			<div class="caption">
				Jobagreement
			</div>
		</div>
		<div class="portlet-body">
		<div>
        <?php
            if(!empty($agreement->Jobagreement->file) && $agreement->Jobagreement->file_dir != '0'){
                $href = URL.'webroot/files/jobagreement/file/'.$agreement->Jobagreement->file_dir.'/'.$agreement->Jobagreement->file;
                $attachment = '<a target="_blank" href="'.$href.'"><i class="fa fa-download"></i></a>';
            } else {
                $attachment = 'No attachment';
            }
        ?>
            <dl class="dl-horizontal">
                <dt>Title:</dt>
                <dd><?php echo $agreement->Jobagreement->title; ?></dd>
                <!-- <dt>Type:</dt>
                <dd><?php echo $agreement->Jobagreementtype->type; ?></dd> -->
                <dt>Content:</dt>
                <dd><?php echo $agreement->Jobagreement->content; ?></dd>
                
                <dt>Sent Date</dt>
                <dd><?php echo $agreement->Sentagreement->date; ?></dd>
                
                <dt>Attachment:</dt>
                <dd><?php echo $attachment; ?></dd>


            </dl>
		</div>
	</div>
    </div>
    </div>
    </div>


