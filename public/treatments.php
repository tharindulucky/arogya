<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php
if(isset($_POST['submit'])){
    
    //validations
    $required_fields = array('name');
    validate_has_presense($required_fields,0);
    
    already_has_treatment(filter($_POST['name']));
    
    if(empty($errors)){
        $name = filter($_POST['name']);
        $notes = filter($_POST['notes']);
        
        $query = "INSERT INTO treatment(";
        $query .= "name, note";
        $query .= ") VALUES(";
        $query .= "'{$name}', '{$notes}'";
        $query .= ");";
        
        $result = mysqli_query($db_conx, $query);
        confirm_query($result);
        
        if($result){
            $_SESSION['message'] = "Treatment Added";
            redirect_to("treatment-added-success.php");
        }else{
            $_SESSION['message'] = "Treatment Not Added";
        }
    }
}
?>
<?php get_header("Treatments");  ?>
    <div id="wrapper">
      <?php require_once('nav.php'); ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Treatments Book <button style="align:right" type="button" class="btn btn-success btn-circle btn-lg" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <?php 
                echo message();
                errors();
                has_presense_errors($errors);
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            The treatments currently you're offering
							
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Treatment Name</th>
                                            <th>Note</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $result = get_treatments();
                                            while($treatments_set = mysqli_fetch_assoc($result)){
                                            ?>
                                            <tr>
                                                <td><?php echo $treatments_set['id']; ?></td>
                                                <td><?php echo $treatments_set['name']; ?></td>
                                                <td><?php echo $treatments_set['note']; ?></td>
                                                <td class="center">
                                                        <a href="edit-treatment.php?id=<?php echo $treatments_set['id']; ?>" id="ttt" style="align:right" class="btn btn-info btn-circle" ><i class="fa fa-pencil"></i></a>
                                                        <a onclick="return confirm('Are you sure ?')" href="delete-treatment.php?id=<?php echo $treatments_set['id']; ?>" class="btn btn-warning btn-circle"><i class="fa fa-times"></i></a>
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
                    <form class="form-horizontal" role="form" method="post" action="treatments.php">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Add Treatment</h4>
                    </div>
                     <!-- Modal Body -->
                        <div class="modal-body">
                              <div class="form-group">
                                <label  class="col-sm-3 control-label"
                                          for="inputEmail3">Treatment Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name']: "" ?>" placeholder="Treatment name"/>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="col-sm-3 control-label">Notes</label>
                                <div class="col-sm-8">
                                    <textarea rows="4" cols="50" class="form-control" id="notes" name="notes" placeholder="Notes on the treatment"><?php echo isset($_POST['notes']) ? $_POST['notes']: "" ?></textarea>			
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
                            <!-- /.modal -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

 <?php require_once('footer.php'); ?>