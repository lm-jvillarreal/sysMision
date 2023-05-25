<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");
$id=$_POST['id'];
$cantidad=$_POST['cantidad'];
$artc_articulo=$_POST['artc_articulo'];
$costo_unitario=$_POST['costo_unitario'];
$costo_renglon=$cantidad*$costo_unitario;
$cadenaInsertar="INSERT INTO inv_renglonesremision(ID_REMISION, CANTIDAD, ARTC_ARTICULO, COSTO_UNITARIO, COSTO_RENGLON, FECHAHORA, ACTIVO, USUARIO)VALUES('$id','$cantidad','$artc_articulo','$costo_unitario','$costo_renglon','$fechahora','1','$id_usuario')";
$insertarRenglon=mysqli_query($conexion,$cadenaInsertar);
echo "ok";
?>