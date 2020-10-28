<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_sucursal = $_POST['id_sucursal'];
	$persona = $_POST['persona'];
        $fecha_e = $_POST['fecha_e'];
        $id_registro = $_POST['id_registro'];

        if($id_registro == 0){
                $cadena = mysqli_query($conexion,"INSERT INTO prestamos (id_sucursal, persona, fecha_entrega, activo, fecha, hora, id_usuario) VALUES('$id_sucursal','$persona','$fecha_e','1','$fecha','$hora','$id_usuario')");

                $cadena_folio = mysqli_query($conexion,"SELECT MAX(id) FROM prestamos");
                $row_folio = mysqli_fetch_array($cadena_folio);
                $folio = $row_folio[0];

                $mensaje =  "ok";
	}else{
                $cadena = mysqli_query($conexion,"UPDATE prestamos SET id_sucursal = '$id_sucursal', persona = '$persona', fecha_entrega = '$fecha_e', fecha = '$fecha', hora = '$hora' WHERE id = '$id_registro'");        

                $mensaje =  "ok";
                $folio = 0;
        }
        $array = array($mensaje, $folio);
        echo json_encode($array);
?>
