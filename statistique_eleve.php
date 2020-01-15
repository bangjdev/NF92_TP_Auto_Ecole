<?php
include('config.php');
//========================================= FUNCTIONS =======================================
function show_statistique_par_theme($connect, $ideleve) {
    $query = "SELECT themes.nom, themes.descriptif, COUNT(*), ROUND(AVG((40 - nb_fautes)/40.0*100), 2)
                FROM themes, inscription, eleves, seances
                WHERE inscription.ideleve=eleves.ideleve
                AND   inscription.idseances=seances.idseance
                AND   seances.idtheme=themes.idtheme
                AND   eleves.ideleve=$ideleve
                AND   seances.DateSeance < CURDATE()
                AND   inscription.nb_fautes>=0
                GROUP BY inscription.idseances";

    $result = mysqli_query($connect, $query);
    $eleve_info = mysqli_fetch_array(mysqli_query($connect, "SELECT nom, prenom FROM eleves WHERE ideleve=$ideleve"));
    $nom = $eleve_info['nom'];
    $prenom = $eleve_info['prenom'];

    $count = mysqli_num_rows($result);
    echo "<div class='col-sm-10 container mainbox-big'>";
    echo "<h1>Élèves $nom $prenom</h1>";
    echo "<div class='table-responsive'>";
    echo "<table class='table'>";
    echo "<thead class='thead-dark'>
            <tr>
            <th class='col-sm-3'>Thème</th>
            <th class='col-sm-3'>Description</th>
            <th class='col-sm-3'>Nb. des séances notées</th>
            <th class='col-sm-3'>Réussite (%)</th>
            </tr>
            </thead>";
    echo "<tbody>";
    $count = 0;
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
        $count ++;
        echo "<tr>";
        for ($i = 0; $i < count($row); $i ++) {
            echo "<td class='col-sm-3'>".$row[$i]."</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "<tfoot>
            <tr>
                <td>
                    Total : $count thème".(($count>1)?"s":"")."
                </td>
            </tr>
        </tfoot>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
}

function show_statistique_par_seance($connect, $ideleve) {
    $query = "SELECT themes.nom, themes.descriptif, seances.DateSeance, ROUND((40 - inscription.nb_fautes) / 40 * 100, 2)
                FROM themes, seances, inscription
                WHERE themes.idtheme = seances.idtheme
                AND seances.idseance = inscription.idseances
                AND inscription.ideleve=$ideleve
                AND seances.DateSeance < CURDATE()";

    $result = mysqli_query($connect, $query);
    $eleve_info = mysqli_fetch_array(mysqli_query($connect, "SELECT nom, prenom FROM eleves WHERE ideleve=$ideleve"));
    $nom = $eleve_info['nom'];
    $prenom = $eleve_info['prenom'];

    $count = mysqli_num_rows($result);
    echo "<div class='col-sm-10 container mainbox-big'>";
    echo "<h1>Élève $nom $prenom</h1>";
    echo "<div class='table-responsive'>";
    echo "<table class='table'>";
    echo "<thead class='thead-dark'>
            <tr>
            <th class='col-sm-3'>Thème</th>
            <th class='col-sm-3'>Description</th>
            <th class='col-sm-3'>Date de séance</th>
            <th class='col-sm-3'>Réussite (%)</th>
            </tr>
            </thead>";
    echo "<tbody>";
    $count = 0;
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
        $count ++;
        echo "<tr>";
        for ($i = 0; $i < count($row) - 1; $i ++) {            
            echo "<td class='col-sm-3'>".$row[$i]."</td>";
        }
        echo "<td class='col-sm-3'>".($row[count($row) - 1]<=100?$row[count($row) - 1]:"Indisponible")."</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "<tfoot>
            <tr>
                <td>
                    Total : $count séance".(($count>1)?"s":"")."
                </td>
            </tr>
        </tfoot>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
}

//============================================ MAIN =========================================
echo "<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
        <link rel='stylesheet' type='text/css' href='css/container.css'>
    </head>";

date_default_timezone_set('Europe/Paris');

// Connect to db
$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
mysqli_query($connect, "SET NAMES utf8");

if ((empty($_POST['ideleve'])) && (empty($_POST['seance'])) && (empty($_POST['theme']))) {
    // Show eleves to choose
    $query = "SELECT ideleve, nom, prenom, dateNaiss FROM eleves";
    $result = mysqli_query($connect, $query);
    echo "<div class='col-sm-10 container mainbox-big'>";
    echo "<h1>Choisir un élève pour le statistique</h1>";
    echo "<form action='statistique_eleve.php' method='POST'>";
    echo "<div class='table-responsive'>";
    echo "<table class='table'>";
    echo "<thead class='thead-dark'>
            <tr>
                <th class='col-sm-2'>ID</th>
                <th class='col-sm-3'>Nom</th>
                <th class='col-sm-3'>Prénom</th>
                <th class='col-sm-3'>Date de naissance</th>
                <th class='col-sm-1'>Choix</th>
            </tr>
        </thead>";
    echo "<tbody>";
    $count = 0;
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
        $count ++;
        echo "<tr>";
        echo "<td class='col-sm-2'>$row[0]</td>";
        for ($i = 1; $i < count($row); $i ++) {            
            echo "<td class='col-sm-3'>".$row[$i]."</td>";
        }                   
        echo "<td class='col-sm-1'><input type='radio' name='ideleve' value='$row[0]' required></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "<div class='form-group'>
            <div class='btn-group d-flex col-sm-4 offset-sm-4' role='group'>
                <input type='submit' class='btn btn-primary w-100' name = 'seance' value='Par séance'>
                <input type='submit' class='btn btn-primary w-100' name = 'theme' value='Par thème'>
            </div>        
        </div>";
    echo "</form>";
    echo "</div>";
} else {
    // Show statistic
    $ideleve = $_POST['ideleve'];
    if (!empty($_POST['theme'])) {
        show_statistique_par_theme($connect, $ideleve);
    } else {
        show_statistique_par_seance($connect, $ideleve);
    }
}

?>
