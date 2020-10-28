<?php
	include '../global_seguridad/verificar_sesion.php';

	$id_proveedor = $_POST['id_proveedor'];
	$orden = $_POST['orden'];
        $fecha = $_POST['fecha'];
        $factura = $_POST['factura'];
        $comentarios = $_POST['comentarios'];
        $id_registro = $_POST['id_registro'];

	if($id_registro == 0){
                $cadena_folio = mysqli_query($conexion,"SELECT MAX(id_entrada) FROM entradas");
                $row_folio = mysqli_fetch_array($cadena_folio);
                $folio = $row_folio[0] + 1;
                $cadena = mysqli_query($conexion,"INSERT INTO entradas (id_proveedor, folio, orden_compra, factura, comentarios, activo, fecha, id_usuario) VALUES('$id_proveedor','$folio','$orden','$factura', '$comentarios','1','$fecha','$id_usuario')");

                $mensaje =  "ok";
	}else{
                $cadena = mysqli_query($conexion,"UPDATE entradas SET id_proveedor = '$id_proveedor', orden_compra = '$orden', factura = '$factura', comentarios = '$comentarios' fecha = '$fecha' WHERE id_entrada = '$id_registro'");        

                $mensaje =  "ok";
                $folio = 0;
        }
        $array = array($mensaje, $folio);
        echo json_encode($array);
?>
