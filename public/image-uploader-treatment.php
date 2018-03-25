<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php

$patient = null;

if(isset($_POST['p_id'])){
    $patient = get_patient_by_id($_POST['p_id']);
}

if(isset($_POST['treatment_rec_id'])){
    $treatment_rec_id = filter($_POST['treatment_rec_id']);
}


$ds = DIRECTORY_SEPARATOR; 
 
$storeFolder = "uploads/{$patient['id']}/treatments/{$treatment_rec_id}";  
 
if (!empty($_FILES)) {
 
    $tempFile = $_FILES['file']['tmp_name'];         
 
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds; 
 
    $targetFile =  $targetPath. $_FILES['file']['name']; 
 
    move_uploaded_file($tempFile,$targetFile);
    
        $query = "INSERT INTO image(";
        $query .= "url, patient_id";
        $query .= ") VALUES(";
        $query .= "'{$_FILES['file']['name']}', {$patient['id']}";
        $query .= ");";

        $resultr = mysqli_query($db_conx, $query);
        $image_id = mysqli_insert_id($db_conx);
        confirm_query($resultr);
        
        if($resultr){
            
            $query2 = "INSERT INTO treatments_rec_images(";
            $query2 .= "treatment_rec_id, image_id";
            $query2 .= ") VALUES(";
            $query2 .= "'{$treatment_rec_id}', {$image_id}";
            $query2 .= ");";
            
            $resultr2 = mysqli_query($db_conx, $query2);
            confirm_query($resultr2);
            
            $_SESSION['message'] = "Image uploaded successfully";
        }else{
            $_SESSION['errors'] = "Image not uploaded";
        }
    
       
 
} else {                                                           
    $result  = array();
 
    $files = scandir($storeFolder);                 //1
    if ( false!==$files ) {
        foreach ( $files as $file ) {
            if ( '.'!=$file && '..'!=$file) {       //2
                $obj['name'] = $file;
                $obj['size'] = filesize($storeFolder.$ds.$file);
                $result[] = $obj;
            }
        }
        
         
        
    
        
    }
     
    header('Content-type: text/json');              //3
    header('Content-type: application/json');
    echo json_encode($result);
    
        
    
}
?>