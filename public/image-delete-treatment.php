<?php // require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php

//$image = null;
//
//if(isset($_GET['image_id'])){
//    $image = get_image_by_id($_GET['image_id']);
//}
//
//
//
//$patient = null;
//
//if(isset($_GET['p_id'])){
//    $patient = get_patient_by_id($_GET['p_id']);
//}
//
//
//
//if(!$image){
//    redirect_to("view-gallery.php?image_id={$image['id']}&p_id={$patient['id']}");
//}
//
//if(!$patient){
//   redirect_to("view-gallery.php?image_id={$image['id']}&p_id={$patient['id']}");
//}
//
//
//$query = "DELETE ";
//$query .= "FROM image ";
//$query .= "WHERE id = {$image['id']} ";
//$query .= "LIMIT 1";
//
//$result = mysqli_query($db_conx, $query);
//
//$query2 = "DELETE ";
//$query2 .= "FROM treatments_rec_images ";
//$query2 .= "WHERE image_id = {$image['id']} ";
//
//$result2 = mysqli_query($db_conx, $query2);
//
//if($result2 && mysqli_affected_rows($db_conx) == 1){
//    $_SESSION["message"] = "Image Deleted";
//    redirect_to("view-gallery.php?image_id={$image['id']}&p_id={$patient['id']}");
//}else{
//    $_SESSION["errors"] = "Image Deletion Failed". mysqli_error($db_conx);
//    redirect_to("view-gallery.php?image_id={$image['id']}&p_id={$patient['id']}");
//}

?>