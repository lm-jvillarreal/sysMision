<?php
//include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$tipo_movimiento = $_POST['tipo_mov'];
$folio_mov = $_POST['folio_mov'];
$sucursal = $_POST['sucursal'];

$cadena_consulta = "SELECT
						CFG_USUARIOS.USUC_NOMBRE,
                		CFG_USUARIOS.USUN_ID
					FROM
						INV_MOVIMIENTOS
					INNER JOIN CFG_USUARIOS ON CFG_USUARIOS.USUN_ID = MOVN_USUARIOREALIZAMOV
					WHERE
						MODC_TIPOMOV = '$tipo_movimiento'
					AND MODN_FOLIO = '$folio_mov'
					AND ALMN_ALMACEN = '$sucursal'";


$st = oci_parse($conexion_central, $cadena_consulta);
oci_execute($st);
$row_movimiento = oci_fetch_row($st);
$array = array(
	$row_movimiento[0],
	$row_movimiento[1]

);
$array_datos = json_encode($array);
echo $array_datos;

?>