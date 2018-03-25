<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php
if(isset($_POST['patient_id'])){
    redirect_to("patient.php?id={$_POST['patient_id']}");
}
redirect_to("patient.php?id={$_GET['id']}");
?>