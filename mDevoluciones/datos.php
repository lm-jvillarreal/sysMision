<?php
    include '../global_seguridad/verificar_sesion.php';

    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $tipo   = $_POST['tipo'];
    
    $json   = [];

    if($tipo == '1'){
        $cadena = "SELECT (SELECT CONCAT(numero_proveedor,' - ',proveedor) FROM proveedores WHERE proveedores.id = devoluciones.numero_proveedor),COUNT(*) FROM devoluciones WHERE  fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) GROUP BY numero_proveedor";
    }else if($tipo == '2'){
        $cadena = "SELECT tipo,COUNT(*) FROM devoluciones WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) GROUP BY tipo";
    }else if($tipo == '3'){
        $cadena = "SELECT (SELECT nombre FROM sucursales WHERE sucursales.id = devoluciones.id_sucursal),COUNT(*) FROM devoluciones WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) GROUP BY id_sucursal";
    }else if($tipo == '4'){
        $cadena = "SELECT (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = devoluciones.usuario),COUNT(*) FROM devoluciones WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) GROUP BY usuario";
    }else{
       $cadena = "SELECT (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona WHERE usuarios.id = devoluciones.usuario_autoriza),COUNT(*) FROM devoluciones WHERE fecha BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) GROUP BY usuario_autoriza";
    }
    $consulta = mysqli_query($conexion,$cadena);
    while ($row = mysqli_fetch_array($consulta)) {
        if($row[1] != 0 && $row[0] != ""){
            $json[] = [(string)$row[0],(int)$row[1]]; 
        }
    }

    echo json_encode($json);
?>