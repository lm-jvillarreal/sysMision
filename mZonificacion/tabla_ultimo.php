<?php
include '../global_seguridad/verificar_sesion.php';
$datos = array();
$fraccion=$_POST['id_fraccion'];
$cadenaDetalle="SELECT
                ARTC_ARTICULO,
                ARTC_DESCRIPCION,
                ARTC_FRENTE,
                ARTC_ALTO,
                ARTC_FONDO,
                ARTC_CAPACIDAD 
                FROM
                inv_detallemuebles 
                WHERE
                ID = ( SELECT MAX( ID ) FROM inv_detallemuebles WHERE ID_FRACCION = '$fraccion' )";
$consultaDetalle=mysqli_query($conexion,$cadenaDetalle);
while($rowDetalle=mysqli_fetch_array($consultaDetalle)){
  //$ver ="<center><a href='#' onclick='ver($rowMuebles[0])'class='btn btn-warning'><i class='fa fa-search fa-lg' aria-hidden='true'></i><a/></center>";
  array_push($datos,array(
    'artc_articulo'=>$rowDetalle[0],
    'artc_descripcion'=>$rowDetalle[1],
    'frente'=>$rowDetalle[2],
    'alto'=>$rowDetalle[3],
    'fondo'=>$rowDetalle[4],
    'capacidad'=>$rowDetalle[5]
  ));
}
echo utf8_encode(json_encode($datos));
?>