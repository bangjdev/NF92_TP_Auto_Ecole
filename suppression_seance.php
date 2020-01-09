<?php
    include('config.php');

    echo "<head>
        <meta charset='utf-8'/>
        <link rel='stylesheet' type='text/css' href='bootstrap-4.3.1/css/bootstrap.min.css'>
        <link rel='stylesheet' type='text/css' href='css/container.css'>
    </head>";

    // Connect to db
    $connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die("Can't connect to database");
    mysqli_query($connect, "SET NAMES utf8");


    $query = "SELECT seances.idseance, themes.nom, themes.descriptif, seances.DateSeance
                FROM seances, themes
                WHERE seances.idtheme=themes.idtheme
                AND   seances.DateSeance >= CURDATE()";
    
    $seances = mysqli_query($connect, $query);

    echo "<div class='container col-sm-10 mainbox-big'>";
    echo "<h1>Choissisez une séance pour supprimer</h1>";
    echo "<form method='POST' action='supprimer_seance.php'>";
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
    $count = 0;
    while ($row = mysqli_fetch_array($seances, MYSQLI_NUM)) {
        $count ++;
        echo "<tr>";
        for ($i = 1; $i < count($row); $i ++) {
            if ($i == count($row) - 1)
                echo "<td class='col-sm-3'>".$row[$i]."</td>";
            else
	    	    echo "<td class='col-sm-4'>".$row[$i]."</td>";
        }		
        echo "<td class='col-sm-1'><input type='radio' name='idseance' value='$row[0]' required></td>";
        echo "</tr>";
    }
    echo "<tfoot>
            <tr>
                <td>Total : $count séance".(($count>1)?"s":"")."</td>
            </tr>
        </tfoot>";
    echo "</table>";
    echo "</div>";
    if ($count != 0) {
        echo "<div class='form-group'>
                <div class='btn-group d-flex col-sm-4 offset-sm-4' role='group'>
                    <input type='submit' class='btn btn-primary w-100' value='Supprimer'>
                </div>        
            </div>";
    }
    echo "</form>
    </div>";

    mysqli_close($connect);
?>