<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
$fechahora=date("Y-m-d H:i:s");

$artc_articulo=$_POST['artc_articulo'];
$artc_piezapeso=$_POST['artc_pesokilo'];
$artc_piezacosto=$_POST['artc_costokilo'];
$entrada_tipoent=$_POST['entrada_tipoent'];
$entrada_folio=$_POST['entrada_folio'];
$clave_proveedor=$_POST['clave_proveedor'];
$nombre_proveedor=$_POST['nombre_proveedor'];
$sucursal=$_POST['sucursal'];

$cadenaDesc="SELECT ARTC_DESCRIPCION FROM COM_ARTICULOS WHERE ARTC_ARTICULO='$artc_articulo'";
$st = oci_parse($conexion_central, $cadenaDesc);
oci_execute($st);
$rowDescripcion = oci_fetch_array($st);
$artc_descripcion=$rowDescripcion[0];

$cadenaInsertar="INSERT INTO carniceria_costeo (ARTC_CODIGO, ARTC_CORTE, ENTRADA_FOLIO, ENTRADA_TIPO, PROC_CVEPROVEEDOR, PROC_PROVEEDOR, ARTC_PESOENT, ARTC_COSTOKILO, SUCURSAL, ESTATUS, FECHAHORA, ACTIVO, USUARIO)VALUES('$artc_articulo','$artc_descripcion','$entrada_folio','$entrada_tipoent','$clave_proveedor','$nombre_proveedor','$artc_piezapeso','$artc_piezacosto', '$sucursal', '0', '$fechahora', '1', '$id_usuario')";
$insertarCosteo=mysqli_query($conexion,$cadenaInsertar);

$cadenaSelect="SELECT MAX(ID) FROM carniceria_costeo WHERE SUCURSAL='$sucursal' AND USUARIO='$id_usuario' AND ESTATUS='0'";
$consultaSelect=mysqli_query($conexion,$cadenaSelect);
$rowSelect=mysqli_fetch_array($consultaSelect);
echo $rowSelect[0];
?>