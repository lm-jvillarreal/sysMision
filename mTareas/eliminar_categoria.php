<?php
	include '../global_seguridad/verificar_sesion.php';

	$folio = $_POST['folio'];
	$cadena = mysqli_query($conexion,"UPDATE categoria_tareas SET activo = '0' WHERE folio = '$folio'");
	echo "ok";
?>