<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$precio_venta = (isset($_POST['precio_venta'])) ? $_POST['precio_venta'] : '';
$precio_mayor = (isset($_POST['precio_mayor'])) ? $_POST['precio_mayor'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$stock = (isset($_POST['stock'])) ? $_POST['stock'] : '';
$stock_min = (isset($_POST['stock_min'])) ? $_POST['stock_min'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$codigo = (isset($_POST['codigo'])) ? $_POST['codigo'] : '';


switch($opcion){
    case 1:
        $consulta = "INSERT INTO productos (codigo, nombre, precio_venta, precio_mayor, descripcion, stock, stock_min) VALUES('$codigo','$nombre', '$precio_venta', '$precio_mayor', '$descripcion', '$stock', '$stock_min') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        
        $consulta = "SELECT codigo, nombre, precio_venta, precio_mayor, descripcion, stock, stock_min FROM productos ORDER BY codigo DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);       
        break;    
    case 2:        
        $consulta = "UPDATE productos SET nombre='$nombre', precio_venta='$precio_venta', precio_mayor='$precio_mayor', descripcion='$descripcion', stock='$stock', stock_min='$stock_min' WHERE codigo='$codigo' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT codigo, nombre, precio_venta, precio_mayor, descripcion, stock, stock_min FROM productos WHERE codigo='$codigo' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:        
        $consulta = "DELETE FROM productos WHERE codigo='$codigo' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();   
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);                        
        break;
    case 4:    
        $consulta = "SELECT codigo, nombre, precio_venta, precio_mayor, descripcion, stock, stock_min FROM productos";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 5:
        $consulta = "SELECT nombre from productos where codigo = '$codigo'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 6:
        $consulta = "SELECT EXISTS(select * from productos where codigo = '$codigo') as existe;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
$conexion=null;