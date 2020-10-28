<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_sucursales = "SELECT id, nombre FROM sucursales where activo = '1' order by id asc";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_sucursales = "SELECT id, nombre FROM sucursales where nombre like '%".$search."%' and activo = '1' order by id asc ";
} 
$consulta_sucursales = mysqli_query($conexion, $cadena_sucursales);
$data = array();
while ($row_sucursales=mysqli_fetch_array($consulta_sucursales)) {
	$data[] = array("id"=>$row_sucursales[0], "text"=>$row_sucursales[1]);
}
echo json_encode($data);
?>