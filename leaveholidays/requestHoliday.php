<?php 

// $orgId = $_GET['org_id'];
$branchId = $_GET['branch_id'];


$url = URL . "Leaveholidays/listHolidays/" . $user_id .'/'.$orgId.'/'.$branchId.".json";
$data = \Httpful\Request::get($url)->send();
$holidays = $data->body->holidays;

if(isset($_POST['submit']))
{

    $url = URL."Leaveholidays/requestHoliday/".$user_id.".json";
    $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

                $url = URL . "Leaveholidays/listHolidays/" . $user_id .'/'.$orgId.'/'.$branchId.".json";
                $data = \Httpful\Request::get($url)->send();
                $holidays = $data->body->holidays;

                if($response->body->output->status == 0)
                {
                    echo '<script>
                            toastr.error("'.$response->body->output->error.'");
                    </script>';
                }

                else
                {
                    echo '<script>
                            toastr.success("Request has been sent.");
                    </script>';
                }
}

//$totalPage = $data->body->output->pageCount;
//$currentPage = $data->body->output->currentPage;
// echo "<pre>";
// print_r($holidays);
?>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>





<!-- BEGIN PAGE HEADER-->
<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Holiday <small>Request</small></h1>
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
                    <li>
                        <a href="#">Request</a>
                    </li>
                </ul>

<div class="row">

                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i>Holidays
                            </div>
                            <div class="actions">
                                <a href="javascript:;" id="request_holiday" class="btn btn-default btn-sm">
                                <i class="fa fa-pencil"></i> Request Holiday </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="sample_2">
                            <thead>
                            <tr>
                               <!--  <th class="table-checkbox">
                                    <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
                                </th> -->
                                <th>
                                     S.N
                                </th>
                                <th>
                                     Note
                                </th>
                                <th>
                                     Requested Date 
                                </th>
                                <th>
                                     Status
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                                <?php if(isset($holidays) && !empty($holidays))
                                {?>

                                <?php 
                                
                                usort($holidays, function($a1, $a2) {
                                                                                   $v1 = strtotime($a1->Leaveholiday->requested_date);
                                                                                   $v2 = strtotime($a2->Leaveholiday->requested_date);
                                                                                   return $v2 - $v1; // $v2 - $v1 to reverse direction
                                                                                });
                                    $sn=1;
                                foreach ($holidays as $holiday):?>

                                
                        <tr class="odd gradeX">
                               <!--  <td>
                                    <input type="checkbox" class="checkboxes" value="1"/>
                                </td> -->

                                <td>
                                   <?php echo $sn; ?>
                                </td>

                                <td>
                                    <?php echo $holiday->Leaveholiday->note;?>
                                </td>

                                <td>
                                   <?php echo $holiday->Leaveholiday->requested_date;?>
                                </td>

                                <td>
                                    <?php if($holiday->Leaveholiday->status == 0 ) { ?>
                                    <span class="label label-sm label-warning ">
                                                        Pending <i class="fa fa-share"></i>
                                                        </span>
                                    <?php 
                                        }
                                        else{ 
                                    ?>
                                    <span class="label label-sm label-success">
                                                        Approved <i class="fa fa-check"></i> </span>
                                                        <?php } ?>
                                </td>
                            </tr>
                        <?php 
                        $sn++;
                        endforeach;
                        ?>

                        <?php }else{?>

                        <tr class="odd gradeX">
                                <td>
                                   -
                                </td>

                                <td>
                                   No Data
                                </td>

                                <td>
                                   No Data
                                </td>

                                <td>
                                    No Data
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
            toastr.options = {
                                      "closeButton": true,
                                      "debug": false,
                                      "positionClass": "toast-top-center",
                                      "onclick": null,
                                      "showDuration": "1000",
                                      "hideDuration": "1000",
                                      "timeOut": "10000",
                                      "extendedTimeOut": "1000",
                                      "showEasing": "swing",
                                      "hideEasing": "linear",
                                      "showMethod": "fadeIn",
                                      "hideMethod": "fadeOut"
                                    };

            $("#request_holiday").click(function()
                    {

                        

                        bootbox.dialog({
                            title: "Request Holiday",
                            message:'<form method="post" action="" class="form-body"> ' +


                                '<input type="hidden" name="data[Leaveholiday][user_id]" value="<?php echo $user_id;?>"/>'+
                                '<input type="hidden" name="data[Leaveholiday][organization_id]" value="<?php echo $orgId;?>"/>'+
                                '<input type="hidden" name="data[Leaveholiday][branch_id]" value="<?php echo $branchId;?>"/>'+
                                '<input type="hidden" name="data[Leaveholiday][requested_date]" value="<?php echo date("Y-m-d");?>"/>'+

                                    '<div id="holidayType" class="form-group form-md-radios">'+
                                        '<div class="md-radio-inline">'+
                                            '<div class="md-radio">'+
                                                '<input type="radio" id="radio6" name="data[Leaveholiday][radio]" holiday-type="single" class="md-radiobtn">'+
                                                '<label for="radio6">'+
                                                '<span></span>'+
                                                '<span class="check"></span>'+
                                                '<span class="box"></span>'+
                                                'Single</label>'+
                                            '</div>'+

                                            '<div class="md-radio">'+
                                                '<input type="radio" id="radio7" name="data[Leaveholiday][radio]" holiday-type="multiple" class="md-radiobtn">'+
                                                '<label for="radio7">'+
                                                '<span></span>'+
                                                '<span class="check"></span>'+
                                                '<span class="box"></span>'+
                                                'Multiple </label>'+
                                            '</div>'+

                                    '</div>'+
                                '</div>'+

                                '<div id="single_holiday_date_div" class="form-group" style="display:none;">'+
                            '<input class="form-control input-medium date-picker date-picker-modal" data-date-format="yyyy-mm-dd" size="16" type="text" value="">'+
                                '</div>'+

                                '<div id="multiple_holiday_date_div" class="form-group" style="display:none;">'+
                                            '<div class="input-group input-large date-picker input-daterange date-picker-modal" data-date="10/11/2012" data-date-format="yyyy-mm-dd">'+
                                                '<input id="multiDate" type="text" class="form-control">'+
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

                                    '<input type="submit" name="submit" value="Save" class="btn btn-success" />'+
                                    

                                '</div> ' +
                                '</form>'
                        });


                            $("#holidayType input").on('click', function()
                                {
                                    var holiday_type = $(this).attr('holiday-type');
                                    switch(holiday_type)
                                    {
                                        case 'single':
                                        $("#multiple_holiday_date_div #multiDate").removeAttr('name');
                                        $("#multiple_holiday_date_div #multiDate").prop('required', false);
                                            $("#multiple_holiday_date_div").hide();
                                            $("#single_holiday_date_div").show();
                                            $("#single_holiday_date_div input").attr('name', 'data[Leaveholiday][start_date]');
                                            $("#single_holiday_date_div input").prop('required', true);
                                            break;

                                        case 'multiple':
                                        $("#single_holiday_date_div input").removeAttr('name');
                                        $("#single_holiday_date_div input").prop('required', false);
                                        $("#single_holiday_date_div").hide();

                                        $("#multiple_holiday_date_div").show();
                                        $("#multiple_holiday_date_div #multiDate").attr('name', 'data[Leaveholiday][start_date]');
                                        $("#multiple_holiday_date_div #multiDate").prop('required', true);
                                            break;
                                    }
                                });

                            $(".date-picker-modal").datepicker();
                    });

                
                
        });



</script>
