<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php get_header("Dashboard");  ?>

   <?php require_once('nav.php');  ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Last 10 Patients
                            <div class="pull-right">
                                <div class="btn-group">
                                    
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th style="width:100px;">Address</th>
                                            <th style="width:80px !important">Age</th>
                                            <th>Mobile</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                            <?php
                                            $result = get_patients(10);
                                            while($patients_set = mysqli_fetch_assoc($result)){
                                            ?>
                                        <tr>
                                                <td><?php echo $patients_set['id']; ?></td>
                                                <td><?php echo $patients_set['name']; ?></td>
                                                <td class="center"><?php echo $patients_set['address']; ?></td>
                                                <td class="center"><?php echo $patients_set['age']; ?></td>
                                                <td class="center"><?php echo $patients_set['mobile']; ?></td>
                                           </tr>
                                            <?php
                                            }
                                            
                                            if (mysqli_num_rows($result) == 0) {
                                                echo "<tr><td colspan=6>No Patients Found</td></tr>";
                                            }
                                            
                                            ?>
                                        
                                        
                                    </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-8">
                                    <div id="morris-bar-chart"></div>
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                  
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Summary
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href="patients.php" class="list-group-item">
                                    <i class="fa fa-wheelchair fa-fw"></i> All patients : <?php echo count_patients(); ?>
                                    <span class="pull-right text-muted small"><em>View all</em>
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-stethoscope fa-fw"></i> Pending Treatments : <?php echo count_pending_treatments(); ?>
                                    
                                    </span>
                                </a>
                                <a href="#" class="list-group-item">
                                    <i class="fa fa-heart-o fa-fw"></i> Completed Treatments : <?php echo count_completed_treatments(); ?>
                                    
                                    </span>
                                </a>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                   
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
            
            
            
            <div class="row">
                
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Area Chart Example
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        
                          
                        
                        <div class="panel-body">
                            <div id="morris-area-chart"></div>
                            
                      
                            
                        </div>
                        
                        
                        
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Bar Chart Example
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="#">Action</a>
                                        </li>
                                        <li><a href="#">Another action</a>
                                        </li>
                                        <li><a href="#">Something else here</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.panel -->
               
                </div>
            </div>
            
            
            
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

      <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    
    
    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
    
    <script>
    $(document).ready(function() {
        $('#dataTables-example2').DataTable({
                responsive: true
        });
    });
    </script>

    
    <!-- Morris Charts JavaScript -->
    <script src="../bower_components/raphael/raphael-min.js"></script>
    <script src="../bower_components/morrisjs/morris.min.js"></script>
    <script src="../js/morris-data.js"></script>
    
    <script>
 $('#user').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        modal.find('.modal-content').html("<div style=\"width:100%; height:100px;text-align:center; \"><br><div class=\"push\"></div><i class=\"fa fa-cog fa-spin fa-3x\"></i><h4>Loading...</h4></div><div class=\"push\"><br></div>");
        //    
        //My Ajax Code
        
        
        $.post('admin-ajax-user.php', {id: id}, function(data){
             modal.find('.modal-content').html(data);
        });

    });

</script>
    
</body>

</html>
 <script>
$(function() {                               /*
    * Play with this code and it'll update in the panel opposite.
    *
    * Why not try some of the options above?
    */
   Morris.Area({
     element: 'morris-area-chart',
     data: [
       { y: '2006', a: 50},
       { y: '2007', a: 75},
       { y: '2008', a: 50},
       { y: '2009', a: 75},
       { y: '2010', a: 50},
       { y: '2011', a: 75},
       { y: '2012', a: 100}
     ],
     xkey: 'y',
     ykeys: ['a'],
     labels: ['Series A']
   });

  });
</script>