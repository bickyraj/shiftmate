<script src="<?php echo URL_VIEW;?>js/jquery-2.1.1.js"></script>

<?php


//Get list of countries
$url = URL . "Countries/getCountryList.json";
$countryList = \Httpful\Request::get($url)->send();
$countries = $countryList->body->countries;

//Get List of Cities
$url = URL . "Cities/cityList.json";
$cityList = \Httpful\Request::get($url)->send();
$cities = $cityList->body->cities;

?>
<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>styles/login.css"/>
<div class="registration-formDiv">
    <div class="logo">
    Shiftmate
    </div>
    <div class="content">
    <form action="#" id="UserAddForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <div style="display:none;">
            <input type="hidden" name="_method" value="POST"/>
        </div>
        <h3 class="form-title">User Registration</h3>
        <ul class="registration-form">
            <li>
                <div class="input text required">
                <label for="UserFname">Fname</label>
                <input name="data[User][fname]" maxlength="200" type="text" id="UserFname" required/>
                </div>
            </li>
            <li>
                <div class="input text required">
                    <label for="UserLname">Lname</label>
                    <input name="data[User][lname]" maxlength="200" type="text" id="UserLname" required/>
                </div>
            </li>
            <li>
                <div class="input text required">
                    <label for="UserUsername">Username</label>
                    <input name="data[User][username]" maxlength="200" type="text" id="UserUsername" required/>
                </div>
            </li>
            <li>
                <div class="input password required">
                    <label for="UserPassword">Password</label>
                    <input name="data[User][password]" type="password" id="UserPassword" required/>
                </div>
            </li>

            <li>
                <div class="input password required">
                    <label for="UserPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" required/>
                </div>
            </li>


            <li>
                <div class="input email required">
                    <label for="UserEmail">Email</label>
                    <input name="data[User][email]" maxlength="200" type="email" id="UserEmail" required/>
                </div>
            </li>
                <!--Edited br rabi
                    typr="text" now type="date"
                -->
            <li>
                <div class="input date required">
                    <label for="UserDobMonth">Dob</label>
                    <input name="data[User][dob]" maxlength="200" type="date" id="UserDob" required/>
                </div>
            </li>
            <li>
                <div class="input text required">
                    <label for="UserAddress">Address</label>
                    <input name="data[User][address]" maxlength="200" type="text" id="UserAddress" required/>
                </div>
            </li>
            <li>
                <div class="input tel required">
                    <label for="UserPhone">Phone</label>
                    <input name="data[User][phone]" maxlength="100" type="tel" id="UserPhone" required/>
                </div>
            </li>
            <li>
                <div class="input select required">
                    <label for="UserCountryId">Country</label>
                    <select name="data[User][country_id]" id="UserCountryId" required>
                        <?php foreach ($countries as $key => $country): ?>
                            <option value="<?php echo $key; ?>"><?php echo $country; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </li>
            <li>
                <div class="input select required">
                    <label for="UserCityId">City</label>
                    <select name="data[User][city_id]" id="UserCityId" required>
                        <?php foreach ($cities as $key => $city): ?>
                            <option value="<?php echo $key; ?>"><?php echo $city; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </li>
            <li>
                <div class="input text required">
                    <label for="UserState">State</label>
                    <input name="data[User][state]" maxlength="100" type="text" id="UserState" required/>
                </div>
            </li>
            <li>
                <div class="input text required">
                    <label for="UserZipcode">Zipcode</label>
                    <input name="data[User][zipcode]" maxlength="100" type="text" id="UserZipcode" required/>
                </div>
            </ll>

            <li>
                <div class="input text required">
                    <label for="image">Image</label>
                    <input name="image" type="file" id="image" required/>
                </div>
            </ll>

            <li>
                <div class="submit">
                    <input  type="submit" name="submit" value="Submit"/>
                </div>
            </li>

            
        </ul>
    </form>
    </div>
</div>
<!-- End Registration form -->


<script type="text/javascript">

    $(function()
        {

            console.log("hello");
            $("form").submit(function(eV)
                {
                    eV.preventDefault();

                    var conpass = $("#confirmPassword").val();
                    var pass = $("#Password").val();

                        var data=$("#UserAddForm").serialize();

                        $.ajax({
                                              url: "<?php echo URL_VIEW.'employees/process.php'?>",
                                              data:data,
                                              type: 'POST',
                                              success:function(response)
                                                                   {

                                                                    alert(response);
                                                                   }
                                         });
                    


                    
                });
        });
</script>






