<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm'])){ 
  $cadena_catalogo = "SELECT usuarios.id,CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)
						FROM usuarios 
						INNER JOIN personas ON personas.id = usuarios.id_persona
						WHERE usuarios.activo = '1'";
}else{ 
  $search = $_POST['searchTerm'];   
  $cadena_catalogo = "SELECT usuarios.id,CONCAT(personas.nombre,' ',personas.ap_paterno,' ',personas.ap_materno)
						FROM usuarios INNER JOIN personas ON personas.id = usuarios.id_persona
						WHERE personas.nombre  LIKE '%".$search."%'";
} 

$consulta_catalogo = mysqli_query($conexion, $cadena_catalogo);
$data = array();
while ($row_catalogo=mysqli_fetch_array($consulta_catalogo)) {
	$data[] = array("id"=>$row_catalogo[0], "text"=>$row_catalogo[1]); 
}

echo json_encode($data);
?>