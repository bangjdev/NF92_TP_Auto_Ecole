<?php
include('config.php');
// ================ GLOBAL VARIABLES =================
$required_params = array('firstname',
                        'lastname',
                        'dob');

// ==================== FUNCTIONS ====================

function check_params($params) {
    foreach ($GLOBALS['required_params'] as $param_name) {
        if (empty($params[$param_name]))
            return false;
    }
    return true;
}

function show_summary($params) {
    echo "<h1>Récapitulatif</h1>";
    echo "<ul>";
        echo "<li>Nom : ".$params['lastname']."</li>";
        echo "<li>Prénom : ".$params['firstname']."</li>";
        echo "<li>Date de naissance : ".$params['dob']."</li>";
    echo "</ul>";
}

// ==================== MAIN ====================
echo "<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
        <link rel='stylesheet' type='text/css' href='css/container.css'>
   </head>";
if (!check_params($_POST)) {
    echo "<div class='container col-sm-8 errorbox'>
            <div class='alert alert-danger' role='alert'>
                <strong>Mauvaise requête !</strong><br>Veuillez remplir tous les champs demandés
            </div>
        </div>";
    return;
}
date_default_timezone_set('Europe/Paris');

// Get the POST params
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$dateNaiss = $_POST['dob'];


$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
// Set UTF8
mysqli_query($connect, "SET NAMES utf8");

// INSERT new student
$query = "INSERT INTO eleves VALUES(NULL,'".$lastname."','".$firstname."','".$dateNaiss."',CURDATE())";
$result = mysqli_query($connect, $query);
if (!$result) {
    echo "<div class='container col-sm-6 errorbox'>
            <div class='alert alert-danger'>
                <strong>Échoué !</strong><br>Impossible d'enregistrer dans la base de données
            </div>
        </div>";
} else {    
    echo "<div class='container col-sm-6 mainbox-big'>
            <div class='alert alert-success'>
                <strong>Réussi !</strong><br>L'élève a été enregistré
            </div>";
    show_summary($_POST);
    echo "</div>";
}
mysqli_close($connect);
?>
