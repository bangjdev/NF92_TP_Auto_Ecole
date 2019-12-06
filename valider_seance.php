<?php
    include('config.php');

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    echo "<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
        <link rel='stylesheet' type='text/css' href='css/container.css'>
    </head>";


    date_default_timezone_set('Europe/Paris');

    // Connect to db
    if (empty($_GET['idseance'])) {
        return;
    }
    $idseance = $_GET['idseance'];


    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");


    $query = "SELECT eleves.ideleve, nom, prenom, dateNaiss, nb_fautes
                FROM eleves, seances, inscription 
                WHERE eleves.ideleve=inscription.ideleve
                AND  seances.idseance=inscription.idseances
                AND  seances.idseance='$idseance'";
	$result = mysqli_query($connect, $query);
   
    echo "<div class='container col-sm-8 mainbox-big'>";
    echo "<h1>Liste des étudiants à valider</h1>";
    echo "<form action='noter_eleves.php' method = 'POST'>";
    echo "<div class='table-responsive'>";
	echo "<table class='table'>";
	echo "<thead class='thead-dark'>
          <tr>
			<th>Index</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Date de naissance</th>
			<th>Nombre de fautes</th>
		  </tr>
          </thead>";
    $count = 0;
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
        $count ++;        
        echo "<tr>";
        echo "<td>$count</td>";
        for ($i = 1; $i < count($row) - 1; $i ++) {            
	    	echo "<td>".$row[$i]."</td>";
        }
		echo "<td><input type='number' name='$row[0]' value='$row[4]' class='form-control'></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    echo "<input type='hidden' name='idseance' value='$idseance'>";
    echo "<div class='form-group'>
              <div class='col-sm-4 offset-sm-4 btn-group btn-group-justified'>
                  <input class='btn btn-block btn-primary' type='submit' value='Mettre à jour'>
              </div>
          </div>";
    echo "</form>";
    echo "</div>";

    mysqli_close($connect);
?>
