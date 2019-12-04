<?php
    include('config.php');

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

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
