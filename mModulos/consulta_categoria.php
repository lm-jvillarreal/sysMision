<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_modulo = "SELECT  id, nombre FROM categorias_modulos";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_modulo = "SELECT  id, nombre FROM categorias_modulos WHERE nombre LIKE '%".$search."%'";
}

$consulta_modulo = mysqli_query($conexion, $cadena_modulo);
$data = array();
while ($row_modulo=mysqli_fetch_array($consulta_modulo)) {
	$data[] = array("id"=>$row_modulo[0], "text"=>$row_modulo[1]);
}
echo json_encode($data);
?>