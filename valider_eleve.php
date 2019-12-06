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


echo "<div class='container col-sm-6 mx-auto'>";
if (mysqli_num_rows($result)) {
    echo "<div class='alert alert-warning' role='alert'>
              <strong>Atention !</strong> Il existe déjà un élève avec le même nom et prénom.<br>
              Si vous voulez encore l'enregistrer, cliquez sur le bouton <b>Confirmer</b><br>
              Sinon, cliquez sur le bouton <b>Annuler</b><br>
          </div>";
}
echo "<h1>Récapitulatif</h1>";
echo "<form action='ajouter_eleve.php' method='POST'>
        <div class='form-group row'>
           <label class='col-sm-3 col-form-label'>Nom d'élève</label>
           <div class='col-sm-9'>
              <input type='text' name='lastname' value='".$lastname."' readonly='readonly' class='form-control'>
           </div>
        </div>
        <div class='form-group row'>
           <label class='col-sm-3 col-form-label'>Prénom d'élève</label>
           <div class='col-sm-9'>
              <input type='text' name='firstname' value='".$firstname."' readonly='readonly' class='form-control'>
           </div>
        </div>
        <div class='form-group row'>
           <label class='col-sm-3 col-form-label'>Date de naissance</label>
           <div class='col-sm-9'>
              <input type='date' name='dob' value='".$dateNaiss."' readonly='readonly' class='form-control'>
           </div>
        </div>
        <div class='form-group'>
           <div class='col-sm-4 offset-sm-4 btn-group btn-group-justified'>
              <input type='submit' class='btn btn-primary' value='Confirmer'>
              <a class='btn btn-danger' href='ajout_eleve.html'>Annuler</a>
           </div>
        </div>
     </form>";

echo "</div>";




mysqli_close($connect);
?>

