<?php

if (isset($_POST["formSubmit"])) {

    $url = URL . "Useravailabilities/updateEmployeeAvailabilities/" . $userId . ".json";
    $response = \Httpful\Request::post($url)
    ->sendsJson()
    ->body($_POST['data'])
    ->send();

    echo "<script>
    
            var url ='".URL_VIEW."useravailabilities/myAvailability';
            window.location.href = url;
    </script>";
    
}

if(isset($loginUserRelationToOther->userOrganization) && !empty($loginUserRelationToOther->userOrganization))
{
    $myOrganizations = $loginUserRelationToOther->userOrganization;
}


$url = URL . "Useravailabilities/useravailabilityList/" . $userId . ".json";
$data = \Httpful\Request::get($url)->send();

$availabilities = $data->body->availabilities;


?>

<!-- Edit -->
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Update Availability <small> Update Availability</small></h1>
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
                <a href="<?=URL_VIEW;?>useravailabilities/myAvailability">Availability</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:;">Update Availability</a>
            </li>
        </ul>

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PORTLET-->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Update Availabilities</span>
                            <!-- <span class="caption-helper hide">weekly stats...</span> -->
                        </div>
                        <!-- <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="#portlet-config" data-toggle="modal" class="config">
                            </a>
                            <a href="javascript:;" class="reload">
                            </a>
                            <a href="javascript:;" class="remove">
                            </a>
                        </div> -->
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="" method="POST" class="form-horizontal form-bordered">
                            <div class="form-body">
                                <?php foreach ($availabilities as $key => $availability): ?>
                                <div class="form-group availabilityDiv">
                                    <label class="control-label col-md-3"><?php echo $availability->day->title;?></label>
                                    <div class="col-md-4">
                                        <input type="hidden" name="data[Useravailability][<?php echo $key; ?>][id]" value="<?php echo $availability->data->id;?>">
                                        <select class="form-control availabilitySelect" name="data[Useravailability][<?php echo $key; ?>][availabilities]" id="<?php echo $key; ?>">
                                            <option value="0" <?php echo ($availability->data->status == '0') ? "selected = 'selected'" : ''; ?>>Available</option>
                                            <option value="1" <?php echo ($availability->data->status == 1) ? "selected = 'selected'" : ''; ?>>Avaliable time</option>
                                            <option value="2" <?php echo ($availability->data->status == 2) ? "selected = 'selected'" : ''; ?>>Not Avaliable</option>
                                        </select>
                                        <!-- /input-group -->
                                        <div class="portlet">
                                            <div class="selectTimeDiv">
                                        <?php if ($availability->data->status == 1) { ?>
                                        
                                            
                                            <?php $i = 0; foreach ($availability->time as $time):?>

                                                <div class="portlet-body" style="border-bottom: 1px solid rgb(234, 234, 234);padding-bottom: 26px;margin-bottom: 25px;">

                                                    <input type="hidden" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][id]" value="<?php echo $time->id;?>">
                                                    <div class="well well-sm" style="overflow:hidden;margin-top: 11px;background-color: #F5F5F5;width: 256px;">
                                                        <div style="width:90px;float:left;">
                                                            <input type="text" class="form-control timepicker timepicker-no-seconds startTimePicker" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][starttime]" value="<?php echo hisToTime($time->starttime);?>">
                                                        </div>
                                                        <span class="badge badge-primary" style="float: left;margin: 7px;">to</span>
                                                        <div style="width:90px;float:left;">
                                                        
                                                            <input type="text" class="form-control timepicker timepicker-no-seconds endTimePicker" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][endtime]" value="<?php echo hisToTime($time->endtime);?>">
                                                        </div>
                                                        <a href="javascript:;" class="btn btn-xs closeBtn">
                                                        <i class="fa fa-times"></i>
                                                        </a>
                                                    </div>

                                                    <div class="checkbox-list">
                                                            <label>
                                                            <input type="checkbox" class="permanentCheck" <?php echo (isset($time->organizationId) && $time->organizationId !='0')?'checked':'' ;?>>Permanent</label>
                                                    </div>

                                                    <select class="form-control input-sm selectOrg" name="data[Useravailability][<?php echo $key; ?>][time][<?php echo $i; ?>][organization_id]" style="width:256px;" <?php echo (isset($time->organizationId) && $time->organizationId !='0')?'':'disabled' ;?>>
                                                        <?php if(isset($myOrganizations) && !empty($myOrganizations)):?>
                                                        <option value="0">Select Organization</option>
                                                        <?php foreach($myOrganizations as $orgId=>$value):?>
                                                            <option value="<?php echo $orgId;?>" <?php echo($orgId == $time->organizationId)?'selected':'';?>>
                                                                <?php foreach ($value as $orgTitle => $branch):?>
                                                                    <?php echo $orgTitle;?>
                                                                <?php endforeach;?>
                                                            </option>
                                                        <?php endforeach;?>
                                                    <?php else:?>
                                                            <option>No Organization</option>
                                                <?php endif;?>
                                                    </select>

                                                </div>
                                                
                                            <?php $i++; endforeach;?>
                                            
                                            
                                        
                                        <?php }?>
                                            </div>
                                            <a href="javascript:;" class="btn btn-sm green addTimeBtn" style="display:none;">Add <i class="fa fa-plus"></i></a>
                                        </div>
                                        
                                    </div>
                                </div>
                                <?php endforeach;?>

                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" name="formSubmit" class="btn purple"><i class="fa fa-check"></i> Update</button>
                                        <a href="<?php echo URL_VIEW;?>useravailabilities/myAvailability" type="button" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
                <!-- END PORTLET-->
            </div>
        </div>
    </div>
