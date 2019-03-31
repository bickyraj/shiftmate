<?php
$userId = $_GET['user_id'];
//print_r($_GET['user_id']);

$url = URL."Users/orgEdit/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$user = $data->body->users->User;
$organization = $data->body->users->Organization;

//echo "<pre>";
//print_r($data);

//get userId using org Id.
$url = URL . "Organizations/getOrgIdFromUserId/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$orgId = $data->body->orgId;


//Get list of countries
$url = URL."Countries/getCountryList.json";
$countryList = \Httpful\Request::get($url)->send();
$countries = $countryList->body->countries;

//Get list of Days
$url = URL."Days/dayList.json";
$dayList = \Httpful\Request::get($url)->send();
$days = $dayList->body->days;

//Get List of Cities
$url = URL."Cities/cityList.json";
$cityList = \Httpful\Request::get($url)->send();
$cities = $cityList->body->cities;





if(isset($_POST["submit"]))
{

    $_POST['data']['Organization']['logo'] = array( 'name'=> $_FILES['logo']['name'],
            'type'=> $_FILES['logo']['type'],
            'tmp_name'=> $_FILES['logo']['tmp_name'],
            'error'=> $_FILES['logo']['error'],
            'size'=> $_FILES['logo']['size']
            );


    // echo "<pre>";
   // print_r($_POST['data']);
    $url = URL."Users/orgEdit.json";
    $response = \Httpful\Request::post($url)    
    ->sendsJson()
    ->body($_POST['data']) 
    ->send(); 
// echo "<pre>";

// print_r($response->body);
// die();
if($response->body->output->status == 1){
    header('Location: orgList.php');
}
   
}
?>

<div class="tableHeader">
    <div class="blueHeader">
        <ul class="subNav subNav_left">
                <li><a href="<?php echo URL_VIEW . 'organizations/orgView?org_id='.$orgId;?>">Profile</a></li>
                <li><a class="active" href="<?php echo URL_VIEW . 'organizations/orgEdit?user_id=' . $organization->Organization->user_id; ?>">Edit Profile</a></li>
                <li><a href="<?php echo URL_VIEW . 'organizations/changePassword?org_id=' .$orgId; ?>">Change Password</a></li>
                <!-- <li><a href="<?php echo URL_VIEW . 'organizationUsers/listOrganizationEmployees?org_id=' . $organization->Organization->id; ?>">List Users in Organization</a></li> -->
                <!-- <li><a href="<?php echo URL_VIEW . 'users/requestEmployeeToOrganization?org_id=' . $organization->Organization->id; ?>">Request Employee</a></li> -->
        </ul>
    </div>
    <div class="clear"></div>

<div class="form createShift">
<form action="" id="OrganizationAddForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	<table cellpadding="5px">
     <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
        <input type="hidden" name="data[User][id]" value="<?php echo $userId;?>"/>
        <input type="hidden" name="data[Organization][id]" value="<?php echo $organization->id;?>"/>
    </div>
    <tr>
    	<th>Organization Name</th>
        <td> <input type="text" name="data[Organization][title]" value="<?php echo $organization->title;?>"/></td>
    </tr>
    
    <tr>
    	<th>Logo</th>
        <td><input type="file" name="logo"/></td>
    </tr>	
    
    <tr>
    	<th>Address</th>
        <td><input type="text" name="data[Organization][address]" value="<?php echo $organization->address;?>"  /></td>
    </tr>
    
     <tr>
    	<th>Phone</th>
        <td><input type="text" name="data[Organization][phone]" value="<?php echo $organization->phone;?>" /></td>
    </tr>
    
     <tr>
    	<th>Fax</th>
        <td><input type="text" name="data[Organization][fax]" value="<?php echo $organization->fax;?>" /></td>
    </tr>
    
     <tr>
    	<th>Website</th>
        <td><input type="text" name="data[Organization][website]" value="<?php echo $organization->website;?>" /></td>
    </tr>
    
    <tr>
    	<th>Country</th>
        <td> <select name="data[Organization][country_id]">
                <?php foreach($countries as $key=>$country):?>
                
                <option value="<?php echo $key;?>" <?php echo ($organization->country_id == $key)? 'selected="selected"':'';?>><?php echo $country;?></option>
                <?php endforeach;?>
                </td>
    </tr>
    
     <tr>
    	<th>City</th>
        <td> <select name="data[Organization][city_id]">
                <?php foreach($cities as $key=>$city):?>
                
                <option value="<?php echo $key;?>" <?php echo ($organization->city_id == $key)? 'selected="selected"':'';?>><?php echo $city;?></option>
                <?php endforeach;?>
            </select>
            </td>
    </tr>
    
     <tr>
    	<th>Lat</th>
        <td><input type="text" name="data[Organization][lat]" value="<?php echo $organization->lat;?>" /></td>
    </tr>
    
     <tr>
    	<th>Long</th>
        <td><input type="text" name="data[Organization][long]" value="<?php echo $organization->long;?>" /></td>
    </tr>
    
    <tr>
    	<th>Day</th>
        <td> <select name="data[Organization][day_id]">
                <?php foreach($days as $key=>$day):?>
                
                <option value="<?php echo $key;?>" <?php echo ($organization->day_id == $key)? 'selected="selected"':'';?>><?php echo $day;?></option>
                <?php endforeach;?>
            </select>
            </td>
    </tr>
    
    <tr>
    	<td colspan="2"><input  type="submit" name="submit" value="Submit" class="rightbtn"/></td>
    </tr>	
    </table>
</form>
</div>

<div class="clear"></div>

<script>
    $.getJSON( "<?php echo URL_VIEW;?>Countries/getCountryList.json", { countryId: "1" } )
.done(function( json ) {
console.log( json );
})

});
    
    </script>