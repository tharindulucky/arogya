<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php

if(isset($_GET['p_id']) && isset($_GET['disease_rec_id'])){
    
    $disease_rec = get_disease_rec_by_id($_GET['disease_rec_id']);
    $patient = get_patient_by_id($_GET['p_id']);
    
     $query = "SELECT * ";
     $query .= "FROM diseases_rec_images ";
     $query .= "WHERE disease_rec_id = {$disease_rec['id']}";
     
     $result = mysqli_query($db_conx, $query);
     confirm_query($result);
    echo '<a title="View Photos" href="view-gallery.php?p_id='.$patient['id'].'&disease_rec_id='.$disease_rec['id'].'">';
    
     while ($images_set = mysqli_fetch_assoc($result)){
         $image = get_image_by_id($images_set['image_id']);
         echo '<div style="width:100px; height:100px; background:url(\'http://'.$_SERVER["HTTP_HOST"].'/projects/dental/public/uploads/'.$patient['id']."/diseases/".$disease_rec['id']."/".$image['url'].'\'); background-size:cover; float:left; margin:3px;"></div>';
     }
     
     echo '</a>';
     
     if (mysqli_num_rows($result) == 0) {
        echo "No images found";
     }
     
     echo '<div style="clear:both; line-height:1px;"></div>';
     echo "</div>";
}


?>