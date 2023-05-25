<?php
include '../global_seguridad/verificar_sesion.php';
$datos=[];
$cadenaCortes="SELECT ID, CODIGO_CORTE, DESCRIPCION_CORTE FROM carniceria_catalogo WHERE ACTIVO='1'";
$consultaCortes=mysqli_query($conexion,$cadenaCortes);
while($rowCortes=mysqli_fetch_array($consultaCortes)){
  $ver = "<center><a href='#' data-folio = '$rowCortes[0]' data-toggle = 'modal' data-target = '#modal_corterenglones' class='btn btn-success btn-sm'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    "id"=>$rowCortes[0],
    "artc_codigo"=>$rowCortes[1],
    "artc_corte"=>$rowCortes[2],
    "opciones"=>$ver
  ));
}
echo utf8_encode(json_encode($datos));
?>