<?php
include '../global_seguridad/verificar_sesion.php';
$cara=$_POST['cara'];
$datos = array();
$contador=1;
$cadenaFracciones="SELECT
                    f.ID,
                    (SELECT nombre FROM sucursales WHERE id=f.ID_SUCURSAL) AS Sucursal,
                    (SELECT AREA FROM inv_areas WHERE ID=f.ID_AREA) AS AREA,
                    f.ID_ZONA as ZONA,
                    (SELECT TIPO_MUEBLE FROM inv_muebles WHERE ID=f.ID_MUEBLE) as TipoMueble,
                    (SELECT MUEBLE FROM inv_muebles WHERE ID=f.ID_MUEBLE) as Mueble,
                    (SELECT CARA_MUEBLE FROM inv_caramuebles WHERE ID=f.ID_CARA) as Cara,
                    f.FRACCION_MUEBLE
                    FROM
                    inv_fraccionesmueble AS f
                      WHERE f.ID_CARA='$cara'";
$consultaFracciones=mysqli_query($conexion,$cadenaFracciones);
while($rowFracciones=mysqli_fetch_array($consultaFracciones)){
  $ver="<a href='#' onclick='ver($rowFracciones[0])'class='btn btn-primary'><i class='fa fa-search fa-lg' aria-hidden='true'></i><a/>";
  $articulo ="<a href='#' onclick='articulo($rowFracciones[0])'class='btn btn-warning'><i class='fa fa-plus fa-lg' aria-hidden='true'></i><a/>";
  $opciones = "<center>".$articulo."&nbsp;&nbsp;".$ver."</center>";
  array_push($datos,array(
    'id'=>$rowFracciones[0],
    'sucursal'=>$rowFracciones[1],
    'area'=>$rowFracciones[2],
    'zona'=>$rowFracciones[3],
    'tipo_mueble'=>$rowFracciones[4],
    'mueble'=>$rowFracciones[5],
    'cara'=>$rowFracciones[6],
    'fraccion'=>$rowFracciones[7],
    'opciones'=>$opciones
  ));
  $contador=$contador+1;
}
echo utf8_encode(json_encode($datos));
?>