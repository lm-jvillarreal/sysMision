<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$nombre           = $_POST['nombre'];
$ap_paterno       = $_POST['ap_paterno'];
$ap_materno       = $_POST['ap_materno'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$sexo             = $_POST['sexo'];
$rfc              = $_POST['rfc'];
$curp             = $_POST['curp'];
$email            = $_POST['email'];
$celular          = $_POST['celular'];
$colonia          = $_POST['colonia'];
$calle            = $_POST['calle'];
$numero           = $_POST['numero'];
$estado_civil     = $_POST['estado_civil'];
$municipio        = $_POST['municipio'];
$telefono         = $_POST['telefono'];
$depto            = $_POST['depto'];
$ext              = $_POST['ext'];
$titulo           = $_POST['titulo'];
$num_empleado     = $_POST['num_emp'];

$cadena_actualizar = "UPDATE personas SET nombre = '$nombre', ap_paterno = '$ap_paterno', ap_materno='$ap_materno', sexo='$sexo', fecha_nac = '$fecha_nacimiento', rfc = '$rfc', curp = '$curp', e_mail = '$email', telefono = '$celular', colonia = '$colonia', calle = '$calle', numero = '$numero', ecivil = '$estado_civil', municipio = '$municipio', estado = 'Nuevo León', telprocede = '$telefono', fecha='$fecha', hora = '$hora', actualizado = '1', departamento = '$depto', ext = '$ext', titulo = '$titulo', num_empleado = '$num_empleado' WHERE id = '$id_persona'";

$actualizar_datos = mysqli_query($conexion, $cadena_actualizar);

echo "ok"; 
?>