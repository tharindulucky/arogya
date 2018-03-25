<?php session_start() ?>
<?php require_once('../inc/functions.php');  ?>
<?php check_logged_in() ?>
<?php
$_SESSION['user_id'] = NULL;
$_SESSION['username'] = NULL;

redirect_to("login.php");

?>