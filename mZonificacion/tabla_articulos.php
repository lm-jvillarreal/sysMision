<?php
include '../global_seguridad/verificar_sesion.php';
$fraccion=$_POST['fraccion'];
$datos = array();
$cadenaArticulos="SELECT
                  d.ID,
                  (SELECT nombre FROM sucursales WHERE ID=d.ID_SUCURSAL) as Suc,
                  (SELECT AREA FROM inv_areas WHERE ID=d.ID_AREA) as Area,
                  d.ID_ZONA,
                  (SELECT TIPO_MUEBLE FROM inv_muebles WHERE ID=d.ID_MUEBLE) as TipoMueble,
                  d.ID_MUEBLE,
                  (SELECT CARA_MUEBLE FROM inv_caramuebles WHERE ID=d.ID_CARA) as Cara,
                  d.ID_FRACCION,
                  d.NIVEL,
                  d.ARTC_ARTICULO,
                  d.ARTC_DESCRIPCION,
                  d.ARTC_FRENTE,
                  d.ARTC_FONDO,
                  d.ARTC_CAPACIDAD
                  FROM
                    inv_detallemuebles as d
                    WHERE d.ID_FRACCION='$fraccion'";
$consultaArticulos=mysqli_query($conexion,$cadenaArticulos);
while($rowArticulos=mysqli_fetch_array($consultaArticulos)){
  //$ver="<a href='#' onclick='ver($rowFracciones[0])'class='btn btn-primary'><i class='fa fa-search fa-lg' aria-hidden='true'></i><a/>";
  //$articulo ="<a href='#' onclick='articulo($rowFracciones[0])'class='btn btn-warning'><i class='fa fa-plus fa-lg' aria-hidden='true'></i><a/>";
  $eliminar ="<a href='#' onclick='eliminar_articulo($rowArticulos[0],$rowArticulos[7])'class='btn btn-warning'><i class='fa fa-trash fa-lg' aria-hidden='true'></i><a/>";
  //$opciones = "<center>".$articulo."&nbsp;&nbsp;".$ver."</center>";
  array_push($datos,array(
    'id'=>$rowArticulos[0],
    'sucursal'=>$rowArticulos[1],
    'area'=>$rowArticulos[2],
    'zona'=>$rowArticulos[3],
    'tipo_mueble'=>$rowArticulos[4],
    'mueble'=>$rowArticulos[5],
    'cara'=>$rowArticulos[6],
    'fraccion'=>$rowArticulos[7],
    'nivel'=>$rowArticulos[8],
    'artc_articulo'=>$rowArticulos[9],
    'artc_descripcion'=>$rowArticulos[10],
    'artc_frente'=>$rowArticulos[11],
    'artc_fondo'=>$rowArticulos[12],
    'artc_capacidad'=>$rowArticulos[13],
    'opciones'=>$eliminar
  ));
}
echo utf8_encode(json_encode($datos));
?>