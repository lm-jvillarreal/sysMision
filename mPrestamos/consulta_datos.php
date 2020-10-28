<?php
	include '../global_seguridad/verificar_sesion.php';
    $id_pieza = $_POST['id_pieza'];	
    $folio = $_POST['folio'];	
	$cadena = mysqli_query($conexion,"SELECT id_sucursal
									  FROM prestamos 
									  WHERE id = '$folio'");
    $row = mysqli_fetch_array($cadena);

    $cadena2 = mysqli_query($conexion,"SELECT cantidad FROM historial_existencias WHERE id_almacen = '$row[0]' AND codigo_interno = '$id_pieza'");
    $row2 = mysqli_fetch_array($cadena2);
    echo $row2[0];
?>