<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $consulta = "SELECT codigo, nombre, descripcion, stock, stock_min FROM productos where stock < stock_min";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        // editar
        $codigo = (isset($_POST['codigo'])) ? $_POST['codigo'] : '';
        $stock = (isset($_POST['stock'])) ? $_POST['stock'] : '';
        $stock_min = (isset($_POST['stock_min'])) ? $_POST['stock_min'] : '';
        $consulta = "UPDATE productos SET stock = $stock, stock_min = $stock_min WHERE codigo = '$codigo'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();   

        $consulta = "SELECT codigo, nombre, descripcion, stock, stock_min FROM productos where codigo = '$codigo'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        // borrar
        $codigo = (isset($_POST['codigo'])) ? $_POST['codigo'] : '';
        $consulta = "SET FOREIGN_KEY_CHECKS = 0 ; DELETE FROM productos WHERE codigo ='$codigo'; SET FOREIGN_KEY_CHECKS = 1;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();   
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
$conexion=null;
?>