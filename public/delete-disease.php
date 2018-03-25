<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php

$current_disease = get_disease_by_id($_GET['id']);

if(!$current_disease){
    redirect_to("diseases.php");
}

$disease_id = $current_disease['id'];

$query = "DELETE ";
$query .= "FROM disease ";
$query .= "WHERE id = {$disease_id} ";
$query .= "LIMIT 1";

$result = mysqli_query($db_conx, $query);

if($result && mysqli_affected_rows($db_conx) == 1){
    $_SESSION["message"] = "Disease <b>{$current_disease['name']}</b> Deleted";
    redirect_to("diseases.php");
}else{
    $_SESSION["errors"] = "Disease Deletion Failed". mysqli_error($db_conx);
    redirect_to("diseases.php");   
}

?>