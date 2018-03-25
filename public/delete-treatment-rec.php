<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php

if(isset($_GET['id']) && isset($_GET['p_id'])){
    
    $current_treatment_rec = get_treatment_rec_by_id($_GET['id']);
    $current_patient = get_patient_by_id($_GET['p_id']);
    
    if(!empty($current_treatment_rec['id']) && !empty($current_patient['id'])){
        
        $image = get_images_by_treatment_rec_id($current_treatment_rec['id']);

        while($single_image = mysqli_fetch_assoc($image)){
            $query4 = "DELETE ";
            $query4 .= "FROM image ";
            $query4 .= "WHERE id = {$single_image['image_id']} ";

            $result4 = mysqli_query($db_conx, $query4);
        }
        
        
        

        $query = "DELETE ";
        $query .= "FROM  pending_treatment ";
        $query .= "WHERE id = {$current_treatment_rec['id']} ";
        $query .= "LIMIT 1";

        $result = mysqli_query($db_conx, $query);
        
        
        
        $query2 = "DELETE ";
        $query2 .= "FROM tooth_treatment_rec ";
        $query2 .= "WHERE treatment_rec_id = {$current_treatment_rec['id']} ";

        $result2 = mysqli_query($db_conx, $query2);
        
        
        $query3 = "DELETE ";
        $query3 .= "FROM treatments_rec_images ";
        $query3 .= "WHERE treatment_rec_id = {$current_treatment_rec['id']} ";

        $result3 = mysqli_query($db_conx, $query3);
        
        if($query){
            
            $treatment_rec_dir = "uploads/{$current_patient['id']}/treatments/{$current_treatment_rec['id']}";
            
            
            if (file_exists($treatment_rec_dir)) {
                rrmdir($treatment_rec_dir);
            }
            
            $_SESSION["message"] = "Treatment Record Deleted";
            redirect_to("patient.php?id={$current_patient['id']}");
        }else{
            $_SESSION["errors"] = "Treatment Record Deletion Failed ". mysqli_error($db_conx);
            redirect_to("patient.php?id={$current_patient['id']}");   
        }
    }else{
        $_SESSION["errors"] = "Record Not Found ";
        redirect_to("patient.php");   
    }
    
}

?>