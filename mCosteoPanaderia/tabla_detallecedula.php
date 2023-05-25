<?php
include '../global_seguridad/verificar_sesion.php';
$datos=[];
$producto=$_POST['id_receta'];
$cadenaDetalle="SELECT
                  ID,
                  ID_PRODUCTO,
                  CLAVE_ARTICULO,
                  CANTIDAD_RECETA,
                  SUBRECETA,
                  MERMA 
                  FROM
                  panaderia_recetasventarenglones 
                  WHERE
                  ACTIVO = 1 
                  AND ID_PRODUCTO = '$producto'";
$consultaDetalle=mysqli_query($conexion,$cadenaDetalle);
//ECHO $cadenaDetalle;
while($rowDetalle=mysqli_fetch_array($consultaDetalle)){
  //Se revisa si es subreceta
  if($rowDetalle[4]=='1'){
    //se busca por subreceta
    $cadenaSR="SELECT CLAVE_RECETA, NOMBRE_RECETA, UNIDAD_MEDIDA, RENDIMIENTO AS FACTOR_EMPAQUE, ID FROM panaderia_subrecetas WHERE CLAVE_RECETA='$rowDetalle[2]'";
    $consultaSR=mysqli_query($conexion,$cadenaSR);
    $rowSR=mysqli_fetch_array($consultaSR);
    //ECHO $cadenaSR;
    
    //Se desglosa para encontrar subrecetas anidadas
    $cadenaDesglose="SELECT ID, ID_ARTICULO, CANTIDAD_RECETA, SUBRECETA, ACTIVO FROM panaderia_subrecetasrenglones WHERE ID_SUBRECETA='$rowSR[4]' AND ACTIVO='1'";
    $consultaDesglose=mysqli_query($conexion,$cadenaDesglose);
    //ECHO $cadenaDesglose;
    while($rowDesglose=mysqli_fetch_array($consultaDesglose)){
      //Si existe subreceta dentro de subreceta
      if($rowDesglose[3]=='1' && $rowDesglose[4] == '1'){
        //OBTENER ID DE LA RECETA
        $cadenaRec="SELECT ID, NOMBRE_RECETA, RENDIMIENTO, UNIDAD_MEDIDA FROM panaderia_subrecetas WHERE CLAVE_RECETA='$rowDesglose[1]'";
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
                        ( SELECT RENDIMIENTO FROM panaderia_subrecetas WHERE ID = '$rowRec[0]' ) AS RENDIMIENTO,
                        round(
                          (
                            SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) + SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) * 0.03 
                          ) / ( SELECT RENDIMIENTO FROM panaderia_subrecetas WHERE ID = '$rowRec[0]' ),
                          2 
                        ) AS COSTO_UM,
                        a.UNIMEDIDA_VENTA 
                      FROM
                        panaderia_subrecetasrenglones AS r
                        INNER JOIN panaderia_articulos AS a ON r.ID_ARTICULO = a.ARTC_ARTICULO 
                      WHERE
                        r.ID_SUBRECETA = '$rowRec[0]'";
        $consultaTotales=mysqli_query($conexion,$cadenaTotales);
        $rowTotales=mysqli_fetch_array($consultaTotales);
      }elseif($rowDesglose[3]=='0' && $rowDesglose[4] == '1'){
        $cadenaTotales="SELECT
                          round(
                            SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) + SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) * 0.03,
                            2 
                          ) AS COSTO_NETO 
                        FROM
                          panaderia_subrecetasrenglones  AS r
                          INNER JOIN panaderia_articulos AS a ON r.ID_ARTICULO = a.ARTC_ARTICULO 
                        WHERE
                          r.ID_SUBRECETA = '$rowSR[4]'";
        $consultaTotales=mysqli_query($conexion,$cadenaTotales);
        $rowTotales=mysqli_fetch_array($consultaTotales);
      }
    }
    $artc_articulo=$rowSR[0];
    $artc_descripcion=$rowSR[1];
    $unidad_medida=$rowSR[2];
    $factor_empaque=$rowSR[3];
    $proveedor='LA MISIÓN SUPERMERCADOS';
    $costo_empaque=$rowTotales[0];
    $cantidad_receta=$rowDetalle[3];
    $merma=$rowDetalle[5];
    $costo_unitario=round($costo_empaque/$factor_empaque,2);
    $precio_unitario=round(($costo_unitario*$cantidad_receta)/(1-$merma),2);
    $articulo = json_encode($rowSR[0]);
    $Prod = json_encode($producto);
    $ide = json_encode($rowDetalle[0]);

    $activo = "<center><a href='#' class='btn btn-danger'onclick ='cambiarEstado($articulo,$Prod,$ide)'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
  }else{
    //Entra aqui si es articulo
    $cadenaArtc="SELECT
                  r.CLAVE_ARTICULO,
                  a.ARTC_DESCRIPCION,
                  a.PROVEEDOR,
                  a.RMON_ULTIMOPRECIO,
                  a.UNIMEDIDA_COMPRA,
                  a.FACTOR_EMPAQUE,
                  round((a.RMON_ULTIMOPRECIO/a.FACTOR_EMPAQUE),2) as COSTO_UNITARIO,
                  r.CANTIDAD_RECETA,
                  a.PORCENTAJE_MERMA,
                  round(((a.RMON_ULTIMOPRECIO/a.FACTOR_EMPAQUE)*r.CANTIDAD_RECETA)/(1-(a.PORCENTAJE_MERMA/100)),2) PRECIO_UNITARIO
                  FROM
                  panaderia_recetasventarenglones AS r
                  INNER JOIN panaderia_articulos AS a ON r.CLAVE_ARTICULO = a.ARTC_ARTICULO
                  WHERE r.CLAVE_ARTICULO='$rowDetalle[2]' AND r.ID_PRODUCTO='$rowDetalle[1]'";
    //ECHO $cadenaArtc;
    $consultaArtc=mysqli_query($conexion,$cadenaArtc);
    $rowArtc=mysqli_fetch_array($consultaArtc);
    $artc_articulo=$rowArtc[0];
    $artc_descripcion=$rowArtc[1];
    $proveedor=$rowArtc[2];
    $costo_empaque=$rowArtc[3];
    $unidad_medida=$rowArtc[4];
    $factor_empaque=$rowArtc[5];
    $costo_unitario=$rowArtc[6];
    $cantidad_receta=$rowArtc[7];
    $merma=$rowArtc[8];
    $precio_unitario=$rowArtc[9];
    $articulo = json_encode($rowArtc[0]);
    $Prod = json_encode($producto);
    $ide = json_encode($rowDetalle[0]);
    $activo = "<center><a href='#' class='btn btn-danger'onclick ='cambiarEstado($articulo,$Prod,$ide)'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
  }
  array_push($datos,array(
    'artc_articulo'=>$artc_articulo,
    'artc_descripcion'=>$artc_descripcion,
    'proveedor'=>$proveedor,
    'costo_empaque'=>$costo_empaque,
    'unidad_medida'=>$unidad_medida,
    'factor_empaque'=>$factor_empaque,
    'costo_unitario'=>$costo_unitario,
    'cantidad_receta'=>$cantidad_receta,
    'merma'=>$merma,
    'precio_unitario'=>$precio_unitario,
    'cambiar_estado'=>$activo
  ));
}
echo utf8_encode(json_encode($datos));
?>