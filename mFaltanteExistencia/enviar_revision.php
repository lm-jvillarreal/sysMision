<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date('Y-m-d H:i:s');
$artc_articulo=$_POST['artc_articulo'];
$artc_descripcion=$_POST['artc_descripcion'];
$sucursal=$_POST['sucursal'];
$depto=$_POST['depto'];
$teorico=$_POST['teorico'];
$comentario=$_POST['comentario'];

$cadenaInsertar="INSERT INTO revision_faltantes (ARTC_ARTICULO, ARTC_DESCRIPCION, COMENTARIO, SUCURSAL, DEPARTAMENTO, TEORICO, FECHAHORA, ACTIVO, USUARIO)VALUES('$artc_articulo','$artc_descripcion','$comentario','$sucursal','$depto','$teorico','$fechahora','1','$id_usuario')";
$revision=mysqli_query($conexion,$cadenaInsertar);
echo "ok";
?>