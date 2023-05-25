<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

if(!isset($_POST['searchTerm'])){
  $cadena_proveedores = "SELECT TRIM(PR.PROC_CVEPROVEEDOR), CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE pr.PRON_ESTATUS=0";
}else{
  $search = $_POST['searchTerm'];
  $cadena_proveedores = "SELECT TRIM(PR.PROC_CVEPROVEEDOR), CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) FROM CXP_PROVEEDORES pr WHERE pr.PRON_ESTATUS=0 AND CONCAT(CONCAT(PR.PROC_CVEPROVEEDOR,'' ), PR.PROC_NOMBRE) like '%".$search."%'";
}
$consulta_proveedores = oci_parse($conexion_central, $cadena_proveedores);
oci_execute($consulta_proveedores);
$data = array();
while ($row_proveedores=oci_fetch_row($consulta_proveedores)) {
	$data[] = array("id"=>$row_proveedores[0], "text"=>$row_proveedores[1]); 
}
echo json_encode($data);
?>