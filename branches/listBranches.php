

<link href="<?php echo URL_VIEW;?>styles/autocompleteCss/autocomplete.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/autocomplete/jquery.autocomplete.min.js"></script>
<?php
// $orgId = $_GET['org_id'];
//print_r($userId);

//$page = $_GET['page'];
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}
// if(isset($_POST["add"]))
// {
//   //   echo "<pre>";
//   //  print_r($_POST['data']);
//   // die();
//     $url = URL."Branches/createBranches/".$orgId."/".$userId.".json";
//     $response = \Httpful\Request::post($url)    
//     ->sendsJson()
//     ->body($_POST['data']) 
//     ->send(); 

//     // echo "<pre>";
//     // print_r($response);
//     // die();

//     if($response->body->output->status == '1')
//     {
        
//         echo("<script>location.href = '".URL_VIEW."branches/listBranches?org_id=".$orgId."';</script>");
//         // echo("<script>location.href = '".URL_VIEW."branches/listBranches';</script>");

//         $_SESSION['success']="test";
//     }
   
// }

//get userId using org Id.
$url = URL . "Organizations/getUserIdFromOrgId/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$userId = $data->body->userId;


//Get list of Branches
$url = URL."Branches/listBranches/".$orgId."/".$page.".json";
$brancheList = \Httpful\Request::get($url)->send();
//print_r($brancheList);
$branches = $brancheList->body->branches;
 // echo "<pre>";
// print_r($brancheList);

$totalPage = $brancheList->body->output->pageCount;
$currentPage = $brancheList->body->output->currentPage;
/*
By rabi
*/
$url = URL."Organizations/userInfoInBranch/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$userinfo = $data->body->organizationUserInfo;
// echo "<pre>";
// print_r($userinfo);
// die();

$url = URL."Countries/getCountryList.json";
$countryList = \Httpful\Request::get($url)->send();
$countries = $countryList->body->countries;

$url = URL."Cities/cityList.json";
$cityList = \Httpful\Request::get($url)->send();
$cities = $cityList->body->cities;
 
 $url = URL . "OrganizationUsers/getOrganizationUsers/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$organizationUsers = $data->body->organizationUsers;



?>

<!-- End of Save Success Notification -->
<style>
.caption > a {
    color: #8c7878 !important;
}
.caption > a:hover {
    text-decoration: underline;
}
.branch-list span{
    color:#777;
}
</style>


<!-- Edit-->
<div class="modal fade" id="portlet-config_1_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Create Branch</h4>
            </div>
            <div class="row">

                <div class="modal-body">
                    <form action="" id="BoardAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                    </div>
                    <div class="form-body">     
                        <div class="form-group">
                            <label class="control-label col-md-4">Branch Manager <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                 <select class="form-control" name="data[Branch][user_id]" id="BoardUserId" >
                                    <option value="0">Assign later</option>
                                    <?php foreach($organizationUsers as $organizationUser):?>
                                    <option value="<?php echo $organizationUser->User->id;?>"><?php echo $organizationUser->User->fname.' '.$organizationUser->User->lname;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Branch Name <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="data[Branch][title]"required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Contact Number <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="number" min="0" name="data[Branch][phone]"required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Fax<span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="number" min="0" name="data[Branch][fax]"required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Email <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="email" name="data[Branch][email]" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Address <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" id="BranchAddress" name="data[Branch][address]" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Country <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                               <select name="data[Branch][country_id]" id="UserCountryId" class="form-control" required />
                                    <option value="">Choose Country</option>
                                  <?php foreach($countries as $key=>$country):?>
                                        <option value="<?php echo $key;?>"><?php echo $country;?></option>
                                    <?php endforeach;?>
                                </select>
                               
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-4">City <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-7">
                                     <select name="data[Branch][city_id]" id="UserCityId" class="form-control" required />
                                         <option value="">Select City</option>
                                       
                                    </select>
                                </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-7">
                                <input class="form-control" type="hidden"  id="BranchLat" name="data[Branch][lat]" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-7">
                                <input class="form-control" type="hidden" id="BranchLong" name="data[Branch][long]" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <input  type="submit" name="add" value="Submit" class="btn green"  />
                                   <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                                    <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
                                    <input type="reset" class="clear btn default" value="Clear">
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-head">
    <div class="container">
        <div class="page-title">
			<h1>Branch List <small>View Branch List</small></h1>
		</div>  
    </div>
