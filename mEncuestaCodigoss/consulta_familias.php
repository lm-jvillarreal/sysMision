<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

$departamento=$_POST['departamento'];

if(!isset($_POST['searchTerm'])){ 
  $cadena_departamentos = "SELECT * FROM COM_FAMILIAS WHERE FAMN_NIVEL = '2' and FAMC_FAMILIAPADRE= '$departamento'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_departamentos = "SELECT * FROM COM_FAMILIAS WHERE FAMN_NIVEL = '2'  and FAMC_FAMILIAPADRE= '$departamento' AND FAMC_DESCRIPCION like '%".$search."%'";
} 


$consulta_departamentos = oci_parse($conexion_central, $cadena_departamentos);
oci_execute($consulta_departamentos);
$data = array();
while ($row_departamentos=oci_fetch_row($consulta_departamentos)) {
	$data[] = array("id"=>$row_departamentos[2], "text"=>$row_departamentos[2]); 
}

echo json_encode($data);
?>