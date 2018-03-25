<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php

$current_patient = null;
if(isset($_GET['id'])){
    $current_patient = get_patient_by_id($_GET['id']);
}

if(isset($_POST['submit'])){
    
    //validations
    $required_fields = array('name', 'age',);
    validate_has_presense($required_fields,0);
    
    $required_fields = array('age','phone');
    validate_is_numeric($required_fields);
    
    check_length('phone', 10);
    
    if(empty($errors)){
        $name = filter($_POST['name']);
        $email = filter($_POST['email']);
        $address = filter($_POST['address']);
        
        $age = filter($_POST['age']);
        $age = preg_replace("/[^0-9]/","",$age);
        
        $phone = filter($_POST['phone']);
        
        
        $query = "UPDATE patient SET ";
        $query .= "name = '{$name}', ";
        $query .= "email = '{$email}', ";
        $query .= "address = '{$address}', ";
        $query .= "age = {$age}, ";
        $query .= "landphone = '{$phone}' ";
        $query .= "WHERE id = {$current_patient['id']} ";
        $query .= "LIMIT 1";
        
        $result = mysqli_query($db_conx, $query);
        confirm_query($result);
        
        if($result){
            $_SESSION['message'] = "Patient Details Updated";
            redirect_to("patient-updated-success.php");
        }else{
            $_SESSION['message'] = "Patient Not Updated";
        }
                
        
    }
    
    
    
}
?>
<?php get_header("Edit Patient");  ?>
    <div id="wrapper">

   <?php require_once('nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Edit Patient</h2>
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
                            DataTables Advanced Tables
			</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                  <div style="padding: 10px;">
                                      <form method="post" action="edit-patient.php?id=<?php echo $current_patient['id'] ?>"> 
                                            <div class="form-group">
                                              <label class="col-sm-3 control-label">Name</label>
                                              <div class="col-sm-8">
                                                  <input type="text" name="name" class="form-control" value="<?php echo $current_patient['name'] ?>"  placeholder="Enter Patient Name"/>
                                              </div>
                                            </div>
                                            <br><br>  <br> 

                                            <div class="form-group">
                                              <label class="col-sm-3 control-label"  >Email</label>
                                              <div class="col-sm-8">
                                                  <input type="text" name="email" class="form-control" value="<?php echo $current_patient['email'] ?>" placeholder="Enter Patient Email"/>
                                              </div>
                                            </div>
                                           <br><br>
                                           <div class="form-group">
                                              <label class="col-sm-3 control-label" >Address</label>
                                              <div class="col-sm-8">
                                                  <input type="text" name="address" class="form-control" value="<?php echo $current_patient['address'] ?>" placeholder="Enter Patient Address"/>
                                              </div>
                                            </div>
                                        
                                                  <br><br>	  
                                           <div class="form-group">
                                              <label class="col-sm-3 control-label">Age</label>
                                              <div class="col-sm-8">
                                                  <input type="text" name="age" class="form-control" id="" value="<?php echo $current_patient['age'] ?>" placeholder="Enter Patient Age"/>
                                              </div>
                                            </div>
                                                  <br><br>	  
                                           <div class="form-group">
                                              <label class="col-sm-3 control-label">Phone</label>
                                              <div class="col-sm-8">
                                                  <input type="text" name="phone" class="form-control" value="<?php echo $current_patient['landphone'] ?>" placeholder="Enter Patient Phone no."/>
                                              </div>
                                            </div>
                                          
                                                  <br><br> <br>
                                                  <div class="form-group">
                                                      <div class="col-sm-8">
                                                           <a href="patients.php" class="btn btn-default">Cancel</a>
                                                           <input type="submit" class="btn btn-primary" name="submit" value="Update Patient">
                                                      </div>
                                                  </div>
                                                 
                                      </form>
              
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

                            <!-- /.modal -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php require_once('footer.php'); ?>
