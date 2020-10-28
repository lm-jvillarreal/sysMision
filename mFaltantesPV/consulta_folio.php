<?php
include '../global_seguridad/verificar_sesion.php';

$cadena_consulta = "SELECT MAX(folio) FROM faltantes_pasven WHERE estatus = '1'";
$consulta_folio = mysqli_query($conexion, $cadena_consulta);
$row_folio = mysqli_fetch_array($consulta_folio);
$folio = $row_folio[0]+1;

$array = array(
			$folio
		);
$array_datos = json_encode($array);
echo "$array_datos"; 
?>