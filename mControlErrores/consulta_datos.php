<?php
//include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$tipo_movimiento = $_POST['tipo_mov'];
$folio_mov = $_POST['folio_mov'];
$sucursal = $_POST['sucursal'];

if($tipo_movimiento=='ENTSOC'){
	$cadena_filtro = "SELECT autn_autorizacion + 600
						FROM INV_TIPOS_MOVIMIENTO
						WHERE ctbs_cia   = '1'
						AND tmoc_tipomov = 'ENTSOC'";
	$st = oci_parse($conexion_central, $cadena_filtro);
	oci_execute($st);
	$row_filtro = oci_fetch_row($st);

	$cadena_consulta = "SELECT u.usuc_nombre, u.usus_usuario
						FROM com_autorizaciones a, ctb_usuario u
						WHERE ctbs_cia            = 1
						AND   autn_autorizosn     = 1
						AND   autn_autorizacion   = 603
						AND   autf_folio          = TO_NUMBER(LPAD(TO_CHAR($sucursal),5,'0')||LPAD(TO_CHAR($folio_mov),10,'0'))
						AND   autn_ordenimpresion = ( SELECT MAX(autn_ordenimpresion)
													FROM com_autorizaciones
													WHERE ctbs_cia          = a.ctbs_cia
													AND   autn_autorizacion = a.autn_autorizacion
													AND   autf_folio        = a.autf_folio )
						AND   a.usus_usuario = u.usus_usuario";
	$st = oci_parse($conexion_central, $cadena_consulta);
	oci_execute($st);
	$row_movimiento = oci_fetch_row($st);
}else{
	$cadena_consulta = "SELECT
						CTB_USUARIO.USUC_NOMBRE,
						CTB_USUARIO.USUS_USUARIO,
						INV_MOVIMIENTOS.MOVC_CVEPROVEEDOR
						FROM
						INV_MOVIMIENTOS
						INNER JOIN CTB_USUARIO ON CTB_USUARIO.USUS_USUARIO = MOVN_USUARIOREALIZAMOV
						WHERE
						MODC_TIPOMOV = '$tipo_movimiento'
						AND MODN_FOLIO = '$folio_mov'
						AND ALMN_ALMACEN = '$sucursal'";
	$st = oci_parse($conexion_central, $cadena_consulta);
	oci_execute($st);
	$row_movimiento = oci_fetch_row($st);

	//$cadena_proveedor = "SELECT CONCAT(CONCAT(TRIM(PROC_CVEPROVEEDOR),' - '),PROC_NOMBRE) FROM CXP_PROVEEDORES WHERE PROC_CVEPROVEEDOR = '$row_movimiento[2]'";
	//$st_prov = oci_parse($conexion_central, $cadena_proveedor);
	//oci_execute($st_prov);
	//$row_prov = oci_fetch_row($st_prov);
}
$array = array(
	$row_movimiento[0],
	$row_movimiento[1]

);
$array_datos = json_encode($array);
echo $array_datos;
//echo $cadena_consulta;
?>