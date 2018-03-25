<?php

//Table Users************************************************************************

$tbl_users = "CREATE TABLE IF NOT EXISTS user(
                id INT(11) NOT NULL AUTO_INCREMENT,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                user_type ENUM('a','b','c','d') NOT NULL DEFAULT 'a',
                PRIMARY KEY(id), 
                UNIQUE KEY email (email)
              );";

$query = mysqli_query($db_conx, $tbl_users);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; users TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  users TABLE NOT CREATED :-(";
}


//Table Patients************************************************************************

$tbl_users = "CREATE TABLE IF NOT EXISTS patient(
                id INT(11) NOT NULL AUTO_INCREMENT,
                name VARCHAR(200) NOT NULL,
                age VARCHAR(5) NOT NULL,
                email VARCHAR(255),
                landphone VARCHAR(15),
                mobile VARCHAR(15),
                address VARCHAR(500),
                gender ENUM('m','f'),
                PRIMARY KEY(id)
              );";

$query = mysqli_query($db_conx, $tbl_users);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; patient TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  patient TABLE NOT CREATED :-(";
}


//Table Diseases************************************************************************

$tbl_diseases = "CREATE TABLE IF NOT EXISTS disease(
                id INT(11) NOT NULL AUTO_INCREMENT,
                name VARCHAR(200) NOT NULL,
                note TEXT NOT NULL,
                PRIMARY KEY(id), 
                UNIQUE KEY (name)
              );";

$query = mysqli_query($db_conx, $tbl_diseases);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; disease TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  disease TABLE NOT CREATED :-(";
}




//Table Treatments************************************************************************

$tbl_treatment = "CREATE TABLE IF NOT EXISTS treatment(
                id INT(11) NOT NULL AUTO_INCREMENT,
                name VARCHAR(200) NOT NULL,
                note TEXT NOT NULL,
                PRIMARY KEY(id), 
                UNIQUE KEY (name)
              );";

$query = mysqli_query($db_conx, $tbl_treatment);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; treatment TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  treatment TABLE NOT CREATED :-(";
}





//Table diseases_record************************************************************************

$tbl_diseases_record = "CREATE TABLE IF NOT EXISTS diseases_record(
                id INT(11) NOT NULL AUTO_INCREMENT,
                datetime VARCHAR(100) NOT NULL,
                condition_name VARCHAR(200),
                note TEXT,
                patient_id INT(11) NOT NULL,
                PRIMARY KEY(id)
              );";

$query = mysqli_query($db_conx, $tbl_diseases_record);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; diseases_record TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  diseases_record TABLE NOT CREATED :-(".  mysqli_error($db_conx);
}




//Table tooth************************************************************************

$tbl_tooth = "CREATE TABLE IF NOT EXISTS tooth(
                id VARCHAR(10) NOT NULL,
                tooth VARCHAR(5),
                PRIMARY KEY(id)
              );";

$query = mysqli_query($db_conx, $tbl_tooth);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; tooth TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  tooth TABLE NOT CREATED :-(";
}






//Table tooth_diseases_rec************************************************************************

$tbl_tooth_diseases_rec = "CREATE TABLE IF NOT EXISTS tooth_diseases_rec(
                id INT(5) NOT NULL AUTO_INCREMENT,
                tooth_id VARCHAR(10) NOT NULL,
                disease_rec_id INT(11) NOT NULL,
                patient_id INT(11) NOT NULL,
                PRIMARY KEY(id)
              );";

$query = mysqli_query($db_conx, $tbl_tooth_diseases_rec);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; tooth_diseases_rec TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  tooth_diseases_rec TABLE NOT CREATED :-(";
}



//Table image************************************************************************

$tbl_image = "CREATE TABLE IF NOT EXISTS image(
                id INT(11) NOT NULL AUTO_INCREMENT,
                url VARCHAR(500) NOT NULL,
                note TEXT NOT NULL,
                patient_id INT(11) NOT NULL,
                PRIMARY KEY(id)
              );";

$query = mysqli_query($db_conx, $tbl_image);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; image TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  image TABLE NOT CREATED :-(";
}





//Table pending_treatment************************************************************************

$tbl_pending_treatment = "CREATE TABLE IF NOT EXISTS pending_treatment(
                id INT(11) NOT NULL AUTO_INCREMENT,
                datetime VARCHAR(30) NOT NULL,
                treatment VARCHAR(400) NOT NULL,
                price DECIMAL(8,2) DEFAULT 0,
                note TEXT NOT NULL,
                patient_id INT(11) NOT NULL,
                completed ENUM('0','1') NOT NULL DEFAULT '0',
                PRIMARY KEY(id),
                FOREIGN KEY (patient_id) REFERENCES patient(id)
              );";

$query = mysqli_query($db_conx, $tbl_pending_treatment);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; pending_treatment TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  pending_treatment TABLE NOT CREATED :-(";
}




//Table tooth_treatment************************************************************************

$tbl_tooth_treatment = "CREATE TABLE IF NOT EXISTS tooth_treatment_rec(
                id INT(11) NOT NULL AUTO_INCREMENT,
                tooth_id VARCHAR(10) NOT NULL,
                treatment_rec_id INT(11) NOT NULL,
                patient_id INT(11) NOT NULL,
                PRIMARY KEY(id)
              );";

$query = mysqli_query($db_conx, $tbl_tooth_treatment);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; tooth_treatment TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  tooth_treatment TABLE NOT CREATED :-(";
}




//Table treatments_record ************************************************************************

$tbl_treatments_record = "CREATE TABLE IF NOT EXISTS treatments_record(
                id INT(11) NOT NULL AUTO_INCREMENT,
                datetime VARCHAR(30) NOT NULL,
                treatment_id INT(11) NOT NULL,
                note TEXT NOT NULL,
                PRIMARY KEY(id)
              );";

$query = mysqli_query($db_conx, $tbl_treatments_record);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; treatments_record TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  treatments_record TABLE NOT CREATED :-(";
}






//Table diseases_images ************************************************************************

$tbl_diseases_images = "CREATE TABLE IF NOT EXISTS diseases_rec_images(
                id INT(11) NULL AUTO_INCREMENT,
                disease_rec_id INT(11) NOT NULL,
                image_id INT(11) NOT NULL,
                PRIMARY KEY(id)
              );";

$query = mysqli_query($db_conx, $tbl_diseases_images);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; diseases_images TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  diseases_images TABLE NOT CREATED :-(";
}





//Table treatments_images ************************************************************************

$tbl_treatments_rec_images = "CREATE TABLE IF NOT EXISTS treatments_rec_images(
                id INT(11) NULL AUTO_INCREMENT,
                treatment_rec_id INT(11) NOT NULL,
                image_id INT(11) NOT NULL,
                PRIMARY KEY(id)
              );";

$query = mysqli_query($db_conx, $tbl_treatments_rec_images);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp; treatments_images TABLE CREATED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  treatments_images TABLE NOT CREATED :-(";
}