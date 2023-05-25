<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$cadenaRevision="SELECT
                  ARTC_ARTICULO,
                  ARTC_DESCRIPCION,
                  (SELECT nombre FROM sucursales WHERE id=revision_faltantes.sucursal) as Sucursal,
                  COMENTARIO,
                  TEORICO,
                  DEPARTAMENTO,
                  ID,
                  SUCURSAL
                  FROM
                  revision_faltantes
                  WHERE ACTIVO=1";
$consultaRevision=mysqli_query($conexion,$cadenaRevision);
while($rowRevision=mysqli_fetch_array($consultaRevision)){
  $liberar = "<center><a href='#' class='btn btn-danger' onclick=\"liberar($rowRevision[6],'$rowRevision[0]',$rowRevision[7])\"><i class='fa fa-check fa-lg' aria-hidden='true'></i></a></center>";
  array_push($datos,array(
    "artc_articulo"=>$rowRevision[0],
    "artc_descripcion"=>$rowRevision[1],
    "sucursal"=>$rowRevision[2],
    "depto"=>$rowRevision[5],
    "existencia"=>$rowRevision[4],
    "opciones"=>$liberar
  ));
}
echo utf8_encode(json_encode($datos));
?>