

<?php 
$inboxMessage_link = URL_VIEW."users/employee/organizationMessage";

$orgListMessage = getOrgListReceiveMessage($user_id);

$loginUserRelationToOther = loginUserRelationToOther($user_id);

foreach ($loginUserRelationToOther->board as $key => $value) {
    $userRelatedBoards[] = $key;
}
// echo "<pre>";
// print_r($userRelatedBoards);


foreach($orgListMessage->OrganizationUser as $orgListMessages){
    $orgList[$orgListMessages->Organization->id] = $orgListMessages->Organization->title;
    $orgMessages[$orgListMessages->Organization->title] = $orgListMessages->Organization->Organizationmessage;
    
}


    if(isset($_POST['submit'])){


        $url = URL."Organizationmessages/add.json";
        $response = \Httpful\Request::put($url)                  // Build a PUT request...
            ->sendsJson()                               // tell it we're sending (Content-Type) JSON...
            //->authenticateWith('username', 'password')  // authenticate with basic auth...
            ->body($_POST['data'])             // attach a body/payload...
    ->send();

        if($response->body->output == 1){
            ?>
            <script>
            $(document).ready(function()
            {
                window.location.href = '<?php echo $inboxMessage_link;?>';
                });
            </script>
            
            <?php   
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

<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>global/plugins/typeahead/typeahead.css">

<script src="<?php echo URL_VIEW;?>admin/pages/scripts/components-form-tools.js"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/typeahead/typeahead.bundle.min.js" type="text/javascript"></script>

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

 <h3 class="page-title">
            Messages <small></small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="index.html">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Pages</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Inbox</a>
                    </li>
                </ul>
                <div class="page-toolbar">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                        Actions <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li>
                                <a href="#">Action</a>
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
                        </ul>
                    </div>
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <div class="row inbox">
                <div class="col-md-2">
                    <ul class="inbox-nav margin-bottom-10">
                        <li class="compose-btn">
                            <a href="<?php echo URL_VIEW.'users/employee/organizationMessage';?>" data-title="Compose" class="btn green">
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
                        <form class="form-inline pull-right" action="index.html">
                            <div class="input-group input-medium">
                                <input type="text" class="form-control" placeholder="Password">
                                <span class="input-group-btn">
                                <button type="submit" class="btn green"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="inbox-content">

                        <form class="inbox-compose form-horizontal" id="fileupload" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="data[Organizationmessage][user_id]" value="<?php echo $user_id;?>">
                            <input type="hidden" name="data[Organizationmessage][parent_id]" value="0">
                                              <div class="inbox-compose-btn">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Custom Template</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                            <i class="fa fa-cogs"></i>
                                                            </span>
                                                            <input type="text" id="typeahead_example_modal_3" name="typeahead_example_modal_3" class="form-control"/>
                                                        </div>
                                                        <p class="help-block">
                                                             Uses a precompiled template to customize look of suggestion.</code>
                                                        </p>
                                                    </div>
                                                </div>
                                              </div>
                                              <div class="inbox-form-group">
                                                <textarea class="inbox-editor inbox-wysihtml5 form-control" name="data[Organizationmessage][content]" placeholder="Message..." rows="12"></textarea>
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
                                                <button class="btn">Discard</button>
                                                <button class="btn">Draft</button>
                                              </div>
                        </form>
                    </div>
                </div>
            </div>



<script type="text/javascript">

$(function()
    {

                // var urli = '<?php echo URL."OrganizationUsers/getAllOrganizationUsers.json";?>';
                // var userList;

                // $.ajax(
                //     {
                //         url:urli,
                //         type:'post',
                //         success:function(response)
                //         {
                //             var searchUsers = response.organizationUsers;

                //             userList = $.map(searchUsers, function(value, index) {
                //                                 return [value.User.fname+' '+value.User.lname];
                //                             });

                //             $('#autocomplete').autocomplete({
                //               lookup: userList,
                //               onSelect: function (suggestion) {
                //               // some function here
                //               }
                //             });
                //         }

                //     });
        
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
                ComponentsFormTools.init();
    });

</script>