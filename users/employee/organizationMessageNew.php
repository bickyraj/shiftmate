

<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo URL_VIEW;?>admin/pages/css/inbox.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
   

            <div class="row inbox">
                <div class="col-md-2">
                    <ul class="inbox-nav margin-bottom-10">
                        <li class="compose-btn">
                            <a href="javascript:;" data-title="Compose" class="btn green">
                            <i class="fa fa-edit"></i> Compose </a>
                        </li>
                        <li class="inbox active">
                            <a href="javascript:;" class="btn" data-title="Inbox">
                            Inbox(3) </a>
                            <b></b>
                        </li>
                        <li class="sent">
                            <a class="btn" href="javascript:;" data-title="Sent">
                            Sent </a>
                            <b></b>
                        </li>
                        <li class="draft">
                            <a class="btn" href="javascript:;" data-title="Draft">
                            Draft </a>
                            <b></b>
                        </li>
                        <li class="trash">
                            <a class="btn" href="javascript:;" data-title="Trash">
                            Trash </a>
                            <b></b>
                        </li>
                    </ul>
                </div>
                <div class="col-md-10">
                    <div class="inbox-header">
                        <h1 class="pull-left">Inbox</h1>
                        <form class="form-inline pull-right" action="index.html">
                            <div class="input-group input-medium">
                                <input type="text" class="form-control" placeholder="Password">
                                <span class="input-group-btn">
                                <button type="submit" class="btn green"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="inbox-loading">
                         Loading...
                    </div>
                    <div class="inbox-content">
                    </div>
                </div>
            </div>
      



<!-- END: Page level plugins -->
<script src="<?php //cho URL_VIEW;?>admin/pages/scripts/inbox.js" type="text/javascript"></script>

<script>
// jQuery(document).ready(function() {
//    Inbox.init();
// });
</script>
