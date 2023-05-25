<?php
	include '../global_seguridad/verificar_sesion.php';

	$no_serie           = $_POST['no_serie'];
	$id_sucursal        = $_POST['id_sucursal'];
    $ubicacion          = $_POST['ubicacion'];
    $marca              = $_POST['marca'];
    $modelo             = $_POST['modelo'];
    $tipo               = $_POST['tipo'];
    $capacidad          = $_POST['capacidad'];
    $entrada_salida     = $_POST['entrada_salida'];
    $tomacorrientes     = $_POST['tomacorrientes'];
    $tiempo_respaldo    = $_POST['tiempo_respaldo'];
    $garantia           = $_POST['garantia'];
    $series             = $_POST['series'];
    $id_registro        = $_POST['id_registro'];

	if($id_registro == 0){

        $verificar = mysqli_query($conexion,"SELECT id FROM equipo_ups WHERE no_serie = '$no_serie'");
        $existe = mysqli_num_rows($verificar);
        if($existe == 0){
            $cadena = "INSERT INTO equipo_ups (no_serie, id_sucursal,ubicacion, marca, modelo, tipo, capacidad, entrada_salida, tomacorrientes, tiempo_respaldo, garantia, series, activo, fecha, hora, id_usuario, id_tipo) VALUES('$no_serie','$id_sucursal','$ubicacion','$marca','$modelo','$tipo','$capacidad','$entrada_salida','$tomacorrientes','$tiempo_respaldo','$garantia','$series','1','$fecha','$hora','$id_usuario','3')";
            $insert = mysqli_query($conexion,$cadena);

            echo "ok";
        }else{
            echo "duplicado";
        }
        
	}else{
        $cadena_actualizar = "UPDATE equipo_ups SET no_serie = '$no_serie', id_sucursal = '$id_sucursal', ubicacion = '$ubicacion', marca = '$marca', modelo = '$modelo', tipo = '$tipo', capacidad = '$capacidad', entrada_salida = '$entrada_salida', tomacorrientes = '$tomacorrientes', tiempo_respaldo = '$tiempo_respaldo', garantia = '$garantia', series = '$series', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id_registro'";
        $update = mysqli_query($conexion,$cadena_actualizar);        

        echo "ok_actualizado";
	}
?>
