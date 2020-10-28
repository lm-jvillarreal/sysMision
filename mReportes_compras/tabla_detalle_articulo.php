<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
include '../global_settings/conexion_sucursales.php';

$folio=$_POST['folio'];
$datos=array();

$cadenaDetalle="SELECT FOLIO_SUCURSAL, ARTC_ARTICULO FROM com_detalleArticulos WHERE FOLIO='$folio'";
$detalle=mysqli_query($conexion,$cadenaDetalle);

while($rowDetalle=mysqli_fetch_array($detalle)){

  $cadena_consulta = "SELECT ARTC_ARTICULO, 
                          ARTC_DESCRIPCION,
                          (SELECT 
                              RMON_ULTIMOPRECIO 
                          FROM INV_RENGLONES_MOVIMIENTOS 
                          WHERE almn_almacen='$rowDetalle[0]' 
                          AND   ARTC_ARTICULO=artc.artc_articulo
                          AND MODN_FOLIO=(SELECT MAX(modn_folio) 
                                          FROM INV_MOV_KARDEX_VW 
                                          WHERE almn_almacen='$rowDetalle[0]' 
                                          AND (MODC_TIPOMOV='ENTSOC' OR
                                                MODC_TIPOMOV='ENTCOC' OR 
                                                MODC_TIPOMOV='ESCARG') 
                                          AND ARTC_ARTICULO=artc.artc_articulo
                                          AND modn_folio<(SELECT MAX(modn_folio) 
                                                          FROM INV_MOV_KARDEX_VW 
                                                          WHERE almn_almacen='$rowDetalle[0]' 
                                                          AND (MODC_TIPOMOV='ENTSOC' OR
                                                                MODC_TIPOMOV='ENTCOC' OR 
                                                                MODC_TIPOMOV='ESCARG') 
                                                          AND ARTC_ARTICULO=artc.artc_articulo))) COSTO_ANTERIOR,
                            (SELECT 
                                  RMON_ULTIMOPRECIO 
                              FROM INV_RENGLONES_MOVIMIENTOS 
                              WHERE almn_almacen='$rowDetalle[0]' 
                              AND   ARTC_ARTICULO=artc.artc_articulo
                              AND   MODN_FOLIO=(SELECT MAX(modn_folio) 
                                                FROM INV_MOV_KARDEX_VW 
                                                WHERE almn_almacen='$rowDetalle[0]' 
                                                AND (MODC_TIPOMOV='ENTSOC' OR
                                                      MODC_TIPOMOV='ENTCOC' OR 
                                                      MODC_TIPOMOV='ESCARG') 
                                                AND ARTC_ARTICULO=artc.artc_articulo)) ULTIMO_COSTO,
                            artc.artn_precioventa,
                            (SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 1, artc.artc_articulo) FROM dual) EX_DO,
                            (SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 2, artc.artc_articulo) FROM dual) EX_ARB,
                            (SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 3, artc.artc_articulo) FROM dual) EX_VILL,
                            (SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 4, artc.artc_articulo) FROM dual) EX_ALL,
                            (SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 5, artc.artc_articulo) FROM dual) EX_LP,
                            (SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, 99, artc.artc_articulo) FROM dual) EX_CEDIS,
                            (SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) Departamento,
                            FAM.FAMC_DESCRIPCION Familia
                          FROM COM_ARTICULOS artc INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = artc.ARTC_FAMILIA WHERE artc.ARTC_ARTICULO='$rowDetalle[1]'";
  $st = oci_parse($conexion_central, $cadena_consulta);
        oci_execute($st);
  $row_producto = oci_fetch_row($st);

  $total_teorico=$row_producto[5]+$row_producto[6]+$row_producto[7]+$row_producto[8]+$row_producto[9]+$row_producto[10];
  if(is_null($row_producto[3]) || is_null($row_producto[4])){
    $margen_ppublico=0;
  }else{
    $margen_ppublico=(1-($row_producto[3]/$row_producto[4]))*100;
    $margen_ppublico=round($margen_ppublico,2);
  }

  if($rowDetalle[0]=='1'){
    $conexion_sucursal = $conexion_do;
  }elseif($rowDetalle[0]=='2'){
    $conexion_sucursal = $conexion_arb;
  }elseif($rowDetalle[0]=='3'){
    $conexion_sucursal = $conexion_vill;
  }elseif($rowDetalle[0]=='4'){
    $conexion_sucursal = $conexion_all;
  }elseif($rowDetalle[0]=='5'){
    $conexion_sucursal = $conexion_lp;
  }

  $cadenaOferta="SELECT prfn_precio_con_imp_y_desc P_OFERTA, TO_CHAR(prfd_fin_vigencia,'DD/MM/YYYY') VIGENCIA FROM pvs_precios_finales_vw WHERE artc_articulo = '$rowDetalle[1]'";
  $stoferta=oci_parse($conexion_sucursal,$cadenaOferta);
  oci_execute($stoferta);
  $rowOferta=oci_fetch_array($stoferta);

  if(is_null($row_producto[3]) || $row_producto[3]=='0' || is_null($rowOferta[0]) || $rowOferta[0]=='0'){
    $margen_poferta=0;
  }else{
    $margen_poferta=(1-($row_producto[3]/$rowOferta[0]))*100;
    $margen_poferta=round($margen_poferta,2);
  }

  array_push($datos,array(
    'artc_articulo'=>$row_producto[0],
    'artc_descripcion'=>$row_producto[1],
    'costo_anterior'=>$row_producto[2],
    'costo_ultimo'=>$row_producto[3],
    'ppublico'=>$row_producto[4],
    'margen_publico'=>$margen_ppublico,
    'poferta'=>$rowOferta[0],
    'margen_oferta'=>$margen_poferta,
    'vigencia_oferta'=>$rowOferta[1],
    'do'=>$row_producto[5],
    'arb'=>$row_producto[6],
    'vill'=>$row_producto[7],
    'all'=>$row_producto[8],
    'lp'=>$row_producto[9],
    'cedis'=>$row_producto[10],
    'total'=>$total_teorico,
    'depto'=>$row_producto[11],
    'familia'=>$row_producto[12]
  ));
}
echo utf8_encode(json_encode($datos));
//echo $cadena_consulta;
?>