<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<?php
$url = URL . "BoardUsers/myBoardDetail/" . $userId . ".json";
$data = \Httpful\Request::get($url)->send();
$departments = $data->body;
?>
<style>
.label-danger,.yellow a {
    color: #ffffff;
}

</style>


<!-- Edit-->    
    <div class="page-head">
        <div class="container">
            <div class="page-title">
				<h1>Departments <small> Lists</small></h1>
			</div>
        </div>
    </div>

    <div class="page-content">
        <div class="container">

            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="javascript:;">Departments</a>
                </li>
            </ul>
            <!-- END PAGE BREADCRUMB -->
            <!-- BEGIN PAGE CONTENT INNER -->
            <div class="row">

                    <!-- BEGIN INLINE NOTIFICATIONS PORTLET-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="fa fa-list theme-font"></i>
                                <span class="caption-subject theme-font bold uppercase">Department List</span>
                                <!-- <span class="caption-helper hide">weekly stats...</span> -->
                            </div>
                        </div>
                        <div class="portlet-body">
                        <div id="tab_2_2" class="tab-pane fade active in">
                            <div class="row">
                                <div class="col-md-2 col-sm-2 col-xs-2 margin-top-20">
                                    <ul class="nav nav-tabs tabs-left">
                                        <?php if(isset($departments) && !empty($departments)){ ?>
                                        <?php $c=1; foreach($departments as $key=>$d){ ?>
                                        <li class="<?php if($c == 1){ echo 'active'; } ?>">
                                            <a aria-expanded="true" href="#tab_<?php echo $c; ?>" data-toggle="tab">
                                            <?php echo $key; ?> </a>
                                        </li>
                                        <?php $c++; } } ?>
                                    </ul>
                                </div>
                            <div class="col-md-10 col-sm-10">
                                <div class="tab-content">
                                    <?php if(isset($departments) && !empty($departments)){ ?>
                                    <?php $count=1; foreach($departments as $d){ ?>
                                            
                                    <div id="tab_<?php echo $count; ?>" class="tab-pane fade <?php if($count == 1){ echo 'active in'; } ?>">
                                        <div class="table-scrollable table-scrollable-borderless">
                                            <table class="table table-light table-hover">
                                            <thead class="uppercase">
                                                <tr>
                                                    <th>
                                                        Sn
                                                    </th>
                                                    <th>
                                                        Department Name
                                                    </th>
                                                    <th>
                                                        Branch
                                                    </th>

                                                    <th>
                                                        Manager
                                                    </th>

                                                    <th>
                                                        No. Of Employee
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="departmentTable">
                                                    <?php if(!empty($d)) { ?>
                                                    <?php $cn = 1; foreach($d as $d1) { ?>
                                                    <tr>
                                                        <td><?php echo $cn; ?></td>
                                                        <td><a href="<?php echo URL_VIEW.'organizationUsers/employee/myOrgBranchBoardDetail?board_id='.$d1->id.'&org_id='.$d1->Organization->id.'&branch_id='.$d1->Branch->id;?>"><?php echo $d1->title; ?></a></td>
                                                        <td><?php echo $d1->Branch->title; ?></td>
                                                        <td><?php if(isset($d1->User) && !empty($d1->User)){ echo $d1->User->fname.' '.$d1->User->lname; } else{ echo '  ----'; } ?></td>
                                                        <td><?php echo $d1->noOfEmployee; ?></td>
                                                    </tr>

                                                    <?php $cn++; }  }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                     <?php $count++; }  } else { ?>  <p>No records to show.</p> <?php }?>
                                    
                                </div>
                            </div>
                            </div>
                        
                        </div>

                        </div>
                    </div>
                    <!-- END INLINE NOTIFICATIONS PORTLET-->
             


                    </div>
                </div>        

            </div>
            <!-- END PAGE CONTENT INNER -->
        </div>
        <!-- BEGIN PAGE CONTENT -->

        </div>
    
 
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>

<script type="text/javascript" src="<?php echo URL_VIEW; ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/ui-alert-dialog-api.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo URL_VIEW; ?>admin/pages/scripts/table-advanced.js"></script>
<script>

</script>

