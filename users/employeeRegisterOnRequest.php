<?php


$orgId = $_GET['org_id'];
$userId = $_GET['user_id'];


//Get User detail by userId.
$url = URL . "Users/getUserDetailById/".$userId.".json";
$data = \Httpful\Request::get($url)->send();
$userDetail = $data->body->userDetail;

//Get list of countries
$url = URL . "Countries/getCountryList.json";
$countryList = \Httpful\Request::get($url)->send();
$countries = $countryList->body->countries;

//Get List of Cities
$url = URL . "Cities/cityList.json";
$cityList = \Httpful\Request::get($url)->send();
$cities = $cityList->body->cities;




if (isset($_POST["submit"])) {
    // echo "<pre>";
    // print_r($_POST['data']);
    $url = URL . "Users/employeeRegistrationOnOrgRequest/".$orgId."/".$userId.".json";
    $response = \Httpful\Request::post($url)
            ->sendsJson()
            ->body($_POST['data'])
            ->send();
    // echo "<pre>";
    // print_r($response);
}
?>

<form action="" id="UserAddForm" method="post" accept-charset="utf-8">
    <div style="display:none;">
        <input type="hidden" name="_method" value="POST"/>
        <input type="hidden" name="data[User][id]" value="<?php echo $userDetail->User->id;?>"/>
    </div>
    <fieldset>
        <legend>Add User</legend>

        <div class="input text required">
            <label for="UserFname">Fname</label>
            <input name="data[User][fname]" maxlength="200" type="text" id="UserFname" required="required"/>
        </div>
        <div class="input text required">
            <label for="UserLname">Lname</label>
            <input name="data[User][lname]" maxlength="200" type="text" id="UserLname" required="required"/>
        </div>
        <div class="input text required">
            <label for="UserUsername">Username</label>
            <input name="data[User][username]" maxlength="200" type="text" id="UserUsername" required="required"/>
        </div>
        <div class="input password required">
            <label for="UserPassword">Password</label>
            <input name="data[User][password]" type="password" id="UserPassword" required="required"/>
        </div>
        <div class="input email required">
            <label for="UserEmail">Email</label>
            <input disabled="disabled" name="data[User][email]" value="<?php echo $userDetail->User->email;?>" maxlength="200" type="email" id="UserEmail" required="required"/>
        </div>
        <div class="input date required">
            <label for="UserDobMonth">Dob</label>
            <input name="data[User][dob]" maxlength="200" type="text" id="UserDob" required="required"/>

        </div>
        <div class="input text required">
            <label for="UserAddress">Address</label>
            <input name="data[User][address]" maxlength="200" type="text" id="UserAddress" required="required"/>
        </div><div class="input tel required">
            <label for="UserPhone">Phone</label>
            <input name="data[User][phone]" maxlength="100" type="tel" id="UserPhone" required="required"/>
        </div>
        <div class="input select required">
            <label for="UserCountryId">Country</label>
            <select name="data[User][country_id]" id="UserCountryId" required="required">
                <?php foreach ($countries as $key => $country): ?>
                    <option value="<?php echo $key; ?>"><?php echo $country; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input select required">
            <label for="UserCityId">City</label>
            <select name="data[User][city_id]" id="UserCityId" required="required">
                <?php foreach ($cities as $key => $city): ?>
                    <option value="<?php echo $key; ?>"><?php echo $city; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input text required">
            <label for="UserState">State</label>
            <input name="data[User][state]" maxlength="100" type="text" id="UserState" required="required"/>
        </div>
        <div class="input text required">
            <label for="UserZipcode">Zipcode</label>
            <input name="data[User][zipcode]" maxlength="100" type="text" id="UserZipcode" required="required"/>
        </div>
        


    </fieldset>
    <div class="submit">
        <input  type="submit" name="submit" value="Submit"/>
    </div>
</form>