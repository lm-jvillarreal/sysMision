<?php
include '../global_seguridad/verificar_sesion.php';

$clave_receta = $_POST['clave_receta'];
//id_articulo
$id_receta = $_POST['id_receta'];
//id_registro
$tipo = $_POST['tipo'];
//receta-producto-subreceta
$cantidad = $_POST['cantidad_prod'];
//cantidad insertar
$cadenaExiste = "SELECT COUNT(ID) FROM panaderia_inventariospos WHERE ID_ARTICULO = '$clave_receta'";

$consultaExiste = mysqli_query($conexion, $cadenaExiste);
$rowExiste =  mysqli_fetch_array($consultaExiste);
if($rowExiste[0] > 0){
  $consulta_modifica = "UPDATE panaderia_inventariospos SET CANTIDAD = '$cantidad', USUARIO = '$id_usuario' WHERE ID_ARTICULO = '$clave_receta'";
  $cadena_modifica = mysqli_query($conexion, $consulta_modifica);
  echo "ok_modifica";
}else{
   $cadena_insertar = "INSERT INTO panaderia_inventariospos (ID_ARTICULO,CANTIDAD, FECHA,HORA, ACTIVO, USUARIO)
  VALUES('$clave_receta','$cantidad','$fecha','$hora', '1', '$id_usuario')";
  $insertar_registro = mysqli_query($conexion,$cadena_insertar);
  echo "ok";
}

 ?>