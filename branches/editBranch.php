<?php 


$branchId = $_GET['branch_id'];

$orgId = $_GET['org_id'];
$homeBranch = URL_VIEW.'branches/listBranches?org_id='.$orgId;
//print_r($_GET['user_id']);

// echo $_SESSION['success'];

$url = URL."Branches/editBranch/".$branchId.".json";
$data = \Httpful\Request::get($url)->send();
// echo "<pre>";
// print_r($data);die();
$branch = $data->body->branch;
// echo "<pre>";
// print_r($branch);
//$organization = $data->body->users->Organization;



$url = URL."Countries/getCountryList.json";
$countryList = \Httpful\Request::get($url)->send();
$countries = $countryList->body->countries;

$url = URL."Cities/cityList/".$branch->Branch->country_id.".json";
$cityList = \Httpful\Request::get($url)->send();
$cities = $cityList->body->cities;
// echo "<pre>";
// print_r($cities) ;
// die();
 $url = URL . "OrganizationUsers/getOrganizationUsers/".$orgId.".json";
$data = \Httpful\Request::get($url)->send();
$organizationUsers = $data->body->organizationUsers;
// echo "<pre>";
// print_r($organizationUsers);
// die();
if(isset($_POST["submit"]))
{
   //  echo "<pre>";
   // print_r($_POST['data']);
   // die();
    $url = URL."Branches/editBranch/".$branchId.".json";
$response = \Httpful\Request::post($url)    
    ->sendsJson()
    ->body($_POST['data']) 
    ->send();
// echo "<pre>";
// print_r($response);

    if($response->body->output->status == '1')
    {   
        echo '<script>toastr.success("Branch updated successfully.");</script>';
        echo("<script>location.href = '".URL_VIEW."branches/listBranches?org_id=".$orgId."';</script>");

    }

   
}
?>

<!-- Edit -->
<div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Edit Branch <small> Edit Branch</small></h1>
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
                        <a href="<?=URL_VIEW."branches/listBranches";?>">Branches</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="javascript:;">Edit Branch</a>
                    </li>
                </ul>
                
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <!-- BEGIN VALIDATION STATES-->
                        <div class="portlet light">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="icon-bar-chart theme-font hide"></i>
                                    <span class="caption-subject theme-font bold uppercase">Edit Branch Detail</span>
                                    <!-- <span class="caption-helper hide">weekly stats...</span> -->
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form onsubmit="validateForm()" action="" id="OrganizationAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <div style="display:none;">
                                        <input type="hidden" name="_method" value="POST"/>
                                        <input type="hidden" name="data[Branch][id]" value="<?php echo $branchId;?>"/>
                                    </div>
                                    <div class="form-body">     
                                        <div class="form-group">
                                            <label class="control-label col-md-4">
                                                Branch Name <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input  class="form-control" required required type="text" name="data[Branch][title]" value="<?php echo $branch->Branch->title;?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Branch Manager <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                 <select class="form-control" name="data[Branch][user_id]" id="BoardUserId" >
                                                    
                                                    <option value="0">Assign later</option>
                                                    <?php 
                                                    if(isset($branch->Branch->user_id) && $branch->Branch->user_id != 0){
                                                        ?>
                                                      <option selected value="<?php echo $branch->Branch->user_id;?>"><?php echo $branch->User->fname.' '.$branch->User->lname;?></option>
                                                    <?php }
                                                    foreach($organizationUsers as $organizationUser):

                                                        if($branch->Branch->user_id != $organizationUser->User->id){
                                                        ?>
                                                    <option value="<?php echo $organizationUser->User->id;?>"><?php echo $organizationUser->User->fname.' '.$organizationUser->User->lname;?></option>
                                                    <?php } endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">
                                                Phone<span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control" required type="number" name="data[Branch][phone]" value="<?php echo $branch->Branch->phone;?>" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">
                                                Fax <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control" required type="number" name="data[Branch][fax]" value="<?php echo $branch->Branch->fax;?>" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">
                                                Email <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control" required type="email" name="data[Branch][email]" value="<?php echo $branch->Branch->email;?>" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">
                                                Address <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control" required id="BranchAddress" type="text" name="data[Branch][address]" value="<?php echo $branch->Branch->address;?>" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-4" >Country <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7"> 
                                                 <select class="form-control" name="data[Branch][country_id]" id="OrganizationCountryId" required="required">
                                                     <option value="default">Choose Country</option>
                                                    <?php foreach($countries as $key=>$country):?>
                                                    
                                                    <option value="<?php echo $key;?>" <?php echo ($branch->Branch->country_id == $key)? 'selected="selected"':'';?>><?php echo $country;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">City <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                 <select class="form-control" required name="data[Branch][city_id]" id="cities">
                                                    <option value="default">Choose City</option>
                                                    <?php foreach($cities as $key=>$city):?>

                                                    <option value="<?php echo $key;?>" <?php echo ($branch->Branch->city_id == $key)? 'selected="selected"':'';?>><?php echo $city;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Lat <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control" required id="BranchLat" type="text" name="data[Branch][lat]" value="<?php echo $branch->Branch->lat;?>" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Long <span class="required">
                                            * </span>
                                            </label>
                                            <div class="col-md-7">
                                                <input class="form-control" required type="text" id="BranchLong" name="data[Branch][long]" value="<?php echo $branch->Branch->long;?>" />
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                            <input  type="submit" name="submit" value="Submit" class="btn green"/>
<!--                                                 <a href="<?php echo URL_VIEW."branches/listBranches?org_id=".$orgId;?>"><button type="submit" class="btn default">Cancel</button></a>
 -->                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- END FORM-->
                            </div>
                        </div>
                    </div>
                </div>


<!-- by rabi -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#OrganizationCountryId").on('change',function(){
            var data;
            var country = $(this).val();
           // alert(country);
             $.ajax({
                 url: "<?php echo URL_VIEW."process.php";?>",
                data: "action=getCountryCity&countryID="+country,
                type: "post",
                success:function(response){
                    //console.log(response);
                    var cities = JSON.parse(response);
                    console.log(cities);
                     $.each(cities, function(key,obj){
                               data+= "<option value=" + key + ">" + obj + "</option>";
                           });
                           $("#cities").html(data);
                            if(jQuery.isEmptyObject(cities))
                            {
                                
                                data = "<option value=''>Select city</option>";
                                $("#cities").html(data);
                            }
                }                  
            });
        });
    });
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCIuoU0w1H1peZGucqAzVwBFrfwbYaUPD8&libraries=places"> </script>
<script type="text/javascript">
     function initialize() {
         var searchbox = new google.maps.places.SearchBox(document.getElementById("BranchAddress"));
         $('.pac-container').attr('style',"z-index:100;");
         google.maps.event.addListener(searchbox, 'places_changed', function () {
             var placeDetail = searchbox.getPlaces();
             var location = placeDetail[0]['geometry']['location'];
             document.getElementById("BranchLat").value=location.lat();
             document.getElementById("BranchLong").value=location.lng();
         });
     }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>