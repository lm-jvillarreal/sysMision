<?php
include '../global_seguridad/verificar_sesion.php';
$sucursal = $_POST['sucursal'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

if(!empty($sucursal)){
    $filtro_sucursal = " AND id_sucursal = '$sucursal'";
}elseif(empty($sucursal)){
    $filtro_sucursal = "";
}

$cadena_oc = "SELECT COUNT(id) FROM orden_compra WHERE  fecha between '$fecha_inicio' AND '$fecha_fin'".$filtro_sucursal;
$consulta_oc = mysqli_query($conexion, $cadena_oc);
$row_oc = mysqli_fetch_array($consulta_oc);
$total = number_format($row_oc[0], 0, '.', ',');

$cadena_entcoc = "SELECT COUNT(id) FROM orden_compra WHERE tipo='1' AND  fecha between '$fecha_inicio' AND '$fecha_fin'".$filtro_sucursal;
$consulta_entcoc = mysqli_query($conexion, $cadena_entcoc);
$row_entcoc = mysqli_fetch_array($consulta_entcoc);
$total_entcoc = number_format($row_entcoc[0], 0, '.', ',');
$porcentaje_entcoc = ($row_entcoc[0] * 100) / $row_oc[0];
$porcentaje_entcoc = round($porcentaje_entcoc, 2) . '%';
$texto_entcoc = $porcentaje_entcoc." del total capturado";

$cadena_entsoc = "SELECT COUNT(id) FROM orden_compra WHERE (tipo='2' OR tipo='3') AND  fecha between '$fecha_inicio' AND '$fecha_fin'".$filtro_sucursal;
$consulta_entsoc = mysqli_query($conexion, $cadena_entsoc);
$row_entsoc = mysqli_fetch_array($consulta_entsoc);
$total_entsoc = number_format($row_entsoc[0], 0, '.', ',');
$porcentaje_entsoc = ($row_entsoc[0] * 100) / $row_oc[0];
$porcentaje_entsoc = round($porcentaje_entsoc, 2) . '%';
$texto_entsoc = $porcentaje_entsoc." del total capturado";

$cadena_liberadas = "SELECT COUNT(id) FROM orden_compra WHERE status = '3' AND fecha_final between '$fecha_inicio' AND '$fecha_fin'".$filtro_sucursal;
$consulta_liberadas = mysqli_query($conexion, $cadena_liberadas);
$row_liberadas = mysqli_fetch_array($consulta_liberadas);
$total_liberadas = number_format($row_liberadas[0], 0, '.', ',');
$porcentaje_liberadas = ($row_liberadas[0] * 100) / $row_oc[0];
$porcentaje_liberadas = round($porcentaje_liberadas, 2) . '%';
$texto_liberadas = $porcentaje_liberadas." del total capturado";

$cadena_libENTCOC = "SELECT COUNT(id) FROM orden_compra WHERE status = '3' AND tipo = '1' AND fecha_final between '$fecha_inicio' AND '$fecha_fin'".$filtro_sucursal;
$consulta_libENTCOC = mysqli_query($conexion, $cadena_libENTCOC);
$row_libENTCOC = mysqli_fetch_array($consulta_libENTCOC);
$total_libENTCOC = number_format($row_libENTCOC[0], 0, '.', ',');
$porcentaje_libENTCOC = ($row_libENTCOC[0] * 100) / $row_liberadas[0];
$porcentaje_libENTCOC = round($porcentaje_libENTCOC, 2) . '%';
$texto_libENTCOC = $porcentaje_libENTCOC." del total liberado";

$cadena_libENTSOC = "SELECT COUNT(id) FROM orden_compra WHERE status = '3' AND (tipo = '2' OR tipo='3') AND fecha_final between '$fecha_inicio' AND '$fecha_fin'".$filtro_sucursal;
$consulta_libENTSOC = mysqli_query($conexion, $cadena_libENTSOC);
$row_libENTSOC = mysqli_fetch_array($consulta_libENTSOC);
$total_libENTSOC = number_format($row_libENTSOC[0], 0, '.', ',');
$porcentaje_libENTSOC = ($row_libENTSOC[0] * 100) / $row_liberadas[0];
$porcentaje_libENTSOC = round($porcentaje_libENTSOC, 2) . '%';
$texto_libENTSOC = $porcentaje_libENTSOC." del total liberado";

$cadena_pendientes = "SELECT COUNT(id) FROM orden_compra WHERE status = '2' AND fecha between '$fecha_inicio' AND '$fecha_fin'".$filtro_sucursal;
$consulta_pendientes = mysqli_query($conexion, $cadena_pendientes);
$row_pendientes = mysqli_fetch_array($consulta_pendientes);
$total_pendientes = number_format($row_pendientes[0], 0, '.', ',');
$porcentaje_pendientes = ($row_pendientes[0] * 100) / $row_oc[0];
$porcentaje_pendientes = round($porcentaje_pendientes, 2) . '%';
$texto_pendientes = $porcentaje_pendientes." del total capturado";

$cadena_pendENTCOC = "SELECT COUNT(id) FROM orden_compra WHERE status = '2' AND tipo = '1' AND fecha between '$fecha_inicio' AND '$fecha_fin'".$filtro_sucursal;
$consulta_pendENTCOC = mysqli_query($conexion, $cadena_pendENTCOC);
$row_pendENTCOC = mysqli_fetch_array($consulta_pendENTCOC);
$total_pendENTCOC = number_format($row_pendENTCOC[0], 0, '.', ',');
$porcentaje_pendENTCOC = ($row_pendENTCOC[0] * 100) / $row_pendientes[0];
$porcentaje_pendENTCOC = round($porcentaje_pendENTCOC, 2) . '%';
$texto_pendENTCOC = $porcentaje_pendENTCOC." del total pendiente";

$cadena_pendENTSOC = "SELECT COUNT(id) FROM orden_compra WHERE status = '2' AND (tipo = '2' OR tipo='3') AND fecha between '$fecha_inicio' AND '$fecha_fin'".$filtro_sucursal;
$consulta_pendENTSOC = mysqli_query($conexion, $cadena_pendENTSOC);
$row_pendENTSOC = mysqli_fetch_array($consulta_pendENTSOC);
$total_pendENTSOC = number_format($row_pendENTSOC[0], 0, '.', ',');
$porcentaje_pendENTSOC = ($row_pendENTSOC[0] * 100) / $row_pendientes[0];
$porcentaje_pendENTSOC = round($porcentaje_pendENTSOC, 2) . '%';
$texto_pendENTSOC = $porcentaje_pendENTSOC." del total pendiente";

$array = array(
    $total,
    $total_entcoc, //Total estatus 2
    $porcentaje_entcoc, //Porcentje estatus 2
    $texto_entcoc,
    $total_entsoc, //Total estatus 2
    $porcentaje_entsoc, //Porcentje estatus 2
    $texto_entsoc,
    $total_liberadas, //Total estatus 2
    $porcentaje_liberadas, //Porcentje estatus 2
    $texto_liberadas,
    $total_libENTCOC, //Total estatus 2
    $porcentaje_libENTCOC, //Porcentje estatus 2
    $texto_libENTCOC,
    $total_libENTSOC, //Total estatus 2
    $porcentaje_libENTSOC, //Porcentje estatus 2
    $texto_libENTSOC,
    $total_pendientes, //Total estatus 2
    $porcentaje_pendientes, //Porcentje estatus 2
    $texto_pendientes,
    $total_pendENTCOC, //Total estatus 2
    $porcentaje_pendENTCOC, //Porcentje estatus 2
    $texto_pendENTCOC,
    $total_pendENTSOC, //Total estatus 2
    $porcentaje_pendENTSOC, //Porcentje estatus 2
    $texto_pendENTSOC
);
$array_datos = json_encode($array);
echo $array_datos;
?>