<?php
include 'global_settings/conexion_oracle.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$fechaInicial = new DateTime('2019-01-01');
//$fechaInicial = new DateTime('2023-05-10');
$rangosTrimestrales = [];
$cuerpo="";
for ($i = 0; $i < 20; $i++) {
    $inicioTrimestre = clone $fechaInicial;
    $inicioTrimestre->add(new DateInterval('P'.($i*3).'M'));
    
    $finTrimestre = clone $fechaInicial;
    $finTrimestre->add(new DateInterval('P'.(($i + 1)*3).'M'))->modify('-1 day');

    $rangosTrimestrales[] = [
        'InicioTrimestre' => $inicioTrimestre->format('Ymd'),
        'FinTrimestre' => $finTrimestre->format('Ymd')
    ];
    $iniTrim=$inicioTrimestre->format('Ymd');
    $finTrim=$finTrimestre->format('Ymd');
    $cadenaConsulta="SELECT
	( SELECT NVL( COUNT( * ), 0 ) FROM PV_TICKETS WHERE TICN_AAAAMMDDVENTA >= $iniTrim AND TICN_AAAAMMDDVENTA <= $finTrim AND TICC_SUCURSAL = 1 AND TICN_ESTATUS = 3) DO,
	( SELECT NVL( COUNT( * ), 0 ) FROM PV_TICKETS WHERE TICN_AAAAMMDDVENTA >= $iniTrim AND TICN_AAAAMMDDVENTA <= $finTrim AND TICC_SUCURSAL = 2 AND TICN_ESTATUS = 3) ARB,
	( SELECT NVL( COUNT( * ), 0 ) FROM PV_TICKETS WHERE TICN_AAAAMMDDVENTA >= $iniTrim AND TICN_AAAAMMDDVENTA <= $finTrim AND TICC_SUCURSAL = 3 AND TICN_ESTATUS = 3) VILL,
	( SELECT NVL( COUNT( * ), 0 ) FROM PV_TICKETS WHERE TICN_AAAAMMDDVENTA >= $iniTrim AND TICN_AAAAMMDDVENTA <= $finTrim AND TICC_SUCURSAL = 4 AND TICN_ESTATUS = 3) ALLE,
	( SELECT NVL( COUNT( * ), 0 ) FROM PV_TICKETS WHERE TICN_AAAAMMDDVENTA >= $iniTrim AND TICN_AAAAMMDDVENTA <= $finTrim AND TICC_SUCURSAL = 5 AND TICN_ESTATUS = 3) PET,
	( SELECT NVL( COUNT( * ), 0 ) FROM PV_TICKETS WHERE TICN_AAAAMMDDVENTA >= $iniTrim AND TICN_AAAAMMDDVENTA <= $finTrim AND TICC_SUCURSAL = 6 AND TICN_ESTATUS = 3) MMORELOS
FROM
	DUAL";
    $consulta_ventas=oci_parse($conexion_central, $cadenaConsulta);
    oci_execute($consulta_ventas);
    $rowVentas=oci_fetch_array($consulta_ventas);
    $renglon="<tr>
                <td>$iniTrim</td>
                <td>$finTrim</td>
                <td>$rowVentas[0]</td>
                <td>$rowVentas[1]</td>
                <td>$rowVentas[2]</td>
                <td>$rowVentas[3]</td>
                <td>$rowVentas[4]</td>
                <td>$rowVentas[5]</td>
            </tr>";
    $cuerpo=$cuerpo.$renglon;
}
echo"<table border=1>
        <tr>
            <th>Inicio</th>
            <th>Fin</th>
            <th>DO</th>
            <th>ARB</th>
            <th>VILL</th>
            <th>ALL</th>
            <th>PET</th>
            <th>MMORELOS</th>
        </tr>"
        .$cuerpo."
    </table>";
//print_r($rangosTrimestrales);
?>