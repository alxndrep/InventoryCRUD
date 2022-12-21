<?php
include_once '../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$data =  null;
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1:
        $consulta = "SELECT venta_id, IF(nro_folio = 0, venta_id, nro_folio) as folio, IFNULL(v.vendedor, 'SIN ESPECIFICAR') as vendedor, DATE_FORMAT(v.fecha, '%d/%m/%Y') as fecha, clientes.razon_social as cliente, (select FORMAT((sum(c.precio_product*c.cant_product)*1.19),'es_CL') from carro c where c.venta_id = v.venta_id) as total,
        clientes.rut as rut, clientes.direccion as direccion, clientes.giro as giro, notaventa
        from ventas v
        INNER JOIN clientes on clientes.cliente_id=v.cliente_id
        group by v.venta_id;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();   
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $venta_id = (isset($_POST['venta_id'])) ? $_POST['venta_id'] : '';
        $consulta = "SELECT c.producto_codigo as codigo, c.nombre_producto as nombre, c.cant_product as cant, FORMAT(c.precio_product, 'es_CL') as precio, FORMAT((c.cant_product*c.precio_product), 'es_CL') as total 
        from carro c
        INNER JOIN productos on c.producto_codigo=productos.codigo
        WHERE venta_id = $venta_id
        group by c.producto_codigo;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();   
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $venta_id = (isset($_POST['venta_id'])) ? $_POST['venta_id'] : '';

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
        $consulta = "DELETE FROM ventas WHERE venta_id='$venta_id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();   
        break;
    case 4:
        $venta_id = (isset($_POST['venta_id'])) ? $_POST['venta_id'] : '';
        $consulta = "SELECT clientes.rut, clientes.razon_social, clientes.giro, clientes.email, clientes.contacto, clientes.direccion as direccion, clientes.comuna, ventas.fecha, ventas.vendedor, IF(ventas.nro_folio = 0, ventas.venta_id, ventas.nro_folio) as nro_folio, IF(ventas.nro_folio = 0, 1, 0) as isborrador, ventas.notaventa
        FROM clientes
        INNER JOIN ventas on clientes.cliente_id = ventas.cliente_id
        where ventas.venta_id = $venta_id
        group by clientes.rut;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 5:
        $vendedor = (isset($_POST['vendedor'])) ? $_POST['vendedor'] : '';
        $fechaInicio = (isset($_POST['fechaInicio'])) ? $_POST['fechaInicio'] : '';
        $fechaTermino = (isset($_POST['fechaTermino'])) ? $_POST['fechaTermino'] : '';

        $consulta = "SELECT venta_id, IF(nro_folio = 0, venta_id, nro_folio) as folio, IFNULL(v.vendedor, 'SIN ESPECIFICAR') as vendedor, DATE_FORMAT(v.fecha, '%d/%m/%Y') as fecha, clientes.razon_social as cliente, (select FORMAT((sum(c.precio_product*c.cant_product)*1.19),'es_CL') from carro c where c.venta_id = v.venta_id) as total,
        clientes.rut as rut, clientes.direccion as direccion, clientes.giro as giro, v.notaventa
        from ventas v
        INNER JOIN clientes on clientes.cliente_id=v.cliente_id
        where vendedor like '$vendedor'
        AND fecha BETWEEN date('$fechaInicio') and date('$fechaTermino')
        group by v.venta_id;";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 6:

        $vendedor = (isset($_POST['vendedor'])) ? $_POST['vendedor'] : '';
        $fechaInicio = (isset($_POST['fechaInicio'])) ? $_POST['fechaInicio'] : '';
        $fechaTermino = (isset($_POST['fechaTermino'])) ? $_POST['fechaTermino'] : '';
        $clientes = (isset($_POST['clientes'])) ? $_POST['clientes'] : '';

        $consulta = "SELECT venta_id, IF(nro_folio = 0, venta_id, nro_folio) as folio, IFNULL(v.vendedor, 'SIN ESPECIFICAR') as vendedor, DATE_FORMAT(v.fecha, '%d/%m/%Y') as fecha, clientes.razon_social as cliente, (select FORMAT((sum(c.precio_product*c.cant_product)*1.19),'es_CL') from carro c where c.venta_id = v.venta_id) as total,
        clientes.rut as rut, clientes.direccion as direccion, clientes.giro as giro, v.notaventa
        from ventas v
        INNER JOIN clientes on clientes.cliente_id=v.cliente_id
        where vendedor like '$vendedor' AND (";

        foreach($clientes as $cliente => $cliente_info){
            $nombre_cliente = $cliente_info;
            $consulta .= "clientes.razon_social like '$nombre_cliente' OR ";
        }
        $consulta = substr($consulta, 0, -3);
        $consulta .= " ) AND fecha BETWEEN date('$fechaInicio') and date('$fechaTermino') group by v.venta_id;";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 7:
        $vendedor = (isset($_POST['vendedor'])) ? $_POST['vendedor'] : '';
        $consulta = "SELECT c.razon_social as nombre from clientes c
        inner join ventas on ventas.cliente_id = c.cliente_id
        where ventas.vendedor like '$vendedor'
        group by c.cliente_id;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 8:
        $vendedor = (isset($_POST['vendedor'])) ? $_POST['vendedor'] : '';

        $consulta = "SELECT venta_id, IF(nro_folio = 0, venta_id, nro_folio) as folio, IFNULL(v.vendedor, 'SIN ESPECIFICAR') as vendedor, DATE_FORMAT(v.fecha, '%d/%m/%Y') as fecha, clientes.razon_social as cliente, (select FORMAT((sum(c.precio_product*c.cant_product)*1.19),'es_CL') from carro c where c.venta_id = v.venta_id) as total,
        clientes.rut as rut, clientes.direccion as direccion, clientes.giro as giro, v.notaventa
        from ventas v
        INNER JOIN clientes on clientes.cliente_id=v.cliente_id
        where vendedor like '$vendedor'
        group by v.venta_id;";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 9:
        $vendedor = (isset($_POST['vendedor'])) ? $_POST['vendedor'] : '';
        $fechaInicio = (isset($_POST['fechaInicio'])) ? $_POST['fechaInicio'] : '';
        $fechaTermino = (isset($_POST['fechaTermino'])) ? $_POST['fechaTermino'] : '';
        $clientes = (isset($_POST['clientes'])) ? $_POST['clientes'] : '';

        $consulta = "SELECT venta_id, IF(nro_folio = 0, venta_id, nro_folio) as folio, IFNULL(v.vendedor, 'SIN ESPECIFICAR') as vendedor, DATE_FORMAT(v.fecha, '%d/%m/%Y') as fecha, clientes.razon_social as cliente, (select FORMAT((sum(c.precio_product*c.cant_product)*1.19),'es_CL') from carro c where c.venta_id = v.venta_id) as total,
        clientes.rut as rut, clientes.direccion as direccion, clientes.giro as giro, v.notaventa
        from ventas v
        INNER JOIN clientes on clientes.cliente_id=v.cliente_id
        where vendedor like '$vendedor' AND (";

        foreach($clientes as $cliente => $cliente_info){
            $nombre_cliente = $cliente_info;
            $consulta .= "clientes.razon_social like '$nombre_cliente' OR ";
        }
        $consulta = substr($consulta, 0, -3);
        $consulta .= " ) GROUP BY v.venta_id;";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 10:
        $vendedor = (isset($_POST['vendedor'])) ? $_POST['vendedor'] : '';
        $consulta = "SELECT venta_id, IF(nro_folio = 0, venta_id, nro_folio) as folio, IFNULL(v.vendedor, 'SIN ESPECIFICAR') as vendedor, DATE_FORMAT(v.fecha, '%d/%m/%Y') as fecha, clientes.razon_social as cliente, (select FORMAT((sum(c.precio_product*c.cant_product)*1.19),'es_CL') from carro c where c.venta_id = v.venta_id) as total,
        clientes.rut as rut, clientes.direccion as direccion, clientes.giro as giro, v.notaventa
        from ventas v
        INNER JOIN clientes on clientes.cliente_id=v.cliente_id
        WHERE vendedor like '$vendedor'
        group by v.venta_id;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();   
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 11:
        $venta_id = (isset($_POST['venta_id'])) ? $_POST['venta_id'] : '';
        $consulta = "SELECT notaventa from ventas where venta_id = $venta_id;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();   
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 12:
        $fechaInicio = (isset($_POST['fechaInicio'])) ? $_POST['fechaInicio'] : '';
        $fechaTermino = (isset($_POST['fechaTermino'])) ? $_POST['fechaTermino'] : '';
        $consulta = "SELECT venta_id, IF(nro_folio = 0, venta_id, nro_folio) as folio, IFNULL(v.vendedor, 'SIN ESPECIFICAR') as vendedor, DATE_FORMAT(v.fecha, '%d/%m/%Y') as fecha, clientes.razon_social as cliente, (select FORMAT((sum(c.precio_product*c.cant_product)*1.19),'es_CL') from carro c where c.venta_id = v.venta_id) as total,
        clientes.rut as rut, clientes.direccion as direccion, clientes.giro as giro, v.notaventa, v.estadoVenta as estado
        from ventas v
        INNER JOIN clientes on clientes.cliente_id=v.cliente_id
        AND fecha BETWEEN date('$fechaInicio') and date('$fechaTermino')
        group by v.venta_id;";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();    
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 13:
        $venta_id = (isset($_POST['venta_id'])) ? $_POST['venta_id'] : '';
        $estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
        $consulta = "UPDATE ventas set estadoVenta = $estado where venta_id = $venta_id;";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();   
        break;
    
}

print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
$conexion=null;
?>