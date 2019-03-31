<link rel="stylesheet" type="text/css" href="<?=URL_VIEW;?>global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">

<?php
    
    if (isset($_POST['submit'])){ 
        $url = URL . "Reviews/saveReview.json";
        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();    
        ?>
        <script>
            toastr.info("Review successfully sent to employee.");
        </script>    
        <?php } ?>

        <?php
        $userDetail = URL."Users/myProfile/".@$_GET['user_id'].".json";
        $user = \Httpful\Request::get($userDetail)->send();
        if(isset($user->body->userDetail->User->fname)){
            $fname = $user->body->userDetail->User->fname;
        }else{
            $fname = "";
        }
        if(isset($user->body->userDetail->User->lname)){
            $lname = $user->body->userDetail->User->lname;
        }else{
            $lname = "";
        }

        $userId = $_GET['user_id'];
        $url1 = URL . "BranchUsers/getUserRelatedBranches/".$userId.".json";
        $data1 = \Httpful\Request::get($url1)->send();
        $branch = $data1->body->list; 

?>

<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>Reviews <small> New.</small></h1>
		</div>  
    </div>
</div>

<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
            <li>
    			<i class="fa fa-home fa-2x"></i>
    			<a href="<?php echo URL_VIew; ?>">Home</a>
    			<i class="fa fa-circle"></i>
    		</li>
    		<li>
    			<a href="<?=URL_VIEW."reviews/allReviews";?>">Reviews</a>
                <i class="fa fa-circle"></i>
    		</li>
            <li>
                <a href="javascript:;">New Reviews</a>
            </li>
        </ul>
        <div class="portlet light">
			<div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart theme-font hide"></i>
                    <span class="caption-subject theme-font bold uppercase">New Review | <?=ucwords($fname." ".$lname);?></span>
                    <!-- <span class="caption-helper hide">weekly stats...</span> -->
                </div>
			</div>
			<div class="portlet-body">
				<form class="form-horizontal" id="form_sample" action="" method="post">
					<div class="form-body">
						<div class="alert alert-danger display-hide">
							<button data-close="alert" class="close"></button>
							You have some form errors. Please check below.
						</div>
						<div class="alert alert-success display-hide">
							<button data-close="alert" class="close"></button>
							Your form validation is successful!
						</div>
                        
                        
                        <input type="hidden" name="data[Review][user_id]" class="form-control" value="<?php echo $_GET['user_id']; ?>" />
                        <input type="hidden" name="data[Review][reviewby]" class="form-control" value="<?php echo $user_id; ?>" />
                        <input type="hidden" name="data[Review][organization_id]" id="orgnid" class="form-control" value="<?php echo $orgId; ?>" />
                        <input type="hidden" name="data[Review][reviewtype]" class="form-control" value="<?php echo $_GET['rev_typ']; ?>" />
                        <div class="col-md-12">
                            <div class="form-group">
    							<label class="control-label">Branch *
                                </label>

                                
                                <select name="data[Review][branch_id]" id="branchid" class="form-control" required>
                                    <?php if(!empty($branch)){ ?>
                                        <?php foreach($branch as $b): ?>
                                            <option value="<?php echo $b->Branch->id; ?>"><?php echo $b->Branch->title; ?></option>
                                        <?php endforeach; ?>    
                                    <?php } else {?>
                                            <option selected disabled value="0">User has not been added to any branches.</option> 
                                    <?php } ?>   
                                </select>
    						</div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
    							<label class="control-label">Department
    							</label>
                                <select name="data[Review][board_id]" id="boardid" class="form-control" required>
                                </select>
    						</div>
                        </div>
                        <div class="col-md-12">
    						<div class="form-group">
    							<label class="control-label">Details <span class="required" aria-required="true">
    							* </span>
    							</label>
                                <textarea name="data[Review][details]" class="data-wysihtml5" rows="10" required></textarea>
    						</div>
                        </div>
                    </div>
					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<button class="btn green" type="submit" name="submit">Submit</button>
								<a class="btn default" type="button" href="<?php echo URL_VIEW."organizationUsers/listOrganizationEmployees?org_id=".$orgId;?>">Cancel
                                </a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
    </div>
</div>
<span id="print-this" style="display:none;"></span>

<script src="<?=URL_VIEW;?>global/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript"></script>
<script src="<?=URL_VIEW;?>global/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
<link href="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
<script src="<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
<script type="text/javascript">



