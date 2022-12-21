<?php 
    session_start();
    require 'connectionDB.php';
    $usuarios = $mysqli->query("SELECT username, email, nombre, apellido, tipo
    FROM usuarios
    WHERE email = '". $_POST['uemail']. "'
    AND pwd = SHA1('". $_POST['upassword']. "');");

    if($usuarios->num_rows == 1):
        $datos = $usuarios->fetch_assoc();
        echo json_encode(array('error' => false));
        $nombre_user = $datos['nombre']. " " . $datos['apellido'];
        $_SESSION['usertype'] = $datos['tipo'];
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $nombre_user;

    else:
        echo json_encode(array('error' => true));
    endif;

    $mysqli->close();

?>