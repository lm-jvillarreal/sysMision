<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d H:i:s"); 
$fechaf = date("Y-m-d");

$filtro_sucursal = ($solo_sucursal == '1') ? " AND c.sucursal = '$id_sede'" : "";

$cadena_consulta = "SELECT c.codigo_articulo, 
                    c.descripcion_articulo, 
                    s.nombre, 
                    DATE_FORMAT(c.fecha_caducidad,'%d/%m/%Y'),
                    c.cantidad, 
                    c.lote,
                    c.precio_publico,
                    c.precio_oferta,
                    date_format(c.fecha, '%Y-%m-%d'),
                    c.id
                    FROM far_medicamentosCaducan AS c 
                    INNER JOIN sucursales as s 
                    ON c.sucursal = s.id 
                    WHERE estatus = '1'".$filtro_sucursal;
$consulta_codigos = mysqli_query($conexion, $cadena_consulta);

while($row_codigos = mysqli_fetch_array($consulta_codigos)){

    $cadena_entradas = "SELECT SUM(INV_RENGLONES_MOVIMIENTOS.RMON_CANTSURTIDA)
    FROM INV_MOVIMIENTOS INNER JOIN INV_RENGLONES_MOVIMIENTOS
    ON INV_MOVIMIENTOS.MODN_FOLIO = INV_RENGLONES_MOVIMIENTOS.MODN_FOLIO
    AND INV_MOVIMIENTOS.ALMN_ALMACEN = INV_RENGLONES_MOVIMIENTOS.ALMN_ALMACEN
    AND INV_MOVIMIENTOS.MODC_TIPOMOV = INV_RENGLONES_MOVIMIENTOS.MODC_TIPOMOV
    WHERE (inv_movimientos.modc_tipomov = 'SALXVE')
    AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION >= TRUNC(TO_DATE('$row_codigos[8]','YYYY-MM-DD'))
    AND INV_MOVIMIENTOS.MOVD_FECHAAFECTACION <= TRUNC(TO_DATE('$fechaf', 'YYYY-MM-DD'))
    AND INV_MOVIMIENTOS.ALMN_ALMACEN = '$id_sede'
    AND INV_RENGLONES_MOVIMIENTOS.ARTC_ARTICULO = '$row_codigos[0]'";
    $st_entradas = oci_parse($conexion_central, $cadena_entradas);
    oci_execute($st_entradas);
    $row_entradas = oci_fetch_row($st_entradas);

    //echo $cadena_entradas;
    if($row_entradas[0] > '0'){

        $cantidad = $row_codigos[4];
        $ventas = $row_entradas[0];
        $restante = $cantidad-$ventas;
        $cadena_liberar = "UPDATE far_medicamentosCaducan SET cantidad = '$restante', estatus='2' WHERE id = '$row_codigos[9]'";
        $consulta_liberar = mysqli_query($conexion, $cadena_liberar);
    }
}
echo "ok";
?>