<?php
include('config.php');
include('message.php');

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

$required_params = array('idthemes');

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
    show_error("Vous n'avez choisi aucun thème");
    return;
}

echo "<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
    </head>";


date_default_timezone_set('Europe/Paris');

// Gather infos
$idthemes = $_POST['idthemes'];

// Connect to db
$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
mysqli_query($connect, "SET NAMES utf8");

for ($i = 0; $i < count($idthemes); $i ++) {
    $query = "UPDATE themes 
            SET supprime=1
            WHERE idtheme=".$idthemes[$i];
    mysqli_query($connect, $query);
}

echo "<div class='container col-sm-6 errorbox'>";
show_success("Désactivé ".count($idthemes)." thèmes");
echo "</div>";
mysqli_close($connect);
?>