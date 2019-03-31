

<link href="<?php echo URL_VIEW;?>styles/autocompleteCss/autocomplete.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo URL_VIEW;?>js/autocomplete/jquery.autocomplete.min.js"></script>
<?php
$orgId = $_GET['org_id'];
// print_r($userId);

//$page = $_GET['page'];
if(isset($_GET['page'])){
    $page = "page:".$_GET['page'];
}else{
    $page = '';
}
if(isset($_POST["add"]))
{
  //   echo "<pre>";
  //  print_r($_POST['data']);
  // die();
    $url = URL."Branches/createBranches/".$orgId."/".$userId.".json";
    $response = \Httpful\Request::post($url)    
    ->sendsJson()
    ->body($_POST['data']) 
    ->send(); 

    // echo "<pre>";
    // print_r($response);
    // die();

    if($response->body->output->status == '1')
    {
        
        echo("<script>location.href = '".URL_VIEW."branches/listBranches?org_id=".$orgId."';</script>");
        // echo("<script>location.href = '".URL_VIEW."branches/listBranches';</script>");

        $_SESSION['success']="test";
    }
   
}

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

// $i = 0;
// foreach ($organizationUsers as $employee ) {
//     $employ_name[$i]['User']['id'] = $employee->User->id;
//     $employ_name[$i]['User']['name'] = $employee->User->fname." ".$employee->User->lname;
//     $employ_name[$i]['User']['image'] = $employee->User->image_dir."/thumb2_".$employee->User->image;
//     $i++;
// }

?>

<!-- End of Save Success Notification -->
<style>
.caption > a {
    color: #ffffff;
}
.caption > a:hover {
    text-decoration: underline;
}
</style>


<!-- Edit-->
<h3 class="page-title">
    Branch List <small>View Branch List</small>
</h3>
<div class="modal fade" id="portlet-config_1_2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

<script type="text/javascript">

                                $(function(){
                                    $('#portlet-config_1_2').modal('hide');
                                    var employ = '<?php echo json_encode($employ_name);?>';
                                    var imageUrl = '<?php echo URL."webroot/files/user/image/";?>';

                                    employ = JSON.parse(employ);
                                    console.log(employ);


                                        
                                    var userList = $.map(employ, function(value, index) {
                                                            return {value:value.User.name,UserId:value.User.id, image:value.User.image};
                                                                            });

                                   console.log(userList);

                                      $('#autocomplete').autocomplete({
                                        lookup: userList,
                                         formatResult: function (suggestion, currentValue)
                                                              {
                                                                console.log(suggestion['value']);
                                                                var dataHtml = '<div class="media"><div class="pull-left"><div class="media-object"><img src="'+
                                                                imageUrl+
                                                                suggestion['image']+
                                                                '" width="50" height="50"/></div></div><div class="media-body"><h4 class="media-heading text-capitalize">'+suggestion['value']+'</h4></div></div>';
                                                                return dataHtml;
                                                              },
                                        onSelect: function (suggestion) {
                                            // $('#user_id').val(suggestion['UserId']);
                                        }
                                      });
                                });

                                </script>
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

                        <?php /* <div class="form-group">
                            <label class="control-label col-md-3">Select User <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                               <div id="searchfield">
                                    <input class="form-control" type="text"   class="biginput" id="autocomplete" required>
                                </div>
                            </div>
                        </div> */?>
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
                                <input class="form-control" type="text" name="data[Branch][phone]"required />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-md-4">Fax<span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="data[Branch][fax]"required />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-md-4">Email <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="data[Branch][email]"required />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-md-4">Address <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="data[Branch][address]"required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Country <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                               <select name="data[Branch][country_id]" id="UserCountryId" class="form-control">
                                    <option value="default">Choose Country</option>
                                  <?php foreach($countries as $key=>$country):?>
                                        <option value="<?php echo $key;?>"><?php echo $country;?></option>
                                    <?php endforeach;?>
                                </select>
                               
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-4">Cities <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-7">
                                     <select name="data[Branch][city_id]" id="UserCityId" class="form-control" required>
                                         <option value="default">Select Cities</option>
                                       
                                    </select>
                                </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-4">Lat <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="number" name="data[Branch][lat]"required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Long <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-7">
                                <input class="form-control" type="number" name="data[Branch][long]"required />
                            </div>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <input  type="submit" name="add" value="Add" class="btn green"  />
                                   <!--  <button type="button" class="btn default"> <a class="cancel_a" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a></button> -->
                                    <!-- <a class="btn default" href="<?php echo URL_VIEW."boards/listBoards?org_id=".$orgId;?>">Cancel</a> -->
                                    <input type="reset" class="btn default" value="Clear">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
              </div>
            </div>
              <!-- <div class="modal-footer">
                  <button type="button" class="btn default" data-dismiss="modal">Close</button>
              </div> -->
        </div>
          <!-- /.modal-content -->
    </div>
                    <!-- /.modal-dialog -->
    </div>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Branch</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Branch List</a>
        </li>
    </ul>
    <div class="page-toolbar">
    <div class="btn-group pull-right">
         <a class="btn btn-fit-height grey-salt dropdown-toggle" href="#portlet-config_1_2" class="news-block-btn" data-toggle="modal" class="config" id="test">
                                          <i class="fa fa-plus"></i> Add New Branch </a>
    </div>
</div>
</div>

<div class="row">
        
        <?php 
            if($branches){
            foreach($branches as $branch):
        ?>
            <div class="col-md-6 col-sm-12">
        <div class="portlet green box">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i><a href="viewBranch?branch_id=<?php echo $branch->Branch->id;?>"><?php echo $branch->Branch->title;?>  </a>
                </div>
               
                <div class="actions">
                <div class="btn-group">
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
                </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Branch Name:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $branch->Branch->title;?>              
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Organization:
                    </div>
                    <div class="col-md-7 value">
                        <?php echo $branch->Organization->title;?>                   
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Email:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $branch->Branch->email;?>                 
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Address:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $branch->Branch->address;?>                
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         City:
                    </div>
                    <div class="col-md-7 value">
                         <?php echo $branch->City->title;?>                   
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-md-5 name">
                         Country:
                    </div>
                    <div class="col-md-7 value">
                        <?php echo $branch->Country->title;?>                
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
            <div class="row static-info">
                
                <div class="col-md-7 value">
                    No branches Found .....             
                </div>
            </div>    
         <?php
            }
         ?>
        
 
</div>

<script type="text/javascript">
$(function(){
    $('#UserCountryId').on('change',function(){
       
        var data;
        var country = $(this).val();
        //alert(country);
         $.ajax({
                 url: "<?php echo URL_VIEW."process.php";?>",
                data: "action=getCountryCity&countryID="+country,
                type: "post",
                success:function(response){
                    console.log(response);
                    var cities = JSON.parse(response);
                        console.log(cities);
                     $.each(cities, function(key,obj){
                               data+= "<option value=" + key + ">" + obj + "</option>";
                           });
                           $("#UserCityId").html(data);
                            if(jQuery.isEmptyObject(cities))
                            {
                                
                                data = "<option value=''>Select city</option>";
                                $("#UserCityId").html(data);
                            }
                }                  
            });
     });
});

</script>
