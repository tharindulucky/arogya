<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php



if(isset($_GET['id'])){
    
    $current_patient = get_patient_by_id($_GET['id']);
    
    if(!empty($current_patient['id'])){
        
        
        
        $disease_rec = get_disease_rec_by_patient_id($current_patient['id']);
                
        while($single_disease_rec = mysqli_fetch_assoc($disease_rec)){

            $query3 = "DELETE ";
            $query3 .= "FROM diseases_rec_images ";
            $query3 .= "WHERE disease_rec_id = {$single_disease_rec['id']} ";

            $result3 = mysqli_query($db_conx, $query3);
        }
        
        
        
         
        $treatment_rec = get_treatment_rec_by_patient_id($current_patient['id']);
                
        while($single_treatment_rec = mysqli_fetch_assoc($treatment_rec)){

            $query5 = "DELETE ";
            $query5 .= "FROM treatments_rec_images ";
            $query5 .= "WHERE treatment_rec_id = {$single_treatment_rec['id']} ";

            $result5 = mysqli_query($db_conx, $query5);
        }
        
        
        
        $images = get_images_by_patient_id($current_patient['id']);

        while($single_image = mysqli_fetch_assoc($images)){
            $query4 = "DELETE ";
            $query4 .= "FROM image ";
            $query4 .= "WHERE id = {$single_image['id']} ";

            $result4 = mysqli_query($db_conx, $query4);
        }

        
        
        
        $query2 = "DELETE ";
        $query2 .= "FROM tooth_diseases_rec ";
        $query2 .= "WHERE patient_id = {$current_patient['id']} ";

        $result2 = mysqli_query($db_conx, $query2);
        
        
        $query21 = "DELETE ";
        $query21 .= "FROM tooth_treatment_rec ";
        $query21 .= "WHERE patient_id = {$current_patient['id']} ";

        $result21 = mysqli_query($db_conx, $query21);
        
        
        
        $query = "DELETE ";
        $query .= "FROM  diseases_record ";
        $query .= "WHERE patient_id = {$current_patient['id']} ";

        $result = mysqli_query($db_conx, $query);
        
        
        
        
        
        
        
        $query1 = "DELETE ";
        $query1 .= "FROM  pending_treatment ";
        $query1 .= "WHERE patient_id = {$current_patient['id']} ";

        $result1 = mysqli_query($db_conx, $query1);


        
        
        $query6 = "DELETE ";
        $query6 .= "FROM patient ";
        $query6 .= "WHERE id = {$current_patient['id']} ";
        $query6 .= "LIMIT 1";

        $result6 = mysqli_query($db_conx, $query6);
        
        

        if($result6){
            
            $patient_dir = "uploads/{$current_patient['id']}";
            
            if (file_exists($patient_dir)) {
                rrmdir($patient_dir);
            }
            
            
             $_SESSION["message"] = "Patient <b>{$current_patient['name']}</b> and his records Deleted";
             redirect_to("patients.php");
        }else{
            $_SESSION["errors"] = "Patient Deletion Failed". mysqli_error($db_conx);
            redirect_to("patients.php");   
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






