<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_grupos = "SELECT id, grupo FROM mtto_grupo";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_grupos = "SELECT id, grupo FROM mtto_grupo WHERE grupo like '%".$search."%'";
} 


$consulta_grupos = mysqli_query($conexion, $cadena_grupos);
$data = array();
while ($row_grupos=mysqli_fetch_array($consulta_grupos)) {
	$data[] = array("id"=>$row_grupos[0], "text"=>$row_grupos[1]);
}

echo json_encode($data);
?>