<?php
include '../global_settings/conexion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_personas = "SELECT id, CONCAT(nombre, ' ',ap_paterno,' ',ap_materno) FROM personas WHERE activo = '1'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_personas = "SELECT id, CONCAT(nombre, ' ',ap_paterno,' ',ap_materno) FROM personas WHERE activo = '1' AND CONCAT(nombre, ' ',ap_paterno,' ',ap_materno) like '%".$search."%'";
} 


$consulta_personas = mysqli_query($conexion, $cadena_personas);

$data = array();
while ($row_personas=mysqli_fetch_array($consulta_personas)) {
	$data[] = array("id"=>$row_personas[0], "text"=>$row_personas[1]); 
}
echo json_encode($data);
?>