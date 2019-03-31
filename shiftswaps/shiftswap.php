
<?php


    $loginUserRelationToOther = loginUserRelationToOther($user_id);
    $userOrganization = $loginUserRelationToOther->userOrganization;

    
    if(isset($_POST['submitSwapRequest']))
    {
        // echo "<pre>";print_r($_POST);die();
        $url = URL."Shiftswaps/addSwapRequest.json";
        $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

                $response =$response->body;

        if($response->output->status == 1)
        {
            echo "<script> toastr.success('Your request has been sent.');</script>";
        } else if($response->output->status == 2){
            echo "<script>toastr.info('This shift swap request is already sent.');</script>";
        }
        else
        {
            echo "<script> toastr.error('Error sending request. Please try again.');</script>";
        }
    }

    $url = URL."Shiftswaps/listSwapShifts/".$user_id.".json";
    $response = \Httpful\Request::get($url)->send();
    $swapList = $response->body;
?>

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>


<!-- BEGIN PAGE HEADER-->

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Shift Swap <small>Swap With Other User</small></h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?=URL_VIEW;?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Shift Swap</a>
            </li>
        </ul>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-cogs font-green-sharp"></i>
                                <span class="caption-subject font-green-sharp bold uppercase">Swap List</span>
                                <!-- <span class="caption-helper">alert samples...</span> -->
                            </div>
                        <div class="actions">
                            <a class="btn btn-success" data-toggle="modal" href="#requestSwap">
                            <i class="fa fa-plus"></i> Request New</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                        <tr>
                            <th>
                                S.N
                            </th>
                            <th>
                                 Shift
                            </th>
                            <th>
                                 Department
                            </th>

                            <th>
                                 Organisation
                            </th>

                            <th>
                                 From Date
                            </th>

                            <th>
                                 To Date
                            </th>

                            <th>
                                 Sent To
                            </th>

                            <th>
                                 Status
                            </th>


                        </tr>
                        </thead>
                        <tbody>
                            <?php if($swapList->output->status == '1'):?>
                                <?php $n=1; foreach ($swapList->listSwapShifts as $listSwapShifts):?>
                                <tr class="odd gradeX text-capitalize">
                                    <td>
                                        <?php echo $n++;?>
                                    </td>
                                    <td>
                                         <?php echo $listSwapShifts->Shift->title;?>
                                    </td>
                                    <td>
                                        <?php echo $listSwapShifts->Board->title;?>
                                    </td>

                                    <td>
                                        <?php echo $listSwapShifts->Organization->title;?>
                                    </td>

                                    <td>
                                        <?php echo $listSwapShifts->Shiftswap->shift_date;?>
                                    </td>

                                    <td>
                                        <?php echo $listSwapShifts->Shiftswap->to_date;?>
                                    </td>

                                    <td>
                                        <?php echo $listSwapShifts->To_User->fname." ".$listSwapShifts->To_User->lname;?>
                                    </td>

                                    <td>
                                        <?php if($listSwapShifts->Shiftswap->status == 0 || $listSwapShifts->Shiftswap->status == 1):?>
                                            <span class="label label-sm label-warning">Pending </span>
                                        <?php elseif($listSwapShifts->Shiftswap->status == 2):?>
                                            <span class="label label-sm label-success">Approved </span>
                                        <?php else:?>
                                            <span class="label label-sm label-danger">Denied</span>
                                        <?php endif;?>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            <?php else:?>
                                <tr class="odd gradeX">
                                    <td>
                                        No Data
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

                                    <td>
                                        No Data
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
                            <?php endif;?>

                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
</div>


