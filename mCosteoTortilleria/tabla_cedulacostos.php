<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaConsulta="SELECT ID, ARTC_ARTICULO, ARTC_DESCRIPCION FROM tortilleria_recetasventa WHERE ACTIVO=1";
$consultaCostos=mysqli_query($conexion,$cadenaConsulta);
while($rowCostos=mysqli_fetch_array($consultaCostos)){
  $ver = "<center><a href='#' data-folio = '$rowCostos[0]' data-toggle = 'modal' data-target = '#modal_detallecedula' class='btn btn-success'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    "id"=>$rowCostos[0],
    "artc_articulo"=>$rowCostos[1],
    "artc_descripcion"=>$rowCostos[2],
    "costo_bruto"=>'',
    "merma"=>"",
    "costo_neto"=>"",
    "opciones"=>$ver
  ));
}

echo utf8_encode(json_encode($datos));
?>