<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$folio_mov = $_POST['folio_mov'];

$cadena_existe = "SELECT MAX(consecutivo_nc) FROM aportaciones WHERE folio_movimiento = '$folio_mov'";
$consulta_existe = mysqli_query($conexion, $cadena_existe);
$row_existe = mysqli_fetch_array($consulta_existe);
$numero_existe = COUNT($row_existe);

if ($numero_existe>0) {
	$consecutivo = $row_existe[0]+1;
}elseif($numero_existe==0){
	$consecutivo = 1;
}

$cadena_consulta = "SELECT 
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
    INNER JOIN cxp_manejoncc ON cxp_notascarcre.nccv_numncc = cxp_manejoncc.nccv_numncc
    AND cxp_manejoncc.nccn_tipo = cxp_notascarcre.nccn_tipo
    INNER JOIN CXP_PROVEEDORES
    ON CXP_NOTASCARCRE.PROC_CVEPROVEEDOR = CXP_PROVEEDORES.PROC_CVEPROVEEDOR
    WHERE cxp_notascarcre.nccv_numncc = '$folio_mov'
    AND CXP_MANEJONCC.nccv_numncc = '$folio_mov'
    AND cxp_manejoncc.nccn_tipo='$consecutivo'";

//echo $cadena_consulta;
$st = oci_parse($conexion_central, $cadena_consulta);
oci_execute($st);
$row_movimiento = oci_fetch_row($st);


$array = array(
	$row_movimiento[0],
	$row_movimiento[1],
	$row_movimiento[2],
	'$'.NUMBER_FORMAT($row_movimiento[3],2),
	$row_movimiento[4],
	$row_movimiento[6],
	$row_movimiento[7],
	$row_movimiento[3],
	$row_movimiento[8]
	);

$array_datos = json_encode($array);
echo "$array_datos"; 
//echo "$cadena_consulta";
?>