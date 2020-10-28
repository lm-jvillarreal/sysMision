<?php
include '../global_seguridad/verificar_sesion.php';

if(!isset($_POST['searchTerm']) AND !isset($_POST['grupo'])){ 
  $cadena_grupos = "SELECT id, tipo_equipo FROM mtto_tipo_equipo LIMIT 0";
}else if(!isset($_POST['searchTerm']) AND isset($_POST['grupo'])){
	$grupo = $_POST['grupo'];
	$cadena_grupos = "SELECT id, tipo_equipo FROM mtto_tipo_equipo WHERE id_grupo = '".$grupo."'";
}else if(isset($_POST['searchTerm']) AND isset($_POST['grupo'])){
	$search = $_POST['searchTerm'];
  	$grupo = $_POST['grupo'];
  	$cadena_grupos = "SELECT id, tipo_equipo FROM mtto_tipo_equipo WHERE tipo_equipo like '%".$search."%' AND id_grupo = '".$grupo."'";
}
//echo $cadena_grupos;

$consulta_grupos = mysqli_query($conexion, $cadena_grupos);
$data = array();
while ($row_grupos=mysqli_fetch_array($consulta_grupos)) {
	$data[] = array("id"=>$row_grupos[0], "text"=>$row_grupos[1]);
}

echo json_encode($data);
?>