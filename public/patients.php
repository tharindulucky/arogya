<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php
if(isset($_POST['submit'])){
    
    //validations
    $required_fields = array('name', 'age' );
    validate_has_presense($required_fields,0);
    
    $required_fields = array('age','phone');
    validate_is_numeric($required_fields);
    
    check_length('phone', 10);
    
    //already_has_patient(filter($_POST['email']));
    
    if(empty($errors)){
        $name = filter($_POST['name']);
        $email = filter($_POST['email']);
        $address = filter($_POST['address']);
        
        $age = filter($_POST['age']);
        $age = preg_replace("/[^0-9]/","",$age);
        
        $phone = filter($_POST['phone']);
        
        
        $query = "INSERT INTO patient(";
        $query .= "name, email, address, age, landphone";
        $query .= ") VALUES(";
        $query .= "'{$name}', '{$email}', '{$address}', {$age}, '{$phone}'";
        $query .= ");";
        
        $result = mysqli_query($db_conx, $query);
        $record_id = mysqli_insert_id($db_conx);
        confirm_query($result);
        
        if($result){
            
            $patient = get_patient_by_id($record_id);
            
            $dir_path = "uploads/{$patient['id']}";
            $dir_path_diseases = "uploads/{$patient['id']}/diseases";
            $dir_path_treatments = "uploads/{$patient['id']}/treatments";
            
            if(!file_exists($dir_path)){
                mkdir($dir_path);
            }
            
            if(!file_exists($dir_path_diseases)){
                mkdir($dir_path_diseases);
            }
            
            if(!file_exists($dir_path_treatments)){
                mkdir($dir_path_treatments);
            }
            
            $_SESSION['message'] = "Patient Added";
            redirect_to("patient-added-success.php?p_id={$patient['id']}");
        }else{
            $_SESSION['message'] = "Patient Not Added";
        }
                
        
    }
    
    
    
}
?>
<?php get_header("All Patients");  ?>
    <div id="wrapper">

   <?php require_once('nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">All Patients <button title="Add Patient" style="align:right" type="button" class="btn btn-warning btn-circle btn-lg" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <?php 
                echo message();
                errors();
                has_presense_errors($errors);
            ?>
            <!-- /.row -->
             <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Total patients : <?php echo count_patients(); ?>
			</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th style="width:100px;">Address</th>
                                            <th style="width:80px !important">Age</th>
                                            <th>Phone</th>
                                            <th style="width:110px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                            <?php
                                            $result = get_patients(0);
                                            while($patients_set = mysqli_fetch_assoc($result)){
                                            ?>
                                        <tr>
                                                <td><?php echo "P".str_pad($patients_set['id'], 5, "0", STR_PAD_LEFT); ?></td>
                                                <td><?php echo $patients_set['name']; ?></td>
                                                <td class="center"><?php echo $patients_set['email']; ?></td>
                                                <td class="center"><?php echo $patients_set['address']; ?></td>
                                                <td class="center"><?php echo $patients_set['age']; ?></td>
                                                <td class="center"><?php echo $patients_set['landphone']; ?></td>
                                                <td class="center">
                                                    <a title="View Patient" href="patient.php?id=<?php echo $patients_set['id']; ?>" class="btn btn-primary btn-circle"><i class="fa fa-eye"></i></a>
                                                    <a title="Edit Patient" href="edit-patient.php?id=<?php echo $patients_set['id']; ?>" id="ttt" style="align:right" class="btn btn-primary btn-circle" ><i class="fa fa-pencil"></i></a>
                                                    <a title="Delete Patient" onclick="return confirm('Are you sure ?')" href="delete-patient.php?id=<?php echo $patients_set['id']; ?>" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></a>
                                                </td>
                                           </tr>
                                            <?php
                                            }
                                            ?>
                                        
                                        
                                    </tbody>
                                </table>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
         
        <div class="modal-content">
            <form class="form-horizontal" role="form" method="post" action="patients.php">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Patient</h4>
            </div>
             <!-- Modal Body -->
            
            <div class="modal-body">
                <div style="padding: 10px;">
                    
                  <div class="form-group">
                    <label class="col-sm-3 control-label">* Name </label>
                    <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $_POST['name']: "" ?>"  placeholder="Enter Patient Name (Required)"/>
                    </div>
                  </div>
				  
				  
                  <div class="form-group">
                    <label class="col-sm-3 control-label"  >Email</label>
                    <div class="col-sm-8">
                        <input type="text" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $_POST['email']: "" ?>" placeholder="Enter Patient Email"/>
                    </div>
                  </div>
                 
		 <div class="form-group">
                    <label class="col-sm-3 control-label" >Address</label>
                    <div class="col-sm-8">
                        <input type="text" name="address" class="form-control" value="<?php echo isset($_POST['address']) ? $_POST['address']: "" ?>" placeholder="Enter Patient Address"/>
                    </div>
                  </div>
		
				  
		 <div class="form-group">
                    <label class="col-sm-3 control-label">* Age </label>
                    <div class="col-sm-8">
                        <input type="text" name="age" class="form-control" id="" value="<?php echo isset($_POST['age']) ? $_POST['age']: "" ?>" placeholder="Enter Patient Age (Required)"/>
                    </div>
                  </div>
				  
		 <div class="form-group">
                    <label class="col-sm-3 control-label">Phone</label>
                    <div class="col-sm-8">
                        <input type="text" name="phone" class="form-control" value="<?php echo isset($_POST['phone']) ? $_POST['phone']: "" ?>" placeholder="Enter Patient's phone no."/>
                    </div>
                  </div>
			
              
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="submit" class="btn btn-primary" value="Save">
            </div>
             </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
            
            
            
            
            
  <!-- Modal -->
    <div class="modal fade" id="edit_patient_modal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            
          
        </div>
    </div>           
 

    <!-- Bootstrap Core JavaScript -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
 
    <script>
    $('#edit_patient_modal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget); // Button that triggered the modal
          var recipient = button.data('id'); // Extract info from data-* attributes
          var modal = $(this);
          var dataString = 'id=' + recipient;
 
            $.ajax({
                type: "GET",
                url: "ajax_patient.php",
                data: dataString,
                cache: false,
                success: function (data) {
                    console.log(data);
                    modal.find('.modal-content').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });  
    })
    </script>

                            <!-- /.modal -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php require_once('footer.php'); ?>