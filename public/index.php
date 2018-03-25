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
                
                
            </div>
            <!-- /.row -->
            
            
            
            <div class="row">
                
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Total patients per year
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
                            <i class="fa fa-bar-chart-o fa-fw"></i> Admission vs Discharges 
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
                        
                        <div class="panel-body">
                            <div id="morris-bar-chart"></div>
                        </div>
                    </div>
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
                    
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Patients by Categories
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                            <a href="#" class="btn btn-default btn-block">View Details</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                   
                </div>
                <!-- /.col-lg-4 -->
                
                
            </div>
            
            
            
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require_once('footer.php'); ?>
    


<script src="admin/js/morris-data.js"></script>


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