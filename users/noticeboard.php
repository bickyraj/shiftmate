<?php
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }else{
        $page = 1;
    }
	$url = URL."Users/Notices/".$userId."/".$page.".json";
	$org = \Httpful\Request::get($url)->send();
    //fal($org);
	$org_details = $org->body->output['0']->OrganizationUser;
    //fal($org_details);

    $branchManager = loginUserRelationToOther($user_id)->branchManager;
    //fal($branchManager);

    $url = URL."BranchUsers/getUserRelatedBranches/".$userId.".json";
    $data = \Httpful\Request::get($url)->send();
    $userRelatedBranches = $data->body->list;

    $branchIds = array();
    foreach($userRelatedBranches as $b){
        $branchIds[] = $b->BranchUser->branch_id;
    }
?>


<style>
.portlet-body {
    height: 160px;
}
.portlet-title:hover {
    cursor: default !important;
}
</style>

<!-- BEGIN PAGE HEADER-->

<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Notice Board <small> view notice board</small></h1>
        </div>  
        <?php if(!empty($branchManager)){ ?>
        <div class="page-toolbar">
            <div class="btn-group pull-right" id="createNewNotice" style="margin-top: 15px;">
                <a  class="btn btn-fit-height grey-salt dropdown-toggle">
                    Create New Notice
                </a>
            </div>
        </div>
        <?php } ?>
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
                <a href="#">Notice Board</a>
            </li>
        </ul>

        <div class="row" id="sortable_portlets">
            <?php 
            $orgIds = array();
            if(isset($org_details) && !empty($org_details)):?>
                <?php foreach ($org_details as $org_detail):
                
                if ( in_array($org_detail->organization_id, $orgIds) ) {
                    continue;
                }
                $orgIds[] = $org_detail->organization_id;
                ?>

                    <?php  foreach($org_detail->Organization->Noticeboard as $notice): ?>
                        <?php if($notice->branch_id == 0 || in_array($notice->branch_id, $branchIds)) { ?>
                            <div class="col-md-4 column sortable">
                                <div class="portlet portlet-sortable light bg-inverse">
                                    <div class="portlet-title ui-sortable-handle">
                                        <div class="caption">
                                            <i class="icon-puzzle font-red-flamingo"></i>
                                            <span class="caption-subject bold font-red-flamingo uppercase">
                                            <?php echo $org_detail->Organization->title;?></span>
                                        
                                            <?php if($notice->branch_id != 0){ ?>
                                            <h6 style="font-weight:bold;"><?php echo $notice->Branch->title.' Branch'; ?></h6>
                                        <?php } ?>
                                        </div>

                                        <div class="tools">
                                            <?php 
                                   
                                            if(isset($notice->Branch->user_id)){
                                            if($userId == $notice->Branch->user_id):
                                            //if(!empty($branchManager)):

                                            ?>
                                            <span class="editNoticeBoard" id="<?php echo $notice->id; ?>"><a href="javascript:;" class=""><i class="fa fa-pencil"></i></a></span>
                                            <?php endif; }?>
                                            
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <h4 class="notice_title"><?php echo $notice->title;?></h4>
                                        <h6><?php echo $notice->notice_date;?></h6>
                                        <p class="notice_description">
                                           <?php echo substr($notice->description,0,100);
                                               $data=$notice->description;
                                            ?>
                                        </p>
                                    
                                        <?php 
                                            if(str_word_count($data) < 10 ){

                                        
                                            }
                                        
                                        else{
                                            ?>
                                        <a href="#portlet-config_<?php echo $notice->id; ?>" class="news-block-btn" data-toggle="modal" class="config">
                                        Read more <i class="m-icon-swapright m-icon-black"></i>
                                        </a>
                                        <?php
                                            }
                                        ?>

                                        <div class="modal fade" id="portlet-config_<?php echo $notice->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title"><?php echo $notice->title;?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                         <?php echo $notice->description; ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endforeach;?>
                <?php endforeach;?>
            <?php else:?>
                <div>No notices.</div>
            <?php endif;?>
        </div>
    </div>
</div>
<!--<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
<?php
$page=$org->body->page;
$max=$org->body->maxPage;

if($max>0){
?>
<div>Showing Page <?=$page;?> of <?=$max;?></div>
    <ul class="pagination" style="visibility: visible;">
        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
        <?php if($page<=1){ ?>
            <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
        <?php }else{ ?>
            <a title="First" href="?page=1"><i class="fa fa-angle-double-left"></i></a>
        <?php } ?>
        </li>
        <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
        <?php if($page<=1){ ?>
        <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
        <?php }else{ ?>
            <a title="Prev" href="?page=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
        <?php } ?>
        </li>
        
        <?php if($max<=5){
            for($i=1;$i<=$max;$i++){ ?>
            <li>
               <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
            </li>
         <?php }}else{
            if(($page-2)>=1 && ($page+2)<=$max){
                for($i=($page-2);$i<=($page+2);$i++){ ?>
                <li>
                   <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                </li>
          <?php  }}elseif(($page-2)<1){
            for($i=1;$i<=5;$i++){ ?>
                <li>
                   <a title="<?=$i;?>" href="?page=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                </li>
         <?php }}elseif(($page+2)>$max){
            for ($i=($max-4);$i<=$max;$i++){ ?>
                <li>
                   <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page=<?=$i?>"><?=$i;?></a>
                </li>
        <?php }}} ?>
        
        <li class="next <?php if($page>=$max){echo 'disabled';}?>">
        <?php if($page>=$max){ ?>
        <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
        <?php }else{ ?>
        <a title="Next" href="?page=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
        <?php } ?></li>
        <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
        <?php if($max==0 || $max==1){ ?>
        <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
        <?php }else{ ?>
        <a title="Last" href="?page=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
        <?php } ?></li>
    </ul>
<?php } ?>
</div> -->
<!-- END PAGE CONTENT-->
<script type="text/javascript">
    $(function()
    {
        var userId = '<?php echo $user_id; ?>';
        $("#createNewNotice").on('click',function(){
            $.ajax({
                url : '<?php echo URL."Users/loginUserRelationToOther11/"."'+userId+'".".json"; ?>',
                datatype : "jsonp",
                success:function(response)
                {
                    console.log(response);
                    var organization = '';
                    $.each(response.output.userOrganization,function(e,i){
                        $.each(i,function(l,j){
                            organization += '<option value="'+e+'">'+l+'</option>';
                        });
                    });
                    bootbox.dialog({
                        title: "New Notice",
                        message:
                            '<form class="form-body" id="addNotice" action="" method="post"> ' +

                            '<div class="form-group">'+
                                '<label>Organization <span class="required">'+
                                '* </span>'+
                                '</label>'+
                                   '<select name="data[Noticeboard][organization_id]" class="form-control" id="organization" required><option value="0">Choose your Organization</option>'+organization+'</select>'+
                            '</div>'+
                            '<span id="orgError" style="display:none;color:red;">Choose Organization</span>'+

                            '<div class="form-group">'+
                                '<label>Branch <span class="required">'+
                                '* </span>'+
                                '</label>'+
                                   '<select name="data[Noticeboard][branch_id]" class="form-control" id = "branch" required><option value="0">Choose your Branch</option></select>'+
                            '</div>'+
                            '<span id="branchError" style="display:none;color:red;">Choose Branch</span>'+

                            '<div class="form-group">'+
                                '<label>Title</label>'+
                                    '<input type="text" name="data[Noticeboard][title]" class="form-control" required>'+
                            '</div>'+


                            '<div class="form-group">'+
                                    '<label>Description</label>'+
                                    '<textarea style="min-height:200px;" class="form-control" name="data[Noticeboard][description]" rows="3" required></textarea>'+
                                '</div>'+

                             '<input type="submit" name="submit" value="Save" class="btn btn-success" />'+
                             '<input type="reset" class="addclear btn default" value="Clear">'+
                            '</form>'
                    });
                    $("#organization").live('change',function(){
                        var orgId = $(this).val();
                        console.log('<?php echo URL."Branches/orgRelatedToBranch/"."'+orgId+'"."/"."'+userId+'".".json"; ?>');
                        $.ajax({
                            url : '<?php echo URL."Branches/orgRelatedToBranch/"."'+orgId+'"."/"."'+userId+'".".json"; ?>',
                            datatype : "jsonp",
                            success:function(response)
                            {
                                //console.log(response);
                                var branchData = '';
                                $.each(response.branch,function(e,i){
                                    
                                        branchData += '<option value="'+i.Branch.id+'">'+i.Branch.title+'</option>';
                                });
                                $("#branch").html(branchData);
                                if(orgId == 0){
                                    branchData = '<option value = "0">Choose branch</option>';
                                    $("#branch").html(branchData);
                                }
                            }
                        });
                    });
                    
                }
            });
        });

        $("#addNotice").live('submit',function(event){
            event.preventDefault();
            var branchName = $("#branch option:selected").text()+' Branch';
            var orgId = $("#organization").val();
            var branchId = $("#branch").val();
            if(branchId != 0 || branchId != 0){
               var data = $(this).serialize();
                var ev = $(this);
                $.ajax({
                    url : '<?php echo URL."Noticeboards/addNoticeByUser/"."'+userId+'".".json"; ?>',
                    type : "post",
                    data : data,
                    datatype : "jsonp",
                    success:function(response)
                    {
                        console.log(response);
                        var noticeDisplay;
                        var noticeDescFinal = '';
                        var noticeDesc = response.nbData.Noticeboard.description; 
                        var maxLength = 100;
                        var trimmedString = noticeDesc.substr(0, maxLength);
                        // if(noticeDesc < maxLength){
                        //     noticeDescFinal = response.nbData.Noticeboard.description;
                        // }
                        // else{
                        //     noticeDescFinal = trimmedString+'<div class="noticeDisplayMore">Read more <i class="m-icon-swapright m-icon-black"></i></div>';
                        // }


                        var a = noticeDesc.split(/[\s\.,;]+/).length;
                        if(a <= 15){
                            noticeDescFinal = noticeDesc;
                        }
                        else{
                            noticeDescFinal = trimmedString+'<div class="noticeDisplayMore_'+response.nbData.Noticeboard.id+'"><a href="">Read more <i class="m-icon-swapright m-icon-black"></i></a></div>';
                        }
                        noticeDisplay = '<div class="col-md-4 column sortable"><div class="portlet portlet-sortable light bg-inverse"><div class="portlet-title ui-sortable-handle"><div class="caption"><i class="icon-puzzle font-red-flamingo"></i><span class="caption-subject bold font-red-flamingo uppercase">'+response.nbData.Organization.title+'</span><h6 style="font-weight:bold;">'+branchName+'</h6></div><div class="tools"><a href="" class="collapse" data-original-title="" title=""></a><a href="" class="fullscreen" data-original-title="" title=""></a><span class="editNoticeBoard" id="'+response.nbData.Noticeboard.id+'"><a href="" class="edit"><i class="fa fa-pencil"></i></a></span><a href="" class="remove" data-original-title="" title=""></a></div></div><div class="portlet-body"><h4 class="notice_title">'+response.nbData.Noticeboard.title+'</h4><h6>'+response.nbData.Noticeboard.notice_date+'</h6><p class="notice_description">'+noticeDescFinal+'</p></div></div></div>';
                        
                        $("#sortable_portlets").append(noticeDisplay);
                        ev.find('.addclear').click();
                        ev.find('.bootbox-close-button').click();
                        ev.closest('.modal-dialog').find('.bootbox-close-button').click();
                        $(".noticeDisplayMore_"+response.nbData.Noticeboard.id).live('click',function(ev){
                            ev.preventDefault();
                            bootbox.dialog({
                                title: response.nbData.Noticeboard.title,
                                message:
                                    '<div class="modal-body">'+noticeDesc+'</div>'+
                                    '<div class="modal-footer">'+
                                        '<button type="button" class="btn default" data-dismiss="modal">Close</button>'+
                                    '</div>'
                            });
                        });

                    }
                });
            }
            else if(orgId == 0 && branchId != 0){
                $("#branchError").css("display", "none");
               $("#orgError").css("display", "block");
            }
            else if(orgId != 0 &&branchId == 0){
                $("#orgError").css("display", "none");
               $("#branchError").css("display", "block");
            }
            
            else{
                $("#branchError").css("display", "block");
                $("#orgError").css("display", "block");
            }
        });
        $(".editNoticeBoard").live('click',function(){
            var noticeBoardID = this.id;
            $.ajax
            ({
                url : '<?php echo URL."Noticeboards/editNoticeBoardData/"."'+userId+'"."/"."'+noticeBoardID+'".".json"; ?>',
                datatype : "jsonp",
                success:function(response)
                {
                    console.log(response);
                    var orgshow = "";
                    var option = "";
                    var selectedbranchId = response.noticeBoard.Noticeboard.branch_id;
                    var test = '<option value="'+response.noticeBoard.Branch.id+'">'+response.noticeBoard.Branch.title+'</option>';
                    $.each(response.branchManager.userOrganization,function(i,v){
                        $.each(v,function(k,l)
                        {
                            if(response.noticeBoard.Noticeboard.organization_id == i)
                            {
                                orgshow = 'selected="selected"';
                                var editbranchData = '';
                                $.ajax({
                                    url : '<?php echo URL."Branches/orgRelatedToBranch/"."'+response.noticeBoard.Noticeboard.organization_id+'"."/"."'+userId+'".".json"; ?>',
                                    datatype : "jsonp",
                                    success:function(response)
                                    {
                                       
                                         var editbranchData = '';
                                         var a = '';
                                        $.each(response.branch,function(e,i)
                                         {  
                                            if(i.Branch.id == selectedbranchId){
                                                
                                                editbranchData += '<option value="'+i.Branch.id+'" selected>'+i.Branch.title+'</option>';
                                            }
                                            else
                                            {

                                            editbranchData += '<option value="'+i.Branch.id+'">'+i.Branch.title+'</option>';
                                            }
                                         });
                                         $("#editbranch").html(editbranchData);
                                    }
                                });
                            }
                            else{
                                orgshow = '';
                            }
                            option += '<option value="'+i+'"'+orgshow+'>'+k+'</option>';
                            //console.log(option);
                        });
                    });

                    bootbox.dialog
                    ({
                        title: "Edit Notice",
                        message:
                            '<form class="form-body" id="editNotice" action="" method="post" data-noticeBoardids="'+response.noticeBoard.Noticeboard.id+'"> ' +

                            '<div class="form-group">'+
                                '<label>Organization <span class="required">'+
                                '* </span>'+
                                '</label>'+
                                   '<select name="data[Noticeboard][organization_id]" class="form-control" id="editorganization" required><option value="0">Choose your Organization</option>'+option+'</select>'+
                            '</div>'+
                            '<span id="orgEditError" style="display:none;color:red;">Choose Organization</span>'+

                            '<div class="form-group">'+
                                '<label>Branch <span class="required">'+
                                '* </span>'+
                                '</label>'+
                                   '<select name="data[Noticeboard][branch_id]" class="form-control" id = "editbranch" required><option value="0">Choose your Branch</option></select>'+
                            '</div>'+
                            '<span id="branchEditError" style="display:none;color:red;">Choose Branch</span>'+

                            '<div class="form-group">'+
                                '<label>Title</label>'+
                                    '<input type="text" name="data[Noticeboard][title]" class="form-control" value= "'+response.noticeBoard.Noticeboard.title+'" required>'+
                            '</div>'+


                            '<div class="form-group">'+
                                    '<label>Description</label>'+
                                    '<textarea style="min-height:200px;" class="form-control" name="data[Noticeboard][description]" rows="3" required>'+response.noticeBoard.Noticeboard.description+'</textarea>'+
                                '</div>'+

                             '<input type="submit" name="submit" value="Save" class="btn btn-success" />'+
                             '<input type="reset" class="editclear btn default" value="Clear">'+
                            '</form>'
                    });
                    $("#editorganization").live('change',function(){
                        var orgId = $(this).val();
                        //console.log('<?php echo URL."Branches/orgRelatedToBranch/"."'+orgId+'"."/"."'+userId+'".".json"; ?>');
                        $.ajax({
                            url : '<?php echo URL."Branches/orgRelatedToBranch/"."'+orgId+'"."/"."'+userId+'".".json"; ?>',
                            datatype : "jsonp",
                            success:function(response)
                            {
                                 var editbranchData = '';
                                $.each(response.branch,function(e,i)
                                 {  
                                    editbranchData += '<option value="'+i.Branch.id+'">'+i.Branch.title+'</option>';
                                 });
                                 $("#editbranch").html(editbranchData);
                                 if(orgId == 0){
                                    editbranchData  = '<option value = "0">select Branch</option>';
                                    $("#editbranch").html(editbranchData);
                                 }

                            }
                        });
                    });
                }
            });
        });
        $("#editNotice").live('submit',function(event){
            event.preventDefault();
            var orgeditId = $("#editorganization").val();
            var brancheditId = $("#editbranch").val();
            console.log(orgeditId);
            console.log(brancheditId);
            if(orgeditId != 0 || brancheditId != 0){
                var e = $(this);
                var data = $(this).serialize();
                var noticeids = $(this).attr('data-noticeBoardids');
                
                $.ajax({
                    url : '<?php echo URL."Noticeboards/editNoticeBoard/"."'+noticeids+'".".json"; ?>',
                    type : "post",
                    data : data,
                    datatype : "jsonp",
                    success:function(response)
                    {
                        if(response.output == 1){
                           window.location.reload(true);
                           toastr.success('Recorded Updated Successfully');
                            e.find('.editclear').click();
                            e.find('.bootbox-close-button').click();
                            e.closest('.modal-dialog').find('.bootbox-close-button').click();
                       }
                        
                    }
                });
            }
            else if(orgeditId == 0 && brancheditId != 0){
                $("#orgEditError").css("display", "block");
               $("#branchEditError").css("display", "none");
            }
            else if(orgeditId != 0 &&brancheditId == 0){
                $("#orgEditError").css("display", "block");
               $("#branchEditError").css("display", "none");
            }
            
            else{
                $("#orgEditError").css("display", "block");
                $("#branchEditError").css("display", "block");
            }

        });

    });
</script>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL_VIEW;?>global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>admin/layout/scripts/demo.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- END JAVASCRIPTS -->