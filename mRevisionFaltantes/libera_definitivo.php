<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d H:i:s"); 
$fechaf = date("Y-m-d");
$horaf = date("H:i:s");

$filtro_sucursal = ($solo_sucursal == '1') ? " AND sucursal = '$id_sede'" : "";

$cadena_consulta = "SELECT 
                        cve_articulo, 
                        sucursal, 
                        date_format(fecha_captura, '%Y-%m-%d'), 
                        id 
                    FROM faltantes_pasven
                    WHERE (estatus = '4' or estatus = '3')
                    AND DATE(fecha_captura) BETWEEN DATE_SUB(NOW(),INTERVAL 7 DAY) AND DATE(NOW())".$filtro_sucursal;
$consulta_codigos = mysqli_query($conexion, $cadena_consulta);

while($row_codigos = mysqli_fetch_array($consulta_codigos)){

    $cadena_entradas = "SELECT COUNT(inv_movimientos.modn_folio)
    FROM INV_MOVIMIENTOS INNER JOIN INV_RENGLONES_MOVIMIENTOS
    ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO
    AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
    AND INV_MOVIMIENTOS.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
    WHERE (inv_movimientos.modc_tipomov = 'ENTSOC' OR inv_movimientos.modc_tipomov = 'ENTCOC' OR inv_movimientos.modc_tipomov = 'ETRANS')
    AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC(TO_DATE('$row_codigos[2]','YYYY-MM-DD'))
    AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION <= TRUNC(TO_DATE('$fechaf', 'YYYY-MM-DD'))
    AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$row_codigos[1]'
    AND INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO = '$row_codigos[0]'";
    $st_entradas = oci_parse($conexion_central, $cadena_entradas);
    oci_execute($st_entradas);
    $row_entradas = oci_fetch_row($st_entradas);

    //echo $cadena_entradas;
    if($row_entradas[0] != '0'){
        $cadena_liberar = "UPDATE faltantes_pasven SET estatus = '5', usuario_libera = '$id_persona', fecha_libera = '$fecha' WHERE id = '$row_codigos[3]'";
        $consulta_liberar = mysqli_query($conexion, $cadena_liberar);
    }
}

$cadena_bitacora = "INSERT INTO bitacora_faltantes (nombre_actualiza, fecha_actualiza, hora_actualiza, id_sucursal, fecha, hora, activo, usuario)VALUES('$nombre_persona','$fechaf','$horaf', '$id_sede', '$fechaf','$horaf','1','$id_usuario')";
$consulta_bitacora = mysqli_query($conexion, $cadena_bitacora);
echo "ok";
?>