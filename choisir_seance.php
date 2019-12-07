<?php
    include('config.php');

    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
    
    $required_params = array('ideleve');

// ==================== FUNCTIONS ====================

function check_params($params) {
    foreach ($GLOBALS['required_params'] as $param_name) {
        if (empty($params[$param_name]))
            return false;
    }
    return true;
}
// ==================== MAIN ====================
    if (!check_params($_POST)) {
        echo "Bad request<br>";
	    return;
    }

    echo "<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
        <link rel='stylesheet' type='text/css' href='css/container.css'>
    </head>";

    // Get info
    $ideleve = $_POST['ideleve'];


    // Connect to db
    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");


    $query = "SELECT seances.idseance, themes.nom, themes.descriptif, seances.DateSeance
                FROM seances, inscription, themes
                WHERE inscription.ideleve=$ideleve
                AND   inscription.idseances=seances.idseance
                AND   seances.idtheme=themes.idtheme
                AND   seances.DateSeance > CURDATE()";

    echo $query;
    $seances = mysqli_query($connect, $query);

    echo "<div class='container col-sm-10 mainbox-big'>";
    echo "<h1>Choissisez une séance pour désinscrire</h1>";
    echo "<form method='POST' action='desincrire_eleve.php'>";
    echo "<input type='hidden' name='ideleve' value='$ideleve'>";
    echo "<div class='table-responsive'>";
	echo "<table class='table'>";
	echo "<thead class='thead-dark'>
          <tr>
            <th class='col-sm-4'>Thème</th>
			<th class='col-sm-4'>Description</th>
            <th class='col-sm-3'>Date</th>
            <th class='col-sm-1'>#</th>
		  </tr>
          </thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_array($seances, MYSQLI_NUM)) {
        echo "<tr>";
        for ($i = 1; $i < count($row); $i ++) {
            if ($i == count($row) - 1)
                echo "<td class='col-sm-3'>".$row[$i]."</td>";
            else
	    	    echo "<td class='col-sm-4'>".$row[$i]."</td>";
        }		
        echo "<td class='col-sm-1'><input type='radio' name='idseance' value='$row[0]'></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "
        <div class='form-group'>
        <div class='btn-group d-flex col-sm-4 offset-sm-4' role='group'>
            <input type='submit' class='btn btn-primary w-100' value='Désincrire'>
        </div>            
      </div>
    </form>
    </div>";

    mysqli_close($connect);
?>