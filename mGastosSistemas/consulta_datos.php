<?php
    include '../global_settings/conexion_oracle.php';
    
    $fecha  = $_POST['fecha'];
    $provee = $_POST['provee'];

    $cadena_detalle = "SELECT CONCAT(CONCAT(CP.PROC_CVEPROVEEDOR,'' ), CP.PROC_NOMBRE)
                        FROM CXP_MOVIMIENTOS CM
                        INNER JOIN CXP_PROVEEDORES CP ON CP.PROC_CVEPROVEEDOR = CM.PROC_CVEPROVEEDOR
                        WHERE CM.PROC_CVEPROVEEDOR = '$provee'";

    $consulta_detalle = oci_parse($conexion_central, $cadena_detalle);
    oci_execute($consulta_detalle);
    $row = oci_fetch_row($consulta_detalle);
    
    $fecha_nueva = date("Y-m-d", strtotime($fecha));
    
    $array = array($row[0],
                    $fecha_nueva);
    echo json_encode($array);
?>