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

    // Connect to db

    $eleve_table = 'eleves';
    $seance_table = 'seances';

    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");


    $query = "SELECT * FROM ".$eleve_table;
    $eleves = mysqli_query($connect, $query);

    echo "<div class='container col-sm-6 mainbox-big'>";
    echo "<h1>Inscription à une séance</h1>";
    echo "<form method='POST' action='choisir_seance.php'>";
    echo "<div class='form-group row'>
            <label class='col-sm-4 col-form-label'>Choissisez un élève</label>
            <div class='col-sm-8'>
                <select class='custom-select' name='ideleve' size='5'>";
    while ($row = mysqli_fetch_array($eleves, MYSQLI_NUM)) { 
        echo "<option value='".$row[0]."'>".$row[1]." ".$row[2]."</option>";
    }
    echo        "</select>";
    echo    "</div>
          </div>";

    echo "
        <div class='form-group'>
        <div class='btn-group d-flex col-sm-6 offset-sm-3' role='group'>
            <input type='submit' class='btn btn-primary w-100' value='Choisir'>
        </div>
      </div>
    </form>
    </div>";

    mysqli_close($connect);
?>
