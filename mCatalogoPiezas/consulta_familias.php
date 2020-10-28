<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_grupos = "SELECT id_familia, clave_familia, nombre FROM familias_mantenimiento WHERE activo = 1 ORDER BY clave_familia";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_grupos = "SELECT id_familia, clave_familia, nombre FROM familias_mantenimiento WHERE nombre like '%".$search."%' AND activo='1' ORDER BY id ASC";
} 


$consulta_grupos = mysqli_query($conexion, $cadena_grupos);
$data = array();
while ($row_grupos=mysqli_fetch_array($consulta_grupos)) {
	$data[] = array("id"=>$row_grupos[0], "text"=>$row_grupos[2]);
}

echo json_encode($data);
?>