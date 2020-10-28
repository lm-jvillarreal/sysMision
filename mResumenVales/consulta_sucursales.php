<?php
include '../global_seguridad/verificar_sesion.php';

$filtro_rp = ($solo_sucursal == '1') ? " AND id = '$id_sede'" : "";

if(!isset($_POST['searchTerm'])){ 
  $cadena_sucursal = "SELECT id, nombre FROM sucursales WHERE activo = '1'".$filtro_rp;
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_sucursal = "SELECT id, nombre FROM sucursales WHERE activo = '1' AND nombre like '%".$search."%'" .$filtro_rp;
} 
$consulta_sucursal = mysqli_query($conexion, $cadena_sucursal);
$data = array();
while ($row_sucursal=mysqli_fetch_array($consulta_sucursal)) {
	$data[] = array("id"=>$row_sucursal[0], "text"=>$row_sucursal[1]);
}
echo json_encode($data);
?>