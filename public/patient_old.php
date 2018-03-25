<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php
    $patient = null;
    if(isset($_GET['id'])){
        $patient = get_patient_by_id($_GET['id']);
    }
    
    if(isset($_POST['add_disease_rec'])){
        $affected_teeth = null;
        if(isset($_POST['teeth_group'])){
            $affected_teeth = $_POST['teeth_group'];
        }
        
        //validations
        $required_fields = array('date');
        validate_has_presense($required_fields,0);
        
        if(empty($errors)){
            $date_time = filter($_POST['date']);
            $condition = filter($_POST['condition']);
            $notes = filter($_POST['notes']);
            
            $query = "INSERT INTO diseases_record(";
            $query .= "datetime, condition_name, note, patient_id";
            $query .= ") VALUES(";
            $query .= "'{$date_time}', '{$condition}', '{$notes}', {$patient['id']}";
            $query .= ");";
            
            $result = mysqli_query($db_conx, $query);
            $disease_rec_id = mysqli_insert_id($db_conx);
            confirm_query($result);
            
            if($result && isset($affected_teeth)){
                foreach ($affected_teeth as $key => $value){
                    $query = "INSERT INTO tooth_diseases_rec(";
                    $query .= "tooth_id, disease_rec_id, patient_id ";
                    $query .= ") VALUES(";
                    $query .= "'{$value}', '{$disease_rec_id}', {$patient['id']}";
                    $query .= ");";

                    $result2 = mysqli_query($db_conx, $query);
                    
                    confirm_query($result2).mysqli_error($db_conx);
                }
            }
            
            if($result){
                
                $dir_path = "uploads/{$patient['id']}/diseases/{$disease_rec_id}";

                if(!file_exists($dir_path)){
                    mkdir($dir_path);
                }
                
                $_SESSION['message'] = "Disease Record Added";
                redirect_to("record-added-success.php?id={$patient['id']}");
            }else{
                $_SESSION['message'] = "Disease Record Not Added";
            }
        }
    }
    
    
if(isset($_POST['add_treatment_rec'])){
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
            $date_time = filter($_POST['date']);
            $treatment = filter($_POST['treatment']);
            $notes = filter($_POST['notes']);
            
            if(empty($_POST['price'])){
                $price = 0;
            }else{
                $price = filter($_POST['price']);
            }
            
            $query = "INSERT INTO pending_treatment(";
            $query .= "datetime, treatment, note, price, patient_id";
            $query .= ") VALUES(";
            $query .= "'{$date_time}', '{$treatment}', '{$notes}', {$price}, {$patient['id']}";
            $query .= ");";
            
            $result = mysqli_query($db_conx, $query);
            $treatment_rec_id = mysqli_insert_id($db_conx);
            confirm_query($result);
            
            if($result && isset($affected_teeth)){
                foreach ($affected_teeth as $key => $value){
                    $query = "INSERT INTO tooth_treatment_rec(";
                    $query .= "tooth_id, treatment_rec_id, patient_id ";
                    $query .= ") VALUES(";
                    $query .= "'{$value}', '{$treatment_rec_id}', {$patient['id']}";
                    $query .= ");";

                    $result2 = mysqli_query($db_conx, $query);
                    
                    confirm_query($result2).mysqli_error($db_conx);
                }
            }
            
            if($result){
                
                $dir_path = "uploads/{$patient['id']}/treatments/{$treatment_rec_id}";

                if(!file_exists($dir_path)){
                    mkdir($dir_path);
                }
                
                $_SESSION['message'] = "Treatment Log Added";
                redirect_to("record-added-success.php?id={$patient['id']}");
            }else{
                $_SESSION['message'] = "Treatment Log Not Added";
            }
        }
    }
    
    
   //if they DID upload a file...
if(isset($_FILES['image'])){
    
      
    
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      
      $rrr = explode('.',$_FILES['image']['name']);
      $file_ext=strtolower(end($rrr));
      
      $expensions= array("jpeg","jpg","png");
      
      if($_FILES['image']['name'] == ""){
          $_SESSION['errors'] ='Please select a file to upload.';
          $img_error = "nofile";
      }else if(in_array($file_ext,$expensions)=== false){
         $_SESSION['errors'] ="extension not allowed, please choose a JPEG or PNG file.";
         $img_error = "exterr";
      }
      
      if($file_size > 2097152){
         $_SESSION['errors'] ='File size must be excately 2 MB';
      }
      
      if(empty($img_error)==true){
         move_uploaded_file($file_tmp,"uploads/diseases/".$patient['id']."_".$file_name);
         
         
         
        $query = "INSERT INTO image(";
        $query .= "url, patient_id";
        $query .= ") VALUES(";
        $query .= "'{$file_name}', {$patient['id']}";
        $query .= ");";

        $result = mysqli_query($db_conx, $query);
        confirm_query($result);

        if($result){
            $_SESSION['message'] = "Image uploaded successfully";
        }else{
            $_SESSION['errors'] = "Image not uploaded";
        }
         
         
      }else{
         //print_r($errors);
      }
   }


    
