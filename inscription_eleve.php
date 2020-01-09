<?php
include('config.php');

echo "<head>
    <meta charset='utf-8'/>
    <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='css/container.css'>
</head>";

// Connect to db

$eleve_table = 'eleves';
$seance_table = 'seances';

$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
mysqli_query($connect, "SET NAMES utf8");


$query = "SELECT * FROM ".$eleve_table;
$eleves = mysqli_query($connect, $query);

$query = "SELECT idseance, DateSeance, effmax, nom
            FROM $seance_table, themes
            WHERE DateSeance>=CURDATE()
            AND   themes.supprime=0
            AND   seances.idtheme=themes.idtheme";
$seances = mysqli_query($connect, $query);

echo "<div class='container col-sm-6 mainbox-big'>";
echo "<h1>Inscription à une séance</h1>";
echo "<form method='POST' action='inscrire_eleve.php'>";
echo "<div class='form-group row'>
        <label class='col-sm-4 col-form-label'>Choissisez un élève</label>
        <div class='col-sm-8'>
            <select class='custom-select' name='ideleve' size='5' required>";
while ($row = mysqli_fetch_array($eleves, MYSQLI_NUM)) { 
    echo "<option value='".$row[0]."'>ID : $row[0] || ".$row[1]." ".$row[2]."</option>";
}
echo        "</select>";
echo    "</div>
        </div>";

echo "<div class='form-group row'>
        <label class='col-sm-4 col-form-label'>Choissisez une séance</label>
        <div class='col-sm-8'>
            <select class='custom-select' name='idseances' size='5' required>";
while ($row = mysqli_fetch_array($seances, MYSQLI_NUM)) {
    echo "<option value='".$row[0]."'>Date : ".$row[1]." || EffMax : ".$row[2]." || Thème : ".$row[3]."</option>";
}
echo        "</select>";
echo    "</div>
    </div>
    <div class='form-group'>
    <div class='btn-group d-flex col-sm-6 offset-sm-3' role='group'>
        <input type='submit' class='btn btn-primary w-100' value='Inscrire'>
        <input type='reset' class='btn btn-warning w-100' value='Réinitialiser'>
    </div>            
    </div>
</form>
</div>";

mysqli_close($connect);
?>
