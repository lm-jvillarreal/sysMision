<?php
	include '../global_seguridad/verificar_sesion.php';
	$id_cotizacion = $_POST['id_cotizacion'];	
	$id_proveedor  = $_POST['id_proveedor'];	
    $cadena = mysqli_query($conexion,"UPDATE cotizaciones SET proveedor_seleccionado = '$id_proveedor' WHERE id = '$id_cotizacion'");
    echo "ok";
?>