?>
<?php get_header($patient['name']);  ?>
    <div id="wrapper">
      <?php require_once('nav.php'); ?>
        <div id="page-wrapper">
            <br>
            <?php 
                echo message();
                errors();
                has_presense_errors($errors);
                
                if($patient){
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $patient['name'] ?></h1>
                    <h3 class="page-header"><?php echo $patient['age'] ?> Years</h3>
                    <h4 class="page-header"><?php echo $patient['address'] ?></h4>
		 </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <form role="form">
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
                                                        <label class="checkbox-inline"><input value="RUE" id="RUE"  class="rrrr" name="teeth_group[]" type="checkbox">E</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="RUD" id="RUD"  class="rrrr" class="rrrr" name="teeth_group[]" type="checkbox">D</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="RUC" id="RUC" class="rrrr" name="teeth_group[]" type="checkbox">C</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="RUB" id="RUB"  class="rrrr" name="teeth_group[]" type="checkbox">B</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="RUA" id="RUA" class="rrrr" name="teeth_group[]" type="checkbox">A</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="LUA" id="LUA" class="rrrr" name="teeth_group[]" type="checkbox">A</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="LUB" id="LUB" class="rrrr" name="teeth_group[]" type="checkbox">B</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="LUC" id="LUC" class="rrrr" name="teeth_group[]" type="checkbox">C</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="LUD" id="LUD" class="rrrr" name="teeth_group[]" type="checkbox">D</label>
                                                </td>
                                                <td>
                                                        <label class="checkbox-inline"><input value="LUE" id="LUE" class="rrrr" name="teeth_group[]" type="checkbox">E</label>
                                                </td>
                                                <td style="background-color:transparent;"></td>
                                                <td style="background-color:transparent;"></td>
                                                <td style="background-color:transparent;"></td>
                                            </tr>

                                            <tr class="info">
                                                <td>
                                                    <label class="checkbox-inline"><input value="RU8" id="RU8" class="rrrr" name="teeth_group[]" type="checkbox">8</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU7" id="RU7" class="rrrr" name="teeth_group[]" type="checkbox">7</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU6" id="RU6" class="rrrr" name="teeth_group[]" type="checkbox">6</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU5" id="RU5" class="rrrr" name="teeth_group[]" type="checkbox">5</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU4" id="RU4" class="rrrr" name="teeth_group[]" type="checkbox">4</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU3" id="RU3" class="rrrr" name="teeth_group[]" type="checkbox">3</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU2" id="RU2" class="rrrr" name="teeth_group[]" type="checkbox">2</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input  value="RU1" id="RU1" class="rrrr" name="teeth_group[]" type="checkbox">1</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU1" id="LU1" class="rrrr" name="teeth_group[]" type="checkbox">1</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU2" id="LU2" class="rrrr" name="teeth_group[]" type="checkbox">2</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU3" id="LU3" class="rrrr" name="teeth_group[]" type="checkbox">3</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU4" id="LU4" class="rrrr" name="teeth_group[]" type="checkbox">4</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU5" id="LU5" class="rrrr" name="teeth_group[]" type="checkbox">5</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU6" id="LU6" class="rrrr" name="teeth_group[]" type="checkbox">6</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU7" id="LU7" class="rrrr" name="teeth_group[]" type="checkbox">7</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LU8" id="LU8" class="rrrr" name="teeth_group[]" type="checkbox">8</label>
                                                </td>
                                            </tr>

                                            <tr class="info">
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL8" id="RL8" class="rrrr" name="teeth_group[]" type="checkbox">8</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL7" id="RL7" class="rrrr" name="teeth_group[]" type="checkbox">7</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL6" id="RL6" class="rrrr" name="teeth_group[]" type="checkbox">6</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL5" id="RL5" class="rrrr" name="teeth_group[]" type="checkbox">5</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL4" id="RL4" class="rrrr" name="teeth_group[]" type="checkbox">4</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL3" id="RL3" class="rrrr" name="teeth_group[]" type="checkbox">3</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL2" id="RL2" class="rrrr" name="teeth_group[]" type="checkbox">2</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="RL1" id="RL1" class="rrrr" name="teeth_group[]" type="checkbox">1</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL1" id="LL1" class="rrrr" name="teeth_group[]" type="checkbox">1</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL2" id="LL2" class="rrrr" name="teeth_group[]" type="checkbox">2</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL3" id="LL3" class="rrrr" name="teeth_group[]" type="checkbox">3</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL4"  id="LL4" class="rrrr" name="teeth_group[]" type="checkbox">4</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL5" id="LL5" class="rrrr" name="teeth_group[]" type="checkbox">5</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL6" id="LL6" class="rrrr" name="teeth_group[]" type="checkbox">6</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL7" id="LL7" class="rrrr" name="teeth_group[]" type="checkbox">7</label>
                                                </td>
                                                <td>
                                                    <label class="checkbox-inline"><input value="LL8" id="LL8" class="rrrr" name="teeth_group[]" type="checkbox">8</label>
                                                </td>
                                            </tr>

                                                    <tr class="success">
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLE" id="RLE" class="rrrr" name="teeth_group[]" type="checkbox">E</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLD" id="RLD" class="rrrr" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLC" id="RLC" class="rrrr" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLB" id="RLB" class="rrrr" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLA" id="RLA" class="rrrr" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLA" id="LLA" class="rrrr" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLB" id="LLB" class="rrrr" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLC" id="LLC" class="rrrr" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLD" id="LLD" class="rrrr" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLE" id="LLE" class="rrrr" name="teeth_group[]" type="checkbox">E</label>
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
          </form>
        </div>
</div>
						
		 <script>
                    $(document).ready(function(){
                        $(".rrrr").click(function(){
                            var p_id = <?php echo $patient['id'];  ?>;
                            var ids = [], idsString;
                            $(":checkbox:checked").each( function() {
                                ids.push( this.id );
                            });

                            idsString = ids.join(',');
                            $("#disease_log").load("ajax_disease_log.php?t_id="+idsString+"&p_id="+p_id);
                            $("#pending_treatment_log").load("ajax_pending_treatment_log.php?t_id="+idsString+"&p_id="+p_id);
                            $("#completed_treatment_log").load("ajax_completed_treatment_log.php?t_id="+idsString+"&p_id="+p_id);
                        });
                    });
                </script>
			
						
						
						
						
						
						
						
						
						<div class="panel panel-default">
							<div class="panel-heading">
								
								Subsequent Visits
							</div>
							<div class="panel-body">
							
									<div class="dataTable_wrapper">
										<table class="table table-striped table-bordered table-hover" id="dataTables-example">
											<thead>
												<tr>
													<th>Date & Time</th>
													<th>Treatment</th>
													<th>Note</th>
													
												</tr>
											</thead>
											<tbody>
												<?php
                                                                                                $result = get_treatment_rec_by_patient_id($patient['id']);
                                                                                                    while($treatment_rec_set = mysqli_fetch_assoc($result)){
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td><?php echo $treatment_rec_set['datetime']; ?></td>
                                                                                                        <td><?php echo $treatment_rec_set['treatment']; ?></td>
                                                                                                        <td><?php echo $treatment_rec_set['note']; ?></td>
                                                                                                        
                                                                                                    </tr>
                                                                                                    <?php
                                                                                                    }
                                                                                                    
                                                                                                    if (mysqli_num_rows($result) == 0) {
                                                                                                        echo "<tr><td colspan=3>No Logs Found</td></tr>";
                                                                                                    }
                                                                                                    
                                                                                                ?>
											</tbody>
										</table>
									</div>
                            <!-- /.table-responsive -->
								
						
							
							
						</div>
					</form>
                    <!-- /.panel -->
					
                </div>
						
						<div class="panel panel-default">
							<div class="panel-heading">
								
								Diseases Log
							</div>
                                                    
                                                    
							<div class="panel-body">
							
							<div class="panel panel-success">
								<div class="panel-heading">
									Diseases Information
									<button  type="button" class="btn btn-success btn-circle" data-toggle="modal" data-target="#add_disease_log"><i class="fa fa-plus"></i></button>
								</div>
								<div class="panel-body">
								
									<div class="dataTable_wrapper" id="disease_log">
										<table class="table table-striped table-bordered table-hover" id="disease-log">
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
                                                                                                $result = get_disease_rec_by_patient_id($patient['id']);
                                                                                                    while($diseases_rec_set = mysqli_fetch_assoc($result)){
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td><?php echo $diseases_rec_set['id']; ?></td>
                                                                                                        <td><?php echo $diseases_rec_set['datetime']; ?></td>
                                                                                                        <td><?php echo $diseases_rec_set['condition_name']; ?></td>
                                                                                                        <td>
                                                                                                            <?php
                                                                                                            
                                                                                                                $result3 = get_teeth_by_disease_rec_id($diseases_rec_set['id']);
                                                                                                                while ($affected_teeth_set = mysqli_fetch_assoc($result3)){
                                                                                                                    echo $affected_teeth_set['tooth_id'].", ";
                                                                                                                }
                                                                                                            ?>
                                                                                                        </td>
                                                                                                        <td><button class="open_uploader_disease_rec btn btn-success btn-circle" type="button" data-disease_rec_id="<?php echo $diseases_rec_set['id']; ?>"  data-toggle="modal" data-target="#image_gallery" ><i class="fa fa-camera"></i></button></td>
                                                                                                        <td><?php echo $diseases_rec_set['note']; ?></td>
                                                                                                        <td class="center">
                                                                                                            <a href="edit-disease-rec.php?id=<?php echo $diseases_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" id="ttt" style="align:right" class="btn btn-info btn-circle" ><i class="fa fa-pencil"></i></a>
                                                                                                                <a onclick="return confirm('Are you sure ?')" href="delete-disease-rec.php?id=<?php echo $diseases_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></a>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <?php
                                                                                                    }
                                                                                                    
                                                                                                    if (mysqli_num_rows($result) == 0) {
                                                                                                        echo "<tr><td colspan=7>No Logs Found</td></tr>";
                                                                                                    }
                                                                                                    
                                                                                                ?>
											</tbody>
										</table>
									</div>
                            <!-- /.table-responsive -->
								</div>
							</div>
							<!-- /.panel-body -->
							
							
						</div>
					</form>
                    <!-- /.panel -->
					
                </div>
                <!-- /.col-lg-12 -->
				
				
				
						<div class="panel panel-default">
							<div class="panel-heading">
								Treatment Logs
							</div>
							<div class="panel-body">
							
							<div class="panel panel-info">
								<div class="panel-heading">
									Completed Treatment
								</div>
								<div class="panel-body">
								
                                                                    <div class="dataTable_wrapper" id="completed_treatment_log">
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
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php
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
                                                                                                        <td><button type="button"  data-toggle="modal" data-target="#image_gallery_treatment" data-treatment_rec_id="<?php echo $treatment_rec_set['id']; ?>" class="btn btn-info btn-circle open_uploader_treatment_rec"><i class="fa fa-camera"></i></button></td>
                                                                                                        <td><?php echo $treatment_rec_set['note']; ?></td>
                                                                                                        <td><?php echo $treatment_rec_set['price']; ?></td>
                                                                                                        <td class="center">
                                                                                                            <a href="treatment-pending.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" id="ttt" title="Mark as Pending" style="align:right; " class="btn btn-warning btn-circle" ><i class="fa fa-reply"></i></a>
                                                                                                            <a href="edit-treatment-rec.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" id="ttt" style="align:right" class="btn btn-info btn-circle" ><i class="fa fa-pencil"></i></a>
                                                                                                            <a onclick="return confirm('Are you sure ?')" title="Delete Record" href="delete-treatment-rec.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></a>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <?php
                                                                                                    }
                                                                                                    
                                                                                                     if (mysqli_num_rows($result) == 0) {
                                                                                                        echo "<tr><td colspan=8>No Logs Found</td></tr>";
                                                                                                    }
                                                                                                ?>
											</tbody>
										</table>
									</div>
                            <!-- /.table-responsive -->
								</div>
							</div>
							<!-- /.panel-body -->
							
							<div class="panel panel-warning">
								<div class="panel-heading">
									Treatments
									<button  type="button" class="btn btn-warning btn-circle" data-toggle="modal"  data-target="#add_treatment_log"><i class="fa fa-plus"></i></button>
								</div>
								<div class="panel-body">
								
									<div class="dataTable_wrapper" id="pending_treatment_log">
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
                                                                                                $result = get_all_treatment_recs_by_patient_id($patient['id']);
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
                                                                                                        <td><button type="button" class="btn btn-warning btn-circle open_uploader_treatment_rec" data-toggle="modal" data-treatment_rec_id="<?php echo $treatment_rec_set['id']; ?>" data-target="#image_gallery_treatment"><i class="fa fa-camera"></i></button></td>
                                                                                                        <td><?php echo $treatment_rec_set['note']; ?></td>
                                                                                                        <td><?php echo $treatment_rec_set['price']; ?></td>
                                                                                                        <td><?php echo $treatment_rec_set['completed'] == '1' ? 'Completed' : 'Pending' ?></td>
                                                                                                        <td class="center">
                                                                                                            <?php
                                                                                                                if($treatment_rec_set['completed'] == '1'){
                                                                                                            ?>
                                                                                                            <a href="treatment-pending.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" id="ttt" title="Mark as Pending" style="align:right; " class="btn btn-warning btn-circle" ><i class="fa fa-reply"></i></a>
                                                                                                            
                                                                                                            <?php
                                                                                                                }else{
                                                                                                            ?>
                                                                                                            <a href="treatment-complete.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" id="ttt" title="Mark as Completed" style="align:right;" class="btn btn-info btn-circle" ><i class="fa fa-check"></i></a>
                                                                                                            <?php
                                                                                                                }
                                                                                                            ?>
                                                                                                            
                                                                                                            <a href="edit-treatment-rec.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" id="ttt" style="align:right" title="Edit Record" class="btn btn-info btn-circle" ><i class="fa fa-pencil"></i></a>
                                                                                                            <a onclick="return confirm('Are you sure ?')" title="Delete Record" href="delete-treatment-rec.php?id=<?php echo $treatment_rec_set['id']; ?>&p_id=<?php echo $patient['id']; ?>" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></a>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <?php
                                                                                                    }
                                                                                                    
                                                                                                    if (mysqli_num_rows($result) == 0) {
                                                                                                        echo "<tr><td colspan=7>No Logs Found</td></tr>";
                                                                                                    }
                                                                                                    ?>
											</tbody>
										</table>
									</div>
                            <!-- /.table-responsive -->
								</div>
							</div>
							<!-- /.panel-body -->
						</div>
					</form>
                    <!-- /.panel -->
					
					
					
					
                </div>
                <!-- /.col-lg-12 -->
				
				
				
				
				
				
				<!-- Modal -->
