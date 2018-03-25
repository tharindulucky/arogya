<?php require_once ("../inc/sessions.php"); ?>
<?php require_once('../inc/functions.php');  ?>
<?php require_once('header.php');  ?>
<div id="wrap">
      <div class="container">
          <h1 style="line-height: 100px;">Installing...</h1>
<?php
include_once ('db_operations/mysql_connection.php');
include_once ('db_operations/create_tables.php');
include_once ('db_operations/insert_data.php');
echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp;  <b>Installation Complete!</b>";
?>
      <br><br><a href="../public/login.php" class="btn btn-primary" type="button">Finish</a><br>
      <div id="push"></div><br><br>
    </div>
</div>
<?php require_once('../public/footer.php');  ?>