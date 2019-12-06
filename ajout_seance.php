<?php
    include('config.php');

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    echo"<head>
            <meta charset='utf-8'/>
            <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
            <link rel='stylesheet' type='text/css' href='css/container.css'>
        </head>";

    // Connect to db

    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");

    $query = "SELECT * FROM themes wHERE supprime=0";

    $result = mysqli_query($connect, $query);

    echo "<div class = 'container col-sm-6 mainbox-big'>";
    echo "<h1>Ajouter une séance</h1>";
    echo "<form method='POST' action='ajouter_seance.php'>";
    echo "<div class='form-group row'>
            <label class='col-sm-4 col-form-label'>Thème</label>
            <div class='col-sm-8'>
                <select class='custom-select' name='menuChoixTheme' size='5'>";
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { 
        echo "<option value='".$row[0]."'>".$row[1]."</option>";
    }
    echo        "</select>";
    echo    "</div>
          </div>
          <div class='form-group row'>
            <label class='col-sm-4 col-form-label'>Date de la séance</label>
            <div class='col-sm-8'>
                <input class='form-control' type='date' name='DateSeance'>
            </div>
          </div>
          <div class='form-group row'>
            <label class='col-sm-4 col-form-label'>Nombre d'effectif maximum</label>
            <div class='col-sm-8'>
                <input class='form-control' type='number' name='effmax'>
            </div>
          </div>
          <div class='form-group'>
            <div class='btn-group d-flex col-sm-6 offset-sm-3' role='group'>
                <input type='submit' class='btn btn-primary w-100' value='Enregistrer'>
                <input type='reset' class='btn btn-warning w-100' value='Réinitialiser'>
            </div>            
          </div>
        </form>
        </div>";
    mysqli_close($connect);
?>
