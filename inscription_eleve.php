<?php
    include('config.php');

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    echo "<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
    </head>";

    // Connect to db

    $eleve_table = 'eleves';
    $seance_table = 'seances';

    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");


    $query = "SELECT * FROM ".$eleve_table;
    $eleves = mysqli_query($connect, $query);

    $query = "SELECT * FROM $seance_table
                WHERE DateSeance>CURDATE()";
    $seances = mysqli_query($connect, $query);

    echo "<form method='POST' action='inscrire_eleve.php'>";
    echo "<h2>Choisir un élève</h2>";
    echo "<select name='ideleve' size='4'>";    
    while ($row = mysqli_fetch_array($eleves, MYSQLI_NUM)) {         
        echo "<option value='".$row[0]."'>".$row[1]." ".$row[2]." || ".$row[3]."</option>";
    }
    echo "</select><br>";

    echo "<h2>Choisir des séances</h2>";
    echo "<select name='idseances' size='4'>";
    while ($row = mysqli_fetch_array($seances, MYSQLI_NUM)) {
        echo "<option value='".$row[0]."'>".$row[1]." || ".$row[2]." || ".$row[3]."</option>";
    }
    echo "</select><br>";
    echo "<input type='submit' class='btn btn-primary' value='Inscrire'>";
    echo "</form>";

    mysqli_close($connect);
?>
