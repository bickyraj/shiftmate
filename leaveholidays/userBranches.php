<?php 

    //$orgId = $_GET['orgId'];

   
    $url = URL."Leaveholidays/userBranches/".$userId."/".$orgId.".json";
    $data = \Httpful\Request::get($url)->send();
    $branches = $data->body->output;
    // echo "<pre>";
    // print_r($branches);
    // die();
    
?>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>



<!-- BEGIN PAGE HEADER-->
<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Holiday</h1>
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
                        <a href="#">Holiday</a>
                    </li>
                </ul>
<!-- END PAGE HEADER-->
            
<!-- BEGIN PAGE CONTENT-->
<!-- <div class="note note-success">
    <p>
        The draggable portlets powered with jQueryUI Sortable Plugin. You can use the jQueryUI Sortable API to store the portlet positions in your backend.The draggable portlets powered with jQueryUI Sortable Plugin. You can use the jQueryUI Sortable API to store the portlet positions in your backend.
    </p>
</div> -->

<div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i>Holidays
                            </div>
                            <!-- <div class="actions">
                                <div class="btn-group">
                                    <a class="btn btn-default btn-sm" href="javascript:;" data-toggle="dropdown">
                                    <i class="fa fa-cogs"></i> Tools <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="javascript:;">
                                            <i class="fa fa-pencil"></i> Edit </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                            <i class="fa fa-trash-o"></i> Delete </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                            <i class="fa fa-ban"></i> Ban </a>
                                        </li>
                                        <li class="divider">
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                            <i class="i"></i> Make admin </a>
                                        </li>
                                    </ul>
                                </div>
                            </div> -->
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="sample_2">
                            <thead>
                            <tr>
                                <!-- <th class="table-checkbox">
                                    <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
                                </th> -->
                                <th>
                                     Branch
                                </th>
                                <!-- <th>
                                     Total Leaves
                                </th> -->
                                <th>
                                     Action
                                </th>
                                <!-- <th>
                                     Leaves Notification
                                </th> -->
                            </tr>
                            </thead>
                            <tbody>

                                <?php if(isset($branches) && !empty($branches))
                                {?>

                                <?php foreach ($branches as $branch):
                                
                                ?>
                        <tr class="odd gradeX">
                                <!-- <td>
                                    <input type="checkbox" class="checkboxes" value="1"/>
                                </td> -->

                                <td>
                                   <?php echo $branch->Branch->title;?>
                                </td>

                               <!--  <td>
                                    20
                                </td> -->

                                <td>
                                   <!--  <a href="" class="btn btn-xs blue">
                                                            Request Holiday</i>
                                                            </a> -->
                                    <a href="<?php echo URL_VIEW."leaveholidays/requestHoliday?org_id=".$orgId."&branch_id=".$branch->Branch->id;?>" class="btn btn-xs green">
                                                            View <i class="fa fa-circle-o-notch"></i>
                                                            </a>
                                </td>

                               <!--  <td>
                                    <span class="label label-sm label-danger">No new notification</span>
                                </td> -->
                            </tr>
                        <?php endforeach;?>

                        <?php }else{?>

                        <tr class="odd gradeX">
                                <td>
                                    <input type="checkbox" class="checkboxes" value="1"/>
                                </td>

                                <td>
                                    no data.
                                </td>

                                <td>
                                    no data.
                                </td>

                                <td>
                                    no data.
                                </td>

                                <td>
                                    no data.
                                </td>
                            </tr>

                        <?php }?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>







            </div>







<!-- END PAGE CONTENT-->

<!-- BEGIN PAGE LEVEL PLUGINS -->
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

<!-- END JAVASCRIPTS -->

<script type="text/javascript">

    $(function()
        {
            $("#request_holiday").click(function()
                    {

                        var urli = '<?php echo URL."Leaveholiday/requestHoliday/".$user_id.".json";?>';

                        bootbox.dialog({
                            title: "Request Holiday",
                            message:
                                '<form id="request_holiday_form" class="form-body"> ' +

                                '<div class="form-group">'+
                                        '<label>Subject</label>'+
                                            '<input type="text" name="data[Leaveholiday][title]" class="form-control" required>'+
                                    '</div>'+

                                    '<div id="holidayType" class="form-group form-md-radios">'+
                                        '<div class="md-radio-inline">'+
                                            '<div class="md-radio">'+
                                                '<input type="radio" id="radio6" holiday-type="single" name="radio2" class="md-radiobtn">'+
                                                '<label for="radio6">'+
                                                '<span></span>'+
                                                '<span class="check"></span>'+
                                                '<span class="box"></span>'+
                                                'Single</label>'+
                                            '</div>'+

                                            '<div class="md-radio">'+
                                                '<input type="radio" id="radio7" holiday-type="multiple" name="radio2" class="md-radiobtn">'+
                                                '<label for="radio7">'+
                                                '<span></span>'+
                                                '<span class="check"></span>'+
                                                '<span class="box"></span>'+
                                                'Multiple </label>'+
                                            '</div>'+

                                    '</div>'+
                                '</div>'+

                                '<div id="single_holiday_date_div" class="form-group" style="display:none;">'+
                            '<input class="form-control input-medium date-picker date-picker-modal" data-date-format="yyyy-mm-dd" size="16" type="text" value="" name="data[Leaveholiday][start_date]">'+
                                '</div>'+

                                '<div id="multiple_holiday_date_div" class="form-group" style="display:none;">'+
                                            '<div class="input-group input-large date-picker input-daterange date-picker-modal" data-date="10/11/2012" data-date-format="mm/dd/yyyy">'+
                                                '<input type="text" class="form-control" name="data[Leaveholiday][start_date]">'+
                                                '<span class="input-group-addon">'+
                                                 'to </span>'+
                                                '<input type="text" class="form-control" name="data[Leaveholiday][end_date]">'+
                                            '</div>'+
                                            '<span class="help-block">'+
                                             'Select date range </span>'+
                                    '</div>'+


                                '<div class="form-group">'+
                                        '<label>Reason for leave</label>'+
                                        '<textarea style="min-height:200px;" class="form-control" name="data[Leaveholiday][note]" rows="3" required></textarea>'+
                                    '</div>'+
                                    

                                '</div> ' +
                                '</form>',

                            buttons: {
                                success: {
                                    label: "Save",
                                    className: "btn-success",
                                    callback: function () {

                                        var data = $("#request_holiday_form").serialize();

                                        // console.log(data);

                                        $.ajax({
                                                      url:urli,
                                                      type:'post',
                                                      data:data,
                                                      success:function(response)
                                                           {

                                                                var status = response.output.status;
                                                                
                                                                if(status == 1)
                                                                {
                                                                    location.reload();
                                                                }

                                                                else
                                                                {
                                                                    alert("Empty Data.");
                                                                }
                                                           }
                                                });
                                    }
                                }
                            }
                        });

                            $("#holidayType input").on('click', function()
                                {
                                    var holiday_type = $(this).attr('holiday-type');
                                    switch(holiday_type)
                                    {
                                        case 'single':
                                            $("#multiple_holiday_date_div").hide();
                                            $("#single_holiday_date_div").show();
                                            break;

                                        case 'multiple':
                                        $("#single_holiday_date_div").hide();

                                        $("#multiple_holiday_date_div").show();
                                            break;
                                    }
                                });

                            $(".date-picker-modal").datepicker();
                    });
        });

</script>


