<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaDetalle="SELECT
                  r.ID,
                  r.ID_AUDITORIA,
                  r.ARTC_ARTICULO,
                  ( SELECT ARTC_DESCRIPCION FROM vidvig_categorias WHERE ARTC_ARTICULO = r.ARTC_ARTICULO LIMIT 1 ) DESCRIPCION,
                  ( SELECT AREA FROM vidvig_areas WHERE ID = r.ID_AREA ) AREA,
                  r.CANTIDAD
                  FROM
                  vidvig_renglonesauditoria AS r
                  INNER JOIN vidvig_auditoria AS a ON r.ID_AUDITORIA = a.ID 
                  WHERE
                  r.ID_AREA = ( SELECT MIN( ID_AREA ) FROM vidvig_renglonesauditoria WHERE ESTATUS = 1 ) 
                  AND a.SUCURSAL = '$id_sede'
                  AND a.ESTATUS='1'
                  ";
$consultaDetalle=mysqli_query($conexion,$cadenaDetalle);
while($rowDetalle=mysqli_fetch_array($consultaDetalle)){
  if(is_null($rowDetalle[5])){
    $class="btn btn-danger";
  }else{
    $class="btn btn-success";
  }
  $editar = "<center><a href='#' class='$class' onclick=\"captura($rowDetalle[0],'$rowDetalle[3]')\"><i class='fa fa-plus fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    'id'=>$rowDetalle[0],
    'id_auditoria'=>$rowDetalle[1],
    'artc_articulo'=>$rowDetalle[2],
    'descripcion'=>$rowDetalle[3],
    'area'=>$rowDetalle[4],
    'cantidad'=>$rowDetalle[5],
    'opciones'=>$editar
  ));
}
echo utf8_encode(json_encode($datos));
?>