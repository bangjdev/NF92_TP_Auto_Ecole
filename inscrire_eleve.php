<?php
include('config.php');
$required_params = array('ideleve',
                        'idseances');

// ==================== FUNCTIONS ====================

function check_params($params) {
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
    echo "<div class='container col-sm-6 errorbox'>
        <div class='alert alert-danger'>
            <strong>Mauvaise requête !</strong><br>Veuillez remplir tous les champs demandés
        </div>
    </div>";
    return;
}

$ins_table = 'inscription';

$eleve = $_POST['ideleve'];
$seances = $_POST['idseances'];

$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
mysqli_query($connect, "SET NAMES utf8");

$EffMax = mysqli_fetch_row(mysqli_query($connect, "SELECT EffMax
                                                    FROM seances
                                                    WHERE idseance=$seances"))[0];
$currentEff = mysqli_fetch_row(mysqli_query($connect, "SELECT count(*)
                                                        FROM inscription
                                                        WHERE idseances=$seances"))[0];
if ($currentEff >= $EffMax) {
    echo "<div class='container col-sm-6 errorbox'>
            <div class='alert alert-danger'>
                <strong>Échoué !</strong><br>Pas assez de place
            </div>
        </div>";
    mysqli_close($connect);
    return;
}

$query = "INSERT INTO ".$ins_table." (ideleve, idseances) VALUES(".$eleve.", ".$seances.")";
echo $query;

$result = mysqli_query($connect, $query);

if (!$result) {
    echo "<div class='container col-sm-6 errorbox'>
            <div class='alert alert-danger'>
                <strong>Échoué !</strong><br>Impossible d'enregistrer dans la base de données";
    if (mysqli_errno($connect) == 1062)  {
        // Duplicate entries
        echo "<br>Cet élève s'est déjà inscrit à cette séance";
    }
    echo "</div>
        </div>";
} else {
    echo "<div class='container col-sm-6 errorbox'>
            <div class='alert alert-success'>
                <strong>Réussi !</strong><br>L'élève a été inscrit à cette séance
            </div>
        </div>";
}

mysqli_close($connect);
?>