<!-- Request modal -->
<div class="modal fade" id="requestSwap" tabindex="-1" role="basic">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Shift Swap</h4>
            </div>
            <form class="form-horizontal" id="shiftSwapForm" role="form" action="" method="POST">

                <input type="hidden" name="data[Shiftswap][user_id]" value="<?php echo $user_id;?>">
                <input type="hidden" id="shiftUserId" name="data[Shiftswap][shiftuser_id]" value="">
                <input type="hidden" id="boardId" name="data[Shiftswap][board_id]" value="">

                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date to swap</label>
                            <div class="col-md-6">
                                <div class="input-group date date-picker swapDatePicker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                    <input type="text" class="form-control shiftDate" name="data[Shiftswap][shift_date]" required>
                                    <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <!-- /input-group -->
                                <span class="help-block">
                                Select date </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Organization</label>
                            <div class="col-md-6">
                                <select class="form-control selectOrg" name="data[Shiftswap][organization_id]">
                                    <?php foreach ($userOrganization as $key => $value):?>
                                        <option value="<?php echo $key;?>">
                                            <?php foreach ($value as $orgName => $data)
                                            {
                                                echo $orgName;
                                            }?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Your shifts on this organization</h3>
                                    </div>
                                    <div class="panel-body">
                                         <div class="form-group form-md-radios">
                                            <label class="control-label"></label>
                                                <div class="col-md-10">
                                                    <div class="loadingAjaxSpinner" style="display:none;"><img src="<?php echo URL_VIEW;?>admin/layout/img/ajax-loading.gif" width="30px" height="30px"></div>
                                                    <div class="md-radio-list shiftListCheckBox">
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">To Date</label>
                            <div class="col-md-6">
                                <div class="input-group date date-picker ToSwapDatePicker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                    <input type="text" class="form-control toShiftDate" name="data[Shiftswap][to_date]" required>
                                    <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <!-- /input-group -->
                                <span class="help-block">
                                Select date </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Shift Alternatives</h3>
                                    </div>
                                    <div class="panel-body">
                                         <div class="form-group form-md-radios">
                                            <label class="control-label"></label>
                                                <div class="col-md-10">
                                                    <div class="loadingAjaxSpinner1" style="display:none;"><img src="<?php echo URL_VIEW;?>admin/layout/img/ajax-loading.gif" width="30px" height="30px"></div>
                                                    <div class="md-radio-list swapShiftListCheckBox">
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn blue" name="submitSwapRequest">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<!-- end of request modal -->




<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_VIEW;?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/table-managed.js"></script>

