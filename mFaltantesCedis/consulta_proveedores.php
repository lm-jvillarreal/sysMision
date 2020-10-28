<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_proveedores = "SELECT TRIM(numero_proveedor), CONCAT(numero_proveedor,' - ', proveedor) FROM proveedores WHERE cedis='1'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_proveedores = "SELECT TRIM(numero_proveedor), CONCAT(numero_proveedor,' - ', proveedor) FROM proveedores WHERE cedis='1' AND CONCAT(numero_proveedor,' ',proveedor) LIKE '%".$search."%'";
}
$consulta_compradores = mysqli_query($conexion, $cadena_proveedores);
$data = array();
while ($row_proveedores=mysqli_fetch_array($consulta_compradores)) {
	$data[] = array("id"=>$row_proveedores[0], "text"=>$row_proveedores[1]); 
}
echo json_encode($data);
?>