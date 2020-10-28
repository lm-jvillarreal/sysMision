<?php
	include '../global_seguridad/verificar_sesion.php';
	$id = $_POST['id'];
    $cadena = mysqli_query($conexion,"UPDATE detalle_historial_requisicion SET activo = '2' WHERE id = '$id'");
    $cadena2 = mysqli_query($conexion,"SELECT codigo, cantidad, historial_requisicion.id_sucursal	
    FROM detalle_historial_requisicion 
	INNER JOIN historial_requisicion ON historial_requisicion.id = detalle_historial_requisicion.id_historial
    WHERE detalle_historial_requisicion.id = '$id'");
    $row = mysqli_fetch_array($cadena2);
    $consulta1="UPDATE historial_existencias
                    SET cantidad = cantidad + '$row[1]'
                    WHERE
                    codigo_interno = '$row[0]' 
                    AND id_almacen = '$row[2]'";             
    $result1 = mysqli_query($conexion, $consulta1); 

	echo "ok";
?>