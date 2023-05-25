<?php
include '../global_seguridad/verificar_sesion.php';
$datos=array();
$id_receta=$_POST['id_receta'];
$cadenaDesglose="SELECT ID, ID_ARTICULO, CANTIDAD_RECETA, SUBRECETA, ACTIVO FROM panaderia_subrecetasrenglones WHERE ID_SUBRECETA='$id_receta' AND ACTIVO='1'";
$consultaDesglose=mysqli_query($conexion,$cadenaDesglose);
while($rowDesglose=mysqli_fetch_array($consultaDesglose)){
  if($rowDesglose[3]=='1' && $rowDesglose[4] == '1'){
    //OBTENER ID DE LA RECETA
    $cadenaRec="SELECT ID, NOMBRE_RECETA, RENDIMIENTO, UNIDAD_MEDIDA FROM panaderia_subrecetas WHERE CLAVE_RECETA='$rowDesglose[1]'";
    $consultaRec=mysqli_query($conexion,$cadenaRec);
    $rowRec=mysqli_fetch_array($consultaRec);
    //CÁLCULO AL SER SUBRECETA
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
    $consultaReceta=mysqli_query($conexion,$cadenaReceta);
    $rowReceta=mysqli_fetch_array($consultaReceta);
    //VARIABLES PARA ARRAY
    $artc_articulo=$rowDesglose[1];
    $artc_descripcion=$rowRec[1];
    $proveedor="LA MISIÓN SUPERMERCADOS";
    $costo_empaque=$rowReceta[0];
    $unidad_medida=$rowRec[3];
    $factor_empaque=$rowReceta[3];
    $costo_unitario=$rowReceta[2];
    $cantidad_receta=$rowRec[2];
    $merma=$rowReceta[1];
    $precio_unitario=$rowReceta[4];
    $articulo = json_encode($rowDesglose[1]);
    $ide = json_encode($rowDesglose[0]);
    $Receta = json_encode($id_receta);
    $activo = "<center><a href='#' class='btn btn-danger'onclick ='cambiarEstado($articulo,$Receta,$ide)'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
  }elseif($rowDesglose[3]=='0' && $rowDesglose[4] == '1'){
    $cadenaDetalle="SELECT
                  a.ARTC_DESCRIPCION,
                  a.PROVEEDOR,
                  a.RMON_ULTIMOPRECIO,
                  a.UNIMEDIDA_COMPRA,
                  a.FACTOR_EMPAQUE,
                  round( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ), 2 ) AS COSTO_UNITARIO,
                  a.PORCENTAJE_MERMA,
                  round( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * $rowDesglose[2] ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ), 2 ) PRECIO_UNITARIO 
                FROM
                  panaderia_articulos AS a 
                WHERE
                  a.ARTC_ARTICULO = '$rowDesglose[1]'";
    $consultaReceta=mysqli_query($conexion,$cadenaDetalle);
    $rowDetalle=mysqli_fetch_array($consultaReceta);
    
    //VARIABLES PARA ARRAY
    $artc_articulo=$rowDesglose[1];
    $artc_descripcion=$rowDetalle[0];
    $proveedor=$rowDetalle[1];
    $costo_empaque=$rowDetalle[2];
    $unidad_medida=$rowDetalle[3];
    $factor_empaque=$rowDetalle[4];
    $costo_unitario=$rowDetalle[5];
    $cantidad_receta=$rowDesglose[2];
    $merma=$rowDetalle[6];
    $precio_unitario=$rowDetalle[7];
    $articulo = json_encode($rowDesglose[1]);
    $ide = json_encode($rowDesglose[0]);
    $Receta = json_encode($id_receta);
    $activo = "<center><a href='#' class='btn btn-danger'onclick ='cambiarEstado($articulo,$Receta,$ide)'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></center>";
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
    'cambio_estado'=>$activo
  ));
}
echo utf8_encode(json_encode($datos));
?>