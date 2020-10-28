<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_catalogo = "SELECT  id, opcion FROM sepomex_municipios WHERE relacion = '19'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_catalogo = "SELECT  id, opcion FROM sepomex_municipios WHERE relacion = '19' AND opcion LIKE '%".$search."%'";
} 

$consulta_catalogo = mysqli_query($conexion, $cadena_catalogo);
$data = array();
while ($row_catalogo=mysqli_fetch_array($consulta_catalogo)) {
	$data[] = array("id"=>$row_catalogo[0], "text"=>$row_catalogo[1]); 
}

echo json_encode($data);
?>