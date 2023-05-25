<?php
include '../global_seguridad/verificar_sesion.php';

$id_articulo = $_POST['id_articulo'];
//id_articulo
$id_registro = $_POST['id_registro'];
//id_registro
//receta-producto-subreceta
$cantidad = $_POST['cantidad_materia'];
//cantidad insertar
$cadenaExiste = "SELECT COUNT(ID) FROM panaderia_invpro_cantidad WHERE ID_ARTICULO = '$id_articulo'";

$consultaExiste = mysqli_query($conexion, $cadenaExiste);
$rowExiste =  mysqli_fetch_array($consultaExiste);
if($rowExiste[0] > 0){
  $consulta_modifica = "UPDATE 
    panaderia_invpro_cantidad 
  SET CANTIDAD = '$cantidad', 
  USUARIO = '$id_usuario'
    WHERE ID_ARTICULO = '$id_articulo'";
  $cadena_modifica = mysqli_query($conexion, $consulta_modifica);
  echo "ok_modifica";
}else{
    $cadena_insertar = "INSERT INTO 
    panaderia_invpro_cantidad (ID_ARTICULO,CANTIDAD,TIPO, FECHA,HORA, ACTIVO, USUARIO)
    VALUES('$id_articulo','$cantidad','3','$fecha','$hora', '1', '$id_usuario')";
  $insertar_registro = mysqli_query($conexion,$cadena_insertar);
  echo "ok";
}
//TIPO: 1= RECETA
    //  2= SUBRECETA
    //  3= PRODUCTO
 ?>