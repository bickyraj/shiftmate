<?php
// if (isset($_GET['page'])) {
//     $page = "page:" . $_GET['page'];
// } else {
//     $page = '';
// }


$url = URL . "Noticeboards/listNoticeboards/" . $orgId . ".json";
$data = \Httpful\Request::get($url)->send();

// fal($data);

if(isset($data->body->notices) && !empty($data->body->notices))
{
    $notices = $data->body->notices;
}
// echo "<pre>";
// print_r($notices);
//$totalPage = $data->body->output->pageCount;
//$currentPage = $data->body->output->currentPage;
// echo "<pre>";
// print_r($notices);

// if(isset($_POST['submit']))
// {
//     $url = URL."Noticeboards/add/".$orgId.".json";
//     $response = \Httpful\Request::post($url)
//                 ->sendsJson()
//                 ->body($_POST['data'])
//                 ->send();
//     $url = URL . "Noticeboards/listNoticeboards/" . $orgId . ".json";
//     $data = \Httpful\Request::get($url)->send();
//     $notices = $data->body->notices;
// }

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
.portlet-body {
    height: 190px;
}
.portlet-title:hover {
    cursor: default !important;
}
</style>

<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
    Notice Board <small> view notice board</small>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo URL_VIEW; ?>">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Notice Board</a>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
        <a id="create_new_notice"  class="btn btn-fit-height grey-salt dropdown-toggle">
                <!--<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">-->
                Create New Notice
            <!--</button>-->
            </a>
            <!-- <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
            Actions <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <li>
                    <a id="create_new_notice">Create New Notice</a>
                </li>
                <li>
                    <a href="#">Another action</a>
                </li>
                <li>
                    <a href="#">Something else here</a>
                </li>
                <li class="divider">
                </li>
                <li>
                    <a href="#">Separated link</a>
                </li>
            </ul> -->
        </div>
    </div>
</div>
<!-- END PAGE HEADER-->
            
<!-- BEGIN PAGE CONTENT-->

<div class="row" id="sortable_portlets">
<?php if(isset($notices) && !empty($notices))
    {?>


        <?php                       
            usort($notices, function($a1, $a2) {
                                               $v1 = strtotime($a1->Noticeboard->notice_date);
                                               $v2 = strtotime($a2->Noticeboard->notice_date);
                                               return $v2 - $v1; // $v2 - $v1 to reverse direction
                                            });

        ?>
    


    <?php $n=1; foreach ($notices as $notice):?>
    <div class="col-md-4 column sortable" id = "notices">

        

        <div class="portlet portlet-sortable light bg-inverse">
                                <div class="portlet-title ui-sortable-handle">
                                    <div class="caption">
                                        <i class="icon-puzzle font-red-flamingo"></i>
                                        <span class="caption-subject bold font-red-flamingo uppercase">
                                        Notice <?php echo $n++;?> </span>
                                    </div>
                                    <div class="tools">
                                        <a href="" class="collapse" data-original-title="" title="">
                                        </a>
                                        <a data-toggle="modal" class="config edit_notice_btn" data-original-title="" title="Edit">
                                        </a>
                                        <a href="" class="remove" data-original-title="" title="">
                                        </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <h4 class="notice_title"><?php echo $notice->Noticeboard->title;?></h4>

                                    <div class="notice_id" style="display:none;"><?php echo $notice->Noticeboard->id;?></div>
                                    <h6><?php echo $notice->Noticeboard->notice_date;?></h6>
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
                                     <a href="#portlet-config_<?php echo $notice->Noticeboard->id; ?>" class="news-block-btn" data-toggle="modal" class="config">
                                        Read more <i class="m-icon-swapright m-icon-black"></i></a>
                                       <?php }?>
                                </div>

                            </div>
                            <!-- empty sortable porlet required for each columns! -->
        <div class="modal fade" id="portlet-config_<?php echo $notice->Noticeboard->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h4 class="modal-title"><?php echo $notice->Noticeboard->title;?></h4>
                                            </div>
                                            <div class="modal-body">
                                                 <?php echo $notice->Noticeboard->description; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    </div>
    <?php endforeach;?>

    <?php }else{?>

<?php }?>
</div>
<!-- END PAGE CONTENT-->


    <!-- BEGIN PAGE LEVEL SCRIPTS -->

    <script type="text/javascript">
