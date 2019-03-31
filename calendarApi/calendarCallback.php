<?php 

require_once __DIR__ . '/vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfigFile(URL_VIEW.'calendarApi/client_secrets.json');
$client->addScope(Google_Service_Calendar::CALENDAR);


if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  // header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
?>

<script>
        window.location="<?php echo filter_var($auth_url, FILTER_SANITIZE_URL);?>";
    </script>
<?php
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  // $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/shiftmate_view/myShifts/myShiftCalendar';
  $redirect_uri = URL_VIEW.'myShifts/myShiftCalendar';
  // header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  $_SESSION['succAuthCal'] = 1;
?>

<script>
    window.location="<?php echo filter_var($redirect_uri, FILTER_SANITIZE_URL);?>";
</script>
<?php 
}