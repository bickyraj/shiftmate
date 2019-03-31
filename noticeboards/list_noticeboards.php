<?php
 if (isset($_GET['page'])) {
     $page = $_GET['page'];
 } else {
     $page = 1;
 }

$url = URL . "Branches/listBranchesName/" . $orgId.".json";
$data = \Httpful\Request::get($url)->send();
$branches = $data->body->branches;

$url = URL . "Noticeboards/listNoticeboards/" . $orgId . "/".$page.".json";
$data = \Httpful\Request::get($url)->send();

if(isset($data->body->notices) && !empty($data->body->notices))
{
    $notices = $data->body->notices;
}

$totalPage = $data->body->output->pageCount;
$currentPage = $data->body->output->currentPage;


if (isset($_POST['editSubmit'])) {
            $url = URL."Noticeboards/editNoticeboards.json";
            $response = \Httpful\Request::post($url)
                ->sendsJson()
                ->body($_POST['data'])
                ->send();

            $url = URL . "Noticeboards/listNoticeboards/" . $orgId . ".json";
            $data = \Httpful\Request::get($url)->send();
            $notices = $data->body->notices;
}
?>
<style>
.portlet-title:hover {
    cursor: default !important;
}
</style>

<!-- BEGIN PAGE HEADER-->
<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>Notice Board <!-- <small> View Notice Board</small> --></h1>
		</div>
    </div>
