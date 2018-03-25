<?php require_once('../inc/functions.php');  ?>
<?php require_once('../inc/validation_functions.php');  ?>
<?php require_once ("../inc/db_conx.php"); ?>
<?php require_once ("../inc/sessions.php"); ?>
<?php check_logged_in() ?>
<?php check_user_exists() ?>
<?php get_header("Debugger");  ?>


  

<script type="text/javascript">//<![CDATA[
$(window).load(function(){
$('#datetimepicker1').datetimepicker();
$('#datetimepicker2').datetimepicker();
});//]]> 

</script>

<style>
    
    
    
</style>


<div class="form-group">
            <div class="input-group date" id="datetimepicker1">
                <input class="form-control" type="text"><span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
            </div>
        </div>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    
      <script type="text/javascript" src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
    
      <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css">
    