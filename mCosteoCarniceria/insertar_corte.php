<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");
$artc_articulo=$_POST['artc_articulo'];
$artc_descripcion=$_POST['artc_descripcion'];
$cadenaInsertar="INSERT INTO carniceria_catalogo (CODIGO_CORTE, DESCRIPCION_CORTE, FECHAHORA, ACTIVO, USUARIO)VALUES('$artc_articulo','$artc_descripcion','$fechahora','1','$id_usuario')";
$insertar=mysqli_query($conexion,$cadenaInsertar);
echo $cadenaInsertar;
?>