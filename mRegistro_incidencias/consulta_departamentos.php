<?php
include '../global_settings/conexion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_categoria = "SELECT id, nombre FROM departamentos WHERE activo = '1'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_categoria = "SELECT id, nombre FROM departamentos WHERE activo = '1' AND nombre like '%".$search."%'";
} 


$consulta_categoria = mysqli_query($conexion, $cadena_categoria);

$data = array();
while ($row_categoria=mysqli_fetch_array($consulta_categoria)) {
	$data[] = array("id"=>$row_categoria[0], "text"=>$row_categoria[1]); 
}
echo json_encode($data);
?>