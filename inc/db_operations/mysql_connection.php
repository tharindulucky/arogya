<?php
define("DB_SERVER","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("DB_NAME","dental");

//Connection to the DB

$db_conx = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

if(mysqli_connect_errno()){
    die("<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  Database Connection Error");
}else{
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp;  Connected to Database Successfully.";
}
?>