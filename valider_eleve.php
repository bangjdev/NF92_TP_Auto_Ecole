<?php
// ================ GLOBAL VARIABLES =================
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
date_default_timezone_set('Europe/Paris');
$required_params = array('firstname',
                        'lastname',
                        'dob',
                        'email',
                        'tel',
                        'address');

// ==================== FUNCTIONS ====================

function check_params($params) {
    foreach ($GLOBALS['required_params'] as $param_name) {
        if (empty($params[$param_name]))
            return false;
    }
    return true;
}

function show_summary($params) {
    echo "<h1>Récapitulatif</h1><ul>";
    foreach ($GLOBALS['required_params'] as $param_name) {
        echo "<li>".$param_name." : ".$params[$param_name]."</li>";
    }
    echo "</ul>";
}

// ==================== MAIN ====================
if (!check_params($_POST)) {
    echo "Bad request<br>";
    return;
}
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'mypassword';
$dbname = 'nf92a172';
$dbtable = 'eleves';

$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$dateNaiss = $_POST['dob'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$address = $_POST['address'];
$sex = $_POST['sex'];
$date = date("Y-m-d");

$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Can't connect to database");

$query = "SELECT * FROM ".$dbtable." WHERE sexe='".$sex."' AND nom='".$lastname."' AND prenom='".$firstname."'";
$result = mysqli_query($connect, $query);
if ($result) {
    echo "Il existe déjà un élève avec le même nom et prénom avec vous.<br>
    Si vous voulez encore l'enregistrer, cliquez sur le bouton <b>Confirmer</b><br>
    Sinon, cliquez sur le bouton <b>Annuler</b><br>";

    echo "<form action='ajouter_eleve.php' method='POST'>
        <input type='hidden' name='lastname' value='".$lastname."'>
        <input type='hidden' name='firstname' value='".$firstname."'>
        <input type='hidden' name='dob' value='".$dateNaiss."'>
        <input type='hidden' name='email' value='".$email."'>
        <input type='hidden' name='tel' value='".$tel."'>
        <input type='hidden' name='address' value='".$address."'>
        <input type='hidden' name='sex' value='".$sex."'>
        <input type='submit' class='btn btn-primary' value='Confirmer'>
        <input type='button' class='btn btn-danger' href='/autoecole.html' value='Annuler'>
     </form>";
} else {
    
}


mysqli_close($connect);
?>

