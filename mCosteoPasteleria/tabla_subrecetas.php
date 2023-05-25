<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaConsulta="SELECT ID, CLAVE_RECETA, NOMBRE_RECETA, RENDIMIENTO, UNIDAD_MEDIDA FROM pasteleria_subrecetas WHERE ACTIVO=1";

$consulta=mysqli_query($conexion,$cadenaConsulta);
while($row=mysqli_fetch_array($consulta)){
  $ver = "<center><a href='#' data-folio = '$row[0]' data-toggle = 'modal' data-target = '#modal-detalle' class='btn btn-success'><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    "id"=>$row[0],
    "clave_receta"=>$row[1],
    "nombre_receta"=>$row[2],
    "rendimiento"=>$row[3],
    "unidad_medida"=>$row[4],
    "opciones"=>$ver
  ));
}
echo utf8_encode(json_encode($datos));