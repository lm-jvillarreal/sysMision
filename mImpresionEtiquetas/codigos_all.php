<?php
include '../global_settings/conexion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = '2019';

$cadena_total = "SELECT count(d.id)
                FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                WHERE  (d.fecha BETWEEN '2020-05-01' and '2020-05-31')
                AND s.sucursal = '4'";
$total_codigos = mysqli_query($conexion, $cadena_total);
$row_total = mysqli_fetch_array($total_codigos);

$cadena_solicitados = "SELECT count(d.id)
                    FROM detalle_solicitud as d INNER JOIN solicitud_etiquetas as s ON d.id_solicitud = s.id
                    WHERE d.cantidad > 0 AND (d.fecha BETWEEN '2020-05-01' and '2020-05-31')
                    AND s.sucursal = '4'";
$total_solicitados = mysqli_query($conexion,$cadena_solicitados);
$row_solicitados = mysqli_fetch_array($total_solicitados);

$total = $row_total[0];
$solicitados = $row_solicitados[0];

$restante = $total - $solicitados;

$solicita=(empty($solicitados))?"0":"$solicitados";
$resto=(empty($restante))?"0":"$restante";

	$renglon = "
		['Solicitado', $solicita],
		['Correcto', $resto]";

echo $renglon;
?>