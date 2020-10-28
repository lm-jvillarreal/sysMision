<?php
include '../global_seguridad/verificar_sesion.php';

$id_receta = $_POST['id_receta'];
$codigo = $_POST['codigo'];
$articulo = $_POST['articulo'];
$descripcion = $_POST['descripcion'];

$cadenaConsulta = "SELECT artc_descripcion FROM cp_productos WHERE artc_articulo = '$articulo'";
$consultaArticulo = mysqli_query($conexion, $cadenaConsulta);
$rowArticulo = mysqli_fetch_array($consultaArticulo);
$conteo = count($rowArticulo[0]);
if($conteo==0){
  echo "no_existe";
}else{
  $cadenaExiste = "SELECT * FROM cp_detalle_receta WHERE id_receta = '$id_receta' AND artc_articulo = '$articulo'";
  $existe= mysqli_query($conexion, $cadenaExiste);
  $rowExiste = mysqli_fetch_array($existe);
  $conteoDetalle = count($rowExiste[0]);
  if($conteoDetalle==0){
    $cadenaInsertar = "INSERT INTO cp_detalle_receta(id_receta, codigo_receta, artc_articulo, cantidad, fecha, hora, activo, usuario)VALUES('$id_receta', '$codigo', '$articulo', '1', '$fecha', '$hora', '1', '$id_usuario')";
    $insertarDetalle = mysqli_query($conexion, $cadenaInsertar);
    echo $rowArticulo[0]; 
  }else{
    echo $rowArticulo[0]; 
  }
}
?>
