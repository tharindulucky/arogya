<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php

$current_treatment = get_treatment_by_id($_GET['id']);

if(!$current_treatment){
    redirect_to("treatments.php");
}

$treatment_id = $current_treatment['id'];

$query = "DELETE ";
$query .= "FROM treatment ";
$query .= "WHERE id = {$treatment_id} ";
$query .= "LIMIT 1";

$result = mysqli_query($db_conx, $query);

if($result && mysqli_affected_rows($db_conx) == 1){
    $_SESSION["message"] = "Treatment <b>{$current_treatment['name']}</b> Deleted";
    redirect_to("treatments.php");
}else{
    $_SESSION["errors"] = "Treatment Deletion Failed". mysqli_error($db_conx);
    redirect_to("treatments.php");   
}

?>