<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_sucursales.php';

$prefijo = $_POST['prefijo'];
$consecutivo = $_POST['consecutivo'];
$artc_articulo=$_POST['artc_articulo'];
$artc_cantidad = $_POST['artc_cantidad'];

if($id_sede=='1'){
	$conexion_central = $conexion_do;
}elseif($id_sede=='2'){
	$conexion_central = $conexion_arb;
}elseif($id_sede=='3'){
	$conexion_central = $conexion_vill;
}elseif($id_sede=='4'){
	$conexion_central = $conexion_all;
}elseif($id_sede=='5'){
  $conexion_central=$conexion_lp;
}elseif($id_sede=='6'){
  $conexion_central=$conexion_mm;
}

$cadena_consulta = "SELECT 
                    ARTC_ARTICULO, 
                    (SELECT ARTC_DESCRIPCION FROM PVS_ARTICULOS WHERE ARTC_ARTICULO=A.ARTC_ARTICULO) DESCRIPCION,
                    ARTN_CANTIDAD, 
                    TO_CHAR(ROUND((ARTN_PRECIOVENTA + (ARTN_MONTO_IMPUESTOS/ARTN_CANTIDAD)),2),'9999D99') PRECIO,
                    TO_CHAR(ROUND((ARTN_PRECIOVENTA *ARTN_CANTIDAD) + ARTN_MONTO_IMPUESTOS,2),'9999D99') TOTAL,
                    (SELECT ARTC_FAMILIA FROM PVS_ARTICULOS WHERE ARTC_ARTICULO=A.ARTC_ARTICULO) FAMILIA
                    FROM PVS_ARTICULOSTICKET A
                    WHERE ticn_aaaammddventa='$prefijo'
                    AND ticn_folio='$consecutivo' AND ARTC_ARTICULO='$artc_articulo' AND ARTN_CANTIDAD='$artc_cantidad'";
$consulta_ticket = oci_parse($conexion_central, $cadena_consulta);
oci_execute($consulta_ticket);
$row = oci_fetch_row($consulta_ticket);

$array=array(
  $row[0],
  $row[1],
  $row[2],
  $row[3],
  $row[4],
  $row[5]
);
$array=json_encode($array);
echo $array;

?>