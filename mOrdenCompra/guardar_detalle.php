<?php
	include '../global_seguridad/verificar_sesion.php';

	$folio = $_POST['folio'];
	$cantidad = $_POST['cantidad'];
    $concepto = $_POST['concepto'];
    $costo = $_POST['costo'];
    $importe = $_POST['importe'];
    $id_registro2 = $_POST['id_registro2'];

	if($id_registro2 == 0){
        $cadena = mysqli_query($conexion,"INSERT INTO historial_ordenes (folio, concepto, cantidad, costo, importe, activo, fecha, hora, id_usuario) VALUES('$folio','$concepto','$cantidad','$costo','$importe','1','$fecha','$hora','$id_usuario')");

        echo "ok";
	}else{
        $cadena = mysqli_query($conexion,"UPDATE historial_ordenes SET concepto = '$concepto', cantidad = '$cantidad', costo = '$costo', importe = '$importe', fecha = '$fecha', hora = '$hora' WHERE id_historial = '$id_registro2'");        

        echo "ok";
    }
?>
