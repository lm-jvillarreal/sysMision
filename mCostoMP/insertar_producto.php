<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");
$artc_articulo=$_POST['clave_producto'];
$artc_descripcion=$_POST['nombre_producto'];

$cadenaInsertar="INSERT INTO perecederos_recetasventa (ARTC_ARTICULO, ARTC_DESCRIPCION, FECHAHORA, ACTIVO, USUARIO)VALUES('$artc_articulo','$artc_descripcion','$fechahora','1','$id_usuario')";
$consultaInsertar=mysqli_query($conexion,$cadenaInsertar);
echo "ok";
?>