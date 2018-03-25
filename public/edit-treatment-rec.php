<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php

$current_treatment_log = null;
$current_patient = null;

if(isset($_GET['id'])){
    $current_treatment_log = get_treatment_rec_by_id($_GET['id']);
    $current_patient = get_patient_by_id($_GET['p_id']);
}

if(isset($_POST['submit'])){
    $affected_teeth = null;
    if(isset($_POST['teeth_group'])){
        $affected_teeth = $_POST['teeth_group'];
    }
    
    
    //validations
    $required_fields = array('date');
    validate_has_presense($required_fields,0);
    
    $required_fields = array('price');
    validate_is_numeric($required_fields);
    
    if(empty($errors)){
        $date = filter($_POST['date']);
        $treatment = filter($_POST['treatment']);
        $notes = filter($_POST['notes']);
        $price = filter($_POST['price']);
        
        $query = "UPDATE pending_treatment SET ";
        $query .= "datetime = '{$date}', ";
        $query .= "treatment = '{$treatment}', ";
        $query .= "note = '{$notes}', ";
        $query .= "price = {$price} ";
        $query .= "WHERE id = {$current_treatment_log['id']} ";
        $query .= "LIMIT 1";
       
        //echo $query;
        $result = mysqli_query($db_conx, $query);
        confirm_query($result);
        
        $query2 = "DELETE ";
        $query2 .= "FROM tooth_treatment_rec ";
        $query2 .= "WHERE treatment_rec_id = {$current_treatment_log['id']} ";
       

        $result2 = mysqli_query($db_conx, $query2);
        confirm_query($result2);
        
        if($result && $result2 && isset($affected_teeth)){
            foreach ($affected_teeth as $key => $value){
                
                    $query3 = "INSERT INTO tooth_treatment_rec(";
                    $query3 .= "tooth_id, treatment_rec_id, patient_id ";
                    $query3 .= ") VALUES(";
                    $query3 .= "'{$value}', '{$current_treatment_log['id']}', {$current_patient['id']}";
                    $query3 .= ");";

                    $result3 = mysqli_query($db_conx, $query3);
            
                    confirm_query($result3).mysqli_error($db_conx);
                    
            }
            
            
            if($result3){
                $_SESSION["message"] = "Treatment Log Updated";
                redirect_to("patient.php?id={$current_patient['id']}");
            }else{
                $_SESSION["errors"] = "Treatment Log not Updated ". mysqli_error($db_conx);
                redirect_to("patient.php?id={$current_patient['id']}");   
            }
            
        }
            
        
        if($result2){
                $_SESSION["message"] = "Treatment Log Updated";
                redirect_to("patient.php?id={$current_patient['id']}");
            }else{
                $_SESSION["errors"] = "Treatment Log not Updated3 ". mysqli_error($db_conx);
                redirect_to("patient.php?id={$current_patient['id']}");   
            }
        
    }
    
    
    
}
?>
<?php get_header("Edit Treatment Log");  ?>
    <div id="wrapper">

   <?php require_once('nav.php'); ?>

        <div id="page-wrapper">
            
             <form method="post" action="edit-treatment-rec.php?id=<?php echo $current_treatment_log['id'] ?>&p_id=<?php echo $current_patient['id'] ?>"> 
            
            <div class="row">
                
                <div class="col-lg-12">
                    <h2 class="page-header">Edit Treatment Log</h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <?php 
                echo message();
                errors();
                has_presense_errors($errors);
            ?>            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                   
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        Select Tooth
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                       <tbody>
                                        <tr class="warning">
                                                    <td colspan="8" ><small>Right Upper</small></td>
                                                    <td colspan="8" style="text-align:right"><small>Left Upper</small></td>
                                         </tr>
                                         <tr class="success">
                                                <td style="background-color:transparent;"></td>
                                                <td style="background-color:transparent;"></td>
                                                <td style="background-color:transparent;"></td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="RUE" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RUE"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?>
                                                        id="RUE"  class="rrrr" name="teeth_group[]" type="checkbox">E</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="RUD" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RUD"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RUD"  class="rrrr" class="rrrr" name="teeth_group[]" type="checkbox">D</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="RUC" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RUC"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RUC" class="rrrr" name="teeth_group[]" type="checkbox">C</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="RUB" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RUB"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RUB"  class="rrrr" name="teeth_group[]" type="checkbox">B</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="RUA" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RUA"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RUA" class="rrrr" name="teeth_group[]" type="checkbox">A</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="LUA" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LUA"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LUA" class="rrrr" name="teeth_group[]" type="checkbox">A</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="LUB" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LUB"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LUB" class="rrrr" name="teeth_group[]" type="checkbox">B</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="LUC" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LUC"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LUC" class="rrrr" name="teeth_group[]" type="checkbox">C</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="LUD" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LUD"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LUD" class="rrrr" name="teeth_group[]" type="checkbox">D</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="LUE" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LUE"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LUE" class="rrrr" name="teeth_group[]" type="checkbox">E</label>
                                                </td>
                                                <td style="background-color:transparent;"></td>
                                                <td style="background-color:transparent;"></td>
                                                <td style="background-color:transparent;"></td>
                                            </tr>

                                            <tr class="info">
                                                <td>
                                                    <label class="checkbox-inline"><input value="RU8" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RU8"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RU8" class="rrrr" name="teeth_group[]" type="checkbox">8</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU7" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RU7"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RU7" class="rrrr" name="teeth_group[]" type="checkbox">7</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU6" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RU6"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RU6" class="rrrr" name="teeth_group[]" type="checkbox">6</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU5" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RU5"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RU5" class="rrrr" name="teeth_group[]" type="checkbox">5</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU4" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RU4"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RU4" class="rrrr" name="teeth_group[]" type="checkbox">4</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU3" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RU3"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RU3" class="rrrr" name="teeth_group[]" type="checkbox">3</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU2" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RU2"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RU2" class="rrrr" name="teeth_group[]" type="checkbox">2</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU1" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RU1"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RU1" class="rrrr" name="teeth_group[]" type="checkbox">1</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU1" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LU1"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LU1" class="rrrr" name="teeth_group[]" type="checkbox">1</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU2" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LU2"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LU2" class="rrrr" name="teeth_group[]" type="checkbox">2</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU3" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LU3"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LU3" class="rrrr" name="teeth_group[]" type="checkbox">3</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU4" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LU4"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LU4" class="rrrr" name="teeth_group[]" type="checkbox">4</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU5" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LU5"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LU5" class="rrrr" name="teeth_group[]" type="checkbox">5</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU6" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LU6"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LU6" class="rrrr" name="teeth_group[]" type="checkbox">6</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU7" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LU7"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LU7" class="rrrr" name="teeth_group[]" type="checkbox">7</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU8" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LU8"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LU8" class="rrrr" name="teeth_group[]" type="checkbox">8</label>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL8" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RL8"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RL8" class="rrrr" name="teeth_group[]" type="checkbox">8</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL7" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RL7"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RL7" class="rrrr" name="teeth_group[]" type="checkbox">7</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL6" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RL6"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RL6" class="rrrr" name="teeth_group[]" type="checkbox">6</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL5" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RL5"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RL5" class="rrrr" name="teeth_group[]" type="checkbox">5</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL4" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RL4"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RL4" class="rrrr" name="teeth_group[]" type="checkbox">4</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL3" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RL3"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RL3" class="rrrr" name="teeth_group[]" type="checkbox">3</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL2" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RL2"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RL2" class="rrrr" name="teeth_group[]" type="checkbox">2</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL1" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RL1"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RL1" class="rrrr" name="teeth_group[]"  type="checkbox">1</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL1" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LL1"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LL1" class="rrrr" name="teeth_group[]" type="checkbox">1</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL2"
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LL2"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LL2" class="rrrr" name="teeth_group[]" type="checkbox">2</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL3" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LL3"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LL3" class="rrrr" name="teeth_group[]" type="checkbox">3</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL4" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LL4"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LL4" class="rrrr" name="teeth_group[]" type="checkbox">4</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL5" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LL5"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LL5" class="rrrr" name="teeth_group[]" type="checkbox">5</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL6" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LL6"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LL6" class="rrrr" name="teeth_group[]" type="checkbox">6</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL7" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LL7"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LL7" class="rrrr" name="teeth_group[]" type="checkbox">7</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL8" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LL8"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LL8" class="rrrr" name="teeth_group[]" type="checkbox">8</label>
                                                </td>
                                            </tr>

                                                    <tr class="success">
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td>
                                                            <label class="checkbox-inline"><input 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RLE"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> value="RLE" id="RUE" class="rrrr"  name="teeth_group[]" type="checkbox">E</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLD" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RLD"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RLD" class="rrrr" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLC" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RLC"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RLC" class="rrrr" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLB" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RLB"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RLB" class="rrrr" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLA" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "RLA"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="RLA" class="rrrr" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLA" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LLA"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LLA" class="rrrr" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLB" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LLB"){
                                                                     echo " checked ";
                                                                 }
                                                              }
                                                             ?> id="LLB" class="rrrr" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLC" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LLC"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LLC" class="rrrr" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLD" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LLD"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LLD" class="rrrr" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLE" 
                                                             <?php
                                                             $affected_teeth = get_teeth_by_treatment_rec_id($current_treatment_log['id']);
                                                             while($teeth_set = mysqli_fetch_assoc($affected_teeth)){
                                                                 if($teeth_set['tooth_id'] == "LLE"){
                                                                     echo " checked ";
                                                                 }
                                                             }
                                                             ?> id="LLE" class="rrrr" name="teeth_group[]" type="checkbox">E</label>
                                                        </td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                    </tr>
                                                    <tr class="warning">
                                                            <td colspan="8" ><small>Right Lower</small></td>
                                                            <td colspan="8" style="text-align:right"><small>Left Lower</small></td>
                                                    </tr>
                                </tbody>
                        </table>
                </div>

                                                   
            <!-- /.table-responsive -->

              </div>
    
        </div>
