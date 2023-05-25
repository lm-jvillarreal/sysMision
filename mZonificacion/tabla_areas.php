<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaAreas="SELECT
              ID,
              ( SELECT nombre FROM sucursales WHERE id = inv_areas.ID_SUCURSAL ) SUCURSAL,
              AREA 
              FROM
              inv_areas 
              WHERE
              ACTIVO = '1'";
$consultaAreas=mysqli_query($conexion,$cadenaAreas);
while($rowAreas=mysqli_fetch_array($consultaAreas)){
  $editar = "<center><a href='#' class='btn btn-danger' onclick=\"editar($rowAreas[0])\"><i class='fa fa-edit fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    'id'=>$rowAreas[0],
    'area'=>$rowAreas[2],
    'sucursal'=>$rowAreas[1],
    'opciones'=>$editar
  ));
}
echo utf8_encode(json_encode($datos));
?>