$(function()
{

    $("#create_new_notice").click(function()
        {
            bootbox.dialog({
                title: "Create New Notice",
                message:
                    '<form action="" id="addNotice" method="post" class="form-body"> ' +

                    '<div class="form-group">'+
                            '<label>Title</label>'+
                                '<input type="text" name="data[Noticeboard][title]" class="form-control" required>'+
                        '</div>'+


                    '<div class="form-group">'+
                            '<label>Description</label>'+
                            '<textarea style="min-height:200px;" class="form-control" name="data[Noticeboard][description]" rows="3" required></textarea>'+
                        '</div>'+

                         '<input type="submit" name="submit" value="Save" class="btn btn-success" />'+
                        '<input type="reset" name="clear" value="Clear" class="addclear btn default">'+

                    '</div> ' +
                    '</form>'
            }
        );
        });
    $("#addNotice").live('submit',function(ev){
        ev.preventDefault()
        var orgId = '<?php echo $orgId; ?>';
        //console.log('<?php echo URL."Boards/editBoardwithdata/"."'+orgId+'".".json"; ?>');
        var data =$(this).serialize();
        var e = $(this);
        $.ajax({
            url : '<?php echo URL."Noticeboards/addnoticewithdata/"."'+orgId+'".".json"; ?>',
            type : "post",
            data : data,
            datatype : "jsonp",
            success:function(response)
            {
                console.log(response);
                var noticeDisplay = "";
                var noticeDesc = response.noticeBoard.Noticeboard.description;
                 var description = '<p class="notice_description">'+noticeDesc.substring(0, 200)+'</p>';
                var test = "";
                if(noticeDesc.length <= 200){
                    test = '';
                }
                else{
                    test = '<a href="#portlet-config_'+response.noticeBoard.Noticeboard.id+'" class="news-block-btn" data-toggle="modal" class="config">Read more <i class="m-icon-swapright m-icon-black"></i></a>';
                }
                noticeDisplay = '<div class="portlet portlet-sortable light bg-inverse"><div class="portlet-title ui-sortable-handle"><div class="caption"><i class="icon-puzzle font-red-flamingo"></i><span class="caption-subject bold font-red-flamingo uppercase">Notice  </span></div><div class="tools"><a href="" class="collapse" data-original-title="" title=""></a><a data-toggle="modal" class="config edit_notice_btn" data-original-title="" title="Edit"></a><a href="" class="remove" data-original-title="" title=""></a></div></div><div class="portlet-body"><h4 class="notice_title">'+response.noticeBoard.Noticeboard.title+'</h4><div class="notice_id" style="display:none;">'+response.noticeBoard.Noticeboard.id+'</div><h6>'+response.noticeBoard.Noticeboard.notice_date+'</h6>'+description+' '+test;
                if(response.output.status == '1'){
                    toastr.success('Recorded Added Successfully');
                    $("#notices").prepend(noticeDisplay);
                    e.find('.addclear').click();
                    e.find('.bootbox-close-button').click();
                    e.closest('.modal-dialog').find('.bootbox-close-button').click();
                }
            }
        });
    });

    $(".edit_notice_btn").live('click',function()
        {
            var e = $(this);

            var notice_title = e.closest('.portlet').find(".notice_title").text();

            var notice_description = e.closest('.portlet').find(".notice_description").text();

            var notice_id = e.closest('.portlet').find(".notice_id").text();

            console.log(notice_id);

             bootbox.dialog({
                title: "Edit Notice",
                message:
                    '<form class="form-body" method="post"> ' +

                    '<div class="form-group">'+
                            '<label>Title</label>'+
                                '<input type="text" name="data[Noticeboard][title]" value="'+notice_title+'" class="form-control" required>'+
                        '</div>'+

                    '<input type="hidden" name="data[Noticeboard][id]" value="'+notice_id+'"/>'+

                    '<div class="form-group">'+
                            '<label>Description</label>'+
                            '<textarea style="min-height:200px;" class="form-control" name="data[Noticeboard][description]" rows="3" required>'+notice_description+'</textarea>'+
                        '</div>'+

                        '<input type="submit" name="editSubmit" value="Save" class="btn btn-success" />'+
                    '</form>'
            }
        );
    });
});


</script>

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/portlet-draggable.js"></script>




