<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$id=$_POST['id_remision'];
$cadenaRemision="SELECT CANTIDAD, ARTC_ARTICULO, COSTO_UNITARIO, COSTO_RENGLON FROM inv_renglonesremision WHERE ID_REMISION='$id'";

$consultaRemision=mysqli_query($conexion,$cadenaRemision);
while($rowRemision=mysqli_fetch_array($consultaRemision)){
  array_push($datos,array(
    "cantidad"=>$rowRemision[0],
    "artc_articulo"=>$rowRemision[1],
    "costo_unitario"=>$rowRemision[2],
    "costo_total"=>$rowRemision[3]
  ));
}
echo utf8_encode(json_encode($datos));
?>