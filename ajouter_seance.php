<?php
include('config.php');
include('message.php');
// ================ GLOBAL VARIABLES =================
date_default_timezone_set('Europe/Paris');

$required_params = array('menuChoixTheme',
                        'DateSeance',
                        'effmax');

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
        echo "<li>ID thème : ".$params['menuChoixTheme']."</li>";
        echo "<li>Date : ".$params['DateSeance']."</li>";
        echo "<li>Nombre d'effectis maximum : ".$params['effmax']."</li>";
    echo "</ul>";
}

// ==================== MAIN ====================
echo "<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
        <link rel='stylesheet' type='text/css' href='css/container.css'>
    </head>";
if (!check_params($_POST)) {
    show_error("Veuillez remplir tous les champs demandés");
    return;
}  
$dbtable = 'seances';
$theme = $_POST['menuChoixTheme'];
$dateseance = $_POST['DateSeance'];
$today = date("Y-m-d");
$effmax = $_POST['effmax'];

// show_summary($_POST);

if ($dateseance <= $today) {
    show_error("Vous ne pouvez que créer une séance dans le futur");    
    return;
}    

$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
mysqli_query($connect, "SET NAMES utf8");

// Check duplicate seance
$query = "SELECT * FROM ".$dbtable." WHERE DateSeance='".$dateseance."' and idtheme='".$theme."'";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result)) {
    show_error("Vous ne pouvez pas avoir des séances avec le même thème et la même date");
    mysqli_close($connect);
    return;
}

// Insert seance
$query = "INSERT INTO ".$dbtable." VALUES(NULL,'".$dateseance."','".$effmax."','".$theme."')";

$result = mysqli_query($connect, $query);
if (!$result) {
    show_error("Impossible d'enregistrer dans la base de données");
} else {
    echo "<div class='container col-sm-6 mainbox-big'>";
    show_success("Créé une nouvelle séance");
    show_summary($_POST);
    echo "</div>";
}
mysqli_close($connect);
?>

