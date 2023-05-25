<?php
include '../global_settings/conexion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_categoria = "SELECT DISTINCT(FOLIO), CATEGORIA FROM vidvig_categorias";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_categoria = "SELECT DISTINCT(FOLIO), CATEGORIA FROM vidvig_categorias WHERE CATEGORIA like '%".$search."%'";
} 


$consulta_categoria = mysqli_query($conexion, $cadena_categoria);

$data = array();
while ($row_categoria=mysqli_fetch_array($consulta_categoria)) {
	$data[] = array("id"=>$row_categoria[0], "text"=>$row_categoria[1]); 
}
echo json_encode($data);
?>