<?php
require_once '../calendarApi/vendor/autoload.php';
require_once '../config.php';
session_start();
$client = new Google_Client();
$client->setAuthConfigFile(URL_VIEW.'calendarApi/client_secret.json');
$client->setRedirectUri(URL_VIEW.'ShiftUsers/oauth2callback.php');
$client->addScope(Google_Service_Calendar::CALENDAR);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect_uri = URL_VIEW.'ShiftUsers/myShiftCalendar?succAuthCal=1&org_id='.$_SESSION['org_id'].'&board_id='.$_SESSION['board_id'].'&branch_id='.$_SESSION['branch_id'];  
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>