<?php
include '../global_settings/conexion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_area = "SELECT ID, AREA FROM vidvig_areas WHERE ACTIVO=1";
}else{ 
  $search = $_POST['searchTerm'];
  $cadena_area = "SELECT ID, AREA FROM vidvig_areas WHERE ACTIVO=1 AND AREA like '%".$search."%'";
}
$consulta_area = mysqli_query($conexion, $cadena_area);

$data = array();
while ($row_area=mysqli_fetch_array($consulta_area)) {
	$data[] = array("id"=>$row_area[0], "text"=>$row_area[1]); 
}
echo json_encode($data);
?>