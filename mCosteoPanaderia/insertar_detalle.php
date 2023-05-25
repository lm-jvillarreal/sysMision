<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");
$id_receta=$_POST['id_receta'];
$artc_articulo=$_POST['artc_articulo'];
$artc_cantidad=$_POST['artc_cantidad'];
$subreceta=$_POST['subreceta'];

$cadenaValidar="SELECT * FROM panaderia_subrecetasrenglones
 WHERE ID_SUBRECETA='$id_receta' AND ID_ARTICULO='$artc_articulo'";
$consultaValidar=mysqli_query($conexion,$cadenaValidar);
$rowValidar=mysqli_fetch_array($consultaValidar);

$conteo=count($rowValidar[0]);
if($conteo>0){
  echo "ya_existe";
}else{
  $cadenaInsertar="INSERT INTO panaderia_subrecetasrenglones
   (ID_SUBRECETA, ID_ARTICULO, CANTIDAD_RECETA, FECHAHORA, ACTIVO, USUARIO, SUBRECETA)VALUES('$id_receta','$artc_articulo','$artc_cantidad','$fechahora','1','$id_usuario', '$subreceta')";
  $consultaInsertar=mysqli_query($conexion,$cadenaInsertar);
  echo "ok";
}
?>