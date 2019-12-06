<?php
    include('config.php');
// ================ GLOBAL VARIABLES =================
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
    date_default_timezone_set('Europe/Paris');

    // Get the POST params
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $dateNaiss = $_POST['dob'];

    show_summary($_POST);


    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    // Set UTF8
    mysqli_query($connect, "SET NAMES utf8");

    // INSERT new student
    $query = "INSERT INTO eleves VALUES(NULL,'".$lastname."','".$firstname."','".$dateNaiss."',CURDATE())";
    $result = mysqli_query($connect, $query);
    if (!$result) {
        echo "Bad request<br>".mysqli_error($connect);
    }
    mysqli_close($connect);
?>
