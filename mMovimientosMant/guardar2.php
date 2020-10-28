<?php
	include '../global_seguridad/verificar_sesion.php';

	$solicitante = $_POST['solicitante'];
	$id_sucursal = $_POST['id_sucursal'];
    $fechaD = $_POST['fecha'];
    $orden_t = $_POST['orden_t'];
    $area = $_POST['area'];
    $referencia = $_POST['referencia'];
    $comentarios = $_POST['comentarios'];
    $id_registro = $_POST['id_registro'];

	if($id_registro == 0){
                $cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM salidas");
                $row_folio = mysqli_fetch_array($cadena_folio);
                $folio = $row_folio[0] + 1;
                $cadena = mysqli_query($conexion,"INSERT INTO salidas (folio, orden_trabajo, solicitante, fecha, id_sucursal, area, comentarios, referencia, activo, id_usuario, fecha_registro, hora_registro) VALUES('$folio','$orden_t','$solicitante','$fechaD', '$id_sucursal','$area','$comentarios','$referencia','1','$id_usuario','$fecha','$hora')");
                $mensaje =  "ok";
	}
    $array = array($mensaje, $folio);
    echo json_encode($array);
?>
