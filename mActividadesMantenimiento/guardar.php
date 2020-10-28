<?php
	include '../global_seguridad/verificar_sesion.php';

	$fechaD        = $_POST['fecha'];
	$id_sucursal = $_POST['id_sucursal'];
    $id_area        = $_POST['id_area'];
    $tipo_actividad        = $_POST['tipo_actividad'];
    $tiempo        = $_POST['tiempo'];
    $dactividad        = $_POST['dactividad'];

    $piezas = (isset($_POST['id_pieza']))?$_POST['id_pieza']:"";
    $cant_piezas = (isset($_POST['id_pieza']))?count($piezas):0;
    
    $compañero = (isset($_POST['id_compañero']))?$_POST['id_compañero']:"";
    $cant_comp = (isset($_POST['id_compañero']))?count($compañero):0;

    $id_registro      = $_POST['id_registro'];
    
    $cadena_piezas = "";

	if($id_registro == 0){

        $cadena = mysqli_query($conexion,"INSERT INTO actividades_mantenimiento (fecha, actividad, id_area, id_t_actividad, id_sucursal, tiempo, id_usuario, activo)
                    VALUES('$fechaD','$dactividad','$id_area','$tipo_actividad','$id_sucursal','$tiempo','$id_usuario','1')");
        $cadena_folio = mysqli_query($conexion,"SELECT MAX(id) FROM actividades_mantenimiento");
        $row_folio = mysqli_fetch_array($cadena_folio);

        for($i=0;$i<$cant_piezas;$i++){
            $cadena2= mysqli_query($conexion,"INSERT INTO detalle_act_mant_piezas (id_act_mant, id_pieza, fecha, hora, activo , id_usuario) VALUES ('$row_folio[0]','$piezas[$i]','$fecha','$hora','1','$id_usuario')");
        }

        for($o=0;$o<$cant_comp;$o++){
            $cadena3= mysqli_query($conexion,"INSERT INTO detalle_act_mant_compañeros (id_act_mant, id_compañero, fecha, hora, activo , id_usuario) VALUES ('$row_folio[0]','$compañero[$o]','$fecha','$hora','1','$id_usuario')");
        }

        echo "ok";
	}else{
        $cadena = mysqli_query($conexion,"UPDATE actividades_mantenimiento SET fecha = '$fechaD', actividad = '$dactividad', id_area = '$id_area', id_t_actividad = '$tipo_actividad', id_sucursal = '$id_sucursal', tiempo = '$tiempo' WHERE id = '$id_registro'");
        
        for($i=0;$i<$cant_piezas;$i++){
            $cadena2= mysqli_query($conexion,"INSERT INTO detalle_act_mant_piezas (id_act_mant, id_pieza, fecha, hora, activo , id_usuario) VALUES ('$id_registro','$piezas[$i]','$fecha','$hora','1','$id_usuario')");
        }

        for($o=0;$o<$cant_comp;$o++){
            $cadena3= mysqli_query($conexion,"INSERT INTO detalle_act_mant_compañeros (id_act_mant, id_compañero, fecha, hora, activo , id_usuario) VALUES ('$id_registro','$compañero[$o]','$fecha','$hora','1','$id_usuario')");
        }
        
        echo "ok";
	}
?>
