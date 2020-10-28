<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d H:i:s"); 
$hora=date ("H:i:s");

$folio = $_POST['folio'];
$codigo =  $_POST['codigo'];

$cadena_consulta = "SELECT 
(SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento,
 FAM.FAMC_DESCRIPCION,
 COM_ARTICULOS.ARTC_ARTICULO, 
 COM_ARTICULOS.ARTC_DESCRIPCION
FROM COM_ARTICULOS
INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
WHERE com_articulos.artc_articulo = '$codigo'";

$st = oci_parse($conexion_central, $cadena_consulta);
oci_execute($st);

$row_producto = oci_fetch_row($st);
$departamento = $row_producto[0];
$familia = $row_producto[1];
$descripcion = $row_producto[3];

$cantidad = COUNT($descripcion);
if ($cantidad==0) {
	echo "no_existe";
}else{

	$cadena_valida = "SELECT * FROM faltantes_pasven WHERE folio = '$folio' AND cve_articulo = '$codigo'";
	$consulta_valida = mysqli_query($conexion, $cadena_valida);
	$row_valida = mysqli_fetch_array($consulta_valida);
	$conteo = COUNT($row_valida);
	if ($conteo>0) {
		echo "registrado";
	}else{

		$cadena_inserta = "INSERT INTO faltantes_pasven(folio, cve_articulo, descripcion_articulo, estatus, sucursal, usuario_captura, fecha_captura, activo, depto, familia)VALUES('$folio', '$codigo', '$descripcion', '0', '$id_sede', '$id_persona', '$fecha', '1', '$departamento', '$familia')";
		$consulta_inserta = mysqli_query($conexion, $cadena_inserta);

		echo $descripcion;
	}
}
?>