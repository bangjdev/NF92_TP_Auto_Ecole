<?php
function show_error($message) {
    echo "<div class='container col-sm-6 errorbox'>
            <div class='alert alert-danger'>
                <strong>Échoué !</strong><br>$message
            </div>
        </div>";
}

function show_success($message) {
    echo "<div class='alert alert-success'>
            <strong>Réussi !</strong><br>$message
        </div>";
}
?>