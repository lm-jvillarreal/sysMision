<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");

$artc_articulo = $_POST['articulo'];
$proyeccion_porcentaje=$_POST['proyeccion'];
$numero_piezas=$_POST['piezas'];

$cadenaExiste="SELECT COUNT(ID) FROM panaderia_conversion
WHERE ARTICULO='$artc_articulo'";
$consultaExiste=mysqli_query($conexion,$cadenaExiste);
$rowExiste=mysqli_fetch_array($consultaExiste);
if($rowExiste[0]>0){
  $consulta_modifica = "UPDATE panaderia_conversion SET PORCENTAJE = '$proyeccion_porcentaje', CANTIDAD = '$numero_piezas', USUARIO = '$id_usuario' WHERE ARTICULO = '$artc_articulo'";
  $cadena_modifica = mysqli_query($conexion, $consulta_modifica);
  echo "ok_modifica";
}else{
  $cadenaInsertar="INSERT INTO panaderia_conversion (ARTICULO, PORCENTAJE, CANTIDAD, FECHAHORA, ACTIVO, USUARIO) VALUES('$artc_articulo','$proyeccion_porcentaje','$numero_piezas','$fechahora','1','$id_usuario')";
  $insertar=mysqli_query($conexion,$cadenaInsertar);
  echo "ok";
}
?>