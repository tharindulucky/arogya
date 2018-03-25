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
                                <th>Treatment</th>
                                <th>Affected Teeth</th>
                                <th>Images</th>
                                <th>Notes</th>
                                <th>Charge</th>
                                <th>Status</th>
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
        $query .= "FROM tooth_treatment_rec ";
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
            $treatment_record_ids[$i] = $teeth_set['treatment_rec_id'];
            $i++;
        }
        
        
        if(!empty($treatment_record_ids)){
        
        $treatment_record_ids = array_unique($treatment_record_ids);
        //var_dump($disease_record_ids);

        foreach($treatment_record_ids as $key => $value){

                $query2 = "SELECT * ";
                $query2 .= "FROM pending_treatment ";
                $query2 .= "WHERE id = {$value}";

                $result2 = mysqli_query($db_conx, $query2);
                confirm_query($result2);

                while ($treatment_rec_set = mysqli_fetch_assoc($result2)){

    ?>

                        <tr style="background-color: <?php echo $treatment_rec_set['completed'] == '1' ? '#d6e9c6' : '#fcf8e3' ?>">
                            <td><?php echo $treatment_rec_set['id']; ?></td>
                            <td><?php echo $treatment_rec_set['datetime']; ?></td>
                            <td><?php echo $treatment_rec_set['treatment'];?></td>
                            <td>
                                <?php
                                    $result3 = get_teeth_by_treatment_rec_id($treatment_rec_set['id']);
                                    while ($affected_teeth_set = mysqli_fetch_assoc($result3)){
                                        echo $affected_teeth_set['tooth_id'].", ";
                                    }
                                ?>
                            </td>
                            <td><button type="button"  data-toggle="modal" data-target="#image_gallery_treatment" data-treatment_rec_id="<?php echo $treatment_rec_set['id']; ?>" class="btn btn-warning btn-circle open_uploader_treatment_rec"><i class="fa fa-camera"></i></button></td>
                            <td><?php echo $treatment_rec_set['note']; ?></td>
                            <td><?php echo $treatment_rec_set['price']; ?></td>
                            <td><?php echo $treatment_rec_set['completed'] == '1' ? 'Completed' : 'Pending' ?></td>
                            <td class="center">
                                   <?php
                                        if($treatment_rec_set['completed'] == '1'){
                                    ?>
                                    <a href="treatment-pending.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $current_patient['id']; ?>" id="ttt" title="Mark as Pending" style="align:right; " class="btn btn-warning btn-circle" ><i class="fa fa-reply"></i></a>

                                    <?php
                                        }else{
                                    ?>
                                    <a href="treatment-complete.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $current_patient['id']; ?>" id="ttt" title="Mark as Completed" style="align:right;" class="btn btn-info btn-circle" ><i class="fa fa-check"></i></a>
                                    <?php
                                        }
                                    ?>

                                    <a href="edit-treatment-rec.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $current_patient['id']; ?>" id="ttt" style="align:right" title="Edit Record" class="btn btn-info btn-circle" ><i class="fa fa-pencil"></i></a>
                                    <a onclick="return confirm('Are you sure ?')" title="Delete Record" href="delete-treatment-rec.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $current_patient['id']; ?>" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>

    <?php
                }

        }
        }   
    }else{
        $result = get_pending_treatment_rec_by_patient_id($current_patient['id']);
        while($treatment_rec_set = mysqli_fetch_assoc($result)){
        ?>
        <tr style="background-color: <?php echo $treatment_rec_set['completed'] == '1' ? '#d6e9c6' : '#fcf8e3' ?>">
            <td><?php echo $treatment_rec_set['id']; ?></td>
            <td><?php echo $treatment_rec_set['datetime']; ?></td>
            <td><?php echo $treatment_rec_set['treatment']; ?></td>
            <td>
                 <?php
                     $result3 = get_teeth_by_treatment_rec_id($treatment_rec_set['id']);
                     while ($affected_teeth_set = mysqli_fetch_assoc($result3)){
                        echo $affected_teeth_set['tooth_id'].", ";
                    }
                 ?>
            </td>
            <td><button type="button"  data-toggle="modal" data-target="#image_gallery_treatment" data-treatment_rec_id="<?php echo $treatment_rec_set['id']; ?>" class="btn btn-warning btn-circle open_uploader_treatment_rec"><i class="fa fa-camera"></i></button></td>
            <td><?php echo $treatment_rec_set['note']; ?></td>
            <td><?php echo $treatment_rec_set['price']; ?></td>
                            <td><?php echo $treatment_rec_set['completed'] == '1' ? 'Completed' : 'Pending' ?></td>
                            <td class="center">
                                   <?php
                                        if($treatment_rec_set['completed'] == '1'){
                                    ?>
                                    <a href="treatment-pending.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $current_patient['id']; ?>" id="ttt" title="Mark as Pending" style="align:right; " class="btn btn-warning btn-circle" ><i class="fa fa-reply"></i></a>

                                    <?php
                                        }else{
                                    ?>
                                    <a href="treatment-complete.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $current_patient['id']; ?>" id="ttt" title="Mark as Completed" style="align:right;" class="btn btn-info btn-circle" ><i class="fa fa-check"></i></a>
                                    <?php
                                        }
                                    ?>

                                    <a href="edit-treatment-rec.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $current_patient['id']; ?>" id="ttt" style="align:right" title="Edit Record" class="btn btn-info btn-circle" ><i class="fa fa-pencil"></i></a>
                                    <a onclick="return confirm('Are you sure ?')" title="Delete Record" href="delete-treatment-rec.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $current_patient['id']; ?>" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></a>
                            </td>
        </tr>
        <?php
        }
    }
   

}
?>

	</tbody>
</table>