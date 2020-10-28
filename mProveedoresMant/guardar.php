<?php
	include '../global_seguridad/verificar_sesion.php';

	$nombre       = $_POST['nombre'];
	$razon_social = $_POST['razon_social'];
    $t_empresa    = $_POST['t_empresa'];
    $n_vendedor   = $_POST['n_vendedor'];
    $c_vendedor   = $_POST['c_vendedor'];
    $correo_vendedor = $_POST['correo_vendedor'];
    $n_supervisor    = $_POST['n_supervisor'];
    $c_supervisor    = $_POST['c_supervisor'];
    $correo_supervisor = $_POST['correo_supervisor'];
    $id_registro      = $_POST['id_registro'];

	if($id_registro == 0){

        $cadena = mysqli_query($conexion,"INSERT INTO proveedores_mantenimiento (nombre, razon_social,tel_empresa, nombre_vededor, cel_vendedor, corr_vend, nombre_supervisor, cel_supervisor, corr_superv, activo, fecha, hora, id_usuario) VALUES('$nombre','$razon_social','$t_empresa','$n_vendedor','$c_vendedor','$correo_vendedor','$n_supervisor','$c_supervisor','$correo_supervisor','1','$fecha','$hora','$id_usuario')");

        echo "ok";
	}else{
        $cadena = mysqli_query($conexion,"UPDATE proveedores_mantenimiento SET nombre = '$nombre', razon_social = '$razon_social', tel_empresa = '$t_empresa', nombre_vededor = '$n_vendedor', cel_vendedor = '$c_vendedor', corr_vend = '$correo_vendedor', nombre_supervisor = '$n_supervisor', cel_supervisor = '$c_supervisor', corr_superv = '$correo_supervisor', fecha = '$fecha', hora = '$hora' WHERE id_proveedor = '$id_registro'");        

        echo "ok";
	}
?>