</div>
 <div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo URL_VIEW; ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Notice Board</a>
            </li>
        </ul>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <!-- BEGIN PORTLET-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Notices</span>
                            <span class="caption-helper">organization notices list</span>
                        </div>
                        <div class="btn-group pull-right">
                        <a id="create_new_notice" data-toggle="modal" href="#newNoticeModal"  class="btn btn-fit-height green dropdown-toggle">
                                <i class="fa fa-plus"></i> 
                                Create New Notice
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div id="sortable_portlets">
                                    <?php if(isset($notices) && !empty($notices)):?>
                                        <?php usort($notices, function($a1, $a2) 
                                        {
                                           $v1 = strtotime($a1->Noticeboard->notice_date);
                                           $v2 = strtotime($a2->Noticeboard->notice_date);
                                           return $v2 - $v1; // $v2 - $v1 to reverse direction
                                        });

                                    ?>
                                        <?php $n=1; foreach ($notices as $notice):?>
                                            <div class="col-md-4 column sortable" id = "notices">
                                                <div class="portlet portlet-sortable light bg-inverse noticeOrgDiv">
                                                    <div class="portlet-title ui-sortable-handle">
                                                        <div class="caption">
                                                            <i class="fa fa-thumb-tack font-red-flamingo"></i>
                                                            <span class="caption-subject bold font-red-flamingo uppercase">
                                                            <?php echo $notice->Noticeboard->title;?></span>
                                                            <h6><?php echo getStandardDateTime($notice->Noticeboard->notice_date);?></h6>
                                                            <?php if($notice->Noticeboard->branch_id != 0) { ?>
                                                                <h6 style="font-weight:bold;"><?php echo $notice->Branch->title. ' Branch'; ?></h6>
                                                            <?php } ?>
                                                            
                                                        </div>
                                                        <div class="tools">
                                                            <a data-toggle="modal" class="config edit_notice_btn" data-original-title="" title="Edit" data-id="<?php echo $notice->Noticeboard->id;?>">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="notice_id" style="display:none;"><?php echo $notice->Noticeboard->id;?></div>
                                                        <p class="notice_description">
                                                            <?php $notice_desc=$notice->Noticeboard->description;

                                                                
                                                                echo substr($notice_desc,0,200);
                                                                 
                                                             
                                                            ?>
                                                        </p>
                                                        <?php
                                                        if(str_word_count($notice_desc) < 10 ){

                                                    
                                                        }
                                                    
                                                        else{
                                                            ?>
                                                             <a class="news-block-btn view_notice_btn config" data-toggle="modal" data-id="<?php echo $notice->Noticeboard->id;?>">
                                                                Read more <i class="m-icon-swapright m-icon-black"></i></a>
                                                               <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach;?>
                                    <?php else: ?>
                                        <div class="col-md-12" id="nonotice">No any notice published.</div>
                                    <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newNoticeModal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Create Notice</h4>
            </div>
            <form role="form" id="addNotice">
                <div class="modal-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label>Title</label>
                             <input type="text" name="data[Noticeboard][title]" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Select Branch</label>
                        <select class="form-control" name="data[Noticeboard][branch_id]" id="branch" required>
                            <option value="" selected disabled>Select Branch</option>
                            <?php foreach($branches as $key => $val){ ?>
                                <option value="<?php echo $key;?>"><?php echo $val;?></option>';
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea style="min-height:200px;" class="form-control" name="data[Noticeboard][description]" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" id="noticeSubmit" class="btn green">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
    $(function()
    {   
        $("#addNotice").live('submit',function(ev){
            ev.preventDefault()
            var orgId = '<?php echo $orgId; ?>';
            //console.log('<?php echo URL."Boards/editBoardwithdata/"."'+orgId+'".".json"; ?>');
            var data =$(this).serialize();
            var e = $(this);
            var branchName = $("#branch option:selected").text()+' Branch';
            $.ajax({
                url : '<?php echo URL."Noticeboards/addnoticewithdata/"."'+orgId+'".".json"; ?>',
                type : "post",
                data : data,
                datatype : "jsonp",
                success:function(response)
                {
                    // console.log(response);
                    var noticeDisplay = "";
                    var noticeDesc = response.noticeBoard.Noticeboard.description;
                     var description = '<p class="notice_description">'+noticeDesc.substring(0, 200)+'</p>';
                    var test = "";
                    if(noticeDesc.length <= 200){
                        test = '';
                    }
                    else{
                        test = '<a class="news-block-btn view_notice_btn" data-id="'+response.noticeBoard.Noticeboard.id+'" data-toggle="modal" class="config">Read more <i class="m-icon-swapright m-icon-black"></i></a>';
                    }
                    noticeDisplay = '<div class="col-md-4 column sortable" id = "notices"><div class="portlet portlet-sortable light bg-inverse noticeOrgDiv"><div class="portlet-title ui-sortable-handle"><div class="caption"><i class="icon-puzzle font-red-flamingo"></i><span class="caption-subject bold font-red-flamingo uppercase">'+response.noticeBoard.Noticeboard.title+'</span><h6>'+response.newNoticeTime+'</h6><h6 style="font-weight:bold;">'+branchName+'</h6></div><div class="tools"><a data-toggle="modal" class="config edit_notice_btn" data-id="'+response.noticeBoard.Noticeboard.id+'" data-original-title="" title="Edit"></a></div></div><div class="portlet-body"><div class="notice_id" style="display:none;">'+response.noticeBoard.Noticeboard.id+'</div>'+description+' '+test+'</div></div>';
                    if(response.output.status == '1'){
                        toastr.success('Posted Successfully.');
                        $("#sortable_portlets").prepend(noticeDisplay);
                        e.find('.addclear').click();
                        $("#newNoticeModal").modal('toggle');
                        $("#nonotice").remove();
                    }
                }
            });
        });

        $(".edit_notice_btn").live('click',function()
            {
                var e = $(this);

                var noticeId = e.attr('data-id');

                $.ajax(
                    {
                        url:'<?php echo URL;?>Noticeboards/viewNoticeboards/'+noticeId+'.json',
                        type:'post',
                        datatype:'jsonp',
                        success:function(res)
                        {
                            var data = res.notice;
                            var branchId = data.Noticeboard.branch_id;
                            
                            var option = '<option value="0">All Branch</option>';
                            
                            <?php foreach($branches as $key => $val){ ?>
                                var selected = '';
                                
                                if(branchId != 0 && branchId == '<?php echo $key ;?>'){
                                    selected = 'selected';
                                }
                                
                                option += '<option value="'+'<?php echo $key;?>'+'" '+selected+'>'+'<?php echo $val;?>'+'</option>';
                            <?php } ?>
                        

                            bootbox.dialog({
                                        title: "Edit Notice",
                                        message:
                                            '<form class="form-body" method="post"><div class="form-group">'+
                                                    '<label>Title</label>'+
                                                        '<input type="text" name="data[Noticeboard][title]" value="'+data.Noticeboard.title+'" class="form-control" required>'+
                                                '</div>'+

                                            '<input type="hidden" name="data[Noticeboard][id]" value="'+data.Noticeboard.id+'"/>'+

                                            '<div class="form-group">'+
                                                '<lable>Select Branch</label>'+
                                                '<select name="data[Noticeboard][branch_id]" class="form-control">'+
                                                 option+

                                                '</select>'+
                                            '</div>'+

                                            '<div class="form-group">'+
                                                    '<label>Description</label>'+
                                                    '<textarea style="min-height:200px;" class="form-control" name="data[Noticeboard][description]" rows="3" required>'+data.Noticeboard.description+'</textarea>'+
                                                '</div>'+
                                                '<div class="modal-footer">'+
                                                '<input type="button" name="close" value="Close" data-dismiss="modal" class="btn default">'+
                                                '<input type="submit" name="editSubmit" value="Save" class="btn btn-success" />'+
                                                '</div>'+
                                            '</form>'
                                    });
                        }
                    });

                 
        });


        $(".view_notice_btn").live('click',function()
            {
                var e = $(this);

                var noticeId = e.attr('data-id');

                $.ajax(
                    {
                        url:'<?php echo URL;?>Noticeboards/viewNoticeboards/'+noticeId+'.json',
                        type:'post',
                        datatype:'jsonp',
                        success:function(res)
                        {
                            var data = res.notice;

                            console.log(data);

                            bootbox.dialog({
                                        title:data.Noticeboard.title,
                                        message:
                                        '<div class="body">'+data.Noticeboard.description+'</div><div class="modal-footer"><button type="button" class="btn default" data-dismiss="modal">Close</button></div>'
                                    });
                        }
                    });

                 
        });
    });
</script>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/portlet-draggable.js"></script>




