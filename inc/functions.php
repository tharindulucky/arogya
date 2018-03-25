<?php


function redirect_to($new_location){
    header("Location: ". $new_location);
    exit;
}


function logged_in(){
    return (isset($_SESSION['user_id']));
}

function check_logged_in(){
    if(!logged_in()){
        redirect_to("login.php");
    }
}

function check_user_exists(){
    if(!user_exists()){
        redirect_to("logout.php");
    }
}

function user_exists(){
    if(isset($_SESSION['user_id'])){
        global $db_conx;
        $safe_user_id = filter($_SESSION['user_id']);

        $query = "SELECT * ";
        $query .= "FROM user ";
        $query .= "WHERE id = {$safe_user_id}";

        $result = mysqli_query($db_conx, $query);
        confirm_query($result);

        if(mysqli_num_rows($result) > 0){
            return TRUE;
        }  else {
            return FALSE;
        }
    }else {
        return FALSE;
    }
}

function confirm_query($result_set){
    global $db_conx;
    if(!$result_set){
       die("Fatal Error Occured : Database Query Failed <a href=\"error-report.php\">Report this error</a>".  mysqli_error($db_conx)); 
    }
}


function filter($unsafe_string){
    global $db_conx;
    $safe_string = mysqli_real_escape_string($db_conx, $unsafe_string);
    return $safe_string;
}

function filter_s($unsafe_string){
    global $db_conx;
    
    $safe_string = mysqli_real_escape_string($db_conx, $unsafe_string);
    $safe_string = str_replace(' ', '-', $safe_string);
    $safe_string = preg_replace('/[^A-Za-z0-9\-]/', '', $safe_string);
    $safe_string = strip_tags($safe_string);
    
    return $safe_string;
}


function password_check($password, $existing_hash){
    //$hash = crypt($password,$existing_hash);
    if($password === $existing_hash){
        return TRUE;
    }else{
        return FALSE;
    }
}

function login_attempt($email, $password){
    $user = get_user_by_email($email);
    if($user){
        //user found.
        //Now checking if the password matches
        if(password_check($password, $user['password'])){
            //password matches with the username
            return $user;
        }else{
            //password does not match
            return FALSE;
        }
    }else {
        //User not found.
        return FALSE;
    }
}

function get_user_by_email($email){
    global $db_conx;
    
    $safe_email = filter($email);
    
    $query = "SELECT * ";
    $query .= "FROM user ";
    $query .= "WHERE email = '{$safe_email}'";
 
    $result = mysqli_query($db_conx, $query);
    confirm_query($result);
    
    if($the_user = mysqli_fetch_assoc($result)){
        return $the_user;
    }  else {
        return NULL;
    }
}

function get_patients($limit){
    global $db_conx;
    
    $query = "SELECT * FROM patient ";
    
    if($limit > 0){
        $query .= "LIMIT {$limit}";
    }
    
    $result = mysqli_query($db_conx, $query);
    confirm_query($result);
    
        return $result;
}

function get_diseases(){
    global $db_conx;
    
    $query = "SELECT * FROM disease";
    
    $result = mysqli_query($db_conx, $query);
    confirm_query($result);
    
        return $result;
}


function get_treatments(){
    global $db_conx;
    
    $query = "SELECT * FROM treatment";
    
    $result = mysqli_query($db_conx, $query);
    confirm_query($result);
    
        return $result;
}

function get_patient_by_id($patient_id){
    global $db_conx;
    
    $safe_patient_id = filter_s($patient_id);
     
     $query = "SELECT * ";
     $query .= "FROM patient ";
     $query .= "WHERE id = {$safe_patient_id}";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Patient does not exists";
     }else{
            if( $the_patient = mysqli_fetch_assoc($result)){
                return $the_patient;
            }  else {
                return NULL;
            }
     }  
}



function get_disease_by_id($disease_id){
    global $db_conx;
    
    $safe_disease_id = filter_s($disease_id);
     
     $query = "SELECT * ";
     $query .= "FROM disease ";
     $query .= "WHERE id = {$safe_disease_id}";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Disease does not exists";
     }else{
            if( $the_disease = mysqli_fetch_assoc($result)){
                return $the_disease;
            }  else {
                return NULL;
            }
     }  
}


