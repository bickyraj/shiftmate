

<?php

// echo $_GET['msgId'];

$url = URL."Senders/getMessageDetail/".$_GET['msgId'].".json";

$response = \Httpful\Request::get($url)->send();

$messageDetail = $response->body;
// echo "<pre>";
// print_r($messageDetail);
   
    
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
                <a href="#">Pages</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">Inbox</a>
            </li>
        </ul>
                
        <div class="row inbox">
            <div class="col-md-12 col-sm-12">
                <div class="portlet light" style="min-height:300px;">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <ul class="inbox-nav margin-bottom-10">
                                        <li class="compose-btn">
                                            <a href="<?php echo URL_VIEW.'messages/composeMessage';?>" data-title="Compose" class="btn green">
                                        <i class="fa fa-edit"></i> Compose </a>
                                        </li>
                                        <li class="inbox">
                                           <a href="<?php echo URL_VIEW.'messages/inboxMessages';?>" class="btn" data-title="Inbox">
                                        Inbox</a>
                                        </li>
                                        <li class="sent">
                                            <a class="btn" href="<?php echo URL_VIEW.'messages/sentMessages';?>" data-title="Sent">
                                        Sent </a>
                                            <b></b>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-10">
                                    <div class="inbox-header">
                                        <h1 class="pull-left">Message</h1>
                                    </div>
                                    <div class="inbox-content">
                                        <div class="inbox-header inbox-view-header">
                                            <h1 class="pull-left"><a href="javascript:;">
                                                <?php //if(isset($messageDetail->Organization_id)):?>
                                                        Sent
                                                    <?php //endif;?> 

                                                </a>
                                            </h1>
                                        </div>
                                        <div class="inbox-view-info">
                                            <div class="row">
                                                <div class="col-md-12">
                                                            <?php if(!empty($messageDetail->Organization->logo_dir)):?>
                                                            <img src="<?php echo URL.'webroot/files/organization/logo/'.$messageDetail->Organization->logo_dir.'/thumb_'.$messageDetail->Organization->logo;?>" width="20" height="20">
                                                            <?php else:?>

                                                                <img src="<?php echo URL_VIEW;?>admin/layout/img/avatar1_small.jpg" width="20" height="20">
                                                            <?php endif;?>
<!--                                                             <span class="bold"><?php echo $messageDetail->Organization->title;?></span>
 -->                                                            <span>

                                                            &#60;<?php echo $messageDetail->Organization->email;?>&#62; </span>
                                                            to 


                                                            <span class="bold">
                                                            <?php if($messageDetail->Sender->board_id != 0){ echo $messageDetail->Board->title.' Department'; ?>
                                                             
                                                            <?php } else if($messageDetail->Sender->branch_id != 0) {
                                                                echo $messageDetail->Branch->title.' Branch';
                                                                } else if($messageDetail->Sender->status ==2){
                                                                    echo "All Employee";
                                                                    } else {
                                                                        //fal($messageDetail);
                                                                        if(!empty($messageDetail->Receiver)){
                                                                            if(!empty($messageDetail->Receiver[0]->User)){
                                                                            echo $messageDetail->Receiver[0]->User->fname.' '.$messageDetail->Receiver[0]->User->lname;
                                                                        }}
                                                                        } ?>

                                                            </span>
                                                            
                                                            on <?php $date = new DateTime($messageDetail->Sender->date_time);

                                                                echo $date->format('g:i A jS F Y');
                                                            ?>
        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inbox-view"><p><?php echo $messageDetail->Sender->content;?></p></div>
                                        <hr>
                                    </div>
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