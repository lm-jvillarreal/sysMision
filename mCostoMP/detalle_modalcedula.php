<?php
include '../global_seguridad/verificar_sesion.php';
$id_producto=$_POST['folio'];
$cadenaDetalle="SELECT ID, ARTC_ARTICULO, ARTC_DESCRIPCION FROM perecederos_recetasventa WHERE ID='$id_producto'";
$consultaDetalle=mysqli_query($conexion,$cadenaDetalle);
$rowDetalle=mysqli_fetch_array($consultaDetalle);

echo utf8_encode(json_encode(
  array(
    $rowDetalle[0],
    $rowDetalle[1],
    $rowDetalle[2]
  )
  ));
?>