</div>
            <!-- /.row -->
            
            
            
            
            
            
             <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit Details
			</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                  <div style="padding: 10px;">
                                       <script type="text/javascript">
                                            $(window).load(function(){
                                            $('#datetimepicker2').datetimepicker();
                                            });
                                       </script>
                                               <div class="form-group">
                                                    <label  class="col-sm-2 control-label">Date & Time</label>
                                                    <div class="input-group date col-sm-8"  style="padding-left: 14px" id="datetimepicker2">
                                                        <input class="form-control" value="<?php echo $current_treatment_log['datetime'] ?>" type="text" name="date"><span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                                                    </div>
                                                  </div>
                                                  <br>
                                                <div class="form-group">
                                                    <label  class="col-sm-2 control-label">Treatment</label>
                                                    <div class="col-sm-10">
                                                       <select class="form-control" name="treatment">
                                                            <?php
                                                            $result = get_treatments();
                                                            
                                                            
                                                            
                                                            while($treatment_set = mysqli_fetch_assoc($result)){
                                                                
                                                                
                                                            ?>
                                                            <option  
                                                                
                                                                <?php
                                                                    if($current_treatment_log['treatment'] == $treatment_set['name']){
                                                                        echo " selected ";
                                                                    }
                                                                ?>
                                                                
                                                                value="<?php echo $treatment_set['name']; ?>"><?php echo $treatment_set['name']; ?></option>

                                                            <?php
                                                            }
                                                            
                                                            ?>
                                                       </select>
                                                    </div>
                                                  </div>
                                                  <br><br>
                                                  <div class="form-group">
                                                    <label class="col-sm-2 control-label">Note</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="notes" value="<?php echo $current_treatment_log['note'] ?>" id="notes" placeholder="Notes"/>
                                                    </div>
                                                  </div>
                                                  
                                                  <br><br>
                                                  <div class="form-group">
                                                    <label class="col-sm-2 control-label">Charge</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="price" value="<?php echo $current_treatment_log['price'] ?>" id="notes" placeholder="Notes"/>
                                                    </div>
                                                  </div>
                                                  
                                                  
                                                  
                                                  <br><br> <br>
                                                  <div class="form-group">
                                                      <div class="col-sm-8">
                                                          <a href="patient.php?id=<?php echo $current_patient['id']; ?>" class="btn btn-default">Cancel</a>
                                                           <input type="submit" class="btn btn-primary" name="submit" value="Update Log">
                                                      </div>
                                                  </div>
                               
              
                                    </div> 
                            </div>
                            <!-- /.table-responsive -->
                          
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                   
              
                </div>
                <!-- /.col-lg-12 -->
            </div>
             
              
            <!-- /.row -->
            <!-- Modal -->
            </form>
                            <!-- /.modal -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php require_once('footer.php'); ?>