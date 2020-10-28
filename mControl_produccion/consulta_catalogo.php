<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_catalogo = "SELECT  DISTINCT(nombre_catalogo), no_catalogo FROM cp_catalogos GROUP BY no_catalogo";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_catalogo = "SELECT  DISTINCT(nombre_catalogo), no_catalogo FROM cp_catalogos GROUP BY no_catalogo WHERE DISTINCT(nombre_catalogo) like '%".$search."%'";
} 

$consulta_catalogo = mysqli_query($conexion, $cadena_catalogo);
$data = array();
while ($row_catalogo=mysqli_fetch_array($consulta_catalogo)) {
	$data[] = array("id"=>$row_catalogo[1], "text"=>$row_catalogo[0]); 
}

echo json_encode($data);
?>