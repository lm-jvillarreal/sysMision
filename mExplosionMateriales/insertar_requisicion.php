<?php
include '../global_seguridad/verificar_sesion.php';
$id_articulo = $_POST['articulo'];
//id_articulo
$dias_entrega = $_POST['dias_entrega'];
//dias que el proveedor tarda en entregar mercancía
$cantidad = $_POST['cantidad_ordenar'];

//cantidad insertar
$fecha=date("Y-m-d"); 
$hora=date ("H:i:s");
$fechahora = $fecha.' '.$hora;
$cadenaExiste = "SELECT COUNT(ID) FROM panaderia_requisicion WHERE ID_ARTICULO = '$id_articulo'";
$consultaExiste = mysqli_query($conexion, $cadenaExiste);
$rowExiste =  mysqli_fetch_array($consultaExiste);
if($rowExiste[0] > 0){
  $consulta_modifica = "UPDATE panaderia_requisicion SET CANTIDAD_ORDENAR = '$cantidad',DIAS_ENTREGA = '$dias_entrega', USUARIO = '$id_usuario' WHERE ID_ARTICULO = '$id_articulo'";
  $cadena_modifica = mysqli_query($conexion, $consulta_modifica);
  echo "ok_modifica";
}else{
   $cadena_insertar = "INSERT INTO panaderia_requisicion (ID_ARTICULO, DIAS_ENTREGA, CANTIDAD_ORDENAR, FECHAHORA, ACTIVO, USUARIO)
  VALUES('$id_articulo','$dias_entrega','$cantidad','$fechahora', '1', '$id_usuario')";
 // $insertar_registro = mysqli_query($conexion,$cadena_insertar);
  echo $cadena_insertar;
}
 ?>