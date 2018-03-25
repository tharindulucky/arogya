<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php

if(isset($_GET['id']) && isset($_GET['p_id'])){
    
    $current_disease_rec = get_disease_rec_by_id($_GET['id']);
    $current_patient = get_patient_by_id($_GET['p_id']);
    
    if(!empty($current_disease_rec['id']) && !empty($current_patient['id'])){
        
        $image = get_images_by_disease_rec_id($current_disease_rec['id']);

        while($single_image = mysqli_fetch_assoc($image)){
            $query4 = "DELETE ";
            $query4 .= "FROM image ";
            $query4 .= "WHERE id = {$single_image['image_id']} ";

            $result4 = mysqli_query($db_conx, $query4);
        }



        $disease_rec_id = $current_disease_rec['id'];

        $query = "DELETE ";
        $query .= "FROM  diseases_record ";
        $query .= "WHERE id = {$current_disease_rec['id']} ";
        $query .= "LIMIT 1";

        $result = mysqli_query($db_conx, $query);



        $query2 = "DELETE ";
        $query2 .= "FROM tooth_diseases_rec ";
        $query2 .= "WHERE disease_rec_id = {$current_disease_rec['id']} ";

        $result2 = mysqli_query($db_conx, $query2);




        $query3 = "DELETE ";
        $query3 .= "FROM diseases_rec_images ";
        $query3 .= "WHERE disease_rec_id = {$current_disease_rec['id']} ";

        $result3 = mysqli_query($db_conx, $query3);


        if($query){
            
            
            $disease_rec_dir = "uploads/{$current_patient['id']}/diseases/{$current_disease_rec['id']}";
            
            
            if (file_exists($disease_rec_dir)) {
                rrmdir($disease_rec_dir);
            }
            
            
            $_SESSION["message"] = "Disease Record Deleted";
            redirect_to("patient.php?id={$current_patient['id']}");
        }else{
            $_SESSION["errors"] = "Disease Record Deletion Failed ". mysqli_error($db_conx);
            redirect_to("patient.php?id={$current_patient['id']}");   
        }
    }else{
        $_SESSION["errors"] = "Record Not Found ";
        redirect_to("patient.php");   
    }
    
}else{
    $_SESSION["errors"] = "Record Not Found ";
    redirect_to("patient.php");  
}






?>