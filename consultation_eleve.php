<?php
include('config.php');

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

echo "<div class='col-sm-10 container mainbox-big'>";
echo "<h1>Liste des élèves à consulter</h1>";
echo "<form action='consulter_eleve.php' method = 'POST'>";
echo "<div class='table-responsive'>";
echo "<table class='table'>";
echo "<thead class='thead-dark'>
        <tr>
        <th class='col-sm-2'>ID</th>
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
    echo "<td class='col-sm-2'>$row[0]</td>";
    for ($i = 1; $i < count($row); $i ++) {            
        echo "<td class='col-sm-3'>".$row[$i]."</td>";
    }		
    echo "<td class='col-sm-4'><a class='btn btn-success' href='consulter_eleve.php?ideleve=".$row[0]."'>Consulter</a></td>";
    echo "</tr>";
}
echo "</tbody>";
echo "<tfoot>
        <tr>
            <td>
                Total : $count élève".(($count>1)?"s":"")."
            </td>
        </tr>
    </tfoot>";
echo "</table>";
echo "</div>";
echo "</form>";
echo "</div>";

mysqli_close($connect);
?>
