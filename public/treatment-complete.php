<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php

$current_treatment_rec = get_treatment_rec_by_id($_GET['id']);
$current_patient = get_patient_by_id($_GET['p_id']);

if(!$current_treatment_rec){
    redirect_to("patient.php");
}

$treatment_rec_id = $current_treatment_rec['id'];

$query = "UPDATE pending_treatment SET ";
$query .= "completed = '1' ";
$query .= "WHERE id = {$current_treatment_rec['id']} ";
$query .= "LIMIT 1";

$result = mysqli_query($db_conx, $query);

if($result){
    $_SESSION["message"] = "Treatment Record Marked  <b>Completed </b>";
    redirect_to("patient.php?id={$current_patient['id']}");
}else{
    $_SESSION["errors"] = "Treatment Record Not Marked <b>Completed </b>". mysqli_error($db_conx);
    redirect_to("patient.php?id={$current_patient['id']}");   
}

?>