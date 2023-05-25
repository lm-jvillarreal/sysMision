<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$artc_articulo=$_POST['artc_articulo'];
$cadenaBitacora="SELECT
                  ARTC_ARTICULO,
                  ARTC_DESCRIPCION,
                  DEPARTAMENTO,
                  (SELECT nombre FROM sucursales WHERE id=revision_faltantes.sucursal) SUCURSAL,
                  DATE_FORMAT(FECHAHORA,'%d/%m/%Y %H:%i:%s') FECHA_REVISION,
                  TEORICO,
                  DATE_FORMAT(FECHAHORA_AJUSTE,'%d/%m/%Y %H:%i:%s') FECHA_AJUSTE,
                  TEORICO_AJUSTE,
                  OBSERVACIONES
                  FROM
                  revision_faltantes
                  WHERE ARTC_ARTICULO='$artc_articulo'";
$consultaBitacora=mysqli_query($conexion,$cadenaBitacora);
while($rowBitacora=mysqli_fetch_array($consultaBitacora)){
  array_push($datos,array(
    "artc_articulo"=>$rowBitacora[0],
    "artc_descripcion"=>$rowBitacora[1],
    "depto"=>$rowBitacora[2],
    "sucursal"=>$rowBitacora[3],
    "fecha_revision"=>$rowBitacora[4],
    "teorico"=>$rowBitacora[5],
    "fecha_ajuste"=>$rowBitacora[6],
    "teorico_ajuste"=>$rowBitacora[7],
    "observaciones"=>$rowBitacora[8]
  ));
}
echo utf8_encode(json_encode($datos));
?>