<div class="modal fade" id="add_disease_log" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <form class="form-horizontal" role="form" method="post" action="patient.php?id=<?php echo $patient['id'];  ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                           <span aria-hidden="true">&times;</span>
                           <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       Add Disease Log
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> Select Tooth </div>
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
                                                                <label class="checkbox-inline"><input value="RUE" name="teeth_group[]" type="checkbox">E</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="RUD" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="RUC" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="RUB" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="RUA" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="LUA" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="LUB" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="LUC" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="LUD" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="LUE" name="teeth_group[]" type="checkbox">E</label>
                                                        </td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                    </tr>

                                                    <tr class="info">
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RU8" name="teeth_group[]" type="checkbox">8</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU7" name="teeth_group[]" type="checkbox">7</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU6" name="teeth_group[]" type="checkbox">6</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU5" name="teeth_group[]" type="checkbox">5</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU4" name="teeth_group[]" type="checkbox">4</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU3" name="teeth_group[]" type="checkbox">3</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU2" name="teeth_group[]" type="checkbox">2</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU1" name="teeth_group[]" type="checkbox">1</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU1" name="teeth_group[]" type="checkbox">1</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU2" name="teeth_group[]" type="checkbox">2</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU3" name="teeth_group[]" type="checkbox">3</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU4" name="teeth_group[]" type="checkbox">4</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU5" name="teeth_group[]" type="checkbox">5</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU6" name="teeth_group[]" type="checkbox">6</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU7" name="teeth_group[]" type="checkbox">7</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU8" name="teeth_group[]" type="checkbox">8</label>
                                                        </td>
                                                    </tr>

                                                    <tr class="info">
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL8" name="teeth_group[]" type="checkbox">8</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL7" name="teeth_group[]" type="checkbox">7</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL6" name="teeth_group[]" type="checkbox">6</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL5" name="teeth_group[]" type="checkbox">5</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL4" name="teeth_group[]" type="checkbox">4</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL3" name="teeth_group[]" type="checkbox">3</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL2" name="teeth_group[]" type="checkbox">2</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL1" name="teeth_group[]" type="checkbox">1</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL1" name="teeth_group[]" type="checkbox">1</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL2" name="teeth_group[]" type="checkbox">2</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL3" name="teeth_group[]" type="checkbox">3</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL4" name="teeth_group[]" type="checkbox">4</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL5" name="teeth_group[]" type="checkbox">5</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL6" name="teeth_group[]" type="checkbox">6</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL7" name="teeth_group[]" type="checkbox">7</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL8" name="teeth_group[]" type="checkbox">8</label>
                                                        </td>
                                                    </tr>

                                                    <tr class="success">
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLE" name="teeth_group[]" type="checkbox">E</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLD" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLC" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLB" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLA" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLA" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLB" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLC" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLD" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLE" name="teeth_group[]" type="checkbox">E</label>
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
                    <script type="text/javascript">
                        $(window).load(function(){
                            $('#datetimepicker1').datetimepicker();
                            
                            var today = new Date();
                            
                            var dd = today.getDate();
                            var mm = today.getMonth()+1; //January is 0!
                            var yyyy = today.getFullYear();
                            
                            var hours = today.getHours();
                            var minutes = today.getMinutes();
                            
                            var ampm = hours >= 12 ? 'pm' : 'am';
                            hours = hours % 12;
                            hours = hours ? hours : 12; // the hour '0' should be '12'
                            minutes = minutes < 10 ? '0'+minutes : minutes;
                            

                            if(dd<10) {
                                dd='0'+dd
                            } 

                            if(mm<10) {
                                mm='0'+mm
                            } 

                            today = mm+'/'+dd+'/'+yyyy+' '+hours+':'+minutes+' '+ampm;
                            
                            $('#datetime').val(today);
                            $('#datetime2').val(today);
                            
                        });
                    </script>
                      <div class="form-group">
                        <label  class="col-sm-2 control-label">Date & Time</label>
                        <div class="input-group date col-sm-8"  style="padding-left: 14px" id="datetimepicker1">
                            <input class="form-control" type="text" id="datetime" name="date"><span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                        </div>
                      </div>

                    <div class="form-group">
                        <label  class="col-sm-2 control-label">Condition</label>
                        <div class="col-sm-10">
                           <select class="form-control" name="condition">
                                <?php
                                $result = get_diseases();
                                while($diseases_set = mysqli_fetch_assoc($result)){
                                ?>
                                <option value="<?php echo $diseases_set['name']; ?>"><?php echo $diseases_set['name']; ?></option>

                                <?php
                                }
                                ?>
                           </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Note</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="notes" id="notes" placeholder="Notes"/>
                        </div>
                      </div>


                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" name="add_disease_rec" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
				
				
			 <!-- /.modal -->	
				
				
		<?php
                }
                
                ?>
				
				
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

		
		
		
		
		
		
		
		
		
		
		
				
				<!-- Modal -->
