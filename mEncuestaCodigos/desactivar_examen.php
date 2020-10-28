<?php
	include '../global_seguridad/verificar_sesion.php';

    $id = $_POST['id'];
    $consulta = mysqli_query($conexion,"SELECT activo FROM examenes WHERE id = '$id'");
    $row = mysqli_fetch_array($consulta);
    if($row[0] == 1){
        $status = '2';
    }else{
        $status = '1';
    }
    $cadena = mysqli_query($conexion,"UPDATE examenes SET activo = '$status' WHERE id = '$id'");
    // echo "UPDATE examenes SET activo = '$status' WHERE id = '$id'";
	echo "ok";
?>