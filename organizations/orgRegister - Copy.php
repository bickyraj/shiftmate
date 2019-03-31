<link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>styles/login.css"/>

<script src="<?php echo URL_VIEW;?>global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>
<?php


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
// echo "<pre>";
// print_r($cities);

if(isset($_POST["submit"]))
{
     $_POST['data']['Organization']['logo'] = array( 'name'=> $_FILES['logo']['name'],
    'type'=> $_FILES['logo']['type'],
    'tmp_name'=> $_FILES['logo']['tmp_name'],
    'error'=> $_FILES['logo']['error'],
    'size'=> $_FILES['logo']['size']
    );

       //  echo "<pre>";
       // print_r($_POST['data']);
       // die();
        $url = URL."Users/orgRegistration.json";
    $response = \Httpful\Request::post($url)    
        ->sendsJson()
        ->body($_POST['data']) 
        ->send(); 
       //  echo "<pre>";
       // print_r($response);
       // die();
    //echo "Please wait for confirmation";
        if($response->body->output->status == '1')
           {
                $_SESSION['success']= "Thank you for registration";
               echo '<script>window.location.assign("login.php")</script>';
           }
           else{
            echo("<script>
                location.href ='".URL_VIEW."organizations/orgRegister"."';</script>");
           }
      

//print_r($response);
   
}
?>


<div class="registration-formDiv">
    <div class="logo">
        Shiftmate
    </div>
    <div class="content">
        <form action="" id="OrganizationAddForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <div style="display:none;">
                <input type="hidden" name="_method" value="POST"/>
            </div>
            <h3 class="form-title">Add Organization</h3>
            
            <ul class="registration-form">
                <li>
                    <div class="input text required">
                        <label for="OrganizationTitle">Organization Name</label>
                        <input name="data[Organization][title]" maxlength="200" type="text" id="OrganizationTitle" required="required"/>
                    </div>
                </li>
                <li>
                    <div class="input text required">
                        <label for="OrganizationLogo">Username</label>
                        <input name="data[User][username]" maxlength="255" type="text" id="OrganizationLogo" required="required"/>
                    </div>
                </li>
                <li>
                    <div class="input text required">
                        <label for="OrganizationLogo">Email</label>
                        <input name="data[User][email]" maxlength="255" type="email" id="orgEmail" required="required"/>
                    </div>
                </li>
                <li>
                    <div class="loader" style="display:none;"><img src="<?php echo URL_IMAGE.'ajax-loader.gif';?>" /></div>
                        <i id="error" style="display:none; float:right;"></i>
                </li>
                <li>
                    <div class="input text required">
                        <label for="OrganizationLogo">password</label>
                        <input type="password" name="data[User][password]" maxlength="255" type="text" id="password" required="required"/>
                    </div>
                </li>


                <li>
                    <div class="input text required">
                        <label for="OrganizationLogo">Confirm Password</label>
                        <input name="data[User][confirm_password]" type="password" maxlength="255" type="text" id="confirmPassword" required="required"/>
                    </div>
                </li>
                 <li>
                    <div id="cpassError" style="float:right; display:none; color:red;">The password did not match the original.</div>
                </li>

                <li>
                    <div class="input text required">
                        <label for="OrganizationLogo">Logo</label>
                        <input name="logo" type="file" id="OrganizationLogo" required/>
                    </div>
                </ll>
                

                <!-- <li>
                    <div class="input text required">
                        <label for="OrganizationLogo">Logo</label>
                        <input type="file" name="data[Organization][logo]" maxlength="255" type="text" id="OrganizationLogo" required="required"/>
                    </div>
                </li> -->
                <li>
                    <div class="input text required">
                        <label for="OrganizationAddress">Address</label>
                        <input name="data[Organization][address]" maxlength="255" type="text" id="OrganizationAddress" required="required"/>
                    </div>
                </li>
                <li>
                    <div class="input tel required">
                        <label for="OrganizationPhone">Phone</label>
                        <input name="data[Organization][phone]" maxlength="200" type="tel" id="OrganizationPhone" required="required"/>
                    </div>
                </li>
                <li>
                    <div class="input text required">
                        <label for="OrganizationFax">Fax</label>
                        <input name="data[Organization][fax]" maxlength="200" type="text" id="OrganizationFax" required="required"/>
                    </div>
                </li>
                <li>
                    <div class="input text required">
                        <label for="OrganizationWebsite">Website</label>
                        <input name="data[Organization][website]" maxlength="200" type="text" id="OrganizationWebsite" required="required"/>
                    </div>
                </li>
                <li>
                    <div class="input select required">
                        <label for="OrganizationCountryId">Country</label>
                        <select name="data[Organization][country_id]" id="OrganizationCountryId" required="required">
                            <option value="default">Choose Country</option>
                            <?php foreach($countries as $key=>$country):?>
                            
                            <option value="<?php echo $key;?>"><?php echo $country;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </li>
                <li>
                    <div class="input select required">
                        <label for="OrganizationCityId">City</label>
                        <select name="data[Organization][city_id]" id="cities" required="required" >
                            <option value="default">Select Cities</option>
                            
                        </select>
                    </div>
                </li>
                <li>
                    <div class="input text required">
                        <label for="OrganizationLat">Lat</label>
                        <input name="data[Organization][lat]" maxlength="255" type="text" id="OrganizationLat" required="required"/>
                    </div>
                </li>
                <li>
                    <div class="input text required">
                        <label for="OrganizationLong">Long</label>
                        <input name="data[Organization][long]" maxlength="255" type="text" id="OrganizationLong" required="required"/>
                    </div>
                </li>
                <li>
                    <div class="input text required">
                        <label for="OrganizationDayId">Day</label>
                        <select name="data[Organization][day_id]" id="OrganizationDayId" required="required">
                            <?php foreach($days as $key=>$day):?>
                            
                            <option value="<?php echo $key;?>"><?php echo $day;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </li>
                <li>
                    <li>
                        <div id="googleCaptcha" style="float:right;"></div>
                        <i id="capError" style="display:none; float:right;"></i>
                    </ll>

                </li>
                
                <li>
                    <div class="submit"><input  type="submit" name="submit" value="Submit"/>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</div>

<script type="text/javascript">
    var captchaSubmit = false;
var verifyCallback = function(response) {
    
        var capError = $("#capError");
        capError.css("display", "none");
        captchaSubmit = true;
      };
var onloadCallback = function() {
        grecaptcha.render('googleCaptcha', {
          'sitekey' : '6Lc1xwsTAAAAAC3eiLOPB7qfCprUeK2cNkAU8VHv',
          'callback' : verifyCallback,
          'theme': 'light'
        });
      };
    $(document).ready(function(){
        $("#OrganizationCountryId").on('change',function(){
            //alert('hello');
            var data;
            var country=$(this).val();
          // alert(country);
            $.ajax({
                 url: "<?php echo URL_VIEW."process.php";?>",
                data: "action=getCountryCity&countryID="+country,
                type: "post",
                success:function(response){
                    //console.log(response);
                    var cities = JSON.parse(response);
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
        $("#confirmPassword").blur(function(e){
            var passError = $("#cpassError");
            if($("#password").val() != $("#confirmPassword").val())
            {
                passError.css("display", "block");
            }
            else
            {
                passError.css("display", "none");
            }
        });
        $("#OrganizationAddForm").on('submit', function(e)
        {
            var conPass;
            var cpassError = $("#cpassError");

            if($("#password").val() != $("#confirmPassword").val())
            {
                cpassError.css("display", "block");
                conPass = false;
            }else
            {
                cpassError.css("display", "none");
                conPass = true;
            }

            var email = $("#orgEmail").val();

            if(conPass === false)
            {
                console.log('false');
                return false;
            }
            else
            {
                e.preventDefault();
                console.log("true");
                checkEmail(email);
            }
        });
        function validateEmail(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return re.test(email);
        }
        $("#orgEmail").blur(function(e){
            var email = $(this).val();
             var validEmail = validateEmail(email);

            var urli = '<?php echo URL."Users/checkUniqueEmail.json";?>';
             var loader = $(".loader");
             var error = $("#error");

             error.css("display", "none");


             if(email === "" || validEmail==false)
             {
                error.css("display", "block");
                error.html("Invalid email.").css("color", "red");
             }

             else
             {
                loader.css("display", "block");

                 $.ajax({
                          url:urli,
                          type:'post',
                          data:'email='+email,
                          success:function(response)
                                               {
                                                    var status = response.output.status;
                                                    

                                                    loader.css("display","none");

                                                    if(status === 1){
                                                        error.css("display", "block");
                                                        error.html("The email is already in use.").css("color", "red");
                                                    }else{

                                                        error.css("display", "block");
                                                        error.html("valid email.").css("color", "green");

                                                    }
                                               }
                     });
             }
        });
    function checkEmail(email)
{

            var valid;
             var urli = '<?php echo URL."Users/checkUniqueEmail.json";?>';
             var loader = $(".loader");
             var error = $("#error");
             error.css("display", "none");

             

             if(email === "" || valid === true)
             {

             }

             else
             {

                loader.css("display", "block");

                 $.ajax({
                          url:urli,
                          type:'post',
                          data:'email='+email,
                          success:function(response)
                                               {
                                                    var status = response.output.status;
                                                    

                                                    loader.css("display","none");

                                                    if(status === 1){
                                                        error.css("display", "block");
                                                        error.html("The email is already in use.").css("color", "red");

                                                        valid = false;

                                                        return false;
                                                    }else{

                                                        error.css("display", "block");
                                                        error.html("valid email.").css("color", "green");

                                                        valid = true;

                                                        if(captchaSubmit == true)
                                                        {
                                                            $('#OrganizationAddForm').unbind('submit').submit();
                                                            $('#formSubmit').click();
                                                        }

                                                        else
                                                        {
                                                            var capError = $("#capError");
                                                            capError.css("display", "block");
                                                            capError.html("Captcha Please.").css("color", "red");
                                                        }


                                                    }
                                               }
                     });
             }


}
    });
</script>

<?php /*?><link rel="stylesheet" type="text/css" href="<?php echo URL_VIEW;?>styles/style.css"/>
<div class="bodywrap">
<div class="employregWrapper">
    <h1>Shiftmate</h1>
    <div class="orgRegisterTable">
            <h1>Organization Registration</h1>
        <div class="form createShift orgRegisterForm">
            <form action="" id="UserAddForm" method="post" accept-charset="utf-8">
                <div style="display:none;">
                    <input type="hidden" name="_method" value="POST"/>
                </div>

                <table cellpadding="5px">
                     <tr>
                        <th>Organization Name</th>
                        <td><input name="data[Organization][title]" maxlength="200" type="text" id="OrganizationTitle" required="required"/></td>
                    </tr>

                    <tr>
                        <th>Username</th>
                        <td><input name="data[User][username]" maxlength="200" type="text" id="OrganizationLogo" required="required"/></td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td><input name="data[User][email]" maxlength="200" type="email" id="OrganizationLogo" required="required"/></td>
                    </tr>

                    <tr>
                        <th>password</th>
                        <td><input name="data[User][password]" maxlength="200" type="password" id="OrganizationLogo" required="required"/></td>
                    </tr>

                    <tr>
                        <th>Confirm Password</th>
                        <td><input name="data[User][confirm_password]" maxlength="200" type="password" required="required"/></td>
                    </tr>

                    <tr>
                        <th>Logo</th>
                        <td>
                             <input type="file" name="data[Organization][logo]" maxlength="255" type="text" id="OrganizationLogo" required="required"/>
                        </td>
                        <!-- <td><input name="data[User][dob]" maxlength="200" type="text" id="UserDob" required="required"/></td> -->
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td><input name="data[User][address]" maxlength="200" type="text" id="UserAddress" required="required"/></td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td><input name="data[Organization][address]" maxlength="200" type="text" id="OrganizationPhone" required="required"/></td>
                    </tr>

                    <tr>
                        <th>Fax</th>
                        <td><input name="data[Organization][fax]" maxlength="200" type="text" id="OrganizationFax" required="required"/></td>
                    </tr>

                    <tr>
                        <th>Website</th>
                        <td><input name="data[Organization][website]" maxlength="200" type="text" id="OrganizationWebsite" required="required"/></td>
                    </tr>

                    <tr>
                        <th>Country</th>
                        <td><select name="data[Organization][country_id]" id="OrganizationCountryId" required="required">
                            <?php foreach ($countries as $key => $country): ?>
                            <option value="<?php echo $key; ?>"><?php echo $country; ?></option>
                        <?php endforeach; ?>
                    </select></td>
                    </tr>

                    <tr>
                        <th>City</th>
                        <td> <select name="data[Organization][city_id]" id="OrganizationCityId" required="required">
                            <?php foreach ($cities as $key => $city): ?>
                            <option value="<?php echo $key; ?>"><?php echo $city; ?></option>
                        <?php endforeach; ?>
                        </select>
                        </td>
                    </tr>

                    <tr>
                        <th>Lat</th>
                        <td><input name="data[Organization][lat]" maxlength="200" type="text" id="OrganizationLat" required="required"/></td>
                    </tr>

                    <tr>
                        <th>Long</th>
                        <td><input name="data[Organization][long]" maxlength="200" type="text" id="OrganizationLong" required="required"/></td>
                    </tr>

                    <tr>
                        <th>Day</th>
                        <td>
                            <select name="data[Organization][day_id]" id="OrganizationDayId" required="required">
                            <?php foreach ($days as $key=>$day): ?>
                            <option value="<?php echo $key;?>"><?php echo $day;?></option>
                            <?php endforeach;?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input  type="submit" name="submit" value="Submit" class="rightbtn"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
</div><?php */?>

