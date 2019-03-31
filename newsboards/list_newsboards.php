<?php
 if (isset($_GET['page'])) {
     $page = $_GET['page'];
 } else {
     $page = 1;
 }

$url = URL . "Newsboards/listNewsboards/" . $orgId . "/".$page.".json";
$data = \Httpful\Request::get($url)->send();
$newsboards = $data->body->news;

$totalPage = $data->body->output->pageCount;
$currentPage = $data->body->output->currentPage;

// echo "<pre>";
// print_r($notices);

// if(isset($_POST['submit']))
// {
//     $url = URL."Newsboards/add/".$orgId.".json";
//     $response = \Httpful\Request::post($url)
//                 ->sendsJson()
//                 ->body($_POST['data'])
//                 ->send();
//     $url = URL . "Newsboards/listNewsboards/" . $orgId . ".json";
//     $data = \Httpful\Request::get($url)->send();
//     $newsboards = $data->body->news;
// }

// if (isset($_POST['editSubmit'])) {

//             $url = URL."Newsboards/editNewsboards.json";
//             $response = \Httpful\Request::post($url)
//                 ->sendsJson()
//                 ->body($_POST['data'])
//                 ->send();

//             $url = URL . "Newsboards/listNewsboards/" . $orgId . ".json";
//             $data = \Httpful\Request::get($url)->send();
//             $newsboards = $data->body->news;
// }
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
			<h1>News<small> View news</small></h1>
		</div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-circle"></i>
                <a href="<?php echo URL_VIEW; ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:;">News</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">News</span>
                            <span class="caption-helper">organisation news list</span>
                        </div>
                        <div class="btn-group pull-right">
                            <a id="create_new_news" class="btn btn-fit-height green dropdown-toggle">
                            <i class="fa fa-plus"></i> 
                                Create New News
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                    <div class="row">
                        <div id="sortable_portlets">
                            <?php if(isset($newsboards) && !empty($newsboards)):?>

                                <?php usort($newsboards, function($a1, $a2) {
                                                                               $v1 = strtotime($a1->Newsboard->news_date);
                                                                               $v2 = strtotime($a2->Newsboard->news_date);
                                                                               return $v2 - $v1; // $v2 - $v1 to reverse direction
                                                                            });
                                ?>
                                <?php $n=1; foreach ($newsboards as $news):?>
                                <div class="col-md-4 column sortable" >
                                    <div class="portlet portlet-sortable box green-haze">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-ellipsis-v"></i>News <?php echo $n++;?>
                                            </div>
                                            <div class="actions edit_news_btn" id ="<?php echo $news->Newsboard->id;?>">
                                                <a href="javascript:;" class="btn btn-default btn-sm">
                                                <i class="fa fa-pencil"></i> Edit </a>
                                                <!-- <a href="javascript:;" class="btn btn-default btn-sm">
                                                <i class="fa  fa-times"></i> Delete </a> -->
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <h4 class="news_title"><?php echo $news->Newsboard->title;?></h4>
                                            <div class="news_id" style="display:none;"><?php echo $news->Newsboard->id;?></div>
                                            <h6><?php echo getStandardDateTime($news->Newsboard->news_date);?></h6>
                                            <p class="news_description">
                                                <?php echo substr($news->Newsboard->description,0,100);
                                               $data=$news->Newsboard->description;
                                            ?>
                                            </p>
                                            <?php
                                                if(str_word_count($data) < 10 ){

                                            
                                                }
                                            
                                            else{
                                                ?>
                                            <a href="#portlet-config_<?php echo $news->Newsboard->id; ?>" class="news-block-btn" data-toggle="modal" class="config">
                                            Read more <i class="m-icon-swapright m-icon-black"></i>
                                            </a>
                                            <?php
                                                }
                                            ?>

                                            <!--pop-up content for News board-->

                                            <div class="modal fade" id="portlet-config_<?php echo $news->Newsboard->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                            <h4 class="modal-title"><?php echo $news->Newsboard->title;?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                             <?php echo $news->Newsboard->description; ?>
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

                                <?php endforeach;?>
                            <?php endif;?>
                        </div>

                        <?php if(!isset($newsboards) && empty($newsboards)):?>
                            <div>There are no news published.</div>
                        <?php endif;?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(isset($newsboards) && !empty($newsboards)):?>
                                <hr>
                                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                                    <?php
                                    $page=$currentPage;
                                    $max=$totalPage;
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
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(function()
    {

        var orgId = '<?php echo $orgId; ?>';
        $("#create_new_news").click(function()
        {
            $("#submitNews").removeAttr("disabled");
            bootbox.dialog({
                title: "New News",
                message:
                    '<form class="form-body" id="addNews" action="" method="post"> ' +

                    '<div class="form-group">'+
                            '<label>Title</label>'+
                                '<input type="text" name="data[Newsboard][title]" class="form-control" required>'+
                        '</div>'+


                    '<div class="form-group">'+
                            '<label>Description</label>'+
                            '<textarea style="min-height:200px;" class="form-control" name="data[Newsboard][description]" rows="3" required></textarea>'+
                        '</div>'+

                     '<div class="modal-footer">'+
                     '<input type="submit" name="submit" id="submitNews" value="Save" class="btn btn-success" />'+
                     '<input type="button" data-dismiss="modal" class="btn btn-default" value="Close">'+
                     '</div>'+
                    '</form>'
            }
        );
        });
        $("#addNews").live('submit',function(ev){
            $("#submitNews").attr("disabled","disabled");
            ev.preventDefault();
            //console.log('<?php echo URL."Boards/editBoardwithdata/"."'+orgId+'".".json"; ?>');
            var data =$(this).serialize();
            //alert('tt');
            var e = $(this);
            $.ajax({
                url : '<?php echo URL."Newsboards/addnewswithdata/"."'+orgId+'".".json"; ?>',
                type : "post",
                data : data,
                datatype : "jsonp",
                success:function(response)
                {
                    var newsDescFinal ='';
                    var newsDesc = response.newsData.Newsboard.description; 
                    var maxLength = 100;
                    var trimmedString = newsDesc.substr(0, maxLength);
                    var countLength = newsDesc.split(/[\s\.,;]+/).length;
                    if(countLength <= 15){
                        newsDescFinal = newsDesc;
                    }
                    else{
                        newsDescFinal = trimmedString+'<div class="newsDisplayMore_'+response.newsData.Newsboard.id+'"><a href="">Read more <i class="m-icon-swapright m-icon-black"></i></a></div>';
                    }
                    var newsDisplay = '<div class="col-md-4 column sortable" ><div class="portlet portlet-sortable box green-haze"><div class="portlet-title"><div class="caption"><i class="fa fa-ellipsis-v"></i>News</div><div class="actions edit_news_btn" id = "'+response.newsData.Newsboard.id+'"><a href="javascript:;" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i> Edit </a></div></div><div class="portlet-body"><h4 class="news_title">'+response.newsData.Newsboard.title+'</h4><div class="news_id" style="display:none;">'+response.newsData.Newsboard.id+'</div><h6>'+response.newNewsTime+'</h6><p class="news_description">'+newsDescFinal+'</p></div></div></div>';
                    if(response.output == 1){
                        toastr.success('Recorded Added Successfully');
                        $("#sortable_portlets").prepend(newsDisplay);
                        e.find('.addclear').click();
                        e.find('.bootbox-close-button').click();
                        e.closest('.modal-dialog').find('.bootbox-close-button').click();
                    }
                    $(".newsDisplayMore_"+response.newsData.Newsboard.id).live('click',function(ev){
                        ev.preventDefault();
                        bootbox.dialog({
                            title: response.newsData.Newsboard.title,
                            message:
                                '<div class="modal-body">'+newsDesc+'</div>'+
                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn default" data-dismiss="modal">Close</button>'+
                                '</div>'
                        });
                    });
                }
            }); 
        });

        $(".edit_news_btn").live('click',function()
        {
            var newsId = this.id;
            $.ajax({
                url : '<?php echo URL."Newsboards/editnewsData/"."'+newsId+'".".json"; ?>',
                datatype : "jsonp",
                headers: {"Api-key": "008b98c7209c83359461bdbcc5784f9d", "access-token":'<?php echo $_SESSION["token"]->access_token; ?>'},
                success:function(response)
                {
                    console.log(response);
                    bootbox.dialog({
                        title: "Edit news",
                        message:
                            '<form class="form-body" action="" method="post" id="editNewsBoards" data-newsId="'+response.newsEditData.Newsboard.id+'"> ' +

                            '<div class="form-group">'+
                                    '<label>Title</label>'+
                                        '<input type="text" name="data[Newsboard][title]" value="'+response.newsEditData.Newsboard.title+'" class="form-control"  required>'+
                                '</div>'+
                            '<div class="form-group">'+
                                    '<label>Description</label>'+
                                    '<textarea style="min-height:200px;" class="form-control" name="data[Newsboard][description]" rows="3" required>'+response.newsEditData.Newsboard.description+'</textarea>'+
                                '</div>'+
                                '<div class="modal-footer">'+
                                '<input type="submit" name="editSubmit" value="Save" class="btn btn-success" />'+
                                '<input type="button" data-dismiss="modal" class="btn btn-default" value="Close">'+                                
                                '</div>'+    
                            '</form>'
                    }); 
                }
            });
             
        });
        $("#editNewsBoards").live('submit',function(ev){
            ev.preventDefault();
            var newsid = $(this).attr('data-newsId');
            var data = $(this).serialize();
            var e = $(this);
            $.ajax({
                url : '<?php echo URL."Newsboards/editNewsboards/"."'+newsid+'".".json"; ?>',
                type : "post",
                data : data,
                datatype : "jsonp",
                headers: {"Api-key": "008b98c7209c83359461bdbcc5784f9d", "access-token":'<?php echo $_SESSION["token"]->access_token; ?>'},
                success:function(response)
                {
                    //console.log(response);
                    if(response.output == 1){
                       window.location.reload(true);
                       toastr.success('Recorded Updated Successfully');
                        e.find('.editclear').click();
                        e.find('.bootbox-close-button').click();
                        e.closest('.modal-dialog').find('.bootbox-close-button').click();
                   }
                    
                }
            });
        });



    });

</script>
    <!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/portlet-draggable.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- END PAGE LEVEL PLUGINS -->


