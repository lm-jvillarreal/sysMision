<?php
	include '../global_seguridad/verificar_sesion.php';
	include '../global_settings/conexion_oracle.php';

$cadena_dep = "SELECT 
(SELECT FAMC_DESCRIPCION FROM COM_FAMILIAS WHERE FAM.FAMC_FAMILIAPADRE = COM_FAMILIAS.FAMC_FAMILIA AND ROWNUM =1) AS Departamento
FROM COM_ARTICULOS
INNER JOIN COM_FAMILIAS FAM ON FAM.FAMC_FAMILIA = COM_ARTICULOS.ARTC_FAMILIA
WHERE  COM_ARTICULOS.ARTN_ESTATUS=1 ORDER BY fam.famc_descripcion ASC";
$consulta_dep = oci_parse($conexion_central, $cadena_dep);
oci_execute($consulta_dep);
$row_dep = oci_fetch_row($consulta_dep);

$array = array(
	$row_dep[0]
	);

$array_datos = json_encode($array);
echo "$array_datos"; 
?>