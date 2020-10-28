<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$cve_nc = $_POST['id'];
$consecutivo = $_POST['consecutivo'];

$cadena_nc = "SELECT
    CXP_NOTASCARCRE.nccv_numncc, 
    CXP_NOTASCARCRE.proc_cveproveedor,
    CXP_PROVEEDORES.PROC_NOMBRE,
    CXP_NOTASCARCRE.nccv_descripcion,
    CXP_NOTASCARCRE.NCCD_FECHANCC,
    cxp_manejoncc.mncc_ccostos,
    CXP_MANEJONCC.mncm_importe,
    CXP_NOTASCARCRE.NCCN_IVA,
    CXP_NOTASCARCRE.nccn_retencion,
    CXP_NOTASCARCRE.nccc_numfact, 
    CXP_NOTASCARCRE.nccd_aplicacion,
    cxp_notascarcre.nccc_numfact
FROM CXP_NOTASCARCRE
INNER JOIN CXP_PROVEEDORES ON CXP_NOTASCARCRE.PROC_CVEPROVEEDOR = CXP_PROVEEDORES.PROC_CVEPROVEEDOR
INNER JOIN cxp_manejoncc ON cxp_notascarcre.nccv_numncc = cxp_manejoncc.nccv_numncc
WHERE CXP_NOTASCARCRE.NCCV_NUMNCC = '$cve_nc' 
AND cxp_manejoncc.mncn_consecutivo = '$consecutivo'";

$st = oci_parse($conexion_central, $cadena_nc);
oci_execute($st);
$row_nc = oci_fetch_row($st);

$cadena_realiza = "SELECT CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno) 
						FROM personas 
						INNER JOIN usuarios ON personas.id = usuarios.id_persona
						INNER JOIN fondos as aportaciones ON usuarios.id = aportaciones.usuario 
						AND aportaciones.folio_movimiento = '$cve_nc' AND aportaciones.consecutivo_nc = '$consecutivo'";
$consulta_realiza = mysqli_query($conexion, $cadena_realiza);
$row_realiza = mysqli_fetch_array($consulta_realiza);

$imprimir = '
<div class="container">
	<div class="col-md-12">
		<label>No. de Nota de Credito:&nbsp;</label>'.$row_nc[0].'<br>
		<label>Clave del Proveedor:&nbsp;</label>'.$row_nc[1].'<br>
		<label>Nombre del Proveedor:&nbsp;</label>'.$row_nc[2].'<br>
		<label>No. Factura:&nbsp;</label>'.$row_nc[11].'<br>
		<label>Fecha del documento&nbsp;</label>'.$row_nc[4].'<br>
		<label>Descripción:&nbsp;</label>APORTACIÓN POR NC<br>
		<label>Centro de Costos:&nbsp;</label>'.$row_nc[5].'<br>
		<label>Importe:&nbsp;</label>'.$row_nc[6].'<br>
		<label>IVA:&nbsp;</label>'.$row_nc[7].'<br>
		<label>IEPS:&nbsp;</label>'.$row_nc[8].'<br>
		<label>Realizó:&nbsp;</label>'.$row_realiza[0].'<br>
	</div>
</div>
';

echo $imprimir;
?>