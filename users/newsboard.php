<?php

	$url = URL."OrganizationUsers/Newslist/".$user_id.".json";
	$org = \Httpful\Request::get($url)->send();
	$org_details = $org->body->output;
	 //echo "<pre>";
	  //print_r($org_details);

 //    die();

?>
<style>
.portlet-body {
    min-height: 120px;
}
.portlet-title:hover {
    cursor: default !important;
}
</style>

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>News Board <small> view news board</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?=URL_VIEW;?>">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="#">News Board</a>
            </li>
        </ul>
<!-- END PAGE HEADER-->
            
<!-- BEGIN PAGE CONTENT-->
<div class="row" id="sortable_portlets">

    <?php foreach ($org_details as $org_detail):?>

    	<?php foreach($org_detail->Organization->Newsboard as $news): ?>
    <div class="col-md-4 column sortable">

        

        <div class="portlet portlet-sortable light bg-inverse">
                                <div class="portlet-title ui-sortable-handle">
                                    <div class="caption">
                                        <i class="icon-puzzle font-red-flamingo"></i>
                                        <span class="caption-subject bold font-red-flamingo uppercase">
                                        <?php echo $org_detail->Organization->title; ?></span>
                                    </div>
                                     
        								
                                    <div class="tools">
                                        <a href="" class="collapse" data-original-title="" title="">
                                        </a>
                                        <a href="" class="fullscreen" data-original-title="" title="">
                                        </a>
                                        <a href="" class="remove" data-original-title="" title="">
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <h4 class="notice_title"><?php echo $news->title;?></h4>
                                    <h6><?php //echo $news->notice_date;?></h6>
                                    <p class="notice_description">
                                        <?php echo $news->description;?>
                                    </p>
                                </div>
                            </div>
                            <!-- empty sortable porlet required for each columns! -->
    </div>
        <?php endforeach;?>
    <?php endforeach;?>
</div>
<!-- END PAGE CONTENT-->


    <!-- BEGIN PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_VIEW;?>global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/demo.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- END JAVASCRIPTS -->