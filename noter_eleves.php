<?php
    include('config.php');

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    echo "<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
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
        echo $query.";<br>";
        mysqli_query($connect, $query);
    }
    
    mysqli_close($connect);
?>
