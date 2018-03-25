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
    $patient = get_patient_by_id($_GET['p_id']);
    
    if(sizeof($idsArray) > 0){
        
        $query = "SELECT * ";
        $query .= "FROM tooth_treatment_rec ";
        $query .= "WHERE ";
        foreach ($idsArray as $key => $value){
            $query .= "tooth_id = '".$value."' OR ";
        }
        $query = substr($query, 0, -3);
        $query .= " AND patient_id = {$patient['id']}";

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
                $query2 .= "WHERE id = {$value} AND completed = '1'";

                $result2 = mysqli_query($db_conx, $query2);
                confirm_query($result2);

                while ($treatment_rec_set = mysqli_fetch_assoc($result2)){

    ?>

                        <tr>
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
                            <td><button type="button" class="btn btn-info btn-circle open_uploader_treatment_rec" data-toggle="modal" data-treatment_rec_id="<?php echo $treatment_rec_set['id']; ?>" data-target="#image_gallery_treatment"><i class="fa fa-camera"></i></button></td>
                            <td><?php echo $treatment_rec_set['note']; ?></td>
                            <td class="center">
                                     <a href="treatment-pending.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" id="ttt" title="Mark as Pending" style="align:right; " class="btn btn-warning btn-circle" ><i class="fa fa-reply"></i></a>
                                     <a onclick="return confirm('Are you sure ?')" title="Delete Record" href="delete-treatment-rec.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>

    <?php
                }

        }
        
        }
    }else{
        $result = get_completed_treatment_rec_by_patient_id($patient['id']);
        while($treatment_rec_set = mysqli_fetch_assoc($result)){
        ?>
        <tr>
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
            <td><button type="button" class="btn btn-info btn-circle open_uploader_treatment_rec" data-toggle="modal" data-treatment_rec_id="<?php echo $treatment_rec_set['id']; ?>" data-target="#image_gallery_treatment"><i class="fa fa-camera"></i></button></td>
            <td><?php echo $treatment_rec_set['note']; ?></td>
            <td class="center">
                <a href="treatment-pending.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" id="ttt" title="Mark as Pending" style="align:right; " class="btn btn-warning btn-circle" ><i class="fa fa-reply"></i></a>
                    <a onclick="return confirm('Are you sure ?')" title="Delete Record" href="delete-treatment-rec.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></a>
            </td>
        </tr>
        <?php
        }
    }
   

}
?>

	</tbody>
</table>