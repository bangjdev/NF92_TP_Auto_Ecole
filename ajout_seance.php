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

    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");

    $query = "SELECT * FROM themes wHERE supprime=0";

    $result = mysqli_query($connect, $query);

    echo"<head>
            <meta charset='utf-8'/>
            <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
        </head>";

    echo "<h1>Ajouter une séance</h1>";
    echo "<form method='POST' action='ajouter_seance.php'>";
    echo "<select name='menuChoixTheme' size='4'>";
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
        echo "<option value='".$row[0]."'>".$row[1]."</option>";
    }
    echo "</select><br>";
    echo "<input type='date' name='DateSeance'><br>";
    echo "<input type='number' name='effmax'><br>";
    echo "<input type='submit' class='btn btn-primary' value='Enregistrer séance'>";
    echo "</form>";
    mysqli_close($connect);
?>
