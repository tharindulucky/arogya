<?php

$insert_default_user = "INSERT INTO user(email, password) VALUES 
                     ('demo@demo.com', 'demo');
                     ";

$query = mysqli_query($db_conx, $insert_default_user);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp;  demo user INSERTED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp; demo user NOT INSERTED :-(". mysqli_error($db_conx);
}



$insert_diseases = "INSERT INTO disease(name, note) VALUES 
                     ('Gum disease', 'The first stage of gum disease is called gingivitis, which is the only stage that is reversible. If not treated, gingivitis may lead to a more serious, destructive form of gum/periodontal disease called periodontitis. It is possible to have gum disease and have no warning signs. '),
                     ('Missing Teeth', 'Missing molar can affect how you chew. Remaining teeth may shift and in some cases, bone loss can occur around a missing tooth. With today’s advances, you don’t have to suffer from missing teeth. '),
                     ('Sensitivity', 'Sensitive teeth can be treated. Your dentist may recommend desensitizing toothpaste or an alternative treatment based on the cause of your sensitivity. Proper oral hygiene is the key to preventing sensitive-tooth pain. Ask your dentist if you have any questions about your daily oral hygiene routine or concerns about tooth sensitivity.'),
                     ('Dry mouth', 'Patients using oral inhalers for asthma often develop oral candidiasis, an oral fungal infection, and are encouraged to rinse their mouths with water after using the inhaler. Tell your dentist what medications you are taking and any other information about your health that may help identify the cause of your dry mouth.'),
                     ('Oropharyngeal Cancer', 'Ororpharyngeal cancer can affect any area of the oropharyngeal cavity including the lips, gum tissue, check lining, tongue, jaw the hard or soft palate and throat. It often starts as a tiny, unnoticed white or red spot or sore or swelling anywhere in the mouth or throat. ')
                     ;";

$query = mysqli_query($db_conx, $insert_diseases);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp;  diseases book INSERTED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  diseases book NOT INSERTED :-(". mysqli_error($db_conx);
}



$insert_treatments = "INSERT INTO treatment(name, note) VALUES 
                     ('Extractions', 'Whatever the description is'),
                     ('fillings', 'Whatever the description is'),
                     ('Scalings', 'Whatever the description is'),
                     ('Root Canal Treatments', 'Whatever the description is'),
                     ('Jacket Crowns Porcelain', 'Whatever the description is'),
                     ('Full Metal Crown', 'Whatever the description is'),
                     ('Post Crowns Porcelain With Fiber Post', 'Whatever the description is'),
                     ('Bridges Porcelain', 'Whatever the description is'),
                     ('Maryland Bridges', 'Whatever the description is'),
                     ('Bridges Zirconia', 'Whatever the description is'),
                     ('Dentures Acrylic English', 'Whatever the description is'),
                     ('Dentures Acrylic Japanese', 'Whatever the description is'),
                     ('Dentures Valplast Flexible', 'Whatever the description is'),
                     ('Orthodontic Plates', 'Whatever the description is'),
                     ('Fixed Appliances', 'Whatever the description is'),
                     ('Correction Of Medial Diastema', 'Whatever the description is'),
                     ('Whitening Of Teeth Or Bleaching', 'Whatever the description is'),
                     ('Removal Of Impacted Molar', 'Whatever the description is'),
                     ('Minor Operations', 'Whatever the description is'),
                     ('Metal Dentures', 'Whatever the description is'),
                     ('Incision And Drianage', 'Whatever the description is')
                     ;";

$query = mysqli_query($db_conx, $insert_treatments);

if($query == TRUE){
    echo "<br><br><span style=\"color:green;\" class=\"glyphicon glyphicon-ok\" aria-hidden=\"true\"></span>&nbsp;  treatments book INSERTED SUCCESSFULLY";
}else{
    echo "<br><br><span style=\"color:red;\" class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span>&nbsp;  treatments book NOT INSERTED :-(". mysqli_error($db_conx);
}