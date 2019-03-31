<?php 


$orgId = $_GET['org_id'];
$userId = $_GET['user_id'];
//$orgId = 5;
//$userId = 9;
//Get list of countries
$url = URL."Countries/getCountryList.json";
$countryList = \Httpful\Request::get($url)->send();
$countries = $countryList->body->countries;

$url = URL."Cities/cityList.json";
$cityList = \Httpful\Request::get($url)->send();
$cities = $cityList->body->cities;


if(isset($_POST["submit"]))
{
    //echo "<pre>";
   // print_r($_POST['data']);
    $url = URL."Branches/createBranches/".$orgId."/".$userId.".json";
    $response = \Httpful\Request::post($url)    
    ->sendsJson()
    ->body($_POST['data']) 
    ->send(); 

    // echo "<pre>";
    // print_r($response->status);

    if($response->body->output->status == '1')
    {
        
		/*echo("<script>location.href = '".URL_VIEW."branches/listBranches?org_id=".$orgId."';</script>");*/
		echo("<script>location.href = '".URL_VIEW."branches/viewBranch?branch_id=".$response->body->output->id."';</script>");

        $_SESSION['success']="test";
    }
   
}
?>



<!-- Edit -->    
    <div class="page-head">
       <div class="container">
            <div class="page-title">
				<h1>Add Branch <small> Add Branch</small></h1>
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
                        <a href="javascript:;">Add Branch</a>
                    </li>
                </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                <i class="fa fa-plus"></i>Add Branch 
            </button>
        </div>
    </div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>Branch Detail
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="" id="OrganizationAddForm" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST"/>
                    </div>
                    <div class="form-body">    
                        <div class="form-group">
                            <label class="control-label col-md-3">Branch Name <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" required type="text" name="data[Branch][title]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Phone <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" required type="text" name="data[Branch][phone]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Fax <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" required type="text" name="data[Branch][fax]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" required type="email" name="data[Branch][email]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Address <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" required type="text" name="data[Branch][address]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Country <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <select class="form-control" name="data[Branch][country_id]" id="BranchCountryId" required="required">
                                    <?php foreach($countries as $key=>$country):?>
                                        <option value="<?php echo $key;?>"><?php echo $country;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3">City <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-4">
                                     <select class="form-control" name="data[Branch][city_id]" id="BranchCityId" required="required">
                                        <?php foreach($cities as $key=>$city):?>
                                        
                                        <option value="<?php echo $key;?>"><?php echo $city;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Lat <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" required type="text" name="data[Branch][lat]" value="000">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Long <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control" required type="text" name="data[Branch][long]" value="000">
                            </div>
                        </div> 
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green">Submit</button>
                                <button type="button" class="btn default">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>




















<form action="" id="OrganizationAddForm" method="post" accept-charset="utf-8">
    <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
    </div>

    <!-- Table -->
        <div class="tableHeader">
    <div class="blueHeader">
        <div class="table-heading">Add Branch</div>
    </div>
    <div class="clear"></div>

    <div class="form createShift">
        <table cellpadding="5px">
         
        <tbody><tr>
            <th>Branch Name</th>
            <td> <input required type="text" name="data[Branch][title]"></td>
        </tr>
        
        <tr>
            <th>Phone</th>
            <td><input required type="text" name="data[Branch][phone]"></td>
        </tr>   
        
        <tr>
            <th>Fax</th>
            <td><input required type="text" name="data[Branch][fax]"></td>
        </tr>
        
         <tr>
            <th>Email</th>
            <td><input required type="email" name="data[Branch][email]"></td>
        </tr>
        
         <tr>
            <th>Address</th>
            <td><input required type="text" name="data[Branch][address]"></td>
        </tr>
        
         <tr>
            <th>Country</th>
            <td>
                <select name="data[Branch][country_id]" id="BranchCountryId" required="required">
                    <?php foreach($countries as $key=>$country):?>
                        <option value="<?php echo $key;?>"><?php echo $country;?></option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
        
         <tr>
            <th>City</th>
            <td> <select name="data[Branch][city_id]" id="BranchCityId" required="required">
                    <?php foreach($cities as $key=>$city):?>
                    
                    <option value="<?php echo $key;?>"><?php echo $city;?></option>
                    <?php endforeach;?>
                </select></td>
        </tr>
        
         <tr>
            <th>Lat</th>
            <td><input required type="text" name="data[Branch][lat]" value="000"></td>
        </tr>
        
         <tr>
            <th>Long</th>
            <td><input required type="text" name="data[Branch][long]" value="000"></td>
        </tr>
        
        <tr>

            <td colspan="2">
                <a class="cancel_a" href="<?php echo URL_VIEW."branches/listBranches?org_id=".$orgId;?>">Cancel</a>
                <input type="submit" name="submit" value="Submit" class="rightbtn"></td>
        </tr>   
        </tbody></table>
    </div>

<div class="clear"></div>

</div>
    <!-- End of Table -->
</form>