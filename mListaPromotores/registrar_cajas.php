<?php
	include '../global_seguridad/verificar_sesion.php';

    $id_promotor = $_POST['id_promotor'];
    $cajas       = $_POST['cant_cajas'];

    $cadena = mysqli_query($conexion,"SELECT id,actividad FROM actividades_promotor WHERE id_promotor = '$id_promotor' AND principal = '1'");
    $row = mysqli_fetch_array($cadena);

    $cadena1 = mysqli_query($conexion,"INSERT INTO actividades_promotor (actividad,id_promotor,fecha,hora,id_usuario,activo,principal,temporal)
        VALUES ('Surtir Cajas Extra','$id_promotor','$fecha','$hora','$id_usuario','1','0','1')");

    $cadena2 = mysqli_query($conexion,"SELECT MAX(id) FROM actividades_promotor");
    $row2 = mysqli_fetch_array($cadena2);

    $cadena3 = mysqli_query($conexion,"INSERT INTO registro_actividades (duracion,id_actividad,hora_inicio,hora_fin,fecha,hora,activo,id_usuario,cajas_surtidas,id_sucursal) VALUES('00:00:00','$row2[0]','$hora','$hora','$fecha','$hora','1','$id_usuario','$cajas','$id_sede')");

    echo "ok";
?>