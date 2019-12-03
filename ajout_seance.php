<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

// Connect to db

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'mypassword';
$dbname = 'nf92a172';
$dbtable= 'seances';

$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Can't connect to database");
$query = "SELECT * FROM themes wHERE supprime=0";

$result = mysqli_query($connect, $query);

echo"<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
    </head>";


echo "<form method='POST' action='ajouter_seance.php'>";
echo "<select name='menuChoixTheme' size='4'>";
// echo "<table border='1'>";
// echo "<tr>";
// echo "<th>ID</th>";
// echo "<th>Nom</th>";
// echo "<th>Description</th>";
// echo "</tr>";
while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
    // echo "<tr>";
    // for ($i = 0; $i < count($row); $i ++) {
    //     if ($i != 2)
    //         echo "<td>".$row[$i]."</td>";
    // }
    // echo "</tr>";
    echo "<option value='".$row[0]."'>".$row[1]."</option>";
}
//echo "</table>";
echo "</select><br>";
echo "<input type='date' name='DateSeance'><br>";
echo "<input type='number' name='effmax'><br>";
echo "<input type='submit' class='btn btn-primary' value='Enregistrer séance'>";
echo "</form>";
mysqli_close($connect);
?>
