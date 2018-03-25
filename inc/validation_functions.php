<?php
/*
 * Contains all the reusable validation functions 
 */

$errors = array();

function make_it_cute($field_name){
    $field_name = str_replace("_", " ", $field_name);
    $field_name = ucfirst($field_name);
    return $field_name;
}



function has_presense($value){
    return isset($value)&& $value !== "";
}

function validate_has_presense($required_fields){
    global $errors;
    
    foreach ($required_fields as $field){
        $value = trim($_POST[$field]);
        if(!has_presense($value)){
            $errors[$field] = "Please enter patient's ".make_it_cute($field);
        }
    }
}


function validate_is_numeric($required_fields){
    global $errors;
    
    foreach ($required_fields as $field){
        $value = trim($_POST[$field]);
        
        if(!empty($value)){
           if(!is_numeric($value)){
                $errors[$field] = "Patient's ".make_it_cute($field)." is not valid";
            } 
        }
        
    }
}


function check_length($field, $max_length){
    global $errors;
    if(strlen($_POST[$field]) > $max_length){
        $errors[$field] = "Patient's ".make_it_cute($field)." has too many characters";
    }
}



function already_has_patient($email){
    global $db_conx;
    global $errors;
    
    $query2 = "SELECT * FROM patient ";
    $query2 .= "WHERE email = '{$email}'";

    $result2 = mysqli_query($db_conx, $query2);

    if(mysqli_num_rows($result2) != 0){
        $errors['duplicate_patient'] = "This patient is already in your database.";
        //$_SESSION["errors"] = "This patient is already in your database.";
        return true;
    }else{
        return false;
    }

}

function already_has_disease($name){
    global $db_conx;
    global $errors;
    $query = "SELECT * FROM disease ";
    $query .= "WHERE name = '{$name}'";

    $result = mysqli_query($db_conx, $query);
    

    if(mysqli_num_rows($result)){
        $errors['duplicate_disease'] = "This disease is already in your database.";
        $_SESSION["errors"] = "This disease is already in your database.";
        return true;
    }else{
        return false;
    }

}


function already_has_treatment($name){
    global $db_conx;
    global $errors;
    $query = "SELECT * FROM treatment ";
    $query .= "WHERE name = '{$name}'";

    $result = mysqli_query($db_conx, $query);
    

    if(mysqli_num_rows($result)){
        $errors['duplicate_treatment'] = "This treatment is already in your database.";
        $_SESSION["errors"] = "This treatment is already in your database.";
        return true;
    }else{
        return false;
    }

}