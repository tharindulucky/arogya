<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php

$current_disease = null;
if(isset($_GET['id'])){
    $current_disease = get_disease_by_id($_GET['id']);
}

if(isset($_POST['submit'])){
    
    //validations
    $required_fields = array('name','notes' );
    validate_has_presense($required_fields,0);
    
    if(empty($errors)){
        $name = filter($_POST['name']);
        $notes = filter($_POST['notes']);
        
        
        $query = "UPDATE disease SET ";
        $query .= "name = '{$name}', ";
        $query .= "note = '{$notes}' ";
        $query .= "WHERE id = {$current_disease['id']} ";
        $query .= "LIMIT 1";
        
        $result = mysqli_query($db_conx, $query);
        confirm_query($result);
        
        if($result){
            $_SESSION['message'] = "Disease Details Updated";
            redirect_to("disease-added-success.php");
        }else{
            $_SESSION['message'] = "Disease Not Updated";
        }
                
        
    }
    
    
    
}
?>
<?php get_header("Edit Disease");  ?>
    <div id="wrapper">

   <?php require_once('nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Edit Disease</h2>
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
                                      <form method="post" action="edit-disease.php?id=<?php echo $current_disease['id'] ?>"> 
                                              <div class="form-group">
                                                <label  class="col-sm-3 control-label"
                                                          for="inputEmail3">Disease Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $current_disease['name'] ?>" placeholder="Disease name"/>
                                                </div>
                                              </div>
                                          <br><br><br>
                                              <div class="form-group">
                                                <label class="col-sm-3 control-label"  >Note</label>
                                                <div class="col-sm-8">
                                                    <textarea rows="4" cols="50" class="form-control" id="notes" name="notes" placeholder="Notes on the disease"><?php echo $current_disease['note'] ?></textarea>			
                                                </div>
                                              </div>
                                                  <br><br> <br>
                                                  <div class="form-group">
                                                      <div class="col-sm-8">
                                                           <a href="diseases.php" class="btn btn-default">Cancel</a>
                                                           <input type="submit" class="btn btn-primary" name="submit" value="Update Disease">
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
