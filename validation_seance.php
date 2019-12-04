<?php
    include('config.php');
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    date_default_timezone_set('Europe/Paris');

    echo "<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
    </head>";

    // Connect to db
    $today = date("Y-m-d");

    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");


    $query = "SELECT seances.idseance, themes.nom, themes.descriptif, seances.DateSeance
                FROM seances
                INNER JOIN themes
                ON themes.idtheme=seances.idtheme
                WHERE seances.DateSeance < '".$today."'";

    $result = mysqli_query($connect, $query);
    
    echo "<h1>Liste des séances à valider</h1>";
    echo "<form action='valider_seance.php' method = 'POST'>";
    echo "<table border='1'>";
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
        echo "<tr>";
        for ($i = 0; $i < count($row); $i ++) {            
	    	echo "<td>".$row[$i]."</td>";
        }
		echo "<td><a href='valider_seance.php?idseance=".$row[0]."'>Noter</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</form>";

    mysqli_close($connect);
?>
