<?php
include '../global_settings/conexion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_promotores = "SELECT id, CONCAT(nombre, ' ', ap_paterno,' - ',compañia)  FROM promotores";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_promotores = "SELECT id, CONCAT(nombre, ' ', ap_paterno,' - ',compañia)  FROM promotores WHERE CONCAT(nombre, ' ',ap_paterno) like '%".$search."%'";
} 


$consulta_promotores = mysqli_query($conexion, $cadena_promotores);

$data = array();
while ($row_promotores=mysqli_fetch_array($consulta_promotores)) {
	$data[] = array("id"=>$row_promotores[0], "text"=>$row_promotores[1]); 
}
echo json_encode($data);
?>