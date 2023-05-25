<?php
include '../global_seguridad/verificar_sesion.php';
$datos=[];
$producto=$_POST['id_receta'];
$precio_unitario=0;
$costo_bruto=0;
$cadenaDetalle="SELECT
                  CLAVE_ARTICULO,
                  SUBRECETA,
                  MERMA,
                  CANTIDAD_RECETA
                  FROM
                  tortilleria_recetasventarenglones 
                  WHERE
                  ACTIVO = 1 
                  AND ID_PRODUCTO = '$producto'";
$consultaDetalle=mysqli_query($conexion,$cadenaDetalle);
while($rowDetalle=mysqli_fetch_array($consultaDetalle)){
  if($rowDetalle[1]=='1'){
    //se busca por subreceta
    $cadenaSR="SELECT ID, UNIDAD_MEDIDA, RENDIMIENTO AS FACTOR_EMPAQUE FROM tortilleria_subrecetas WHERE CLAVE_RECETA='$rowDetalle[0]'";
    $consultaSR=mysqli_query($conexion,$cadenaSR);
    $rowSR=mysqli_fetch_array($consultaSR);
    $unidad_medida=$rowSR[1];
    $factor_empaque=$rowSR[2];
    $cadenaTotales="SELECT
                    round(
                      SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) + SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) * 0.03,
                      2 
                    ) AS COSTO_NETO
                  FROM
                    tortilleria_subrecetasrenglones AS r
                    INNER JOIN tortilleria_articulos AS a ON r.ID_ARTICULO = a.ARTC_ARTICULO 
                  WHERE
                    r.ID_SUBRECETA = '$rowSR[0]'";
    $consultaTotales=mysqli_query($conexion,$cadenaTotales);
    $rowTotales=mysqli_fetch_array($consultaTotales);
    $costo_empaque=$rowTotales[0];
    $cantidad_receta=$rowDetalle[3];
    $merma=$rowDetalle[2];
    $costo_unitario=round($costo_empaque/$factor_empaque,2);
    $precio_unitario=($costo_unitario*$cantidad_receta)/(1-$merma);
  }else{
    $cadenaArtc="SELECT
                round(((a.RMON_ULTIMOPRECIO/a.FACTOR_EMPAQUE)*r.CANTIDAD_RECETA)/(1-(a.PORCENTAJE_MERMA/100)),2) PRECIO_UNITARIO
                FROM
                tortilleria_subrecetasrenglones AS r
                INNER JOIN tortilleria_articulos AS a ON r.ID_ARTICULO = a.ARTC_ARTICULO
                WHERE r.ID_ARTICULO='$rowDetalle[0]'";
    $consultaArtc=mysqli_query($conexion,$cadenaArtc);
    $rowArtc=mysqli_fetch_array($consultaArtc);
    $precio_unitario=$rowArtc[0];
  }
  $costo_bruto=$costo_bruto+$precio_unitario;
}
$costo_bruto=round($costo_bruto,2);
$merma_servicio=round(($costo_bruto*3)/100,2);
$costo_neto=round($costo_bruto+$merma_servicio,2);
echo utf8_encode(json_encode(array(
  $costo_bruto,
  $merma_servicio,
  $costo_neto
)));
?>