<?php
include('config.php');
include('message.php');
// ================ GLOBAL VARIABLES =================
$required_params = array(
    'name',
    'descriptif'
);

// ==================== FUNCTIONS ====================

function check_params($params)
{
    foreach ($GLOBALS['required_params'] as $param_name) {
        if (empty($params[$param_name]))
            return false;
    }
    return true;
}

function show_summary($params) {
    echo "<h1>Récapitulatif</h1>";
    echo "<ul>";
        echo "<li>Nom du thème : ".$params['name']."</li>";
        echo "<li>Description : ".$params['descriptif']."</li>";
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
            <div class='alert alert-danger'>
                <strong>Mauvaise requête !</strong><br>Veuillez remplir tous les champs demandés
            </div>
        </div>";
    return;
}
date_default_timezone_set('Europe/Paris');

$dbtable = 'themes';

$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
mysqli_query($connect, "SET NAMES utf8");

$name = mysqli_real_escape_string($connect, $_POST['name']);
$descriptif = mysqli_real_escape_string($connect, $_POST['descriptif']);
$date = date("Y-m-d");

// Verify if there was a theme with same name

$query = "SELECT * FROM " . $dbtable . " WHERE nom='$name'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);
if (count($row) > 0) {     
    if ($row[2] == '1') {  // it's deleted, reactivate it
        mysqli_query($connect, "UPDATE $dbtable SET supprime='0' WHERE idtheme=$row[0]");
        echo "<div class='container col-sm-6 errorbox'>";
        show_success("Réactivé le thème");
        echo "</div>";
        mysqli_close($connect);
        return;
    }
    // Duplicated, exit
    show_error("Il existe déjà ce thème");
    mysqli_close($connect);
    return;
}

// If not, insert a new theme
$query = "INSERT INTO " . $dbtable . " (nom, descriptif) VALUES ('" . $name . "','" . $descriptif . "')";
$result = mysqli_query($connect, $query);
if (!$result) {
    show_error("Impossible d'enregistrer dans la base de données");    
} else {
    echo "<div class='container col-sm-6 mainbox-big'>";
    show_success("Ajouté un thème");
    show_summary($_POST);
    echo "</div>";
}

mysqli_close($connect);
?>