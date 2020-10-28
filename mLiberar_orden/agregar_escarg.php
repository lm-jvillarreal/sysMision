<?php
include '../global_seguridad/verificar_sesion.php';

date_default_timezone_set("America/Monterrey");
$fechahora=date("Y-m-d H:i:s");

$ficha_entrada=$_POST['ficha_entrada'];
$id_sucursal=$_POST['id_sucursal'];
$id_proveedor=$_POST['id_proveedor'];
$artc_articulo=$_POST['artc_articulo'];
$artc_descripcion=$_POST['artc_descripcion'];
$artc_cantidad=$_POST['artc_cantidad'];

$cadenaInsertar="INSERT INTO recibo_escarg (FICHA_ENTRADA, SUCURSAL, ID_PROVEEDOR, ARTC_ARTICULO, ARTC_DESCRIPCION, ARTC_CANTIDAD, FECHAHORA_REGISTRO, USUARIO_REGISTRO, ESTATUS, ACTIVO)VALUES('$ficha_entrada','$id_sucursal','$id_proveedor','$artc_articulo','$artc_descripcion','$artc_cantidad','$fechahora','$id_usuario','1','1')";
$insertarEscarg=mysqli_query($conexion,$cadenaInsertar);
echo "ok";
?>