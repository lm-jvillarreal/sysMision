<?php
include '../global_settings/conexion.php';
//include '../global_settings/conexion_oracle.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_perfil = "SELECT id, nombre FROM perfil";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_perfil = "SELECT id,nombre FROM perfil WHERE nombre like '%".$search."%'";
} 


$consulta_perfil = mysqli_query($conexion, $cadena_perfil);

$data = array();
while ($row_perfil=mysqli_fetch_array($consulta_perfil)) {
	$data[] = array("id"=>$row_perfil[0], "text"=>$row_perfil[1]); 
}

echo json_encode($data);
?>