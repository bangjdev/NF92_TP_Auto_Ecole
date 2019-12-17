<?php
include('config.php');


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


$query = "SELECT nom, prenom, dateNaiss, dateInscription
            FROM eleves
            WHERE ideleve=$ideleve";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result, MYSQLI_NUM);

echo "<div class='container col-sm-6 mainbox-big'>";
echo "<h2>Information</h2>    
        <ul>
            <li>Nom:                ".$row[0]."</li>
            <li>Prénom:             ".$row[1]."</li>
            <li>Date de naissance:  ".$row[2]."</li>
            <li>Date d'inscription: ".$row[3]."</li>
        </ul>
    </div>";

mysqli_close($connect);
?>
