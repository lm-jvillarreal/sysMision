<?php
include '../global_seguridad/verificar_sesion.php';
//include '../global_settings/conexion_oracle.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_proveedores = "SELECT numero_proveedor, CONCAT(numero_proveedor,' ',proveedor) FROM proveedores";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_proveedores = "SELECT numero_proveedor, CONCAT(numero_proveedor,' ',proveedor) FROM proveedores WHERE CONCAT(numero_proveedor,' ',proveedor) like '%".$search."%'";
} 


$consulta_proveedores = mysqli_query($conexion, $cadena_proveedores);

$data = array();
while ($row_proveedores=mysqli_fetch_row($consulta_proveedores)) {
	$data[] = array("id"=>$row_proveedores[0], "text"=>$row_proveedores[1]); 
}

echo json_encode($data);
?>
