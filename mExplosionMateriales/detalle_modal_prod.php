<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['folio'];
$tipo = $_POST['tipo'];
$id = $_POST['idprod'];

$dt = new DateTime(); 
$dt->setISODate($dt->format('o'), $dt->format('W') + 1);
$periods = new DatePeriod($dt, new DateInterval('P1D'), 6);
$days = iterator_to_array($periods);
$fechaInicioC = $days[0]->format("Ymd");
$fechaFinC = $days[6]->format("Ymd");
$fechaInicioLW = $days[0]->format("Y-m-d");
$fechaFinLW = $days[6]->format("Y-m-d");

$cadenaReceta = "SELECT ID,
                ID_ARTICULO,
                ID_TABLA,
                LUNES,
                MARTES,
                MIERCOLES,
                JUEVES,
                VIERNES,
                SABADO,
                DOMINGO,
                TIPO,
                FECHA_INICIO,
                FECHA_FIN
                FROM panaderia_calendarioprod
                WHERE ID_TABLA='$id'
                AND ID_ARTICULO = '$folio'
                AND FECHA_INICIO = '$fechaInicioC'
                AND FECHA_FIN = '$fechaFinC'";
$consultaReceta=mysqli_query($conexion,$cadenaReceta);
$rowReceta=mysqli_fetch_array($consultaReceta);

echo utf8_encode(json_encode(array(
    $folio,
    $tipo,
    $id,
    round(($rowReceta[3] == null ? '0': $rowReceta[3]), 2),
    round(($rowReceta[4] == null ? '0': $rowReceta[4]), 2),
    round(($rowReceta[5] == null ? '0': $rowReceta[5]), 2),
    round(($rowReceta[6] == null ? '0': $rowReceta[6]), 2),
    round(($rowReceta[7] == null ? '0': $rowReceta[7]), 2),
    round(($rowReceta[8] == null ? '0': $rowReceta[8]), 2),
    round(($rowReceta[9] == null ? '0': $rowReceta[9]), 2),
    $fechaInicioLW . " al " . $fechaFinLW
)));
?>