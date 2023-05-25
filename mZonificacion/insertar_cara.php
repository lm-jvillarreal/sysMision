<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set("America/Monterrey");
$fechahora=date("Y-m-d H:i:s");
$id=$_POST['id'];
$nombre=$_POST['nombre'];
$cadenaTipoMueble="SELECT TIPO_MUEBLE FROM inv_muebles WHERE ID='$id'";
$consultaTipoMueble=mysqli_query($conexion,$cadenaTipoMueble);
$rowTipoMueble=mysqli_fetch_array($consultaTipoMueble);

$cadenaInsertar="INSERT INTO inv_caramuebles (ID_MUEBLE, TIPO_MUEBLE, CARA_MUEBLE, FECHAHORA, ACTIVO, USUARIO)VALUES('$id','$rowTipoMueble[0]','$nombre','$fechahora','1','$id_usuario')";
$consultaInsertar=mysqli_query($conexion,$cadenaInsertar);
echo "ok";
?>