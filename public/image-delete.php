<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php


if(isset($_GET['image_id']) && isset($_GET['p_id']) && isset($_GET['disease_rec_id'])){
    
    
    
    $image = get_image_by_id($_GET['image_id']);
    $patient = get_patient_by_id($_GET['p_id']);
    $disease_rec = get_disease_rec_by_id($_GET['disease_rec_id']);
    
    if(!empty($image) && !empty($patient) && !empty($disease_rec)){
        
        $query = "DELETE ";
        $query .= "FROM image ";
        $query .= "WHERE id = {$image['id']} ";
        $query .= "LIMIT 1";

        $result = mysqli_query($db_conx, $query);

        $query2 = "DELETE ";
        $query2 .= "FROM diseases_rec_images ";
        $query2 .= "WHERE image_id = {$image['id']} ";

        $result2 = mysqli_query($db_conx, $query2);

        if($result2 && mysqli_affected_rows($db_conx) == 1){
            
            $image_url = "uploads/{$patient['id']}/diseases/{$disease_rec['id']}/{$image['url']}";
            unlink("$image_url");
            
            $_SESSION["message"] = "Image Deleted";
            redirect_to("view-gallery.php?p_id={$patient['id']}&disease_rec_id={$disease_rec['id']}");
        }else{
            $_SESSION["errors"] = "Image Deletion Failed". mysqli_error($db_conx);
            redirect_to("view-gallery.php?p_id={$patient['id']}&disease_rec_id={$disease_rec['id']}");
        }
    }else{
        $_SESSION["errors"] = "No image found for that ID";
        redirect_to("view-gallery.php?p_id={$patient['id']}&disease_rec_id={$disease_rec['id']}");
    }
   
    
}

if(isset($_GET['image_id']) && isset($_GET['p_id']) && isset($_GET['treatment_rec_id'])){
    
    $image = get_image_by_id($_GET['image_id']);
    $patient = get_patient_by_id($_GET['p_id']);
    $treatment_rec = get_treatment_rec_by_id($_GET['treatment_rec_id']);
    
    if(!empty($image) && !empty($patient) && !empty($treatment_rec)){
        
        $query = "DELETE ";
        $query .= "FROM image ";
        $query .= "WHERE id = {$image['id']} ";
        $query .= "LIMIT 1";

        $result = mysqli_query($db_conx, $query);

        $query2 = "DELETE ";
        $query2 .= "FROM treatments_rec_images ";
        $query2 .= "WHERE image_id = {$image['id']} ";

        $result2 = mysqli_query($db_conx, $query2);

        if($result2 && mysqli_affected_rows($db_conx) == 1){
            
            $image_url = "uploads/{$patient['id']}/treatments/{$treatment_rec['id']}/{$image['url']}";
            unlink("$image_url");
            
            $_SESSION["message"] = "Image Deleted";
            redirect_to("view-gallery.php?p_id={$patient['id']}&treatment_rec_id={$treatment_rec['id']}");
        }else{
            $_SESSION["errors"] = "Image Deletion Failed". mysqli_error($db_conx);
            redirect_to("view-gallery.php?p_id={$patient['id']}&treatment_rec_id={$treatment_rec['id']}");
        }
    }else{
        $_SESSION["errors"] = "No image found";
        redirect_to("view-gallery.php?p_id={$patient['id']}&treatment_rec_id={$treatment_rec['id']}");
    }
    
    
    
}




?>