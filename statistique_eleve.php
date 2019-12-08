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

    if (empty($_GET['ideleve'])) {
        // Show eleves to choose
        $query = "SELECT ideleve, nom, prenom FROM eleves";
        $result = mysqli_query($connect, $query);
        
        $count = mysqli_num_rows($result);
        echo "<div class='col-sm-10 container mainbox-big'>";
        echo "<h1>Nombre des élèves: $count</h1>";        
        echo "<div class='table-responsive'>";
        echo "<table class='table'>";
        echo "<thead class='thead-dark'>
              <tr>
                <th class='col-sm-2'>Index</th>
                <th class='col-sm-3'>Nom</th>
                <th class='col-sm-3'>Prénom</th>
                <th class='col-sm-4'>#</th>
              </tr>
              </thead>";
        echo "<tbody>";
        $count = 0;
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
            $count ++;
            echo "<tr>";
            echo "<td class='col-sm-2'>$count</td>";
            for ($i = 1; $i < count($row); $i ++) {            
                echo "<td class='col-sm-3'>".$row[$i]."</td>";
            }       
            echo "<td class='col-sm-4'><a class='btn btn-success' href='statistique_eleve.php?ideleve=".$row[0]."'>Afficher</a></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
    } else {
        // Show statistic
        $ideleve = $_GET['ideleve'];
        $query = "SELECT themes.nom, themes.descriptif, ROUND((40 - nb_fautes)/40.0*100, 2)
                    FROM themes, inscription, eleves, seances
                    WHERE inscription.ideleve=eleves.ideleve
                    AND   inscription.idseances=seances.idseance
                    AND   seances.idtheme=themes.idtheme
                    AND   eleves.ideleve=$ideleve
                    AND   seances.DateSeance < CURDATE()";

        $result = mysqli_query($connect, $query);
        $eleve_info = mysqli_fetch_array(mysqli_query($connect, "SELECT nom, prenom FROM eleves WHERE ideleve=$ideleve"));
        $nom = $eleve_info['nom'];
        $prenom = $eleve_info['prenom'];

        $count = mysqli_num_rows($result);
        echo "<div class='col-sm-10 container mainbox-big'>";
        echo "<h1>Élèves $nom $prenom a fait $count thèmes</h1>";
        echo "<div class='table-responsive'>";
        echo "<table class='table'>";
        echo "<thead class='thead-dark'>
              <tr>
                <th class='col-sm-1'>Index</th>
                <th class='col-sm-4'>Thème</th>
                <th class='col-sm-4'>Description</th>
                <th class='col-sm-3'>Réussite (%)</th>
              </tr>
              </thead>";
        echo "<tbody>";
        $count = 0;
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
            $count ++;
            echo "<tr>";
            echo "<td class='col-sm-1'>$count</td>";
            for ($i = 0; $i < count($row); $i ++) {
                if ($i == count($row) - 1)
                    echo "<td class='col-sm-3'>".$row[$i]."</td>";
                else
                    echo "<td class='col-sm-4'>".$row[$i]."</td>";
            }
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
    }

?>
