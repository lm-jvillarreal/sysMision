<?php
	include '../global_seguridad/verificar_sesion.php';
	$folio   = $_POST['folio'];
	$cadena  = mysqli_query($conexion,"DELETE FROM  materiales WHERE folio = '$folio'");
	$cadena2 = mysqli_query($conexion,"DELETE FROM historial_pedido_materiales WHERE folio = '$folio'");
	echo "ok";
?>