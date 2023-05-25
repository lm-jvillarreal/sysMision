<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date('Y-m-d H:i:s');
$id_producto=$_POST['id_receta'];
$artc_articulo=$_POST['artc_articulo'];
$artc_cantidad=$_POST['artc_cantidad'];
$subreceta=$_POST['subreceta'];

$cadenaInsertar="INSERT INTO panaderia_recetasventarenglones (ID_PRODUCTO, CLAVE_ARTICULO, CANTIDAD_RECETA, SUBRECETA, FECHAHORA, ACTIVO, USUARIO, MERMA)VALUES('$id_producto','$artc_articulo','$artc_cantidad','$subreceta','$fechahora','1','$id_usuario', 0.000)";
$consutaReceta=mysqli_query($conexion,$cadenaInsertar);
echo "ok";
?>