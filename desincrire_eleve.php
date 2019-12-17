<?php
include('config.php');

$required_params = array('ideleve', 'idseance');

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

// Get info
$ideleve = $_POST['ideleve'];
$idseance = $_POST['idseance'];


// Connect to db
$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
mysqli_query($connect, "SET NAMES utf8");


$query = "DELETE FROM inscription
            WHERE ideleve=$ideleve
            AND   idseances=$idseance";

mysqli_query($connect, $query);

echo "<div class='container col-sm-6 errorbox'>
        <div class='alert alert-success'>
            <strong>Réussi !</strong><br>L'élève a été désinscrit de cette séance
        </div>";
echo "</div>";

mysqli_close($connect);
?>