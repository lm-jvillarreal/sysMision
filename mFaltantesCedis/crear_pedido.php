<?php
include '../global_seguridad/verificar_sesion.php';
$fechahora = $fecha.' '.$hora;
$descripcion = $_POST['descripcion'];
$codigo = $_POST['codigo'];
$artc_descripcion = $_POST['artc_descripcion'];
$sugerido = $_POST['sugerido'];
$cantidad = $_POST['cantidad'];
$conteo = count($codigo);

$cadenaFolio ="SELECT IFNULL(MAX(FOLIO_PEDIDO),0)+1 FROM solicitud_traspasos";
$consultaFolio = mysqli_query($conexion,$cadenaFolio);
$rowFolio = mysqli_fetch_array($consultaFolio);

for($i=0;$i<$conteo;$i++){
  if($sugerido[$i]=='0'){
    $porciento_sugerido='0';
  }else{
    $porciento_sugerido = ($cantidad[$i]/$sugerido[$i])*100;
  }
  $cadenaInsertar = "INSERT INTO solicitud_traspasos (FOLIO_PEDIDO, DESCRIPCION_TRASPASO, ARTC_ARTICULO, ARTC_DESCRIPCION, CANTIDAD_SOLICITA, ID_SOLICITA, FECHAHORA_SOLICITA, ESTATUS, ACTIVO, SUCURSAL, CANTIDAD_SUGERIDA, PORCIENTO_SUGERIDO)VALUES('$rowFolio[0]', '$descripcion', '$codigo[$i]', '$artc_descripcion[$i]', '$cantidad[$i]' ,'$id_usuario', '$fechahora', '1', '1','$id_sede','$sugerido[$i]','$porciento_sugerido')";
  $insertaPedido = mysqli_query($conexion,$cadenaInsertar);
}
echo "ok";
?>