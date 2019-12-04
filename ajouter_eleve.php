<?php
    include('config.php');
// ================ GLOBAL VARIABLES =================
//    error_reporting(E_ALL);
//    ini_set('display_errors', 1); 
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
        //    	http_response_code(400);
        echo "Bad request<br>";
	    return;
    }
    date_default_timezone_set('Europe/Paris');
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $dateNaiss = $_POST['dob'];
    $date = date("Y-m-d");

    show_summary($_POST);

    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");

    $query = "INSERT INTO eleves VALUES(NULL,'".$lastname."','".$firstname."','".$dateNaiss."','".$date."')";
    echo "<h1>Query</h1>".$query."<br>";
    $result = mysqli_query($connect, $query);
    if (!$result) {
        echo "Bad request<br>".mysqli_error($connect);
    }
    mysqli_close($connect);
?>
