<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_sucursal = $_POST['id_sucursal'];
	$o_trabajo = $_POST['o_trabajo'];
        $area = $_POST['area'];
        $justificacion = $_POST['justificacion'];
        $id_registro = $_POST['id_registro'];

        if($id_registro == 0){
                $cadena = mysqli_query($conexion,"INSERT INTO historial_requisicion (id_sucursal, justificacion, area, orden_trabajo, activo, fecha, hora, id_usuario) VALUES('$id_sucursal','$justificacion','$area','$o_trabajo','1','$fecha','$hora','$id_usuario')");

                $cadena_folio = mysqli_query($conexion,"SELECT MAX(id) FROM historial_requisicion");
                $row_folio = mysqli_fetch_array($cadena_folio);
                $folio = $row_folio[0];

                $mensaje =  "ok";
	}else{
                $cadena = mysqli_query($conexion,"UPDATE historial_requisicion SET id_sucursal = '$id_sucursal', justificacion = '$justificacion', area = '$area', orden_trabajo = '$o_trabajo', fecha = '$fecha', hora = '$hora' WHERE id = '$id_registro'");        

                $mensaje =  "ok";
                $folio = 0;
        }
        $array = array($mensaje, $folio);
        echo json_encode($array);
?>
