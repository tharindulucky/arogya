<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php
$patient_id = filter($_GET['p_id']);

redirect_to("patient.php?id={$patient_id}");
?>