<?php 
include '../global_seguridad/verificar_sesion.php';

$datos = array();
$equipo= $_GET['equipo'];

$cadena  = "SELECT id, nombre FROM fallas_equipos WHERE activo = '1' AND equipo = '$equipo' OR equipo = '0'";
$numero = 1;
$consulta = mysqli_query($conexion, $cadena);
// $PHPvariable = “<script> document.write(variableJS) </script>”;
$data = array();
	while ($row=mysqli_fetch_array($consulta)) {
	 $data[] = array("id"=>$row[0], "text"=>$row[1]); 
	}

	echo json_encode($data);