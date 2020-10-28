<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_recetas = "SELECT id, CONCAT(codigo_receta,' - ',nombre_receta) FROM cp_recetas where activo = '1'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_recetas = "SELECT id, CONCAT(codigo_receta,' - ',nombre_receta) FROM cp_recetas WHERE activo = '1' AND nombre_receta LIKE '%".$search."%'";
} 
$consulta_recetas = mysqli_query($conexion, $cadena_recetas);
$data = array();
while ($row_recetas=mysqli_fetch_array($consulta_recetas)) {
	$data[] = array("id"=>$row_recetas[0], "text"=>$row_recetas[1]); 
}
echo json_encode($data);
?>