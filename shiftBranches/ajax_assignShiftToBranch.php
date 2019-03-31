<?php
include('../httpful.phar');
include('../config1.php');
//define("URL", "http://localhost/newshiftmate/");
//define("URL_VIEW", "http://localhost/shiftmate/");


if (isset($_POST['data']['ShiftBranch'])) {
   
    

    if(!empty($_POST['data']))
    {
        $url = URL . "ShiftBranches/assignShiftToBranch.json";
        $response = \Httpful\Request::post($url)
        ->sendsJson()
        ->body($_POST['data'])
        ->send();
     }
}
?>


