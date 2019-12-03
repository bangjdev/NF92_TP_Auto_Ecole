<?php
// ================ GLOBAL VARIABLES =================
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
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
    echo "<h1>Récapitulatif</h1><ul>";
    foreach ($GLOBALS['required_params'] as $param_name) {
        echo "<li>".$param_name." : ".$params[$param_name]."</li>";
    }
    echo "</ul>";
}

// ==================== MAIN ====================
    if (!check_params($_POST)) {
        //      http_response_code(400);
        echo "Bad request<br>";
        return;
    }
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'mypassword';
    $dbname = 'nf92a172';
    $dbtable = 'seances';
    $theme = $_POST['menuChoixTheme'];
    $dateseance = $_POST['DateSeance'];
    $today = date("Y-m-d");
    $effmax = $_POST['effmax'];

    show_summary($_POST);

    if ($dateseance < $today) {
        echo "Vous ne pouvez pas créer une séance au passé<br>";
        return;
    }

    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Can't connect to database");

    $query = "INSERT INTO ".$dbtable." VALUES(NULL,'".$dateseance."','".$effmax."','".$theme."')";

    echo "<h1>Query</h1>".$query."<br>";
    $result = mysqli_query($connect, $query);
    if (!$result) {
        echo "Bad request<br>".mysqli_error($connect);
    }
    mysqli_close($connect);
?>