function get_disease_rec_by_id($disease_rec_id){
    global $db_conx;
    
    $safe_disease_rec_id = filter_s($disease_rec_id);
     
     $query = "SELECT * ";
     $query .= "FROM  diseases_record ";
     $query .= "WHERE id = {$safe_disease_rec_id}";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Disease Record does not exists";
     }else{
            if( $the_disease_rec = mysqli_fetch_assoc($result)){
                return $the_disease_rec;
            }  else {
                return NULL;
            }
     }  
}



function get_treatment_by_id($treatment_id){
    global $db_conx;
    
    $safe_treatment_id = filter_s($treatment_id);
     
     $query = "SELECT * ";
     $query .= "FROM treatment ";
     $query .= "WHERE id = {$safe_treatment_id}";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Treatment does not exists";
     }else{
            if( $the_treatment = mysqli_fetch_assoc($result)){
                return $the_treatment;
            }  else {
                return NULL;
            }
     }  
}

function count_patients(){
    global $db_conx;
     
     $query = "SELECT * ";
     $query .= "FROM patient ";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Cannot get the cout!";
     }else{
            if( $the_count = mysqli_num_rows($result)){
                return $the_count;
            }  else {
                return NULL;
            }
     } 
}


function count_pending_treatments(){
    global $db_conx;
     
     $query = "SELECT * ";
     $query .= "FROM pending_treatment WHERE completed = '0' ";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Cannot get the cout!";
     }else{
            if( $the_count = mysqli_num_rows($result)){
                return $the_count;
            }  else {
                return NULL;
            }
     } 
}

function count_completed_treatments(){
    global $db_conx;
     
     $query = "SELECT * ";
     $query .= "FROM pending_treatment WHERE completed = '1' ";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Cannot get the cout!";
     }else{
            if( $the_count = mysqli_num_rows($result)){
                return $the_count;
            }  else {
                return NULL;
            }
     } 
}


function get_disease_rec_by_patient_id($patient_id){
    global $db_conx;
    
    $safe_patient_id = filter_s($patient_id);
     
     $query = "SELECT * ";
     $query .= "FROM diseases_record ";
     $query .= "WHERE patient_id = {$safe_patient_id}";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    
     return $result; 
}


function get_treatment_rec_by_patient_id($patient_id){
    global $db_conx;
    
    $safe_patient_id = filter_s($patient_id);
     
     $query = "SELECT * ";
     $query .= "FROM pending_treatment ";
     $query .= "WHERE patient_id = {$safe_patient_id}";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    
     return $result; 
}


function get_teeth_by_disease_rec_id($disease_rec_id){
    global $db_conx;
    
    $safe_disease_rec_id = filter_s($disease_rec_id);
     
     $query = "SELECT * ";
     $query .= "FROM tooth_diseases_rec ";
     $query .= "WHERE disease_rec_id = {$safe_disease_rec_id}";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    
     return $result; 
}


function get_pending_treatment_rec_by_patient_id($patient_id){
    global $db_conx;
    
    $safe_patient_id = filter_s($patient_id);
     
     $query = "SELECT * ";
     $query .= "FROM pending_treatment ";
     $query .= "WHERE patient_id = {$safe_patient_id}";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    
     return $result; 
}



function get_all_treatment_recs_by_patient_id($patient_id){
    global $db_conx;
    
    $safe_patient_id = filter_s($patient_id);
     
     $query = "SELECT * ";
     $query .= "FROM pending_treatment ";
     $query .= "WHERE patient_id = {$safe_patient_id}";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    
     return $result; 
}


function get_completed_treatment_rec_by_patient_id($patient_id){
    global $db_conx;
    
    $safe_patient_id = filter_s($patient_id);
     
     $query = "SELECT * ";
     $query .= "FROM pending_treatment ";
     $query .= "WHERE patient_id = {$safe_patient_id} AND completed = '1'";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    
     return $result; 
}



