<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");

$ap_paterno=$_POST['ap_paterno'];
$ap_materno=$_POST['ap_materno'];
$nombre=$_POST['nombre'];
$sucursal=$_POST['sucursal'];

$cadenaInsertar="INSERT INTO vidvig_vigilantes (AP_PATERNO, AP_MATERNO, NOMBRE, ID_SUCURSAL, FECHAHORA, ACTIVO, USUARIO) VALUES('$ap_paterno','$ap_materno','$nombre','$sucursal','$fechahora','1','$id_usuario')";
$insertarVigilante=mysqli_query($conexion,$cadenaInsertar);
echo "ok";
?>