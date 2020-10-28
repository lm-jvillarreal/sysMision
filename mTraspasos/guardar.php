<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_sucursal = $_POST['id_sucursal'];
	$pieza = $_POST['pieza'];
        $id_sucursal2 = $_POST['id_sucursal2'];
        $cantidad = $_POST['cantidad'];
        $id_registro = $_POST['id_registro'];

        if($id_registro == 0){
                $cadena = mysqli_query($conexion,"INSERT INTO traspasos (id_sucursal_origen, codigo_interno, id_sucursal_destino, cantidad, activo, fecha, hora, id_usuario) VALUES('$id_sucursal','$pieza','$id_sucursal2','$cantidad','1','$fecha','$hora','$id_usuario')");

                $actualizar = mysqli_query($conexion,"UPDATE historial_existencias SET cantidad = cantidad - '$cantidad' WHERE codigo_interno = '$pieza'");

	}else{
                $cadena = mysqli_query($conexion,"UPDATE traspasos SET id_sucursal_origen = '$id_sucursal', codigo_interno = '$pieza', id_sucursal_destino = '$id_sucursal2', cantidad = '$cantidad', fecha = '$fecha', hora = '$hora' WHERE id = '$id_registro'");        
        }
        echo "ok";
?>
