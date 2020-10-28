<?php
	include '../global_seguridad/verificar_sesion.php';

	$fecha1 = $_POST['fecha1'];
	$fecha2 = $_POST['fecha2'];
    $tipo_actividad = $_POST['tipo_actividad'];
    $empleado = $_POST['empleado'];
    $pendiente = $_POST['pendiente'];
    $color = "";
    $texto = "";
    $id_registro      = $_POST['id_registro'];

    if($tipo_actividad == 1){
        $color = "#006400";
        $texto = "Correctiva";
    }else if($tipo_actividad == 2){
        $color = "#ad2121";
        $texto = "Preventiva";
    }else if($tipo_actividad == 3){
        $color = "#e3bc08";
        $texto = "Revision";
    }else if($tipo_actividad == 4){
        $color = "#1e90ff";
        $texto = "Junta";
    }else if($tipo_actividad == 5){
        $color = "#1e90ff";
        $texto = "Liberado";
    }else{
        $color = "#9c9c9c";
        $texto = "Otro";
    }

    $fechac1 = $fecha1." 12:00:00";
    $fechac2 = $fecha2." 12:00:00";

	if($id_registro == 0){
        $cadena_folio = mysqli_query($conexion,"SELECT MAX(folio) FROM agenda");
        $row_folio    = mysqli_fetch_array($cadena_folio);
        $folio        = $row_folio[0] + 1;

        $cadena = mysqli_query($conexion,"INSERT INTO pendientes_mantenimiento (id_calendario, fecha_inicial, fecha_final, id_tipo_actividad, id_usuario_asignado, pendiente, fecha, hora, activo, id_usuario) VALUES ('$folio','$fecha1','$fecha2', '$tipo_actividad','$empleado','$pendiente','$fecha','$hora','1','$id_usuario')");

        
        $cadena_calendario = mysqli_query($conexion,"INSERT INTO agenda (folio,title, start, end, id_usuario, fecha, hora,backgroundColor,borderColor) VALUES ('$folio','$texto','$fechac1','$fechac2','$empleado','$fecha','$hora','$color','$color')");

        echo "ok";
	}else{
        $cadena = mysqli_query($conexion,"UPDATE pendientes_mantenimiento SET fecha_inicial = '$fecha1', fecha_final = '$fecha2', id_tipo_actividad = '$tipo_actividad', id_usuario_asignado = '$empleado', pendiente = '$pendiente', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_registro'"); 
        
        $cadena2 = mysqli_query($conexion,"SELECT id_calendario FROM pendientes_mantenimiento WHERE id = '$id_registro'");
        $row2 = mysqli_fetch_array($cadena2);

        $cadena_calendario = mysqli_query($conexion,"UPDATE agenda SET start = '$fechac1', end = '$fechac2', title = '$texto', id_usuario = '$empleado' WHERE folio = '$row2[0]'");
        
        echo "ok";
	}
?>
