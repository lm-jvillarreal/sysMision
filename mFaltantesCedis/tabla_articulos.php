<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$fecha_i = date("Y-m-d",strtotime($fecha."- 1 days"));
$fecha_f = date("Y-m-d",strtotime($fecha."- 16 days"));
$folio_i = str_replace("-","",$fecha_i);
$folio_f = str_replace("-","",$fecha_f);

$proveedor = $_POST['proveedor'];

$cadenaPrincipal = "SELECT
                      INV_ARTICULOS_DETALLE.ARTC_ARTICULO AS Codigo,
                      INV_ARTICULOS_DETALLE.ARTC_DESCRIPCION,
                      INV_ARTICULOS_DETALLE.ARTN_ULTIMOPRECIO,
                      familias.FAMC_DESCRIPCION AS Familia,
                      (SELECT COM_FAMILIAS.FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE COM_FAMILIAS.FAMC_FAMILIA = familias.FAMC_FAMILIAPADRE ) AS Departamento,
                      (SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '$id_sede', INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS Existencia,
                      ROUND( INV_ARTICULOS_DETALLE.ARTN_COSTO_PROMEDIO, 2) AS C_PROM,
                      NVL((SELECT AREN_CANTIDAD FROM INV_ARTICULOS_EMPAQUE WHERE ARTC_ARTICULO = INV_ARTICULOS_DETALLE.ARTC_ARTICULO AND ROWNUM = 1),0) AS U_EMP,
                      INV_ARTICULOS_DETALLE.artc_unimedida_compra,
                      (SELECT spin_articulos.fn_existencia_disponible_todos ( 13, NULL, NULL, 1, 1, '99', INV_ARTICULOS_DETALLE.ARTC_ARTICULO ) FROM dual ) AS CEDIS
                    FROM
                    INV_ARTICULOS_DETALLE 
                    INNER JOIN COM_ARTICULOSLISTAPRECIOS ON INV_ARTICULOS_DETALLE.ARTC_ARTICULO = COM_ARTICULOSLISTAPRECIOS.ARTC_ARTICULO
                    INNER JOIN COM_FAMILIAS familias ON familias.FAMC_FAMILIA = INV_ARTICULOS_DETALLE.ARTC_FAMILIA
                    WHERE INV_ARTICULOS_DETALLE.ARTD_BAJA IS NULL
                    AND COM_ARTICULOSLISTAPRECIOS.PROC_CVEPROVEEDOR='$proveedor'";

//ECHO $cadenaPrincipal;
$consultaPrincipal = oci_parse($conexion_central,$cadenaPrincipal);
oci_execute($consultaPrincipal);
$cuerpo ="";
$conteo=0;
while($row_articulo = oci_fetch_row($consultaPrincipal)){
  if($row_articulo[9]=='0'){
    $renglon="";
  }else{
  $conteo=$conteo+1;
  $escape_descripcion = mysqli_real_escape_string($conexion,$row_articulo[1]);
  $descripcion=$escape_descripcion."<input type='hidden' value='$escape_descripcion' id='artc_descripcion_$conteo'>";
  $escape_depto = mysqli_real_escape_string($conexion,$row_articulo[4]);
  $escape_familia = mysqli_real_escape_string($conexion,$row_articulo[3]);

  $cadenaVentas = "SELECT
									NVL(SUM(DETALLE.ARTN_CANTIDAD),0)
								FROM
									PV_ARTICULOSTICKET detalle
								INNER JOIN PV_TICKETS tik ON TIK.TICN_AAAAMMDDVENTA = DETALLE.TICN_AAAAMMDDVENTA
								AND TIK.TICN_FOLIO = DETALLE.TICN_FOLIO
								WHERE
									DETALLE.ARTC_ARTICULO = '$row_articulo[0]'
								AND TIK.ticn_aaaammddventa BETWEEN '$folio_f'
								AND '$folio_i'
								AND TIK.TICC_SUCURSAL = '$id_sede'
								AND DETALLE.TICC_SUCURSAL = '$id_sede'
                AND TIK.TICN_ESTATUS = 3";
  
  //echo $cadenaVentas;
  $consultaVentas = oci_parse($conexion_central, $cadenaVentas);
  oci_execute($consultaVentas);
  $row_ventas = oci_fetch_row($consultaVentas);
  $faltante = $row_ventas[0] - $row_articulo[5];
  if($row_articulo[7]=='0'){
    $faltante_ue = "0";
  }else{
    $faltante_ue = $faltante/$row_articulo[7];
    $faltante_ue = ceil($faltante_ue);
  }
  if($row_articulo[5]==0 || $row_ventas[0]==0){
    $dias_inv=0;
  }else{
    $dias_inv = $row_articulo[5]/($row_ventas[0]/15);
    $dias_inv=round($dias_inv,2);
  }
  if($faltante_ue<0){
    $faltante_pedido=0;
  }else{
    $faltante_pedido=$faltante_ue;
  }
  $sugerido = "<input type='hidden' id='sugerido_$conteo' value='$faltante' readonly='true' class='form-control'>";
  $pedido="<div class='input-group'><span class='input-group-addon'><input type='checkbox' id='$conteo' name='articulos' value='$row_articulo[0]' onclick='pedido($row_articulo[0],$conteo)'></span><input type='number' min='0' step='1' id='cantidad_$conteo' value='$faltante_pedido' readonly='true' class='form-control'></div>";
  
  $cadenaFaltantePV="SELECT * FROM faltantes_pasven where sucursal='$id_sede' and cve_articulo='$row_articulo[0]' and (estatus='1' or estatus='3')
                    AND DATE(fecha_captura) BETWEEN DATE_SUB(NOW(),INTERVAL 7 DAY) AND DATE(NOW())";
  $consultaFaltantePV=mysqli_query($conexion,$cadenaFaltantePV);
  $rowFaltantePV=mysqli_fetch_array($consultaFaltantePV);
  $conteoFaltantePV=count($rowFaltantePV[0]);
  if($conteoFaltantePV>0){
    $descripcion=" * ".$descripcion;
  }else{
    $descripcion=$descripcion;
  }

  $renglon="
  {
    \"codigo\":\"$row_articulo[0]\",
    \"descripcion\":\"$descripcion\",
    \"departamento\":\"$escape_depto\",
    \"unidad_compra\":\"$row_articulo[8]\",
    \"unidad_empaque\":\"$row_articulo[7]\",
    \"ventas\":\"$row_ventas[0]\",
    \"teorico\":\"$row_articulo[5]\",
    \"cedis\":\"$row_articulo[9]\",
    \"dias_inv\": \"$dias_inv\",
    \"faltante\":\"$faltante\",
    \"faltante_cajas\":\"$faltante_ue $sugerido\",
    \"pedido\":\"$pedido\"
  },";
}
  $cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>