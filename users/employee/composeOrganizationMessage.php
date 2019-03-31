

<?php



$loginUserRelationToOther = loginUserRelationToOther($user_id);

foreach ($loginUserRelationToOther->board as $key => $value) {
    $userRelatedBoards[] = $key;
}
// echo "<pre>";
// print_r($userRelatedBoards);

$listBoardId = implode('_',$userRelatedBoards);


    if(isset($_POST['submit'])){


        $url = URL."Messages/add.json";
        $response = \Httpful\Request::put($url)->sendsJson()->body($_POST['data'])->send();

        if($response->body->output == 1){

            echo '<script>

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
                            toastr.success("Message Sent Successfully!!");
                    </script>';

            $loginUserRelationToOther = loginUserRelationToOther($user_id);

                foreach ($loginUserRelationToOther->board as $key => $value) {
                    $userRelatedBoards[] = $key;
                }

        }

        else
        {
            echo '<script>

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
                            toastr.error("Sorry Username does not exists.");
                    </script>';
        }
    }
    
    
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
<link href="<?php echo URL_VIEW;?>styles/autocompleteCss/autocomplete.css" rel="stylesheet" type="text/css"/>

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

<script type="text/javascript" src="<?php echo URL_VIEW;?>js/autocomplete/jquery.autocomplete.min.js"></script>

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
            <!-- END PAGE HEADER-->
            <div class="row inbox">
                <div class="col-md-2">
                    <ul class="inbox-nav margin-bottom-10">
                        <li class="compose-btn">
                            <a href="<?php echo URL_VIEW.'users/employee/composeMessage';?>" data-title="Compose" class="btn green">
                            <i class="fa fa-edit"></i> Compose </a>
                        </li>
                        <li class="inbox">
                            <a href="<?php echo URL_VIEW.'users/employee/inboxMessages';?>" class="btn" data-title="Inbox">
                            Inbox</a>
                            <b></b>
                        </li>
                        <li class="sent">
                            <a class="btn" href="<?php echo URL_VIEW.'users/employee/sentEmployeeMessages';?>" data-title="Sent">
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
                        <h1 class="pull-left">Compose</h1>
                    </div>
                    <div class="inbox-content">

                        <form class="inbox-compose form-horizontal" id="fileupload" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="data[Message][from]" value="<?php echo $user_id;?>">
                            <input type="hidden" name="data[Message][parent_id]" value="0">
                                              <div class="inbox-compose-btn">
                                                <div class="form-group">

                                                    <div class="col-sm-4">
                                                        to:
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                <i class="fa fa-user"></i>
                                                                </span>
                                                                <input id="msgId" type="hidden" name="data[Message][to]" value="">
                                                                <input class="form-control" type="text" placeholder="type username" class="biginput" id="autocomplete" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                              </div>
                                              <div class="inbox-form-group">
                                                <textarea class="inbox-editor inbox-wysihtml5 form-control" name="data[Message][content]" placeholder="Message..." rows="12" required></textarea>
                                              </div>
                                              <div class="inbox-compose-attachment">
                                                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                               
                                                <!-- The table listing the files available for upload/download -->
                                                <table role="presentation" class="table table-striped margin-top-10">
                                                <tbody class="files">
                                                </tbody>
                                                </table>
                                              </div>
                                              <script id="template-upload" type="text/x-tmpl">
                                            {% for (var i=0, file; file=o.files[i]; i++) { %}
                                                <tr class="template-upload fade">
                                                    <td class="name" width="30%"><span>{%=file.name%}</span></td>
                                                    <td class="size" width="40%"><span>{%=o.formatFileSize(file.size)%}</span></td>
                                                    {% if (file.error) { %}
                                                        <td class="error" width="20%" colspan="2"><span class="label label-danger">Error</span> {%=file.error%}</td>
                                                    {% } else if (o.files.valid && !i) { %}
                                                        <td>
                                                            <p class="size">{%=o.formatFileSize(file.size)%}</p>
                                                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                               <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                               </div>
                                                        </td>
                                                    {% } else { %}
                                                        <td colspan="2"></td>
                                                    {% } %}
                                                    <td class="cancel" width="10%" align="right">{% if (!i) { %}
                                                        <button class="btn btn-sm red cancel">
                                                                   <i class="fa fa-ban"></i>
                                                                   <span>Cancel</span>
                                                               </button>
                                                    {% } %}</td>
                                                </tr>
                                            {% } %}
                                              </script>
                                              <!-- The template to display files available for download -->
                                              <script id="template-download" type="text/x-tmpl">
                                            {% for (var i=0, file; file=o.files[i]; i++) { %}
                                                <tr class="template-download fade">
                                                    {% if (file.error) { %}
                                                        <td class="name" width="30%"><span>{%=file.name%}</span></td>
                                                        <td class="size" width="40%"><span>{%=o.formatFileSize(file.size)%}</span></td>
                                                        <td class="error" width="30%" colspan="2"><span class="label label-danger">Error</span> {%=file.error%}</td>
                                                    {% } else { %}
                                                        <td class="name" width="30%">
                                                            <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
                                                        </td>
                                                        <td class="size" width="40%"><span>{%=o.formatFileSize(file.size)%}</span></td>
                                                        <td colspan="2"></td>
                                                    {% } %}
                                                    <td class="delete" width="10%" align="right">
                                                        <button class="btn default btn-sm" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            {% } %}
                                              </script>
                                              <div class="inbox-compose-btn">
                                                <button name="submit" class="btn blue"><i class="fa fa-check"></i>Send</button>
                                                <button type="reset" class="btn">Discard</button>
                                              </div>
                        </form>
                    </div>
                </div>
            </div>



<script type="text/javascript">

$(function()
    {

                var urli = '<?php echo URL."BoardUsers/getBoardRelatedUsers/".$listBoardId."/".$user_id.".json";?>';
                var userList;
                var imageUrl = '<?php echo URL."webroot/files/user/image/";?>';

                $.ajax(
                    {
                        url:urli,
                        type:'post',
                        success:function(response)
                        {
                            // console.log(response);
                            var searchUsers = response.boardUsers;

                            userList = $.map(searchUsers, function(value, index) {
                            return {value:value.User.fname+' '+value.User.lname, data:value.User.id, image:value.User.image, image_dir:value.User.image_dir,
                            boardTitle:value.Board.title};
                                            });

                            $('#autocomplete').autocomplete({
                              lookup: userList,
                              formatResult: function (suggestion, currentValue)
                              {
                                var dataHtml = '<div class="media"><div class="pull-left"><div class="media-object"><img src="'+
                                imageUrl+
                                suggestion['image_dir']+
                                '/thumb2_'+
                                suggestion['image']+
                                '" width="50" height="50"/></div></div><div class="media-body"><h4 class="media-heading text-capitalize">'+suggestion['value']+'</h4><p>'+
                                suggestion['boardTitle']+'</p></div></div>';
                                return dataHtml;
                              },
                              onSelect: function (suggestion) {

                                event.preventDefault();

                                $("#msgId").attr('value',suggestion['data']);
                              }
                            });
                        }

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