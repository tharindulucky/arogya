<?php
session_start();

function message(){
    if(isset($_SESSION["message"])){
        echo "<div class=\"alert alert-success alert-dismissible\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
        echo $_SESSION["message"];
        echo "</div>";
        $_SESSION["message"] = NULL;
    }
}


function error_message(){
    if(isset($_SESSION["error_message"])){
        
        echo $_SESSION["error_message"];
        $_SESSION["error_message"] = NULL;
    }
}



function errors(){
    if(isset($_SESSION["errors"])){
        echo "<div class=\"alert alert-danger alert-dismissible\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
        echo $_SESSION["errors"];
        echo "</div>";
        $_SESSION["errors"] = NULL;
    }
}

function has_presense_errors($errors){
    if(!empty($errors)){
        echo "<div class=\"push\"></div>";
        echo "<div class=\"alert alert-danger alert-dismissible\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
        echo "<ul style=\"margin-left:-20px\">";
        foreach ($errors as $key => $value){
            echo "<li style=\"margin:3px\">".$value."</li>";
        }
        echo "</ul>";
        echo "</div>";  
    }
    
}
