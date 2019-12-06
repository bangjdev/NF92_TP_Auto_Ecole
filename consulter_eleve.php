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
    if (empty($_GET['ideleve'])) {
        return;
    }
    $ideleve = $_GET['ideleve'];


    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");


    $query = "SELECT nom, prenom, dateNaiss, dateInscription
                FROM eleves
                WHERE ideleve=$ideleve";
	$result = mysqli_query($connect, $query);
   
    echo "<div class='container'>";
    echo "<h1>Informations personnelles</h1>";    
    echo "<div class='table-responsive'>";
	echo "<table class='table'>";
	echo "<thead class='thead-dark'>
          <tr>
			<th>Nom</th>
			<th>Prénom</th>
            <th>Date de naissance</th>
            <th>Date d'inscription</th>
		  </tr>
          </thead>";
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
        echo "<tr>";
        for ($i = 0; $i < count($row); $i ++) {
	    	echo "<td>".$row[$i]."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    echo "</div>";

    mysqli_close($connect);
?>
