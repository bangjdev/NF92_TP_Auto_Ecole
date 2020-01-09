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
    if (empty($_GET['ideleve'])) {
        return;
    }
    $ideleve = $_GET['ideleve'];


    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");


    $query = "SELECT themes.nom, themes.descriptif, seances.DateSeance
                FROM seances, themes, inscription
                WHERE inscription.ideleve=$ideleve
                AND   inscription.idseances=seances.idseance
                AND   seances.idtheme=themes.idtheme
                AND   seances.DateSeance>=CURDATE()";
    $result = mysqli_query($connect, $query);    
   
    echo "<div class='container col-sm-8 mainbox-big'>";
    echo "<h1>Liste des séances du futur</h1>";    
    echo "<div class='table-responsive'>";
	echo "<table class='table'>";
	echo "<thead class='thead-dark'>
          <tr>
			<th class='col-sm-3'>Thème</th>
			<th class='col-sm-5'>Description</th>
            <th class='col-sm-4'>Date</th>
		  </tr>
          </thead>";
    
    $count = 0; // Count number of séances
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
        $count ++;
        echo "<tr>";
        echo "<td class='col-sm-3'>".$row[0]."</td>";
        echo "<td class='col-sm-5'>".$row[1]."</td>";
        echo "<td class='col-sm-4'>".$row[2]."</td>";        
        echo "</tr>";
    }
    echo "<tfoot>
            <tr>
                <td>Total : $count séance".(($count>1)?"s":"")."</td>
            </tr>
        </tfoot>";
    echo "</table>";
    echo "</div>";
    echo "</div>";

    mysqli_close($connect);
?>
