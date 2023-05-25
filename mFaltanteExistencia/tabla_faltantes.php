<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$datos=array();
$sucursal=$_POST['sucursal'];
$cadenaFaltantes="SELECT
                  DISTINCT(renglon.ARTC_ARTICULO),a.ARTC_DESCRIPCION,
                  (SELECT SUM(a.RMON_CANTSURTIDA) 
                      FROM INV_RENGLONES_MOVIMIENTOS a 
                      WHERE a.artc_articulo = renglon.artc_articulo 
                      AND (a.RMON_ESTATUS='1' OR a.RMON_ESTATUS='2') AND a.MODC_TIPOMOV = 'SALXVE' AND ALMN_ALMACEN = '$sucursal') AS CANTIDAD,
                  (SELECT spin_articulos.fn_existencia_disponible_todos(13, NULL, NULL, 1, 1, $sucursal, renglon.ARTC_ARTICULO)FROM dual) AS Existencia,
                  (SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento,
                  (SELECT SUM(a.RMON_CANTSURTIDA) 
                      FROM INV_RENGLONES_MOVIMIENTOS a 
                      WHERE a.artc_articulo = renglon.artc_articulo 
                      AND (a.RMON_ESTATUS='1' OR a.RMON_ESTATUS='2') AND a.MODC_TIPOMOV = 'ENTCOC' AND ALMN_ALMACEN = '$sucursal') AS ENTCOC,
                  (SELECT SUM(a.RMON_CANTSURTIDA) 
                      FROM INV_RENGLONES_MOVIMIENTOS a 
                      WHERE a.artc_articulo = renglon.artc_articulo 
                      AND (a.RMON_ESTATUS='1' OR a.RMON_ESTATUS='2') AND a.MODC_TIPOMOV = 'ENTSOC' AND ALMN_ALMACEN = '$sucursal') AS ENTSOC,
                  (SELECT SUM(a.RMON_CANTSURTIDA) 
                      FROM INV_RENGLONES_MOVIMIENTOS a 
                      WHERE a.artc_articulo = renglon.artc_articulo 
                      AND (a.RMON_ESTATUS='1' OR a.RMON_ESTATUS='2') AND a.MODC_TIPOMOV = 'ENTTRA' AND ALMN_ALMACEN = '$sucursal') AS ENTTRA,
                  (SELECT SUM(a.RMON_CANTSURTIDA) 
                      FROM INV_RENGLONES_MOVIMIENTOS a 
                      WHERE a.artc_articulo = renglon.artc_articulo 
                      AND (a.RMON_ESTATUS='1' OR a.RMON_ESTATUS='2') AND a.MODC_TIPOMOV = 'ETRANS' AND ALMN_ALMACEN = '$sucursal') AS ETRANS,
                      (
                      SELECT
                        NVL( SUM( a.RMON_CANTSURTIDA ), 0 ) 
                      FROM
                        INV_RENGLONES_MOVIMIENTOS a 
                        INNER JOIN INV_MOVIMIENTOS m
                        ON a.MODC_TIPOMOV=m.MODC_TIPOMOV
                        and a.MODN_FOLIO=m.MODN_FOLIO
                        and a.ALMN_ALMACEN=m.ALMN_ALMACEN
                      WHERE
                        a.MODC_TIPOMOV='SIROTA'
                        and a.ALMN_ALMACEN='1'
                        AND a.ARTC_ARTICULO=renglon.artc_articulo 
                        AND (a.RMON_ESTATUS='2' OR a.RMON_ESTATUS='3')
                        and m.MOVN_ESTATUS='2'
                    ) AS SIROTA
                  FROM  INV_RENGLONES_MOVIMIENTOS renglon 
                  INNER JOIN COM_ARTICULOS a  on a.artc_articulo = renglon.artc_articulo
                  INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = a.ARTC_FAMILIA
                  WHERE (renglon.RMON_ESTATUS='1' OR renglon.RMON_ESTATUS = '2') AND renglon.MODC_TIPOMOV = 'SALXVE' AND renglon.ALMN_ALMACEN = '$sucursal'
                  ORDER BY renglon.ARTC_ARTICULO ASC";
$consulta_principal = oci_parse($conexion_central, $cadenaFaltantes);
oci_execute($consulta_principal);
while($rowFaltantes=oci_fetch_row($consulta_principal)){
  $revision = "<center><a href='#' class='btn btn-danger' onclick=\"revisar('$rowFaltantes[0]','$rowFaltantes[1]','$sucursal','$rowFaltantes[4]',$rowFaltantes[3])\"><i class='fa fa-search fa-lg' aria-hidden='true'></i></a></center>";
  $faltante=($rowFaltantes[3]-$rowFaltantes[2])*-1;
  array_push($datos,array(
    'artc_articulo'=>$rowFaltantes[0],
    'artc_descripcion'=>$rowFaltantes[1],
    'cantidad_afectar'=>$rowFaltantes[2],
    'existencia'=>$rowFaltantes[3],
    'faltante'=>$faltante,
    'entcoc'=>$rowFaltantes[5],
    'entsoc'=>$rowFaltantes[6],
    'enttra'=>$rowFaltantes[7],
    'etrans'=>$rowFaltantes[8],
    'sirota'=>$rowFaltantes[9],
    'depto'=>$rowFaltantes[4],
    'revision'=>$revision
  ));
}
echo utf8_encode(json_encode($datos));
?>