<div class="modal fade" id="add_treatment_log" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <form class="form-horizontal" role="form" method="post" action="patient.php?id=<?php echo $patient['id'];  ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                           <span aria-hidden="true">&times;</span>
                           <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       Add Treatment Log
                    </h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"> Select Tooth </div>
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
                                                                <label class="checkbox-inline"><input value="RUE" name="teeth_group[]" type="checkbox">E</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="RUD" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="RUC" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="RUB" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="RUA" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="LUA" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="LUB" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="LUC" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="LUD" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                                <label class="checkbox-inline"><input value="LUE" name="teeth_group[]" type="checkbox">E</label>
                                                        </td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                    </tr>

                                                    <tr class="info">
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RU8" name="teeth_group[]" type="checkbox">8</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU7" name="teeth_group[]" type="checkbox">7</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU6" name="teeth_group[]" type="checkbox">6</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU5" name="teeth_group[]" type="checkbox">5</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU4" name="teeth_group[]" type="checkbox">4</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU3" name="teeth_group[]" type="checkbox">3</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU2" name="teeth_group[]" type="checkbox">2</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input  value="RU1" name="teeth_group[]" type="checkbox">1</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU1" name="teeth_group[]" type="checkbox">1</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU2" name="teeth_group[]" type="checkbox">2</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU3" name="teeth_group[]" type="checkbox">3</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU4" name="teeth_group[]" type="checkbox">4</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU5" name="teeth_group[]" type="checkbox">5</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU6" name="teeth_group[]" type="checkbox">6</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU7" name="teeth_group[]" type="checkbox">7</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LU8" name="teeth_group[]" type="checkbox">8</label>
                                                        </td>
                                                    </tr>

                                                    <tr class="info">
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL8" name="teeth_group[]" type="checkbox">8</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL7" name="teeth_group[]" type="checkbox">7</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL6" name="teeth_group[]" type="checkbox">6</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL5" name="teeth_group[]" type="checkbox">5</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL4" name="teeth_group[]" type="checkbox">4</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL3" name="teeth_group[]" type="checkbox">3</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL2" name="teeth_group[]" type="checkbox">2</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RL1" name="teeth_group[]" type="checkbox">1</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL1" name="teeth_group[]" type="checkbox">1</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL2" name="teeth_group[]" type="checkbox">2</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL3" name="teeth_group[]" type="checkbox">3</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL4" name="teeth_group[]" type="checkbox">4</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL5" name="teeth_group[]" type="checkbox">5</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL6" name="teeth_group[]" type="checkbox">6</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL7" name="teeth_group[]" type="checkbox">7</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LL8" name="teeth_group[]" type="checkbox">8</label>
                                                        </td>
                                                    </tr>

                                                    <tr class="success">
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td style="background-color:transparent;"></td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLE" name="teeth_group[]" type="checkbox">E</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLD" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLC" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLB" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="RLA" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLA" name="teeth_group[]" type="checkbox">A</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLB" name="teeth_group[]" type="checkbox">B</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLC" name="teeth_group[]" type="checkbox">C</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLD" name="teeth_group[]" type="checkbox">D</label>
                                                        </td>
                                                        <td>
                                                            <label class="checkbox-inline"><input value="LLE" name="teeth_group[]" type="checkbox">E</label>
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
                    <script type="text/javascript">
                    $(window).load(function(){
                    $('#datetimepicker2').datetimepicker();
                    });

                    </script>
                      <div class="form-group">
                        <label  class="col-sm-2 control-label">Date & Time</label>
                        <div class="input-group date col-sm-8"  style="padding-left: 14px" id="datetimepicker2">
                            <input class="form-control" type="text" id="datetime2" name="date"><span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">Note</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="notes" id="notes" placeholder="Notes"/>
                        </div>
                      </div>

                       <div class="form-group">
                            <label class="col-sm-2 control-label">Treatment</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="treatment">
                                    <option value="Extractions"><b>Extractions</b></option>
                                    <option value="Fillings">Fillings </option>
                                    <optgroup>
                                        <option value="Temporary">Temporary</option>
                                        <option value="G.I.C">G.I.C</option>
                                        <option value="Amalgam">Amalgam</option>
                                        <option value="Composite">Composite</option>
                                    </optgroup>
                                        <option value="Scalings">Scalings</option>
                                        <option value="Root Canal Treatments">Root Canal Treatments</option>
                                        <option value="Jacket Crowns Porcelain">Jacket Crowns Porcelain</option>
                                        <option value="Full Metal Crown">Full Metal Crown</option>
                                        <option value="Post Crowns Porcelain With Fiber Post">Post Crowns Porcelain With Fiber Post</option>
                                        <option value="Bridges Porcelain">Bridges Porcelain</option>
                                        <option value="Maryland Bridges">Maryland Bridges</option>
                                        <option value="Bridges Zirconia">Bridges Zirconia</option>
                                        <option value="Dentures Acrylic English">Dentures Acrylic English</option>
                                        <option value="">Dentures Acrylic Japanese</option>
                                        <option value="Dentures Acrylic Japanese">Dentures Valplast Flexible</option>
                                        <option value="Orthodontic Plates">Orthodontic Plates</option>
                                        <option value="Fixed Appliances">Fixed Appliances</option>
                                        <option value="Correction Of Medial Diastema">Correction Of Medial Diastema</option>
                                        <option value="Whitening Of Teeth Or Bleaching">Whitening Of Teeth Or Bleaching</option>
                                        <option value="Removal Of Impacted Molar">Removal Of Impacted Molar</option>
                                        <option value="Minor Operations">Minor Operations</option>
                                        <option value="Metal Dentures">Metal Dentures</option>
                                        <option value="Incision And Drianage">Incision And Drianage</option>
                                </select>
                            </div>
                        </div>
                    
                    
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="price" id="price" placeholder="Treatment Charge"/>
                            </div>
                        </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" name="add_treatment_rec" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>		
		
		
		
		
		
				
				<!-- Modal -->
