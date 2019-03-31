

<?php 
$inboxMessage_link = URL_VIEW."users/employee/organizationMessage";


if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}
 $url = URL.'Messages/listSentMessage/'.$user_id.'/'.$page.'.json';
 $response = \Httpful\Request::get($url)
 ->send();

 $messages = $response->body->mySentMessage;

 // fal($messages);

 $pageInfo = $response->body->output;

$totalPage=$pageInfo->pageCount;
$currentPage=$pageInfo->page;
 // echo "<pre>";
 // print_r($response->body->messages);
   
    
?>


<!-- BEGIN:File Upload Plugin CSS files-->

<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet"/>
<link href="<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet"/>
<!-- END:File Upload Plugin CSS files-->
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo URL_VIEW;?>admin/pages/css/inbox.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
<!-- BEGIN:File Upload Plugin JS files-->
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->




<script src="<?php echo URL_VIEW;?>admin/pages/scripts/inbox.js" type="text/javascript"></script>

<!-- END THEME STYLES -->
<div class="page-head">
    <div class="container">
        <div class="page-title">
            <h1>Messages</h1>
        </div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo URL_VIEW.'users/employee/inboxMessages'; ?>">Message</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Sentmessage</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet light">
                    <div class="portlet-body">
                        <div class="row inbox">
                            <div class="col-md-2">
                                <ul class="inbox-nav margin-bottom-10">
                                    <li class="compose-btn">
                                        <a href="<?php echo URL_VIEW.'messages/employeeComposeMessage';?>" data-title="Compose" class="btn green">
                                        <i class="fa fa-edit"></i> Compose </a>
                                    </li>
                                    <li class="inbox">
                                        <a href="<?php echo URL_VIEW.'messages/employeeInbox';?>" class="btn" data-title="Inbox">
                                        Inbox</a>
                                        <b></b>
                                    </li>
                                    <li class="sent active">
                                        <a class="btn" href="<?php echo URL_VIEW.'messages/employeeSentMessages';?>" data-title="Sent">
                                        Sent </a>
                                        <b></b>
                                    </li>
                                    <!-- <li class="draft">
                                        <a class="btn" href="javascript:;" data-title="Draft">
                                        Draft </a>
                                        <b></b>
                                    </li>
                                    <li class="trash">
                                        <a class="btn" href="javascript:;" data-title="Trash">
                                        Trash </a>
                                        <b></b>
                                    </li> -->
                                </ul>
                            </div>
                            <div class="col-md-10">
                                <div class="inbox-header">
                                    <h1 class="pull-left">Sent</h1>
                                </div>
                                <div class="inbox-content">
                                    <table class="table table-striped table-advance table-hover">
                                            <thead>
                                            <tr>
                                                <th colspan="3">
                                                    <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm blue dropdown-toggle" href="javascript:;" data-toggle="dropdown">
                                                        More <i class="fa fa-angle-down"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="javascript:;">
                                                                <i class="fa fa-pencil"></i> Mark as Read </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;">
                                                                <i class="fa fa-ban"></i> Spam </a>
                                                            </li>
                                                            <li class="divider">
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;">
                                                                <i class="fa fa-trash-o"></i> Delete </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </th>
                                                <th class="pagination-control" colspan="3">
                                                    <?php if(isset($pageInfo) && !empty($pageInfo) && $pageInfo->status ==1):?>
                                                        <span class="pagination-info">
                                                        <?php echo $pageInfo->page;?> of <?php echo $pageInfo->pageCount;?> </span>

                                                        <?php if($pageInfo->prevPage ==true):?>
                                                            <?php $prev = $pageInfo->page - 1;?>
                                                            <a href="<?php echo URL_VIEW;?>users/employee/sentEmployeeMessages?page=<?php echo $prev;?>" class="btn btn-sm blue">
                                                            <i class="fa fa-angle-left"></i>
                                                            </a>
                                                        <?php else:?>
                                                            <?php $prev = $pageInfo->page - 1;?>
                                                            <Button class="btn btn-sm blue" style="opacity:0.6;">
                                                            <i class="fa fa-angle-left"></i>
                                                            </Button>
                                                        <?php endif;?>
                                                        <?php if($pageInfo->nextPage == true):?>
                                                            <?php $next = $pageInfo->page + 1;?>
                                                            <a href="<?php echo URL_VIEW;?>users/employee/sentEmployeeMessages?page=<?php echo $next;?>" class="btn btn-sm blue">
                                                            <i class="fa fa-angle-right"></i>
                                                            </a>
                                                        <?php else:?>
                                                            <Button class="btn btn-sm blue" style="opacity:0.6;">
                                                            <i class="fa fa-angle-right"></i>
                                                            </Button>
                                                        <?php endif;?>
                                                    <?php endif;?>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                if(isset($messages) && !empty($messages))
                                                {
                                                    foreach ($messages as $message)
                                                        {?>
                                                            <tr class="unread" data-messageid="<?php echo $message->Message->id;?>">
                                                                <td class="inbox-small-cells">
                                                                    <input type="checkbox" class="mail-checkbox">
                                                                </td>
                                                                <!-- <td class="inbox-small-cells">
                                                                    <i class="fa fa-star"></i>
                                                                </td> -->
                                                                <td class="view-message hidden-xs">
                                                                    <?php echo $message->UserTo->fname." ".$message->UserTo->lname; ?>
                                                                </td>
                                                                <td class="view-message ">

                                                                    <i><?php echo $message->Message->content;?></i>
                                                                </td>

                                                                <?php $date = new DateTime($message->Message->date_time);?>
                                                                <td class="view-message text-right">
                                                                    <?php echo $date->format('g:i A');?>
                                                                </td>

                                                                <td>
                                                                    <?php echo $date->format('jS F Y');?>
                                                                </td>
                                                            

                                                            </tr>

                                                    <?php }
                                                }
                                                else{?>
                                                                <tr class="unread" data-messageid="1">
                                                                    <td>
                                                                    No Messages
                                                                </td>
                                                            </tr>
                                                <?php }?>
                                            </tbody>
                                            </table>                             
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
jQuery(document).ready(function() {

    
   // Inbox.init();
});
</script>

<script type="text/javascript">

$(function()
    {
        $('.inbox-content').on('click', '.view-message', function () {
            var messageId = $(this).closest('tr').attr('data-messageid');
            var url = "<?php echo URL_VIEW.'messages/viewSentMessages?msgId=';?>"+messageId;    
            $(location).attr('href',url);
        });
        
        var initWysihtml5 = function () {
        $('.inbox-wysihtml5').wysihtml5({
            "stylesheets": ["<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
        });
    }

    var initFileupload = function () {

        $('#fileupload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: '<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/server/php/',
            autoUpload: true
        });

        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '<?php echo URL_VIEW;?>global/plugins/jquery-file-upload/server/php/',
                type: 'HEAD'
            }).fail(function () {
                $('<span class="alert alert-error"/>')
                    .text('Upload server currently unavailable - ' +
                    new Date())
                    .appendTo('#fileupload');
            });
        }
    }
        initFileupload();
                initWysihtml5();

                $('.inbox-wysihtml5').focus();
                Layout.fixContentHeight();
                Metronic.initUniform();
    });

</script>