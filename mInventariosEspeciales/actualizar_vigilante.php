<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");

$id=$_POST['id'];
$ap_paterno=$_POST['ap_paterno'];
$ap_materno=$_POST['ap_materno'];
$nombre=$_POST['nombre'];
$sucursal=$_POST['sucursal'];

$cadenaInsertar="UPDATE vidvig_vigilantes SET AP_PATERNO='$ap_paterno', AP_MATERNO='$ap_materno', NOMBRE='$nombre', ID_SUCURSAL='$sucursal', FECHAHORA='$fechahora', ACTIVO='1', USUARIO='$id_usuario' WHERE ID='$id'";
$insertarVigilante=mysqli_query($conexion,$cadenaInsertar);
echo "ok";
?>