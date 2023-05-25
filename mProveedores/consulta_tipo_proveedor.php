<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_tipoProveedor = "SELECT
	ID,
	TIPO_PROVEEDOR 
FROM
	categorias_proveedor";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_tipoProveedor = "SELECT
	ID,
	TIPO_PROVEEDOR 
FROM
	categorias_proveedor WHERE TIPO_PROVEEDOR like '%".$search."%'";
} 

$consulta_tipoProveedor = mysqli_query($conexion, $cadena_tipoProveedor);
$data = array();
while ($row_tipoProveedor=mysqli_fetch_array($consulta_tipoProveedor)) {
	$data[] = array("id"=>$row_tipoProveedor[0], "text"=>$row_tipoProveedor[1]); 
}

echo json_encode($data);
?>