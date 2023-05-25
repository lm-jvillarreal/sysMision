<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$datos=array();
//Obtener la lista de recetas registradas en el sistema
$cadenaRecetas="SELECT ID, ARTC_ARTICULO, ARTC_DESCRIPCION FROM tortilleria_recetasventa WHERE ACTIVO=1";
$consultaRecetas=mysqli_query($conexion,$cadenaRecetas);
while($rowRecetas=mysqli_fetch_array($consultaRecetas)){

  //calcular el costo de la subreceta
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
                    AND ID_PRODUCTO = '$rowRecetas[0]'";
  $consultaDetalle=mysqli_query($conexion,$cadenaDetalle);
  while($rowDetalle=mysqli_fetch_array($consultaDetalle)){
    if($rowDetalle[1]=='1'){
      //se busca por subreceta
      $cadenaSR="SELECT ID, UNIDAD_MEDIDA, RENDIMIENTO AS FACTOR_EMPAQUE FROM tortilleria_subrecetas WHERE CLAVE_RECETA='$rowDetalle[0]'";
      $consultaSR=mysqli_query($conexion,$cadenaSR);
      $rowSR=mysqli_fetch_array($consultaSR);

      //Se desglosa para ver si existen subrecetas anidadas
      $cadenaDesglose="SELECT ID, ID_ARTICULO, CANTIDAD_RECETA, SUBRECETA FROM tortilleria_subrecetasrenglones WHERE ID_SUBRECETA='$rowSR[0]' AND ACTIVO='1'";
      $consultaDesglose=mysqli_query($conexion,$cadenaDesglose);
      while($rowDesglose=mysqli_fetch_array($consultaDesglose)){
        //Si existe subreceta dentro de subreceta
        if($rowDesglose[3]=='1'){
          //OBTENER ID DE LA RECETA
          $cadenaRec="SELECT ID, NOMBRE_RECETA, RENDIMIENTO, UNIDAD_MEDIDA FROM tortilleria_subrecetas WHERE CLAVE_RECETA='$rowDesglose[1]'";
          $consultaRec=mysqli_query($conexion,$cadenaRec);
          $rowRec=mysqli_fetch_array($consultaRec);
          $cadenaTotales="SELECT
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
                          ( SELECT RENDIMIENTO FROM tortilleria_subrecetas WHERE ID = '$rowRec[0]' ) AS RENDIMIENTO,
                          round(
                            (
                              SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) + SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) * 0.03 
                            ) / ( SELECT RENDIMIENTO FROM tortilleria_subrecetas WHERE ID = '$rowRec[0]' ),
                            2 
                          ) AS COSTO_UM,
                          a.UNIMEDIDA_VENTA 
                        FROM
                          tortilleria_subrecetasrenglones AS r
                          INNER JOIN tortilleria_articulos AS a ON r.ID_ARTICULO = a.ARTC_ARTICULO 
                        WHERE
                          r.ID_SUBRECETA = '$rowRec[0]'";
          $consultaTotales=mysqli_query($conexion,$cadenaTotales);
          $rowTotales=mysqli_fetch_array($consultaTotales);
        }elseif($rowDesglose[3]=='0'){
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
        }
      }
      $unidad_medida=$rowSR[1];
      $factor_empaque=$rowSR[2];
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
  $costoNeto=round($costo_bruto+$merma_servicio,2);

  //Obtener el precio de venta del platillo
  $cadenaPrecio="SELECT to_char(PRFN_PRECIO_CON_IMP, 'fm9990.00'), ARTC_UNIMEDIDA_VENTA FROM PV_PRECIOS_FINALES_VW WHERE ARTC_ARTICULO='$rowRecetas[1]' AND CFGC_SUCURSAL='2'";
  $consultaPrecio = oci_parse($conexion_central, $cadenaPrecio);
  oci_execute($consultaPrecio);
  $rowPrecio = oci_fetch_row($consultaPrecio);
  $conIva=$rowPrecio[0];
  $sinIva=round($rowPrecio[0]/1.16,2);
  $mb=round((1-($costoNeto/$sinIva))*100,2);
  $cv=round(100-$mb,2);
  $utilidad=round($sinIva-$costoNeto,2);

  array_push($datos,array(
    'artc_articulo'=>$rowRecetas[1],
    'platillo'=>$rowRecetas[2],
    'unidad_medida'=>$rowPrecio[1],
    'costo'=>$costoNeto,
    'sin_iva'=>$sinIva,
    'con_iva'=>$conIva,
    'cv'=>$cv,
    'mb'=>$mb,
    'utilidad'=>$utilidad
  ));
}
echo utf8_encode(json_encode($datos));
?>