</div>
<div class="page-content">
    <div class="container">
        <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?=URL_VIEW;?>">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="<?=URL_VIEW."branches/listBranches";?>">Branch Lists</a>
                    </li>
        </ul>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject theme-font bold uppercase">Branch List</span>
                            <!-- <span class="caption-helper">16 pending</span> -->
                        </div>
                        <div class="btn-group pull-right">
                             <a class="btn btn-fit-height green dropdown-toggle" href="#portlet-config_1_2" class="news-block-btn" data-toggle="modal" class="config" id="test"><i class="fa fa-plus"></i> Add New Branch 
                             </a>
                        </div>
                    </div>
                    
                    <div class="portlet-body">
                        <div class="row" id="portletDisplay">
                            <?php 
                                if($branches){
                                foreach($branches as $branch):
                            ?>
                            <div class="col-md-6 col-sm-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <!-- <i class="fa fa-cogs"></i> -->
                                            <a href="viewBranch?branch_id=<?php echo $branch->Branch->id;?>"><?php echo $branch->Branch->title;?>  </a>
                                        </div>
                                       
                                        <div class="actions">
                                        <a href="editBranch?branch_id=<?php echo $branch->Branch->id.'&org_id='.$orgId;?>" class="btn btn-default btn-sm">
                                        <i class="fa fa-pencil"></i> Edit </a>
                                        <a href="viewBranch?branch_id=<?php echo $branch->Branch->id;?>" class="btn btn-default btn-sm">
                                        <i class="fa fa-street-view"></i> View </a>

                                        <!-- <div class="btn-group" style="padding-top:0px;">
                                            <button type="button" class="btn btn-sm btn-default" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                                            Actions <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right" role="menu">
                                                <li>
                                                    <a href="viewBranch?branch_id=<?php echo $branch->Branch->id;?>"><i class="fa fa-eye"></i> View Detail</a>
                                                </li>
                                                <li>
                                                    <a href="editBranch?branch_id=<?php echo $branch->Branch->id.'&org_id='.$orgId;?>"><i class="fa fa-pencil"></i> Edit Branch</a>
                                                </li>
                                            </ul>
                                        </div> -->
                                        </div>
                                    </div>
                                    <div class="portlet-body branch-list" style="height:210px;">
                                        <div class="scroller" style="height: 200x;">
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                     Branch Name:
                                                </div>
                                                <div class="col-md-7 value">
                                                     <span><?php echo $branch->Branch->title;?></span>              
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                     Organization:
                                                </div>
                                                <div class="col-md-7 value">
                                                    <span><?php echo $branch->Organization->title;?></span>                   
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                     Email:
                                                </div>
                                                <div class="col-md-7 value">
                                                     <span><?php echo $branch->Branch->email;?></span>                 
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                     Address:
                                                </div>
                                                <div class="col-md-7 value">
                                                     <span><?php echo $branch->Branch->address;?></span>                
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                     City:
                                                </div>
                                                <div class="col-md-7 value">
                                                     <span><?php echo $branch->City->title;?></span>                   
                                                </div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name">
                                                     Country:
                                                </div>
                                                <div class="col-md-7 value">
                                                    <span><?php echo $branch->Country->title;?></span>                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                endforeach;
                                }
                                else
                                {
                             ?>
                             <div class="container">
                                 <p class="noBranch">No branch added till now.</p> 
                            </div>
                            <?php
                                }
                            ?>
                        </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#UserCountryId').on('change',function(){
       
        var data;
        var country = $(this).val();
        
         $.ajax({
                 url: "<?php echo URL_VIEW."process.php";?>",
                data: "action=getCountryCity&countryID="+country,
                type: "post",
                success:function(response){
                    data = "<option value=''>Select City</option>";
                    console.log(response);
                    var cities = JSON.parse(response);
                        console.log(cities);
                     $.each(cities, function(key,obj){
                               data+= "<option value=" + key + ">" + obj + "</option>";
                           });
                           $("#UserCityId").html(data);
                            if(jQuery.isEmptyObject(cities))
                            {
                                
                                
                                $("#UserCityId").html(data);
                            }
                }                  
            });
     });
    
