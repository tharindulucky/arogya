<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php get_header("About");  ?>
    <div id="wrapper">

   <?php require_once('nav.php'); ?>

       <div id="page-wrapper">
            <div class="row">
                
                <!-- /.col-lg-12 -->
            </div>
           
           <div class="row">
                
                <!-- /.col-lg-12 -->
            </div>
            
            <!-- /.row -->
             <!-- /.row -->
             
             <br><br>
             
            <div class="row">
                <div class="col-lg-12 center" style="text-align: center;">
                    <div class="col-lg-12 ">
                        <h1><i class="fa fa-user-md fa-4x"></i> </h1>
                        <h3 class="page-header">Patient Management System </h3>
                        <!--<p>Another Web Solution by
                            <a href="http://www.geniusamigos.com" target="blank">GeniusAmigos.com</a></p> -->
                        <p>Powered by
                            <a href="http://www.smartit.lk" target="blank">SmartIT</a></p>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
         
        <!-- /.modal -->
        </div>
        <!-- /#page-wrapper -->

    </div>
  
<?php require_once('footer.php'); ?>