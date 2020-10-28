<?php
include '../global_seguridad/verificar_sesion.php';
$folio = $_POST['folio'];
$usuario = $_POST['usuario'];

$cadenaFolio = "SELECT folio_desc, artc_articulo, artc_descripcion, artc_familia, artc_depto FROM monitoreo_teoricos WHERE folio = '$folio'";
$consultaFolio = mysqli_query($conexion, $cadenaFolio);

$cadena_folio = "SELECT IFNULL(MAX(folio),0)+1 FROM monitoreo_teoricos";
$consulta_folio = mysqli_query($conexion,$cadena_folio);
$row_folio = mysqli_fetch_array($consulta_folio);
$folio_registro = $row_folio[0];

while($rowFolio = mysqli_fetch_array($consultaFolio)){
  $cadenaInsertar = "INSERT INTO monitoreo_teoricos (folio, folio_desc, artc_articulo, artc_descripcion, artc_familia, artc_depto, fecha, hora, activo, usuario)VALUES('$folio_registro','$rowFolio[0]','$rowFolio[1]','$rowFolio[2]','$rowFolio[3]','$rowFolio[4]','$fecha','$hora','1','$usuario')";
  $consultaInsertar = mysqli_query($conexion,$cadenaInsertar);
}
echo "ok";
?>