<script type="text/javascript">
        
        $(function()
            {
                $("#shiftSwapForm").submit(function(){

                    $(this).submit(function(){
                        return false;
                    });
                    return true;
                
                });
                
                $(".date-picker").datepicker({autoclose:true});

                $(".swapDatePicker").on('changeDate', function(event)
                    {
                        var orgId = $(".selectOrg").val();
                        var shiftDate = $(".shiftDate").val();
                        var userId = '<?php echo $user_id;?>';

                        getShifts(userId, orgId, shiftDate);
                    });

                // to Date change

                $(".ToSwapDatePicker").on('changeDate', function(event)
                    {
                        var orgId = $(".selectOrg").val();
                        var toShiftDate = $(".toShiftDate").val();
                        var userId = '<?php echo $user_id;?>';
                        var boardId = $("#boardId").val();

                        if($(".shiftListCheckBox input").is(':checked'))
                        {
                           getSwapShifts(userId, orgId, boardId, toShiftDate); 
                        }
                        else
                        {
                            toastr.warning('Please check shifts from the list.');
                        }

                    });
                // end to date change



                $('.selectOrg').on('change', function(event)
                    {
                        var e=$(this);
                        var orgId = e.val();
                        var shiftDate = $(".shiftDate").val();
                        var userId = '<?php echo $user_id;?>';

                        getShifts(userId, orgId, shiftDate);
                    });



                $(".shiftRadCheck").on('click', shiftRadCheck);

                
                function shiftRadCheck()
                    {

                        var e = $(this);

                        var userId = '<?php echo $user_id;?>';
                        var orgId = $('.selectOrg').val();
                        var boardId = e.attr('data-boardId');
                        var toShiftDate = $('.toShiftDate').val();

                        $("#shiftUserId").val(e.attr('data-shiftUserId'));
                        $("#boardId").val(boardId);

                        if(toShiftDate !="")
                        {
                           getSwapShifts(userId, orgId, boardId, toShiftDate);
                        }

                        
                    }


                function getShifts(userId, orgId, shiftDate)
                {
                    var spinner = $(".loadingAjaxSpinner");
                    var data="";

                    var shiftListCheckBox = $(".shiftListCheckBox");
                    shiftListCheckBox.html("");
                    spinner.show();

                    $.ajax(
                            {
                                url:'<?php echo URL."ShiftUsers/getShiftsOnParticularDate/"."'+userId+'"."/"."'+orgId+'"."/"."'+shiftDate+'".".json";?>',
                                type:'post',
                                datatype:'jsonp',
                                success:function(response)
                                {
                                    // console.log(response);

                                    if(response.output.status == '1')
                                    {
                                        var Shifts =response.shiftList;

                                        $.each(Shifts, function(key,value)
                                            {
                                                data+= '<div class="md-radio">'+
                                                    '<input data-shiftUserId="'+value.ShiftUser.id+'" data-boardId="'+value.Board.id+'" type="radio" id="radio'+value.ShiftUser.id+'" name="data[Shiftswap][shift_id]" class="md-radiobtn shiftRadCheck" value="'+value.Shift.id+'">'+
                                                    '<label for="radio'+value.ShiftUser.id+'">'+
                                                    '<span></span>'+
                                                    '<span class="check"></span>'+
                                                    '<span class="box"></span>'+
                                                    value.Shift.title+', '+value.Board.title+
                                                    '</label>'+
                                                '</div>';
                                            });

                                        spinner.hide();

                                        shiftListCheckBox.html("");
                                        shiftListCheckBox.append(data);

                                        $(".shiftRadCheck").unbind('click', shiftRadCheck);
                                        $(".shiftRadCheck").bind('click', shiftRadCheck);

                                    }
                                    else
                                    {
                                        spinner.hide();
                                        data='<span>no shift on this date.</span>';
                                        shiftListCheckBox.html("");
                                        shiftListCheckBox.append(data); 
                                    }
                                    
                                }
                        });
                }

                function getSwapShifts(userId, orgId, boardId, toShiftDate)
                {
                    var spinner1 = $(".loadingAjaxSpinner1");
                    var data="";

                    var swapShiftListCheckBox = $(".swapShiftListCheckBox");
                    swapShiftListCheckBox.html("");
                    spinner1.show();

                    $.ajax(
                            {
                                url:'<?php echo URL."ShiftUsers/getBoardRelatedShiftsOnDate/"."'+userId+'"."/"."'+orgId+'"."/"."'+boardId+'"."/"."'+toShiftDate+'".".json";?>',
                                type:'post',
                                datatype:'jsonp',
                                success:function(response)
                                {
                                    console.log(response);

                                    if(response.output.status == '1')
                                    {
                                        var swapShifts =response.swapShiftList;

                                        $.each(swapShifts, function(key,value)
                                            {
                                                // console.log(value.ShiftUser.id);
                                                data+= '<div class="md-radio">'+
                                                '<input type="hidden" name="data[Shiftswap][withshiftuserid]" value="'+value.ShiftUser.id+'">'+
                                                    '<input data-shiftUserId="'+value.ShiftUser.id+'" data-boardId="'+value.Board.id+'" type="radio" id="radio'+value.ShiftUser.id+'" name="data[Shiftswap][requested_to]" class="md-radiobtn" value="'+value.User.id+'">'+
                                                    '<label for="radio'+value.ShiftUser.id+'" class="text-capitalize">'+
                                                    '<span></span>'+
                                                    '<span class="check"></span>'+
                                                    '<span class="box"></span>'+
                                                    value.Shift.title+', '+value.Board.title+'<br/>'+value.User.fname+
                                                    ' '+value.User.lname+
                                                    '</label>'+
                                                '</div>';
                                            });

                                        spinner1.hide();

                                        swapShiftListCheckBox.html("");
                                        swapShiftListCheckBox.append(data);

                                        $(".swapShiftRadCheck").unbind('click', shiftRadCheck);
                                        $(".swapSshiftRadCheck").bind('click', shiftRadCheck);

                                    }
                                    else
                                    {
                                        spinner1.hide();
                                        data='<span>no shift on this date.</span>';
                                        swapShiftListCheckBox.html("");
                                        swapShiftListCheckBox.append(data); 
                                    }
                                    
                                }
                        });
                }
            });

</script>
<script>
jQuery(document).ready(function() {
   TableManaged.init();
});
</script>