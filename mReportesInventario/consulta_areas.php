<?php
//include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_pruebas.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_proveedores = "SELECT id, nombre FROM inv_areas";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_proveedores = "SELECT id, nombre FROM inv_areas";
} 

$qry = mysqli_query($conexion, $cadena_proveedores);
$data = array();
while ($row_proveedores=mysqli_fetch_row($qry)) {
	$data[] = array("id"=>$row_proveedores[0], "text"=>$row_proveedores[1]); 
}

echo json_encode($data);
?>