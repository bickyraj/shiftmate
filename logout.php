<?php
include('config.php');
session_start();
session_destroy();
// setcookie('remember_me_cookie','', -1,"/");
header('location:'.URL_VIEW);
?>