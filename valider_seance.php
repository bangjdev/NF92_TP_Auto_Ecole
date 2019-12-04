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
    $idseance = $_GET['idseance'];

    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");


    $query = "SELECT eleves.ideleve, nom, prenom, dateNaiss, nb_fautes
                FROM eleves, seances, inscription 
                WHERE eleves.ideleve=inscription.ideleve
                AND  seances.idseance=inscription.idseances
                AND  seances.idseance='$idseance'";
	echo $query;
	$result = mysqli_query($connect, $query);
    
    echo "<h1>Liste des étudiants à valider</h1>";
    echo "<form action='noter_eleves.php' method = 'POST'>";
	echo "<table border='1'>";
	echo "<tr>
			<th>ID</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Date de naissance</th>
			<th>Nombre de fautes</th>
		  </tr>";
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
        echo "<tr>";
        for ($i = 0; $i < count($row) - 1; $i ++) {            
	    	echo "<td>".$row[$i]."</td>";
        }
		echo "<td><input type='number' name='$row[0]' value='$row[4]'></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<input type='hidden' name='idseance' value='$idseance'>";
    echo "<input type='submit' value='Mettre à jour'>";
    echo "</form>";

    mysqli_close($connect);
?>
