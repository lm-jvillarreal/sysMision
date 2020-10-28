<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_proveedor = $_POST['id_proveedor'];
	$vendedor = $_POST['vendedor'];
        $telefono = $_POST['telefono'];
        $id_registro = $_POST['id_registro'];

	if($id_registro == 0){
                $cadena_folio = mysqli_query($conexion,"SELECT MAX(id_orden_entrada) FROM ordenes_compra_mantenimiento");
                $row_folio = mysqli_fetch_array($cadena_folio);
                $folio = $row_folio[0] + 1;
                $cadena = mysqli_query($conexion,"INSERT INTO ordenes_compra_mantenimiento (id_proveedor, folio,vendedor, telefono, activo, fecha, hora, id_usuario) VALUES('$id_proveedor','$folio','$vendedor','$telefono','1','$fecha','$hora','$id_usuario')");

                $mensaje =  "ok";
	}else{
                $cadena = mysqli_query($conexion,"UPDATE ordenes_compra_mantenimiento SET id_proveedor = '$id_proveedor', vendedor = '$vendedor', telefono = '$telefono', fecha = '$fecha', hora = '$hora' WHERE id_orden_entrada = '$id_registro'");        

                $mensaje =  "ok";
                $folio = 0;
        }
        $array = array($mensaje, $folio);
        echo json_encode($array);
?>
