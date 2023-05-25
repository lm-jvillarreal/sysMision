<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora=date("Y-m-d H:i:s");

$artc_articulo = $_POST['articulo'];
//id_articulo
$pedido = $_POST['pedido'];
//id_registro

$cadenaExiste = "SELECT COUNT(ID) FROM panaderia_cantidadproducir WHERE ID_ARTICULO = '$artc_articulo'";

$consultaExiste = mysqli_query($conexion, $cadenaExiste);
$rowExiste =  mysqli_fetch_array($consultaExiste);
if($rowExiste[0] > 0){
  $consulta_modifica = "UPDATE panaderia_cantidadproducir SET CANTIDAD = '$pedido', USUARIO = '$id_usuario' WHERE ID_ARTICULO = '$artc_articulo'";
  $cadena_modifica = mysqli_query($conexion, $consulta_modifica);
  echo "ok_modifica";
}else{
   $cadena_insertar = "INSERT INTO panaderia_cantidadproducir (ID_SUCURSAL,ID_ARTICULO,TOTAL_VENTAS,CANTIDAD,ESTIMACION_VENTAS,FECHAHORA,ACTIVO,USUARIO)
  VALUES('$id_sede','$artc_articulo','0','$pedido','0','$fechahora', '1', '$id_usuario')";
  $insertar_registro = mysqli_query($conexion,$cadena_insertar);
  echo "ok";
}
 ?>