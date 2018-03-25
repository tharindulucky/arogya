<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>

<?php get_header("Gallery");  ?>
    <div id="wrapper">

   <?php require_once('nav.php'); ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Patients Image Gallery</h2>
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
                                     <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            
                                            <th>Name</th>
                                            <th>NIC</th>
                                            <th style="width:110px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                            <?php
                                            $result = get_patients();
                                            while($patients_set = mysqli_fetch_assoc($result)){
                                            ?>
                                        <tr>
                                                <td><?php echo $patients_set['name']; ?></td>
                                                <td class="center"><?php echo $patients_set['nic']; ?></td>
                                                <td class="center">
                                                    <a href="view-gallery.php?p_id=<?php echo $patients_set['id']; ?>" class="btn btn-primary">View Photos</a></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        
                                        
                                    </tbody>
                                </table>
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