</div>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-pickers.js"></script>
<script>
        jQuery(document).ready(function() {
           ComponentsPickers.init();
        });   
</script>

<script type="text/javascript">

    $(function()
        {
            var addBtn = $(".addTimeBtn");
            // addBtn.hide();

            $( ".availabilitySelect" ).each(function(index){

                                var e = $(this);

                                var option = e.val();

                                if(option == 1)
                                {
                                    e.closest('.availabilityDiv').find(addBtn).show();
                                }
                        });

            $(".addTimeBtn").on('click', function(event)
                {
                    var e = $(this);
                    var key = e.closest('.availabilityDiv').find('.availabilitySelect').attr('id');
                    var index = e.closest('.portlet').find('.selectTimeDiv').find('.portlet-body').length-1;
                    var data = addTimeSelectDiv(e, key, index);

                    e.closest('.portlet').find('.selectTimeDiv').append(data);

                    // for naming the name attribute of input uniquely
                    var portletBody = e.closest('.portlet').find('.selectTimeDiv').find('.portlet-body');
                    $.each(portletBody, function(i, value)
                        {
                            // console.log(i);
                            var st = $(value).find('.startTimePicker');
                            var et = $(value).find('.endTimePicker');
                            var oid = $(value).find('.selectOrg');

                            st.attr('name', 'data[Useravailability]['+key+'][time]['+i+'][starttime]');
                            et.attr('name', 'data[Useravailability]['+key+'][time]['+i+'][endtime]');
                            oid.attr('name', 'data[Useravailability]['+key+'][time]['+i+'][organization_id]');
                        });
                    // end of naming

                    $('body').find('.timepicker').timepicker({defaultTime: '00:00 AM'});
                    $("body .closeBtn").bind('click', closeTimeDiv);

                    $("body .permanentCheck").unbind('click',permanentCheck);
                    $("body .permanentCheck").bind('click',permanentCheck);
                    
                });

            function addTimeSelectDiv(e, key, index)
            {
                var data = '<div class="portlet-body" style="border-bottom: 1px solid rgb(234, 234, 234);padding-bottom: 26px;margin-bottom: 25px;"><div class="well well-sm" style="width:256px;overflow:hidden;margin-top: 11px;background-color: #F5F5F5;"><div style="width:90px;float:left;"><input type="text" class="form-control timepicker timepicker-no-seconds startTimePicker" name="data[Useravailability]['+key+'][time]['+index+'][starttime]" value=""></div><span class="badge badge-primary" style="float: left;margin: 7px;">to</span><div style="width:90px;float:left;"><input type="text" class="form-control timepicker timepicker-no-seconds endTimePicker" name="data[Useravailability]['+key+'][time]['+index+'][endtime]" value=""></div><a href="javascript:;" class="btn btn-xs closeBtn"><i class="fa fa-times"></i></a></div>'+
                '<div class="checkbox-list">'+
                '<label>'+
                    '<input type="checkbox" class="permanentCheck">Permanent</label>'+
                '</div>'+
                '<select class="form-control input-sm selectOrg" name="data[Useravailability]['+key+'][time]['+index+'][organization_id]" style="width:256px;" value="0" disabled>'+
                '<?php if(isset($myOrganizations)&& !empty($myOrganizations)):?>'+
                '<option>Select Organization</option>'+
                '<?php foreach($myOrganizations as $orgId=>$value):?>'+
                '<option value="<?php echo $orgId;?>"><?php foreach ($value as $orgTitle => $branch):?><?php echo $orgTitle;?><?php endforeach;?></option>'+
                '<?php endforeach;?>'+
                '<?php else:?>'+
                    '<option>No Organization</option>'+
                '<?php endif;?>'+
                '</select></div>';
                return data;
            }


            $(".availabilitySelect").change(function(event) {

            // console.log('change');

                    var e = $(this);
                    var portletBody= e.closest('.availabilityDiv').find('.portlet-body').length;
                    if (e.val() == 1) 
                    {
                        if(portletBody ==0)
                        {
                            var key = e.attr('id');
                            var index = portletBody;

                            var data = addTimeSelectDiv(e, key, index);

                            e.closest('.availabilityDiv').find('.selectTimeDiv').append(data);

                            $('body').find('.timepicker').timepicker({defaultTime: '00:00 AM'}); 
                        }
                        else
                        {

                            e.closest('.availabilityDiv').find('.selectTimeDiv').show();
                        }
                            e.closest('.availabilityDiv').find(addBtn).show();

                    } else {
                        e.closest('.availabilityDiv').find('.selectTimeDiv').hide();
                        e.closest('.availabilityDiv').find(addBtn).hide();
                    }

                    $("body .closeBtn").bind('click', closeTimeDiv);

                    $("body .permanentCheck").unbind('click',permanentCheck);
                    $("body .permanentCheck").bind('click',permanentCheck);
                });

            $(".closeBtn").on('click', closeTimeDiv);

            function closeTimeDiv(e)
            {
                var e = $(this);

                var portletBody= e.closest('.availabilityDiv').find('.portlet-body').length;

                if(portletBody == 1)
                {

                }
                else
                {

                    e.closest('.portlet-body').remove();
                }
            }

            $(".permanentCheck").on('click', permanentCheck);

            function permanentCheck()
            {
                var e = $(this);
                var selectOrg = e.closest('.portlet-body').find('.selectOrg');
                    if(selectOrg.prop('disabled') == true)
                    {
                        console.log('false');
                        selectOrg.prop('disabled', false);
                    }
                    else
                    {
                        console.log('true');
                        selectOrg.prop('disabled', true);
                    }
            }


        });

</script>