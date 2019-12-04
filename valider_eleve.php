<?php
include('config.php');
// ================ GLOBAL VARIABLES =================
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
date_default_timezone_set('Europe/Paris');
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
    
}

// ==================== MAIN ====================
if (!check_params($_POST)) {
    echo "Bad request<br>";
    return;
}

echo "<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
    </head>";

$dbtable = 'eleves';

$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$dateNaiss = $_POST['dob'];
$date = date("Y-m-d");

$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
mysqli_query($connect, "SET NAMES utf8");

$query = "SELECT * FROM ".$dbtable." WHERE nom='".$lastname."' AND prenom='".$firstname."'";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result)) {
    echo "Il existe déjà un élève avec le même nom et prénom.<br>
    Si vous voulez encore l'enregistrer, cliquez sur le bouton <b>Confirmer</b><br>
    Sinon, cliquez sur le bouton <b>Annuler</b><br>";
}

echo "<h1>Récapitulatif</h1>";
    echo "<form action='ajouter_eleve.php' method='POST'>
        <input type='text' name='lastname' value='".$lastname."' readonly='readonly'><br>
        <input type='text' name='firstname' value='".$firstname."' readonly='readonly'><br>
        <input type='date' name='dob' value='".$dateNaiss."' readonly='readonly'><br>
        <input type='submit' class='btn btn-primary' value='Confirmer'>
        <input type='button' class='btn btn-danger' href='/autoecole.html' value='Annuler'><br>
     </form>";

mysqli_close($connect);
?>

