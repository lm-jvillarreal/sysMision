<?php
include '../global_seguridad/verificar_sesion.php';
$datos = array();
$cadenaMuebles="SELECT
                ID,
                (SELECT nombre FROM sucursales WHERE id=M.ID_SUCURSAL) as Sucursal,
                (SELECT AREA FROM inv_areas WHERE ID=M.ID_AREA) AS Area,
                ZONA,
                MUEBLE,
                TIPO_MUEBLE,
                COMENTARIOS 
                FROM
                inv_muebles AS M
                WHERE
                ACTIVO = '1'";
$consultaMuebles=mysqli_query($conexion,$cadenaMuebles);
while($rowMuebles=mysqli_fetch_array($consultaMuebles)){
  $ver ="<center><a href='#' onclick='ver($rowMuebles[0])'class='btn btn-warning'><i class='fa fa-search fa-lg' aria-hidden='true'></i><a/></center>";
  array_push($datos,array(
    'id'=>$rowMuebles[0],
    'sucursal'=>$rowMuebles[1],
    'area'=>$rowMuebles[2],
    'zona'=>$rowMuebles[3],
    'mueble'=>$rowMuebles[4],
    'tipo_mueble'=>$rowMuebles[5],
    'comentarios'=>$rowMuebles[6],
    'opciones'=>$ver
  ));
}
echo utf8_encode(json_encode($datos));
?>