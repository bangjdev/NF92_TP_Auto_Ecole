<?php
include('config.php');
include('message.php');
// ================ GLOBAL VARIABLES =================
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
date_default_timezone_set('Europe/Paris');
$required_params = array(
   'firstname',
   'lastname',
   'dob'
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

$dbtable = 'eleves';

$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
mysqli_query($connect, "SET NAMES utf8");

$lastname = mysqli_real_escape_string($connect, $_POST['lastname']);
$firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
$dateNaiss = mysqli_real_escape_string($connect, $_POST['dob']);
$date = date("Y-m-d");

if ($dateNaiss >= $date) {
    show_error("La date de naissance n'est pas bonne");
    return;
}

$query = "SELECT * FROM " . $dbtable . " WHERE nom='" . $lastname . "' AND prenom='" . $firstname . "'";
$result = mysqli_query($connect, $query);


echo "<div class='container col-sm-8 mainbox-big'>";
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
              <input type='text' name='lastname' value='" . htmlspecialchars($_POST['lastname'], ENT_QUOTES) . "' readonly='readonly' class='form-control'>
           </div>
        </div>
        <div class='form-group row'>
           <label class='col-sm-3 col-form-label'>Prénom d'élève</label>
           <div class='col-sm-9'>
              <input type='text' name='firstname' value='" . htmlspecialchars($_POST['firstname'], ENT_QUOTES) . "' readonly='readonly' class='form-control'>
           </div>
        </div>
        <div class='form-group row'>
           <label class='col-sm-3 col-form-label'>Date de naissance</label>
           <div class='col-sm-9'>
              <input type='date' name='dob' value='" . $dateNaiss . "' readonly='readonly' class='form-control'>
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