<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_perfiles = "SELECT id, nombre FROM perfil where activo='1'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_perfiles = "SELECT id, nombre FROM perfil where activo='1' AND nombre LIKE '%".$search."%'";
}
$consulta_perfiles = mysqli_query($conexion, $cadena_perfiles);
$data = array();
while ($row_perfiles=mysqli_fetch_array($consulta_perfiles)) {
	$data[] = array("id"=>$row_perfiles[0], "text"=>$row_perfiles[1]); 
}
echo json_encode($data);
?>