var initWysihtml5 = function () {

   var myCustomTemplates = {
      html : function(locale) {
        // return "<li>" +
        //        "<div class='btn-group'>" +
        //        "<a class='btn-default'><i class='glyphicon glyphicon-print'></i></a>" +
        //        "</div>" +
        //        "</li>";
      return '<a class="btn default" title="Print" unselectable="on"><i class="glyphicon glyphicon-print"></i></a>';
      }
    }
 
    $('.data-wysihtml5').wysihtml5({
        "stylesheets": ["<?php echo URL_VIEW;?>global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"],
        customTemplates: myCustomTemplates,
        "image":false,
        "link":false,
        "html":false
        });
    }
initWysihtml5();
</script>
<script>
    var handleValidation2 = function() {

    var form2 = $('#form_sample');
    var error2 = $('.alert-danger', form2);
    var success2 = $('.alert-success', form2);

    form2.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",  // validate all fields including form hidden input
        rules: {
            details: {
                minlength: 10,
                required: true
            }
        },

        invalidHandler: function (event, validator) { //display error alert on form submit              
            success2.hide();
            error2.show();
            Metronic.scrollTo(error2, -200);
        },

        errorPlacement: function (error, element) { // render error placement for each input type
            var icon = $(element).parent('.input-icon').children('i');
            icon.removeClass('fa-check').addClass("fa-warning");  
            icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
        },

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
            },

        unhighlight: function (element) { // revert the change done by hightlight

        },

        success: function (label, element) {
            var icon = $(element).parent('.input-icon').children('i');
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
            icon.removeClass("fa-warning").addClass("fa-check");
        },

        submitHandler: function (form) {
            success2.show();
            error2.hide();
            form[0].submit(); // submit the form
        }
    });
}
</script>
<script>
        $(document).ready(function () {
            var printBtn = '<li><div class="btn-group"><a class="btn default printer" title="Print"><i class="fa fa-print"></i></a></div></li>';
            $(".wysihtml5-toolbar").append(printBtn);

            $('#form_sample').submit(function() {
                var branchId = $("#branchid option:selected").val();
            
                var boardId = $("#boardid option:selected").val();
                if(branchId == 0){
                    toastr.info('Branch not selected');
                    $("#branchid").focus();
                    return false;
                }

                if(boardId == 0){
                    toastr.info("Department not selected");
                    $("#boardid").focus();
                    return false;
                }

            });

            var userId = "<?php echo $userId;?>";
            function getbranchlist(){
                var orgnid=$("#orgnid").val();
                var branch_id = <?php echo (isset($_GET['branch_id'])?$_GET['branch_id']:0);?>;
                $.ajax({
                    url: "<?php echo URL_VIEW."process.php";?>",
                    async:false,
                    data: "action=getOrgProfile&orgid="+orgnid,
                    type: "post",
                    success:function(data){
                        var data1 = "";
                        var allbr=JSON.parse(data);            
                        $.each(allbr.Branch , function(k,obj){
                            if(obj.id == branch_id){
                                data1 += "<option value=" + obj.id + " selected>" + obj.title + "</option>";
                            }else{
                                data1 += "<option value=" + obj.id + ">" + obj.title + "</option>";
                            }
                        });

                        $("#branchid").html(data1);
                    }
                });

            }
            function getboardlist(){
                var branchId = $("#branchid option:selected").val();
                var url = "<?php echo URL;?>BoardUsers/findBoardOfUser/"+userId+'/'+branchId+'.json';
                $.ajax({
                    url: url,
                    async:false,
                    datatype: "jsonp",
                    type: "post",
                    success:function(data){
                        //console.log(data);
                        var data1 = ""; 
                        if(data.length != 0){
                            if(data.board_list.length != 0){               
                                $.each(data.board_list, function(k,obj){
                                    data1 += "<option value=" + obj.board_id + ">" + obj.board_title + "</option>";
                                });
                            } else {
                                data1 = '<option value="0">No Departments</option>';
                            }
                        } else {
                            data1 = '<option value="0">No Departments</option>';
                        } 
                           

                        $("#boardid").html(data1);
                    }
                });
                
                
            }
            //getbranchlist();
            setTimeout(function(){}, 2000);
            getboardlist();
            $("#branchid").on('change',function(){
                getboardlist();
            });
        });

$('.printer').live('click',function(){
    var details = $(".data-wysihtml5").val();
    //priC.show();
    if(details != ''){
        $("#print-this").html(details);
        PrintElem('#print-this'); 
    }

});
</script>

<script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open();
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>