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
    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");


    $query = "SELECT ideleve, nom, prenom FROM eleves";
	$result = mysqli_query($connect, $query);
   
    echo "<div class='col-sm-8 container mainbox-big'>";
    echo "<h1>Liste des étudiants</h1>";
    echo "<form action='consulter_eleve.php' method = 'POST'>";
    echo "<div class='table-responsive'>";
	echo "<table class='table'>";
	echo "<thead class='thead-dark'>
          <tr>
            <th>Index</th>
			<th>Nom</th>
            <th>Prénom</th>
            <th>#</th>
		  </tr>
          </thead>";
    echo "<tbody>";
    $count = 0;
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
        $count ++;
        echo "<tr>";
        echo "<td>$count</td>";
        for ($i = 1; $i < count($row); $i ++) {            
	    	echo "<td>".$row[$i]."</td>";
        }		
        echo "<td><a class='btn btn-success' href='consulter_eleve.php?ideleve=".$row[0]."'>Consulter</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</form>";
    echo "</div>";

    mysqli_close($connect);
?>
