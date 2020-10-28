<?php
	include '../global_seguridad/verificar_sesion.php';

	$parte = $_POST['parte'];
    $cantidad = $_POST['cantidad'];
    $id_sucursal = $_POST['id_sucursal2'];
    $folio = $_POST['folio'];

    $cadena = mysqli_query($conexion,"INSERT INTO detalle_historial_requisicion (id_historial, codigo, cantidad, activo, fecha, hora, id_usuario) VALUES('$folio','$parte','$cantidad','1','$fecha','$hora','$id_usuario')");

    $consulta3="UPDATE historial_existencias
                SET cantidad = cantidad - '$cantidad'
                WHERE
                codigo_interno = '$parte' 
                AND id_almacen = '$id_sucursal'";             
    $result = mysqli_query($conexion, $consulta3); 

    echo "ok";
?>
