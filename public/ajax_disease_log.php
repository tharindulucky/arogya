<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>


<div class="dataTable_wrapper" id="disease_log">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                        <tr>
                                <th>ID</th>
                                <th>Date & Time</th>
                                <th>Medical Diseases & Conditions</th>
                                <th>Affected Teeth</th>
                                <th>Images</th>
                                <th>Notes</th>
                                <th>Actions</th>
                        </tr>
                </thead>
                <tbody>
<?php

if(isset($_GET['t_id'])){
    
    $idsArray = explode(',', $_GET['t_id']);
    $idsArray = array_filter($idsArray);
    
    //var_dump($idsArray);
    
    $current_teeth = filter($_GET['t_id']);
    $current_patient = get_patient_by_id($_GET['p_id']);
    
    if(sizeof($idsArray) > 0){
        
        $query = "SELECT * ";
        $query .= "FROM tooth_diseases_rec ";
        $query .= "WHERE ";
        foreach ($idsArray as $key => $value){
            $query .= "tooth_id = '".$value."' OR ";
        }
        $query = substr($query, 0, -3);
        $query .= " AND patient_id = {$current_patient['id']}";

        //echo $query;
        $result = mysqli_query($db_conx, $query);
        confirm_query($result);
        
        $i=0;
        while($teeth_set = mysqli_fetch_assoc($result)){
            $disease_record_ids[$i] = $teeth_set['disease_rec_id'];
            $i++;
        }
        
        if(!empty($disease_record_ids)){
            $disease_record_ids = array_unique($disease_record_ids);
            //var_dump($disease_record_ids);
       
        

        foreach($disease_record_ids as $key => $value){

                $query2 = "SELECT * ";
                $query2 .= "FROM diseases_record ";
                $query2 .= "WHERE id = {$value}";
                //echo $query2;
                $result2 = mysqli_query($db_conx, $query2);
                confirm_query($result2);

                while ($disease_rec_set = mysqli_fetch_assoc($result2)){

    ?>



                        <tr>
                            <td><?php echo $disease_rec_set['id']; ?></td>
                            <td><?php echo $disease_rec_set['datetime']; ?></td>
                            <td><?php echo$disease_rec_set['condition_name'];?> </td>
                            <td>
                                <?php

                                    $result3 = get_teeth_by_disease_rec_id($disease_rec_set['id']);
                                    while ($affected_teeth_set = mysqli_fetch_assoc($result3)){
                                        echo $affected_teeth_set['tooth_id'].", ";
                                    }
                                ?>
                            </td>
                            <td><button class="open_uploader_disease_rec btn btn-success btn-circle" type="button" data-disease_rec_id="<?php echo $disease_rec_set['id']; ?>"  data-toggle="modal" data-target="#image_gallery" ><i class="fa fa-camera"></i></button></td>
                            <td><?php echo $disease_rec_set['note']; ?></td>
                            <td class="center">
                                    <a href="edit-disease.php?id=<?php echo $disease_rec_set['id']; ?>" id="ttt" style="align:right" class="btn btn-info btn-circle" ><i class="fa fa-pencil"></i></a>
                                    <a onclick="return confirm('Are you sure ?')" href="delete-disease-rec.php?id=<?php echo $disease_rec_set['id']; ?>&p_id=<?php echo $current_patient['id']; ?>" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>

    <?php





                }

        }
        }   
    }else{
        $result3 = get_disease_rec_by_patient_id($current_patient['id']);
        while($diseases_rec_set = mysqli_fetch_assoc($result3)){
        ?>
        <tr>
            <td><?php echo $diseases_rec_set['id']; ?></td>
            <td><?php echo $diseases_rec_set['datetime']; ?></td>
            <td><?php echo $diseases_rec_set['condition_name'];?> </td>
            <td>
                <?php

                    $result4 = get_teeth_by_disease_rec_id($diseases_rec_set['id']);
                    while ($affected_teeth_set = mysqli_fetch_assoc($result4)){
                        echo $affected_teeth_set['tooth_id'].", ";
                    }
                ?>
            </td>
            <td><button class="open_uploader_disease_rec btn btn-success btn-circle" type="button" data-disease_rec_id="<?php echo $diseases_rec_set['id']; ?>"  data-toggle="modal" data-target="#image_gallery" ><i class="fa fa-camera"></i></button></td>
            <td><?php echo $diseases_rec_set['note']; ?></td>
            <td class="center">
                    <a href="edit-disease.php?id=<?php echo $diseases_rec_set['id']; ?>" id="ttt" style="align:right" class="btn btn-info btn-circle" ><i class="fa fa-pencil"></i></a>
                    <a onclick="return confirm('Are you sure ?')" href="delete-disease-rec.php?id=<?php echo $diseases_rec_set['id']; ?>&p_id=<?php echo $current_patient['id']; ?>" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></a>
            </td>
        </tr>
        <?php
        }
    }
   

}
?>

	</tbody>
</table>