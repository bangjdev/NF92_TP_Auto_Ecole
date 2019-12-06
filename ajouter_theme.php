<?php
    include('config.php');
// ================ GLOBAL VARIABLES =================
    $required_params = array('name',
                            'descriptif');

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

    $dbtable = 'themes';
    
    $name = $_POST['name'];
    $descriptif = $_POST['descriptif'];
    $date = date("Y-m-d");

    show_summary($_POST);

    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");

    // Verify if there was a theme with same name

    $query = "SELECT * FROM ".$dbtable." WHERE nom='$name'";
    $result = mysqli_query($connect, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row[2]=='1') {  // it's deleted, reactivate it
            mysqli_query($connect, "UPDATE $dbtable SET supprime='0' WHERE idtheme=$row[0]"); 
        }
        // Duplicated, exit
        mysqli_close($connect);
        return;        
    }
    
    // If not, insert a new theme

    $query = "INSERT INTO ".$dbtable." (nom, descriptif) VALUES ('".$name."','".$descriptif."')";
    echo "<h1>Query</h1>".$query."<br>";

    $result = mysqli_query($connect, $query);
    if (!$result) {
        echo "Bad request<br>".mysqli_error($connect);
    }

    mysqli_close($connect);
?>
