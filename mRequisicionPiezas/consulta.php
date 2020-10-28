<?php
	include '../global_seguridad/verificar_sesion.php';
    $id_pieza = $_POST['id_pieza'];
    $id_sucursal = $_POST['id_sucursal'];
    $cadena = mysqli_query($conexion,"SELECT cantidad FROM historial_existencias WHERE codigo_interno = '$id_pieza' AND id_almacen = '$id_sucursal'");
    $row = mysqli_fetch_array($cadena);
	echo $row[0];
?>