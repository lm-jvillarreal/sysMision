<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$datos=array();
$numero = 0;

$cadenaConsulta="SELECT
ID,
ARTC_ARTICULO, 
ARTC_DESCRIPCION,
RMON_ULTIMOPRECIO,
FACTOR_EMPAQUE,
UNIMEDIDA_VENTA
FROM panaderia_articulos_historial
WHERE ACTIVO=1  
GROUP BY ARTC_ARTICULO";
$consulta=mysqli_query($conexion,$cadenaConsulta);
while($row=mysqli_fetch_array($consulta)){
  $CadenaCantidad = "SELECT CANTIDAD FROM panaderia_inventariospos WHERE ID_ARTICULO = '$row[1]' GROUP BY ID_ARTICULO";
  $ConsultaCantidad = mysqli_query($conexion, $CadenaCantidad);
  $rowCantidad = mysqli_fetch_array($ConsultaCantidad);
  if($rowCantidad[0]==""){
    $ValorCant = '0';
  }else{
    $ValorCant = $rowCantidad[0];
  }
  $input = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$ValorCant'></input></div>";
  array_push($datos,array(
    "id"=>$row[0],
    "tipo" => "ARTICULO",
    "artc_articulo"=>$row[1],
    "unimedida_venta"=>$row[5],
    "artc_descripcion"=>$row[2],
    "rmon_ultimoprecio"=>$row[3],
    "cantidad"=>$input,
    "total"=>round(($row[3] * $ValorCant), 2)
  ));
}

$cadenaConsultaProducto = "SELECT 
        ID, 
        ARTC_ARTICULO, 
        ARTC_DESCRIPCION 
        FROM 
        panaderia_recetasventa WHERE ACTIVO=1 
        GROUP BY ARTC_ARTICULO";
$consultaProducto = mysqli_query($conexion, $cadenaConsultaProducto);
while ($row2 = mysqli_fetch_array($consultaProducto)) {
  $CadenaCantidad = "SELECT CANTIDAD FROM panaderia_inventariospos WHERE ID_ARTICULO = '$row2[1]' GROUP BY ID_ARTICULO";
  $ConsultaCantidad = mysqli_query($conexion, $CadenaCantidad);
  $rowCantidad = mysqli_fetch_array($ConsultaCantidad);
  if($rowCantidad[0]==""){
    $ValorCant = '0';
  }else{
    $ValorCant = $rowCantidad[0];
  }
  $cadenaPrecio="SELECT 
  to_char(PRFN_PRECIO_CON_IMP, 'fm9990.00'), 
  ARTC_UNIMEDIDA_VENTA 
  FROM 
  PV_PRECIOS_FINALES_VW 
  WHERE ARTC_ARTICULO='$row2[1]' 
  AND CFGC_SUCURSAL='2'";
  $consultaPrecio = oci_parse($conexion_central, $cadenaPrecio);
  oci_execute($consultaPrecio);
  $rowPrecio = oci_fetch_row($consultaPrecio);
  $conIva=$rowPrecio[0];
  $input = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$ValorCant'></input></div>";
  array_push($datos,array(
    "id"=>$row2[0],
    "tipo" =>"RECETA",
    "artc_articulo"=>$row2[1],
    "unimedida_venta"=>$rowPrecio[1],
    "artc_descripcion"=>$row2[2],
    "rmon_ultimoprecio"=>$conIva,
    "cantidad"=>$input,
    "total"=>round(($conIva * $ValorCant), 2)
  ));
}

$cadenaRec="SELECT ID, CLAVE_RECETA, NOMBRE_RECETA, RENDIMIENTO, UNIDAD_MEDIDA FROM panaderia_subrecetas WHERE ACTIVO = 1";
$consultaDesglose=mysqli_query($conexion,$cadenaRec);
while($rowDesglose=mysqli_fetch_array($consultaDesglose)){
  $CadenaCantidad = "SELECT CANTIDAD FROM panaderia_inventariospos WHERE ID_ARTICULO = '$rowDesglose[1]' GROUP BY ID_ARTICULO";
  $ConsultaCantidad = mysqli_query($conexion, $CadenaCantidad);
  $rowCantidad = mysqli_fetch_array($ConsultaCantidad);
  if($rowCantidad[0]==""){
    $ValorCant = '0';
  }else{
    $ValorCant = $rowCantidad[0];
  }
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
                ( SELECT RENDIMIENTO FROM panaderia_subrecetas WHERE ID = '$rowDesglose[0]' ) AS RENDIMIENTO,
                round(
                  (
                    SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) + SUM( ( ( a.RMON_ULTIMOPRECIO / a.FACTOR_EMPAQUE ) * r.CANTIDAD_RECETA ) / ( 1- ( a.PORCENTAJE_MERMA / 100 ) ) ) * 0.03 
                  ) / ( SELECT RENDIMIENTO FROM panaderia_subrecetas WHERE ID = '$rowDosglose[0]' ),
                  2 
                ) AS COSTO_UM,
                a.UNIMEDIDA_VENTA 
              FROM
                panaderia_subrecetasrenglones AS r
                INNER JOIN panaderia_articulos AS a ON r.ID_ARTICULO = a.ARTC_ARTICULO 
              WHERE
                r.ID_SUBRECETA = '$rowDesglose[0]'";
    $consultaReceta=mysqli_query($conexion,$cadenaReceta);
    $rowReceta=mysqli_fetch_array($consultaReceta);
    $artc_articulo=$rowDesglose[1];
    $artc_descripcion=$rowDesglose[2];
    $proveedor="LA MISIÓN SUPERMERCADOS";
    $costo_empaque=$rowReceta[0];
    $unidad_medida=$rowDesglose[4];
    $factor_empaque=$rowReceta[3];
    $costo_unitario=$rowReceta[2];
    $cantidad_receta=$rowDesglose[3];
    $merma=$rowReceta[1];
    $precio_unitario=$rowReceta[4];

    $input = "<div class='input-group' style='width:100%''><input type='number'  class='form-control' value='$ValorCant'></input></div>";
    array_push($datos,array(
      "id"=>$rowDesglose[0],
      "tipo" => "SUBRECETA",
      "artc_articulo"=>$artc_articulo,
      "unimedida_venta"=>$rowDesglose[4],
      "artc_descripcion"=>$artc_descripcion,
      "rmon_ultimoprecio"=>$costo_unitario,
      "cantidad"=>$input,
      "total"=>round(($costo_unitario * $ValorCant), 2)
    ));
}

echo utf8_encode(json_encode($datos));