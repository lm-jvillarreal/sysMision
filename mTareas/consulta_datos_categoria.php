<?php
include '../global_seguridad/verificar_sesion.php';

$folio = $_POST['folio'];

$cadena = mysqli_query($conexion,"SELECT nombre,descripcion FROM categoria_tareas WHERE folio = '$folio'");

$row = mysqli_fetch_array($cadena);

$array2 = array(
	$row[0], //datos_caja
	$row[1], // id_marca
	);

$array = json_encode($array2);
echo "$array";
?>