function get_teeth_by_treatment_rec_id($treatment_rec_id){
    global $db_conx;
    
    $safe_treatment_rec_id = filter_s($treatment_rec_id);
     
     $query = "SELECT * ";
     $query .= "FROM tooth_treatment_rec ";
     $query .= "WHERE treatment_rec_id = {$safe_treatment_rec_id}";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    
     return $result; 
}


function get_treatment_rec_by_id($treatment_rec_id){
    global $db_conx;
    
    $safe_treatment_rec_id = filter_s($treatment_rec_id);
     
     $query = "SELECT * ";
     $query .= "FROM  pending_treatment ";
     $query .= "WHERE id = {$safe_treatment_rec_id}";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Treatment Record does not exists";
     }else{
            if( $the_treatment_rec = mysqli_fetch_assoc($result)){
                return $the_treatment_rec;
            }  else {
                return NULL;
            }
     }  
}


function get_images_by_patient_id($patient_id){
    global $db_conx;
    
    $safe_patient_id = filter_s($patient_id);
     
     $query = "SELECT * ";
     $query .= "FROM image ";
     $query .= "WHERE patient_id = {$safe_patient_id}";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    
     return $result; 
}


function get_images_by_disease_rec_id($disease_rec_id){
    global $db_conx;
    
    $safe_disease_rec_id = filter_s($disease_rec_id);
     
     $query = "SELECT * ";
     $query .= "FROM diseases_rec_images ";
     $query .= "WHERE disease_rec_id = {$safe_disease_rec_id}";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    
     return $result; 
}




function get_diseases_rec_images_by_disease_rec_id($disease_rec_id){
    global $db_conx;
    
    $safe_disease_rec_id = filter_s($disease_rec_id);
     
     $query = "SELECT * ";
     $query .= "FROM diseases_rec_images ";
     $query .= "WHERE disease_rec_id = {$safe_disease_rec_id}";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    
     return $result; 
}




function get_images_by_treatment_rec_id($treatment_rec_id){
    global $db_conx;
    
    $safe_treatment_disease_rec_id = filter_s($treatment_rec_id);
     
     $query = "SELECT * ";
     $query .= "FROM treatments_rec_images ";
     $query .= "WHERE treatment_rec_id = {$safe_treatment_disease_rec_id}";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    
     return $result; 
}



function count_patient_photos($patient_id){
    global $db_conx;
     
     $query = "SELECT * ";
     $query .= "FROM image WHERE patient_id = $patient_id ";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Cannot get the cout!";
     }else{
            if( $the_count = mysqli_num_rows($result)){
                return $the_count;
            }  else {
                return NULL;
            }
     } 
}


function get_image_by_id($image_id){
    global $db_conx;
    
    $safe_image_id = filter_s($image_id);
     
     $query = "SELECT * ";
     $query .= "FROM  image ";
     $query .= "WHERE id = {$safe_image_id}";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Image not exists";
     }else{
            if( $image = mysqli_fetch_assoc($result)){
                return $image;
            }  else {
                return NULL;
            }
     }  
}


function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (is_dir($dir."/".$object))
           rrmdir($dir."/".$object);
         else
           unlink($dir."/".$object); 
       } 
     }
     rmdir($dir); 
   } 
 }
 
 
 function count_diseases_rec_photos($record_id){
     global $db_conx;
     
     $safe_record_id = filter_s($record_id);
     
     $query = "SELECT * ";
     $query .= "FROM diseases_rec_images WHERE disease_rec_id = {$safe_record_id} ";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Cannot get the cout!".$query;
     }else{
            if( $the_count = mysqli_num_rows($result)){
                return $the_count;
            }  else {
                return NULL;
            }
     }
 }
 
 
 function count_treatments_rec_photos($record_id){
     global $db_conx;
     
     $safe_record_id = filter_s($record_id);
     
     $query = "SELECT * ";
     $query .= "FROM treatments_rec_images WHERE treatment_rec_id = {$safe_record_id} ";
     
     $result = mysqli_query($db_conx, $query);
     
     if(!$result){
         $_SESSION["errors"] = "Cannot get the cout!".$query;
     }else{
            if( $the_count = mysqli_num_rows($result)){
                return $the_count;
            }  else {
                return NULL;
            }
     }
 }
 
 
 function get_header($page_title){
     require_once('header.php');
 }