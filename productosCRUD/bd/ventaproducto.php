<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$data =  null;
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $consulta = "SELECT codigo, nombre, descripcion, stock, precio_mayor FROM productos";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();   
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $infoventa = (isset($_POST['nventa'])) ? $_POST['nventa'] : '';
        $folio = $infoventa['folio'];
        $vendedor = $infoventa['vendedor'];
        $fecha = $infoventa['fecha'];
        $rut = $infoventa['rut'];
        $notaventa = $infoventa['notaventa'];

        $consulta = "SELECT cliente_id FROM clientes WHERE rut = '$rut'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        $cliente_id = (isset($data[0]['cliente_id'])) ? $data[0]['cliente_id'] : "NULL";
        

        if($folio == null){
            if($vendedor == null){
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id, notaventa) values (DEFAULT, DEFAULT, '$fecha', $cliente_id, '$notaventa')";
            }else{
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id, notaventa) values (DEFAULT, '$vendedor', '$fecha', $cliente_id, '$notaventa')";
            }
        }else{
            if($vendedor == null){
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id, notaventa) values ($folio, DEFAULT, '$fecha', $cliente_id, '$notaventa')";
            }else{
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id, notaventa) values ($folio, '$vendedor', '$fecha', $cliente_id, '$notaventa')";
            }
        }

        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT venta_id FROM ventas ORDER BY venta_id DESC LIMIT 0,1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        $venta_id = $data[0]['venta_id'];    

        $consulta = "INSERT INTO carro (venta_id, producto_codigo, cant_product, precio_product, nombre_producto) values";
        $listaproductos = (isset($_POST['nvproductos'])) ? $_POST['nvproductos'] : '';
        foreach($listaproductos as $producto => $producto_info){
            $codigo = $producto_info['codigo'];
            $cant = $producto_info['cant'];
            $precio = $producto_info['precio'];
            $nombre = $producto_info['nombre'];
            $consulta .= " ($venta_id, '$codigo', $cant, $precio, '$nombre'),";
            
            $query = "UPDATE productos SET stock =  (stock - $cant) WHERE codigo = '$codigo'";
            $resultado = $conexion->prepare($query);
            $resultado->execute();
        }
        $consulta = rtrim($consulta, ",");
        $consulta .= ";";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $consulta = "select max(venta_id) as last_id from ventas;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $venta_id = (isset($_POST['venta_id'])) ? $_POST['venta_id'] : '';
        $productos = (isset($_POST['nvproductos'])) ? $_POST['nvproductos'] : '';
        $rut = (isset($_POST['rut'])) ? $_POST['rut'] : '';

        $consulta = "SELECT cliente_id FROM clientes WHERE rut = '$rut'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        $cliente_id = (isset($data[0]['cliente_id'])) ? $data[0]['cliente_id'] : "NULL";


        $consulta = "SELECT c.producto_codigo as cod, c.cant_product as cant from carro c
                    inner join ventas on c.venta_id = ventas.venta_id
                    where c.venta_id = $venta_id;";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $wea => $wea2){
            $codigo = $wea2["cod"];
            $cant = $wea2["cant"];
            $consulta = "UPDATE productos
                        set stock = (stock + $cant)
                        where codigo = '$codigo'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();          
        }
        $consulta = "DELETE FROM carro WHERE venta_id='$venta_id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();   

        $consulta = "INSERT INTO carro (venta_id, producto_codigo, cant_product, precio_product, nombre_producto) values";
        foreach($productos as $producto => $producto_info){
            $codigo = $producto_info['codigo'];
            $cant = $producto_info['cant'];
            $precio = $producto_info['precio'];
            $nombre = $producto_info['nombre'];
            $consulta .= " ($venta_id, '$codigo', $cant, $precio, '$nombre'),";
            
            $query = "UPDATE productos SET stock =  (stock - $cant) WHERE codigo = '$codigo'";
            $resultado = $conexion->prepare($query);
            $resultado->execute();
        }
        $consulta = rtrim($consulta, ",");
        $consulta .= ";";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
        $vendedoractualizado = (isset($_POST['vendedor'])) ? $_POST['vendedor'] : '';
        $notaventa = (isset($_POST['notaventa'])) ? $_POST['notaventa'] : '';
        $consulta = "UPDATE ventas
                    SET fecha = '$fecha', vendedor = '$vendedoractualizado', notaventa = '$notaventa', cliente_id = $cliente_id
                    WHERE venta_id = $venta_id";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 4:
        $folio = (isset($_POST['nfolio'])) ? $_POST['nfolio'] : '';
        $consulta = "SELECT EXISTS(select * from ventas where nro_folio = $folio) as existe;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 5:
        $infoventa = (isset($_POST['nventa'])) ? $_POST['nventa'] : '';
        $folio = $infoventa['folio'];
        $vendedor = $infoventa['vendedor'];
        $fecha = $infoventa['fecha'];
        $rut = $infoventa['cliente']['rut'];
        $razon_social = $infoventa['cliente']['nombre'];
        $email = "SIN ESPECIFICAR";
        $giro = $infoventa['cliente']['giro'];
        $contacto = $infoventa['cliente']['contacto'];
        $comuna = $infoventa['cliente']['comuna'];
        $direccion = $infoventa['cliente']['direccion'];

        $consulta = "SELECT cliente_id FROM clientes WHERE rut = '$rut'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        $cliente_id = (isset($data[0]['cliente_id'])) ? $data[0]['cliente_id'] : "NULL";
        
        if($cliente_id == "NULL"){
            $consulta = "INSERT INTO clientes (rut, razon_social, email, giro, contacto, comuna) VALUES('$rut','$razon_social', '$email', '$giro', '$contacto', '$comuna'); 
            INSERT INTO direcciones (cliente_id, direccion) VALUES ((SELECT cliente_id from clientes where rut = '$rut'), '$direccion');";			
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consultav2 = "SELECT cliente_id FROM clientes WHERE rut = '$rut'";
            $resultado = $conexion->prepare($consultav2);
            $resultado->execute();
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
            $cliente_id = (isset($data[0]['cliente_id'])) ? $data[0]['cliente_id'] : "";
        }


        if($folio == null){
            if($vendedor == null){
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id) values (DEFAULT, DEFAULT, '$fecha', $cliente_id)";
            }else{
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id) values (DEFAULT, '$vendedor', '$fecha', $cliente_id)";
            }
        }else{
            if($vendedor == null){
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id) values ($folio, DEFAULT, '$fecha', $cliente_id)";
            }else{
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id) values ($folio, '$vendedor', '$fecha', $cliente_id)";
            }
        }

        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT venta_id FROM ventas ORDER BY venta_id DESC LIMIT 0,1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        $venta_id = $data[0]['venta_id'];    

        $listaproductos = (isset($_POST['nvproductos'])) ? $_POST['nvproductos'] : '';

        foreach($listaproductos as $producto => $producto_info){
            $codigo = $producto_info['codigo'];
            $consulta = "SELECT EXISTS(select * from productos where codigo = '$codigo') as existe;";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();        
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
            $existeProducto = $data[0]['existe'];
            if($existeProducto == 0){
                $precio = $producto_info['precio'];
                $nombre = $producto_info['nombre'];
                $consulta = "INSERT INTO productos (codigo, nombre, precio_venta, precio_mayor, descripcion, stock, stock_min) VALUES('$codigo','$nombre', '0', '$precio', 'SIN ESPECIFICAR', '0', '0') ";			
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(); 
            }
        }

        $consulta = "INSERT INTO carro (venta_id, producto_codigo, cant_product, precio_product, nombre_producto) values";
        foreach($listaproductos as $producto => $producto_info){
            $codigo = $producto_info['codigo'];
            $cant = $producto_info['cant'];
            $precio = $producto_info['precio'];
            $nombre = $producto_info['nombre'];
            $consulta .= " ($venta_id, '$codigo', $cant, $precio, '$nombre'),";
            
            $query = "UPDATE productos SET stock =  (stock - $cant) WHERE codigo = '$codigo'";
            $resultado = $conexion->prepare($query);
            $resultado->execute();
        }
        $consulta = rtrim($consulta, ",");
        $consulta .= ";";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $consulta = "select max(venta_id) as last_id from ventas;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 6:
        $infoventa = (isset($_POST['nventa'])) ? $_POST['nventa'] : '';
        $folio = $infoventa['folio'];
        $vendedor = $infoventa['vendedor'];
        $fecha = $infoventa['fecha'];
        $rut = $infoventa['cliente']['rut'];
        $razon_social = $infoventa['cliente']['nombre'];
        $email = "SIN ESPECIFICAR";
        $giro = $infoventa['cliente']['giro'];
        $contacto = $infoventa['cliente']['contacto'];
        $comuna = $infoventa['cliente']['comuna'];
        $direccion = $infoventa['cliente']['direccion'];

        $consulta = "SELECT cliente_id FROM clientes WHERE rut = '$rut'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        $cliente_id = (isset($data[0]['cliente_id'])) ? $data[0]['cliente_id'] : "NULL";
        
        if($cliente_id == "NULL"){
            $consulta = "INSERT INTO clientes (rut, razon_social, email, giro, contacto, comuna) VALUES('$rut','$razon_social', '$email', '$giro', '$contacto', '$comuna'); 
            INSERT INTO direcciones (cliente_id, direccion) VALUES ((SELECT cliente_id from clientes where rut = '$rut'), '$direccion');";			
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $consultav2 = "SELECT cliente_id FROM clientes WHERE rut = '$rut'";
            $resultado = $conexion->prepare($consultav2);
            $resultado->execute();
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
            $cliente_id = (isset($data[0]['cliente_id'])) ? $data[0]['cliente_id'] : "";
        }


        if($folio == null){
            if($vendedor == null){
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id, notaventa, estadoVenta) values (DEFAULT, DEFAULT, '$fecha', $cliente_id, '', 1)";
            }else{
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id, notaventa, estadoVenta) values (DEFAULT, '$vendedor', '$fecha', $cliente_id, '', 1)";
            }
        }else{
            if($vendedor == null){
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id, notaventa, estadoVenta) values ($folio, DEFAULT, '$fecha', $cliente_id, '', 1)";
            }else{
                $consulta = "INSERT INTO ventas (nro_folio, vendedor, fecha, cliente_id, notaventa, estadoVenta) values ($folio, '$vendedor', '$fecha', $cliente_id, '', 1)";
            }
        }

        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT venta_id FROM ventas ORDER BY venta_id DESC LIMIT 0,1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        $venta_id = $data[0]['venta_id'];    

        $listaproductos = (isset($_POST['nvproductos'])) ? $_POST['nvproductos'] : '';

        foreach($listaproductos as $producto => $producto_info){
            $codigo = $producto_info['codigo'];
            $consulta = "SELECT EXISTS(select * from productos where codigo = '$codigo') as existe;";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();        
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
            $existeProducto = $data[0]['existe'];
            if($existeProducto == 0){
                $precio = $producto_info['precio'];
                $nombre = $producto_info['nombre'];
                $consulta = "INSERT INTO productos (codigo, nombre, precio_venta, precio_mayor, descripcion, stock, stock_min) VALUES('$codigo','$nombre', '0', '$precio', 'SIN ESPECIFICAR', '0', '0') ";			
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(); 
            }
        }

        $consulta = "INSERT INTO carro (venta_id, producto_codigo, cant_product, precio_product, nombre_producto) values";
        foreach($listaproductos as $producto => $producto_info){
            $codigo = $producto_info['codigo'];
            $cant = $producto_info['cant'];
            $precio = $producto_info['precio'];
            $nombre = $producto_info['nombre'];
            $consulta .= " ($venta_id, '$codigo', $cant, $precio, '$nombre'),";
            
            $query = "UPDATE productos SET stock =  (stock - $cant) WHERE codigo = '$codigo'";
            $resultado = $conexion->prepare($query);
            $resultado->execute();
        }
        $consulta = rtrim($consulta, ",");
        $consulta .= ";";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $consulta = "select max(venta_id) as last_id from ventas;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}
     
print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
$conexion=null;
?>