<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$sucursal = $_POST['sucursal'];

if(!isset($_POST['searchTerm'])){
  $cadena_proveedores = "SELECT
				USUN_ID,
				CONCAT (
					USUN_ID,
					CONCAT (' ', USUC_NOMBRE)
				) USUC_NOMBRE
			FROM
				CFG_USUARIOS
			WHERE
				USUC_SUCURSAL_ASIGNADA = '$sucursal'";
}else{
  $search = $_POST['searchTerm'];
  $cadena_proveedores = "SELECT PR.PROC_CVEPROVEEDOR, CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) like '%".$search."%'";
}


$consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
oci_execute($consulta_proveedores);
$data = array();
while ($row_proveedores=oci_fetch_row($consulta_proveedores)) {
	$data[] = array("id"=>$row_proveedores[0], "text"=>$row_proveedores[1]);
}

echo json_encode($data);
?>
