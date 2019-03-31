<?php
    require_once('config.php');
    $action=$_POST['action'];
    switch($action){
        case 'approveRequest':
            if(isset($_POST['leaverequestid']) && isset($_POST['opt'])){
                $url= URL."Leaverequests/respondRequest/".$_POST['leaverequestid']."/".$_POST['opt'].".json";
                $response=\Httpful\Request::get($url)->send();
                echo json_encode($response);
            }
        break;
        case 'getOrgProfile':
            if(isset($_POST['orgid'])){
                $url=URL."Organizations/organizationProfile/".$_POST['orgid'].".json";
                $response=\Httpful\Request::get($url)->send();
                echo json_encode($response->body->output);
            }
        break;
    }
?>