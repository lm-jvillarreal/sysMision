<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_departamentos = "SELECT FAMC_FAMILIA, FAMC_DESCRIPCION, FAMN_NIVEL FROM COM_FAMILIAS WHERE FAMN_NIVEL = '1'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_departamentos = "SELECT FAMC_FAMILIA, FAMC_DESCRIPCION, FAMN_NIVEL FROM COM_FAMILIAS WHERE FAMN_NIVEL = '1' AND FAMC_DESCRIPCION like '%".$search."%'";
} 


$consulta_departamentos = oci_parse($conexion_central, $cadena_departamentos);
oci_execute($consulta_departamentos);
$data = array();
while ($row_departamentos=oci_fetch_row($consulta_departamentos)) {
	$data[] = array("id"=>$row_departamentos[0], "text"=>$row_departamentos[1]); 
}

echo json_encode($data);
?>