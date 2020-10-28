<?php
include '../global_seguridad/verificar_sesion.php';

$id_registro = $_POST['liberar'];
$folioDesc = $_POST['folio'];

$cadenaFolio = "SELECT IFNULL(MAX(folio),0)+1 from auditoria_pv";
$consultaFolio = mysqli_query($conexion, $cadenaFolio);
$rowFolio = mysqli_fetch_array($consultaFolio);

$conteo = count($id_registro);
for($i=0;$i<$conteo;){
  $cadenaActualiza = "UPDATE auditoria_pv SET folio = '$rowFolio[0]', folio_desc ='$folioDesc', activo = '2' WHERE id = '$id_registro[$i]'";
  $consultaActualiza = mysqli_query($conexion, $cadenaActualiza);

  echo $cadenaActualiza;
  $i=$i+1;
}
?>