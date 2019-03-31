<?php


$userId = $_GET['user_id'];

//Get employee detail to populate form fields.
$url = URL . "Users/editEmployeeDetail/".$userId.".json";
$users = \Httpful\Request::get($url)->send();
$employee = $users->body->employee;

//Get list of countries
$url = URL . "Countries/getCountryList.json";
$countryList = \Httpful\Request::get($url)->send();
$countries = $countryList->body->countries;

//Get List of Cities
$url = URL . "Cities/cityList.json";
$cityList = \Httpful\Request::get($url)->send();
$cities = $cityList->body->cities;

// echo "<pre>";

// print_r($employee);
// die();


if (isset($_POST["submit"])) {
    

        $_POST['data']['User']['image'] = array( 'name'=> $_FILES['image']['name'],
            'type'=> $_FILES['image']['type'],
            'tmp_name'=> $_FILES['image']['tmp_name'],
            'error'=> $_FILES['image']['error'],
            'size'=> $_FILES['image']['size']
            );

    // echo "<pre>";
    // print_r($_POST['data']);
    // die();
    $url = URL . "Users/editEmployeeDetail/".$userId.".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    // echo "<pre>";
    // print_r($response);
    // die();
}
?>

<form action="" id="UserAddForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
        <input type="hidden" name="data[User][id]" value="<?php echo $userId;?>"/>
    </div>
    <fieldset>
        <legend>Update Employee</legend>

        <div class="input text required">
            <label for="UserFname">Fname</label>
            <input name="data[User][fname]" value="<?php echo $employee->User->fname;?>" maxlength="200" type="text" id="UserFname" required="required"/>
        </div>
        <div class="input text required">
            <label for="UserLname">Lname</label>
            <input name="data[User][lname]" value="<?php echo $employee->User->lname;?>" maxlength="200" type="text" id="UserLname" required="required"/>
        </div>
        <div class="input text required">
            <label for="UserUsername">Username</label>
            <input disabled="disabled" name="data[User][username]" value="<?php echo $employee->User->username;?>" maxlength="200" type="text" id="UserUsername" required="required"/>
        </div>
        
        <div class="input email required">
            <label for="UserEmail">Email</label>
            <input disabled="disabled" name="data[User][email]" value="<?php echo $employee->User->email;?>" maxlength="200" type="email" id="UserEmail" required="required"/>
        </div>
        <div class="input date required">
            <label for="UserDobMonth">Dob</label>
            <input name="data[User][dob]" value="<?php echo $employee->User->dob;?>" maxlength="200" type="text" id="UserDob" required="required"/>

        </div>
        <div class="input text required">
            <label for="UserAddress">Address</label>
            <input name="data[User][address]" value="<?php echo $employee->User->address;?>" maxlength="200" type="text" id="UserAddress" required="required"/>
        </div><div class="input tel required">
            <label for="UserPhone">Phone</label>
            <input name="data[User][phone]" value="<?php echo $employee->User->phone;?>" maxlength="100" type="tel" id="UserPhone" required="required"/>
        </div>
        <div class="input select required">
            <label for="UserCountryId">Country</label>
            <select name="data[User][country_id]" id="UserCountryId" required="required">
                <?php foreach($countries as $key=>$country):?>
                <option value="<?php echo $key;?>" <?php echo ($employee->User->country_id == $key)? 'selected="selected"':'';?>><?php echo $country;?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="input select required">
            <label for="UserCityId">City</label>
            <select name="data[User][city_id]" id="UserCityId" required="required">
                <?php foreach($cities as $key=>$city):?>
                <option value="<?php echo $key;?>" <?php echo ($employee->User->city_id == $key)? 'selected="selected"':'';?>><?php echo $city;?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="input text required">
            <label for="UserState">State</label>
            <input name="data[User][state]" value="<?php echo $employee->User->state;?>" maxlength="100" type="text" id="UserState" required="required"/>
        </div>
        <div class="input text required">
            <label for="UserZipcode">Zipcode</label>
            <input name="data[User][zipcode]" value="<?php echo $employee->User->zipcode;?>" maxlength="100" type="text" id="UserZipcode" required="required"/>
        </div>

        <img src='<?php echo URL."webroot/files/user/image/".$employee->User->image_dir."/thumb2_".$employee->User->image;?>'/>

        <div class="input text required">
            <label for="Image">Profile Picture</label>
            <input name="image" type="file" id="image"/>
        </div>
        


    </fieldset>
    <div class="submit">
        <input  type="submit" name="submit" value="Submit"/>
    </div>
</form>