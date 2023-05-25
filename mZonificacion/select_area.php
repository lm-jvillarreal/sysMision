<?php
include '../global_seguridad/verificar_sesion.php';
//include '../global_settings/conexion_oracle.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_areas = "SELECT ID, AREA FROM inv_areas WHERE ID_SUCURSAL='$id_sede' AND ACTIVO='1'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_areas = "SELECT ID, AREA FROM inv_areas WHERE ID_SUCURSAL='$id_sede' AND ACTIVO='1' AND AREA LIKE '%".$search."%'";
} 
$consulta_areas = mysqli_query($conexion, $cadena_areas);

$data = array();
while ($row_areas=mysqli_fetch_array($consulta_areas)) {
	$data[] = array("id"=>$row_areas[0], "text"=>$row_areas[1]); 
}

echo json_encode($data);
?>