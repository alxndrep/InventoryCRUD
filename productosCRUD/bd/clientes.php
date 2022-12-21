<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$razon_social = (isset($_POST['razon_social'])) ? $_POST['razon_social'] : '';
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : '';
$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$giro = (isset($_POST['giro'])) ? $_POST['giro'] : '';
$contacto = (isset($_POST['contacto'])) ? $_POST['contacto'] : '';
$comuna = (isset($_POST['comuna'])) ? $_POST['comuna'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$rut = (isset($_POST['rut'])) ? $_POST['rut'] : '';
$busquedaAJAX = (isset($_POST['busquedaAJAX'])) ? $_POST['busquedaAJAX'] : '';

switch($opcion){
    case 1:
        $consulta = "INSERT INTO clientes (rut, razon_social, email, giro, contacto, comuna, direccion) VALUES( '$rut', \"$razon_social\", '$email', '$giro', \"$contacto\", '$comuna', \"$direccion\")"; 
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consultav2 = "SELECT rut, razon_social, giro, email, contacto, comuna, direccion from clientes;";

        $resultado = $conexion->prepare($consultav2);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);       
        break;    
    case 2:        
        $consulta = "UPDATE clientes SET razon_social=\"$razon_social\", email='$email', giro='$giro', contacto=\"$contacto\", comuna='$comuna', direccion=\"$direccion\" WHERE rut='$rut'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();      
                 
        $consultav2 = "SELECT rut, razon_social, giro, email, contacto, comuna, direccion from clientes;";
        $resultado = $conexion->prepare($consultav2);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:        
        $consulta = "DELETE FROM clientes WHERE rut='$rut';";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;
    case 4:    
        $consultav2 = "SELECT rut, razon_social, giro, email, contacto, comuna, direccion from clientes;";
        $resultado = $conexion->prepare($consultav2);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 5:
        $consultav2 = "SELECT rut, razon_social as nombre, giro, email, contacto, comuna, direccion from clientes where razon_social like '$busquedaAJAX'";
        $resultado = $conexion->prepare($consultav2);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 6:
        $consultav2 = "SELECT rut, razon_social as nombre, giro, email, contacto, comuna, direccion from clientes where rut like '$busquedaAJAX'";
        $resultado = $conexion->prepare($consultav2);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 7:
        $consulta = "SELECT rut from clientes where rut = '$rut'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
$conexion=null;