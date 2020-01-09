<?php
include('config.php');
include('message.php');

$required_params = array('idseance');

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
        <link rel='stylesheet' type='text/css' href='css/container.css'>
    </head>";

date_default_timezone_set('Europe/Paris');

// Connect to db

$idseance = $_POST['idseance'];

$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
mysqli_query($connect, "SET NAMES utf8"); 

$query = "SELECT eleves.ideleve
            FROM eleves, inscription
            WHERE eleves.ideleve=inscription.ideleve
            AND   inscription.idseances=$idseance";
$ids = mysqli_query($connect, $query);

while ($row = mysqli_fetch_row($ids)) {
    $query = "UPDATE inscription 
            SET inscription.nb_fautes=".$_POST[$row[0]]."
            WHERE inscription.ideleve=$row[0]
            AND inscription.idseances=$idseance";
    mysqli_query($connect, $query);
}
echo "<div class='container col-sm-6 errorbox'>";
show_success("Mis à jour le nombre de fautes des élèves");
echo "</div>";

mysqli_close($connect);
?>
