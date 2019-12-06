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
    if (!check_params($_POST)) {
        echo "Bad request<br>";
        return;
    }

    // Connect to db
    $ins_table = 'inscription';

    $eleve = $_POST['ideleve'];
    $seances = $_POST['idseances'];

    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");
    
    $query = "INSERT INTO ".$ins_table." VALUES('".$eleve."', '".$seances."', '')";
    echo $query;

    $result = mysqli_query($connect, $query);

    if (!$result) {
        echo "Bad request<br>".mysqli_error($connect);
    }

    mysqli_close($connect);
?>
