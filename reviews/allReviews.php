<?php

if(isset($_GET['page_no'])){
    $startlimit=$_GET['page_no'];
}else{
    $startlimit=1;
}


$url = URL."Reviews/sentAllReviews/".$orgId."/".$startlimit.".json";
$datas = \Httpful\Request::get($url)->send();
$response = $datas->body->sentAllReview->datas;
//fal($response);

$path = URL . "Branches/orgBranches/".$orgId.".json";
$result = \Httpful\request::get($path)->send();
$branchesName = $result->body->branches;
?>
<div class="page-head">
    <div class="container">
        <div class="page-title">
    		<h1>Reviews<small> All.</small></h1>
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
    		</li>
        </ul>
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart theme-font hide"></i>
                    <span class="caption-subject theme-font bold uppercase">All Reviews</span>
                    <!-- <span class="caption-helper">16 pending</span> -->
                </div>
                <div class="actions pull-right">
                                    <form id="searchForm" class="form-inline" role="form" action="" method="post">
                                        <span style="color:grey">Filter Employee :</span>
                                        
                                        <div class="form-group">
                                            <select name="branchId" class="form-control input-sm" id="select-branch">
                                                <option class="default" selected="" value="0">--All Branch--</option>
                                                <?php foreach($branchesName as $b): ?>
                                                    <option value="<?php echo $b->Branch->id;?>"><?php echo $b->Branch->title; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <select name="departmentId" id="selectDepartment" class="form-control input-sm" >
                                            <option class="default" selected="" value="0">--All Department--</option>

                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <input id="username" name="username" value="" type="text" class="form-control input-sm" placeholder="Enter Employee Name" required="">
                                        </div>
                                    </form>
                                </div>
            </div>
            <div class="portlet-body">
            <div id="panel-second" class="panel-group accordion">

            </div>
                <div id="accordion3" class="panel-group accordion">
                    <?php $count=1;?>
                        <?php if(isset($response) && !empty($response)):?>

                            <?php foreach($response as $res){
                            ?>
                            	    <div class="panel panel-default">
                                            <div class="panel-heading">
                                        	    <h4 class="panel-title">
                                                <a aria-expanded="false" href="#collapse_3_<?php echo $count;?>" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">

                                                    <?php if($count==1){ ?>
                                                    <div class="row" style="font-size: 1.5em;"><div class="col-md-1">#</div><div class="col-md-2">User</div><div class="col-md-2">Department</div><div class="col-md-2">Type</div><div class="col-md-2">Date</div><div class="col-md-2">Status</div><div class="col-md-1"></div></div>
                                                    <hr />
                                                    <?php } ?>

                                                    <div class="row">
                                                        <div class="col-md-1"><?php echo $count;?></div>
                                                        <div class="col-md-2">
                                                       
                                                         <?php
                                                            $userimage = URL."webroot/files/user/image/".$res->User->image_dir.'/thumb2_'.$res->User->image;
                                                            //fal($userimage);
                                                            $image = $res->User->image;
                                                            $gender = $res->User->gender;
                                        
                                                          $user_image = imageGenerate($userimage,$image,$gender);
                                                      ?>
                                                      <?php $status = $res->Review->status; ?>
                                                      <img src="<?php echo $user_image; ?>" alt="image not found" style="width: 40px; height: 40px;"/><?php echo ucwords($res->User->fname." ".$res->User->lname);?>
                                                        </div>
                                                        <div class="col-md-2"><?php echo $res->Board->title;?></div>
                                                        <div class="col-md-2"><?php echo $res->Review->reviewtype;?></div>
                                                        <div class="col-md-2"><?php echo getStandardDateTime($res->Review->reviewdate);?></div>
                                                        <div class="col-md-2">
                                                        <?php if($status == 1){ ?>
                                                        <span class="label label-sm label-success"><i class="fa fa-check-square"></i> Accepted</span>
                                                        <?php } else if($status == 2) { ?>
                                                        <span class="label label-sm label-warning"><i class="fa fa-square"></i> Seen</span>

                                                        <?php } else { ?>
                                                        <span class="label label-sm label-danger"><i class="fa fa-minus-square"></i> Not Seen</span>

                                                        <?php } ?>
                                                        </div>
                                                        <div class="col-md-1"><button class="btn btn-default">+/-</button></div>        
                                                    </div>
                                                </a>
                                        	   </h4>
                                        	</div>
                                        	<div class="panel-collapse collapse" id="collapse_3_<?php echo $count;?>" aria-expanded="false">
                                        	    <div class="panel-body">
                                                    <dl>
                                                        <dt>Details : </dt>
                                                        <dd><ul class="chats"><li class="in"><div class='message'><span class='arrow'></span><span class='body'><?php echo $res->Review->details;?></span></div></li></ul></dd>
                                                    </dl>
                                                </div>
                                    	   </div>
                            	       </div>
                            <?php
                            $count++;
                        } ?>
                        <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate" style="float: none;">
                            <?php
                            $page = $datas->body->sentAllReview->pages;
                            $limit1=$datas->body->sentAllReview->limit;
                            $count1=$datas->body->sentAllReview->counts;
                            $max=ceil($count1/$limit1);

                            if($max>0){
                            ?>
                            <div>Showing Page <?=$page;?> of <?=$max;?></div>
                                <ul class="pagination" style="visibility: visible;">
                                    <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                    <?php if($page<=1){ ?>
                                        <a title="First" href="javascript:;"><i class="fa fa-angle-double-left"></i></a>
                                    <?php }else{ ?>
                                        <a title="First" href="?page_no=1"><i class="fa fa-angle-double-left"></i></a>
                                    <?php } ?>
                                    </li>
                                    <li class="prev <?php if($page<=1){ echo 'disabled';}?>">
                                    <?php if($page<=1){ ?>
                                    <a title="Prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                                    <?php }else{ ?>
                                        <a title="Prev" href="?page_no=<?php echo ($page-1); ?>"><i class="fa fa-angle-left"></i></a>
                                    <?php } ?>
                                    </li>
                                    
                                    <?php if($max<=5){
                                        for($i=1;$i<=$max;$i++){ ?>
                                        <li>
                                           <a title="<?=$i;?>" href="?page_no=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                        </li>
                                     <?php }}else{
                                        if(($page-2)>=1 && ($page+2)<=$max){
                                            for($i=($page-2);$i<=($page+2);$i++){ ?>
                                            <li>
                                               <a title="<?=$i;?>" href="?page_no=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                      <?php  }}elseif(($page-2)<1){
                                        for($i=1;$i<=5;$i++){ ?>
                                            <li>
                                               <a title="<?=$i;?>" href="?page_no=<?=$i?>" class="btn <?php if($page==$i){echo "blue";}?>"><?=$i;?></a>
                                            </li>
                                     <?php }}elseif(($page+2)>$max){
                                        for ($i=($max-4);$i<=$max;$i++){ ?>
                                            <li>
                                               <a title="<?=$i;?>" class="btn <?php if($page==$i){echo "blue";}?>" href="?page_no=<?=$i?>"><?=$i;?></a>
                                            </li>
                                    <?php }}} ?>
                                    
                                    <li class="next <?php if($page>=$max){echo 'disabled';}?>">
                                    <?php if($page>=$max){ ?>
                                    <a href="javascript:;" title="Next"><i class="fa fa-angle-right"></i></a>
                                    <?php }else{ ?>
                                    <a title="Next" href="?page_no=<?php echo ($page+1);?>"><i class="fa fa-angle-right"></i></a>
                                    <?php } ?></li>
                                    <li class="next <?php if($max==0 || $max==1){ echo "disabled"; }?>">
                                    <?php if($max==0 || $max==1){ ?>
                                    <a title="Last" href="javascript:;" ><i class="fa fa-angle-double-right"></i></a>
                                    <?php }else{ ?>
                                    <a title="Last" href="?page_no=<?php echo $max;?>"><i class="fa fa-angle-double-right"></i></a>
                                    <?php } ?></li>
                                </ul>
                            <?php } ?>
                        </div>
                    <?php else:?>
                        <div>There are no Reviews.</div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
    //$("#accordion3").hide();
    var timer;
    var orgId = "<?php echo $orgId;?>";
    function ImageExist(url)
      {
        var img = new Image();
        img.src = url;
        return img.height != 0;
      }

    
    $("#select-branch").on('change',function(){      
        var e = $(this);
        var username = $('#username').val();
        if(username == ''){
            username = '0';
        }
        var departmentId = '0';
        var branchId = e.find("option:selected").val();
        var data =  getBoardList(branchId);
        var html = ""; 
        html += '<option selected value="0">--All Department--</option>';
        $.each(data,function(key,val){
            var departmentId = val.Board.id;
            var title = val.Board.title;
            html += '<option value="'+departmentId+'">'+title+'</option>';
        });
        $("#selectDepartment").html("").append(html);
        filterReview(orgId,username,branchId,departmentId); 
    });


    $("#selectDepartment").on('change',function(){

        var e = $(this);
        var username = $('#username').val();
        if(username == ''){
            username = '0';
        }

        var branchId = $("#select-branch option:selected").val();
        var departmentId = e.find("option:selected").val();
        filterReview(orgId,username,branchId,departmentId);           

    });
   
    //var branchId = 0;


    $('#username').on('keyup', function(e) {
        var branchId = $("#select-branch option:selected").val();
        var departmentId = $("#selectDepartment option:selected").val();
        
        var username = $('#username').val();
        if(username == ''){
            username='0';    
        }
        clearTimeout(timer);
        timer = setTimeout(function (event) {
            filterReview(orgId,username,branchId,departmentId);           
        }, 600);

    });

    function filterReview(orgId,username,branchId,departmentId)
    {   

        var html ="";
        var url = '<?php echo URL ;?>Reviews/filterReview/'+orgId+'/'+username+'/'+branchId+'/'+departmentId+'.json';
    if(username != '0' || branchId != '0' || departmentId != '0'){
        $.ajax({
            url:url,
            type:'post',
            datatype:'jsonp',
            success:function(response){

                if(response.length == 0){
                    html += '<div>There are no Reviews.</div>';
                }

                    $.each(response,function(key,val){
                        var reviewStatus = val.Review.status;                        if(ImageExist(val['User']['imagepath']) && val['User']['imagepath'] != ""){
                          var imgurl = val['User']['imagepath'];
                        }else{
                          if(val['User']['gender']== 0){
                            var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/defaultuser.png";
                          }else{
                            var imgurl = "<?php echo URL;?>"+"webroot/img/user_image/femaleadmin.png";
                          }
                        }
                        key++;
                        
                        html += '<div class="panel panel-default">';
                        html += '<div class="panel-heading"><h4 class="panel-title"><a aria-expanded="false" href="#collapse_3_'+key+'" data-parent="#accordion3" data-toggle="collapse" class="accordion-toggle collapsed">';
                        if(key == 1){
                            html += '<div class="row" style="font-size: 1.5em;"><div class="col-md-1">#</div><div class="col-md-2">User</div><div class="col-md-2">Department</div><div class="col-md-2">Type</div><div class="col-md-2">Date</div><div class="col-md-2">Status</div><div class="col-md-1"></div></div>';
                            html += '<hr />';
                            }
                            html += '<div class="row">';
                            html += '<div class="col-md-1">'+key+'</div>';
                            html += '<div class="col-md-2"><img src="'+imgurl+'" alt="image not found" style="width: 40px; height: 40px;"/>'+' '+val.User.fname+' '+val.User.lname+'</div>';
                            html += '<div class="col-md-2">'+val.Board.title+'</div>';
                            html += '<div class="col-md-2">'+val.Review.reviewtype+'</div>';
                            html += '<div class="col-md-2">'+val.Review.reviewdate+'</div>';
                            html += '<div class="col-md-2">';
                            if(reviewStatus == 1){
                            html += '<span class="label label-sm label-success"><i class="fa fa-check-square"></i> Accepted</span>';
                            } else if(reviewStatus == 2) { 
                            
                            html += '<span class="label label-sm label-warning"><i class="fa fa-square"></i> Seen</span>';
                            
                            } else {
                            
                            html += '<span class="label label-sm label-danger"><i class="fa fa-minus-square"></i> Not Seen</span>';
                            
                            }
                            html += '</div>';
                            html += '<div class="col-md-1"><button class="btn btn-default">+/-</button></div>';
                            html += '</div></a></h4></div>';
                            html += '<div class="panel-collapse collapse" id="collapse_3_'+key+'" aria-expanded="false"><div class="panel-body"><dl><dt>Details : </dt><dd><ul class="chats"><li class="in"><div class="message"><span class="arrow"></span><span class="body">'+val.Review.details+'</span></div></li></ul></dd></dl></div></div>';
                            html += '</div>';
                    });
                       $("#panel-second").html(html);

                    //alert("true");
                        $("#accordion3").hide();
                        $("#panel-second").show();
                        
                }
                 
            //console.log(html);

        });
    } else {
            $("#accordion3").show();
            $("#panel-second").hide();
        }
}
   function getBoardList(branchId)
    {
        var boards;
        var orgId = '<?php echo $orgId;?>';
        var url = '<?php echo URL;?>Boards/getBoardListOfBranch/'+branchId+'.json';
        $.ajax(
        {
            url:url,
            type:'post',
            async:false,
            datatype:'jsonp',
            success:function(res)
            {
                boards = res.boardList;
            }
        })
                return boards;
    }
});
</script>    