<?php
include '../global_seguridad/verificar_sesion.php';

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

//DIAZ ORDAZ //
$cadena_cero_do = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE d.cantidad = '0' AND (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND s.sucursal = '1'";
$consulta_cero_do = mysqli_query($conexion, $cadena_cero_do);
$row_cero_do = mysqli_fetch_array($consulta_cero_do);

$cadena_solicita_do = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE d.cantidad > 0 AND (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND s.sucursal = '1'";
$consulta_solicita_do = mysqli_query($conexion, $cadena_solicita_do);
$row_solicita_do = mysqli_fetch_array($consulta_solicita_do);

$cadena_escaneados_do = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND  NOT isnull(d.cantidad)
                AND s.sucursal = '1'";
$consulta_escaneados_do = mysqli_query($conexion, $cadena_escaneados_do);
$row_escaneados_do = mysqli_fetch_array($consulta_escaneados_do);

$solicita_do = $row_solicita_do[0];
$auditado_do = $row_cero_do[0];
$escaneados_do = $row_escaneados_do[0];

//ARBOLEDAS //
$cadena_cero_arb = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE d.cantidad = '0' AND (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND s.sucursal = '2'";
$consulta_cero_arb = mysqli_query($conexion, $cadena_cero_arb);
$row_cero_arb = mysqli_fetch_array($consulta_cero_arb);

$cadena_solicita_arb = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE d.cantidad > 0 AND (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND s.sucursal = '2'";
$consulta_solicita_arb = mysqli_query($conexion, $cadena_solicita_arb);
$row_solicita_arb = mysqli_fetch_array($consulta_solicita_arb);

$cadena_escaneados_arb = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND  NOT isnull(d.cantidad)
                AND s.sucursal = '2'";
$consulta_escaneados_arb = mysqli_query($conexion, $cadena_escaneados_arb);
$row_escaneados_arb = mysqli_fetch_array($consulta_escaneados_arb);

$solicita_arb = $row_solicita_arb[0];
$auditado_arb = $row_cero_arb[0];
$escaneados_arb = $row_escaneados_arb[0];

//VILLEGAS
$cadena_cero_vill = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE d.cantidad = '0' AND (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND s.sucursal = '3'";
$consulta_cero_vill = mysqli_query($conexion, $cadena_cero_vill);
$row_cero_vill = mysqli_fetch_array($consulta_cero_vill);

$cadena_solicita_vill = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE d.cantidad > 0 AND (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND s.sucursal = '3'";
$consulta_solicita_vill = mysqli_query($conexion, $cadena_solicita_vill);
$row_solicita_vill = mysqli_fetch_array($consulta_solicita_vill);

$cadena_escaneados_vill = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND  NOT isnull(d.cantidad)
                AND s.sucursal = '3'";
$consulta_escaneados_vill = mysqli_query($conexion, $cadena_escaneados_vill);
$row_escaneados_vill = mysqli_fetch_array($consulta_escaneados_vill);

$solicita_vill = $row_solicita_vill[0];
$auditado_vill = $row_cero_vill[0];
$escaneados_vill = $row_escaneados_vill[0];

//ALLENDE
$cadena_cero_all = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE d.cantidad = '0' AND (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND s.sucursal = '4'";
$consulta_cero_all = mysqli_query($conexion, $cadena_cero_all);
$row_cero_all = mysqli_fetch_array($consulta_cero_all);

$cadena_solicita_all = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE d.cantidad > 0 AND (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND s.sucursal = '4'";
$consulta_solicita_all = mysqli_query($conexion, $cadena_solicita_all);
$row_solicita_all = mysqli_fetch_array($consulta_solicita_all);

$cadena_escaneados_all = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND  NOT isnull(d.cantidad)
                AND s.sucursal = '4'";
$consulta_escaneados_all = mysqli_query($conexion, $cadena_escaneados_all);
$row_escaneados_all = mysqli_fetch_array($consulta_escaneados_all);

$solicita_all = $row_solicita_all[0];
$auditado_all = $row_cero_all[0];
$escaneados_all = $row_escaneados_all[0];

//LA PETACA
$cadena_cero_lp = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE d.cantidad = '0' AND (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND s.sucursal = '5'";
$consulta_cero_lp = mysqli_query($conexion, $cadena_cero_lp);
$row_cero_lp = mysqli_fetch_array($consulta_cero_lp);

$cadena_solicita_lp = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE d.cantidad > 0 AND (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND s.sucursal = '5'";

//echo $cadena_solicita_lp;
$consulta_solicita_lp = mysqli_query($conexion, $cadena_solicita_lp);
$row_solicita_lp = mysqli_fetch_array($consulta_solicita_lp);

$cadena_escaneados_lp = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE (d.fecha BETWEEN '$fecha_inicio' and '$fecha_fin')
                AND  NOT isnull(d.cantidad)
                AND s.sucursal = '5'";
$consulta_escaneados_lp = mysqli_query($conexion, $cadena_escaneados_lp);
$row_escaneados_lp = mysqli_fetch_array($consulta_escaneados_lp);

$solicita_lp = $row_solicita_lp[0];
$auditado_lp = $row_cero_lp[0];
$escaneados_lp = $row_escaneados_lp[0];

$array_datos  = array(		
    $solicita_do,
    $auditado_do,
    $solicita_arb,
    $auditado_arb,
    $solicita_vill,
    $auditado_vill,
    $solicita_all,
    $auditado_all,
    $escaneados_do,
    $escaneados_arb,
    $escaneados_vill,
    $escaneados_all,
    $solicita_lp,
    $auditado_lp,
    $escaneados_lp
);
$array = json_encode($array_datos);
echo $array;
?>