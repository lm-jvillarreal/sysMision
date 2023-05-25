<?php
include '../global_seguridad/verificar_sesion.php';
$folio=$_POST['folio'];
$cadenaReceta="SELECT ID, 
    CLAVE_RECETA, 
    NOMBRE_RECETA, 
    UNIDAD_MEDIDA 
  FROM panaderia_subrecetas WHERE ID='$folio'";
$consultaReceta=mysqli_query($conexion,$cadenaReceta);
$rowReceta=mysqli_fetch_array($consultaReceta);

echo utf8_encode(json_encode(array(
  $rowReceta[0],
  $rowReceta[1],
  $rowReceta[2],
  $rowReceta[3]
)));
?>