<div class="modal fade" id="image_gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
           
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                           <span aria-hidden="true">&times;</span>
                           <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       Upload an Image
                    </h4>
                </div>
                
                <!-- Modal Body -->
                <div class="modal-body">
                    <script>
                        var open_uploader_disease_rec;
                        
                        $(document).on("click", ".open_uploader_disease_rec", function () {
                                open_uploader_disease_rec = $(this).data('disease_rec_id');
                                $("#disease_rec_id").val(open_uploader_disease_rec);
                                $("#image_preview").html('<i class="fa fa-cog fa-spin fa-4x"></i>');
                                $("#image_preview").load("ajax_disease_images.php?p_id="+<?php echo $patient['id']; ?>+"&disease_rec_id="+open_uploader_disease_rec);
                            });
                
                           
                    </script>
                    <form method="get" action="image-uploader.php?p_id=<?php echo $patient['id']; ?>" class="dropzone dropzone2" id="my-dropzone">
                        <input type="text" hidden value="<?php echo $patient['id']; ?>" name="p_id">
                        <input id="disease_rec_id" type="text" hidden name="disease_rec_id">
                    </form> 
                    
                    <script>
                            $(".dropzone2").dropzone({ 
                                    url : "image-uploader.php?p_id=<?php echo $patient['id']; ?>", 
                                    maxFilesize: 10, // Mb 
                                            init : function() { 
                                                    this.on('complete', function() { 
                                                    $("#image_preview").load("ajax_disease_images.php?p_id="+<?php echo $patient['id']; ?>+"&disease_rec_id="+open_uploader_disease_rec);
                                            }); 
                                    } 
                            });
                    </script>
                    
                    <br><br>
                    <h5><center>Previously uploaded images for this disease log</center></h5>
                    <br>
                    
                    <?php
