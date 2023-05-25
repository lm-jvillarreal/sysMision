<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d");
$hora=date ("h:i:s");
//$anio = date("Y");
$anio = '2022';

$fecha_afectacion = $_POST['fecha_afectacion'];
$movimiento = $_POST['movimiento'];
$folio = $_POST['folio'];
$valor = $_POST['val_real'];
$concepto = $_POST['concepto'];
$id_comprador = $_POST['id_comprador'];
$proveedor = $_POST['cve_prov'];
$comentario = $_POST['comentarios'];
$sucursal = $_POST['sucursal'];

$cadena_validar = "SELECT MAX(consecutivo_nc) FROM aportaciones WHERE folio_movimiento = '$folio'";
$consulta_validar = mysqli_query($conexion, $cadena_validar);
$row_validar = mysqli_fetch_array($consulta_validar);
$num_validar = COUNT($row_validar);

if ($num_validar > 0) {
	$consecutivo = $row_validar[0]+1;
	$cadena_repetido = "
	SELECT 
		CXP_NOTASCARCRE.nccd_captura, 
		'NC', 
		CXP_NOTASCARCRE.nccv_numncc, 
		CXP_NOTASCARCRE.nccn_importe, 
		CONCAT(CXP_NOTASCARCRE.proc_cveproveedor, CONCAT(' ',CXP_PROVEEDORES.PROC_NOMBRE)),
		cxp_notascarcre.nccv_descripcion,
		CXP_NOTASCARCRE.proc_cveproveedor,
	    cxp_manejoncc.mncc_ccostos,
	    cxp_manejoncc.nccn_tipo
	FROM CXP_NOTASCARCRE 
	INNER JOIN CXP_PROVEEDORES
	ON CXP_NOTASCARCRE.PROC_CVEPROVEEDOR = CXP_PROVEEDORES.PROC_CVEPROVEEDOR
	INNER JOIN cxp_manejoncc ON cxp_notascarcre.nccv_numncc = cxp_manejoncc.nccv_numncc
	AND cxp_notascarcre.nccv_numncc = '$folio_mov' AND cxp_manejoncc.nccn_tipo='$consecutivo'";

	$consulta_repetido = oci_parse($conexion_central, $cadena_repetido);
	oci_execute($consulta_repetido);
	$row_repetido = oci_fetch_row($consulta_repetido);

	$cantidad_repetido = COUNT($row_repetido);

	if ($cantidad_repetido>0) {
		$cadena_proveedor = "SELECT PROC_NOMBRE FROM CXP_PROVEEDORES WHERE PROC_CVEPROVEEDOR = '$proveedor'";
		$consulta_proveedor = oci_parse($conexion_central, $cadena_proveedor);
		oci_execute($consulta_proveedor);
		$row_proveedor = oci_fetch_row($consulta_proveedor);
		
		$cadena_inserta_repetido = "INSERT INTO aportaciones (tipo_movimiento, folio_movimiento, fecha_afectacion, id_sucursal, concepto, anio, id_comprador, cve_proveedor, nombre_proveedor, total, comentarios, fecha, hora, activo, usuario, consecutivo_nc)VALUES('$movimiento','$folio','$fecha_afectacion','$sucursal','$concepto','$anio','$id_comprador','$proveedor','$row_proveedor[0]','$valor','$comentario','$fecha','$hora','1','$id_usuario','$consecutivo')";

		$inserta_repetido = mysqli_query($conexion, $cadena_inserta_repetido);

		echo "ok";

	}else{

		echo "repetido";

	}
}else{

$cadena_proveedor = "SELECT PROC_NOMBRE FROM CXP_PROVEEDORES WHERE PROC_CVEPROVEEDOR = '$proveedor'";
$consulta_proveedor = oci_parse($conexion_central, $cadena_proveedor);
oci_execute($consulta_proveedor);
$row_proveedor = oci_fetch_row($consulta_proveedor);

$cadena_aportacion = "INSERT INTO aportaciones (tipo_movimiento, folio_movimiento, fecha_afectacion, id_sucursal, concepto, id_comprador, cve_proveedor, nombre_proveedor, total, comentarios, fecha, hora, activo, usuario, consecutivo_nc)VALUES('$movimiento','$folio','$fecha_afectacion','$sucursal','$concepto','$id_comprador','$proveedor','$row_proveedor[0]','$valor','$comentario','$fecha','$hora','1','$id_usuario','1')";

$inserta_aportacion = mysqli_query($conexion, $cadena_aportacion);

echo "ok";
}
?>