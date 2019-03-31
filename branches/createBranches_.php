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