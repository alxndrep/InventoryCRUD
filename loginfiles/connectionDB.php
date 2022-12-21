<?php
    
    $mysqli = new mysqli('localhost', 'libreri2_admin', 'carlos18_basededatos2022', 'libreri2_libreriadiego');
    //$mysqli = new mysqli('localhost', 'libreriadiego', 'root', '');

    if($mysqli->connect_errno):
        echo "Error al conectarse con el servidor";
    endif;
?>