</script>
 <script type="text/javascript">
 $(function(){
    $("#BoardAddForm").on('submit',function(event)
    {   
        //return false;
        //console.log(e);
        event.preventDefault();
        var data = $(this).serialize();
        var orgId = '<?php echo  $orgId; ?>';
        var userId = '<?php echo  $userId; ?>';
        var e = $(this);
        $.ajax({
            url : '<?php echo URL."Branches/createBranch/"."'+orgId+'"."/"."'+userId+'".".json"; ?>',
            type : "post",
            data : data,
            datatype : "jsonp",
            success:function(response)
            {   
                var status = response.output.status;
                console.log(status);

                if(status == 1){
                    var portlet = "";
                    $.each(response.output.branch,function(i,v){
                        portlet = '<div class="col-md-6 col-sm-12"><div class="portlet light bordered" style="max-height: 262px;min-height: 242px;overflow-x: hidden;overflow-y: scroll;"><div class="portlet-title"><div class="caption"><i class="fa fa-cogs"></i><a href="viewBranch?branch_id='+v.Branch.id+'">'+v.Branch.title+'</a></div><div class="actions"><a href="editBranch?branch_id='+v.Branch.id+'&org_id='+orgId+'" class="btn btn-default btn-sm"> <i class="fa fa-pencil"></i> Edit </a><a href="viewBranch?branch_id='+v.Branch.id+'" class="btn btn-default btn-sm"><i class="fa fa-street-view"></i> View </a></div></div> <div class="portlet-body"><div class="row static-info"><div class="col-md-5 name">Branch Name:</div><div class="col-md-7 value">'+v.Branch.title+'</div></div><div class="row static-info"><div class="col-md-5 name">Organization:</div><div class="col-md-7 value">'+v.Organization.title+'</div></div><div class="row static-info"><div class="col-md-5 name">Email:</div><div class="col-md-7 value">'+v.Branch.email+'</div></div><div class="row static-info"><div class="col-md-5 name">Address:</div><div class="col-md-7 value">'+v.Branch.address+'</div></div><div class="row static-info"><div class="col-md-5 name">City:</div><div class="col-md-7 value">'+v.City.title+'</div></div><div class="row static-info"><div class="col-md-5 name">Country:</div><div class="col-md-7 value">'+v.Country.title+'</div></div></div></div></div>';
                    });
                    $(".noBranch").remove();
                    $("#portletDisplay").prepend(portlet);
                    toastr.success('Branch Added Successfully');
                } else if(status == 2){
                    toastr.info('Branch already exist.Please try again.');
                } else {
                    toastr.info('Something went wrong.Please Try again.');
                }
                e.find('.clear').click();
                e.closest('.modal-dialog').find('.close').click();
            }
        });
    });
});    


</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB63hwaEjR7qPH8O8QrvpFMN12Eu5VijLA&libraries=places"> </script>
<script type="text/javascript">
     function initialize() {
         var searchbox = new google.maps.places.SearchBox(document.getElementById("BranchAddress"));
         google.maps.event.addListener(searchbox, 'places_changed', function () {
             var placeDetail = searchbox.getPlaces();
             var location = placeDetail[0]['geometry']['location'];
             document.getElementById("BranchLat").value=location.lat();
             document.getElementById("BranchLong").value=location.lng();
         });
     }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
<style>
    .pac-container{
        z-index:99999;
    }
</style>