//                        $result = get_images_by_patient_id($patient['id']);
//                            while($images_set = mysqli_fetch_assoc($result)){
//                                //echo '<img width=100 src="http://'.$_SERVER["HTTP_HOST"].'/dental/public/uploads/diseases/'.$patient['id']."_".$images_set['url'].'"> &nbsp;';
//                                
//                                echo '<div style="width:100px; height:100px; background:url(\'http://'.$_SERVER["HTTP_HOST"].'/dental/public/uploads/diseases/'.$patient['id']."_".$images_set['url'].'\'); background-size:cover; float:left; margin:3px;"></div>';
//                                
//                                if(mysqli_num_rows($result) == 0){
//                                    echo "No images";
//                                }
//                            }
//                            echo '<div style="clear:both; line-height:1px;"></div>';
//                              
//                        ?>
                        <div id="image_preview" style="text-align: center;">
                            
                        </div>
                   
                    <br><br>

                 

                </div>
                <form method="post" action="record-added-success.php">
<!--                <form method="post" action="patient.php?id=<?php echo $patient['id'];  ?>">-->
                <!-- Modal Footer -->
                <div class="modal-footer">
<!--                    <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>-->
                    <input type="text" name="patient_id" hidden value="<?php echo $patient['id']; ?>">  
                    <input type="submit" name="upload_image" class="btn btn-primary" value="Done">
                </div>
                </form>
        </div>
    </div>
