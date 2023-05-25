<?php
include '../global_seguridad/verificar_sesion.php';
$id_receta=$_POST['id_receta'];

$cadenaReceta="SELECT
                round(
                  SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ),
                  2 
                ) AS COSTO_BRUTO,
                round(
                  SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) * 0.03,
                  2 
                ) AS MERMA,
                round(
                  SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) + SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) * 0.03,
                  2 
                ) AS COSTO_NETO,
                ( SELECT RENDIMIENTO FROM perecederos_subrecetas WHERE ID = '$id_receta' ) AS RENDIMIENTO,
                round(
                  (
                    SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) + SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) * 0.03 
                  ) / ( SELECT RENDIMIENTO FROM perecederos_subrecetas WHERE ID = '$id_receta' ),
                  2 
                ) AS COSTO_UM,
                a.UNIMEDIDA_VENTA 
              FROM
                perecederos_subrecetasrenglones AS r
                INNER JOIN perecederos_articulos AS a ON r.ID_ARTICULO = a.ARTC_ARTICULO 
              WHERE
                r.ID_SUBRECETA = '$id_receta'";
$consultaReceta=mysqli_query($conexion,$cadenaReceta);
$rowReceta=mysqli_fetch_array($consultaReceta);

echo utf8_encode(json_encode(array(
  $rowReceta[0],
  $rowReceta[1],
  $rowReceta[2],
  $rowReceta[3],
  $rowReceta[4],
  $rowReceta[5]
)));
?>