</div>		
		
		
		
		
		

				
				<!-- Modal -->
<div class="modal fade" id="image_gallery_treatment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
           
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                           <span aria-hidden="true">&times;</span>
                           <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       Upload an Image
                    </h4>
                </div>
                
                <!-- Modal Body -->
                <div class="modal-body">
                    <script>
                        var open_uploader_treatment_rec
                        
                        $(document).on("click", ".open_uploader_treatment_rec", function () {
                                open_uploader_treatment_rec = $(this).data('treatment_rec_id');
                                $("#treatment_rec_id").val(open_uploader_treatment_rec);
                                $("#image_preview_treatment").html('<i class="fa fa-cog fa-spin fa-4x"></i>');
                                $("#image_preview_treatment").load("ajax_treatment_images.php?p_id="+<?php echo $patient['id']; ?>+"&treatment_rec_id="+open_uploader_treatment_rec);
                           });
                    </script>
                    <form method="get" action="image-uploader-treatment.php?p_id=<?php echo $patient['id']; ?>" class="dropzone dropzone3" id="my-dropzone">
                        <input type="text" hidden value="<?php echo $patient['id']; ?>" name="p_id">
                        <input id="treatment_rec_id" type="text" hidden name="treatment_rec_id">
                    </form> 
                    
                    <script>
                            $(".dropzone3").dropzone({ 
                                    url : "image-uploader-treatment.php?p_id=<?php echo $patient['id']; ?>", 
                                    maxFilesize: 10, // Mb 
                                            init : function() { 
                                                    this.on('complete', function() { 
                                                    $("#image_preview_treatment").load("ajax_treatment_images.php?p_id="+<?php echo $patient['id']; ?>+"&treatment_rec_id="+open_uploader_treatment_rec);
                                            }); 
                                    } 
                            });
                    </script>
                    
                    <br><br>
                    <h5><center>Previously uploaded images for this treatment log</center></h5>
                    <br>
                    
                    <div id="image_preview_treatment" style="text-align: center;">
                            
                        </div>
                   
                    <br><br>

                 

                </div>
<!--            <form method="post" action="patient.php?id=<?php echo $patient['id'];  ?>">-->
                <form method="post" action="record-added-success.php">
                <!-- Modal Footer -->
                <div class="modal-footer">
<!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>-->
                   <input type="text" name="patient_id" hidden value="<?php echo $patient['id']; ?>">                    
                   <input type="submit" name="upload_image" class="btn btn-primary" value="Done">
                </div>
                </form>
        </div>
    </div>
</div>		

                                
                                
		
		
		
		
    </div>
    <!-- /#wrapper -->
    
    <!-- Scripts -->
<!--    <link rel="stylesheet" href="widgets/datepicker.css">
    <script src="widgets/jquery.min.js"></script>
    <script src="widgets/datepicker.js"></script>
    <script src="widgets/main.js"></script>-->
    
   

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

 
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    
      <script type="text/javascript" src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
    
      <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css">
    
    
</body>

</html>
